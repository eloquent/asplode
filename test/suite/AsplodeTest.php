<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode;

use ErrorException;
use Icecave\Isolator\Isolator;
use PHPUnit_Framework_TestCase;
use Phunky;

class AsplodeTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->isolator = Phunky::mock('Icecave\Isolator\Isolator');
    }

    public function testInstall()
    {
        Asplode::install(111, $this->isolator);

        Phunky::verify($this->isolator)->set_error_handler($this->isInstanceOf(__NAMESPACE__ . '\ErrorHandler'));
        Phunky::verify($this->isolator)->str_repeat(' ', 111);
        Phunky::verify($this->isolator)->register_shutdown_function($this->isInstanceOf(__NAMESPACE__ . '\FatalErrorHandler'));
    }

    public function testInstallErrorHandler()
    {
        Asplode::installErrorHandler($this->isolator);

        Phunky::verify($this->isolator)->set_error_handler($this->isInstanceOf(__NAMESPACE__ . '\ErrorHandler'));
        Phunky::verify($this->isolator, Phunky::never())->register_shutdown_function(Phunky::anyParameters());
    }

    public function testInstallFatalHandler()
    {
        Asplode::installFatalHandler(111, $this->isolator);

        Phunky::verify($this->isolator)->str_repeat(' ', 111);
        Phunky::verify($this->isolator)->register_shutdown_function($this->isInstanceOf(__NAMESPACE__ . '\FatalErrorHandler'));
        Phunky::verify($this->isolator, Phunky::never())->set_error_handler(Phunky::anyParameters());
    }

    public function testAssertCompatibleHandler()
    {
        Phunky::when($this->isolator)
            ->trigger_error(Phunky::anyParameters())
            ->thenGetReturnByLambda(function ($message, $errorType) {
                throw new ErrorException($message, 0, $errorType, '/path/to/file', 111);
            });
        Asplode::assertCompatibleHandler($this->isolator);

        Phunky::verify($this->isolator)->trigger_error('Error handling is incorrectly configured.', E_USER_NOTICE);
    }

    public function testAssertCompatibleHandlerFailure()
    {
        $this->setExpectedException(__NAMESPACE__ . '\Exception\ErrorHandlingConfigurationException');
        Asplode::assertCompatibleHandler($this->isolator);
    }
}
