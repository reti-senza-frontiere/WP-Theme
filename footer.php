<?php
global $menu;
?>
		<!-- Footer nav & social menu -->
		<nav id="footer_nav">
			<div class="nav-wrapper container">
				<?php
				wp_nav_menu(
					array(
						"theme_location"	=> "footer-nav-menu",
						"menu"				=> "Footer Nav Menu",
						"container"			=> false,
						"menu_class"		=> "left",
						"menu_id"			=> "footer-nav-menu",
						"walker"			=> new cleaner_walker_nav_menu()
					)
				);
				?>
				<ul class="social-menu right">
					<li>
						<a href="javascript:;" target="_blank" class="waves-effect waves-teal cyan-text">
							<span class="fa fa-fw fa-twitter"></span>
						</a>
					</li>
					<li>
						<a href="javascript:;" target="_blank" class="waves-effect waves-teal blue-text">
							<span class="fa fa-fw fa-facebook"></span>
						</a>
					</li>
					<li>
						<a href="https://plus.google.com/u/0/b/107745520427491992609/107745520427491992609/" target="_blank" class="waves-effect waves-teal red-text">
							<span class="fa fa-fw fa-google-plus"></span>
						</a>
					</li>
					<li>
						<a href="<?php bloginfo('rss2_url'); ?>" target="_blank" class="waves-effect waves-teal grey-text">
							<span class="fa fa-fw fa-feed"></span>
						</a>
					</li>
				</ul>
			</div>
		</nav>
		<!-- Footer -->
		<footer id="footer-main">
			<div class="container">
				<!-- Footer-widget area -->
				<div class="row">
					<div class="col m3 s6 s12">
						<?php
						wp_nav_menu(
							array(
							    "theme_location"	=> "widget-footer-menu-info",
							    "menu"				=> "Widget footer menu (Info)",
							    "container"			=> false,
							    "menu_class"		=> "",
							    "menu_id"			=> "footer-menu-info",
							    "walker"			=> new cleaner_walker_nav_menu()
							)
						);
						?>
					</div>
					<div class="col m3 s6 s12">
						<h3 class="widget-title"><?php print __("L'associazione", "rsf"); ?></h3>
						<?php
						wp_nav_menu(
							array(
								"theme_location"	=> "widget-footer-menu-associazione",
								"menu"				=> "Widget footer menu (Associazione)",
								"container"			=> false,
								"menu_class"		=> "",
								"menu_id"			=> "footer-menu-associazione",
								"walker"			=> new cleaner_walker_nav_menu()
							)
						);
						?>
					</div>
					<div class="col m3 s6 s12">
						<h3 class="widget-title"><?php print __("Attività", "rsf"); ?></h3>
						<?php
						wp_nav_menu(
							array(
								"theme_location"	=> "widget-footer-menu-attivita",
								"menu"				=> "Widget footer menu (Attività)",
								"container"			=> false,
								"menu_class"		=> "",
								"menu_id"			=> "footer-menu-attivita",
								"walker"			=> new cleaner_walker_nav_menu()
							)
						);
						?>
					</div>
					<div class="col m3 s6 s12">
						<h3 class="widget-title"><?php print __("Partners", "rsf"); ?></h3>
						<?php
						wp_nav_menu(
							array(
								"theme_location"	=> "widget-footer-menu-partners",
								"menu"				=> "Widget footer menu (Partners)",
								"container"			=> false,
								"menu_class"		=> "",
								"menu_id"			=> "footer-menu-partners",
								"walker"			=> new cleaner_walker_nav_menu()
							)
						);
						?>
					</div>
				</div>
				<div class="row">
					<div class="col l8 m6 s12">
						<div class="footer-site-info"><?php print __("Associazione senza scopo di lucro \"Reti Senza Frontiere\".<br>Tutti i diritti liberi.", "rsf"); ?></div>
					</div>
				</div>
			</div>
		</footer>
		<?php wp_footer(); ?>
	</body>

</html>
