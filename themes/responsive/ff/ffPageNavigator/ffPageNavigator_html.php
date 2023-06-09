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
											"component" => array(
												"class" => "pageNavigator"
												, "pagination" => "align-center"
											)
											, "pagination" => array(
                                               "def" => array(
                                                   "class" => null
                                                    /*, "col" => array(
                                                            "xs" => 12
                                                            , "sm" => 10
                                                            , "md" => 12
                                                            , "lg" => 6
                                                    )*/
                                                )
                                                , "page" => array(
                                                    "class" => null
                                                    , "pagination" => "page"
                                                )
                                                , "page-link" => array(
                                                    "class" => null
                                                    , "pagination" => "page-link"
                                                )
                                                , "menu" => array(
                                                    "class" => null
                                                    , "pagination" => "pages"
                                                )
                                                , "icons" => array(
                                                    "first" => "first"
                                                    , "prev" => "&laquo;"
                                                    , "next" => "&raquo;"
                                                    , "last" => "last"
                                                    , "prevframe" => "prev-frame"
                                                    , "nextframe" => "next-frame"
                                                )
											)
											, "choice" => array(
											    "def" => array(
                                                    "class" => "mt-1"
                                                )
                                                , "wrap" => array(
                                                    "form" => "group-sm"
                                                )
                                                , "input" => array(
                                                    "class" => null
                                                    , "form" => array("control", "size-sm")
                                                )
												/*, "col" => array(
														"xs" => 0
														, "sm" => 0
														, "md" => 5
														, "lg" => 2
												)*/
											)
											, "totelem" => array(
												"class" => "lead mt-1"
												/*, "col" => array(
														"xs" => 0
														, "sm" => 2
														, "md" => 3
														, "lg" => 2
												)*/
											)
											, "perPage" => array(
											    "def" => array(
                                                    "class" => null
                                                    /*, "col" => array(
                                                            "xs" => 0
                                                            , "sm" => 0
                                                            , "md" => 4
                                                            , "lg" => 2
                                                    )*/
                                                )
                                                , "wrap" => array(
                                                    "form" => "group-sm"
                                                )
                                                , "select" => array(
                                                    "class" => null
                                                    , "form" => array("control", "size-sm")
                                                )
											)

	), "ffPageNavigator");


class ffPageNavigator_html extends ffPageNavigator_base
{
    const MAX_RECORD                    = 100;
    const MAX_PAGINATION                = 10;

	var $framework_css					= null;

	var $id_if                          = null;
	var $prefix                         = null;
	var $tpl_processed                  = false;
	/**
	 * Determina se le azioni devono essere eseguite con richieste Ajax
	 * @var Boolean
	 */
	var $doAjax = true;

    function __construct($disk_path, $site_path, $page_path, $theme, ffPage_html $page = null)
    {
        parent::__construct($disk_path, $site_path, $page_path, $theme, $page);

        $this->framework_css = frameworkCSS::findComponent("ffPageNavigator");
    }

	function getIDIF()
	{
		if ($this->id_if !== null)
			return $this->id_if;
		else
			return $this->id;
	}

	function getPrefix($tmp = null)
	{
		if($this->prefix === null) {
			if($tmp === null)
				$tmp = $this->getIDIF();

			if (strlen($tmp))
				return $tmp . "_";
		} else {
			return $this->prefix;
		}
	}

	var $url = null;
    var $callback = "null";
    var $callback_params = "{}";
    var $infinite = false;

