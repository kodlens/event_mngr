<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AcademicYear;
use App\Models\Evaluation;

class AndroidEvaluationController extends Controller
{
    //


    public function store(Request $req){

        $data = json_decode($req->ans);
        //$item = json_decode($data[0]);
        //return $item->event_id;

        $ay = AcademicYear::where('active', 1)->first();
        $arr = [];

        foreach($data as $arrItem){
            $item = json_decode($arrItem);
            array_push($arr, [
                'academic_year_id' => $ay->academic_year_id,
                'user_id' => $item->user_id,
                'event_id' => $item->event_id,
                'question_id' => $item->question_id,
                'rating' => $item->rating
            ]);
        }
        Evaluation::insert($arr);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }
}
