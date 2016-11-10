<?php
/**
 * Shortcodes
 */

/**
 * Display the donation button
 */
function rsf_donation_button(){
    $output = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=8KB4T8EPACQT8" target="_blank" rel="nofollow">';
    $output .= '<img src="' . get_template_directory_uri_images() . '/pulsante_donazione.png" alt="" />';
    $output .= '</a>';
	return $output;
}
add_shortcode("donation_btn", "rsf_donation_button");

/**
 * Display a "Diventa socio" button
 */
function rsf_diventa_socio(){
    $output = '<a href="' . get_permalink(get_page_by_title("Come aderire")->ID) . '" rel="nofollow">';
    $output .= '<img src="' . get_template_directory_uri_images() . '/pulsante_diventa_socio.png" alt="" />';
    $output .= '</a>';
	return $output;
}
add_shortcode("diventa_socio_btn", "rsf_diventa_socio");

/**
 * Display a list of child pages
 */
function list_childpages(){
    global $post;

    $childpages = wp_list_pages('sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0');
    if($childpages) {
        $string = '<ul class="browser-default">' . $childpages . '</ul>';
    }
    return $string;
}
add_shortcode("list_childpages", "list_childpages");
