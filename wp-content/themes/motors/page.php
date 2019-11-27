<?php

//activation user page
$activation_text = "Please <a href='/login-register'>sign up</a>";
if(is_page(3533)){
    if(isset($_GET["user"]) && !empty($_GET["user"])){
        $user_id = $_GET["user"];
        $user       = get_userdata($user_id);
        $username   = $user->user_login;
        $activation_text = "Thank you <b>".$username. "</b> your account has been activated";
    }
}

if(stm_is_rental()) {
    if(is_checkout() or is_cart()) {
        get_template_part('partials/rental/reservation', 'archive');
        return false;
    }
}
?>



<?php
get_header();

if(!stm_is_auto_parts() && !is_front_page()) {
    get_template_part('partials/page_bg');
    get_template_part('partials/title_box');
}

do_action('stm-wcmap-title-box');

//Get compare page
$compare_page = '';
if(!stm_motors_is_unit_test_mod()) {
    get_theme_mod( 'compare_page', 156 );
}

$compare_page = stm_motors_wpml_is_page($compare_page);

if (!empty($compare_page) and get_the_id() == $compare_page): ?>
    <div class="container">
        <?php get_template_part('partials/compare'); ?>
    </div>
<?php else: ?>


    <div class="container">

        <?php //activation page
            if(is_page(3533)) {
                echo $activation_text;
            }
        ?>

        <?php if(is_page(3877)){ ?>
        <!--forgot password-->
        <div class="forgot-pass-wrapper">
            <form action="" class="forgot-check-email-form">
                <p>Enter your email address to receive a link to reset your password.</p>
                <input class="forgot-u-email" type="text" placeholder="Enter your email"  required="">
                <div class="pass-reset-msg pass-reset-error">Wrong email address</div>
                <div class="pass-reset-msg pass-reset-succc">Mail with instruction has been sent successfully</div>
                <input type="submit">
            </form>
        </div>
        <script>
            jQuery(document).on("submit", ".forgot-check-email-form", function(e){
                e.preventDefault();
                var email = $(".forgot-u-email").val()
                var data = { action: "check_user_email", "email": email }
                jQuery.ajax({
                    "type": "GET",
                    "url": ajaxurl,
                    "data": data,
                    success: function(data){
                        var data = JSON.parse(data);
                        $(".pass-reset-msg ").hide()
                        if(data["result"]){
                            jQuery('.forgot-check-email-form .pass-reset-succc').show()
                            localStorage.setItem("u_email", email)
                        } else {
                            jQuery('.forgot-check-email-form .pass-reset-error').show()
                        }
                        setTimeout(function(){
                            $('.pass-reset-msg').hide()
                        }, 3000)
                    }
                })
            })
        </script>
        <?php }?>

        <?php if(is_page(3879)){ //change pass 

            if( isset( $_GET["email"]) && !empty($_GET["email"]) ) {
                echo "<input type='hidden' class='check_pss' name='get_pass' value=". $_GET["email"] ." />";
            }

        ?>

        <!--forgot password-->
        <div class="forgot-pass-wrapper">
            <form action="" class="reset-pass-form">
                <label for="">
                    <input type="password" name="u_pss" placeholder="Enter password" required="">
                </label>
                <label for="">
                    <input type="password" name="u_pss_rep" placeholder="Repeat password"  required="">
                </label>
                <div class="pass-reset-msg pass-reset-error">Password doesn't match</div>
                 <div class="pass-reset-msg pass-reset-error-msg">Password change error</div>
                <div class="pass-reset-msg pass-reset-succc">Your password has been changed successfully!</div>
                <input type="submit" value="Submit">
            </form>
        </div>
        <script>
            jQuery(document).on("submit", ".reset-pass-form", function(e){
                e.preventDefault();

                var pss = $("input[name=u_pss]").val()
                var pss_rep = $("input[name=u_pss_rep]").val()
                var check_email = $('.check_pss').val()
                var loc_email = localStorage.getItem("u_email")

                if(pss !== pss_rep) {
                    jQuery('.reset-pass-form .pass-reset-error').show()
                    setTimeout(function(){
                        $('.pass-reset-msg').hide()
                    }, 3000)
                    return
                }

                if( check_email === loc_email ){
                    var data = { action: "change_user_pass", "email": check_email, "pass": pss }
                    jQuery.ajax({
                        "type": "GET",
                        "url": ajaxurl,
                        "data": data,
                        success: function(data){
                            var data = JSON.parse(data);
                            $(".pass-reset-msg ").hide()
                            if(data["result"]){
                                jQuery('.reset-pass-form .pass-reset-succc').show()
                            } else {
                                jQuery('.reset-pass-form .pass-reset-error-msg').show()
                            }
                            setTimeout(function(){
                                $('.pass-reset-msg').hide()
                            }, 3000)
                        }
                    })
                } else {
                    jQuery('.pass-reset-error-msg').show()
                     setTimeout(function(){
                                $('.pass-reset-msg').hide()
                            }, 3000)
                }
            })
        </script>
        <?php }?>       

        <?php if (have_posts()) :
            while (have_posts()) : the_post();
                the_content();
            endwhile;
        endif; ?>

        <?php
        wp_link_pages(array(
            'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'motors') . '</span>',
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>',
            'pagelink' => '<span class="screen-reader-text">' . __('Page', 'motors') . ' </span>%',
            'separator' => '<span class="screen-reader-text">, </span>',
        ));
        ?>

        <div class="clearfix">
            <?php
            if (comments_open() || get_comments_number()) {
                comments_template();
            }
            ?>
        </div>
    </div>
<?php endif; ?>
<?php
get_footer();