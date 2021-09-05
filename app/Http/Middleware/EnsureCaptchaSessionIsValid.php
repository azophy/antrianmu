<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EnsureCaptchaSessionIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  String  $type
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $type)
    {
        $code = strtolower($request->route('code'));
        $session_key = "$type.$code";

        if ($request->isMethod('post')) {
            $request->validate([
                'g-recaptcha-response' => 'required|captcha',
            ]);
            session([ $session_key => Carbon::now()->addMinutes(config('session.ticket_lifetime')) ]);
        }

        if (
            !session($session_key) ||
            session($session_key) < Carbon::now()
        ) {
            return response()->view('ticket.login', [
                'target' => $request->fullUrl(),
            ]);
        }

        return $next($request);
    }
}
