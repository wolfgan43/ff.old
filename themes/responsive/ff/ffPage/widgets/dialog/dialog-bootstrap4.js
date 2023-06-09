/*
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

/**
 * Forms Framework Javascript Handling Object
 *    dialog page' plugin namespace
 */
ff.ffPage.dialog = (function () {

// inits
var firstDialog = null;
var unique = null;
//overflow manage

ff.pluginAddInit("ff.ajax", function () {
	ff.ajax.addEvent({
		"event_name" : "onUpdateContent"
		, "func_name" : function (params, data, injectid) {
			if (params.ctx && ff.ffPage.dialog.exist(params.ctx) && params.component === undefined) {
				if (!ff.ffPage.dialog.get(params.ctx).instance) {
                    ff.ffPage.dialog.makeInstance(params.ctx);
                }
			}
		}
	});
	ff.ajax.addEvent({
		"event_name" : "onRedirect"
		, "func_name" : function (url, data, mydata, params) {
			if (
				(params.ctx && ff.ffPage.dialog.get(params.ctx) && ff.ffPage.dialog.getInstance(params.ctx))
				&& (params.doredirects || data["doredirects"] !== undefined)
			) {
				ff.ffPage.dialog.getInstance(params.ctx).dialog("close"); 
			}
		}
	});
	ff.ajax.addEvent({
		"event_name" : "ctxInitDone"
		, "func_name" : function (id) {
			if (dialogs.get(id) && dialogs.get(id).waiting) {
				ff.ajax.unblockUI();
				ff.ffPage.dialog.refresh(id, true);
				return true;
			}
		}
	});
}, "a65c581e-64d9-473d-a166-c1848cas23cb");



/* privates */
var dialogs		= ff.hash();
/*var inits_by_dlg = ff.hash();
var inits_by_wdg = ff.hash();

function initsReset(id) {
	inits_by_dlg.set(id, ff.hash());
	ff.ffPage.dialog.needInit(id, false);
}*/

var that = { /* publics */
__ff : "ff.ffPage.dialog-bootstrap4", /* used to recognize ff'objects */

"dialog_params"        : ff.hash(),
/*"dialog_deps"        : ff.hash(),*/

"addDialog" : function (params) {
	/** mod di alex **/
	if(unique === null && params.unique) {
		unique = params.id;
	}
	unique = null;
	/** fine mod di alex **/

	if (that.dialog_params.isset(params.id))
		return;	
	
    that.dialog_params.set(params.id, {
        "class"			: (params.dialogClass ? " " + params.dialogClass : ""),
        "callback"		: params.callback,
        "url"			: params.url,
        "title"			: params.title,
        "width"			: params.width,
        "params"        : params.params || {},
        "doredirects"	: params.doredirects,
    });
	
	ff.ajax.ctxAdd(params.id, that, "dialog");

    that.doEvent({
        "event_name"    : "onAddDialog",
        "event_params"    : [params.id]
    });
},

"get" : function (id) {
    return dialogs.get(id);
},

"exist" : function (id) {
	return that.dialog_params.isset(id);
},

"getInstance" : function (id) {
    return dialogs.get(id).instance;
},

"replaceHTML" : function (id, data) {
	that.getInstance(id).html(data["html"]);
	ff.ffPage.dialog.makeDlgBt(id, data);
},

"param" : function (id, param, value) {
    if (value !== undefined)
        that.dialog_params.get(id)[param] = value;
    else
        return that.dialog_params.get(id)[param];
},

"refresh" : function (id, show) {
	if(id === undefined) {
		id = dialogs.keys[dialogs.keys.length - 1];
	}

	var instance = dialogs.get(id).instance;
	
	if(!instance.hasClass("show")) {
        instance.addClass("show");
		//widget.modal({backdrop: false});
        instance.show();
 		
 		that.doEvent({
		    "event_name"    : "onDisplayedDialog",
		    "event_params"    : [id]
		});		
	}
	//that.adjSize(id);

	return true;
},

"makeInstance" : function (id, data, title) {
	//overflow manage
	if (firstDialog === null) {
		jQuery("body").addClass("modal-open");
		firstDialog = id;
	}

	jQuery("body").append('<div id="ffWidget_dialog_' + id + '" class="ff-modal modal fade" role="dialog"></div>');
	
	dialogs.get(id).instance = jQuery('#ffWidget_dialog_' + id);

	return dialogs.get(id).instance;
},

"doOpen" : function (id, url, title, preserveIstance, elemHighlight) {
//unique = null;
	var html = undefined;
	if(id.trim().substring(0,1) == "<") {
		html = id;
		id = new Date().getTime();
	}

	if(unique && dialogs.keys.length) {
		preserveIstance = true;
		if(!url)
			url = that.dialog_params.get(id)["url"];
		if(!title)
			title = that.dialog_params.get(id)["title"];

		id = unique;
	}
	if(that.dialog_params.get(id) !== undefined) {
        if (url !== undefined)
            that.dialog_params.get(id)["url"] = url;
		else
            url = that.dialog_params.get(id)["url"];

        if (title !== undefined && title.length > 0)
            that.dialog_params.get(id)["title"] = title;
		else
            title = that.dialog_params.get(id)["title"];
    }
	if(that.dialog_params.get(id)) {
        that.updateCursor(id, that.dialog_params.get(id)["url"]);
    }

    if (dialogs.get(id) && dialogs.get(id).instance) {
        if(dialogs.get(id).params.current_url != url && preserveIstance) {
			var breadCrumbs = dialogs.get(id).breadCrumbs;
        	var actionBack = false;
        	if(breadCrumbs.length > 0) {
        		for(var i=0; i< breadCrumbs.length; i++) {
        			if(breadCrumbs[i]["url"] == url) {
        				breadCrumbs = breadCrumbs.splice(i);
        				actionBack = true;
        				break;
					}
				}
        	}
        	if(!actionBack)
        		breadCrumbs.push({"title":  jQuery(".modal-title", instance).text(), "url" : dialogs.get(id).params.current_url});
				
            ff.ffPage.dialog.goToUrl(id, url);
        } else {
            //widget.modal("show");
            //widget.modal({backdrop: false});
            that.refresh(id);
        }
        return;
    }

 	dialogs.set(id, {
		"instance"	: null,
		"params"	: jQuery.extend(true, {}, that.dialog_params.get(id)), 
	    "elemHighlight" : elemHighlight,
		"breadCrumbs": []
	});	

	if(url) {
        if(ff.ajax.ctxGet(id)) {
        	ff.ajax.ctxGet(id).reset();

			dialogs.get(id).params.current_url = dialogs.get(id).params.url;

			var evres = that.doEvent({"event_name": "doOpen", "event_params" : [that, id, url, title]});
			if (evres !== true) {
				ff.ajax.doRequest({
					"url"			: that.parseUrl(id, dialogs.get(id).params.current_url),
					"type"			: "GET",
					"callback"		: that.onSuccess,
					"customdata"	: {
						"id" : id
						, "caller" : {
							"func" : ff.ffPage.dialog.doOpen
							, "args" : ff.argsAsArray(arguments)
						}
					},
					"injectid"		: dialogs.get(id).instance,
					"ctx"			: id,
					"brandnew"		: true,
					"doredirects"	: dialogs.get(id).params.doredirects
				});
			}
        }
	} else {
		ff.ffPage.dialog.makeInstance(id, html || jQuery("#" + id).outerHTML(), title);
		that.refresh(id);
	}
},

"close" : function (id) {
	if(id === undefined) {
		id = dialogs.keys[dialogs.keys.length - 1];
	}

	that.onClose(id);
},

"onSuccess" : function (data, customdata) {
    var id = customdata.id;
	var instance = dialogs.get(id).instance;
    if (data === null) {
        if (dialogs.get(id).params.params && dialogs.get(id).params.params.persistent)
            dialogs.get(id).params.params.persistent = false;
        instance && dialogs.get(id).instance.dialog("close");
        return false;
    }
    
    //jQuery(widget).modal("show");
    
    if(dialogs.get(id).elemHighlight)
        jQuery(dialogs.get(id).elemHighlight).addClass("ff-modal-highlight");

    /**
     *    data.close
     *        true = chiude il dialog
     *        false = valorizza (o aggiorna) il dialog
     *
     *    data.refresh
     *        true = imposta il dialog per l'aggiornamento del chiamante su chiusura
     *
     *    data.html
     *        contenuto del dialog se aggiornato
     *
     *    data.url
     *        cambia l'url del dialog su redirect interno
     */

    if (customdata.callback)
        customdata.callback(id, data);

    if (data.callback)
        eval(data.callback);

    if (data["close"]) {
        that.close(id);
	} else if (data["url"]) {
		dialogs.get(id).params.current_url = data["url"];
		that.updateCursor(id, data["url"]);
	} else if (data["cursor_reload"] && data["cursor_reload"] === id) {
		ff.ffRecord.cursor.reload(id);		
    } else {
        if (data["html"]) {
            that.makeDlgBt(id, data["html"]);
            if (data["footers"].replace(/\s+/, '')) {
                eval(data["footers"]);
            }
			if (!ff.ajax.ctxGet(id).needInit() && dialogs.get(id) !== undefined ) {
				//jQuery(widget).modal({backdrop: false});
				that.refresh(id);
			}
        }

		if (!ff.ajax.ctxGet(id).needInit()) {
            ff.ffPage.dialog.refresh(id, true);
        } else {
			dialogs.get(id).waiting = true;
			ff.ajax.blockUI();
		}
    }
    return true;
},

"onClose" : function (id, hide) {
    if(dialogs.get(id).elemHighlight)
        jQuery(dialogs.get(id).elemHighlight).removeClass("ff-modal-highlight");
    
    if (dialogs.get(id).params.params && dialogs.get(id).params.params.persistent)
        return;

    if (dialogs.get(id).params.callback) {
        eval(dialogs.get(id).params.callback);
    }

    ff.struct.get("comps").each(function (componentid, component) {
        if (component.ctx === id) {
            ff.clearComponent(componentid);
        }
    });

    ff.struct.get("fields").each(function (key, field) {
        if (field.ctx !== undefined && field.ctx === id) {
            ff.doEvent({
                "event_name"    : "onClearField",
                "event_params"    : [undefined, key, field]
            });
            ff.struct.get("fields").unset(key);
        }
    });
	
    dialogs.get(id).instance.remove();
    dialogs.unset(id);

    if(ff.ajax.ctxGet(id))
		ff.ajax.ctxGet(id).reset();
	
	if (id === firstDialog) {
		jQuery("body").removeClass("modal-open");
		firstDialog = null;
	}

    that.doEvent({
        "event_name": "onClose"
        , "event_params" : [id]
    });
},

"doAction" : function (id, action, component, detailaction, action_param, addit_fields) {
    that.param(id, "lastaction", action);
    
    switch (action) {
        case "close":
        	that.close(id);
            break;
        default:
        	var instance = dialogs.get(id).instance;

			ff.ajax.ctxGet(id).reset();
            that.doEvent({"event_name": "doAction", "event_params" : [id, action, component, detailaction, action_param]});

            var fields = ff.getFields(instance, id);
            fields.push(
                {name: "frmAction", value: component + action}
            );
            if (detailaction) {
                fields.push(
                    {name: component + "detailaction", value: detailaction}
                );
            }

            if (action == "detail_delete") {
                fields.push(
                    {name: detailaction + "_delete_row", value: action_param}
                );
            }

            if(addit_fields) {
                for(var i in addit_fields) {
                    fields.push(addit_fields[i]);
                }
            }
            ff.ajax.doRequest({
                 "url"                : that.parseUrl(id, dialogs.get(id).params.current_url),
                 "type"                : "POST",
                 "fields"            : fields,
                 "callback"            : that.onSuccess,
                 "customdata"        : {
                    "id" : id
					, "caller" : {
						"func" : ff.ffPage.dialog.doAction
						, "args" : ff.argsAsArray(arguments)
					}
                 },
                 "injectid"            : dialogs.get(id).instance,
                 "ctx"				: id,
                 "doredirects"        : dialogs.get(id).params.doredirects
            });
            break;
    }
},

"goToUrl" : function (id, url) {
	ff.ajax.ctxGet(id).reset();
	
    dialogs.get(id).params.current_url = url;
	that.updateCursor(id, url);

    ff.ajax.doRequest({
         "url"                : that.parseUrl(id, dialogs.get(id).params.current_url),
         "type"                : "GET",
         "callback"            : that.onSuccess,
         "customdata"        : {
            "id" : id
			, "caller" : {
				"func" : ff.ffPage.dialog.goToUrl
				, "args" : ff.argsAsArray(arguments)
			}
         },
         "injectid"            : dialogs.get(id).instance,
         "ctx"				: id,
		 "brandnew"			: true,
         "doredirects"        : dialogs.get(id).params.doredirects
    });
},

"doRequest" : function (id, params) {
    /**
     * params
     *    url
     *    component
     *    section
     *    injectid
     *    action
     *    detailaction
     *    callback
     *    action_param
     *    fields            i campi da passare con la richiesta, se no vengono presi quelli di tutta la pagina
     */
    var instance = dialogs.get(id).instance;
    
	ff.ajax.ctxGet(id).reset();
	
	var fields = (params.fields === undefined ? jQuery(":input", instance).not("input:checkbox:not(:checked)").not("input:radio:not(:checked)") : params.fields);

    if (params.action) {
        fields.push(
            {"name": "frmAction", "value": params.action}
        );
    }
        
    if (params.detailaction) {
        fields.push(
            {"name": params.detailaction + "detailaction", "value": params.component}
        );
    }

    if (params.action_param !== undefined) {
        fields.push(
            {"name": params.component + "_delete_row", "value": params.action_param}
        );
    }

    var url = (params.url !== undefined ? params.url : null);

    if (!url && params.component && ff.struct.get("comps").get(params.component) !== undefined)
        url = ff.struct.get("comps").get(params.component).url;

    if (!url)
        url = dialogs.get(id).params.current_url;
        
    ff.ajax.doRequest({
         "url"                	: that.parseUrl(id, url),
         "component"        	: params.component,
         "section"            	: params.section,
         "fields"            	: fields,
         "callback"            	: that.onSuccess,
         "customdata"        	: {
            "id"            	: id
            , "callback"    	: params.callback
			, "caller" 			: {
				"func" 			: ff.ffPage.dialog.doRequest
				, "args" 		: ff.argsAsArray(arguments)
			}
         },
         "injectid"            	: params.injectid,
         "ctx"					: id,
         "chainupdate"        	: params.chainupdate, 
         "doredirects"        	: dialogs.get(id).params.doredirects
    });
},

"parseUrl" : function (id, url) {
    var parsedurl = url;

    /*if (parsedurl.indexOf('?') > -1) {
        if (parsedurl.substring(parsedurl.length - 1) != "&")
            parsedurl += "&";
        parsedurl += "XHR_THEME=dialog";
    } else
        parsedurl += "?XHR_THEME=dialog";*/

    var regTags = /\[\[([a-zA-Z0-9_\-\[\](?!\]))]+)\]\]/g;
    var ret;
    while ((ret = regTags.exec(url)) !== null) {
        var tmp = ret[1].replace(/\[/g, "\\[").replace(/\]/g, "\\]");  
        var encodeTmp = false;

        if(tmp.indexOf("_ENCODE") > 0) {
            tmp = tmp.replace("_ENCODE", "");
            encodeTmp = true;
        }

        if(tmp.indexOf("_TEXT") > 0) {
            if(jQuery("#" + tmp.replace("_TEXT", "")).is("select")) {
                parsedurl = parsedurl.replace(ret[0], (encodeTmp ? encodeURIComponent(jQuery("#" + tmp.replace("_TEXT", "") + " option:selected").text()) : jQuery("#" + tmp.replace("_TEXT", "") + " option:selected").text()), "g");                            
            } else {
                parsedurl = parsedurl.replace(ret[0], (encodeTmp ? encodeURIComponent(jQuery("#" + tmp.replace("_TEXT", "")).text()) : jQuery("#" + tmp.replace("_TEXT", "")).text()), "g");                
            }
        } else {
            parsedurl = parsedurl.replace(ret[0], (encodeTmp ? encodeURIComponent(jQuery("#" + tmp).val()) : jQuery("#" + tmp).val()), "g");    
        }
    }

    if (dialogs.get(id).params.params !== undefined)
    {

/*        for (i in dialogs.get(id).params.params) {
            parsedurl += "&" + i + "=" + jQuery("#" + dialogs.get(id).params.params[i]).val();
        }*/
    }
    return parsedurl;
},
"makeDlgBt" : function(id, html) {
	var instance = dialogs.get(id).instance;

	if(jQuery(".modal-dialog", html)) {
		instance.html(html);
        jQuery(".modal-title", instance).before('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>');
	} else {
		var tmp = '<div id="ffpwd_' + id + '" class="ff-modal modal fade" role="dialog">'
				 +  '<div class="modal-dialog' + (tmp_params["class"] || "") + '">'
				 +    '<div class="modal-content">'
				 +      '<div class="modal-header d-block">'
				 + 		  '<div class="d-flex">'
				 +          '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>'
				 +          '<h3 class="modal-title">' + jQuery(".card-title", html).html() + '</h3>'
        		 + 			jQuery(".card-subtitle", html).outerHTML()
				 +		  '</div>'
				 +      '</div>'
				 +      '<div id="ffWidget_dialog_container_' + id + '" class="modal-body clearfix">' + html + '</div>'
				 +      '<div class="modal-footer">' + jQuery(".card-footer", html).html() + ' </div>'
				 +    '</div>'
				 +  '</div>'
				 + '</div>';

        instance.html(tmp)
    }

    jQuery(".close", dialogs.get(id).instance).on('click', function () {
        that.onClose(id);
    });

},
"updateCursor" : function (id, url) {
	var tmp = null;
	if (tmp = ff.getURLParameter("cursor[id]", url)) {
		that.dialog_params.get(id)["cursor"] = {
			"id" : tmp,
			"rrow" : ff.getURLParameter("cursor[rrow]", url),
			"rows" : ff.getURLParameter("cursor[rows]", url),
		};
	}
}

}; /* publics' end */

    /* Init obj */
    function constructor() { // NB: called below publics
        ff.initExt(that);
        jQuery(document).keyup(function(e) {
            if (e.key === "Escape") { // escape key maps to keycode `27`
                jQuery(".ff-modal .close").trigger("click");
            }
        });
    }

    if(document.readyState === "complete") {
        //  constructor(); //va in contrasto con libLoaded
    } else {
        window.addEventListener('load', function () {
            constructor();
        });
    }

return that;

/* code's end. */
})();	
	