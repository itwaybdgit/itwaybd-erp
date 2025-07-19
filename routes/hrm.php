<?php

use App\Http\Controllers\Report\AccountReportController;
use App\Http\Controllers\Report\LedgerReportController;
use App\Http\Controllers\Report\BalanceSheetController;
use App\Http\Controllers\Report\TrialBalanceController;
use App\Http\Controllers\Report\IncomeStatementController;
use App\Http\Controllers\Admin\Device\DeviceController;

use App\Http\Controllers\Backend\Hrm\PositionController;
use App\Http\Controllers\Backend\Hrm\AttendanceController;
use App\Http\Controllers\Backend\Hrm\EmployeeController;
use App\Http\Controllers\Backend\Hrm\AttendanceLogController;
use App\Http\Controllers\Backend\Hrm\PaySheetController;
use App\Http\Controllers\Backend\Hrm\LeaveApplicationController;
use App\Http\Controllers\Backend\Hrm\LoneApplicationController;
use App\Http\Controllers\Backend\Hrm\ApproveLeaveApplicationController;
use App\Http\Controllers\Backend\Hrm\HoliDayController;
use App\Http\Controllers\Backend\Hrm\ApproveCashReqApplicationController;
use App\Http\Controllers\Backend\Hrm\PayrollController;
use App\Http\Controllers\Backend\Hrm\CashApplicationController;
use Illuminate\Support\Facades\Route;

// Route::prefix('admin')->namespace('Admin')->middleware(['auth'])->group(function () {
//     //account report start
//     Route::name('report.')->prefix('report')->group(function () {
//         Route::get('/cashbook', [AccountReportController::class, 'cashbook'])->name('cashbook');
//         Route::get('/create-report/cashbook', [AccountReportController::class, 'createReport'])->name('cashbooksearch');

//         Route::get('/ledger', [LedgerReportController::class, 'index'])->name('ledger');
//         Route::post('/create-report/ledger', [LedgerReportController::class, 'index'])->name('ledgersearch');

