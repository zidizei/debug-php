<?php
/**
 * Debug example usage.
 * Open with browser or run via command-line
 */

// Autoload Debugger via composer
require "../vendor/autoload.php";

class Test {

	private $name = 'Test';

	public function __toString() {
		return "My name is: {$this->name}\n";
	}

}

class Bar {

	public $name = 'Foobar';
	public $url;

}

$obj  = new Test;
$obj2 = new Bar;
$arr1 = array("foo", "bar");
$arr2 = array("lorem", "ipsum", array(1, 2));
$arr3 = array("lorem", "ipsum", array(1, 2), array($obj));
$arr4 = array("foo", $obj);

\Debug\profile("objects-and-arrays");

\Debug\debug("objects in array: %s", $arr3);
\Debug\debug("objects in multi-dimensional array: %s", $arr4);


\Debug\profile("arrays");

\Debug\debug("one-dimensional array: %s", $arr1);
\Debug\debug("multi-dimensional array: %s", $arr2);

\Debug\profile();
\Debug\profile("objects");

\Debug\debug("object: %s", $obj);
\Debug\debug("object without __toString(): %s", $obj2);

\Debug\profile();


\Debug\profile();
