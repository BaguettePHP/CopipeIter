<?php

namespace Baguette\iter;

use PHPUnit\Framework\TestCase;

/**
 * @license WTFPL
 */
final class MapTest extends TestCase
{
    /**
     * @dataProvider for_Array
     * @param array<mixed> $expected
     * @param array<mixed> $input
     * @return void
     */
    public function test_Array($expected, array $input)
    {
        $twice = function ($n) { return is_numeric($n) ? ($n * 2) : 0; };

        $actual = [];
        foreach (map($input, $twice) as $k => $v) {
            $actual[$k] = $v;
        }

        $this->assertEquals($expected, $actual);
    }

    /**
     * @phpstan-return list<array{expected:array<mixed>,input:array<mixed>}>
     */
    public function for_Array()
    {
        return [
            [
                'expected' => [],
                'input'    => [],
            ],
            [
                'expected' => [2, 4, 6],
                'input'    => [1, 2, 3],
            ],
            [
                'expected' => [
                    'name' => 0,
                    'age'  => 62,
                    'race' => 0
                ],
                'input'    => [
                    'name' => 'Teto Kasane',
                    'age'  => 31,
                    'race' => 'chimera'
                ],
            ],
        ];
    }

    /**
     * @dataProvider for_Generator
     * @template K
     * @template V
     * @phpstan-param array<K,V> $expected
     * @phpstan-param callable():\Generator<K,V> $input
     * @return void
     */
    public function test_Generator($expected, callable $input)
    {
        $twice = function ($n) { return is_numeric($n) ? ($n * 2) : 0; };

        $generator = $input();
        $this->assertInstanceOf('\Generator', $generator);

        $actual = [];
        foreach (map($generator, $twice) as $k => $a) {
            $actual[$k] = $a;
        }

        $this->assertEquals($expected, $actual);
    }

    /**
     * @phpstan-return list<array{expected:array<mixed>,input:\Generator<mixed>}>
     */
    public function for_Generator()
    {
        return [
            [
                'expected' => [],
                'input' => function () {
                    return;
                    // @phpstan-ignore-next-line
                    yield;
                },

            ],
            [
                'expected' => [2, 4, 6],
                'input'    => function () { yield 1; yield 2; yield 3; },
            ],
            [
                'expected' => [
                    'name' => 0,
                    'age'  => 62,
                    'race' => 0
                ],
                'input'    => function () {
                    yield 'name' => 'Teto Kasane';
                    yield 'age'  => 31;
                    yield 'race' => 'chimera';
                },
            ],
        ];
    }
}
