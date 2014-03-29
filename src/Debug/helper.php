<?php
namespace Debug;

use Debug\Debugger;

function profile ($tag=null)
{
    Debugger::profile($tag);
}

function debug()
{
	$argv = func_get_args();

	Debugger::debug($argv);
}