<?php

use Eloquent\Phony\Phpunit\Phony;

class Phunky
{
    public static function mock($className)
    {
        return Phony::mock($className)->mock();
    }

    public static function partialMock($className)
    {
        $arguments = func_get_args();
        $className = array_shift($arguments);

        return Phony::partialMock($className, $arguments)->mock();
    }

    public static function when($mock)
    {
        return new PhunkyStubbingProxy(Phony::on($mock));
    }

    public static function verify($mock, $times = null)
    {
        return new PhunkyVerificationProxy(Phony::on($mock), $times);
    }

    public static function verifyNoInteraction($mock)
    {
        Phony::on($mock)->noInteraction();
    }

    public static function inOrder()
    {
        return call_user_func_array('Eloquent\Phony\Phpunit\Phony::inOrder', func_get_args());
    }

    public static function anyParameters()
    {
        return Phony::wildcard();
    }

    public static function times($times)
    {
        return array($times, $times);
    }

    public static function never()
    {
        return array(0, 0);
    }

    public static function setReference($value)
    {
        return new PhunkySetReference($value);
    }

    public static function capture(&$value)
    {
        return new PhunkyCapture($value);
    }
}
