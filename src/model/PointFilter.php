<?php

namespace App\Validation\Filter;


use App\Validation\Point2D;

interface PointFilter
{
    function fits(Point2D $point): bool;
}