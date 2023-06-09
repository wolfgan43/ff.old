<?php
/**
 * VGallery: CMS based on FormsFramework
 * Copyright (C) 2004-2015 Alessandro Stucchi <wolfgan@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  @package VGallery
 *  @subpackage core
 *  @author Alessandro Stucchi <wolfgan@gmail.com>
 *  @copyright Copyright (c) 2004, Alessandro Stucchi
 *  @license http://opensource.org/licenses/gpl-3.0.html
 *  @link https://github.com/wolfgan43/vgallery
 */

frameworkCSS::extend(array(
            "grids" => array(
                "default" => array(
                    "class" => null
                    , "table" => array("container", "oddeven")
                )
                , "basic" => array(
                    "class" => null
                    , "table" => array("container")
                )
                , "inverse" => array(
                    "class" => null
                    , "table" => array("container", "inverse")
                )
                , "compact" => array(
                    "class" => null
                    , "table" => array("container", "compact")
                )
                , "small" => array(
                    "class" => null
                    , "table" => array("container", "small")
                )
                , "hover" => array(
                    "class" => null
                    , "table" => array("container", "hover")
                )
                , "border" => array(
                    "class" => null
                    , "table" => array("container", "border")
                )
                , "oddeven" => array(
                    "class" => null
                    , "table" => array("container", "oddeven")
                )
            )
            , "outer_wrap" => null
			, "component" => array(
                "inner_wrap" => array(
                    "card" => "container"
                )
                , "header_wrap" => array(
                    "card" => "header"
                )
                , "body_wrap" => array(
                    "card" => "body"
                )
                , "footer_wrap" => array(
                    "card" => "footer"
                )
                , "grid" => false        //false OR array(xs, sm, md, lg) OR 'row' OR 'row-fluid'
			)
			, "title" => array(
                "class" => null
                , "card" => "title"
            )
            , "description" => array(
                "class" => null
                , "card" => "sub-title"
            )
            , "title-alt" => array(
                "class" => null
                , "card" => "title"
            )
            , "description-alt" => array(
                "class" => "mb-2"
                , "card" => "sub-title"
            )
			, "actionsTop" => array(
			    "def" => array(
                    "class" => "actions mr-0 mb-3"
                    , "row" => "end"
                )
                , "button" => array(
                    "class" => "mr-1"
                )

			)
			, "search" => array(
			    "def" => null
                , "input" => array(
                    "class" => null
                    , "form" => array("control", "size-sm")
                )
                , "button" => array(
                    "class" => null
                    , "button" => array(
                        "color" => "primary"
                        , "size" => "small"
                    )
                )
			)
            , "searchAdv" => array(
                "def" => array(
                    "class" => "bg-light"
                    , "util" => array(
                        "hide"
                    )
                    , "card" => "container"
                )
                , "header_wrap" => false /*array(
                    "card" => "header"
                )*/
                , "body_wrap" => array(
                    "card" => "body"
                )
                , "footer_wrap" => false /*array(
                    "card" => "footer"
                )*/
			)
			, "navigatorTop" => array(
                "selector" => null
                , "nav" => null
                , "totelem" => null
                , "choice" => null
			)
            , "tableBefore" => array(
                "def" => array(
                    "class" => null
                    , "row" => "between"
                )
                , "left" => array(
                    "class" => null
                    , "col" => array(
                        "xs" => 12
                        , "sm" => 12
                        , "md" => 6
                        , "lg" => 6
                    )
                )
                , "right" => array(
                    "class" => null
                    , "col" => array(
                        "xs" => 12
                        , "sm" => 12
                        , "md" => 6
                        , "lg" => 6
                    )
                )
            )
			, "table" => array(
			    "def" => null
                , "responsive" => array(
                    "class" => null
                    , "table" => array("responsive")
                )
                , "cols" => array(
                    "def" => array(
                        "class" => null
                        , "util" => array(
                            "text-nowrap"
                            , "align-right"
                        )
                    )
                    , "counter" => false
                    , "first" => null
                    , "last" => array(
                        "class" => "hlast"
                    )
                )
                , "rows" => array(
                    "def" => array(
                        "class" => null
                    )
                    , "counter" => true
                    , "oddeven" => false
                    , "first" => null
                    , "last" => array(
                        "util" => array(
                            "align-right"
                        )
                    )
                )
                , "cell" => array(
                    "def" => array(
                        "class" => null
                    )
                    , "counter" => false
                    , "first" => null
                    , "last" => array(
                        "util" => array(
                            "align-right"
                        )
                    )
                )
			)
            , "tableAfter" => array(
                "def" => array(
                    "class" => null
                    , "row" => "between"
                )
                , "left" => array(
                    "class" => null
                    , "col" => array(
                        "xs" => 12
                        , "sm" => 12
                        , "md" => 6
                        , "lg" => 4
                    )
                )
                , "center" => array(
                    "class" => null
                    , "col" => array(
                        "xs" => 0
                        , "sm" => 0
                        , "md" => 0
                        , "lg" => 4
                    )
                )
                , "right" => array(
                    "class" => null
                    , "col" => array(
                        "xs" => 12
                        , "sm" => 12
                        , "md" => 6
                        , "lg" => 4
                    )
                )
            )
            , "sort" => array(
                "icon" => array(
                    "sortable" => "sort"
                    , "ASC" => "sort-asc"
                    , "DESC" => "sort-desc"
                ),
                "sortable" => array(
                     "table" => array("sorting")
                )
                , "ASC" => array(
                    "class" => null
                    , "table" => array("sorting_asc")
                )
                , "DESC" => array(
                    "class" => null
                    , "table" => array("sorting_desc")
                )
            )
			, "filter" => array(
				"def" => array(
				    "class" => "ml-1"
                    , "button" => "secondary"
                )
                , "icon" => "filter"
			)
			, "alphanum" => array(
				"class" => "mt-2"
				, "table" => array("container", "small")
			)
            , "navigatorBottom" => array(
                "selector" => null
                , "totelem" => null
                , "choice" => null
                , "nav" => null
			)
			, "actionsBottom" => array(
			    "def" => array(
                    "class" => "mr-0"
                    , "row" => "end"
                )
                , "button" => array(
                    "class" => "mr-1"
                )
            )
			, "field" => array(
				"label" => array(
					"col" => null
				)
				, "control" => array(
					"col" => null
				)
			)
			, "error" => array(
				"class" => "error"
				, "callout" => "danger"
			)
			, "norecord" => array(
			    "def" => array(
			        "class" => "mt-2"
			        , "card" => "container"
                    , "util" => array(
                        "align-center"
                    )
                )
                , "wrap" => array(
                    "card" => "body"
                )
			)), "ffGrid");

class ffGrid_html extends ffGrid_base
{
	var $framework_css          = null;
	var $buttons_options		= array(
									"search" => array(
											  "display" => true
											, "index" 	=> 0
											, "obj" 	=> null
											, "label" 	=> null
											, "class"	=> null
											, "icon"	=> null
											, "aspect"	=> "link"
									)
									, "delete" => array(
											"class"		=> null
											, "label"	=> null
                                            , "aspect"    => "link"
                                            , "disposition" => array("row" => 1, "col" => "last")
									)
									, "edit" => array(
											"class"		=> null
											, "label"	=> null
                                            , "icon"    => null
                                            , "aspect"  => "link"
                                            , "disposition" => array("row" => 1, "col" => "last")
									)
									, "addnew" => array(
											"class"		=> null
											, "label"	=> null
											, "icon"	=> null
											, "aspect"	=> "link"
									)
									, "export" => array(
											"class"		=> null
											, "display" => false
											, "index" 	=> 0
											, "obj" 	=> null
											, "label" 	=> null
											, "icon"	=> null
											, "aspect"	=> "link"
									)
								);

	var $id_if					= null;
	var $type					= null;

	var $grid_disposition_elem = array();
	var $component_properties = array();
    var $dialog_delete_url = null;
    var $dialog_action_button = false;

    var $cursor_dialog = false;

    /**
     * La label del tasto "turnon"
     * usato in presenza di checkbox
     * @var String
     */
    var $turn_on_label    = "ON";
    /**
     * La label del tasto "turnoff"
     * usato in presenza di checkbox
     * @var String
     */
    var $turn_off_label = "OFF";
    /**
     * Se la grid dev'essere full ajax
     * @var Boolean
     */
    var $full_ajax        = false;
    /**
     * Se dev'essere usata la funzionalità di aggiunta ajax con dialog
     * @var Boolean
     */
    var $ajax_addnew    = false;
    /**
     * Se dev'essere usata la funzionalità di editing ajax con dialog
     * @var Boolean
     */
    var $ajax_edit        = false;
    /**
     * Se dev'essere usata la funzionalità di cancellazione ajax con dialog
     * @var Boolean
     */
    var $ajax_delete    = false;
    /**
     * Se dev'essere usata la funzionalità di ricerca ajax con dialog
     * @var Boolean
     */
    var $ajax_search    = false;

    var $ajax_update_all = false;

    var $dialog_options = array(
        "addnew" => array(
        	"type" 			=> null
            , "width" 		=> ""
            , "height" 		=> ""
            , "title" 		=> ""
            , "class" 		=> null
        )
        , "edit" => array(
            "type" 			=> null
            , "width" 		=> ""
            , "height" 		=> ""
            , "title" 		=> ""
            , "class" 		=> null
        )
        , "delete" => array(
            "type" 			=> null
            , "width" 		=> ""
            , "height" 		=> ""
            , "title" 		=> ""
            , "class" 		=> null
        )
    );

    /**
     * una classe da associare alla riga
     * @var String
     */
    var $row_class        = "";
    var $row_properties   = array();
	//var $cel_class = "cel-[COUNT]";

    /**
     * La classe da assegnare alle colonne intermedie
     * @var String
     */
    var $column_class                = "";
    /**
     * La classe da assegnare alla prima colonna
     * @var String
     */
    //var $column_class_first         = "";
    /**
     * La classe da assegnare all'ultima colonna
     * @var String
     */
    //var $column_class_last            = "";
    /**
     * La classe da assegnare alle label di ordinamento
     * @var String
     */
    var $label_class                = "";
    /**
     * La classe da assegnare alle label di ordinamento quando selezionate
     * @var String
     */
    var $label_selected_class        = "";

    /**
     * Se visualizzare l'url di editing sulla griglia
     * @var Boolean
     */
    var $display_edit_url_alt   = "";
    /**
     * Se visualizzare il pulsante di editing sulla griglia
     * @var Boolean
     */
    var $display_edit_bt        = false;        // display edit record button
    /**
     * Target dell'editing sulla griglia
     * @var Boolean
     */
    var $record_target = false;
	/**
     * Se visualizzare il pulsante di cancellazione sulla griglia
     * @var Boolean
     */
    var $display_delete_bt        = true;            // display delete record button. This cause use of dialog.
    /**
     * Il simbolo usato per visualizzare i campi valuta
     * @var String
     */
    var $symbol_valuta          = "&euro; ";
    /**
     * Se visualizzare il campo di ricerca semplice
     * @var Boolean
     */
    var $display_search_simple     = true;
    /**
     * Le opzioni del campo di ricerca semplice
     * @var Array
     */
    var $search_simple_field_options    = array(
                                                "id" => "searchall"
                                                , "label"     => ""
                                                , "src_operation" => " [NAME] LIKE([VALUE]) "
                                                , "src_prefix"     => "%"
                                                , "src_postfix"     => "%"
                                                , "obj"     => null
                                                , "index"     => 0
                                                , "src_having" => true
                                            );
    var $reset_page_on_search = false;
    /**
     * Le dipendenze in widgets del componente
     * @var Array
     */
    var $widget_deps = array(
    		array("name" => "fullclick")
        );
    /**
     * Se la ricerca avanzata dev'essere aperta di default
     * @var Boolean
     */
    var $open_adv_search = false;
    /**
     * Una descrizione aggiuntiva da assegnare al componente
     * @var String
     */
    public $description = null;

    public $no_record_label = null;

    var $navigator_doAjax = true;
    var $navigator_display_selector = true;

	var $grid_disposition	= null;				// array of ffFields and fButtons to display in grid  by Row and Col
	var $grid_disposition_options = array(		// Wrap elem with same type in the same Col
		"button" => array(
			"wrap_col" => false
		)
		, "field" => array(
			"wrap_col" => false
		)
	);

    private $parsed_hidden_fields     = 0;
    /**
     * Variabile ad uso interno
     */
    private $parsed_fields         = 0;
    /**
     * Variabile ad uso interno
     */
    private $parsed_filters        = 0;

	var $js_deps = array(
		"ff.ffGrid" => null
	);

	/**
     * Il costruttore dell'oggetto
     * da non richiamare direttamente
     * @param ffPage_base $page
     * @param String $disk_path
     * @param String $theme
     */
    function __construct(ffPage_html $page, $disk_path, $theme)
    {
        parent::__construct($page, $disk_path, $theme);

        $this->framework_css = frameworkCSS::findComponent("ffGrid");

        if (ffTheme::RANDOMIZE_COMP_ID) {
            $this->id_if = uniqid();
        }

        if ($this->display_search_simple)
        {
            if ($this->search_simple_field_options["obj"] !== null)
            {
                $this->addSearchField($this->search_simple_field_options["obj"]);
            }
            else
            {
                $tmp = ffField::factory($page);
                $tmp->id			= $this->search_simple_field_options["id"];
                $tmp->label			= $this->search_simple_field_options["label"];
                $tmp->src_operation = $this->search_simple_field_options["src_operation"];
                $tmp->src_prefix	= $this->search_simple_field_options["src_prefix"];
                $tmp->src_postfix	= $this->search_simple_field_options["src_postfix"];
                $tmp->framework_css["control"] = $this->framework_css["search"]["input"];

                $tmp->data_type		= "";
                $tmp->display		= false;
                $this->addSearchField($tmp);
            }
        }
    }

	/**
	 * Aggiunge un campo che verrà visualizzato
	 * @param ffField Il campo da aggiungere
	 * @param boolean
	 */
	function addContent($field, $toOrder = true, $col = null, $row = null, $params = null)
	{
		$field->framework_css = array_replace_recursive($this->framework_css["field"], $field->framework_css);

		parent::addContent($field, $toOrder);

		$this->addGridDisposition($field->id, "field", $col, $row, $params);
	}

