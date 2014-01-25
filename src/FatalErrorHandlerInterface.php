<?php

/*
 * This file is part of the Asplode package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eloquent\Asplode;

/**
 * The interface implemented by fatal error handlers.
 */
interface FatalErrorHandlerInterface
{
    /**
     * Installs this fatal error handler.
     *
     * @throws Exception\AlreadyInstalledException If this fatal error handler is already installed.
     */
    public function install();

    /**
     * Uninstalls this fatal error handler.
     *
     * @throws Exception\NotInstalledException If this fatal error handler is not installed.
     */
    public function uninstall();

    /**
     * Returns true if this fatal error handler is installed.
     *
     * @return boolean True if this fatal error handler is installed.
     */
    public function isInstalled();

    /**
     * Handles PHP shutdown, and produces exceptions for any detected fatal
     * error.
     *
     * This function will not actually throw any exceptions. If an installed
     * exception handler is detected, it will create an exception representing
     * the fatal error, and pass it to the installed exception handler.
     */
    public function handle();
}
