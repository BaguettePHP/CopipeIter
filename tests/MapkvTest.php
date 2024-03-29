<?php

namespace Baguette\iter;

use PHPUnit\Framework\TestCase;

/**
 * @license WTFPL
 */
final class MapkvTest extends TestCase
{
    /**
     * @dataProvider for_Array
     * @param array<mixed> $expected
     * @param array<mixed> $input
     * @return void
     */
    public function test_Array(array $expected, array $input)
    {
        $kv_pair = function ($k, $v) { return [$k, $v]; };

        $actual = [];
        foreach (map_kv($input, $kv_pair) as $k => $a) {
            $actual[$k] = $a;
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
                'expected' => [
                    [0, 'apple'],
                    [1, 'banana'],
                    [2, 'orange'],
                ],
                'input'    => ['apple', 'banana', 'orange'],
            ],
            [
                'expected' => [
                    'name' => ['name', 'Teto Kasane'],
                    'age'  => ['age' , 31],
                    'race' => ['race', 'chimera'],
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
        $kv_pair = function ($k, $v) { return [$k, $v]; };

        $generator = $input();
        $this->assertInstanceOf('\Generator', $generator);

        $actual = [];
        foreach (map_kv($generator, $kv_pair) as $k => $a) {
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
                'expected' => [
                    [0, 'apple'],
                    [1, 'banana'],
                    [2, 'orange'],
                ],
                'input'    => function () {
                    yield 0 => 'apple';
                    yield 1 => 'banana';
                    yield 2 => 'orange';
                },
            ],
            [
                'expected' => [
                    'name' => ['name', 'Teto Kasane'],
                    'age'  => ['age' , 31],
                    'race' => ['race', 'chimera'],
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
