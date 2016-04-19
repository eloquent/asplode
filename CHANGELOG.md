# Asplode changelog

## 2.2.0 (2016-04-19)

- **[IMPROVED]** Increased the amount of memory reserved by the fatal error
  handler, to improve the chances of catching memory exhausted fatals.

## 2.1.0 (2015-12-11)

- **[IMPROVED]** Error exceptions use file and line from the original error, and
  trim *Asplode* internals from the stack trace (#15).

[#15]: https://github.com/eloquent/asplode/issues/15

## 2.0.1 (2014-10-29)

- **[IMPROVED]** Support for [Isolator] 3.

[isolator]: https://github.com/IcecaveStudios/isolator

## 2.0.0 (2014-01-25)

- **[BC BREAK]** Complete re-write
- **[NEW]** Fatal error handling ([#10])
- **[IMPROVED]** Easier installation via static methods
- **[FIXED]** No longer throws exceptions for deprecation errors ([#9])
- **[FIXED]** Correctly handles '@' supression ([#7])

[#7]: https://github.com/eloquent/asplode/issues/7
[#9]: https://github.com/eloquent/asplode/issues/9
[#10]: https://github.com/eloquent/asplode/issues/10

## 1.1.1 (2013-08-01)

- **[MAINTENANCE]** General repository maintenance.

## 1.1.0 (2013-06-11)

- **[NEW]** Added utility method for asserting correct error handler
  configuration ([#5])
- **[NEW]** Added utility methods for managing the error handler stack
- **[NEW]** Added utility method for invoking a callback without any error
  handlers
- **[NEW]** API documentation added
- **[IMPROVED]** Uninstall will only throw a not installed exception if the
  current instance is the top-most handler in the stack
- **[IMPROVED]** Install will only throw an already installed exception if the
  current instance is the top-most handler in the stack
- **[FIXED]** Uninstall can no longer remove unrelated error handlers ([#6])

[#5]: https://github.com/eloquent/asplode/issues/5
[#6]: https://github.com/eloquent/asplode/issues/6

## 1.0.5 (2013-03-04)

- **[NEW]** [Archer] integration
- **[NEW]** Implemented changelog

[archer]: https://github.com/IcecaveStudios/archer