	/**
	 * Aggiunge un pulsante a ffGrid; il pulsante viene aggiunto ad ogni riga di ffGrid
	 * @param ffButton $button
	 */
	function addGridButton($button, $col = null, $row = null, $params = null)
	{
		parent::addGridButton($button);

		$this->addGridDisposition($button->id, "button", $col, $row, $params);
	}

    function addGridDisposition($ID_component, $component_type, $col = null, $row = null, $params = null) {
    	$default_type = array(
    		"button" => -1
    	);

		if(!count($this->grid_disposition))
			$this->grid_disposition[] = array();

		if($row === null)
			$row = 0;
		elseif(is_numeric($row))
			$row = $row - 1;
		elseif($row == "last")
			$row = count($this->grid_disposition) - 1;

		if($row < 0)
			$row = 0;

		if($row - count($this->grid_disposition) > 1)
			$row = count($this->grid_disposition) + 1;

		if($col == "last" && !isset($this->grid_disposition_elem["data"][$row][count($this->grid_disposition[$row]) - 1][$component_type]))
			$col = null;
		if($col == "default")
			$col = (is_array($this->grid_disposition_elem["data"][$row][count($this->grid_disposition[$row]) - 1][$component_type]) && count($this->grid_disposition_elem["data"][$row][count($this->grid_disposition[$row]) - 1][$component_type]) == 1
				? "last"
				: null
			);

		if($col === null) {
			$col = count($this->grid_disposition[$row]);

			if($this->grid_disposition_options[$component_type]["wrap_col"]
				&& isset($default_type[$component_type])
				&& $col > 0
				&& count($this->grid_disposition_elem["data"][$row][$col + $default_type[$component_type]]) == 1
				&& isset($this->grid_disposition_elem["data"][$row][$col + $default_type[$component_type]][$component_type])
			) {
				$col = $col + $default_type[$component_type];
			}
		} elseif(is_numeric($col)) {
			$col = $col - 1;
		} elseif($col == "last") {
			$col = count($this->grid_disposition[$row]) - 1;
		}

		if($col < 0)
			$col = count($this->grid_disposition[$row]);

		if($col - count($this->grid_disposition[$row]) > 1)
			$col = count($this->grid_disposition[$row]) + 1;

		$params["type"] = $component_type;

		$this->grid_disposition[$row][$col][$ID_component] = $params;

		$this->grid_disposition_elem["data"][$row][$col][$component_type]++;
		$this->grid_disposition_elem[$component_type][$row]++;
		$this->grid_disposition_elem["count"][$row]++;
    }

	function getIDIF()
	{
		if ($this->id_if !== null) {
            return $this->id_if;
        } else {
            return $this->id;
        }
	}

	function getPrefix()
	{
		$tmp = $this->getIDIF();
		if (strlen($tmp))
			return $tmp . "_";
	}

