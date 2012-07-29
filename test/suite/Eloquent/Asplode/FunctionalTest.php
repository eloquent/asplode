<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class FunctionalTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test one line installation.
     */
    public function testOneLineInstallation()
    {
        \Eloquent\Asplode\Asplode::instance()->install();
        $actual = set_error_handler(function() {
        });
        restore_error_handler();
        restore_error_handler();

        $this->assertTrue(is_array($actual));
        $this->assertSame(array(0, 1), array_keys($actual));
        $this->assertInstanceOf('Eloquent\Asplode\Asplode', $actual[0]);
        $this->assertSame('handleError', $actual[1]);
        $this->assertTrue(is_callable($actual));
    }

    /**
     * Test legacy PHP error example.
     */
    public function testLegacyPhpError()
    {
        $this->setExpectedException('PHPUnit_Framework_Error_Warning');
        $fp = fopen(uniqid(), 'r');
    }

    /**
     * Test Asplode error handling.
     */
    public function testAsplodeHandling()
    {
        \Eloquent\Asplode\Asplode::instance()->install();
        $caught = false;
        try {
            $fp = fopen(uniqid(), 'r');
        } catch (ErrorException $e) {
            $caught = true;
        }

        $this->assertTrue($caught);
    }
}