	/**
	 * Carica il template nell'oggetto $tpl
	 */
	public function tplLoad()
	{
        $this->tpl[0] = $this->oPage[0]->loadTemplate(pathinfo($this->template_file, PATHINFO_FILENAME));
		//$this->tpl[0] = ffTemplate::factory($this->getTemplateDir());
		//$this->tpl[0]->load_file($this->template_file, "main");

        if($this->id !== null)
            $id = $this->id;
		elseif ($this->parent !== NULL && strlen($this->parent[0]->id))
            $id = $this->parent[0]->id;

        $this->tpl[0]->set_var("XHRcomponent", $id);
        $this->tpl[0]->set_var("prefix", $this->getPrefix($id));

		$this->tpl[0]->set_var("site_path", $this->site_path);
		$this->tpl[0]->set_var("page_path", $this->page_path);
		$this->tpl[0]->set_var("theme", $this->getTheme());

		$this->tpl[0]->set_var("form_action", $this->form_action);
		$this->tpl[0]->set_var("form_name", $this->form_name);

		if (is_array($this->fixed_vars) && count($this->fixed_vars))
		{
			foreach ($this->fixed_vars as $key => $value)
			{
				$this->tpl[0]->set_var($key, $value);
			}
			reset($this->fixed_vars);
		}

		return $id;
	}



	/**
	 * Esegue il parsing del template
	 * @param Boolean $output_result se true visualizza a video il risultato del processing, se false restituisce il contenuto del processing
	 * @return Mixed può essere string o true, a seconda di output_result
	 */
	public function tplParse($section)
	{
        switch ($section) {
            case "selector":
                $section = "SectSelector";
                break;
            case "choice":
                $section = "SectChoice";
                break;
            case "totelem":
                $section = "SectTotElem";
                break;
            case "nav":
                $section = "SectNav";
                break;
            default:
                $output_result = $section;
                $section = "main";
                if ($this->parent === NULL)
                {
                    $this->process_headers();
                    $this->process_footers();
                }
        }

		// determina se è stand-alone o attaccato ad una page/componente
        if ($output_result)
		{
			return ($this->tpl[0]->isset_block($section)
                ? $this->tpl[0]->pparse($section, false)
                : false
            );
		}
		else
		{
			return ($this->tpl[0]->isset_block($section)
                ? $this->tpl[0]->rpparse($section, false)
                : null
            );
		}
	}

