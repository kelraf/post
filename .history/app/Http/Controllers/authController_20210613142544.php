<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\User;

class authController extends Controller
{
    /**
     * 
     * Login An Account.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function login(Request $request) {

        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // $user = DB::select("SELECT * FROM users WHERE email = :email", ["email" => $request->email]);
        // $user = User::where("email", $request->email)->first();
        $user = User::where("email", $request->email)->first("name", "created_at", "updated_at", "email");

        // if($user === null) {

        //     return response(["message" => "invalid email or password 001"], 404);

        // } elseif(!Hash::check($request->password, $user->password)) {

        //     return response(["message" => "invalid email or password 002"], 404);

        // } else {
            
        //     return $user;

        // }

        return $user;

    }
}
