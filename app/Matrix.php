<?php

namespace App;

class Matrix
{
    /**
     * @var Grid
     */
    private $grid;

    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    public function display(Point $pointP = null, Point $pointQ = null): void
    {
        $lastColumnIndex = count(current($this->grid->get())) - 1;

        foreach ($this->grid->get() as $key => $row) {
            foreach ($row as $index => $cell) {
                switch ($cell) {
                    case true:
                        if ($pointP && $pointQ) {
                            $this->printPoints($pointP, $pointQ, $key, $index);
                        } else {
                            echo '* ';
                        }
                        break;
                    default:
                        echo '# ';
                }

                if ($index == $lastColumnIndex) {
                    echo PHP_EOL;
                }
            }
        }
    }

    private function printPoints(Point $pointP, Point $pointQ, int $gridX, int $gridY): void
    {
        switch (true) {
            case $pointP->get() == $pointQ->get() && $pointP->get() == [$gridX, $gridY]:
                echo 'P/Q ';
                break;
            case $pointP->get() == [$gridX, $gridY]:
                echo 'P ';
                break;
            case $pointQ->get() == [$gridX, $gridY]:
                echo 'Q ';
                break;
            default:
                echo '* ';
        }
    }
}
