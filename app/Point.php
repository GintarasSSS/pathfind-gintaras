<?php

namespace App;

class Point
{
    /**
     * @var Grid
     */
    private $grid;

    /**
     * @var int
     */
    private $x;
    /**
     * @var int
     */
    private $y;

    public function __construct(string $coordinates, Grid $grid)
    {
        $this->set($coordinates);
        $this->grid = $grid;

        $this->validate();
    }

    public function get(): array
    {
        return [
            $this->x,
            $this->y
        ];
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    private function set(string $coordinates): void
    {
        $coordinates = explode(',', $coordinates);

        $this->x = isset($coordinates[0]) && is_numeric($coordinates[0]) ? intval(trim($coordinates[0])) : null;
        $this->y = isset($coordinates[1]) && is_numeric($coordinates[1]) ? intval(trim($coordinates[1])) : null;
    }

    private function validate(): void
    {
        if (!isset($this->x) || !isset($this->y)) {
            throw new \InvalidArgumentException('Coordinates are not in correct (x, y) format.');
        }

        $selectedGrid = $this->grid->get();

        $maxX = max(array_keys($selectedGrid));
        $maxY = max(array_keys(current($selectedGrid)));

        if ($this->x > $maxX || $this->y > $maxY) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Coordinates are out of range: (%d, %d)',
                    $maxX,
                    $maxY
                )
            );
        }

        if (empty($selectedGrid[$this->x][$this->y])) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Coordinates are in blocked cell: (%d, %d)',
                    $this->x,
                    $this->y
                )
            );
        }
    }
}
