<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Department;

class OpenController extends Controller
{
    //


    public function loadDepartments(){
        return Department::orderBy('code', 'asc')
            ->get();
    }
}
