<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode\Test;

class CallableWrapper
{
    public function __construct($callable)
    {
        $this->callable = $callable;
    }

    public function __invoke()
    {
        return call_user_func_array($this->callable, func_get_args());
    }

    private $callable;
}
