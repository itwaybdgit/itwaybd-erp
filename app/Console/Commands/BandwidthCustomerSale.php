<?php

namespace App\Console\Commands;

use App\Models\BandwidthCustomer;
use App\Models\BandwidthSaleInvoice;
use Illuminate\Console\Command;

class BandwidthCustomerSale extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bandwidth:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
    $bandwidthcustomer = BandwidthCustomer::get();
    foreach($bandwidthcustomer as $value){
    $bandwidthsaleinvoice = BandwidthSaleInvoice::where('customer_id',$value->id)->whereMonth('billing_month',date("m"))->whereYear('billing_month',date("Y"))->orderBy('id',"desc")->first();

      if($bandwidthsaleinvoice){

      }else{
        $model = new BandwidthSaleInvoice();
        $purchaseLastData = BandwidthSaleInvoice::latest('id')->pluck('id')->first() ?? "0";
        $invoice_no = 'BS' . str_pad($purchaseLastData + 1, 5, "0", STR_PAD_LEFT);
        $valideted['invoice_no'] = $invoice_no;
        $valideted['billing_month'] = date("m-Y");
        $valideted['due'] = 0;
        $valideted['total'] = 0;
        $valideted['created_by'] = auth()->id();
        $bandwidthsaleinvoice = $model->getModel()->create($valideted);
        // dd($bandwidthsaleinvoice);

        foreach($value->package as $item){

            $details[] = [
                'bandwidth_sale_invoice_id' => $bandwidthsaleinvoice->id,
                'item_id' => $item->item_id,
                'description' => $item->description,
                'unit' => $item->unit,
                'qty' => $item->qty,
                'rate' => $item->rate,
                'vat' => $item->vat,
                'from_date' => date('Y-m-d'),
                'to_date' => "",
                'total' => $request->total[$i],
            ];
        }

        $this->getModel()->detaile()->insert($details);
      }
    }

        throw new \Exception("Opps");
    }
}
