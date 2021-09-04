<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Queue;
use App\Models\Ticket;

class QueueController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'slug' => [ 'required', 'regex:/^[a-zA-Z0-9_-]*$/' ],
        ]);

        $newQueue = Queue::createBySlug($request->slug);

        return redirect()->route('admin.setting', [ $newQueue->slug ]);
    }

    public function adminSetting($slug)
    {
        $queue = Queue::findBySlugOrFail($slug);

        return response()->json([
            'judul' => $queue->title,
            'kode rahasia' => $queue->secret_code,
            'Nomor antrian saat ini' => $queue->ticket_current,
            'Nomor antrian terakhir' => $queue->ticket_last,
            'Batas nomor antrian hari ini' => $queue->ticket_limit,
        ]);
    }

    public function adminCounter()
    {
    }

    public function adminNext()
    {
    }

    public function guestCounter($slug)
    {
        $queue = Queue::findBySlugOrFail($slug);

        return view('queue.guest_counter', $queue->getOriginal());
    }

    public function guestAdd($slug, Request $request)
    {
        $queue = Queue::findBySlugOrFail($slug);

        if ($queue->ticket_last >= $queue->ticket_limit) {
            abort(404, 'Maaf, nomor antrian hari ini sudah habis');
        }

        $queue->ticket_last++;
        $queue->save();

        $ticket = Ticket::create([
            'queue_id' => $queue->id,
            'order' => $queue->ticket_last,
            'secret_code' => Ticket::generateSecretCode(),
        ]);

        return response()->json([
            'judul' => $queue->title,
            'kode rahasia' => $queue->secret_code,
            'Nomor antrian saat ini' => $queue->ticket_current,
            'Nomor antrian terakhir' => $queue->ticket_last,
            'Batas nomor antrian hari ini' => $queue->ticket_limit,
            'ticket' => [
                'id' => $ticket->id,
                'order' => $ticket->order,
                'secret_code' => $ticket->secret_code,
            ],
        ]);
    }
}
