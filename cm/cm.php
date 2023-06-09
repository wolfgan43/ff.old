<?php
/**
 * @package ContentManager
 * @author Samuele Diella <samuele.diella@gmail.com>
 * @copyright Copyright (c) 2004-2017, Samuele Diella
 * @license https://opensource.org/licenses/LGPL-3.0
 * @link http://www.formsphpframework.com
 */

if(!defined("DISABLE_CACHE")) define("DISABLE_CACHE", false);
if(!defined("DEBUG_MODE")) define("DEBUG_MODE", false);

class cm extends ffCommon
{
	private static $singleton 			= null;
    private static  $env                = array();

    static protected $_events = null;

    const DEBUG                         = DEBUG_MODE;
    const NOCACHE                       = DISABLE_CACHE;
	//const LAYOUT_PRIORITY_INERHIT		= 0; // special, get parent'
	const LAYOUT_PRIORITY_TOPLEVEL		= 1; // special, only one
	const LAYOUT_PRIORITY_HIGH			= 2;
	const LAYOUT_PRIORITY_NORMAL	    = 3;
	const LAYOUT_PRIORITY_LOW			= 4;
	const LAYOUT_PRIORITY_FINAL			= 5; // special, only one
	const LAYOUT_PRIORITY_DEFAULT		= cm::LAYOUT_PRIORITY_NORMAL;

    var $config                 = array();
    var $fs                     = array(
                                        "/modules"      => array(
                                            "filter"    => array("css", "js", "html", "jpg", "svg", "png")
                                            , "rules" => array(
                                                "/layouts/"             => "layouts"
                                                , "/common/"            => "common"
                                                , "/contents/"          => "components"
                                                , "/widgets/"           => "widgets"
                                                , "/css/"               => "css"
                                                , "/javascript/"        => "js"
                                                , "/images/"            => "images"
                                                , "/fonts/"             => "fonts"
                                                , "/ff/"                => "components"
                                            )
                                        )
                                );
    var $content_root			= null;
	var	$path_info 				= null;
	var $real_path_info			= null;
	var $query_string 			= null;
	var $script_name			= null;
	var $is_php					= null;
	var $is_resource			= null;
	var $module					= null;
	var $module_path			= null;
		
	var $process_next_rule		= false;
	var $processed_rule			= null;
	var $processed_rule_attrs = null;
	
	//var $ff_settings_loaded		= array();
	//var $ff_settings			= null;

	var $layout_vars			= null;

	var $default_mime			= "text/html";
	var $default_charset		= "UTF-8";

	/**
	 *
	 * @var cmRouter
	 */
	var $router 				= null;
	/**
	 *
	 * @var cmRouter
	 */
	var $cache_router 			= null;
	var $cache_force_enable		= null;
	var $cache_force_expire		= null;
	var $cache_force_max_age	= null;
	
	/**
	 *
	 * @var ffMemCache
	 */
	var $cache					= null;

	//var $applets_components 	= array();
	var $loaded_applets 		= array();
	var $modules				= array();
	
	/**
	 *
	 * @var ffPage_base
	 */
	var $oPage					= null;
	/**
	 *
	 * @var ffTemplate
	 */
	var $tpl_content 			= null;
	
	var $json_response			= array(
			"success" => true
		);
	
	private function __construct()
	{
		$this->router = cmRouter::getInstance();
	}
	
	private function __clone()
	{
	}
	
	/**
	 *
	 * @return cm
	 */
	public static function getInstance()
	{
		if (self::$singleton === null) {
            self::$singleton = new cm();
        }
		return self::$singleton;
	}
	
	/**
	* EVENTS OVERRIDING
	*/
	
	static public function _addEvent($event_name, $func_name, $priority = null, $index = 0, $break_when = null, $break_value = null, $additional_data = null)
	{
		self::initEvents();
		return self::$_events->addEvent($event_name, $func_name, $priority, $index, $break_when, $break_value, $additional_data);
	}

	static public function _doEvent($event_name, $event_params = array())
	{
		self::initEvents();
		return self::$_events->doEvent($event_name, $event_params);
	}
	
	static private function initEvents()
	{
		if (self::$_events === null)
			self::$_events = new ffEvents();
	}

	public function doEvent($event_name, $event_params = array())
	{
		return self::_doEvent($event_name, $event_params);
	}
	
	public function addEvent($event_name, $func_name, $priority = null, $index = 0, $break_when = null, $break_value = null, $additional_data = null)
	{
		return self::_addEvent($event_name, $func_name, $priority, $index, $break_when, $break_value, $additional_data);
	}

    /**
     * Env
     */
    public static function env($name, $value = null) {
        if($value) {
            self::$env[$name] = $value;
        }

        return self::$env[$name];
    }

    public function load_env($envs) {
        foreach ($envs as $key => $env) {
            self::$env[$key] = $env["value"];
        }
    }

    /*public function load_env_by_xml(SimpleXMLElement $xml) {
        if (isset($xml) && count($xml->children()))
        {
            foreach ($xml->children() as $key => $properties)
            {
                $attrs = $properties->attributes();
                $value = (string) $attrs["value"];
                switch ($value) {
                    case "false":
                        $value = false;
                        break;
                    case "true":
                        $value = true;
                        break;
                    default:
                }

                self::env($key, $value);
            }
        }
    }*/

    private function getLayoutParams() {
       // $this->layout_vars = array();

        //if(!$this->layout_vars["title"]) {
        ///    $this->layout_vars["title"] = cm_getAppName();
        //}

        if(!$this->layout_vars["theme"]) {
            $this->layout_vars["theme"] = cm::env("APP_THEME");
           // if($this->layout_vars["theme"] != FF_MAIN_THEME) {
             //   $this->loadConfig(__PRJ_DIR__ . FF_THEME_DIR . "/" . $this->layout_vars["theme"] . "/conf/config.xml");
            //}

           /* if($this->isXHR() && $_REQUEST["XHR_THEME"]) {
                $this->layout_vars["theme"] = $_REQUEST["XHR_THEME"];
            }*/
        }

        if(!$this->layout_vars["framework_css"]) {
            $this->layout_vars["framework_css"] = cm::env("APP_FRAMEWORK_CSS");
        }
        if(!$this->layout_vars["font_icon"]) {
            $this->layout_vars["font_icon"] = cm::env("APP_FONT_ICON");
        }

        //$this->layout_vars["title"] = str_replace("[CM_LOCAL_APP_NAME]", cm_getAppName(), $this->layout_vars["title"]);

        return $this->layout_vars;
    }

    public function loadConfig($file, $type = null) {
        if(is_file($file)) {
            $fs = Filemanager::getInstance("xml");
            $config = $fs->read($file);

            if(is_array($config["env"]) && count($config["env"])) {
                foreach ($config["env"] AS $key => $value) {
                    $config["env"][$key] = ($value["@attributes"]
                        ? $value["@attributes"]
                        : $value
                    );
                }
            }
            if($config["env"]) {
                $this->load_env($config["env"]);
            }
            if($type && !isset($this->config[$type])) {
                $this->config[$type] = array();
            }
            if($type) {
                $ref = &$this->config[$type];
            } else {
                $ref = &$this->config;
            }

            if(is_array($config) && count($config)) {
                foreach ($config AS $name => $params) {

                    if($name && $name != "comment" && !isset($params[0])) {
                        $ref[$name] = array_replace((array)$ref[$name], $params);
                    }
                }
            }
        }
    }

    private function loadORM($entry) {
        if (@is_file(CM_MODULES_ROOT . "/" . $entry . "/ds/common.php")) {
            require CM_MODULES_ROOT . "/" . $entry . "/ds/common.php";
        }
        if (@is_dir(CM_MODULES_ROOT . "/" . $entry . "/ds/sources"))
        {
            $itGroup = new DirectoryIterator(CM_MODULES_ROOT . "/" . $entry . "/ds/sources");
            foreach($itGroup as $fiGroup)
            {
                if($fiGroup->isDot() || $fiGroup->isDir())
                    continue;

                require($fiGroup->getPathname());
            }
        }
    }

