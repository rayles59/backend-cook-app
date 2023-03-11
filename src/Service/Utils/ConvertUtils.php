<?php

namespace App\Service\Utils;

class ConvertUtils
{
    public static function ConvertToMo(int $size) : int
    {
        return $size / 1048576;
    }
}