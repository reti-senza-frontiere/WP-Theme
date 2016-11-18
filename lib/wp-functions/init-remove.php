<?php
//rimuovo dall"head
remove_action("wp_head", "feed_links_extra", 3); //display the links to the extra feeds such as category feeds
remove_action("wp_head", "feed_links", 2); //display the links to the general feeds: Post and Comment Feed
remove_action("wp_head", "rsd_link"); //display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action("wp_head", "wlwmanifest_link"); //display the link to the Windows Live Writer manifest file.
remove_action("wp_head", "index_rel_link"); //index link
remove_action("wp_head", "parent_post_rel_link", 10, 0); //prev link
remove_action("wp_head", "start_post_rel_link", 10, 0); //start link
remove_action("wp_head", "wp_generator"); //display the XHTML generator that is generated on the wp_head hook, WP version
remove_action("wp_head", "wp_shortlink_wp_head"); //display shortlink
remove_action("wp_head", "print_emoji_detection_script", 7);
remove_action("wp_print_styles", "print_emoji_styles");
//remove_action("wp_head", "adjacent_posts_rel_link_wp_head", 10, 0); //remove next and prev posts

//rimuovo i colori dal profilo utente
function remove_from_admin_head() {
	remove_action("admin_color_scheme_picker", "admin_color_scheme_picker");
}
add_action("admin_head","remove_from_admin_head");

/*
//...proseguo rimuovendo il tag wpml
function theme_generator_tag() {
    return false;
}
add_filter("meta_generator_tag", "theme_generator_tag");

//rimuovo i tags
function remove_from_admin() {
	remove_meta_box("tagsdiv-post_tag", "post", "normal");
	remove_submenu_page("edit.php", "edit-tags.php?taxonomy=post_tag");
}
add_action("admin_menu", "remove_from_admin");

//rimuovo la colonna tags da post
function remove_post_columns($defaults) {
	unset($defaults["tags"]);
	return $defaults;
}
add_filter("manage_posts_columns", "remove_post_columns");
*/

//rimuovo dall"head lo stile
function remove_recent_comment_style() {
	global $wp_widget_factory;
	remove_action("wp_head", array($wp_widget_factory->widgets["WP_Widget_Recent_Comments"], "recent_comments_style"));
}
add_action("widgets_init", "remove_recent_comment_style");

//disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if(post_type_supports($post_type, "comments")) {
			remove_post_type_support($post_type, "comments");
			remove_post_type_support($post_type, "trackbacks");
		}
	}
}
add_action("admin_init", "df_disable_comments_post_types_support");

//close comments on the front-end
function df_disable_comments_status() {
	return false;
}
add_filter("comments_open", "df_disable_comments_status", 20, 2);
add_filter("pings_open", "df_disable_comments_status", 20, 2);

//hide existing comments
function df_disable_comments_hide_existing_comments($comments) {
	$comments = array();
	return $comments;
}
add_filter("comments_array", "df_disable_comments_hide_existing_comments", 10, 2);

//remove comments page in menu
function df_disable_comments_admin_menu() {
	remove_menu_page("edit-comments.php");
}
add_action("admin_menu", "df_disable_comments_admin_menu");

//redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect() {
	global $pagenow;
	if ($pagenow === "edit-comments.php") {
		wp_redirect(admin_url()); exit;
	}
}
add_action("admin_init", "df_disable_comments_admin_menu_redirect");

//remove comments metabox from dashboard
function df_disable_comments_dashboard() {
	remove_meta_box("dashboard_recent_comments", "dashboard", "normal");
}
add_action("admin_init", "df_disable_comments_dashboard");

//remove comments links from admin bar
function df_disable_comments_admin_bar() {
	if (is_admin_bar_showing()) {
		remove_action("admin_bar_menu", "wp_admin_bar_comments_menu", 60);
	}
}
add_action("init", "df_disable_comments_admin_bar");

//rimuovo dalla barra admin di wordpress
function remove_admin_bar_links() {
    global $wp_admin_bar;
    /*
	$wp_admin_bar->remove_menu("wp-logo");          // Remove the WordPress logo
    $wp_admin_bar->remove_menu("about");            // Remove the about WordPress link
    $wp_admin_bar->remove_menu("wporg");            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu("documentation");    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu("support-forums");   // Remove the support forums link
    $wp_admin_bar->remove_menu("feedback");         // Remove the feedback link
    $wp_admin_bar->remove_menu("site-name");        // Remove the site name menu
    $wp_admin_bar->remove_menu("view-site");        // Remove the view site link
    $wp_admin_bar->remove_menu("updates");          // Remove the updates link
	*/
    $wp_admin_bar->remove_menu("comments");         // Remove the comments link
    /*
    $wp_admin_bar->remove_menu("new-content");      // Remove the content link
    $wp_admin_bar->remove_menu("w3tc");             // If you use w3 total cache remove the performance link
    $wp_admin_bar->remove_menu("my-account");       // Remove the user details tab
    */
}
add_action("wp_before_admin_bar_render", "remove_admin_bar_links");

/*
//rimuovo i metabox icl
function disable_icl_metabox() {
	$div_ids = array(//i div da rimuovere
		"icl_div",
		"icl_div_config"
	);
	$post_types = array(//i post_type dove non lo vogliamo
		"post",
		"forum",
		"transaction"
	);
	$contexts = array(//da tutte le posizioni
		"normal",
		"advanced",
		"side"
	);
	foreach($div_ids as $div_id) { //ciclo i div
		foreach($post_types as $post_type) { //ciclo i post_type
			foreach($contexts as $context) { //ciclo le posizioni
				remove_meta_box($div_id, $post_type, $context);
			}
		}
	}
}
add_action("admin_head", "disable_icl_metabox", 99);
*/
