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
        $user = User::where("email", $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {

            return response(["message" => "Invalid Credentials"], 401);

        } else {
            
            $token = $user->createToken("user-auth")->plainTextToken;
            return [
                "user" => $user,
                "token" => $token
            ];

        }


    }
}
