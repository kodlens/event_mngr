<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\AcademicYear;
use App\Models\EventAttendance;
use App\Models\User;


class EventsController extends Controller
{
    //

    public function eventsList(Request $req){
        $ay = AcademicYear::where('active', 1)->first();

        $data = Event::where('event', 'like', $req->event . '%')
            ->where('academic_year_id', $ay->academic_year_id)
            ->where('approval_status', 1)
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
        
        return $user;
    }




    public function checkIfOpen($eventId){
        $data = Event::where('event_id', $eventId)
            ->where('is_open', 1)
            ->count();
        return $data;
    }




    
}
