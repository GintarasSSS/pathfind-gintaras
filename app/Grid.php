<?php

namespace App;

class Grid
{
    const RANDOM_GRID_SIZE = 8;

    const GRIDS = [
        'A' => [
            0 => [true, true, true, true, true],
            1 => [true, false, false, false, true],
            2 => [true, true, true, true, true],
            3 => [true, true, true, true, true],
            4 => [true, true, true, true, true]
        ],
        'B' => [
            0 => [true, true, true, true, true],
            1 => [true, false, false, false, true],
            2 => [true, false, true, false, true],
            3 => [true, false, false, false, true],
            4 => [true, true, true, true, true]
        ],
        'C' => [
            0 => [true, true, true, true, true],
            1 => [true, false, false, false, true],
            2 => [true, true, false, true, true],
            3 => [true, false, false, false, true],
            4 => [true, true, true, true, true]
        ],
        'D' => []
    ];

    private $randomGrid = [];

    /**
     * @var string
     */
    private $key;

    public function get(): array
    {
        return !empty(self::GRIDS[$this->key]) ? self::GRIDS[$this->key] : $this->randomGrid;
    }

    public function set(string $key): void
    {
        $key = strtoupper($key);

        $this->validate($key);

        $this->key = $key;

        $this->generateRandom();
    }

    public function getKeys(): array
    {
        return array_keys(self::GRIDS);
    }

    private function validate(string $key): void
    {
        if (!array_key_exists($key, self::GRIDS)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Selected key "%s" does not exist',
                    $key
                )
            );
        }
    }

    private function generateRandom(): void
    {
        if (empty(self::GRIDS[$this->key])) {
            for ($row = 0; $row < self::RANDOM_GRID_SIZE; $row++) {
                for ($column = 0; $column < self::RANDOM_GRID_SIZE; $column++) {
                    $this->randomGrid[$row][$column] = (bool)mt_rand(0, 1);
                }
            }
        }
    }
}
