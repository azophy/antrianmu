<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    static function generateSecretCode()
    {
        $codeLength = 6;
        $chars = 'abcdefghjkmnprtuwxy0123456789';
        $numChars = strlen($chars);
        $newRandomInt = random_int(0, $numChars ** $codeLength);

        $newStr = '';
        for ($i=0;$i<$codeLength;$i++)
            $newStr .= $chars[random_int(0, $numChars-1)];

        return $newStr;
    }
}
