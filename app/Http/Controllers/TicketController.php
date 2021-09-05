<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ticket;

class TicketController extends Controller
{
    public function view($code, Request $request)
    {
        $ticket = Ticket::findByCodeQuery($code)
            ->with('queue')
            ->first()
            ;

        if (empty($ticket)) {
            abort(404, "Maaf, tiket dengan kode '$code' tidak dapat ditemukan");
        }

        return view('ticket.view', [
            'ticket' => $ticket,
            'queue' => $ticket->queue,
        ]);
    }
}
