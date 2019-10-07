</div> <!--main-->
</div> <!--wrapper-->
<?php do_action('stm_pre_footer'); ?>
<?php if ( !is_404() and !is_page_template( 'coming-soon.php' ) ) { ?>
    <footer id="footer">
        <?php get_template_part( 'partials/footer/footer' ); ?>
        <?php get_template_part( 'partials/footer/copyright' ); ?>
        <?php get_template_part( 'partials/global-alerts' ); ?>
        <!-- Searchform -->
        <?php get_template_part( 'partials/modals/searchform' ); ?>
    </footer>
<?php } elseif ( is_page_template( 'coming-soon.php' ) ) {
    get_template_part( 'partials/footer/footer-coming-soon' );
}; ?>

<?php
if ( get_theme_mod( 'frontend_customizer' ) ) {
    get_template_part( 'partials/frontend_customizer' );
}
?>

<?php wp_footer(); ?>

<?php
if ( !stm_is_auto_parts() ) :
    if ( is_singular( stm_listings_post_type() ) ) {
        if ( get_theme_mod( 'show_calculator', true ) ) get_template_part( 'partials/modals/car-calculator' );
        if ( get_theme_mod( 'show_offer_price', false ) ) get_template_part( 'partials/modals/trade-offer' );
        if ( get_theme_mod( 'show_trade_in', stm_is_motorcycle() ) ) get_template_part( 'partials/modals/trade-in' );
    }

    if ( get_theme_mod( 'show_test_drive', true ) ) get_template_part( 'partials/modals/test-drive' );
    get_template_part( 'partials/modals/get-car-price' );

    $show_compare = ( is_single( get_the_ID() ) ) ? get_theme_mod( 'show_listing_compare', true ) : get_theme_mod( 'show_compare', true );
    if ( $show_compare ) get_template_part( 'partials/single-car/single-car-compare-modal' );

    if ( stm_is_rental() ) {
        get_template_part( 'partials/modals/rental-notification-choose-another-class' );
        echo '<div class="stm-rental-overlay"></div>';
    }

    if ( stm_pricing_enabled() ) {
        get_template_part( 'partials/modals/limit_exceeded' );
        get_template_part( 'partials/modals/subscription_ended' );
    }
    ?>
    <?php if ( is_listing( array( 'listing_two', 'listing_three' ) ) ) : ?>
        <div class="notification-wrapper">
            <div class="notification-wrap">
                <div class="message-container">
                    <span class="message"></span>
                </div>
                <div class="btn-container">
                    <button class="notification-close">
                        <?php echo esc_html__( 'Close', 'motors' ); ?>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="modal_content"></div>
<?php endif; ?>

<script type="text/javascript">

