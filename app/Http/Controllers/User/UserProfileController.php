<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Auth;

class UserProfileController extends Controller
{
    //

    public function index(){
        return view('user.user-profile');
    }

    public function loadProfile(){
        $user = Auth::user();
        return $user;
    }

    public function update(Request $req, $id){

        $req->validate([
            'lname' => ['required'],
            'fname' => ['required'],
            'email' => ['required', 'unique:users,email,' .$id . ',user_id'],
            'sex' => ['required']
        ]);

        $data = User::find($id);
        $data->lname = strtoupper($req->lname);
        $data->fname = strtoupper($req->fname);
        $data->mname = strtoupper($req->mname);
        $data->suffix = strtoupper($req->suffix);
        $data->email = $req->email;
        $data->sex = strtoupper($req->sex);
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }
}
