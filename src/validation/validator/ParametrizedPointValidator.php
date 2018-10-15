<?php

namespace App\Validation;

use App\Validation\Validator\Validator;

class ParametrizedPointValidator implements Validator
{
    private $validator;
    private $direction;
    private $includeBorder;

    function __construct(
        ParametrizedFunction2D $parametrizedFunction,
        ApproveDirection $direction,
        bool $includeBorder
    ) {
        $this->validator     = $parametrizedFunction;
        $this->direction     = $direction;
        $this->includeBorder = $includeBorder;
    }

    function validate(): bool
    {
        $args_num = func_num_args();
        if ($args_num < 2) {
            throw new \BadFunctionCallException(
                "Parametrized validator takes at least 2 arguments: value, parameter"
            );
        }

        $point     = func_get_arg(0);
        $parameter = func_get_arg(1);

        $result = $this->validator($parameter, $point->getX());

        $diff = $point->getY() - $result;

        if (abs($diff) <= PHP_FLOAT_EPSILON) {
            $diff = 0.0;
        }

        if ($this->includeBorder && $diff == 0.0) {
            return true;
        } elseif ($this->direction == ApproveDirection::POSITIVE) {
            return $diff > 0.0;
        } elseif ($this->direction == ApproveDirection::NEGATIVE) {
            return $diff < 0.0;
        } else {
            throw new \RuntimeException("Could not validate $point");
        }
    }

}