$(function() {





 var a = $('.normal-price span').text();

 var new_a = a.split(' ').join(',');

console.log(new_a);




         if ( $( ".premium-package" ).hasClass( "active-package" ) ) {
             $(".form-container .packages-row .col-md-12").append('<img class="premium-image" src="http://qprcar01.kinsta.cloud/wp-content/uploads/2019/09/Vector-3.png">');
               $('.checker span').addClass('checked');         

         }

         if ( $( ".free-package" ).hasClass( "active-package" ) ) {
             $(".form-container .packages-row .col-md-12").append('<img class="free-image" src="http://qprcar01.kinsta.cloud/wp-content/uploads/2019/09/Vector.png">');
              $('.checker span').removeClass('checked');


         }



     $(".packages-row .button-package").click(function(){  
        $(".button-package").toggleClass("active-package"); 


        if ( $( ".premium-package" ).hasClass( "active-package" ) ) {
 
            $(".form-container .packages-row .col-md-12").css("background-color", "#C4862B");
            $(".form-container .packages-row .col-md-12:nth-child(even)").css("background-color", "#9B6B28");
            // $(".form-container .packages-row .col-md-12:nth-child(3)").css("border-radius", "5px 0 0 0");
            $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-left");
            $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-right");
            $(".form-container .packages-row .col-md-12").append('<img class="premium-image" src="http://qprcar01.kinsta.cloud/wp-content/uploads/2019/09/Vector-3.png">');
            $( ".free-image" ).remove();
            $('.checker span').addClass('checked');
            $( ".checker span.checked" ).addClass( "checked" );
     
        };


         if ( $( ".free-package" ).hasClass( "active-package" ) ) {
         
            $(".form-container .packages-row .col-md-12").css("background-color", "#7F92A3");
            $(".form-container .packages-row .col-md-12:nth-child(even)").css("background-color", "#687c8e");
            // $(".form-container .packages-row .col-md-12:nth-child(3)").css("border-radius", "0px 5px 0 0");
             $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-right");
              $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-left");
             $(".form-container .packages-row .col-md-12").append('<img class="free-image" src="http://qprcar01.kinsta.cloud/wp-content/uploads/2019/09/Vector.png">');
             $( ".premium-image" ).remove();
              $('.checker span').removeClass('checked');
              $( ".checker span.checked" ).removeClass( "checked" );
        };

        if ( $( ".rtl .premium-package" ).hasClass( "active-package" ) ) {
              $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-right");
              $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-left");

        };

        if ( $( ".rtl .free-package" ).hasClass( "active-package" ) ) {

            $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-left");
            $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-right");

        };





    });  

     if ( $( ".free-package" ).hasClass( "active-package" ) ) {
              $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-right");
              $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-left");

        };

      if ( $( ".premium-package" ).hasClass( "active-package" ) ) {

          $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-left");
          $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-right");

      };

      if ( $( ".rtl .premium-package" ).hasClass( "active-package" ) ) {
              $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-right");
              $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-left");

        };

      if ( $( ".rtl .free-package" ).hasClass( "active-package" ) ) {

          $(".form-container .packages-row .col-md-12:nth-child(3)").addClass("border-radius-left");
          $(".form-container .packages-row .col-md-12:nth-child(3)").removeClass("border-radius-right");

      };

    // var height_of_sidebar = $(".stm-user-private .col-md-3.col-sm-3.hidden-sm.hidden-xs.stm-sticky-user-sidebar").height();

    //  console.log('height'+height_of_sidebar);
     

$(".stm-view-by").append('<a class="map-show-hide-button view-type"> <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="512px" height="512px" class=""><g><g><g><path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035    c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719    c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#888888"/></g></g></g></svg></a>');  
    

$(".stm-inventory-map-wrap").css( "height", 0 );
$(".stm-inventory-map-wrap").css( "overflow", 'hidden' );

$(".map-show-hide-button").click(function(){
    $(".stm-inventory-map-wrap").toggleClass( "map-show" );
    $(  "#listings-result" ).toggle();
});


// $( ".car-action-unit.stm-share" ).hover(function() {
//   $( ".stm-a2a-popup" ).toggleClass( "stm-a2a-popup-active" );
// });


$( ".stm-shareble" ).hover(function() {
  $( ".stm-a2a-popup" ).toggleClass( "stm-a2a-popup-active" );
});




// $( "body" ).removeClass( "rtl" );

$( ".stm-user-private-sidebar" ).append(  "<h4 style='color:#fff; margin: 40px 13px;'>Contact Motors Doha</h4>"  );





$(window).resize(function(){

       if ($(window).width() <= 500) {  

              $(  ".stm_edit_disable_car" ).css("opacity", "1");

       }     

});


// $('').on('classChange', function() {
//      // do stuff
// });





  $.get("http://ipinfo.io", function (response) {
    // $("#ip").html("IP: " + response.ip);
    var current_city = response.city;
    console.log(current_city);
/*     $("#details").html(JSON.stringify(response, null, 4)); */
$(".my-city").val(current_city);  
}, "jsonp");






// $('.car-title').text(function(){

// var ellipsis = "...";

// var a = $(this).text;

// function TrimLength(a, maxLength)
// {
//     a = $.trim(a);

//     if (a.length > maxLength)
//     {
//         a = a.substring(0, maxLength - ellipsis.length)
//         return a.substring(0, a.lastIndexOf(" ")) + ellipsis;
//     }
//     else
//         return text;
// }

// TrimLength($(this), '15')
// });


});


