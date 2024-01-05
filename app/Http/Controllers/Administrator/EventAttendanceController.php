<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventAttendance;
use App\Models\Event;

class EventAttendanceController extends Controller
{
    //

    public function index($id){
        $data = Event::find($id);
        return view('administrator.event_attendance.event-attendance')
            ->with('id', $id)
            ->with('data', $data);
    }


    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);

        $event = EventAttendance::with(['event', 'user'])
            ->whereHas('user', function($q) use ($req){
                $q->where('lname', 'like', $req->lname . '%');
            })
            ->where('event_id', $req->event)
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $event;
    }


    public function getReportEventEvaluations(Request $req){
        
    }


    
}
