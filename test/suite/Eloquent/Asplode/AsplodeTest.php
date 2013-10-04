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

        $this->handlerStack = array();
        $handler = set_error_handler(function() {});
        while (null !== $handler) {
            $this->handlerStack[] = $handler;
            restore_error_handler();
            restore_error_handler();
            $handler = set_error_handler(function() {});
        }
        restore_error_handler();

        $this->isolator = Phake::mock(Isolator::className());
        $this->asplode = new Asplode($this->isolator);

        Phake::when($this->isolator)->error_reporting()->thenReturn(E_ALL | E_NOTICE | E_USER_NOTICE | E_STRICT);
    }

    protected function tearDown()
    {
        parent::tearDown();

        foreach ($this->handlerStack as $handler) {
            set_error_handler($handler);
        }
    }

    public function testAssertCompatibleHandler()
    {
        Phake::when($this->isolator)
            ->trigger_error(Phake::anyParameters())
            ->thenGetReturnByLambda(function ($name, array $arguments) {
                throw new ErrorException($arguments[0], 111, $arguments[1], '/path/to/file', 222);
            });
        Asplode::assertCompatibleHandler($this->isolator);

        $this->assertTrue(true);
    }

    public function testAssertCompatibleHandlerFailure()
    {
        $this->setExpectedException(__NAMESPACE__ . '\Exception\ErrorHandlingConfigurationException');
        Asplode::assertCompatibleHandler($this->isolator);
    }

    public function testCurrentErrorHandler()
    {
        Phake::when($this->isolator)->set_error_handler(Phake::anyParameters())->thenReturn('foo');

        $this->assertSame('foo', Asplode::currentErrorHandler($this->isolator));
        $restoreErrorHandlerVerification = Phake::verify($this->isolator, Phake::times(2))->restore_error_handler();
        Phake::inOrder(
            Phake::verify($this->isolator)->set_error_handler(function () {}),
            $restoreErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            Phake::verify($this->isolator)->set_error_handler('foo')
        );
    }

    public function testCurrentErrorHandlerStack()
    {
        Phake::when($this->isolator)
            ->set_error_handler(Phake::anyParameters())
            ->thenReturn('foo')
            ->thenReturn('bar')
            ->thenReturn(null);

        $this->assertSame(array('foo', 'bar'), Asplode::currentErrorHandlerStack($this->isolator));
        $setEmptyErrorHandlerVerification = Phake::verify(
            $this->isolator,
            Phake::times(3)
        )->set_error_handler(function () {});
        $restoreErrorHandlerVerification = Phake::verify(
            $this->isolator,
            Phake::times(6)
        )->restore_error_handler();
        Phake::inOrder(
            $setEmptyErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $setEmptyErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $setEmptyErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            Phake::verify($this->isolator)->set_error_handler('foo'),
            Phake::verify($this->isolator)->set_error_handler('bar')
        );
    }

    public function testPushErrorHandler()
    {
        Asplode::pushErrorHandler('foo', $this->isolator);

        Phake::verify($this->isolator)->set_error_handler('foo');
    }

    public function testPopErrorHandler()
    {
        Phake::when($this->isolator)->set_error_handler(Phake::anyParameters())->thenReturn('foo');

        $this->assertSame('foo', Asplode::popErrorHandler($this->isolator));
        $restoreErrorHandlerVerification = Phake::verify($this->isolator, Phake::times(2))->restore_error_handler();
        Phake::inOrder(
            Phake::verify($this->isolator)->set_error_handler(function () {}),
            $restoreErrorHandlerVerification,
            $restoreErrorHandlerVerification
        );
    }

    public function testRemoveErrorHandlers()
    {
        Phake::when($this->isolator)
            ->set_error_handler(Phake::anyParameters())
            ->thenReturn('foo')
            ->thenReturn('bar')
            ->thenReturn(null);

        $this->assertSame(array('foo', 'bar'), Asplode::removeErrorHandlers($this->isolator));
        $setEmptyErrorHandlerVerification = Phake::verify(
            $this->isolator,
            Phake::times(3)
        )->set_error_handler(function () {});
        $restoreErrorHandlerVerification = Phake::verify(
            $this->isolator,
            Phake::times(6)
        )->restore_error_handler();
        Phake::inOrder(
            $setEmptyErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $setEmptyErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $setEmptyErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $restoreErrorHandlerVerification
        );
    }

    public function testRestoreErrorHandlers()
    {
        Asplode::restoreErrorHandlers(array('foo', 'bar'), $this->isolator);

        Phake::inOrder(
            Phake::verify($this->isolator)->set_error_handler('foo'),
            Phake::verify($this->isolator)->set_error_handler('bar')
        );
    }

    public function testUnsafe()
    {
        $callable = Phake::partialMock(
            __NAMESPACE__ . '\Test\CallableWrapper',
            function () {
                return 'foobar';
            }
        );
        Phake::when($this->isolator)
            ->set_error_handler(Phake::anyParameters())
            ->thenReturn('foo')
            ->thenReturn('bar')
            ->thenReturn(null);

        $this->assertSame('foobar', Asplode::unsafe($callable, $this->isolator));
        $setEmptyErrorHandlerVerification = Phake::verify(
            $this->isolator,
            Phake::times(3)
        )->set_error_handler(function () {});
        $restoreErrorHandlerVerification = Phake::verify(
            $this->isolator,
            Phake::times(6)
        )->restore_error_handler();
        Phake::inOrder(
            $setEmptyErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $setEmptyErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $setEmptyErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            Phake::verify($callable)->__invoke(),
            Phake::verify($this->isolator)->set_error_handler('foo'),
            Phake::verify($this->isolator)->set_error_handler('bar')
        );
    }

    public function testInstance()
    {
        $this->assertInstanceOf(__NAMESPACE__.'\Asplode', Asplode::instance());
    }

    public function testConstructor()
    {
        $expected = function() {
            return false;
        };

        $this->assertEquals($expected, $this->asplode->fallbackHandler());
    }

    public function testSetFallbackHandler()
    {
        $arguments = null;
        $fallbackHandler = function () {};
        $this->asplode->setFallbackHandler($fallbackHandler);

        $this->assertSame($fallbackHandler, $this->asplode->fallbackHandler());
    }

    public function testInstall()
    {
        $this->asplode->install();

        $restoreErrorHandlerVerification = Phake::verify($this->isolator, Phake::times(2))->restore_error_handler();
        Phake::inOrder(
            Phake::verify($this->isolator)->set_error_handler(function () {}),
            $restoreErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            Phake::verify($this->isolator)->set_error_handler($this->identicalTo($this->asplode))
        );
    }

    public function testInstallFailureConfiguration()
    {
        Phake::when($this->isolator)->error_reporting()->thenReturn(0);

        $this->setExpectedException(__NAMESPACE__.'\Exception\ErrorHandlingConfigurationException');
        $this->asplode->install();
    }

    public function testInstallFailureAlreadyInstalled()
    {
        Phake::when($this->isolator)->set_error_handler(Phake::anyParameters())->thenReturn($this->asplode);

        $this->setExpectedException(__NAMESPACE__.'\Exception\AlreadyInstalledException');
        $this->asplode->install();
    }

    public function testUninstall()
    {
        Phake::when($this->isolator)->set_error_handler(Phake::anyParameters())->thenReturn($this->asplode);
        $this->asplode->uninstall();

        $restoreErrorHandlerVerification = Phake::verify($this->isolator, Phake::times(2))->restore_error_handler();
        Phake::inOrder(
            Phake::verify($this->isolator)->set_error_handler(function () {}),
            $restoreErrorHandlerVerification,
            $restoreErrorHandlerVerification
        );
    }

    public function testUninstallFailure()
    {
        Phake::when($this->isolator)->set_error_handler(Phake::anyParameters())->thenReturn('foo');
        $caught = false;
        try {
            $this->asplode->uninstall();
        } catch (Exception\NotInstalledException $e) {
            $caught = true;
        }

        $this->assertSame(true, $caught);
        $restoreErrorHandlerVerification = Phake::verify($this->isolator, Phake::times(2))->restore_error_handler();
        Phake::inOrder(
            Phake::verify($this->isolator)->set_error_handler(function () {}),
            $restoreErrorHandlerVerification,
            $restoreErrorHandlerVerification,
            Phake::verify($this->isolator)->set_error_handler('foo')
        );
    }

    public function testHandleError()
    {
        $expected = new ErrorException('foo', 0, E_USER_ERROR, 'bar', 111);

        try {
            $this->asplode->handleError(E_USER_ERROR, 'foo', 'bar', 111);
        } catch (ErrorException $actual) {
            $this->assertEquals($expected, $actual);

            return;
        }

        $this->fail('No ErrorException was thrown.');
    }

    public function testHandleErrorFallbackDefault()
    {
        $this->asplode->handleError(E_DEPRECATED, 'foo', 'bar', 111);

        $this->assertTrue(true);
    }

    public function testHandleErrorDeprecated()
    {
        $arguments = null;
        $fallbackHandler = function () use (&$arguments) {
            $arguments = func_get_args();
        };
        $this->asplode->setFallbackHandler($fallbackHandler);
        $this->asplode->handleError(E_DEPRECATED, 'foo', 'bar', 111);

        $this->assertSame(array(E_DEPRECATED, 'foo', 'bar', 111), $arguments);
    }

    public function testHandleErrorUserDeprecated()
    {
        $arguments = null;
        $fallbackHandler = function () use (&$arguments) {
            $arguments = func_get_args();
        };
        $this->asplode->setFallbackHandler($fallbackHandler);
        $this->asplode->handleError(E_USER_DEPRECATED, 'foo', 'bar', 111);

        $this->assertSame(array(E_USER_DEPRECATED, 'foo', 'bar', 111), $arguments);
    }

    public function testHandleErrorAtSuppression()
    {
        $arguments = null;
        $fallbackHandler = function () use (&$arguments) {
            $arguments = func_get_args();
        };
        $this->asplode->setFallbackHandler($fallbackHandler);
        Phake::when($this->isolator)->error_reporting()->thenReturn(0);
        $this->asplode->handleError(E_USER_ERROR, 'foo', 'bar', 111);

        $this->assertSame(array(E_USER_ERROR, 'foo', 'bar', 111), $arguments);
    }

    public function testInvoke()
    {
        $asplode = $this->asplode;
        $expected = new ErrorException('foo', 0, E_USER_ERROR, 'bar', 111);

        try {
            $asplode(E_USER_ERROR, 'foo', 'bar', 111);
        } catch (ErrorException $actual) {
            $this->assertEquals($expected, $actual);

            return;
        }

        $this->fail('No ErrorException was thrown.');
    }
}
