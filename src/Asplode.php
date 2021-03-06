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

use Eloquent\Asplode\Exception\ErrorHandlingConfigurationException;
use ErrorException;
use Icecave\Isolator\Isolator;

/**
 * Implements static convenience methods for use with Asplode.
 */
abstract class Asplode
{
    /**
     * Installs a new error handler, and a new fatal error handler
     * simultaneously.
     *
     * @param integer       $reservedMemory The amount of memory to reserve for fatal error handling.
     * @param Isolator|null $isolator       The isolator to use.
     *
     * @return tuple<ErrorHandlerInterface,FatalErrorHandlerInterface> A tuple containing the installed error handler and fatal error handler.
     * @throws ErrorHandlingConfigurationException                     If the error reporting level is incorrectly configured.
     */
    public static function install(
        $reservedMemory = 1048576,
        Isolator $isolator = null
    ) {
        $fatalHandler = static::installFatalHandler($reservedMemory, $isolator);

        return array(static::installErrorHandler($isolator), $fatalHandler);
    }

    /**
     * Installs a new error handler.
     *
     * @param Isolator|null $isolator The isolator to use.
     *
     * @return ErrorHandlerInterface               The installed error handler.
     * @throws ErrorHandlingConfigurationException If the error reporting level is incorrectly configured.
     */
    public static function installErrorHandler(Isolator $isolator = null)
    {
        $handler = new ErrorHandler(null, $isolator);
        $handler->install();

        return $handler;
    }

    /**
     * Installs a new fatal error handler.
     *
     * This handler will, on shutdown, detect any installed exception handler,
     * and pass an exception representing any fatal errors to said handler.
     *
     * @param integer       $reservedMemory The amount of memory to reserve for fatal error handling.
     * @param Isolator|null $isolator       The isolator to use.
     *
     * @return FatalErrorHandlerInterface The installed fatal error handler.
     */
    public static function installFatalHandler(
        $reservedMemory = 1048576,
        Isolator $isolator = null
    ) {
        $handler = new FatalErrorHandler(null, $isolator);
        $handler->install($reservedMemory);

        return $handler;
    }

    /**
     * Asserts that an error handling is configured in a way that is compatible
     * with code expecting error exceptions.
     *
     * @param Isolator|null $isolator The isolator to use.
     *
     * @throws ErrorHandlingConfigurationException If error handling is not configured correctly.
     */
    public static function assertCompatibleHandler(Isolator $isolator = null)
    {
        $isolator = Isolator::get($isolator);
        $message = 'Error handling is incorrectly configured.';

        try {
            $isolator->trigger_error($message, E_USER_NOTICE);
        } catch (ErrorException $e) {
            if (
                $e->getMessage() === $message &&
                $e->getSeverity() === E_USER_NOTICE
            ) {
                return;
            }
        }

        throw new ErrorHandlingConfigurationException();
    }
}
