<?php
/**
 * framework main inclusion file
 * 
 * @package FormsFramework
 * @subpackage common
 * @author Samuele Diella <samuele.diella@gmail.com>
 * @copyright Copyright (c) 2004-2017, Samuele Diella
 * @license https://opensource.org/licenses/LGPL-3.0
 * @link http://www.formsphpframework.com
 */

// init framework..
if (!defined("FF_MAIN_INIT"))
{
	if(version_compare(phpversion(), "5.4", "<"))
		die("Forms PHP Framework, Critical Error: PHP Version >= 5.4 required, " . phpversion() . " detected.");

	/**
	* get parent'dir, no matter if windows or linux
	* @param type $path
	* @return string 
	*/
	function ffCommon_dirname($path) 
	{
		static $windows = null;
		if ($windows === null)
		{
			if(dirname("/") == "\\")
				$windows = true;
			else
				$windows = false;
		}
		
		if (substr($path, -1) === "/")
			$res = substr($path, 0, -1);
		else
			$res = dirname($path);
		
		if($windows)
			$res = str_replace("\\", "/", $res);

		if($res == ".")
			$res = "";

		return $res;
	}
	
	// normalize superglobals (to avoid bugs, server differences and others)
	
	if (isset($_SERVER["HTTP_HOST"]))
	{
		$_SERVER["HTTP_HOST"] = strtolower($_SERVER["HTTP_HOST"]);

		$fftmp_ffq = false;
		if (isset($_SERVER["argv"]))
		{
			foreach($_SERVER["argv"] AS $argv)
			{
				parse_str($argv, $tmp_request);
				if(isset($tmp_request["_ffq_"]))
				{
					$_REQUEST["_ffq_"] = $tmp_request["_ffq_"];
					break;
				}
				unset($tmp_request);
			}
		}
		if (isset($_REQUEST["_ffq_"])) // used to manage .htaccess [QSA] option, this overwhelm other options
		{
			$fftmp_ffq = true;
			$_SERVER["PATH_INFO"] = $_REQUEST["_ffq_"];
			$_SERVER["ORIG_PATH_INFO"] = $_REQUEST["_ffq_"];
		}
		else if (isset($_SERVER["ORIG_PATH_INFO"]))
			$_SERVER["PATH_INFO"] = $_SERVER["ORIG_PATH_INFO"];

		$fftmp_urlparams = false;
		if (defined("FF_URLPARAMS"))
		{
			$fftmp_urlparams = explode(",", FF_URLPARAMS);
			$fftmp_urlparams = array_flip($fftmp_urlparams);
		}

		if (strlen($_SERVER["QUERY_STRING"]))
		{
			$fftmp_new_querystring = "";
			$fftmp_parts = explode("&", rtrim($_SERVER["QUERY_STRING"], "&"));
			foreach ($fftmp_parts as $fftmp_value)
			{
				$fftmp_subparts = explode("=", $fftmp_value);
				$fftmp = strtoupper($fftmp_subparts[0]);
				
				if ($fftmp_urlparams !== false && isset($fftmp_urlparams[$fftmp]))
				{
					define ("FF_URLPARAM_" . trim($fftmp, "_"), true);
					unset($_REQUEST[$fftmp_subparts[0]]);
					unset($_GET[$fftmp_subparts[0]]);
					continue;
				}
				
				if ($fftmp_subparts[0] == "_ffq_")
					continue;
				if (!isset($_REQUEST[$fftmp_subparts[0]]))
					$_REQUEST[$fftmp_subparts[0]] = (count($fftmp_subparts) == 2 ? rawurldecode($fftmp_subparts[1]) : "");
				$fftmp_new_querystring .= $fftmp_subparts[0] . (count($fftmp_subparts) == 2 ? "=" . $fftmp_subparts[1] : "") . "&";
			}
			if ($fftmp_ffq)
			{
				$_SERVER["QUERY_STRING"] = $fftmp_new_querystring;
				unset($_REQUEST["_ffq_"]);
				unset($_GET["_ffq_"]);
			}
			unset($fftmp_new_querystring);
			unset($fftmp_parts);
			unset($fftmp_value);
			unset($fftmp_subparts);
			unset($fftmp);
		}

		// fix request_uri. can't use code above due to multiple redirects (es.: R=401 and ErrorDocument in .htaccess)
		if (strpos($_SERVER["REQUEST_URI"], "?") !== false)
		{
			$fftmp_requri_parts = explode("?", $_SERVER["REQUEST_URI"]);
			if (strlen($fftmp_requri_parts[1]))
			{
				$fftmp_new_querystring = "";
				$fftmp_parts = explode("&", rtrim($fftmp_requri_parts[1], "&"));
				foreach ($fftmp_parts as $fftmp_value)
				{
					$fftmp_subparts = explode("=", $fftmp_value);
					$fftmp = strtoupper($fftmp_subparts[0]);

					if ($fftmp_urlparams !== false && isset($fftmp_urlparams[$fftmp]))
						continue;

					if ($fftmp_subparts[0] == "_ffq_")
						continue;
					$fftmp_new_querystring .= $fftmp_subparts[0] . (count($fftmp_subparts) == 2 ? "=" . $fftmp_subparts[1] : "") . "&";
				}

				$_SERVER["REQUEST_URI"] = $fftmp_requri_parts[0] . ($fftmp_requri_parts[1] !== $fftmp_new_querystring && $fftmp_new_querystring === "" ? "" : "?") . $fftmp_new_querystring;

				unset($fftmp_new_querystring);
				unset($fftmp_parts);
				unset($fftmp_value);
				unset($fftmp_subparts);
				unset($fftmp);
			}
			unset($fftmp_requri_parts);
		}
		
		unset($fftmp_urlparams);
	}
	
	// set default extension for php files
	define("FF_PHP_EXT", "php");

	// some preprocessing for CPU saving
    define("__FF_DIR__", __DIR__);

    define("__TOP_DIR__", (getenv("FF_TOP_DIR") && getenv("FF_TOP_DIR") != "1"
        ? getenv("FF_TOP_DIR")
        : ffCommon_dirname(__FF_DIR__)
    ));

    define("__PRJ_DIR__", (getenv("FF_PROJECT_DIR") && getenv("FF_PROJECT_DIR") != "1"
        ? getenv("FF_PROJECT_DIR")
        : __TOP_DIR__
    ));

	// add ff'dirs to include path
	set_include_path(
			__TOP_DIR__ . PATH_SEPARATOR .
			__TOP_DIR__ . "/library" . PATH_SEPARATOR .
			get_include_path()
		);

	// Common Functions (except for ffCommon_dirname, defined here)
	require(__FF_DIR__ . "/common." . FF_PHP_EXT);

	// load config...

	// ..base (all others depends on this one)
	if (@is_file(__PRJ_DIR__ . "/config." . FF_PHP_EXT))
		require_once __PRJ_DIR__ . "/config." . FF_PHP_EXT;
	else if (@is_file(__FF_DIR__ . "/config." . FF_PHP_EXT))
		require __FF_DIR__ . "/config." . FF_PHP_EXT;
	else
		die("FORMS FRAMEWORK: config." . FF_PHP_EXT . " file not found. Place it under sources or root directory.");

	// now check presence of server redirect to fix something
	if (isset($_SERVER["HTTP_HOST"]))
	{
		if (!$fftmp_ffq && isset($_SERVER["REDIRECT_URL"]))
		{
            if(strpos($_SERVER["REDIRECT_URL"], $_SERVER["SCRIPT_NAME"]) === 0)
				$_SERVER["PATH_INFO"] = substr($_SERVER["REDIRECT_URL"], strlen($_SERVER["SCRIPT_NAME"]));
			else if (FF_SITE_PATH !== "")
				$_SERVER["PATH_INFO"] = substr($_SERVER["REDIRECT_URL"], strlen(FF_SITE_PATH));
			else
				$_SERVER["PATH_INFO"] = $_SERVER["REDIRECT_URL"];
			$_SERVER["ORIG_PATH_INFO"] = $_SERVER["PATH_INFO"];
		}
		unset($fftmp_ffq);
	}
	
	// ..check config
    if(!defined("FF_SYSTEM_LOCALE"))                    define("FF_SYSTEM_LOCALE", "ISO9075"); /* Default Locale */
    if(!defined("FF_DEFAULT_CHARSET"))                  define("FF_DEFAULT_CHARSET", "UTF-8");  /* Charset Default */

    // manage charsets
    if (FF_DEFAULT_CHARSET == "UTF-8")
    {
        mb_regex_encoding("UTF-8");
        mb_internal_encoding("UTF-8");
    }

	/**
	* @ignore
	*/
	if (!defined("FF_ENABLE_MEM_TPL_CACHING"))	          define("FF_ENABLE_MEM_TPL_CACHING", false);
	/**
	* @ignore
	*/
	if (!defined("FF_ENABLE_MEM_PAGE_CACHING"))         define("FF_ENABLE_MEM_PAGE_CACHING", false);
	/**
	* @ignore
	*/
	if (!defined("FF_CACHE_ADAPTER"))                   define("FF_CACHE_ADAPTER", "apc");
	/**
	* @ignore
	*/
	if (!defined("FF_UPDIR"))                           define("FF_UPDIR", "/uploads");
	/**
	* @ignore
	*/
	if (!defined("FF_DB_INTERFACE"))                    define("FF_DB_INTERFACE", "mysql"); // mysqli allowed too
	if (!defined("FF_ORM_ENABLE"))                      define("FF_ORM_ENABLE", true);
	if (!defined("FF_PREFIX"))                          define("FF_PREFIX", "ff_");
	if (!defined("FF_SUPPORT_PREFIX"))                  define("FF_SUPPORT_PREFIX", "support_");

    if (!defined("FF_ERRORS_MAXRECURSION"))             define("FF_ERRORS_MAXRECURSION", NULL);
    if (!defined("FF_URLREWRITE_REMOVEHYPENS"))         define("FF_URLREWRITE_REMOVEHYPENS", false);

	// Error Handling, loaded now cause need configuration
	require(__FF_DIR__ . "/error_handling." . FF_PHP_EXT);

	// Theme Management
	// define base theme(s) location
	if (!defined("FF_THEME_DIR"))			            define ("FF_THEME_DIR", 	"/themes");
	if (!defined("FF_THEME_DISK_PATH")) 	            define ("FF_THEME_DISK_PATH", 	__TOP_DIR__ . FF_THEME_DIR);
	if (!defined("FF_THEME_SITE_PATH")) 	            define ("FF_THEME_SITE_PATH", 	FF_SITE_PATH . FF_THEME_DIR);

	if (defined("FF_DEFAULT_THEME"))
	{
		define("FF_THEME_ONLY_INIT", true);
		ffCommon_theme_init(FF_DEFAULT_THEME);
	}
	
	// Load other configs..

	// ..theme
	/*if (@is_file(FF_THEME_DISK_PATH . "/" . FF_DEFAULT_THEME . "/ff/config.php"))
		require FF_THEME_DISK_PATH . "/" . FF_DEFAULT_THEME . "/ff/config.php";*/

	// ..local
	/*
	$script_path = substr(ffCommon_dirname($_SERVER['SCRIPT_FILENAME']), strlen(FF_DISK_PATH));
	$script_path_parts = explode("/", $script_path);
	$script_path_tmp = FF_DISK_PATH . "/";
	$i = 1;
	while ($i < count($script_path_parts) && $script_path_tmp .= $script_path_parts[$i] . "/")
	{
		if (@is_file($script_path_tmp . "config" . "." . FF_PHP_EXT))
			require($script_path_tmp . "config." . FF_PHP_EXT);
		$i++;
	}
	*/

	// Framework Classes
	ffAutoload();

	define("FF_MAIN_INIT", true);
	if (defined("FF_ONLY_INIT"))
		return;
}

