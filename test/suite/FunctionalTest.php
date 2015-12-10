<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Eloquent\Asplode\HandlerStack\ErrorHandlerStack;
use Eloquent\Asplode\HandlerStack\ExceptionHandlerStack;

class FunctionalTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->errorHandlerStack = new ErrorHandlerStack();
        $this->exceptionHandlerStack = new ExceptionHandlerStack();

        $this->errorHandlers = $this->errorHandlerStack->clear();
        $this->exceptionHandlers = $this->exceptionHandlerStack->clear();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->errorHandlerStack->restore($this->errorHandlers);
        $this->exceptionHandlerStack->restore($this->exceptionHandlers);
    }

    /**
     * Test one line installation.
     */
    public function testOneLineInstallation()
    {
        Eloquent\Asplode\Asplode::install();
        $actual = set_error_handler(function () {});
        restore_error_handler();
        restore_error_handler();

        $this->assertInstanceOf('Eloquent\Asplode\ErrorHandler', $actual);
    }

    /**
     * Test error handling.
     */
    public function testHandling()
    {
        Eloquent\Asplode\Asplode::install();
        $caught = false;
        try {
            $fp = fopen(uniqid(), 'r');
        } catch (ErrorException $e) {
            $caught = true;
        }

        $this->assertTrue($caught);
    }

    /**
     * Test error handling for recoverable fatals.
     */
    public function testHandlingRecoverableFatal()
    {
        $callback = function (Iterator $o) {};
        Eloquent\Asplode\Asplode::install();
        $caught = false;
        try {
            $callback(new stdClass());
        } catch (ErrorException $e) {
            $caught = true;
        }

        $this->assertTrue($caught);
    }

    /**
     * Test '@' suppression.
     */
    public function testAtSuppressionHandling()
    {
        Eloquent\Asplode\Asplode::install();
        $caught = false;
        try {
            $fp = @fopen(uniqid(), 'r');
        } catch (ErrorException $e) {
            $caught = true;
        }

        $this->assertFalse($caught);
    }

    /**
     * Test fatal error handling.
     */
    public function testFatalHandlingUndefinedFunction()
    {
        $source = <<<'EOD'
require %s;

set_exception_handler(
    function (Exception $e) {
        printf('Caught %%s', var_export($e->getMessage(), true));
    }
);

Eloquent\Asplode\Asplode::installFatalHandler();
foo();
EOD;
        $source = sprintf($source, var_export(__DIR__ . '/../../vendor/autoload.php', true));
        exec(sprintf('php -r %s 2>&1', escapeshellarg($source)), $output, $exitCode);
        $output = implode(PHP_EOL, $output);

        $this->assertNotEquals(0, $exitCode);
        $this->assertContains("Caught 'Call to undefined function foo()'", $output);
    }

    /**
     * Test out of memory fatal error handling.
     */
    public function testFatalHandlingOutOfMemory()
    {
        $source = <<<'EOD'
require %s;

set_exception_handler(
    function (Exception $e) {
        $memory = str_repeat(' ', 10240); // Verify that the memory freed by the fatal handler can be re-used.
        printf('Caught %%s' . PHP_EOL, var_export($e->getMessage(), true));
    }
);
Eloquent\Asplode\Asplode::installFatalHandler();

$_SERVER['memory'] = '';
while (true) {
    $_SERVER['memory'] .= ' ';
}
EOD;
        $source = sprintf($source, var_export(__DIR__ . '/../../vendor/autoload.php', true));
        exec(sprintf('php -dmemory_limit=15000000 -r %s 2>&1', escapeshellarg($source)), $output, $exitCode);
        $output = implode(PHP_EOL, $output);

        $this->assertNotEquals(0, $exitCode);
        $this->assertRegExp(
            "/Caught 'Allowed memory size of \d+ bytes exhausted \(tried to allocate \d+ bytes\)'/",
            $output
        );
    }
}
