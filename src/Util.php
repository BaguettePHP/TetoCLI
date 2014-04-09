<?php

namespace MyTeto;

/**
 * Utility class for MyTeto
 *
 * @author USAMI Kenta<tadsan@zonu.me>
 */
class Util implements UtilInterface
{
    /**
     * @param  mixed $value
     * @return mixed
     */
    public static function getShellStatus($value)
    {
        return ($value === true) ? 0 : (($value === false) ? 1 : $value);
    }

    /**
     * @param  array $args
     * @param  array $conf
     */
    public static function parseArguments(array $args, array $conf)
    {
        $result   = array(
            'subcmd'   => null,
            'options'  => null,
            'restargs' => null,
        );
        $rough    = self::parseRoughArguments($args);
        $options  = $rough['options'];
        $restargs = $rough['restargs'];

        if (isset($conf['enable_subcmd']) && $conf['enable_subcmd']) {
            $result['subcmd'] = array_shift($restargs);
        }

        $result['options']  = $options;
        $result['restargs'] = $restargs;

        return $result;
    }

    /**
     * @param  array $args
     * @return array
     */
    public static function parseRoughArguments(array $args)
    {
        $options  = array();
        $restargs = array();

        foreach ($args as $v) {
            if (strpos($v, '--') === 0 && strpos($v, '=') !== false) {
                $a = explode('=', $v);
                $k = substr(array_shift($a), 2);
                $options[$k] = implode('=', $a);
            } else {
                $restargs[] = $v;
            }
        }

        return array(
            'options'  => $options,
            'restargs' => $restargs,
        );
    }

    public static function getCLIClassSubCommands(\ReflectionClass $ref)
    {
        $methods = array();

        foreach ($ref->getMethods(\ReflectionMethod::IS_PUBLIC) as $mref) {
            $name = $mref->name;
            if (strpos($name, '__') !== 0) {
                $methods[$name] = true;
            }
        }

        return array_keys($methods);
    }
}
