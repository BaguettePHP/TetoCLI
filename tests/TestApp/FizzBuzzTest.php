<?php

namespace TestApp;

class FizzBuzzTest extends \TetoCLI\TestCase
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
        return [
            [   1,        '1'],
            [   2,        '2'],
            [   3,     'Fizz'],
            [   4,        '4'],
            [   5,     'Buzz'],
            [   6,     'Fizz'],
            [   7,        '7'],
            [   8,        '8'],
            [   9,     'Fizz'],
            [  10,     'Buzz'],
            [  15, 'FizzBuzz'],
            [  55,     'Buzz'],
            [  99,     'Fizz'],
            [ 100,     'Buzz'],
            [ 313,      '313'],
            [ 998,      '998'],
            [ 999,     'Fizz'],
        ];
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
        return [
            ['zero',     0],
            ['minus',   -1],
            ['minus', -100],
            ['minus',   -1],
            ['float',  1.1],
        ];
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
