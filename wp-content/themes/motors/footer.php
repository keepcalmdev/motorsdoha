</div> <!--main-->
</div> <!--wrapper-->
<?php do_action('stm_pre_footer'); ?>
<?php if ( !is_404() and !is_page_template('coming-soon.php') ) { ?>
    <footer id="footer">
        <?php get_template_part('partials/footer/footer'); ?>
        <?php get_template_part('partials/footer/copyright'); ?>
        <?php get_template_part('partials/global-alerts'); ?>
        <!-- Searchform -->
        <?php get_template_part('partials/modals/searchform'); ?>
    </footer>
<?php } elseif ( is_page_template('coming-soon.php') ) {
    get_template_part('partials/footer/footer-coming-soon');
}; ?>

<?php
if ( get_theme_mod('frontend_customizer') ) {
    get_template_part('partials/frontend_customizer');
}
?>

<?php wp_footer(); ?>

<?php
if ( !stm_is_auto_parts() ) :
    if ( is_singular( stm_listings_post_type() ) ) {
        if ( get_theme_mod('show_calculator', true ) ) get_template_part('partials/modals/car-calculator');
        if ( get_theme_mod('show_offer_price', false ) ) get_template_part('partials/modals/trade-offer');
        if ( get_theme_mod('show_trade_in', stm_is_motorcycle() ) ) get_template_part('partials/modals/trade-in');
    }

    if ( get_theme_mod('show_test_drive', true ) ) get_template_part('partials/modals/test-drive');
    get_template_part('partials/modals/get-car-price');

    $show_compare = ( is_single( get_the_ID() ) ) ? get_theme_mod('show_listing_compare', true ) : get_theme_mod('show_compare', true );
    if ($show_compare ) get_template_part('partials/single-car/single-car-compare-modal');

    if ( stm_is_rental() ) {
        get_template_part('partials/modals/rental-notification-choose-another-class');
        echo '<div class="stm-rental-overlay"></div>';
    }

    if ( stm_pricing_enabled() ) {
        get_template_part('partials/modals/limit_exceeded');
        get_template_part('partials/modals/subscription_ended');
    }
    ?>
    <?php if ( is_listing( array('listing_two', 'listing_three') ) ) : ?>
        <div class="notification-wrapper">
            <div class="notification-wrap">
                <div class="message-container">
                    <span class="message"></span>
                </div>
                <div class="btn-container">
                    <button class="notification-close">
                        <?php echo esc_html__('Close', 'motors'); ?>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="modal_content"></div>
<?php endif; ?>

