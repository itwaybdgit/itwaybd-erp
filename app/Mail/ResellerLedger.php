<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResellerLedger extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $business;
    protected $saleinvoiceid;
    protected $reseller;
    public function __construct($business,$saleinvoiceid,$reseller)
    {
        $this->business = $business;
        $this->saleinvoiceid = $saleinvoiceid;
        $this->reseller = $reseller;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $business = $this->business;
        $saleinvoiceid =  $this->saleinvoiceid;
        $reseller =  $this->reseller;
        return $this->view('admin.pages.reports.reseller.invoice',get_defined_vars())->from($business->email,$business->business_name);
    }
}
