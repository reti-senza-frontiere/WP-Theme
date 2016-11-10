<?php
function ajax_example() {
    ob_flush();
    exit;
}
add_action('wp_ajax_ajax_example', 'ajax_example');
add_action('wp_ajax_nopriv_ajax_example', 'ajax_example');