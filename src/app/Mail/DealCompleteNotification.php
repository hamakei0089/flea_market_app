<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DealCompleteNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $item;
    /**
     * Create a new message instance.
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    public function build()
    {
        return $this->subject('【取引完了通知】')
                    ->view('emails.deal_complete')
                    ->with(['item' => $this->item]);
    }

}
