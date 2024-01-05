<?php

namespace App\Http\Controllers\Administrator;


use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Event;
use App\Models\EventVenue;
use App\Models\User;
use App\Models\EventFile;
use App\Models\CustomRecipient;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Storage;
use Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\ApproveEmail;
use App\Mail\DeclineEmail;
use App\Mail\UpdateEventMail;
use App\Mail\ParticipantsMailApprove;

use App\Rules\DetectConflictRule;


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

        $event = Event::with(['academic_year',
            'event_type',
            'venue',
            'user.department',
            'approving_officer',
            'event_files',
            'department'
            ])
            ->where('is_archive', 0)
            ->where('event', 'like', $req->event . '%')
            ->where('academic_year_id', $acadYear->academic_year_id)
            ->orderBy($sort[0], $sort[1]);

        if(in_array($role, ['REQUESTING PARTY'])){
            $event->where('user_id', $user->user_id);
        }

        if(in_array($role, ['APPROVING OFFICER'])){
            $event->where('ao_user_id', $user->user_id);
        }


        return $event->paginate($req->perpage);
    }

    public function getArchiveEvents(Request $req){
        $acadYear = AcademicYear::where('active', 1)->first();
        $user = Auth::user();

        $role = $user->role;

        $sort = explode('.', $req->sort_by);

        $event = Event::with(['academic_year', 'event_type', 'venue'])
            ->where('event', 'like', $req->event . '%')
            ->where('is_archive', 1)
            ->where('academic_year_id', $acadYear->academic_year_id)
            ->orderBy($sort[0], $sort[1]);

        // if(in_array($role, ['REQUESTING PARTY'])){
        //     $event->where('user_id', $user->user_id);
        // }

        // if(in_array($role, ['APPROVING OFFICER'])){
        //     $event->where('ao_user_id', $user->user_id);
        // }
        return $event->paginate($req->perpage);
    }

    public function create(){
        return view('administrator.event.event-page-create-edit')
            ->with('id', 0)
            ->with('data', []);
    }

    public function edit($id){
        $event = Event::with(['event_files', 'custom_recipients'])->find($id);
        return view('administrator.event.event-page-create-edit')
            ->with('id', $event->event_id)
            ->with('data', $event);
    }


    public function store(Request $req){


        $ay = AcademicYear::where('active', 1)->first();
        $user = Auth::user();

        $event_date_from = date('Y-m-d', strtotime($req->event_date_from));
        $event_date_to = date('Y-m-d', strtotime($req->event_date_to));
        $eventTimeFrom = date('H:i:s', strtotime($req->event_time_from));
        $eventTimeTo = date('H:i:s', strtotime($req->event_time_to));

        $req->validate([
            'event' => ['required'],
            'event_content' => ['required'],
            'event_date_from' => ['required'],
            'event_time_from' => ['required'],
            'event_time_to' => ['required'],
            'event_type_id' => ['required'],
            'department_id' => ['required'],
            'ao_user_id' => ['required'],
            'event_img' => ['required', 'mimes:jpg,bmp,png'],
            'file_attachments.*.event_file_path' => ['required', 'mimes:pdf'],
            'event_venue_id' => ['required', new DetectConflictRule($event_date_from, $event_date_to, $eventTimeFrom, $eventTimeTo, 0)]
        ],[
            'event_img.required' => 'Please upload and image.',
            'event_img.mimes' => 'Only JPG, PNG and BMP are accepted.',
            'file_attachments.required' => 'Please upload file attachment.',
            'department_id.required' => 'Please select school.',
            'file_attachments.*.event_file_path.mimes' => 'Only PDF are accepted.',
            'ao_user_id.required' => 'Please select approving officer.',
        ]);

        //return $req;
        $n = [];
        if($req->hasFile('event_img')) {
            $pathFile = $req->event_img->store('public/events'); //get path of the file
            $n = explode('/', $pathFile); //split into array using /
        }

        $data = Event::create([
            'academic_year_id' => $ay->academic_year_id,
            'user_id' => $user->user_id,
            'event_type_id' => $req->event_type_id,
            'event_venue_id' => $req->event_venue_id,
            'event' => $req->event,
            'event_content' => $req->event_content,
            'if_others' => strtoupper($req->if_others),
            'event_date_from' => $event_date_from,
            'event_date_to' => $event_date_to,
            'event_time_from' => $eventTimeFrom,
            'event_time_to' => $eventTimeTo,
            'img_path' => $req->hasFile('event_img') ? $n[2] : '',

            'is_need_approval' => $req->is_need_approval,
            'ao_user_id' => $req->ao_user_id,
            'department_id' => $req->department_id,
        ]);


        if($req->has('file_attachments')){
            foreach ($req->file_attachments as $item) {
                $nPath = [];
                if($item['event_file_path']){
                    $pathFile = $item['event_file_path']->store('public/attach_files'); //get path of the file
                    $nPath = explode('/', $pathFile); //split into array using /
                }

                //insert into database after upload 1 image
                EventFile::create([
                    'event_id' => $data->event_id,
                    'event_filename' => $item['event_filename'],
                    'event_file_path' => $nPath[2]
                ]);
            }
        }
        
        if($req->has('customRecipients')){
            foreach ($req->customRecipients as $mail) {
                //insert recipient in database
                CustomRecipient::create([
                    'event_id' => $data->event_id,
                    'email' => $mail['email'], 
                ]);
            }
        }


        //return $req;

        return response()->json([
            'status' => 'saved'
        ], 200);
    }




    public function updateEvent(Request $req, $id){
        //return $req;

        // foreach ($req->file_attachments as $item) {
        //     if (isset($item['event_file_path']) && $item['event_file_path'] instanceof UploadedFile) {
        //         return 'is a file';
        //     }
        // }

        //get the current active semester
        $ay = AcademicYear::where('active', 1)->first();

        //format the date
        $event_date_from = date('Y-m-d', strtotime($req->event_date_from));
        $event_date_to = date('Y-m-d', strtotime($req->event_date_to));
        $eventTimeFrom = date('H:i:s', strtotime($req->event_time_from));
        $eventTimeTo = date('H:i:s', strtotime($req->event_time_to));

        $req->validate([
            'event' => ['required'],
            'event_content' => ['required'],
            'event_date_from' => ['required'],
            'event_type_id' => ['required'],
            'event_time_from' => ['required'],
            'event_time_to' => ['required'],
            'department_id' => ['required'],

            'event_venue_id' => ['required', new DetectConflictRule($event_date_from, $event_date_to, $eventTimeFrom, $eventTimeTo, $id)]
        ],[
            'department_id.required' => 'Please select school.'

        ]);

        $data = Event::with(['user', 'venue'])->find($id);

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
        $data->event_content = $req->event_content;
        $data->event_date_from = $event_date_from;
        $data->event_date_to = $event_date_to;
        $data->event_time_from = $eventTimeFrom;
        $data->event_time_to = $eventTimeTo;
        $data->is_need_approval = $req->is_need_approval;
        $data->department_id = $req->department_id;
        $data->ao_user_id = $req->ao_user_id;
        
        if($req->hasFile('event_img')){
            $data->img_path = $n[2];
        }

        $data->save();

        if($req->has('customRecipients')){
            foreach ($req->customRecipients as $mail) {
                //insert recipient in database
                CustomRecipient::updateOrCreate([
                    'custom_recipient_id'=> $mail['custom_recipient_id']
                ],
                [
                    'event_id' => $data->event_id,
                    'email' => $mail['email'], 
                ]);
            }
        }


        // $nPath=[];
        // if($req->has('file_attachments')){
        //     foreach ($req->file_attachments as $item) {

        //         $nPath = [];
        //         if($item['event_file_path']){
        //             $pathFile = $item['event_file_path']->store('public/attach_files'); //get path of the file
        //             $nPath = explode('/', $pathFile); //split into array using /
        //         }

        //         //insert into database after upload 1 image
        //         EventFile::updateOrCreate([
        //             'event_file_id' => $item['event_file_id']
        //         ],[
        //             'event_id' => $data->event_id,
        //             'event_filename' => $item['event_filename'],

        //             'event_file_path' => $nPath[2]
        //         ]);
        //     }
        // }

        $newEventVenue = EventVenue::find($req->event_venue_id);
        $when = now()->addSeconds(10);
        if(Env::get('MAIL_OPEN') == 1){
            // Mail::to($data->user->email)
            //     ->later($when, new ApproveEmail($data->event));

            $when = now()->addSeconds(10);
            Mail::to($data->user->email)
                ->later($when, new UpdateEventMail($data,
                    $req->event,
                    $newEventVenue,
                    $event_date_from,
                    $event_date_to,
                    $eventTimeFrom,
                    $eventTimeTo));
        }


        //return $req;

        return response()->json([
            'status' => 'updated'
        ], 200);
    }


    public function eventApprove($id){

        $user = Auth::user();

        $data = Event::with(['user'])
            ->find($id);
        $data->approval_status = 1;
        $userId = $data->user_id;
        $data->approve_by = $user->fname[0] . $user->lname;
        $data->approve_by_id = $user->user_id;

        $data->save();

        //return $data->user->email;
        //GINOO NLAANG JUD NAKABLO GE UNSA NI NAKO
        if(Env::get('MAIL_OPEN') == 1){
            $when = now()->addSeconds(10);
            Mail::to($data->user->email)
                ->later($when, new ApproveEmail($data->event));

            if($data->department_id > -1){

                if($data->department_id === 0){
                    $users = User::where('role', 'ATTENDEE')
                        ->get();
                }else{
                    $users = User::where('role', 'ATTENDEE')
                        ->where('department_id', $data->department_id)
                        ->get();
                }
                foreach($users as $u){
                    Mail::to($u->email)
                        ->later($when, new ParticipantsMailApprove($data->event));
    
                    sleep(2);
                }
            }else{
                $recipients = CustomRecipient::where('event_id', $id)
                    ->get();

                foreach($recipients as $r){
                    Mail::to($r['email'])
                        ->later($when, new ParticipantsMailApprove($data->event));
                    sleep(2);
                }
            }
          
        }

        return response()->json([
            'status' => 'approved'
        ], 200);
    }

    public function eventCancel(Request $req, $id){
        $req->validate([
            'event_id' => ['required'],
            'remarks_decline' => ['required'],

        ]);
        $data = Event::with(['user'])
            ->find($id);
        $data->approval_status = 2;
        $data->remarks_decline = $req->remarks_decline;
        $data->save();

        $when = now()->addSeconds(10);

        if(Env::get('MAIL_OPEN') == 1){
            $when = now()->addSeconds(10);
            Mail::to($data->user->email)
                ->later($when, new DeclineEmail($data->event, $req->remarks_decline));
        }

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



    public function archiveEvents(Request $req){


        foreach($req->data as $item){
            $id = $item['event_id'];

            $data = Event::find($id);
            $data->is_archive = 1;
            $data->archive_date = date('Y-m-d');
            $data->save();
        }

        return response()->json([
            'status' => 'archived'
        ], 200);
    }

    public function undoArchive(Request $req){

        foreach($req->data as $item){
            $id = $item['event_id'];

            $data = Event::find($id);
            $data->is_archive = 0;
            $data->archive_date = null;
            $data->save();
        }

        return response()->json([
            'status' => 'undo'
        ], 200);
    }




    public function removeEventFileAttachment($id){

        $data = EventFile::find($id);

          //if an image has already in database, it will delete from events folder to avoid redundancy
        if(Storage::exists('public/events/' .$data->attach_files)) {
            Storage::delete('public/events/' . $data->attach_files);
        }
        $data = EventFile::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);

    }

    public function removeCustomRecipient($id){
        CustomRecipient::destroy($id);
    }



}
