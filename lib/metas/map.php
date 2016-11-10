<?php
/*
	cambiare sempre i nomi delle TRE funzioni per ogni meta
	il nome del file coincide con il nome del meta. es "data.php" diventera "meta_data"
*/

//settings
/*
$settings[basename(__FILE__, '.php')] = array(
	'box_title'		=> __('Mappa', 'rsf'),
	'input_title'	=> __('Inserisci il pin sulla mappa', 'rsf'),
	'screen'		=> array('affitti'), //su che pagine deve andare
	'meta_key'		=> basename(__FILE__, '.php'),
	'box_id'		=> basename(__FILE__, '.php').'_box_id',
	'input_id'		=> basename(__FILE__, '.php').'_input_id'
);

//add meta box
if(!function_exists($settings[basename(__FILE__, '.php')]['meta_key'].'_add_meta_box')) {
	function map_add_meta_box() { //****************************************************************** da cambiare
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
    if(ICL_LANGUAGE_CODE == 'it') add_action('add_meta_boxes', $settings[basename(__FILE__, '.php')]['meta_key'].'_add_meta_box');
}

//html
if(!function_exists($settings[basename(__FILE__, '.php')]['meta_key'].'_meta_box_callback')) {
	function map_meta_box_callback($post) { //****************************************************************** da cambiare
		global $settings;
        $coords = get_post_meta($post->ID, $settings[basename(__FILE__, '.php')]['meta_key'], true); //recupero il valore
        if(empty($coords)) {
            $coords = array(
                'lat' => 41.929030,
                'lng' => 12.486869,
                'zoom' => 15
            );
        }
		?>
		<style type="text/css">
		    #search_map {width:100%;}
		</style>
		<div id="<?php echo $settings[basename(__FILE__, '.php')]['input_id']; ?>-label-container">
			<label for="<?php echo $settings[basename(__FILE__, '.php')]['input_id']; ?>"><?php echo $settings[basename(__FILE__, '.php')]['input_title']; ?></label>
		</div>
		<div id="<?php echo $settings[basename(__FILE__, '.php')]['input_id']; ?>-input-container">
			<input type="text" id="search_map" placeholder="<?php echo __('Cerca...', 'rsf'); ?>" maxlength="50" />
		</div>
        <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript">
            var geocoder,map, marker,addressField;
            jQuery(document).ready(function($) {
                function initialize() {
                    addressField = jQuery('#search_map');
                    geocoder = new google.maps.Geocoder();
                    var latlng = new google.maps.LatLng(<?php echo $coords['lat']; ?>,<?php echo $coords['lng']; ?>);
                    var myOptions = {
                        zoom: <?php echo $coords['zoom']; ?>,
                        center: latlng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        mapTypeControl: false,
                        streetViewControl: false
                    };
                    map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
                    marker = new google.maps.Marker({
                        map: map,
                        position: latlng,
                        draggable: true
                    });

                    google.maps.event.addListener(map, 'click', function(event) {
                        marker.setPosition(event.latLng);
                        updatePosition(event.latLng);
                    });

                    google.maps.event.addListener(marker, 'dragend', function(a) {
                        updatePosition(a.latLng);
                    });

                    google.maps.event.addListener(map, 'zoom_changed', function() {
                        zoomChangeBoundsListener = google.maps.event.addListener(map, 'bounds_changed', function(event) {
                            jQuery('#map_coord_zoom').val(this.getZoom());
                            google.maps.event.removeListener(zoomChangeBoundsListener);
                        });
                    });
                }

                initialize();

                jQuery('#search_map').keydown(function(event) {
                    if(event.keyCode == 13) {
                        event.preventDefault();
                        search();
                        return false;
                    }
                });

                jQuery('#search_map_button').click(function(ev) {
                    ev.preventDefault();
                    search();
                    return false;
                });
            });

            function updatePosition(latLng) {
                jQuery('#map_coord_lat').val(latLng.lat());
                jQuery('#map_coord_lng').val(latLng.lng());
            }

            function search() {
                geocoder.geocode(
                    {'address': addressField.val()},
                    function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            var loc = results[0].geometry.location;
                            // use loc.lat(), loc.lng()
                            map.setCenter(loc);
                            map.setZoom(15);
                            marker.setPosition(loc);
                            jQuery('#search_map').val(results[0].formatted_address);
                            updatePosition(loc);
                        } else {
                            alert('Not found: ' + status);
                        }
                    }
                );
                return false;
            }
        </script>
        <div id="wrapper-map">
            <div id="map_canvas" style="height:342px;margin-top: 10px;"></div>
        </div>
        <input type="hidden" id="map_coord_lat" name="<?php echo $settings[basename(__FILE__, '.php')]['meta_key']; ?>[lat]" value="<?php echo $coords['lat']; ?>" />
        <input type="hidden" id="map_coord_lng" name="<?php echo $settings[basename(__FILE__, '.php')]['meta_key']; ?>[lng]" value="<?php echo $coords['lng']; ?>" />
        <input type="hidden" id="map_coord_zoom" name="<?php echo $settings[basename(__FILE__, '.php')]['meta_key']; ?>[zoom]" value="<?php echo $coords['zoom']; ?>" />
		<?php
	}
}

//save
if(!function_exists($settings[basename(__FILE__, '.php')]['meta_key'].'_save_meta_box_data')) {
	function map_save_meta_box_data($post_id) { //****************************************************************** da cambiare
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
		$data = $_POST[$settings[basename(__FILE__, '.php')]['meta_key']];
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
