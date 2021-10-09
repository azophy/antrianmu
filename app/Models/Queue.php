<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Ticket;
use App\GenericHelper as Helper;

class Queue extends Model
{
    use HasFactory;

    const TYPE_FREE = 1; // no registration required
    const TYPE_BASIC = 2; // free registration
    const TYPE_PRO = 3;

    const MIN_TURN_LENGTH = 1; // minimum elapsed time (in seconds) for it to be considered "not skipped"

    const RESERVED_SLUG_NAMES = [
        'tiket',
        'ticket',
        'tickets',
        'queue',
        'queues',
        'antrian',
        'antrianmu',
    ];

    public $fillable = [
        'slug',
        'secret_code',
        'type',
        'title',
        'description',
        'ticket_current',
        'ticket_last',
        'ticket_limit',
        'valid_until',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
        'valid_until' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type' => self::TYPE_FREE,
        'ticket_current' => 0,
        'ticket_last' => 0,
        'ticket_limit' => 50,
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function getCurrentTicket()
    {
        return $this->tickets()
                    ->where('order', $this->ticket_current)
                    ->first();
    }

    public function createNextTicket()
    {
        $this->ticket_last++;
        $this->save();

        return Ticket::create([
            'queue_id' => $this->id,
            'order' => $this->ticket_last,
            'secret_code' => Ticket::generateSecretCode(),
        ]);
    }

    public function updateToNextTicket()
    {
        $queueMeta = $this->meta;

        if ($this->ticket_current > 0) {
            // count average processing time
            $currentTicket = $this->getCurrentTicket();
            $currentTicket->finish_time = Carbon::now();
            $elapsed = $currentTicket->finish_time
                            ->diffInSeconds($currentTicket->start_time);

            if ($elapsed > self::MIN_TURN_LENGTH) {
                $queueMeta['elapsed_valid_turn'] += $elapsed;
                $queueMeta['num_valid_turn']++;
                $queueMeta['last_average'] = $queueMeta['elapsed_valid_turn'] / $queueMeta['num_valid_turn'];
            }

            $currentTicket->save();
        }

        $this->ticket_current++;

        if ($this->ticket_current <= $this->ticket_last) {
            $currentTicket = $this->getCurrentTicket();
            $currentTicket->start_time = Carbon::now();
            $currentTicket->save();
        }

        $this->meta = $queueMeta;
        $this->save();
    }

    public function isCurrentUserAdmin()
    {
        $sessionKey = self::generateSessionKey($this->slug);
        return (
            session($sessionKey) &&
            session($sessionKey) >= Carbon::now()
        );
    }

    /* calculate time giver order
     * @return Carbon   Predicted time
     */
    public function calculateTurnPrediction($order)
    {
        if ($this->ticket_current == 0) {
            $turnLeft = $order;
            $lastTurnTime = new Carbon($this->meta['predicted_start']);
        } else {
            $currentTicket = $this->getCurrentTicket();
            $turnLeft = $order - $currentTicket->order;
            $lastTurnTime = $currentTicket->start_time;
        }
        $secondsLeft = $this->meta['last_average'] * $turnLeft;
        return $lastTurnTime->addSeconds($secondsLeft);
    }

    /* get latest average as display-able string */
    public function displayLastAverage()
    {
        $val = $this->meta['last_average'] / 60;
        return ($val < 1.000) ?
            'kurang dari 1 menit' :
            (int) $val . ' menit' ;
    }

    static function findBySlugQuery($slug)
    {
        return self::where([
            ['slug', '=', strtolower($slug) ],
            [ 'valid_until', '>=' , Carbon::now() ],
        ]);
    }

    static function findBySlugOrFail($slug)
    {
        $queue = self::findBySlugQuery($slug)->first();

        if (empty($queue)) {
            abort(404, "Maaf antrian dengan nama '$slug' tidak ditemukan");
        }

        return $queue;
    }

    static function createBySlug($slug)
    {
        if (Queue::findBySlugQuery($slug)->exists()
        || in_array($slug, self::RESERVED_SLUG_NAMES)) {
            abort(400, "maaf antrian dengan nama '$slug' sudah ada");
        }

        return self::create([
            'slug' => strtolower($slug),
            'secret_code' => self::generateSecretCode(),
            'title' => $slug,
            'valid_until' => Carbon::now()->addHours(24),
            'meta' => [
                'predicted_average' => 60, // prediction value. either configured by used or use result from previous day
                'predicted_start' => Carbon::now()->hour(7)->minute(0)->second(0),
                'elapsed_valid_turn' => 60, // use initial average as initial elapsed
                'num_valid_turn' => 1, // extra offset for predicted initial average
                'last_average' => 60,
            ],
        ]);
    }

    /* generate new usable secret code
     * @return string
     */
    static function generateSecretCode():string
    {
        do {
            $newCode = Helper::generateSecretCode();
        } while (
            self::where([
                ['secret_code', '=', $newCode ],
                [ 'valid_until', '>=' , Carbon::now() ],
            ])->exists()
        );

        return $newCode;
    }

    /* generate session key, used for session auth in Queue's Admin pages
     * @return string
     */
    static function generateSessionKey($slug)
    {
        $slug = strtolower($slug);
        return "queue_admin_expire.$slug";
    }
}
