<?php

namespace TestApp;

class CLITest extends \TetoCLI\TestCase
{
    /**
     * @dataProvider validNumbers
     */
    public function test_fizzbuzz($n)
    {
        $arg = array('testappcmd', 'fizzbuzz', $n);
        $cli = new CLI($arg);
        $actual = $cli->__invoke();
        $count = $n + 1;

        $this->assertInternalType('string', $actual);
        $this->assertCount($count, explode("\n", $actual));
    }

    public function validNumbers()
    {
        return array(
            array(1),
            array(10),
            array(100),
        );
    }
}
