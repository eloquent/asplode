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

use Icecave\Isolator\Isolator;
use PHPUnit_Framework_TestCase;
use Phake;

class ErrorHandlerTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->stack = Phake::mock(__NAMESPACE__ . '\HandlerStack\HandlerStackInterface');
        $this->isolator = Phake::mock(Isolator::className());
        $this->handler = new ErrorHandler($this->stack, $this->isolator);

        Phake::when($this->isolator)->error_reporting()->thenReturn(E_ALL);
    }

    public function testConstructor()
    {
        $expectedFallbackHandler = function() {
            return false;
        };

        $this->assertSame($this->stack, $this->handler->stack());
        $this->assertEquals($expectedFallbackHandler, $this->handler->fallbackHandler());
    }

    public function testConstructorDefaults()
    {
        $this->handler = new ErrorHandler;

        $this->assertInstanceOf(__NAMESPACE__ . '\HandlerStack\ErrorHandlerStack', $this->handler->stack());
    }

    public function testSetFallbackHandler()
    {
        $arguments = null;
        $fallbackHandler = function () {};
        $this->handler->setFallbackHandler($fallbackHandler);

        $this->assertSame($fallbackHandler, $this->handler->fallbackHandler());
    }

    public function testInstall()
    {
        $this->handler->install();

        Phake::verify($this->stack)->push($this->handler);
    }

    public function testInstallFailureConfiguration()
    {
        Phake::when($this->isolator)->error_reporting()->thenReturn(0);

        $this->setExpectedException(__NAMESPACE__ . '\Exception\ErrorHandlingConfigurationException');
        $this->handler->install();
    }

    public function testInstallFailureAlreadyInstalled()
    {
        Phake::when($this->stack)->handler()->thenReturn($this->handler);

        $this->setExpectedException(__NAMESPACE__ . '\Exception\AlreadyInstalledException');
        $this->handler->install();
    }

    public function testUninstall()
    {
        Phake::when($this->stack)->pop()->thenReturn($this->handler);
        $this->handler->uninstall();

        Phake::verify($this->stack)->pop();
    }

    public function testUninstallFailure()
    {
        Phake::when($this->stack)->pop()->thenReturn('foo');
        $caught = false;
        try {
            $this->handler->uninstall();
        } catch (Exception\NotInstalledException $e) {
            $caught = true;
        }

        $this->assertSame(true, $caught);
        Phake::verify($this->stack)->push('foo');
    }

    public function testUninstallFailureEmptyStack()
    {
        Phake::when($this->stack)->pop()->thenReturn(null);
        $caught = false;
        try {
            $this->handler->uninstall();
        } catch (Exception\NotInstalledException $e) {
            $caught = true;
        }

        $this->assertSame(true, $caught);
        Phake::verify($this->stack, Phake::never())->push(Phake::anyParameters());
    }

    public function testIsInstalled()
    {
        Phake::when($this->stack)->handler()
            ->thenReturn(null)
            ->thenReturn('foo')
            ->thenReturn($this->handler);

        $this->assertFalse($this->handler->isInstalled());
        $this->assertFalse($this->handler->isInstalled());
        $this->assertTrue($this->handler->isInstalled());
    }

    public function testHandle()
    {
        $handler = $this->handler;

        try {
            $handler(E_USER_ERROR, 'foo', 'bar', 111);
        } catch (Error\ErrorException $error) {
            $this->assertSame('foo', $error->getMessage());
            $this->assertSame(E_USER_ERROR, $error->getSeverity());
            $this->assertSame('bar', $error->getFile());
            $this->assertSame(111, $error->getLine());

            return;
        }

        $this->fail('No exception was thrown.');
    }

    public function testHandleFallbackDefault()
    {
        $this->handler->handle(E_DEPRECATED, 'foo', 'bar', 111);

        $this->assertTrue(true);
    }

    public function testHandleDeprecated()
    {
        $arguments = null;
        $fallbackHandler = function () use (&$arguments) {
            $arguments = func_get_args();
        };
        $this->handler->setFallbackHandler($fallbackHandler);
        $this->handler->handle(E_DEPRECATED, 'foo', 'bar', 111);

        $this->assertSame(array(E_DEPRECATED, 'foo', 'bar', 111), $arguments);
    }

    public function testHandleUserDeprecated()
    {
        $arguments = null;
        $fallbackHandler = function () use (&$arguments) {
            $arguments = func_get_args();
        };
        $this->handler->setFallbackHandler($fallbackHandler);
        $this->handler->handle(E_USER_DEPRECATED, 'foo', 'bar', 111);

        $this->assertSame(array(E_USER_DEPRECATED, 'foo', 'bar', 111), $arguments);
    }

    public function testHandleAtSuppression()
    {
        $arguments = null;
        $fallbackHandler = function () use (&$arguments) {
            $arguments = func_get_args();
        };
        $this->handler->setFallbackHandler($fallbackHandler);
        Phake::when($this->isolator)->error_reporting()->thenReturn(0);
        $this->handler->handle(E_USER_ERROR, 'foo', 'bar', 111);

        $this->assertSame(array(E_USER_ERROR, 'foo', 'bar', 111), $arguments);
    }
}
