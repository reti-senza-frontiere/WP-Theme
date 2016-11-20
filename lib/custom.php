<?php

/**
 * Allow redirections
 */
add_action("init", "do_output_buffer");
function do_output_buffer() {
    ob_start();
}

?>
