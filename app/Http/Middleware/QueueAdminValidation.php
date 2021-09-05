<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QueueAdminValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $slug = $request->route('slug');
        $sessionKey = \App\Models\Queue::generateSessionKey($slug);

        if (
            !session($sessionKey) ||
            session($sessionKey) < Carbon::now()
        ) {
            return response()->view('queue.login', [
                'target' => route('admin.login', ['slug' => $slug ]),
            ]);
        }

        return $next($request);
    }
}
