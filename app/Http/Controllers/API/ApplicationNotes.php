<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\ApplicationNoteRequest;

class ApplicationNotes extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all application notes
        return ApplicationNotes::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationNoteRequest $request)
    {
        // returns an array of all the data the user sent
        $data = $request->all();

        // creates an application note with the user data, store in DB and return it as JSON
        // NOTE: automatically gets 201 status as it's a POST request
        $applicationnote = ApplicationNote::create($data);

        //returns a new resource with selected fields
        return new ApplicationNoteResource($applicationnote);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ApplicationNote $applicationnote)
    {
        //return the note requested in the URL
        return new ApplicationNoteResource($applicationnote);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicationNoteRequest $request, ApplicationNote $applicationnote)
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
    public function destroy($id)
    {
        //delete the note from the DB
        $job->delete();

        //use 204 code as there will be no content in the response
        return response(null, 204);
    }
}
