<?php
frameworkCSS::extend(array(
    "aspect" => "link"
), "ffButton");

class ffButton_html extends ffButton_base
{
	/**
	 * Classe assegnata al container del bottone
	 * @var String
	 */
	var $container_class		= "";
	var $container_properties	= array();
	var $data_class			= "";
	var $data_properties		= array();
	//var $widget_activebt_enable = false;
	
	var $fixed_pre_content = "";
	var $fixed_post_content = "";
	var $activebuttons = false;
	var $framework_css = null;

    function __construct($disk_path, $site_path, $page_path, $theme)
    {
        parent::__construct($disk_path, $site_path, $page_path, $theme);

        $this->framework_css = frameworkCSS::findComponent("ffButton");

    }


    /**
	 * recupera il file del template
	 * @return String 
	 */
	public function getTemplateFile()
	{
		if (strlen($this->template_file))
			return $this->template_file;
		else
		{
			switch ($this->aspect)
			{
				case "button":
					return "ffButton_button.html";
				case "link":
                default:
					return "ffButton_link.html";

					//return "ffButton_" . $this->aspect . ".html";
			}
		}
	}
	/**
	* recupera la classe HTML associata al pulsante
	* @return String
	*/
	function get_class($custom_class = null)
	{
        $class = array();

		if($this->class === false) {
            $class[] = $this->id;
        } elseif(is_array($this->class)) {
			$class[] = $this->parent_page[0]->frameworkCSS->get($this->id, $this->framework_css["aspect"], $this->class["params"]) . (strlen($this->class["value"]) ? " " . $this->class["value"] : "");
		} else {
		    if(!isset($this->framework_css["aspect"]["button"])) {
                switch ($this->aspect) {
                    case "button":
                    case "link":
                        $class[] = $this->parent_page[0]->frameworkCSS->get($this->id, "button");
                        break;
                    default:
                        $class[] = $this->parent_page[0]->frameworkCSS->get($this->aspect, "button");

                }
            }
            if(is_array($this->framework_css["aspect"])) {
                $class[] = $this->parent_page[0]->frameworkCSS->getClass($this->framework_css["aspect"]);
            }

            if(strlen($this->class)) {
                $class[] = $this->class;
            }
        }

		if($this->framework_css["addon"]) {
			$class[] = $this->parent_page[0]->frameworkCSS->get("control-" . $this->framework_css["addon"], "form");
		}
		if($this->activebuttons)
			$class[] = "activebuttons";
		if($custom_class) 
			$class[] = $custom_class;

		return implode(" ", $class);
	}
	function get_icon($only_class = null)
    {              
        if ($this->icon === NULL && $only_class !== false)  {  
            return $this->parent_page[0]->frameworkCSS->get($this->id, "icon-" . ($only_class ? "" : $this->framework_css["aspect"] . "-tag-") . "default");
        } else
            return array($this->icon); 
    }		
	/**
	 * carica l'oggetto template dentro $tpl
	 */
	public function tplLoad()
	{
		//if($this->aspect == "button")
		//	$this->framework_css["aspect"] = $this->aspect;

        $this->tpl[0] = $this->parent_page[0]->loadTemplate(pathinfo($this->getTemplateFile(), PATHINFO_FILENAME));
		//$this->tpl[0] = ffTemplate::factory($this->getTemplateDir());
		//$this->tpl[0]->load_file($this->getTemplateFile(), "main");

		if ($this->parent !== NULL && strlen($this->parent[0]->id))
			$this->tpl[0]->set_var("container", $this->parent[0]->id . "_");
		
		$this->tpl[0]->set_var("site_path", $this->site_path);
		$this->tpl[0]->set_var("page_path", $this->page_path);
		$this->tpl[0]->set_var("theme",  $this->getTheme());
		
		$icons = $this->get_icon(true);
		if(is_array($icons)) {
			$this->tpl[0]->set_var("class", $this->get_class());
			$this->tpl[0]->set_var("icon", implode("", $icons));
		} else {
			$this->tpl[0]->set_var("class", $this->get_class() . " " . $icons);
			$this->tpl[0]->set_var("icon", "");
		}
		$this->tpl[0]->set_var("fixed_pre_content", $this->fixed_pre_content);
		$this->tpl[0]->set_var("fixed_post_content", $this->fixed_post_content);
		
		/*if(strpos($this->get_class(), "activebuttons") !== false) {
			$this->widget_activebt_enable = true;

			if($this->parent !== NULL && property_exists($this->parent[0], "widget_activebt_enable")) {
				$this->parent[0]->widget_activebt_enable = true;
			}
		}*/
		
		$this->tpl[0]->set_var("properties", $this->getProperties());

		$this->tpl[0]->set_var("id", $this->id);

		if($this->display_label)
			$this->tpl[0]->set_var("label", $this->label);
			
		if (is_array($this->fixed_vars) && count($this->fixed_vars))
		{
			foreach ($this->fixed_vars as $key => $value)
			{
				$this->tpl[0]->set_var($key, $value);
			}
			reset($this->fixed_vars);
		}
	}
		
	/**
	 * Esegue il parsing del template
	 * @param Boolean $output_result se true visualizza a video il risultato del processing, se false restituisce il contenuto del processing
	 * @return Mixed può essere string o true, a seconda di output_result
	 */
	public function tplParse($output_result)
	{
		if ($output_result)
		{
			$this->tpl[0]->pparse("main", false);
			return true;
		}
		else
		{
			return $this->tpl[0]->rpparse("main", false);
		}
	}
}
