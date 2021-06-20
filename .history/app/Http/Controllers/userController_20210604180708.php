<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

// Models
use App\Models\User;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|max:255|min:1",
            "email" => "required|email|unique:users|max:100",
            "password" => "required|min:6|max:100|confirmed"
        ]);

        return User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if($user === null) {
            return response(["message" => "Resource Not Available"], 404);
        } else {
            return $user;
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_name(Request $request, $id)
    {   
        $user = User::find($id);

        if($user === null) {
            return response(["message" => "Resource Not Found"], 404);
        } else {
            
            $request->validate([
                "name" => "required|max:255|min:1"
            ]);

            DB::update("UPDATE users SET users.name=$request->name WHERE users.id=? RETURNING users.id, users.name, users.email, users.created_at, users.updated_at, users.email_verified_at")
    
            // return $user->update(["name" => $request->name]);

        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return User::destroy($id);
    }
}
