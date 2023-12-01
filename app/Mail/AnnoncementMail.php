<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnnoncementMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $announcement;
    public function __construct($announcement)
    {
         $this->announcement = $announcement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        
        
        return $this->view('mail.announcement')->subject($this->announcement['title'])->with(['announcement' => $this->announcement]);
    }
}
