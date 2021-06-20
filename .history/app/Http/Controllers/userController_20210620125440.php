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
        return User::with("posts.comments")->get();
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
        $user = User::with("posts.comments")->where("id", $id)->get();

        if($user === null || $user === []) {
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

            // return DB::update("UPDATE users SET name=$name WHERE id=? RETURNING id, name, email, created_at, updated_at, email_verified_at", [$id]);
    
            // return $user->update(["name" => $request->name]);

            // return User::where("id", $id)->updateOrCreate(["name" => $request->name]);
            return tap($user)->update(["name" => $request->name]);

        }

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_email(Request $request, $id)
    {   
        $user = User::find($id);

        if($user === null) {
            return response(["message" => "Resource Not Found"], 404);
        } else {
            
            $request->validate([
                "email" => "required|email|unique:users"
            ]);
            
            return tap($user)->update(["email" => $request->email]);

        }

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request, $id)
    {   
        $user = User::find($id);

        if($user === null) {
            return response(["message" => "Resource Not Found"], 404);
        } else {
            
            $request->validate([
                "innitial_password" => "required",
                "password" => "required|min:6|max:100|confirmed"
            ]);
            
            if (!Hash::check($request->innitial_password, $user->password)) {
                return response(["message" => "Invalid Password"], 401);
            } else {
                return tap($user)->update(["password" => Hash::make($request->password)]);
            }

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
