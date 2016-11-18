<?php
/**
 * Assets dir
 */
function get_template_directory_uri_assets() {
	return get_template_directory_uri() . "/assets";
}

/**
 * Bower components dir
 */
function get_template_directory_uri_packs() {
	return get_template_directory_uri_assets() . "/bower_components";
}

/**
 * CSS dir
 */
function get_template_directory_uri_css() {
	return get_template_directory_uri_assets() . "/css";
}
function change_stylesheet_directory_uri() {
	$stylesheet_directory = get_template_directory_uri_css();
	return $stylesheet_directory;
}
add_filter("stylesheet_directory_uri", "change_stylesheet_directory_uri");

/**
 * Main CSS file
 */
function change_stylesheet_uri() {
	$stylesheet_uri = get_template_directory_uri_css() . "/main.css";
	return $stylesheet_uri;
}
add_filter("stylesheet_uri", "change_stylesheet_uri");

/**
 * Fonts dir
 */
function get_template_directory_uri_fonts() {
	return get_template_directory_uri_assets() . "/fonts";
}

/**
 * Images dir
 */
function get_template_directory_uri_images() {
	return get_template_directory_uri_assets() . "/images";
}

/**
 * Javascript dir
 */
function get_template_directory_uri_js() {
	return get_template_directory_uri_assets() . "/js";
}

/**
 * JSON dir
 */
function get_template_directory_uri_json() {
	return get_template_directory_uri_assets() . "/json";
}

function paths_for_javascript() {
	return array(
		"assets"			=> get_template_directory_uri_assets(),
		"bower_components"	=> get_template_directory_uri_packs(),
		"css"				=> get_template_directory_uri_css(),
		"fonts"				=> get_template_directory_uri_fonts(),
		"images"			=> get_template_directory_uri_images(),
		"js"				=> get_template_directory_uri_js(),
		"json"				=> get_template_directory_uri_json()
	);
}
