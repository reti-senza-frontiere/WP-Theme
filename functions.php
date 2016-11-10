<?php
//mostro gli errori
$display_errors = true;
if($display_errors) { //mostro gli errori
	error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

//apro la sessione
//session_start();

//importa le funzioni wordpress
$path = get_template_directory().'/lib/wp-functions/';
if(file_exists($path)) {
	$open = opendir($path);
	while(false !== ($file = readdir($open))) {
		if($file != '.' && $file != '..') {
			require('lib/wp-functions/'.$file);
		}
	}
}

//importa le funzioni
$path = get_template_directory().'/lib/functions/';
if(file_exists($path)) {
	$open = opendir($path);
	while(false !== ($file = readdir($open))) {
		if($file != '.' && $file != '..') {
			require('lib/functions/'.$file);
		}
	}
}

//importa i post type
$path = get_template_directory().'/lib/post-types/';
if(file_exists($path)) {
	$open = opendir($path);
	while(false !== ($file = readdir($open))) {
		if($file != '.' && $file != '..') {
			require('lib/post-types/'.$file);
		}
	}
}

//importa i meta
$path = get_template_directory().'/lib/metas/';
if(file_exists($path)) {
	$open = opendir($path);
	while(false !== ($file = readdir($open))) {
		if($file != '.' && $file != '..') {
			require('lib/metas/'.$file);
		}
	}
}

//importa le pagine dell'admin
$path = get_template_directory().'/lib/admin-pages/';
if(file_exists($path)) {
	$open = opendir($path);
	while(false !== ($file = readdir($open))) {
		if($file != '.' && $file != '..') {
			require('lib/admin-pages/'.$file);
		}
	}
}

//importa le sidebar
function register_theme_sidebars() {
	$path = get_template_directory().'/lib/sidebars/';
	$files = array();
	if(file_exists($path)) {
		$open = opendir($path);
		while(false !== ($file = readdir($open))) {
			if($file != '.' && $file != '..') {
				$files[] = $file;
			}
		}
	}
	asort($files); //ordino
	foreach($files as $file) {
		require('lib/sidebars/'.$file);
	}
}
add_action('widgets_init', 'register_theme_sidebars');

//importa i widget
function register_theme_widgets() {
	$path = get_template_directory().'/lib/widgets/';
	if(file_exists($path)) {
		$open = opendir($path);
		while(false !== ($file = readdir($open))) {
			if($file != '.' && $file != '..') {
				require('lib/widgets/'.$file);
			}
		}
	}
}
add_action('widgets_init', 'register_theme_widgets');

// Breadcrumbs
require('lib/breadcrumb.php'); //funzioni custom

//altri file
require('lib/custom.php'); //funzioni custom
