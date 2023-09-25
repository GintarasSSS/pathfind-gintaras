<?php

namespace App;

use App\Interfaces\GridInterface;
use App\Interfaces\PathFindInterface;
use App\Interfaces\PointInterface;

class PathFind implements PathFindInterface
{
    const STEP = 1;

    const DIRECTIONS = [
        'up' => ['row' => -self::STEP, 'column' => 0],
        'down' => ['row' => self::STEP, 'column' => 0],
        'left' => ['row' => 0, 'column' => -self::STEP],
        'right' => ['row' => 0, 'column' => self::STEP]
    ];

    /**
     * @var Grid
     */
    private $grid;

    /**
     * @var Point
     */
    private $pointP;

    /**
     * @var Point
     */
    private $pointQ;

    public function __construct(GridInterface $grid, PointInterface $pointP, PointInterface $pointQ)
    {
        $this->grid = $grid;
        $this->pointP = $pointP;
        $this->pointQ = $pointQ;
    }

    public function get(): int
    {
        $rows = count($this->grid->get());
        $columns = count(current($this->grid->get()));

        $iterator = [];
        $visited = [];
        $result = -1;

        foreach ($this->grid->get() as $rowKey => $row) {
            foreach ($row as $index => $value) {
                $visited[$rowKey][$index] = !$value;
            }
        }

        $visited[$this->pointP->getX()][$this->pointP->getY()] = true;
        $iterator[] = new QueueItem($this->pointP->getX(), $this->pointP->getY(), 0);

        while (!empty($iterator)) {
            $item = array_shift($iterator);

            if ([$item->row, $item->column] == $this->pointQ->get()) {
                return $item->distance;
            }

            foreach (self::DIRECTIONS as $direction) {
                $row = $item->row + $direction['row'];
                $column = $item->column + $direction['column'];

                $this->move(
                    $row,
                    $column,
                    $item->distance,
                    $iterator,
                    $visited,
                    $direction['row'] ? $rows : $columns,
                    $direction['row'] ? $row : $column
                );
            }
        }

        return $result;
    }

    private function move(
        int $row,
        int $column,
        int $distance,
        array &$iterator,
        array &$visited,
        int $total,
        int $valuation
    ): void {
        if ($valuation >= 0 && $valuation < $total && !$visited[$row][$column]) {
            $iterator[] = new QueueItem($row, $column, $distance + self::STEP);
            $visited[$row][$column] = true;
        }
    }
}
