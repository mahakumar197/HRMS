<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobSchedule extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $js;
    public function __construct($js)
    {
        $this->js = $js;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()

    {         
         return $this->view('mail.job-schedule')->subject('Interview Scheduled for - '.$this->js['job_code'] .' | Round - ' .$this->js['round_id'])->with(['js' => $this->js]);
    }
}
