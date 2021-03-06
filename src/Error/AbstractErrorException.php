<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode\Error;

use ErrorException;
use Exception;
use ReflectionClass;

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

        $reflector = new ReflectionClass('Exception');

        $fileProperty = $reflector->getProperty('file');
        $fileProperty->setAccessible(true);
        $lineProperty = $reflector->getProperty('line');
        $lineProperty->setAccessible(true);
        $traceProperty = $reflector->getProperty('trace');
        $traceProperty->setAccessible(true);

        $fileProperty->setValue($this, $path);
        $lineProperty->setValue($this, $lineNumber);

        $trace = $this->getTrace();

        foreach ($trace as $index => $call) {
            if (
                isset($call['class']) &&
                0 === strpos($call['class'], 'Eloquent\Asplode\\')
            ) {
                unset($trace[$index]);
            }
        }

        $traceProperty->setValue($this, $trace);
    }
}
