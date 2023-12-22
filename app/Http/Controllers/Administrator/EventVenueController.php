<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventVenue;

class EventVenueController extends Controller
{
    //
    //wla nai constructor

    
    public function index(){
        return view('administrator.event_venue.event-venue-index');
    }


    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = EventVenue::where('event_venue', 'like', $req->venue . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }


    public function show($id){
        return EventVenue::find($id);
    }

    public function store(Request $req){
        $req->validate([
            'event_venue' => ['required', 'unique:event_venues']
        ]);

        EventVenue::created([
            'event_venue' => strtoupper($req->event_venue),
            'active' => $req->active
        ]);


        return response()->json([
            'status' => 'saved'
        ], 200);
    }


    public function update(Request $req, $id){
    

        $req->validate([
            'event_venue' => ['required', 'unique:event_venues,event_venue,'. $id . ',event_venue_id']
        ]);
  

        $data = EventVenue::find($id);
        $data->event_venue = strtoupper($req->event_venue);
        $data->active = $req->active;

        $data->save();


        return response()->json([
            'status' => 'updated'
        ], 200);
    }


    public function destroy($id){
        EventVenue::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }
}