$(document).ready(function(){  
  
  
$('.btn-add-edit button').click(function(){
   
      $('.stm-form1-intro-unit .select2-hidden-accessible option:selected').each(function() {
          if($(this).val() =='') {
           
             $(this).parent().siblings().addClass('abcd');
        
          }
          else{
              $(this).parent().siblings().removeClass('abcd');
          }
      });

      $("input[name='stm_car_price']").each(function() {
            if($(this).val() =='') {
             
               $(this).addClass('abcd');
        }
        else{
              $(this).removeClass('abcd');
          }

      }); 
  

  

  });


var str =  $(".whatsapp-link a").attr("href");

str = str.replace(/\s+/g, '');

str = str.replace('+', '');

$(".whatsapp-link a").attr("href", str+'?text='+$('.stm-single-car-content .title.h2').html());





      $('.add-car-btns-wrap li.btn-add-edit button').html('<i class="stm-service-icon-add_check"></i> Save');


      $('#header').append('<a href="/add-a-car" class="listing_add_cart heading-font"><span class="list-label heading-font">Add your item</span><i class="stm-service-icon-listing_car_plus"></i></a>');


      $('#header').append('<a href="http://qprcar01.kinsta.cloud/compare/" title="Watch compared" class="compare"><span class="list-label heading-font">Compare</span><i class="list-icon stm-icon-speedometr2"></i><span class="list-badge"><span class="stm-current-cars-in-compare" data-contains="compare-count"></span></span></a>');    
       $('#header').append('<div class=lOffer-account-unit><a href=http://qprcar01.kinsta.cloud/login-register/ class=lOffer-account><i class=stm-service-icon-user></i></a><div class="lOffer-account-dropdown login"><a href="http://qprcar01.kinsta.cloud/author/caradmin/?page=settings"class=settings><i class="stm-service-icon-cog stm-settings-icon"></i></a><div class=name><a href=http://qprcar01.kinsta.cloud/author/caradmin/ >caradmin</a></div><ul class=account-list><li><a href=http://qprcar01.kinsta.cloud/author/caradmin/ >My items (<span>1</span>)</a><li class=stm-my-favourites><a href="http://qprcar01.kinsta.cloud/author/caradmin/?page=favourite">Favorites (<span>0</span>)</a></ul><a href="http://qprcar01.kinsta.cloud/qprlogin/?action=logout&redirect_to=http%3A%2F%2Fqprcar01.kinsta.cloud&_wpnonce=c37efc72c2"class=logout><i class="fa fa-power-off"></i>Logout</a></div><div class=stm-user-mobile-info-wrapper><div class=stm-user-private><div class=stm-user-private-sidebar><div class="clearfix stm-user-top"><div class=stm-user-avatar><div class=stm-empty-avatar-icon><i class=stm-service-icon-user></i></div></div><div class=stm-user-profile-information><div class="heading-font title">caradmin</div><div class=title-sub>Private Seller</div></div></div><div class=stm-became-dealer><a href="http://qprcar01.kinsta.cloud/author/caradmin/?become_dealer=1"class="button stm-dp-in">Become a dealer</a></div><div class="heading-font stm-actions-list"><a href=http://qprcar01.kinsta.cloud/author/caradmin/ class=active><i class=stm-service-icon-inventory></i> My Inventory </a><a href="http://qprcar01.kinsta.cloud/author/caradmin/?page=favourite"><i class=stm-service-icon-star-o></i> My Favorites </a><a href="http://qprcar01.kinsta.cloud/author/caradmin/?page=settings"><i class="fa fa-cog"></i> Profile Settings</a></div><div class=stm-dealer-mail><i class="fa fa-envelope-o"></i><div class="heading-font mail-label">Seller Email</div><div class=mail><a href=mailto:reputation.manager.01@gmail.com>reputation.manager.01@gmail.com</a></div></div><div class=show-my-profile><a href="http://qprcar01.kinsta.cloud/author/caradmin/?view-myself=1"target=_blank><i class="fa fa-external-link"></i>Show my Public Profile</a></div><div class=show-my-profile><a href="http://qprcar01.kinsta.cloud/qprlogin/?action=logout&redirect_to=http%3A%2F%2Fqprcar01.kinsta.cloud&_wpnonce=c37efc72c2"><i class="fa fa-sign-out"></i>Logout</a></div><h4 style="color:#fff;margin:40px 13px">Contact Motors Doha</h4></div></div></div></div>');

});  






 </script>

<script type="text/javascript">
  $.get("https://ipinfo.io/json", function (response) {
     
    console.log(response.city);
    console.log(response.region);

      var names = response.loc;
  var nameArr = names.split(',');
  console.log(nameArr);

nameArr[0]

$('#stm-add-car-location').val(response.postal);
$('.text_stm_lat').val(nameArr[0]);
$('.text_stm_lng').val(nameArr[1]);
}, "jsonp");
</script>







<!-- <style>
 
 div#header .listing_add_cart {

    display: none;
 }


@media(max-width: 991px){

    div#header .listing_add_cart {
    margin-left: 33px;
    margin-bottom: 26px;
    display: block;
}



}

</style>
 -->
<?php


if(is_user_logged_in()){
?>

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



<?php
}

        if(is_user_logged_in()){
        }
        else{
        ?>

             <style type="text/css">

                /*.listing_add_cart.heading-font {display: block!important; }*/
                    

            </style>

            <script>  

            $(function() {  
              $('a.listing_add_cart.heading-font').attr("href", "http://qprcar01.kinsta.cloud/login-register/");

            });

        </script> 


        <?php



    }




 ?>
<?php
if(isset($_GET['edit_car'])) {
 
?>
<script type="text/javascript">
  $( "#addcar_page, #addcar2_page" ).show();
  $( "div#wpcf7-f1979-p1735-o1" ).hide();

</script>

<?php

} else {
   


?>
<script type="text/javascript">
  $( ".wpcf7-submit" ).click(function() {

  setTimeout(function(){
  


    if ( $( '.wpcf7-response-output.wpcf7-display-none' ).hasClass( "wpcf7-mail-sent-ok" ) ) {
 
        $( "#addcar_page, #addcar2_page" ).show();
        $( "div#wpcf7-f1979-p1735-o1" ).hide();
 
    }
  
  }, 3000);
 
 
});
</script>
<?php
}

?>

</body>
</html>


