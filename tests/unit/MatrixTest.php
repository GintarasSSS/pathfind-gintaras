<?php

namespace Tests\unit;

use App\Grid;
use App\Matrix;
use App\Point;
use PHPUnit\Framework\TestCase;

class MatrixTest extends TestCase
{
    protected $gridMock;

    public function setUp(): void
    {
        $this->gridMock = $this->getMockBuilder(Grid::class)->getMock();
    }

    /**
     * @dataProvider getGridData
     */
    public function testPrintMatrixWithoutPoints(string $expected, array $data): void
    {
        $this->expectOutputString($expected);

        $this->gridMock->expects($this->any())->method('get')->willReturn($data);

        (new Matrix($this->gridMock))->display();
    }

    /**
     * @dataProvider getGridDataWithPoints
     */
    public function testPrintMatrixWithPoints(string $expected, array $data, array $x, array $y): void
    {
        $this->expectOutputString($expected);

        $pointMockP = $this->getMockBuilder(Point::class)->disableOriginalConstructor()->getMock();
        $pointMockQ = $this->getMockBuilder(Point::class)->disableOriginalConstructor()->getMock();

        $this->gridMock->expects($this->any())->method('get')->willReturn($data);

        $pointMockP->expects($this->any())->method('get')->willReturn($x);
        $pointMockQ->expects($this->any())->method('get')->willReturn($y);

        (new Matrix($this->gridMock))->display($pointMockP, $pointMockQ);
    }

    public function getGridData(): array
    {
        return [
            'all true fields' => [
                'expected' => '* * ' . PHP_EOL . '* * ' . PHP_EOL,
                'data' => [[true, true], [true, true]]
            ],
            'all false fields' => [
                'expected' => '# # ' . PHP_EOL . '# # ' . PHP_EOL,
                'data' => [[false, false], [false, false]]
            ],
            '50_50 false_true fields' => [
                'expected' => '# * ' . PHP_EOL . '* # ' . PHP_EOL,
                'data' => [[false, true], [true, false]]
            ]
        ];
    }

    public function getGridDataWithPoints(): array
    {
        return [
            'points are in different positions' => [
                'expected' => 'P # ' . PHP_EOL . '* Q ' . PHP_EOL,
                'data' => [[true, false], [true, true]],
                'x' => [0,0],
                'y' => [1,1]
            ],
            'points are in same position' => [
                'expected' => 'P/Q # ' . PHP_EOL . '* * ' . PHP_EOL,
                'data' => [[true, false], [true, true]],
                'x' => [0,0],
                'y' => [0,0]
            ]
        ];
    }
}
