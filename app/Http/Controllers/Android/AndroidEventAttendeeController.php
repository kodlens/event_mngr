<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\EventAttendee;

class AndroidEventAttendeeController extends Controller
{
    //

    public function store(Request $req){
    
        $event = Event::find($req->event_id);

        $req->validate([
            'user_id' => ['required'],
            'event_id' => ['required']
        ]);

        $exist = EventAttendee::where('user_id', $req->user_id)
            ->where('event_id', $req->event_id)->exists();

        if($exist){
            return response()->json([
                'errors' => [
                    'message' => ['You already had a previous request.']
                ]
            ], 422);
        }

        EventAttendee::create([
            'user_id' => $req->user_id,
            'event_id' => $req->event_id,
            'date_request' => date('Y-m-d'),
            'status' => $event->is_need_approval == 0 ? 1 : 0,
            'date_mark' => $event->is_need_approval == 0 ? date('Y-m-d') : null
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }
}
