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
 * This Asplode instance has not been installed.
 */
final class NotInstalledException extends Exception implements
    AsplodeExceptionInterface
{
    /**
     * Construct a new not installed exception.
     *
     * @param Exception|null $previous The cause, if available.
     */
    public function __construct(Exception $previous = null)
    {
        parent::__construct(
            'This instance of Asplode has not been installed.',
            0,
            $previous
        );
    }
}
