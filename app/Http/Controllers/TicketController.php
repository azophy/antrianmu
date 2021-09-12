<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        return view('ticket.login', [
            'isSearchTicketEnabled' => true,
        ]);
    }

    public function view($code, Request $request)
    {
        $ticket = Ticket::findByCodeQuery($code)
            ->with('queue')
            ->first()
            ;

        if (empty($ticket)) {
            return view('ticket.login', [
                'isSearchTicketEnabled' => true,
            ])->withErrors([
                'Not Found' => "Tiket dengan kode '$code' tidak dapat ditemukan",
            ]);
        }

        return view('ticket.view', [
            'ticket' => $ticket,
            'queue' => $ticket->queue,
        ]);
    }
}
