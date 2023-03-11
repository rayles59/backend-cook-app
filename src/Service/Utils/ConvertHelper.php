<?php

namespace App\Service\Utils;

class ConvertHelper
{
    public static function ConvertToMo(int $size) : int
    {
        return $size / 1048576;
    }
}