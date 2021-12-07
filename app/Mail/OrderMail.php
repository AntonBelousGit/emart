<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $order_info;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order,$order_info)
    {
        $this->order = $order;
        $this->order_info = $order_info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.order');
    }
}
