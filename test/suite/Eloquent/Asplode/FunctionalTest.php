<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2013 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class FunctionalTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->handlerStack = \Eloquent\Asplode\Asplode::removeErrorHandlers();
    }

    protected function tearDown()
    {
        parent::tearDown();

        \Eloquent\Asplode\Asplode::removeErrorHandlers();
        \Eloquent\Asplode\Asplode::restoreErrorHandlers($this->handlerStack);
    }

    /**
     * Test one line installation.
     */
    public function testOneLineInstallation()
    {
        var_dump(version_compare(PHP_VERSION, '5.4.0'));ob_flush();
        if (!version_compare(PHP_VERSION, '5.4.0')) {
            $this->markTestSkipped('Requires PHP >= 5.4');

            return;
        }

        // eval because otherwise 5.3 complains about syntax
        eval('(new \Eloquent\Asplode\Asplode)->install();');
        $actual = set_error_handler(function() {
        });
        restore_error_handler();
        restore_error_handler();

        $this->assertInstanceOf(
            '\Eloquent\Asplode\Asplode',
            $actual
        );
    }

    /**
     * Test one line installation for PHP 5.3.
     */
    public function testOneLineInstallationPhp53()
    {
        \Eloquent\Asplode\Asplode::instance()->install();
        $actual = set_error_handler(function() {
        });
        restore_error_handler();
        restore_error_handler();

        $this->assertInstanceOf(
            '\Eloquent\Asplode\Asplode',
            $actual
        );
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
