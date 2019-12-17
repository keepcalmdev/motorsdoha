<?php
$user_id = get_post_meta(get_the_ID(), 'stm_car_user', true);
$user_email = get_userdata($user_id)->user_email;
$show_email = get_user_meta($user_id, 'stm_show_email', true);
$post_id = get_the_ID();
$car_title = get_post_meta($post_id, 'car_title', true);
$car_condition = get_post_meta($post_id, 'condition', true);

//data
$filter = stm_listings_filter();
//make
$car_make = get_post_meta($post_id, 'make', true);
$car_make = $filter["options"]["make"][$car_make]["label"];
//model
$car_model = get_post_meta($post_id, 'serie', true);
$car_model = $filter["options"]["serie"][$car_model]["label"];
//year
$car_year = get_post_meta($post_id, 'ca-year', true);
//car name
$car_name = $car_make." ".$car_model." ".$car_year;
//lang
$lang = get_locale();
$custom_car_title = "";
if($car_title === ""){
   if($car_condition === "new-cars"){//Specific Car Page (New)
        if($lang !== "en_US"){
            $custom_car_title = "سيارة ".$car_name;
        } else {
            $custom_car_title = $car_name;
        }
    } else if ($car_condition === "used-cars"){//Specific Car Page (Used)
        if($lang !== "en_US"){
            $custom_car_title = "سيارة ".$car_name;
        } else {
            $custom_car_title = "Used ".$car_name;
        }
    } 
}
?>
<div class="row">
    <div class="col-md-9 col-sm-12 col-xs-12">
        <div class="stm-single-car-content">
            <h1 class="title h2"><?php echo ($car_title === "")? $custom_car_title : $car_title; ?></h1>

            <!--Actions-->
            <?php get_template_part( 'partials/single-car/car', 'actions' ); ?>

            <!--Gallery-->
            <?php get_template_part( 'partials/single-car/car', 'gallery' ); ?>

            <!--Car Gurus if is style BANNER-->
            <?php if ( strpos( get_theme_mod( "carguru_style", "STYLE1" ), "BANNER" ) !== false ) get_template_part( 'partials/single-car/car', 'gurus' ); ?>
            <?php //the_content(); ?>

            <?php //echo "<pre>"; print_r(get_post_meta(get_the_ID())); echo "</pre>"; ?>

