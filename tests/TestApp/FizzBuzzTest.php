<?php

namespace TestApp;

class FizzBuzzTest extends \MyTeto\TestCase
{
    /**
     * @dataProvider fizzbuzzNumbers
     */
    public function test_fizzbuzz($num, $expected)
    {
        $actual = FizzBuzz::fizzbuzz($num);

        $this->assertSame($expected, $actual);
    }

    public function fizzbuzzNumbers()
    {
        return array(
            array(  1, '1'),
            array(  2, '2'),
            array(  3, 'Fizz'),
            array(  4, '4'),
            array(  5, 'Buzz'),
            array(  6, 'Fizz'),
            array(  7, '7'),
            array(  8, '8'),
            array(  9, 'Fizz'),
            array( 10, 'Buzz'),
            array( 15, 'FizzBuzz'),
            array( 55, 'Buzz'),
            array( 99, 'Fizz'),
            array(100, 'Buzz'),
            array(313, '313'),
            array(998, '998'),
            array(999, 'Fizz'),
        );
    }

    /**
     * @dataProvider fizzbuzzInvalidNumbers
     */
    public function test_fizzbuzz_raise_($num, $expected)
    {
        $this->setExpectedException('OutOfBoundsException');

        $actual = FizzBuzz::fizzbuzz($num);
    }

    public function fizzbuzzInvalidNumbers()
    {
        return array(
            array('zero',   0),
            array('minus', -1),
            array('minus', -100),
            array('minus', -1),
            array('float', 1.1)
        );
    }

    public function test_Iteration()
    {
        $last = 10;

        $n = 0;
        $fizzbuzz = new FizzBuzz($last);

        foreach ($fizzbuzz as $k => $fb) {
            $this->assertInternalType('string', $fb);
            $n++;
        }

        $this->assertSame($last, $n);
    }
}
