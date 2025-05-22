<?php
/**
 * Block Name: Asen Location Map
 *
 * Google Map block for marking and linking a location.
 */

if ( is_admin() ) {
    echo '<h3 class="asen-block-heading">' . $block['title'] . '</h3>';
}

$className = '';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

?>
<section
    class="asen-location-map asen-location-map-<?php echo $block['id']; echo $className; ?><?php echo get_field('full_width') ? ' full-width' : ' fixed-width'; ?>">
    <div class="inside"
        style="<?php if (!get_field('full_width')) echo 'max-width: ' . get_field('block_max_width') . 'px;'; ?>">
        <div class="heading-container">
            <h2 class="<?php echo get_field('heading_text_transform'); ?>"><?php echo get_field('heading'); ?></h2>
        </div>
        <?php if (!get_field('google_maps') ) : ?>
        <div id="mapDiv" class="leaflet" style="width: 800px; height: 500px"></div>
        <?php else : ?>
        <div id="map" class="google-map" style="width: 100%; height: 500px"></div>

        <script>
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(
                () => d[l](f, ...n))
        })
        ({
            key: "<?php echo get_field('gm_api_key'); ?>",
            v: "weekly"
        });
        </script>
        <?php endif; ?>
</section>


<?php $heading_size = get_field('heading_font_size'); ?>
<style>
.asen-location-map-<?php echo $block['id'];

?> {
    <?php $top_padding=get_field('top_padding');
    $bottom_padding=get_field('bottom_padding');
    $top_margin=get_field('top_margin');
    $bottom_margin=get_field('bottom_margin');

    if ($top_padding) {
        echo 'padding-top: '. $top_padding . 'px;';
        echo '@media (max-width: 1440px) {padding-top: '. $top_padding * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {padding-top: '. $top_padding * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {padding-top: '. $top_padding * 0.55 . 'px;}';
    }

    if ($bottom_padding) {
        echo 'padding-bottom: '. $bottom_padding . 'px;';
        echo '@media (max-width: 1440px) {padding-bottom: '. $bottom_padding * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {padding-bottom: '. $bottom_padding * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {padding-bottom: '. $bottom_padding * 0.55 . 'px;}';
    }

    if ($top_margin) {
        echo 'margin-top: '. $top_margin . 'px;';
        echo '@media (max-width: 1440px) {margin-top: '. $top_margin * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {margin-top: '. $top_margin * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {margin-top: '. $top_margin * 0.55 . 'px;}';
    }

    if ($bottom_margin) {
        echo 'margin-bottom: '. $bottom_margin . 'px;';
        echo '@media (max-width: 1440px) {margin-bottom: '. $bottom_margin * 0.8 . 'px;}';
        echo '@media (max-width: 1024px) {margin-bottom: '. $bottom_margin * 0.7 . 'px;}';
        echo '@media (max-width: 768px) {margin-bottom: '. $bottom_margin * 0.55 . 'px;}';
    }

    ?>h2 {
        font-size: <?php echo get_field('heading_font_size') . 'px';
        ?>;
        color: <?php echo get_field('heading_color');
        ?>;

        <?php if (isset($heading_size) && $heading_size > 40) {
            $heading_size=round($heading_size * 0.85);
        }

        ?>@media (max-width: 1200px) {
            font-size: <?php if (isset($heading_size)) echo $heading_size . 'px';
            ?>;
        }

        <?php if (isset($heading_size) && $heading_size > 40) {
            $heading_size=round($heading_size * 0.8);
        }

        ?>@media (max-width: 640px) {
            font-size: <?php if (isset($heading_size)) echo $heading_size . 'px';
            ?>;
        }
    }

    a.directions-link {
        color: <?php echo get_field('link_color');
        ?>;
    }

    a.directions-link:hover {
        color: <?php echo get_field('link_hover_color');
        ?>;
    }
}
</style>

<?php
if (get_field('marker_icon')) {
    $src          = get_field('marker_icon');
    $upload_dir   = wp_upload_dir();
    $image_path   = str_replace( $upload_dir[ 'baseurl' ], $upload_dir[ 'basedir' ], $src );
    $getimagesize = wp_getimagesize( $image_path );

}
?>

<script defer>
<?php if (!get_field('google_maps')) : ?>
    // Leaflet.js
    (function($) {
        var address = "<?php echo get_field('address'); ?>",
            icon = null

        // Custom icon
        <?php if (get_field('marker_icon')) : ?>
        icon = L.icon({
            iconUrl: "<?php echo get_field('marker_icon'); ?>",
            iconSize: [<?php echo $getimagesize[0] ? $getimagesize[0] : 40; ?>,
                <?php echo $getimagesize[1] ? $getimagesize[1] : 40; ?>
            ],
            iconAnchor: [<?php echo $getimagesize[0] ? ($getimagesize[0] / 2) : 20; ?>,
                <?php echo $getimagesize[1] ? $getimagesize[1] : 40; ?>
            ],
            popupAnchor: [0, <?php echo $getimagesize[1] ? ($getimagesize[1] * -1) : -40; ?>]
        })
        <?php endif; ?>

        // Create map if address is provided
        if (address.length > 0) {
            const req = $.get(location.protocol + '//nominatim.openstreetmap.org/search?format=json&q=' +
                    address)
                .done(
                    function(data) {
                        var lon = data[0].lon,
                            lat = data[0].lat,
                            map = L.map('mapDiv').setView([lat, lon], 16);

                        L.tileLayer(
                            'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                                maxZoom: 19
                            }).addTo(map);

                        // add marker to the map
                        if (icon) {
                            var marker = L.marker([lat, lon], {
                                icon: icon
                            }).addTo(map);
                        } else {
                            var marker = L.marker([lat, lon]).addTo(map);
                        }

                        // add popup to the marker
                        marker.bindPopup(
                                <?php if (get_field('popup_content')) : ?> '<span class="business-name"><?php echo get_field('popup_content'); ?></span><br>' +
                                <?php endif; ?> '<span class="address">' + address + '</span><br>'
                                <?php if (get_field('maps_link')) : ?> +
                                '<a class="directions-link" href="<?php echo get_field('maps_link'); ?>" target="_blank">Get Directions</a>'
                                <?php endif; ?>
                            )
                            .openPopup()

                        var mapElement = document.getElementById('mapDiv');
                        mapElement.style.width = '100%';
                        mapElement
                            .style.height = '500px';
                        map.invalidateSize();
                    })
        }
    })(jQuery)

<?php else : ?>
// Google Maps API
// Initialize and add the map
let map;

async function initMap() {
    const position = {
        lat: -25.344,
        lng: 131.031
    };
    // Request needed libraries.
    const {
        Map
    } = await google.maps.importLibrary("maps");
    const {
        AdvancedMarkerElement
    } = await google.maps.importLibrary("marker");

    // The map, centered at Uluru
    map = new Map(document.getElementById("map"), {
        zoom: 16,
        center: position,
        mapId: "DEMO_MAP_ID",
    });

    // The marker, positioned at Uluru
    const marker = new AdvancedMarkerElement({
        map: map,
        position: position,
        title: "Uluru",
    });
}

initMap();
<?php endif; ?>
</script>