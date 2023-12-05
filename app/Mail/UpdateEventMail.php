<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdateEventMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     private $oldEvent;
     private $updatedEvent;
     private $newEventVenue;
     private $newEventDate;
     private $newEventFrom;
     private $newEventTo;

    public function __construct($oldEvent, $updatedEvent, $newEventVenue,
            $newEventDate, $newEventFrom, $newEventTo
        )
    {
        //
        $this->oldEvent = $oldEvent;
        $this->updatedEvent = $updatedEvent;
        $this->newEventVenue = $newEventVenue;
        $this->newEventDate = $newEventDate;
        $this->newEventFrom = $newEventFrom;
        $this->newEventTo = $newEventTo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.update-event-email')
            ->with('oldEvent', $this->oldEvent)
            ->with('updatedEvent', $this->updatedEvent)
            ->with('newEventVenue', $this->newEventVenue)
            ->with('newEventDate', $this->newEventDate)
            ->with('newEventFrom', $this->newEventFrom)
            ->with('newEventTo', $this->newEventTo);
    }
}
