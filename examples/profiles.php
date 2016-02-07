<?php
/**
 * Debug example usage.
 * Open with browser or run via command-line
 */

// Autoload Debugger via composer
require "../vendor/autoload.php";

// initiate debug profile named 'parser'
\Debug\profile("parser");

usleep(500 * 1000);

\Debug\debug("Parsing some stuff now");

/* Parse the stuff */
usleep(1000 * 1000);

\Debug\debug("Stuff successfully parsed");

usleep(100 * 1000);

// initiate debug profile named 'worker'
\Debug\profile("worker");

\Debug\debug("Working with the stuff now");

/* Work with the parsed stuff */
usleep(600 * 1000);

\Debug\debug("Stuff successfully worked with.. or something like that.");

// close the current debug profile (in this case 'worker')
\Debug\profile();

// close the current debug profile (in this case 'parser')
\Debug\profile();
