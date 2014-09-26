<?php
/**
 * Simple debugging utility for PHP.
 * Prints out messages to stdout or the browser's JavaScript console, if supported.
 *
 * @author Patrick Lam
 */

namespace Debug;

use Debug\Debugger;

/**
 * Helper function for opening/closing debugging profiles.
 * Maps to the static and public method \Debug\Debugger::profile().
 *
 * @param string $tag Specifies the name of the profile to
 * 					  be opened closed. `null` for closing the
 * 					  profile currently open, or - if no profile has
 * 					  been opened yet - opens a default one.
 */
function profile ($tag = null)
{
    Debugger::profile($tag);
}

/**
 * Helper function for displaying debugging messages.
 * Maps to the static and public method \Debug\Debugger::debug().
 *
 * @param mixed $args Specify debug message as regular String or
 *					  a format String like printf().
 * @link http://php.net/manual/en/function.printf.php
 */
function debug()
{
    $argv = func_get_args();

    Debugger::debug($argv);
}
