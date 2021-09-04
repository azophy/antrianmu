<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Queue;
use App\GenericHelper as Helper;

class Ticket extends Model
{
    use HasFactory;

    public $fillable = [
        'queue_id',
        'secret_code',
        'order',
        'info',
        'start_time',
        'finish_time',
        'meta',
    ];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    static function findByCodeQuery($code)
    {
        return self::where('secret_code', $code )
                ->whereRelation('queue', 'valid_until', '>=' , Carbon::now())
                ;

    }

    /* generate new usable secret code */
    static function generateSecretCode():string
    {
        do {
            $newCode = Helper::generateSecretCode();
        } while (
            self::findByCodeQuery($newCode)->exists()
        );

        return $newCode;
    }
}
