<?php
/*
	cambiare sempre i nomi delle DUE funzioni
*/

/*
//settings
$settings[basename(__FILE__, '.php')] = array(
	'page_title'		=> __('User comments', 'rsf'),
	'menu_name'			=> __('Comments', 'rsf')
);

//inizializzo
function example_admin_init() { //****************************************************************** da cambiare
	global $settings;
    add_menu_page(
		$settings[basename(__FILE__, '.php')]['page_title'],	//titolo pagina
		$settings[basename(__FILE__, '.php')]['menu_name'],		//titolo menu
		'manage_options',				//chi puo' utilizzarla
		basename(__FILE__, '.php'),		//slug
		basename(__FILE__, '.php'),		//nome funzione
		'dashicons-format-status',		//icona //https://developer.wordpress.org/resource/dashicons/
		10								//posizione
	);
}
add_action('admin_menu', basename(__FILE__, '.php').'_admin_init');

//head_foot della tabella
function table_comments_object($name = 'thead') {
	?>
	<<?php echo $name; ?>>
		<tr>
			<th scope="col" style="text-align:center;width:40px;"><?php echo __('Post', 'rsf'); ?></th>
			<th scope="col" style="width:110px;"><?php echo __('User', 'rsf'); ?></th>
			<th scope="col"><?php echo __('Comment', 'rsf'); ?></th>
			<th scope="col" style="width:110px;"><?php echo __('Date', 'rsf'); ?></th>
			<th scope="col" style="text-align:center;width:40px;"><?php echo __('View', 'rsf'); ?></th>
			<th scope="col" style="text-align:center;width:70px;"><?php echo __('Moderate', 'rsf'); ?></th>
		</tr>
	</<?php echo $name; ?>>
	<?php
}

//stampo la pagina
function example() { //****************************************************************** da cambiare
	global $settings;
	$data = array_merge($_GET, $_POST);
	if(isset($data['p']) && $data['p'] > 0 && is_numeric($data['p'])) { //paginazione
		$p = (int)$data['p']; //prendo da GET
	} else {
		$p = 1; //altrimenti e' uno
	}
	if(isset($data['post_id']) && $data['post_id'] > 0 && is_numeric($data['post_id'])) { //post_id
		$post_id = (int)$data['post_id']; //prendo da GET
	} else {
		$post_id = 0; //altrimenti e' vuoto
	}
	$num = 100;
	$start = ($p * $num) - $num;
	$page_title = $settings[basename(__FILE__, '.php')]['page_title']; //titolo pagina
	
	if (!current_user_can('manage_options'))  { //se non puoi maneggiare
		wp_die(__('You do not have sufficient permissions to access this page.', 'rsf'));
	}
	
	//navigazione
	$page_nav = '
	<div class="tablenav top">
		<div class="alignleft actions bulkactions">
			<select name="action" class="bulk-action-selector" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">';
	for($i=1; $i<=30; $i++) {
		$page_nav .= '<option value="'.admin_url('admin.php?page=comments&p=').(int)$i.'&post_id='.$post_id.'" ';
		if($i == $p) { //se e' la pagina corrente
			$page_nav .= 'selected="selected"'; //e' selezionata
		}
		$page_nav .= '>'.__('Page', 'rsf').' '.$i.'</option>';
	}
	$page_nav .= '
			</select>
		</div>
	</div>';
	
	//trovo i commenti
	$params = array(
		'post_id'	=> $post_id,
		'orderby'	=> 'date',
		'start'		=> $start,
		'limit'		=> $num
	);
	$comments = get_users_comments($params);
	?>
	<div class="wrap">
		<h2><?php echo $page_title; ?></h2>
		<?php echo $page_nav; ?>
		<table class="wp-list-table widefat fixed posts">
			<?php table_comments_object('thead'); ?>
			<tbody id="the-list">
				<?php
				if(count($comments)) { //se ci sono commenti
					$count = 1;
					foreach($comments as $comment) { //ciclo commenti
						if($count % 2) {
							$class_alternate = 'alternate';
						} else {
							$class_alternate = '';
						}
						
						$date = strtotime($comment->comment_date); //data
						?>
						<tr class="<?php echo $class_alternate; ?>">
							<td class="colspanchange" align="center"><a href="<?php echo get_edit_post_link($comment->post_id); ?>" target="_blank"><i class="icon-file-alt"></i></a></td>
							<td class="colspanchange"><a href="<?php echo get_edit_user_link($comment->user_id); ?>" target="_blank" class="row-title"><?php echo $comment->user_display_name; ?></a></td>
							<td class="colspanchange"><?php echo $comment->comment_content; ?></td>
							<td class="colspanchange"><?php echo date('Y-m-d H:i', $date); ?></td>
							<td class="colspanchange" align="center"><a href="<?php echo $comment->post_guid; ?>" target="_blank"><i class="icon-file-alt"></i></a></td>
							<td class="colspanchange" align="center"><a href="<?php echo admin_url('admin-ajax.php?action=ajax_moderate_comment&id='.(int)$comment->comment_id); ?>" onclick="return confirm('<?php echo __('Are you sure?', 'rsf'); ?>');"><i class="icon-remove"></i></a></td>
						</tr>
						<?php
						$count++;
					} //fine ciclo
				} else { //nessun commento trovato
					?>
					<tr class="no-items">
						<td class="colspanchange" colspan="6"><?php echo __('No comments found.', 'rsf'); ?></td>
					</tr>
					<?php
				}
				?>
			</tbody>
			<?php table_comments_object('tfoot'); ?>
		</table>
		<?php echo $page_nav; ?>
	</div>
	<?php
}
*/