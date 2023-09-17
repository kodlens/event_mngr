<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    //

    public function index(){
        return view('administrator.question.question-page');
    }


    public function getQuestions(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Question::with(['event'])
            ->where('question', 'like', $req->lname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }


    public function store(Request $req){
        $req->validate([
            'question' => ['required'],
            'input_type' => ['required']
        ]);

        Question::create([
            'question' => strtoupper($req->question),
            'input_type' => strtoupper($req->input_type)
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }
}
