<?php

namespace TestApp;

/**
 * FizzBuzz class
 *
 * @author USAMI Kenta<tadsan@zonu.me>
 * @see    http://blog.codinghorror.com/why-cant-programmers-program/
 */
class FizzBuzz implements \SeekableIterator
{
    const ORIGIN = 1;
    const BUZZ_STR = 'Buzz';
    const FIZZ_STR = 'Fizz';

    private $cur  = 0;
    private $last = 0;

    /**
     * @param  int $last
     * @throws \UnexpectedValueException
     */
    public function __construct($last)
    {
        self::assertNumberisNaturalOrZero($last);

        $this->cur  = self::ORIGIN;
        $this->last = (int)$last;
    }

    /**
     * @param int $position
     * @return null
     */
    public function seek($position)
    {
        self::assertNumberisNaturalOrZero($position);

        $this->cur = $position;
    }

    /**
     * @return string
     */
    public function current()
    {
        return self::fizzbuzz($this->cur);
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->cur;
    }

    /**
     * @return null
     */
    public function next()
    {
        $this->cur += 1;
    }

    /**
     * @return \TestApp\FizzBuzz
     */
    public function rewind()
    {
        $this->cur= self::ORIGIN;

        return $this;
    }


    /**
     * @return bool
     */
    public function valid()
    {
        return 0 < $this->cur && $this->cur <= $this->last;
    }

    /**
     * @param  int $n
     * @return string
     */
    public static function fizzbuzz($n)
    {
        self::assertNumberisNaturalOrZero($n);

        $str = '';

        if (self::isFizz($n)) {
            $str .= self::FIZZ_STR;
        }

        if (self::isBuzz($n)) {
            $str .= self::BUZZ_STR;
        }

        if (empty($str)) {
            $str = (string)$n;
        }

        return $str;
    }

    /**
     * @param  int $n
     * @return bool
     */
    public static function isBuzz($n)
    {
        return $n % 5 === 0;
    }

    /**
     * @param  int $n
     * @return bool
     */
    public static function isFizz($n)
    {
        return $n % 3 === 0;
    }

    /**
     * @param  int $n
     * @return bool
     */
    public static function assertNumberisNaturalOrZero($n)
    {
        if (!is_int($n) || $n <= 0) {
            throw new \OutOfBoundsException();
        }

        return true;
    }
}
