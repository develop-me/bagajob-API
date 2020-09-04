<?php

namespace App\Http\Middleware;
use App\User;

// Resources (Response formatting)
use App\Http\Resources\API\UserResource;

use Closure;

class AppendUserToLoginResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // get user Object from request
        $userEmail = $request->only('username');
        $user = User::where('email', '=', $userEmail)
        ->first();

        // inspect the response
        $response =  $next($request);

        $content = json_decode($response->content(), true);

        // check if there is an access token in the response
        if (!empty($content['access_token'])) {
            // append the user into the response
            $content['user'] = new UserResource($user);
            $response->setContent($content);
        }

        // if it's not an access_token response, just return the unchanged response
        return $response;
    }
}
