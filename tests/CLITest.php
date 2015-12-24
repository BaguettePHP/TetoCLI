<?php

namespace TetoCLI;

class TestCLIApp extends \TetoCLI\CLI
{
    public function normal_cmd()
    {
        return 'success!';
    }

    /**
     * @throws \OutOfRangeException
     */
    public function get_raise_outofrange()
    {
        return $this->not_exists;
    }

    /**
     * @throws \OutOfRangeException
     */
    public function set_raise_outofrange()
    {
        $this->not_exists = 'value';
    }

    private function private_cmd_is_invisible()
    {
        return "Don't returns!";
    }
}

class CLITest extends \TetoCLI\TestCase
{
    public function test_normal_cmd()
    {
        $expected = 'success!';
        $arg = ['testappcmd', 'normal_cmd'];
        $cli = new TestCLIApp($arg);

        $actual = $cli->__invoke();
        $this->assertSame($expected, $actual);
    }

    public function test_get_raise_OutOuRangeException()
    {
        $arg = ['testappcmd', 'get_raise_outofrange'];
        $cli = new TestCLIApp($arg);

        $this->setExpectedException('OutOfRangeException');
        $cli->__invoke();
    }

    public function test_set_raise_OutOuRangeException()
    {
        $arg = ['testappcmd', 'set_raise_outofrange'];
        $cli = new TestCLIApp($arg);

        $this->setExpectedException('OutOfRangeException');
        $cli->__invoke();
    }

    public function test_privateMethod_raise_RuntimeException()
    {
        $arg = ['testappcmd', 'private_cmd_is_invisible'];
        $cli = new TestCLIApp($arg);

        $this->setExpectedException('RuntimeException');
        $cli->__invoke();
    }

    public function test_protectedMethod_raise_RuntimeException()
    {
        $arg = ['testappcmd', 'protected_cmd_is_invisible'];
        $cli = new TestCLIApp($arg);

        $this->setExpectedException('RuntimeException');
        $cli->__invoke();
    }
}
