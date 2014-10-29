<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode;

use Icecave\Isolator\Isolator;
use PHPUnit_Framework_TestCase;
use Phake;

class FatalErrorHandlerTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->stack = Phake::mock(__NAMESPACE__ . '\HandlerStack\HandlerStackInterface');
        $this->isolator = Phake::mock('Icecave\Isolator\Isolator');
        $this->handler = Phake::partialMock(__NAMESPACE__ . '\FatalErrorHandler', $this->stack, $this->isolator);

        $this->exceptionHandler = Phake::partialMock(
            'Eloquent\Asplode\Test\CallableWrapper',
            function () {
                return 'foobar';
            }
        );
        Phake::when($this->stack)->handler()->thenReturn($this->exceptionHandler);

        Phake::when($this->isolator)->error_reporting()->thenReturn(E_ALL);
    }

    public function testConstructor()
    {
        $expectedFallbackHandler = function () {
            return false;
        };

        $this->assertSame($this->stack, $this->handler->stack());
    }

    public function testConstructorDefaults()
    {
        $this->handler = new FatalErrorHandler;

        $this->assertInstanceOf(__NAMESPACE__ . '\HandlerStack\ExceptionHandlerStack', $this->handler->stack());
    }

    public function testInstall()
    {
        $this->handler->install();

        $this->assertTrue($this->handler->isInstalled());
        Phake::inOrder(
            Phake::verify($this->handler)->beforeRegister(),
            Phake::verify($this->handler)->loadClasses(),
            Phake::verify($this->isolator)->class_exists(__NAMESPACE__ . '\Error\FatalErrorException'),
            Phake::verify($this->handler)->reserveMemory(),
            Phake::verify($this->isolator)->str_repeat(' ', 10240),
            Phake::verify($this->isolator)->register_shutdown_function($this->handler)
        );
    }

    public function testInstallFailureAlreadyInstalled()
    {
        $this->handler->install();

        $this->setExpectedException(__NAMESPACE__ . '\Exception\AlreadyInstalledException');
        $this->handler->install();
    }

    public function testUninstall()
    {
        $this->handler->install();
        $this->handler->uninstall();

        $this->assertFalse($this->handler->isInstalled());
    }

    public function testUninstallFailure()
    {
        $this->setExpectedException(__NAMESPACE__ . '\Exception\NotInstalledException');
        $this->handler->uninstall();
    }

    public function testHandleDisabled()
    {
        $handler = $this->handler;
        $handler->install();
        $handler->uninstall();
        $handler();

        Phake::verify($this->handler, Phake::never())->handleFatalError(Phake::anyParameters());
    }

    public function testHandleNoError()
    {
        $handler = $this->handler;
        $handler->install();
        $handler();

        Phake::verify($this->handler, Phake::never())->handleFatalError(Phake::anyParameters());
    }

    public function testHandleFatal()
    {
        Phake::when($this->isolator)->error_get_last()->thenReturn(
            array(
                'message' => 'message',
                'type' => E_ERROR,
                'file' => '/path/to/file',
                'line' => 111,
            )
        );
        $handler = $this->handler;
        $handler->install();
        $handler();

        $freeMemoryVerification = Phake::verify($this->handler)->freeMemory();
        $handleVerification = Phake::verify($this->handler)->handleFatalError(Phake::capture($error));
        $this->assertInstanceOf(__NAMESPACE__ . '\Error\FatalErrorException', $error);
        $this->assertSame('message', $error->getMessage());
        $this->assertSame(E_ERROR, $error->getSeverity());
        $this->assertSame('/path/to/file', $error->getFile());
        $this->assertSame(111, $error->getLine());
        Phake::inOrder(
            $freeMemoryVerification,
            $handleVerification,
            Phake::verify($this->exceptionHandler)->__invoke($error)
        );
    }

    public function testHandleFatalNoHandler()
    {
        Phake::when($this->isolator)->error_get_last()->thenReturn(
            array(
                'message' => 'message',
                'type' => E_ERROR,
                'file' => '/path/to/file',
                'line' => 111,
            )
        );
        Phake::when($this->stack)->handler()->thenReturn(null);
        $handler = $this->handler;
        $handler->install();
        $handler();

        Phake::inOrder(
            Phake::verify($this->handler)->freeMemory(),
            Phake::verify($this->handler)->handleFatalError(Phake::capture($error))
        );
        $this->assertInstanceOf(__NAMESPACE__ . '\Error\FatalErrorException', $error);
        $this->assertSame('message', $error->getMessage());
        $this->assertSame(E_ERROR, $error->getSeverity());
        $this->assertSame('/path/to/file', $error->getFile());
        $this->assertSame(111, $error->getLine());
        Phake::verify($this->exceptionHandler, Phake::never())->__invoke(Phake::anyParameters());
    }
}
