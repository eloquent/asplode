<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode;

/**
 * The interface implemented by Asplode error handlers.
 */
interface ErrorHandlerInterface
{
    /**
     * Set an error handler to use as a fallback for errors that are not handled
     * by Asplode.
     *
     * Errors not handled by Asplode include deprecation messages, and '@'
     * suppressed errors.
     *
     * @param callable|null $fallbackHandler The fallback handler to use, or null to use the default PHP handler.
     */
    public function setFallbackHandler($fallbackHandler = null);

    /**
     * Get the error handler used as a fallback for errors that are not handled
     * by Asplode.
     *
     * @return callable The fallback error handler.
     */
    public function fallbackHandler();

    /**
     * Installs this error handler.
     *
     * @throws Exception\AlreadyInstalledException           If this error handler is already the top-most handler on the stack.
     * @throws Exception\ErrorHandlingConfigurationException If the error reporting level is incorrectly configured.
     */
    public function install();

    /**
     * Uninstalls this error handler.
     *
     * @throws Exception\NotInstalledException If this error handler is not the top-most handler on the stack.
     */
    public function uninstall();

    /**
     * Returns true if this error handler is the top-most handler on the stack.
     *
     * @return boolean True if this error handler is the top-most handler on the stack.
     */
    public function isInstalled();

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
    public function handle($severity, $message, $filename, $lineno);
}
