<?php

namespace Baguette\iter;

/**
 * @license WTFPL
 */
final class MapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider for_Array
     */
    public function test_Array($expected, array $input)
    {
        $twice = function ($n) { return $n * 2; };

        $actual = [];
        foreach (map($input, $twice) as $k => $v) {
            $actual[$k] = $v;
        }

        $this->assertEquals($expected, $actual);
    }

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
     */
    public function test_Generator($expected, callable $input)
    {
        $twice = function ($n) { return $n * 2; };

        $generator = $input();
        $this->assertInstanceOf('\Generator', $generator);

        $actual = [];
        foreach (map($generator, $twice) as $k => $a) {
            $actual[$k] = $a;
        }

        $this->assertEquals($expected, $actual);
    }

    public function for_Generator()
    {
        return [
            [
                'expected' => [],
                'input'    => function () { return; yield; },
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
