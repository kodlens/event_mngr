<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    //

    public function index(){
        return view('administrator.evaluation.evaluation-index');
    }


    public function getReportEvaluations(Request $req){
        $eventId = $req->eventid;
        $ayId = $req->ayid;


        $data = DB::table('questions as a')
            ->select(
                'question_id', 'question',
                DB::raw('ROUND(
                        (select sum(rating) from evaluation_answers aa join evaluations bb on aa.evaluation_id = bb.evaluation_id where aa.question_id = a.question_id and bb.event_id = ?)
                        /
                        (select count(*) from evaluation_answers aa join evaluations bb on aa.evaluation_id = bb.evaluation_id where aa.question_id = a.question_id and bb.event_id = ?)
                    , 2) as rating
                ')
                
            )
            ->orderBy('order_no', 'asc')
            ->addBinding($eventId, 'select')
            ->addBinding($eventId, 'select')
            ->get();

        return $data;
    }
}
