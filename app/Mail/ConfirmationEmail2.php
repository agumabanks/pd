<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $confirmationLink;

    public function __construct($user, $confirmationLink)
    {
        $this->user = $user;
        $this->confirmationLink = $confirmationLink;
    }

    public function build()
    {
        return $this->subject('Validate Your Email')
                    ->view('emails.confirmation')
                    ->with([
                        'user' => $this->user,
                        'confirmationLink' => $this->confirmationLink,
                    ]);
    }
}