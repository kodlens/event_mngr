<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterPageController extends Controller
{
    //
    public function index(){
        return view('auth.register');
    }


    public function store(Request $req){

        $validate = $req->validate([
            'username' => ['required', 'string', 'unique:users'],
            'lname' => ['required', 'string', 'max:100'],
            'fname' => ['required', 'string', 'max:100'],
            'sex' => ['required', 'string', 'max:20'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            'department_id' => ['required'],
            // 'province' => ['required', 'string'],
            // 'city' => ['required', 'string'],
            // 'barangay' => ['required', 'string'],
        ]);

        $qr_code = substr(md5(time() . $req->lname . $req->fname), -8);

        User::create([
            'qr_code' => strtoupper($qr_code),
            'username' => $req->username,
            'password' => Hash::make($req->password),
            'email' => $req->email,
            'lname' => strtoupper($req->lname),
            'fname' => strtoupper($req->fname),
            'mname' => strtoupper($req->mname),
            'suffix' => strtoupper($req->suffix),
            'sex' => $req->sex,
            'contact_no' => $req->contact_no,
            'role' => 'STUDENT',
            'department_id' => $req->department_id,
            'active' => 0
            // 'province' => $req->province,
            // 'city' => $req->city,
            // 'barangay' => $req->barangay,
            // 'street' => strtoupper($req->street)
        ]);

        return response()->json([
            'status' => 'saved'
        ],200);
    }
}
