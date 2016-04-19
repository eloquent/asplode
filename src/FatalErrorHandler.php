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

use Eloquent\Asplode\Error\FatalErrorException;
use Eloquent\Asplode\Exception\AlreadyInstalledException;
use Eloquent\Asplode\Exception\NotInstalledException;
use Eloquent\Asplode\HandlerStack\ExceptionHandlerStack;
use Eloquent\Asplode\HandlerStack\HandlerStackInterface;
use Icecave\Isolator\Isolator;

/**
 * The standard Asplode fatal error handler.
 */
class FatalErrorHandler implements FatalErrorHandlerInterface
{
    /**
     * Construct a new fatal error handler.
     *
     * @param HandlerStackInterface|null $stack    The exception handler stack to use.
     * @param Isolator|null              $isolator The isolator to use.
     */
    public function __construct(
        HandlerStackInterface $stack = null,
        Isolator $isolator = null
    ) {
        $this->isolator = Isolator::get($isolator);

        if (null === $stack) {
            $stack = new ExceptionHandlerStack($isolator);
        }

        $this->stack = $stack;
        $this->isRegistered = false;
        $this->isEnabled = false;
    }

    /**
     * Get the exception handler stack.
     *
     * @return HandlerStackInterface The exception handler stack.
     */
    public function stack()
    {
        return $this->stack;
    }

    /**
     * Installs this fatal error handler.
     *
     * @param integer $reservedMemory The amount of memory to reserve for fatal error handling.
     *
     * @throws AlreadyInstalledException If this fatal error handler is already installed.
     */
    public function install($reservedMemory = 1048576)
    {
        if ($this->isEnabled) {
            throw new AlreadyInstalledException();
        }

        if (!$this->isRegistered) {
            $this->reservedMemory =
                $this->isolator->str_repeat(' ', $reservedMemory);
            $this->isolator
                ->class_exists('Eloquent\Asplode\Error\FatalErrorException');
            $this->isolator->register_shutdown_function($this);
            $this->isRegistered = true;
        }

        $this->isEnabled = true;
    }

    /**
     * Uninstalls this fatal error handler.
     *
     * @throws NotInstalledException If this fatal error handler is not installed.
     */
    public function uninstall()
    {
        if (!$this->isEnabled) {
            throw new NotInstalledException();
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
        return $this->isRegistered && $this->isEnabled;
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
        if (!$this->isEnabled) {
            return;
        }

        $this->reservedMemory = '';
        $error = $this->isolator->error_get_last();

        if (null === $error) {
            return;
        }

        $handler = $this->stack->handler();

        if (null === $handler) {
            return;
        }

        $handler(
            new FatalErrorException(
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
        $this->handle();
    }

    private $stack;
    private $isolator;
    private $isRegistered;
    private $isEnabled;
    private $reservedMemory;
}
