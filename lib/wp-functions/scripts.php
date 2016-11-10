<?php
function theme_head_scripts() {
	/**
	 * Css packs
	 */
	// // jQuery UI
	// wp_enqueue_style("jquery-ui", get_template_directory_uri_packs() . "/jquery-ui/jquery-ui.min.css", array(), null);
	// // Bootstrap
	// wp_enqueue_style("bootstrap", get_template_directory_uri_packs() . "/bootstrap/dist/css/bootstrap.min.css", array(), null);
	// // Bootstrap (theme)
	// wp_enqueue_style("bootstrap-theme", get_template_directory_uri_packs() . "/bootstrap/dist/css/bootstrap-theme.min.css", array(), null);
	// // Owl carousel
	// wp_enqueue_style("owl-carousel", get_template_directory_uri_packs() . "/owlcar/owl-carousel2/owl.carousel.css", array(), null);
	// // Owl carousel (theme)
	// wp_enqueue_style("owl-carousel-theme", get_template_directory_uri_packs() . "/owlcar/owl-carousel2/owl.theme.css", array(), null);
	// Font Awesome
	wp_enqueue_style("font-awesome", get_template_directory_uri_packs() . "/font-awesome/css/font-awesome.min.css", array(), null);
	// Materialize
	wp_enqueue_style("materialize", get_template_directory_uri_packs() . "/materialize/css/materialize.css", array(), null);
	// // Fancybox
	// wp_enqueue_style("fancybox", get_template_directory_uri_packs() . "/fancybox/source/jquery.fancybox.css", array(), null);
	// Mapbox
	wp_enqueue_style("mapbox", get_template_directory_uri_packs() . "/mapbox.js/mapbox.css", array(), null);

	/**
	 * Google fonts
	 * @link  https://fonts.google.com/
	 */
	$query_args = array(
		"family" => "Roboto:300,400,700",
		"family" => "Bitter:400,400i,700",
		"family" => "Material+Icons"
	);
	wp_enqueue_style("google-fonts", add_query_arg($query_args, "//fonts.googleapis.com/css"), array(), null);

	/**
	 * Custom css
	 */
	wp_enqueue_style("default", get_bloginfo("stylesheet_url"), array(), null);
	wp_enqueue_style("responsiveness", get_template_directory_uri_css() . "/responsiveness.css", array(), null);

	/**
	 * Javascript packs
	 */
	// jQuery
	wp_enqueue_script("jquery", get_template_directory_uri_packs() . "/jquery/dist/jquery.min.js", array(), "1.11.4", false);
	// jQuery UI
	wp_enqueue_script("jquery-ui", get_template_directory_uri_packs() . "/jquery-ui/jquery-ui.js", array(), "1.11.4", false);
	// // Bootstrap
	// wp_enqueue_script("bootstrap", get_template_directory_uri_packs() . "/bootstrap/dist/js/bootstrap.min.js", array(), "3.3.4", false);
	// Materialize
	wp_enqueue_script("materialize", get_template_directory_uri_packs() . "/materialize/dist/js/materialize.js", array(), "3.3.4", false);
	// jQuery Validation
	wp_enqueue_script("jquery-validation", get_template_directory_uri_packs() . "/jquery-validation/dist/jquery.validate.min.js", array(), "1.15.1", false);
	// jQuery Validation
	wp_enqueue_script("jquery-validation-additional-methods", get_template_directory_uri_packs() . "/jquery-validation/dist/additional-methods.min.js", array(), "1.15.1", false);
	// // Owl carousel
	// wp_enqueue_script("owl-carousel", get_template_directory_uri_packs() . "/owlcar/owl-carousel/owl.carousel.js", array(), "1.3.2", false);
	// // Fancybox
	// wp_enqueue_script("fancybox", get_template_directory_uri_packs() . "/fancybox/source/jquery.fancybox.js", array(), "2.1.5", false);
	// // Google maps
	// wp_enqueue_script("google-maps", "//maps.googleapis.com/maps/api/js?v=3.exp", array(), "1.1", false);
	// // Google maps js
	// wp_enqueue_script("google-maps", get_template_directory_uri_packs() . "/gmaps/gmaps.min.js", array(), "1.1", false);
	// Mapbox
	wp_enqueue_script("mapbox", get_template_directory_uri_packs() . "/mapbox.js/mapbox.js", array(), "2.2.1", false);

	// // Google chart
	// wp_enqueue_script("google-charts", "//www.google.com/jsapi", array(), "1.1", false);
	// Google reCaptcha
	wp_enqueue_script("google-recaptcha", "https://www.google.com/recaptcha/api.js", array(), "1.0.0", false);
	/**
	 * Custom Javascript
	 */
	wp_enqueue_script("default", get_template_directory_uri_js() . "/scripts.js", array(), "1.0.0", true);
	wp_enqueue_script("map", get_template_directory_uri_js() . "/map.js", array(), "1.0.0", true);
	wp_enqueue_script("form", get_template_directory_uri_js() . "/form.js", array(), "1.0.0", true);
	wp_localize_script("default", "root_path", paths_for_javascript());
}
add_action("wp_enqueue_scripts", "theme_head_scripts");

