<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class AndroidQuestionController extends Controller
{
    //

    public function loadQuestions(){
        $data = Question::orderBy('order_no', 'asc')
            ->get();
        return $data;
    }


    
}
