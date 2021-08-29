<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Queue;

class QueueController extends Controller
{
    public function create(Request $request)
    {
        if (Queue::where([
            [ 'slug', '=', $request->slug, ],
            [ 'valid_until', '<=' , Carbon::today(), ],
        ])->exists()) {
            return 'maaf antrian dengan nama ini sudah ada';
        }

        $newQueue = Queue::create([
            'slug' => $request->slug,
            'secret_code' => Queue::generateSecretCode(),
        ]);

        return redirect()->route('admin.setting', [ $newQueue->slug ]);
    }

    public function adminSetting($slug)
    {
        $queue = Queue::where([
            ['slug', '=', $slug ],
            [ 'valid_until', '<=' , Carbon::today() ],
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

    public function guestCounter()
    {
    }

    public function guestAdd()
    {
    }
}
