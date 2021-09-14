<?php

namespace Baguette\iter;

use PHPUnit\Framework\TestCase;

/**
 * @license WTFPL
 */
final class SliceTest extends TestCase
{
    /**
     * @dataProvider for_Array
     */
    public function test_Array($expected, array $input)
    {
        $actual = slice($input, 2);
        $this->assertInstanceOf('\Generator', $actual);

        $results = [];
        foreach ($actual as $k => $v) {
            $results[$k] = $v;
        }

        $this->assertEquals($expected, $results);
        $this->assertEquals(array_slice($input, 2, null, true), $results);
    }

    public function for_Array()
    {
        return [
            [
                'expected' => [],
                'input'    => [],
            ],
            [
                'expected' => [2 => 3],
                'input'    => [1, 2, 3],
            ],
            [
                'expected' => [
                    'race' => 'chimera'
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
        $generator = $input();
        $this->assertInstanceOf('\Generator', $generator);

        $actual = slice($generator, 2);
        $this->assertInstanceOf('\Generator', $actual);

        $results = [];
        foreach ($actual as $k => $v) {
            $results[$k] = $v;
        }

        $this->assertEquals($expected, $results);
    }

    public function for_Generator()
    {
        return [
            [
                'expected' => [],
                'input'    => function () { return; yield; },
            ],
            [
                'expected' => [2 => 3],
                'input'    => function () { yield 1; yield 2; yield 3; },
            ],
            [
                'expected' => [
                    'race' => 'chimera'
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