	/**
	* Main Process Fucntion (use only once per session)
	* 
	*/
	public function process()
	{
		if (CM_ENABLE_MEM_CACHING)
		{
			$this->cache = ffCache::getInstance();

			if (defined("FF_URLPARAM_CLEARCACHE"))
				$this->cache->clear();
		}

		$this->path_info 		= $_SERVER['PATH_INFO'];
		$this->query_string 	= $_SERVER['QUERY_STRING'];

		// #0: verifica configurazione

		// #1: normalizzazione dell'url
		if (CM_URL_NORMALIZE)
		{
			$this->path_info = ffCommon_url_normalize($this->path_info);
			$this->path_info = ffCommon_url_stripslashes($this->path_info);
		}

		if (!strlen($this->path_info) || $this->path_info == "/")  //todo: da verificare se serve. Con la cache in home, la cache si sfonda
		{
			$this->path_info = "/index";
			if (CM_URL_NORMALIZE)
				$_SERVER['PATH_INFO'] = $this->path_info;
		}

		// STATIC CACHE
		


		$this->doEvent("on_before_init", array($this));


		// #2: inizializzazione classi

		$ff = ffGlobals::getInstance("ff");
		/*if(!is_object($ff) || !is_object($ff->events) || !(method_exists($ff->events, "addEvent"))) {
			ffErrorHandler::raise("Errore Critico (Rebecca)", E_USER_ERROR, get_included_files(), get_defined_vars());
		}*/
		$ff->events->addEvent("onRedirect", "cm::onRedirect");
		if(CM_ENABLE_MEM_CACHING)
		    $router_loaded = $this->router->loadMem();

		if (!$router_loaded)
		{
			$this->router->loadFile(cm_confCascadeFind(__DIR__ . "/conf", "/cm", "routing_table.xml"));

			if (is_file(__PRJ_DIR__ . "/conf/routing_table.xml"))
				$this->router->loadFile(__PRJ_DIR__. "/conf/routing_table.xml");
		}

		///cacche
        $this->doEvent("on_after_init", array($this));
		
		// #3: precaricamento moduli
        $this->loadConfig(__TOP_DIR__ . "/cm/conf/config.xml");

        Filemanager::scan(CM_MODULES_ROOT, Filemanager::SCAN_DIR, function($dir) {
            $entry = basename($dir);

            if (__PRJ_DIR__ !== __TOP_DIR__)
            {
                if (!file_exists(__PRJ_DIR__ . "/modules/" . $entry)) {
                    return;
                }
            }

            if (!isset($this->modules[$entry])) {
                $this->modules[$entry] = array();
            }

            if (!isset($this->modules[$entry]["events"])) {
                $this->modules[$entry]["events"] = new ffEvents();
            }

            $this->loadConfig(CM_MODULES_ROOT . "/" . $entry . "/conf/config.xml");
            $this->loadConfig(FF_DISK_PATH . "/conf/modules/" . $entry . "/config.xml");

            //todo: da togliere in futuro
            if (@is_file(__PRJ_DIR__ . "/conf/modules/" . $entry . "/config." . FF_PHP_EXT))
                require __PRJ_DIR__ . "/conf/modules/" . $entry . "/config." . FF_PHP_EXT;

            //todo: da togliere in futuro
            if (@is_file(CM_MODULES_ROOT . "/" . $entry . "/conf/config." . FF_PHP_EXT))
                require CM_MODULES_ROOT . "/" . $entry . "/conf/config." . FF_PHP_EXT;

            if (is_file(CM_MODULES_ROOT . "/" . $entry . "/autoload." . FF_PHP_EXT)) {
                require CM_MODULES_ROOT . "/" . $entry . "/autoload." . FF_PHP_EXT;
            }

            //todo: da eliminare is_file nel futuro
            if(is_file(FF_DISK_PATH . "/conf/modules/" . $entry . "/routing_table.xml")) {
                $this->router->loadFile(FF_DISK_PATH . "/conf/modules/" . $entry . "/routing_table.xml");
            } else {
                $this->router->loadFile(CM_MODULES_ROOT . "/" . $entry . "/conf/routing_table.xml");
            }
            if(ALLOW_PAGECACHE) {
                //todo: da eliminare is_file nel futuro
                if(is_file(FF_DISK_PATH . "/conf/modules/" . $entry . "/cache_routing_table.xml")) {
                    $this->router->loadFile(FF_DISK_PATH . "/conf/modules/" . $entry . "/cache_routing_table.xml");
                } else {
                    $this->router->loadFile(CM_MODULES_ROOT . "/" . $entry . "/conf/cache_routing_table.xml");
                }
            }

            $res = $this->doEvent("on_load_config_module", array($this, $entry));
        });

        $this->loadConfig(__PRJ_DIR__ . "/conf/config.xml");






/*
        $modules = new DirectoryIterator(CM_MODULES_ROOT);
        foreach($modules as $module)
        {
            if($module->isDot()) {
                continue;
            }
            $entry = $module->getBasename();

            if (__PRJ_DIR__ !== __TOP_DIR__)
            {
                if (!file_exists(__PRJ_DIR__ . "/modules/" . $entry)) {
                    continue;
                }
            }

            if (!isset($this->modules[$entry])) {
                $this->modules[$entry] = array();
            }

            if (!isset($this->modules[$entry]["events"])) {
                $this->modules[$entry]["events"] = new ffEvents();
            }

            $this->loadConfig(CM_MODULES_ROOT . "/" . $entry . "/conf/config.xml");
            $this->loadConfig(FF_DISK_PATH . "/conf/modules/" . $entry . "/config.xml");

            //todo: da togliere in futuro
            if (@is_file(__PRJ_DIR__ . "/conf/modules/" . $entry . "/config." . FF_PHP_EXT))
                require __PRJ_DIR__ . "/conf/modules/" . $entry . "/config." . FF_PHP_EXT;

            //todo: da togliere in futuro
            if (@is_file(CM_MODULES_ROOT . "/" . $entry . "/conf/config." . FF_PHP_EXT))
                require CM_MODULES_ROOT . "/" . $entry . "/conf/config." . FF_PHP_EXT;

            if (is_file(CM_MODULES_ROOT . "/" . $entry . "/autoload." . FF_PHP_EXT)) {
                require CM_MODULES_ROOT . "/" . $entry . "/autoload." . FF_PHP_EXT;
            }

            if (!$router_loaded) {
                //todo: da eliminare is_file nel futuro
                if(is_file(FF_DISK_PATH . "/conf/modules/" . $entry . "/routing_table.xml")) {
                    $this->router->loadFile(FF_DISK_PATH . "/conf/modules/" . $entry . "/routing_table.xml");
                } else {
                    $this->router->loadFile(CM_MODULES_ROOT . "/" . $entry . "/conf/routing_table.xml");
                }
                if(ALLOW_PAGECACHE) {
                    //todo: da eliminare is_file nel futuro
                    if(is_file(FF_DISK_PATH . "/conf/modules/" . $entry . "/cache_routing_table.xml")) {
                        $this->router->loadFile(FF_DISK_PATH . "/conf/modules/" . $entry . "/cache_routing_table.xml");
                    } else {
                        $this->router->loadFile(CM_MODULES_ROOT . "/" . $entry . "/conf/cache_routing_table.xml");
                    }
                }
            }
            $res = $this->doEvent("on_load_config_module", array($this, $entry));
        }
        */

        foreach ($this->modules AS $entry => $value) {
            if (is_file(CM_MODULES_ROOT . "/" . $entry . "/common." . FF_PHP_EXT)) {
                require CM_MODULES_ROOT . "/" . $entry . "/common." . FF_PHP_EXT;
            }

            if (cm::env("CM_ORM_ENABLE")) {
                $this->loadORM($entry);
            }

            $res = $this->doEvent("on_load_module", array($this, $entry));
        }

		if (CM_ENABLE_MEM_CACHING && !$router_loaded)
		{
			$this->router->orderRules();
            $this->cache->set("cm/router/rules", $this->router->rules);
            $this->cache->set("cm/router/named_rules", $this->router->named_rules);
		}

		//cache router


        $res = $this->doEvent("on_modules_loaded", array($this));

        if (defined("CM_DONT_RUN")) {
            return;
        }

		$res = $this->doEvent("on_before_cm", array($this));
		$rc = end($res);

		// #4: Inizializzazione Layout
        /*if(is_array($rc) && array_key_exists("path_info", $rc)) {
            $layout_path_info = $rc["path_info"];
        } else {
            $layout_path_info = $this->path_info;
        }
       if(!defined("CM_DONT_RUN_LAYOUT") && strpos($this->query_string, "__nolayout__") === false)
		{
			$this->layout_vars = $this->getLayoutByPath($layout_path_info);
		    if ($this->isXHR() && isset($_REQUEST["XHR_THEME"]))
			{
				$this->layout_vars["theme"] = $_REQUEST["XHR_THEME"];
			}
		}*/

        //require additional theme (restricted)
		//ffCommon_main_theme_init();


        /*if (isset($this->layout_vars["theme"]) && $this->layout_vars["theme"] !== $this->layout_vars["main_theme"])
        {
            if (@is_file(FF_THEME_DISK_PATH . "/" . $this->layout_vars["theme"] . "/ff/config.php"))
                require FF_THEME_DISK_PATH . "/" . $this->layout_vars["theme"] . "/ff/config.php";

            if (@is_file(FF_THEME_DISK_PATH . "/" . $this->layout_vars["theme"] . "/ff/common.php"))
                require FF_THEME_DISK_PATH . "/" . $this->layout_vars["theme"] . "/ff/common.php";
        }

        foreach ($this->modules as $key => $value)
        {
            if (@is_file(CM_MODULES_ROOT . "/" . $key . "/themes/" . FF_MAIN_THEME . "/ff/common." . FF_PHP_EXT))
                require CM_MODULES_ROOT . "/" . $key . "/themes/" . FF_MAIN_THEME . "/ff/common." . FF_PHP_EXT;
        }
        reset($this->modules);*/




		//if (!isset($this->layout_vars["theme"]) || !strlen($this->layout_vars["theme"]))
		//	$this->layout_vars["theme"] = cm_getMainTheme();

        $this->doEvent("on_before_page_process", array($this));

        $this->oPage = ffTheme::factory($this->getLayoutParams(), $this->fs); //ffCommon_ffPage_init($this->getLayoutParams(), $this->fs);
        $this->oPage->addEvent("on_page_process", "cm::oPage_on_page_process");
        $this->oPage->addEvent("on_page_processed", "cm::oPage_on_page_processed", ffEvent::PRIORITY_HIGH);

        /*
        $this->oPage = ffPage::factory(ff_getThemeDir($this->layout_vars["theme"]), FF_SITE_PATH, null, $this->layout_vars["theme"]);
        $this->oPage->loadResources($this->fs);

		$this->oPage->addEvent("on_page_process", "cm::oPage_on_page_process");
        //$this->oPage->addEvent("on_after_process_components", "cm::oPage_on_after_process_components", ffEvent::PRIORITY_HIGH);
        $this->oPage->addEvent("on_page_processed", "cm::oPage_on_page_processed", ffEvent::PRIORITY_HIGH);
*/
		/*if (CM_IGNORE_THEME_DEFAULTS || $this->layout_vars["ignore_defaults"])
		{
			$this->oPage->page_css = array();
			$this->oPage->page_js = array();
			$this->oPage->page_meta = array();
		}*/
		
		/*if (strlen($this->layout_vars["title"]))
			$this->oPage->title = str_replace("[CM_LOCAL_APP_NAME]", cm_getAppName(), $this->layout_vars["title"]);
		else
			$this->oPage->title = cm_getAppName();*/
		
      /*  if(strlen($this->layout_vars["class_body"]))
            $this->oPage->class_body = $this->layout_vars["class_body"];
            
        $this->oPage->use_own_form = !$this->layout_vars["exclude_form"];
        $this->oPage->use_own_js = !$this->layout_vars["exclude_ff_js"];
        $this->oPage->compact_js = (defined("FF_URLPARAM_NOCACHE") || defined("FF_URLPARAM_DEBUG") ? false : $this->layout_vars["compact_js"]);
        $this->oPage->compact_css = (defined("FF_URLPARAM_NOCACHE") || defined("FF_URLPARAM_DEBUG") ? false : $this->layout_vars["compact_css"]);
        $this->oPage->compress = (defined("FF_URLPARAM_NOCACHE") || defined("FF_URLPARAM_DEBUG") ? false : $this->layout_vars["enable_gzip"]);
        
        if(is_array($this->layout_vars["cdn"]["css"]) && count($this->layout_vars["cdn"]["css"]))
            $this->oPage->override_css = array_merge($this->oPage->override_css, $this->layout_vars["cdn"]["css"]);
        if(is_array($this->layout_vars["cdn"]["js"]) && count($this->layout_vars["cdn"]["js"]))
            $this->oPage->override_js = array_merge($this->oPage->override_js, $this->layout_vars["cdn"]["js"]);

        //remove default jqueryui if framework_css is active
		$this->oPage->jquery_ui_theme = ($this->layout_vars["framework_css"]
			? false
			: "base"
		);*/

		//$this->oPage->addEvent("on_tpl_load", "cm::oPage_on_process_parts", ffEvent::PRIORITY_HIGH);
		//$this->oPage->addEvent("on_tpl_layer_loaded", "cm::oPage_on_process_parts", ffEvent::PRIORITY_HIGH);

		//if (!defined("FF_URLPARAM_NOLAYOUT"))
		//{
		/*	$this->doEvent("on_layout_init", array($this->oPage, $this->layout_vars));

			if ($this->layout_vars["page"] != "default" && $this->layout_vars["page"] !== null)
				$this->oPage->template_file = "ffPage_" . $this->layout_vars["page"] . ".html";
				
			if (strlen($this->layout_vars["layer"]))
				$this->oPage->layer = $this->layout_vars["layer"];

			if (is_array($this->layout_vars["sect"]) && count($this->layout_vars["sect"]))
			{
				foreach ($this->layout_vars["sect"] as $key => $value)
				{
					if (strlen($this->layout_vars["sect_theme"][$key]) && array_search($this->oPage->getTheme(), explode(",", $this->layout_vars["sect_theme"][$key])) === false)
						continue;
					
					$this->oPage->addSection($key);
					$this->oPage->sections[$key]["name"] = $value;
				}
				reset($this->layout_vars["sect"]);
			}
				
			if (is_array($this->layout_vars["css"]) && count($this->layout_vars["css"]))
			{
				foreach ($this->layout_vars["css"] as $key => $value)
				{
					if (strlen($value["theme"]) && array_search($this->oPage->getTheme(), explode(",", $value["theme"])) === false)
						continue;
					
					$this->oPage->tplAddCss($key, array(
						"file" => $value["file"]
						, "path" => $value["path"]
						, "overwrite" => true
						, "exclude_compact" => $value["exclude_compact"]
						, "priority" => $value["priority"]
						, "index" => $value["index"]
					));
				}
				reset($this->layout_vars["css"]);
			}

			if (is_array($this->layout_vars["js"]) && count($this->layout_vars["js"]))
			{
				foreach ($this->layout_vars["js"] as $key => $value)
				{
					if (strlen($value["theme"]) && array_search($this->oPage->getTheme(), explode(",", $value["theme"])) === false)
						continue;

					$this->oPage->tplAddJs($key, array(
						"file" => $value["file"]
						, "path" => $value["path"]
						, "overwrite" => true
						, "priority" => $value["priority"]
						, "index" => $value["index"]
					));
				}
				reset($this->layout_vars["js"]);
			}
            if (is_array($this->layout_vars["meta"]) && count($this->layout_vars["meta"]))
            {
                foreach ($this->layout_vars["meta"] as $key => $value)
                {
                    $this->oPage->tplAddMeta($key, $value["content"], true, $value["type"]);
                }
                reset($this->layout_vars["meta"]);
            }*/
		//}
		
        $this->doEvent("on_before_routing", array($this));

		// #5: elaborazione richiesta
		//ffErrorHandler::raise("DEBUG", E_USER_ERROR, $this, get_defined_vars());

		// caricamento dei config / common
        /*
		$include_script_path_parts = explode("/", $this->path_info);
		$include_script_path_tmp = __PRJ_DIR__ . "/conf/contents";
		$include_script_path_count = 0;
		while ($include_script_path_count < count($include_script_path_parts) && $include_script_path_tmp .= $include_script_path_parts[$include_script_path_count] . "/")
		{
			if (@is_file($include_script_path_tmp . "config." . FF_PHP_EXT))
				require $include_script_path_tmp . "config." . FF_PHP_EXT;
			if (@is_file($include_script_path_tmp . "config_" . $this->oPage->getTheme() . "." . FF_PHP_EXT))
				require $include_script_path_tmp . "config_" . $this->oPage->getTheme() . "." . FF_PHP_EXT;
			$include_script_path_count++;
		}

		$include_script_path_parts = explode("/", $this->path_info);
		$include_script_path_tmp = __PRJ_DIR__ . "/conf/contents";
		$include_script_path_count = 0;
		while ($include_script_path_count < count($include_script_path_parts) && $include_script_path_tmp .= $include_script_path_parts[$include_script_path_count] . "/")
		{
			if (@is_file($include_script_path_tmp . "common." . FF_PHP_EXT))
				require $include_script_path_tmp . "common." . FF_PHP_EXT;
			if (@is_file($include_script_path_tmp . "common_" . $this->oPage->getTheme() . "." . FF_PHP_EXT))
				require $include_script_path_tmp . "common_" . $this->oPage->getTheme() . "." . FF_PHP_EXT;
			$include_script_path_count++;
		}

		unset($include_script_path_parts, $include_script_path_tmp, $include_script_path_count);
*/

		$this->router_run();

		// LOAD SETTINGS BY COMPONENT
		if (is_dir(__PRJ_DIR__ . "/conf/ffsettings/components"))
		{
			foreach ($this->oPage->components as $key => $value)
			{
				if (defined("FF_URLPARAM_SHOWCASCADELOADER"))
					echo __PRJ_DIR__ . "/conf/ffsettings/components/" . $key . "." . $this->oPage->getTheme() . ".xml<br />\n";
				if (@is_file(__PRJ_DIR__ . "/conf/ffsettings/components/" . $key . "." . $this->oPage->getTheme() . ".xml"))
					$this->load_ffSettings(__PRJ_DIR__ . "/conf/ffsettings/components/" . $key . "." . $this->oPage->getTheme() . ".xml");
				else if (@is_file(__PRJ_DIR__ . "/conf/ffsettings/components/" . $key . ".xml"))
				{
					if (defined("FF_URLPARAM_SHOWCASCADELOADER"))
						echo __PRJ_DIR__ . "/conf/ffsettings/components/" . $key . ".xml<br />\n";
					$this->load_ffSettings(__PRJ_DIR__ . "/conf/ffsettings/components/" . $key . ".xml");
				}
			}
			reset($this->oPage->components);
		}

		$rc = $this->load_ffSettingsByPath($this->path_info);
		if ($rc === false && $this->oPage->page_path !== $this->path_info)
			$rc = $this->load_ffSettingsByPath($this->oPage->page_path);

		$include_script_path_tmp = __PRJ_DIR__ . "/conf/contents" . rtrim($this->path_info, "/") . "/";
		if (@is_file($include_script_path_tmp . "custom." . FF_PHP_EXT))
			require $include_script_path_tmp . "custom." . FF_PHP_EXT;
		if (@is_file($include_script_path_tmp . "custom_" . $this->oPage->getTheme() . "." . FF_PHP_EXT))
			require $include_script_path_tmp . "custom_" . $this->oPage->getTheme() . "." . FF_PHP_EXT;
		unset($include_script_path_tmp);
		
		$this->doEvent("on_before_process", array($this));
		
		$this->oPage->process_params();

		if(CM_PAGECACHE) {
            $this->cache();
        }

		$buffer = null;
		
		if (CM_MIME_FORCE && !$this->isXHR())
		{
			$mime = null;
			$charset = null;
		
			$hsent = ffHTTP_getHeader();
			if ($hsent !== false)
			{
				$mime = $hsent["value"];
				if (array_key_exists("opt_name", $hsent) && $hsent["opt_name"] == "charset")
					$charset = $hsent["opt_value"];

				if (!strlen($mime))
					$mime = null;
				if (!strlen($charset))
					$charset = null;
			}

			if ($mime === null && CM_MIME_FINFO /*&& class_exists("finfo")*/)
			{
				$buffer = $this->oPage->process(false);
				$finfo = new finfo(FILEINFO_MIME_TYPE);
				$mime_type = $finfo->buffer($buffer, FILEINFO_MIME_TYPE);

				if (!strlen($mime_type))
					$mime_type = null;
			}

			if ($mime === null)
				$mime = $this->default_mime;

			if ($charset === null)
				$charset = $this->default_charset;

			$header = "Content-type: " . $mime_type . "; charset=" . $charset;
			header($header);
		}

		if ($buffer === null)
			$this->oPage->process();
		else
			echo $buffer;

		if (cm::DEBUG && cm::NOCACHE) {
            ffErrorHandler::raise("DEBUG CM Process End", E_USER_ERROR, $this, get_defined_vars());
        }
		/*echo "<pre>";
		print_r(ffDB_Sql::$_objProfile);*/
		exit;
	}

