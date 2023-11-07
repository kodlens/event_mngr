<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class ChangePasswordController extends Controller
{
    //

    // public function __construct(){
    //     $this->middleware('auth');
    // }

    public function changePassword(Request $req)
    {
        
        return $req;
        $credentials = $req->validate([
            'username' => ['required'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = \DB::table('users')
            ->where('username', $req->username)
            ->first();
        
        if($user){
            if (Hash::check($req->password, $user->password)) {
                // Passwords match
                User::where('username', $req->username)
                    ->update([
                        'password' => Hash::make($req->password)
                    ]);
            } else {
                // Passwords do not match
                return response()->json([
                    'errors' => [
                        'message' => ['Authentication failed.']
                    ]
                ], 422);
            }
        }else{
            return response()->json([
                'errors' => [
                    'message' => ['Authentication failed.']
                ]
            ], 422);
        }

        

        
        // if (Auth::attempt($credentials)) {
        //     //$request->session()->regenerate();
        //     //$user = Auth::user();
        //     
        //     return $user;
        //     // return redirect()->intended('dashboard');
        // }

        // return response()->json([
        //     'errors' => [
        //         'username' => ['Username and password error. Access denied.']
        //     ]
        // ], 422);
    }

    public function logout(Request $req){

        Auth::logout();
        $req->session()->invalidate();

        $req->session()->regenerateToken();

        return redirect('/');
    }


}
