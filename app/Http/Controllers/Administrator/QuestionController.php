<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Event;

class QuestionController extends Controller
{
    //

    public function index(){
        return view('administrator.question.question-page');
    }

    public function getBrowseEvents(Request $req){
        $sort = explode('.', $req->sort_by);
        $ay = AcademicYear::where('active', 1)->first();

        $data = Event::where('academic_year_id', $ay->academic_year_id)
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function getQuestions(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Question::with(['academic_year', 'event'])
            ->where('academic_year_id', $req->ay)
            ->where('question', 'like', $req->lname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }


    public function create(){

        return view('administrator.question.question-create')
            ->with('id', 0)
            ->with('data',  []);
    }

    public function store(Request $req){

        $req->validate([
            'order_no' => ['required'],
            'question' => ['required'],
            'input_type' => ['required']
        ]);

        Question::create([
            'academic_year_id' => $req->academic_year_id,
            'order_no' => $req->order_no,
            'event_id' => $req->event_id,
            'question' => strtoupper($req->question),
            'input_type' => strtoupper($req->input_type)
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }
}
