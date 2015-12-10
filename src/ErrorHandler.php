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
 * The standard Asplode error handler.
 */
class ErrorHandler implements ErrorHandlerInterface
{
    /**
     * Construct a new error handler.
     *
     * @param HandlerStack\HandlerStackInterface|null $stack    The error handler stack to use.
     * @param Isolator|null                           $isolator The isolator to use.
     */
    public function __construct(
        HandlerStack\HandlerStackInterface $stack = null,
        Isolator $isolator = null
    ) {
        $this->isolator = Isolator::get($isolator);
        if (null === $stack) {
            $stack = new HandlerStack\ErrorHandlerStack($isolator);
        }

        $this->setFallbackHandler();
        $this->stack = $stack;
    }

    /**
     * Get the error handler stack.
     *
     * @return HandlerStack\HandlerStackInterface The error handler stack.
     */
    public function stack()
    {
        return $this->stack;
    }

    /**
     * Set an error handler to use as a fallback for errors that are not handled
     * by Asplode.
     *
     * Errors not handled by Asplode include deprecation messages, and '@'
     * suppressed errors.
     *
     * @param callable|null $fallbackHandler The fallback handler to use, or null to use the default PHP handler.
     */
    public function setFallbackHandler($fallbackHandler = null)
    {
        if (null === $fallbackHandler) {
            $fallbackHandler = function () {
                return false;
            };
        }

        $this->fallbackHandler = $fallbackHandler;
    }

    /**
     * Get the error handler used as a fallback for errors that are not handled
     * by Asplode.
     *
     * @return callable The fallback error handler.
     */
    public function fallbackHandler()
    {
        return $this->fallbackHandler;
    }

    /**
     * Installs this error handler.
     *
     * @throws Exception\AlreadyInstalledException           If this error handler is already the top-most handler on the stack.
     * @throws Exception\ErrorHandlingConfigurationException If the error reporting level is incorrectly configured.
     */
    public function install()
    {
        if (0 === $this->isolator()->error_reporting()) {
            throw new Exception\ErrorHandlingConfigurationException();
        }
        if ($this->isInstalled()) {
            throw new Exception\AlreadyInstalledException();
        }

        $this->stack()->push($this);
    }

    /**
     * Uninstalls this error handler.
     *
     * @throws Exception\NotInstalledException If this error handler is not the top-most handler on the stack.
     */
    public function uninstall()
    {
        $handler = $this->stack()->pop();
        if ($handler !== $this) {
            if (null !== $handler) {
                $this->stack()->push($handler);
            }

            throw new Exception\NotInstalledException();
        }
    }

    /**
     * Returns true if this error handler is the top-most handler on the stack.
     *
     * @return boolean True if this error handler is the top-most handler on the stack.
     */
    public function isInstalled()
    {
        return $this->stack()->handler() === $this;
    }

    /**
     * Handles a PHP error.
     *
     * @param integer $severity The severity of the error.
     * @param string  $message  The error message.
     * @param string  $filename The filename in which the error was raised.
     * @param integer $lineno   The line number in which the error was raised.
     *
     * @return boolean                               False if the error is a deprecation message, or '@' suppression is in use.
     * @throws Error\NonFatalErrorExceptionInterface Representing the error, unless the error is a deprecation message, or '@' suppression is in use.
     */
    public function handle($severity, $message, $filename, $lineno)
    {
        if (
            E_DEPRECATED === $severity ||
            E_USER_DEPRECATED === $severity ||
            0 === $this->isolator()->error_reporting()
        ) {
            $fallbackHandler = $this->fallbackHandler();

            return $fallbackHandler($severity, $message, $filename, $lineno);
        }

        throw new Error\ErrorException($message, $severity, $filename, $lineno);
    }

    /**
     * Handles a PHP error.
     *
     * @param integer $severity The severity of the error.
     * @param string  $message  The error message.
     * @param string  $filename The filename in which the error was raised.
     * @param integer $lineno   The line number in which the error was raised.
     *
     * @return boolean                               False if the error is a deprecation message, or '@' suppression is in use.
     * @throws Error\NonFatalErrorExceptionInterface Representing the error, unless the error is a deprecation message, or '@' suppression is in use.
     */
    public function __invoke($severity, $message, $filename, $lineno)
    {
        return $this->handle($severity, $message, $filename, $lineno);
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

    private $stack;
    private $fallbackHandler;
    private $isolator;
}