<script type="text/javascript">

    $(function() {

        $('input[name="stm_s_s_engine"]').parent().find('.stm-label').html('<i class="stm-icon-engine_fill"></i> Engine CC');
        $('input[name="stm_s_s_engine"]').attr('placeholder', 'Enter Engine CC');

        $('select[name="stm_f_s[make]"]').change(function(){
            var make = $(this).val();
            var model = $('select[name="stm_f_s[serie]"]').val();
            var year = $('select[name="stm_f_s[ca_pre_year]"]').val();
            make_model_year(make, model, year);
        });
        $('select[name="stm_f_s[serie]"]').change(function(){
            var model = $(this).val();
            var year = $('select[name="stm_f_s[ca_pre_year]"]').val();
            var make = $('select[name="stm_f_s[make]"]').val();
            make_model_year(make, model, year);
        });
        $('select[name="stm_f_s[ca_pre_year]"]').change(function(){
            var year = $(this).val();
            var model = $('select[name="stm_f_s[serie]"]').val();
            var make = $('select[name="stm_f_s[make]"]').val();
            make_model_year(make, model, year);
        });

        function make_model_year(make, model, year){
            if (make != '' && model != '' && year != '') {
                $.get("<?php echo get_bloginfo('url'); ?>/wp-json/car/v1/getcardetails/?model="+model+"&year="+year+"&make="+make, function(data, status){
                    if (data.length) {
                        $('input[name="stm_s_s_countryOfOrigin"]').val(data[0].countryOfOrigin);
                        $('input[name="stm_s_s_class"]').val(data[0].class);
                        $('input[name="stm_s_s_bodyStyle"]').val(data[0].bodyStyle);
                        $('input[name="stm_s_s_weight"]').val(data[0].weight);
                        $('input[name="stm_s_s_engine_type"]').val(data[0].engine);
                        $('input[name="stm_s_s_gearBox"]').val(data[0].gearBox);
                        $('input[name="stm_s_s_power"]').val(data[0].power);
                        $('input[name="stm_s_s_torque"]').val(data[0].torque);
                        $('input[name="stm_s_s_fuelEconomy100KMPL"]').val(data[0].fuelEconomy100KMPL);
                        $('input[name="stm_s_s_fuelEconomyKMPL"]').val(data[0].fuelEconomyKMPL);
                        $('input[name="stm_s_s_zeroToHundred"]').val(data[0].zeroToHundred);
                        $('input[name="stm_s_s_topSpeed"]').val(data[0].topSpeed);
                    }
                });
            }
        }

        if ($('body').hasClass('rtl')) {
            $('.normal-price').each(function(){
                var abc = $(this).html().replace('ريال قطري', '').replace('ر.ق', '');
                // $(this).html($(this).html().replace('ريال قطري', 'ر.ق'));
                $(this).html(abc+'<span style="float: left; padding-right: 2px;">'+'ر.ق'+'</span>');
            });
            $('.trp-wrap').each(function(){
                $(this).html(
                    $(this).html()
                    .replace('Kilometers', 'المسافة المقطوعة')
                    .replace('Engine', 'المحرك')
                    .replace('Drive', 'نوع الدفع')
                    .replace('Interior Color', 'اللون الداخلي')
                    .replace('Exterior Color', 'اللون الخارجي')
                    .replace('Transmission', 'ناقل الحركة')
                    .replace('Fuel type', 'نوع الوقود')
                );
            });
            setTimeout(function(){
            $('.found-cars.heading-font .blue-lt').html($('.found-cars.heading-font .blue-lt').html().replace('سيارات', 'سيارة'));
            }, 1500);
        }

        $('.mynewtabs ul li a').click(function(){
            $('.mynewtabs ul li').removeClass('ui-tabs-active ui-state-active');
            $(this).parent().addClass('ui-tabs-active ui-state-active');
            $('.mynewtabs .wpb_tab').hide();
            var cTab = $(this).attr('href').replace('#', '');
            $('#'+cTab).show();
            return false;
        });

        if ($(".premium-package" ).hasClass( "active-package" ) ) {
            $(".form-container .packages-row .col-md-12").append('<img class="premium-image" src="/wp-content/uploads/2019/09/Vector-3.png">');
            $('.checker span').addClass('checked');         

        }

        if ($(".free-package" ).hasClass( "active-package" ) ) {
            $(".form-container .packages-row .col-md-12").append('<img class="free-image" src="/wp-content/uploads/2019/09/Vector.png">');
            $('.checker span').removeClass('checked');
        }

        $(".packages-row .button-package").click(function(){  
            $(".button-package").toggleClass("active-package"); 

            if ($(".premium-package" ).hasClass( "active-package" ) ) {
                $(".form-container .packages-row .col-md-12").css("background-color", "#C4862B");
                $(".form-container .packages-row .col-md-12:nth-child(even)").css("background-color", "#9B6B28");
                // $(".form-container .packages-row .col-md-12:nth-child(3)").css("border-radius", "5px 0 0 0");
                $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-left");
                $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-right");
                $(".form-container .packages-row .col-md-12").append('<img class="premium-image" src="/wp-content/uploads/2019/09/Vector-3.png">');
                $(".free-image" ).remove();
                $('.checker span').addClass('checked');
                $(".checker span.checked" ).addClass( "checked" );
                $('.col-lg-12 h2 i').text('1250');
            };

            if ($(".free-package" ).hasClass( "active-package" ) ) {
                $(".form-container .packages-row .col-md-12").css("background-color", "#7F92A3");
                $(".form-container .packages-row .col-md-12:nth-child(even)").css("background-color", "#687c8e");
                // $(".form-container .packages-row .col-md-12:nth-child(3)").css("border-radius", "0px 5px 0 0");
                $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-right");
                $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-left");
                $(".form-container .packages-row .col-md-12").append('<img class="free-image" src="/wp-content/uploads/2019/09/Vector.png">');
                $(".premium-image" ).remove();
                $('.checker span').removeClass('checked');
                $(".checker span.checked" ).removeClass( "checked" );
                $('.col-lg-12 h2 i').text('0');
            };

            $('.update-prices:not(:last-child)').click(function(e){
                if ($(".free-package" ).hasClass( "active-package" ) ) {
                    $(".premium-package" ).click();
                }
            });

            if ($(".rtl .premium-package" ).hasClass( "active-package" ) ) {
                $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-right");
                $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-left");
            };

            if ($(".rtl .free-package" ).hasClass( "active-package" ) ) {
                $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-left");
                $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-right");
            };
        });  

        if ($(".free-package" ).hasClass( "active-package" ) ) {
            $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-right");
            $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-left");
        };

        if ($(".premium-package" ).hasClass( "active-package" ) ) {
            $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-left");
            $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-right");
        };

        if ($(".rtl .premium-package" ).hasClass( "active-package" ) ) {
            $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-right");
            $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-left");
        };

        if ($(".rtl .free-package" ).hasClass( "active-package" ) ) {
            $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-left");
            $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-right");
        };

        $(".stm-view-by").append('<a class="map-show-hide-button view-type"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="512px" height="512px" class=""><g><g><g><path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035    c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719    c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#888888"/></g></g></g></svg></a>');  
        

        $(".stm-inventory-map-wrap").css( "height", 0 );
        $(".stm-inventory-map-wrap").css( "overflow", 'hidden');

        $(".map-show-hide-button").click(function(){
            $(".stm-inventory-map-wrap").toggleClass( "map-show" );
            $(  "#listings-result" ).toggle();
        });

        $(".stm-shareble" ).hover(function() {
            $(".stm-a2a-popup" ).toggleClass( "stm-a2a-popup-active" );
        });

        $(".stm-user-private-sidebar" ).append(  "<h4 style='color:#fff; margin: 40px 13px;'>Contact Motors Doha</h4>"  );

        $(window).resize(function(){
            if ($(window).width() <= 500) {  
                $(  ".stm_edit_disable_car" ).css("opacity", "1");
            }     
        });

        $.get("http://ipinfo.io", function (response) {
            var current_city = response.city;
            $(".my-city").val(current_city);  
        }, "jsonp");
    });


    $(document).ready(function(){  
        $('.btn-add-edit button').click(function(){

        $('.stm-form1-intro-unit .select2-hidden-accessible option:selected').each(function() {
            if($(this).val() =='') {
                $(this).parent().siblings().addClass('abcd');
            } else {
                $(this).parent().siblings().removeClass('abcd');
            }
        });

        $("input[name='stm_car_price']").each(function() {
            if($(this).val() =='') {
                $(this).addClass('abcd');
            } else{
                $(this).removeClass('abcd');
            }
        }); 
    });

    $(".page-id-1735 .car-first-form input[type='checkbox']").click();
    var number = 0;
    $(".checked").parent().parent().parent().parent().parent().parent().parent().addClass('update-prices');
    $('.update-prices .col-lg-6.text-right.text-dark p span').each(function(){
        number += (parseInt($(this).text(), 10));
    });

    $('.col-lg-12 h2 i').text(number);  
    $('.car-first-form .checkbox input[type="checkbox"]').click(function() {
        if ($(".premium-package" ).hasClass( "active-package" ) ) {
            if (!$(this).hasClass("checked")) {
                $(this).parent().parent().parent().parent().parent().parent().parent().parent().toggleClass('update-prices')
            }
        }
    }); 

    $('.car-first-form .checkbox input[type="checkbox"]').click(function() {
        if ($(".premium-package" ).hasClass( "active-package" ) ) {
            var number = 0;
            $(".checked").parent().parent().parent().parent().parent().parent().parent().addClass('update-prices');
            $('.update-prices .col-lg-6.text-right.text-dark p span').each(function(){
                number += (parseInt($(this).text(), 10));
                $('.col-lg-12 h2 i').text(number);
            });
        }
    });

    var text =0;
    $('.car-first-form .social-media-checkboxes .checked').click(function(){
        if ($(".premium-package" ).hasClass( "active-package" ) ) {
            var text =0
            if ($('.car-first-form .social-media-checkboxes .checked').length) {
                $('.car-first-form .social-media-checkboxes .checked').each(function() {  
                    text += (parseInt(50));
                    $('span.social-icon').text(text);
                });
            } else {
                text += 0;
                $('span.social-icon').text(text);
            }
        }
    })

    $('.car-first-form .social-media-checkboxes .checked').each(function() {
        var a = 50;
        text += (parseInt(a, 10));
        $('span.social-icon').text(text);
    });

    $('.car-first-form .social-media-checkboxes .checked').click(function(){
        if ($(".premium-package" ).hasClass( "active-package" ) ) {
            // $('.car-first-form .social-media-main span div').addClass('hover focus');
            // $('.car-first-form .social-media-main span div span input').click();
            setTimeout(function(){
                $(this).click();
                var number = 0;
                $(".checked").parent().parent().parent().parent().parent().parent().parent().addClass('update-prices');
                $('.update-prices .col-lg-6.text-right.text-dark p span').each(function(){
                    number += (parseInt($(this).text(), 10));
                    $('.col-lg-12 h2 i').text(number);
                });
             }, 700);
            // setTimeout(function(){ $('.car-first-form .social-media-main span div span input').click() }, 700);
        }
    });

    $('.car-first-form .social-media-main input[type="checkbox"]').click(function(){
        if ($(".premium-package" ).hasClass( "active-package" ) ) {
            if($(this).is(':checked')) {
                $('.car-first-form .social-media-checkboxes .checker > span').addClass('checked');
                var text =0
                if ($('.car-first-form .social-media-checkboxes .checked').length) {
                    $('.car-first-form .social-media-checkboxes .checked').each(function() {  
                        text += (parseInt(50));
                        $('span.social-icon').text(text);
                    });
                } else {
                    text += 0;
                    $('span.social-icon').text(text);
                }
                var number = 0;
                $(".checked").parent().parent().parent().parent().parent().parent().parent().addClass('update-prices');
                $('.update-prices .col-lg-6.text-right.text-dark p span').each(function(){
                    number += (parseInt($(this).text(), 10));
                    $('.col-lg-12 h2 i').text(number);
                });
            } else {
                $('.car-first-form .social-media-checkboxes .checked').removeClass('checked');
                $('span.social-icon').text(0);
                var number = 0;
                $(".checked").parent().parent().parent().parent().parent().parent().parent().addClass('update-prices');
                $('.update-prices .col-lg-6.text-right.text-dark p span').each(function(){
                    number += (parseInt($(this).text(), 10));
                    $('.col-lg-12 h2 i').text(number);
                });
            }
        }
    });

    $('.car-first-form .social-media-checkboxes input[type="checkbox"]').click(function(){
        if ($(".premium-package" ).hasClass( "active-package" ) ) {
            // $('.car-first-form .social-media-checkboxes .checked').each(function(){
                // setTimeout(function(){
                //     alert($('.col-lg-12 h2 i').text());
                // }, 1000);
            // });
            setTimeout(function(){
                $('.col-lg-12 h2 i').html(parseInt($('.col-lg-12 h2 i').text())+parseInt($('.social-icon').text()));
            }, 700);
        }
    });

    $(".stm-location-input-wrap.stm-location" ).append('<iframe class="map-view" target="_blank" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAfGgE2PLIlFX_TcMMnW0p75_q29o1U2hA&q=Qatar" style="display: block; width: 100%; border: 0; position: absolute; top: 70px; height: 350px;"></iframe>');
    
    $("#stm-add-car-location").change(function(){
        setTimeout(function(){
            $(".map-view").attr("src",  'https://www.google.com/maps/embed/v1/place?key=AIzaSyAfGgE2PLIlFX_TcMMnW0p75_q29o1U2hA&q='+$('#stm-add-car-location').val() );
            $(".map-view").show();
        }, 900);
    }); 
  
    var pageURL = $(location).attr("href");
    var wstr =  $(".whatsapp-link a").attr("href");
    if (wstr) {
        wstr = wstr.replace(/\s+/g, '');
        wstr = wstr.replace('+', '');

        if (window.location.href.indexOf("/ar/") > -1) {
            $(".whatsapp-link a").attr("href", wstr+'?text='+'السلام عليكم..حبيت أستفسر عن '+ $('.stm-single-car-content .title.h2').html()+' '+pageURL);
        } else {
            $(".whatsapp-link a").attr("href", wstr+'?text='+'Hello, I would like to inquire about '+ $('.stm-single-car-content .title.h2').html()+' '+pageURL);
        }
    }

    // $('.social-media-main').parent().parent().click(function(){
    //     return false;
    // });

    $('.add-car-btns-wrap li.btn-add-edit button').html('<i class="stm-service-icon-add_check"></i> Save');
});
</script>