	private function router_run()  {
        if (CM_ENABLE_MEM_CACHING && CM_ENABLE_PATH_CACHE)
            $this->router->matched_rules = $this->cache->get($this->path_info, "/cm/router/matches");

        if (!$this->router->matched_rules) {
            $this->router->process($this->path_info, $this->query_string, $_SERVER["HTTP_HOST"]);
            if (CM_ENABLE_MEM_CACHING && CM_ENABLE_PATH_CACHE)
                $this->cache->set($this->path_info, $this->router->matched_rules, "/cm/router/matches");
        }

        if (!is_array($this->router->matched_rules) && !count($this->router->matched_rules))
            ffErrorHandler::raise("CM: no available routes!", E_USER_ERROR, $this, get_defined_vars());

        //ffErrorHandler::raise("DEBUG", E_USER_ERROR, $this, get_defined_vars());
        foreach ($this->router->matched_rules as $key => $match)
        {
            $this->process_next_rule = null;
            $this->real_path_info = null;
            $this->script_name = null;
            $this->is_php = null;
            $this->is_resource = null;
            $this->module = null;

            $this->processed_rule = $match;

            $match_attrs = $match["rule"]->__attributes;

            $this->processed_rule_attrs = $match_attrs;

            if (isset($match["rule"]->destination->header))
            {
                if(isset($match["rule"]->useragent))
                {
                    $skip_rule = true;
                    if(isset($match["rule"]->useragent->browser) && strlen($match["rule"]->useragent->browser))
                    {
                        $arrBrowser = explode(",", strtolower($match["rule"]->useragent->browser));
                        $actualBrowser = $this->getBrowser();
                        if(array_search(strtolower($actualBrowser["name"]), $arrBrowser) !== false)
                        {
                            if(isset($match["rule"]->useragent->version) && strlen($match["rule"]->useragent->version))
                            {
                                $arrBrowserVersion = explode(",", $match["rule"]->useragent->version);
                                if(array_search($actualBrowser["majorver"], $arrBrowserVersion) !== false)
                                {
                                    $skip_rule = false;
                                }
                            }
                            else
                            {
                                $skip_rule = false;
                            }
                        }
                    }
                    if($skip_rule)
                        continue;
                }

                if (isset($match["rule"]->destination->location))
                {
                    $location = str_replace("[SITE_PATH]", FF_SITE_PATH, (string)$match["rule"]->destination->location);

                    for ($i = 0; $i < 10; $i++)
                    {
                        $location = str_replace('$' . $i, $match["params"][$i][0], $location);
                    }
                    /*
                     * Da sistemare, non funziona con stesso path_info su hostname diverso (probabilmente da togliere)
                    if(strlen($location) && strpos($location, str_replace("/index", "/", $this->path_info)) !== 0 && str_replace("/index", "/", $this->path_info) != "/")
                    {
                        continue;
                    }*/

                    ffRedirect($location, (int)$match["rule"]->destination->header);
                }
                else
                    http_response_code((int)$match["rule"]->destination->header);
                exit;
            }
            elseif (isset($match["rule"]->destination->file))
            {
                $file = __PRJ_DIR__ . "/" . trim((string)$match["rule"]->destination->file, "/");
                if (!is_file($file))
                    ffErrorHandler::raise("FILE NOT FOUND", E_USER_ERROR, $this, get_defined_vars());

                ffMedia::sendHeaders($file);
                readfile($file);
                exit;
            }

            if (isset($match["rule"]->destination->url))
                $url = (string)$match["rule"]->destination->url;
            else
                $url = "";

            if (isset($match["rule"]->destination->module))
            {
                $this->module = (string)$match["rule"]->destination->module;
                $this->module_path = CM_MODULES_ROOT . "/" . $this->module;
                if (isset($match["rule"]->destination->module_root))
                    $doc_root = CM_MODULES_ROOT . "/" . $this->module;
                else
                    $doc_root = CM_MODULES_ROOT . "/" . $this->module . "/contents";
            }
            else
            {
                if (isset($match["rule"]->destination->toplevel))
                    $doc_root = __TOP_DIR__;
                else
                    $doc_root =  CM_CONTENT_ROOT; //ff_getAbsDir($url);
            }

            if (isset($match["rule"]->destination->content_root))
                $doc_root = __PRJ_DIR__ . (string)$match["rule"]->destination->content_root;

            for ($i = 0; $i < 10; $i++)
            {
                $url = str_replace('$' . $i, $match["params"][$i][0], $url);
                $doc_root = str_replace('$' . $i, $match["params"][$i][0], $doc_root);
            }

            $url = str_replace("[MAIN_THEME]", FF_THEME_DIR . "/" . cm_getMainTheme(), $url);
            $url = str_replace("[THEME]", FF_THEME_DIR . "/" . $this->oPage->getTheme(), $url);
            $doc_root = str_replace("[MAIN_THEME]", FF_THEME_DIR . "/" . cm_getMainTheme(), $doc_root);
            $doc_root = str_replace("[THEME]", FF_THEME_DIR . "/" . $this->oPage->getTheme(), $doc_root);

            $this->content_root = $doc_root;


            // TOCHECK: inclusione dei parametri $_REQUEST nelle regole. Perchè è disattivato?
            /*if (isset($match["rule"]->params) && isset($match["rule"]->params->param) && count($match["rule"]->params->param))
            {
                foreach ($match["rule"]->params->param as $key => $value)
                {
                    if (CM_ENABLE_MEM_CACHING)
                        $attrs = $value->__attributes;
                    else
                        $attrs = $value->attributes();

                    $value = (string)$attrs["value"];
                    for ($i = 0; $i < 10; $i++)
                    {
                        $value = str_replace('$' . $i, $match["params"][$i][0], $value);
                    }

                    if (strlen($value))
                    {
                        $_REQUEST[(string)$attrs["name"]] = $value;
                    }

                }
            }*/

            // rileva il file giusto da caricare procedendo con test a ritroso
            $tmp_path = $url;
            $tmp_url = $url;


            do
            {
                if ($tmp_path == "" || $tmp_path == "/")
                {
                    $tmp_path = "/index";
                    $tmp_url = "/index" . $tmp_url;
                }

                $tmp_ext = pathinfo($tmp_path, PATHINFO_EXTENSION);
                if (@is_file($doc_root . $tmp_path . "." . FF_PHP_EXT) || (@is_file($doc_root . $tmp_path) && $tmp_ext == FF_PHP_EXT))
                {
                    $this->real_path_info = substr($tmp_url, strlen($tmp_path));
                    if(strlen($tmp_ext))
                        $this->script_name = $tmp_path;
                    else
                        $this->script_name = $tmp_path . "." . FF_PHP_EXT;

                    $this->is_php = true;
                    $this->is_resource = false;
                    break;
                }
                elseif (@is_file($doc_root . $tmp_path . ".html") || (@is_file($doc_root . $tmp_path) && $tmp_ext == "html"))
                {
                    $this->real_path_info = substr($tmp_url, strlen($tmp_path));
                    if(strlen($tmp_ext))
                        $this->script_name = $tmp_path;
                    else
                        $this->script_name = $tmp_path . ".html";
                    $this->is_php = false;
                    $this->is_resource = false;
                    break;
                }
                elseif (@is_file($doc_root . $tmp_path . "/index." . FF_PHP_EXT))
                {
                    $this->real_path_info = substr($tmp_url, strlen($tmp_path));
                    $this->script_name = $tmp_path . "/index." . FF_PHP_EXT;
                    $this->is_php = true;
                    $this->is_resource = false;
                    break;
                }
                elseif (@is_file($doc_root . $tmp_path . "/index.html"))
                {
                    $this->real_path_info = substr($tmp_url, strlen($tmp_path));
                    $this->script_name = $tmp_path . "/index.html";
                    $this->is_php = false;
                    $this->is_resource = false;
                    break;
                }
                elseif(@is_file($doc_root . $tmp_path))
                {
                    $this->real_path_info = substr($tmp_url, strlen($tmp_path));
                    $this->script_name = $tmp_path;
                    $this->is_php = false;
                    $this->is_resource = true;
                    break;
                }

                if ($tmp_path == "/index")
                    break;

                if ($tmp_path != "/index")
                {
                    if (substr($tmp_path, -1) == "/")
                        $tmp_path = substr($tmp_path, 0, -1);
                    else
                        $tmp_path = ffCommon_dirname($tmp_path);
                }
            } while (true);

            if ((!isset($match["rule"]->accept_path_info) || (string)$match["rule"]->accept_path_info == "false") && strlen($this->real_path_info))
            {
                continue;
            }

            // se ha trovato qualcosa da eseguire, lo esegue
            if (strlen($this->script_name))
            {
                $path_parts = explode("/", $this->path_info);
                $script_parts = explode("/", $this->script_name);

                if (
                    end($path_parts) . ".html" == end($script_parts)
                    || end($path_parts) . "." . FF_PHP_EXT == end($script_parts)
                )
                {
                    $this->oPage->page_path = ffCommon_dirname($this->path_info);
                }
                else
                {
                    if (strlen($this->real_path_info))
                        $this->oPage->page_path = substr($this->path_info, 0, strlen($this->real_path_info) * -1);
                    else
                        $this->oPage->page_path = $this->path_info;
                }

                if ($this->is_php)
                {
                    if (file_exists($this->content_root . $this->script_name))
                    {
                        $this->callScript($this->content_root . $this->script_name);
                    }
                    else if (file_exists($this->content_root . $this->script_name . ".php"))
                    {
                        $this->callScript($this->content_root . $this->script_name . ".php");
                    }

                    if ($this->module !== null)
                    {
                        $tmp_mod_parts = explode("/", $this->script_name);
                        array_pop($tmp_mod_parts);
                        $tmp_mod_path = implode("/", $tmp_mod_parts);
                        if (is_file(FF_THEME_DISK_PATH . "/" . cm_getMainTheme() . "/modules/" . $this->module . $tmp_mod_path . "/config.php"))
                            require FF_THEME_DISK_PATH . "/" . cm_getMainTheme() . "/modules/" . $this->module . $tmp_mod_path . "/config.php";
                        if (is_file(FF_THEME_DISK_PATH . "/" . cm_getMainTheme() . "/modules/" . $this->module . $tmp_mod_path . "/common.php"))
                            require FF_THEME_DISK_PATH . "/" . cm_getMainTheme() . "/modules/" . $this->module . $tmp_mod_path . "/common.php";
                        if ($this->oPage->getTheme() !== cm_getMainTheme())
                        {
                            if (is_file($this->oPage->getThemeDir() . "/modules/" . $this->module . $tmp_mod_path . "/config.php"))
                                require $this->oPage->getThemeDir() . "/modules/" . $this->module . $tmp_mod_path . "/config.php";
                            if (is_file($this->oPage->getThemeDir() . "/modules/" . $this->module . $tmp_mod_path . "/common.php"))
                                require $this->oPage->getThemeDir() . "/modules/" . $this->module . $tmp_mod_path . "/common.php";
                        }
                    }
                }
                else
                {
                    if($this->is_resource)
                    {
                        ffMedia::sendHeaders($this->content_root . $this->script_name);
                        readfile($this->content_root . $this->script_name);
                        exit;
                    }
                    else
                    {
                        $this->tpl_content = ffTemplate::factory($this->content_root);
                        $this->tpl_content->load_file($this->script_name, "main");
                        $this->tpl_content->set_var("site_path", FF_SITE_PATH);
                        $this->tpl_content->set_var("theme", $this->oPage->theme);
                        $this->tpl_content->set_var("ret_url", $_REQUEST["ret_url"]);
                        $this->tpl_content->set_var("encoded_ret_url", rawurlencode($_REQUEST["ret_url"]));
                        $this->tpl_content->set_var("encoded_this_url", rawurlencode($_SERVER["REQUEST_URI"]));
                        //$this->preloadApplets($this->tpl_content);

                        $this->doEvent("cm_onParseFixed", array(&$this));
                    }
                }

                if (isset($this->processed_rule["rule"]->blocking) && (string)$this->processed_rule["rule"]->blocking != "false")
                    exit;

                if ($this->process_next_rule === null && isset($this->processed_rule["rule"]->process_next) && (string)$this->processed_rule["rule"]->process_next != "false")
                    $this->process_next_rule = true;

                if (!$this->process_next_rule)
                    break;
            }
        }
        reset($this->router->matched_rules);

        if (
            strlen($this->real_path_info) &&
            (
                !isset($match["rule"]->accept_path_info) ||
                (isset($match["rule"]->accept_path_info) && (string)$match["rule"]->accept_path_info == "false")
            )
        )
        {
            $this->responseCode(404);
        }
    }

