<?php

namespace App\Mail\Frontend;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Frontend\Messages\Replies;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageReply extends Mailable
{
    use Queueable, SerializesModels;

    public $reply;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Replies $reply, $subject)
    {
        $this->reply = $reply;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@logicbag.com.bd', 'LogicBag')->subject($this->subject)->markdown('emails.new-message-reply');
    }
}
