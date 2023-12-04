<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestUpdateController extends Controller
{
    //

    public function index(){
        return view('administrator.request_update.request-update-index');
    }


    public function store(Request $req){
        
    }
}
