<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2016 Erin Millard
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
     * @param HandlerStack\HandlerStackInterface|null $stack    The exception handler stack to use.
     * @param Isolator|null                           $isolator The isolator to use.
     */
    public function __construct(
        HandlerStack\HandlerStackInterface $stack = null,
        Isolator $isolator = null
    ) {
        $this->isolator = Isolator::get($isolator);
        if (null === $stack) {
            $stack = new HandlerStack\ExceptionHandlerStack(
                $isolator
            );
        }

        $this->stack = $stack;
        $this->isEnabled = $this->isRegistered = false;
    }

    /**
     * Get the exception handler stack.
     *
     * @return HandlerStack\HandlerStackInterface The exception handler stack.
     */
    public function stack()
    {
        return $this->stack;
    }

    /**
     * Installs this fatal error handler.
     *
     * @throws Exception\AlreadyInstalledException If this fatal error handler is already installed.
     */
    public function install()
    {
        if ($this->isInstalled()) {
            throw new Exception\AlreadyInstalledException();
        }

        if (!$this->isRegistered()) {
            $this->beforeRegister();
            $this->isolator()->register_shutdown_function($this);
            $this->isRegistered = true;
        }

        $this->isEnabled = true;
    }

    /**
     * Uninstalls this fatal error handler.
     *
     * @throws Exception\NotInstalledException If this fatal error handler is not installed.
     */
    public function uninstall()
    {
        if (!$this->isInstalled()) {
            throw new Exception\NotInstalledException();
        }

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
            new Error\FatalErrorException(
                $error['message'],
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
     * This method is called just before the shutdown function is registered.
     */
    protected function beforeRegister()
    {
        $this->loadClasses();
        $this->reserveMemory();
    }

    /**
     * Pre-loads any classes or interfaces  required in the event of a fatal
     * error.
     */
    protected function loadClasses()
    {
        $this->isolator()->class_exists(
            __NAMESPACE__ . '\Error\FatalErrorException'
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

        $this->reservedMemory = $this->isolator()->str_repeat(' ', $size);
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
        $handler = $this->stack()->handler();
        if (null === $handler) {
            return;
        }

        $handler($error);
    }

    private $stack;
    private $isolator;
    private $isRegistered;
    private $isEnabled;
    private $reservedMemory;
}
