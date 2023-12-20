<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function index(){
        return view('administrator.user'); //blade.php
    }

    public function getUsers(Request $req){
        $sort = explode('.', $req->sort_by);

        $users = User::with(['department', 'ao'])->where('lname', 'like', $req->lname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $users;
    }

    public function show($id){
        return User::find($id);
    }

    public function store(Request $req){
        //this will create random unique QR code
        $qr_code = substr(md5(time() . $req->lname . $req->fname), -8);

        $validate = $req->validate([
            'username' => ['required', 'max:50', 'unique:users'],
            'lname' => ['required', 'string', 'max:100'],
            'fname' => ['required', 'string', 'max:100'],
            'sex' => ['required', 'string', 'max:20'],
            'email' => ['required','unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            'department_id' => ['required'],
            'role' => ['required', 'string'],
            'ao_user_id' => ['required_if:role,"ORGANIZER"']
        ],
        [
            'ao_user_id.required_if' => 'Please select approving officer for your account.',
            'department_id.required' => 'Please select department.'
        ]);

        User::create([
            'qr_code' => strtoupper($qr_code),
            'username' => $req->username,
            'password' => Hash::make($req->password),
        'lname' => strtoupper($req->lname),
            'fname' => strtoupper($req->fname),
            'mname' => strtoupper($req->mname),
            'suffix' => strtoupper($req->suffix),
            'sex' => $req->sex,
            'contact_no' => $req->contact_no,
            'email' => $req->email,
            'role' => $req->role,
            'department_id' => $req->department_id,
            //'active' => $req->active
        ]);

        return response()->json([
            'status' => 'saved'
        ]);
    }

    public function update(Request $req, $id){

        $validate = $req->validate([
            'username' => ['required', 'max:50', 'unique:users,username,'.$id.',user_id'],
            'lname' => ['required', 'string', 'max:100'],
            'fname' => ['required', 'string', 'max:100'],
            'sex' => ['required', 'string', 'max:20'],
            'email' => ['required','unique:users,email,' . $id . ',user_id'],
            'role' => ['required', 'string'],
            'department_id' => ['required'],
            'ao_user_id' => ['required_if:role,"ORGANIZER"']

        ]);

        $data = User::find($id);
        $data->username = $req->username;
        $data->lname = strtoupper($req->lname);
        $data->fname = strtoupper($req->fname);
        $data->mname = strtoupper($req->mname);
        $data->suffix = strtoupper($req->suffix);
        $data->contact_no = $req->contact_no;
        $data->sex = strtoupper($req->sex);
        $data->email = $req->email;
        $data->role = $req->role;
        $data->department_id = $req->department_id;

        //$data->active = $req->active;
        $data->save();

        return response()->json([
            'status' => 'updated'
        ]);
    }

    public function destroy($id){
        User::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ]);
    }


    public function userActivate($id){
        $data = User::find($id);
        $data->email_verified_at = now();
        $data->save();

        return response()->json([
            'status' => 'activate'
        ], 200);
    }


    public function resetPassword(Request $req, $id){
        $req->validate([
            'password' => ['required', 'confirmed', 'min:4']
        ]);


        $user = User::find($id);
        $user->password = Hash::make($req->password);
        $user->save();

        return response()->json([
            'status' => 'changed'
        ],200);
    }


    public function loadApprovingOfficers(Request $req){
        return User::where('role', 'EVENT OFFICER')
                ->get();
    }

}
