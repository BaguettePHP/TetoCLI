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
            array('string value', 's t r i n g'),
            array('int value'   , 1234567890),
            array('array value' , array('foo' => 'bar')),
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
        return array(
            array('empty argument',
                array(),
                array(
                    'options'  => array(),
                    'restargs' => array(),
                )
            ),
            array('only longopts',
                array('--foo=bar', '--fizz=buzz'),
                array(
                    'options'  => array(
                        'foo'  => 'bar',
                        'fizz' => 'buzz',
                    ),
                    'restargs' => array()
                )
            ),
            array("only longopts contains '=' ",
                array('--foo=bar=buz', '--fizz=buzz=buzz'),
                array(
                    'options'  => array(
                        'foo'  => 'bar=buz',
                        'fizz' => 'buzz=buzz',
                    ),
                    'restargs' => array()
                )
            ),
            array("only longopts doesn't contains '=' ",
                array('--foo', '--fizz'),
                array(
                    'options'  => array(),
                    'restargs' => array('--foo', '--fizz'),
                )
            ),
        );
    }
}