<?php if(is_user_logged_in()){ ?>
    <style>
        .logout-button{
            display: block !important;
        }
        .login-register-button{
            display: none !important;
        }
        #addcar_page, #addcar2_page{
            display: none;
        }
    </style>
<?php } ?>

<?php if(is_user_logged_in()){} else{ ?>
    <script>  
        $(function() {  
            $('a.listing_add_cart.heading-font').attr("href", "/login-register/");
        });
    </script>
<?php } ?>

<?php if(isset($_GET['edit_car'])) { ?>
    <script type="text/javascript">
        $("#addcar_page, #addcar2_page" ).show();
        $("div#wpcf7-f1979-p1735-o1" ).hide();
    </script>
<?php } else { ?>
<?php } ?>

<?php if (get_user_meta(get_current_user_id(), 'stm_dealer_location', true) == '') { ?>
    <script type="text/javascript">
        $(".wpcf7-submit" ).click(function() {
            setTimeout(function(){
                if ($('.wpcf7-response-output.wpcf7-display-none').hasClass( "wpcf7-mail-sent-ok" ) ) {
                    $("#addcar_page, #addcar2_page" ).show();
                    $("div#wpcf7-f1979-p1735-o1" ).hide();
                }
            }, 3000);
        });
    </script>
    <?php
if (is_user_logged_in()) {
    $abc = get_posts(array(
    'post_type' => 'listings',
    'orderby' => 'date',
    'post_author' => get_current_user_id(),
    'order' => 'DESC',
    'date_query' => array(
        array(
            'after' => '1 month ago'
        )
    )
));
if (count($abc) > 0 && !is_page('car-limit') && is_page('add-a-car-page')) {
    ?>
    <script type="text/javascript">
        window.location.replace("<?php bloginfo('url') ?>/car-limit/");
    </script>
    <?php
}
}
?>
<?php } else { ?>
    <script type="text/javascript">
        $("#addcar_page, #addcar2_page" ).show();
        $("div#wpcf7-f1979-p1735-o1" ).hide();
    </script>
<?php } ?>
    <script type="text/javascript">
        $('input[name="stm_s_s_engine"]').parent().remove();
    </script>

