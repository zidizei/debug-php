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

// close the current debug profile (in this case 'parser')
\Debug\profile();
