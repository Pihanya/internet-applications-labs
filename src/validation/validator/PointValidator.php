<?php

namespace App\Validation;

use App\Validation\Validator\Validator;

class PointValidator implements Validator
{
    protected $validator;
    private $direction;
    private $includeBorder;

    function __construct(
        ParametrizedFunction2D $function,
        ApproveDirection $direction,
        bool $includeBorder
    ) {
        $this->validator = $function;
        $this->direction = $direction;
        $this->includeBorder = $includeBorder;
    }

    function validate(): bool
    {
        if (func_num_args() != 1) {
            throw new \BadFunctionCallException(
                "Point validator takes only point as argument"
            );
        }

        $point = func_get_arg(0);

        if ( ! ($point instanceof Point2D)) {
            throw new \BadFunctionCallException(
                "\"Point validator takes only point as argument\""
            );
        }

        $result = $this->validationFunction($point->getX());

        $diff = $point->getY() - $result;

        if (abs($diff) <= PHP_FLOAT_EPSILON) {
            $diff = 0.0;
        }

        if ($this->includeBorder && $diff == 0.0) {
            return true;
        } elseif ($this->direction == ApproveDirection::ANS_POSITIVE) {
            return $diff > 0.0;
        } elseif ($this->direction == ApproveDirection::NEGATIVE) {
            return $diff < 0.0;
        } else {
            throw new \RuntimeException("Could not validate $point");
        }
    }
}