<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //

    public function index(){
        return view('administrator.question.question-page');
    }



    public function store(Request $req){
        
    }
}
