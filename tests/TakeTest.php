<?php

namespace Baguette\iter;

/**
 * @license WTFPL
 */
final class TakeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider for_Array
     */
    public function test_Array($expected, array $input)
    {
        $actual = take($input, 2);
        $this->assertInstanceOf('\Generator', $actual);

        $results = [];
        foreach ($actual as $k => $v) {
            $results[$k] = $v;
        }

        $this->assertEquals($expected, $results);
    }

    public function for_Array()
    {
        return [
            [
                'expected' => [],
                'input'    => [],
            ],
            [
                'expected' => [1, 2],
                'input'    => [1, 2, 3],
            ],
            [
                'expected' => [
                    'name' => 'Teto Kasane',
                    'age'  => 31,
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

        $actual = take($generator, 2);
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
                'expected' => [1, 2],
                'input'    => function () { yield 1; yield 2; yield 3; },
            ],
            [
                'expected' => [
                    'name' => 'Teto Kasane',
                    'age'  => 31,
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
