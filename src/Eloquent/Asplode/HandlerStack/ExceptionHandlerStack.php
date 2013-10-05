<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode\HandlerStack;

use Icecave\Isolator\Isolator;

/**
 * Manages the PHP exception handler stack.
 */
class ExceptionHandlerStack extends AbstractHandlerStack
{
    /**
     * Pushes a handler on to the stack.
     *
     * @param callable $handler The handler to push on to the stack.
     */
    public function push($handler)
    {
        $this->isolator()->set_exception_handler($handler);
    }

    /**
     * Pops a handler off the stack.
     *
     * @return callable|null The handler that was removed from the stack, or null if the stack is empty.
     */
    public function pop()
    {
        $handler = $this->isolator()->set_exception_handler(function() {});
        if (null !== $handler) {
            $this->isolator()->restore_exception_handler();
        }

        $this->isolator()->restore_exception_handler();

        return $handler;
    }
}
