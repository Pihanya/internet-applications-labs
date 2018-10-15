<?php

namespace App\Validation\Common;

class ParametrizedFloatFunction extends FloatFunction
{
    public function execute(): float
    {
        if (func_num_args() < 2) {
            throw new \BadFunctionCallException();
        }

        $parameter = func_get_arg(0);
        $x         = func_get_arg(1);


        if ( ! is_float($parameter) || ! is_float($x)) {
            throw new \BadFunctionCallException();
        }

        return $this->getEvaluator()($parameter, $x);
    }
}