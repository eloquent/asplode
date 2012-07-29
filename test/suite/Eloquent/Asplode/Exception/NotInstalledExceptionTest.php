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

use PHPUnit_Framework_TestCase;

/**
 * @covers Eloquent\Asplode\Exception\NotInstalledException
 * @covers Eloquent\Asplode\Exception\LogicException
 * @covers Eloquent\Asplode\Exception\Exception
 * @group exceptions
 * @group core
 */
class NotInstalledExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $exception = new NotInstalledException;
        $expectedMessage = "This instance of Asplode has not been installed.";

        $this->assertSame($expectedMessage, $exception->getMessage());
    }
}
