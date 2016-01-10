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

use Icecave\Isolator\Isolator;
use PHPUnit_Framework_TestCase;
use Phunky;

class FatalErrorHandlerTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->stack = Phunky::mock(__NAMESPACE__ . '\HandlerStack\HandlerStackInterface');
        $this->isolator = Phunky::mock('Icecave\Isolator\Isolator');
        $this->handler = Phunky::partialMock(__NAMESPACE__ . '\FatalErrorHandler', $this->stack, $this->isolator);

        $this->exceptionHandler = Phunky::partialMock(
            'Eloquent\Asplode\Test\CallableWrapper',
            function () {
                return 'foobar';
            }
        );
        Phunky::when($this->stack)->handler()->thenReturn($this->exceptionHandler);

        Phunky::when($this->isolator)->error_reporting()->thenReturn(E_ALL);
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
        $this->handler = new FatalErrorHandler();

        $this->assertInstanceOf(__NAMESPACE__ . '\HandlerStack\ExceptionHandlerStack', $this->handler->stack());
    }

    public function testInstall()
    {
        $this->handler->install();

        $this->assertTrue($this->handler->isInstalled());
        Phunky::inOrder(
            Phunky::verify($this->handler)->beforeRegister(),
            Phunky::verify($this->handler)->loadClasses(),
            Phunky::verify($this->isolator)->class_exists(__NAMESPACE__ . '\Error\FatalErrorException'),
            Phunky::verify($this->handler)->reserveMemory(),
            Phunky::verify($this->isolator)->str_repeat(' ', 1048576),
            Phunky::verify($this->isolator)->register_shutdown_function($this->handler)
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

        Phunky::verify($this->handler, Phunky::never())->handleFatalError(Phunky::anyParameters());
    }

    public function testHandleNoError()
    {
        $handler = $this->handler;
        $handler->install();
        $handler();

        Phunky::verify($this->handler, Phunky::never())->handleFatalError(Phunky::anyParameters());
    }

    public function testHandleFatal()
    {
        Phunky::when($this->isolator)->error_get_last()->thenReturn(
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

        $freeMemoryVerification = Phunky::verify($this->handler)->freeMemory();
        $handleVerification = Phunky::verify($this->handler)->handleFatalError(Phunky::capture($error));
        $this->assertInstanceOf(__NAMESPACE__ . '\Error\FatalErrorException', $error);
        $this->assertSame('message', $error->getMessage());
        $this->assertSame(E_ERROR, $error->getSeverity());
        $this->assertSame('/path/to/file', $error->getFile());
        $this->assertSame(111, $error->getLine());
        Phunky::inOrder(
            $freeMemoryVerification,
            $handleVerification,
            Phunky::verify($this->exceptionHandler)->__invoke($error)
        );
    }

    public function testHandleFatalNoHandler()
    {
        Phunky::when($this->isolator)->error_get_last()->thenReturn(
            array(
                'message' => 'message',
                'type' => E_ERROR,
                'file' => '/path/to/file',
                'line' => 111,
            )
        );
        Phunky::when($this->stack)->handler()->thenReturn(null);
        $handler = $this->handler;
        $handler->install();
        $handler();

        Phunky::inOrder(
            Phunky::verify($this->handler)->freeMemory(),
            Phunky::verify($this->handler)->handleFatalError(Phunky::capture($error))
        );
        $this->assertInstanceOf(__NAMESPACE__ . '\Error\FatalErrorException', $error);
        $this->assertSame('message', $error->getMessage());
        $this->assertSame(E_ERROR, $error->getSeverity());
        $this->assertSame('/path/to/file', $error->getFile());
        $this->assertSame(111, $error->getLine());
        Phunky::verify($this->exceptionHandler, Phunky::never())->__invoke(Phunky::anyParameters());
    }
}
