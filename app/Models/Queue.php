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

    public function isCurrentUserAdmin()
    {
        $sessionKey = self::generateSessionKey($this->slug);
        return (
            session($sessionKey) &&
            session($sessionKey) >= Carbon::now()
        );
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
        if (Queue::findBySlugQuery($slug)->exists()) {
            abort(400, "maaf antrian dengan nama '$slug' sudah ada");
        }

        return self::create([
            'slug' => strtolower($slug),
            'secret_code' => self::generateSecretCode(),
            'title' => $slug,
            'valid_until' => Carbon::now()->addHours(24),
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
