<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\InterviewRequest;

class Interviews extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all the user's interviews
        return Interviews::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InterviewRequest $request)
    {
        // returns an array of all the data the user sent
        $data = $request->all();

        // creates an Interview with the user data, store in DB and return it as JSON
        // NOTE: automatically gets 201 status as it's a POST request
        $interview = Interview::create($data);

        //returns a new resource with selected fields
        return new InterviewResource($interview);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Interview $interview)
    {
        //return the interview specified in the URL
        return new InterviewResource($interview);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InterviewRequest $request, Interview $interview)
    {
        //get the request data
        $data = $request->all();

        //update the interview entry and save to DB
        $interview->fill($data)->save();

        //return the updated interview entry
        return new InterviewResource($interview);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Interview $interview)
    {
        //delete the interview from the DB
        $interview->delete();

        //use 204 code as there will be no content in the response
        return response(null, 204);
    }
}
