<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Notification extends Mailable
{
    use Queueable, SerializesModels;

    public $form;
    public $name;
    public $mess;
    public $subject;

    public function __construct($form,$name,$mess,$subject)
    {
        $this->form = $form;
        $this->name = $name;
        $this->mess = $mess;
        $this->subject = $subject;
    }

    public function build()
    {
        $form = $this->form;
        $name = $this->name;
        $mess = $this->mess;
        $subject = $this->subject;

        return $this->view('admin.pages.bandwidthsale.bandwidthsaleinvoice.notification', compact('name',"mess"))
            ->from($form, $name)->subject($subject);
    }
}
