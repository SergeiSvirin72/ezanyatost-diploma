<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $sender, $thee, $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender, $name, $thee, $message)
    {
        $this->sender = $sender;
        $this->name = $name;
        $this->thee = $thee;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->sender)->subject($this->thee)->markdown('emails.feedback');
    }
}
