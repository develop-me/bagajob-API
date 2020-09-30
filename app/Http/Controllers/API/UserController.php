<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

// Facades
use Illuminate\Support\Facades\Auth;

// Requests
use App\Http\Requests\API\UserAccountRequest;

// Resources (Response formatting)
use App\Http\Resources\API\UserResource;

// Models
use App\User;

class UserController extends Controller
{
    // Update User Account
    public function updateAccountDetails(UserAccountRequest $request, User $user)
    {
        // confirm the user making the request matches the user they're trying to edit
        $loggedInid = Auth::id();
        $id = $user->id;

        if ( $loggedInid === $id ) {
            //get the request data
            $data = $request->all();

            //update the user and save to DB
            $user->fill($data)->save();

            //return the updated user entry
            return response()->json(["user" => new UserResource($user)]);
        } else {
            return response()->json([
                'message' => 'You cannot edit a user other than your own',
            ], 400);
        }
    }

    // Delete User Account
    public function destroy(User $user)
    {
        $loggedInid = Auth::id();
        $id = $user->id;

        // confirm the user making the request matches the user they're trying to edit
        if ( $loggedInid === $id ) {
            // delete the user from the DB
            $user->delete();

            // use 204 code as there will be no content in the response
            return response(null, 204);
        } else {
            return response()->json([
                'message' => 'You cannot delete a user other than your own',
            ], 400);
        }
    }
}
