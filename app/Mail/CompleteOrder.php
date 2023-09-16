<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompleteOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $order)
    {
        $this->user = $user;
		$this->order = $order;
	
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$user = $this->user;
	    $order = $this->order ;

        return $this->subject('Your Order ID #'.$this->order->id.' is Complete!')
                    ->markdown('emails.completeOrder', compact('user', 'order'));
    }
}
