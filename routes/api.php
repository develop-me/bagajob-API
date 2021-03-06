<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Jobs;
use App\Http\Controllers\API\ApplicationNotes;
use App\Http\Controllers\API\Interviews;

use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Models\Interview;

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

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
/* 
    /login - Login using our passport standard contoller
*/
Route::post('login', [AccessTokenController::class, 'issueToken'])->middleware(['api-login', 'throttle','api-login-add-user']);

/* 
|   /register - Registration using our AuthController
*/
Route::post('register', [AuthController::class, 'register']);

// Forgot Password / Reset Routes

/* 
|   /reset-password-without-token - Generates the reset password token and email
*/
Route::post('reset-password-without-token', [AuthController::class, 'validatePasswordRequest']);

/* 
|    /reset-password-with-token - Resets password and sends confirmation email
*/
Route::post('reset-password-with-token', [AuthController::class, 'resetPassword']); 

/*
|--------------------------------------------------------------------------
| Application/Workflow Routes
|--------------------------------------------------------------------------
*/
// require auth:api middleware for these routes
Route::middleware('auth:api')->group(function() {

    // Users /user/{userId}
    Route::group(['prefix' => 'user/{user}'], function() {
        // PATCH /{user ID} route for updating account details
        Route::patch('', [UserController::class, 'updateAccountDetails']);

        // DELETE /{user ID} route for deleting account
        Route::delete('', [UserController::class, 'destroy']);
    
        // Jobs ~/jobs/
        Route::group(['prefix' => 'jobs'], function() {

            //GET /jobs: show all jobs for user
            Route::get('', [Jobs::class, 'index']);
        
            //POST /jobs: create a new job entry
            Route::post('', [Jobs::class, 'store']);
            
            // ~/{jobId}
            // The following are targeted at one job entry i.e. have an id in the end point
            Route::group(['prefix' => '{job}'], function() {
                
                //GET /jobs/{id}: show the job with id 
                Route::get('', [Jobs::class, 'show']);
        
                //PATCH /jobs/{id}: update the job with id
                Route::patch('', [Jobs::class, 'update']);
        
                //DELETE /jobs/{id}: delete the job with id
                Route::delete('', [Jobs::class, 'destroy']);

                // Interviews ~/interviews
                Route::group(['prefix' => 'interviews'], function() {
                    //GET /interviews: show all interview for job
                    Route::get('', [Interviews::class, 'index']);
                
                    //POST /interviews: create a new job entry
                    Route::post('', [Interviews::class, 'store']);

                    // ~/{interviewId}
                    Route::group(['prefix' => '{interview}'], function() {
                
                        //GET /interviews/{id}: show the interview with id 
                        Route::get('', [Interviews::class, 'show']);
                
                        //PATCH /interviews/{id}: update the interview with id
                        Route::patch('', [Interviews::class, 'update']);
                
                        //DELETE /interviews/{id}: delete the interview with id
                        Route::delete('', [Interviews::class, 'destroy']);
                    });
                });

                // Application Notes ~/app-notes
                Route::group(['prefix' => 'app-notes'], function() {
                    //GET /app-notes: show all application notes for job
                    Route::get('', [ApplicationNotes::class, 'index']);
                
                    //POST /app-notes: create a new application note
                    Route::post('', [ApplicationNotes::class, 'store']);

                    // ~/{noteId}
                    Route::group(['prefix' => '{applicationnote}'], function() {
                
                        //GET /app-notes/{id}: show the notes with id 
                        Route::get('', [ApplicationNotes::class, 'show']);
                
                        //PATCH /app-notes/{id}: update the notes with id
                        Route::patch('', [ApplicationNotes::class, 'update']);
                
                        //DELETE /app-notes/{id}: delete the notes with id
                        Route::delete('', [ApplicationNotes::class, 'destroy']);
                    });
                });
            });
        });
    });
});




