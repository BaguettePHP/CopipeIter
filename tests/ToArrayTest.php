<?php

namespace Baguette\iter;

/**
 * @license WTFPL
 */
final class ToArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider for_Array
     */
    public function test_Array($expected, array $input)
    {
        $this->assertEquals($input, to_array($input));
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
        $generator = $input();
        $this->assertInstanceOf('\Generator', $generator);
        $this->assertEquals($expected, to_array($generator));
    }

    public function for_Generator()
    {
        return [
            [
                'expected' => [],
                'input'    => function () { return; yield; },
            ],
            [
                'expected' => [1, 2, 3],
                'input'    => function () { yield 1; yield 2; yield 3; },
            ],
            [
                'expected' => [
                    'name' => 'Teto Kasane',
                    'age'  => 31,
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
