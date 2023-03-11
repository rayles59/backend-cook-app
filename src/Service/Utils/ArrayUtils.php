<?php

namespace App\Service\Utils;

class ArrayUtils
{
    public static function valueInArray(array $values, array $valuesToCompare): array
    {
        $tab = [];
        foreach ($values as $value) {
            if(in_array($values, $valuesToCompare))
            {
                $tab[] = $value;
            }
        }
        return $tab;
    }
}