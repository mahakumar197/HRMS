<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class new_candidate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $new_can;
    public function __construct($new_can)
    {
         $this->new_can = $new_can;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.new_can')->subject('New Candidate Created '.$this->new_can['can_name'])->with(['new_can' => $this->new_can]);
    }
}
