<?php

use App\Http\Controllers\Admin\Crm\AdminApproveController;
use App\Http\Controllers\Admin\Crm\BillingApproveController;
use App\Http\Controllers\Admin\Crm\BranchController;
use App\Http\Controllers\Admin\Crm\ConfirmBillingApproveController;
use App\Http\Controllers\Admin\Crm\FollowUpListController;
use App\Http\Controllers\Admin\Crm\LeadGenerationController;
use App\Http\Controllers\Admin\Crm\LegalApproveController;
use App\Http\Controllers\Admin\Crm\Level1ApproveController;
use App\Http\Controllers\Admin\Crm\Level2ApproveController;
use App\Http\Controllers\Admin\Crm\Level3ApproveController;
use App\Http\Controllers\Admin\Crm\MeetingDateController;
use App\Http\Controllers\Admin\Crm\Noc2ApproveController;
use App\Http\Controllers\Admin\Crm\NocApproveController;
use App\Http\Controllers\Admin\Crm\TransmissionApproveController;
use App\Http\Controllers\ConnectedPathController;
use App\Http\Controllers\DowngradationListtxpluningController;
use App\Http\Controllers\DowngradationPendingBillingController;
use App\Http\Controllers\DowngradtionConfrimBillingController;
use App\Http\Controllers\DowngradtionlistBillingController;
use App\Http\Controllers\DowngradtionListLevel3Controller;
use App\Http\Controllers\DowngradtionListSaleHeadController;
use App\Http\Controllers\UpgradtionListBillingController;
use App\Http\Controllers\UpgradtionListConfrimBillingController;
use App\Http\Controllers\UpgradtionListLevel3Controller;
use App\Http\Controllers\UpgradtionListSaleHeadController;
use App\Http\Controllers\UpgradtionListtxpluningController;
use App\Http\Controllers\UpgradtionPendingBillingController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->namespace('Admin')->middleware(['auth'])->group(function () {
    //account report start
    Route::name('lead.')->prefix('lead')->group(function () {
        Route::get('/list/{ids?}', [LeadGenerationController::class, 'index'])->name('index');
        Route::get('/dataProcessing/{ids?}', [LeadGenerationController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [LeadGenerationController::class, 'create'])->name('create');
        Route::post('/store', [LeadGenerationController::class, 'store'])->name('store');
        Route::get('/edit/{lead:id}', [LeadGenerationController::class, 'edit'])->name('edit');
        Route::get('/schedule/{lead:id}', [LeadGenerationController::class, 'schedule'])->name('schedule');
        Route::post('/schedule/store/{id}', [LeadGenerationController::class, 'schedulestore'])->name('schedule.store');
        Route::post('/schedule/update/{schedule:id}', [LeadGenerationController::class, 'scheduleupdate'])->name('schedule.update');
        Route::post('/update/{lead:id}', [LeadGenerationController::class, 'update'])->name('update');
        Route::get('/destroy/{lead:id}', [LeadGenerationController::class, 'destroy'])->name('destroy');
        Route::get('/get-items-by-category/{id}', [LeadGenerationController::class, 'getItemsByCategory']);
        Route::get('/confirm/sale/{lead:id}', [LeadGenerationController::class, 'confirmsale'])->name('confirmsale');
        Route::post('/confirm/sale/store/{lead:id}', [LeadGenerationController::class, 'confirmsalestore'])->name('confirmsale.store');

        Route::GET('/division', [LeadGenerationController::class, 'division'])->name('division');
        Route::GET('/upazila', [LeadGenerationController::class, 'upazila'])->name('upazila');

    });

    Route::name('followup.')->prefix('followup')->group(function () {
        Route::get('/list', [FollowUpListController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [FollowUpListController::class, 'dataProcessing'])->name('dataProcessing');
    });
    Route::name('branch.')->prefix('branch')->group(function () {
        Route::get('/list', [BranchController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BranchController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BranchController::class, 'create'])->name('create');
        Route::post('/store', [BranchController::class, 'store'])->name('store');
        Route::get('/edit/{branch:id}', [BranchController::class, 'edit'])->name('edit');
        Route::post('/update/{branch:id}', [BranchController::class, 'update'])->name('update');
        Route::get('/delete/{branch:id}', [BranchController::class, 'destroy'])->name('destroy');

    });

    Route::name('meeting.')->prefix('meeting')->group(function () {
        Route::get('/list', [MeetingDateController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MeetingDateController::class, 'dataProcessing'])->name('dataProcessing');
    });

    Route::name('admin_approv.')->prefix('admin-approv')->group(function () {
        Route::get('/list', [AdminApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [AdminApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [AdminApproveController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [AdminApproveController::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}/approve', [AdminApproveController::class, 'approve'])->name('approve');
    });

    Route::name('upgradtion_salehead.')->prefix('upgradtion-salehead')->group(function () {
        Route::get('/list', [UpgradtionListSaleHeadController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UpgradtionListSaleHeadController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [UpgradtionListSaleHeadController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [UpgradtionListSaleHeadController::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}/approve', [UpgradtionListSaleHeadController::class, 'approve'])->name('approve');
    });

    Route::name('upgradtionlist-billing.')->prefix('upgradtion-list-billing')->group(function () {
        Route::get('/list', [UpgradtionListBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UpgradtionListBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [UpgradtionListBillingController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [UpgradtionListBillingController::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}/approve', [UpgradtionListBillingController::class, 'approve'])->name('approve');
    });

    Route::name('upgradtionlist-level3.')->prefix('upgradtion-list-level3')->group(function () {
        Route::get('/list', [UpgradtionListLevel3Controller ::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UpgradtionListLevel3Controller ::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [UpgradtionListLevel3Controller ::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [UpgradtionListLevel3Controller ::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}/approve', [UpgradtionListLevel3Controller ::class, 'approve'])->name('approve');
        Route::get('/approve/{customer:id}/confirm', [UpgradtionListLevel3Controller::class, 'confirm'])->name('confirm');
        Route::post('/edit/gateway/{customer:id}/updatestore', [UpgradtionListLevel3Controller::class, 'updatestore'])->name('updatestore');
    });

    Route::name('upgradtion-confrim-billing.')->prefix('upgradtion-confrim-billing')->group(function () {
        Route::get('/list', [UpgradtionListConfrimBillingController ::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UpgradtionListConfrimBillingController ::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [UpgradtionListConfrimBillingController ::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [UpgradtionListConfrimBillingController ::class, 'store'])->name('store');
        Route::post('/confirm/billing/{customer:id}', [UpgradtionListConfrimBillingController::class, 'confirm'])->name('confirm');
        Route::get('/check/validity/{customer:id}/approve', [UpgradtionListConfrimBillingController ::class, 'approve'])->name('approve');
    });

    Route::name('upgradtion_pending_billing.')->prefix('upgradtion_pending_billing')->group(function () {
        Route::get('/list', [UpgradtionPendingBillingController ::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UpgradtionPendingBillingController ::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [UpgradtionPendingBillingController ::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [UpgradtionPendingBillingController ::class, 'store'])->name('store');
        Route::post('/confirm/billing/{customer:id}', [UpgradtionPendingBillingController::class, 'confirm'])->name('confirm');
        Route::get('/check/validity/{customer:id}/approve', [UpgradtionPendingBillingController ::class, 'approve'])->name('approve');
    });


    Route::name('downgrading-salehead.')->prefix('downgrading-salehead')->group(function () {
        Route::get('/list', [DowngradtionListSaleHeadController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DowngradtionListSaleHeadController ::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DowngradtionListSaleHeadController::class, 'create'])->name('create');
        Route::post('/store', [DowngradtionListSaleHeadController::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}', [DowngradtionListSaleHeadController::class, 'check_validity'])->name('check_validity');
        Route::get('/show/{downgradation:id}', [DowngradtionListSaleHeadController::class, 'show'])->name('show');
        Route::get('/approve/{downgradation:id}', [DowngradtionListSaleHeadController::class, 'approve'])->name('approve');
        Route::get('/update/{downgradation:id}', [DowngradtionListSaleHeadController::class, 'update'])->name('update');
    });

    Route::name('downgrading-billing.')->prefix('downgrading-billing')->group(function () {
        Route::get('/list', [DowngradtionlistBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DowngradtionlistBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DowngradtionlistBillingController::class, 'create'])->name('create');
        Route::post('/store', [DowngradtionlistBillingController::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}', [DowngradtionlistBillingController::class, 'check_validity'])->name('check_validity');
        Route::get('/show/{downgradation:id}', [DowngradtionlistBillingController::class, 'show'])->name('show');
        Route::get('/approve/{downgradation:id}', [DowngradtionlistBillingController::class, 'approve'])->name('approve');
        Route::get('/update/{downgradation:id}', [DowngradtionlistBillingController::class, 'update'])->name('update');
    });

    Route::name('downgradationlist_tx.')->prefix('downgradation-tx-plumbing')->group(function () {
        Route::get('/list', [DowngradationListtxpluningController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DowngradationListtxpluningController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [DowngradationListtxpluningController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [DowngradationListtxpluningController::class, 'store'])->name('store');
        Route::get('/edit/gateway/{customer:id}/updatedata', [DowngradationListtxpluningController::class, 'updatedata'])->name('updatedata');
        Route::post('/edit/gateway/{customer:id}/updatestore', [DowngradationListtxpluningController::class, 'updatestore'])->name('updatestore');
        Route::get('/edit/gateway/{customer:id}/approve', [DowngradationListtxpluningController::class, 'approve'])->name('approve');
    });

    Route::name('downgrading-level3.')->prefix('downgrading-level3')->group(function () {
        Route::get('/list', [DowngradtionListLevel3Controller ::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DowngradtionListLevel3Controller ::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [DowngradtionListLevel3Controller ::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [DowngradtionListLevel3Controller ::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}/approve', [DowngradtionListLevel3Controller ::class, 'approve'])->name('approve');
        Route::get('/approve/{customer:id}/confirm', [DowngradtionListLevel3Controller::class, 'confirm'])->name('confirm');
        Route::post('/edit/gateway/{customer:id}/updatestore', [DowngradtionListLevel3Controller::class, 'updatestore'])->name('updatestore');
    });

    Route::name('downgrading-confrim-billing.')->prefix('downgrading-confrim-billing')->group(function () {
        Route::get('/list', [DowngradtionConfrimBillingController ::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DowngradtionConfrimBillingController ::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [DowngradtionConfrimBillingController ::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [DowngradtionConfrimBillingController ::class, 'store'])->name('store');
        Route::post('/confirm/billing/{customer:id}', [DowngradtionConfrimBillingController::class, 'confirm'])->name('confirm');
        Route::get('/check/validity/{customer:id}/approve', [DowngradtionConfrimBillingController ::class, 'approve'])->name('approve');
    });

    Route::name('downgrading_pending_billing.')->prefix('downgrading-pending-billing')->group(function () {
        Route::get('/list', [DowngradationPendingBillingController ::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DowngradationPendingBillingController ::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [DowngradationPendingBillingController ::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [DowngradationPendingBillingController ::class, 'store'])->name('store');
        Route::post('/confirm/billing/{customer:id}', [DowngradationPendingBillingController::class, 'confirm'])->name('confirm');
        Route::get('/check/validity/{customer:id}/approve', [DowngradationPendingBillingController ::class, 'approve'])->name('approve');
    });

    Route::name('legal_approv.')->prefix('legal-approv')->group(function () {
        Route::get('/list', [LegalApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [LegalApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [LegalApproveController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [LegalApproveController::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}/approve', [LegalApproveController::class, 'approve'])->name('approve');
    });

    Route::name('connected_path.')->prefix('connected-path')->group(function () {
        Route::get('/list', [ConnectedPathController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ConnectedPathController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ConnectedPathController::class, 'create'])->name('create');
        Route::post('/store', [ConnectedPathController::class, 'store'])->name('store');
        Route::get('/invoice/{connectedpath:id}', [ConnectedPathController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{connectedpath:id}', [ConnectedPathController::class, 'edit'])->name('edit');
        Route::post('/update/{connectedpath:id}', [ConnectedPathController::class, 'update'])->name('update');
        Route::get('/delete/{connectedpath:id}', [ConnectedPathController::class, 'destroy'])->name('destroy');
    });

    Route::name('transmission_approv.')->prefix('transmission-approv')->group(function () {
        Route::get('/list', [TransmissionApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [TransmissionApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [TransmissionApproveController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [TransmissionApproveController::class, 'store'])->name('store');
        Route::post('/transmission/{customer:id}/store', [TransmissionApproveController::class, 'storetransmission'])->name('store.transmission');
        Route::get('/transmission/{customer:id}/approve', [TransmissionApproveController::class, 'approve'])->name('approve');
        Route::get('/transmission/{customer:id}/dataupdate', [TransmissionApproveController::class, 'dataupdate'])->name('dataupdate');
        Route::post('/transmission/{id}/datastore', [TransmissionApproveController::class, 'datastore'])->name('datastore');
    });

    Route::name('noc_approv.')->prefix('noc-approv')->group(function () {
        Route::get('/list', [NocApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [NocApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [NocApproveController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [NocApproveController::class, 'store'])->name('store');
        Route::get('/edit/gateway/{customer:id}/updatedata', [NocApproveController::class, 'updatedata'])->name('updatedata');
        Route::post('/edit/gateway/{customer:id}/updatestore', [NocApproveController::class, 'updatestore'])->name('updatestore');
        Route::get('/edit/gateway/{customer:id}/approve', [NocApproveController::class, 'approve'])->name('approve');
    });

    Route::name('upgradtionlist_tx.')->prefix('tx-plumbing')->group(function () {
        Route::get('/list', [UpgradtionListtxpluningController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UpgradtionListtxpluningController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [UpgradtionListtxpluningController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [UpgradtionListtxpluningController::class, 'store'])->name('store');
        Route::get('/edit/gateway/{customer:id}/updatedata', [UpgradtionListtxpluningController::class, 'updatedata'])->name('updatedata');
        Route::post('/edit/gateway/{customer:id}/updatestore', [UpgradtionListtxpluningController::class, 'updatestore'])->name('updatestore');
        Route::get('/edit/gateway/{customer:id}/approve', [UpgradtionListtxpluningController::class, 'approve'])->name('approve');
    });

    Route::name('noc2_approv.')->prefix('level-4')->group(function () {
        Route::get('/list', [Noc2ApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [Noc2ApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [Noc2ApproveController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [Noc2ApproveController::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}/approve', [Noc2ApproveController::class, 'approve'])->name('approve');
    });

    Route::name('level_3.')->prefix('level-3')->group(function () {
        Route::get('/list', [Level3ApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [Level3ApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [Level3ApproveController::class, 'check_validity'])->name('check_validity');
        Route::post('/level-3/{customer:id}/assing_by', [Level3ApproveController::class, 'assing_by'])->name('assing_by');
        Route::get('/check/validity/{customer:id}/approve', [Level3ApproveController::class, 'approve'])->name('approve');
        Route::get('/check/validity/{customer:id}/task', [Level3ApproveController::class, 'task'])->name('task.store');
        Route::post('/edit/gateway/{customer:id}/updatestore', [Level3ApproveController::class, 'updatestore'])->name('updatestore');
        Route::get('/approve/{customer:id}/confirm', [Level3ApproveController::class, 'confirm'])->name('confirm');
    });

    Route::name('level_2.')->prefix('level-2')->group(function () {
        Route::get('/list', [Level2ApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [Level2ApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [Level2ApproveController::class, 'check_validity'])->name('check_validity');
        Route::post('/level-3/{customer:id}/assing_by', [Level2ApproveController::class, 'assing_by'])->name('assing_by');
        Route::get('/check/validity/{customer:id}/approve', [Level2ApproveController::class, 'approve'])->name('approve');
        Route::post('/edit/gateway/{customer:id}/updatestore', [Level2ApproveController::class, 'updatestore'])->name('updatestore');
        Route::get('/check/validity/{customer:id}/task', [Level2ApproveController::class, 'task'])->name('task.store');
    });

    Route::name('level_1.')->prefix('level-1')->group(function () {
        Route::get('/list', [Level1ApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [Level1ApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [Level1ApproveController::class, 'check_validity'])->name('check_validity');
        Route::post('/level-3/{customer:id}/assing_by', [Level1ApproveController::class, 'assing_by'])->name('assing_by');
        Route::get('/check/validity/{customer:id}/approve', [Level1ApproveController::class, 'approve'])->name('approve');
        Route::post('/edit/gateway/{customer:id}/updatestore', [Level1ApproveController::class, 'updatestore'])->name('updatestore');
        Route::get('/check/validity/{customer:id}/task', [Level1ApproveController::class, 'task'])->name('task.store');
    });

    Route::name('billing_approv.')->prefix('billing-approv')->group(function () {
        Route::get('/list', [BillingApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BillingApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [BillingApproveController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [BillingApproveController::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}/approve', [BillingApproveController::class, 'approve'])->name('approve');
    });

    Route::name('confirm_billing_approv.')->prefix('confirm-billing-approv')->group(function () {
        Route::get('/list', [ConfirmBillingApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ConfirmBillingApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [ConfirmBillingApproveController::class, 'check_validity'])->name('check_validity');
        Route::post('/confirm/billing/{customer:id}', [ConfirmBillingApproveController::class, 'confirm'])->name('confirm');
        Route::get('/check/validity/{customer:id}/approve', [ConfirmBillingApproveController::class, 'approve'])->name('approve');
    });
});
