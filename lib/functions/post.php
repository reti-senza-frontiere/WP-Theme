<?php
function post_example() {
}
add_action('admin_post_post_example', 'post_example');
add_action('admin_post_nopriv_post_example', 'post_example');