<?php

namespace App\Repositories\Hrm;

use App\Helpers\Helper;
use App\Models\Attendance;
use App\Models\Branch;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Transection;
use Carbon\Carbon;

class AttendanceRepositories
{
    /**
     * @var Brand
     */
    private $model;
    /**
     * PositionRepository Position.
     * @param Attendance $Attendance
     */
    public function __construct(Attendance $Attendance)
    {
        $this->model = $Attendance;
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
        $columns = [
            0 => 'id',
            1 => 'employe.name', // used for sorting
            2 => 'employe.id_card'
        ];



        $limit  = $request->input('length');
        $start  = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderBy = $columns[$orderColumnIndex] ?? 'date';
        $orderDir = $request->input('order.0.dir', 'asc');
        $search  = $request->input('search.value');

        $query = $this->model::with('employe');

        // Auth-based filtering
        if (auth()->user()->type !== "Admin") {
            $query->where('emplyee_id', auth()->user()->employee->id ?? 0);
        }

        // Search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('date', 'like', "%{$search}%")
                    ->orWhereHas('employe', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%")
                            ->orWhere('id_card', 'like', "%{$search}%");
                    });
            });
        }

        // Count filtered results
        $totalFiltered = $query->count();

        // Sort: first by date, then by employee name
        // Sort: by date DESC and id_card ASC
        $query->orderBy('date', 'desc')
            ->orderBy(
                Employee::select('id_card')
                    ->whereColumn('employees.id', 'attendances.emplyee_id')
                    ->limit(1),
                'asc'
            );


        // Paginate
        $Attendance = $query->offset($start)
            ->limit($limit)
            ->get();

        $totalData = $this->model::count();

        // Prepare data
        $data = [];
        $previousDate = null;

        foreach ($Attendance as $key => $value) {
            $currentDate = $value->date;

            // Insert a red spacer row when the date changes
            if ($previousDate !== null && $previousDate !== $currentDate) {
                $data[] = [
                    'id' => '',
                    'id_cart' => '',
                    'emplyee_id' => '',
                    'date' => '',
                    'sign_in' => '',
                    'location_in' => '',
                    'sign_out' => '',
                    'location_out' => '',
                    'action' => '',
                    'DT_RowClass' => 'red-separator' // special class for styling
                ];
            }

            $nestedData['id'] = $start + count($data) + 1; // account for spacer rows
            $nestedData['id_cart'] = $value->employe->id_card ?? '';
            $nestedData['emplyee_id'] = ucfirst($value->employe->name ?? '');
            $nestedData['date'] = $value->date;
            $nestedData['sign_in'] = $value->sign_in ? date('h:i A', strtotime($value->sign_in)) : 'N/A';

            $nestedData['location_in'] = ($value->latitude && $value->longitude)
                ? '<a href="https://www.google.com/maps?q=' . $value->latitude . ',' . $value->longitude . '" target="_blank">Check In Location</a>'
                : 'N/A';

            $nestedData['sign_out'] = $value->sign_out ? date('h:i A', strtotime($value->sign_out)) : 'N/A';

            $nestedData['location_out'] = ($value->latitude_out && $value->longitude_out)
                ? '<a href="https://www.google.com/maps?q=' . $value->latitude_out . ',' . $value->longitude_out . '" target="_blank">Check Out Location</a>'
                : 'N/A';


            $previousDate = $currentDate;
            $edit_data = '<a href="' . route('hrm.attendance.edit', $value->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';

            $view_data = '<a href="' . route('hrm.attendance.show', $value->id) . '" class="btn btn-xs btn-default"><i class="fa fa-eye" aria-hidden="true"></i></a>';

            $delete_data = '<a delete_route="' . route('hrm.attendance.destroy', $value->id) . '" delete_id="' . $value->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $value->id . '"><i class="fa fa-times"></i></a>';

            $nestedData['action'] = $edit_data . ' ' . $view_data . ' ' . $delete_data;


            $data[] = $nestedData;
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

    public function signin($request)
    {
        // $branch = Branch::first();
        // $branchId = Auth()->id() ?? $branch->id;

        if ($request->emplyee_id == 'all') {
            $employees = Employee::get();
            $attendances = [];

            foreach ($employees as $data) {
                // Check if attendance exists for this employee and date
                $existing = $this->model::where('emplyee_id', $data->id)
                    ->where('date', $request->date)
                    ->first();

                // If exists, delete it
                if ($existing) {
                    $existing->delete();
                }

                // Create new attendance
                $Attendance = new $this->model;
                $Attendance->emplyee_id = $data->id;
                // $Attendance->branch_id = $branchId;
                $Attendance->date = $request->date;
                $Attendance->sign_in = $request->sign_in;
                $Attendance->latitude = $request->latitude;
                $Attendance->longitude = $request->longitude;
                $Attendance->save();

                $attendances[] = $Attendance;
            }

            return $attendances;
        } else {
            // Check if attendance exists for this employee and date
            $existing = $this->model::where('emplyee_id', $request->emplyee_id)
                ->where('date', $request->date)
                ->first();

            if ($existing) {
                $existing->delete();
            }

            $Attendance = new $this->model;
            $Attendance->emplyee_id = $request->emplyee_id;
            // $Attendance->branch_id = $branchId;
            $Attendance->date = $request->date;
            $Attendance->sign_in = $request->sign_in;
            $Attendance->latitude = $request->latitude;
            $Attendance->longitude = $request->longitude;
            $Attendance->save();

            return $Attendance;
        }
    }



    public function signout($request)
    {
        $branch = Branch::first();
        $Attendance['emplyee_id'] = $request->emplyee_id;
        $Attendance['branch_id'] = Auth()->id() ?? $branch->id;
        $Attendance['sign_out'] = $request->sign_out;
        $Attendance['latitude_out'] = $request->latitude;
        $Attendance['longitude_out'] = $request->longitude;
        $Attendance = Attendance::where('emplyee_id', $request->emplyee_id)->whereDate('date', $request->date)->update($Attendance);
        return $Attendance;
    }
    public function absent($request)
    {
        $branch = Branch::first();
        $Attendance = new $this->model;
        $Attendance->emplyee_id = $request->emplyee_id;
        $Attendance->branch_id = auth()->id() ?? $branch->id;
        $Attendance->date = $request->date;
        $Attendance->sign_in = null;
        $Attendance->sign_out = null;
        $Attendance->latitude = $request->latitude;
        $Attendance->longitude = $request->longitude;
        $Attendance->save();

        return $Attendance;
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
        $attendance = $this->model::find($id);
        $attendance->delete();
        return true;
    }

    public function edit($id)
    {
        $model = $this->model::find($id);

        return $model;
    }

    public function update($request, $id)
    {
        $attendance = $this->model::find($id);
        if ($attendance) {
            $attendance->update([
                'date'      => $request->date,
                'sign_in'   => $request->sign_in,
                'sign_out'   => $request->sign_out,
            ]);
        }
        return $attendance;
    }
}
