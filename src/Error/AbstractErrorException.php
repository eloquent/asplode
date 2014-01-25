<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode\Error;

use ErrorException;
use Exception;

/**
 * An abstract base class for implementing extensions to the built-in error
 * exception.
 */
abstract class AbstractErrorException extends ErrorException
{
    /**
     * Construct a new error exception.
     *
     * @param string         $message    The error message.
     * @param integer        $severity   The error severity.
     * @param string         $path       The path to the file in which the error occurred.
     * @param integer        $lineNumber The line number on which the error occurred.
     * @param Exception|null $previous   The cause, if available.
     */
    public function __construct(
        $message,
        $severity,
        $path,
        $lineNumber,
        Exception $previous = null
    ) {
        parent::__construct(
            $message,
            0,
            $severity,
            $path,
            $lineNumber,
            $previous
        );
    }
}
