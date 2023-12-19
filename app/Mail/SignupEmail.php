<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SignupEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $email_data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->email_data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->markdown('emails.emailRegister',['email_data'=>$this->email_data])->subject('Email verification OTP - '.env('APP_NAME'));
    }
}
