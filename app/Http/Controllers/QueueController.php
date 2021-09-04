<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Queue;

class QueueController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'slug' => [ 'required', 'regex:/^[a-zA-Z0-9_-]*$/' ],
        ]);

        $slug = strtolower($request->slug);

        if (Queue::where([
            [ 'slug', '=', $slug ],
            [ 'valid_until', '<=' , Carbon::today() ],
        ])->exists()) {
            return 'maaf antrian dengan nama ini sudah ada';
        }

        $newQueue = Queue::create([
            'slug' => $slug,
            'secret_code' => Queue::generateSecretCode(),
            'title' => $slug,
            'valid_until' => Carbon::now()->addHours(24),
        ]);

        return redirect()->route('admin.setting', [ $newQueue->slug ]);
    }

    public function adminSetting($slug)
    {
        $slug = strtolower($slug);

        $queue = Queue::where([
            ['slug', '=', $slug ],
            [ 'valid_until', '<=' , Carbon::now() ],
        ])->first();

        if (empty($queue)) {
            return 'Maaf antrian dengan nama ini tidak ditemukan';
        }

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
        $slug = strtolower($slug);

        $queue = Queue::where([
            ['slug', '=', $slug ],
            [ 'valid_until', '<=' , Carbon::now() ],
        ])->first();

        if (empty($queue)) {
            return 'Maaf antrian dengan nama ini tidak ditemukan';
        }

        return view('queue.guest_counter', $queue->getOriginal());
    }

    public function guestAdd(Request $request)
    {
    }
}
