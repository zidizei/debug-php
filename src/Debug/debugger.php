<?php
namespace Debug;

/**
 * Simple debugging utility for PHP.
 * Prints out messages to stdout or the browser's JavaScript console, if supported.
 *
 * @author Patrick Lam
 */
class Debugger {

    private $profiles;
    private $currentProfile;

    private $colors = array(
        array('Web' => '#C91C02', 'CLI' => "\033[31m"),
        array('Web' => '#A0D36E', 'CLI' => "\033[32m"),
        array('Web' => '#FACB47', 'CLI' => "\033[33m"),
        array('Web' => '#0687ED', 'CLI' => "\033[34m"),
        array('Web' => '#aa00ff', 'CLI' => "\033[35m"),
        array('Web' => '#00f6fe', 'CLI' => "\033[36m"),
        array('Web' => '#F8F8F8', 'CLI' => "\033[37m"),
        array('Web' => '#aaaaaa', 'CLI' => "\033[30m")
    );

    private $lastDebug = 0;

    private static $instance = null;

    private static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function profile ($tag=null)
    {
        $debugger = self::getInstance();
        $debugger->manageProfiles($tag);
    }

    public static function debug ($obj)
    {
        $debugger = self::getInstance();
        $debugger->printDebug($obj);
    }


    private function __construct ()
    {
        $this->profiles = array();
        $this->transport = (php_sapi_name() == 'cli') ? 'CLI' : 'Web'; // TODO: maybe check for some Browser extensions like Chrome Logger
    }


    private function manageProfiles ($tag=null)
    {
        if ($tag != null)
        {
            if (isset($this->profiles[$tag])) {
                $this->closeProfile($tag);
            } else {
                $this->openProfile($tag);
            }
        }
        else
        {
            if (count($this->profiles) > 0) {
                // Get the tag name of the last profile.
                end($this->profiles);
                $tag = key($this->profiles);
                reset($this->profiles);

                // And close it
                $this->closeProfile($tag);
            } else {
                // Open a default profile if there are no profiles yet
                $this->openProfile('debug');
            }
        }
    }


    private function openProfile ($tag)
    {
        $pos = count($this->profiles);

        $this->profiles[$tag] = array('color' => $this->colors[$pos], 'start' => round(microtime(true) * 1000));
        $this->currentProfile = $tag;

        $this->printDebug('starting...', $tag);
    }

    private function closeProfile ($tag)
    {
        $profile = $this->profiles[$tag];

        $start = $profile['start'];
        $end   = round(microtime(true) * 1000);

        $this->printDebug('finished after '.($end - $profile['start']).' ms', $tag);

        unset($this->profiles[$tag]);

        // Get the tag name of the last profile, which will be the
        // new current profile.
        end($this->profiles);
        $this->currentProfile = key($this->profiles);
        reset($this->profiles);
    }


    private function printDebug ($obj, $tag=null)
    {
        $tag   = ($tag == null) ? $this->currentProfile : $tag;
        $color = $this->profiles[$tag]['color'][$this->transport];

        $msg   = (is_array($obj)) ? $this->buildDebugMessage($obj) : $obj;

        if ($this->lastDebug > 0) {
            $duration = "+".(round(microtime(true) * 1000)-$this->lastDebug);
        } else {
            $duration = "+0";
        }

        if ($this->transport == 'CLI')
        {
            echo $color;

            echo $tag;

            echo $this->colors[7][$this->transport]." ";
            echo $msg;
            echo " ".$color;

            echo $duration." ms";
            echo "\033[0m";
            echo "\n";
        }
        else
        {
            $msg = $this->escapeForConsole($msg);

            // TODO: if Browser extensions like Chrome Logger are utilised, the following would be the fallback solution
            //       to print to the browser's JavaScript console
            echo "<script>console.log('%c$tag %c $msg %c$duration ms', 'color: $color', 'color: ".$this->colors[7][$this->transport]."', 'color: $color');</script>";
        }

        $this->lastDebug = round(microtime(true) * 1000);
    }

    private function buildDebugMessage ($obj)
    {
    	$count = count($obj);

    	if ($count == 0) return "";
    	if ($count == 1) return $obj[0];

    	if (is_string($obj[0]))
    	{
    		$format = array_shift($obj);
    		$args   = array();

	    	foreach ($obj as $value)
	    	{
	    		if (is_array($value))
	    		{
	    			$args[] = $this->prepareDebugArray($value);
	    		}
	    		else if (is_object($value))
	    		{
	    			$args[] = $this->prepareDebugObject($value);
	    		}
	    	}

    		return vsprintf($format, $args);
    	}
    	else
    	{

    	}
    }

    private function prepareDebugArray ($arr)
    {
    	$str = "{ ";
    	$i   = 0;

    	foreach ($arr as $key => $value)
    	{
    		if (!is_numeric($key)) $str .= $key.': ';

    		if (is_array($value)) {
    			$str .= $this->prepareDebugArray($value);
    		} else if (is_object($value)) {
    			$str .= $this->prepareDebugObject($value);
    		} else {
				ob_start();
				var_dump($value);
				$str .= str_replace("\n", "", ob_get_clean());
    		}

    		if (++$i < count($arr)) $str .= ", ";
    	}

    	$str .= " }";

    	return $str;
    }

    private function prepareDebugObject ($obj)
    {
    	if (method_exists($obj, "__toString")) return str_replace("\n", "", (string) $obj);

    	return $this->prepareDebugArray(get_object_vars($obj));
    }

    private function escapeForConsole ($obj)
    {
      // TODO: if not a String, use another function to get a String representation of that object
      //       and then escape it here
      if (!is_string($obj)) return $obj;

      return addslashes(str_replace("\n", "\\n", $obj));
    }

}
