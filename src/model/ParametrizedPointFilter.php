<?php

namespace App\Validation\Filter;


use App\Validation\Point2D;

interface ParametrizedPointFilter
{
    function fits(Point2D $point, $parameter): bool;
}