<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthenticationError;
use Closure;
use Illuminate\Http\Request;

class AddUserId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()){
            $request->merge([
                'user_id' => auth()->user()->id,
            ]);

            return $next($request);
        }

        throw new AuthenticationError('you are not logged in.');

    }
}
