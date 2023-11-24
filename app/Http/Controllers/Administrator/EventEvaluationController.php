<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evaluation;

class EventEvaluationController extends Controller
{
    //

    public function index(){
        return view('administrator.event.event_evaluation.event-evaluation-index');
    }


    public function getData(Request $req){

        $acadYear = AcademicYear::where('active', 1)->first();

        $sort = explode('.', $req->sort_by);

        $data = Evaluation::with(['user'])
            ->whereHas('user', function($q) use ($req){
                $q->where('lname', 'like', $req->lname . '%');
            })
            ->where('academic_year_id', $acadYear->academic_year_id)
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }
    
}
