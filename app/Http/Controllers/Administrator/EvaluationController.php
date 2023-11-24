<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    //

    public function index(){
        return view('administrator.evaluation.evaluation-index');
    }


    public function loadReportEvaluation(){

        $data = DB::table('evaluations as a')
            ->join('evaluation_answers as b', 'a.evaluation_id', 'c.evaluation_id')
            ->where('a.event_id')
            ->get();
    }
}
