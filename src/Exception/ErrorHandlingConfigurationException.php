<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode\Exception;

use Exception;

/**
 * PHP's error handling is incorrectly configured.
 */
final class ErrorHandlingConfigurationException extends Exception implements
    AsplodeExceptionInterface
{
    /**
     * Construct a new error handling configuration exception.
     *
     * @param Exception|null $previous The cause, if available.
     */
    public function __construct(Exception $previous = null)
    {
        parent::__construct(
            'Error handling is incorrectly configured.',
            0,
            $previous
        );
    }
}
