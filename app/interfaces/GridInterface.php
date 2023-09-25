<?php

namespace App\Interfaces;

interface GridInterface
{
    public function get(): array;
    public function set(string $key): void;
    public function getKeys(): array;
}
