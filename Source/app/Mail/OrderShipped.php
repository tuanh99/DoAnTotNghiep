<?php

namespace App\Mail;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    // use Queueable, SerializesModels;

    // /**
    //  * Create a new message instance.
    //  *
    //  * @return void
    //  */
    
    // public function __construct($orderDetails, $orderUrl)
    // {
    //     // $this->order = $order;
    //     $this->orderDetails = $orderDetails;
    //     $this->orderUrl = $orderUrl;
    // }

    // /**
    //  * Build the message.
    //  *
    //  * @return $this
    //  */
    // public function build()
    // {
    //     // return $this->view('mail.success');
    //     return $this->markdown('mail.success')
    //                 ->with([
    //                     'orderDetails' => $this->orderDetails,
    //                     'orderUrl' => $this->orderUrl
    //                 ]);
    // }

    use Queueable, SerializesModels;

    public $customer;
    public $orderDetails;

    public function __construct(Customer $customer, $orderDetails)
    {
        $this->customer = $customer;
        $this->orderDetails = $orderDetails;
    }

    public function build()
    {
        return $this->markdown('mail.success')->with(['customer' => $this->customer,
                                                    'orderDetails' => $this->orderDetails
    
                                ]);
    }
}
