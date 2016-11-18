<?php
//rinominare la classe e la funzione
/*
class banner300x250 extends WP_Widget { //****************************************************************** da cambiare
	function banner300x250() { //****************************************************************** da cambiare
		//istanzia l'oggetto genitore
		parent::__construct(basename(__FILE__, '.php'), __('Sportando - Banner 300x250', 'rsf'), array('description' => __('Widget for Banner with 300x250 size.', 'rsf')));
	}
	
	function widget($args, $instance) {
		//output del widget
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$content = $instance['content'];
		echo $before_widget; //apro il widget
			?>
			<div class="banner-300x250">
				<?php echo $content; ?>
			</div>
			<?php
		echo $after_widget; //chiudo il widget
	}
	
	function update($new_instance, $old_instance) {
		//salva le opzioni del widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['content'] = $new_instance['content'];
		return $instance;
	}
	
	function form($instance) {
		$defaults = array(
			'title' => __('Title', 'rsf'),
			'content' => __('Insert here the Banner (300x250) code.', 'rsf')
		);
		$instance = array_merge($defaults, $instance);
		//stampa il modulo di amministrazione con le opzioni del widget
		?>
		<div>
			<div>
				<label for="<?php echo $this->get_field_name('title'); ?>"><?php echo __('Title', 'rsf'); ?></label>
			</div>
			<div>
				<input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" maxlength="30" style="width:100%"; />
			</div>
		</div>
		<div>
			<div>
				<label for="<?php echo $this->get_field_name('content'); ?>"><?php echo __('Copy & Paste the code', 'rsf'); ?></label>
			</div>
			<div>
				<textarea name="<?php echo $this->get_field_name('content'); ?>" id="<?php echo $this->get_field_name('content'); ?>" style="width:100%;min-height:150px;resize:vertical;"><?php echo esc_attr($instance['content']); ?></textarea>
			</div>
		</div>
		<?php
	}
}

//registro il widget
register_widget(basename(__FILE__, '.php'));
*/