	private function cache() {
        // STATIC CACHE
        $cache_avoid_match = false;
        if (strlen(CM_PAGECACHE_AVOIDPATTERN))
        {
            $cache_avoid_patterns = explode(",", CM_PAGECACHE_AVOIDPATTERN);
            foreach ($cache_avoid_patterns as $cache_tmp_pattern)
            {
                if (preg_match("/" . str_replace("/", "\\/", $cache_tmp_pattern) . "/", $this->path_info))
                {
                    $cache_avoid_match = true;
                    break;
                }
            }
        }

        if (
            CM_PAGECACHE
            && !$this->isXHR()
            && !cm::NOCACHE
            && !cm::DEBUG
            && !defined("CM_DONT_RUN")
            && strpos($this->path_info, "sitemap.xml") === false
            && !$cache_avoid_match
            && (!defined("ALLOW_PAGECACHE") || ALLOW_PAGECACHE)
        )
        {
            define("ALLOW_PAGECACHE", true);

            $cache_dir = CM_PAGECACHE_DIR;
            if (CM_PAGECACHE_BYDOMAIN)
            {
                $cache_domain_prefix = $_SERVER["HTTP_HOST"];
                if (CM_PAGECACHE_BYDOMAIN_STRIPWWW && strpos($cache_domain_prefix, "www.") === 0)
                    $cache_domain_prefix = substr($cache_domain_prefix, 4);
                $cache_dir .= "/" . $cache_domain_prefix;
            }

            $cache_path_info = $this->path_info;
            if (CM_PAGECACHE_GROUPHASH)
            {
                $hash = sha1($this->path_info);
                $parts = str_split($hash, CM_PAGECACHE_HASHSPLIT);
                $cache_dir .= "/" . implode("/", $parts);
                if (CM_PAGECACHE_GROUPHASH_STRIPPATH)
                    $cache_path_info = "";
            }

            if (file_exists($cache_dir))
            {
                if (CM_PAGECACHE_ASYNC && defined("FF_URLPARAM_GENCACHE"))
                {
                    if (CM_PAGECACHE_GROUPDIRS)
                    {
                        $itGroup = new DirectoryIterator($cache_dir);
                        foreach($itGroup as $fiGroup)
                        {
                            if($fiGroup->isDot())
                                continue;

                            $filePath = $fiGroup->getPathname();
                            $file = $filePath . $cache_path_info;// . "/" . $_SERVER["HTTP_IF_NONE_MATCH"];
                            cm_filecache_empty_dir($file);
                        }
                    }
                    else
                    {
                        $file = $cache_dir . $cache_path_info;// . "/" . $_SERVER["HTTP_IF_NONE_MATCH"];
                        cm_filecache_empty_dir($file);
                    }
                }
                else
                {
                    $now = time();

                    // FIRST: try to find the exact file requested (not others) based on E-Tag
                    if (isset($_SERVER["HTTP_IF_NONE_MATCH"]))
                    {
                        if (CM_PAGECACHE_GROUPDIRS)
                        {
                            $itGroup = new DirectoryIterator($cache_dir);
                            foreach($itGroup as $fiGroup)
                            {
                                if($fiGroup->isDot())
                                    continue;

                                $filePath = $fiGroup->getPathname();
                                $file = $filePath . $cache_path_info . "/" . $_SERVER["HTTP_IF_NONE_MATCH"];
                                if (false !== ($fctime = @filectime($file)))
                                {
                                    if (filemtime($file) > $now)
                                    {
                                        $cache_valid = true;
                                    }
                                    else if (!CM_PAGECACHE_LAST_VALID
                                        || $now < CM_PAGECACHE_LAST_VALID
                                        || $fctime >= CM_PAGECACHE_LAST_VALID
                                    )
                                    {
                                        if (!CM_PAGECACHE_REUSE)
                                            @unlink($file);
                                        else
                                            $cache_valid = true;
                                    }
                                    else
                                    {
                                        @unlink($file);
                                    }
                                }

                                if ($cache_valid)
                                    break;
                            }
                        }
                        else
                        {
                            $file = $cache_dir . $cache_path_info . "/" . $_SERVER["HTTP_IF_NONE_MATCH"];
                            if (false !== ($fctime = @filectime($file)))
                            {
                                if (filemtime($file) > $now)
                                {
                                    $cache_valid = true;
                                }
                                else if (!CM_PAGECACHE_LAST_VALID
                                    || $now < CM_PAGECACHE_LAST_VALID
                                    || $fctime >= CM_PAGECACHE_LAST_VALID
                                )
                                {
                                    if (!CM_PAGECACHE_REUSE)
                                        @unlink($file);
                                    else
                                        $cache_valid = true;
                                }
                                else
                                {
                                    @unlink($file);
                                }
                            }
                        }

                        if ($cache_valid)
                        {
                            http_response_code(304);
                            exit;
                        }
                    }

                    // find right file
                    if (null !== ($find_cache_file = cm_filecache_find($cache_dir
                            , $cache_path_info
                            , CM_PAGECACHE_GROUPDIRS
                            , CM_PAGECACHE_FIXED_MAXAGE
                            , CM_PAGECACHE_LAST_VALID
                            , CM_PAGECACHE_SCALEDOWN
                            , $now
                            , null
                            , true
                            , CM_PAGECACHE_REUSE
                        ))
                    )
                    {
                        if (CM_PAGECACHE_DISABLE_COMPRESSIONS || !ffHTTP_encoding_isset("gzip"))
                        {
                            if ($find_cache_file["uncompressed"] !== null)
                                $cache_file = $find_cache_file["uncompressed"];
                        }
                        else
                        {
                            if ($find_cache_file["compressed"] !== null)
                                $cache_file = $find_cache_file["compressed"];
                            else if (CM_PAGECACHE_SCALEDOWN && $find_cache_file["uncompressed"] !== null)
                                $cache_file = $find_cache_file["uncompressed"];
                        }
                    }

                    if ($cache_file !== null)
                    {
                        if ($cache_file["compressed"] !== false)
                            header("Content-Encoding: " . $cache_file["compressed"]);

                        $mime_type = ffMedia::getMimeTypeByExtension($cache_file["file_parts"][1], "text/html");
                        if ($mime_type == "text/html")
                            $mime_type .= "; charset=UTF-8";
                        header("Content-type: " . $mime_type);

                        // send max-age
                        if (!$cache_file["reused"])
                        {
                            if (CM_PAGECACHE_FIXED_MAXAGE)
                                $max_age = $cache_file["file_parts"][2];
                            else
                            {
                                $max_age = $cache_file["fmtime"] - $now;
                                if ($max_age > $cache_file["file_parts"][2])
                                    $max_age = $cache_file["file_parts"][2];
                            }
                        }
                        else
                        {
                            $max_age = CM_PAGECACHE_REUSE_AGE;
                        }

                        header("Cache-Control: public, max-age=" . $max_age);

                        header("ETag: " . $cache_file["filename"]);

                        readfile($cache_file["file"]);
                        exit;
                    }
                }
            }

            // nessuna cache trovata
            if (CM_PAGECACHE_ASYNC && !defined("FF_URLPARAM_GENCACHE") && CM_PAGECACHE_ASYNC_MISSING)
            {
                http_response_code(CM_PAGECACHE_MISSING_HEADER);
                if (CM_PAGECACHE_MISSING_RETRY !== false)
                {
                    header("Retry-After: " . CM_PAGECACHE_MISSING_RETRY);
                }
                exit;
            }

            $this->cache_router = cmRouter::getInstance("__cm_cache__");
        }
        else
        {
            if (!defined("ALLOW_PAGECACHE"))
                define("ALLOW_PAGECACHE", false);
        }


        ///cacche
        if(ALLOW_PAGECACHE) {
            if(CM_ENABLE_MEM_CACHING)
                $cache_router_loaded = $this->cache_router->loadMem();

            if (!$cache_router_loaded)
            {
                $this->cache_router->loadFile(cm_confCascadeFind(__DIR__ . "/conf", "/cm", "cache_routing_table.xml"));

                if (is_file(__PRJ_DIR__ . "/conf/cache_routing_table.xml"))
                    $this->cache_router->loadFile(__PRJ_DIR__ . "/conf/cache_routing_table.xml");
            }
        }

        if (CM_ENABLE_MEM_CACHING && ALLOW_PAGECACHE && !$cache_router_loaded)
        {
            $this->cache_router->orderRules();
            $this->cache->set("cm/cache_router/rules", $this->cache_router->rules);
            $this->cache->set("cm/cache_router/named_rules", $this->cache_router->named_rules);
        }

        //cache router
        if (CM_ENABLE_MEM_CACHING && ALLOW_PAGECACHE && !$cache_router_loaded)
        {
            $this->cache_router->orderRules();
            $this->cache->set("cm/cache_router/rules", $this->cache_router->rules);
            $this->cache->set("cm/cache_router/named_rules", $this->cache_router->named_rules);
        }
        if (
            ALLOW_PAGECACHE
            && $this->cache_force_enable !== false
            && http_response_code() == 200
            && !@file_exists($cache_dir . "/disk_fail")
            && (
                !CM_PAGECACHE_ASYNC
                || (
                    CM_PAGECACHE_ASYNC && defined("FF_URLPARAM_GENCACHE")
                )
            )
        )
        {
            $enable_cache = false;
            $cache_disk_fail = false;
            $max_age = CM_PAGECACHE_DEFAULT_MAXAGE;
            $expires = null;

            if ($this->cache_force_max_age === null || $this->cache_force_expire === null)
            {
                if (CM_ENABLE_MEM_CACHING && CM_CACHE_ROUTER_MATCH)
                    $this->cache_router->matched_rules = $this->cache->get($this->path_info, "/cm/cache_router/matches");

                if (!$this->cache_router->matched_rules) {
                    $this->cache_router->process($this->path_info, $this->query_string, $_SERVER["HTTP_HOST"]);
                    if (CM_ENABLE_MEM_CACHING && CM_CACHE_ROUTER_MATCH)
                        $this->cache->set($this->path_info, $this->cache_router->matched_rules, "/cm/cache_router/matches");
                }

                if (is_array($this->cache_router->matched_rules) && count($this->cache_router->matched_rules))
                {
                    foreach ($this->cache_router->matched_rules as $key => $match)
                    {
                        $process_next = false;
                        if (isset($match["rule"]->control))
                        {
                            if (strtolower($match["rule"]->control) == "disabled")
                                $enable_cache = false;
                            elseif (strtolower($match["rule"]->control) == "enabled")
                                $enable_cache = true;
                        }

                        if (isset($match["rule"]->expires))
                            $expires = intval($match["rule"]->expires);
                        if (isset($match["rule"]->max_age))
                            $max_age = intval($match["rule"]->max_age);

                        if (isset($match["rule"]->process_next))
                            $process_next = true;
                        if (!$process_next)
                            break;
                    }
                    reset($this->cache_router->matched_rules);
                }

                if ($this->cache_force_expire !== null)
                    $expires = $this->cache_force_expire;
                if ($this->cache_force_max_age !== null)
                    $max_age = $this->cache_force_max_age;
            }

            if (!is_numeric($max_age) || $max_age < 0)
                $max_age = CM_PAGECACHE_DEFAULT_MAXAGE;
            if (!is_numeric($expires) || $expires < 0)
                $expires = $max_age;

            $this->doEvent("on_cache", array(&$this, &$enable_cache, &$max_age, &$expires));

            if ($this->cache_force_enable || $enable_cache)
            {
                $buffer = $this->oPage->process(false);

                // detect output mime-type and extension for file
                $mime_type = null;
                $hsent = false;
                $extension = null;
                $charset = null;

                $hlist = headers_list();
                foreach($hlist as $key => $value)
                {
                    $rc = preg_match("/\s*([^:\s]+)\s*:\s*([^;\s]+)(;\s*([^=]+)\s*=(.+))?/", $value, $matches);
                    if ($rc && strtolower($matches[1]) == "content-type")
                    {
                        $mime_type = $matches[2];
                        $hsent = true;

                        if ($matches[4] == "charset")
                            $charset = $matches[5];
                    }
                }

                if ($mime_type === null && strlen($this->path_info))
                {
                    $extension = (($extension = pathinfo($this->path_info, PATHINFO_EXTENSION)) === "" ? null : $extension);
                    if ($extension !== null)
                        $mime_type = ffMedia::getMimeTypeByExtension($extension, null);
                    if ($mime_type === null)
                        $extension = null;
                }

                if ($mime_type === null && class_exists("finfo"))
                {
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mime_type = $finfo->buffer($buffer, FILEINFO_MIME_TYPE);
                }

                if ($mime_type !== null && $extension === null)
                {
                    $extension = ffMedia::getExtensionByMimeType($mime_type);
                    if ($extension === null)
                        $mime_type = null;
                }

                if ($mime_type === null)
                {
                    $mime_type = "text/html";
                    $extension = "html";
                }

                if ($mime_type == "text/html" && $charset === null)
                {
                    $mime_type .= "; charset=UTF-8";
                    $hsent = false;
                }

                if (!$hsent)
                    header("Content-type: " . $mime_type);

                // make & save cache
                $now = time();

                $id = uniqid();
                $etag = $id . "." . $extension;
                $file = $id . "." . $extension;

                $file .= "." . $max_age;
                $etag .= "." . $max_age;

                $compression = false;
                if (!CM_PAGECACHE_DISABLE_COMPRESSIONS && $this->oPage->compress && ffHTTP_encoding_isset("gzip"))
                    $compression = true;

                $rc_cache = true;

                // when making main dir fail, don't do anything at all
                if ($rc_cache && !is_dir($cache_dir))
                    $rc_cache = @mkdir($cache_dir, 0777, true);

                // write it uncompressed
                if ($rc_cache && $find_cache_file["uncompressed"] === null && (!$compression || CM_PAGECACHE_WRITEALL))
                {
                    if (CM_PAGECACHE_GROUPDIRS)
                    {
                        $cache_group_dir = 0;
                        $rc_cache = cm_filecache_groupwrite(CM_PAGECACHE_DIR, $cache_dir, $cache_path_info, $file, $buffer, ($now + $expires), CM_PAGECACHE_MAXGROUPDIRS, $cache_group_dir, $cache_disk_fail);
                    }
                    else
                        $rc_cache = cm_filecache_write($cache_dir . $cache_path_info, $file, $buffer, ($now + $expires));
                }

                // manage compressions
                if ($rc_cache && ($compression || ($find_cache_file["compressed"] === null && CM_PAGECACHE_WRITEALL)))
                {
                    $ret = ffTemplate::http_compress($buffer, false, "gzip");
                    if ($rc_cache && $find_cache_file["compressed"] === null)
                    {
                        if (CM_PAGECACHE_GROUPDIRS)
                        {
                            if ($cache_group_dir > 0)
                                $cache_group_dir--; // reuse uncompressed' one
                            else
                                $cache_group_dir = 0;

                            $rc_cache = cm_filecache_groupwrite(CM_PAGECACHE_DIR, $cache_dir, $cache_path_info, $file . "." . $ret["method"], $ret["data"], ($now + $expires), CM_PAGECACHE_MAXGROUPDIRS, $cache_group_dir, $cache_disk_fail);
                        }
                        else
                            $rc_cache = cm_filecache_write($cache_dir . $cache_path_info, $file . "." . $ret["method"], $ret["data"], ($now + $expires));
                    }

                    if ($compression)
                    {
                        $buffer = $ret["data"];

                        if ($rc_cache)
                        {
                            $file .= ".gzip"; // just to align, not really used
                            $etag .= ".gzip";
                        }
                    }
                }

                if ($rc_cache)
                {
                    $this->doEvent("on_cache_write", array(&$this, $now, $compression));

                    header("Cache-Control: public, max-age=" . $max_age); // public: to let firefox cache over https

                    header("ETag: " . $etag);
                }

                if ($compression !== false)
                    header("Content-encoding: gzip");

                echo $buffer;
                exit;
            }
        }
    }

