<?php
$menu["header"]["main"] = array(
    "theme_location"	=> "header-menu",
    "menu"				=> "Header Menu",
    "container"			=> false,
    "menu_class"		=> "right hide-on-med-and-down",
    "menu_id"			=> "nav-header",
    "walker"			=> new cleaner_walker_nav_menu()
);
$menu["header"]["vertical_black"] = array(
    "theme_location"	=> "header-menu",
    "menu"				=> "Header Menu",
    "container"			=> false,
    "menu_class"		=> "",
    "menu_id"			=> "",
    "walker"			=> new cleaner_walker_nav_menu
);
$menu["footer"]["social_nav"] = array(
    "theme_location"	=> "footer-nav-menu",
    "menu"				=> "Footer Nav Menu",
    "container"			=> false,
    "menu_class"		=> "left",
    "menu_id"			=> "footer-nav-menu",
    "walker"			=> new cleaner_walker_nav_menu()
);
$menu["footer"]["info"] = array(
    "theme_location"	=> "widget-footer-menu-info",
    "menu"				=> "Widget footer menu (Info)",
    "container"			=> false,
    "menu_class"		=> "",
    "menu_id"			=> "footer-menu-info",
    "walker"			=> new cleaner_walker_nav_menu()
);
$menu["footer"]["associazione"] = array(
    "theme_location"	=> "widget-footer-menu-associazione",
    "menu"				=> "Widget footer menu (Associazione)",
    "container"			=> false,
    "menu_class"		=> "",
    "menu_id"			=> "footer-menu-associazione",
    "walker"			=> new cleaner_walker_nav_menu()
);
$menu["footer"]["attivita"] = array(
    "theme_location"	=> "widget-footer-menu-attivita",
    "menu"				=> "Widget footer menu (Attività)",
    "container"			=> false,
    "menu_class"		=> "",
    "menu_id"			=> "footer-menu-attivita",
    "walker"			=> new cleaner_walker_nav_menu()
);
$menu["footer"]["partners"] = array(
    "theme_location"	=> "widget-footer-menu-partners",
    "menu"				=> "Widget footer menu (Partners)",
    "container"			=> false,
    "menu_class"		=> "",
    "menu_id"			=> "footer-menu-partners",
    "walker"			=> new cleaner_walker_nav_menu()
);

get_header();
?>
        <div class="container-fluid">
        	<div class="row">
                <?php if(have_posts()) : ?>
                    <?php while(have_posts()) : the_post(); ?>
                        <div id="container-main" class="container-fluid">
                            <div class="row">
                                <div class="container">
                                    <div class="row">
                                        <div class="col l12 m12 s12">
                                            <?php
                                            if(!is_front_page()) {
                                                the_title("<h1>", "</h1>");
                                            }
                                            breadcrumb();
                                            the_content();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                <?php endif; ?>
            </div>
        </div>

        <?php get_footer(); ?>
