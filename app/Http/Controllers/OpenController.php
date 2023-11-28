<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Department;
use App\Models\Event;
use App\Models\EventType;
use App\Models\EventVenue;

class OpenController extends Controller
{
    //


    public function loadDepartments(){
        return Department::orderBy('code', 'asc')
            ->get();
    }


    public function loadBrowseEvents(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Event::where('event', 'like', $req->event . '%')
            ->where('academic_year_id', $req->ayid)
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }


    public function loadEventTypes(){
        return EventType::orderBy('event_type', 'asc')
            ->get();
    }


    public function loadEventVenues(){
        return EventVenue::orderBy('event_venue', 'asc')
            ->get();
    }
    
}
