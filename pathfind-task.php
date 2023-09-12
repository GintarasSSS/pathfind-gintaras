<?php

require ('vendor/autoload.php');

use App\Grid;
use App\Matrix;
use App\Point;
use App\PathFind;

try {
    $gridSelectMessage = 'Select grid from (%s): ';
    $pointMessage = 'Set point "%s" X and Y coordinates [example - (0, 0) or (row, column)]: ';
    $distanceMessage = 'Distance between two points is: %d';

    $grid = new Grid();

    $gridKey = (string) readline(
        sprintf(
            $gridSelectMessage,
            implode(', ', $grid->getKeys())
        )
    );

    $grid->set($gridKey);

    $matrix = new Matrix($grid);

    $matrix->display();

    $coordinates = (string) readline(sprintf($pointMessage, 'P'));
    $pointP = new Point($coordinates, $grid);

    $coordinates = (string) readline(sprintf($pointMessage, 'Q'));
    $pointQ = new Point($coordinates, $grid);

    $matrix->display($pointP, $pointQ);

    $distance = (new PathFind($grid, $pointP, $pointQ))->get();

    echo sprintf(
        $distanceMessage . PHP_EOL,
        $distance
    );
} catch (\Exception $e) {
    die($e->getMessage() . PHP_EOL);
}
