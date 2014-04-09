<?php

namespace TestApp;

/**
 * CLI Application for testing of ‘MyTeto’
 *
 * @author USAMI Kenta<tadsan@zonu.me>
 */
class CLI extends \MyTeto\CLI
{
    private $fizzbuzz_args = array('last', 'a natural number of ');
    public function fizzbuzz()
    {
        $args = $this->restargs;

        $last = array_shift($args);
        $str  = '';
        $fizzbuzz = new FizzBuzz($last);

        foreach ($fizzbuzz as $fb) {
            $str .= $fb . PHP_EOL;
        }

        return $str;
    }
}
