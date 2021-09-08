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
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $newQueue = Queue::createBySlug($request->slug);

        $sessionKey = Queue::generateSessionKey($newQueue->slug);
        session([ $sessionKey => $newQueue->valid_until ]);

        return redirect()
            ->route('admin.setting', [ $newQueue->slug ])
            ->with('new', true);
    }

    public function adminLogin($slug, Request $request)
    {
        $queue = Queue::findBySlugOrFail($slug);

        $request->validate([
            'g-recaptcha-response' => 'required|captcha',
            'secret_code' => 'required',
        ]);

        if (!hash_equals($queue->secret_code, $request->secret_code)) {
            abort('401', 'Secret code mismatch');
        }

        $sessionKey = Queue::generateSessionKey($slug);
        session([ $sessionKey => $queue->valid_until ]);

        return redirect()->route('admin.setting', [ $queue->slug ]);
    }

    public function adminSetting($slug)
    {
        $queue = Queue::findBySlugOrFail($slug);

        return view('queue.admin_setting', compact('queue'));
    }

    public function adminSettingUpdate($slug, Request $request)
    {
        $queue = Queue::findBySlugOrFail($slug);

        $queue->fill($request->only([
            'title',
            'description',
        ]));
        $queue->save();

        return view('queue.admin_setting', compact('queue'));
    }

    public function adminCounter($slug, Request $request)
    {
        $queue = Queue::findBySlugOrFail($slug);

        if ($request->ajax()) {
            return view('queue._admin_counter_display', compact('queue'));
        } else {
            return view('queue.admin_counter', compact('queue'));
        }
    }

    public function adminNext($slug)
    {
        $queue = Queue::findBySlugOrFail($slug);

        if ($queue->ticket_current >= $queue->ticket_last) {
            abort(400, 'Sudah berada di ujung antrian');
        }

        $queue->ticket_current++;
        $queue->save();

        return view('queue._admin_counter_display', compact('queue'));
    }


    public function guestCounter($slug)
    {
        $queue = Queue::findBySlugOrFail($slug);

        return view('queue.guest_counter', compact('queue'));
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

        if ($request->ajax() && $queue->isCurrentUserAdmin()) {
            return view('ticket.view', compact('ticket', 'queue'))
                ->renderSections()['content'];
        } else {
            return redirect()->route('ticket.view', [
                'code' => $ticket->secret_code,
            ]);
        }
    }
}
