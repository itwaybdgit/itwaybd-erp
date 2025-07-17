<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SaleInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $business;
    public $request;
    public $filename; // Add this property to hold the PDF file path

    public function __construct($business, $request, $filename)
    {
        $this->business = $business;
        $this->request = $request;
        $this->filename = $filename; // Assign the PDF file path
    }

    public function build()
    {
        $business = $this->business;
        $request = $this->request;
        // Attach the PDF file to the email
        return $this->view('admin.pages.bandwidthsale.bandwidthsaleinvoice.mail_invoice_body', compact('business', 'request'))
            ->attach($this->filename) // Attach the PDF file
            ->from($business->email, $business->business_name);
    }
}
