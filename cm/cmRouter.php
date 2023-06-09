<?php
/**
 * @package ContentManager
 * @subpackage router
 * @author Samuele Diella <samuele.diella@gmail.com>
 * @copyright Copyright (c) 2004-2010, Samuele Diella
 * @license http://opensource.org/licenses/gpl-3.0.html
 * @link http://www.formsphpframework.com
 */

/**
 * @package ContentManager
 * @subpackage router
 * @author Samuele Diella <samuele.diella@gmail.com>
 * @copyright Copyright (c) 2004-2010, Samuele Diella
 * @license http://opensource.org/licenses/gpl-3.0.html
 * @link http://www.formsphpframework.com
 */
class cmRouter extends ffCommon
{
    private static $instances   = array();

    const PRIORITY_TOP 			= 0;
    const PRIORITY_VERY_HIGH	= 1;
    const PRIORITY_HIGH			= 2;
    const PRIORITY_NORMAL 		= 3;
    const PRIORITY_LOW			= 4;
    const PRIORITY_VERY_LOW		= 5;
    const PRIORITY_BOTTOM 		= 6;
    const PRIORITY_DEFAULT 		= cmRouter::PRIORITY_NORMAL;

    public $rules 			    = array();
    public $named_rules 	    = array();
    public $matched_rules 	    = null;
    public $counter			    = 0;

    public $ordered		        = false;

    private $bucket             = null;

    private function __construct($name = null)
    {
        $this->bucket = ($name ? $name : "router");
    }

    private function __clone()
    {
    }

    public static function getInstance($name = "router")
    {
        if (!isset(cmRouter::$instances[$name]))
            cmRouter::$instances[$name] = new cmRouter($name);

        return cmRouter::$instances[$name];
    }

	public function getRuleById($id)
	{
		if (isset($this->named_rules[$id]))
			return $this->named_rules[$id];
		else
			return null;
	}

	/**
	 *
	 * @param type $source
	 * @param type $destination [header, location, file, module, url]
	 * @param type $priority
	 * @param type $accept_path_info
	 * @param type $process_next
	 * @param type $index
	 * @param type $attrs
	 * @param type $reverse
	 * @param type $query
	 * @param type $useragent [browser, version]
	 * @param type $blocking
	 * @param type $control (cache)
	 */
	public function addRule($source, $destination, $priority = cmRouter::PRIORITY_DEFAULT, $accept_path_info = false, $process_next = false, $index = 0, $attrs = array(), $reverse = null, $query = null, $useragent = null, $blocking = false, $control = false, $hosts = array())
	{
		// --------------------------------------------
		// CREAZIONE REGOLA

		$rule = new SimpleXMLElement("<rule></rule>");

		$rule->addChild("source", $source);

		if (is_array($destination) && count($destination))
		{
			$tmp_dest = $rule->addChild("destination");
			foreach ($destination as $key => $value)
			{
				$tmp_dest->addChild($key, $value);
			}
			reset($destination);
		}

		switch ($priority)
		{
			case cmRouter::PRIORITY_TOP:
				$rule->addChild("priority", "TOP");
				break;

			case cmRouter::PRIORITY_VERY_HIGH:
				$rule->addChild("priority", "VERY_HIGH");
				break;

			case cmRouter::PRIORITY_HIGH:
				$rule->addChild("priority", "HIGH");
				break;

			case cmRouter::PRIORITY_LOW:
				$rule->addChild("priority", "LOW");
				break;

			case cmRouter::PRIORITY_VERY_LOW:
				$rule->addChild("priority", "VERY_LOW");
				break;

			case cmRouter::PRIORITY_BOTTOM:
				$rule->addChild("priority", "BOTTOM");
				break;

			default:
				$rule->addChild("priority", "NORMAL");
		}

		if ($accept_path_info)
			$rule->addChild("accept_path_info");

		if ($process_next)
			$rule->addChild("process_next");

		$rule->addChild("index", $index);

		if (is_array($attrs) && count($attrs))
		{
			foreach ($attrs as $key => $value)
			{
				$rule->addAttribute($key, $value);
			}
			reset($attrs);
		}

		if (is_array($hosts) && count($hosts))
		{
			foreach ($hosts as $value)
			{
				$rule->addChild("host", $value);
			}
			reset($attrs);
		}

		if ($reverse)
			$rule->addChild("reverse");

		if ($query !== null)
			$rule->addChild("query", $query);

		if (is_array($useragent) && count($useragent))
		{
			$tmp_usrag = $rule->addChild("useragent");
			foreach ($useragent as $key => $value)
			{
				$tmp_usrag->addChild($key, $value);
			}
			reset($useragent);
		}

		if ($blocking)
			$rule->addChild("blocking");

		if ($control)
			$rule->addChild("control");

		// FINE CREAZIONE REGOLA
		// --------------------------------------------

		$this->addElementRule($rule);
	}

	public function addXMLRule($xml)
	{
		// --------------------------------------------
		// CREAZIONE REGOLA

		$rule = new SimpleXMLElement($xml);

		// FINE CREAZIONE REGOLA
		// --------------------------------------------

		$this->addElementRule($rule);
	}
    public function loadMem() {
        $router                             = false;
        $cache                              = ffCache::getInstance();

        $router                             = $cache->get("cm/" . $this->bucket ."/rules");
        if($router !== false) {
            $this->router->rules            = $router;
            $this->router->named_rules      = $this->cache->get("cm/" . $this->bucket . "/named_rules");
            $this->router->ordered          = true;
        }

        return (bool) $router;
    }
	public function loadFile($file)
	{
        if(is_file($file)) {
            $xml = new SimpleXMLElement("file://" . $file, null, true);

            if (count($xml->rule)) {
                foreach ($xml->rule as $key => $rule) {
                    if ($key == "comment")
                        continue;

                    $this->addElementRule($rule);
                }
            }
        }
		return;
	}

