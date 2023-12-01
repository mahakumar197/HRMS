<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class attendsuperadmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $details;
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->view('mail.attendance_superadmin')->subject('List Of Employee Not Marked Attendance - '.$this->details[2]. ' | '.$this->details[1])->with(['attend_not_marked' => $this->details[0],'date'=>$this->details[1]]);
    }
}
