<?php

namespace App\Repositories\Hrm;

use App\Helpers\Helper;
use App\Models\Accounts;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Rats\Zkteco\Lib\ZKTeco;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeRepositories
{
    /**
     * @var employe
     */
    private $model;

    /**
     * Repository Position.
     * @param position $position
     */
    public function __construct(Employee $position)
    {
        $this->model = $position;
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
            $position = $this->model::offset($start)
                ->limit($limit)
                // ->orderBy($order, $dir)
                ->orderBy('id_card', 'desc')
                ->get();
            $totalFiltered = $this->model::count();
        } else {
            $search = $request->input('search.value');
            $position = $this->model::where('name', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                // ->orderBy($order, $dir)
                ->orderBy('id_card', 'desc')
                ->get();
            $totalFiltered = $this->model::where('name', 'like', "%{$search}%")->count();
        }


        $data = array();
        if ($position) {
            foreach ($position as $key => $value) {
                $nestedData['id'] = $value->id_card;
                $nestedData['name'] = $value->name;
                $nestedData['dob'] = $value->dob;
                $nestedData['gender'] = $value->gender;
                $nestedData['personal_phone'] = $value->personal_phone;
                $nestedData['office_phone'] = $value->office_phone;
                $nestedData['nid'] = $value->nid;
                $nestedData['email'] = $value->email;
                $nestedData['department'] = $value->department;
                $nestedData['present_address'] = $value->present_address;
                $nestedData['salary'] = $value->salary;
                $nestedData['over_time_is'] = $value->over_time_is;
                $nestedData['join_date'] = $value->join_date;


                $edit_data = '<a href="' . route('hrm.employee.edit', $value->id) . '" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true"></i></a>';

                $view_data = '<a href="' . route('hrm.employee.show', $value->id) . '" class="btn btn-xs btn-default"><i class="fa fa-eye" aria-hidden="true"></i></a>';

                $delete_data = '<a delete_route="' . route('hrm.employee.destroy', $value->id) . '" delete_id="' . $value->id . '" title="Delete" class="btn btn-xs btn-default delete_row uniqueid' . $value->id . '"><i class="fa fa-times"></i></a>';

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

        $valideted = $request->validate([
            'name' => ['required'],
            'hidden' => ['nullable'],
            'id_card' => ['nullable'],
            'email' => ['required', 'unique:employees,email'],
            'user_id' => ['nullable', 'numeric'],
            'dob' => ['nullable'],
            'gender' => ['nullable'],
            'username' => [Rule::requiredIf(!empty($request->username)), 'unique:users,username'],
            'roll_id' => [Rule::requiredIf(!empty($request->roll_id))],
            'personal_phone' => ['nullable'],
            'office_phone' => ['nullable'],
            'marital_status' => ['nullable'],
            'nid' => ['nullable'],
            'last_in_time' => ['nullable'],
            'reference' => ['nullable'],
            'experience' => ['nullable'],
            'present_address' => ['nullable'],
            'permanent_address' => ['nullable'],
            'department_id' => ['nullable'],
            'designation_id' => ['nullable'],
            'achieved_degree' => ['nullable'],
            'institution' => ['nullable'],
            'passing_year' => ['nullable'],
            'salary' => ['nullable'],
            'join_date' => ['nullable'],
            'image' => ['nullable'],
            'emp_signature' => ['nullable'],
            'updated_by' => ['nullable'],
            'created_by' => ['nullable'],
            'deleted_by' => ['nullable'],
            'over_time_is' => ['required'],
            'blood_group' => ['nullable'],
            'is_login' => ['nullable'],
            'zone_id' => ['nullable'],
            'subzone_id' => ['nullable'],
            'branch_id' => ['nullable'],
            'password' => ['nullable', 'confirmed', 'min:6',],
        ]);


        DB::beginTransaction();
        if ($request->is_login == "true") {
            $user['name'] = $request->name;
            $user['username'] = $request->username;
            $user['email'] = $request->email;
            $user['office_phone'] = $request->office_phone;
            $user['roll_id'] = $request->roll_id;
            $user['company_id'] = auth()->user()->company_id;
            $user['is_admin'] = $request->access_type;
            $user['password'] = Hash::make($request->password);
            $userDs = User::create($user);
            $valideted['user_id'] = $userDs->id;
        }
        $image = $request->file('image');
        if (isset($image)) {
            $currentDate = Carbon::now()->toDateString();
            $imageName  = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('photo')) {
                Storage::disk('public')->makeDirectory('photo');
            }

            $image->storeAs('photo', $imageName, 'public');
        } else {
            $imageName = null;
        }
        $valideted['image'] = $imageName;
        // Emplyee Signature

        $image = $request->file('emp_signature');
        if (isset($image)) {
            $currentDate = Carbon::now()->toDateString();
            $imageName  = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('photo')) {
                Storage::disk('public')->makeDirectory('photo');
            }

            $image->storeAs('photo', $imageName, 'public');
        } else {
            $imageName = null;
        }
        $valideted['emp_signature'] = $imageName;
        $valideted['zone_id'] = implode(",", $request->zone_id ?? []);
        $valideted['subzone_id'] = implode(",", $request->subzone_id ?? []);
        $employee = Employee::create($valideted);
        DB::commit();


        if (env("ZKTECO")) {
            $employeedf = createZKTecoEmployee([
                "emp_code" => $employee->id,
                "first_name" => $request->username,
                "last_name" => null,
                "nickname" => null,
                "card_no" => null,
                "department" => 1,
                "position" => null,
                "hire_date" => $request->join_date ?? date("Y-m-d"),
                "gender" => null,
                "birthday" => null,
                "verify_mode" => 0,
                "emp_type" => null,
                "contact_tel" => null,
                "office_tel" => null,
                "mobile" => null,
                "national" => null,
                "city" => null,
                "address" => null,
                "postcode" => null,
                "email" => null,
                "enroll_sn" => "",
                "ssn" => null,
                "religion" => null,
                "enable_att" => true,
                "enable_overtime" => false,
                "enable_holiday" => true,
                "dev_privilege" => 0,
                "area" => $request->department_id ?? '',
                "app_status" => 1,
                "app_role" => 1
            ]);
            $employee->device_id = $employeedf['id'] ?? 0;

            $employee->save();
        } else {

            $employee->save();
        }

        return $employee;
    }

    public function update($request, $id)
    {

        $employee = $this->model::find($id);
        $employee->name = $request->name;
        $employee->dob = $request->dob;
        $employee->id_card = $request->id_card;
        $employee->gender = $request->gender;
        $employee->personal_phone = $request->personal_phone;
        $employee->branch_id = $request->branch_id;
        $employee->office_phone = $request->office_phone;
        $employee->marital_status = $request->marital_status;
        $employee->nid = $request->nid;
        $employee->email = $request->email;
        $employee->last_in_time = $request->last_in_time;
        $employee->reference = $request->reference;
        $employee->department_id = $request->department_id;
        // $employee->position_id = $request->position_id;
        $employee->experience = $request->experience;
        $employee->present_address = $request->present_address;
        $employee->permanent_address = $request->permanent_address;
        $employee->achieved_degree = $request->achieved_degree;
        $employee->institution = $request->institution;
        $employee->passing_year = $request->passing_year;
        $employee->attendanceBonus = $request->attendanceBonus;
        $employee->salary = $request->salary;
        $employee->join_date = $request->join_date;
        $employee->blood_group = $request->blood_group;
        $employee->over_time_is = $request->over_time_is;
        $employee->updated_by = auth()->id();
        $employee->guardian_number = $request->guardian_number;
        $employee->is_login = $request->is_login ? 1 : 0;


        $image = $request->file('image');
        if (isset($image)) {
            $currentDate = Carbon::now()->toDateString();
            $imageName  = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('photo')) {
                Storage::disk('public')->makeDirectory('photo');
            }

            Storage::disk('public')->delete('photo/' . $employee->image);

            $image->storeAs('photo', $imageName, 'public');
            $employee->image = $imageName;
        }


        // Emplyee Signature

        $emp_signature = $request->file('emp_signature');
        if (isset($emp_signature)) {
            $currentDate = Carbon::now()->toDateString();
            $imageNameemp_signature  = $currentDate . '-' . uniqid() . '.' . $emp_signature->getClientOriginalExtension();

            if (!Storage::disk('public')->exists('photo')) {
                Storage::disk('public')->makeDirectory('photo');
            }

            Storage::disk('public')->delete('photo/' . $employee->emp_signature);

            $emp_signature->storeAs('photo', $imageNameemp_signature, 'public');
            $employee->emp_signature = $imageNameemp_signature;
        }

        // Emplyee Guardian NID Photo

        $guardian_nid = $request->file('guardian_nid');
        if (isset($guardian_nid)) {
            $currentDate = Carbon::now()->toDateString();
            $imageNameguardian_nid  = $currentDate . '-' . uniqid() . '.' . $guardian_nid->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('photo')) {
                Storage::disk('public')->makeDirectory('photo');
            }
            Storage::disk('public')->delete('photo/' . $employee->guardian_nid);
            $guardian_nid->storeAs('photo', $imageNameguardian_nid, 'public');
            $employee->guardian_nid = $imageNameguardian_nid;
        }
        $employee->am_name = $request->am_name;
        $employee->area = json_encode($request->area);
        $employee->save();

        if (env("ZKTECO")) {
            $local =  editZKTecoEmployee($employee->device_id, [
                "emp_code" => $employee->id,
                "first_name" => $request->am_name,
                "last_name" => null,
                "nickname" => null,
                "card_no" => null,
                "department" => 1,
                "position" => null,
                "hire_date" => $request->join_date ?? date("Y-m-d"),
                "gender" => null,
                "birthday" => null,
                "verify_mode" => 0,
                "emp_type" => null,
                "contact_tel" => null,
                "office_tel" => null,
                "mobile" => null,
                "national" => null,
                "city" => null,
                "address" => null,
                "postcode" => null,
                "email" => null,
                "enroll_sn" => "",
                "ssn" => null,
                "religion" => null,
                "enable_att" => true,
                "enable_overtime" => false,
                "enable_holiday" => true,
                "dev_privilege" => 0,
                "area" => $request->area,
                "app_status" => 1,
                "app_role" => 1
            ]);

            \Log::info('editZKTecoEmployee response', ['response' => $local]);

            if (!is_array($local)) {
                $data = json_decode($local, true);
            }

            if (isset($data['detail']) && $data['detail'] === 'Not found.') {
                $employeedf = createZKTecoEmployee([
                    "emp_code" => $employee->id,
                    "first_name" => $request->am_name,
                    "last_name" => null,
                    "nickname" => null,
                    "card_no" => null,
                    "department" => 1,
                    "position" => null,
                    "hire_date" => $request->join_date ?? date("Y-m-d"),
                    "gender" => null,
                    "birthday" => null,
                    "verify_mode" => 0,
                    "emp_type" => null,
                    "contact_tel" => null,
                    "office_tel" => null,
                    "mobile" => null,
                    "national" => null,
                    "city" => null,
                    "address" => null,
                    "postcode" => null,
                    "email" => null,
                    "enroll_sn" => "",
                    "ssn" => null,
                    "religion" => null,
                    "enable_att" => true,
                    "enable_overtime" => false,
                    "enable_holiday" => true,
                    "dev_privilege" => 0,
                    "area" => $request->area,
                    "app_status" => 1,
                    "app_role" => 1
                ]);
                $employee->device_id = $employeedf['id'] ?? 0;
                $employee->save();
            }
        } else {
            $employee->save();
        }
        return $employee;
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
