<?php

namespace Tests\Functional;

use App\Grid;
use App\PathFind;
use App\Point;
use PHPUnit\Framework\TestCase;

class PathFindTest extends TestCase
{
    /**
     * @dataProvider pathFindData
     */
    public function testItReturnsPath(string $gridKey, string $coordinatesP, string $coordinatesQ, int $expected): void
    {
        $grid = new Grid();
        $grid->set($gridKey);

        $pointP = new Point($coordinatesP, $grid);
        $pointQ = new Point($coordinatesQ, $grid);

        $distance = (new PathFind($grid, $pointP, $pointQ))->get();

        $this->assertEquals($expected, $distance);
    }

    public function pathFindData(): array
    {
        return [
            [
                'gridKey' => 'A',
                'coordinatesP' => '0,1',
                'coordinatesQ' => '3,2',
                'expected' => 6
            ],
            [
                'gridKey' => 'B',
                'coordinatesP' => '0,1',
                'coordinatesQ' => '2,2',
                'expected' => -1
            ],
            [
                'gridKey' => 'C',
                'coordinatesP' => '2,3',
                'coordinatesQ' => '2,3',
                'expected' => 0
            ]
        ];
    }
}
