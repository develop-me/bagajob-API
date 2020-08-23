<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Jobs;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'jobs'], function () {

    //GET /jobs: show all jobs for user
    Route::get('', [Jobs::class, 'index']);

    //POST /jobs: create a new job entry
    Route::get('', [Jobs::class, 'store']);

    //the following are targeted at one job entry i.e. have an id in the end point
    Route::group(['prefix' => '{job}'], function () {
        
        //GET /jobs/2: show the job with id of 2
        Route::get('', [Jobs::class, 'show']);

        //PUT /jobs/2: update the job with id of 2
        Route::put('', [Jobs::class, 'update']);

        //DELETE /jobs/2: delete the job with id of 2
        Route::delete('', [Jobs::class, 'destroy']);
    
    });

});


