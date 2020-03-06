<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Meeting;
use App\User;
use App\Cell;

class MeetingSchedueled extends Mailable
{
    use Queueable, SerializesModels;

    public $meeting;
    public $member;
    public $cell;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Meeting $meeting, User $member, Cell $cell)
    {
        $this->meeting = $meeting;
        $this->member = $member;
        $this->cell = $cell;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("platform@ecdh.ma")
                    ->subject("[ECDH] New Meeting Scheduled")
                    ->view('emails.meeting_scheduled');
    }
}
