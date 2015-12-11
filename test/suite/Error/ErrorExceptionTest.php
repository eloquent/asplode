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

use Exception;
use PHPUnit_Framework_TestCase;

/**
 * @covers \Eloquent\Asplode\Error\ErrorException
 * @covers \Eloquent\Asplode\Error\AbstractErrorException
 */
class ErrorExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $previous = new Exception();
        $exception = new ErrorException('message', 111, '/path/to/file', 222, $previous);

        $this->assertSame('message', $exception->getMessage());
        $this->assertSame(111, $exception->getSeverity());
        $this->assertSame('/path/to/file', $exception->getFile());
        $this->assertSame(222, $exception->getLine());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
