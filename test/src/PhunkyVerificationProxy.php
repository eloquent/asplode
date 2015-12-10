<?php


class PhunkyVerificationProxy
{
    public function __construct($proxy, $times = null)
    {
        if (null === $times) {
            $times = array(1, 1);
        }

        $this->proxy = $proxy;
        $this->times = $times;
    }

    public function __call($name, $arguments)
    {
        $phonyArguments = array();

        foreach ($arguments as $argument) {
            if ($argument instanceof PhunkyCapture) {
                if (null === $argument->when) {
                    $phonyArguments[] = '~';
                } else {
                    $phonyArguments[] = $argument->when;
                }
            } else {
                $phonyArguments[] = $argument;
            }
        }

        $result = call_user_func_array(
            array($this->proxy->$name->between($this->times[0], $this->times[1]), 'calledWith'),
            $phonyArguments
        );

        foreach ($arguments as $index => $argument) {
            if ($argument instanceof PhunkyCapture) {
                $argument->value = $result->argument($index);
            }
        }

        return $result;
    }

    private $proxy;
    private $times;
}
