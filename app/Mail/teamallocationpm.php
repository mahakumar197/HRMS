<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class teamallocationpm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $teamdetail;
    public function __construct( $teamdetail)
    {
        $this->teamdetail = $teamdetail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        
        return $this->view('mail.teamallocation')->subject('New Joinee to your team -'. $this->teamdetail['name'].' '.$this->teamdetail['last_name'])->with(['teamdetail'=> $this->teamdetail]);
    }
}