    /**
     * Carica il template della griglia
     */
    protected function tplLoad()
    {
        $this->tpl[0] = $this->parent[0]->loadTemplate(pathinfo($this->template_file, PATHINFO_FILENAME));
        //$this->tpl[0] = ffTemplate::factory($this->getTemplateDir());
        //$this->tpl[0]->load_file($this->template_file, "main");

        $this->tpl[0]->set_var("site_path", $this->site_path);
        $this->tpl[0]->set_var("page_path", $this->page_path);
        $this->tpl[0]->set_var("theme", $this->getTheme());
        $this->tpl[0]->set_var("this_url", rawurlencode($this->parent[0]->getRequestUri()));

        $this->tpl[0]->set_var("fixed_pre_content", $this->fixed_pre_content);
        $this->tpl[0]->set_var("fixed_post_content", $this->fixed_post_content);

        $this->tpl[0]->set_var("fixed_title_content", $this->fixed_title_content);
        $this->tpl[0]->set_var("fixed_heading_content", $this->fixed_heading_content);
        $this->tpl[0]->set_var("fixed_body_content", $this->fixed_body_content);

        $this->tpl[0]->set_var("SectHiddenField", "");

        $this->tpl[0]->set_var("component", $this->getPrefix());
        $this->tpl[0]->set_var("component_id", $this->getIDIF());

    	//$action_class["default"] = "actions";
        if(isset($_REQUEST["XHR_CTX_ID"]))
        {
        	$title_class["default"] = "dialogTitle";
        	$action_class["dialog"] = "dialogActionsPanel";
          //  $action_class["align"] = $this->parent[0]->frameworkCSS->get("align-right", "util");
        	$action_top_class = $action_class;
            $action_top_class["top"] = "top";
    		if($this->dialog_action_button)
    			$action_top_class["force"] = "force";

			$this->tpl[0]->set_var("actions_top_class", implode(" " , array_filter($action_top_class)));
			$this->tpl[0]->set_var("actions_bottom_class", implode(" " , array_filter($action_class)));
		}
		else
		{
            $action_class           = "";
        	$action_top_class       = "";

            $this->tpl[0]->set_var("actions_top_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["actionsTop"]["def"], $action_top_class));
			$this->tpl[0]->set_var("actions_bottom_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["actionsBottom"]["def"], $action_class));
		}
        if(strlen($this->title)) {
            if($this->framework_css["component"]["header_wrap"]) {
                $this->tpl[0]->set_var("title", '<h2 class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["title"]) . '">' . $this->title . '</h2>');
            } else {
                $this->tpl[0]->set_var("title", '<h4 class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["title-alt"]) . '">' . $this->title . '</h4>');
            }
        }

        if(strlen($this->description)) {
            if($this->framework_css["component"]["header_wrap"]) {
                $this->tpl[0]->set_var("description", '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["description"]) . '">' . $this->description . '</div>');
            } else {
                $this->tpl[0]->set_var("description", '<p class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["description-alt"]) . '">' . $this->description . '</p>');
            }
        }

        //if ($this->parent !== NULL)
        //    $this->tpl[0]->set_var("ret_url", $this->parent[0]->ret_url);


        $this->setProperties();

        if (is_array($this->fixed_vars) && count($this->fixed_vars))
        {
            foreach ($this->fixed_vars as $key => $value)
            {
                $this->tpl[0]->set_var($key, $value);
            }
            reset($this->fixed_vars);
        }

        $res = $this->doEvent("on_load_template", array(&$this, $this->tpl[0]));
    }

    /**
     * Elabora il template
     * @param Boolean $output_result se dev'essere visualizzata immediatamente l'elaborazione
     * @return Mixed il risultato dell'operazione
     */
    public function tplParse($output_result)
    {
        $res = ffGrid::doEvent("on_tplParse", array($this, $this->tpl[0], $output_result));
        $res = $this->doEvent("on_tplParse", array($this, $this->tpl[0], $output_result));

        if(!$this->parent[0]->use_own_form && !$this->full_ajax) {
            $this->tpl[0]->set_var("grid_tag", "form");
            $this->tpl[0]->set_var("component", "");
            $this->tpl[0]->set_var("id", "frmAction");
            $this->tpl[0]->set_var("value", "");
            $this->tpl[0]->parse("SectHiddenField", true);
            $this->properties["method"] = "post";
        } else
            $this->tpl[0]->set_var("grid_tag", "div");

        if($this->use_paging || $this->use_search || $this->use_alpha || $this->use_order || $this->parsed_hidden_fields || $this->use_fields_params)
            $this->tpl[0]->parse("SectHidden", false);
        else
            $this->tpl[0]->set_var("SectHidden", "");

        if ($this->parent[0]->getXHRComponent() == $this->id)
        {
            if($this->db[0]->query_id)
                $this->json_result["rows"] = $this->db[0]->numRows();
            else
                $this->json_result["rows"] = 0;

            $this->json_result["page"] = $this->page;

            if (isset($_REQUEST["XHR_SECTION"]))
            {
                if ($this->use_paging || $this->use_search || $this->use_alpha || $this->use_order || $this->parsed_hidden_fields || $this->use_fields_params)
                    $this->json_result["hidden"] = preg_replace('/\s+/', ' ', $this->tpl[0]->rpparse("SectHidden", false));
                else
                    $this->json_result["hidden"] = "";

                if($this->json_result["rows"]) {
                    return $this->tpl[0]->rpparse("Sect" . $_REQUEST["XHR_SECTION"], false);
                } else {
                    $this->json_result["injectid"] = "#" . $this->id . " TABLE.dataTable";
                    return $this->tpl[0]->rpparse("SectNoRecords", false);
                }
            }
        }

        if ($output_result === true)
        {
            $this->tpl[0]->pparse("main", false);
            return true;
        }
        elseif ($output_result === false)
        {
            return $this->tpl[0]->rpparse("main", false);
        }
    }

    function process_headers()
    {
        if (!isset($this->tpl[0]))
            return;

        if (!$this->display_navigator || !$this->use_paging || ($this->navigator[0]->num_rows <= $this->navigator[0]->records_per_page && !($this->ajax_search || $this->full_ajax)))
            return $this->tpl[0]->rpparse("SectHeaders", false);
        else
            return $this->tpl[0]->rpparse("SectHeaders", false) . $this->navigator[0]->process_headers();
    }

    function process_footers()
    {
        if (!isset($this->tpl[0]))
            return;

        if (!$this->display_navigator || !$this->use_paging || ($this->navigator[0]->num_rows <= $this->navigator[0]->records_per_page && !($this->ajax_search || $this->full_ajax)))
            return $this->tpl[0]->rpparse("SectFooters", false);
        else
            return $this->tpl[0]->rpparse("SectFooters", false) . $this->navigator[0]->process_footers();
    }

    /**
	 * error template processing function
	 * called by process_interface()
	 */
	function displayError($sError = null)
	{
		if ($sError !== null)
			$this->strError = $sError;

		if (strlen($this->strError))
		{
			$this->tpl[0]->set_var("error_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["error"]));
			$this->tpl[0]->set_var("strError", $this->strError);
			$this->tpl[0]->parse("SectError", false);
		}
		else
			$this->tpl[0]->set_var("SectError", "");
	}
    /**
     * Elabora i parametri di ricerca
     */
    function process_search_params()
    {
        parent::process_search_params();

        if($this->display_search_simple && strlen($this->search_fields[$this->search_simple_field_options["id"]]->getValue()) && $this->search_simple_field_options["src_having"])
        {
            $tmp_sqlHaving = "";
            foreach ($this->grid_fields AS $key => $value)
            {
                if ($this->grid_fields[$key]->data_type == "" || $this->grid_fields[$key]->skip_search)
                    continue;

                $tmp_sql = "";

                $tmp_where_value = "";
                if(strlen($this->grid_fields[$key]->src_table))
                    $tblprefix = "`" . $this->grid_fields[$key]->src_table . "`.";
                else
                    $tblprefix = "";

                if($this->grid_fields[$key]->extended_type == "Selection" && $this->grid_fields[$key]->source_SQL)
                {
                    $this->grid_fields[$key]->pre_process();

                    if(is_array($this->grid_fields[$key]->recordset) && count($this->grid_fields[$key]->recordset))
                    {
                        foreach ($this->grid_fields[$key]->recordset AS $source_SQL_key => $source_SQL_value)
                        {
                            if(strpos($source_SQL_value[1]->getValue(), $this->search_fields[$this->search_simple_field_options["id"]]->getValue()) !== false)
                            {
                                if(strlen($tmp_where_value))
                                    $tmp_where_value .= ", ";

                                $tmp_where_value .= $this->db[0]->toSql($source_SQL_value[0]);
                            }
                        }
                    }
                    if(strlen($tmp_where_value))
                        $tmp_sql = $tblprefix . "`" . $this->grid_fields[$key]->get_data_source() . "` IN (" . $tmp_where_value . ")";
                }
                elseif($this->grid_fields[$key]->extended_type == "Selection" && $this->grid_fields[$key]->multi_pairs)
                {
                    if(is_array($this->grid_fields[$key]->multi_pairs) && count($this->grid_fields[$key]->multi_pairs))
                    {
                        foreach ($this->grid_fields[$key]->multi_pairs AS $multi_pairs_key => $multi_pairs_value)
                        {
                            if(stripos($multi_pairs_value[1]->getValue(null, FF_LOCALE), $this->search_fields[$this->search_simple_field_options["id"]]->getValue()) !== false)
                            {
                                if(strlen($tmp_where_value))
                                    $tmp_where_value .= ", ";

                                $tmp_where_value .= $this->db[0]->toSql($multi_pairs_value[0]);
                            }
                        }
                    }
                    if(strlen($tmp_where_value))
                        $tmp_sql = $tblprefix . "`" . $this->grid_fields[$key]->get_data_source() . "` IN (" . $tmp_where_value . ")";
                }
                else
                {
					if ($this->grid_fields[$key]->crypt)
					{
						$tmp_where_value = $this->search_fields[$this->search_simple_field_options["id"]]->value->getValue();

						if ($this->grid_fields[$key]->crypt_modsec)
						{
							$tmp_where_value = mod_sec_crypt_string($tmp_where_value);
						}

						if (is_array($this->grid_fields[$key]->src_fields) && count($this->grid_fields[$key]->src_fields))
							$tmp_sql .= " ( ";

						$tmp_sql = " " . $tblprefix . "`" . $this->grid_fields[$key]->get_data_source() . "` = UNHEX(" . $this->db[0]->toSql(bin2hex($tmp_where_value)) . ") ";

						if (is_array($this->grid_fields[$key]->src_fields) && count($this->grid_fields[$key]->src_fields))
						{
							foreach ($this->grid_fields[$key]->src_fields AS $addfld_key => $addfld_value)
							{
								$tmp_where_part = " " . $tblprefix . "`" . $this->grid_fields[$addfld_key]->get_data_source() . "` = UNHEX(" . $this->db[0]->toSql(bin2hex($tmp_where_value)) . ") ";
								$tmp_sql .= " OR " . $tmp_where_part . " ";
							}
							reset($this->grid_fields[$key]->src_fields);
							$tmp_sql .= " ) ";
						}
					}
					else
					{
						if($this->search_fields[$this->search_simple_field_options["id"]]->src_prefix || $this->search_fields[$this->search_simple_field_options["id"]]->src_postfix)
						{
							$tmp_where_value = $this->db[0]->toSql($this->search_fields[$this->search_simple_field_options["id"]]->value, $this->search_fields[$this->search_simple_field_options["id"]]->base_type, false);
							if ($this->grid_fields[$key]->crypt)
							{
								if ($this->grid_fields[$key]->crypt_modsec)
								{
									$tmp_where_value = mod_sec_crypt_string($tmp_where_value);
								}
							}
							$tmp_where_value = "'" . $this->search_fields[$this->search_simple_field_options["id"]]->src_prefix . $tmp_where_value . $this->search_fields[$this->search_simple_field_options["id"]]->src_postfix . "'";
						}
						else
						{
							$tmp_where_value = $this->db[0]->toSql($this->search_fields[$this->search_simple_field_options["id"]]->value);
						}

						if (is_array($this->grid_fields[$key]->src_fields) && count($this->grid_fields[$key]->src_fields))
							$tmp_sql .= " ( ";

						$tmp_where_part = $this->search_fields[$this->search_simple_field_options["id"]]->src_operation;
						$tmp_where_part = str_replace("[NAME]", $tblprefix . "`" . $this->grid_fields[$key]->get_data_source() . "`", $tmp_where_part);
						$tmp_where_part = str_replace("[VALUE]", $tmp_where_value, $tmp_where_part);
						$tmp_sql .= " " . $tmp_where_part . " ";

						if (is_array($this->grid_fields[$key]->src_fields) && count($this->grid_fields[$key]->src_fields))
						{
							foreach ($this->grid_fields[$key]->src_fields AS $addfld_key => $addfld_value)
							{
								$tmp_where_part = $this->search_fields[$this->search_simple_field_options["id"]]->src_operation;
								$tmp_where_part = str_replace("[NAME]", $this->grid_fields[$addfld_key], $tmp_where_part);
								$tmp_where_part = str_replace("[VALUE]", $tmp_where_value, $tmp_where_part);
								$tmp_sql .= " OR " . $tmp_where_part . " ";
							}
							reset($this->grid_fields[$key]->src_fields);
							$tmp_sql .= " ) ";
						}
					}
                }

                //if($this->grid_fields[$key]->src_having)
                //{
                    if (strlen($tmp_sqlHaving) && strlen($tmp_sql))
                        $tmp_sqlHaving .= " OR ";

                    $tmp_sqlHaving .=  $tmp_sql;
                /*} else {
                    if (strlen($tmp_sqlWhere) && strlen($tmp_sql))
                        $tmp_sqlWhere .= " OR ";

                    $tmp_sqlWhere .=  $tmp_sql;
                }*/
            }
            reset ($this->grid_fields);
            if(strlen($tmp_sqlHaving))
                $this->sqlHaving = " ( " . $tmp_sqlHaving . " ) ";

            /*if(strlen($tmp_sqlWhere))
                $this->sqlWhere = " ( " . $tmp_sqlWhere . " ) ";*/
        }
    }

	/**
	 * alpha template processing function
	 * called by process_interface()
	 */
	function process_alpha()
	{
		if (!$this->use_alpha)
		{
			$this->tpl[0]->set_var("SectAlpha", "");
			return;
		}

		$this->tpl[0]->set_var("alphanum_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["alphanum"], array("alphanum")));
		$this->tpl[0]->set_var("max_colspan", count($this->grid_disposition[0]));
		$this->tpl[0]->set_var("actual_alpha", ffCommon_specialchars($this->alpha));
		$this->tpl[0]->set_var("field", ffCommon_specialchars($this->search_fields[$this->alpha_field]->label));
		$this->tpl[0]->set_var("alpha_selected_" . $this->alpha, $this->parent[0]->frameworkCSS->get("current", "util"));

		if (isset($_REQUEST["XHR_DIALOG_ID"]))
			$this->tpl[0]->set_var("alpha_action", "jQuery('#" . $this->getPrefix() . "alpha').val(jQuery(this).attr('rel')); ff.ffPage.dialog.doRequest('" . $_REQUEST["XHR_DIALOG_ID"] . "', {'action' : 'alpha', 'component' :'" . $this->id . "'})");
		else
			$this->tpl[0]->set_var("alpha_action", "jQuery('#" . $this->getPrefix() . "alpha').val(jQuery(this).attr('rel'));  ff.ajax.doRequest({'action' : 'alpha', 'component' :'" . $this->id . "'})");

		$this->tpl[0]->parse("SectAlpha", false);
	}
    /**
     * action buttons processing function
     * called by process_interface()
     */
    function process_action_buttons()
    {
        if (!$this->display_actions)
        {
            $this->tpl[0]->set_var("SectActionButtons", "");
            return;
        }

        $count = 0;
        if (is_array($this->action_buttons) && count($this->action_buttons))
        {
            foreach ($this->action_buttons as $key => $FormButton)
            {
                if (!isset($this->buttons_options[$key]["display"]) || $this->buttons_options[$key]["display"] !== false)
                {
                    $this->tpl[0]->set_var("ActionButton", $this->action_buttons[$key]->process());
                    $this->tpl[0]->parse("SectAction", true);
                    $count++;
                }
            }
            reset($this->action_buttons);
            $this->tpl[0]->parse("SectActionButtons", false);
        }

        if ($count)
            $this->tpl[0]->parse("SectActionButtons", false);
        else
        {
            $this->tpl[0]->set_var("SectAction", "");
            $this->tpl[0]->set_var("SectActionButtons", "");
        }
    }
    /**
     * action buttons processing function
     * called by process_interface()
     */
    function process_action_buttons_header()
    {
        if (!$this->display_actions && !$this->display_new)
        {
            $this->tpl[0]->set_var("SectActionButtonsHeader", "");
            return;
        }

        $count = $this->display_new;
        if (is_array($this->action_buttons_header) && count($this->action_buttons_header))
        {
            foreach ($this->action_buttons_header as $key => $FormButton)
            {
                if (!isset($this->buttons_options[$key]["display"]) || $this->buttons_options[$key]["display"] !== false)
                {
                    $this->tpl[0]->set_var("ActionButtonHeader", $this->action_buttons_header[$key]->process());
                    $this->tpl[0]->parse("SectActionHeader", true);
                    $count++;
                }
            }
            reset($this->action_buttons_header);
        }

        if ($this->display_new) // done at this time due to maxspan
        {
            if (strlen($this->bt_insert_url))
            {
                $addnew_url_ajax = ffProcessTags($this->bt_insert_url, $this->key_fields, $this->grid_fields, "normal", $this->parent[0]->get_params(), $_SERVER['REQUEST_URI'], $this->parent[0]->get_globals(), null, $this->db[0]);
                $addnew_url_noajax = $addnew_url_ajax;
            }
            else
            {
                if (strlen($this->record_insert_url))
                    $addnew_url_ajax = $this->record_insert_url;
                else
                    $addnew_url_ajax = $this->record_url;

                if($addnew_url_ajax) {
                    $addnew_url_ajax .= "?" . $this->parent[0]->get_keys($this->key_fields) .
                        $this->parent[0]->get_globals() . $this->addit_insert_record_param;

                    $addnew_url_ajax = ffProcessTags($addnew_url_ajax, $this->key_fields, $this->grid_fields, "normal", $this->parent[0]->get_params(), $_SERVER['REQUEST_URI'], $this->parent[0]->get_globals(), null, $this->db[0]);
                    $addnew_url_noajax = $addnew_url_ajax; //. "ret_url=" . rawurlencode($this->parent[0]->getRequestUri());
                }
                /*if($this->full_ajax || $this->ajax_addnew)
                    $addnew_url = $addnew_url_ajax;
                else
                    $addnew_url = $addnew_url_noajax;	*/
            }


            /*            $res = $this->doEvent("onUrlInsert", array(&$this, $temp_url));
                        $rc = end($res);
                            if ($rc !== null)
                                $temp_url = $rc;
            */
            if($this->buttons_options["addnew"]["label"] === null)
                $this->buttons_options["addnew"]["label"] = ffTemplate::_get_word_by_code("ffGrid_addnew");

            if($this->buttons_options["addnew"]["icon"] === null)
                $this->buttons_options["addnew"]["icon"] = $this->parent[0]->frameworkCSS->get("addnew", "icon-" . $this->buttons_options["addnew"]["aspect"] . "-tag");

            if($this->buttons_options["addnew"]["class"] === null)
                $this->buttons_options["addnew"]["class"] = $this->parent[0]->frameworkCSS->get("addnew", $this->buttons_options["addnew"]["aspect"]);

            if ($this->full_ajax || $this->ajax_addnew)
            {
                $this->load_dialog($this->record_id, $this->dialog_options["addnew"]);
                $this->tpl[0]->set_var("ActionAddNew", "<a " . (strlen($this->buttons_options["addnew"]["class"])
                        ? "class=\"" . $this->buttons_options["addnew"]["class"] . "\" "
                        : ""
                    )
                    . ($addnew_url_ajax

                        ? "href=\"javascript:ff.ffPage.dialog.doOpen('" . $this->record_id . "', '" . ffCommon_specialchars($addnew_url_ajax) . "');\">"
                        : "href=\"javascript:void(0);\">"
                    )
                    . $this->buttons_options["addnew"]["icon"] . $this->buttons_options["addnew"]["label"]
                    . "</a>");
            }
            else
            {
                $this->tpl[0]->set_var("ActionAddNew", "<a " . (strlen($this->buttons_options["addnew"]["class"])
                        ? "class=\"" . $this->buttons_options["addnew"]["class"] . " noajax\" "
                        : ""
                    )
                    . "href=\"javascript:ff.ffPage.goToWithRetUrl('" . ffCommon_specialchars($addnew_url_noajax) . "');\">"
                    . $this->buttons_options["addnew"]["icon"] . $this->buttons_options["addnew"]["label"]
                    . "</a>");
            }
        }

        if ($count) {
            $this->tpl[0]->parse("SectActionButtonsHeader", false);
        } else
        {
            $this->tpl[0]->set_var("SectActionHeader", "");
            $this->tpl[0]->set_var("SectActionButtonsHeader", "");
        }
    }
	/**
	 * search template processing function
	 * called by process_interface()
	 */
    function process_search()
    {
        if (!$this->use_search || ($this->parent[0]->getXHRComponent() == $this->id && $this->parent[0]->getXHRSection() == "GridData"))
            return;

        if($this->display_search)
        {
            $this->tpl[0]->set_var("hide_class", $this->parent[0]->frameworkCSS->get("hide", "util"));

            if ($this->display_search_simple)
            {
    			$this->search_fields[$this->search_simple_field_options["id"]]->properties["onkeydown"] = "ff.submitProcessKey(event, jQuery('#" . $this->getIDIF() . " .ffSearch'));";
                $this->search_fields[$this->search_simple_field_options["id"]]->fixed_post_content = $this->search_buttons[0]->process();
    			$buffer = $this->search_fields[$this->search_simple_field_options["id"]]->process($this->search_simple_field_options["id"] . "_src");

                $this->tpl[0]->set_var("omniSearch", $buffer);
            }

            if(is_array($this->search_fields) && count($this->search_fields)) {
                $this->tpl[0]->set_var("filter_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["filter"]["def"]));
                if($this->framework_css["filter"]["icon"]) {
                    $this->tpl[0]->set_var("filter_icon", $this->parent[0]->frameworkCSS->get($this->framework_css["filter"]["icon"], "icon-tag"));
                }
                $this->tpl[0]->set_var("filter_properties", $this->parent[0]->frameworkCSS->get("toggle", "data", "button"));


                $this->tpl[0]->parse("SectFilterToggle", false);
            }

        }

		/*$search_class["default"] = "search";
		$this->tpl[0]->set_var("search_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["search"]["def"], $search_class));
		$this->tpl[0]->set_var("search_box_class", $this->parent[0]->frameworkCSS->get("group", "form"));
*/


            //$this->tpl[0]->set_var("maxspan", ($this->search_cols * 2));
		//$this->tpl[0]->set_var("search_method", $this->search_method);
		//$this->tpl[0]->set_var("search_url", $this->search_url);

		//$col = 1;
		//$last_span = 0;
		$wrap_count = 0;

		$this->parsed_fields = 0;
		$this->parsed_filters = 0;

		foreach ($this->search_fields as $key => $value)
		{
			if (!$this->search_fields[$key]->display)
				continue;

			if($this->display_search)
			{
				$buffer = "";
				$container_class = "";
				if ($this->search_fields[$key]->src_interval)
				{
					// display label from
					if($this->search_fields[$key]->interval_from_label) {
                        $this->search_fields[$key]->label = $this->search_fields[$key]->interval_from_label;
                    }
					// display control from
					$buffer .= $this->search_fields[$key]->process($this->search_fields[$key]->id . "_from_src", $this->search_fields[$key]->interval_from_value);

					// display label to
					if($this->search_fields[$key]->interval_to_label) {
                        $this->search_fields[$key]->label = $this->search_fields[$key]->interval_to_label;
                    }

					// display control to
					$buffer .= $this->search_fields[$key]->process($this->search_fields[$key]->id . "_to_src", $this->search_fields[$key]->interval_to_value);
				}
				else
				{
                    $this->search_fields[$key]->properties["onkeydown"] = "ff.submitProcessKey(event, jQuery('#" . $this->getIDIF() . " .ffSearch'));";

					// display control
					$buffer .= $this->search_fields[$key]->process($this->search_fields[$key]->id . "_src");
				}

				$this->parsed_fields++;
				$row = "wrap";
				if(is_array($this->search_fields[$key]->framework_css["outer_wrap"]["col"])
				    && count($this->search_fields[$key]->framework_css["outer_wrap"]["col"])
				) {
					$container_class = $this->parent[0]->frameworkCSS->get($this->search_fields[$key]->framework_css["outer_wrap"]["col"], "col");
					$wrap_count = $wrap_count + $this->search_fields[$key]->framework_css["outer_wrap"]["col"]["lg"];
				} elseif($this->search_fields[$key]->framework_css["outer_wrap"]["row"]) {
					$row = "wrap-padding";
					//$container_class = $this->parent[0]->frameworkCSS->get("row-padding", "form");
					$wrap_count = 12;
				} else {
					$wrap_count = 12;
				}

				if($container_class)
					$buffer = '<div class="' . $container_class . '">' . $buffer . "</div>";

				$this->tpl[0]->set_var("control", $buffer);
				$this->tpl[0]->parse("SectSearchCol", true);

				if($wrap_count >= 12) {
					$this->tpl[0]->set_var("adv_row_class", $this->parent[0]->frameworkCSS->get($row, "form"));
					$this->tpl[0]->parse("SectSearchRow", true);
					$this->tpl[0]->set_var("SectSearchCol", "");
					$wrap_count = 0;
				}
			}
		}
		reset($this->search_fields);



        if ($this->parsed_fields) {
            // $this->open_adv_search  = true;
            if(/*!$this->searched &&*/ $this->open_adv_search) {
                unset($this->framework_css["searchAdv"]["def"]["util"]);
            }

            $search_html["header"] = ($this->framework_css["searchAdv"]["header_wrap"]
                ? '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["searchAdv"]["header_wrap"]) . '">' . ffTranslator::get_word_by_code("ffGrid_search_title") . '</div>'
                : null
            );
            $search_html["footer"] = ($this->framework_css["searchAdv"]["footer_wrap"]
                ? '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["searchAdv"]["footer_wrap"]) . '">' . $this->search_buttons[0]->process($this->search_buttons[0]->id . "_adv") . '</div>'
                : null
            );

            $this->tpl[0]->set_var("wrap_search_start", '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["searchAdv"]["def"], array("adv-search")) . '">'
                . $search_html["header"]
                . ($this->framework_css["searchAdv"]["body_wrap"]
                    ? '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["searchAdv"]["body_wrap"]) . '">'
                    : null
                )
            );
            $this->tpl[0]->set_var("wrap_search_end", ($this->framework_css["searchAdv"]["body_wrap"]
                    ? '</div>'
                    : null
                )
                . $search_html["footer"]
                . '</div>'
            );

            $this->tpl[0]->parse("SectSearch", false);
        }
    }

    /**
     * Esegue il processing vero e proprio dei contenuti della grid
     */
    public function process_grid()
    {
        if ($this->display_grid == "never" || ($this->display_grid == "search" && !strlen($this->searched)))
        {
            $this->tpl[0]->set_var("SectGridTable", "");
			$this->tpl[0]->parse("SectGrid", false);
            return;
        }

		// Manage various buttons
        /*if ($this->display_edit_bt)
        	$this->addGridDisposition("edit", "button", ($this->grid_disposition_elem["button"][$this->buttons_options["delete"]["disposition"]["row"] - 1] == $this->grid_disposition_elem["data"][$this->buttons_options["edit"]["disposition"]["row"] - 1][count($this->grid_disposition_elem["data"][$this->buttons_options["edit"]["disposition"]["row"] - 1]) - 1]["button"]
        		? "last"
        		: $this->buttons_options["delete"]["disposition"]["col"]), $this->buttons_options["edit"]["disposition"]["row"]
        	);
        if ($this->display_delete_bt)
        	$this->addGridDisposition("delete", "button", ($this->grid_disposition_elem["button"][$this->buttons_options["delete"]["disposition"]["row"] - 1] == $this->grid_disposition_elem["data"][$this->buttons_options["delete"]["disposition"]["row"] - 1][count($this->grid_disposition_elem["data"][$this->buttons_options["delete"]["disposition"]["row"] - 1]) - 1]["button"]
        		? "last"
        		: $this->buttons_options["delete"]["disposition"]["col"]), $this->buttons_options["delete"]["disposition"]["row"]
        	);*/

        if ($this->record_url && $this->display_edit_bt)
        	$this->addGridDisposition("edit", "button", $this->buttons_options["edit"]["disposition"]["col"], $this->buttons_options["edit"]["disposition"]["row"]);
        if ($this->record_url && $this->display_delete_bt)
        	$this->addGridDisposition("delete", "button", $this->buttons_options["delete"]["disposition"]["col"], $this->buttons_options["delete"]["disposition"]["row"]);

        	//echo $this->grid_disposition_elem["data"][$this->buttons_options["delete"]["disposition"]["row"] - 1][count($this->grid_disposition_elem["data"][$this->buttons_options["delete"]["disposition"]["row"] - 1]) - 1]["button"];
        parent::process_grid();

		//$table_class["default"] = "ffGrid";
        if($this->type) {
            $this->framework_css["table"]["def"] = ($this->framework_css["grids"][$this->type]
                ? $this->framework_css["grids"][$this->type]
                : $this->framework_css["grids"]["default"]
            );
        } elseif(!$this->framework_css["table"]["def"]) {
            $this->framework_css["table"]["def"] = $this->framework_css["grids"]["default"];
        }


        $this->tpl[0]->set_var("table_responsive_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["table"]["responsive"]));
        $this->tpl[0]->set_var("table_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["table"]["def"]));

        $this->tpl[0]->set_var("table_before_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["tableBefore"]["def"]));
        $this->tpl[0]->set_var("table_before_left_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["tableBefore"]["left"]));
        $this->tpl[0]->set_var("table_before_right_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["tableBefore"]["right"]));

        $this->tpl[0]->set_var("table_after_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["tableAfter"]["def"]));
        $this->tpl[0]->set_var("table_after_left_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["tableAfter"]["left"]));
        $this->tpl[0]->set_var("table_after_center_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["tableAfter"]["center"]));
        $this->tpl[0]->set_var("table_after_right_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["tableAfter"]["right"]));





        $col_count = count($this->grid_fields);

        if ($this->record_url && $this->display_edit_bt)
            $col_count++;

        if ($this->record_url && $this->display_delete_bt)
            $col_count++;

        if (is_array($this->grid_buttons) && count($this->grid_buttons))
            $col_count += count($this->grid_buttons);

        //$this->tpl[0]->set_var("maxspan", $totfields);

        $this->process_navigator(); // done at this time due to maxspan and $this->db[0]->numRows()

        if ($this->db[0]->query_id )
        {
        	/**
        	* Set last button Col
        	*/
			if(count($this->grid_disposition) > 1
                && count($this->grid_disposition_elem["data"][0][count($this->grid_disposition_elem["data"][0]) - 1]) == 1
                && array_key_exists("button", $this->grid_disposition_elem["data"][0][count($this->grid_disposition_elem["data"][0]) - 1])
            ) {
                $last_button = $this->grid_disposition[0][count($this->grid_disposition) - 1];
                unset($this->grid_disposition[0][count($this->grid_disposition) - 1]);
            }

			if ($this->full_ajax || $this->ajax_edit || $this->ajax_delete) {
				if($this->record_url) {
                    $this->load_dialog($this->record_id, $this->dialog_options["edit"]);

                    if ($this->display_delete_bt) {
                        $this->load_dialog($this->record_id, $this->dialog_options["delete"]);
                    }
                }
			}

            //$this->tpl[0]->set_var("SectNoRecords", "");
            $arrGridData = array();
            if ($this->use_paging && !$this->pagination_save_memory_in_use) {
                if($this->db[0]->nextRecord()) {
                    $this->db[0]->jumpToPage($this->page, $this->records_per_page);
                    $break_while = false;
                    $recordset_count = 0;

                    $rows = $this->db[0]->numRows();
                    $srow = (($this->page - 1) * $this->records_per_page) + 1;
                    do {
                        $arrGridData[] = $this->db[0]->record;
                        if ($this->use_paging && $recordset_count >= $this->records_per_page - 1)
                            $break_while = true;

                        $recordset_count++;
                    } while ($this->db[0]->nextRecord() && !$break_while);
                }
            } else {
                $arrGridData = array_values($this->db[0]->getRecordset());
                $rows = $this->db[0]->numRows();
            }

        	$res = $this->doEvent("on_loaded_data", array(&$this, &$arrGridData));

            $row_default_class = $this->parent[0]->frameworkCSS->getClass($this->framework_css["table"]["rows"]["def"]);
            foreach($arrGridData AS $rrow => $record)
            {
            	$this->db[0]->record = $record;

                $this->tpl[0]->set_var("row", $rrow);

                $res = $this->doEvent("on_load_row", array(&$this, $this->db[0], $rrow));

                /* Step 1: retrieve values (done in 2 steps due to events needs) */

                $keys = "";
                $row_properties = array();

                //$unicKey = $i;
                if (count($this->key_fields))
                {
                    // find global recordset corrispondency (if one)
                    $aKeys = array();
                    foreach($this->key_fields as $key => $FormField)
                    {
                        $this->key_fields[$key]->value = $this->db[0]->getField($this->key_fields[$key]->get_data_source(), $this->key_fields[$key]->base_type);
                        $aKeys[$key] = $this->key_fields[$key]->value->getValue(null, FF_SYSTEM_LOCALE);
                        $keys .= "keys[" . $this->key_fields[$key]->id . "]=" . $this->key_fields[$key]->value->getValue($this->key_fields[$key]->base_type, FF_SYSTEM_LOCALE) . "&";
                        //$unicKey .= $this->key_fields[$key]->value->getValue($this->key_fields[$key]->base_type, FF_SYSTEM_LOCALE);

                        $this->tpl[0]->set_var("Key_" . $key, $this->key_fields[$key]->getValue($this->key_fields[$key]->get_app_type(), $this->key_fields[$key]->get_locale()));
                        $this->tpl[0]->set_var("encoded_Key_" . $key, rawurlencode($this->key_fields[$key]->getValue($this->key_fields[$key]->get_app_type(), $this->key_fields[$key]->get_locale())));
                        if (strlen($this->key_fields[$key]->value->ori_value))
                        {
                            $this->tpl[0]->parse("SectSetKey" . $key, false);
                            $this->tpl[0]->set_var("SectNotSetKey" . $key, "");
                        }
                        else
                        {
                            $this->tpl[0]->set_var("SectSetKey" . $key, "");
                            $this->tpl[0]->parse("SectNotSetKey" . $key, false);
                        }
                    }
                    reset($this->key_fields);

                    $recordset_key = array_search($aKeys, $this->recordset_keys, true);
                    // if not exists, add new
                    if ($recordset_key === false)
                    {
                        $recordset_key = count($this->recordset_keys);
                        $this->recordset_keys[$recordset_key] = $aKeys;
                    }
                    $this->displayed_keys[$recordset_key] = $aKeys;


                    // display hidden key fields to managed displayed values properly
                    if ($this->use_fields_params)
                    {
                        foreach($this->key_fields as $key => $FormField)
                        {
                            $this->tpl[0]->set_var("id", "displayed_keys[" . $recordset_key . "][" . $this->key_fields[$key]->id . "]");
                            $this->tpl[0]->set_var("value",   ffCommon_specialchars($this->key_fields[$key]->value->getValue(null, FF_SYSTEM_LOCALE)));
                            $this->parse_hidden_field();
                        }
                        reset($this->key_fields);
                    }
                }

                $keys .= $this->parent[0]->get_keys($this->key_fields);

                foreach ($this->grid_fields as $key => $FormField)
                {
                    if ($this->use_fields_params && $this->grid_fields[$key]->control_type != "" && isset($this->recordset_values[$recordset_key][$key]))
                    {
                        $this->grid_fields[$key]->value = new ffData($this->recordset_values[$recordset_key][$key], $this->grid_fields[$key]->base_type, FF_SYSTEM_LOCALE);
                        if (isset($this->recordset_ori_values[$recordset_key][$key]))
                        {
                            $this->tpl[0]->set_var("id", "recordset_ori_values[" . $recordset_key . "][" . $this->grid_fields[$key]->id . "]");
                            $this->tpl[0]->set_var("value",   ffCommon_specialchars($this->recordset_ori_values[$recordset_key][$key]));
                            $this->parse_hidden_field();
                        }
                    }
                    else
                    {
                        switch ($this->grid_fields[$key]->data_type)
                        {
                            case "db":
                                $this->grid_fields[$key]->value = $this->db[0]->getField($this->grid_fields[$key]->get_data_source(), $this->grid_fields[$key]->base_type);
                                break;

                            case "callback":
                                $this->grid_fields[$key]->value = call_user_func($this->grid_fields[$key]->get_data_source(), $this->grid_fields, $key);
                                break;

                            default:
                                if (isset($this->recordset_values[$recordset_key][$key]))
                                    $this->grid_fields[$key]->value = new ffData($this->recordset_values[$recordset_key][$key], $this->grid_fields[$key]->base_type, FF_SYSTEM_LOCALE);
                                else
                                    $this->grid_fields[$key]->value = $this->grid_fields[$key]->getDefault(array(&$this));
                        }
                        if ($this->use_fields_params && $this->grid_fields[$key]->control_type != "")
                        {
                            $this->tpl[0]->set_var("id", "recordset_ori_values[" . $recordset_key . "][" . $this->grid_fields[$key]->id . "]");
                            $this->tpl[0]->set_var("value", ffCommon_specialchars($this->grid_fields[$key]->value->getValue($this->grid_fields[$key]->base_type, FF_SYSTEM_LOCALE)));
                            $this->parse_hidden_field();
                        }
                    }
                }
                reset($this->grid_fields);

				parent::processRow();

                /* Step 2: display values */

                // EVENT HANDLER
                $res = $this->doEvent("on_before_parse_row", array(&$this, $rrow));
                $rc = end($res);

                if ($rc === null)
                {


					/**
	                * Set Modify Delete And Confirm Delete Url
	                */
	                if (strlen($this->bt_edit_url))
	                {
	                    $modify_url["default"] = $this->bt_edit_url;
		                $modify_url["default"] = ffProcessTags($modify_url["default"], $this->key_fields, $this->grid_fields, "normal", $this->parent[0]->get_params(), $_SERVER['REQUEST_URI'], $this->parent[0]->get_globals(), null, $this->db[0]);
	                }
	                else
	                {
	                    $modify_url["ajax"] = $this->record_url . "?" . $keys .
	                                $this->parent[0]->get_globals() .
	                                $this->addit_record_param;

		                $modify_url["ajax"] = ffProcessTags($modify_url["ajax"], $this->key_fields, $this->grid_fields, "normal", $this->parent[0]->get_params(), $_SERVER['REQUEST_URI'], $this->parent[0]->get_globals(), null, $this->db[0]);

	  					if($this->cursor_dialog) {
	  						$modify_url["ajax"] .= "cursor[id]=" . rawurlencode($this->getIDIF()) . "&"
													. "cursor[rrow]=" . rawurlencode($srow + $rrow) . "&"
													. "cursor[rows]=" . rawurlencode($rows) . "&";
	  					}

	                    $modify_url["noajax"] = $modify_url["ajax"]; // . "ret_url=" . rawurlencode($this->parent[0]->getRequestUri());

	                    if($this->full_ajax || $this->ajax_edit)
                    		$modify_url["default"] = $modify_url["ajax"];
	                    else
                    		$modify_url["default"] = $modify_url["noajax"];
	                }

	                $cancelurl = $this->parent[0]->getRequestUri();
	                if (strlen($this->dialog_delete_url))
	                {
	                    $delete_url = ffProcessTags($this->dialog_delete_url, $this->key_fields, $this->grid_fields, "normal", $this->parent[0]->get_params(), $_SERVER['REQUEST_URI'], $this->parent[0]->get_globals(), null, $this->db[0]);
	                }
	                else if (strlen($this->record_delete_url))
	                {
	                    $confirmurl = $this->record_delete_url . "?" . $keys .
	                                    $this->parent[0]->get_globals() .
	                                    $this->addit_record_param .
	                                    $this->record_id . "_frmAction=confirmdelete"
	                                    /*. ($this->full_ajax || $this->ajax_delete
                                    		? ""
                                    		: "&ret_url=" . rawurlencode($this->parent[0]->getRequestUri())
	                                    )*/;

	                    $confirmurl = ffProcessTags($confirmurl, $this->key_fields, $this->grid_fields, "normal", $this->parent[0]->get_params(), $_SERVER['REQUEST_URI'], $this->parent[0]->get_globals(), null, $this->db[0]);

	                    $delete_url = $this->dialog(
	                                      true
	                                    , "yesno"
	                                    , $this->parent[0]->title
	                                    , $this->label_delete
	                                    , null// ($this->full_ajax || $this->ajax_delete ? "[CLOSEDIALOG]" : "" /*$cancelurl*/)
	                                    , $confirmurl
	                                    );
	                }
	                else
	                {
	                    if (strlen($this->bt_delete_url))
	                    {
	                        $confirmurl = $this->bt_delete_url;
	                    }
	                    else
	                    {
	                        $confirmurl = $this->record_url . "?" . $keys .
	                                    $this->parent[0]->get_globals() .
	                                    $this->addit_record_param .
	                                    $this->record_id . "_frmAction=confirmdelete"
	                                    /*. ($this->full_ajax || $this->ajax_delete
                                    		? ""
                                    		: "&ret_url=" . rawurlencode($this->parent[0]->getRequestUri())
	                                    )*/;
	                    }
	                    $confirmurl = ffProcessTags($confirmurl, $this->key_fields, $this->grid_fields, "normal", $this->parent[0]->get_params(), $_SERVER['REQUEST_URI'], $this->parent[0]->get_globals(), null, $this->db[0]);

	                    $delete_url = $this->dialog(
	                                                  true
	                                                , "yesno"
	                                                , $this->parent[0]->title
	                                                , $this->label_delete
	                                                , null //($this->full_ajax || $this->ajax_delete ? "[CLOSEDIALOG]" : "" /*$cancelurl*/)
	                                                , $confirmurl
	                                                );
	                }
                    $this->tpl[0]->set_var("keys", $keys); // Useful for Fixed Fields Templates


                    $row_class = array(
                        "base" => $row_default_class
                        , "custom" => $this->row_class
                    );
                    if($this->record_url)
                    {
                    	$row_class["editable"] = "clickable";
                    	if($this->full_ajax || $this->ajax_edit)
                    		$row_class["editable"] .= " ajax";
						if($this->record_target == true)
                    		$row_properties["data-target"] = "_blank";

                    	$row_properties["data-url"] = ffCommon_specialchars($modify_url["default"]);
                    }

					/**
					* Ser Row Class And Properties
					*/
                    if($this->framework_css["table"]["rows"]["oddeven"]) {
                        $row_class["oddeven"] = ($row_class["oddeven"] == "odd"
                            ? "even"
                            : "odd"
                        );
                    }

                    if($this->framework_css["table"]["rows"]["counter"]) {
                        $row_class["record"] = "row-" . ($rrow + 1);
                    }

                    /**
                    * Process Rows Cols Fields buttons
                    */
                   //print_r($this->grid_disposition_elem);
                   // print_r($this->grid_disposition);
                    if(is_array($this->grid_disposition) && count($this->grid_disposition))
                    {
                    	$buffer_col = "";
                    	if(count($this->grid_disposition) > 1) {
                    		$this->tpl[0]->set_var("row_init_start", '<td class="cel-1 mixed"><table><tbody>');
                    	}

                    	foreach($this->grid_disposition AS $row => $cols)
                    	{
							if(count($this->grid_disposition) > 1) {
                    			$this->tpl[0]->set_var("row_start", '<tr' . (isset($this->grid_disposition_elem["rows"][$row])
                    				? " " . $this->getProperties($this->grid_disposition_elem["rows"][$row])
                    				: ''
                    			)
                    			. '>');
							}
                    		if(is_array($cols) && count($cols))
                    		{
                    			foreach($cols AS $col => $grid_contents)
                    			{
                                    $this->parse_col($grid_contents, $recordset_key, $rrow, $modify_url, $keys, $delete_url, $col + 1, count($cols), $row + 1);
                    			}
                    		}

					        $this->tpl[0]->parse("SectRow", true);
					        $this->tpl[0]->set_var("SectCol", "");
						    $this->tpl[0]->set_var("row_start", "");
						    $this->tpl[0]->set_var("row_end",  "");

							if(count($this->grid_disposition) > 1) {
                    			$this->tpl[0]->set_var("row_end",  "</tr>");
							}
                    	}
						if(count($this->grid_disposition) > 1) {
						    if($last_button) {
							    $buffer_col = $this->parse_col($last_button, $recordset_key, $rrow, $modify_url, $keys, $delete_url, 2, 1, 1, true);
							    $this->tpl[0]->set_var("SectCol", "");
							}

							$this->tpl[0]->set_var("row_init_end", "</tbody></table></td>" . $buffer_col);
						}

                    }
                    else
                    {
	                    $col = 1;
	                    foreach ($this->grid_fields as $key => $FormField)
	                    {
	                        $this->parse_col($FormField, $recordset_key, $rrow, $modify_url, $keys, $delete_url, $col, $col_count);

	                        $col++;
	                    }
	                    reset($this->grid_fields);

	                    if (is_array($this->grid_buttons) && count($this->grid_buttons))
	                    {
	                        foreach($this->grid_buttons as $key => $FormButton)
	                        {
		                        $this->parse_col($FormButton, $recordset_key, $rrow, $modify_url, $keys, $delete_url, $col, $col_count);

		                        $col++;
	                        }
	                        reset($this->grid_buttons);
	                    }
				   		if($this->record_url && $this->display_edit_bt)
				   		{
				   			$this->parse_col("edit", $recordset_key, $rrow, $modify_url, $keys, $delete_url, $col, $col_count);

				   			$col++;
						}
				   		if($this->record_url && $this->display_delete_bt)
				   		{
				   			$this->parse_col("delete", $recordset_key, $rrow, $modify_url, $keys, $delete_url, $col, $col_count);

				   			$col++;
						}

				        $this->tpl[0]->parse("SectRow", true);
				        $this->tpl[0]->set_var("SectCol", "");
					}

                    //$this->tpl[0]->set_var("RowNumber", $rrow);
                    //$this->tpl[0]->set_var("RecordNumber", ($rrow + ($this->page - 1 ) * $this->records_per_page));


                    $res = $this->doEvent("on_before_parse_record", array(&$this));


			        $row_properties = array_replace($row_properties, (array) $this->row_properties);
			        $row_properties["class"] = implode(" " , array_filter($row_class));

			        $this->tpl[0]->set_var("row_properties", $this->getProperties($row_properties));

                    $rc = end($res);
                    if ($rc === null)
                        $this->tpl[0]->parse("SectRecord", true);

			        $this->tpl[0]->set_var("SectRow", "");
                }

                // EVENT HANDLER
                $res = $this->doEvent("on_after_parse_row", array(&$this, $rrow));
                $rc = end($res);
                if($rc === true)
                	break;

            }
        }
        else
        {
            $this->tpl[0]->set_var("SectRecord", "");
            $this->tpl[0]->set_var("SectHiddenOrder", "");
        }

		$this->process_labels($col_count);
        $this->process_before_after_table();


        // store value of fields in hidden section, but only for not displayed records

        if ($this->use_fields_params && is_array($this->recordset_keys) && count($this->recordset_keys))
        {
            // cycle records
            foreach ($this->recordset_keys as $rst_key => $rst_value)
            {
                $aKeys = array();
                // cycle keys
                foreach($this->key_fields as $key => $value)
                {
                    $this->tpl[0]->set_var("id", "recordset_keys[" . $rst_key . "][" . $key . "]");
                    $this->tpl[0]->set_var("value", ffCommon_specialchars($this->recordset_keys[$rst_key][$key]));
                    $this->parse_hidden_field();
                    $aKeys[$key] = $this->recordset_keys[$rst_key][$key];
                }
                reset($this->key_fields);

                $displayed = array_search($aKeys, $this->displayed_keys, true);
                // if not displayed, store hidden
                if ($displayed === false)
                {
                    // cycle fields
                    foreach($this->grid_fields as $key => $value)
                    {
                        if ($this->grid_fields[$key]->control_type !== "")
                        {
                            $this->tpl[0]->set_var("id", "recordset_ori_values[" . $rst_key . "][" . $key . "]");
                            $this->tpl[0]->set_var("value", ffCommon_specialchars($this->recordset_ori_values[$rst_key][$key]));
                            $this->parse_hidden_field();

                            $this->tpl[0]->set_var("id", "recordset_values[" . $rst_key . "][" . $key . "]");
                            $this->tpl[0]->set_var("value", ffCommon_specialchars($this->recordset_values[$rst_key][$key]));
                            $this->parse_hidden_field();
                        }
                    }
                    reset($this->grid_fields);
                }
            }
            reset($this->recordset_keys);
        }

        $res = $this->doEvent("on_after_process_grid", array(&$this, $this->tpl[0]));

        $component_class["default"] = $this->class;
        if($this->framework_css["component"]["grid"]) {
            $component_class["grid"] = $this->parent[0]->frameworkCSS->getClass($this->framework_css["component"]["grid"]);
        }
        if ($this->db[0]->query_id && $this->db[0]->numRows())
        {
        	$this->component_properties["data-record"] = $this->record_id;

            $this->tpl[0]->parse("SectGridData", false);
			$this->tpl[0]->parse("SectGridTable", false);
            $this->tpl[0]->parse("SectGrid", false);
            $this->tpl[0]->set_var("SectNoRecords", "");
        }
        else
        {
        	$component_class["empty"] = "padding " . $this->parent[0]->frameworkCSS->get("clear", "util");
        	$this->process_noRecord();
        }

		if($this->tpl[0]->isset_var("component_class")) {
		    $this->tpl[0]->set_var("component_class", implode(" " , array_filter($component_class)));
		} else {
			$this->component_properties["class"] = implode(" ", array_filter($component_class));
		}

		$this->tpl[0]->set_var("component_properties", $this->getProperties($this->component_properties));

        if($this->framework_css["outer_wrap"]) {
            $this->tpl[0]->set_var("outer_wrap_start", '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["outer_wrap"]) . '">');
            $this->tpl[0]->set_var("outer_wrap_end", '</div>');
        }

		if(is_array($this->framework_css["component"]["col"]) && $this->framework_css["component"]["inner_wrap"] === null)
			$this->framework_css["component"]["inner_wrap"] = array("row" => true);

		if($this->framework_css["component"]["inner_wrap"]) {
            $this->tpl[0]->set_var("inner_wrap_start", '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["component"]["inner_wrap"]) . '">');
            $this->tpl[0]->set_var("inner_wrap_end", '</div>');
        }
        if($this->framework_css["component"]["header_wrap"]
            && ($this->title || $this->description || $this->fixed_pre_content)
        ) {
            $this->tpl[0]->set_var("header_wrap_start", '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["component"]["header_wrap"]) . '">');
            $this->tpl[0]->set_var("header_wrap_end", '</div>');
        }
        if($this->framework_css["component"]["body_wrap"]) {
		    if(!$this->framework_css["component"]["header_wrap"] && ($this->title || $this->description || $this->fixed_pre_content)) {
                $this->tpl[0]->set_var("header_wrap_start", '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["component"]["body_wrap"]) . '">');
            } else {
                $this->tpl[0]->set_var("body_wrap_start", '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["component"]["body_wrap"]) . '">');
            }

            $this->tpl[0]->set_var("body_wrap_end", '</div>');
        }
        if($this->framework_css["component"]["footer_wrap"]
            && ($this->tpl[0]->isset_block("SectActionButtons"))
        ) {
            $this->tpl[0]->set_var("footer_wrap_start", '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["component"]["footer_wrap"]) . '">');
            $this->tpl[0]->set_var("footer_wrap_end", '</div>');
        }

    }

    function parse_field($field, $recordset_key, $modify_url, $keys, $hide_container = true, $display_label = false)
    {
	    if (!is_subclass_of($field, "ffField_base"))
	        ffErrorHandler::raise("Wrong Grid Field: must be a ffField", E_USER_ERROR, $this, get_defined_vars());

	    if ($field->display === false)
	        return false;


	    /**
	    * Set Field Label
	    */
		if(/*!$hide_container &&*/ $display_label && $field->display_label && strlen($field->label))
		{
			if($field->encode_label)
				$buffer_label_value = ffCommon_specialchars($field->label);
			else
				$buffer_label_value = $field->label;

			/**
			* Label Class and Properties
			*/
			$label_properties	= array();

			if($field->control_type != "")
				$label_properties["label_for"] = $this->getIDIF() . "_" . $field->id;

			$label_class = array();
			if(is_array($field->framework_css))
			{
				$arrColumnLabel = $field->framework_css["label"]["col"];
				$arrColumnControl = $field->framework_css["control"]["col"];

				$label_class["label"] = $this->parent[0]->frameworkCSS->get("label", "form");
			}

			if(is_array($arrColumnLabel) && count($arrColumnLabel)
				&& is_array($arrColumnControl) && count($arrColumnControl)
			) {
				$label_class["align"] = $this->parent[0]->frameworkCSS->get(array("text-overflow", "text-nowrap"), "util");
				if($this->framework_css["component"]["type"] == "inline") {
					$label_align = "right";
					$control_align = "left";
				} else {
					$label_align = "left";
					$control_align = "right";
				}
				$label_prefix = '<div class="' . $this->parent[0]->frameworkCSS->get($arrColumnLabel, "col") . " " . $this->parent[0]->frameworkCSS->get("align-" . $label_align, "util") . '">';
				$label_postfix = '</div>';

				$control_prefix = '<div class="' . $this->parent[0]->frameworkCSS->get($arrColumnControl, "col") . " " . $this->parent[0]->frameworkCSS->get("text-nowrap", "util") . " " . $this->parent[0]->frameworkCSS->get("align-" . $control_align, "util") . '">';
				$control_postfix = '</div>';
				//$type_label = "-inline";

				$label_set = true;
			}

			$label_properties["class"] = implode(" ", array_filter($label_class));

			$buffer_label = '<label ' . $field->getProperties($label_properties) . ' title="' . $buffer_label_value . '">' . $buffer_label_value . '</label>';
			$buffer_label_container = $label_prefix . $buffer_label . $label_postfix;

			//$label_set = true;
		}

	    /**
	    * Set Field Symbol
	    */
		if(strlen($this->symbol_valuta) && $field->app_type == "Currency")
			$buffer_symbol = $this->symbol_valuta;


		/**
	    * Set Field Data Info
	    */
		/*if($field->data_info["field"] !== null)
	    {
	        $data_info = $this->db[0]->getField($field->data_info["field"], $field->data_info["base_type"], true);
	        if(strlen($data_info))
	        {
	            if($field->data_info["multilang"])
	                $container_properties["title"] = ffTemplate::_get_word_by_code(strip_tags($this->db[0]->getField($field->data_info["field"], $field->data_info["base_type"], true)));
	            else
	                $container_properties["title"] = strip_tags($this->db[0]->getField($field->data_info["field"], $field->data_info["base_type"], true));
	        }
	    }*/


        /**
         * Set Field Value
         */
        if ($field->control_type === "")
        {
            $field->pre_process(true);
            $buffer_control_value = $field->fixed_pre_content . $field->getDisplayValue() . $field->fixed_post_content;
        }
        else
        {
            $field->framework_css["container"] = false;
            $field->display_label = false;
            $buffer_control_value = $field->process();
            $field->display_label = true;
        }

   		/**
	    * Set Field Control
	    */
	    $field_url = $this->parse_field_url($field, $modify_url, $keys);
		if($field_url)
		{
			$buffer_control = '<a href="' . $field_url . '">' . $buffer_symbol . $buffer_control_value . '</a>';
		} else {
			$buffer_control = $buffer_symbol . $buffer_control_value;
		}

		$buffer_control_container = $control_prefix . $buffer_control . $control_postfix;

		/**
		* Set Field Container
		*/
    	$container_properties =  $field->container_properties;

    	$container_class["base"] = "ffField";
	    $container_class["container"] = $field->container_class;
	    if($field->get_app_type() == "Text" && $field->extended_type != "String")
	        $container_class["type"] = strtolower($field->extended_type);
	    else
	        $container_class["type"] = strtolower($field->get_app_type());

		$buffer = $buffer_label_container . $buffer_control_container;
		if($hide_container) {
			if($label_set) {
				$tmp_class["grid"] = $this->parent[0]->frameworkCSS->get("row", "form");

				$buffer =  '<div class="' . $tmp_class["grid"] . '">' . $buffer . '</div>';
			}
		} else {
			if($label_set && is_array($field->framework_css["container"]["col"]) && count($field->framework_css["container"]["col"])) {
				$tmp_class["grid"] = $this->parent[0]->frameworkCSS->get("row", "form");

				$buffer =  '<div class="' . $tmp_class["grid"] . '">' . $buffer . '</div>';

				if(is_array($field->framework_css["container"]["col"])
					&& count($field->framework_css["container"]["col"])
				) {
					$container_class["grid"] = $this->parent[0]->frameworkCSS->get($field->framework_css["container"]["col"], "col");
				} elseif($field->framework_css["container"]["row"]) {
					$container_class["grid"] = $this->parent[0]->frameworkCSS->get("row", "form");
				}
			} elseif($label_set) {
				/*$container_class["grid"] = $this->parent[0]->frameworkCSS->get("row", "form");	*/
			} else {
				if(is_array($field->framework_css["container"]["col"]) && count($field->framework_css["container"]["col"])) {
					$container_class["grid"] = $this->parent[0]->frameworkCSS->get($field->framework_css["container"]["col"], "col");
				} elseif($field->framework_css["container"]["row"]) {
					//$container_class["grid"] = $this->parent[0]->frameworkCSS->get("row", "form");
				}
			}

			$tmp_properties = $container_properties;
			$tmp_properties["class"] = implode(" ", array_filter($container_class));

			$buffer = '<div ' . $field->getProperties($tmp_properties) . '>' . $buffer . '</div>';
		}

		/**
		* Parse Fixed Field Vars
		*/
		$this->tpl[0]->set_var("euro", $buffer_symbol);
		$this->tpl[0]->set_var($field->id . "_display_value", $buffer_control_value);
		$this->tpl[0]->set_var($field->id . "_value", $field->value->getValue());
		$this->tpl[0]->set_var("url_" . $field->id, ffCommon_url_rewrite($field->value->getValue()));
		$this->tpl[0]->set_var("url_" . $field->id . "_display_value", ffCommon_url_rewrite($buffer_control_value));
		$this->tpl[0]->set_var("ent_" . $field->id . "_display_value", ffCommon_specialchars($buffer_control_value));
		$this->tpl[0]->set_var("ent_" . $field->id . "_value", ffCommon_specialchars($field->value->getValue()));

		/**
		* Parse Field Sections
		*/
   		if ($this->tpl[0]->isset_var("Field_" . $field->id) === false && $this->tpl[0]->isset_var("EncodedField_" . $field->id) === false)
   		{
			$this->tpl[0]->set_var("Value", $buffer);
		    $this->tpl[0]->parse("SectGridContent", true);

		    $this->tpl[0]->set_var("Fvalue_" . $field->id, $buffer_control_value);
		    $this->tpl[0]->set_var("EncodedFvalue_" . $field->id, rawurlencode(ffCommon_url_normalize($buffer_control_value)));
		}
		else
		{
	        $this->tpl[0]->set_var("Field_" . $field->id . "_url", ffCommon_specialchars($field_url));
	        $this->tpl[0]->set_var("Field_" . $field->id, $buffer_control_value);
		    $this->tpl[0]->set_var("EncodedField_" . $field->id, rawurlencode(ffCommon_url_normalize($buffer_control_value)));
		}

		if (strlen($this->grid_fields[$field->id]->value->ori_value))
		{
		    $this->tpl[0]->parse("SectSetField_" . $field->id, false);
		    $this->tpl[0]->set_var("SectNotSetField_" . $field->id, "");
		}
		else
		{
		    $this->tpl[0]->set_var("SectSetField_" . $field->id, "");
		    $this->tpl[0]->parse("SectNotSetField_" . $field->id, false);
		}

		if ($this->grid_fields[$field->id]->extended_type == "Selection")
		{
		    $this->tpl[0]->set_regexp_var("/SectSet_" . $field->id . "_.+/", "");
		    $this->tpl[0]->parse("SectSet_" . $field->id . "_" . $this->grid_fields[$field->id]->value->getValue($this->grid_fields[$field->id]->base_type, FF_SYSTEM_LOCALE), false);
		}

		$this->tpl[0]->parse("Sect_" . $field->id, false);

		return array(
			"symbol" => $buffer_symbol
			, "control" => $buffer_control
			, "control_value" => $buffer_control_value
			, "label" => $buffer_label
			, "label_value" => $buffer_label_value
			, "container" => $buffer
			, "container_class" => ($hide_container ? $container_class : array())
			, "container_properties" => ($hide_container ? $container_properties : array())
		);
    }

	/**
	* Set Field Url
	*/
    function parse_field_url($oField, $modify_url, $keys)
    {
		$field_url = null;
		if ($oField->url === null)
		{
		    $oField->url_ajax = false;
		} elseif($oField->url === true) {
			$oField->url_ajax = $this->full_ajax || $this->ajax_edit;
			if($this->display_edit_url_alt) {
				$field_url = $this->display_edit_url_alt . "?" . $keys .
								$this->parent[0]->get_globals() .
								$this->addit_record_param;

				//if(!$oField->url_ajax)
				//	$field_url .= "ret_url=" . rawurlencode($this->parent[0]->getRequestUri());
			} else {
				if($oField->url_ajax)
					$field_url = $modify_url["ajax"];
				else
					$field_url = $modify_url["noajax"];
			}

			if($oField->url_ajax) {
				$this->load_dialog($this->record_id, $this->dialog_options["edit"]);
				$field_url = "javascript:ff.ffPage.dialog.doOp0en('" . $this->record_id . "', '" . ffCommon_specialchars($field_url) . "');";
			} else {
				$field_url = ffCommon_specialchars($field_url);
			}
		} elseif(strlen($oField->url)) {
			if($oField->url_ajax) {
				$this->load_dialog($this->record_id, $this->dialog_options["edit"]);
				$field_url = "javascript:ff.ffPage.dialog.doOpen('" . $this->record_id . "', '" . ffCommon_specialchars(ffProcessTags($oField->url, $this->key_fields, $this->grid_fields, "normal", $this->parent[0]->get_params(), $_SERVER['REQUEST_URI'], $this->parent[0]->get_globals(), null, $this->db[0])) . "');";
			} else {
				$field_url = ffCommon_specialchars(ffProcessTags($oField->url, $this->key_fields, $this->grid_fields, "normal", $this->parent[0]->get_params(), $_SERVER['REQUEST_URI'], $this->parent[0]->get_globals(), null, $this->db[0]));
			}
		}
		$oField->url_parsed = $field_url;
		return $field_url;
    }
    function parse_button($button, $recordset_key, $rrow, $url, $hide_container = true)
    {
		/**
		* Set Button Class
		*/
    	$container_class["base"] = "ffButton";

	    /**
		* Parse Button Section
		*/
	    if(is_object($button) && is_subclass_of($button, "ffButton_base"))
	    {
			/**
			* Set Button Class And Properties
			*/
			$container_class["container"] = $button->container_class;
    		$container_properties =  $button->container_properties;

		    if(!is_array($button->class)) {
		    	/*if(!$hide_container)
		    		$container_class["custom"] = $button->class;

			    $button->class = array(
	                "value" => ($hide_container ? $button->class : implode(" ", array_filter($container_class)))
	                , "params" => array("strict" => true)
			    );*/

			    $button->class = array(
	                "value" => $button->class
	                , "params" => array("strict" => true)
			    );
			}

		    $buffer = $button->process(null
		                                , false
		                                , $button->id . "_" . $rrow
		                            );

		} elseif($button == "edit" || $button == "delete") {
			if($this->buttons_options[$button]["icon"] === null)
			    $this->buttons_options[$button]["icon"] = $this->parent[0]->frameworkCSS->get($button . "row", "icon-" . $this->buttons_options[$button]["aspect"] . "-tag");

			if($this->buttons_options[$button]["class"] === null)
			    $this->buttons_options[$button]["class"] = $button . "row";

 			if ($this->full_ajax || ($button == "edit" && $this->ajax_edit) || ($button == "delete" && $this->ajax_delete))
		    {
				$buffer = "<a " . (strlen($this->buttons_options[$button]["class"])
		                                                    ? "class=\"" . $this->buttons_options[$button]["class"] . "\" "
		                                                    : ""
		                                                )
		                                                . "href=\"javascript:ff.ffPage.dialog.doOpen('" . $this->record_id . "', '" . rawurlencode($url) . "');\">"
		                                                . $this->buttons_options[$button]["icon"] . $this->buttons_options[$button]["label"]
		                                            . "</a>";
			}
			else
			{
				$buffer = "<a " . (strlen($this->buttons_options[$button]["class"])
		                                                    ? "class=\"" . $this->buttons_options[$button]["class"] . "\" "
		                                                    : ""
		                                                )
                                                        . "href=\"javascript:ff.ffPage.goToWithRetUrl('" . rawurlencode($url) . "');\">"
		                                               // . "href=\"" . $url . "\">"
		                                                . $this->buttons_options[$button]["icon"] . $this->buttons_options[$button]["label"]
		                                            . "</a>";
			}
		}

		if($buffer) {
            $this->tpl[0]->set_var("Value", $buffer);
			$this->tpl[0]->parse("SectGridContent", true);
		}

		return array(
			"container" => $buffer
			, "container_class" => $container_class
			, "container_properties" => ($hide_container ? $container_properties : array())
		);
    }

    function parse_col($grid_contents, $recordset_key, $rrow, $modify_url, $keys, $delete_url, $col, $col_count, $row = 1, $output_buffer = false)
    {
    	//$this->tpl[0]->set_var("SectCol", "");
		/**
		* set Col Class
		*/
		$col_class = array(
		    "base" => $this->parent[0]->frameworkCSS->getClass($this->framework_css["table"]["cell"]["def"])
		    , "custom" => $this->column_class
        );

/*
		if ($col == 1 && $this->column_class_first)
		    $col_class["first"]         = $this->column_class_first;
		elseif ($col == $col_count && $this->column_class_last)
		    $col_class["last"]          = $this->column_class_last;
*/
        if($this->framework_css["table"]["cell"]["first"] && $col == 1) {
            $col_class["first"]         = $this->parent[0]->frameworkCSS->getClass($this->framework_css["table"]["cell"]["first"]);
        }

        if($this->framework_css["table"]["cell"]["last"] && $col == $col_count) {
            $col_class["last"]          = $this->parent[0]->frameworkCSS->getClass($this->framework_css["table"]["cell"]["last"]);
        }

        if($this->framework_css["table"]["cell"]["counter"]) {
		    $col_class["cell"]          = "cel-" . ($rrow + 1) . "-" . $col;
        }

        if($row > 1) {
            $col_class["hcel"]          = "hcel-" . ($row) . "-" . $col;
        }

		/**
		* Set Grid Content
		*/

		if(is_array($grid_contents))
		{
			if(is_array($grid_contents) && count($grid_contents))
			{
				foreach($grid_contents AS $key => $params)
				{
					$res = null;

					if($params["type"] == "field")
						$res = $this->parse_field($this->grid_fields[$key], $recordset_key, $modify_url, $keys, ($this->grid_disposition_elem["data"][$row - 1 ][$col - 1]["field"] > 1 && count($this->grid_disposition_elem["data"]) == 1 ? false : true), ($row > 1 ? true : false/*!$this->grid_fields[$key]->allow_order*/));
					elseif($params["type"] == "button") {
						if(isset($this->grid_buttons[$key]))
							$res = $this->parse_button($this->grid_buttons[$key], $recordset_key, $rrow, $modify_url["default"], ($this->grid_disposition_elem["data"][$row - 1 ][$col - 1 ]["button"] > 1 && count($this->grid_disposition_elem["data"]) == 1 ? false : true));
						elseif($key == "edit" && $this->record_url && $this->display_edit_bt)
							$res = $this->parse_button($key, $recordset_key, $rrow, $modify_url["default"], ($this->grid_disposition_elem["data"][$row - 1 ][$col - 1 ]["button"] > 1 && count($this->grid_disposition_elem["data"]) == 1 ? false : true));
						elseif($key == "delete" && $this->record_url && $this->display_delete_bt)
							$res = $this->parse_button($key, $recordset_key, $rrow, $delete_url, ($this->grid_disposition_elem["data"][$row - 1 ][$col - 1 ]["button"] > 1 && count($this->grid_disposition_elem["data"]) == 1 ? false : true));

					}

					$col_class["cell"] = str_replace("[ID]", $key, $col_class["cell"]);
					if(is_array($res)) {
					//	$col_class = array_replace($col_class, $res["container_class"]);
						$col_properties = $res["container_properties"];
					}
				}
			}
		}
		elseif (is_object($grid_contents) && is_subclass_of($grid_contents, "ffField_base"))
		{
			$field = $this->parse_field($grid_contents, $recordset_key, $modify_url, $keys);

			//$col_class = array_replace($col_class, $field["container_class"]);
			$col_properties = $field["container_properties"];
		}
		elseif (is_object($grid_contents) &&  is_subclass_of($grid_contents, "ffButton_base"))
		{
			$button = $this->parse_button($grid_contents, $recordset_key, $rrow, $modify_url["default"]);
			//$col_class = array_replace($col_class, $button["container_class"]);
			$col_properties = $button["container_properties"];
		}
		elseif($grid_contents == "edit") {
			$button = $this->parse_button($grid_contents, $recordset_key, $rrow, $modify_url["default"]);

			//$col_class = array_replace($col_class, $button["container_class"]);
			$col_properties = $button["container_properties"];
		}
		elseif($grid_contents == "delete") {
			$button = $this->parse_button($grid_contents, $recordset_key, $rrow, $delete_url);

			//$col_class = array_replace($col_class, $button["container_class"]);
			$col_properties = $button["container_properties"];
		}

		if($col == 1 && count($this->grid_disposition_elem["data"]) > 1) {
			$colspan = max($this->grid_disposition_elem["count"]) - $col_count;
			if($colspan)
				$col_properties["colspan"] = $colspan + 1;
		}
		/**
		* Parse Col Vars
		*/
		$this->tpl[0]->set_var("col", $col); // Useful for Fixed Fields Templates
		if($this->tpl[0]->isset_var("col_class")) {
			$this->tpl[0]->set_var("col_class", implode(" " , array_filter($col_class)));
		} elseif(count(array_filter($col_class))) {
			$col_properties["class"] = implode(" ", array_filter($col_class));
		}

		$this->tpl[0]->set_var("col_properties", $this->getProperties($col_properties));
		$this->tpl[0]->parse("SectColStart", false);
		$this->tpl[0]->parse("SectColEnd", false);

		if($output_buffer)
		{
			$buffer = $this->tpl[0]->rpparse("SectCol", false);
		}
		else
		{
			$this->tpl[0]->parse("SectCol", true);
		}

		$this->tpl[0]->set_var("SectGridContent", "");
		$this->tpl[0]->set_var("SectColStart", "");
		$this->tpl[0]->set_var("SectColEnd", "");

		return $buffer;
    }

    function parse_field_label($field, $col_class, $hide_container = true)
    {
        $buffer_icon = "";
        $container_class = array();
        $container_properties = $field->container_properties;
		/**
		*  Set Label
		*/
     	if($field->display_label) {
			if ($field->encode_label)
			    $buffer_label_value = ffCommon_specialchars($field->label);
			else
			    $buffer_label_value = $field->label;
		}

		/**
		*  Set Order
		*/
 		if ($this->order_method != "none" && $field->allow_order)
		{
			if ($this->order == $field->id) {
				if ($this->direction == "ASC")
				        $direction = "ASC";
				    else
				        $direction = "DESC";
			} else {
				$direction = $field->order_dir;
			}

            if($field->display_label /*&& $this->order_method*/ && $buffer_label_value)
            {
                if ($this->order_default == $field->id) {
                    $container_properties["aria-sort"] = strtolower($direction) == "asc" ? "ascending" : "descending";
                    $container_class["sort"] = $this->parent[0]->frameworkCSS->getClass($this->framework_css["sort"][$direction]);
                    $container_class["current"] = $this->parent[0]->frameworkCSS->get("current", "util", $this->label_selected_class);
                    $sort_icon = $this->framework_css["sort"]["icon"][$direction];
                } else {
                    $container_class["sort"] = $this->parent[0]->frameworkCSS->getClass($this->framework_css["sort"]["sortable"]);
                    $sort_icon = $this->framework_css["sort"]["icon"]["sortable"];
                }

                $buffer_label = ($this->order_method == "labels" || $this->order_method == "both"
                        ? $buffer_label_value
                        : ""
                    )
                    . ($sort_icon && ($this->order_method == "icons" || $this->order_method == "both")
                        ? $this->parent[0]->frameworkCSS->get($sort_icon, "icon-link-tag")
                        : ""
                    );

                $container_properties["onclick"] = "ff.ffGrid.ajaxOrder(this, '" . $this->getIDIF() . "', '" . $field->id . "'"
                    . ($_REQUEST["XHR_CTX_ID"]
                        ? ", '" . $_REQUEST["XHR_CTX_ID"] . "'"
                        : ""
                    ) . ");";


            }

          /*
			if ($field->display_label && ($this->order_method == "labels" || $this->order_method == "both"))
			{
                $buffer_label = "<a href=\"javascript:void(0);\" "
                			. "onclick=\"ff.ffGrid.ajaxOrder('" .
                				$this->getIDIF() . "', '" .
                				$field->id . "', undefined"
                				. ($_REQUEST["XHR_CTX_ID"]
                					? ", '" . $_REQUEST["XHR_CTX_ID"] . "'"
                					: ""
                				) . ");\">" . $buffer_label_value . "</a>";
			}

			if ($this->order_method == "icons" || $this->order_method == "both")
			{
                $rev_direction = (strtoupper($direction) == "ASC"
                                    ? "DESC"
                                    : "ASC"
                                );
                $buffer_icon = "<a href=\"javascript:void(0);\" "
                				. "onclick=\"ff.ffGrid.ajaxOrder('" .
                					$this->getIDIF() . "', '" .
                					$field->id . "', '" . $rev_direction . "'"
                				. ($_REQUEST["XHR_CTX_ID"]
                					? ", '" . $_REQUEST["XHR_CTX_ID"] . "'"
                					: ""
                				) . ");\""
                				. ($this->order_default == $field->id
                					? " class=\"" .$this->parent[0]->frameworkCSS->get("current", "util", $this->label_selected_class)  . "\""
                					: ""
                				) . ">" .
                					$this->parent[0]->frameworkCSS->get("sort" . ($this->order_default == $field->id ? "-" . strtolower($direction) : ""), "icon-link-tag")
                			. "</a>";
			}*/
		} elseif($hide_container || !$field->display_label)
			$buffer_label = $buffer_label_value;


		/**
		* Set Field Select All
		*/
        if ($field->get_control_type() == "checkbox" && $field->display_label && !isset($field->properties["disabled"])) {
	        $buffer_select = "<input type=\"checkbox\" onclick=\"this.value = ff.ffGrid.turnToggle('" . $this->getIDIF() . "', '" . $field->id . "', this.value);\" value=\"0\" />";
		}


		/**
		* Set Field Container
		*/
		$container_class["base"] = "ffField";
	    if($field->get_app_type() == "Text" && $field->extended_type != "String")
	        $container_class["type"] = strtolower($field->extended_type);
	    else
	        $container_class["type"] = strtolower($field->get_app_type());

		if ($this->order == $field->id)
            $container_class["current"] = $this->parent[0]->frameworkCSS->get("current", "util", $this->label_selected_class);

        /*if($field->width) {
            $container_properties["width"] = $field->width;
        }

	    if($this->tpl[0]->isset_var("col_class")) {
	        $this->tpl[0]->set_var("col_class", implode(" " , array_filter($col_class)));
	    }*/

		$buffer = $buffer_icon . $buffer_label . $buffer_select;



		if(!$hide_container) {
			$tmp_properties = $container_properties;
			$tmp_properties["class"] = implode(" ", array_filter($container_class));

			$buffer = '<div ' . $field->getProperties($tmp_properties) . '>' . $buffer . '</div>';
		}

        if (!$this->use_fixed_fields) {
            $this->tpl[0]->set_var("Label", $buffer);
            $this->tpl[0]->parse("SectGridLabel", true);
		} else {
			$this->tpl[0]->set_var("Label", $buffer_icon . $buffer_label . $buffer_select);
            $this->tpl[0]->parse("SectGridLabel" . $field->id, false);
		}





		return array(
			"icon" => $buffer_icon
			, "select" => $buffer_select
			, "label" => $buffer_label
			, "label_value" => $buffer_label_value
			, "container" => $buffer
			, "container_class" => ($hide_container ? $container_class : array())
			, "container_properties" => ($hide_container ? $container_properties : array())
		);
    }

    function parse_col_label($grid_contents, $col, $col_count, $row = 1)
    {
    	//$this->tpl[0]->set_var("SectCol", "");
		/**
		* set Col Class
		*/
        $col_class = array(
            "grid" => $this->parent[0]->frameworkCSS->getClass($this->framework_css["table"]["cols"]["def"])
            , "custom" => $this->label_class
        );

		/*if ($col == 1 && $this->column_class_first)
		    $col_class["first"] = $this->column_class_first;
		elseif ($col == $col_count && $this->column_class_last)
		    $col_class["last"] = $this->column_class_last;

		$col_class["cell"] = "cel" . ($row > 1 ? "-" . $row : "") . "-" . $col;*/


        if($this->framework_css["table"]["cols"]["first"] && $col == 1) {
            $col_class["first"]         = $this->parent[0]->frameworkCSS->getClass($this->framework_css["table"]["cols"]["first"]);
        }

        if($this->framework_css["table"]["cols"]["last"] && $col == $col_count) {
            $col_class["last"]          = $this->parent[0]->frameworkCSS->getClass($this->framework_css["table"]["cols"]["last"]);
        }

        if($this->framework_css["table"]["cols"]["counter"]) {
            $col_class["cell"]          = "hcel-" . ($row > 1 ? $row . "-" : "") . $col;
        }

		//$col_class["wrap"]              = $this->parent[0]->frameworkCSS->get("text-nowrap", "util");
		/**
		* Set Class And Properties by Grid Content Type
		*/

		if(is_array($grid_contents))
		{
			if(is_array($grid_contents) && count($grid_contents))
			{
				foreach($grid_contents AS $key => $params)
				{
					$res = null;
					if($params["type"] == "field") {
						$res = $this->parse_field_label($this->grid_fields[$key], $col_class, ($this->grid_disposition_elem["data"][$row - 1][$col - 1]["field"] > 1 ? true : true));
					} elseif($params["type"] == "button") {
						$res["container_class"]["base"] = "ffButton";
						$res["container_properties"] = array();
					}

					if(is_array($res)) {
						$col_class = array_replace($col_class, $res["container_class"]);
						$col_properties = $res["container_properties"];
					}
				}
			}
		}
		elseif (is_object($grid_contents) && is_subclass_of($grid_contents, "ffField_base"))
		{
			$field = $this->parse_field_label($grid_contents, $col_class);

			$col_class = array_replace($col_class, $field["container_class"]);
			$col_properties = $field["container_properties"];
		}
		elseif (is_object($grid_contents) &&  is_subclass_of($grid_contents, "ffButton_base"))
		{
			$col_class["base"] = "ffButton";
		}
		elseif($grid_contents == "edit") {
			$col_class["base"] = "ffButton";
			$col_class["default"] = "edit";
		}
		elseif($grid_contents == "delete") {
			$col_class["base"] = "ffButton";
			$col_class["default"] = "delete";
		}




		/**
		* Parse Col Vars
		*/
		$this->tpl[0]->set_var("col", $col); // Useful for Fixed Fields Templates
		if($this->tpl[0]->isset_var("col_class")) {
			$this->tpl[0]->set_var("col_class", implode(" " , array_filter($col_class)));
		} else {
			$col_properties["class"] = implode(" " , array_filter($col_class));
		}

		$this->tpl[0]->set_var("col_properties", $this->getProperties($col_properties));


		$this->tpl[0]->parse("SectColLabelStart", false);
		$this->tpl[0]->parse("SectColLabelEnd", false);
		$this->tpl[0]->parse("SectColLabel", true);
		$this->tpl[0]->set_var("SectGridLabel", "");
    }
    /**
     *  Elabora le label della griglia
     */
    function process_labels($col_count = 0)
    {
        if (!$this->display_labels)
        {
            $this->tpl[0]->set_var("SectLabels", "");
            return;
        }

   /*     if (isset($_REQUEST["XHR_CTX_ID"]))
            $this->tpl[0]->set_var("dialogid", "'" . $_REQUEST["XHR_CTX_ID"] . "'");
        else
            $this->tpl[0]->set_var("dialogid", "undefined");*/

       // $this->tpl[0]->set_var("turn_on_label", ffCommon_specialchars($this->turn_on_label));
       // $this->tpl[0]->set_var("turn_off_label", ffCommon_specialchars($this->turn_off_label));

       // $tot_labels = 0;
       // $tot_labels += (is_array($this->grid_buttons) ? count($this->grid_buttons) : 0);
       // $tot_labels += (is_array($this->grid_fields) ? count($this->grid_fields) : 0);

		if(is_array($this->grid_disposition) && count($this->grid_disposition))
        {
            foreach($this->grid_disposition AS $row => $cols)
            {
                if(is_array($cols) && count($cols))
                {
                    foreach($cols AS $col => $grid_contents)
                    {
                        $this->parse_col_label($grid_contents, $col + 1, count($cols), $row + 1);
                    }
                }

            }
        }
        else
        {
	        $col = 1;
	        foreach ($this->grid_fields as $key => $FormField)
	        {
	            $this->parse_col_label($FormField, $col, $col_count);

	            $col++;
	        }
	        reset($this->grid_fields);

	        if (is_array($this->grid_buttons) && count($this->grid_buttons))
	        {
	            foreach($this->grid_buttons as $key => $FormButton)
	            {
		            $this->parse_col_label($FormButton, $col, $col_count);

		            $col++;
	            }
	            reset($this->grid_buttons);
	        }
			if($this->record_url && $this->display_edit_bt)
			{
				$this->parse_col_label("edit", $col, $col_count);

				$col++;
			}
			if($this->record_url && $this->display_delete_bt)
			{
				$this->parse_col_label("delete", $col, $col_count);

				$col++;
			}
        }

		$this->tpl[0]->parse("SectLabels", false);
    }
    function process_before_after_table() {
        if($this->use_paging || $this->use_search) {
            $this->tpl[0]->parse("SectBeforeTable", false);
        }

        if($this->use_paging) {
            $this->tpl[0]->parse("SectAfterTable", false);

        }


    }
    /**
     * Elabora il page navigator
     */
    function process_navigator()
    {
        $this->navigator[0]->parent[0] = $this;

        $this->navigator[0]->page = $this->page;
        $this->navigator[0]->records_per_page = $this->records_per_page;
        $this->navigator[0]->nav_selector_elements = $this->nav_selector_elements;
        $this->navigator[0]->PagePerFrame = $this->page_per_frame;


        if ($this->db[0]->query_id)
            $this->navigator[0]->num_rows = $this->db[0]->numRows();

        if (!$this->display_navigator || !$this->use_paging || ($this->navigator[0]->num_rows <= $this->navigator[0]->records_per_page && !($this->ajax_search || $this->full_ajax)))
        {
            $this->tpl[0]->set_var("SectHiddenPageNavigator", "");
            $this->tpl[0]->set_var("SectPageNavigator", "");
            $this->tpl[0]->set_var("SectPaginatorTop", "");
            $this->tpl[0]->set_var("SectPaginatorBottom", "");
            return;
        }
        $this->navigator[0]->doAjax = $this->navigator_doAjax;
        $this->navigator[0]->nav_display_selector = $this->navigator_display_selector;
        $this->tpl[0]->set_var("page_parname", $this->navigator[0]->page_parname);
        $this->tpl[0]->set_var("records_per_page_parname", $this->navigator[0]->records_per_page_parname);
        $this->tpl[0]->set_var("page_per_frame_parname", $this->navigator[0]->page_per_frame_parname);

        $this->tpl[0]->set_var("page_per_frame", $this->navigator[0]->PagePerFrame);

        /*if($this->navigator[0]->num_rows >  $this->navigator[0]->records_per_page)
        {*/

        if($this->tpl[0]->isset_var("PageNavigator")) {
            $this->tpl[0]->set_var("PageNavigator", $this->navigator[0]->process());
        }
        if($this->tpl[0]->isset_var("PageNavigator.selector")) {
            $navigator_selector = $this->navigator[0]->process("selector");

        }
        if($this->tpl[0]->isset_var("PageNavigator.choice")) {
            $navigator_choice = $this->navigator[0]->process("choice");
        }
        if($this->tpl[0]->isset_var("PageNavigator.totelem")) {
            $navigator_totelem = $this->navigator[0]->process("totelem");
        }
        if($this->tpl[0]->isset_var("PageNavigator.nav")) {
            $navigator_nav = $this->navigator[0]->process("nav");
        }

        //$this->tpl[0]->parse("SectPageNavigator", false);
        if ($this->navigator_orientation == "both" || $this->navigator_orientation == "top")
        {
            $this->tpl[0]->set_var("PageNavigator.selector", ($navigator_selector && $this->framework_css["navigatorTop"]["selector"]
                ? '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["navigatorTop"]["selector"]) . '">' . $navigator_selector . '</div>'
                : $navigator_selector
            ));
            $this->tpl[0]->set_var("PageNavigator.choice", ($navigator_choice && $this->framework_css["navigatorTop"]["choice"]
                ? '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["navigatorTop"]["choice"]) . '">' . $navigator_choice . '</div>'
                : $navigator_selector
            ));
            $this->tpl[0]->set_var("PageNavigator.totelem", ($navigator_totelem && $this->framework_css["navigatorTop"]["totelem"]
                ? '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["navigatorTop"]["totelem"]) . '">' . $navigator_totelem . '</div>'
                : $navigator_totelem
            ));
            $this->tpl[0]->set_var("PageNavigator.nav", ($navigator_nav && $this->framework_css["navigatorTop"]["nav"]
                ? '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["navigatorTop"]["nav"]) . '">' . $navigator_nav . '</div>'
                : $navigator_nav
            ));

            $this->tpl[0]->parse("SectPaginatorTop", false);
		} //else
          //  $this->tpl[0]->set_var("SectPaginatorTop", "");

        if ($this->navigator_orientation == "both" || $this->navigator_orientation == "bottom")
        {
            $this->tpl[0]->set_var("PageNavigator.selector", ($navigator_selector && $this->framework_css["navigatorBottom"]["selector"]
                ? '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["navigatorBottom"]["selector"]) . '">' . $navigator_selector . '</div>'
                : $navigator_selector
            ));
            $this->tpl[0]->set_var("PageNavigator.choice", ($navigator_choice && $this->framework_css["navigatorBottom"]["choice"]
                ? '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["navigatorBottom"]["choice"]) . '">' . $navigator_choice . '</div>'
                : $navigator_choice
            ));
            $this->tpl[0]->set_var("PageNavigator.totelem", ($navigator_totelem && $this->framework_css["navigatorBottom"]["totelem"]
                ? '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["navigatorBottom"]["totelem"]) . '">' . $navigator_totelem . '</div>'
                : $navigator_totelem
            ));
            $this->tpl[0]->set_var("PageNavigator.nav", ($navigator_nav && $this->framework_css["navigatorBottom"]["nav"]
                ? '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["navigatorBottom"]["nav"]) . '">' . $navigator_nav . '</div>'
                : $navigator_nav
            ));

            $this->tpl[0]->parse("SectPaginatorBottom", false);
		}// else
        //	$this->tpl[0]->set_var("SectPaginatorBottom", "");
        //}
        $this->tpl[0]->parse("SectHiddenPageNavigator", false);
    }
    function process_noRecord() {
        $this->tpl[0]->set_var("norecord_class", $this->parent[0]->frameworkCSS->getClass($this->framework_css["norecord"]["def"]));
        if($this->framework_css["norecord"]["wrap"]) {
            $this->tpl[0]->set_var("norecord_wrap_start", '<div class="' . $this->parent[0]->frameworkCSS->getClass($this->framework_css["norecord"]["wrap"]) . '">');
            $this->tpl[0]->set_var("norecord_wrap_end", '</div>');
        }
        $this->tpl[0]->set_var("SectGridData", "");
        $this->tpl[0]->set_var("SectGridTable", "");
        $this->tpl[0]->parse("SectGrid", false);
        //$this->tpl[0]->set_var("SectAlpha", "");
        //$this->tpl[0]->set_var("SectFilter", "");
        //$this->tpl[0]->set_var("SectSearch", "");
        if ($this->no_record_label !== null)
        {
            $this->tpl[0]->set_var("grid_no_record", $this->no_record_label);
        }
        else
        {
            $this->tpl[0]->set_var("grid_no_record", ffTemplate::_get_word_by_code("grid_no_record"));
        }

        $this->tpl[0]->parse("SectNoRecords", false);
    }
	/**
	*  Load Widget Dialog for Edit and Delete
	*/
    function load_dialog($name = null, $params = null)
    {
		static $dialog_loaded = array();

		if($name === null)
			$name = $this->record_id;

		if(array_key_exists($this->getIDIF() . "_" . $name, $dialog_loaded))
			return;

		if($params === null)
			$params = array(
				"title" 				=> ffTemplate::_get_word_by_code("ffGrid_dialog_title") . " " . $this->title
				, "class" 				=> null
				, "width" 				=> null
				, "height" 				=> null
				, "type" 				=> null
			);

		if(!count($dialog_loaded))
			$this->parent[0]->widgetLoad("dialog");

		$this->parent[0]->widgets["dialog"]->process(
			$name
			, array(
		            "title"          	=> $params["title"]
					, "tpl_id"        	=> $this->getIDIF()
					, "width"        	=> $params["width"]
					, "height"        	=> $params["height"]
					, "dialogClass"     => $params["class"]
					, "type"			=> $params["type"]
				)
			, $this->parent[0]
		);
    }


    /**
     * Inizializza i controlli di default della griglia
     */
    function initControls()
    {
        // PREPARE DEFAULT BUTTONS
        if ($this->buttons_options["search"]["display"])
        {
            //if($this->buttons_options["search"]["label"] === null) //RICHIESTA DEL GIOVINE
             //   $this->buttons_options["search"]["label"] = ffTemplate::_get_word_by_code("ffGrid_search");

            if ($this->buttons_options["search"]["obj"] !== null)
            {
                $this->addSearchButton(   $this->buttons_options["search"]["obj"]
                                        , $this->buttons_options["search"]["index"]);
            }
            else
            {
                $tmp = ffButton::factory(null, $this->disk_path, $this->site_path, $this->page_path, $this->getTheme());
                $tmp->id            = "search";
                $tmp->label         = $this->buttons_options["search"]["label"];
                $tmp->class         = "ffSearch " . $this->buttons_options["search"]["class"];
                $tmp->icon          = $this->buttons_options["search"]["icon"];
                $tmp->aspect        = $this->buttons_options["search"]["aspect"];
                $tmp->action_type   = "submit";
                $tmp->frmAction     = "search";
                $tmp->framework_css["addon"] = "postfix";
                $tmp->framework_css["aspect"] = $this->framework_css["search"]["button"];


                if (isset($_REQUEST["XHR_CTX_ID"]))
                {
                    $tmp->jsaction = ($this->reset_page_on_search ? " jQuery('#" . $this->getPrefix() . $this->navigator[0]->page_parname . "').val('1'); " : "") /*. ($this->open_adv_search === true ? "" : " ff.ffGrid.advsearchHide('" . $this->getIDIF() . "'); ")*/ . " ff.ajax.ctxDoRequest('" . $_REQUEST["XHR_CTX_ID"] . "',{'action'    : '" . $this->getIDIF() . "_search','component' : '" . $this->getIDIF() . "','section'    : 'GridData'});";
                }
                elseif ($this->full_ajax || $this->ajax_search)
                {
                    $this->parent[0]->tplAddJs("ff.ajax");

                    $tmp->jsaction = "ff.ffGrid.searchHistoryPush('" . $this->getIDIF() . "_" . $this->search_simple_field_options["id"] . "'); " . ($this->reset_page_on_search ? " jQuery('#" . $this->getPrefix() . $this->navigator[0]->page_parname . "').val('1'); " : "")  /*. ($this->open_adv_search === true ? "" : " ff.ffGrid.advsearchHide('" . $this->getIDIF() . "'); ")*/ . " ff.ajax.doRequest({'component' : '" . $this->getIDIF() . "','section' : 'GridData'});";
                }
                $this->addSearchButton(   $tmp
                                        , $this->buttons_options["search"]["index"]);
            }
        }

        if ($this->buttons_options["export"]["display"])
        {
            if($this->buttons_options["export"]["label"] === null)
                $this->buttons_options["export"]["label"] = ffTemplate::_get_word_by_code("ffGrid_export");

            if ($this->buttons_options["export"]["obj"] !== null)
            {
                $this->addActionButtonHeader($this->buttons_options["export"]["obj"]);
            }
            else
            {
                $tmp = ffButton::factory(null, $this->disk_path, $this->site_path, $this->page_path, $this->getTheme());
                $tmp->id            = "export";
                $tmp->label         = $this->buttons_options["export"]["label"];
                $tmp->class         = $this->buttons_options["export"]["class"];
                $tmp->icon          = $this->buttons_options["export"]["icon"];
                $tmp->aspect        = $this->buttons_options["export"]["aspect"];
                $tmp->action_type   = "submit";
                $tmp->frmAction     = "export";
                //$tmp->aspect         = "link";
                //$tmp->action_type     = "gotourl";
                //$tmp->form_action_url = $this->parent[0]->getRequestUri() . "&" . $this->getIDIF() . "_t=xls";
                //$tmp->jsaction = "ff.ajax.doRequest({'component' : '" . $this->getIDIF() . "', 'addFields' : '" . $this->getIDIF() . "t=xls'});";
                //$tmp->class         .= "noactivebuttons";
                //$tmp->url = $this->parent[0]->getRequestUri() . "&" . $this->getIDIF() . "_t=xls";
                $this->addActionButtonHeader($tmp);
            }
        }
    }

	public function structProcess($tpl)
    {
		$rc = 0;

        if ($this->ajax_update_all)
        {
			$rc++;
            $tpl->set_var("prop_name",    "update_all");
            $tpl->set_var("prop_value",    "true");
            $tpl->parse("SectFFObjProperty",    true);
        }

		if ($this->id_if !== null)
		{
			$rc++;
            $tpl->set_var("prop_name",    "factory_id");
            $tpl->set_var("prop_value",   '"' . $this->id . '"');
            $tpl->parse("SectFFObjProperty",    true);
		}

		return $rc;
    }

	function setWidthComponent($resolution_large_to_small)
	{
        if(is_array($resolution_large_to_small) || is_numeric($resolution_large_to_small)) {
            $this->framework_css["outer_wrap"]["col"] = frameworkCSS::setResolution($resolution_large_to_small);
        } elseif(strlen($resolution_large_to_small)) {
            $this->framework_css["outer_wrap"]["row"] = $resolution_large_to_small;
        }
	}
	
	function setWidthDialog($width, $action = null) 
	{
		if(is_numeric($width))
			$prop = "width";
		else {
			$prop = "class";
			$width = $this->parent[0]->frameworkCSS->get("window-" . $width, "dialog");
		}
		if($action) {
			$this->dialog_options[$action][$prop] 	= $width;
		} else {
			$this->dialog_options["addnew"][$prop] 	= $width;
			$this->dialog_options["edit"][$prop] 	= $width;
			$this->dialog_options["delete"][$prop] 	= $width;
		}
	}
	function setTitleDialog($title, $action = null) 
	{
		if($action) {
			$this->dialog_options[$action]["title"] 	= $title;
		} else {
			$this->dialog_options["addnew"]["title"] 	= ffTemplate::_get_word_by_code("addnew") . ": " . $title;
			$this->dialog_options["edit"]["title"] 		= ffTemplate::_get_word_by_code("modify") . ": " . $title;
			$this->dialog_options["delete"]["title"] 	= ffTemplate::_get_word_by_code("delete") . ": " . $title;
		}
	}
	function setTitle($title, $class = null) 
	{
		$this->framework_css["title"]["class"] = $class;
		$this->title = $title;
	}
}
