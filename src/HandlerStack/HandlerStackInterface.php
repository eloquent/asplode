<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode\HandlerStack;

/**
 * The interface implemented by handler stacks.
 */
interface HandlerStackInterface
{
    /**
     * Gets the current handler without removing it from the stack.
     *
     * @return callable|null The current handler.
     */
    public function handler();

    /**
     * Gets the current handler stack without changing the stack.
     *
     * @return array<callable> The current handler stack.
     */
    public function handlerStack();

    /**
     * Pushes a handler on to the stack.
     *
     * @param callable $handler The handler to push on to the stack.
     */
    public function push($handler);

    /**
     * Pushes multiple handlers on to the stack.
     *
     * @param array<callable> $handlers The handlers to push on to the stack.
     */
    public function pushAll(array $handlers);

    /**
     * Pops a handler off the stack.
     *
     * @return callable|null The handler that was removed from the stack, or null if the stack is empty.
     */
    public function pop();

    /**
     * Removes all handlers from the stack.
     *
     * @return array<callable> The removed handlers.
     */
    public function clear();

    /**
     * Restores a stack of handlers.
     *
     * @param array<callable> $handlers The handlers to restore.
     */
    public function restore(array $handlers);

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
    public function executeWith($callable, $handler = null);
}
