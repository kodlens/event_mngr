<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminOpenController extends Controller
{
    //

   
    public function loadApprovingOfficers(Request $req){
        return User::where('role', 'APPROVING OFFICER')
                ->get();
    }
}
