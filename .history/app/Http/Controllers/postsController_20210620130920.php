<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;

class postsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Posts::with("comments")->get();
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
            "title" => "required|max:200",
            "message" => "required",
            "user_id" => "required"
        ]);

        return Posts::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Posts::with("comments.user")->where("id", $id)->first();

        if ($post === null) {
            return response(["message" => "Resource Not Available"], 404);
        } else {
            return $post;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Posts::find($id);

        if ($post === null) {
            return response(["message" => "Resource Not Available"], 404);
        } else {

            $request->validate([
                "title" => "required|max:200",
                "message" => "required",
                "user_id" => "required"
            ]);
            
            return tap($post)->update($request->all());
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

        $post = Posts::find($id);

        if ($post === null) {
            return response(["message" => "Resource Not Available"], 404);
        } else {

            if(Posts::destroy($id) == 1) {
                return response($post, 200);
            } else {
                return response(["message" => "Unprocessable Entity"], 402);
            }
            
        }

    }
}
