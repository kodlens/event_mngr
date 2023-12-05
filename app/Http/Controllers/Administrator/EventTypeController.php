<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventType;

class EventTypeController extends Controller
{
    //
    public function index(){
        return view('administrator.event_type.event-type-index');
    }

    public function show($id){
        return EventType::find($id);
    }
    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);
        
        $data = EventType::where('event_type', 'like', $req->event . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
        return $data;

    }
    public function store(Request $req){
       
        $req->validate([
            'event_type' => ['required', 'unique:event_types']
        ]);

        EventType::create([
            'event_type' => strtoupper($req->event_type),
            'active' => $req->active
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function update(Request $req, $id){
       
        $req->validate([
            'event_type' => ['required', 'unique:event_types,event_type,' . $id . ',event_type_id']
        ]);

   
        $data = EventType::find($id);
        $data->event_type = strtoupper($req->event_type);
        $data->active = $req->active;

        $data->save();


        return response()->json([
            'status' => 'updated'
        ], 200);
    }


    public function destroy($id){
        
        EventType::destroy($id);
        
        return response()->json([
            'status' => 'deleted'
        ], 200);
    }


}