	private function tplProcess() {
	    if($this->tpl_processed) {
	        return;
        }

        $id_component = $this->tplLoad();
        $navigator_class["default"] = $id_component . "-pn";
        $pageparname = $this->getPrefix($id_component) . $this->page_parname;
        $current_class = $this->oPage[0]->frameworkCSS->get("current", "pagination");
        $hidden_class = $this->oPage[0]->frameworkCSS->get("hide", "util");
        $page_class = $this->oPage[0]->frameworkCSS->getClass($this->framework_css["pagination"]["page"]);
        $page_link_class = $this->oPage[0]->frameworkCSS->getClass($this->framework_css["pagination"]["page-link"]);

        $loader_class = $this->oPage[0]->frameworkCSS->get("spinner", "icon", "spin");
        $totpage = ceil($this->num_rows / $this->records_per_page);

        $navigator_properties["page"] = 'data-page="' . $this->page . '"';

        if ($this->infinite) {
            if(is_bool($this->infinite))
                $this->infinite = "next";

            $this->with_totelem = false;
            $this->with_choice = false;
            $this->display_first = false;
            $this->display_prev = ($this->infinite === "prev" && $this->page > 1 ? true : false);
            $this->display_next = ($this->infinite === "next" && (!$totpage || $this->page != $totpage) ? true : false);
            $this->display_last = false;
            $this->with_frames = false;

            $this->tpl[0]->set_var("infinite", "true");
            $this->tpl[0]->set_var("SectNoInfinite", "");
        } else {
            if ($this->page > $totpage)
                $this->page = $totpage;

            $this->tpl[0]->set_var("records_per_page_parname", $this->records_per_page_parname);
            $this->tpl[0]->set_var("selected_records_per_page", $this->records_per_page);
            $this->tpl[0]->set_var("page_per_frame", $this->PagePerFrame);

            $navigator_properties["totrec"] = 'data-totrec="' . $this->num_rows . '"';

            $this->tpl[0]->set_var("infinite", "false");
            $this->tpl[0]->parse("SectNoInfinite", false);
        }

        if ($this->page < 1)
            $this->page = 1;

        if($this->infinite)
            $navigator_class["default"] .= "-" . $this->page . " " . $this->infinite;

        if ($this->doAjax)
            $this->tpl[0]->set_var("doAjax", "true");
        else
            $this->tpl[0]->set_var("doAjax", "false");

        $this->tpl[0]->set_var("callback", $this->callback);
        $this->tpl[0]->set_var("callback_params", $this->callback_params);

        $this->tpl[0]->set_var("component_class", $this->oPage[0]->frameworkCSS->getClass($this->framework_css["component"]));
        $this->tpl[0]->set_var("component_properties", implode(" ", $navigator_properties));
        $this->tpl[0]->set_var("page_parname", $this->page_parname);
        $this->tpl[0]->set_var("current_class", $current_class);
        $this->tpl[0]->set_var("hidden_class", $hidden_class);
        $this->tpl[0]->set_var("page_item_class", $page_class);
        $this->tpl[0]->set_var("page_link_class", $page_link_class);

        $this->tpl[0]->set_var("current_page", $this->page);
        $this->tpl[0]->set_var("totrec", $this->num_rows);


        //$this->tpl[0]->set_var("loader_class", $loader_class);
/*
        if(!$this->with_totelem) {
            if(is_array($this->framework_css["pagination"]["def"]["col"]) && count($this->framework_css["pagination"]["def"]["col"])) {
                foreach($this->framework_css["pagination"]["def"]["col"] AS $col_key => $col_value) {
                    $this->framework_css["pagination"]["def"]["col"][$col_key] = $this->framework_css["pagination"]["def"]["col"][$col_key] + $this->framework_css["totelem"]["col"][$col_key];
                    if($this->framework_css["pagination"]["def"]["col"][$col_key] > 12)
                        $this->framework_css["pagination"]["def"]["col"][$col_key] = 12;
                }
            }

            //$this->tpl[0]->set_var("SectTotElem", "");
        }
*/
/*
        if(!$totpage || !$this->with_choice)
        {
            if(is_array($this->framework_css["pagination"]["def"]["col"]) && count($this->framework_css["pagination"]["def"]["col"])) {
                foreach($this->framework_css["pagination"]["def"]["col"] AS $col_key => $col_value) {
                    $this->framework_css["pagination"]["def"]["col"][$col_key] = $this->framework_css["pagination"]["def"]["col"][$col_key] + $this->framework_css["choice"]["col"][$col_key];
                    if($this->framework_css["pagination"]["def"]["col"][$col_key] > 12)
                        $this->framework_css["pagination"]["def"]["col"][$col_key] = 12;
                }
            }
        }
*/
        $this->process_selector($navigator_class); // do at last so variables have the correct values

        if(1 || $totpage > 1)
        {
            $this->tpl[0]->set_var("page_class", ($page_class ? ' class="' . $page_class . '"' : ''));

            if($this->with_choice)
            {
                $choice_class = $navigator_class;
                $choice_class[] = "choice";
                if($totpage <= $this::MAX_PAGINATION) {
                    $choice_class[] = $hidden_class;
                }
                //$choice_class["default"] = "choice";
                //$choice_class["pages"] = $this->oPage[0]->frameworkCSS->get("pages", "pagination");
                $this->tpl[0]->set_var("choice_class", $this->oPage[0]->frameworkCSS->getClass($this->framework_css["choice"]["def"], $choice_class));

                $buffer_choice_label = ffTemplate::_get_word_by_code("page");
                $buffer_choice_tot_page = ffTemplate::_get_word_by_code("of") . '&nbsp;<span class="totpage">' . $totpage . '</span>';
                if(is_array($this->framework_css["choice"]["wrap"])) {
                    $this->tpl[0]->set_var("choice_wrap_start", '<div class="' . $this->oPage[0]->frameworkCSS->getClass($this->framework_css["choice"]["wrap"]) . '">');
                    $this->tpl[0]->set_var("choice_wrap_end", '</div>');

                    $buffer_choice_label = '<span class="' . $this->oPage[0]->frameworkCSS->get("control-prefix", "form") . '"><span class="' . $this->oPage[0]->frameworkCSS->get("control-text", "form") . '">' . $buffer_choice_label . '</span></span>';
                    $buffer_choice_tot_page = '<span class="' . $this->oPage[0]->frameworkCSS->get("control-postfix", "form") . '"><span class="' . $this->oPage[0]->frameworkCSS->get("control-text", "form") . '">' . $buffer_choice_tot_page . '</span></span>';

                    $wrap_addon = $this->oPage[0]->frameworkCSS->get("wrap-addon", "form");
                    if($wrap_addon) {
                        $buffer_choice_label = '<div class="' . $this->oPage[0]->frameworkCSS->get(array(3), "col") . '">' . $buffer_choice_label . '</div>';
                        $buffer_choice_tot_page = '<div class="' . $this->oPage[0]->frameworkCSS->get(array(5), "col") . '">' . $buffer_choice_tot_page . '</div>';
                        $this->tpl[0]->set_var("choice_input_box_class", $this->oPage[0]->frameworkCSS->get(array(4), "col"));
                        $this->tpl[0]->parse("SectChoiceInputStart", false);
                        $this->tpl[0]->parse("SectChoiceInputEnd", false);
                    }
                } else {
                    $choice_tag = ($this->framework_css["choice"]["wrap"]
                        ? $this->framework_css["choice"]["wrap"]
                        : "label"
                    );
                    $this->tpl[0]->set_var("choice_wrap_start", '<' . $choice_tag . '>');
                    $this->tpl[0]->set_var("choice_wrap_end", '</' . $choice_tag . '>');
                }

                $this->tpl[0]->set_var("current_page", $this->page);
                $this->tpl[0]->set_var("choice_input_class", $this->oPage[0]->frameworkCSS->getClass($this->framework_css["choice"]["input"], array("currentpage")));
                $this->tpl[0]->set_var("choice_label", $buffer_choice_label);
                $this->tpl[0]->set_var("choice_tot_page", $buffer_choice_tot_page);

                $this->tpl[0]->parse("SectChoice", false);
            }
            if($this->display_first && $totpage > $this->PagePerFrame)
            {
                //$containerClass = array();
                //$containerClass[] = $arrows_class;
                //if($this->page <= 2)
                //	$containerClass[] = $hidden_class;

                //if(count($containerClass))
                //	$this->tpl[0]->set_var("first_arrows_class", ' class="' . implode(" " , $containerClass) . '"');

                $this->tpl[0]->set_var("url", ffUpdateQueryString($pageparname, false, $this->url));
                $this->tpl[0]->set_var("first_class", ($page_link_class ? $page_link_class . " " : "") . $this->oPage[0]->frameworkCSS->get($this->framework_css["pagination"]["icons"]["first"], "icon"));
                //$this->tpl[0]->set_var("first_icon", $this->oPage[0]->frameworkCSS->get("nav_first", "ico-link-tag"));
                $this->tpl[0]->parse("SectFirstButton", false);
            }

            if($this->display_prev)
            {
                //$containerClass = array();
                //$containerClass[] = $arrows_class;
                //if($this->page == 1)
                //	$containerClass[] = $hidden_class;

                //if(count($containerClass))
                //	$this->tpl[0]->set_var("prev_arrows_class", ' class="' . implode(" " , $containerClass) . '"');

                $this->tpl[0]->set_var("url", ffUpdateQueryString($pageparname, ($this->page == 1 ? $totpage : ($this->page) == 2 ? false :  $this->page - 1), $this->url));

                if($this->infinite)
                    $this->tpl[0]->set_var("prev_class", $loader_class . " prev");
                else
                    $this->tpl[0]->set_var("prev_class", ($page_link_class ? $page_link_class . " " : ""). "prev");
                $this->tpl[0]->set_var("prev_icon", $this->oPage[0]->frameworkCSS->get($this->framework_css["pagination"]["icons"]["prev"], "icon-tag"));
                $this->tpl[0]->parse("SectPrevButton", false);
            }

            if($this->display_next)
            {
                //$page_inject = "pinject";
                //$containerClass = array();
                //$containerClass[] = $arrows_class;
                //if($this->page == $totpage)
                //	$containerClass[] = $hidden_class;

                if($this->infinite) {
                    $this->tpl[0]->set_var("next_class", $loader_class . " next");
                } else {
                    //	$containerClass[] = $page_inject;

                    $this->tpl[0]->set_var("next_class", ($page_link_class ? $page_link_class . " " : "") . "next");
                }
                //if(count($containerClass))
                //	$this->tpl[0]->set_var("next_arrows_class", ' class="' . implode(" " , $containerClass) . '"');

                $this->tpl[0]->set_var("url", ffUpdateQueryString($pageparname, ($this->page == $totpage ? false : $this->page + 1), $this->url));

                $this->tpl[0]->set_var("next_icon", $this->oPage[0]->frameworkCSS->get($this->framework_css["pagination"]["icons"]["next"], "icon-tag"));
                $this->tpl[0]->parse("SectNextButton", false);
            }

            if($this->display_last && $totpage > $this->PagePerFrame)
            {
                //$containerClass = array();
                //$containerClass[] = $arrows_class;
                //if($totpage - $this->page <= 2)
                //	$containerClass[] = $hidden_class;

                /*if(!$page_inject) {
                    $page_inject = "pinject";
                    $containerClass[] = $page_inject;
                }*/

                //if(count($containerClass))
                //	$this->tpl[0]->set_var("last_arrows_class", ' class="' . implode(" " , $containerClass) . '"');

                $this->tpl[0]->set_var("url", ffUpdateQueryString($pageparname, $totpage, $this->url));
                $this->tpl[0]->set_var("last_class", ($page_link_class ? $page_link_class . " " : "") . $this->oPage[0]->frameworkCSS->get($this->framework_css["pagination"]["icons"]["last"], "icon"));
                //$this->tpl[0]->set_var("last_icon", $this->oPage[0]->frameworkCSS->get("nav_last", "ico-link-tag"));
                $this->tpl[0]->parse("SectLastButton", false);
            }

            if ($this->with_frames && $totpage > $this->PagePerFrame)
            {
                //$containerClass = array();
                //$containerClass[] = $arrows_class;
                //if($this->page == 1)
                //	$containerClass[] = $hidden_class;

                //if(count($containerClass))
                //	$this->tpl[0]->set_var("first_frame_arrows_class", ' class="' . implode(" " , $containerClass) . '"');

                $this->tpl[0]->set_var("prevframe_class", ($page_link_class ? $page_link_class . " " : "") . $this->oPage[0]->frameworkCSS->get($this->framework_css["pagination"]["icons"]["prevframe"], "icon"));
                $this->tpl[0]->parse("SectPrevFrameButton", false);

                //$containerClass = array();
                //$containerClass[] = $arrows_class;
                //if($totpage == $this->page)
                //	$containerClass[] = $hidden_class;

                //if(!$page_inject) {
                //	$page_inject = "pinject";
                //	$containerClass[] = $page_inject;
                //}

                //if(count($containerClass))
                //	$this->tpl[0]->set_var("last_frame_arrows_class", ' class="' . implode(" " , $containerClass) . '"');

                $this->tpl[0]->set_var("nextframe_class", ($page_link_class ? $page_link_class . " " : "") . $this->oPage[0]->frameworkCSS->get($this->framework_css["pagination"]["icons"]["nextframe"], "icon"));
                $this->tpl[0]->parse("SectNextFrameButton", false);
            }


            if(!$this->infinite)
            {
                //if($totpage > 1)

                if ($totpage > $this->PagePerFrame) {
                    $start_page = $this->page - floor($this->PagePerFrame / 2);
                    if ($start_page < 1)
                        $start_page = 1;

                    $end_page = $start_page + $this->PagePerFrame - 1;
                    if ($end_page > $totpage)
                        $end_page = $totpage;

                    $start_page = $end_page - $this->PagePerFrame + 1;
                } else {
                    $start_page = 1;
                    $end_page = $totpage;
                }

                if($end_page > $start_page) {
                    $lastNum = ceil(($end_page - $start_page) / $this->PagePerFrame);

                    $start = ($start_page - $lastNum > 0
                        ? $start_page - $lastNum
                        : $start_page
                    );
                    $end = ($this->page < $totpage - $lastNum
                        ? $end_page - $lastNum
                        : $end_page
                    );

                    $step = floor($start_page / $lastNum) - 1;
                    if($start != $start_page) {
                        for($i = 1; $i <= $lastNum; $i++)
                        {
                            $value = $step * $i;
                            if($totpage >= $value) {
                                if($value == $this->page) {
                                    $this->tpl[0]->set_var("page_class", ' class="' . ($page_class ? $page_class . " " : "") . $current_class . '"');
                                } else {
                                    $this->tpl[0]->set_var("page_class", ($page_class ? ' class="' . $page_class . '"' : ''));
                                }
                                $this->tpl[0]->set_var("page_link_class", ($page_link_class ? $page_link_class . " ": "") . "page");
                                $this->tpl[0]->set_var("url", ffUpdateQueryString($pageparname, $value, $this->url));
                                $this->tpl[0]->set_var("num_page", $value);
                                $this->tpl[0]->parse("SectPageButton", true);
                            }
                        }
                    }


                    for ($i = $start; $i <= $end; $i++) {
                        if($i == $this->page) {
                            $this->tpl[0]->set_var("page_class", ' class="' . ($page_class ? $page_class . " " : "") . $current_class . '"');
                        } else {
                            $this->tpl[0]->set_var("page_class", ($page_class ? ' class="' . $page_class . '"' : ''));
                        }
                        $this->tpl[0]->set_var("page_link_class", ($page_link_class ? $page_link_class . " ": "") . "page");
                        $this->tpl[0]->set_var("url", ffUpdateQueryString($pageparname, ($i > 1 ? $i : false), $this->url));
                        $this->tpl[0]->set_var("num_page", $i);
                        $this->tpl[0]->parse("SectPageButton", true);
                    }
                    if($end != $end_page)
                    {
                        $step = floor(($totpage - ($end_page - $lastNum)) / $lastNum);
                        for($i = 1; $i <= $lastNum; $i++)
                        {
                            $value = ($end_page - $lastNum) + ($i * $step);
                            if($totpage >= $value) {
                                if($value == $this->page) {
                                    $this->tpl[0]->set_var("page_class", ' class="' . ($page_class ? $page_class . " " : "") . $current_class . '"');
                                } else {
                                    $this->tpl[0]->set_var("page_class", ($page_class ? ' class="' . $page_class . '"' : ''));
                                }
                                $this->tpl[0]->set_var("page_link_class", ($page_link_class ? $page_link_class . " ": "") . "page");
                                $this->tpl[0]->set_var("url", ffUpdateQueryString($pageparname, $value, $this->url));
                                $this->tpl[0]->set_var("num_page", $value);
                                $this->tpl[0]->parse("SectPageButton", true);
                            }
                        }
                    }

                }
            }

            $pages_class = $navigator_class;
            $pages_class[] = "pages";
            if($totpage > $this::MAX_PAGINATION) {
                $choice_class[] = $hidden_class;
            }
            $this->tpl[0]->set_var("pagination_class", $this->oPage[0]->frameworkCSS->getClass($this->framework_css["pagination"]["def"], $pages_class));
            $this->tpl[0]->set_var("pagination_menu_class", $this->oPage[0]->frameworkCSS->getClass($this->framework_css["pagination"]["menu"]));
            $this->tpl[0]->parse("SectNav", false);
        } /*else {
            if(is_array($this->framework_css["totelem"]["col"]) && count($this->framework_css["totelem"]["col"])) {
                $this->framework_css["totelem"] = array(
                    "col" => array(
                        "xs" => 12
                    , "sm" => 12
                    , "md" => 12
                    , "lg" => 12
                    )
                , "util" => "align-right"
                );
            }
        }*/

        if($this->with_totelem) {
            $totelem_class = $navigator_class;
            $totelem_class[] = "totelem";

            //$totelem_class["pages"] = $this->oPage[0]->frameworkCSS->get("pages", "pagination");
            $this->tpl[0]->set_var("totelem_class", $this->oPage[0]->frameworkCSS->getClass($this->framework_css["totelem"], $totelem_class ));
            $this->tpl[0]->set_var("totelem", $this->num_rows);
            $this->tpl[0]->parse("SectTotElem", false);
        }
    }


