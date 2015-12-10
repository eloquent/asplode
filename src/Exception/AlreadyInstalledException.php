<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode\Exception;

use Exception;

/**
 * This Asplode instance has already been installed.
 */
final class AlreadyInstalledException extends Exception implements
    AsplodeExceptionInterface
{
    /**
     * Construct a new already installed exception.
     *
     * @param Exception|null $previous The cause, if available.
     */
    public function __construct(Exception $previous = null)
    {
        parent::__construct(
            'This instance of Asplode has already been installed.',
            0,
            $previous
        );
    }
}
