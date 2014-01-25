<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode\HandlerStack;

use Exception;
use Icecave\Isolator\Isolator;
use Phake;
use PHPUnit_Framework_TestCase;

/**
 * @covers \Eloquent\Asplode\HandlerStack\ExceptionHandlerStack
 * @covers \Eloquent\Asplode\HandlerStack\AbstractHandlerStack
 */
class ExceptionHandlerStackTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->isolator = Phake::mock(Isolator::className());
        $this->stack = new ExceptionHandlerStack($this->isolator);
    }

    public function testHandler()
    {
        Phake::when($this->isolator)->set_exception_handler(Phake::anyParameters())->thenReturn('foo');

        $this->assertSame('foo', $this->stack->handler());
        $restoreVerification = Phake::verify($this->isolator, Phake::times(2))->restore_exception_handler();
        Phake::inOrder(
            Phake::verify($this->isolator)->set_exception_handler(function () {}),
            $restoreVerification,
            $restoreVerification,
            Phake::verify($this->isolator)->set_exception_handler('foo')
        );
    }

    public function testHandlerEmptyStack()
    {
        Phake::when($this->isolator)->set_exception_handler(Phake::anyParameters())->thenReturn(null);

        $this->assertNull($this->stack->handler());
        Phake::inOrder(
            Phake::verify($this->isolator)->set_exception_handler(function () {}),
            Phake::verify($this->isolator)->restore_exception_handler()
        );
        Phake::verify($this->isolator, Phake::never())->set_exception_handler(null);
    }

    public function testHandlerStack()
    {
        Phake::when($this->isolator)
            ->set_exception_handler(Phake::anyParameters())
            ->thenReturn('foo')
            ->thenReturn('bar')
            ->thenReturn(null);

        $this->assertSame(array('foo', 'bar'), $this->stack->handlerStack());
        $setEmptyVerification = Phake::verify($this->isolator, Phake::times(3))->set_exception_handler(function () {});
        $restoreVerification = Phake::verify($this->isolator, Phake::times(5))->restore_exception_handler();
        Phake::inOrder(
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            Phake::verify($this->isolator)->set_exception_handler('foo'),
            Phake::verify($this->isolator)->set_exception_handler('bar')
        );
    }

    public function testHandlerStackEmptyStack()
    {
        Phake::when($this->isolator)
            ->set_exception_handler(Phake::anyParameters())
            ->thenReturn(null);

        $this->assertSame(array(), $this->stack->handlerStack());
        Phake::inOrder(
            Phake::verify($this->isolator)->set_exception_handler(function () {}),
            Phake::verify($this->isolator)->restore_exception_handler()
        );
    }

    public function testPush()
    {
        $this->stack->push('foo');

        Phake::verify($this->isolator)->set_exception_handler('foo');
        Phake::verify($this->isolator, Phake::never())->restore_exception_handler();
    }

    public function testPop()
    {
        Phake::when($this->isolator)
            ->set_exception_handler(Phake::anyParameters())
            ->thenReturn('foo');

        $this->assertSame('foo', $this->stack->pop());
    }

    public function testPushAll()
    {
        $this->stack->pushAll(array('foo', 'bar'));

        Phake::inOrder(
            Phake::verify($this->isolator)->set_exception_handler('foo'),
            Phake::verify($this->isolator)->set_exception_handler('bar')
        );
        Phake::verify($this->isolator, Phake::never())->restore_exception_handler();
    }

    public function testClear()
    {
        Phake::when($this->isolator)
            ->set_exception_handler(Phake::anyParameters())
            ->thenReturn('foo')
            ->thenReturn('bar')
            ->thenReturn(null);

        $this->assertSame(array('foo', 'bar'), $this->stack->clear());
        $setEmptyVerification = Phake::verify($this->isolator, Phake::times(3))->set_exception_handler(function () {});
        $restoreVerification = Phake::verify($this->isolator, Phake::times(5))->restore_exception_handler();
        Phake::inOrder(
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
        Phake::when($this->isolator)
            ->set_exception_handler(Phake::anyParameters())
            ->thenReturn(null);

        $this->assertSame(array(), $this->stack->clear());
        Phake::inOrder(
            Phake::verify($this->isolator)->set_exception_handler(function () {}),
            Phake::verify($this->isolator)->restore_exception_handler()
        );
    }

    public function testRestore()
    {
        Phake::when($this->isolator)
            ->set_exception_handler(Phake::anyParameters())
            ->thenReturn('foo')
            ->thenReturn(null);
        $this->stack->restore(array('bar', 'baz'));

        $setEmptyVerification = Phake::verify($this->isolator, Phake::times(2))->set_exception_handler(function () {});
        $restoreVerification = Phake::verify($this->isolator, Phake::times(3))->restore_exception_handler();
        Phake::inOrder(
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            Phake::verify($this->isolator)->set_exception_handler('bar'),
            Phake::verify($this->isolator)->set_exception_handler('baz')
        );
    }

    public function testExecuteWith()
    {
        $callable = Phake::partialMock(
            'Eloquent\Asplode\Test\CallableWrapper',
            function () {
                return 'foobar';
            }
        );
        Phake::when($this->isolator)
            ->set_exception_handler(Phake::anyParameters())
            ->thenReturn('foo')
            ->thenReturn('bar')
            ->thenReturn(null)
            ->thenReturn('baz')
            ->thenReturn(null);

        $this->assertSame('foobar', $this->stack->executeWith($callable, 'baz'));
        $setEmptyVerification = Phake::verify($this->isolator, Phake::times(4))->set_exception_handler(function () {});
        $restoreVerification = Phake::verify($this->isolator, Phake::times(6))->restore_exception_handler();
        Phake::inOrder(
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            Phake::verify($this->isolator)->set_exception_handler('baz'),
            Phake::verify($callable)->__invoke(),
            $setEmptyVerification,
            $restoreVerification,
            Phake::verify($this->isolator)->set_exception_handler('foo'),
            Phake::verify($this->isolator)->set_exception_handler('bar')
        );
    }

    public function testExecuteWithEmptyStack()
    {
        $callable = Phake::partialMock(
            'Eloquent\Asplode\Test\CallableWrapper',
            function () {
                return 'foobar';
            }
        );
        Phake::when($this->isolator)
            ->set_exception_handler(Phake::anyParameters())
            ->thenReturn(null)
            ->thenReturn('foo')
            ->thenReturn(null);

        $this->assertSame('foobar', $this->stack->executeWith($callable, 'foo'));
        $setEmptyVerification = Phake::verify($this->isolator, Phake::times(2))->set_exception_handler(function () {});
        $restoreVerification = Phake::verify($this->isolator, Phake::times(2))->restore_exception_handler();
        Phake::inOrder(
            $setEmptyVerification,
            $restoreVerification,
            Phake::verify($this->isolator)->set_exception_handler('foo'),
            Phake::verify($callable)->__invoke(),
            $setEmptyVerification,
            $restoreVerification
        );
    }

    public function testExecuteWithNoHandler()
    {
        $callable = Phake::partialMock(
            'Eloquent\Asplode\Test\CallableWrapper',
            function () {
                return 'foobar';
            }
        );
        Phake::when($this->isolator)
            ->set_exception_handler(Phake::anyParameters())
            ->thenReturn('foo')
            ->thenReturn('bar')
            ->thenReturn(null);

        $this->assertSame('foobar', $this->stack->executeWith($callable));
        $setEmptyVerification = Phake::verify($this->isolator, Phake::times(4))->set_exception_handler(function () {});
        $restoreVerification = Phake::verify($this->isolator, Phake::times(6))->restore_exception_handler();
        Phake::inOrder(
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            Phake::verify($callable)->__invoke(),
            $setEmptyVerification,
            $restoreVerification,
            Phake::verify($this->isolator)->set_exception_handler('foo'),
            Phake::verify($this->isolator)->set_exception_handler('bar')
        );
    }

    public function testExecuteWithException()
    {
        Phake::when($this->isolator)
            ->set_exception_handler(Phake::anyParameters())
            ->thenReturn('foo')
            ->thenReturn('bar')
            ->thenReturn(null);
        $error = new Exception;
        $callable = Phake::partialMock(
            'Eloquent\Asplode\Test\CallableWrapper',
            function () use ($error) {
                throw $error;
            }
        );
        $caught = null;
        try {
            $this->stack->executeWith($callable);
        } catch (Exception $caught) {}

        $this->assertSame($error, $caught);
        $setEmptyVerification = Phake::verify($this->isolator, Phake::times(4))->set_exception_handler(function () {});
        $restoreVerification = Phake::verify($this->isolator, Phake::times(6))->restore_exception_handler();
        Phake::inOrder(
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            $restoreVerification,
            $setEmptyVerification,
            $restoreVerification,
            Phake::verify($callable)->__invoke(),
            $setEmptyVerification,
            $restoreVerification,
            Phake::verify($this->isolator)->set_exception_handler('foo'),
            Phake::verify($this->isolator)->set_exception_handler('bar')
        );
    }
}
