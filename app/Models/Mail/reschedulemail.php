<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class reschedulemail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public $intterviewer;
    public function __construct($intterviewer)
    {
        $this->int = $intterviewer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.job-schedule')->subject('Interview Re Scheduled for '.$this->int['round_id'])->with(['js' => $this->int]);
    }
}
