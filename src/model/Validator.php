<?php

namespace App\Validation\Validator;


interface Validator
{
    function validate(): bool;
}