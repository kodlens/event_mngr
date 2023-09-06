<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //


    public function index(){
        return view('administrator.event-page');
    }

    public function getEvents(Request $req){
        $sort = explode('.', $req->sort_by);

        $event = Event::where('event', 'like', $req->event . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $event;
    }

    public function create(){
        return view('administrator.event.event-page-create-edit')
            ->with('id', 0)
            ->with('data', []);
    }

    public function edit($id){
        $event = Event::find($id);
        return view('administrator.event.event-page-create-edit')
            ->with('id', $event->event_id)
            ->with('data', $event);
    }


}
