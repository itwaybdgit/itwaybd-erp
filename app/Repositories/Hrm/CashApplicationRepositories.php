<?php

namespace App\Repositories\Hrm;

use App\Helpers\Helper;
use App\Models\Attendance;
use App\Models\Lone;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\CashReq;
use App\Models\Transection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CashApplicationRepositories
{
    /**
     * @var Brand
     */
    private $model;
    /**
     * PositionRepository Position.
     * @param LeaveApplication $Attendance
     */
    public function __construct(CashReq $Lone)
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
                ->limit($limit)
                ->orderBy($order, $dir);
            if (auth()->user()->type != "Admin") {
                $Lone = $Lone->where("employee_id", (auth()->user()->employee->id ?? 0));
            }
            $Lone = $Lone->get();
            $totalFiltered = $this->model::count();
        } else {
            $search = $request->input('search.value');
            $Lone = $this->model::where('name', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir);
            if (auth()->user()->type != "Admin") {
                $Lone = $Lone->where("employee_id", (auth()->user()->employee->id ?? 0));
            }
            $Lone = $Lone->get();
            $totalFiltered = $this->model::where('name', 'like', "%{$search}%")->count();
        }


        $data = array();
        if ($Lone) {

            foreach ($Lone as $key => $value) {
                $nestedData['id'] = $key + 1;
                $nestedData['employee_id'] = $value->employee->name;
                $nestedData['amount'] = $value->amount;
                $nestedData['reason'] = $value->reason;
                $nestedData['status'] = $value->status;


                $edit_data = '<a href="' . route('hrm.cashapplicaon.edit', $value->id) . '" class="btn btn-xs btn-success"><i class="fa fa-edit" aria-hidden="true"></i></a>';

                $view_data = '<a href="' . route('hrm.cashapplicaon.show', $value->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>';

                $delete_data = '<a delete_route="' . route('hrm.cashapplicaon.destroy', $value->id) . '" delete_id="' . $value->id . '" title="Delete" class="btn btn-xs btn-danger delete_row uniqueid' . $value->id . '"><i class="fa fa-times"></i></a>';

                $nestedData['action'] = $edit_data . ' ' . $view_data . ' ' . $delete_data;

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
        $lone = new $this->model;
        $lone->employee_id = $request->employee_id;
        $lone->amount = $request->amount;
        $lone->reason = $request->reason;
        $lone->save();
        return $lone;
    }

    public function update($request, $id)
    {
        $lone = $this->model::find($id);

        $lone->employee_id = $request->employee_id;
        $lone->amount = $request->amount;
        $lone->reason = $request->reason;
        $lone->save();
        return $lone;
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
        if ($customer->status == 'approved' || $customer->status == 'completed') {
            return false;
        } else {
            $customer->delete();
            return true;
        }
    }
}
