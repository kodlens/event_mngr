<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\AcademicYear;

class StudentEvaluatedController extends Controller
{
    //


    public function index(){
        return view('administrator.evaluation.student_evaluated.student-evaluated-index');
    }


    public function getStudentsEvaluated(Request $req){

        $sort = explode('.', $req->sort_by);

        $data = Evaluation::with(['user', 'answers'])
            ->whereHas('user', function($q) use ($req){
                $q->where('lname', 'like', $req->lname . '%');
            })
            ->where('academic_year_id', $req->ayid)
            ->where('event_id', $req->eventid)
            ->paginate($req->perpage);

        return $data;
    }

    // public function getReportEventEvaluations(Request $req){
    //     $acadYear = AcademicYear::where('active', 1)->first();

    //     $data = Evaluation::with(['user'])
    //         ->where('academic_year_id', $acadYear->academic_year_id)
    //         ->get();

    //     return $data;

    // }
    
}
