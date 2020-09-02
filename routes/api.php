<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Jobs;
use App\Http\Controllers\API\ApplicationNotes;
use App\Http\Controllers\API\Interviews;

use Laravel\Passport\Http\Controllers\AccessTokenController;


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

// Login using passports AccessTokenController controller
Route::post('login', [AccessTokenController::class, 'issueToken'])->middleware(['api-login', 'throttle']);;

// Registration using our AuthController
Route::post('register', 'API\AuthController@register');

// require auth:api middleware for these routes
Route::middleware('auth:api')->group(function() {
 
    Route::group(['prefix' => 'jobs'], function () {

        //GET /jobs: show all jobs for user
        Route::get('', [Jobs::class, 'index']);
    
        //POST /jobs: create a new job entry
        Route::post('', [Jobs::class, 'store']);
    
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
    
});




