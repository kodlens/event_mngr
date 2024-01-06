<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class ReportEventAttendanceController extends Controller
{
    //

    public function index(){
        return view('administrator.event_attendance.report-event-attendance');
    }


    // public function loadReportEventAttendances(Request $req){
    //     return Event::with(['academic_year', 'user', 'event_type'])
    //         ->whereDate('event_datetime', '>=', $req->from)
    //         ->whereDate('event_datetime', '<=', $req->to)
    //         ->where('approval_status', 1)
    //         ->get();
    // }


    public function loadReportEventAttendances(Request $req){
        $data = Event::with('event_attendances.user')
            ->where('event_id', $req->event)
            ->first();

        return $data;
    }


}

