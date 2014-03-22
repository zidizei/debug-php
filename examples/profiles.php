<?php
/**
 * Debug example usage.
 * Open with browser or run via command-line
 */

// Autoload Debugger via composer
require "../vendor/autoload.php";

// initiate debug profile named 'parser'
\Debug\profile("parser");

\Debug\debug("Parsing some stuff now");
/* Parse the stuff */
\Debug\debug("Stuff successfully parsed");


// initiate debug profile named 'worker'
\Debug\profile("worker");

\Debug\debug("Working with the stuff now");
/* Work with the parsed stuff */
\Debug\debug("Stuff successfully worked with.. or something like that.");

// close the current debug profile (in this case 'worker')
\Debug\profile();


// close the current debug profile (in this case 'parser')
\Debug\profile();