</body>
</html>
<?php 

//GET MAKES
// $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, 'https://dohamotorsapi.azurewebsites.net/api/vehicles/getmakes');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


// $headers = array();
// $headers[] = 'Accept: */*';
// $headers[] = 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjAiLCJuYmYiOjE1NzE5MDcxODYsImV4cCI6MTU3MjA3OTk4NiwiaWF0IjoxNTcxOTA3MTg2fQ.d6elIUJ0pfzHhuQcnyigoAVqxOqLDAXDxy-vvuZ10Uc';
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $result = curl_exec($ch);
// if (curl_errno($ch)) {
//     echo 'Error:' . curl_error($ch);
// }
// curl_close($ch);

// $ch = curl_init();


// if ($error == '') {
//     $results = json_decode($result);
//     if (count($results)) {
//         foreach ($results as $key => $make) {
//             if (term_exists($make, 'make')) {
//                 echo "Exists<br>";
//             } else {
//                 echo "Created<br>";
//                 var_dump(wp_insert_term($make, 'make'));
//             }
//         }
//     } else {
//         echo "No make<br>";
//     }
// } else {
//     echo $error;
// }


//GET YEARS
// $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, 'https://dohamotorsapi.azurewebsites.net/api/vehicles/getyears');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
// $headers = array();
// $headers[] = 'Accept: */*';
// $headers[] = 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjAiLCJuYmYiOjE1NzE5MDcxODYsImV4cCI6MTU3MjA3OTk4NiwiaWF0IjoxNTcxOTA3MTg2fQ.d6elIUJ0pfzHhuQcnyigoAVqxOqLDAXDxy-vvuZ10Uc';
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $result = curl_exec($ch);
// if (curl_errno($ch)) {
//     echo 'Error:' . curl_error($ch);
// }
// curl_close($ch);

