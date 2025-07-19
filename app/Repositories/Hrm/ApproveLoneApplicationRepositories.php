<?php

namespace App\Repositories\Hrm;

use App\Helpers\Helper;
use App\Models\Lone;
use App\Models\LeaveApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Transection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ApproveLoneApplicationRepositories
{
    /**
     * @var Brand
     */
    private $model;
    /**
     * PositionRepository Position.
     * @param LeaveApplication $Attendance
     */
    public function __construct(Lone $Lone)
    {
        $this->model = $Lone;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getAllList()
    {

        $result = $this->model::latest()->get();

        return $result;
    }


    /**
     * @param $request
     * @return mixed
     */

    public function getList($request)
    {

        $columns = array(
            0 => 'id',
            1 => 'name',
        );



        $totalData = $this->model::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $Lone = $this->model::offset($start)
                ->where('status', 'pending')
                ->limit($limit)
                ->orderBy($order, $dir)
                //->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->model::count();
        } else {
            $search = $request->input('search.value');
            $Lone = $this->model::where('name', 'like', "%{$search}%")
                ->where('status', 'pending')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                // ->orderBy('status', 'desc')
                ->get();
            $totalFiltered = $this->model::where('name', 'like', "%{$search}%")->count();
        }


        $data = array();
        if ($Lone) {
            foreach ($Lone as $key => $value) {
                $nestedData['id'] = $key + 1;
                $nestedData['employee_id'] = $value->employee->name ?? "";
                $nestedData['branch_id'] = $value->branch->name ?? "";
                $nestedData['amount'] = $value->amount;
                $nestedData['lone_adjustment'] = $value->lone_adjustment;
                $nestedData['reason'] = $value->reason;
                $nestedData['status'] = $value->status;



                $edit_data = '<a href="' . route('hrm.loneapprove.approve', $value->id) . '"  onclick="return confirm(`Are You Sure`)"  class="btn btn-xs btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>';

                $view_data = '<a href="' . route('hrm.loneapprove.show', $value->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>';

                $cancel_data = '<a href="' . route('hrm.loneapprove.cancel', $value->id) . '" title="Cancel" class="btn btn-xs btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>';

                $nestedData['action'] = $edit_data . ' ' . $view_data . ' ' . $cancel_data;

                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return $json_data;
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
        $Lone = $this->model::find($id);

        $Lone->status = $request->status;

        $Lone->save();
        return $Lone;
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
    }
}