	static function oPage_on_page_process()
	{
		$cm = cm::getInstance();

        if ($cm->tpl_content !== null)
        {
            $cm->oPage->addContent($cm->tpl_content);
        }

		$cm->preloadApplets($cm->oPage->tpl[0]);
		$cm->preloadApplets($cm->oPage->tpl_layer[0]);
			
		foreach ($cm->oPage->sections as $key => $value)
		{
		    if($value["tpl"] instanceof ffTemplate) {
                $cm->preloadApplets($cm->oPage->sections[$key]["tpl"]);
            }
		}
		reset($cm->oPage->sections);
		
		foreach  ($cm->oPage->components as $key => $value)
		{
			$cm->preloadApplets($cm->oPage->components[$key]->tpl[0]);
		}
		
		foreach ($cm->oPage->contents as $key => $content)
		{
		    if($content["data"]) {
		        $ref =& $content["data"];
            } else {
                $ref =& $content;
            }

			if (is_object($ref) && get_class($ref) == "ffTemplate") {
                $cm->preloadApplets($ref);
            } elseif (is_string($ref)) {
                $cm->preloadAppletsContent($ref);
            }
		}
	}
    static function oPage_on_page_processed($oPage) {
        $cm = cm::getInstance();

        if(is_array($cm->loaded_applets) && count($cm->loaded_applets)) {
            $oPage->output_buffer["html"] = $cm->parseAppletsContent($oPage->output_buffer["html"]);
        }
    }

    /*static function oPage_on_process_parts($oPage, $tpl) // RIDONDANTE, È SUFFICIENTE oPage_on_page_process
    {
        if (is_array($tpl))
            $tpl = $tpl[0];

        cm::getInstance()->preloadApplets($tpl);
    }

/*	static function oPage_on_after_process_components($oPage)
	{
        $cm = cm::getInstance();

		$cm->parseApplets($oPage->tpl);
		$cm->parseApplets($oPage->tpl_layer);

		//ffErrorHandler::raise("asd", E_USER_ERROR, null, get_defined_vars());

		foreach ($cm->oPage->sections as $key => $value)
		{
			$cm->parseApplets($cm->oPage->sections[$key]["tpl"]);
		}
		reset($cm->oPage->sections);
		
		foreach  ($cm->oPage->components as $key => $value)
		{
			$cm->parseApplets($cm->oPage->components[$key]->tpl[0]);
		}
		
		foreach ($cm->oPage->contents as $key => $content)
		{
			if (is_object($content["data"]) && get_class($content["data"]) == "ffTemplate")
				$cm->parseApplets($content["data"]);
			elseif (is_string($content["data"]))
				$cm->parseAppletsContent($content["data"]);
		}
		
		if ($cm->tpl_content !== null)
		{
			$cm->parseApplets(array($cm->tpl_content));

			$oPage->addContent($cm->tpl_content->rpparse("main", false), null, $cm->tpl_content->sTemplate);
		}
	}*/
	
	static function onRedirect($destination, $http_response_code, $add_params, $response = array())
	{
		$cm = cm::getInstance();
		if ($cm->isXHR())
		{
			http_response_code(200); // force proper response code

			$out = array_merge($response, $cm->json_response);
            $out["url"] = $destination;
            //$out["url"] = $destination === null ? "" : $destination;
			$out["close"] = false;

			cm::jsonParse($out);
			exit;
		}
	}

	function preloadApplets($tpl)
	{
        if($tpl) {
            if (is_object($tpl) && get_class($tpl) == "ffTemplate") {
                $applets = $tpl->getDApplets();
                if (is_array($applets) && count($applets)) {
                    foreach ($applets AS $appletid => $applet) {
                        if (!isset($this->loaded_applets[$appletid])) {
                            $this->includeApplet($applet["name"], $applet["params"], $appletid);
                        }
                    }
                }
            } else {
                ffErrorHandler::raise("Preload Applets: Missing ffTemplate", E_USER_ERROR, null, get_defined_vars());
            }
        }

/*
		if (is_array($tpl->DVars) && count($tpl->DVars))
		{
			foreach ($tpl->DVars as $key => $ignore)
			{
				if ($tmp = preg_match('/\[([\w\:\=\|\-]+)\]/U', $key, $matches))
				{
					$applet_parts = explode(":", $matches[1]);
					
					$applet = $applet_parts[0];
					
					$params = array();
					$order_params = array();
					if (count($applet_parts) > 1)
					{
						for ($i = 1; $i < count($applet_parts); $i++)
						{
							$params_parts = explode("=", $applet_parts[$i]);
							if (count($params_parts) == 2)
							{
								$params[$params_parts[0]] = $params_parts[1];
								$order_params[] = array("index" => $params_parts[0], "counter" => count($params) - 1, "value" => $params_parts[1]);
							}
						}
					}

					$rc = usort($order_params, "ffCommon_IndexOrder");
					if (!$rc)
						ffErrorHandler::raise("UNABLE TO SORT", E_USER_ERROR, null, get_defined_vars());

					$ordered_params = "";
					foreach ($order_params as $subkey => $subvalue)
					{
						$ordered_params .= ":" . $subvalue["index"] . "=" . $subvalue["value"];
					}

					$appletid = "[" . $applet . $ordered_params . "]";

					foreach ($tpl->DBlocks as $subkey => $subvalue)
					{
						$tpl->DBlocks[$subkey] = str_replace("{" . $key . "}", "{" . $appletid . "}", $tpl->DBlocks[$subkey]);
					}
					reset($tpl->DBlocks);

					unset($tpl->DVars[$key]);// = $appletid;
					$tpl->DVars[$appletid] = "changed by PreloadApplets";

					if (!isset($this->loaded_applets[$appletid]))
						$this->includeApplet($applet, $params, $appletid);
				}
			}
			reset($tpl->DVars);
		}*/
	}

	function preloadAppletsContent($content)
	{
	    $regexp = '/\{\[(.+)\]\}/U';

		$tmp = preg_match_all($regexp, $content, $matches);
		if (is_array($matches[1]) && count($matches[1]))
		{
			foreach ($matches[1] as $key => $value)
			{
				$applet_parts = explode(":", $value);

				$applet = $applet_parts[0];

				$params = array();
				$order_params = array();
				if (count($applet_parts) > 1)
				{
					for ($i = 1; $i < count($applet_parts); $i++)
					{
						$params_parts = explode("=", $applet_parts[$i]);
						if (count($params_parts) == 2)
						{
							$params[$params_parts[0]] = $params_parts[1];
							$order_params[] = array("index" => $params_parts[0], "counter" => count($params) - 1, "value" => $params_parts[1]);
						}
					}
				}

				$rc = usort($order_params, "ffCommon_IndexOrder");
				if (!$rc)
					ffErrorHandler::raise("UNABLE TO SORT", E_USER_ERROR, null, get_defined_vars());

				$ordered_params = "";
				foreach ($order_params as $subkey => $subvalue)
				{
					$ordered_params .= ":" . $subvalue["index"] . "=" . $subvalue["value"];
				}

				$appletid = "[" . $applet . $ordered_params . "]";

				$content = str_replace("{[" . $value . "]}", "{" . $appletid . "}", $content);

				if (!isset($this->loaded_applets[$appletid]))
					$this->includeApplet($applet, $params, $appletid);
			}
			reset($matches);
		}

		return $content;
	}

    function parseAppletsContent($content)
    {
        if (is_array($this->loaded_applets) && count($this->loaded_applets)) {
            foreach ($this->loaded_applets as $key => $value) {
                if(is_array($value["buffer"])) {
                    $html = $value["buffer"]["html"];
                    if($value["buffer"]["js"]) {
                        $this->oPage->tplAddJs($key, array(
                            "embed" => $value["buffer"]["js"]
                        ));
                    }
                    if($value["buffer"]["css"]) {
                        $this->oPage->tplAddCss($key, array(
                            "embed" => $value["buffer"]["css"]
                        ));
                    }
                } else {
                    $html = $value["buffer"];
                }

                $content = str_replace("{" . $key . "}", $html, $content);
            }
        }
        return $content;
    }

