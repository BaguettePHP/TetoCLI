<?php

namespace TestApp;

class CLITest extends \TetoCLI\TestCase
{
    /**
     * @dataProvider validNumbers
     */
    public function test_fizzbuzz($n)
    {
        $arg = ['testappcmd', 'fizzbuzz', $n];
        $cli = new CLI($arg);
        $actual = $cli->__invoke();
        $count = $n + 1;

        $this->assertInternalType('string', $actual);
        $this->assertCount($count, explode("\n", $actual));
    }

    public function validNumbers()
    {
        return [
            [1],
            [10],
            [100],
        ];
    }
}
