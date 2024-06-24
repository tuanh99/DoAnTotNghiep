<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public function __construct($orderDetails, $orderUrl)
    {
        // $this->order = $order;
        $this->orderDetails = $orderDetails;
        $this->orderUrl = $orderUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('mail.success');
        return $this->markdown('mail.success')
                    ->with([
                        'orderDetails' => $this->orderDetails,
                        'orderUrl' => $this->orderUrl
                    ]);
    }
}