	function includeApplet($appletname, $applet_params, $appletid)
	{
		//echo "$appletname, $applet_params, $appletid<br />";
		$this->loaded_applets[$appletid]["params"] = $applet_params;

		$appletname_parts = explode("|", $appletname);
		if (count($appletname_parts) == 2)
		{
			$this->loaded_applets[$appletid]["module"] = $appletname_parts[0];
			$this->loaded_applets[$appletid]["name"] = $appletname_parts[1];
			$applet_file = CM_MODULES_ROOT . "/" . $appletname_parts[0] . "/applets/" . $appletname_parts[1] . "/index." . FF_PHP_EXT;
		}
		else
		{
			$this->loaded_applets[$appletid]["name"] = $appletname;
			$applet_file = __PRJ_DIR__ . "/applets/" . $appletname . "/index." . FF_PHP_EXT;
		}
		
		$cm = $this;

		if (file_exists($applet_file))
			include $applet_file;
		else
			ffErrorHandler::raise("APPLET NON TROVATA", E_USER_ERROR, $this, get_defined_vars());
		
		if (ffIsset($this->loaded_applets[$appletid], "comps"))
		{
			// LOAD SETTINGS BY COMPONENT
			if (is_dir(__PRJ_DIR__ . "/conf/ffsettings/components"))
			{
				foreach ($this->loaded_applets[$appletid]["comps"] as $key)
				{
					if (defined("FF_URLPARAM_SHOWCASCADELOADER"))
						echo __PRJ_DIR__ . "/conf/ffsettings/components/" . $key . "." . $this->oPage->getTheme() . ".xml<br />\n";
					if (@is_file(__PRJ_DIR__ . "/conf/ffsettings/components/" . $key . "." . $this->oPage->getTheme() . ".xml"))
						$this->load_ffSettings(__PRJ_DIR__ . "/conf/ffsettings/components/" . $key . "." . $this->oPage->getTheme() . ".xml");
					else if (@is_file(__PRJ_DIR__ . "/conf/ffsettings/components/" . $key . ".xml"))
					{
						if (defined("FF_URLPARAM_SHOWCASCADELOADER"))
							echo __PRJ_DIR__ . "/conf/ffsettings/components/" . $key . ".xml<br />\n";
						$this->load_ffSettings(__PRJ_DIR__ . "/conf/ffsettings/components/" . $key . ".xml");
					}
				}
			}
		}

        /** @var include $out_buffer */
        $this->loaded_applets[$appletid]["buffer"] = $out_buffer;
		
		$this->oPage->process_params();
		return $out_buffer;
	}

	function callScript($file)
	{
		$ff = ffGlobals::getInstance("ff");
		$cm = $this;

		$this->doEvent("on_beforeCallScript", array(&$this, $this->script_name));
		
		require $file;
		
		$this->doEvent("on_callScript", array(&$this, $this->script_name));
	}
	
	function load_ffSettingsByPath($path_info = null)
	{
		if ($path_info === null)
			$path_info = $this->path_info;
		
		if (is_file($file = rtrim(__PRJ_DIR__ . "/conf/contents" . $path_info, "/") . "/ff_settings." . $this->oPage->getTheme() . ".xml"))
			return $this->load_ffSettings($file);
		else if (is_file($file = rtrim(__PRJ_DIR__ . "/conf/contents" . $path_info, "/") . "/ff_settings.xml"))
			return $this->load_ffSettings($file);
		else
			return false;
	}

	function load_ffSettings($file)
	{
		$res = $this->doEvent("load_ffSettings", array($this, $file));
		$rc = end($res);
		if ($rc !== null)
		{
			if ($rc === true)
				return false;
			else
				$file = $rc;
		}
		
		//if (isset($this->ff_settings_loaded[$file]))
		//	return true;

		//$this->ff_settings_loaded[$file] = true;

		$xml = new SimpleXMLElement("file://" . $file, null, true);

		if (isset($xml->ffPage) && count($xml->ffPage->children()))
		{
			foreach ($xml->ffPage->children() as $key => $value)
			{
				switch ($key)
				{
					case "option":
						$attrs	= $value->attributes();
						$name	= (string)$attrs["name"];
						$mode	= (string)$attrs["mode"];
						if (isset($this->oPage->$name))
						{
							if ($mode)
								$this->ff_settings_merge($this->oPage->$name, $this->ff_settings_process_value($value));
							else
								$this->oPage->$name = $this->ff_settings_process_value($value);
							
						}
						else
							ffErrorHandler::raise("Wrong ffPage option", E_USER_ERROR, $this, get_defined_vars());
						break;
					
					case "event":
						$attrs	= $value->attributes();

						$event	= $this->ff_settings_process_event($attrs, $value);
						$this->oPage->addEvent($event["event_name"], $event["func_name"], $event["priority"], $event["index"], $event["break_when"], $event["break_value"], $event["additional_data"]);
						break;

					case "ffGrid":
					case "ffRecord":
					case "ffDetails":
						$attrs	= $value->attributes();
						$id		= (string)$attrs["id"];
						if (!isset($this->oPage->components[$id]))
							continue;
							
						foreach ($value as $subkey => $subvalue)
						{
							switch ($subkey)
							{
								case "event":
									$attrs	= $subvalue->attributes();

									$event	= $this->ff_settings_process_event($attrs, $subvalue);
									$this->oPage->components[$id]->addEvent($event["event_name"], $event["func_name"], $event["priority"], $event["index"], $event["break_when"], $event["break_value"], $event["additional_data"]);
									break;

								case "option":
									$attrs	= $subvalue->attributes();
									$name	= (string)$attrs["name"];
									$mode	= (string)$attrs["mode"];
									if ($mode)
										$this->ff_settings_merge($this->oPage->components[$id]->$name, $this->ff_settings_process_value($subvalue));
									else
										$this->oPage->components[$id]->$name = $this->ff_settings_process_value($subvalue);
									break;
								
								case "ffField":
								case "ffButton":
									$this->ff_settings_process_element($subkey, $key, $id, $subvalue);
									break;
							}
						}
						break;
					
					case "ffField":
					case "ffButton":
						$this->ff_settings_process_element($key, "ffPage", null, $value);
						break;
				}
			}
		}
		
		return true;
	}
	
	function ff_settings_process_element($type, $container_type, $container_id, $element)
	{
		$attrs	= $element->attributes();
		$field_id	= (string)$attrs["id"];
		$field_type	= (string)$attrs["type"];

		$field = null;
		if ($type === "ffButton")
		{
			switch ($container_type)
			{
				case "ffPage":
					$field = $this->oPage->buttons[$field_id];
					break;
				
				case "ffGrid":
					if (!array_key_exists($container_id, $this->oPage->components))
						//ffErrorHandler::raise ("ffSettings - Unknown container", E_USER_ERROR, $this, get_defined_vars());
						return;
				
					switch ($field_type)
					{
						case "grid":
							$field = $this->oPage->components[$container_id]->grid_buttons[$field_id];
							break;
						case "action":
							$field = $this->oPage->components[$container_id]->action_buttons[$field_id];
							break;
						case "action_header":
							$field = $this->oPage->components[$container_id]->action_buttons_header[$field_id];
							break;
						case "search":
							$field = $this->oPage->components[$container_id]->search_buttons[$field_id];
							break;
					}
					break;
				case "ffRecord":
					if (!array_key_exists($container_id, $this->oPage->components))
						//ffErrorHandler::raise ("ffSettings - Unknown container", E_USER_ERROR, $this, get_defined_vars());
						return;
				
					switch ($field_type)
					{
						case "action":
						default:
							$field = $this->oPage->components[$container_id]->action_buttons[$field_id];
							break;
					}
					break;
				case "ffDetails":
					if (!array_key_exists($container_id, $this->oPage->components))
						//ffErrorHandler::raise ("ffSettings - Unknown container", E_USER_ERROR, $this, get_defined_vars());
						return;
				
					switch ($field_type)
					{
						case "content":
						default:
							$field = $this->oPage->components[$container_id]->detail_buttons[$field_id];
							break;
					}
					break;
			}
		}
		elseif ($type === "ffField")
		{
			if ($container_type == "ffPage")
			{
				$field = $this->oPage->fields[$field_id];
			}
			else
			{
				if (!array_key_exists($container_id, $this->oPage->components))
					//ffErrorHandler::raise ("ffSettings - Unknown container", E_USER_ERROR, $this, get_defined_vars());
					return;
				
				switch ($field_type)
				{
					case "display":
						$field = $this->oPage->components[$container_id]->grid_fields[$field_id];
						break;

					case "search":
						$field = $this->oPage->components[$container_id]->search_fields[$field_id];
						break;

					case "key":
						$field = $this->oPage->components[$container_id]->key_fields[$field_id];
						break;

					case "form":
						$field = $this->oPage->components[$container_id]->form_fields[$field_id];
						break;
				}
			}
		}
		else
			ffErrorHandler::raise("ffSettings - UNHANDLED ELEMENT", E_USER_ERROR, $this, get_defined_vars());
		
		if (!$field)
			//ffErrorHandler::raise ("ffSettings - Unknown element", E_USER_ERROR, $this, get_defined_vars());
			return;

		foreach ($element->children() as $field_key => $field_value)
		{
			switch ($field_key)
			{
				case "event":
					$attrs	= $field_value->attributes();

					$event	= $this->ff_settings_process_event($attrs, $field_value);
					$field->addEvent($event["event_name"], $event["func_name"], $event["priority"], $event["index"], $event["break_when"], $event["break_value"], $event["additional_data"]);
					break;

				case "option":
					$attrs	= $field_value->attributes();
					$name = (string)$attrs["name"];
					$mode = (string)$attrs["mode"];
					if ($mode)
						$this->ff_settings_merge($field->$name, $this->ff_settings_process_value($field_value));
					else
						$field->$name = $this->ff_settings_process_value($field_value);
					break;
					
				case "array":
					$arr_key = (string)$field_value->arr_key;
					
					if (count($field_value->arr_value->children())) // suboptions
					{
						foreach ($field_value->arr_value->children() as $key_opt => $item_opt)
						{
							if ($key_opt == "option")
							{
								$attrs	= $item_opt->attributes();
								$name = (string)$attrs["name"];
								$mode = (string)$attrs["mode"];
								if ($mode)
									$this->ff_settings_merge($field[$arr_key]->$name, $this->ff_settings_process_value($item_opt));
								else
									$field[$arr_key]->$name = $this->ff_settings_process_value($item_opt);
							}
							else
								ffErrorHandler::raise("Wrong ff_settings.xml format", E_USER_ERROR, $this, get_defined_vars());
						}
					}
					else
						$field[$arr_key] = $this->ff_settings_process_value($field_value->arr_value);
					break;

				default:
					ffErrorHandler::raise("Wrong ff_settings.xml format", E_USER_ERROR, $this, get_defined_vars());
			}
		}
	}

	function ff_settings_merge(&$ori, $new)
	{
		if (is_string($new))
		{
			$ori .= $new;
			return;
		}
		
		if (!is_array($new))
		{
			$ori = $new;
			return;
		}

		foreach ($new as $key => $value)
		{
			if (!isset($ori[$key]))
				$ori[$key] = $value;
			else
				$this->ff_settings_merge($ori[$key], $new[$key]); // $this->ff_settings_merge(&$ori[$key], $new[$key]);
		}
		reset($ori);
	}

	function ff_settings_process_event($attrs, $element)
	{
		$event_name			= (string)$attrs["event_name"];
		$func_name			= (string)$attrs["func_name"];

		$priority			= (string)$attrs["priority"];
		switch ($priority)
		{
			case "PRIORITY_TOPLEVEL":
				$priority = ffEvent::PRIORITY_TOPLEVEL;
				break;

			case "PRIORITY_HIGH":
				$priority = ffEvent::PRIORITY_HIGH;
				break;

			case "PRIORITY_NORMAL":
				$priority = ffEvent::PRIORITY_NORMAL;
				break;

			case "PRIORITY_LOW":
				$priority = ffEvent::PRIORITY_LOW;
				break;

			case "PRIORITY_FINAL":
				$priority = ffEvent::PRIORITY_FINAL;
				break;

			default:
				$priority = null;
		}

		$index	= (int)$attrs["index"];
		if (!strlen($index))
			$index = 0;

		$break_when			= (string)$attrs["break_when"];
		switch ($break_when)
		{
			case "BREAK_NEVER":
				$break_when = ffEvent::BREAK_NEVER;
				break;

			case "BREAK_EQUAL":
				$break_when = ffEvent::BREAK_EQUAL;
				break;

			case "BREAK_NOT_EQUAL":
				$break_when = ffEvent::BREAK_NOT_EQUAL;
				break;

			case "BREAK_CALLBACK":
				$break_when = ffEvent::BREAK_CALLBACK;
				break;

			default:
				$break_when = null;
		}

		if ($element->break_value)
			$break_value = $this->ff_settings_process_value($element->break_value);
		else
			$break_value = null;

		if ($element->additional_data)
			$additional_data = $this->ff_settings_process_value($element->additional_data);
		else
			$additional_data = null;

		return array(
				"event_name"			=> $event_name
				, "func_name"			=> $func_name
				, "priority"			=> $priority
				, "index"				=> $index
				, "break_when"			=> $break_when
				, "break_value"			=> $break_value
				, "additional_data"		=> $additional_data
			);
	}

	function ff_settings_process_value($element)
	{
		$value = null;
		
		if (count($element->children()))
		{
			$value = array();
			foreach ($element->children() as $key => $item)
			{
				if ($key == "array")
				{
					$value[(string)$item->arr_key] = $this->ff_settings_process_value($item->arr_value);
				}
				elseif ($key == "pair")
				{
					$value[] = array($this->ff_settings_process_value($item->value[0]), $this->ff_settings_process_value($item->value[1]));
				}
				elseif ($key == "value")
				{
					$value[] = $this->ff_settings_process_value($item);
				}
				else
					ffErrorHandler::raise("Wrong ff_settings.xml format", E_USER_ERROR, $this, get_defined_vars());
			}
		}
		else
		{
			$attrs = $element->attributes();

			if (!isset($attrs["value"]))
			{
				$value = (string)$element;
				if (!strlen($value))
					$value		= null;
			}
			else
				$value		= (string)$attrs["value"];

			$type = (string)$attrs["type"];

			if (!isset($attrs["data_type"]))
				$data_type	= "Text";
			else
				$data_type	= (string)$attrs["data_type"];
				
			if (!isset($attrs["locale"]))
				$locale		= FF_SYSTEM_LOCALE;
			elseif ((string)$attrs["locale"] == "FF_LOCALE")
				$locale		= FF_LOCALE;
			else
				$locale		= (string)$attrs["locale"];

			switch ($data_type)
			{
				case "Boolean":
					if ($value == "true")
						$value = true;
					else
						$value = false;
					break;

				case "Number":
					$value = (double)$value;
					break;

				default:
					$value = str_replace("[FF_SITE_PATH]", FF_SITE_PATH, $value);
					$value = str_replace("[FF_DISK_PATH]", FF_DISK_PATH, $value);
					break;
			}

			if ($type == "ffData")
				$value = new ffData($value, $data_type, $locale);
		}
		return $value;
	}

