<?php


class PhunkyCapture
{
    public function __construct(&$value)
    {
        $this->value = &$value;
    }

    public function when($when)
    {
        $this->when = $when;

        return $this;
    }

    public $value;
    public $when;
}
