<?php

namespace App\Utils;

function is_zero(float $num): bool
{
    return abs($num) <= PHP_FLOAT_EPSILON;
}

function compare_floats(float $num1, float $num2): bool
{
    $diff = $num1 - $num2;

    if (is_zero($diff)) {
        return 0;
    } else {
        return $diff;
    }

    function is_float($input): bool
    {
        if (is_numeric($input)) {
            return true;
        }
    }
}