// init done, loading classes

/* CLASS SECTION - Within this section are included all the class that build the framework
NB: sequence of statements is VITAL */

// Common and Abstract Classes
if (!defined("FF_MAIN_BASE"))
{
	if (!defined("FF_CACHE_DEFAULT_TBLREL")) define("FF_CACHE_DEFAULT_TBLREL", false);

	define("FF_MAIN_BASE", true);
	if (defined("FF_MAIN_ONLY_BASE"))
		return;
}

// Load commons..
// ...base
if (@is_file(__PRJ_DIR__ . "/common." . FF_PHP_EXT))
	require __PRJ_DIR__ . "/common." . FF_PHP_EXT;
//elseif (is_file(ffCommon_dirname($_SERVER['SCRIPT_FILENAME']) . "/common." . FF_PHP_EXT))
//	require (ffCommon_dirname($_SERVER['SCRIPT_FILENAME']) . "/common." . FF_PHP_EXT);

// ..theme 
if (defined("FF_DEFAULT_THEME"))
	ffCommon_theme_init(FF_DEFAULT_THEME); // load commons
	
// ...local
/*
$script_path = substr(ffCommon_dirname($_SERVER['SCRIPT_FILENAME']), strlen(FF_DISK_PATH));
$script_path_parts = explode("/", $script_path);
$script_path_tmp = FF_DISK_PATH . "/";
$i = 1;
while ($i < count($script_path_parts) && $script_path_tmp .= $script_path_parts[$i] . "/")
{
	if (@is_file($script_path_tmp . "common" . "." . FF_PHP_EXT))
		require($script_path_tmp . "common." . FF_PHP_EXT);
	$i++;
}
*/
// done!

$ff = ffGlobals::getInstance("ff");
$ff->events = new ffEvents();
$ff->showfiles_events = new ffEvents();
