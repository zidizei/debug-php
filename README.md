# debug-php

Simple debugging utility for PHP to print out messages to stdout
or the browser's JavaScript console, if supported.

Heavily inspired by [debug](https://github.com/visionmedia/debug)
for [node.js](http://nodejs.org).

[![Latest Stable Version](https://poser.pugx.org/zidizei/debug/v/stable.svg)](https://packagist.org/packages/zidizei/debug) [![Total Downloads](https://poser.pugx.org/zidizei/debug/downloads.svg)](https://packagist.org/packages/zidizei/debug) [![License](https://poser.pugx.org/zidizei/debug/license.svg)](https://packagist.org/packages/zidizei/debug)

## Installation

Use [Composer](http://getcomposer.org) and add this to your
`composer.json`:

    "require": {
        "zidizei/debug", "~0.1.1"
    }

## Usage

**debug-php** lets you print out short debbuging messages for your
PHP project either to stdout or to the JavaScript console of your
browser, in case you are using this library on your website.

```
require "vendor/autoload.php";

// initiate debug profile named 'parser'
\Debug\profile("parser");

\Debug\debug("Parsing some stuff now");
/* Parse the stuff */
\Debug\debug("Stuff successfully parsed");

// close the current debug profile (in this case 'parser')
\Debug\profile();

```

The above code will produce something like this when run using
a web server and browser:

![parser debug](https://patrickl.am/attic/debug-php/debug-parser.png)

Output to `stdout` will look more or less the same using colors
defined by your shell.

### Disabling debugging messages

By default, **debug-php** is good to go by just calling its methods.
Since 0.1.1 you can call `\Debug\off()` to explicitly disable
debugging messages. In combination with `\Debug\on()`, this
could be used to programmatically decide to skip debug messages
for certain sections of your code.

### Multiple Profiles

You can use *profiles* to better distinguish some of your debug
messages. The example above only uses one profile by calling:

    \Debug\profile("parser")

If a *profile* by that name already exists, it will be closed.
You can close the currently active (as in last opened) profile
by omitting the parameter:

    \Debug\profile()

If there are no active profiles, it will open a default one
(aptly named *default*).
Note that there has to be **at least one** profile open for debugging.

The following code example demonstrates the use of multiple
debugging profiles:

```
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
```

The above code will produce something like this when run using
a web server and browser:

![multiple profiles debug](https://patrickl.am/attic/debug-php/debug-profiles.png)

Output to `stdout` will look more or less the same using colors
defined by your shell.

### Time measurements

The milliseconds at the end of each debug line indicate the time
difference between the execution of the current debug message
and the previous one.

Additionally, each profile duration is measured and displayed once
it has been closed.
