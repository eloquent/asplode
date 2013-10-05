<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode;

use ErrorException;
use Icecave\Isolator\Isolator;
use PHPUnit_Framework_TestCase;
use Phake;

class AsplodeTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->isolator = Phake::mock(Isolator::className());
    }

    public function testInstall()
    {
        Asplode::install($this->isolator);

        Phake::verify($this->isolator)->set_error_handler($this->isInstanceOf(__NAMESPACE__ . '\ErrorHandler'));
    }

    public function testInstallFatalHandler()
    {
        Asplode::installFatalHandler($this->isolator);

        Phake::verify($this->isolator)->register_shutdown_function($this->isInstanceOf(__NAMESPACE__ . '\FatalErrorHandler'));
    }

    public function testAssertCompatibleHandler()
    {
        Phake::when($this->isolator)
            ->trigger_error(Phake::anyParameters())
            ->thenGetReturnByLambda(function ($name, array $arguments) {
                throw new ErrorException($arguments[0], 0, $arguments[1], '/path/to/file', 111);
            });
        Asplode::assertCompatibleHandler($this->isolator);

        Phake::verify($this->isolator)->trigger_error('Error handling is incorrectly configured.', E_USER_NOTICE);
    }

    public function testAssertCompatibleHandlerFailure()
    {
        $this->setExpectedException(__NAMESPACE__ . '\Exception\ErrorHandlingConfigurationException');
        Asplode::assertCompatibleHandler($this->isolator);
    }
}
