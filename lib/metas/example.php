<?php
/*
	cambiare sempre i nomi delle TRE funzioni per ogni meta
	il nome del file coincide con il nome del meta. es "data.php" diventera "meta_data"
*/

/*
//settings
$settings[basename(__FILE__, '.php')] = array(
	'box_title'		=> __('Source', 'rsf'),
	'input_title'	=> __('Insert the source of this news', 'rsf'),
	'screen'		=> array('post'), //su che pagine deve andare
	'meta_key'		=> basename(__FILE__, '.php'),
	'box_id'		=> basename(__FILE__, '.php').'_box_id',
	'input_id'		=> basename(__FILE__, '.php').'_input_id'
);

//add meta box
if(!function_exists($settings[basename(__FILE__, '.php')]['meta_key'].'_add_meta_box')) {
	function source_add_meta_box() { //****************************************************************** da cambiare
		global $settings;
		foreach($settings[basename(__FILE__, '.php')]['screen'] as $screen) {
			add_meta_box(
				$settings[basename(__FILE__, '.php')]['box_id'],
				$settings[basename(__FILE__, '.php')]['box_title'],
				$settings[basename(__FILE__, '.php')]['meta_key'].'_meta_box_callback',
				$screen,
				'side',
				'default',
				''
			);
		}
	}
	add_action('add_meta_boxes', $settings[basename(__FILE__, '.php')]['meta_key'].'_add_meta_box');
}

//html
if(!function_exists($settings[basename(__FILE__, '.php')]['meta_key'].'_meta_box_callback')) {
	function source_meta_box_callback($post) { //****************************************************************** da cambiare
		global $settings;
		$value = get_post_meta($post->ID, $settings[basename(__FILE__, '.php')]['meta_key'], true); //recupero il valore
		//stampo
		?>
		<style type="text/css">
		#<?php echo $settings[basename(__FILE__, '.php')]['input_id']; ?> {width:100%;}
		</style>
		<div id="<?php echo $settings[basename(__FILE__, '.php')]['input_id']; ?>-label-container">
			<label for="<?php echo $settings[basename(__FILE__, '.php')]['input_id']; ?>"><?php echo $settings[basename(__FILE__, '.php')]['input_title']; ?></label>
		</div>
		<div id="<?php echo $settings[basename(__FILE__, '.php')]['input_id']; ?>-input-container">
			<input type="text" id="<?php echo $settings[basename(__FILE__, '.php')]['input_id']; ?>" name="<?php echo $settings[basename(__FILE__, '.php')]['meta_key']; ?>" value="<?php echo esc_attr($value); ?>" maxlength="50" />
		</div>
		<?php
	}
}

//save
if(!function_exists($settings[basename(__FILE__, '.php')]['meta_key'].'_save_meta_box_data')) {
	function source_save_meta_box_data($post_id) { //****************************************************************** da cambiare
		global $settings;
		//if this is an autosave, our form has not been submitted, so we don't want to do anything.
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
		//check the user's permissions.
		if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) return;
		} else {
			if (!current_user_can('edit_post', $post_id)) return;
		}	
		//make sure that it is set.
		if (!isset($_POST[$settings[basename(__FILE__, '.php')]['meta_key']])) return;
		
		//sanitize user input.
		$data = sanitize_text_field($_POST[$settings[basename(__FILE__, '.php')]['meta_key']]);
		// update the meta field in the database.
		if(empty($data)) {
			delete_post_meta($post_id, $settings[basename(__FILE__, '.php')]['meta_key']); //delete
		} else {
			update_post_meta($post_id, $settings[basename(__FILE__, '.php')]['meta_key'], $data); //update
		}
	}
	add_action('save_post', $settings[basename(__FILE__, '.php')]['meta_key'].'_save_meta_box_data');
}
*/