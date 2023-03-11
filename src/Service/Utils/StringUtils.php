<?php

namespace App\Service\Utils;

class StringUtils
{
    public static function isValueNotEmptyOrNull(?string $value): bool
    {
        if(null === $value || '' === trim($value))
        {
            return false;
        }
        return true;
    }
}