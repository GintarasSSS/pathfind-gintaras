<?php

namespace Tests\Unit;

use App\Interfaces\GridInterface;
use App\Point;
use PHPUnit\Framework\TestCase;

class PointTest extends TestCase
{
    protected $gridMock;

    public function setUp(): void
    {
        $this->gridMock = $this->getMockBuilder(GridInterface::class)->getMock();
    }

    /**
     * @dataProvider inValidCoordinates
     */
    public function testItInValidatesCoordinates(string $coordinates, string $message): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($message);

        $this->gridMock->expects($this->any())->method('get')->willReturn([[false, false], [false, false]]);

        new Point($coordinates, $this->gridMock);
    }

    public function testItValidatesCoordinates(): void
    {
        $x = 1;
        $y = 0;

        $this->gridMock->expects($this->any())->method('get')->willReturn([[true, true], [true, true]]);

        $point = new Point($x . ',' . $y, $this->gridMock);

        $this->assertEquals($x, $point->getX());
        $this->assertEquals($y, $point->getY());
    }

    public function inValidCoordinates(): array
    {
        return [
            'missing coordinates' => [
                'coordinates' => '',
                'message' => 'Coordinates are not in correct (x, y) format.'
            ],
            'coordinates as x letter' => [
                'coordinates' => 'A,1',
                'message' => 'Coordinates are not in correct (x, y) format.'
            ],
            'coordinates as Y letter' => [
                'coordinates' => '1,B',
                'message' => 'Coordinates are not in correct (x, y) format.'
            ],
            'out of range x coordinates' => [
                'coordinates' => '2,0',
                'message' => 'Coordinates are out of range: (1, 1)'
            ],
            'out of range y coordinates' => [
                'coordinates' => '0,2',
                'message' => 'Coordinates are out of range: (1, 1)'
            ],
            'coordinates are in blocked cell' => [
                'coordinates' => '1,1',
                'message' => 'Coordinates are in blocked cell: (1, 1)'
            ]
        ];
    }
}
