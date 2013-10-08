# Asplode

*Drop-in exception-based error handling for PHP.*

[![Build status]][Latest build]
[![Test coverage]][Test coverage report]
[![Uses semantic versioning]][SemVer]

## Installation and documentation

* Available as [Composer] package [eloquent/asplode].
* [API documentation] available.

## Usage

Installing the *Asplode* error handler can be achieved by a single statement:

```php
Eloquent\Asplode\Asplode::install();
```

## What does *Asplode* do?

*Asplode* is very simple library that sets up an [error handler] to throw
[ErrorException] exceptions instead of using the default PHP error handler. This
method of error handling has proven to be extremely effective, and similar
systems are in use across major PHP frameworks such as [Symfony].

## Why use *Asplode*?

Exceptions offer a much more consistent way to handle errors. In modern PHP
development it is generally considered best-practice to use an exception rather
than a legacy-style error.

*Asplode* offers a hassle-free way to improve the error handling in a PHP
project. It also provides a consistent error handling implementation across
any project or library it's used in, allowing for easier integration.

## Fatal error handling

*Asplode* provides a simple way to improve the handling of fatal errors. Whilst
fatals can't really be handled in the same way as regular errors, if a global
exception handler is installed, it can be passed an Exception representing the
fatal error just before PHP execution completes. This allows developers to
gracefully inform the user of fatal errors before shutdown occurs.

```php
// a global exception handler must be in place:
set_exception_handler(
    function (Exception $e) {
        echo $e->getMessage();
    }
);

Eloquent\Asplode\Asplode::installFatalHandler();
```

## Asserting that the current error handler is compatible

Code that assumes the use of *Asplode* will not work as expected unless the
right type of error handler is installed. For example, code expecting to catch
an `ErrorException` on failure will have unpredictable results if the installed
error handler does not throw `ErrorException` instances.

To ensure that a correctly configured error handler is installed, *Asplode*
provides the `Asplode::assertCompatibleHandler()` method:

```php
use Eloquent\Asplode\Asplode;
use Eloquent\Asplode\Exception\ErrorHandlingConfigurationException;

try {
    Asplode::assertCompatibleHandler();
} catch (ErrorHandlingConfigurationException $e) {
    // handle appropriately
}
```

## Executing legacy code

Sometimes it is unavoidable to work with code that uses bad practices. For
example, a old PHP library might be quite functional and useful, but it may not
anticipate exceptions being thrown when an error occurs.

*Asplode*'s handler stacks both implement an `executeWith()` method that allows
code to be executed with a different handler than the one currently installed.
This method pops all current handlers off the stack temporarily, installs the
specified handler (if one is provided), executes the supplied callback, restores
the handler stack, and returns the result of the callback's execution.

```php
use Eloquent\Asplode\HandlerStack\ErrorHandlerStack;

$stack = new ErrorHandlerStack;

$result = $stack->executeWith(
    function () {
        // this code will be executed under the default handler
    }
);

$result = $stack->executeWith(
    function () {
        // this code will be executed under the supplied handler
    },
    'errorHandlerFunctionName'
);

$result = $stack->executeWith(
    function () {
        // this code will be executed under the supplied handler
    },
    function ($severity, $message, $path, $lineNumber) {
        // handle the error
    }
);
```

## Managing PHP's handler stacks

PHP's error handlers and exception handlers function roughly as a [stack].
However, the implementation is quite limited, and frankly, bad. *Asplode*
includes classes to aid in management of these stacks, which can be harnessed to
manage error handling in a simple, and flexible manner.

The two classes responsible for management of these stacks are
[ErrorHandlerStack] and [ExceptionHandlerStack]. Both implement
[HandlerStackInterface]. These classes do not require the use of the *Asplode*
handler, they can be used in a standalone manner to manage the handler stacks.

## Migrating existing code to work with Asplode

When the *Asplode* error handler is installed, the [error_reporting] setting
will no longer have any effect. Notices, warnings, and errors will all throw an
exception. Deprecation notices will not throw an exception, but will still be
logged, as long as PHP's error logging is correctly configured.

Code that has been written to handle legacy-style PHP errors will most likely
need to be re-written. As an example, this type of logic:

```php
$fp = fopen('/path/to/foo', 'r'); // this throws a PHP warning if the file is not found

if ($fp === false) {
  // handle error opening file
}
```

would need to be replaced with something like:

```php
try {
  $fp = fopen('/path/to/foo', 'r');
} catch (ErrorException $e) {
  // handle error opening file
}
```

It's important to note that PHP can be very inconsistent in the way it handles
error conditions. In some cases functions will simply return a boolean false
when an error occurs; or it may have even stranger, less standard behaviour.

*Asplode* does not free the developer from the responsibility of reading the PHP
documentation, or making sure that they account for all possible outcomes.

<!-- References -->

[API documentation]: http://lqnt.co/asplode/artifacts/documentation/api/
[Composer]: http://getcomposer.org/
[eloquent/asplode]: https://packagist.org/packages/eloquent/asplode
[error handler]: http://php.net/set_error_handler
[error_reporting]: http://php.net/error_reporting
[ErrorException]: http://php.net/ErrorException
[ErrorHandlerStack]: http://lqnt.co/asplode/artifacts/documentation/api/Eloquent/Asplode/HandlerStack/ErrorHandlerStack.html
[ExceptionHandlerStack]: http://lqnt.co/asplode/artifacts/documentation/api/Eloquent/Asplode/HandlerStack/ExceptionHandlerStack.html
[HandlerStackInterface]: http://lqnt.co/asplode/artifacts/documentation/api/Eloquent/Asplode/HandlerStack/HandlerStackInterface.html
[stack]: http://en.wikipedia.org/wiki/Stack_(abstract_data_type)
[Symfony]: http://symfony.com/

[Build status]: https://api.travis-ci.org/eloquent/asplode.png?branch=master
[Composer]: http://getcomposer.org/
[eloquent/asplode]: https://packagist.org/packages/eloquent/asplode
[Latest build]: https://travis-ci.org/eloquent/asplode
[SemVer]: http://semver.org/
[Test coverage report]: https://coveralls.io/r/eloquent/asplode
[Test coverage]: https://coveralls.io/repos/eloquent/asplode/badge.png?branch=master
[Uses semantic versioning]: http://b.repl.ca/v1/semver-yes-brightgreen.png
