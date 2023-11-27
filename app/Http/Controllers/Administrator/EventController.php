<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class EventController extends Controller
{
    //


    public function index(){
        return view('administrator.event.event-page');
    }

    public function getEvents(Request $req){
        $acadYear = AcademicYear::where('active', 1)->first();

        $sort = explode('.', $req->sort_by);

        $event = Event::with(['academic_year'])
            ->where('event', 'like', $req->event . '%')
            ->where('academic_year_id', $acadYear->academic_year_id)
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

        $ay = AcademicYear::where('active', 1)->first();

        $event_date = date('Y-m-d H:i:s', strtotime($req->event_datetime));

        $req->validate([
            'event' => ['required'],
            'content' => ['required'],
            'event_datetime' => ['required'],
            'event_type' => ['required']
        ]);

        $n = [];
        if($req->hasFile('event_img')) {
            $pathFile = $req->event_img->store('public/events'); //get path of the file
            $n = explode('/', $pathFile); //split into array using /
        }

        Event::create([
            'academic_year_id' => $ay->academic_year_id,
            'event' => $req->event,
            'content' => $req->content,
            'event_datetime' => $event_date,
            'event_type' => $req->event_type,
            'img_path' => $req->hasFile('event_img') ? $n[2] : ''
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function updateEvent(Request $req, $id){

        //get the current active semester
        $ay = AcademicYear::where('active', 1)->first();

        //format the date
        $event_date = date('Y-m-d H:i:s', strtotime($req->event_datetime));

        $req->validate([
            'event' => ['required'],
            'content' => ['required'],
            'event_datetime' => ['required'],
            'event_type' => ['required']

        ]);
      
        $data = Event::find($id);
        $n = [];

        if($req->hasFile('event_img')) {
            $pathFile = $req->event_img->store('public/events'); //get path of the file
            $n = explode('/', $pathFile); //split into array using /

            //if an image has already in database, it will delete from events folder to avoid redundancy
            if(Storage::exists('public/events/' .$data->img_path)) {
                Storage::delete('public/events/' . $data->img_path);
            }
        }

        //get data from database
       
        $data->academic_year_id = $ay->academic_year_id;
        $data->event = $req->event;
        $data->content = $req->content;
        $data->event_datetime = $event_date;
        $data->event_type = $req->event_type;
        
        if($req->hasFile('event_img')){
            $data->img_path = $n[2];
        }
        
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }


    public function eventApprove($id){
        $data = Event::find($id);
        $data->approval_status = 1;
        $data->save();
        return response()->json([
            'status' => 'approved'
        ], 200);
    }
    public function eventCancel($id){
        $data = Event::find($id);
        $data->approval_status = 2;
        $data->save();
        return response()->json([
            'status' => 'cancelled'
        ], 200);
    }
    
    public function eventOpenEvaluation($id){
        $data = Event::find($id);
        $data->is_open = 1;
        $data->save();
        return response()->json([
            'status' => 'open'
        ], 200);
    }
    public function eventCloseEvaluation($id){
        $data = Event::find($id);
        $data->is_open = 0;
        $data->save();
        return response()->json([
            'status' => 'open'
        ], 200);
    }
    

    


    public function destroy($id){

        Event::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }



}
