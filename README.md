# Asplode

*Drop-in exception-based error handling for PHP.*

[![Build Status]][Latest build]
[![Test Coverage]][Test coverage report]

## Installation and documentation

* Available as [Composer] package [eloquent/asplode].
* [API documentation] available.

## Usage

*Asplode* can be installed in a single line (PHP 5.4):

```php
(new \Eloquent\Asplode\Asplode)->install();
```

or for PHP 5.3:

```php
\Eloquent\Asplode\Asplode::instance()->install();
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

if ($fp === false)
{
  // handle error opening file
}
```

would need to be replaced with something like:

```php
try
{
  $fp = fopen('/path/to/foo', 'r');
}
catch (ErrorException $e)
{
  // handle error opening file
}
```

It's important to note that PHP can be very inconsistent in the way it handles
error conditions. In some cases you may find that a function will simply return
a boolean false when an error occurs; or it may have even stranger, less
standard behaviour.

*Asplode* does not free you from the responsibility of readingthe PHP
documentation and making sure that you account for all possible return values.

## Why use Asplode?

Exceptions offer a much more consistent way to handle errors. In modern PHP
development it is generally considered best-practice to use an exception rather
than a legacy-style error.

*Asplode* offers a hassle-free way to improve the error handling in a PHP
project. It also provides a consistent error handling implementation across
any project or library it's used in, allowing for easier integration.

<!-- References -->

[API documentation]: http://lqnt.co/asplode/artifacts/documentation/api/
[Build Status]: https://raw.github.com/eloquent/asplode/gh-pages/artifacts/images/icecave/regular/build-status.png
[Composer]: http://getcomposer.org/
[eloquent/asplode]: https://packagist.org/packages/eloquent/asplode
[error handler]: http://php.net/set_error_handler
[error_reporting]: http://php.net/error_reporting
[ErrorException]: http://php.net/ErrorException
[Latest build]: http://travis-ci.org/eloquent/asplode
[Test coverage report]: http://lqnt.co/asplode/artifacts/tests/coverage/
[Test Coverage]: https://raw.github.com/eloquent/asplode/gh-pages/artifacts/images/icecave/regular/coverage.png
