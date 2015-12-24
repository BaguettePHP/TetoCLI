<?php

namespace TetoCLI;

class UtilTest extends \TetoCLI\TestCase
{
    public function test_getShellStatus_returns_0()
    {
        $expected = 0;
        $value    = true;
        $actual   = Util::getShellStatus($value);

        $this->assertSame($expected, $actual);
    }

    public function test_getShellStatus_returns_1()
    {
        $expected = 1;
        $value    = false;
        $actual   = Util::getShellStatus($value);

        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider shellStatusValues
     */
    public function test_getShellStatus_returns_value($desc, $value)
    {
        $expected = $value;
        $actual   = Util::getShellStatus($value);

        $this->assertSame($expected, $actual);
    }

    public function shellStatusValues()
    {
        return array(
            ['string value', 's t r i n g'],
            ['int value'   , 1234567890],
            ['array value' , ['foo' => 'bar']],
        );
    }

    /**
     * @dataProvider argumentsPatterns
     */
    public function test_parseRoughArguments($desc, array $arguments, $expected)
    {
        $actual = Util::parseRoughArguments($arguments);

        $this->assertEquals($expected, $actual);
    }

    public function argumentsPatterns()
    {
        return [
            ['empty argument',
                [],
                [
                    'options'  => [],
                    'restargs' => [],
                ]
            ],
            ['only longopts',
                ['--foo=bar', '--fizz=buzz'],
                [
                    'options'  => [
                        'foo'  => 'bar',
                        'fizz' => 'buzz',
                    ],
                    'restargs' => []
                ]
            ],
            ["only longopts contains '=' ",
                ['--foo=bar=buz', '--fizz=buzz=buzz'],
                [
                    'options'  => [
                        'foo'  => 'bar=buz',
                        'fizz' => 'buzz=buzz',
                    ],
                    'restargs' => []
                ]
            ],
            ["only longopts doesn't contains '=' ",
                ['--foo', '--fizz'],
                [
                    'options'  => [],
                    'restargs' => ['--foo', '--fizz'],
                ]
            ],
        ];
    }
}
