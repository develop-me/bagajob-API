<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\ApplicationNoteRequest;
use App\Http\Resources\API\ApplicationNoteResource;

use App\User;
use App\Job;
use App\ApplicationNote;

class ApplicationNotes extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Job $job)
    {
        //get all application notes associated with the job provided in the URL
        return ApplicationNoteResource::collection($job->notes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Job $job, ApplicationNoteRequest $request)
    {
        // returns an array of all the data the user sent
        $data = $request->all();

        // creates an application note with the user data, store in DB and return it as JSON
        // NOTE: automatically gets 201 status as it's a POST request
        $new_note = $job->notes()->create($data);

        //returns a new resource with selected fields
        return new ApplicationNoteResource($new_note);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Job $job, $noteId)
    {
        // use note Id to get Application note from DB, type-hinting is not working for some reason
        $note = ApplicationNote::findOrFail($noteId);

        //return the note requested in the URL
        return new ApplicationNoteResource($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationNoteRequest $request, User $user, Job $job, ApplicationNote $applicationnote)
    {
        //get the request data
        $data = $request->all();

        //update the note entry and save to DB
        $applicationnote->fill($data)->save();

        //return the updated note entry
        return new ApplicationNoteResource($applicationnote);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Job $job, ApplicationNote $applicationnote)
    {
        //delete the note from the DB
        $applicationnote->delete();

        //use 204 code as there will be no content in the response
        return response(null, 204);
    }
}
