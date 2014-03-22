<?php
/**
 * Debug example usage.
 * Open with browser or run via command-line
 */

// Autoload Debugger via composer
require '../vendor/autoload.php';

\Debug\profile();

usleep(1000);
\Debug\debug("test");

\Debug\profile("asd");

usleep(1000);
\Debug\warn("test");

\Debug\profile(); // same as calling \Debug\profile("asd"); again
\Debug\profile();
