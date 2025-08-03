<?php

namespace App\Services\Hrm;

use App\Repositories\Hrm\EmployeeRepositories;
use Illuminate\Validation\Rule;

class EmployeeService
{

    /**
     * @var $EmployeePaymentRepositories
     */
    private $systemRepositories;

    /**
     * AdminCourseService constructor.
     * @param $EmployeePaymentRepositories
     */
    public function __construct(EmployeeRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        return $this->systemRepositories->getList($request);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getAllList()
    {
        return $this->systemRepositories->getAllList();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function statusUpdate($request, $id)
    {
        return $this->systemRepositories->statusUpdate($request, $id);
    }

    public function statusValidation($request)
    {
        return [
            'id' => 'required',
            'status' => 'required',
        ];
    }

    /**
     * @param $request
     * @return array
     */
    public function storeValidation($request)
    {
        return [
            'name' => ['required'],
            'dob' => ['nullable'],
            'gender' => ['required'],
            'personal_phone' => ['required'],

            'id_card' => ['required', 'unique:employees,id_card'],
            'office_phone' => ['nullable', 'numeric'],
            'marital_status' => ['nullable'],
            'nid' => ['nullable'],
            'email' => ['nullable', 'email'], // added email validation
            'reference' => ['nullable'],
            'last_in_time' => ['required'],
            'department' => ['nullable'],
            'position_id' => ['nullable'],
            'experience' => ['nullable'],
            'Active_address' => ['nullable'],
            'permanent_address' => ['nullable'],
            'achieved_degree' => ['nullable'],
            'institution' => ['nullable'],
            'passing_year' => ['nullable', 'numeric'], // assuming year
            'salary' => ['nullable', 'numeric'], // added numeric
            'join_date' => ['nullable', 'date'], // added date validation
            'status' => ['nullable'],
            'image' => ['nullable', 'image'], // added image validation
            'emp_signature' => ['nullable', 'image'],
            'guardian_numer' => ['nullable'],
            'guardian_nid' => ['nullable'],
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function updateValidation($request, $id)
    {

        return [
            'name' => ['required'],
            'dob' => ['nullable'],
            'gender' => ['required'],
            'personal_phone' => ['required'],

            'id_card' => [
                'required',
                Rule::unique('employees', 'id_card')->ignore($id)
            ],
            'office_phone' => ['nullable', 'numeric'],
            'marital_status' => ['nullable'],
            'nid' => ['nullable'],
            'email' => ['nullable', 'email'],
            'reference' => ['nullable'],
            'last_in_time' => ['required'],
            'department' => ['nullable'],
            'position_id' => ['nullable'],
            'experience' => ['nullable'],
            'Active_address' => ['nullable'],
            'permanent_address' => ['nullable'],
            'achieved_degree' => ['nullable'],
            'institution' => ['nullable'],
            'passing_year' => ['nullable'],
            'salary' => ['nullable', 'numeric'],
            'join_date' => ['nullable', 'date'],
            'status' => ['nullable'],
            'image' => ['nullable', 'image'],
            'emp_signature' => ['nullable', 'image'],
            'guardian_numer' => ['nullable'],
            'guardian_nid' => ['nullable'],
        ];
    }

    /**
     * @param $request
     * @return \App\Models\Currency
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Currency
     */
    public function details($id)
    {

        return $this->systemRepositories->details($id);
    }

    /**
     * @param $request
     * @param $id
     */
    public function update($request, $id)
    {
        return $this->systemRepositories->update($request, $id);
    }

    /**
     * @param $request
     * @param $id
     */
    public function destroy($id)
    {
        return $this->systemRepositories->destroy($id);
    }
}
