<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode\HandlerStack;

use Exception;
use Icecave\Isolator\Isolator;
use PHPUnit_Framework_TestCase;
use Phunky;

/**
 * @covers \Eloquent\Asplode\HandlerStack\ErrorHandlerStack
 * @covers \Eloquent\Asplode\HandlerStack\AbstractHandlerStack
 */
class ErrorHandlerStackTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->isolator = Phunky::mock('Icecave\Isolator\Isolator');
        $this->stack = new ErrorHandlerStack($this->isolator);
    }

    public function testHandler()
    {
        Phunky::when($this->isolator)->set_error_handler(Phunky::anyParameters())->thenReturn('foo');

        $this->assertSame('foo', $this->stack->handler());
        $restoreVerification = Phunky::verify($this->isolator, Phunky::times(2))->restore_error_handler();
        Phunky::inOrder(
            Phunky::verify($this->isolator)->set_error_handler(function () {}),
            $restoreVerification,
            $restoreVerification,
            Phunky::verify($this->isolator)->set_error_handler('foo')
        );
    }

    public function testHandlerEmptyStack()
    {
        Phunky::when($this->isolator)->set_error_handler(Phunky::anyParameters())->thenReturn(null);

        $this->assertNull($this->stack->handler());
        Phunky::inOrder(
            Phunky::verify($this->isolator)->set_error_handler(function () {}),
            Phunky::verify($this->isolator)->restore_error_handler()
        );
        Phunky::verify($this->isolator, Phunky::never())->set_error_handler(null);
    }

    public function testHandlerStack()
    {
        Phunky::when($this->isolator)
            ->set_error_handler(Phunky::anyParameters())
            ->thenReturn('foo')
            ->thenReturn('bar')
            ->thenReturn(null);

        $this->assertSame(array('foo', 'bar'), $this->stack->handlerStack());
        $setEmptyVerification = Phunky::verify($this->isolator, Phunky::times(3))->set_error_handler(function () {});
        $restoreVerification = Phunky::verify($this->isolator, Phunky::times(5))->restore_error_handler();
        Phunky::inOrder(
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            Phunky::verify($this->isolator)->set_error_handler('foo'),
            Phunky::verify($this->isolator)->set_error_handler('bar')
        );
    }

    public function testHandlerStackEmptyStack()
    {
        Phunky::when($this->isolator)
            ->set_error_handler(Phunky::anyParameters())
            ->thenReturn(null);

        $this->assertSame(array(), $this->stack->handlerStack());
        Phunky::inOrder(
            Phunky::verify($this->isolator)->set_error_handler(function () {}),
            Phunky::verify($this->isolator)->restore_error_handler()
        );
    }

    public function testPush()
    {
        $this->stack->push('foo');

        Phunky::verify($this->isolator)->set_error_handler('foo');
        Phunky::verify($this->isolator, Phunky::never())->restore_error_handler();
    }

    public function testPop()
    {
        Phunky::when($this->isolator)
            ->set_error_handler(Phunky::anyParameters())
            ->thenReturn('foo');

        $this->assertSame('foo', $this->stack->pop());
    }

    public function testPushAll()
    {
        $this->stack->pushAll(array('foo', 'bar'));

        Phunky::inOrder(
            Phunky::verify($this->isolator)->set_error_handler('foo'),
            Phunky::verify($this->isolator)->set_error_handler('bar')
        );
        Phunky::verify($this->isolator, Phunky::never())->restore_error_handler();
    }

    public function testClear()
    {
        Phunky::when($this->isolator)
            ->set_error_handler(Phunky::anyParameters())
            ->thenReturn('foo')
            ->thenReturn('bar')
            ->thenReturn(null);

        $this->assertSame(array('foo', 'bar'), $this->stack->clear());
        $setEmptyVerification = Phunky::verify($this->isolator, Phunky::times(3))->set_error_handler(function () {});
        $restoreVerification = Phunky::verify($this->isolator, Phunky::times(5))->restore_error_handler();
        Phunky::inOrder(
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification
        );
    }

    public function testClearEmptyStack()
    {
        Phunky::when($this->isolator)
            ->set_error_handler(Phunky::anyParameters())
            ->thenReturn(null);

        $this->assertSame(array(), $this->stack->clear());
        Phunky::inOrder(
            Phunky::verify($this->isolator)->set_error_handler(function () {}),
            Phunky::verify($this->isolator)->restore_error_handler()
        );
    }

    public function testRestore()
    {
        Phunky::when($this->isolator)
            ->set_error_handler(Phunky::anyParameters())
            ->thenReturn('foo')
            ->thenReturn(null);
        $this->stack->restore(array('bar', 'baz'));

        $setEmptyVerification = Phunky::verify($this->isolator, Phunky::times(2))->set_error_handler(function () {});
        $restoreVerification = Phunky::verify($this->isolator, Phunky::times(3))->restore_error_handler();
        Phunky::inOrder(
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            Phunky::verify($this->isolator)->set_error_handler('bar'),
            Phunky::verify($this->isolator)->set_error_handler('baz')
        );
    }

    public function testExecuteWith()
    {
        $callable = Phunky::partialMock(
            'Eloquent\Asplode\Test\CallableWrapper',
            function () {
                return 'foobar';
            }
        );
        Phunky::when($this->isolator)
            ->set_error_handler(Phunky::anyParameters())
            ->thenReturn('foo')
            ->thenReturn('bar')
            ->thenReturn(null)
            ->thenReturn('baz')
            ->thenReturn(null);

        $this->assertSame('foobar', $this->stack->executeWith($callable, 'baz'));
        $setEmptyVerification = Phunky::verify($this->isolator, Phunky::times(4))->set_error_handler(function () {});
        $restoreVerification = Phunky::verify($this->isolator, Phunky::times(6))->restore_error_handler();
        Phunky::inOrder(
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            Phunky::verify($this->isolator)->set_error_handler('baz'),
            Phunky::verify($callable)->__invoke(),
            $setEmptyVerification,
            $restoreVerification,
            Phunky::verify($this->isolator)->set_error_handler('foo'),
            Phunky::verify($this->isolator)->set_error_handler('bar')
        );
    }

    public function testExecuteWithEmptyStack()
    {
        $callable = Phunky::partialMock(
            'Eloquent\Asplode\Test\CallableWrapper',
            function () {
                return 'foobar';
            }
        );
        Phunky::when($this->isolator)
            ->set_error_handler(Phunky::anyParameters())
            ->thenReturn(null)
            ->thenReturn('foo')
            ->thenReturn(null);

        $this->assertSame('foobar', $this->stack->executeWith($callable, 'foo'));
        $setEmptyVerification = Phunky::verify($this->isolator, Phunky::times(2))->set_error_handler(function () {});
        $restoreVerification = Phunky::verify($this->isolator, Phunky::times(2))->restore_error_handler();
        Phunky::inOrder(
            $setEmptyVerification,
            $restoreVerification,
            Phunky::verify($this->isolator)->set_error_handler('foo'),
            Phunky::verify($callable)->__invoke(),
            $setEmptyVerification,
            $restoreVerification
        );
    }

    public function testExecuteWithNoHandler()
    {
        $callable = Phunky::partialMock(
            'Eloquent\Asplode\Test\CallableWrapper',
            function () {
                return 'foobar';
            }
        );
        Phunky::when($this->isolator)
            ->set_error_handler(Phunky::anyParameters())
            ->thenReturn('foo')
            ->thenReturn('bar')
            ->thenReturn(null);

        $this->assertSame('foobar', $this->stack->executeWith($callable));
        $setEmptyVerification = Phunky::verify($this->isolator, Phunky::times(4))->set_error_handler(function () {});
        $restoreVerification = Phunky::verify($this->isolator, Phunky::times(6))->restore_error_handler();
        Phunky::inOrder(
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            Phunky::verify($callable)->__invoke(),
            $setEmptyVerification,
            $restoreVerification,
            Phunky::verify($this->isolator)->set_error_handler('foo'),
            Phunky::verify($this->isolator)->set_error_handler('bar')
        );
    }

    public function testExecuteWithException()
    {
        Phunky::when($this->isolator)
            ->set_error_handler(Phunky::anyParameters())
            ->thenReturn('foo')
            ->thenReturn('bar')
            ->thenReturn(null);
        $error = new Exception();
        $callable = Phunky::partialMock(
            'Eloquent\Asplode\Test\CallableWrapper',
            function () use ($error) {
                throw $error;
            }
        );
        $caught = null;
        try {
            $this->stack->executeWith($callable);
        } catch (Exception $caught) {
        }

        $this->assertSame($error, $caught);
        $setEmptyVerification = Phunky::verify($this->isolator, Phunky::times(4))->set_error_handler(function () {});
        $restoreVerification = Phunky::verify($this->isolator, Phunky::times(6))->restore_error_handler();
        Phunky::inOrder(
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            Phunky::verify($callable)->__invoke(),
            $setEmptyVerification,
            $restoreVerification,
            Phunky::verify($this->isolator)->set_error_handler('foo'),
            Phunky::verify($this->isolator)->set_error_handler('bar')
        );
    }
}
