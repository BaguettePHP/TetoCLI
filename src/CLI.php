<?php

namespace TetoCLI;

/**
 * Abstract class of Implementation
 *
 * @author USAMI Kenta<tadsan@zonu.me>
 */
abstract class CLI
{
    protected $__data  = [
        'argv'       => null,
        'selfname'   => null,
        'options'    => null,
        'restargs'   => null,
        'subcmd'     => null,
        'reflection' => null,
        'methods'    => null,
        'util'       => null,
    ];
    protected $enable_subcmd  = true;
    protected $default_subcmd = 'help';

    /**
     * @param array $argv
     * @param array $config
     */
    public function __construct(array $argv, array $config = [])
    {
        $this->setConfig($config);

        $this->argv = $argv;
        $this->selfname = array_shift($argv);
        $this->reflection = new \ReflectionClass($this);

        $parseconf = [
            'enable_subcmd' => $this->enable_subcmd,
        ];
        $parsed_args = Util::parseArguments($argv, $parseconf);
        $this->subcmd   = $parsed_args['subcmd'] ?: $this->default_subcmd;
        $this->options  = $parsed_args['options'];
        $this->restargs = $parsed_args['restargs'];

        $this->methods = Util::getCLIClassSubCommands($this->reflection);
    }

    public function help()
    {
        $version = isset($this->options['version']) ? $this->options['version'] : false;

        if ($version) {
            return $this->version();
        }
        $version_str = $this->version();

        $str  = '';
        $str .= $version_str . PHP_EOL . PHP_EOL;
        $str .= 'usage: ' . $this->selfname . PHP_EOL . PHP_EOL;
        $str .= 'sub commands: ' . PHP_EOL;
        foreach ($this->methods as $m) {
            $str .= "  $m" . PHP_EOL;
        }

        return $str;
    }

    public function version()
    {
        $info    = pathinfo($this->selfname);
        $appname = $info['basename'];
        $version = $this->version;

        if ($version) {
            $str = "${appname} version ${version}";
        } else {
            $str = $appname;
        }

        return $str . PHP_EOL;
    }

    public function __invoke()
    {
        $sub = $this->subcmd;

        if (in_array($sub, $this->methods)) {
            $result = $this->$sub();
        } else {
            throw new \RuntimeException(var_export($this, true));
        }

        return $result;
    }

    /**
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->__data[$name])) {
            return $this->__data[$name];
        }

        $msg = var_export(['name' => $name, '__data' => $this->__data], true);
        throw new \OutOfRangeException($msg);
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->__data)) {
            return $this->__data[$name] = $value;
        }

        $msg = var_export(['name' => $name, 'value' => $value, '__data' => $this->__data], true);
        throw new \OutOfRangeException($msg);
    }

    /**
     * @param array $config
     */
    public static function __run(array $config = [])
    {
        $argv = isset($argv) ? $argv : $_SERVER['argv'];
        $cli  = new static($argv, $config);

        exit($cli->__getShellStatus($cli->__invoke()));
    }

    /**
     * @param  array $config
     * @return $this
     */
    protected function setConfig(array $config)
    {
        if (isset($config['util'])) {
            if ($config['util'] instanceof \TetoCLI\UtilInterface) {
                $this->util = $config['util'];
            } else {
                throw new \InvalidArgumentException();
            }
        } else {
            $this->util = new \TetoCLI\Util;
        }

        return $this;
    }

    /**
     * @param  mixed $value
     * @return mixed
     */
    public function __getShellStatus($value)
    {
        return $this->util->getShellStatus($value);
    }
}
