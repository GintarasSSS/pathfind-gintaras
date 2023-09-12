<?php

namespace App;

class PathFind
{
    const STEP = 1;

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

    public function __construct(Grid $grid, Point $pointP, Point $pointQ)
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

            $this->moveUpDown($item->row - self::STEP, $item->column, $item->distance, $iterator, $visited, $rows);
            $this->moveUpDown($item->row + self::STEP, $item->column, $item->distance, $iterator, $visited, $rows);

            $this->moveLeftRight($item->row, $item->column - self::STEP, $item->distance, $iterator, $visited,
                $columns);
            $this->moveLeftRight($item->row, $item->column + self::STEP, $item->distance, $iterator, $visited,
                $columns);
        }

        return $result;
    }

    private function moveUpDown($row, $column, $distance, &$iterator, &$visited, $rows): void
    {
        if ($row >= 0 && $row < $rows && !$visited[$row][$column]) {
            $iterator[] = new QueueItem($row, $column, $distance + self::STEP);
            $visited[$row][$column] = true;
        }
    }

    private function moveLeftRight($row, $column, $distance, &$iterator, &$visited, $columns): void
    {
        if ($column >= 0 && $column < $columns && !$visited[$row][$column]) {
            $iterator[] = new QueueItem($row, $column, $distance + self::STEP);
            $visited[$row][$column] = true;
        }
    }
}
