<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //


    public function index(){
        return view('administrator.event.event-page');
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


    public function store(Request $req){

       // return $req;
        $event_date = date('Y-m-d H:i:s', strtotime($req->event_datetime));

        $req->validate([
            'event' => ['required'],
            'event_description' => ['required'],
            'event_datetime' => ['required']
        ]);

        $n = [];
        if($req->hasFile('event_img')) {
            $pathFile = $req->event_img->store('public/events'); //get path of the file
            $n = explode('/', $pathFile); //split into array using /

        }

        Event::create([
            'event' => $req->event,
            'event_description' => $req->event_description,
            'event_datetime' => $event_date,
            'img_path' => $req->hasFile('event_img') ? $n[2] : ''
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function updateEvents(Request $req, $id){

    }



    public function destroy($id){

        Event::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }



}
