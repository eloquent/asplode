# Asplode changelog

## 1.1.0 (unreleased)

* **[NEW]** Added utility method for asserting correct error handler
  configuration ([#5](https://github.com/eloquent/asplode/issues/5))
* **[NEW]** Added utility methods for managing the error handler stack
* **[NEW]** Added utility method for invoking a callback without any error
  handlers
* **[NEW]** API documentation added
* **[IMPROVED]** Uninstall will only throw a not installed exception if the
  current instance is the top-most handler in the stack
* **[IMPROVED]** Install will only throw an already installed exception if the
  current instance is the top-most handler in the stack
* **[FIXED]** Uninstall can no longer remove unrelated error handlers
  ([#6](https://github.com/eloquent/asplode/issues/6))

## 1.0.5 (2013-03-04)

* **[NEW]** [Archer](https://github.com/IcecaveStudios/archer) integration
* **[NEW]** Implemented changelog
