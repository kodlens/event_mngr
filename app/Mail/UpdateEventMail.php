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
     private $newEventDateFrom;
     private $newEventDateTo;
     private $newEventTimeFrom;
     private $newEventTimeTo;

    public function __construct($oldEvent, $updatedEvent, $newEventVenue,
            $newEventDateFrom, $newEventDateTo, $newEventTimeFrom, $newEventTimeTo
        )
    {
        //
        $this->oldEvent = $oldEvent;
        $this->updatedEvent = $updatedEvent;
        $this->newEventVenue = $newEventVenue;
        $this->newEventDateFrom = $newEventDateFrom;
        $this->newEventDateTo = $newEventDateTo;
        $this->newEventTimeFrom = $newEventTimeFrom;
        $this->newEventTimeTo = $newEventTimeTo;
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
            ->with('newEventDateFrom', $this->newEventDateFrom)
            ->with('newEventDateTo', $this->newEventDateTo)
            ->with('newEventTimeFrom', $this->newEventTimeFrom)
            ->with('newEventTimeTo', $this->newEventTimeTo);
    }
}