// if ($error == '') {
//     $results = json_decode($result);
//     if (count($results)) {
//         foreach ($results as $key => $year) {
//             if (term_exists($year, 'ca-year')) {
//                 echo "Exists<br>";
//             } else {
//                 echo "Created<br>";
//                 var_dump(wp_insert_term($year, 'ca-year'));
//             }
//         }
//     } else {
//         echo "No year<br>";
//     }
// } else {
//     echo $error;
// }


//GET MODELS
// $makes = get_terms(array('taxonomy' => 'make', 'hide_empty' => false ));
// $years = get_terms(array('taxonomy' => 'ca-year', 'hide_empty' => false ));

// foreach ($makes as $key => $make) {
//     foreach ($years as $key => $year) {
//         echo $key.':'.$make->name.' '.$year->name.'<br>';

//         $ch = curl_init();
//         $url = 'https://dohamotorsapi.azurewebsites.net/api/vehicles/getmodel?make='.str_replace(' ', '%20', $make->name).'&year='.$year->name;
//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


//         $headers = array();
//         $headers[] = 'Accept: */*';
//         $headers[] = 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjAiLCJuYmYiOjE1NzE5MDcxODYsImV4cCI6MTU3MjA3OTk4NiwiaWF0IjoxNTcxOTA3MTg2fQ.d6elIUJ0pfzHhuQcnyigoAVqxOqLDAXDxy-vvuZ10Uc';
//         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//         $error = '';
//         $result = curl_exec($ch);
//         if (curl_errno($ch)) {
//             $error = 'Error:' . curl_error($ch);
//         }
//         curl_close($ch);

