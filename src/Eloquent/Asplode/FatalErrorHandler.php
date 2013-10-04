<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode;

use Icecave\Isolator\Isolator;

/**
 * The standard Asplode fatal error handler.
 */
class FatalErrorHandler implements FatalErrorHandlerInterface
{
    /**
     * Construct a new fatal error handler.
     *
     * @param HandlerStack\HandlerStackInterface|null $exceptionHandlerStack The exception handler stack to use.
     * @param Isolator|null                           $isolator              The isolator to use.
     */
    public function __construct(
        HandlerStack\HandlerStackInterface $exceptionHandlerStack = null,
        Isolator $isolator = null
    ) {
        $this->isolator = Isolator::get($isolator);
        if (null === $exceptionHandlerStack) {
            $exceptionHandlerStack = new HandlerStack\ExceptionHandlerStack(
                $isolator
            );
        }

        $this->exceptionHandlerStack = $exceptionHandlerStack;
        $this->isEnabled = $this->isRegistered = false;

        $this->loadClasses();
    }

    /**
     * Get the exception handler stack.
     *
     * @return HandlerStack\HandlerStackInterface The exception handler stack.
     */
    public function exceptionHandlerStack()
    {
        return $this->exceptionHandlerStack;
    }

    /**
     * Installs this fatal error handler.
     */
    public function install()
    {
        if (!$this->isRegistered()) {
            $this->reserveMemory();
            $this->isolator()->register_shutdown_function($this);
            $this->isRegistered = true;
        }

        $this->isEnabled = true;
    }

    /**
     * Uninstalls this fatal error handler.
     */
    public function uninstall()
    {
        $this->isEnabled = false;
    }

    /**
     * Returns true if this fatal error handler is installed.
     *
     * @return boolean True if this fatal error handler is installed.
     */
    public function isInstalled()
    {
        return $this->isRegistered() && $this->isEnabled();
    }

    /**
     * Handles PHP shutdown, and produces exceptions for any detected fatal
     * error.
     *
     * This function will not actually throw any exceptions. If an installed
     * exception handler is detected, it will create an exception representing
     * the fatal error, and pass it to the installed exception handler.
     */
    public function handle()
    {
        if (!$this->isEnabled()) {
            return;
        }

        $error = $this->isolator()->error_get_last();
        if (null === $error) {
            return;
        }

        $this->freeMemory();
        $this->handleFatalError(
            new Error\AsplodeFatalErrorException(
                $error['message'],
                0,
                $error['type'],
                $error['file'],
                $error['line']
            )
        );
    }

    /**
     * Handles PHP shutdown, and produces exceptions for any detected fatal
     * error.
     *
     * This function will not actually throw any exceptions. If an installed
     * exception handler is detected, it will create an exception representing
     * the fatal error, and pass it to the installed exception handler.
     */
    public function __invoke()
    {
        return $this->handle();
    }

    /**
     * Returns true if this handler is registered.
     *
     * @return boolean True if this handler is registered.
     */
    protected function isRegistered()
    {
        return $this->isRegistered;
    }

    /**
     * Returns true if this handler is enabled.
     *
     * @return boolean True if this handler is enabled.
     */
    protected function isEnabled()
    {
        return $this->isEnabled;
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

    /**
     * Pre-loads any classes or interfaces  required in the event of a fatal
     * error.
     */
    protected function loadClasses()
    {
        $this->isolator()->class_exists(
            __NAMESPACE__ . '\Error\AsplodeFatalErrorException'
        );
    }

    /**
     * Reserves an amount of memory for use in the case of an out-of-memory
     * fatal error.
     *
     * @param integer|null $size The amount of memory to reserve.
     */
    protected function reserveMemory($size = null)
    {
        if (null === $size) {
            $size = 10240;
        }

        $this->reservedMemory = str_repeat(' ', $size);
    }

    /**
     * Frees the previously reseverd memory.
     */
    protected function freeMemory()
    {
        $this->reservedMemory = '';
    }

    /**
     * Handles PHP fatal errors.
     *
     * @param Error\FatalErrorExceptionInterface $error The fatal error to handle.
     */
    protected function handleFatalError(
        Error\FatalErrorExceptionInterface $error
    ) {
        $handler = $this->exceptionHandlerStack()->handler();
        if (null === $handler) {
            return;
        }

        $handler($error);
    }

    private $exceptionHandlerStack;
    private $isolator;
    private $isRegistered;
    private $isEnabled;
    private $reservedMemory;
}
