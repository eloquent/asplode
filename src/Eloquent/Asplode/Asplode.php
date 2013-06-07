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

use ErrorException;
use Icecave\Isolator\Isolator;

/**
 * The main Asplode error handler.
 *
 * Also provides utility methods for managing PHP's error handler stack.
 *
 */
class Asplode
{
    /**
     * Asserts that an error handling is configured in a way that is compatible
     * with code expecting error exceptions.
     *
     * @param Isolator|null $isolator The isolator to use.
     *
     * @throws Exception\ErrorHandlingConfigurationException If error handling
     *     is not configured correctly.
     */
    public static function assertCompatibleHandler(Isolator $isolator = null)
    {
        $isolator = Isolator::get($isolator);
        $message = 'Error handling is incorrectly configured.';

        try {
            $isolator->trigger_error($message, E_USER_DEPRECATED);
        } catch (ErrorException $e) {
            if (
                $e->getMessage() === $message &&
                $e->getSeverity() === E_USER_DEPRECATED
            ) {
                return;
            }
        }

        throw new Exception\ErrorHandlingConfigurationException;
    }

    /**
     * Gets the current error handler without removing it from the stack.
     *
     * @param Isolator|null $isolator The isolator to use.
     */
    public static function currentErrorHandler(Isolator $isolator = null)
    {
        $isolator = Isolator::get($isolator);

        $errorHandler = static::popErrorHandler($isolator);
        if (null !== $errorHandler) {
            static::pushErrorHandler($errorHandler, $isolator);
        }

        return $errorHandler;
    }

    /**
     * Gets the current error handler stack without changing the stack.
     *
     * @param Isolator|null $isolator The isolator to use.
     */
    public static function currentErrorHandlerStack(Isolator $isolator = null)
    {
        $isolator = Isolator::get($isolator);

        $errorHandlers = static::removeErrorHandlers($isolator);
        static::restoreErrorHandlers($errorHandlers, $isolator);

        return $errorHandlers;
    }

    /**
     * Pushes an error handler on to the stack.
     *
     * @param callable      $errorHandler The error handler to push on to the stack.
     * @param Isolator|null $isolator     The isolator to use.
     */
    public static function pushErrorHandler(
        $errorHandler,
        Isolator $isolator = null
    ) {
        Isolator::get($isolator)->set_error_handler($errorHandler);
    }

    /**
     * Pops an error handler off the stack.
     *
     * @param Isolator|null $isolator The isolator to use.
     *
     * @return callable|null The error handler that was removed from the stack,
     *     or null if the stack is empty.
     */
    public static function popErrorHandler(Isolator $isolator = null)
    {
        $isolator = Isolator::get($isolator);

        $errorHandler = $isolator->set_error_handler(function() {});
        $isolator->restore_error_handler();
        $isolator->restore_error_handler();

        return $errorHandler;
    }

    /**
     * Removes all error handlers from the stack.
     *
     * @param Isolator|null $isolator The isolator to use.
     *
     * @return array<callable> The removed error handlers.
     */
    public static function removeErrorHandlers(Isolator $isolator = null)
    {
        $isolator = Isolator::get($isolator);

        $errorHandlers = array();
        while (null !== ($errorHandler = static::popErrorHandler($isolator))) {
            $errorHandlers[] = $errorHandler;
        }

        return $errorHandlers;
    }

    /**
     * Restores a stack of error handlers.
     *
     * @param array<callable> $errorHandlers The error handlers to restore.
     * @param Isolator|null   $isolator      The isolator to use.
     */
    public static function restoreErrorHandlers(
        array $errorHandlers,
        Isolator $isolator = null
    ) {
        $isolator = Isolator::get($isolator);

        foreach ($errorHandlers as $errorHandler) {
            static::pushErrorHandler($errorHandler, $isolator);
        }
    }

    /**
     * Invokes a callable by bypassing any error handlers, and using PHP's
     * native error handling.
     *
     * This method is useful for executing legacy PHP code that relies upon '@'
     * suppression or other techniques that are incompatible with
     * exception-based error handling.
     *
     * @param callable      $callable The callable to invoke.
     * @param Isolator|null $isolator The isolator to use.
     *
     * @return mixed The result of the callable's invocation.
     */
    public static function unsafe($callable, Isolator $isolator = null)
    {
        $isolator = Isolator::get($isolator);

        $errorHandlers = static::removeErrorHandlers($isolator);
        $result = $callable();
        static::restoreErrorHandlers($errorHandlers, $isolator);

        return $result;
    }

    /**
     * Creates a new instance of Asplode.
     *
     * This method exists solely to allow one-line installation in PHP 5.3.
     *
     * @return Asplode A new Asplode instance.
     */
    public static function instance()
    {
        return new static;
    }

    /**
     * Construct a new error handler.
     *
     * @param Isolator|null $isolator The isolator to use.
     */
    public function __construct(Isolator $isolator = null)
    {
        $this->isolator = Isolator::get($isolator);
    }

    /**
     * Installs this error handler.
     *
     * @throws Exception\AlreadyInstalledException If this error handler is
     *     already the top-most handler on the stack.
     */
    public function install()
    {
        if (static::currentErrorHandler($this->isolator()) === $this) {
            throw new Exception\AlreadyInstalledException;
        }

        static::pushErrorHandler($this, $this->isolator());
    }

    /**
     * Uninstalls this error handler.
     *
     * @throws Exception\NotInstalledException If this error handler is not the
     *     top-most handler on the stack.
     */
    public function uninstall()
    {
        $errorHandler = static::popErrorHandler($this->isolator());
        if ($errorHandler !== $this) {
            static::pushErrorHandler($errorHandler, $this->isolator());

            throw new Exception\NotInstalledException;
        }
    }

    /**
     * Handles a PHP error.
     *
     * @param integer $severity The severity of the error.
     * @param string  $message  The error message.
     * @param string  $filename The filename in which the error was raised.
     * @param integer $lineno   The line number in which the error was raised.
     *
     * @throws ErrorException Representing the error.
     */
    public function handleError($severity, $message, $filename, $lineno)
    {
        throw new ErrorException($message, 0, $severity, $filename, $lineno);
    }

    /**
     * Handles a PHP error.
     *
     * @param integer $severity The severity of the error.
     * @param string  $message  The error message.
     * @param string  $filename The filename in which the error was raised.
     * @param integer $lineno   The line number in which the error was raised.
     *
     * @throws ErrorException Representing the error.
     */
    public function __invoke($severity, $message, $filename, $lineno)
    {
        return $this->handleError($severity, $message, $filename, $lineno);
    }

    /**
     * @return Isolator
     */
    protected function isolator()
    {
        return $this->isolator;
    }

    private $isolator;
}
