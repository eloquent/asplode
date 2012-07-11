<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode;

use Eloquent\Asplode\Test\TestCase;
use Phake;

/**
 * @covers Eloquent\Asplode\Asplode
 * @group core
 */
class AsplodeTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->_isolator = Phake::mock('IcecaveStudios\Isolator\Isolator');
        $this->_asplode = new Asplode($this->_isolator);
    }

    public function testInstall()
    {
        Phake::when($this->_isolator)
            ->set_error_handler(Phake::anyParameters())
            ->thenReturn(null)
        ;
        $this->_asplode->install();

        Phake::verify($this->_isolator)->set_error_handler(
            $this->identicalTo(array($this->_asplode, 'handleError'))
        );
    }

    public function testInstallFailure()
    {
        Phake::when($this->_isolator)
            ->set_error_handler(Phake::anyParameters())
            ->thenReturn(null)
        ;
        $this->_asplode->install();

        $this->setExpectedException(
          __NAMESPACE__.'\Exception\AlreadyInstalledException'
        );
        $this->_asplode->install();
    }

    public function testUninstall()
    {
        Phake::when($this->_isolator)
            ->set_error_handler(Phake::anyParameters())
            ->thenReturn(null)
        ;
        $this->_asplode->install();
        $this->_asplode->uninstall();

        Phake::verify($this->_isolator)->set_error_handler(
            $this->identicalTo(array($this->_asplode, 'handleError'))
        );
        Phake::verify($this->_isolator)->restore_error_handler();
    }

    public function testUninstallFailure()
    {
        $this->setExpectedException(
            __NAMESPACE__.'\Exception\NotInstalledException'
        );
        $this->_asplode->uninstall();
    }

    public function testHandleError()
    {
        $expected = new \ErrorException('foo', 0, E_USER_ERROR, 'bar', 111);

        try {
            $this->_asplode->handleError(E_USER_ERROR, 'foo', 'bar', 111);
        } catch (\ErrorException $actual) {
            $this->assertEquals($expected, $actual);

            return;
        }

        $this->fail('No ErrorException was thrown.');
    }

    public function testInstance()
    {
        $this->assertInstanceOf(__NAMESPACE__.'\Asplode', Asplode::instance());
    }
}
