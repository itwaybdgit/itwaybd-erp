<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Helpers\DataProcessingFile\BtrcReportDataProcessing;
use App\Helpers\TeamDataProcessing;
use App\Models\BandwidthCustomer;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Team;

class TeamPersonReportController extends Controller
{
    /**
     * String property
     */
    use TeamDataProcessing;
    protected $routeName =  'reports';
    protected $viewName =  'admin.pages.reports';

    protected function getModel()
    {
        return new BandwidthCustomer();
    }

    function itemlist() {
         $bandwidth = Item::get();
         $localbandwidth = [];
         $localbandwidthlocal = [];
         foreach($bandwidth as $item){
            $loca = [
                  [
                  'label' => $item->name . " Qty",
                  'qty' => $item->id,
                  'data' => $item->id . "_qty",
                  'searchable' => true,
                  ],
                  [
                  'label' => $item->name,
                  'value' => $item->id,
                  'data' => $item->id . "_value",
                  'searchable' => true,
                  ]
              ];
            array_push($localbandwidth,$loca);
         }
          foreach($localbandwidth as $value){
           foreach($value as $mainvalue){
            array_push($localbandwidthlocal,$mainvalue);
           }
          }
          return $localbandwidthlocal;
    }

    protected function tableColumnNames()
    {
        $local = [
            [
                'label' => "SL.",
                'data' => "id",
                'searchable' => false,
            ],
            [
                'label' => "Date",
                'data' => "created_at",
                'searchable' => true,
            ],
            [
                'label' => "Company",
                'data' => "company_name",
                'searchable' => true,
            ],
            [
                'label' => "Owner",
                'data' => "company_owner_name",
                'searchable' => true,
            ],
        ];

        $array2 = array_merge($local,$this->itemlist());

       return array_merge($array2,[
        [
            'label' => "Kam",
            'data' => "name",
            'searchable' => false,
            'relation' => "kam",
        ],
         [
        'label' => "Amount",
        'data' => "amount",
        'searchable' => false,
         ]
        ]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Team Person Report";
        $page_heading = "Team Person Report";
        $ajax_url = route($this->routeName . '.teamperson.dataProcessing');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        $employeecheck = auth()->user()->employee;
        if($employeecheck){
            if(check_access("team_leader")){
                $employees = Employee::whereIn('user_id',under_team_leader())->get();
            }

            if(check_access("Sales")){
                $employees = Employee::where('user_id',auth()->user()->id)->get();
            }

            if(!check_access("team_leader") && !check_access("Sales")){
                $employees = Employee::where('type',"LIKE","%team_leader%")->orWhere('type',"LIKE","%Sales%")->get();
            }
        }else{
            $employees = Employee::where('type',"LIKE","%team_leader%")->orWhere('type',"LIKE","%Sales%")->get();
        }
        $tablecount =  count($this->tableColumnNames()) - 3;
        $extracolumn =  $this->itemlist();
        return view('admin.pages.reports.salesreport.teamperson', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function teamdataProcessing(Request $request)
    {
        $model = $this->getModel();
        if(request('columns.1.search.value') != "all"){
            $model = $model->where('created_by', request('columns.1.search.value') ?? 0);
        }
        $model = $model->whereDate('created_at', ">=" ,request('columns.2.search.value') ?? date('Y-m-d'))->whereDate('created_at', "<=" ,request('columns.3.search.value') ?? date('Y-m-d'));
        return $this->getDataResponse(
            //Model Instance
            $model,
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName
        );
    }
}
