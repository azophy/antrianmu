<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Ticket;

class TicketController extends Controller
{
    public function view($code, Request $request)
    {
        $code = strtolower($code);
        $ticket = Ticket::findByCodeQuery($code)
            ->with('queue')
            ->first()
            ;

        if ($request->isMethod('post')) {
            $request->validate([
                'g-recaptcha-response' => 'required|captcha',
            ]);
            session([ "ticket_code_expire.$code" => Carbon::now()->addMinutes(config('session.ticket_lifetime')) ]);
        }

        if (
            !session("ticket_code_expire.$code") ||
            session("ticket_code_expire.$code") < Carbon::now()
        ) {
            return view('ticket.login', compact('code'));
        }

        if (empty($ticket)) {
            abort(404, "Maaf, tiket dengan kode '$code' tidak dapat ditemukan");
        }

        return view('ticket.view', [
            'ticket' => $ticket,
            'queue' => $ticket->queue,
        ]);
    }
}
