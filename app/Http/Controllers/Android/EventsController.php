<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\AcademicYear;

class EventsController extends Controller
{
    //

    public function eventsList(Request $req){
        $ay = AcademicYear::where('active', 1)->first();

        $data = Event::where('event', 'like', $req->event . '%')
            ->where('academic_year_id', $ay->academic_year_id)
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
        return $req;
    }

    
}
