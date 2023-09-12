<?php

namespace Tests\unit;

use App\Grid;
use PHPUnit\Framework\TestCase;

class GridTest extends TestCase
{
    protected $grid;

    public function setUp(): void
    {
        $this->grid = new Grid();
    }

    /**
     * @dataProvider inValidKeys
     */
    public function testItInValidatesKey(string $key): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Selected key "%s" does not exist', strtoupper($key)));

        $this->grid->set($key);
    }

    /**
     * @dataProvider validKeys
     */
    public function testItValidatesKey(string $key): void
    {
        $this->grid->set($key);

        $this->assertIsArray($this->grid->get());
    }

    public function testGetGridKeys(): void
    {
        $getKeysResult = $this->grid->getKeys();

        $this->assertNotEmpty($getKeysResult);
        $this->assertIsArray($getKeysResult);
    }

    public function inValidKeys(): array
    {
        return [
            'invalid key letter' => ['key' => 'E'],
            'invalid key number' => ['key' => '10'],
            'invalid key word' => ['key' => 'test']
        ];
    }

    public function validKeys(): array
    {
        return [
            'valid default key' => ['key' => 'a'],
            'valid circle key' => ['key' => 'b'],
            'valid t shape key' => ['key' => 'C'],
            'valid random grid key' => ['key' => 'D'],
        ];
    }
}