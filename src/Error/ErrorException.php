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

/**
 * Represents a non-fatal error by extending the native error exception to mark
 * it with appropriate interfaces.
 */
final class ErrorException extends AbstractErrorException implements
    NonFatalErrorExceptionInterface
{
}
