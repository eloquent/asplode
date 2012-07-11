<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode\Exception;

use Eloquent\Asplode\Test\TestCase;
use Phake;

class LogicExceptionTest extends TestCase
{
    /**
     * @covers Eloquent\Asplode\Exception\LogicException
     * @covers Eloquent\Asplode\Exception\Exception
     * @group exceptions
     * @group core
     */
    public function testException()
    {
        $message = 'foo';
        $previous = new \Exception;
        $exception = Phake::partialMock(
            __NAMESPACE__.'\LogicException',
            $message,
            $previous
        );

        $this->assertSame($message, $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
