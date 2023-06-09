<?php
// ----------------------------------------
//  		FRAMEWORK FORMS vAlpha
//		      PLUGIN DEFINITION (progressbar)
//			   by Samuele Diella
// ----------------------------------------

class ffWidget_progressbar extends ffCommon
{

	// ---------------------------------------------------------------
	//  PRIVATE VARS (used by code, don't touch or may be explode! :-)

	var $template_file 	 = "ffWidget.html";
	
	var $class			= "ffWidget_progressbar";
	
	var $widget_deps	= array();
	
	var $libraries		= array();
	
    var $js_deps		= array(
							"jquery-ui" 		=> null
						);		
    var $css_deps 		= array();
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

	function process($id, &$value, ffField_html &$Field)
	{
        $oPage = ffPage::getInstance();

		if ($Field->parent !== null && strlen($Field->parent[0]->getIDIF()))
		{
			$tpl_id = $Field->parent[0]->getIDIF();
			$prefix = $tpl_id . "_";
			if (!isset($this->tpl[$tpl_id]))
				$this->prepare_template($tpl_id);
			$this->tpl[$tpl_id]->set_var("component", $tpl_id);
			$this->tpl[$tpl_id]->set_var("container", $prefix);
			//$Field->parent[0]->processed_widgets[$prefix . $id] = "progressbar";
		}
		else
		{
			$tpl_id = "main";
			if (!isset($this->tpl[$tpl_id]))
				$this->prepare_template($tpl_id);
		}

        $oPage->tplAddCss("jquery-ui.progressbar");

		$this->tpl[$tpl_id]->set_var("id", $id);

		if ($Field->contain_error && $Field->error_preserve)
			$this->tpl[$tpl_id]->set_var("value", intval($value->ori_value));
		else
			$this->tpl[$tpl_id]->set_var("value", intval($value->getValue()));
		$this->tpl[$tpl_id]->set_var("properties", $Field->getProperties());
		
		if (strlen($Field->class))
			$this->tpl[$tpl_id]->set_var("class", $Field->class);
		else
			$this->tpl[$tpl_id]->set_var("class", $this->class);		
			
		$this->tpl[$tpl_id]->parse("SectBinding", true);
		return $Field->fixed_pre_content . $this->tpl[$tpl_id]->rpparse("SectControl", FALSE) . $Field->fixed_post_content;
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
