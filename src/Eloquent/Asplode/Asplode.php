<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2012 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode;

use Icecave\Isolator\Isolator;

class Asplode
{
    /**
     * @return Asplode
     */
    public static function instance()
    {
        return new static;
    }

    public function __construct(Isolator $isolator = null)
    {
        $this->isolator = Isolator::get($isolator);
    }

    public function install()
    {
        if ($this->installed) {
            throw new Exception\AlreadyInstalledException;
        }

        $this->isolator->set_error_handler(array($this, 'handleError'));
        $this->installed = true;
    }

    public function uninstall()
    {
        if (!$this->installed) {
            throw new Exception\NotInstalledException;
        }

        $this->isolator->restore_error_handler();
        $this->installed = false;
    }

    public function handleError($severity, $message, $filename, $lineno)
    {
        throw new \ErrorException($message, 0, $severity, $filename, $lineno);
    }

    /**
     * @var boolean
     */
    protected $installed = false;

    /**
     * @var Isolator
     */
    protected $isolator;
}
