<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public $cast = [
        'meta' => 'json',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type' => self::TYPE_FREE,
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
