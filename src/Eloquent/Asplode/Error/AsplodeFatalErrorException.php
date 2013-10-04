<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode\Error;

use ErrorException;

/**
 * Represents a fatal error by extending the native error exception to mark it
 * with appropriate interfaces.
 */
final class AsplodeFatalErrorException extends ErrorException implements
    FatalErrorExceptionInterface
{
}
