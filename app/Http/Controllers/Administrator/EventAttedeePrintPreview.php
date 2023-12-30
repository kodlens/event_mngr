<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventAttedeePrintPreview extends Controller
{
    //


    public function eventAttendeePrintPreview($eventId){
   
        $data = Event::with(['academic_year', 'attendees.user',
            'event_type', 'venue'])
            ->where('event_id', $eventId)
            ->first();
        

        return view('administrator.event.event-attendees-print-preview')
            ->with('data', $data);
    }
}
