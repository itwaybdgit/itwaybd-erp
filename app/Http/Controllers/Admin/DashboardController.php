<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Notification;
use App\Models\AccountTransaction;
use App\Models\BandwidthCustomer;
use App\Models\BandwidthCustomerPackage;
use App\Models\BandwidthSaleInvoice;
use App\Models\Billing;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\LeadGeneration;
use App\Models\MacReseller;
use App\Models\Product;
use App\Models\ResellerCapUncap;
use App\Models\ResellerDiscontinue;
use App\Models\ResellerDowngradation;
use App\Models\ResellerNIRequest;
use App\Models\ResellerOptimize;
use App\Models\ResellerUpgradation;
use App\Models\Supplier;
use App\Models\SupportCategory;
use App\Models\SupportStatus;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $macsallers = MacReseller::count();
        $employeecheck = auth()->user()->employee;

        $disconnect = ResellerDiscontinue::where('confirm_bill_approve', 2)->pluck('customer_id');
        $bandwith_clients = BandwidthCustomer::whereIn('level_confirm', ["2", '3', '4'])->whereNotIn('id', $disconnect)->count();
        $pendingcustomer = BandwidthCustomer::orWhere('sales_approve', '0')->orWhere('legal_approve', '0')->orWhere('transmission_approve', '0')->orWhere('noc_approve', '0')->orWhere('noc2_approve', '0')->orWhere('billing_approve', '0')->orWhere('level_confirm', Null)->orWhere('level_confirm', 1)->count();
        $monthbillgenerate = 0;

        $monthlydeu = AccountTransaction::where('type', 5)
            ->whereNotIn('account_id', [5, 14])
            ->whereYear('created_at', '=', now()->year)
            ->whereMonth('created_at', '=', now()->month)
            ->selectRaw('sum(debit) as debit, sum(credit) as credit')
            ->first();

        // Calculate the difference
        $differencedeu = $monthlydeu->credit - $monthlydeu->debit;

        $monthlycollected = AccountTransaction::where('type', 5)
            ->whereNotIn('account_id', [5, 14])
            ->whereYear('created_at', '=', now()->year)
            ->whereMonth('created_at', '=', now()->month)
            ->selectRaw('sum(debit) as debit')
            ->first();

        // Get the sum of debit
        $differencecollected = $monthlycollected->debit;

        $optimizelist = ResellerOptimize::where('status', 'pending')->get()->count();
        $discontinuelist = ResellerDiscontinue::where('status', 'pending')->get()->count();
        $upgradtionlist = ResellerUpgradation::where('status', 'pending')->get()->count();
        $downgradtionlist = ResellerDowngradation::where('status', 'pending')->get()->count();
        $reselleruncap = ResellerCapUncap::where('status', 'pending')->get()->count();

        //Tx Planning

        $txplanning = BandwidthCustomer::where('noc_approve', "0")->where('billing_approve', "1")->where('reject_sales_approve', "0")->count();
        $optimizelist_txplanning = ResellerOptimize::where('tx_pluning_head_approve', 1)->count();
        $discontinuelist_txplanning = ResellerDiscontinue::where('tx_pluning_head_approve', 1)->count();
        $upgradtionlist_txplanning = BandwidthCustomer::where('noc_approve', 2)->count();
        $downgradtionlist_txplanning = BandwidthCustomer::where('noc_approve', 3)->count();

        //Transmission

        $transmission = BandwidthCustomer::where('transmission_approve', "0")->where('noc_approve', "1")->where('reject_sales_approve', "0")->count();
        $optimizelist_transmission = ResellerOptimize::where('transmission_head_approve', 1)->count();
        $nirequest_transmission = ResellerOptimize::where('transmission_head_approve', 1)->count();
        $discontinuelist_transmission = ResellerDiscontinue::where('transmission_head_approve', 1)->count();

        //Level3

        $level3 = BandwidthCustomer::whereNull('level_confirm')->where('noc2_approve', "1")->count();
        $level3ResellerOptimize = ResellerOptimize::where('level_3_approve', 1)->count();
        $level3nirequest = ResellerOptimize::where('tx_pluning_head_approve', 1)->count();
        $level3Discontinue = ResellerDiscontinue::where('level_3_approve', 1)->count();
        $level3upgradtion = BandwidthCustomer::where('noc2_approve', '2')->count();
        $level3Downgradtion = BandwidthCustomer::where('noc2_approve', '3')->count();
        $level3uncap = ResellerCapUncap::where('level3_approve', '1')->count();
        $level3cap = ResellerCapUncap::where('level3_approve', '3')->count();

        //level2
        $level2 = BandwidthCustomer::where('assign_to', "2")->whereNull('level_confirm')->count();
        $level1 = BandwidthCustomer::where('assign_to', "1")->whereNull('level_confirm')->count();

        //level4
        $level4 = BandwidthCustomer::where('transmission_approve', '1')->where('noc2_approve', "0")->where('reject_sales_approve', "0")->count();
        $level4uncap = ResellerCapUncap::where('level4_approve', "1")->count();
        $level4cap = ResellerCapUncap::whereDate('apply_date', '<=', today())
            ->whereTime('apply_date', '<=', now())
            ->where('level4_approve', '!=', 3)->count();

        $saleinvoice = BandwidthSaleInvoice::with('detaile')->where('billing_month', date('F Y'))->get();

        $monthbillgenerate += $saleinvoice->sum('total');

        if ($employeecheck) {
            if (check_access("team_leader")) {
                $disconnect = ResellerDiscontinue::where('confirm_bill_approve', 2)->whereIN('created_by', under_team_leader())->pluck('customer_id');
                $bandwith_clients = BandwidthCustomer::whereIn('level_confirm', ["2", '3', '4'])->whereNotIn('id', $disconnect)->whereIN('created_by', under_team_leader())->count();
                $pendingcustomer = BandwidthCustomer::where(function ($query) {
                    foreach (['sales_approve', 'legal_approve', 'transmission_approve', 'noc_approve', 'noc2_approve', 'billing_approve', "level_confirm"] as $column) {
                        if ("level_confirm" == $column) {
                            $query->orWhere($column, Null)->orWhere('level_confirm', 1);
                        } else {
                            $query->orWhere($column, '0');
                        }
                    }
                })->whereIN('created_by', under_team_leader())->count();
                $approve = ResellerOptimize::where('status', 'pending')->whereIN('created_by', under_team_leader())->count();
                $upgradtionapprove = ResellerUpgradation::where('status', 'pending')->whereIN('created_by', under_team_leader())->count();
                $downgradtionapprove = ResellerDowngradation::where('status', 'pending')->whereIN('created_by', under_team_leader())->count();
                $reselleruncap = ResellerCapUncap::where('status', 'pending')->whereIN('created_by', under_team_leader())->count();
                $resellernirequest = ResellerNIRequest::where('status', 'pending')->whereIN('created_by', under_team_leader())->count();
            }

            if (check_access("Sales")) {
                $pendingcustomer = BandwidthCustomer::where(function ($query) {
                    foreach (['sales_approve', 'legal_approve', 'transmission_approve', 'noc_approve', 'noc2_approve', 'billing_approve', "level_confirm"] as $column) {
                        if ("level_confirm" == $column) {
                            $query->orWhere($column, Null)->orWhere('level_confirm', 1);
                        } else {
                            $query->orWhere($column, '0');
                        }
                    }
                })->where('created_by', auth()->user()->id)->count();
                $disconnect = ResellerDiscontinue::where('confirm_bill_approve', 2)->where('created_by', auth()->user()->id)->pluck('customer_id');
                $bandwith_clients = BandwidthCustomer::whereIn('level_confirm', ["2", '3', '4'])->whereNotIn('id', $disconnect)->where('created_by', auth()->user()->id)->count();

                $optimizelist = ResellerOptimize::where('created_by',  auth()->user()->id)->get()->count();
                $discontinuelist = ResellerDiscontinue::where('created_by', auth()->user()->id)->get()->count();
                $upgradtionlist = ResellerUpgradation::where('created_by',  auth()->user()->id)->get()->count();
                $downgradtionlist = ResellerDowngradation::where('created_by', auth()->user()->id)->get()->count();
                $reselleruncap = ResellerCapUncap::where('created_by',  auth()->user()->id)->get()->count();
                $resellernirequest = ResellerNIRequest::where('created_by',  auth()->user()->id)->get()->count();
                $pendingCustomer = BandwidthCustomer::where(function ($query) {
                    foreach (['sales_approve', 'legal_approve', 'transmission_approve', 'noc_approve', 'noc2_approve', 'billing_approve', "level_confirm"] as $column) {
                        if ("level_confirm" == $column) {
                            $query->orWhere($column, Null)->orWhere('level_confirm', 1);
                        } else {
                            $query->orWhere($column, '0');
                        }
                    }
                })
                    ->where('created_by',  auth()->user()->id)
                    ->count();
            }

            if (!check_access("team_leader") && !check_access("Sales")) {
                $pendingcustomer = BandwidthCustomer::orWhere('sales_approve', '0')->orWhere('legal_approve', '0')->orWhere('transmission_approve', '0')->orWhere('noc_approve', '0')->orWhere('noc2_approve', '0')->orWhere('billing_approve', '0')->orWhere('level_confirm', Null)->orWhere('level_confirm', 1)->count();

                $disconnect = ResellerDiscontinue::where('confirm_bill_approve', 2)->pluck('customer_id');
                $bandwith_clients = BandwidthCustomer::whereIn('level_confirm', ["2", '3', '4'])->whereNotIn('id', $disconnect)->count();
            }
        }

        // THis month
        $monthlyAmount = BandwidthCustomerPackage::where('billing_frequency', 'MONTHLY')->whereMonth('payment_date_monthly', date('m'))->whereYear('payment_date_monthly', date('Y'))->sum('rate');
        $yearAmount = BandwidthCustomerPackage::where('billing_frequency', 'YEARLY')->whereMonth('payment_date_yearly', date('m'))->whereYear('payment_date_yearly', date('Y'))->sum('rate');

        // $billings = $billingModel->where('company_id', auth()->user()->company_id)->where('date_', today()->format('d-m-Y'))->get();


        //task 

        $tasks = auth()->user()->is_admin == 1
            ? Task::all()
            : Task::where('user_id', auth()->user()->id)->get();


        return view('admin.pages.dashboard', get_defined_vars());
    }

    public function customerInfo()
    {
        $headerTitle = "Active Customer in mikrotik";
        $customers = Customer::where('company_id', auth()->user()->company_id)->where('disabled', 'false')->where('billing_status_id', 5)->paginate(100);
        return view('admin.dashboard.customerInfo', get_defined_vars());
    }

    public function lead_details()
    {
        $leadpending = LeadGeneration::count();
        $leadconfirm = LeadGeneration::where("status", "1")->count();
        $salesperson = Employee::where('type', "LIKE", "%team_leader%")->orWhere('type', "LIKE", "%Sales%")->get();
        return view('admin.dashboard.lead_details', get_defined_vars());
    }

    public function ticketlist()
    {
        $supportstatus = SupportStatus::get();
        $supportTicket = SupportTicket::get();
        $supportcategory = SupportCategory::pluck("name")->toArray();

        $employees = Employee::where(function ($quert) {
            $quert->orWhere("type", "LIKE", "%level_1%");
            $quert->orWhere("type", "LIKE", "%level_2%");
            $quert->orWhere("type", "LIKE", "%level_3%");
            $quert->orWhere("type", "LIKE", "%level_4%");
        })->get(["id", "name", "user_id"]);

        $arraydara = [];
        $categoryarray = [];
        $sporch = SupportStatus::pluck("name")->toArray();

        foreach ($supportstatus as $val) {
            $arraydara[] = ticket_count($val->id);
        }

        foreach (SupportCategory::get() as $val) {
            $categoryarray[] = cateogry_type_count($val->id);
        }
        return view('admin.dashboard.ticketinfoD', get_defined_vars());
    }

    public function customerInactive()
    {
        $headerTitle = "Inactive Customer in mikrotik";
        $customers = Customer::where('company_id', auth()->user()->company_id)->where('disabled', 'true')->paginate(100);
        return view('admin.dashboard.customerInfo', get_defined_vars());
    }

    public function newcustomer()
    {
        $headerTitle = "New Customer";
        $customers = Customer::where('company_id', auth()->user()->company_id)->whereMonth('created_at', today()->format('m-Y'))->paginate(100);
        return view('admin.dashboard.customerInfo', get_defined_vars());
    }

    public function TodayCollectedBill(Request $req)
    {
        $headerTitle = "Today Collected Bill Customer";
        $employees = User::where('company_id', auth()->user()->company_id)->whereIn('is_admin', [4, 5])->get();
        $user = $req->employee_id;
        $date = date('Y-m-d') ??  $req->searchPayment;
        // dd($date);
        $tableid = AccountTransaction::where('company_id', auth()->user()->company_id)->where('type', 4)->whereDate('created_at', $date);
        if ($user) {
            $tableid = $tableid->where('created_by', $user);
        }
        $tableid = $tableid->pluck('table_id');
        $billings = Billing::with('getCustomer')->whereIn('id', $tableid)->get();
        return view('admin.dashboard.customerbilling', get_defined_vars());
    }

    protected function getModel()
    {
        return new Billing();
    }

    protected function paidtableColumnNames()
    {
        return [
            [
                'label' => 'ID',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'User Name',
                'data' => 'username',
                'customesearch' => 'customer_id',
                'searchable' => false,
                'relation' => 'getCustomer',
            ],
            [
                'label' => 'Billing Month',
                'data' => 'date_',
                'searchable' => false,
            ],
            [
                'label' => 'EXP Date',
                'data' => 'exp_date',
                'searchable' => false,
                'relation' => 'getCustomer',
            ],
            [
                'label' => 'Customer Phone',
                'data' => 'phone',
                'searchable' => false,
                'relation' => 'getCustomer',
            ],
            [
                'label' => 'Customer Profile',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'getProfile',
            ],

            [
                'label' => 'Customer Billing Amount',
                'data' => 'pay_amount',
                'searchable' => false,
            ],

            [
                'label' => 'Billing Status',
                'data' => 'status',
                'searchable' => false,
            ],

            // [
            //     'label' => 'Action',
            //     'data' => 'action',
            //     'class' => 'text-nowrap',
            //     'orderable' => false,
            //     'searchable' => false,
            // ],

        ];
    }

    protected function tableColumnNames()
    {
        return [
            [
                'label' => 'ID',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'User Name',
                'data' => 'username',
                'customesearch' => 'customer_id',
                'searchable' => false,
                'relation' => 'getCustomer',
            ],
            // [
            //     'label' => 'Customer',
            //     'data' => 'name',
            //     'searchable' => false,
            //     'relation' => 'getCustomer',
            // ],
            [
                'label' => 'Billing Month',
                'data' => 'date_',
                'searchable' => false,
            ],
            [
                'label' => 'EXP Date',
                'data' => 'exp_date',
                'searchable' => false,
                'relation' => 'getCustomer',
            ],
            [
                'label' => 'Customer Phone',
                'data' => 'customer_phone',
                'searchable' => false,
            ],
            [
                'label' => 'Customer Profile',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'getProfile',
            ],

            [
                'label' => 'Customer Billing Amount',
                'data' => 'customer_billing_amount',
                'searchable' => false,
            ],
            [
                'label' => 'Billing Status',
                'data' => 'status',
                'searchable' => false,
            ],

            // [
            //     'label' => 'Action',
            //     'data' => 'action',
            //     'class' => 'text-nowrap',
            //     'orderable' => false,
            //     'searchable' => false,
            // ],

        ];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function totalCollectedBill()
    {
        $page_title = "Collected Bill";
        $page_heading = "Collected Bill List";
        $ajax_url = route('totalCollectedBill.dataprocess');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->paidtableColumnNames()
        );
        $customers = Customer::where('company_id', auth()->user()->company_id)->where('billing_status_id', 5)->get();
        return view('admin.dashboard.totalCollectedBill', get_defined_vars());
    }

    public function totalpaindingBill()
    {
        $page_title = "Due Bill";
        $page_heading = "Due Bill List";
        $ajax_url = route('totalpaindingBill.data');
        $is_show_checkbox = false;
        // $paymentmethods = PaymentMethod::where('status', 'active')->get();
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        $customers = Customer::where('company_id', auth()->user()->company_id)->get();
        return view('admin.dashboard.totalpaindingBill', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function totalpaindingBilldataProcessing()
    {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->where('company_id', auth()->user()->company_id)
                ->whereIn('status', ['unpaid', 'partial'])->orderBy('id', 'desc'),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            true,
            []

        );
    }

    public function dataProcessing()
    {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->where('company_id', auth()->user()->company_id)
                ->whereIn('status', ['paid', 'partial']),
            //Table Columns Name
            $this->paidtableColumnNames(),
            //Route name
            true,
            []

        );
    }

    function invoice($dm, $id)
    {
        $billing = Billing::with(['company', 'getCustomer'])->find($id);
        $amount = (($billing->customer_billing_amount ?? 0) - ($billing->pay_amount ?? 0));
        return view('invoice', get_defined_vars());
    }


    function notification()
    {
        $notification = \App\Models\Notification::where('is_view', 0)
            ->where('user_id', auth()->id())
            ->orderBy('id', "desc")
            ->whereDate('created_at', date('Y-m-d'))
            ->get();

        $count = count($notification);
        $html = "";

        foreach ($notification as $value) {
            $html .= '<a class="d-flex" href="' . $value->link . '">
                 <div class="media d-flex align-items-start">
                     <div class="media-left">
                         <div class="avatar"><img src="https://png.pngtree.com/png-vector/20190725/ourmid/pngtree-bell-icon-png-image_1606555.jpg" alt="avatar" width="32" height="32"></div>
                     </div>
                     <div class="media-body">
                         <p class="media-heading"><span class="font-weight-bolder">' . $value->message . '</span></p>
                         <div>
                             <span class="notification-time text-danger">' . $value->created_at->format('M d, Y h:i A') . '</span>
                         </div>
                     </div>
                 </div>
               </a>';
        }

        $data = response()->json(["data" => $html, "count" => $count]);

        return $data;
    }
}