	/*
	function getLayoutByPath($layout_path)
	{
		if (CM_ENABLE_MEM_CACHING && CM_ENABLE_PATH_CACHE)
		{
            $layout_vars = $this->cache->get($layout_path, "/cm/layout");
			if ($layout_vars)
				return $layout_vars;
		}

        $db = ffDB_Sql::factory();
		
		$layout_vars = array();
		$layout_vars["main_theme"] = null;
		$layout_vars["theme"] = null;
		$layout_vars["page"] = null;
		$layout_vars["layer"] = null;
		$layout_vars["title"] = null;
		$layout_vars["class_body"] = null;
		$layout_vars["sect"] = array();
		$layout_vars["css"] = array();
		$layout_vars["js"] = array();
		$layout_vars["meta"] = array();
        $layout_vars["cdn"] = array();
		$layout_vars["ignore_defaults"] = false;
		$layout_vars["ignore_defaults_main"] = false;
		$layout_vars["exclude_ff_js"] = null;
		$layout_vars["exclude_form"] = null;
		$layout_vars["enable_gzip"] = false;
		$layout_vars["compact_js"] = false;
		$layout_vars["compact_css"] = false;
		
		$tmp = $layout_path;
		$paths = "";
		$i = 0;
		do
		{
			if (substr($tmp, -1) !== "/" && !($i == 1 && substr($layout_path, -1) === "/")) // this add a directory variant before. This means that /restricted == /restricted/
			{
				if (strlen($paths))
					$paths .= " OR ";
				$paths .= " `path` = " . $db->toSql($tmp . "/");
			}

			if (strlen($paths))
				$paths .= " OR ";

			$paths .= "`path` = " . $db->toSql($tmp);
			$i++;
		} while($tmp != "/" && $tmp = ffCommon_dirname($tmp));

		if(0 && CM_MULTIDOMAIN_ROUTING)
        {
			$find_hosts = array();
			$host_parts = array_reverse(explode(".", $_SERVER["HTTP_HOST"]));
			$last_host = "";
			foreach ($host_parts as $key => $value)
			{
				if (strlen($last_host))
					$last_host = "." . $last_host;
				$last_host = $value . $last_host;
				$find_hosts[] = str_replace('\\', '\\\\', preg_quote($last_host));
				$find_hosts[] = str_replace('\\', '\\\\', preg_quote("*." . $last_host));
			}
			$search_host = implode("|", $find_hosts);

			$sSQL = "SELECT
							`tbl_src`.*
						FROM
							(
								SELECT
									`" . CM_TABLE_PREFIX . "layout`.*
									, IF(`" . CM_TABLE_PREFIX . "layout`.`domains` = ''
										, 0
										, 1
									) AS `sort_domains`
								FROM
									`" . CM_TABLE_PREFIX . "layout`
								WHERE 1
									" . (strlen($paths)
										? " AND (" . $paths . ") " 
										: ""
									) . "
									AND (`" . CM_TABLE_PREFIX . "layout`.`domains` = ''
										OR CONCAT(',', `" . CM_TABLE_PREFIX . "layout`.`domains`, ',') REGEXP ',(" . $search_host . "),'
									)
								ORDER BY
									`sort_domains` DESC, `path` ASC
							) AS `tbl_src`
						GROUP BY 
							`path`
						ORDER BY
							`tbl_src`.`path` ASC
					";
	//									OR FIND_IN_SET(" . $db->toSql($_SERVER["HTTP_HOST"]) . ", `" . CM_TABLE_PREFIX . "layout`.`domains`)
        } 
		else 
		{
            $sSQL = "SELECT
                        " . CM_TABLE_PREFIX . "layout.*
                    FROM
                        " . CM_TABLE_PREFIX . "layout
                    WHERE 1
                        " . (strlen($paths)
                            ? " AND (" . $paths . ") " 
                            : ""
                        ) . "
                    ORDER BY path ASC";
        }

		$db->query($sSQL);
		if ($db->nextRecord())
		{
            $db2 = ffDB_Sql::factory();
			do
			{
				if($db->getField("path", "Text", true) == $layout_path || $db->getField("path", "Text", true) == str_replace("/index", "/", $layout_path))
					$bMatchPath = true;
				else 
					$bMatchPath = false;

				if(!$db->getField("enable_cascading", "Text", true) && !$bMatchPath)
					continue;
				
				if ($db->getField("reset_cascading", "Text", true))
				{
					$layout_vars = array();
					$layout_vars["main_theme"] = null;
					$layout_vars["theme"] = null;
					$layout_vars["page"] = null;
					$layout_vars["layer"] = null;
					$layout_vars["title"] = null;
					$layout_vars["class_body"] = null;
					$layout_vars["sect"] = array();
					$layout_vars["sect_theme"] = array();
					$layout_vars["css"] = array();
					$layout_vars["js"] = array();
					$layout_vars["meta"] = array();
                    $layout_vars["cdn"] = array();
					$layout_vars["ignore_defaults"] = false;
					$layout_vars["ignore_defaults_main"] = false;
					$layout_vars["exclude_ff_js"] = null;
					$layout_vars["exclude_form"] = null;
					$layout_vars["enable_gzip"] = false;
					$layout_vars["compact_js"] = false;
					$layout_vars["compact_css"] = false;
				}

				if($db->getField("ignore_defaults", "Number", true, false))
					$layout_vars["ignore_defaults"] = true;

				if($db->getField("ignore_defaults_main", "Number", true, false))
					$layout_vars["ignore_defaults_main"] = true;

				if(strlen($db->getField("exclude_ff_js", "Number", true, false)))
					$layout_vars["exclude_ff_js"] = $db->getField("exclude_ff_js", "Number", true);

				if(strlen($db->getField("exclude_form", "Number", true, false)))
					$layout_vars["exclude_form"] = $db->getField("exclude_form", "Number", true);

				if(strlen($db->getField("enable_gzip", "Number", true, false)))
					$layout_vars["enable_gzip"] = $db->getField("enable_gzip", "Number", true);

				if(strlen($db->getField("compact_js", "Number", true, false)))
					$layout_vars["compact_js"] = $db->getField("compact_js", "Number", true);

				if(strlen($db->getField("compact_css", "Number", true, false)))
					$layout_vars["compact_css"] = $db->getField("compact_css", "Number", true);

				if (strlen($db->getField("main_theme", "Text", true)))
					$layout_vars["main_theme"] = $db->getField("main_theme", "Text", true);

				if (strlen($db->getField("theme", "Text", true)))
					$layout_vars["theme"] = $db->getField("theme", "Text", true);

				if (strlen($db->getField("page", "Text", true)))
					$layout_vars["page"] = $db->getField("page", "Text", true);

				if (strlen($db->getField("layer", "Text", true)))
					$layout_vars["layer"] = $db->getField("layer", "Text", true);

				if (strlen($db->getField("title", "Text", true)))
					$layout_vars["title"] = $db->getField("title", "Text", true);

				if (strlen($db->getField("class_body", "Text", true)))
					$layout_vars["class_body"] = $db->getField("class_body", "Text", true);

				$sSQL = "SELECT * FROM " . CM_TABLE_PREFIX . "layout_sect WHERE ID_layout = " . $db2->toSql($db->getField("ID")) . " ORDER BY ID";
				
				$db2->query($sSQL);
				if ($db2->nextRecord())
				{
					do
					{
						if(!$db2->getField("cascading", "Text", true) && !$bMatchPath)
							continue;

						$layout_vars["sect"][$db2->getField("name", "Text", true)] = $db2->getField("value", "Text", true);
						$layout_vars["sect_theme"][$db2->getField("name", "Text", true)] = $db2->getField("theme_include", "Text", true);
					} while ($db2->nextRecord());
				}

				$sSQL = "SELECT * FROM " . CM_TABLE_PREFIX . "layout_css WHERE ID_layout = " . $db2->toSql($db->getField("ID")) . " ORDER BY `priority`, `order`, `ID`";
				$db2->query($sSQL);
				if ($db2->nextRecord())
				{
					do
					{
						if(!$db2->getField("cascading", "Text", true) && !$bMatchPath)
							continue;

						if (!$db2->getField("priority", "Number", true))
							$priority = cm::LAYOUT_PRIORITY_DEFAULT;
						else
							$priority = $db2->getField("priority", "Number", true);

						$layout_vars["css"][$db2->getField("name", "Text", true)] = array(
							"path" => ($db2->getField("path", "Text", true) ? $db2->getField("path", "Text", true) : null)
							, "file" => $db2->getField("file", "Text", true)
							, "theme" =>  $db2->getField("theme_include", "Text", true)
							, "exclude_compact" =>  $db2->getField("exclude_compact", "Text", true)
							, "priority" => $priority
							, "index" => ($db2->getField("index", "Number", true) ? $db2->getField("index", "Number", true) : $db2->getField("order", "Number", true) * -1)
						);
					} while ($db2->nextRecord());
				}

				$sSQL = "SELECT * FROM " . CM_TABLE_PREFIX . "layout_js WHERE ID_layout = " . $db2->toSql($db->getField("ID", "Number")) . " ORDER BY ID";
				$db2->query($sSQL);
				if ($db2->nextRecord())
				{
					do
					{
						if(!$db2->getField("cascading", "Text", true) && !$bMatchPath)
							continue;

						if (!$db2->getField("priority", "Number", true))
							$priority = cm::LAYOUT_PRIORITY_DEFAULT;
						else
							$priority = $db2->getField("priority", "Number", true);
						
						if(strlen($db2->getField("plugin_path", "Text", true)))
						{
							if(file_exists(ff_getThemeDir($layout_vars["theme"]) . $db2->getField("plugin_path", "Text", true)))
							{
								$layout_vars["js"][$db2->getField("name", "Text", true)] = array(
									"path" => ffCommon_dirname($db2->getField("plugin_path", "Text", true))
									, "file" => basename($db2->getField("plugin_path", "Text", true))
									, "exclude_compact" => $db2->getField("exclude_compact", "Text", true)
									, "priority" => $priority
									, "index" => ($db2->getField("index", "Number", true) ? $db2->getField("index", "Number", true) : $db2->getField("order", "Number", true) * -1)
								);
							}
							if(strlen($db2->getField("js_path", "Text", true)))
							{ 
								$layout_vars["js"][$db2->getField("name", "Text", true)] = array(
									"path" => "/themes/" . $layout_vars["theme"] . "/javascript" . ffCommon_dirname($db2->getField("js_path", "Text", true))
									, "file" => basename($db2->getField("js_path", "Text", true))
									, "exclude_compact" => $db2->getField("exclude_compact", "Text", true)
									, "priority" => $priority
									, "index" => ($db2->getField("index", "Number", true) ? $db2->getField("index", "Number", true) : $db2->getField("order", "Number", true) * -1)
								);
							}
							else
							{
                                if(file_exists(ff_getThemeDir($layout_vars["theme"]) . "/themes/" . $layout_vars["theme"] . "/javascript/" . basename(ffCommon_dirname($db2->getField("plugin_path", "Text", true))) . ".observe.js"))
                                {
                                    $layout_vars["js"][$db2->getField("name", "Text", true) . ".observe"] = array(
										"path" => "/themes/" . $layout_vars["theme"] . "/javascript"
										, "file" => basename(ffCommon_dirname($db2->getField("plugin_path", "Text", true))) . ".observe.js"
										, "exclude_compact" => $db2->getField("exclude_compact", "Text", true)
										, "priority" => $priority
										, "index" => ($db2->getField("index", "Number", true) ? $db2->getField("index", "Number", true) : $db2->getField("order", "Number", true) * -1)
									);
                                } 
                                elseif(file_exists(ff_getThemeDir($layout_vars["theme"]) . ffCommon_dirname($db2->getField("plugin_path", "Text", true)) . "/" . basename(ffCommon_dirname($db2->getField("plugin_path", "Text", true))) . ".observe.js"))
								{
									$layout_vars["js"][$db2->getField("name", "Text", true) . ".observe"] = array(
										"path" => ffCommon_dirname($db2->getField("plugin_path", "Text", true))
										, "file" => basename(ffCommon_dirname($db2->getField("plugin_path", "Text", true))) . ".observe.js"
										, "exclude_compact" => $db2->getField("exclude_compact", "Text", true)
										, "priority" => $priority
										, "index" => ($db2->getField("index", "Number", true) ? $db2->getField("index", "Number", true) : $db2->getField("order", "Number", true) * -1)
									);
								}
							}
						}
						elseif (strlen($db2->getField("js_path", "Text", true)))
						{
							$layout_vars["js"][$db2->getField("name", "Text", true)] = array(
								"path" => "/themes/" . $layout_vars["theme"] . "/javascript" . ffCommon_dirname($db2->getField("js_path", "Text", true))
								, "file" => basename($db2->getField("js_path", "Text", true))
								, "theme" => $db2->getField("theme_include", "Text", true)
								, "exclude_compact" => $db2->getField("exclude_compact", "Text", true)
								, "priority" => $priority
								, "index" => ($db2->getField("index", "Number", true) ? $db2->getField("index", "Number", true) : $db2->getField("order", "Number", true) * -1)
							);
						}
						else
						{
							$layout_vars["js"][$db2->getField("name", "Text", true)] = array(
								"path" => ($db2->getField("path", "Text", true) ? $db2->getField("path", "Text", true) : null)
								, "file"	=> ($db2->getField("file", "Text", true) ? $db2->getField("file", "Text", true) : null)
								, "theme" => $db2->getField("theme_include", "Text", true)
								, "exclude_compact" => $db2->getField("exclude_compact", "Text", true)
								, "priority" => $priority
								, "index" => ($db2->getField("index", "Number", true) ? $db2->getField("index", "Number", true) : $db2->getField("order", "Number", true) * -1)
							);
						}
					} while ($db2->nextRecord());
				}

				$sSQL = "SELECT * FROM " . CM_TABLE_PREFIX . "layout_meta WHERE ID_layout = " . $db2->toSql($db->getField("ID")) . " ORDER BY ID";
				$db2->query($sSQL);
				if ($db2->nextRecord())
				{
					do
					{
						if(!$db2->getField("cascading", "Text", true) && !$bMatchPath)
							continue;

						$layout_vars["meta"][$db2->getField("name", "Text", true)]["type"] = (strlen($db2->getField("type", "Text", true))
																								? $db2->getField("type", "Text", true)
																								: "name"
																							);
						$layout_vars["meta"][$db2->getField("name", "Text", true)]["content"] = $db2->getField("content", "Text", true);
					} while ($db2->nextRecord());
				}

                $sSQL = "SELECT * FROM " . CM_TABLE_PREFIX . "layout_cdn WHERE ID_layout = " . $db2->toSql($db->getField("ID")) . " ORDER BY ID";
                $db2->query($sSQL);
                if ($db2->nextRecord())
                {
                    do
                    {
                        if(!$db2->getField("status", "Text", true) && !$bMatchPath)
                            continue;

                        $layout_vars["cdn"][$db2->getField("type", "Text", true)][$db2->getField("name", "Text", true)] = $db2->getField("url", "Text", true);
                    } while ($db2->nextRecord());
                }
            } while($db->nextRecord());
		}

		if (CM_ENABLE_MEM_CACHING && CM_ENABLE_PATH_CACHE)
		    $this->cache->set($layout_path, $layout_vars, "/cm/layout");

		return $layout_vars;
	}*/

