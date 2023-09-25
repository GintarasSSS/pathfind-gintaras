<?php

namespace App\Interfaces;

interface MatrixInterface
{
    public function display(PointInterface $pointP = null, PointInterface $pointQ = null): void;
}
