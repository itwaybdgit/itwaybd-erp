<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\Admin\Customer\CustomerController;
use App\Http\Controllers\Admin\Package\PackageController;
use App\Http\Controllers\Admin\Package\Package2Controller;
use App\Http\Controllers\Admin\Attendance\AttendanceController;
use App\Http\Controllers\Admin\Attendance\AttendanceLogController;
use App\Http\Controllers\Admin\SalarySheet\SalarySheetControlller;
use App\Http\Controllers\Admin\LeaveApplication\LeaveApplicationController;
use App\Http\Controllers\Admin\LoneApplication\LoneApplicationController;
use App\Http\Controllers\Admin\LeaveApplication\LeaveApplicationApproveController;
use App\Http\Controllers\Admin\LoneApplication\LoneApplicationApproveController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Account\AccountController;
use App\Http\Controllers\Admin\Account\BillTransferController;

use App\Http\Controllers\Admin\Account\DailyIncomeReportController;
use App\Http\Controllers\Admin\Account\ExpenseReportController;
use App\Http\Controllers\Admin\Account\SupplierLedgerController;
use App\Http\Controllers\Admin\Asset\AssetCategoryController;
use App\Http\Controllers\Admin\Asset\AssetContoller;
use App\Http\Controllers\Admin\Asset\ReasonController;
use App\Http\Controllers\Admin\BandwidthBuy\ItemCategoryController;
use App\Http\Controllers\Admin\BandwidthBuy\ItemController;
use App\Http\Controllers\Admin\BandwidthBuy\ProviderController;
use App\Http\Controllers\Admin\BandwidthSale\BandwidthSaleInvoiceController;
use App\Http\Controllers\Admin\BandwidthSale\BandwidthCustomerController;
use App\Http\Controllers\Admin\BandwidthSale\CustomerBandwidthSaleInvoiceController;
use App\Http\Controllers\Admin\BandwidthSale\DIsBandwidthCustomerController;
use App\Http\Controllers\Admin\BandwidthSale\PendingBandwidthCustomerController;
use App\Http\Controllers\Admin\BandwidthSale\RejectBandwidthCustomerController;
use App\Http\Controllers\Admin\Billing\AdvanceBillingController;
use App\Http\Controllers\Admin\Billing\BillingController;
use App\Http\Controllers\Admin\Billing\CollectedBillingController;
use App\Http\Controllers\Admin\Billing\NoPaidCustomerController;
use App\Http\Controllers\Admin\BillingStatus\BillingStatusController;
use App\Http\Controllers\Admin\Box\BoxController;
use App\Http\Controllers\Admin\ClientType\ClientTypeController;
use App\Http\Controllers\Admin\ConnectionType\ConnectionTypeController;
use App\Http\Controllers\Admin\Crm\CapLevel4ApproveController;
use App\Http\Controllers\Admin\Crm\DiscontinueTransmissionController;
use App\Http\Controllers\Admin\Crm\GenerateBillingApproveController;
use App\Http\Controllers\Admin\Crm\NIRequestTransmissionController;
use App\Http\Controllers\Admin\Crm\OptimizeTransmissionController;
use App\Http\Controllers\Admin\Crm\RevertController;
use App\Http\Controllers\Admin\Crm\UncapLevel4ApproveController;
use App\Http\Controllers\Admin\Customer\GeneralCustomerController;
use App\Http\Controllers\Admin\Customer\NewConnectionController;
use App\Http\Controllers\Admin\Customer\StaticCustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Destroyitem\DestroyItemController;
use App\Http\Controllers\Admin\PayRoll\DepartmentController;
use App\Http\Controllers\Admin\Device\DeviceController;
use App\Http\Controllers\Admin\Tj\TjController;
use App\Http\Controllers\Admin\Expense\ExpenseController;
use App\Http\Controllers\Admin\Discount\DiscountController;
use App\Http\Controllers\Admin\Employee\EmployeeController;
use App\Http\Controllers\Admin\Employee\EmployeeExpenseController;
use App\Http\Controllers\Admin\Employee\SalaryController;
use App\Http\Controllers\Admin\Expense\ExpenseCategoryController;
use App\Http\Controllers\Admin\Sms\SmsController;
use App\Http\Controllers\Admin\Group\GroupController;
use App\Http\Controllers\Admin\Income\DailyIncomeController;
use App\Http\Controllers\Admin\Income\IncomeCategoryController;
use App\Http\Controllers\Admin\Income\IncomeHistoryController;
use App\Http\Controllers\Admin\InstallationFee\InstallationFeeController;
use App\Http\Controllers\Admin\Inventory\BrandController;
use App\Http\Controllers\Admin\Inventory\ProductCategoryController;
use App\Http\Controllers\Admin\Inventory\ProductController;
use App\Http\Controllers\Admin\Inventory\UnitController;
use App\Http\Controllers\Admin\LicenseType\LicenseTypeController;
use App\Http\Controllers\Admin\MacReseller\AddResellerFundController;
use App\Http\Controllers\Admin\MacReseller\MacResellerController;
use App\Http\Controllers\Admin\MacReseller\MacPackageController;
use App\Http\Controllers\Admin\MacReseller\MacTariffConfigController;
use App\Http\Controllers\Admin\MacReseller\ResellerFundingController;
use App\Http\Controllers\Admin\MikrotikServer\MikrotikServerController;
use App\Http\Controllers\Admin\MPPPProfile\MPPPProfileController;
use App\Http\Controllers\Admin\PaymentMethod\PaymentMethodController;
use App\Http\Controllers\Admin\PayRoll\DesignationController;
use App\Http\Controllers\Admin\PayRoll\TeamController;
use App\Http\Controllers\Admin\Ppp\ActiveConnectionController;
use App\Http\Controllers\Admin\Ppp\MInterfaceController;
use App\Http\Controllers\Admin\Ppp\MPoolController;
use App\Http\Controllers\Admin\Protocol\ProtocolController;
use App\Http\Controllers\Admin\Report\BtrcReportController;
use App\Http\Controllers\Admin\Splitter\SplitterController;
use App\Http\Controllers\Admin\Purchase\PurchaseController;
use App\Http\Controllers\Admin\Purchase\PurchaseRequisitionController;
use App\Http\Controllers\Admin\Report\BillCollectionReportController;
use App\Http\Controllers\Admin\Report\CustomerReportController;
use App\Http\Controllers\Admin\Report\DiscountReportController;
use App\Http\Controllers\Admin\Report\ResellerReportController;
use App\Http\Controllers\Admin\Report\TeamPersonReportController;
use App\Http\Controllers\Admin\Report\TeamReportController;
use App\Http\Controllers\Admin\Report\TicketReportController;
use App\Http\Controllers\Admin\Report\UpstreamReportController;
use App\Http\Controllers\Admin\RollPermissionController;
use App\Http\Controllers\Admin\Setup\CompanyController;
use App\Http\Controllers\Admin\Setup\MailSetupController;
use App\Http\Controllers\Admin\StockOut\StockOutController;
use App\Http\Controllers\Admin\Subzone\SubzoneController;
use App\Http\Controllers\Admin\Supplier\SupplierController;
use App\Http\Controllers\Admin\SupportTicketing\CustomerSupportTicketController;
use App\Http\Controllers\Admin\SupportTicketing\MySupportTicketController;
use App\Http\Controllers\Admin\SupportTicketing\SourceController;
use App\Http\Controllers\Admin\SupportTicketing\SupportCategoryController;
use App\Http\Controllers\Admin\SupportTicketing\SupportStatusController;
use App\Http\Controllers\Admin\SupportTicketing\SupportTicketController;
use App\Http\Controllers\Admin\TodayCollectedController;
use App\Http\Controllers\Admin\UserPackage\UserPackageController;
use App\Http\Controllers\Admin\Zone\ZoneController;
use App\Http\Controllers\Billing\BillingDetailsController;
use App\Http\Controllers\PackageUpdateDownRate\PackageUpdateDownRateController;
use App\Http\Controllers\BalanceTransferController;
use App\Http\Controllers\BkashPaymentController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CapLevel3Controller;
use App\Http\Controllers\CustomBillController;
use App\Http\Controllers\Customer\auth\BandwidthCustomerAuth;
use App\Http\Controllers\Customer\auth\CustomerLogin;
use App\Http\Controllers\CustomerResellerCapUncapController;
use App\Http\Controllers\CustomerResellerDowngradingController;
use App\Http\Controllers\CustomerResellerOptimizeController;
use App\Http\Controllers\CustomerResellerUpgradationController;
use App\Http\Controllers\DashboardBillListController;
use App\Http\Controllers\DashboardCollectedBillController;
use App\Http\Controllers\Dashboardindex\TodayCustomerOff;
use App\Http\Controllers\Dashboardindex\TomorrowCustomerOff;
use App\Http\Controllers\DataSourceController;
use App\Http\Controllers\DiscontinueBillingController;
use App\Http\Controllers\DiscontinueConfrimBillingController;
use App\Http\Controllers\DiscontinueLevel3Controller;
use App\Http\Controllers\DiscontinueSaleHeadController;
use App\Http\Controllers\DiscontinueTxPluningController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\MikrotikCustomerList;
use App\Http\Controllers\NIRequestBillingController;
use App\Http\Controllers\NIRequestLevel3Controller;
use App\Http\Controllers\NIRequestPendingBillingController;
use App\Http\Controllers\NIRequestSaleHeadController;
use App\Http\Controllers\NIRequestTConfrimBillingController;
use App\Http\Controllers\NIRequestTxPluningController;
use App\Http\Controllers\OpeningBalanceController;
use App\Http\Controllers\OptimizeBillingController;
use App\Http\Controllers\OptimizeConfrimBillingController;
use App\Http\Controllers\OptimizeLevel3Controller;
use App\Http\Controllers\OptimizePendingBillingController;
use App\Http\Controllers\OptimizeSaleHeadController;
use App\Http\Controllers\OptimizeTxPluningController;
use App\Http\Controllers\PopController;
use App\Http\Controllers\PurchaseBillController;
use App\Http\Controllers\RunFunController;
use App\Http\Controllers\StaticIp\IpAddressController;
use App\Http\Controllers\StaticIp\QueueController;
use App\Http\Controllers\StaticIp\VlanController;
use App\Http\Controllers\SupportHistoryController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Ticketing\TicketingController;
use App\Http\Controllers\UpozillaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\MacResellerReportController;
use App\Http\Controllers\ResellerCapUncapController;
use App\Http\Controllers\ResellerDiscontinueController;
use App\Http\Controllers\ResellerDowngradingController;
use App\Http\Controllers\ResellerNIRequestController;
use App\Http\Controllers\ResellerOptimizeController;
use App\Http\Controllers\ResellerUpgradationController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\UncapBillingController;
use App\Http\Controllers\UncapLevel3Controller;
use App\Http\Controllers\UncapSaleHeadController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Admin\ProjectManager\ProjectController;
use App\Http\Controllers\Admin\Task\TaskController;
use App\Http\Controllers\Admin\Task\MytaskController;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

// Route::get('/password-resolve', [RunFunController::class, 'resetpass']);

Route::get('/update-rowter', function () {
    $customers  = App\Models\Customer::get();

    foreach ($customers as $customer) {
        $code = 'SafaIT' . str_pad($customer->id, 8, "0", STR_PAD_LEFT);
        $customer->update(['client_id' => $code]);
    }
    return 'back';
});

Route::any('/test', [TestController::class, 'index']);

Route::any('/zkt/test', [TestController::class, 'zkt']);

Route::get('/storagelink', function () {
    $output = [];
    \Artisan::call('storage:link', $output);
    dd($output);
});

Route::get('/tnx-you', function () {
    return  view('thankyou');
})->name('tnx.you');

Route::any('/bandwidthcustomer-login/customer/login', [BandwidthCustomerAuth::class, 'customer'])->name('bandwidthcustomer.login');

Route::any('/customer/login', [CustomerLogin::class, 'customer'])->name('customer.login');

Route::get('/invoice/{dm}&{id}', [DashboardController::class, 'invoice'])->name('invoice.payment');

Route::get('/bkash/create-payment/{id}', [App\Http\Controllers\BkashTokenizePaymentController::class, 'createPayment'])->name('bkash-invoice-payment');

Route::get('/customer/bkash/callback', [App\Http\Controllers\BkashTokenizePaymentController::class, 'callBack'])->name('bkash-callBack');

