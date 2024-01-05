<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class ReportEventListController extends Controller
{
    //

    public function index(){
        return view('administrator.report.report-event-list');
    }


    public function loadReportEventLists(Request $req){
        return Event::with(['academic_year', 'user', 'event_type'])
            ->whereDate('event_date_from', '>=', $req->from)
            ->whereDate('event_date_from', '<=', $req->to)
            ->where('approval_status', 1)
            ->get();
    }


}
