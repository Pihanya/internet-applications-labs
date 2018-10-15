<?php

namespace App\Validation\Filter;


interface Filter
{
    function fits(): bool;
}