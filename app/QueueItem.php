<?php

namespace App;

class QueueItem
{
    public $row;
    public $column;
    public $distance;

    public function __construct(int $row, int $column, int $distance)
    {
        $this->row = $row;
        $this->column = $column;
        $this->distance = $distance;
    }
}