//         if ($error == '') {
//             $results = json_decode($result);
//             if (count($results)) {
//                 foreach ($results as $key => $model) {
//                     $parent = term_exists($make->name, 'make');
//                     $term = term_exists($model, 'serie');
//                     if ($term) {
//                         echo "Exists<br>";
//                         add_term_meta( $term['term_id'], 'stm_parent', $make->slug );
//                     } else {
//                         echo "Created<br>";
//                         var_dump(wp_insert_term($model, 'serie', [
//                             'parent' => $parent['term_id']
//                         ]));
//                     }
//                 }
//             } else {
//                 echo "No model<br>";
//             }
//         } else {
//             echo $error;
//         }
//     }
// }





// curl_setopt($ch, CURLOPT_URL, 'https://dohamotorsapi.azurewebsites.net/api/vehicles/getyears');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


// $headers = array();
// $headers[] = 'Accept: */*';
// $headers[] = 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjAiLCJuYmYiOjE1NzE5MDcxODYsImV4cCI6MTU3MjA3OTk4NiwiaWF0IjoxNTcxOTA3MTg2fQ.d6elIUJ0pfzHhuQcnyigoAVqxOqLDAXDxy-vvuZ10Uc';
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// $result = curl_exec($ch);
// if (curl_errno($ch)) {
//     echo 'Error:' . curl_error($ch);
// }
// curl_close($ch);


// $makes = get_terms(array('taxonomy' => 'make', 'hide_empty' => false ));
// $years = get_terms(array('taxonomy' => 'ca-year', 'hide_empty' => false ));

// echo "<pre>";
// foreach ($makes as $key => $make) {
//     foreach ($years as $key => $year) {
//         $ch = curl_init();
//         $url = 'https://dohamotorsapi.azurewebsites.net/api/vehicles/getmodel?make='.$make->name.'&year='.$year->name;
//         // echo $url;
//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


//         $headers = array();
//         $headers[] = 'Accept: */*';
//         $headers[] = 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjAiLCJuYmYiOjE1NzE5MDcxODYsImV4cCI6MTU3MjA3OTk4NiwiaWF0IjoxNTcxOTA3MTg2fQ.d6elIUJ0pfzHhuQcnyigoAVqxOqLDAXDxy-vvuZ10Uc';
//         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//         $error = '';
//         $result = curl_exec($ch);
//         if (curl_errno($ch)) {
//             $error = 'Error:' . curl_error($ch);
//         }
//         curl_close($ch);
// // print_r($result); die;

//         if ($error == '') {
//             $results = json_decode($result);
//             if (count($results)) {
//                 foreach ($results as $key => $model) {
//                     $parent = term_exists($make->name, 'make');
//                     $term = term_exists($model, 'serie');
//                     if ($term) {
//                         echo "Exists<br>";
//                         add_term_meta( $term['term_id'], 'stm_parent', $make->slug );
//                     } else {
//                         echo "Created<br>";
//                         var_dump(wp_insert_term($model, 'serie', [
//                             'parent' => $parent['term_id']
//                         ]));
//                     }

//                     // $parent = term_exists($make->name, 'make');
//                     // if (term_exists($model, 'serie')) {
//                     //     echo "Exists<br>";
//                     // } else {
//                     //     echo "Created<br>";
//                     //     var_dump(wp_insert_term($model, 'serie', [
//                     //         'parent' => $parent['term_id']
//                     //     ]));
//                     // }
//                 }
//             } else {
//                 echo "No model<br>";
//             }
//         } else {
//             echo $error;
//         }
//     }
// }

// die;
?>

</body>
</html>