	function isXHR()
	{
		if ($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest")
			return true;
		else
			return false;
	}
	
	static function getJSONP()
	{
		if (isset($_REQUEST["XHR_JSONP"]))
			return $_REQUEST["XHR_JSONP"];
		else
			return false;
	}
	
	function jsonAddResponse($data)
	{
		return $this->json_response = array_replace_recursive($this->json_response, $data);
		
	}
	
	static function jsonParse($arData, $out = true, $add_newline = false, $standard_encode = false, $standard_opts = 0, $skip_event = false)
	{
		if (!$skip_event)
			cm::_doEvent("jsonParse", array(&$arData, &$out, &$add_newline, &$standard_encode, &$standard_opts));
		
		if ($jsonp = cm::getJSONP())
		{
			$jsonp_pre = $jsonp . "(";
			$jsonp_post = ")";
			
			if ($out)
				header("Content-type: application/javascript; charset=utf-8");
		}
		elseif ($out)
				header("Content-type: application/json; charset=utf-8");
		
		if ($standard_encode)
		{
			if ($out)
				echo $jsonp_pre . json_encode($arData, $standard_opts) . $jsonp_post;
			else
				return $jsonp_pre . json_encode($arData, $standard_opts) . $jsonp_post;
		}
		else
		{
			if ($out)
				echo $jsonp_pre . ffCommon_jsonenc($arData, false, $add_newline) . $jsonp_post;
			else
				return $jsonp_pre . ffCommon_jsonenc($arData, false, $add_newline) . $jsonp_post;
		}		
	}
	
	function getBrowser()
	{
	    $u_agent = $_SERVER['HTTP_USER_AGENT'];
	    $bname = 'Unknown';
	    $platform = 'Unknown';
	    $version= "";

	    //First get the platform?
	    if (preg_match('/linux/i', $u_agent)) {
	        $platform = 'linux';
	    }
	    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
	        $platform = 'mac';
	    }
	    elseif (preg_match('/windows|win32/i', $u_agent)) {
	        $platform = 'windows';
	    }
	   
	    // Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/iPad/i',$u_agent))
	    {
	        $bname = 'Ipad';
	        $ub = "Ipad";
	    }
		elseif(preg_match('/iPhone/i',$u_agent))
	    {
	        $bname = 'iPhone';
	        $ub = "iPhone";
	    }
		elseif(preg_match('/iPod/i',$u_agent))
	    {
	        $bname = 'Ipod';
	        $ub = "Ipod";
	    }
	    elseif(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
	    {
	        $bname = 'Internet Explorer';
	        $ub = "MSIE";
	    }
	    elseif(preg_match('/Firefox/i',$u_agent))
	    {
	        $bname = 'Mozilla Firefox';
	        $ub = "Firefox";
	    }
	    elseif(preg_match('/Chrome/i',$u_agent))
	    {
	        $bname = 'Google Chrome';
	        $ub = "Chrome";
	    }
	    elseif(preg_match('/Safari/i',$u_agent))
	    {
	        $bname = 'Apple Safari';
	        $ub = "Safari";
	    }
	    elseif(preg_match('/Opera/i',$u_agent))
	    {
	        $bname = 'Opera';
	        $ub = "Opera";
	    }
	    elseif(preg_match('/Netscape/i',$u_agent))
	    {
	        $bname = 'Netscape';
	        $ub = "Netscape";
	    }

	    
	    // finally get the correct version number
	    $known = array('Version', $ub, 'other');
	    $pattern = '#(?<browser>' . join('|', $known) .
	    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	    if (!preg_match_all($pattern, $u_agent, $matches)) {
	        // we have no matching number just continue
	    }
	   
	    // see how many we have
	    $i = count($matches['browser']);
	    if ($i != 1) {
	        //we will have two since we are not using 'other' argument yet
	        //see if version is before or after the name
	        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
	            $version= $matches['version'][0];
	        }
	        else {
	            $version= $matches['version'][1];
	        }
	    }
	    else {
	        $version= $matches['version'][0];
	    }
	   
	    // check if we have a number
	    if ($version==null || $version=="") {$version="?";}
	   
	    return array(
	        'userAgent' 	=> $u_agent
	        , 'extendname'  => $bname
	        , 'name'		=> $ub
	        , 'majorver'   	=> (strpos($version, ".") === false ? $version : substr($version, 0, strpos($version, ".")))
	        , 'lowerver'   	=> (strpos($version, ".") === false ? $version : substr($version, strpos($version, ".") + 1))
	        , 'platform'  	=> $platform
	        , 'pattern'    	=> $pattern
	    );
	}
	
	function responseCode($code, $mute = false)
	{
		//ffErrorHandler::raise("DEBUG", E_USER_ERROR, $this, get_defined_vars());
		$res = $this->doEvent("on_responseCode", array($this, $code));
		$rc = end($res);
		if ($rc === null)
		{
			$tpl = null;
			
			if (!$mute)
			{
				if (is_file(__PRJ_DIR__ . "/conf/cm/extras/" . $code . ".html"))
					$tpl = ffTemplate::factory(__PRJ_DIR__ . "/conf/cm/extras");
				else if (is_file(__TOP_DIR__ . "/cm/extras/" . $code . ".html"))
					$tpl = ffTemplate::factory(__TOP_DIR__ . "/cm/extras");

				if ($tpl !== null)
				{
					$tpl->load_file($code . ".html", "main");
					$tpl->pparse("main", false);
				}
			}
			http_response_code($code);
			exit;
		}
	}

    function get_locale($lang_default = FF_LOCALE, $nocurrent = false) { //cache, security
        $db = ffDB_Sql::factory();

        $locale = array();
        $locale["lang"] = array();

        $sSQL = "SELECT " . FF_PREFIX . "languages.* 
			FROM " . FF_PREFIX . "languages 
			WHERE " . FF_PREFIX . "languages.status > 0
			ORDER BY " . FF_PREFIX . "languages.description";
        $db->query($sSQL);
        if($db->nextRecord())
        {
            $arrLangKey = array();
            if($lang_default === null)
                $lang_default = $db->getField("code", "Text", true);

            do
            {
                $ID_lang = $db->getField("ID", "Number", true);
                $lang_code = $db->getField("code", "Text", true);

                $locale["lang"][$lang_code]["ID"] 										= $ID_lang;
                $locale["lang"][$lang_code]["tiny_code"] 								= $db->getField("tiny_code", "Text", true);
                $locale["lang"][$lang_code]["description"] 								= $db->getField("description", "Text", true);
                $locale["lang"][$lang_code]["stopwords"] 								= $db->getField("stopwords", "Text", true);
                $locale["lang"][$lang_code]["prefix"] 									= ($lang_code == $lang_default
                    ? ""
                    : "/" . $locale["lang"][$lang_code]["tiny_code"]
                );

                $locale["rev"]["lang"][$locale["lang"][$lang_code]["tiny_code"]] 		= $lang_code;

                if(!$nocurrent && $locale["ID_languages"] == $ID_lang)
                {
                    $locale["lang"]["current"] 											= $locale["lang"][$lang_code];
                    $locale["lang"]["current"]["code"] 									= $lang_code;
                }
                $arrLangKey[$ID_lang] 													= $lang_code;
            } while($db->nextRecord());

            if(0 && count($arrLangKey)) {
                $locale["rev"]["key"] 													= $arrLangKey;

                $sSQL = "SELECT " . FF_SUPPORT_PREFIX . "state.*
						, ip2nationCountries.country 		AS country
						, ip2nationCountries.iso_country 	AS country_iso
						, ip2nationCountries.code 			AS country_code
					FROM " . FF_SUPPORT_PREFIX . "state
						INNER JOIN ip2nationCountries ON ip2nationCountries.iso_country = " . FF_SUPPORT_PREFIX . "state.name 
					WHERE " . FF_SUPPORT_PREFIX . "state.ID_lang IN(" . $db->toSql(implode(",", array_keys($arrLangKey)), "Number") . ")";
                $db->query($sSQL);
                if($db->nextRecord()) {
                    do {
                        $country_code = $db->getField("country_code", "Text", true);

                        $locale["country"][$country_code]["ID"]													= $db->getField("ID", "Number", true);
                        $locale["country"][$country_code]["name"]												= $db->getField("country", "Text", true);
                        $locale["country"][$country_code]["iso"]												= $db->getField("country_iso", "Text", true);
                        $locale["country"][$country_code]["ID_lang"]											= $db->getField("ID_lang", "Number", true);

                        $locale["rev"]["country"][$country_code] 												= $arrLangKey[$locale["country"][$country_code]["ID_lang"]];
                        $locale["lang"][$arrLangKey[$locale["country"][$country_code]["ID_lang"]]]["country"] 	= $country_code;

                    } while($db->nextRecord());
                }
            }
        }

        if(0 && !$nocurrent) { //todo: da sistemare
            $sSQL = "SELECT ip2nation.country AS country_code
				FROM ip2nation
				WHERE ip2nation.ip < INET_ATON(" . $db->toSql($_SERVER["REMOTE_ADDR"]) . ")
				ORDER BY ip2nation.ip DESC
				LIMIT 0, 1";
            $db->query($sSQL);
            if($db->nextRecord())
            {
                $country_code = $db->getField("country_code", "Text", true);

                $locale["country"]["current"]												= $locale["country"][$country_code];
                $locale["country"]["current"]["code"]										= $country_code;

                if(isset($arrLangKey[$locale["country"]["current"]["ID_lang"]])) {
                    $locale["lang"]["current"] 												= $locale["lang"][$arrLangKey[$locale["country"]["current"]["ID_lang"]]];
                    $locale["lang"]["current"]["code"] 										= $arrLangKey[$locale["country"]["current"]["ID_lang"]];
                }
            }

            if(!array_key_exists("current", $locale["lang"]) && strlen($lang_default))
            {
                $locale["lang"]["current"] 													= $locale["lang"][$lang_default];
                $locale["lang"]["current"]["code"] 											= $lang_default;
            }
        }
        return $locale;
    }

	static public function _layoutOrderElements(&$elements, $priority = null)
	{
		if ($priority)
		{
			if (!isset($elements[$priority]))
				return;

			usort($elements[$priority], "ffCommon_IndexOrder");
			$elements[$priority] = array_reverse($elements[$priority]);
		}
		else
		{
			ksort($elements);
		
			for($i = CM::LAYOUT_PRIORITY_TOPLEVEL; $i <= CM::LAYOUT_PRIORITY_FINAL; $i++)
			{
				if (!isset($elements[$i]))
					continue;

				uasort($elements[$i], "ffCommon_IndexOrder");
				$elements[$i] = array_reverse($elements[$i]);
			}
		}
	}
}
