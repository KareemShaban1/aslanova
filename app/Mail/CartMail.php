<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CartMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cartItems;
    public $customerEmail;
    public $total_data;
    public $location_data;

    public function __construct($cartItems, $customerEmail ,$total_data , $location_data)
    {
        $this->cartItems = $cartItems;
        $this->customerEmail = $customerEmail;
        $this->total_data = $total_data;
        $this->location_data = $location_data;
    }

    public function build()
    {
        return $this->from($this->customerEmail)
                    ->subject('New Cart Order')
                    ->view('emails.cart')
                    ->with([
                        'cartItems' => $this->cartItems,
                        'total_data' => $this->total_data,
                        'location_data' => $this->location_data
                    ]);
    }
}