<?php if (get_post_meta(get_the_ID(), 'image_360', true)) { ?>
    <iframe style="width: 100%; height: 400px; border: 0px;" src="<?php echo base64_decode(get_post_meta(get_the_ID(), 'image_360', true)); ?>"></iframe>
    <br>
    <br>
<?php } ?>

            <style type="text/css">.wpb_tour_tabs_wrapper.ui-tabs ul.wpb_tabs_nav > li {float: left;}</style>
            <div class="wpb_tabs wpb_content_element mynewtabs" data-interval="0">
                <div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs stm_tabs_style_1  vc_clearfix ui-widget ui-widget-content ui-corner-all">
                    <ul class="wpb_tabs_nav ui-tabs-nav vc_clearfix ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
                        <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tab-90676444-d4f2-8" aria-labelledby="ui-id-1" aria-selected="true" aria-expanded="true"><a href="#tab-90676444-d4f2-8" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">Vehicle overview</a></li>
                        <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tab-1446536320841-4-6" aria-labelledby="ui-id-5" aria-selected="false" aria-expanded="false"><a href="#tab-1446536320841-4-61" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-5">Seller Notes</a></li>
                        <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tab-745aa3c6-a316-2" aria-labelledby="ui-id-2" aria-selected="false" aria-expanded="false"><a href="#tab-745aa3c6-a316-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">Technical</a></li>
                        <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tab-1446536246604-2-8" aria-labelledby="ui-id-3" aria-selected="false" aria-expanded="false"><a href="#tab-1446536246604-2-8" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3">Features &amp; Options</a></li>
                        <!-- <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tab-1446536305473-3-8" aria-labelledby="ui-id-4" aria-selected="false" aria-expanded="false"><a href="#tab-1446536305473-3-8" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4">Location</a></li> -->
                        <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tab-1446536320841-4-6" aria-labelledby="ui-id-5" aria-selected="false" aria-expanded="false"><a href="#tab-1446536320841-4-6" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-5">Contact</a></li>
                    </ul>
                    <div id="tab-90676444-d4f2-8" class="wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false" style="display: block;">

                        <div class="wpb_text_column wpb_content_element ">
                            <div class="wpb_wrapper">
                                <?php 
                                    $ch = curl_init();
    
                                    $model = str_replace('-', '%20', str_replace(' ', '%20', get_post_meta(get_the_ID(), 'serie', true)));
                                    $make = str_replace('-', '%20', str_replace(' ', '%20', get_post_meta(get_the_ID(), 'make', true)));
                                    if (get_post_meta(get_the_ID(), 'make', true) == 'mercedes-benz') {
                                        $make = str_replace(' ', '%20', get_post_meta(get_the_ID(), 'make', true));
                                    }

                                    curl_setopt($ch, CURLOPT_URL, 'https://dohamotorsapi.azurewebsites.net/api/vehicles/getmodelinfo?make='.$make.'&year='.get_post_meta(get_the_ID(), 'ca-year', true).'&model='.$model);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


                                    $headers = array();
                                    $headers[] = 'Accept: */*';
                                    $headers[] = 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjAiLCJuYmYiOjE1NzE5MDcxODYsImV4cCI6MTU3MjA3OTk4NiwiaWF0IjoxNTcxOTA3MTg2fQ.d6elIUJ0pfzHhuQcnyigoAVqxOqLDAXDxy-vvuZ10Uc';
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                                    $result = curl_exec($ch);
                                    if (curl_errno($ch)) {
                                        // echo 'Error:' . curl_error($ch);
                                    }
                                    curl_close($ch);
                                    $contentcar = json_decode($result);
                                ?>
                                <h4 style="margin-bottom: 21px; font-weight: 400; line-height: 22px;"><?php echo isset($contentcar[0]) ? $contentcar[0]->overview : 'N/A'; ?></h4>
                            </div>
                        </div>
                    </div>

                    <div id="tab-1446536320841-4-61" class="wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false" style="display: none;">
                        <div class="wpb_text_column wpb_content_element ">
                            <div class="wpb_wrapper">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>

                    <div id="tab-745aa3c6-a316-2" class="wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-2" role="tabpanel" aria-hidden="true" style="display: none;">

                        <div class="stm-tech-infos">
                            <div class="stm-tech-title">
                                <i class="stm-icon-engine" style="font-size:27px;"></i>
                                <div class="title h5">Engine</div>
                            </div>

                            <table>
                                <tbody>

                                    <tr>
                                        <td>
                                            <span class="text-transform ">Power CC</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo get_post_meta(get_the_ID(), 'engine', true) ?></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span class="text-transform ">Engine Type</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo get_post_meta(get_the_ID(), 'engine_type', true) ?></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span class="text-transform ">Gear Box</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo get_post_meta(get_the_ID(), 'gearbox', true) ?></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span class="text-transform ">Horsepower</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo get_post_meta(get_the_ID(), 'power', true) ?></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span class="text-transform ">Engine Torque</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo get_post_meta(get_the_ID(), 'torque', true) ?></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="stm-tech-infos">
                            <div class="stm-tech-title">
                                <i class="stm-icon-speedometr3" style="font-size:28px;"></i>
                                <div class="title h5">Performance</div>
                            </div>

                            <table>
                                <tbody>

                                    <tr>
                                        <td>
                                            <span class="text-transform ">Mileage</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo get_post_meta(get_the_ID(), 'mileage', true) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-transform ">Fuel Consumption (100 KM/L)</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo get_post_meta(get_the_ID(), 'fueleconomy100kmpl', true) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-transform ">Fuel Consumption (KM/L)</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo get_post_meta(get_the_ID(), 'fueleconomykmpl', true) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-transform ">0-100 KM/Sec</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo get_post_meta(get_the_ID(), 'zerotohundred', true) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-transform ">Max Speed</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo get_post_meta(get_the_ID(), 'topspeed', true) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-transform ">Country of Origin</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo ucwords(str_replace('-', ' ', get_post_meta(get_the_ID(), 'countryoforigin', true))) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-transform ">Car Class</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo ucwords(str_replace('-', ' ', get_post_meta(get_the_ID(), 'class', true))) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-transform ">Body Style</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo ucwords(str_replace('-', ' ', get_post_meta(get_the_ID(), 'bodystyle', true))) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-transform ">Car Weight (KG)</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo get_post_meta(get_the_ID(), 'weight', true) ?></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="stm-tech-infos">
                            <div class="stm-tech-title">
                                <i class="stm-icon-transmission2" style="font-size:35px;"></i>
                                <div class="title h5">Transmission</div>
                            </div>

                            <table>
                                <tbody>

                                    <tr>
                                        <td>
                                            <span class="text-transform subtitle">Transmission</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo get_post_meta(get_the_ID(), 'transmission', true) ?></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <span class="text-transform ">Displacement</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="h6"><?php echo get_post_meta(get_the_ID(), 'drive', true) ?></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div id="tab-1446536246604-2-8" class="wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-3" role="tabpanel" aria-hidden="true" style="display: none;">
                        <div class="vc_row wpb_row vc_inner vc_row-fluid vc_custom_1445931891055">
                            <div class="wpb_column vc_column_container vc_col-sm-12">
                                <div class="vc_column-inner">
                                    <div class="wpb_wrapper">
	                                    <?php
                                            $features = get_post_meta(get_the_ID(), 'additional_features', true);
                                            if( $features !== '' ) :
                                                $features_array = explode( ',', $features );
                                            ?>
                                                <h4 style="color: #252628;text-align: left;font-family:Montserrat;font-weight:400;font-style:normal" class="vc_custom_heading vc_custom_1561380831678">Features</h4>
                                                <div class="wpb_text_column wpb_content_element ">
                                                    <div class="wpb_wrapper">
                                                        <ul class="list-style-1" style="-webkit-column-count: 3; -moz-column-count: 3; column-count: 3;">
                                                            <?php foreach ($features_array as $key => $feature): ?>
                                                                <li><?php echo $feature; ?></li>
                                                            <?php endforeach ?>
                                                        </ul>

                                                    </div>
                                                </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab-1446536305473-3-8" class="wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-4" role="tabpanel" aria-hidden="true" style="display: none;">

                        <div style="width: 100%; height: 366px; position: relative; overflow: hidden;" id="stm_map-472120538" class="stm_gmap">
                            <div style="height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);">
                                <div style="overflow: hidden;"></div>
                                <div class="gm-style" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px;">
                                    <div tabindex="0" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; cursor: url(&quot;https://maps.gstatic.com/mapfiles/openhand_8_8.cur&quot;), default; touch-action: pan-x pan-y;">
                                        <div style="z-index: 1; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(0px, 0px);">
                                            <div style="position: absolute; left: 0px; top: 0px; z-index: 100; width: 100%;">
                                                <div style="position: absolute; left: 0px; top: 0px; z-index: 0;">
                                                    <div style="position: absolute; z-index: 982; transform: matrix(1, 0, 0, 1, 0, 0);">
                                                        <div style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px;">
                                                            <div style="width: 256px; height: 256px;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="position: absolute; left: 0px; top: 0px; z-index: 101; width: 100%;"></div>
                                            <div style="position: absolute; left: 0px; top: 0px; z-index: 102; width: 100%;"></div>
                                            <div style="position: absolute; left: 0px; top: 0px; z-index: 103; width: 100%;">
                                                <div style="position: absolute; left: 0px; top: 0px; z-index: -1;">
                                                    <div style="position: absolute; z-index: 982; transform: matrix(1, 0, 0, 1, 0, 0);">
                                                        <div style="width: 256px; height: 256px; overflow: hidden; position: absolute; left: 0px; top: 0px;"></div>
                                                    </div>
                                                </div>
                                                <div style="width: 48px; height: 59px; overflow: hidden; position: absolute; left: -24px; top: -59px; z-index: 0;"><img alt="" src="<?php bloginfo("url") ?>/wp-content/themes/motors/assets/images/map-marker.png" draggable="false" style="position: absolute; left: 0px; top: 0px; user-select: none; width: 48px; height: 59px; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                            </div>
                                            <div style="position: absolute; left: 0px; top: 0px; z-index: 0;"></div>
                                        </div>
                                        <div class="gm-style-pbc" style="z-index: 2; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; opacity: 0;">
                                            <p class="gm-style-pbt"></p>
                                        </div>
                                        <div style="z-index: 3; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; touch-action: pan-x pan-y;">
                                            <div style="z-index: 4; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(0px, 0px);">
                                                <div style="position: absolute; left: 0px; top: 0px; z-index: 104; width: 100%;"></div>
                                                <div style="position: absolute; left: 0px; top: 0px; z-index: 105; width: 100%;"></div>
                                                <div style="position: absolute; left: 0px; top: 0px; z-index: 106; width: 100%;">
                                                    <div title="" style="width: 64px; height: 75px; overflow: hidden; position: absolute; opacity: 0; cursor: pointer; touch-action: none; left: -32px; top: -67px; z-index: 0;"><img alt="" src="<?php bloginfo("url") ?>/wp-content/themes/motors/assets/images/map-marker.png" draggable="false" style="position: absolute; left: 0px; top: 0px; width: 64px; height: 75px; user-select: none; border: 0px; padding: 0px; margin: 0px; max-width: none;"></div>
                                                </div>
                                                <div style="position: absolute; left: 0px; top: 0px; z-index: 107; width: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <iframe aria-hidden="true" frameborder="0" src="about:blank" style="z-index: -1; position: absolute; width: 100%; height: 100%; top: 0px; left: 0px; border: none;"></iframe>
                                </div>
                            </div>
                        </div>

                        <script>
                            jQuery(document).ready(function($) {
                                google.maps.event.addDomListener(window, 'load', init);

                                var center, map;

                                function init() {
                                    center = new google.maps.LatLng(39.070379, -96.281433);
                                    var mapOptions = {
                                        zoom: 18,
                                        center: center,
                                        scrollwheel: true
                                    };
                                    var mapElement = document.getElementById('stm_map-472120538');
                                    map = new google.maps.Map(mapElement, mapOptions);
                                    var marker = new google.maps.Marker({
                                        position: center,
                                        icon: '<?php bloginfo("url") ?>/wp-content/themes/motors/assets/images/map-marker.png',
                                        map: map
                                    });

                                    var infowindow = new google.maps.InfoWindow({
                                        content: '<h6>1208 Road 345, Allen, KS 66833, United States</h6>',
                                        pixelOffset: new google.maps.Size(0, 71),
                                        boxStyle: {
                                            width: "320px"
                                        }
                                    });

                                    marker.addListener('click', function() {
                                        infowindow.open(map, marker);
                                        map.setCenter(center);
                                    });
                                }

                                $('.vc_tta-tab').on('click', function() {
                                    if (typeof map != 'undefined' && typeof center != 'undefined') {
                                        setTimeout(function() {
                                            google.maps.event.trigger(map, "resize");
                                            map.setCenter(center);
                                        }, 1000);
                                    }
                                })

                                $('a').on('click', function() {
                                    if (typeof $(this).data('vc-accordion') !== 'undefined' && typeof map != 'undefined' && typeof center != 'undefined') {
                                        setTimeout(function() {
                                            google.maps.event.trigger(map, "resize");
                                            map.setCenter(center);
                                        }, 1000);
                                    }
                                })

                                $('.wpb_tour_tabs_wrapper.ui-tabs ul.wpb_tabs_nav > li').on('click', function() {
                                    if (typeof map != 'undefined' && typeof center != 'undefined') {
                                        setTimeout(function() {
                                            google.maps.event.trigger(map, "resize");
                                            map.setCenter(center);
                                        }, 1000);
                                    }
                                })

                                $(window).resize(function() {
                                    if (typeof map != 'undefined' && typeof center != 'undefined') {
                                        setTimeout(function() {
                                            map.setCenter(center);
                                        }, 1000);
                                    }
                                })
                            });
                        </script>

                        <!--Infowindow styles-->
                        <style type="text/css">
                            /* white background and box outline */
                            
                            .gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div {
                                border: none !important;
                                box-shadow: rgba(0, 0, 0, 0.1) 5px 5px 5px !important;
                            }
                            /* arrow first */
                            
                            .gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div > div:first-child > div {
                                left: 3px !important;
                                transform: skewX(36deg) !important;
                                box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 1px !important;
                                z-index: 40;
                            }
                            /* arrow second */
                            
                            .gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div > div:nth-child(2) > div {
                                left: 2px !important;
                                transform: skewX(-36deg) !important;
                                box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 1px !important;
                                z-index: 40;
                            }
                            
                            .gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div:first-child {
                                display: none !important;
                            }
                            
                            .gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div:nth-child(2) {
                                background-color: transparent !important;
                                box-shadow: none !important;
                            }
                            
                            .gm-style .gm-style-iw {
                                padding: 10px 10px 5px 10px;
                                min-height: 54px;
                                width: 240px !important;
                            }
                            
                            .gm-style .gm-style-iw > div > div {
                                overflow: hidden !important;
                            }
                            
                            .gm-style .gm-style-iw h6 {
                                margin-bottom: 0 !important;
                                font-weight: 400 !important;
                            }
                        </style>

                    </div>

                   


                <!-- <pre>
                    <!-- <?php //print_r(get_userdata(get_current_user_id())); ?> -->
                        <!-- <?php// print_r(get_user_meta(get_current_user_id())); ?> 
                </pre> -->


                    <div id="tab-1446536320841-4-6" class="wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-5" role="tabpanel" aria-hidden="true" style="display: none;">
                        <div class="vc_row wpb_row vc_inner vc_row-fluid single-car-form">
                            <div class="stm-border-right wpb_column vc_column_container vc_col-sm-4 col-md-4">
                                <div class="vc_column-inner">
                                    <div class="wpb_wrapper">

                                        <div class="icon-box vc_custom_1448521886982 icon_box_58636 stm-layout-box-car_dealer  " style="color:#232628">
                                            <div class="boat-line"></div>
                                            <div class="icon vc_custom_1448521886977 boat-third-color" style="font-size:27px;color:#cc621a; ">
                                                <i class="fa fa-envelope-o"></i>
                                            </div>
                                            <div class="icon-text">
                                                <h4 class="title heading-font" style="color:#232628">Contact Information        </h4>
                                            </div>
                                        </div>

                                        <style>
                                        .icon_box_58636:after,
                                            .icon_box_58636:before {
                                                background-color: #ffffff;
                                            }
                                        }
                                        .icon_box_58636 .icon-box-bottom-triangle {
                                            border-right-color: rgba(255, 255, 255, 0.9);
                                        }
                                        .icon_box_58636:hover .icon-box-bottom-triangle {
                                            border-right-color: rgba(255, 255, 255, 1);
                                        }
                                        .icon-box .icon-text .content a {
                                            color: #232628;
                                        }
                                        </style>
                                        <div class="wpb_text_column wpb_content_element  vc_custom_1445945228480">
                                            <div class="wpb_wrapper">
                                                <p style="line-height: 18px;"><span style="color: #888888; font-size: 13px;">
                                                     <?php echo get_user_meta(get_current_user_id(), 'stm_seller_notes',true); ?>
                                                </span></p>

                                            </div>
                                        </div>

	                                    <?php
                                            $dealer_location = get_user_meta($user_id, 'stm_dealer_location', true);
                                            if( $dealer_location ) : ?>

                                                <div class="icon-box vc_custom_1448604655830 icon_box_54380 stm-layout-box-car_dealer  " style="color:#232628">
                                                    <div class="boat-line"></div>
                                                    <div class="icon vc_custom_1448604655827 boat-third-color" style="font-size:30px;color:#cc621a; ">
                                                        <i class="stm-icon-pin"></i>
                                                    </div>
                                                    <div class="icon-text">
                                                        <div class="content">
                                                            <h5>
                                                                <?php echo $dealer_location; ?>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>

                                        <?php endif; ?>

                                        <style>
                                        .icon_box_54380:after,
                                            .icon_box_54380:before {}
                                        }
                                        .icon_box_54380 .icon-box-bottom-triangle {
                                            border-right-color: rgba(, 0.9);
                                        }
                                        .icon_box_54380:hover .icon-box-bottom-triangle {
                                            border-right-color: rgba(, 1);
                                        }
                                        .icon-box .icon-text .content a {
                                            color: #232628;
                                        }
                                        </style>

                                        <div class="icon-box vc_custom_1448604661449 icon_box_73050 stm-layout-box-car_dealer  " style="color:#232628">
                                            <div class="boat-line"></div>
                                            <div class="icon vc_custom_1448604661446 boat-third-color" style="font-size:30px;color:#cc621a; ">
                                                <i class="stm-icon-phone"></i>
                                            </div>
                                            <div class="icon-text">
                                                <div class="content">
                                                    <h6 style="margin-bottom: 0; font-weight: 400;"><span style="color: #888888; font-size: 13px;">PHONE:</span></h6>
                                                    <a href="tel:<?php echo get_user_meta($user_id, 'stm_phone',true); ?>">
                                                        <h5>
                                                            <?php echo get_user_meta($user_id, 'stm_phone' ,true); ?>
                                                        </h5>
                                                    </a> 
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <style>
                                        .icon_box_73050:after,
                                            .icon_box_73050:before {}
                                        }
                                        .icon_box_73050 .icon-box-bottom-triangle {
                                            border-right-color: rgba(, 0.9);
                                        }
                                        .icon_box_73050:hover .icon-box-bottom-triangle {
                                            border-right-color: rgba(, 1);
                                        }
                                        .icon-box .icon-text .content a {
                                            color: #232628;
                                        }
                                        </style>

                                        <?php if ( $user_email && $show_email === 'show' ) : ?>
                                            <div class="icon-box vc_custom_1448604718190 icon_box_93931 stm-layout-box-car_dealer  " style="color:#232628">
                                                <div class="boat-line"></div>
                                                <div class="icon vc_custom_1448604718188 boat-third-color" style="font-size:30px;color:#cc621a; ">
                                                    <i class="stm-icon-mail"></i>
                                                </div>
                                                <div class="icon-text">
                                                    <div class="content">
                                                        <h6 style="margin-bottom: 0; font-weight: 400;"><span style="color: #888888; font-size: 13px;">EMAIL:</span></h6>
                                                        <h5><a href="mailto:<?php echo $user_email; ?>">
                                                                <?php echo $user_email; ?>
                                                            </a>
                                                        </h5>

                                                    </div>
                                                </div>
                                            </div>

                                        <?php endif; ?>

                                        <style>
                                        .icon_box_93931:after,
                                            .icon_box_93931:before {}
                                        }
                                        .icon_box_93931 .icon-box-bottom-triangle {
                                            border-right-color: rgba(, 0.9);
                                        }
                                        .icon_box_93931:hover .icon-box-bottom-triangle {
                                            border-right-color: rgba(, 1);
                                        }
                                        .icon-box .icon-text .content a {
                                            color: #232628;
                                        }
                                        </style>
                                    </div>
                                </div>
                            </div>
                            <div class="stm-col-pad-left wpb_column vc_column_container vc_col-sm-8 col-md-8">
                                <div class="vc_column-inner">
                                    <div class="wpb_wrapper">

                                        <div class="icon-box vc_custom_1448522065607 icon_box_5376 stm-layout-box-car_dealer  " style="color:#232628">
                                            <div class="boat-line"></div>
                                            <div class="icon vc_custom_1448522065606 boat-third-color" style="font-size:27px;color:#6c98e1; ">
                                                <i class="fa fa-paper-plane"></i>
                                            </div>
                                            <div class="icon-text">
                                                <h4 class="title heading-font" style="color:#232628">Message to Vender</h4>
                                            </div>
                                        </div>

                                        <style>
                                        .icon_box_5376:after,
                                            .icon_box_5376:before {
                                                background-color: #ffffff;
                                            }
                                        }
                                        .icon_box_5376 .icon-box-bottom-triangle {
                                            border-right-color: rgba(255, 255, 255, 0.9);
                                        }
                                        .icon_box_5376:hover .icon-box-bottom-triangle {
                                            border-right-color: rgba(255, 255, 255, 1);
                                        }
                                        .icon-box .icon-text .content a {
                                            color: #232628;
                                        }
                                        </style>
                                        <!-- <div role="form" class="wpcf7" id="wpcf7-f500-p1607-o1" lang="en-US" dir="ltr">
                                            <div class="screen-reader-response"></div>
                                            <form action="/listings/bmw-570i-navi-leather-turbo/#wpcf7-f500-p1607-o1" method="post" class="wpcf7-form" novalidate="novalidate">
                                                <div style="display: none;">
                                                    <input type="hidden" name="_wpcf7" value="500">
                                                    <input type="hidden" name="_wpcf7_version" value="5.1.3">
                                                    <input type="hidden" name="_wpcf7_locale" value="en_US">
                                                    <input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f500-p1607-o1">
                                                    <input type="hidden" name="_wpcf7_container_post" value="1607">
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <div class="form-label">Your Name:</div>
                                                            <p> <span class="wpcf7-form-control-wrap your-name"><input type="text" name="your-name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false"></span>
                                                            </p>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-label">Your telephone number:</div>
                                                            <p> <span class="wpcf7-form-control-wrap your-tel"><input type="tel" name="your-tel" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-tel wpcf7-validates-as-required wpcf7-validates-as-tel" aria-required="true" aria-invalid="false"></span>
                                                            </p>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-label">Email:</div>
                                                            <p> <span class="wpcf7-form-control-wrap your-email"><input type="email" name="your-email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" aria-required="true" aria-invalid="false"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6">
                                                        <div class="form-group-textarea">
                                                            <div class="form-label">Your Message</div>
                                                            <p> <span class="wpcf7-form-control-wrap your-message"><textarea name="your-message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" aria-invalid="false">I am interested in a price quote on this vehicle. Please contact me at your earliest convenience with your best price for this vehicle.</textarea></span>
                                                            </p>
                                                        </div>
                                                        <p>
                                                            <input type="submit" value="Submit" class="wpcf7-form-control wpcf7-submit"><span class="ajax-loader"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="wpcf7-response-output wpcf7-display-none"></div>
                                            </form>
                                        </div> -->
                                        <?php echo do_shortcode('[contact-form-7 id="3742" title="Send message to dealer_copy"]') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="stm-single-car-side">
            <?php
            if ( is_active_sidebar( 'stm_listing_car' ) ) {
                dynamic_sidebar( 'stm_listing_car' );
            } else {
                /*<!--Prices-->*/
                get_template_part( 'partials/single-car/car', 'price' );

                /*<!--Data-->*/
                get_template_part( 'partials/single-car/car', 'data' );

                /*<!--Rating Review-->*/
                get_template_part( 'partials/single-car/car', 'review_rating' );

                /*<!--MPG-->*/
                get_template_part( 'partials/single-car/car', 'mpg' );

                /*<!--Calculator-->*/
                get_template_part( 'partials/single-car/car', 'calculator' );
            }
            ?>

        </div>
    </div>
</div>
