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

/**
 * PHP's error handling is incorrectly configured.
 */
final class ErrorHandlingConfigurationException extends LogicException
{
    /**
     * Construct a new error handling configuration exception.
     *
     * @param NativeException|null $previous The previous exception, if available.
     */
    public function __construct(NativeException $previous = null)
    {
        parent::__construct(
            'Error handling is incorrectly configured.',
            $previous
        );
    }
}
