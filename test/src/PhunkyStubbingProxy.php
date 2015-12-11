<?php

use Eloquent\Phony\Phpunit\Phony;

class PhunkyStubbingProxy
{
    public function __construct($proxy)
    {
        $this->proxy = $proxy;
    }

    public function __call($name, $arguments)
    {
        $phonyArguments = array();

        foreach ($arguments as $argument) {
            if ($argument instanceof PhunkySetReference) {
                $phonyArguments[] = Phony::any();
            } else {
                $phonyArguments[] = $argument;
            }
        }

        $verifier = call_user_func_array(array($this->proxy, $name), $phonyArguments);

        foreach ($arguments as $index => $argument) {
            if ($argument instanceof PhunkySetReference) {
                $verifier->setsArgument($index, $argument->value);
            }
        }

        return new PhunkyStubVerifierProxy($verifier);
    }

    private $proxy;
}