	function process_headers($stand_alone = false)
	{
		if($this->oPage !== NULL)
			$this->oPage[0]->tplAddJs("ff.ffPageNavigator");

		if (!isset($this->tpl[0]))
			return;

		if ($this->parent === NULL)
			$this->tpl[0]->parse("SectHeaders", false);
		else
		{
			return $this->tpl[0]->rpparse("SectHeaders", false);
		}
	}

	function process_footers($stand_alone = false)
	{
		if (!isset($this->tpl[0]))
			return;

		if ($this->parent === NULL)
			$this->tpl[0]->parse("SectFooters", false);
		else
		{
			return $this->tpl[0]->rpparse("SectFooters", false);
		}
	}

	/**
	 * process è la funzione di elaborazione principale dell'oggetto
	 * @param Boolean $output_result se true visualizza a video il risultato del processing, se false restituisce il contenuto del processing
	 * @return Mixed può essere string o true, a seconda di output_result
	 */
	function process($section = FALSE)
	{
        $output_result = false;

        switch ($section) {
            case "selector":
                $this->nav_display_selector = true;
                break;
            case "choice":
                $this->with_choice = true;
                break;
            case "totelem":
                $this->with_totelem = true;
                break;
            default:
        }

		$this->tplProcess();

		return $this->tplParse($section);
	}