/**
 * Admin interface scripts
 */
// function theme_admin_head_scripts() {
// 	wp_register_style("datepicker-jquery-ui", "//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css", false, "1.0.0");
// 	wp_enqueue_style("datepicker-jquery-ui");
// 	wp_register_style("datepicker-jquery-style", "//jqueryui.com/resources/demos/style.css", false, "1.0.0");
// 	wp_enqueue_style("datepicker-jquery-style");
// 	wp_enqueue_script("jquery-ui-1.11.4", "//code.jquery.com/ui/1.11.4/jquery-ui.js", array(), "1.11.4", false);
// }
// add_action("admin_enqueue_scripts", "theme_admin_head_scripts");

// Meta tags in the header
function add_meta_head() {
	global $post;
	$current_url = home_url($_SERVER["REQUEST_URI"]);

	// Thumbnails
	if(is_singular() && (isset($post) && has_post_thumbnail($post->ID))) { //pagina singola
		$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full");
		$thumbnail_src = esc_attr($thumbnail_src[0]);
	} else {
		if(file_exists(get_template_directory() . "/images/logo-top.png")) {
			$thumbnail_src = get_template_directory_uri_images() . "/logo-top.png";
		} else {
			$thumbnail_src = get_template_directory_uri_images() . "/default-share-icon.png";
		}
	}

	/**
	 * Facebook
	 */
	if(strstr(get_user_info("user_agent"), "facebook")) {
		?><meta property="fb:admins" content="" /><?php
	}

	// Twitter
	if(strstr(get_user_info("user_agent"), "Twitterbot")) {
		?>
		<meta name="twitter:title" content="<?php wp_title("|", true, "right"); ?>" />
		<meta name="twitter:image" content="<?php echo $thumbnail_src; ?>" />
		<meta name="twitter:domain" content="<?php echo home_url(); ?>" />
		<meta name="twitter:site" content="@assist" />
		<meta name="twitter:creator" content="@assist" />
		<meta name="twitter:card" content="summary">
		<?php
	}

	// General meta tags
	?>
	<meta property="og:title" content="<?php wp_title("|", true, "right"); ?>" />
	<meta property="og:image" content="<?php echo $thumbnail_src; ?>" />
	<meta property="og:url" content="<?php echo $current_url; ?>" />
	<meta property="og:site_name" content="<?php echo get_bloginfo("name"); ?>" />
	<meta property="og:type" content="article" />
	<meta itemprop="name" content="<?php wp_title("|", true, "right"); ?>" />
	<meta itemprop="image" content="<?php echo $thumbnail_src; ?>" />
	<meta itemprop="datePublished" content="<?php echo current_time("Y-m-d"); ?>" />
	<link rel="image_src" href="<?php echo $thumbnail_src; ?>" />
	<?php
}
add_action("wp_head", "add_meta_head", 10, 2);
