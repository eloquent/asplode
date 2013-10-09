# Asplode

*Drop-in exception-based error handling for PHP.*

[![Build status]][Latest build]
[![Test coverage]][Test coverage report]
[![Uses semantic versioning]][SemVer]

## Installation and documentation

* Available as [Composer] package [eloquent/asplode].
* [API documentation] available.

## Usage

The *Asplode* error handler can be installed with a single statement:

```php
Eloquent\Asplode\Asplode::install();
```

## What does *Asplode* do?

*Asplode* is a very simple PHP [error handler] implementation that throws
[ErrorException] exceptions instead of using the default PHP error handling
behaviour. This means that all non-fatal runtime errors are presented to the
developer in the form of an exception. It also means that any unhandled errors
are delivered to a single point: the global exception handler.

## Why use *Asplode*?

Developers need the ability to decide how their code behaves when an error
occurs. Exceptions offer the only truly consistent way to report and recover
from errors in PHP.

This method of handling errors has proven to be extremely effective. Similar
strategies are used in major PHP frameworks such as [Symfony]. *Asplode* is a
standalone implementation that can be used for any project.

## Fatal error handling

While it's not feasible to *recover* from fatal PHP errors, it is possible to
*report* fatal errors in the same manner as uncaught exceptions.

With *Asplode*, fatal errors cause a synthesized exception representing the
fatal error to be passed to the global exception handler. This allows developers
to gracefully inform the user of fatal errors just before the PHP interpreter is
shut down.

The *Asplode* fatal error handler is installed by default, but is only activated
if a global exception handler is installed.

```php
set_exception_handler(
    function (Exception $e) {
        echo $e->getMessage();
    }
);

Eloquent\Asplode\Asplode::install();
```

To use *Asplode* without the fatal error handler, use
`Asplode::installErrorHandler()` instead of `Asplode::install()`. To use only
the fatal error handler, use `Asplode::installFatalHandler()`.

Note that attempting to autoload files in the shutdown phase of PHP may be
probelmatic; and as such, custom exception handlers should explicitly load their
dependencies where possible.

## Asserting that the current error handler is compatible

Code that assumes the use of *Asplode* may not work as expected unless the right
type of error handler is installed. For example, code expecting to catch an
`ErrorException` on failure will have unpredictable results if the installed
error handler does not throw `ErrorException` instances.

To ensure that a correctly configured error handler is installed, *Asplode*
provides the `Asplode::assertCompatibleHandler()` method.

```php
use Eloquent\Asplode\Asplode;
use Eloquent\Asplode\Exception\ErrorHandlingConfigurationException;

try {
    Asplode::assertCompatibleHandler();
} catch (ErrorHandlingConfigurationException $e) {
    // handle appropriately
}
```

A *compatible* error handler is any handler that throws `ErrorException`
exceptions. It does not need to be the implementation provided by *Asplode*.

## Managing PHP's handler stacks

PHP's error and exception handlers approximate the behaviour of a [stack].
However, the interface for manipulating the stack is limited, and quite frankly,
poorly implemented.

*Asplode* includes two classes to aid in management of these stacks,
[ErrorHandlerStack] and [ExceptionHandlerStack]. Both implement
[HandlerStackInterface] which provides a familiar interface for working with
stacks. These classes do not require the use of the *Asplode* handler; they can
be used in a standalone manner to manage the handler stacks.

## Migrating existing code to work with Asplode

When the *Asplode* error handler is installed, the [error_reporting] setting
will no longer have any effect. Notices, warnings, and errors will all result in
an exception being thrown. Deprecation notices will not throw an exception, but
will still be logged provided that PHP is configured to do so.

Code that has been written to handle legacy-style PHP errors will most likely
need to be re-written. As an example, this type of logic:

```php
$fp = fopen('/path/to/foo', 'r'); // this throws a PHP warning if the file is not found

if ($fp === false) {
  // handle error opening file
}
```

would need to be rewritten to to handle exceptions:

```php
try {
  $fp = fopen('/path/to/foo', 'r');
} catch (ErrorException $e) {
  // handle error opening file
}
```

It's important to note that PHP can be very inconsistent in the way it reports
error conditions. Some functions will return a boolean false to indicate an
error has occurred; others may require the developer to call additional
functions to check for errors; and others still may exhibit entirely
non-standard behaviour.

*Asplode* does not free the developer from the responsibility of reading the PHP
documentation, or making sure that they account for all possible error
conditions.

## Executing legacy code

Sometimes working with code that uses bad practices is unavoidable. A legacy PHP
library might be perfectly functional and useful, but it may not anticipate
exceptions being thrown when an error occurs.

*Asplode*'s exception and error handler stacks both implement an `executeWith()`
method that allows code to be executed with a different handler than the one
currently installed. This method pops all current handlers off the stack
temporarily, installs the specified handler (if one is provided) and executes
the supplied callback. The original handler is restored after the callback is
executed.

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

<!-- References -->

[error handler]: http://php.net/set_error_handler
[error_reporting]: http://php.net/error_reporting
[ErrorException]: http://php.net/ErrorException
[ErrorHandlerStack]: http://lqnt.co/asplode/artifacts/documentation/api/Eloquent/Asplode/HandlerStack/ErrorHandlerStack.html
[ExceptionHandlerStack]: http://lqnt.co/asplode/artifacts/documentation/api/Eloquent/Asplode/HandlerStack/ExceptionHandlerStack.html
[HandlerStackInterface]: http://lqnt.co/asplode/artifacts/documentation/api/Eloquent/Asplode/HandlerStack/HandlerStackInterface.html
[stack]: http://en.wikipedia.org/wiki/Stack_(abstract_data_type)
[Symfony]: http://symfony.com/

[API documentation]: http://lqnt.co/asplode/artifacts/documentation/api/
[Build status]: https://api.travis-ci.org/eloquent/asplode.png?branch=master
[Composer]: http://getcomposer.org/
[eloquent/asplode]: https://packagist.org/packages/eloquent/asplode
[Latest build]: https://travis-ci.org/eloquent/asplode
[SemVer]: http://semver.org/
[Test coverage report]: https://coveralls.io/r/eloquent/asplode
[Test coverage]: https://coveralls.io/repos/eloquent/asplode/badge.png?branch=master
[Uses semantic versioning]: http://b.repl.ca/v1/semver-yes-brightgreen.png