	/**
	 * Elabora la parte di selezione degli elementi totali e dell'input di selezione della pagina
	 */
	function process_selector($navigator_class)
	{
	    $count_selector = 0;
		if ($this->nav_display_selector && count($this->nav_selector_elements))
		{
            $this->tpl[0]->set_var("perpage_option_class", $this->oPage[0]->frameworkCSS->getClass($this->framework_css["perPage"]["select"], array("rec-page")));

            $current_selector_isset = false;
            $this->nav_selector_elements = array(
                floor($this->records_per_page / 2)
                , $this->records_per_page
            );

            if($this->records_per_page * 2 < $this->num_rows) {
                $this->nav_selector_elements[] = $this->records_per_page * 2;
            }

			foreach ($this->nav_selector_elements AS $value)
			{
               // if($this->num_rows >= $value) {
                    if(!$current_selector_isset && $value >= $this->records_per_page) {
                       // $this->tpl[0]->set_var("rec_per_page_class", ' class="' . $current_class . '"');
                        $this->tpl[0]->set_var("rec_per_page_class", ' selected="selected"');
                        $current_selector_isset = true;
                    } else {
                        $this->tpl[0]->set_var("rec_per_page_class", "");
                    }                
				    $this->tpl[0]->set_var("records_per_page", $value);
                   // $this->tpl[0]->set_var("records_per_page_class", "rec-x-page-" . $value);
				    $this->tpl[0]->parse("SectSelectorPage", true);
                    $count_selector++;
               // }
			}
			reset($this->nav_selector_elements);
		}

        if($this->nav_selector_elements_all && $this->num_rows <= $this::MAX_RECORD) {
            if(!$current_selector_isset && $this->records_per_page >= $this->num_rows) {
                //$this->tpl[0]->set_var("rec_per_page_class", ' class="' . $current_class . '"');
                $this->tpl[0]->set_var("rec_per_page_class", ' selected="selected"');
            } else {
                $this->tpl[0]->set_var("rec_per_page_class", "");
            }
            $this->tpl[0]->set_var("totelem", $this->num_rows);
            //$this->tpl[0]->set_var("records_per_page_all_class", "rec-x-page-all");
            $this->tpl[0]->parse("SectSelectorPageAll", false);
            $count_selector++;
        }

        if($count_selector > 0) {
		    $perpage_class = $navigator_class;
		    $perpage_class[] = "perPage";
        	//$perpage_class["default"] = "perPage";
        	//$perpage_class["pages"] = $this->oPage[0]->frameworkCSS->get("pages", "pagination");



        	$this->tpl[0]->set_var("perpage_class", $this->oPage[0]->frameworkCSS->getClass($this->framework_css["perPage"]["def"], $perpage_class));

            $buffer_perpage_label = ffTemplate::_get_word_by_code("show");
            $buffer_perpage_items = ""; //ffTemplate::_get_word_by_code("items");
        	if(is_array($this->framework_css["perPage"]["wrap"])) {
                $this->tpl[0]->set_var("perpage_wrap_start", '<div class="' . $this->oPage[0]->frameworkCSS->getClass($this->framework_css["perPage"]["wrap"]) . '">');
                $this->tpl[0]->set_var("perpage_wrap_end", '</div>');

                $buffer_perpage_label = '<div class="' . $this->oPage[0]->frameworkCSS->get("control-prefix", "form") . '"><span class="' . $this->oPage[0]->frameworkCSS->get("control-text", "form") . '">' . $buffer_perpage_label . '</span></div>';
                if($buffer_perpage_items) {
                    $buffer_perpage_items = '<div class="' . $this->oPage[0]->frameworkCSS->get("control-postfix", "form") . '"><span class="' . $this->oPage[0]->frameworkCSS->get("control-text", "form") . '">' . $buffer_perpage_items . '</span></div>';
                }
                $wrap_addon = $this->oPage[0]->frameworkCSS->get("wrap-addon", "form");
                if ($wrap_addon) {
                    if ($buffer_perpage_label) {
                        $buffer_perpage_label = '<div class="' . $this->oPage[0]->frameworkCSS->get(array(3), "col") . '">' . $buffer_perpage_label . '</div>';
                    }
                    if ($buffer_perpage_items) {
                        $buffer_perpage_items = '<div class="' . $this->oPage[0]->frameworkCSS->get(array(5), "col") . '">' . $buffer_perpage_items . '</div>';
                    }
                    $this->tpl[0]->set_var("perpage_input_box_class", $this->oPage[0]->frameworkCSS->get(array(4), "col"));
                    $this->tpl[0]->parse("SectSelectorInputStart", false);
                    $this->tpl[0]->parse("SectSelectorInputEnd", false);
                }
            } else {
                $perpage_tag = ($this->framework_css["perPage"]["wrap"]
                    ? $this->framework_css["perPage"]["wrap"]
                    : "label"
                );
                $this->tpl[0]->set_var("perpage_wrap_start", '<' . $perpage_tag . '>');
                $this->tpl[0]->set_var("perpage_wrap_end", '</' . $perpage_tag . '>');
            }
            $this->tpl[0]->set_var("perpage_label", $buffer_perpage_label);
            $this->tpl[0]->set_var("perpage_items", $buffer_perpage_items);

            $this->tpl[0]->parse("SectSelector", false);
		} else {
            /*if(is_array($this->framework_css["pagination"]["def"]["col"]) && count($this->framework_css["pagination"]["def"]["col"])) {
                foreach($this->framework_css["pagination"]["def"]["col"] AS $col_key => $col_value) {
                    $this->framework_css["pagination"]["def"]["col"][$col_key] = $this->framework_css["pagination"]["def"]["col"][$col_key] + $this->framework_css["perPage"]["col"][$col_key];
                    if($this->framework_css["pagination"]["def"]["col"][$col_key] > 12)
                        $this->framework_css["pagination"]["def"]["col"][$col_key] = 12;
                }
            }*/
            
			$this->tpl[0]->set_var("SectSelector", "");
		}
		
	}

}