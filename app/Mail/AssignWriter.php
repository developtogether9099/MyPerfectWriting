<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssignWriter extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $order, $writer)
    {
        $this->user = $user;
		$this->order = $order;
		$this->writer = $writer;
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
		$writer = $this->writer;
        return $this->subject('Your Order ID #'.$this->order->id.' is in Good Hands!')
                    ->markdown('emails.assignOrder', compact('user', 'order', 'writer'));
    }
}
