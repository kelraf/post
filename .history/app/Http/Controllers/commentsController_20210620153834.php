<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;

class commentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comments::with("user")->get();
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
            "message" => "required|max:1000",
            "user_id" => "required",
            "post_id" => "required"
        ]);

        // return Comments::create($request->all());
        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comments::with("user")->where("id", $id)->first();

        if ($comment === null) {
            return response(["message" => "Resource Not Available"], 404);
        } else {
            return $comment;
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
        $comment = Comments::find($id);

        if ($comment === null) {
            return response(["message" => "Resource Not Available"], 404);
        } else {
            
            $request->validate([
                "message" => "required|max:1000",
                "user_id" => "required",
                "post_id" => "required"
            ]);

            return tap($comment)->update($request->all());
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
        $comment = Comments::find($id);

        if ($comment === null) {
            return response(["message" => "Resource Not Available"], 404);
        } else {

            if(Comments::destroy($id) == 1) {
                return response($comment, 200);
            } else {
                return response(["message" => "Unprocessable Entity"], 402);
            }
            
        }
    }
}
