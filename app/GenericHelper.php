<?php

namespace App;

class GenericHelper
{

    static function generateSecretCode(int $codeLength = 6):string
    {
        $chars = 'abcdefghjkmnprtuwxy0123456789';
        $numChars = strlen($chars);
        $newRandomInt = random_int(0, $numChars ** $codeLength);

        $newStr = '';
        for ($i=0;$i<$codeLength;$i++)
            $newStr .= $chars[random_int(0, $numChars-1)];

        return $newStr;
    }
}
