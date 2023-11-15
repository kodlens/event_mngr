<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventAttendance;


class EventAttendanceController extends Controller
{
    //

    public function index(){
        return view('administrator.event_attendance.event-attendance');
    }


    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);

        $event = EventAttendance::with(['event', 'user'])
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $event;
    }
}
