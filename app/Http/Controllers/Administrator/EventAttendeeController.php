<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventAttendee;

class EventAttendeeController extends Controller
{
    //

    public function index($eventId){
        return view('administrator.event_attendee.event-attendee-index')
            ->with('eventId', $eventId);
    }

    public function getEventAttendees(Request $req){
        $sort = explode('.', $req->sort_by);

        $event = EventAttendee::with(['event', 'user'])
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $event;
    }


    public function approveAttendee($id){
        $data = EventAttendee::find($id);
        $data->status = 1;
        $data->date_mark = date('Y-m-d');
        $data->save();

        return response()->json([
            'status' => 'approved'
        ], 200);
    }

    public function declineAttendee($id){
        $data = EventAttendee::find($id);
        $data->status = 2;
        $data->date_mark = date('Y-m-d');
        $data->save();

        return response()->json([
            'status' => 'declined'
        ], 200);
    }
}