//         Route::any('/trialbalance', [TrialBalanceController::class, 'index'])->name('trialbalance');
//         Route::any('/incomestatement', [IncomeStatementController::class, 'index'])->name('incomestatement');
//         Route::any('/balancesheet', [BalanceSheetController::class, 'index'])->name('balancesheet');
//     });
//     //account report end
// });

Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {
    // position setup crud start
    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Hrm'], function () {
        //position crud operation start
        Route::get('/hrm-position-list', [PositionController::class, 'index'])->name('hrm.position.index');
        Route::get('/dataProcessingposition', [PositionController::class, 'dataProcessingposition'])->name('hrm.position.dataProcessingPosition');
        Route::get('/hrm-position-create', [PositionController::class, 'create'])->name('hrm.position.create');
        Route::post('/hrm-position-store', [PositionController::class, 'store'])->name('hrm.position.store');
        Route::get('/hrm-position-edit/{id}', [PositionController::class, 'edit'])->name('hrm.position.edit');
        Route::get('/hrm-position-show/{id}', [PositionController::class, 'show'])->name('hrm.position.show');
        Route::post('/hrm-position-update/{id}', [PositionController::class, 'update'])->name('hrm.position.update');
        Route::get('/hrm-position-delete/{id}', [PositionController::class, 'destroy'])->name('hrm.position.destroy');
        Route::get('/hrm-position-status/{id}/{status}', [PositionController::class, 'statusUpdate'])->name('hrm.position.status');
        //position crud operation end

        //area crud operation start
        Route::get('/hrm-area-list', 'AreaController@index')->name('hrm.area.index');
        Route::get('/dataProcessing-area', 'AreaController@dataProcessing')->name('hrm.area.dataProcessing');
        Route::get('/hrm-area-create', 'AreaController@create')->name('hrm.area.create');
        Route::post('/hrm-area-store', 'AreaController@store')->name('hrm.area.store');
        Route::get('/hrm-area-edit/{id}', 'AreaController@edit')->name('hrm.area.edit');
        Route::get('/hrm-area-show/{id}', 'AreaController@show')->name('hrm.area.show');
        Route::post('/hrm-area-update/{id}', 'AreaController@update')->name('hrm.area.update');
        Route::get('/hrm-area-delete/{id}', 'AreaController@destroy')->name('hrm.area.destroy');
        Route::get('/hrm-area-status/{id}/{status}', 'AreaController@statusUpdate')->name('hrm.area.status');
        //area crud operation end

        //Employe crud operation start

        Route::get('/hrm-employe-list', [EmployeeController::class, 'index'])->name('hrm.employee.index');

        Route::get('/hrm-left-employe-list', [EmployeeController::class, 'index2'])->name('hrm.employee.index2');

        Route::get('/dataProcessingemployee', [EmployeeController::class, 'dataProcessingEmployee'])->name('hrm.employee.dataProcessingEmployee');
        Route::get('/hrm-employe-create', [EmployeeController::class, 'create'])->name('hrm.employee.create');
        Route::post('/hrm-employe-store', [EmployeeController::class, 'store'])->name('hrm.employee.store');
        Route::get('/hrm-employe-edit/{id}', [EmployeeController::class, 'edit'])->name('hrm.employee.edit');
        Route::get('/hrm-employe-show/{employee:id}', [EmployeeController::class, 'show'])->name('hrm.employee.show');
        Route::post('/hrm-employe-update/{id}', [EmployeeController::class, 'update'])->name('hrm.employee.update');
        Route::get('/hrm-employe-delete/{id}', [EmployeeController::class, 'destroy'])->name('hrm.employee.destroy');
        Route::get('/hrm-employe-status/{id}/{status}', [EmployeeController::class, 'statusUpdate'])->name('hrm.employee.status');
        Route::get('/create-accounts', [EmployeeController::class, 'storeAccount'])->name('accounts.create');
        //Employe crud operation end

        //Salary Pay crud operation start
        Route::any('/hrm-salary-pay-sheet-list', [PaySheetController::class, 'index'])->name('hrm.paysheet.index');
        Route::get('/hrm-salary-pay-sheet-show/{pay:id}', [PaySheetController::class, 'show'])->name('hrm.paysheet.show');
        Route::post('/hrm-salary-pay-details-store/{monthlyPayableSalary:id}', [PaySheetController::class, 'empPayDetailsStore'])->name('hrm.paysheet.empPayDetailsStore');

        //Salary Pay crud operation end

        //Leave Application crud operation start
        Route::get('/hrm-leave-applicaitn-list', [LeaveApplicationController::class, 'index'])->name('hrm.leave.index');
        Route::get('/dataProcessingLeaveApplication', [LeaveApplicationController::class, 'dataProcessingLeaveApplication'])->name('hrm.leave.dataProcessingLeaveApplication');
        Route::get('/hrm-leave-applicaitn-create', [LeaveApplicationController::class, 'create'])->name('hrm.leave.create');
        Route::post('/hrm-leave-applicaitn-store', [LeaveApplicationController::class, 'store'])->name('hrm.leave.store');
        Route::get('/hrm-leave-applicaitn-edit/{id}', [LeaveApplicationController::class, 'edit'])->name('hrm.leave.edit');
        Route::post('/hrm-leave-applicaitn-update/{id}', [LeaveApplicationController::class, 'update'])->name('hrm.leave.update');
        Route::get('/hrm-leave-applicaitn-show/{leave:id}', [LeaveApplicationController::class, 'show'])->name('hrm.leave.show');
        Route::get('/hrm-leave-applicaitn-delete/{id}', [LeaveApplicationController::class, 'destroy'])->name('hrm.leave.destroy');
        //Leave Application crud operation end

        // Leave Approve  start
        Route::get('/hrm-leave-approve-applicaitn-lists', [ApproveLeaveApplicationController::class, 'index'])->name('hrm.leaveapprove.index');
        Route::get('/dataProcessingApproveLeaveApplication', [ApproveLeaveApplicationController::class, 'dataProcessingApproveLeaveApplication'])->name('hrm.leaveapprove.dataProcessingApproveLeaveApplication');
        Route::get('/hrm-leave-approve-applicaitn-update/{leave:id}', [ApproveLeaveApplicationController::class, 'edit'])->name('hrm.leaveapprove.approve');
        Route::get('/hrm-leave-approve-applicaitn-show/{leave:id}', [ApproveLeaveApplicationController::class, 'show'])->name('hrm.leaveapprove.show');
        Route::get('/hrm-leave-approve-applicaitn-cancel/{leave:id}', [ApproveLeaveApplicationController::class, 'cancel'])->name('hrm.leaveapprove.cancel');

        // Leave Approve End

        //Lone Application crud operation start
        Route::get('/hrm-lone-applicaitn-list', [LoneApplicationController::class, 'index'])->name('hrm.lone.index');
        Route::get('/dataProcessingLoneApplication', [LoneApplicationController::class, 'dataProcessingLoneApplication'])->name('hrm.lone.dataProcessingLoneApplication');
        Route::get('/hrm-lone-applicaitn-create', [LoneApplicationController::class, 'create'])->name('hrm.lone.create');
        Route::post('/hrm-lone-applicaitn-store', [LoneApplicationController::class, 'store'])->name('hrm.lone.store');
        Route::get('/hrm-lone-applicaitn-edit/{id}', [LoneApplicationController::class, 'edit'])->name('hrm.lone.edit');
        Route::get('/hrm-lone-applicaitn-show/{lone:id}', [LoneApplicationController::class, 'show'])->name('hrm.lone.show');
        Route::post('/hrm-lone-applicaitn-update/{id}', [LoneApplicationController::class, 'update'])->name('hrm.lone.update');
        Route::get('/hrm-lone-applicaitn-delete/{id}', [LoneApplicationController::class, 'destroy'])->name('hrm.lone.destroy');
        //Lone Application crud operation end

        //Cash Application crud operation start
        Route::get('/hrm-cash-req-applicaitn-list', [CashApplicationController::class, 'index'])->name('hrm.cashapplicaon.index');
        Route::get('/cash-loan-dataProcessing', [CashApplicationController::class, 'dataProcessing'])->name('hrm.cashapplicaon.dataProcessing');
        Route::get('/hrm-cash-req-applicaitn-create', [CashApplicationController::class, 'create'])->name('hrm.cashapplicaon.create');
        Route::post('/hrm-cash-req-applicaitn-store', [CashApplicationController::class, 'store'])->name('hrm.cashapplicaon.store');
        Route::get('/hrm-cash-req-applicaitn-edit/{id}', [CashApplicationController::class, 'edit'])->name('hrm.cashapplicaon.edit');
        Route::get('/hrm-cash-req-applicaitn-show/{lone:id}', [CashApplicationController::class, 'show'])->name('hrm.cashapplicaon.show');
        Route::post('/hrm-cash-req-applicaitn-update/{id}', [CashApplicationController::class, 'update'])->name('hrm.cashapplicaon.update');
        Route::get('/hrm-cash-req-applicaitn-delete/{id}', [CashApplicationController::class, 'destroy'])->name('hrm.cashapplicaon.destroy');
        //Cash Application crud operation end

        // Cash Approve start
        Route::get('/hrm-cash-req-approve-applicaitn-lists', [ApproveCashReqApplicationController::class, 'index'])->name('hrm.cash-req.index');
        Route::get('/cash-req-dataProcessing', [ApproveCashReqApplicationController::class, 'dataProcessing'])->name('hrm.cash-req.dataProcessingApprove');
        Route::get('/hrm-cash-req-approve-applicaitn-update/{lone:id}', [ApproveCashReqApplicationController::class, 'edit'])->name('hrm.cash-req.approve');
        Route::get('/hrm-cash-req-approve-applicaitn-show/{lone:id}', [ApproveCashReqApplicationController::class, 'show'])->name('hrm.cash-req.show');
        Route::get('/hrm-cash-req-approve-applicaitn-cancel/{lone:id}', [ApproveCashReqApplicationController::class, 'cancel'])->name('hrm.cash-req.cancel');
        // Cash Approve End
        // Lone Approve start
        Route::get('/hrm-lone-approve-applicaitn-lists', 'ApproveLoneApplicationController@index')->name('hrm.loneapprove.index');
        Route::get('/dataProcessingApproveLoneApplication', 'ApproveLoneApplicationController@dataProcessingApproveLoneApplication')->name('hrm.loneapprove.dataProcessingApproveLoneApplication');
        Route::get('/hrm-lone-approve-applicaitn-update/{lone:id}', 'ApproveLoneApplicationController@edit')->name('hrm.loneapprove.approve');
        Route::get('/hrm-lone-approve-applicaitn-show/{lone:id}', 'ApproveLoneApplicationController@show')->name('hrm.loneapprove.show');
        Route::get('/hrm-lone-approve-applicaitn-cancel/{lone:id}', 'ApproveLoneApplicationController@cancel')->name('hrm.loneapprove.cancel');
        // Lone Approve End

        //Salary Sheet crud operation start
        Route::get('/hrm-salary-sheet-list', 'SalarySheetController@index')->name('hrm.salary.sheet.index');
        Route::get('/dataProcessingsalarysheet', 'SalarySheetController@dataProcessingSalarySheet')->name('hrm.salary.sheet.dataProcessingSalarySheet');
        Route::get('/hrm-salary-sheet-create', 'SalarySheetController@create')->name('hrm.salary.sheet.create');
        Route::post('/hrm-salary-sheet-store', 'SalarySheetController@store')->name('hrm.salary.sheet.store');
        Route::get('/hrm-salary-sheet-edit/{id}', 'SalarySheetController@edit')->name('hrm.salary.sheet.edit');
        Route::get('/hrm-salary-sheet-show/{id}', 'SalarySheetController@show')->name('hrm.salary.sheet.show');
        Route::post('/hrm-salary-sheet-update/{id}', 'SalarySheetController@update')->name('hrm.salary.sheet.update');
        Route::get('/hrm-salary-sheet-delete/{id}', 'SalarySheetController@destroy')->name('hrm.salary.sheet.destroy');
        Route::get('/hrm-salary-sheet-status/{id}/{status}', 'SalarySheetController@statusUpdate')->name('hrm.salary.sheet.status');
        //Salary Sheet crud operation end

        //Award crud operation start
        Route::get('/hrm-award-list', 'AwardController@index')->name('hrm.award.index');
        Route::get('/dataProcessingAward', 'AwardController@dataProcessingAward')->name('hrm.award.dataProcessingAward');
        Route::get('/hrm-award-create', 'AwardController@create')->name('hrm.award.create');
        Route::post('/hrm-award-store', 'AwardController@store')->name('hrm.award.store');
        Route::get('/hrm-award-edit/{id}', 'AwardController@edit')->name('hrm.award.edit');
        Route::get('/hrm-award-show/{id}', 'AwardController@show')->name('hrm.award.show');
        Route::post('/hrm-award-update/{id}', 'AwardController@update')->name('hrm.award.update');
        Route::get('/hrm-award-delete/{id}', 'AwardController@destroy')->name('hrm.award.destroy');
        Route::get('/hrm-award-status/{id}/{status}', 'AwardController@statusUpdate')->name('hrm.award.status');
        //Award crud operation end

        //Salary attendance crud operation start

        Route::get('/hrm-attendance-index', [AttendanceController::class, 'index'])->name('hrm.attendance.index');
        Route::get('/dataProcessingattendance', [AttendanceController::class, 'dataProcessingattendance'])->name('hrm.attendance.dataProcessingattendance');
        Route::get('/hrm-attendance-create', [AttendanceController::class, 'create'])->name('hrm.attendance.create');
        Route::get('/hrm-attendance-show', [AttendanceController::class, 'show'])->name('hrm.attendance.show');
        Route::get('/hrm-attendance-edit/{id}', [AttendanceController::class, 'edit'])->name('hrm.attendance.edit');
        Route::post('/hrm-attendance-update/attendance/{id}', [AttendanceController::class, 'update'])->name('hrm.attendance.update.attendnace');
        Route::get('/hrm.attendance.destroy/{id}', [AttendanceController::class, 'destroy'])->name('hrm.attendance.destroy');
        Route::match(['get', 'post'], '/hrm.attendance.mark', [AttendanceController::class, 'mark'])->name('hrm.attendance.mark');
        Route::get('/attendance/filter', [AttendanceController::class, 'filter'])->name('hrm.attendance.filter');
        Route::post('/attendance/ajax-update', [AttendanceController::class, 'ajaxUpdate'])->name('attendance.ajaxUpdate');
        Route::post('/attendance/mark/update/{id}', [AttendanceController::class, 'updateSingle'])->name('attendance.update.mark');
        Route::get('/admin/attendance/fetch-row/{attendanceId}', [AttendanceController::class, 'fetchRow']);
        Route::post('/hrm-attendance-sign_in', [AttendanceController::class, 'sign_in'])->name('hrm.attendance.sign_in');
        Route::post('/hrm-attendance-sign_out', [AttendanceController::class, 'sign_out'])->name('hrm.attendance.sign_out');
        Route::post('/hrm-attendance-absent-employee', [AttendanceController::class, 'absentEmployee'])->name('hrm.attendance.absent.employee');

        //Salary attendance crud operation end
        //Payroll start

        Route::get('/hrm-payroll-index', [PayrollController::class, 'index'])->name('hrm.payroll.index');
        Route::post('/hrm-payroll-fetch', [PayrollController::class, 'fetch'])->name('hrm.payroll.fetch');
        Route::get('/hrm-payroll-report', [PayrollController::class, 'report'])->name('hrm.payroll.report');
        Route::get('/hrm-payroll-create', [PayrollController::class, 'create'])->name('hrm.payroll.create');
        Route::post('/hrm-payroll-store', [PayrollController::class, 'store'])->name('hrm.payroll.store');
        Route::get('/hrm-payroll-show/{id}', [PayrollController::class, 'show'])->name('hrm.payroll.show');
        Route::get('/hrm-payroll-edit/{id}', [PayrollController::class, 'edit'])->name('hrm.payroll.edit');
        Route::post('/hrm-payroll-update/{id}', [PayrollController::class, 'update'])->name('hrm.payroll.update');
        Route::get('/hrm-payroll-payslip', [PayrollController::class, 'payslip'])->name('hrm.payslip.index');
        //Payroll End+


        //HoliDay crud operation start
        Route::get('/hrm-holiday-list', [HoliDayController::class, 'index'])->name('hrm.holiday.index');
        Route::get('/hrm-holidays', [HoliDayController::class, 'indexList']);
        Route::post('/hrm-holiday-store', [HoliDayController::class, 'store'])->name('hrm.holiday.store');
        Route::post('/hrm-holiday-update/{holiday}', [HoliDayController::class, 'update'])->name('hrm.holiday.update');
        Route::delete('/hrm-holiday-delete/{holiday}', [HoliDayController::class, 'destroy'])->name('hrm.holiday.destroy');
        Route::get('/hrm-holiday-status/{holiday}/{status}', [HoliDayController::class, 'statusUpdate'])->name('hrm.holiday.status');

        //HoliDay crud operation end

        //Salary attendance crud operation start
        Route::any('/hrm-attendance-log-create', [AttendanceLogController::class, 'index'])->name('hrm.attendancelog.index');
        Route::any('/hrm-attendance-absent', [AttendanceLogController::class, 'absent'])->name('hrm.absencelog.index');
        Route::any('/hrm-attendance-newemployee', [AttendanceLogController::class, 'newemployee'])->name('hrm.employee.newemployee');
    });


    Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Recruitment'], function () {
        //Candidate Information crud operation start
        Route::get('/candidate-list', 'CandidateInformationController@index')->name('candidate.index');
        Route::get('/dataProcessingCandidate', 'CandidateInformationController@dataProcessingCandidate')->name('candidate.dataProcessingCandidate');
        Route::get('/candidate-create', 'CandidateInformationController@create')->name('candidate.create');
        Route::post('/candidate-store', 'CandidateInformationController@store')->name('candidate.store');
        Route::get('/candidate-edit/{id}', 'CandidateInformationController@edit')->name('candidate.edit');
        Route::get('/candidate-show/{candidateInformation:id}', 'CandidateInformationController@show')->name('candidate.show');
        Route::post('/candidate-update/{id}', 'CandidateInformationController@update')->name('candidate.update');
        Route::get('/candidate-delete/{id}', 'CandidateInformationController@destroy')->name('candidate.destroy');
        Route::get('/candidate-status/{id}/{status}', 'CandidateInformationController@statusUpdate')->name('candidate.status');
        //Candidate Information crud operation end

        //Candidate Shortlist crud operation start
        Route::get('/candidate-shortlist', 'CandidateShortlistController@index')->name('candidate.shortlist.index');
        Route::get('/dataProcessingCandidateShortlist', 'CandidateShortlistController@dataProcessingCandidateShortlist')->name('candidate.shortlist.dataProcessingCandidateShortlist');
        Route::get('/candidate-shortlist-create', 'CandidateShortlistController@create')->name('candidate.shortlist.create');
        Route::post('/candidate-shortlist-store', 'CandidateShortlistController@store')->name('candidate.shortlist.store');
        Route::get('/candidate-shortlist-edit/{id}', 'CandidateShortlistController@edit')->name('candidate.shortlist.edit');
        Route::get('/candidate-shortlist-show/{candidateInformation:id}', 'CandidateShortlistController@show')->name('candidate.shortlist.show');
        Route::post('/candidate-shortlist-update/{id}', 'CandidateShortlistController@update')->name('candidate.shortlist.update');
        Route::get('/candidate-shortlist-delete/{id}', 'CandidateShortlistController@destroy')->name('candidate.shortlist.destroy');
        Route::get('/candidate-shortlist-status/{id}/{status}', 'CandidateShortlistController@statusUpdate')->name('candidate.shortlist.status');
        //Candidate Shortlist crud operation end

        //Candidate Selection crud operation start
        Route::get('/candidate-selection', 'CandidateSelectionController@index')->name('candidate.selection.index');
        Route::get('/dataProcessingCandidateSelection', 'CandidateSelectionController@dataProcessingCandidateSelection')->name('candidate.selection.dataProcessingCandidateSelection');
        Route::get('/candidate-selection-create', 'CandidateSelectionController@create')->name('candidate.selection.create');
        Route::post('/candidate-selection-store', 'CandidateSelectionController@store')->name('candidate.selection.store');
        Route::get('/candidate-selection-edit/{id}', 'CandidateSelectionController@edit')->name('candidate.selection.edit');
        Route::get('/candidate-selection-show/{candidateInformation:id}', 'CandidateSelectionController@show')->name('candidate.selection.show');
        Route::post('/candidate-selection-update/{id}', 'CandidateSelectionController@update')->name('candidate.selection.update');
        Route::get('/candidate-selection-delete/{id}', 'CandidateSelectionController@destroy')->name('candidate.selection.destroy');
        Route::get('/candidate-selection-status/{id}/{status}', 'CandidateSelectionController@statusUpdate')->name('candidate.selection.status');
        //Candidate Shortlist crud operation end
    });
});

require __DIR__ . '/auth.php';
