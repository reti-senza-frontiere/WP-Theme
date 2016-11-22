<?php
global $menu;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <title><?php wp_title('|', true, 'right'); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <link rel="icon" href="<?php print get_template_directory_uri_images(); ?>/favicon.ico" type="image/x-icon" />
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <nav id="head_nav" class="transparent">
            <div class="nav-wrapper">
                <a href="" class="brand-logo left">
                    <img src="<?php print get_template_directory_uri_images(); ?>/site_250.png" class="hide-on-large-only" alt="<?php echo __('Logo', 'rsf'); ?>" />
                    <img src="<?php print get_template_directory_uri_images(); ?>/site_350.png" class="hide-on-med-and-down" alt="<?php echo __('Logo', 'rsf'); ?>" />
                </a>
                <?php
                // Main menu
                wp_nav_menu(
                    array(
                        "theme_location"	=> "header-menu",
                        "menu"				=> "Header Menu",
                        "container"			=> false,
                        "menu_class"		=> "right hide-on-med-and-down",
                        "menu_id"			=> "nav-header",
                        "walker"			=> new cleaner_walker_nav_menu()
                    )
                );
                ?>
                <a href="#" data-activates="slide-out" class="button-collapse hide-on-large-only right">
                    <i class="material-icons">menu</i>
                </a>
            </div>
        </nav>
        <div id="fixed_nav" class="navbar-fixed">
            <nav>
                <div class="nav-wrapper">
                    <a href="" class="brand-logo left">
                        <img src="<?php print get_template_directory_uri_images(); ?>/site_claim_350.png" class="hide-on-med-and-down" alt="<?php echo __('Logo', 'rsf'); ?>" />
                        <!-- <img src="<?php print get_template_directory_uri_images(); ?>/site_claim_250.png" class="hide-on-small-only hide-on-large-only" alt="<?php echo __('Logo', 'rsf'); ?>" /> -->
                        <img src="<?php print get_template_directory_uri_images(); ?>/site_250.png" class="hide-on-large-only" alt="<?php echo __('Logo', 'rsf'); ?>" />
                    </a>
                    <a href="#" data-activates="slide-out" class="button-collapse right">
                        <i class="material-icons">menu</i>
                    </a>
                </div>
            </nav>
        </div>
        <header>
            <div id="slide-out" class="side-nav">
                <div class="side-nav-header">
                    <a href="javascript:;" onclick="hide_navbar()" class="button left"><i class="material-icons">keyboard_arrow_left</i></a>
                    <form id="search_frm" action="" method="get">
                        <div class="input-field inline">
                            <input id="search_input" type="text" name="s" class="validate" placeholder="<?php print __('Cerca nel sito', 'rsf'); ?>" />
                        </div>
                    </form>
                </div>
                <?php
                // Vertical black menu
                wp_nav_menu(
                    array(
                        "theme_location"	=> "header-menu",
                        "menu"				=> "Header Menu",
                        "container"			=> false,
                        "menu_class"		=> "",
                        "menu_id"			=> "",
                        "walker"			=> new cleaner_walker_nav_menu
                    )
                );
                ?>
            </div>
        </header>
        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a class="btn-floating btn-large grey" onclick="window.scrollTo(0, 0);">
                <i class="material-icons">keyboard_arrow_up</i>
            </a>
        </div>
