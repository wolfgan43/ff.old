ff.ffPage.activebuttons = (function () {

var that = { /* publics */
	__ff : "ff.ffPage.activebuttons", /* used to recognize ff'objects */
	"init" : function (spinnerClass) {
		//jQuery(".activebuttons").unbind("click.activebuttons");
		jQuery(".activebuttons").off("click.activebuttons").on("click.activebuttons", function() {
			if(spinnerClass && jQuery(this).is("a")) {
		        jQuery(this).attr("data-class", jQuery(this).attr("class"));
		        jQuery(this).attr("class", jQuery(this).attr("class").substring(0, jQuery(this).attr("class").indexOf("activebuttons") - 1));
		        jQuery(this).addClass("activatedbuttons");
		        jQuery(this).prepend('<i class="' + spinnerClass + '"></i>'); 
			}
			jQuery(this).css({"opacity": "0.6", "pointer-events": "none"});

			if(!jQuery(this).is("a")) 
            	jQuery(this).attr("disabled", "disabled");
		});
	}
	, "reset" : function() {
		jQuery('.activatedbuttons').each(function() {
			jQuery(this).attr("class", jQuery(this).attr("data-class"));
			jQuery(this).removeAttr("data-class");
			jQuery("i", this).remove();
			jQuery(this).removeAttr("style");
		});
	}
}; /* publics' end */

    /* Init obj */
    function constructor() { // NB: called below publics
        ff.initExt(that);
    }

    if(document.readyState == "complete") {
        //  constructor(); //va in contrasto con libLoaded
    } else {
        window.addEventListener('load', function () {
            constructor();
        });
    }

return that;

/* code's end. */
})();