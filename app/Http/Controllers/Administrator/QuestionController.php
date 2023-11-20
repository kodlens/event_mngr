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

    // public function getBrowseEvents(Request $req){
    //     $sort = explode('.', $req->sort_by);
    //     $ay = AcademicYear::where('active', 1)->first();

    //     $data = Event::where('academic_year_id', $ay->academic_year_id)
    //         ->orderBy($sort[0], $sort[1])
    //         ->paginate($req->perpage);

    //     return $data;
    // }

    public function show($id){
        return Question::find($id);
    }

    public function getQuestions(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Question::where('question', 'like', $req->question . '%')
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
            'order_no' => ['required', 'unique:questions'],
            'question' => ['required']
        ]);

        Question::create([
            'order_no' => $req->order_no,
            'question' => strtoupper($req->question),
            'active' => $req->active
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }


    public function update(Request $req, $id){

        $req->validate([
            'order_no' => ['required', 'unique:questions,order_no,' . $id . ',question_id'],
            'question' => ['required']
        ]);
        $data = Question::find($id);
        $data->order_no = $req->order_no;
        $data->question = strtoupper($req->question);
        $data->active = $req->active;

        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }

    public function destroy($id){
        Question::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }
}
