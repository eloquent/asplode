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

use Exception;
use Icecave\Isolator\Isolator;

/**
 * An abstract base class for implementing handler stacks.
 */
abstract class AbstractHandlerStack implements HandlerStackInterface
{
    /**
     * Construct a new handler stack.
     *
     * @param Isolator|null $isolator The isolator to use.
     */
    public function __construct(Isolator $isolator = null)
    {
        $this->isolator = Isolator::get($isolator);
    }

    /**
     * Gets the current handler without removing it from the stack.
     *
     * @return callable|null The current handler.
     */
    public function handler()
    {
        $handler = $this->pop();
        if (null !== $handler) {
            $this->push($handler);
        }

        return $handler;
    }

    /**
     * Gets the current handler stack without changing the stack.
     *
     * @return array<callable> The current handler stack.
     */
    public function handlerStack()
    {
        $this->pushAll($handlers = $this->clear());

        return $handlers;
    }

    /**
     * Pushes multiple handlers on to the stack.
     *
     * @param array<callable> $handlers The handlers to push on to the stack.
     */
    public function pushAll(array $handlers)
    {
        array_map(array($this, 'push'), $handlers);
    }

    /**
     * Removes all handlers from the stack.
     *
     * @return array<callable> The removed handlers.
     */
    public function clear()
    {
        $handlers = array();
        while (null !== ($handler = $this->pop())) {
            $handlers[] = $handler;
        }

        return $handlers;
    }

    /**
     * Restores a stack of handlers.
     *
     * @param array<callable> $handlers The handlers to restore.
     */
    public function restore(array $handlers)
    {
        $this->clear();
        $this->pushAll($handlers);
    }

    /**
     * Temporarily bypass the current handler stack and execute a callable with
     * the supplied handler.
     *
     * This method is useful for executing PHP code that relies upon handling
     * techniques that are incompatible with Asplode
     *
     * @param callable      $callable The callable to invoke.
     * @param callable|null $handler  The handler to use.
     *
     * @return mixed     The result of the callable's invocation.
     * @throws Exception If the callable throws an exception.
     */
    public function executeWith($callable, $handler = null)
    {
        $handlers = $this->clear();
        if (null !== $handler) {
            $this->push($handler);
        }

        $error = null;
        try {
            $result = $callable();
        } catch (Exception $error) {
            // re-thrown after handlers are restored
        }

        $this->restore($handlers);

        if (null !== $error) {
            throw $error;
        }

        return $result;
    }

    /**
     * Get the isolator.
     *
     * @return Isolator The isolator.
     */
    protected function isolator()
    {
        return $this->isolator;
    }

    private $isolator;
}
