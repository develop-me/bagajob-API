<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interview;
use App\Http\Requests\API\InterviewRequest;
use App\Http\Resources\API\InterviewResource;
use App\Models\Job;
use App\Models\User;

class Interviews extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Job $job)
    {
        // get all the interviews associated with the job passed in the URL
        return InterviewResource::collection($job->interviews);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Job $job, InterviewRequest $request)
    {
        // returns an array of all the data the form sent
        $data = $request->all();

        // creates an Interview with the form data, store in DB and return it as JSON
        // NOTE: automatically gets 201 status as it's a POST request
        $new_interview = $job->interviews()->create($data);

        //returns a new resource with selected fields
        return new InterviewResource($new_interview);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Job $job, Interview $interview)
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
    public function update(InterviewRequest $request, User $user, Job $job, Interview $interview)
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
    public function destroy(User $user, Job $job, Interview $interview)
    {
        //delete the interview from the DB
        $interview->delete();

        //use 204 code as there will be no content in the response
        return response(null, 204);
    }
}
