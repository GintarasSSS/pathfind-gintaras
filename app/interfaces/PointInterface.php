<?php

namespace App\Interfaces;

interface PointInterface
{
    public function get(): array;
    public function getX(): int;
    public function getY(): int;
}
