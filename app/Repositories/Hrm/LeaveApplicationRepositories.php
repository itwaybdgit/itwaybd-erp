<?php

namespace App\Repositories\Hrm;

use App\Helpers\Helper;
use App\Models\Attendance;
use App\Models\LeaveApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Transection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class LeaveApplicationRepositories
{
    /**
     * @var Brand
     */
    private $model;
    /**
     * PositionRepository Position.
     * @param LeaveApplication $Attendance
     */
    public function __construct(LeaveApplication $LeaveApplication)
    {
        $this->model = $LeaveApplication;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getAllList()
    {

        $result = $this->model::with(['employee', 'department'])->latest()->get();
        return $result;
    }


    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {
        $columns = [
            0 => 'id',
            1 => 'apply_date',
            2 => 'department_id',
            3 => 'employee_id',
        ];

        $totalData = $this->model::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderIndex = $request->input('order.0.column', 0);
        $dir = $request->input('order.0.dir', 'asc');
        $order = $columns[$orderIndex] ?? 'id';

        $search = $request->input('search.value');

        $query = $this->model->with(['employee', 'department']);

        if ($search) {
            $query = $query->whereHas('employee', function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('id_card', 'like', "%{$search}%")
                        ->orWhere('personal_phone', 'like', "%{$search}%");
                });
            });
        }

        // Uncomment if you want to restrict for non-admins
        if (auth()->user()->is_admin != 1) {
            $query = $query->where("employee_id", (auth()->user()->employee->id ?? 0));
        }

        $totalFiltered = $query->count();

        $LeaveApplication = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];
        foreach ($LeaveApplication as $key => $value) {
            $to = \Carbon\Carbon::parse($value->end_date);
            $from = \Carbon\Carbon::parse($value->apply_date);
            $days = $to->diffInDays($from);

            $data[] = [
                'id' => $key + 1,
                'employee_id' => $value->employee->id_card ?? '',
                'employee_name' => $value->employee->name ?? '',
                'department_id' => $value->department->name ?? '',
                'days' => $days ?? '',
                'apply_date' => $value->apply_date,
                'end_date' => $value->end_date,
                'reason' => $value->reason,
                'action' => '<a href="' . route('hrm.leave.edit', $value->id) . '" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a> ' .
                    '<a href="' . route('hrm.leave.show', $value->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a> ' .
                    '<a delete_route="' . route('hrm.leave.destroy', $value->id) . '" delete_id="' . $value->id . '" class="btn btn-xs btn-danger delete_row"><i class="fa fa-times"></i></a>'
            ];
        }

        return [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];
    }

    /**
     * @param $request
     * @return mixed
     */
    public function details($id)
    {
        $result = $this->model::find($id);
        return $result;
    }

    public function store($request)
    {

        $LeaveApplication = new $this->model;
        $LeaveApplication->employee_id = $request->employee_id;
        $LeaveApplication->department_id = $request->department_id;
        $LeaveApplication->apply_date = $request->apply_date;
        $LeaveApplication->end_date = $request->end_date;
        $LeaveApplication->reason = $request->reason;
        $LeaveApplication->payment_status = $request->payment_status;
        $file = $request->file('file');
        if (isset($file)) {
            $currentDate = Carbon::now()->toDateString();
            $fileName  = $currentDate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('leave')) {
                Storage::disk('public')->makeDirectory('leave');
            }

            $file->storeAs('leave', $fileName, 'public');
        } else {
            $fileName = null;
        }
        $LeaveApplication->file = $fileName;
        $LeaveApplication->save();
        return $LeaveApplication;
    }

    public function update($request, $id)
    {
        $LeaveApplication = $this->model::find($id);

        // $LeaveApplication->employee_id = $request->employee_id;
        $LeaveApplication->apply_date = $request->apply_date;
        $LeaveApplication->end_date = $request->end_date;
        $LeaveApplication->reason = $request->reason;
        $LeaveApplication->payment_status = $request->payment_status;

        $file = $request->file('file');
        if (isset($file)) {
            $currentDate = Carbon::now()->toDateString();
            $fileName  = $currentDate . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('leave')) {
                Storage::disk('public')->makeDirectory('leave');
            }
            Storage::disk('public')->delete('leave/' . $LeaveApplication->file);


            $file->storeAs('leave', $fileName, 'public');
        } else {
            $fileName = null;
        }
        $LeaveApplication->file = $fileName;
        $LeaveApplication->save();
        return $LeaveApplication;
    }

    public function statusUpdate($id, $status)
    {
        $customer = $this->model::find($id);
        $customer->status = $status;
        $customer->save();
        return $customer;
    }

    public function destroy($id)
    {
        $customer = $this->model::find($id);
        $customer->delete();
        return true;
        // if ($customer) {
        //     $customer->delete();
        //     return true;
        // } else {
        //     $customer->delete();
        //     return true;
        // }
    }
}