	private function addElementRule($rule)
	{
		$this->counter++;
		$rule->counter = $this->counter;

		$attrs = $rule->attributes();

		// check required params
		if (isset($rule->priority))
			$priority = (string)$rule->priority;
		else
			$priority = "NORMAL";

		if (!isset($rule->index))
			$rule->addChild("index", "0");

		// convert object, cache or not
		$rule = new ffSerializable($rule);

		// populate queues
		if (isset($attrs["id"]))
			$this->named_rules[(string)$attrs["id"]] = $rule;

		switch (strtoupper($priority))
		{
			case "TOP":
				$this->rules[cmRouter::PRIORITY_TOP][] = $rule;
				break;

			case "VERY_HIGH":
				$this->rules[cmRouter::PRIORITY_VERY_HIGH][] = $rule;
				break;

			case "HIGH":
				$this->rules[cmRouter::PRIORITY_HIGH][] = $rule;
				break;

			case "LOW":
				$this->rules[cmRouter::PRIORITY_LOW][] = $rule;
				break;

			case "VERY_LOW":
				$this->rules[cmRouter::PRIORITY_VERY_LOW][] = $rule;
				break;

			case "BOTTOM":
				$this->rules[cmRouter::PRIORITY_BOTTOM][] = $rule;
				break;

			default:
				$this->rules[cmRouter::PRIORITY_DEFAULT][] = $rule;
		}
	}

	public function process($url, $query = null, $host = null)
	{
		$this->matched_rules = array();

		for($i = cmRouter::PRIORITY_TOP; $i <= cmRouter::PRIORITY_BOTTOM; $i++)
		{
			if (!isset($this->rules[$i]))
				continue;

			usort($this->rules[$i], "ffCommon_IndexOrder");
			$this->rules[$i] = array_reverse($this->rules[$i]);

			foreach ($this->rules[$i] as $key => $value)
			{
				$attrs = $value->__attributes; //cmRouter::getRuleAttrs($value);

				if ($host !== null && isset($value->host))
				{
					if (!isset($attrs["host_mode"]) || strtolower($attrs["host_mode"]) == "allow")
						$host_allow = false;
					if (strtolower($attrs["host_mode"]) == "disallow")
						$host_allow = true;

					if (count($value->host) == 1)
					{
						$host_matches = array();
						$host_rc = preg_match('/' . str_replace('/', '\/', $value->host) . '/', $host, $host_matches,  PREG_OFFSET_CAPTURE);
						if ($host_rc)
						{
							if (!isset($attrs["host_mode"]) || strtolower($attrs["host_mode"]) == "allow")
								$host_allow |= true;
							elseif (strtolower($attrs["host_mode"]) == "disallow")
								$host_allow &= false;
						}
					}
					else
					{
						for($c = 0; $c < count($value->host); $c++)
						{
							$host_matches = array();
							$host_rc = preg_match('/' . str_replace('/', '\/', $value->host[$c]) . '/', $host, $host_matches,  PREG_OFFSET_CAPTURE);

							if ($host_rc)
							{
								if (!isset($attrs["host_mode"]) || strtolower($attrs["host_mode"]) == "allow")
									$host_allow |= true;
								elseif (strtolower($attrs["host_mode"]) == "disallow")
									$host_allow &= false;
							}
						}
					}

					if (!$host_allow)
						continue;
				}

                if (!is_array($value->source))
				{
					$matches = array();
					$rc = preg_match('/' . str_replace('/', '\/', $value->source) . '/', $url, $matches,  PREG_OFFSET_CAPTURE);
					if($rc && isset($value->query) && strlen($value->query) && strlen($query))
						$rc = preg_match('/' . str_replace('/', '\/', $value->query) . '/', $query, $matches,  PREG_OFFSET_CAPTURE);
				}
				else
				{
					$rc = false;

					for($c = 0; $c < count($value->source); $c++)
					{
						$matches = array();
						$sub_rc = preg_match('/' . str_replace('/', '\/', $value->source[$c]) . '/', $url, $matches,  PREG_OFFSET_CAPTURE);
						if($sub_rc && isset($value->query[$c]) && strlen($value->query[$c]) && strlen($query))
							$sub_rc = preg_match('/' . str_replace('/', '\/', $value->query[$c]) . '/', $query, $matches,  PREG_OFFSET_CAPTURE);
						$rc |= $sub_rc;
					}
				}

				if ($rc)
				{
					if (strlen((string)$attrs["id"]))
						$this->matched_rules[(string)$attrs["id"]] = array("rule" => $value, "params" => $matches);
					else
						$this->matched_rules[] = array("rule" => $value, "params" => $matches);
                }
			}
			reset($this->rules[$i]);


		}
	}


	public function getMatchedRules($key) {

	    if(is_array($this->matched_rules) && count($this->matched_rules)) {
	        foreach ($this->matched_rules AS $name => $router) {
                if(isset($router["rule"]->$key)) {
                    $res = (array) $router["rule"]->$key;
                    unset($res["__tostring"]);
                    unset($res["__attributes"]);
                    break;
                }
            }
        }

       return $res;
    }

	static function getRuleAttrs($rule)
	{
		if (get_class($rule) == "ffSerializable")
			return $rule->__attributes;
		else
			return $rule->attributes();

	}
}