<?php
// ----------------------------------------
//  		FRAMEWORK FORMS vAlpha
//		      PLUGIN DEFINITION (datepicker)
//			   by Samuele Diella
// ----------------------------------------

class ffWidget_datepicker extends ffCommon
{

	// ---------------------------------------------------------------
	//  PRIVATE VARS (used by code, don't touch or may be explode! :-)

	var $template_file 	 = "ffWidget.html";
	
	var $class			= "ffWidget_datepicker";

	var $widget_deps	= array();
	
	var $libraries		= array();
	
    var $js_deps = array(
    						"jquery-ui" 			=> null,
							"jquery-ui.timepicker" 	=> null
						);
	
    var $css_deps 		= array(
							"jquery-ui.datepicker" 	=> null
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
			//$Field->parent[0]->processed_widgets[$prefix . $id] = "datepicker";
		}
		else
		{
			$tpl_id = "main";
			if (!isset($this->tpl[$tpl_id]))
				$this->prepare_template($tpl_id);
		}

		$this->tpl[$tpl_id]->set_var("id", $id);
		
		$lang = ($Field->datepicker_lang ? $Field->datepicker_lang : strtolower(substr(FF_LOCALE, 0, -1)));
		
		$oPage->tplAddJs("jquery-ui.datepicker-lang-" . $lang, array(
			"path" => "/themes/library/jquery-ui"
			, "file" => "i18n/jquery.ui.datepicker-" . $lang . ".js"
			, "index" => 200
		));
		
		$this->tpl[$tpl_id]->set_var("lang", strtolower(substr(FF_LOCALE, 0, -1)));
		
		if ($Field->contain_error && $Field->error_preserve) {
			$this->tpl[$tpl_id]->set_var("value", ffCommon_specialchars($value->ori_value));
		} else {
			if($Field->base_type == "Timestamp" && $value->getValue("Timestamp") <= 0) {
				$this->tpl[$tpl_id]->set_var("value", "");
			} else {
				$this->tpl[$tpl_id]->set_var("value", ffCommon_specialchars($value->getValue($Field->get_app_type(), $Field->get_locale())));
			}
		}
		$this->tpl[$tpl_id]->set_var("properties", $Field->getProperties());
		
		if (strlen($Field->class))
			$this->tpl[$tpl_id]->set_var("class", $Field->class);
		else
			$this->tpl[$tpl_id]->set_var("class", $this->class);

        if($Field->min_year)
            $this->tpl[$tpl_id]->set_var("min_year", $Field->min_year);
        else
            $this->tpl[$tpl_id]->set_var("min_year", "10");

        if($Field->max_year)
            $this->tpl[$tpl_id]->set_var("max_year", $Field->max_year);
        else
            $this->tpl[$tpl_id]->set_var("max_year", "2");
		
		if ($Field->datepicker_showbutton)
        {
	        $Field->framework_css["fixed_post_content"] = array(2);         
	        $Field->fixed_post_content = '<a href="javascript:void(0);" onclick="jQuery.fn.escapeGet(\'' . $Field->parent[0]->id . "_" . $id . '\').datepicker(\'show\');" class="' . $oPage->frameworkCSS->get("calendar", "icon") . '"></a>';
	        /*messo nel css */ //$Field->properties["style"] = "position: relative; z-index: 100000;"; //workground per far funzionare il datepicker dentro le dialog modali
        }
		
		if ($Field->datepicker_weekselector)
			$this->tpl[$tpl_id]->parse("SectWeek", false);
		else
			$this->tpl[$tpl_id]->set_var("SectWeek", "");		
		
		if ($Field->get_app_type() == "DateTime" || $Field->datepicker_force_datetime)
		{
            $this->tpl[$tpl_id]->parse("SectDateTime", false);
			$this->tpl[$tpl_id]->set_var("SectDate", "");
		}
		else
		{
			$this->tpl[$tpl_id]->set_var("SectDateTime", "");
			$this->tpl[$tpl_id]->parse("SectDate", false);
		}
		
		$this->tpl[$tpl_id]->parse("SectBinding", true);
        return;
		//return $Field->fixed_pre_content . $this->tpl[$tpl_id]->rpparse("SectControl", FALSE) . $Field->fixed_post_content;
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
