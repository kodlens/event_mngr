<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\AcademicYear;
use App\Models\EventAttendance;
use App\Models\EventAttendee;
use App\Models\User;


class EventsController extends Controller
{
    //

    public function eventsList(Request $req){
        $ay = AcademicYear::where('active', 1)->first();
        $userId = $req->id;

        $data = Event::where('event', 'like', $req->event . '%') 
            ->where('academic_year_id', $ay->academic_year_id)
            ->where('approval_status', 1)
            ->orderBy('event_id', 'desc');

        if($userId > 0){
            $data->where('user_id', $userId);
        }
        return $data->get();
    }

    public function loadEvents(Request $req){
        $ay = AcademicYear::where('active', 1)->first();

        $data = Event::where('academic_year_id', $ay->academic_year_id)
            ->where('approval_status', 1)
            ->where('is_archive', 0)
            ->orderBy('event_id', 'desc')
            ->get();

        return response()->json($data);
    }

    public function show($id){

        $data = Event::where('event_id', $id)
            ->first();

        return $data;
    }


    public function submitScanned(Request $req){

        //return $req;
        //first check if this user is registered on the event
        $exist = EventAttendee::where('user_id', $req->user_id)
            ->where('event_id', $req->event_id)
            ->where('status', 1)
            ->exists();

        if(!$exist){
            return response()->json([
                'errors' => [
                    'message' => ['Attendee information is invalid or not yet registered.']
                ]
            ], 422);
        }

        $status = $req->status;
        $timeLog = now();

        $user = User::find($req->user_id);

        EventAttendance::updateOrCreate([
           
            'user_id' => $req->user_id,
            'event_id' => $req->event_id
        ],
        [
            $status => $timeLog,
        ]);
        
        return response()->json([
            'status' => 'saved',
            'user' => $user
        ], 200);;
    }




    public function checkIfOpen($eventId){
        $data = Event::where('event_id', $eventId)
            ->where('is_open', 1)
            ->count();
        return $data;
    }



    
}
