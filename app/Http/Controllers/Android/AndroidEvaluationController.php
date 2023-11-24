<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AcademicYear;
use App\Models\Evaluation;
use App\Models\EvaluationAnswer;

class AndroidEvaluationController extends Controller
{
    //


    public function store(Request $req){
        //return $req->ans;
        $data = json_decode($req->ans);
        $item = json_decode($data[0]);
        //return $item->user_id;
        // return $data[0];

        $ay = AcademicYear::where('active', 1)->first();
        $arr = [];

        //validate
        $exist = Evaluation::where('academic_year_id', $ay->academic_year_id)
            ->where('event_id', $item->event_id)
            ->where('user_id', $item->user_id)
            ->exists();

        if($exist){
            return response()->json([
                'status' => 'exist'
            ], 422);
        }

        $eval = Evaluation::create([
            'academic_year_id' => $ay->academic_year_id,
            'event_id' => $item->event_id,
            'user_id' => $item->user_id,
        ]);

        foreach($data as $arrItem){
            $item = json_decode($arrItem);
           // return $item->user_id;

            array_push($arr, [
                'evaluation_id' => $eval->evaluation_id,
                'question_id' => $item->question_id,
                'rating' => $item->rating
            ]);
        }
        EvaluationAnswer::insert($arr);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }
}
