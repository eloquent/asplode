<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// path constants
require __DIR__.'/paths.php';

// use Composer for autoloading
$autoloader = require LQNT_VENDOR_DIR.DIRECTORY_SEPARATOR.'autoload.php';
$autoloader->add('Eloquent', LQNT_TEST_SRC_DIR);

// include Phake for improved mocking support
Phake::setClient(Phake::CLIENT_PHPUNIT);
