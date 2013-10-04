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
 * Implements static convenience methods for use with Asplode.
 */
abstract class Asplode
{
    /**
     * Installs a new Asplode error handler.
     *
     * @return ErrorHandlerInterface                         The installed error handler.
     * @throws Exception\ErrorHandlingConfigurationException If the error reporting level is incorrectly configured.
     */
    public static function install()
    {
        $handler = new ErrorHandler;
        $handler->install();

        return $handler;
    }

    /**
     * Installs a new Asplode fatal error handler.
     *
     * This handler will, on shutdown, detect any installed exception handler,
     * and pass an exception representing any fatal errors to said handler.
     *
     * @return FatalErrorHandlerInterface The installed fatal error handler.
     */
    public static function installFatalHandler()
    {
        $handler = new FatalErrorHandler;
        $handler->install();

        return $handler;
    }

    /**
     * Asserts that an error handling is configured in a way that is compatible
     * with code expecting error exceptions.
     *
     * @param Isolator|null $isolator The isolator to use.
     *
     * @throws Exception\ErrorHandlingConfigurationException If error handling is not configured correctly.
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

        throw new Exception\ErrorHandlingConfigurationException;
    }
}
