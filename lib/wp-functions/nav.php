<?php
//registro i menu
function register_menus() {
	$menus = array(
		array(
			'id'	=> 'header-menu',
			'title'	=> 'Header Menu'
		),
		array(
			'id'	=> 'footer-menu',
			'title'	=> 'Footer Menu'
		)
	);
	//ciclo i menu
	foreach($menus as $menu) {
		register_nav_menu($menu['id'], $menu['title']); //registro
		if(!wp_get_nav_menu_object($menu['title'])) {
			wp_create_nav_menu($menu['title'], array('slug' => $menu['id'])); //creo
		}
	}
}
add_action('after_setup_theme', 'register_menus');

//current-menu-item to active
function special_nav_class($classes, $item) {
	if(in_array('current-menu-item', $classes)) {
		$classes = str_replace('current-menu-item', 'active', $classes);
	}
	return $classes;
}
add_filter('nav_menu_css_class', 'special_nav_class', 10 , 2);

//menu pulito
class cleaner_walker_nav_menu extends Walker {
	var $tree_type = array('post_type', 'taxonomy', 'custom');
	var $db_fields = array('parent' => 'menu_item_parent', 'id' => 'db_id');
	function start_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}
	function end_lvl(&$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}
	function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
		global $wp_query;
		$indent = ($depth) ? str_repeat("\t", $depth) : '';
		$class_names = $value = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$classes = in_array('current-menu-item', $classes) ? array('current-menu-item') : array();
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = strlen(trim($class_names)) > 0 ? ' class="' . esc_attr($class_names) . '"' : '';
		$id = apply_filters('nav_menu_item_id', '', $item, $args);
		$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';
		$id = ' id="menu-item-'.$item->ID.'"';
		$output .= $indent . '<li' . $id . $value . $class_names .'>';
		$attributes  = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
		$attributes  = ! empty($item->url)        ? ' href="'   . esc_attr($item->url) .'"' : '';
		$attributes .= ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : ' title="' . $item->title . '"';
		$attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target) .'"' : '';
		$attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) .'"' : '';
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>'.$args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after.'</a>'; //metto il link normale
		$item_output .= $args->after;
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
	function end_el(&$output, $item, $depth = 0, $args = array()) {
		$output .= "</li>\n";
	}
}
