<?php

namespace App\Validation\Common;

class Point2D
{
    private $x;
    private $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x == null ? 0 : $x;
        $this->y = $y == null ? 0 : $y;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }
}