Route::prefix('customer')->namespace('Customer')->middleware(['customerAuth'])->group(function () {
    Route::get('/dashboard', [CustomerLogin::class, 'dashboard'])->name('customer.dashboard');

    //Ticketing start
    Route::name('ticketing.')->prefix('ticketing')->group(function () {
        Route::get('/list', [TicketingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [TicketingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [TicketingController::class, 'create'])->name('create');
        Route::post('/store', [TicketingController::class, 'store'])->name('store');
        Route::get('/show/{ticketing:id}', [TicketingController::class, 'show'])->name('show');
        Route::get('/edit/{ticketing:id}', [TicketingController::class, 'edit'])->name('edit');
        Route::post('/update/{ticketing:id}', [TicketingController::class, 'update'])->name('update');
        Route::get('/delete/{ticketing:id}', [TicketingController::class, 'destroy'])->name('destroy');
    });
    //Ticketing end

    //Billing Details start
    Route::name('billing_details.')->prefix('billing_details')->group(function () {
        Route::get('/list', [BillingDetailsController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BillingDetailsController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BillingDetailsController::class, 'create'])->name('create');
        Route::post('/store', [BillingDetailsController::class, 'store'])->name('store');
        Route::post('/update/{billingdetails:id}', [BillingDetailsController::class, 'update'])->name('update');
        Route::get('/pay-bill-details/{billingdetails:id}', [BillingDetailsController::class, 'payment'])->name('payment');
        Route::get('/pay-bill/{billingdetails:id}', [BillingDetailsController::class, 'pay'])->name('pay');
        Route::get('/invoice/{billingdetails:id}', [BillingDetailsController::class, 'invoice'])->name('invoice');
        Route::get('/invoice-print', [BillingDetailsController::class, 'invoiceprint'])->name('invoice.print');
        Route::get('/pay-list/{billingdetails:id}', [BillingDetailsController::class, 'paylist'])->name('paylist');
        Route::get('/bkash/create-payment/{id}', [App\Http\Controllers\BkashTokenizePaymentController::class, 'createPayment'])->name('bkash-create-payment');
    });

    //Billing Details End

    // Payment Routes for bKash
    Route::get('/bkash/payment', [App\Http\Controllers\BkashTokenizePaymentController::class, 'index']);


    //search payment
    Route::get('/bkash/search/{trxID}', [App\Http\Controllers\BkashTokenizePaymentController::class, 'searchTnx'])->name('bkash-serach');

    //refund payment routes
    Route::get('/bkash/refund', [App\Http\Controllers\BkashTokenizePaymentController::class, 'refund'])->name('bkash-refund');
    Route::get('/bkash/refund/status', [App\Http\Controllers\BkashTokenizePaymentController::class, 'refundStatus'])->name('bkash-refund-status');
});

Route::get('/customer/logout', [CustomerLogin::class, 'customerlogout']);
Route::get('/logout', [AccessController::class, 'logout']);

Route::prefix('admin')->namespace('Admin')->middleware(['auth'])->group(function () {

    Route::get('test', function () {
        $data = [
            'title' => 'Test PDF',
            'date' => date('d-m-Y'),
        ];
        $pdf = Pdf::loadView('test', $data);
        return $pdf->stream('Test.pdf');
    });

    Route::get('/change-password', [AccessController::class, 'change_password'])->name('change.password');
    Route::post('/update-change-password', [AccessController::class, 'update_change_password'])->name('update.change.password');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/ticketlist', [DashboardController::class, 'ticketlist'])->name('dashboard.ticketlist');
    Route::get('/dashboard/lead/details', [DashboardController::class, 'lead_details'])->name('dashboard.lead_details');

    Route::get('/customerInfo', [DashboardController::class, 'customerInfo'])->name('customerInfo');

    Route::get('/customerInactive', [DashboardController::class, 'customerInactive'])->name('customerInactive');

    Route::get('/newcustomer', [DashboardController::class, 'newcustomer'])->name('newcustomer');

    Route::get('/dashboard/bill/{type}', [DashboardBillListController::class, 'index'])->name('dashboard.bill');
    Route::get('/dashboard/dataProcessing/{id}', [DashboardBillListController::class, 'dataProcessing'])->name('dashboardbill.dataProcessing');

    // Route::get('/todays-billings', [TodayCollectedController::class, 'index'])->name('todays_billings');
    Route::any('/todays-billings', [DashboardController::class, 'TodayCollectedBill'])->name('todays_billings');

    Route::get('/totalCollectedBill', [DashboardController::class, 'totalCollectedBill'])->name('totalCollectedBill');
    Route::get('/totalCollectedBill-dataprocess', [DashboardController::class, 'dataProcessing'])->name('totalCollectedBill.dataprocess');
    Route::get('/totaldueBill', [DashboardController::class, 'totalpaindingBill'])->name('totaldueBill');
    Route::get('/totalapindindBill-dataprocess', [DashboardController::class, 'totalpaindingBilldataProcessing'])->name('totalpaindingBill.data');
    Route::get('/dashboard/collectec/bill', [DashboardCollectedBillController::class, 'index'])->name('dashboardcollectedbill');
    Route::get('/data/collectected/bill/process', [DashboardCollectedBillController::class, 'dataProcessing'])->name('dashboardcollectedbill.dataProcessing');
    /*********************
     * GROUP
     *********************/
    Route::name('groups.')->prefix('groups')->group(function () {
        Route::get('/', [GroupController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [GroupController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [GroupController::class, 'create'])->name('create');
        Route::post('/create', [GroupController::class, 'store'])->name('store');
        Route::get('/{group:id}', [GroupController::class, 'edit'])->name('edit');
        Route::put('/{group:id}', [GroupController::class, 'update'])->name('update');
        Route::get('/{group:id}/access', [GroupController::class, 'access'])->name('access');
        Route::put('/{group:id}/access', [GroupController::class, 'accessStore']);
        Route::get('/{group:id}/view', [GroupController::class, 'view'])->name('view');
        Route::get('/{group:id}/delete', [GroupController::class, 'destroy'])->name('destroy');
    });
    /*********************
     * End GROUP
     *********************/

    //User operation start
    Route::name('users.')->prefix('users')->group(function () {
        Route::get('/list', [UserController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UserController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{user:id}', [UserController::class, 'edit'])->name('edit');
        Route::get('/show/{user:id}', [UserController::class, 'show'])->name('show');
        Route::post('/update/{user:id}', [UserController::class, 'update'])->name('update');
        Route::get('/delete/{user:id}', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/status/{user:id}/{status}', [UserController::class, 'statusUpdate'])->name('status');
    });
    //User operation end

    //customers operation start
    Route::name('customers.')->prefix('customers')->group(function () {
        Route::get('/list', [CustomerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [CustomerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::post('/store', [CustomerController::class, 'store'])->name('store');
        Route::get('/edit/{customer:id}', [CustomerController::class, 'edit'])->name('edit');
        Route::get('/show/{customer:id}', [CustomerController::class, 'show'])->name('show');
        Route::post('/update/{customer:id}', [CustomerController::class, 'update'])->name('update');
        Route::get('/delete/{customer:id}', [CustomerController::class, 'destroy'])->name('destroy');
        Route::get('/status/{customer:id}/{status}', [CustomerController::class, 'statusUpdate'])->name('status');
        Route::get('/profile-details', [CustomerController::class, 'getProfile'])->name('get_profile');
        Route::get('/m-disabled/{customer:id}', [CustomerController::class, 'mikrotikStatus'])->name('disabled');
        Route::post('/update_expire_date', [CustomerController::class, 'update_expire_date'])->name('update_expire_date');
        Route::get('/pay-list/{billcollected:id}', [CollectedBillingController::class, 'paylist'])->name('paylist');
        Route::post('/multi/delete', [CustomerController::class, 'multidelete'])->name('multi.delete');
        Route::post('/multi/messagesend', [CustomerController::class, 'messagesend'])->name('multi.messagesend');
    });
    //customers operation end

    //today line off customers operation start
    Route::name('today_line_off.')->prefix('today-line-off')->group(function () {
        Route::get('/list', [TodayCustomerOff::class, 'index'])->name('index');
        Route::get('/dataProcessing', [TodayCustomerOff::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [TodayCustomerOff::class, 'create'])->name('create');
        Route::post('/store', [TodayCustomerOff::class, 'store'])->name('store');
        Route::get('/edit/{customer:id}', [TodayCustomerOff::class, 'edit'])->name('edit');
        Route::get('/show/{customer:id}', [TodayCustomerOff::class, 'show'])->name('show');
        Route::post('/update/{customer:id}', [TodayCustomerOff::class, 'update'])->name('update');
        Route::get('/delete/{customer:id}', [TodayCustomerOff::class, 'destroy'])->name('destroy');
        Route::get('/status/{customer:id}/{status}', [TodayCustomerOff::class, 'statusUpdate'])->name('status');
        Route::get('/profile-details', [TodayCustomerOff::class, 'getProfile'])->name('get_profile');
        Route::get('/m-disabled/{customer:id}', [TodayCustomerOff::class, 'mikrotikStatus'])->name('disabled');
        Route::post('/update_expire_date', [TodayCustomerOff::class, 'update_expire_date'])->name('update_expire_date');
        Route::get('/pay-list/{billcollected:id}', [CollectedBillingController::class, 'paylist'])->name('paylist');
        Route::post('/multi/delete', [TodayCustomerOff::class, 'multidelete'])->name('multi.delete');
    });
    //today line off customers operation start
    Route::name('tomorrow_line_off.')->prefix('tomorrow-line-off')->group(function () {
        Route::get('/list', [TomorrowCustomerOff::class, 'index'])->name('index');
        Route::get('/dataProcessing', [TomorrowCustomerOff::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [TodayCustomerOff::class, 'create'])->name('create');
        Route::post('/store', [TodayCustomerOff::class, 'store'])->name('store');
        Route::get('/edit/{customer:id}', [TodayCustomerOff::class, 'edit'])->name('edit');
        Route::get('/show/{customer:id}', [TomorrowCustomerOff::class, 'show'])->name('show');
        Route::post('/update/{customer:id}', [TodayCustomerOff::class, 'update'])->name('update');
        Route::get('/delete/{customer:id}', [TodayCustomerOff::class, 'destroy'])->name('destroy');
        Route::get('/status/{customer:id}/{status}', [TodayCustomerOff::class, 'statusUpdate'])->name('status');
        Route::get('/profile-details', [TodayCustomerOff::class, 'getProfile'])->name('get_profile');
        Route::get('/m-disabled/{customer:id}', [TodayCustomerOff::class, 'mikrotikStatus'])->name('disabled');
        Route::post('/update_expire_date', [TodayCustomerOff::class, 'update_expire_date'])->name('update_expire_date');
        Route::get('/pay-list/{billcollected:id}', [CollectedBillingController::class, 'paylist'])->name('paylist');
        Route::post('/multi/delete', [TodayCustomerOff::class, 'multidelete'])->name('multi.delete');
    });
    //today line off customers operation end

    //New Connection operation start
    Route::name('newconnection.')->prefix('newconnection')->group(function () {
        Route::get('/list', [NewConnectionController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [NewConnectionController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [NewConnectionController::class, 'create'])->name('create');
        Route::post('/store', [NewConnectionController::class, 'store'])->name('store');
        Route::get('/edit/{newconnection:id}', [NewConnectionController::class, 'edit'])->name('edit');
        Route::get('/show/{newconnection:id}', [NewConnectionController::class, 'show'])->name('show');
        Route::post('/update/{newconnection:id}', [NewConnectionController::class, 'update'])->name('update');
        Route::get('/delete/{newconnection:id}', [NewConnectionController::class, 'destroy'])->name('destroy');
        Route::get('/approved/{newconnection:id}', [NewConnectionController::class, 'approve'])->name('approved');
        Route::get('/monthlybill', [NewConnectionController::class, 'monthlybill'])->name('monthlybill');
        Route::get('/status/{newconnection:id}/{status}', [NewConnectionController::class, 'statusUpdate'])->name('status');
        Route::get('/profile-details', [NewConnectionController::class, 'getProfile'])->name('get_profile');
        Route::get('/m-disabled/{customer:id}', [NewConnectionController::class, 'mikrotikStatus'])->name('disabled');
    });
    //customers operation end

    //package operation start
    Route::name('packages.')->prefix('packages')->group(function () {
        Route::get('/list', [PackageController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [PackageController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [PackageController::class, 'create'])->name('create');
        Route::post('/store', [PackageController::class, 'store'])->name('store');
        Route::get('/edit/{package:id}', [PackageController::class, 'edit'])->name('edit');
        Route::get('/show/{package:id}', [PackageController::class, 'show'])->name('show');
        Route::post('/update/{package:id}', [PackageController::class, 'update'])->name('update');
        Route::get('/delete/{package:id}', [PackageController::class, 'destroy'])->name('destroy');
        Route::get('/status/{package:id}/{status}', [PackageController::class, 'statusUpdate'])->name('status');
    });
    //package operation end

    //acounts operation start
    Route::name('accounts.')->prefix('accounts')->group(function () {
        Route::get('/list', [AccountController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [AccountController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/dataProcessingsubAccount/{account:id}', [AccountController::class, 'dataProcessingsubAccount'])->name('dataProcessingsubAccount');
        Route::get('/create', [AccountController::class, 'create'])->name('create');
        Route::post('/store', [AccountController::class, 'store'])->name('store');
        Route::get('/subaccount/{account:id}', [AccountController::class, 'subaccount'])->name('subaccount');
        Route::get('/edit/{account:id}', [AccountController::class, 'edit'])->name('edit');
        Route::get('/view', [AccountController::class, 'view'])->name('view');
        Route::post('/update/{account:id}', [AccountController::class, 'update'])->name('update');
        Route::get('/delete/{account:id}', [AccountController::class, 'destroy'])->name('destroy');
        Route::get('/status/{account:id}', [AccountController::class, 'statusUpdate'])->name('status');
        Route::get('/account1st', [AccountController::class, 'account1st'])->name('account1st');
        Route::get('/account2st', [AccountController::class, 'account2st'])->name('account2st');
        Route::get('/account3rd', [AccountController::class, 'account3rd'])->name('account3rd');
    });
    //acounts operation end

    //billtransfer operation start
    Route::name('billtransfer.')->prefix('billtransfer')->group(function () {
        Route::get('/list', [BillTransferController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BillTransferController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BillTransferController::class, 'create'])->name('create');
        Route::post('/store', [BillTransferController::class, 'store'])->name('store');
        Route::get('/show/{transaction:id}', [BillTransferController::class, 'show'])->name('show');
        Route::get('/edit/{transaction:id}', [BillTransferController::class, 'edit'])->name('edit');
        Route::post('/update/{transaction:id}', [BillTransferController::class, 'update'])->name('update');
        Route::get('/delete/{transaction:id}', [BillTransferController::class, 'destroy'])->name('destroy');
        Route::get('/status/{transaction:id}/{status}', [BillTransferController::class, 'statusUpdate'])->name('status');
    });
    //billtransfer operation end

    //cash book operation start
    // Route::name('cashbook.')->prefix('cashbook')->group(function () {
    //     Route::get('/list', [CashBookController::class, 'index'])->name('index');
    //     Route::get('/dataProcessing', [CashBookController::class, 'dataProcessing'])->name('dataProcessing');
    //     Route::get('/create', [CashBookController::class, 'create'])->name('create');
    //     Route::post('/store', [CashBookController::class, 'store'])->name('store');
    //     Route::get('/show/{account:id}', [CashBookController::class, 'show'])->name('show');
    //     Route::get('/edit/{account:id}', [CashBookController::class, 'edit'])->name('edit');
    //     Route::post('/update/{account:id}', [CashBookController::class, 'update'])->name('update');
    //     Route::get('/delete/{account:id}', [CashBookController::class, 'destroy'])->name('destroy');
    //     Route::get('/status/{account:id}/{status}', [CashBookController::class, 'statusUpdate'])->name('status');
    // });

    //cash book operation end
    //cash book operation start
    Route::name('supplier_ledger.')->prefix('supplier_ledger')->group(function () {
        Route::get('/list', [SupplierLedgerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SupplierLedgerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/pay/{supplierledger:id}', [SupplierLedgerController::class, 'pay'])->name('pay');
        Route::post('/update/{supplier:id}', [SupplierLedgerController::class, 'update'])->name('update');
    });
    //cash book operation end

    //acounts operation start
    Route::name('expense_category.')->prefix('expense_category')->group(function () {
        Route::get('/list', [ExpenseCategoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ExpenseCategoryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ExpenseCategoryController::class, 'create'])->name('create');
        Route::post('/store', [ExpenseCategoryController::class, 'store'])->name('store');
        Route::get('/show/{expense:id}', [ExpenseCategoryController::class, 'show'])->name('show');
        Route::get('/edit/{expense:id}', [ExpenseCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{expense:id}', [ExpenseCategoryController::class, 'update'])->name('update');
        Route::get('/delete/{expensecategory:id}', [ExpenseCategoryController::class, 'destroy'])->name('destroy');
        Route::get('/status/{expense:id}/{status}', [ExpenseCategoryController::class, 'statusUpdate'])->name('status');
    });
    //acounts operation end

    //acounts operation start
    Route::name('expenses.')->prefix('expenses')->group(function () {
        Route::get('/list', [ExpenseController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ExpenseController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ExpenseController::class, 'create'])->name('create');
        Route::post('/store', [ExpenseController::class, 'store'])->name('store');
        Route::get('/show/{expense:id}', [ExpenseController::class, 'show'])->name('show');
        Route::get('/edit/{expense:id}', [ExpenseController::class, 'edit'])->name('edit');
        Route::post('/update/{expense:id}', [ExpenseController::class, 'update'])->name('update');
        Route::get('/delete/{expense:id}', [ExpenseController::class, 'destroy'])->name('destroy');
        Route::get('/status/{expense:id}/{status}', [ExpenseController::class, 'statusUpdate'])->name('status');
    });
    //acounts operation end
    //acounts operation start
    Route::name('expensereports.')->prefix('expensereports')->group(function () {
        Route::get('/list', [ExpenseReportController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ExpenseReportController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ExpenseReportController::class, 'create'])->name('create');
        Route::post('/store', [ExpenseReportController::class, 'store'])->name('store');
        Route::get('/show/{expense:id}', [ExpenseReportController::class, 'show'])->name('show');
        Route::get('/edit/{expense:id}', [ExpenseReportController::class, 'edit'])->name('edit');
        Route::post('/update/{expense:id}', [ExpenseReportController::class, 'update'])->name('update');
        Route::get('/delete/{expense:id}', [ExpenseReportController::class, 'destroy'])->name('destroy');
        Route::get('/status/{expense:id}/{status}', [ExpenseReportController::class, 'statusUpdate'])->name('status');
    });
    //acounts operation end

    //income operation start
    Route::name('incomeCategory.')->prefix('incomeCategory')->group(function () {
        Route::get('/list', [IncomeCategoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [IncomeCategoryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [IncomeCategoryController::class, 'create'])->name('create');
        Route::post('/store', [IncomeCategoryController::class, 'store'])->name('store');
        Route::get('/show/{Incomecategory:id}', [IncomeCategoryController::class, 'show'])->name('show');
        Route::get('/edit/{Incomecategory:id}', [IncomeCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{Incomecategory:id}', [IncomeCategoryController::class, 'update'])->name('update');
        Route::get('/delete/{Incomecategory:id}', [IncomeCategoryController::class, 'destroy'])->name('destroy');
        Route::get('/status/{Incomecategory:id}/{status}', [IncomeCategoryController::class, 'statusUpdate'])->name('status');
    });
    Route::name('dailyIncome.')->prefix('dailyIncome')->group(function () {
        Route::get('/list', [DailyIncomeController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DailyIncomeController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DailyIncomeController::class, 'create'])->name('create');
        Route::post('/store', [DailyIncomeController::class, 'store'])->name('store');
        Route::get('/show/{expense:id}', [DailyIncomeController::class, 'show'])->name('show');
        Route::get('/edit/{dailyincome:id}', [DailyIncomeController::class, 'edit'])->name('edit');
        Route::post('/update/{dailyincome:id}', [DailyIncomeController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [DailyIncomeController::class, 'destroy'])->name('destroy');
        Route::post('/search/data', [DailyIncomeController::class, 'search'])->name('search');

        Route::get('/status/{expense:id}/{status}', [DailyIncomeController::class, 'statusUpdate'])->name('status');
    });
    Route::name('incomeHistory.')->prefix('incomeHistory')->group(function () {
        Route::get('/list', [IncomeHistoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [IncomeHistoryController::class, 'dataProcessing'])->name('dataProcessing');
    });
    Route::name('installationFee.')->prefix('installationFee')->group(function () {
        Route::get('/list', [InstallationFeeController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [InstallationFeeController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [InstallationFeeController::class, 'create'])->name('create');
        Route::post('/store', [InstallationFeeController::class, 'store'])->name('store');
        Route::get('/show/{installationFee:id}', [InstallationFeeController::class, 'show'])->name('show');
        Route::get('/edit/{installationFee:id}', [InstallationFeeController::class, 'edit'])->name('edit');
        Route::get('/pay/{installationFee:id}', [InstallationFeeController::class, 'pay'])->name('pay');
        Route::post('/update/{installationFee:id}', [InstallationFeeController::class, 'update'])->name('update');
        Route::get('/delete/{installationFee:id}', [InstallationFeeController::class, 'destroy'])->name('destroy');
        Route::get('/status/{installationFee:id}/{status}', [InstallationFeeController::class, 'statusUpdate'])->name('status');
    });
    //income operation end

    //Discount operation start
    Route::name('discounts.')->prefix('discounts')->group(function () {
        Route::get('/list', [DiscountController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DiscountController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DiscountController::class, 'create'])->name('create');
        Route::post('/store', [DiscountController::class, 'store'])->name('store');
        Route::get('/show/{discount:id}', [DiscountController::class, 'show'])->name('show');
        Route::get('/edit/{discount:id}', [DiscountController::class, 'edit'])->name('edit');
        Route::post('/update/{discount:id}', [DiscountController::class, 'update'])->name('update');
        Route::get('/delete/{discount:id}', [DiscountController::class, 'destroy'])->name('destroy');
        Route::get('/status/{discount:id}/{status}', [DiscountController::class, 'statusUpdate'])->name('status');
    });

    Route::get('/email', function () {
        return view('email');
    });


    //Employe status start
    Route::name('employees.')->prefix('employees')->group(function () {
        Route::get('/list', [EmployeeController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [EmployeeController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/store', [EmployeeController::class, 'store'])->name('store');
        Route::get('/show/{employee:id}', [EmployeeController::class, 'show'])->name('show');
        Route::get('/edit/{employee:id}', [EmployeeController::class, 'edit'])->name('edit');
        Route::post('/update/{employee:id}', [EmployeeController::class, 'update'])->name('update');
        Route::get('/delete/{employee:id}', [EmployeeController::class, 'destroy'])->name('destroy');
    });
    //Employe status end

    //Leave Application start
    Route::name('leaveApplication.')->prefix('leaveApplication')->group(function () {
        Route::get('/list', [LeaveApplicationController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [LeaveApplicationController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [LeaveApplicationController::class, 'create'])->name('create');
        Route::post('/store', [LeaveApplicationController::class, 'store'])->name('store');
        Route::get('/show/{leave:id}', [LeaveApplicationController::class, 'show'])->name('show');
        Route::get('/edit/{leave:id}', [LeaveApplicationController::class, 'edit'])->name('edit');
        Route::post('/update/{leave:id}', [LeaveApplicationController::class, 'update'])->name('update');
        Route::get('/delete/{leave:id}', [LeaveApplicationController::class, 'destroy'])->name('destroy');
    });
    //Leave Application end


    //Leave Application Approve start
    Route::name('leaveApplicationApprove.')->prefix('leaveApplicationApprove')->group(function () {
        Route::get('/list', [LeaveApplicationApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [LeaveApplicationApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [LeaveApplicationApproveController::class, 'create'])->name('create');
        Route::post('/store', [LeaveApplicationApproveController::class, 'store'])->name('store');
        Route::get('/show/{leave:id}', [LeaveApplicationApproveController::class, 'show'])->name('show');
        Route::get('/edit/{leave:id}', [LeaveApplicationApproveController::class, 'edit'])->name('edit');
        Route::post('/update/{leave:id}', [LeaveApplicationApproveController::class, 'update'])->name('update');
        Route::get('/delete/{leave:id}', [LeaveApplicationApproveController::class, 'destroy'])->name('destroy');
        Route::get('/cancel/{leave:id}', [LeaveApplicationApproveController::class, 'cancel'])->name('cancel');
    });
    //Leave Application Approve end

    //Lone Application start
    Route::name('loneApplication.')->prefix('loneApplication')->group(function () {
        Route::get('/list', [LoneApplicationController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [LoneApplicationController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [LoneApplicationController::class, 'create'])->name('create');
        Route::post('/store', [LoneApplicationController::class, 'store'])->name('store');
        Route::get('/show/{lone:id}', [LoneApplicationController::class, 'show'])->name('show');
        Route::get('/edit/{lone:id}', [LoneApplicationController::class, 'edit'])->name('edit');
        Route::post('/update/{lone:id}', [LoneApplicationController::class, 'update'])->name('update');
        Route::get('/delete/{lone:id}', [LoneApplicationController::class, 'destroy'])->name('destroy');
    });
    //Lone Application end


    //Lone Application Approve start
    Route::name('loneApplicationApprove.')->prefix('loneApplicationApprove')->group(function () {
        Route::get('/list', [LoneApplicationApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [LoneApplicationApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [LoneApplicationApproveController::class, 'create'])->name('create');
        Route::post('/store', [LoneApplicationApproveController::class, 'store'])->name('store');
        Route::get('/show/{Lone:id}', [LoneApplicationApproveController::class, 'show'])->name('show');
        Route::get('/edit/{lone:id}', [LoneApplicationApproveController::class, 'edit'])->name('edit');
        Route::post('/update/{lone:id}', [LoneApplicationApproveController::class, 'update'])->name('update');
        Route::get('/delete/{lone:id}', [LoneApplicationApproveController::class, 'destroy'])->name('destroy');
        Route::get('/cancel/{lone:id}', [LoneApplicationApproveController::class, 'cancel'])->name('cancel');
    });
    //Lone Application Approve end

    //Ticketing start
    Route::name('supporthistory.')->prefix('supporthistory')->group(function () {
        Route::get('/list', [SupportHistoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SupportHistoryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SupportHistoryController::class, 'create'])->name('create');
        Route::post('/store', [SupportHistoryController::class, 'store'])->name('store');
        Route::get('/show/{supporthistory:id}', [SupportHistoryController::class, 'show'])->name('show');
        Route::get('/edit/{supporthistory:id}', [SupportHistoryController::class, 'edit'])->name('edit');
        Route::post('/update/{supporthistory:id}', [SupportHistoryController::class, 'update'])->name('update');
        Route::get('/delete/{supporthistory:id}', [SupportHistoryController::class, 'destroy'])->name('destroy');
    });
    //Ticketing end

    //Employe Expense status start
    Route::name('em_expense.')->prefix('em_expense')->group(function () {
        Route::get('/list', [EmployeeExpenseController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [EmployeeExpenseController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [EmployeeExpenseController::class, 'create'])->name('create');
        Route::post('/store', [EmployeeExpenseController::class, 'store'])->name('store');
        Route::get('/show/{Expense:id}', [EmployeeExpenseController::class, 'show'])->name('show');
        Route::get('/edit/{Expense:id}', [EmployeeExpenseController::class, 'edit'])->name('edit');
        Route::post('/update/{Expense:id}', [EmployeeExpenseController::class, 'update'])->name('update');
        Route::get('/delete/{Expense:id}', [EmployeeExpenseController::class, 'destroy'])->name('destroy');
        Route::get('/status/{Expense:id}/{status}', [EmployeeExpenseController::class, 'statusUpdate'])->name('status');
    });
    //Employe Expense status end

    //Employe salarys status start
    Route::name('salarys.')->prefix('salarys')->group(function () {
        Route::get('/list', [SalaryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SalaryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SalaryController::class, 'create'])->name('create');
        Route::post('/store', [SalaryController::class, 'store'])->name('store');
        Route::get('/show/{Salary:id}', [SalaryController::class, 'show'])->name('show');
        Route::get('/edit/{Salary:id}', [SalaryController::class, 'edit'])->name('edit');
        Route::get('/view/ajax', [SalaryController::class, 'viewAjax'])->name('ajax');
        Route::post('/update/{Salary:id}', [SalaryController::class, 'update'])->name('update');
        Route::get('/delete/{Salary:id}', [SalaryController::class, 'destroy'])->name('destroy');
        Route::get('/status/{Salary:id}/{status}', [SalaryController::class, 'statusUpdate'])->name('status');
    });
    //Employe salarys status end

    //sms status start
    Route::name('sms.')->prefix('sms')->group(function () {
        Route::get('/list', [SmsController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SmsController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SmsController::class, 'create'])->name('create');
        Route::post('/store', [SmsController::class, 'store'])->name('store');
        Route::get('/show/{sms:id}', [SmsController::class, 'show'])->name('show');
        Route::get('/edit/{sms:id}', [SmsController::class, 'edit'])->name('edit');
        Route::post('/update/{sms:id}', [SmsController::class, 'update'])->name('update');
        Route::get('/delete/{sms:id}', [SmsController::class, 'destroy'])->name('destroy');
        Route::get('/status/{sms:id}/send-message', [SmsController::class, 'sendMessage'])->name('send.message');
    });
    //sms status end
    //PPP Profile status start
    Route::name('m_p_p_p_profiles.')->prefix('ppp-profiles')->group(function () {
        Route::get('/list', [MPPPProfileController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MPPPProfileController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [MPPPProfileController::class, 'create'])->name('create');
        Route::post('/store', [MPPPProfileController::class, 'store'])->name('store');
        Route::get('/show/{m_p_p_p_profile:id}', [MPPPProfileController::class, 'show'])->name('show');
        Route::get('/edit/{m_p_p_p_profile:id}', [MPPPProfileController::class, 'edit'])->name('edit');
        Route::post('/update/{m_p_p_p_profile:id}', [MPPPProfileController::class, 'update'])->name('update');
        Route::get('/delete/{m_p_p_p_profile:id}', [MPPPProfileController::class, 'destroy'])->name('destroy');
        Route::get('/status/{m_p_p_p_profile:id}/send-message', [MPPPProfileController::class, 'sendMessage'])->name('send.message');
    });
    //Profile status status end

    //PPP Active Connection status start
    Route::name('activeconnections.')->prefix('active-connections')->group(function () {
        Route::get('/list', [ActiveConnectionController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ActiveConnectionController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/show/{m_p_p_p_profile:id}', [ActiveConnectionController::class, 'show'])->name('show');
    });
    //Active Connection status end

    //PPP Interface status start
    Route::name('minterface.')->prefix('interface')->group(function () {
        Route::get('/list', [MInterfaceController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MInterfaceController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/show/{m_p_p_p_profile:id}', [MInterfaceController::class, 'show'])->name('show');
    });
    //Interface status end

    //Pool status start
    Route::name('mpool.')->prefix('mpool')->group(function () {
        Route::get('/list', [MPoolController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MPoolController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [MPoolController::class, 'create'])->name('create');
        Route::post('/store', [MPoolController::class, 'store'])->name('store');
        Route::get('/show/{mpool:id}', [MPoolController::class, 'show'])->name('show');
        Route::get('/edit/{mpool:id}', [MPoolController::class, 'edit'])->name('edit');
        Route::post('/update/{mpool:id}', [MPoolController::class, 'update'])->name('update');
        Route::get('/delete/{mpool:id}', [MPoolController::class, 'destroy'])->name('destroy');
        Route::get('/status/{mpool:id}/send-message', [MPoolController::class, 'sendMessage'])->name('send.message');
    });
    //Pool Interface status end

    //Billcollect start
    Route::name('billcollect.')->prefix('billcollect')->group(function () {
        Route::get('/list', [BillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BillingController::class, 'create'])->name('create');
        Route::post('/store', [BillingController::class, 'store'])->name('store');
        Route::post('/update/{billing:id}', [BillingController::class, 'update'])->name('update');
        Route::get('/pay-bill-details/{billing:id}', [BillingController::class, 'payment'])->name('payment');
        Route::get('/pay-bill/{billing:id}', [BillingController::class, 'pay'])->name('pay');
        Route::get('/due-pay-bill/{billing:id}', [BillingController::class, 'duepay'])->name('duepay');
        Route::get('/due-pay-partial/{billing:id}', [BillingController::class, 'partial'])->name('partial');
        Route::get('/invoice/{billing:id}', [BillingController::class, 'invoice'])->name('invoice');
        Route::get('/invoice-print', [BillingController::class, 'invoiceprint'])->name('invoice.print');
        Route::get('/pay-list/{billing:id}', [BillingController::class, 'paylist'])->name('paylist');
        Route::get('/getAmount', [BillingController::class, 'paylist'])->name('paylist');
        Route::get('/delete/{billing:id}', [BillingController::class, 'delete'])->name('delete');
    });
    //Billcollect end

    //Advance Billing start
    Route::name('advancebilling.')->prefix('advancebilling')->group(function () {
        Route::get('/list', [AdvanceBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [AdvanceBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [AdvanceBillingController::class, 'create'])->name('create');
        Route::post('/store', [AdvanceBillingController::class, 'store'])->name('store');
        // Route::get('/show/{billing:id}', [AdvanceBillingController::class, 'show'])->name('show');
        Route::get('/edit/{advancebilling:id}', [AdvanceBillingController::class, 'edit'])->name('edit');
        Route::post('/update/{advancebilling:id}', [AdvanceBillingController::class, 'update'])->name('update');
        Route::get('/delete/{advancebilling:id}', [AdvanceBillingController::class, 'destroy'])->name('destroy');
        // Route::get('/pay-bill-details/{billing:id}', [AdvanceBillingController::class, 'payment'])->name('payment');
        // Route::get('/pay-bill/{billing:id}', [AdvanceBillingController::class, 'pay'])->name('pay');
        // Route::get('/invoice/{billing:id}', [AdvanceBillingController::class, 'invoice'])->name('invoice');
        // Route::get('/invoice-print', [AdvanceBillingController::class, 'invoiceprint'])->name('invoice.print');
        // Route::get('/pay-list/{billing:id}', [AdvanceBillingController::class, 'paylist'])->name('paylist');
    });
    //Advance Billing end



    //Package Update and Down Rate start
    Route::name('package_update_and_down_rate.')->prefix('package_update_and_down_rate')->group(function () {
        Route::get('/list', [PackageUpdateDownRateController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [PackageUpdateDownRateController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [PackageUpdateDownRateController::class, 'create'])->name('create');
        Route::post('/store', [PackageUpdateDownRateController::class, 'store'])->name('store');
        // Route::get('/show/{billing:id}', [PackageUpdateDownRateController::class, 'show'])->name('show');
        Route::get('/edit/{Packageupdatedownrate:id}', [PackageUpdateDownRateController::class, 'edit'])->name('edit');
        Route::post('/update/{Packageupdatedownrate:id}', [PackageUpdateDownRateController::class, 'update'])->name('update');
        Route::get('/delete/{Packageupdatedownrate:id}', [PackageUpdateDownRateController::class, 'destroy'])->name('destroy');
    });
    //Package Update and Down Rate end

    //Billcollected status start
    Route::name('billcollected.')->prefix('billcollected')->group(function () {
        Route::get('/list', [CollectedBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [CollectedBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/pay-bill-details/{billing:id}', [BillingController::class, 'payment'])->name('payment');
        Route::get('/pay-bill-destroy/{billing:id}', [CollectedBillingController::class, 'destroy'])->name('destroy');
    });
    //Billcollected Interface status end

    //todaybillcollected status start
    Route::name('todaybillcollected.')->prefix('todaybillcollected')->group(function () {
        Route::get('/list', [CollectedBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [CollectedBillingController::class, 'dataProcessing'])->name('dataProcessing');
    });
    //todaybillcollected Interface status end

    //nopaidcustomer status start
    Route::name('nopaidcustomer.')->prefix('nopaidcustomer')->group(function () {
        Route::get('/list', [NoPaidCustomerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [NoPaidCustomerController::class, 'dataProcessing'])->name('dataProcessing');
    });
    //nopaidcustomer Interface status end

    //Data Source start
    Route::name('data_source.')->prefix('data_source')->group(function () {
        Route::get('/list', [DataSourceController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DataSourceController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DataSourceController::class, 'create'])->name('create');
        Route::post('/store', [DataSourceController::class, 'store'])->name('store');
        Route::get('/show/{division:id}', [DataSourceController::class, 'show'])->name('show');
        Route::get('/edit/{division:id}', [DataSourceController::class, 'edit'])->name('edit');
        Route::post('/update/{division:id}', [DataSourceController::class, 'update'])->name('update');
        Route::get('/delete/{division:id}', [DataSourceController::class, 'destroy'])->name('destroy');
    });
    //Division end

    //Division start
    Route::name('division.')->prefix('division')->group(function () {
        Route::get('/list', [DivisionController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DivisionController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DivisionController::class, 'create'])->name('create');
        Route::post('/store', [DivisionController::class, 'store'])->name('store');
        Route::get('/show/{division:id}', [DivisionController::class, 'show'])->name('show');
        Route::get('/edit/{division:id}', [DivisionController::class, 'edit'])->name('edit');
        Route::post('/update/{division:id}', [DivisionController::class, 'update'])->name('update');
        Route::get('/delete/{division:id}', [DivisionController::class, 'destroy'])->name('destroy');
    });
    //Division end

    //District start
    Route::name('district.')->prefix('district')->group(function () {
        Route::get('/list', [DistrictController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DistrictController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DistrictController::class, 'create'])->name('create');
        Route::post('/store', [DistrictController::class, 'store'])->name('store');
        Route::get('/show/{district:id}', [DistrictController::class, 'show'])->name('show');
        Route::get('/edit/{district:id}', [DistrictController::class, 'edit'])->name('edit');
        Route::post('/update/{district:id}', [DistrictController::class, 'update'])->name('update');
        Route::get('/delete/{district:id}', [DistrictController::class, 'destroy'])->name('destroy');
    });
    //District end

    //Upozilla start
    Route::name('upozilla.')->prefix('upozilla')->group(function () {
        Route::get('/list', [UpozillaController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UpozillaController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [UpozillaController::class, 'create'])->name('create');
        Route::post('/store', [UpozillaController::class, 'store'])->name('store');
        Route::get('/show/{upozilla:id}', [UpozillaController::class, 'show'])->name('show');
        Route::get('/edit/{upozilla:id}', [UpozillaController::class, 'edit'])->name('edit');
        Route::post('/update/{upozilla:id}', [UpozillaController::class, 'update'])->name('update');
        Route::get('/delete/{upozilla:id}', [UpozillaController::class, 'destroy'])->name('destroy');
    });
    //Upozilla end

    //Zone start
    Route::name('zones.')->prefix('zones')->group(function () {
        Route::get('/list', [ZoneController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ZoneController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ZoneController::class, 'create'])->name('create');
        Route::post('/store', [ZoneController::class, 'store'])->name('store');
        Route::get('/show/{zone:id}', [ZoneController::class, 'show'])->name('show');
        Route::get('/edit/{zone:id}', [ZoneController::class, 'edit'])->name('edit');
        Route::post('/update/{zone:id}', [ZoneController::class, 'update'])->name('update');
        Route::get('/delete/{zone:id}', [ZoneController::class, 'destroy'])->name('destroy');
        Route::get('/upozilla/ajax', [ZoneController::class, 'getSubCat'])->name('getUpozilla');
    });
    //Zone end

    //subzone start
    Route::name('subzones.')->prefix('subzones')->group(function () {
        Route::get('/list', [SubzoneController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SubzoneController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SubzoneController::class, 'create'])->name('create');
        Route::post('/store', [SubzoneController::class, 'store'])->name('store');
        Route::get('/show/{subzone:id}', [SubzoneController::class, 'show'])->name('show');
        Route::get('/edit/{subzone:id}', [SubzoneController::class, 'edit'])->name('edit');
        Route::post('/update/{subzone:id}', [SubzoneController::class, 'update'])->name('update');
        Route::get('/delete/{subzone:id}', [SubzoneController::class, 'destroy'])->name('destroy');
        Route::get('/zone/ajax', [SubzoneController::class, 'getSubSubCat'])->name('getZone');
    });
    //subzone end

    //Tjs start
    Route::name('tjs.')->prefix('tjs')->group(function () {
        Route::get('/list', [TjController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [TjController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [TjController::class, 'create'])->name('create');
        Route::post('/store', [TjController::class, 'store'])->name('store');
        Route::get('/show/{tj:id}', [TjController::class, 'show'])->name('show');
        Route::get('/edit/{tj:id}', [TjController::class, 'edit'])->name('edit');
        Route::post('/update/{tj:id}', [TjController::class, 'update'])->name('update');
        Route::get('/delete/{tj:id}', [TjController::class, 'destroy'])->name('destroy');
    });
    //Tjs end

    //spliters start
    Route::name('splitters.')->prefix('splitters')->group(function () {
        Route::get('/list', [SplitterController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SplitterController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SplitterController::class, 'create'])->name('create');
        Route::post('/store', [SplitterController::class, 'store'])->name('store');
        Route::get('/show/{splitter:id}', [SplitterController::class, 'show'])->name('show');
        Route::get('/edit/{splitter:id}', [SplitterController::class, 'edit'])->name('edit');
        Route::post('/update/{splitter:id}', [SplitterController::class, 'update'])->name('update');
        Route::get('/delete/{splitter:id}', [SplitterController::class, 'destroy'])->name('destroy');
    });
    //spliters end

    //box start
    Route::name('boxes.')->prefix('boxes')->group(function () {
        Route::get('/list', [BoxController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BoxController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BoxController::class, 'create'])->name('create');
        Route::post('/store', [BoxController::class, 'store'])->name('store');
        Route::get('/show/{box:id}', [BoxController::class, 'show'])->name('show');
        Route::get('/edit/{box:id}', [BoxController::class, 'edit'])->name('edit');
        Route::post('/update/{box:id}', [BoxController::class, 'update'])->name('update');
        Route::get('/delete/{box:id}', [BoxController::class, 'destroy'])->name('destroy');
    });
    //box end

    //POP start
    Route::name('pops.')->prefix('pops')->group(function () {
        Route::get('/list', [PopController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [PopController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [PopController::class, 'create'])->name('create');
        Route::post('/store', [PopController::class, 'store'])->name('store');
        Route::get('/show/{pop:id}', [PopController::class, 'show'])->name('show');
        Route::get('/edit/{pop:id}', [PopController::class, 'edit'])->name('edit');
        Route::post('/update/{pop:id}', [PopController::class, 'update'])->name('update');
        Route::get('/delete/{pop:id}', [PopController::class, 'destroy'])->name('destroy');
    });
    //pop end

    //Router start
    Route::name('routers.')->prefix('routers')->group(function () {
        Route::get('/list', [RouterController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [RouterController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [RouterController::class, 'create'])->name('create');
        Route::post('/store', [RouterController::class, 'store'])->name('store');
        Route::get('/show/{router:id}', [RouterController::class, 'show'])->name('show');
        Route::get('/edit/{router:id}', [RouterController::class, 'edit'])->name('edit');
        Route::post('/update/{router:id}', [RouterController::class, 'update'])->name('update');
        Route::get('/delete/{router:id}', [RouterController::class, 'destroy'])->name('destroy');
    });
    //router end

    //Product category start
    Route::name('productCategory.')->prefix('product-category')->group(function () {
        Route::get('/list', [ProductCategoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ProductCategoryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ProductCategoryController::class, 'create'])->name('create');
        Route::post('/store', [ProductCategoryController::class, 'store'])->name('store');
        Route::get('/show/{productcategory:id}', [ProductCategoryController::class, 'show'])->name('show');
        Route::get('/edit/{productcategory:id}', [ProductCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{productcategory:id}', [ProductCategoryController::class, 'update'])->name('update');
        Route::get('/delete/{productcategory:id}', [ProductCategoryController::class, 'destroy'])->name('destroy');
    });
    //Product category end

    //Unit start
    Route::name('units.')->prefix('units')->group(function () {
        Route::get('/list', [UnitController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UnitController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [UnitController::class, 'create'])->name('create');
        Route::post('/store', [UnitController::class, 'store'])->name('store');
        Route::get('/show/{unit:id}', [UnitController::class, 'show'])->name('show');
        Route::get('/edit/{unit:id}', [UnitController::class, 'edit'])->name('edit');
        Route::post('/update/{unit:id}', [UnitController::class, 'update'])->name('update');
        Route::get('/delete/{unit:id}', [UnitController::class, 'destroy'])->name('destroy');
    });
    //Unit end

    //products start
    Route::name('products.')->prefix('products')->group(function () {
        Route::get('/list', [ProductController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ProductController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/show/{products:id}', [ProductController::class, 'show'])->name('show');
        Route::get('/edit/{products:id}', [ProductController::class, 'edit'])->name('edit');
        Route::post('/update/{products:id}', [ProductController::class, 'update'])->name('update');
        Route::get('/delete/{products:id}', [ProductController::class, 'destroy'])->name('destroy');
    });
    //products end

    //Supplier start
    Route::name('suppliers.')->prefix('suppliers')->group(function () {
        Route::get('/list', [SupplierController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SupplierController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::post('/store', [SupplierController::class, 'store'])->name('store');
        Route::get('/show/{supplier:id}', [SupplierController::class, 'show'])->name('show');
        Route::get('/edit/{supplier:id}', [SupplierController::class, 'edit'])->name('edit');
        Route::post('/update/{supplier:id}', [SupplierController::class, 'update'])->name('update');
        Route::get('/delete/{supplier:id}', [SupplierController::class, 'destroy'])->name('destroy');
    });
    //Supplier end

    //Asset management start
    Route::name('assets.')->prefix('assets')->group(function () {
        Route::get('/list', [AssetCategoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [AssetCategoryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [AssetCategoryController::class, 'create'])->name('create');
        Route::post('/store', [AssetCategoryController::class, 'store'])->name('store');
        Route::get('/show/{assetscategory:id}', [AssetCategoryController::class, 'show'])->name('show');
        Route::get('/edit/{assetscategory:id}', [AssetCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{assetscategory:id}', [AssetCategoryController::class, 'update'])->name('update');
        Route::get('/delete/{assetscategory:id}', [AssetCategoryController::class, 'destroy'])->name('destroy');
        Route::get('/status/{assetscategory:id}', [AssetCategoryController::class, 'status'])->name('status');
    });
    Route::name('reasons.')->prefix('reasons')->group(function () {
        Route::get('/list', [ReasonController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ReasonController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ReasonController::class, 'create'])->name('create');
        Route::post('/store', [ReasonController::class, 'store'])->name('store');
        Route::get('/show/{assetcategory:id}', [ReasonController::class, 'show'])->name('show');
        Route::get('/edit/{assetcategory:id}', [ReasonController::class, 'edit'])->name('edit');
        Route::post('/update/{assetcategory:id}', [ReasonController::class, 'update'])->name('update');
        Route::get('/delete/{assetcategory:id}', [ReasonController::class, 'destroy'])->name('destroy');
    });
    Route::name('assetlist.')->prefix('assetlist')->group(function () {
        Route::get('/list', [AssetContoller::class, 'index'])->name('index');
        Route::get('/dataProcessing', [AssetContoller::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [AssetContoller::class, 'create'])->name('create');
        Route::post('/store', [AssetContoller::class, 'store'])->name('store');
        Route::get('/show/{assetlist:id}', [AssetContoller::class, 'show'])->name('show');
        Route::get('/edit/{assetlist:id}', [AssetContoller::class, 'edit'])->name('edit');
        Route::post('/update/{assetlist:id}', [AssetContoller::class, 'update'])->name('update');
        Route::get('/delete/{assetlist:id}', [AssetContoller::class, 'destroy'])->name('destroy');
        Route::get('/status/{assetlist:id}', [AssetContoller::class, 'status'])->name('status');
    });
    Route::name('destroyitems.')->prefix('destroyitems')->group(function () {
        Route::get('/list', [DestroyItemController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DestroyItemController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DestroyItemController::class, 'create'])->name('create');
        Route::post('/store', [DestroyItemController::class, 'store'])->name('store');
        Route::get('/show/{destroyitems:id}', [DestroyItemController::class, 'show'])->name('show');
        Route::get('/edit/{destroyitems:id}', [DestroyItemController::class, 'edit'])->name('edit');
        Route::post('/update/{destroyitems:id}', [DestroyItemController::class, 'update'])->name('update');
        Route::get('/delete/{destroyitems:id}', [DestroyItemController::class, 'destroy'])->name('destroy');
    });
    //Asset management end

    //Brand start
    Route::name('brands.')->prefix('brands')->group(function () {
        Route::get('/list', [BrandController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BrandController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        Route::get('/show/{brans:id}', [BrandController::class, 'show'])->name('show');
        Route::get('/edit/{brans:id}', [BrandController::class, 'edit'])->name('edit');
        Route::post('/update/{brans:id}', [BrandController::class, 'update'])->name('update');
        Route::get('/delete/{brans:id}', [BrandController::class, 'destroy'])->name('destroy');
    });
    //Brand end

    //Brand start
    Route::name('reverts.')->prefix('reverts')->group(function () {
        Route::get('/list', [RevertController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [RevertController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [RevertController::class, 'create'])->name('create');
        Route::post('/store', [RevertController::class, 'store'])->name('store');
        Route::get('/show/{customer:id}', [RevertController::class, 'show'])->name('show');
        Route::get('/reject/{revert:id}', [RevertController::class, 'reject'])->name('reject');
        Route::get('/confirm/{revert:id}', [RevertController::class, 'confirm'])->name('confirm');
    });

    //Brand end

    //reject customer start
    Route::name('rejectbandwidthCustomers.')->prefix('reject-bandwidth-customers')->group(function () {
        Route::get('/list', [RejectBandwidthCustomerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [RejectBandwidthCustomerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/show/{bandwidthCustomer:id}', [RejectBandwidthCustomerController::class, 'show'])->name('show');
    });
    //reject customer start

    //Brand start
    Route::name('companies.')->prefix('companies')->group(function () {
        Route::get('/list', [CompanyController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [CompanyController::class, 'dataProcessing'])->name('dataProcessing');
        // Route::get('/create', [CompanyController::class, 'create'])->name('create');
        // Route::post('/store', [CompanyController::class, 'store'])->name('store');
        Route::get('/show/{company:id}', [CompanyController::class, 'show'])->name('show');
        Route::get('/edit/{company:id}', [CompanyController::class, 'edit'])->name('edit');
        Route::post('/update/{company:id}', [CompanyController::class, 'update'])->name('update');
        Route::get('/delete/{company:id}', [CompanyController::class, 'destroy'])->name('destroy');
    });
    //Brand end

    Route::name('businesses.')->prefix('businesses')->group(function () {
        Route::get('/list', [BusinessController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BusinessController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BusinessController::class, 'create'])->name('create');
        Route::post('/store', [BusinessController::class, 'store'])->name('store');
        Route::get('/show/{businesses:id}', [BusinessController::class, 'show'])->name('show');
        Route::get('/edit/{business}', [BusinessController::class, 'edit'])->name('edit');

        Route::post('/update/{businesses:id}', [BusinessController::class, 'update'])->name('update');
        Route::get('/delete/{businesses:id}', [BusinessController::class, 'destroy'])->name('destroy');
        Route::get('/get-business-info/{businessId}', [BusinessController::class, 'getBusinessInfo'])->name('getBusinessInfo');
    });

    //Purchase start
    Route::name('purchases.')->prefix('purchases')->group(function () {
        Route::get('/list', [PurchaseController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [PurchaseController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [PurchaseController::class, 'create'])->name('create');
        Route::post('/store', [PurchaseController::class, 'store'])->name('store');
        Route::get('/show/{purchase:id}', [PurchaseController::class, 'show'])->name('show');
        Route::get('/edit/{purchase:id}', [PurchaseController::class, 'edit'])->name('edit');
        Route::post('/update/{purchase:id}', [PurchaseController::class, 'update'])->name('update');
        Route::get('/delete/{purchase:id}', [PurchaseController::class, 'destroy'])->name('destroy');
        Route::get('/get-product', [PurchaseController::class, 'getProductList'])->name('get.product');
        Route::get('/get-unitPice', [PurchaseController::class, 'unitPrice'])->name('unitPice');
        Route::get('/get-account', [PurchaseController::class, 'getAccounts'])->name('accounts');
        Route::get('/get-balance', [AccountController::class, 'getBalance'])->name('getBalance');
        Route::get('/all-stock', [PurchaseController::class, 'allstock'])->name('stock.list');

        Route::get('/invoice/{purchase:id}', [PurchaseController::class, 'invoice'])->name('invoice');
    });
    //Purchase end

    //Stock Out start
    Route::name('stockout.')->prefix('stockout')->group(function () {
        Route::get('/list', [StockOutController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [StockOutController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [StockOutController::class, 'create'])->name('create');
        Route::post('/store', [StockOutController::class, 'store'])->name('store');
        Route::get('/show/{brans:id}', [StockOutController::class, 'show'])->name('show');
        Route::get('/edit/{brans:id}', [StockOutController::class, 'edit'])->name('edit');
        Route::post('/update/{brans:id}', [StockOutController::class, 'update'])->name('update');
        Route::get('/delete/{brans:id}', [StockOutController::class, 'destroy'])->name('destroy');
        Route::get('/get-product', [StockOutController::class, 'getProductList'])->name('get.product');
        Route::get('/get-quantity', [StockOutController::class, 'getQty'])->name('get.quantity');
    });
    //Stock Out end

    //Mac package  start
    Route::name('macpackage.')->prefix('macpackage')->group(function () {
        Route::get('/list', [MacPackageController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MacPackageController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [MacPackageController::class, 'create'])->name('create');
        Route::post('/store', [MacPackageController::class, 'store'])->name('store');
        Route::get('/show/{macpackage:id}', [MacPackageController::class, 'show'])->name('show');
        Route::get('/edit/{macpackage:id}', [MacPackageController::class, 'edit'])->name('edit');
        Route::post('/update/{macpackage:id}', [MacPackageController::class, 'update'])->name('update');
        Route::get('/delete/{macpackage:id}', [MacPackageController::class, 'destroy'])->name('destroy');
    });
    //Mac Reseller end

    //package operation start
    Route::name('packages2.')->prefix('packages2')->group(function () {
        Route::get('/list', [Package2Controller::class, 'index'])->name('index');
        Route::get('/dataProcessing', [Package2Controller::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [Package2Controller::class, 'create'])->name('create')->middleware(['ismac']);
        Route::post('/store', [Package2Controller::class, 'store'])->name('store');
        Route::get('/edit/{package2:id}', [Package2Controller::class, 'edit'])->name('edit');
        Route::get('/show/{package2:id}', [Package2Controller::class, 'show'])->name('show');
        Route::post('/update/{package2:id}', [Package2Controller::class, 'update'])->name('update');
        Route::get('/delete/{package2:id}', [Package2Controller::class, 'destroy'])->name('destroy');
        Route::get('/status/{package2:id}/{status}', [Package2Controller::class, 'statusUpdate'])->name('status');
    });
    //package operation end

    //Mac Tariff Config start
    Route::name('mactariffconfig.')->prefix('mactariffconfig')->group(function () {
        Route::get('/list', [MacTariffConfigController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MacTariffConfigController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [MacTariffConfigController::class, 'create'])->name('create');
        Route::post('/store', [MacTariffConfigController::class, 'store'])->name('store');
        Route::get('/show/{mactariffconfig:id}', [MacTariffConfigController::class, 'show'])->name('show');
        Route::get('/edit/{mactariffconfig:id}', [MacTariffConfigController::class, 'edit'])->name('edit');
        Route::post('/update/{mactariffconfig:id}', [MacTariffConfigController::class, 'update'])->name('update');
        Route::get('/delete/{mactariffconfig:id}', [MacTariffConfigController::class, 'destroy'])->name('destroy');
        Route::get('/get-profile', [MacTariffConfigController::class, 'getprofile'])->name('getprofile');
        Route::get('/get-queue', [MacTariffConfigController::class, 'getQueue'])->name('getQueue');
        Route::get('/tarifPackageEdit/{package2:id}', [MacTariffConfigController::class, 'tarifPackageEdit'])->name('tarifPackageEdit');
        Route::post('/tarifPackageUpdate/{package2:id}', [MacTariffConfigController::class, 'tarifPackageUpdate'])->name('tarifPackageUpdate');
    });
    //Mac Tariff Config end

    //User Package start
    Route::name('userpackage.')->prefix('userpackage')->group(function () {
        Route::get('/list', [UserPackageController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UserPackageController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [UserPackageController::class, 'create'])->name('create');
        Route::post('/store', [UserPackageController::class, 'store'])->name('store');
        Route::get('/show/{userpackage:id}', [UserPackageController::class, 'show'])->name('show');
        Route::get('/edit/{userpackage:id}', [UserPackageController::class, 'edit'])->name('edit');
        Route::post('/update/{userpackage:id}', [UserPackageController::class, 'update'])->name('update');
        Route::get('/delete/{userpackage:id}', [UserPackageController::class, 'destroy'])->name('destroy');
        Route::get('/get-profile', [UserPackageController::class, 'getprofile'])->name('getprofile');
    });
    //User Package end

    //Mac Reseller start
    Route::name('macreseller.')->prefix('macreseller')->group(function () {
        Route::get('/list', [MacResellerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MacResellerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [MacResellerController::class, 'create'])->name('create');
        Route::post('/store', [MacResellerController::class, 'store'])->name('store');
        Route::get('/show/{MacReseller:id}', [MacResellerController::class, 'show'])->name('show');
        Route::get('/edit/{MacReseller:id}', [MacResellerController::class, 'edit'])->name('edit');
        Route::post('/update/{MacReseller:id}', [MacResellerController::class, 'update'])->name('update');
        Route::get('/delete/{MacReseller:id}', [MacResellerController::class, 'destroy'])->name('destroy');
    });
    //Mac Reseller end
    //Device start
    Route::name('devices.')->prefix('devices')->group(function () {
        Route::get('/list', [DeviceController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DeviceController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DeviceController::class, 'create'])->name('create');
        Route::post('/store', [DeviceController::class, 'store'])->name('store');
        Route::get('/show/{device:id}', [DeviceController::class, 'show'])->name('show');
        Route::get('/edit/{device:id}', [DeviceController::class, 'edit'])->name('edit');
        Route::post('/update/{device:id}', [DeviceController::class, 'update'])->name('update');
        Route::get('/delete/{device:id}', [DeviceController::class, 'destroy'])->name('destroy');
    });
    //Device end

    //Connection Type start
    Route::name('connections.')->prefix('connections')->group(function () {
        Route::get('/list', [ConnectionTypeController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ConnectionTypeController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ConnectionTypeController::class, 'create'])->name('create');
        Route::post('/store', [ConnectionTypeController::class, 'store'])->name('store');
        Route::get('/show/{connection:id}', [ConnectionTypeController::class, 'show'])->name('show');
        Route::get('/edit/{connection:id}', [ConnectionTypeController::class, 'edit'])->name('edit');
        Route::post('/update/{connection:id}', [ConnectionTypeController::class, 'update'])->name('update');
        Route::get('/delete/{connection:id}', [ConnectionTypeController::class, 'destroy'])->name('destroy');
    });
    //Connection Type end

    //Protocol Type start
    Route::name('protocols.')->prefix('protocols')->group(function () {
        Route::get('/list', [ProtocolController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ProtocolController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ProtocolController::class, 'create'])->name('create');
        Route::post('/store', [ProtocolController::class, 'store'])->name('store');
        Route::get('/show/{protocol:id}', [ProtocolController::class, 'show'])->name('show');
        Route::get('/edit/{protocol:id}', [ProtocolController::class, 'edit'])->name('edit');
        Route::post('/update/{protocol:id}', [ProtocolController::class, 'update'])->name('update');
        Route::get('/delete/{protocol:id}', [ProtocolController::class, 'destroy'])->name('destroy');
    });
    //Protocol Type end

    //Protocol Type start
    Route::name('billingstatus.')->prefix('billing-status')->group(function () {
        Route::get('/list', [BillingStatusController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BillingStatusController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BillingStatusController::class, 'create'])->name('create');
        Route::post('/store', [BillingStatusController::class, 'store'])->name('store');
        Route::get('/show/{billingstatus:id}', [BillingStatusController::class, 'show'])->name('show');
        Route::get('/edit/{billingstatus:id}', [BillingStatusController::class, 'edit'])->name('edit');
        Route::post('/update/{billingstatus:id}', [BillingStatusController::class, 'update'])->name('update');
        Route::get('/delete/{billingstatus:id}', [BillingStatusController::class, 'destroy'])->name('destroy');
    });
    //Protocol Type end

    //Protocol Type start
    Route::name('payments.')->prefix('payment-method')->group(function () {
        Route::get('/list', [PaymentMethodController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [PaymentMethodController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [PaymentMethodController::class, 'create'])->name('create');
        Route::post('/store', [PaymentMethodController::class, 'store'])->name('store');
        Route::get('/show/{payment:id}', [PaymentMethodController::class, 'show'])->name('show');
        Route::get('/edit/{payment:id}', [PaymentMethodController::class, 'edit'])->name('edit');
        Route::post('/update/{payment:id}', [PaymentMethodController::class, 'update'])->name('update');
        Route::get('/delete/{payment:id}', [PaymentMethodController::class, 'destroy'])->name('destroy');
    });
    //Protocol Type end

    //Item categories start
    Route::name('itemcategory.')->prefix('itemcategory')->group(function () {
        Route::get('/list', [ItemCategoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ItemCategoryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ItemCategoryController::class, 'create'])->name('create');
        Route::post('/store', [ItemCategoryController::class, 'store'])->name('store');
        Route::get('/show/{ItemCategory:id}', [ItemCategoryController::class, 'show'])->name('show');
        Route::get('/edit/{ItemCategory:id}', [ItemCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{ItemCategory:id}', [ItemCategoryController::class, 'update'])->name('update');
        Route::get('/delete/{ItemCategory:id}', [ItemCategoryController::class, 'destroy'])->name('destroy');
    });
    //Item categories end

    //Item start
    Route::name('items.')->prefix('items')->group(function () {
        Route::get('/list', [ItemController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ItemController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ItemController::class, 'create'])->name('create');
        Route::post('/store', [ItemController::class, 'store'])->name('store');
        Route::get('/show/{Item:id}', [ItemController::class, 'show'])->name('show');
        Route::get('/edit/{Item:id}', [ItemController::class, 'edit'])->name('edit');
        Route::post('/update/{Item:id}', [ItemController::class, 'update'])->name('update');
        Route::get('/delete/{Item:id}', [ItemController::class, 'destroy'])->name('destroy');
    });
    //Item end

    //Provider start
    Route::name('providers.')->prefix('providers')->group(function () {
        Route::get('/list', [ProviderController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ProviderController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ProviderController::class, 'create'])->name('create');
        Route::post('/store', [ProviderController::class, 'store'])->name('store');
        Route::get('/show/{Provider:id}', [ProviderController::class, 'show'])->name('show');
        Route::get('/edit/{Provider:id}', [ProviderController::class, 'edit'])->name('edit');
        Route::post('/update/{Provider:id}', [ProviderController::class, 'update'])->name('update');
        Route::get('/delete/{Provider:id}', [ProviderController::class, 'destroy'])->name('destroy');
    });
    //Provider end
    //Provider start
    Route::name('mikrotikserver.')->prefix('mikrotikserver')->group(function () {
        Route::get('/list', [MikrotikServerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [MikrotikServerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [MikrotikServerController::class, 'create'])->name('create');
        Route::post('/store', [MikrotikServerController::class, 'store'])->name('store');
        Route::get('/show/{mikrotik_server:id}', [MikrotikServerController::class, 'show'])->name('show');
        Route::get('/edit/{mikrotik_server:id}', [MikrotikServerController::class, 'edit'])->name('edit');
        Route::post('/update/{mikrotik_server:id}', [MikrotikServerController::class, 'update'])->name('update');
        Route::get('/delete/{mikrotik_server:id}', [MikrotikServerController::class, 'destroy'])->name('destroy');
        Route::post('/sync/{mikrotikser:id}', [MikrotikServerController::class, 'sync'])->name('sync');
    });
    //Provider end
    //Provider start
    Route::name('client_types.')->prefix('client_types')->group(function () {
        Route::get('/list', [ClientTypeController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ClientTypeController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ClientTypeController::class, 'create'])->name('create');
        Route::post('/store', [ClientTypeController::class, 'store'])->name('store');
        Route::get('/show/{ClientType:id}', [ClientTypeController::class, 'show'])->name('show');
        Route::get('/edit/{ClientType:id}', [ClientTypeController::class, 'edit'])->name('edit');
        Route::post('/update/{ClientType:id}', [ClientTypeController::class, 'update'])->name('update');
        Route::get('/delete/{ClientType:id}', [ClientTypeController::class, 'destroy'])->name('destroy');
    });
    //Provider end

    //Provider start
    Route::name('bandwidthCustomers.')->prefix('bandwidthCustomers')->group(function () {
        Route::get('/list', [BandwidthCustomerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BandwidthCustomerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BandwidthCustomerController::class, 'create'])->name('create');
        Route::post('/store', [BandwidthCustomerController::class, 'store'])->name('store');
        Route::get('/show/{bandwidthCustomer:id}', [BandwidthCustomerController::class, 'show'])->name('show');
        Route::get('/connection/status/{bandwidthCustomer:id}', [BandwidthCustomerController::class, 'status'])->name('connection.status');
        Route::post('/connection/status/save/{bandwidthCustomer:id}', [BandwidthCustomerController::class, 'status'])->name('connection.status.store');
        Route::get('/edit/{bandwidthCustomer:id}', [BandwidthCustomerController::class, 'edit'])->name('edit');
        Route::post('/update/{bandwidthCustomer:id}', [BandwidthCustomerController::class, 'update'])->name('update');
        Route::get('/delete/{bandwidthCustomer:id}', [BandwidthCustomerController::class, 'destroy'])->name('destroy');
    });

    Route::name('disbandwidthCustomers.')->prefix('disconnect-bandwidthCustomers')->group(function () {
        Route::get('/list', [DIsBandwidthCustomerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DIsBandwidthCustomerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DIsBandwidthCustomerController::class, 'create'])->name('create');
        Route::post('/store', [DIsBandwidthCustomerController::class, 'store'])->name('store');
        Route::get('/show/{bandwidthCustomer:id}', [DIsBandwidthCustomerController::class, 'show'])->name('show');
        Route::get('/connection/status/{bandwidthCustomer:id}', [DIsBandwidthCustomerController::class, 'status'])->name('connection.status');
        Route::post('/connection/status/save/{bandwidthCustomer:id}', [DIsBandwidthCustomerController::class, 'status'])->name('connection.status.store');
        Route::get('/edit/{bandwidthCustomer:id}', [DIsBandwidthCustomerController::class, 'edit'])->name('edit');
        Route::post('/update/{bandwidthCustomer:id}', [DIsBandwidthCustomerController::class, 'update'])->name('update');
        Route::get('/delete/{bandwidthCustomer:id}', [DIsBandwidthCustomerController::class, 'destroy'])->name('destroy');
    });

    Route::name('generate_billing.')->prefix('generate-billing')->group(function () {
        Route::get('/list', [GenerateBillingApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [GenerateBillingApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [GenerateBillingApproveController::class, 'check_validity'])->name('check_validity');
        Route::post('/confirm/billing/{customer:id}', [GenerateBillingApproveController::class, 'confirm'])->name('confirm');
        Route::get('/check/validity/{customer:id}/approve', [GenerateBillingApproveController::class, 'approve'])->name('approve');
    });

    Route::name('upgradation.')->prefix('upgradation')->group(function () {
        Route::get('/list', [ResellerUpgradationController::class, 'index'])->name('index');
        Route::get('/create', [ResellerUpgradationController::class, 'create'])->name('create');
        Route::get('/edit/{upgradation:id}', [ResellerUpgradationController::class, 'edit'])->name('edit');
        Route::post('/store', [ResellerUpgradationController::class, 'store'])->name('store');
        Route::get('/show/{upgradation:id}', [ResellerUpgradationController::class, 'show'])->name('show');
        Route::put('/update/{upgradation:id}', [ResellerUpgradationController::class, 'update'])->name('update');
    });

    Route::name('downgrading.')->prefix('downgrading')->group(function () {
        Route::get('/list', [ResellerDowngradingController::class, 'index'])->name('index');
        Route::get('/create', [ResellerDowngradingController::class, 'create'])->name('create');
        Route::post('/store', [ResellerDowngradingController::class, 'store'])->name('store');
        Route::get('/show/{downgradation:id}', [ResellerDowngradingController::class, 'show'])->name('show');
        Route::get('/update/{downgradation:id}', [ResellerDowngradingController::class, 'update'])->name('update');
        Route::get('/update/{downgradation:id}', [ResellerDowngradingController::class, 'update'])->name('update');
    });

    Route::name('capuncap.')->prefix('capuncap')->group(function () {
        Route::get('/list', [ResellerCapUncapController::class, 'index'])->name('index');
        Route::get('/create', [ResellerCapUncapController::class, 'create'])->name('create');
        Route::post('/store', [ResellerCapUncapController::class, 'store'])->name('store');
        Route::get('/show/{capuncap:id}', [ResellerCapUncapController::class, 'show'])->name('show');
        Route::get('/update/{capuncap:id}', [ResellerCapUncapController::class, 'update'])->name('update');
        Route::get('/update/{capuncap:id}', [ResellerCapUncapController::class, 'update'])->name('update');
    });


    Route::name('uncap_salehead.')->prefix('uncap-sale-head')->group(function () {
        Route::get('/list', [UncapSaleHeadController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UncapSaleHeadController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [UncapSaleHeadController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [UncapSaleHeadController::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}/approve', [UncapSaleHeadController::class, 'approve'])->name('approve');
    });

    Route::name('uncap_billing.')->prefix('uncap-list-billing')->group(function () {
        Route::get('/list', [UncapBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UncapBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [UncapBillingController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [UncapBillingController::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}/approve', [UncapBillingController::class, 'approve'])->name('approve');
    });

    Route::name('uncap_level4_approv.')->prefix('uncap-level-4')->group(function () {
        Route::get('/list', [UncapLevel4ApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UncapLevel4ApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [UncapLevel4ApproveController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [UncapLevel4ApproveController::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}/approve', [UncapLevel4ApproveController::class, 'approve'])->name('approve');
    });

    Route::name('upcap_level3.')->prefix('uncap-list-level3')->group(function () {
        Route::get('/list', [UncapLevel3Controller::class, 'index'])->name('index');
        Route::get('/dataProcessing', [UncapLevel3Controller::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [UncapLevel3Controller::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [UncapLevel3Controller::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}/approve', [UncapLevel3Controller::class, 'approve'])->name('approve');
        Route::get('/approve/{customer:id}/confirm', [UncapLevel3Controller::class, 'confirm'])->name('confirm');
        Route::post('/edit/gateway/{customer:id}/updatestore', [UncapLevel3Controller::class, 'updatestore'])->name('updatestore');
    });

    Route::name('cap_level4_approv.')->prefix('cap-level-4')->group(function () {
        Route::get('/list', [CapLevel4ApproveController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [CapLevel4ApproveController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [CapLevel4ApproveController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [CapLevel4ApproveController::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}/approve', [CapLevel4ApproveController::class, 'approve'])->name('approve');
    });

    Route::name('cap_level3.')->prefix('cap-list-level3')->group(function () {
        Route::get('/list', [CapLevel3Controller::class, 'index'])->name('index');
        Route::get('/dataProcessing', [CapLevel3Controller::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{customer:id}', [CapLevel3Controller::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{customer:id}/store', [CapLevel3Controller::class, 'store'])->name('store');
        Route::get('/check/validity/{customer:id}/approve', [CapLevel3Controller::class, 'approve'])->name('approve');
        Route::get('/approve/{customer:id}/confirm', [CapLevel3Controller::class, 'confirm'])->name('confirm');
        Route::post('/edit/gateway/{customer:id}/updatestore', [CapLevel3Controller::class, 'updatestore'])->name('updatestore');
    });

    //panding customer
    Route::name('pending_customer.')->prefix('pending-customer')->group(function () {
        Route::get('/list', [PendingBandwidthCustomerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [PendingBandwidthCustomerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [PendingBandwidthCustomerController::class, 'create'])->name('create');
        Route::post('/store', [PendingBandwidthCustomerController::class, 'store'])->name('store');
        Route::get('/show/{bandwidthCustomer:id}', [PendingBandwidthCustomerController::class, 'show'])->name('show');
        Route::get('/edit/{bandwidthCustomer:id}', [PendingBandwidthCustomerController::class, 'edit'])->name('edit');
        Route::post('/update/{bandwidthCustomer:id}', [PendingBandwidthCustomerController::class, 'update'])->name('update');
        Route::get('/delete/{bandwidthCustomer:id}', [PendingBandwidthCustomerController::class, 'destroy'])->name('destroy');
    });
    //Provider endvalidity

    //Bandwidth Sale Invoice start
    Route::name('bandwidthsaleinvoice.')->prefix('bandwidthsaleinvoice')->group(function () {
        Route::get('/list', [BandwidthSaleInvoiceController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BandwidthSaleInvoiceController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BandwidthSaleInvoiceController::class, 'create'])->name('create');
        Route::post('/store', [BandwidthSaleInvoiceController::class, 'store'])->name('store');
        Route::get('/invoice/{banseidthsaleinvoice:id}', [BandwidthSaleInvoiceController::class, 'invoice'])->name('invoice');
        Route::match(['get', 'post'], '/mail-invoice/{business}/{saleinvoiceid:id}', [BandwidthSaleInvoiceController::class, 'mail_invoice'])->name('mail.invoice');
        Route::get('/mail-invoice2/{business}/{saleinvoiceid:id}', [BandwidthSaleInvoiceController::class, 'mail_invoice2'])->name('mail.invoice2');
        Route::get('/edit/{banseidthsaleinvoice:id}', [BandwidthSaleInvoiceController::class, 'edit'])->name('edit');
        Route::post('/update/{banseidthsaleinvoice:id}', [BandwidthSaleInvoiceController::class, 'update'])->name('update');
        Route::get('/delete/{banseidthsaleinvoice:id}', [BandwidthSaleInvoiceController::class, 'destroy'])->name('destroy');
        Route::get('/invoice/{banseidthsaleinvoice:id}', [BandwidthSaleInvoiceController::class, 'invoice'])->name('invoice');
        Route::get('/delete', [BandwidthSaleInvoiceController::class, 'itemval'])->name('getItemVal');
        Route::get('/pay', [BandwidthSaleInvoiceController::class, 'pay'])->name('pay');
        Route::post('/paystore}', [BandwidthSaleInvoiceController::class, 'paystore'])->name('paystore');
        // Route::get('/mailinvoice2',function(){
        //     return view('admin.pages.bandwidthsale.bandwidthsaleinvoice.mailinvoice2');
        // });
        Route::get('/getAvailableBalance}', [BandwidthSaleInvoiceController::class, 'getAvailableBalance'])->name('getAvailableBalance');
    });
    //Bandwidth Sale Invoice end

    //Support Category Sale Invoice start
    Route::name('supportcategory.')->prefix('supportcategory')->group(function () {
        Route::get('/list', [SupportCategoryController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SupportCategoryController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SupportCategoryController::class, 'create'])->name('create');
        Route::post('/store', [SupportCategoryController::class, 'store'])->name('store');
        Route::get('/invoice/{supportcategory:id}', [SupportCategoryController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{supportcategory:id}', [SupportCategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{supportcategory:id}', [SupportCategoryController::class, 'update'])->name('update');
        Route::get('/delete/{supportcategory:id}', [SupportCategoryController::class, 'destroy'])->name('destroy');
    });
    //Support Category Sale Invoice end

    //Support Status Sale Invoice start
    Route::name('supportstatus.')->prefix('supportstatus')->group(function () {
        Route::get('/list', [SupportStatusController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [SupportStatusController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SupportStatusController::class, 'create'])->name('create');
        Route::post('/store', [SupportStatusController::class, 'store'])->name('store');
        Route::get('/invoice/{supportcategory:id}', [SupportStatusController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{supportcategory:id}', [SupportStatusController::class, 'edit'])->name('edit');
        Route::post('/update/{supportcategory:id}', [SupportStatusController::class, 'update'])->name('update');
        Route::get('/delete/{supportcategory:id}', [SupportStatusController::class, 'destroy'])->name('destroy');
    });
    //Support Status Sale Invoice end


    Route::name('supportticket.')->prefix('supportticket')->group(function () {
        Route::get('/total/list/{id?}', [SupportTicketController::class, 'total'])->name('total');
        Route::get('/list/{id?}', [SupportTicketController::class, 'index'])->name('index');
        Route::get('/dataProcessing/{id?}', [SupportTicketController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [SupportTicketController::class, 'create'])->name('create');
        Route::post('/store', [SupportTicketController::class, 'store'])->name('store');
        Route::get('/invoice/{supportticket:id}', [SupportTicketController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{supportticket:id}', [SupportTicketController::class, 'edit'])->name('edit');
        Route::post('/update/{supportticket:id}', [SupportTicketController::class, 'update'])->name('update');
        Route::get('/delete/{supportticket:id}', [SupportTicketController::class, 'destroy'])->name('destroy');
        Route::get('/user-Details', [SupportTicketController::class, 'userDetails'])->name('userdetails');
        Route::get('/assign/{supportticket:id}', [SupportTicketController::class, 'assign'])->name('assign');
        Route::get('/status/{supportticket:id}', [SupportTicketController::class, 'status'])->name('status');
        Route::post('/status-update/{supportticket:id}', [SupportTicketController::class, 'statusupdate'])->name('statusupdate');
    });
    //Support Ticket Sale Invoice end
    //Support Ticket Sale Invoice start
    Route::name('my_supportticket.')->prefix('my-supportticket')->group(function () {
        Route::get('/list/{id?}', [MySupportTicketController::class, 'index'])->name('index');
        Route::get('/dataProcessing/{id?}', [MySupportTicketController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/ticketstatus/{supportticket:id}', [MySupportTicketController::class, 'ticketstatus'])->name('ticketstatus');
        Route::post('/statusup/{supportticket:id}', [MySupportTicketController::class, 'statusup'])->name('statusup');
        Route::get('/assignto/{supportticket:id}', [MySupportTicketController::class, 'assignto'])->name('assignto');
    });

    // //Support Ticket Sale Invoice start
    // Route::name('supportticket.')->prefix('supportticket')->group(function () {
    //     Route::get('/total/list/{id?}', [SupportTicketController::class, 'total'])->name('total');
    //     Route::get('/list/{id?}', [SupportTicketController::class, 'index'])->name('index');
    //     Route::get('/dataProcessing/{id?}', [SupportTicketController::class, 'dataProcessing'])->name('dataProcessing');
    //     Route::get('/create', [SupportTicketController::class, 'create'])->name('create');
    //     Route::post('/store', [SupportTicketController::class, 'store'])->name('store');
    //     Route::get('/invoice/{supportticket:id}', [SupportTicketController::class, 'invoice'])->name('invoice');
    //     Route::get('/edit/{supportticket:id}', [SupportTicketController::class, 'edit'])->name('edit');
    //     Route::post('/update/{supportticket:id}', [SupportTicketController::class, 'update'])->name('update');
    //     Route::get('/delete/{supportticket:id}', [SupportTicketController::class, 'destroy'])->name('destroy');
    //     Route::get('/user-Details', [SupportTicketController::class, 'userDetails'])->name('userdetails');
    //     Route::get('/assign/{supportticket:id}', [SupportTicketController::class, 'assign'])->name('assign');
    //     Route::get('/status/{supportticket:id}', [SupportTicketController::class, 'status'])->name('status');
    //     Route::post('/status-update/{supportticket:id}', [SupportTicketController::class, 'statusupdate'])->name('statusupdate');
    // });
    // //Support Ticket Sale Invoice end

    // //Support Ticket Sale Invoice start
    // Route::name('my_supportticket.')->prefix('my-supportticket')->group(function () {
    //     Route::get('/list/{id?}', [MySupportTicketController::class, 'index'])->name('index');
    //     Route::get('/dataProcessing/{id?}', [MySupportTicketController::class, 'dataProcessing'])->name('dataProcessing');
    //     Route::get('/ticketstatus/{supportticket:id}', [MySupportTicketController::class, 'ticketstatus'])->name('ticketstatus');
    //     Route::post('/statusup/{supportticket:id}', [MySupportTicketController::class, 'statusup'])->name('statusup');
    //     Route::get('/assignto/{supportticket:id}', [MySupportTicketController::class, 'assignto'])->name('assignto');
    // });
    // //Support Ticket Sale Invoice end


    //Reports start
    Route::name('reports.')->prefix('reports')->group(function () {
        Route::get('/btrc', [BtrcReportController::class, 'index'])->name('btrc');
        Route::get('/dataProcessing', [BtrcReportController::class, 'dataProcessing'])->name('dataProcessing');

        Route::get('/ticket', [TicketReportController::class, 'index'])->name('ticket');
        Route::get('/dataProcessing-ticket', [TicketReportController::class, 'dataProcessing'])->name('dataProcessing.ticket');

        Route::get('/teamhead', [TeamReportController::class, 'index'])->name('teamhead');
        Route::get('/teamhead/dataProcessing', [TeamReportController::class, 'teamdataProcessing'])->name('teamhead.dataProcessing');

        Route::get('/teamperson', [TeamPersonReportController::class, 'index'])->name('teamperson');
        Route::get('/teamperson/dataProcessing', [TeamPersonReportController::class, 'teamdataProcessing'])->name('teamperson.dataProcessing');

        Route::any('/bill-list', [BillCollectionReportController::class, 'index'])->name('bill.index');
        Route::get('/process-billcollection', [BillCollectionReportController::class, 'bill_collections'])->name('bill_collections');

        Route::get('/discounts', [DiscountReportController::class, 'index'])->name('discounts');
        Route::get('/process-discounts', [DiscountReportController::class, 'discount_process'])->name('discount_process');

        Route::get('/customers', [CustomerReportController::class, 'index'])->name('customers');
        Route::get('/customer-process', [CustomerReportController::class, 'customer_process'])->name('customer_process');

        Route::any('/reseller', [ResellerReportController::class, 'index'])->name('reseller');
        // Route::any('/reseller/teamhead', [ResellerReportController::class, 'teamhead'])->name('teamhead');
        Route::any('/reseller-invoice', [ResellerReportController::class, 'invoice'])->name('reseller.invoice');
        Route::any('/upstream', [UpstreamReportController::class, 'index'])->name('upstream');

        Route::any('/mac.reseller', [MacResellerReportController::class, 'index'])->name('mac.reseller');
        Route::any('/mac/reseller/payment/delete/{accountTransaction:invoice}', [MacResellerReportController::class, 'paymentDelete'])->name('mac.reseller.payment.delete');
    });
    //Reports end
    //Daily Income report start
    Route::name('dailyincomereports.')->prefix('dailyincomereports')->group(function () {
        Route::get('/list', [DailyIncomeReportController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DailyIncomeReportController::class, 'dataProcessing'])->name('dataProcessing');

        Route::get('/bill-list', [DailyIncomeReportController::class, 'index'])->name('bill.index');
        Route::get('/process-billcollection', [DailyIncomeReportController::class, 'bill_collections'])->name('bill_collections');

        Route::get('/discounts', [DiscountReportController::class, 'index'])->name('discounts');
        Route::get('/process-discounts', [DiscountReportController::class, 'discount_process'])->name('discount_process');

        Route::get('/customers', [CustomerReportController::class, 'index'])->name('customers');
        Route::get('/customer-process', [CustomerReportController::class, 'customer_process'])->name('customer_process');
    });
    //Daily Income report end

    //Imports start
    Route::name('imports.')->prefix('imports')->group(function () {
        Route::get('/customers', [ImportController::class, 'user_import_form'])->name('customer');
        Route::post('/customers', [ImportController::class, 'user_file_import'])->name('customer.excel');
        /**
         * Billing
         */
        Route::get('/billings', [ImportController::class, 'billing_import_form'])->name('billings');
        Route::post('/billings', [ImportController::class, 'billing_file_import']);

        Route::post('/bandwidth_billings', [ImportController::class, 'bandwidth_customer'])->name('bandwidth_billings');
    });
    //Imports end


    //Support Category Sale Invoice start
    Route::name('rollPermission.')->prefix('rollPermission')->group(function () {
        Route::get('/list', [RollPermissionController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [RollPermissionController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [RollPermissionController::class, 'create'])->name('create');
        Route::post('/store', [RollPermissionController::class, 'store'])->name('store');
        Route::get('/invoice/{rollpermission:id}', [RollPermissionController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{rollpermission:id}', [RollPermissionController::class, 'edit'])->name('edit');
        Route::post('/update/{rollpermission:id}', [RollPermissionController::class, 'update'])->name('update');
        Route::get('/delete/{rollpermission:id}', [RollPermissionController::class, 'destroy'])->name('destroy');
    });

    Route::name('mailer.')->prefix('mailer')->group(function () {
        Route::get('/create', [MailSetupController::class, 'create'])->name('create');
        Route::post('/store', [MailSetupController::class, 'store'])->name('store');
    });
    //Support Category Sale Invoice end

    //Department start
    Route::name('department.')->prefix('department')->group(function () {

        Route::get('/list', [DepartmentController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DepartmentController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DepartmentController::class, 'create'])->name('create');
        Route::post('/store', [DepartmentController::class, 'store'])->name('store');
        Route::get('/invoice/{department:id}', [DepartmentController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{department:id}', [DepartmentController::class, 'edit'])->name('edit');
        Route::post('/update/{department:id}', [DepartmentController::class, 'update'])->name('update');
        Route::get('/delete/{department:id}', [DepartmentController::class, 'destroy'])->name('destroy');
    });
    //Department end

    //team start
    Route::name('team.')->prefix('team')->group(function () {

        Route::get('/list', [TeamController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [TeamController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [TeamController::class, 'create'])->name('create');
        Route::post('/store', [TeamController::class, 'store'])->name('store');
        Route::get('/invoice/{team:id}', [TeamController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{team:id}', [TeamController::class, 'edit'])->name('edit');
        Route::post('/update/{team:id}', [TeamController::class, 'update'])->name('update');
        Route::get('/delete/{team:id}', [TeamController::class, 'destroy'])->name('destroy');
    });
    //team end
    Route::name('licensetype.')->prefix('licensetype')->group(function () {

        Route::get('/list', [LicenseTypeController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [LicenseTypeController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [LicenseTypeController::class, 'create'])->name('create');
        Route::post('/store', [LicenseTypeController::class, 'store'])->name('store');
        Route::get('/invoice/{licensetype:id}', [LicenseTypeController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{licensetype:id}', [LicenseTypeController::class, 'edit'])->name('edit');
        Route::post('/update/{licensetype:id}', [LicenseTypeController::class, 'update'])->name('update');
        Route::get('/delete/{licensetype:id}', [LicenseTypeController::class, 'destroy'])->name('destroy');
    });
    //team end

    //designation start
    Route::name('designation.')->prefix('designation')->group(function () {
        Route::get('/list', [DesignationController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DesignationController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [DesignationController::class, 'create'])->name('create');
        Route::post('/store', [DesignationController::class, 'store'])->name('store');
        Route::get('/invoice/{designation:id}', [DesignationController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{designation:id}', [DesignationController::class, 'edit'])->name('edit');
        Route::post('/update/{designation:id}', [DesignationController::class, 'update'])->name('update');
        Route::get('/delete/{designation:id}', [DesignationController::class, 'destroy'])->name('destroy');
    });
    //designation end

    //opening balance start
    Route::name('openingbalance.')->prefix('openingbalance')->group(function () {
        Route::get('/list', [OpeningBalanceController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [OpeningBalanceController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [OpeningBalanceController::class, 'create'])->name('create');
        Route::post('/store', [OpeningBalanceController::class, 'store'])->name('store');
        Route::get('/invoice/{openingbalance:id}', [OpeningBalanceController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{openingbalance:id}', [OpeningBalanceController::class, 'edit'])->name('edit');
        Route::post('/update/{openingbalance:id}', [OpeningBalanceController::class, 'update'])->name('update');
        Route::get('/delete/{openingbalance:id}', [OpeningBalanceController::class, 'destroy'])->name('destroy');
    });
    //opening balance end

    //balance Transfer start
    Route::name('balancetransfer.')->prefix('balancetransfer')->group(function () {
        Route::get('/list', [BalanceTransferController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [BalanceTransferController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [BalanceTransferController::class, 'create'])->name('create');
        Route::post('/store', [BalanceTransferController::class, 'store'])->name('store');
        Route::get('/invoice/{balancetransfer:id}', [BalanceTransferController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{balancetransfer:id}', [BalanceTransferController::class, 'edit'])->name('edit');
        Route::post('/update/{balancetransfer:id}', [BalanceTransferController::class, 'update'])->name('update');
        Route::get('/delete/{balancetransfer:id}', [BalanceTransferController::class, 'destroy'])->name('destroy');
    });
    //balance Transfer end

    //vlan start
    Route::name('vlan.')->prefix('vlan')->group(function () {
        Route::get('/list', [VlanController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [VlanController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [VlanController::class, 'create'])->name('create');
        Route::post('/store', [VlanController::class, 'store'])->name('store');
        Route::get('/invoice/{vlan:id}', [VlanController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{vlan:id}', [VlanController::class, 'edit'])->name('edit');
        Route::post('/update/{vlan:id}', [VlanController::class, 'update'])->name('update');
        Route::get('/delete/{vlan:id}', [VlanController::class, 'destroy'])->name('destroy');
        Route::get('/disabled/{vlan:id}', [VlanController::class, 'disabled'])->name('disabled');
    });
    //vlan end

    //ip_address start
    Route::name('ip_address.')->prefix('ip_address')->group(function () {
        Route::get('/list', [IpAddressController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [IpAddressController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [IpAddressController::class, 'create'])->name('create');
        Route::post('/store', [IpAddressController::class, 'store'])->name('store');
        Route::get('/invoice/{ipaddress:id}', [IpAddressController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{ipaddress:id}', [IpAddressController::class, 'edit'])->name('edit');
        Route::get('/disabled/{ipaddress:id}', [IpAddressController::class, 'disabled'])->name('disabled');
        Route::post('/update/{ipaddress:id}', [IpAddressController::class, 'update'])->name('update');
        Route::get('/delete/{ipaddress:id}', [IpAddressController::class, 'destroy'])->name('destroy');
    });
    //ip_address end

    //queue start
    Route::name('queue.')->prefix('queue')->group(function () {
        Route::get('/list', [QueueController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [QueueController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [QueueController::class, 'create'])->name('create');
        Route::post('/store', [QueueController::class, 'store'])->name('store');
        Route::get('/invoice/{Queue:id}', [QueueController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{Queue:id}', [QueueController::class, 'edit'])->name('edit');
        Route::get('/disabled/{Queue:id}', [QueueController::class, 'disabled'])->name('disabled');
        Route::post('/update/{Queue:id}', [QueueController::class, 'update'])->name('update');
        Route::get('/delete/{Queue:id}', [QueueController::class, 'destroy'])->name('destroy');
    });
    //queue end

    //Purchase Bill start
    Route::name('purchasebill.')->prefix('purchasebill')->group(function () {
        Route::get('/list', [PurchaseBillController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [PurchaseBillController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [PurchaseBillController::class, 'create'])->name('create');
        Route::post('/store', [PurchaseBillController::class, 'store'])->name('store');
        Route::get('/invoice/{PurchaseBill:id}', [PurchaseBillController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{PurchaseBill:id}', [PurchaseBillController::class, 'edit'])->name('edit');
        Route::get('/disabled/{PurchaseBill:id}', [PurchaseBillController::class, 'disabled'])->name('disabled');
        Route::post('/update/{PurchaseBill:id}', [PurchaseBillController::class, 'update'])->name('update');
        Route::get('/delete/{PurchaseBill:id}', [PurchaseBillController::class, 'destroy'])->name('destroy');
        Route::get('/pay', [PurchaseBillController::class, 'pay'])->name('pay');
        Route::post('/paystore', [PurchaseBillController::class, 'paystore'])->name('paystore');
        Route::post('/purchasebill', [PurchaseBillController::class, 'purchasebill'])->name('purchasebill');
        Route::get('/getAvailableBalance', [PurchaseBillController::class, 'getAvailableBalance'])->name('getAvailableBalance');
    });
    //purchase bill end

    //Static Customers Bill start
    Route::name('static_customers.')->prefix('static-customers')->group(function () {
        Route::get('/list', [StaticCustomerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [StaticCustomerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [StaticCustomerController::class, 'create'])->name('create');
        Route::post('/store', [StaticCustomerController::class, 'store'])->name('store');
        Route::get('/edit/{customer:id}', [StaticCustomerController::class, 'edit'])->name('edit');
        Route::get('/show/{customer:id}', [StaticCustomerController::class, 'show'])->name('show');
        Route::post('/update/{customer:id}', [StaticCustomerController::class, 'update'])->name('update');
        Route::get('/delete/{customer:id}', [StaticCustomerController::class, 'destroy'])->name('destroy');
        Route::get('/status/{customer:id}/{status}', [StaticCustomerController::class, 'statusUpdate'])->name('status');
        Route::get('/profile-details', [StaticCustomerController::class, 'getProfile'])->name('get_profile');
        Route::get('/m-disabled/{customer:id}', [StaticCustomerController::class, 'mikrotikStatus'])->name('queue_disabled');
    });
    //Static customers bill end

    //General Customers Bill start
    Route::name('general_customers.')->prefix('general-customers')->group(function () {
        Route::get('/list', [GeneralCustomerController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [GeneralCustomerController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [GeneralCustomerController::class, 'create'])->name('create');
        Route::post('/store', [GeneralCustomerController::class, 'store'])->name('store');
        Route::get('/edit/{customer:id}', [GeneralCustomerController::class, 'edit'])->name('edit');
        Route::get('/show/{customer:id}', [GeneralCustomerController::class, 'show'])->name('show');
        Route::post('/update/{customer:id}', [GeneralCustomerController::class, 'update'])->name('update');
        Route::get('/delete/{customer:id}', [GeneralCustomerController::class, 'destroy'])->name('destroy');
        Route::get('/status/{customer:id}/{status}', [GeneralCustomerController::class, 'statusUpdate'])->name('status');
        Route::get('/profile-details', [GeneralCustomerController::class, 'getProfile'])->name('get_profile');
        Route::get('/m-disabled/{customer:id}', [GeneralCustomerController::class, 'mikrotikStatus'])->name('disabled');
    });
    //General customers bill end

    //Add Reseller Fund start
    Route::name('addresellerfund.')->prefix('addresellerfund')->group(function () {
        Route::get('/list', [AddResellerFundController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [AddResellerFundController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [AddResellerFundController::class, 'create'])->name('create');
        Route::post('/store', [AddResellerFundController::class, 'store'])->name('store');
        Route::get('/edit/{AddResellerFund:id}', [AddResellerFundController::class, 'edit'])->name('edit');
        Route::get('/show/{AddResellerFund:id}', [AddResellerFundController::class, 'show'])->name('show');
        Route::post('/update/{AddResellerFund:id}', [AddResellerFundController::class, 'update'])->name('update');
        Route::get('/delete/{AddResellerFund:id}', [AddResellerFundController::class, 'destroy'])->name('destroy');
        Route::get('/status/{AddResellerFund:id}/{status}', [AddResellerFundController::class, 'statusUpdate'])->name('status');
    });
    //Add Reseller Fund end

    //Add Reseller Fund start
    Route::name('custombill.')->prefix('custombill')->group(function () {
        Route::get('/list', [CustomBillController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [CustomBillController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [CustomBillController::class, 'create'])->name('create');
        Route::post('/store', [CustomBillController::class, 'store'])->name('store');
        Route::get('/invoice/{customBill:id}', [CustomBillController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{customBill:id}', [CustomBillController::class, 'edit'])->name('edit');
        Route::post('/update/{customBill:id}', [CustomBillController::class, 'update'])->name('update');
        Route::get('/delete/{customBill:id}', [CustomBillController::class, 'destroy'])->name('destroy');
        Route::get('/status/{customBill:id}/{status}', [CustomBillController::class, 'statusUpdate'])->name('status');
    });
    //Add Reseller Fund end

    //ResellerFunding Bill start
    Route::name('resellerFunding.')->prefix('resellerFunding')->group(function () {
        Route::get('/list', [ResellerFundingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ResellerFundingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ResellerFundingController::class, 'create'])->name('create');
        Route::post('/store', [ResellerFundingController::class, 'store'])->name('store');
        Route::get('/edit/{ResellerFunding:id}', [ResellerFundingController::class, 'edit'])->name('edit');
        Route::get('/show', [ResellerFundingController::class, 'show'])->name('show');
        Route::post('/update/{ResellerFunding:id}', [ResellerFundingController::class, 'update'])->name('update');
        Route::get('/delete/{ResellerFunding:id}', [ResellerFundingController::class, 'destroy'])->name('destroy');
        Route::get('/status/{ResellerFunding:id}/{status}', [ResellerFundingController::class, 'statusUpdate'])->name('status');
        Route::get('/paymentCreate', [ResellerFundingController::class, 'paymentCreate'])->name('paymentCreate');
        Route::post('/paymentStore', [ResellerFundingController::class, 'paymentStore'])->name('paymentStore');
        Route::get('/get-due', [ResellerFundingController::class, 'resellerdue'])->name('get.due');
    });
    //ResellerFunding bill end

    //ResellerFunding Bill start
    Route::name('purchaseRequisition.')->prefix('purchaseRequisition')->group(function () {
        Route::get('/list', [PurchaseRequisitionController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [PurchaseRequisitionController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [PurchaseRequisitionController::class, 'create'])->name('create');
        Route::post('/store', [PurchaseRequisitionController::class, 'store'])->name('store');
        Route::get('/show/{purchaseRequisition:id}', [PurchaseRequisitionController::class, 'show'])->name('show');
        Route::get('/edit/{purchaseRequisition:id}', [PurchaseRequisitionController::class, 'edit'])->name('edit');
        Route::post('/update/{purchaseRequisition:id}', [PurchaseRequisitionController::class, 'update'])->name('update');
        Route::get('/delete/{purchaseRequisition:id}', [PurchaseRequisitionController::class, 'destroy'])->name('destroy');
        Route::get('/invoice/{purchaseRequisition:id}', [PurchaseRequisitionController::class, 'invoice'])->name('invoice');
        Route::get('/get-product', [PurchaseRequisitionController::class, 'getProductList'])->name('get.product');
        Route::get('/get-unitPice', [PurchaseRequisitionController::class, 'unitPrice'])->name('unitPice');
        Route::get('/get-account', [PurchaseRequisitionController::class, 'getAccounts'])->name('accounts');
        Route::get('/get-balance', [AccountController::class, 'getBalance'])->name('getBalance');
        Route::get('/all-stock', [PurchaseRequisitionController::class, 'allstock'])->name('stock.list');
    });
    //ResellerFunding bill end

    //mikrotiklist Bill start
    Route::name('mikrotiklist.')->prefix('mikrotiklist')->group(function () {
        Route::get('/list', [MikrotikCustomerList::class, 'index'])->name('index');
        Route::get('/dataProcessing/{id}', [MikrotikCustomerList::class, 'dataProcessing'])->name('dataProcessing');
        Route::post('/importCustomer', [MikrotikCustomerList::class, 'importCustomer'])->name('importCustomer');
        Route::post('/importStaticCustomer', [MikrotikCustomerList::class, 'importStaticCustomer'])->name('importStaticCustomer');
    });
    //mikrotiklist bill end

    //optimize  start
    Route::name('optimize.')->prefix('optimize')->group(function () {
        Route::get('/list', [ResellerOptimizeController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ResellerOptimizeController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ResellerOptimizeController::class, 'create'])->name('create');
        Route::get('/edit/{optimize:id}', [ResellerOptimizeController::class, 'edit'])->name('edit');
        Route::post('/store', [ResellerOptimizeController::class, 'store'])->name('store');
        Route::get('/show/{optimize:id}', [ResellerOptimizeController::class, 'show'])->name('show');
        Route::get('/update/{optimize:id}', [ResellerOptimizeController::class, 'update'])->name('update');
    });

    //optimize end

    Route::name('optimize_salehead.')->prefix('optimize-salehead')->group(function () {
        Route::get('/list', [OptimizeSaleHeadController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [OptimizeSaleHeadController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{optimize:id}', [OptimizeSaleHeadController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{optimize:id}/store', [OptimizeSaleHeadController::class, 'store'])->name('store');
        Route::get('/check/validity/{optimize:id}/approve', [OptimizeSaleHeadController::class, 'approve'])->name('approve');
    });

    Route::name('optimize_billing.')->prefix('optimize-billing')->group(function () {
        Route::get('/list', [OptimizeBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [OptimizeBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{optimize:id}', [OptimizeBillingController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{optimize:id}/store', [OptimizeBillingController::class, 'store'])->name('store');
        Route::get('/check/validity/{optimize:id}/approve', [OptimizeBillingController::class, 'approve'])->name('approve');
    });


    Route::name('optimize_tx.')->prefix('optimize-plumbing')->group(function () {
        Route::get('/list', [OptimizeTxPluningController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [OptimizeTxPluningController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{optimize:id}', [OptimizeTxPluningController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{optimize:id}/store', [OptimizeTxPluningController::class, 'store'])->name('store');
        Route::get('/edit/gateway/{optimize:id}/updatedata', [OptimizeTxPluningController::class, 'updatedata'])->name('updatedata');
        Route::post('/edit/gateway/{optimize:id}/updatestore', [OptimizeTxPluningController::class, 'updatestore'])->name('updatestore');
        Route::get('/edit/gateway/{optimize:id}/approve', [OptimizeTxPluningController::class, 'approve'])->name('approve');
    });

    Route::name('optimize_transmission.')->prefix('optimize-transmission')->group(function () {
        Route::get('/list', [OptimizeTransmissionController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [OptimizeTransmissionController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{optimize:id}', [OptimizeTransmissionController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{optimize:id}/store', [OptimizeTransmissionController::class, 'store'])->name('store');
        Route::post('/transmission/{optimize:id}/store', [OptimizeTransmissionController::class, 'storetransmission'])->name('store.transmission');
        Route::get('/transmission/{optimize:id}/approve', [OptimizeTransmissionController::class, 'approve'])->name('approve');
        Route::get('/transmission/{optimize:id}/dataupdate', [OptimizeTransmissionController::class, 'dataupdate'])->name('dataupdate');
        Route::post('/transmission/{id}/datastore', [OptimizeTransmissionController::class, 'datastore'])->name('datastore');
    });

    Route::name('optimize_level3.')->prefix('optimize-level3')->group(function () {
        Route::get('/list', [OptimizeLevel3Controller::class, 'index'])->name('index');
        Route::get('/dataProcessing', [OptimizeLevel3Controller::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{optimize:id}', [OptimizeLevel3Controller::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{optimize:id}/store', [OptimizeLevel3Controller::class, 'store'])->name('store');
        Route::get('/check/validity/{optimize:id}/approve', [OptimizeLevel3Controller::class, 'approve'])->name('approve');
        Route::get('/approve/{optimize:id}/confirm', [OptimizeLevel3Controller::class, 'confirm'])->name('confirm');
        Route::post('/edit/gateway/{optimize:id}/updatestore', [OptimizeLevel3Controller::class, 'updatestore'])->name('updatestore');
    });

    Route::name('optimize_confrim_billing.')->prefix('optimize-confrim-billing')->group(function () {
        Route::get('/list', [OptimizeConfrimBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [OptimizeConfrimBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{optimize:id}', [OptimizeConfrimBillingController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{optimize:id}/store', [OptimizeConfrimBillingController::class, 'store'])->name('store');
        Route::post('/confirm/billing/{optimize:id}', [OptimizeConfrimBillingController::class, 'confirm'])->name('confirm');
        Route::get('/check/validity/{optimize:id}/approve', [OptimizeConfrimBillingController::class, 'approve'])->name('approve');
    });

    Route::name('optimize_pending_billing.')->prefix('optimize-pending-billing')->group(function () {
        Route::get('/list', [OptimizePendingBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [OptimizePendingBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{optimize:id}', [OptimizePendingBillingController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{optimize:id}/store', [OptimizePendingBillingController::class, 'store'])->name('store');
        Route::post('/confirm/billing/{optimize:id}', [OptimizePendingBillingController::class, 'confirm'])->name('confirm');
        Route::get('/check/validity/{optimize:id}/approve', [OptimizePendingBillingController::class, 'approve'])->name('approve');
    });

    //nirequest Started
    Route::name('nirequest.')->prefix('nirequest')->group(function () {
        Route::get('/list', [ResellerNIRequestController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ResellerNIRequestController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ResellerNIRequestController::class, 'create'])->name('create');
        Route::get('/edit/{optimize:id}', [ResellerNIRequestController::class, 'edit'])->name('edit');
        Route::post('/store', [ResellerNIRequestController::class, 'store'])->name('store');
        Route::get('/show/{optimize:id}', [ResellerNIRequestController::class, 'show'])->name('show');
        Route::get('/update/{optimize:id}', [ResellerNIRequestController::class, 'update'])->name('update');
        Route::get('/confirm/sale/{nireq:id}', [ResellerNIRequestController::class, 'confirmsale'])->name('confirmsale');
        Route::post('/confirm/sale/store/{nireq:id}', [ResellerNIRequestController::class, 'confirmsalestore'])->name('confirmsale.store');
    });


    Route::name('nirequest_salehead.')->prefix('nirequest-salehead')->group(function () {
        Route::get('/list', [NIRequestSaleHeadController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [NIRequestSaleHeadController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{optimize:id}', [NIRequestSaleHeadController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{optimize:id}/store', [NIRequestSaleHeadController::class, 'store'])->name('store');
        Route::get('/check/validity/{optimize:id}/approve', [NIRequestSaleHeadController::class, 'approve'])->name('approve');
    });


    Route::name('nirequest_billing.')->prefix('nirequest-billing')->group(function () {
        Route::get('/list', [NIRequestBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [NIRequestBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{optimize:id}', [NIRequestBillingController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{optimize:id}/store', [NIRequestBillingController::class, 'store'])->name('store');
        Route::get('/check/validity/{optimize:id}/approve', [NIRequestBillingController::class, 'approve'])->name('approve');
    });


    Route::name('nirequest_tx.')->prefix('nirequest-plumbing')->group(function () {
        Route::get('/list', [NIRequestTxPluningController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [NIRequestTxPluningController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{optimize:id}', [NIRequestTxPluningController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{optimize:id}/store', [NIRequestTxPluningController::class, 'store'])->name('store');
        Route::get('/edit/gateway/{optimize:id}/updatedata', [NIRequestTxPluningController::class, 'updatedata'])->name('updatedata');
        Route::post('/edit/gateway/{optimize:id}/updatestore', [NIRequestTxPluningController::class, 'updatestore'])->name('updatestore');
        Route::get('/edit/gateway/{optimize:id}/approve', [NIRequestTxPluningController::class, 'approve'])->name('approve');
    });
    Route::name('nirequest_transmission.')->prefix('nirequest-transmission')->group(function () {
        Route::get('/list', [NIRequestTransmissionController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [NIRequestTransmissionController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{optimize:id}', [NIRequestTransmissionController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{optimize:id}/store', [NIRequestTransmissionController::class, 'store'])->name('store');
        Route::post('/transmission/{optimize:id}/store', [NIRequestTransmissionController::class, 'storetransmission'])->name('store.transmission');
        Route::get('/transmission/{optimize:id}/approve', [NIRequestTransmissionController::class, 'approve'])->name('approve');
        Route::get('/transmission/{optimize:id}/dataupdate', [NIRequestTransmissionController::class, 'dataupdate'])->name('dataupdate');
        Route::post('/transmission/{id}/datastore', [NIRequestTransmissionController::class, 'datastore'])->name('datastore');
    });

    Route::name('nirequest_level3.')->prefix('nirequest-level3')->group(function () {
        Route::get('/list', [NIRequestLevel3Controller::class, 'index'])->name('index');
        Route::get('/dataProcessing', [NIRequestLevel3Controller::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{optimize:id}', [NIRequestLevel3Controller::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{optimize:id}/store', [NIRequestLevel3Controller::class, 'store'])->name('store');
        Route::get('/check/validity/{optimize:id}/approve', [NIRequestLevel3Controller::class, 'approve'])->name('approve');
        Route::get('/approve/{optimize:id}/confirm', [NIRequestLevel3Controller::class, 'confirm'])->name('confirm');
        Route::post('/edit/gateway/{optimize:id}/updatestore', [NIRequestLevel3Controller::class, 'updatestore'])->name('updatestore');
    });



    Route::name('nirequest_confrim_billing.')->prefix('nirequest-confrim-billing')->group(function () {
        Route::get('/list', [NIRequestTConfrimBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [NIRequestTConfrimBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{optimize:id}', [NIRequestTConfrimBillingController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{optimize:id}/store', [NIRequestTConfrimBillingController::class, 'store'])->name('store');
        Route::post('/confirm/billing/{optimize:id}', [NIRequestTConfrimBillingController::class, 'confirm'])->name('confirm');
        Route::get('/check/validity/{optimize:id}/approve', [NIRequestTConfrimBillingController::class, 'approve'])->name('approve');
    });


    Route::name('nirequest_pending_billing.')->prefix('nirequest-pending-billing')->group(function () {
        Route::get('/list', [NIRequestPendingBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [NIRequestPendingBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{optimize:id}', [NIRequestPendingBillingController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{optimize:id}/store', [NIRequestPendingBillingController::class, 'store'])->name('store');
        Route::post('/confirm/billing/{optimize:id}', [NIRequestPendingBillingController::class, 'confirm'])->name('confirm');
        Route::get('/check/validity/{optimize:id}/approve', [NIRequestPendingBillingController::class, 'approve'])->name('approve');
    });
    //Discontinue  start
    Route::name('discontinue.')->prefix('discontinue')->group(function () {
        Route::get('/list', [ResellerDiscontinueController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [ResellerDiscontinueController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [ResellerDiscontinueController::class, 'create'])->name('create');
        Route::get('/edit/{discontinue:id}', [ResellerDiscontinueController::class, 'edit'])->name('edit');
        Route::post('/store', [ResellerDiscontinueController::class, 'store'])->name('store');
        Route::get('/show/{discontinue:id}', [ResellerDiscontinueController::class, 'show'])->name('show');
        Route::get('/update/{discontinue:id}', [ResellerDiscontinueController::class, 'update'])->name('update');
    });
    //Discontinue end

    Route::name('discontinue_salehead.')->prefix('discontinue-salehead')->group(function () {
        Route::get('/list', [DiscontinueSaleHeadController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DiscontinueSaleHeadController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{discontinue:id}', [DiscontinueSaleHeadController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{discontinue:id}/store', [DiscontinueSaleHeadController::class, 'store'])->name('store');
        Route::get('/check/validity/{discontinue:id}/approve', [DiscontinueSaleHeadController::class, 'approve'])->name('approve');
    });

    Route::name('discontinue_billing.')->prefix('discontinue-billing')->group(function () {
        Route::get('/list', [DiscontinueBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DiscontinueBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{discontinue:id}', [DiscontinueBillingController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{discontinue:id}/store', [DiscontinueBillingController::class, 'store'])->name('store');
        Route::get('/check/validity/{discontinue:id}/approve', [DiscontinueBillingController::class, 'approve'])->name('approve');
    });


    Route::name('discontinue_tx.')->prefix('discontinue-plumbing')->group(function () {
        Route::get('/list', [DiscontinueTxPluningController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DiscontinueTxPluningController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{discontinue:id}', [DiscontinueTxPluningController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{discontinue:id}/store', [DiscontinueTxPluningController::class, 'store'])->name('store');
        Route::get('/edit/gateway/{discontinue:id}/updatedata', [DiscontinueTxPluningController::class, 'updatedata'])->name('updatedata');
        Route::post('/edit/gateway/{discontinue:id}/updatestore', [DiscontinueTxPluningController::class, 'updatestore'])->name('updatestore');
        Route::get('/edit/gateway/{discontinue:id}/approve', [DiscontinueTxPluningController::class, 'approve'])->name('approve');
    });

    Route::name('discontinue_transmission.')->prefix('discontinue-transmission')->group(function () {
        Route::get('/list', [DiscontinueTransmissionController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DiscontinueTransmissionController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{discontinue:id}', [DiscontinueTransmissionController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{discontinue:id}/store', [DiscontinueTransmissionController::class, 'store'])->name('store');
        Route::post('/transmission/{discontinue:id}/store', [DiscontinueTransmissionController::class, 'storetransmission'])->name('store.transmission');
        Route::get('/transmission/{discontinue:id}/approve', [DiscontinueTransmissionController::class, 'approve'])->name('approve');
        Route::get('/transmission/{discontinue:id}/dataupdate', [DiscontinueTransmissionController::class, 'dataupdate'])->name('dataupdate');
        Route::post('/transmission/{id}/datastore', [DiscontinueTransmissionController::class, 'datastore'])->name('datastore');
    });

    Route::name('discontinue_level3.')->prefix('discontinue-level3')->group(function () {
        Route::get('/list', [DiscontinueLevel3Controller::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DiscontinueLevel3Controller::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{discontinue:id}', [DiscontinueLevel3Controller::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{discontinue:id}/store', [DiscontinueLevel3Controller::class, 'store'])->name('store');
        Route::get('/check/validity/{discontinue:id}/approve', [DiscontinueLevel3Controller::class, 'approve'])->name('approve');
        Route::get('/approve/{discontinue:id}/confirm', [DiscontinueLevel3Controller::class, 'confirm'])->name('confirm');
        Route::post('/edit/gateway/{discontinue:id}/updatestore', [DiscontinueLevel3Controller::class, 'updatestore'])->name('updatestore');
    });


    Route::name('discontinue_confrim_billing.')->prefix('discontinue-confrim-billing')->group(function () {
        Route::get('/list', [DiscontinueConfrimBillingController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [DiscontinueConfrimBillingController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/check/validity/{discontinue:id}', [DiscontinueConfrimBillingController::class, 'check_validity'])->name('check_validity');
        Route::post('/check/validity/{discontinue:id}/store', [DiscontinueConfrimBillingController::class, 'store'])->name('store');
        Route::post('/confirm/billing/{discontinue:id}', [DiscontinueConfrimBillingController::class, 'confirm'])->name('confirm');
        Route::get('/check/validity/{discontinue:id}/approve', [DiscontinueConfrimBillingController::class, 'approve'])->name('approve');
    });

    //Bill Confirm status start
    // Route::name('billconfirm.')->prefix('bill-confirm')->group(function () {
    //     Route::get('/list', [BillConfirmController::class, 'index'])->name('index');
    //     Route::get('/dataProcessing', [BillConfirmController::class, 'dataProcessing'])->name('dataProcessing');
    //     Route::get('/pay-bill-confirm/{billing:id}', [BillConfirmController::class, 'confirm'])->name('confirm');
    //     Route::get('/pay-bill-reject/{billing:id}', [BillConfirmController::class, 'reject'])->name('reject');
    //     Route::post('/pay-bill-multiconfirm', [BillConfirmController::class, 'multiconfirm'])->name('multiconfirm');
    // });
    //Bill Confirm Interface status end

    //Leave Application crud operation start
    // Route::get('/hrm-leave-applicaitn-list', [LeaveApplicationController::class, 'index'])->name('hrm.leave.index');
    // Route::get('/dataProcessingLeaveApplication', 'LeaveApplicationController@dataProcessingLeaveApplication')->name('hrm.leave.dataProcessingLeaveApplication');
    // Route::get('/hrm-leave-applicaitn-create', 'LeaveApplicationController@create')->name('hrm.leave.create');
    // Route::post('/hrm-leave-applicaitn-store', 'LeaveApplicationController@store')->name('hrm.leave.store');
    // Route::get('/hrm-leave-applicaitn-edit/{id}', 'LeaveApplicationController@edit')->name('hrm.leave.edit');
    // Route::get('/hrm-leave-applicaitn-show/{leave:id}', 'LeaveApplicationController@show')->name('hrm.leave.show');
    // Route::post('/hrm-leave-applicaitn-update/{id}', 'LeaveApplicationController@update')->name('hrm.leave.update');
    // Route::get('/hrm-leave-applicaitn-delete/{id}', 'LeaveApplicationController@destroy')->name('hrm.leave.destroy');

    //Leave Application crud operation end

    //Salary attendance crud operation start

    Route::get('/hrm-attendance-create', [AttendanceController::class, 'create'])->name('hrm.attendance.create');
    Route::post('/hrm-attendance-sign_in', [AttendanceController::class, 'signin'])->name('hrm.attendance.sign_in');
    Route::post('/hrm-attendance-sign_out', [AttendanceController::class, 'signout'])->name('hrm.attendance.sign_out');
    //Salary attendance crud operation end

    //Salary attendance crud operation start
    Route::any('/hrm-attendance-log-create', [AttendanceLogController::class, 'index'])->name('hrm.attendancelog.index');

    Route::any('/notification-status', [DashboardController::class, 'notification'])->name('notification.status');
    //Salary attendance crud operation end

    //Salary attendance crud operation start
    Route::any('/hrm-salarysheet-log-create', [SalarySheetControlller::class, 'index'])->name('hrm.salarysheetlog.index');
    //Salary attendance crud operation end

    //Employee Transfer start
    Route::name('employee.')->prefix('employee')->group(function () {
        Route::get('/list', [SupportTicketController::class, 'index'])->name('index');
    });

    //sync mikrotik
    Route::get('/runSchedul', [RunFunController::class, 'runScheduler'])->name('runSchedul');
    Route::post('/add-Mac-Address', [RunFunController::class, 'addMacAddress'])->name('add.mac.address');


    Route::name('project.')->prefix('project')->group(function () {
        Route::get('/list', [ProjectController::class, 'index'])->name('index');
        Route::get('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/store', [ProjectController::class, 'store'])->name('store');
        route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('edit');
        route::get('/show/{id}', [ProjectController::class, 'show'])->name('show');
        route::put('/update/{id}', [ProjectController::class, 'update'])->name('update');
        route::delete('/destroy/{id}', [ProjectController::class, 'destroy'])->name('destroy');
    });

    Route::name('task.')->prefix('task')->group(function () {
        Route::get('/list', [TaskController::class, 'index'])->name('index');
        Route::get('/create', [TaskController::class, 'create'])->name('create');
        Route::post('/store', [TaskController::class, 'store'])->name('store');
        route::get('/edit/{id}', [TaskController::class, 'edit'])->name('edit');
        route::get('/show/{id}', [TaskController::class, 'show'])->name('show');
        route::put('/update/{id}', [TaskController::class, 'update'])->name('update');
        route::delete('/destroy/{id}', [TaskController::class, 'destroy'])->name('destroy');
        Route::delete('task-message/{id}', [TaskController::class, 'taskmessage_destory'])->name('task-message.destroy');

        route::get('/mytasks', [MytaskController::class, 'index'])->name('mytask');
    });
});

Route::prefix('bandwidthcustomer')->name('bandwidthcustomer.')->namespace('Admin')->middleware(['customerAuth'])->group(function () {
    //optimize Start
    Route::name('optimize.')->prefix('optimize')->group(function () {
        Route::get('/list', [CustomerResellerOptimizeController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [CustomerResellerOptimizeController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [CustomerResellerOptimizeController::class, 'create'])->name('create');
        Route::get('/edit/{optimize:id}', [CustomerResellerOptimizeController::class, 'edit'])->name('edit');
        Route::post('/store', [CustomerResellerOptimizeController::class, 'store'])->name('store');
        Route::get('/show/{optimize:id}', [CustomerResellerOptimizeController::class, 'show'])->name('show');
        Route::get('/update/{optimize:id}', [CustomerResellerOptimizeController::class, 'update'])->name('update');
    });

    Route::name('upgradation.')->prefix('upgradation')->group(function () {
        Route::get('/list', [CustomerResellerUpgradationController::class, 'index'])->name('index');
        Route::get('/create', [CustomerResellerUpgradationController::class, 'create'])->name('create');
        Route::get('/edit/{upgradation:id}', [CustomerResellerUpgradationController::class, 'edit'])->name('edit');
        Route::post('/store', [CustomerResellerUpgradationController::class, 'store'])->name('store');
        Route::get('/show/{upgradation:id}', [CustomerResellerUpgradationController::class, 'show'])->name('show');
        Route::put('/update/{upgradation:id}', [CustomerResellerUpgradationController::class, 'update'])->name('update');
    });

    Route::name('downgrading.')->prefix('downgrading')->group(function () {
        Route::get('/list', [CustomerResellerDowngradingController::class, 'index'])->name('index');
        Route::get('/create', [CustomerResellerDowngradingController::class, 'create'])->name('create');
        Route::post('/store', [CustomerResellerDowngradingController::class, 'store'])->name('store');
        Route::get('/show/{downgradation:id}', [CustomerResellerDowngradingController::class, 'show'])->name('show');
        Route::get('/update/{downgradation:id}', [CustomerResellerDowngradingController::class, 'update'])->name('update');
        Route::get('/update/{downgradation:id}', [CustomerResellerDowngradingController::class, 'update'])->name('update');
    });

    Route::name('capuncap.')->prefix('capuncap')->group(function () {
        Route::get('/list', [CustomerResellerCapUncapController::class, 'index'])->name('index');
        Route::get('/create', [CustomerResellerCapUncapController::class, 'create'])->name('create');
        Route::post('/store', [CustomerResellerCapUncapController::class, 'store'])->name('store');
        Route::get('/show/{capuncap:id}', [CustomerResellerCapUncapController::class, 'show'])->name('show');
        Route::get('/update/{capuncap:id}', [CustomerResellerCapUncapController::class, 'update'])->name('update');
        Route::get('/update/{capuncap:id}', [CustomerResellerCapUncapController::class, 'update'])->name('update');
    });


    //Bandwidth Sale Invoice start
    Route::name('bandwidthsaleinvoice.')->prefix('bandwidthsaleinvoice')->group(function () {
        Route::get('/list', [CustomerBandwidthSaleInvoiceController::class, 'index'])->name('index');
        Route::get('/dataProcessing', [CustomerBandwidthSaleInvoiceController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/invoice/{banseidthsaleinvoice:id}', [CustomerBandwidthSaleInvoiceController::class, 'invoice'])->name('invoice');
    });
    //Bandwidth Sale Invoice end


    //Support Ticket Sale Invoice start
    Route::name('supportticket.')->prefix('supportticket')->group(function () {
        Route::get('/list/{id?}', [CustomerSupportTicketController::class, 'index'])->name('index');
        Route::get('/dataProcessing/{id?}', [CustomerSupportTicketController::class, 'dataProcessing'])->name('dataProcessing');
        Route::get('/create', [CustomerSupportTicketController::class, 'create'])->name('create');
        Route::post('/store', [CustomerSupportTicketController::class, 'store'])->name('store');
        Route::get('/invoice/{supportticket:id}', [CustomerSupportTicketController::class, 'invoice'])->name('invoice');
        Route::get('/edit/{supportticket:id}', [CustomerSupportTicketController::class, 'edit'])->name('edit');
        Route::post('/update/{supportticket:id}', [CustomerSupportTicketController::class, 'update'])->name('update');
        Route::get('/delete/{supportticket:id}', [CustomerSupportTicketController::class, 'destroy'])->name('destroy');
        Route::get('/user-Details', [CustomerSupportTicketController::class, 'userDetails'])->name('userdetails');
        Route::get('/assign/{supportticket:id}', [CustomerSupportTicketController::class, 'assign'])->name('assign');
        Route::get('/status/{supportticket:id}', [CustomerSupportTicketController::class, 'status'])->name('status');
        Route::post('/status-update/{supportticket:id}', [CustomerSupportTicketController::class, 'statusupdate'])->name('statusupdate');
    });
    //Support Ticket Sale Invoice end


});


require __DIR__ . '/auth.php';
