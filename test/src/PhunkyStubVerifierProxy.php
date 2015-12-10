<?php


class PhunkyStubVerifierProxy
{
    public function __construct($verifier)
    {
        $this->verifier = $verifier;
    }

    public function thenReturn($value)
    {
        $this->verifier->returns($value);

        return $this;
    }

    public function thenThrow($exception = null)
    {
        $this->verifier->throws($exception);

        return $this;
    }

    public function thenCallParent()
    {
        $this->verifier->forwards();

        return $this;
    }

    public function thenGetReturnByLambda($callback)
    {
        $this->verifier->does($callback);

        return $this;
    }

    private $proxy;
    private $times;
}
