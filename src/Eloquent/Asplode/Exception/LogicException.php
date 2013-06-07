<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode\Exception;

use Exception as NativeException;
use LogicException as NativeLogicException;

/**
 * Abstract base class for exceptions that arise from logic errors in code.
 */
abstract class LogicException extends NativeLogicException implements Exception
{
    /**
     * Construct a new logic exception.
     *
     * @param string               $message  The exception message.
     * @param NativeException|null $previous The previous exception, if available.
     */
    public function __construct($message, NativeException $previous = null)
    {
        parent::__construct((string) $message, 0, $previous);
    }
}
