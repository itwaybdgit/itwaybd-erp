<?php

namespace App\Services\Hrm;

use App\Repositories\Hrm\AttendanceRepositories;

class AttendanceService
{

    /**
     * @var $CustomerPaymentRepositories
     */
    private $systemRepositories;

    /**
     * AdminCourseService constructor.
     * @param $CustomerPaymentRepositories $branchRepositories
     */
    public function __construct(AttendanceRepositories $systemRepositories)
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
            'emplyee_id' => 'required',
            'date' => 'required',
            'sign_in' => 'required',
            'sign_out' => 'required',
        ];
    }

    /**
     * @param $request
     * @return array
     */
    public function signinValidation($request)
    {
        return [
            'emplyee_id' => 'required',
            'sign_in' => 'required',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function signoutValidation($request)
    {
        return [
            'emplyee_id' => 'required',
            'sign_out' => 'required',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function attendanceEditValidation($request)
    {
        return [
            'date' => 'required',
            'sign_in' => 'required',
            'sign_out' => 'required',
        ];
    }

    /**
     * @param $request
     * @return \App\Models\Currency
     */
    public function signin($request)
    {
        return $this->systemRepositories->signin($request);
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
    public function signout($request)
    {
        return $this->systemRepositories->signout($request);
    }

    /**
     * @param $request
     * @param $id
     */
    public function destroy($id)
    {
        return $this->systemRepositories->destroy($id);
    }
     public function absent($request)
    {
        return $this->systemRepositories->absent($request);
    }

    /**
     * @param $request
     * @param $id
     */
    public function edit($id)
    {
        return $this->systemRepositories->edit($id);
    }

    /**
     * @param $request
     * @param $id
     */
    public function update($request, $id)
    {
        return $this->systemRepositories->update($request, $id);
    }
}
