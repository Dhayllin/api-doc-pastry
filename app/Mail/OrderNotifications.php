<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Product;

class OrderNotifications extends Mailable
{
    use Queueable, SerializesModels;

    private $product;
    private $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($product, $customer)
    {
        $this->product = $product;
        $this->customer = $customer;
    }


    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this
                ->subject('Pedidos')
                ->view('mail.products.product-notification',['products' => $this->product,'customer' => $this->customer['name']]);
    }
}
