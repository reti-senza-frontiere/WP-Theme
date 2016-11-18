
/**
 * Mapbox
 * Reti Senza Frontiere key: pk.eyJ1IjoiZ3ViaSIsImEiOiJjaXY5d2hkZDkwMDB6MnpsYWYzMjE1ZGRjIn0.d_HL3zRQRj9DkuimcqjTqw
 * @see  https://www.mapbox.com/studio/account/tokens/
 */
L.mapbox.accessToken = "pk.eyJ1IjoiZ3ViaSIsImEiOiJjaXY5d2hkZDkwMDB6MnpsYWYzMjE1ZGRjIn0.d_HL3zRQRj9DkuimcqjTqw";
var map = L.mapbox.map("map", "mapbox.streets").setView([43.524673, 12.1605], 5);

/**
 * Search for places using Google Geocode API
 * @example URI https://maps.googleapis.com/maps/api/place/autocomplete/json?input={text}&key={key}
 * @key AIzaSyDZhGPRXg3WIPS5toziTEtQCk-2lR-QjbQ
 */
var timer;
jQuery("#reg_search_map").keyup(function() {
    clearTimeout(timer);
    var $this = jQuery(this),
        ms = 500,
        val = this.value,
        results = {};
    if(val.length >= 3) {
        timer = setTimeout(function() {
            jQuery.ajax({
                type: "GET",
                url: "https://maps.googleapis.com/maps/api/geocode/json",
                data: {
                    address: val,
                    key: "AIzaSyDZhGPRXg3WIPS5toziTEtQCk-2lR-QjbQ"
                },
                dataTye: "jsonp",
                success: function(data) {
                    // console.log(data);
                    var c = data.results.length;
                    if(c > 0) {
            			for(var i = 0; i < c; i++){
            				results[data.results[i].formatted_address] = null;
            			}
                        // console.warn(results);
                        jQuery(".autocomplete-content").remove();
                        jQuery("#reg_search_map").autocomplete({
                            data: results,
                            search: false,
                            callback: data.results
                        }, function(d) {
                            // console.info(d);
                            // map.setView(d.center);
                            L.marker([d.geometry.location.lat, d.geometry.location.lng], {
                                title: d.formatted_address
                            }).addTo(map);
                            map.fitBounds([
                                [d.geometry.viewport.southwest.lat, d.geometry.viewport.southwest.lng],
                                [d.geometry.viewport.northeast.lat, d.geometry.viewport.northeast.lng]
                            ]);
                            map.setZoom(15);
                            jQuery("#reg_map_data").val(JSON.stringify(d));
                            jQuery("#reg_street_no").val(d.address_components[0].long_name);
                            jQuery("#reg_street").val(d.address_components[1].long_name);
                            jQuery("#reg_city").val(d.address_components[2].long_name);
                            jQuery("#reg_province").val(d.address_components[4].long_name);
                            jQuery("#reg_region").val(d.address_components[5].short_name);
                            jQuery("#reg_postal_code").val(d.address_components[7].long_name);
                        });
                    }
                }
            });
        }, ms);
    }
});
