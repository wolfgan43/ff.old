<?php
// ----------------------------------------
//  		FRAMEWORK FORMS vAlpha
//		      PLUGIN DEFINITION (timepicker)
//			   by Samuele Diella
// ----------------------------------------

class ffWidget_timepicker extends ffCommon
{

	// ---------------------------------------------------------------
	//  PRIVATE VARS (used by code, don't touch or may be explode! :-)
	var $template_file 	 = "ffWidget.html";
	
	var $class			= "ffWidget_timepicker";

	var $widget_deps	= array();

	var $libraries		= array();
	
    var $js_deps = array(
		"ff.ffField.timepicker" => null
	);
	
    var $css_deps = array(
	);

	// PRIVATE VARS

    /**
     * @var $tpl ffTemplate[]
     */
    private $tpl 			= null;
	
	
	function __construct(ffPage_base $oPage = null)
	{
		$this->get_defaults();
	}

	function prepare_template($id)
	{
		$this->tpl[$id] = ffTemplate::factory(__DIR__);
		$this->tpl[$id]->load_file($this->template_file, "main");
	}
	
	function process($id, &$value, ffField_base &$Field)
	{

		// THE REAL STUFF
		if ($Field->parent !== null && strlen($Field->parent[0]->getIDIF()))
		{
			$tpl_id = $Field->parent[0]->getIDIF();
			$prefix = $tpl_id . "_";
			if (!isset($this->tpl[$tpl_id]))
				$this->prepare_template($tpl_id);
			$this->tpl[$tpl_id]->set_var("component", $tpl_id);
			$this->tpl[$tpl_id]->set_var("container", $prefix);
			//$Field->parent[0]->processed_widgets[$prefix . $id] = "timepicker";
		}
		else
		{
			$tpl_id = "main";
			if (!isset($this->tpl[$tpl_id]))
				$this->prepare_template($tpl_id);
		}
			
		$this->tpl[$tpl_id]->set_var("id", $id);
		$this->tpl[$tpl_id]->set_var("class", $this->class);
		$this->tpl[$tpl_id]->set_var("properties", $Field->getProperties());

		$hour = 0;
		$minute = 0;
		$text_value = preg_replace("/[^0-9\:]+/", "", $value->getValue());

		$timeparts = explode(":", $text_value);
		if (count($timeparts) > 0)
		{
			$hour = intval($timeparts[0]);
			$minute = intval($timeparts[1]);
			$second = intval($timeparts[2]); // non gestito
		}

		$this->tpl[$tpl_id]->set_var("sel_hour", $hour);
		$this->tpl[$tpl_id]->set_var("sel_minute", $minute);

		if ($Field->contain_error && $Field->error_preserve)
			$this->tpl[$tpl_id]->set_var("value", ffCommon_specialchars($value->ori_value));
		else
			$this->tpl[$tpl_id]->set_var("value", $hour . ":" . $minute);

		$this->tpl[$tpl_id]->parse("SectBinding", true);
		return $this->tpl[$tpl_id]->rpparse("SectControl", false);
	}
	
	function get_component_headers($id)
	{
		if (!isset($this->tpl[$id]))
			return;

		return $this->tpl[$id]->rpparse("SectHeaders", false);
	}
	
	function get_component_footers($id)
	{
		if (!isset($this->tpl[$id]))
			return;

		return $this->tpl[$id]->rpparse("SectFooters", false);
	}
	
	function process_headers()
	{
		if (!isset($this->tpl["main"]))
			return;

		return $this->tpl["main"]->rpparse("SectHeaders", false);
	}
	
	function process_footers()
	{
		if (!isset($this->tpl["main"]))
			return;

		return $this->tpl["main"]->rpparse("SectFooters", false);
	}
}
