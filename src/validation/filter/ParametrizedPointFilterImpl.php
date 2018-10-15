<?php

namespace Pihanya\Validation\Filter;


use Pihanya\Validation\Filter\ParametrizedPointFilter;
use Pihanya\Validation\Filter\PointFilter;

class ParametrizedPointFilterImpl implements ParametrizedPointFilter,
    PointFilter
{
    private $parametrizedValidators;
    private $validators;

    function __construct(
        ParametrizedPointValidator $parametrizedValidators,
        PointValidator... $validators
    ) {
        $this->parametrizedValidators = $parametrizedValidators;
        $this->validators             = $validators;
    }

    function addParametrizedValidator(ParametrizedPointValidator $validator
    ) {
        array_push($this->parametrizedValidators, $validator);
    }

    function addValidator(PointValidator $validator)
    {
        array_push($this->validators, $validator);
    }


    function fits(Point2D $point): bool
    {
        // TODO: Implement fits() method.
    }
}