<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\ApproveEmail;
use App\Mail\DeclineEmail;

class EventController extends Controller
{
    //


    public function index(){
        return view('administrator.event.event-page');
    }

    public function getEvents(Request $req){
        $acadYear = AcademicYear::where('active', 1)->first();
        $user = Auth::user();
        $role = $user->role;

        $sort = explode('.', $req->sort_by);

        $event = Event::with(['academic_year', 'event_type'])
            ->where('event', 'like', $req->event . '%')
            ->where('academic_year_id', $acadYear->academic_year_id)
            ->orderBy($sort[0], $sort[1]);
        
        if(in_array($role, ['ORGANIZER', 'STUDENT', 'ATTENDEE'])){
            $event->where('user_id', 'like', $user->user_id);
        }

        return $event->paginate($req->perpage);;
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
        $user = Auth::user();

        $event_date = date('Y-m-d H:i:s', strtotime($req->event_date));
        $eventFrom = date('H:i:s', strtotime($req->event_time_from));
        $eventTo = date('H:i:s', strtotime($req->event_time_to));

        $req->validate([
            'event' => ['required'],
            'content' => ['required'],
            'event_date' => ['required'],
            'event_time_from' => ['required'],
            'event_time_to' => ['required'],
            'event_type_id' => ['required']
        ]);

 
        $n = [];
        if($req->hasFile('event_img')) {
            $pathFile = $req->event_img->store('public/events'); //get path of the file
            $n = explode('/', $pathFile); //split into array using /
        }  

        Event::create([
            'academic_year_id' => $ay->academic_year_id,
            'user_id' => $user->user_id,
            'event_type_id' => $req->event_type_id,
            'event_venue_id' => $req->event_venue_id,
            'event' => $req->event,
            'content' => $req->content,
            'if_others' => strtoupper($req->if_others),
            'event_date' => $event_date,
            'event_time_from' => $eventFrom,
            'event_time_to' => $eventTo,
            'img_path' => $req->hasFile('event_img') ? $n[2] : '',
            'is_need_approval' => $req->is_need_approval,
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function updateEvent(Request $req, $id){

        //get the current active semester
        $ay = AcademicYear::where('active', 1)->first();

        //format the date
        $event_date = date('Y-m-d H:i:s', strtotime($req->event_date));
        $eventFrom = date('H:i:s', strtotime($req->event_time_from));
        $eventTo = date('H:i:s', strtotime($req->event_time_to));

        $req->validate([
            'event' => ['required'],
            'content' => ['required'],
            'event_date' => ['required'],
            'event_type_id' => ['required'],
            'event_time_from' => ['required'],
            'event_time_to' => ['required'],
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
        $data->event = strtoupper($req->event);
        $data->event_type_id = $req->event_type_id;
        $data->event_venue_id = $req->event_venue_id;
        $data->content = $req->content;
        $data->event_date = $event_date;
        $data->event_time_from = $eventFrom;
        $data->event_time_to = $eventTo;
        $data->is_need_approval = $req->is_need_approval;
        
        if($req->hasFile('event_img')){
            $data->img_path = $n[2];
        }
        
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }


    public function eventApprove($id){

        $data = Event::with(['user'])
            ->find($id);
        $data->approval_status = 1;
        $userId = $data->user_id;
        $data->save();

        //return $data->user->email;

         //GINOO NLAANG JUD NAKABLO GE UNSA NI NAKO
            // $when = now()->addSeconds(10);
        Mail::to($data->user->email)
            ->send(new ApproveEmail($data->event));

        return response()->json([
            'status' => 'approved'
        ], 200);
    }
    public function eventCancel($id){
        $data = Event::with(['user'])
            ->find($id);
        $data->approval_status = 2;
        //$data->save();

        Mail::to($data->user->email)
            ->send(new DeclineEmail($data->event));

        return response()->json([
            'status' => 'declined'
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
