<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;


class ResetPasswordSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $year;
    public $now;
    public $to;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        // set up variables for blade template
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
        return $this->markdown('emails.resetpasswordsuccess');
    }
}
