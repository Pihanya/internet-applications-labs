<?php

namespace App\Validation\Common;


abstract class FloatFunction
{
    private $evaluator;

    function __construct(callable $evaluatorFunction)
    {
        $this->evaluator = $evaluatorFunction;
    }

    public function __invoke(float $parameter, float $x): float
    {
        return $this->execute(func_get_args());
    }

    public abstract function execute(): float;

    public function getEvaluator()
    {
        if ($this->evaluator == null) {
            $evaluator = function (): float {
                return 0;
            };
        }

        return $this->evaluator;
    }
}