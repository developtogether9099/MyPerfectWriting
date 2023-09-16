<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlaceOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $order_id)
    {
        $this->user = $user;
		$this->order_id = $order_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$user = $this->user;
        return $this->subject('Confirmation of Your Order – ID #'.$this->order_id)
                    ->markdown('emails.placeOrder', compact('user'));
    }
}
