<?php

namespace App\Validation\Common;

class FloatFunctionImpl extends FloatFunction
{
    public function execute(): float
    {
        if (func_num_args() != 1) {
            throw new \BadFunctionCallException();
        }

        $x = func_get_arg(0);

        if ( ! is_float($x)) {
            throw new \BadFunctionCallException();
        }

        return $this->getEvaluator()($x);
    }
}