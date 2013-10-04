# Asplode

*Drop-in exception-based error handling for PHP.*

[![Build status]][Latest build]
[![Test coverage]][Test coverage report]
[![Uses semantic versioning]][SemVer]

## Installation and documentation

* Available as [Composer] package [eloquent/asplode].
* [API documentation] available.

## Usage

*Asplode* can be installed in a single line (PHP 5.4):

```php
(new Eloquent\Asplode\Asplode)->install();
```

or for PHP 5.3:

```php
Eloquent\Asplode\Asplode::instance()->install();
```

## What does it do?

*Asplode* is very simple library that sets up an [error handler] to throw
[ErrorException] exceptions instead of using the default PHP error handler.

## How will it affect existing code?

The [error_reporting] setting will no longer have any effect. Any error of any
severity will throw an exception.

Any code that previously raised a PHP notice, warning, or error will instead
throw an exception. Code that has been written to handle the old PHP-style
errors will most likely need to be re-written.

As an example, this type of logic:

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
documentation, or making sure that they account for all possible return values.

## Why use Asplode?

Exceptions offer a much more consistent way to handle errors. In modern PHP
development it is generally considered best-practice to use an exception rather
than a legacy-style error.

*Asplode* offers a hassle-free way to improve the error handling in a PHP
project. It also provides a consistent error handling implementation across
any project or library it's used in, allowing for easier integration.

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
example, a old PHP library might be quite functional and useful, but still use
'@' suppression, or some other feature that is incompatible with *Asplode*.

For this purpose, *Asplode* provides a simple way to bypass any error handlers
and execute code via the `Asplode::unsafe()` method:

```php
use Eloquent\Asplode\Asplode;

Asplode::unsafe(
    function () {
        // code here will be executed without error handlers
    }
);
```

<!-- References -->

[API documentation]: http://lqnt.co/asplode/artifacts/documentation/api/
[Composer]: http://getcomposer.org/
[eloquent/asplode]: https://packagist.org/packages/eloquent/asplode
[error handler]: http://php.net/set_error_handler
[error_reporting]: http://php.net/error_reporting
[ErrorException]: http://php.net/ErrorException

[Build status]: https://api.travis-ci.org/eloquent/asplode.png?branch=master
[Composer]: http://getcomposer.org/
[eloquent/asplode]: https://packagist.org/packages/eloquent/asplode
[Latest build]: https://travis-ci.org/eloquent/asplode
[SemVer]: http://semver.org/
[Test coverage report]: https://coveralls.io/r/eloquent/asplode
[Test coverage]: https://coveralls.io/repos/eloquent/asplode/badge.png?branch=master
[Uses semantic versioning]: http://b.repl.ca/v1/semver-yes-brightgreen.png
