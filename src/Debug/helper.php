<?php
namespace Debug;

use Debug\Debugger;

function profile ($tag=null)
{
    $debugger = Debugger::profile($tag);
}

function debug ($obj)
{
    Debugger::debug('-', $obj);
}

function warn ($obj)
{
    Debugger::debug('!', $obj);
}

function error ($obj)
{
    Debugger::debug('x', $obj);
}

function assert ($obj)
{
    Debugger::debug('✓', $obj);
}
