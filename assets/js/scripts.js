function hide_navbar() {
    jQuery('.button-collapse').sideNav('hide');
}
function show_navbar() {
    jQuery('.button-collapse').sideNav('show');
}
function activate_search() {
    jQuery("#search_input").focus();
    return false;
}
function require_config(file, callback) {
    jQuery.getJSON(root_path.json + "/" + file, function(data){
        if(typeof(callback) == "function") {
            callback(data);
        }
    });
}

/**
 * Materialize sideNav
 */
jQuery(".button-collapse").sideNav({
    menuWidth: 300,
    edge: "right",
    closeOnClick: true,
    draggable: true
});

/**
 * Scroll to top behaviours
 */
jQuery(window).scroll(function (event) {
    var y = jQuery(window).scrollTop();
    if(y < 50) {
        jQuery("#head_nav").show();
        jQuery("#fixed_nav").hide();
        jQuery(".fixed-action-btn").fadeOut();
    } else {
        jQuery("#head_nav").hide();
        jQuery("#fixed_nav").show();
        jQuery(".fixed-action-btn").fadeIn();
    }
});

jQuery(document).ready(function() {
    /**
    * Add link button visible on mouse over to anchored header tags
    */
    if(jQuery("#toc_container").length > 0) {
        jQuery("#container-main").find("h2, h3, h4, h5, h6").each(function(i, el) {
            jQuery(el).hover(function() {
                var $this = jQuery(el),
                    id = $this.find("span").attr("id");
                    console.log(id);
                $this.prepend(
                    jQuery("<a>", {
                        "class": "breadcrumbs-link",
                        "href": "#" + id
                    }).html('<i class="fa fa-hashtag"></i>')
                );
            }, function() {
                jQuery(".breadcrumbs-link").remove();
            });
        });
    }

    jQuery(".ul.tabs").tabs();
});
