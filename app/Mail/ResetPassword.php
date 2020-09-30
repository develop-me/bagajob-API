<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;


class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $resetUrl;
    public $year;
    public $now;
    public $to;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $resetUrl)
    {
        // set up variables for blade template
        $this->resetUrl = $resetUrl;
        $now = Carbon::now();
        $this->year = $now->year();
        $this->now = $now;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // build email HTML from the markdown blade template
        return $this->markdown('emails.resetpassword');
    }
}
