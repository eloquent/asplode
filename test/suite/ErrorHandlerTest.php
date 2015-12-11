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

class ErrorHandlerTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->stack = Phunky::mock(__NAMESPACE__ . '\HandlerStack\HandlerStackInterface');
        $this->isolator = Phunky::mock('Icecave\Isolator\Isolator');
        $this->handler = new ErrorHandler($this->stack, $this->isolator);

        Phunky::when($this->isolator)->error_reporting()->thenReturn(E_ALL);
    }

    public function testConstructor()
    {
        $expectedFallbackHandler = function () {
            return false;
        };

        $this->assertSame($this->stack, $this->handler->stack());
        $this->assertEquals($expectedFallbackHandler, $this->handler->fallbackHandler());
    }

    public function testConstructorDefaults()
    {
        $this->handler = new ErrorHandler();

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

        Phunky::verify($this->stack)->push($this->handler);
    }

    public function testInstallFailureConfiguration()
    {
        Phunky::when($this->isolator)->error_reporting()->thenReturn(0);

        $this->setExpectedException(__NAMESPACE__ . '\Exception\ErrorHandlingConfigurationException');
        $this->handler->install();
    }

    public function testInstallFailureAlreadyInstalled()
    {
        Phunky::when($this->stack)->handler()->thenReturn($this->handler);

        $this->setExpectedException(__NAMESPACE__ . '\Exception\AlreadyInstalledException');
        $this->handler->install();
    }

    public function testUninstall()
    {
        Phunky::when($this->stack)->pop()->thenReturn($this->handler);
        $this->handler->uninstall();

        Phunky::verify($this->stack)->pop();
    }

    public function testUninstallFailure()
    {
        Phunky::when($this->stack)->pop()->thenReturn('foo');
        $caught = false;
        try {
            $this->handler->uninstall();
        } catch (Exception\NotInstalledException $e) {
            $caught = true;
        }

        $this->assertSame(true, $caught);
        Phunky::verify($this->stack)->push('foo');
    }

    public function testUninstallFailureEmptyStack()
    {
        Phunky::when($this->stack)->pop()->thenReturn(null);
        $caught = false;
        try {
            $this->handler->uninstall();
        } catch (Exception\NotInstalledException $e) {
            $caught = true;
        }

        $this->assertSame(true, $caught);
        Phunky::verify($this->stack, Phunky::never())->push(Phunky::anyParameters());
    }

    public function testIsInstalled()
    {
        Phunky::when($this->stack)->handler()
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
        Phunky::when($this->isolator)->error_reporting()->thenReturn(0);
        $this->handler->handle(E_USER_ERROR, 'foo', 'bar', 111);

        $this->assertSame(array(E_USER_ERROR, 'foo', 'bar', 111), $arguments);
    }
}
