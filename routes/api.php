<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Jobs;
use App\Http\Controllers\API\ApplicationNotes;
use App\Http\Controllers\API\Interviews;

use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;

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
            
            // ~/jobs/{jobId}
            // The following are targeted at one job entry i.e. have an id in the end point
            Route::group(['prefix' => '{job}'], function() {
                
                //GET /jobs/{id}: show the job with id 
                Route::get('', [Jobs::class, 'show']);
        
                //PUT /jobs/{id}: update the job with id
                Route::put('', [Jobs::class, 'update']);
        
                //DELETE /jobs/{id}: delete the job with id
                Route::delete('', [Jobs::class, 'destroy']);
            });
        });
    });
});




