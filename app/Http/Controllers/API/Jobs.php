<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Job;
use App\Http\Requests\API\JobRequest;
use App\Http\Resources\API\JobResource;

class Jobs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all the user's jobs
        return Job::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {
        // returns an array of all the data the user sent
        $data = $request->all();

        // creates a Job with the user data, store in DB and return it as JSON
        // NOTE: automatically gets 201 status as it's a POST request
        $job = Job::create($data);

        //returns a new resource with selected fields
        return new JobResource($job);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        //return the job requested in the URL
        return new JobResource($job);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobRequest $request, Job $job)
    {
        //get the request data
        $data = $request->all();

        //update the job entry and save to DB
        $job->fill($data)->save();

        //return the updated job entry
        return new JobResource($job);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        //delete the job from the DB
        $job->delete();

        //use 204 code as there will be no content in the response
        return response(null, 204);
    }
}
