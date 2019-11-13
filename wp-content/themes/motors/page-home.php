<?php /** Template Name: Home Landing **/ ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="http://localhost:8888/wordpress/assets/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
  <style type="text/css">
    input.email-field {
      margin-bottom: 0;
    }
    @media (max-width: 480px) {
    input.email-field {
      width: 239px !important;
    }
    input.send-button-field {
      width: 265px !important;
        max-width: 239px;
    }
    #demo > span {
      width: 120px !important;
    }
    #demo > div {
    }
    .social-wrapper {
        margin-top: 50px;
        padding-bottom: 0;
        height: 10vh;
        justify-content: space-between;
    }

    }
  </style>
</head>
<body>
<div class="site-background first-day">
<div class="sec-half mx-auto">
	<div class="logo mx-auto"><img src="http://localhost:8888/wordpress/assets/img/logo.png"></div>
	<div class="bold-heading1">WEBSITE IS UNDER CONSTRUCTION</div>
	<div class="heading1">PLEASE SEND US EMAIL DIRECTLY</div>
	<!-- <form>
		<input class="email-field" type="email" placeholder="YOUR EMAIL">
		<input class="send-button-field" type="submit"  value="SEND">
	</form> -->


    <!-- Begin Mailchimp Signup Form -->
    <div id="mc_embed_signup">
    <form action="https://qpr.us4.list-manage.com/subscribe/post?u=7a83c8102ac99628cb490bb82&amp;id=a2bfc6c050" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
        <div id="mc_embed_signup_scroll">
      
            <div style="display: none!important;" class="indicates-required"><span class="asterisk">*</span> indicates required</div>

            <div class="mc-field-group">
                <input type="email" value="" name="EMAIL" class="required email email-field" id="mce-EMAIL" placeholder="YOUR EMAIL">
                <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button send-button-field">
            </div>
            <div id="mce-responses" class="clear">
                <div class="response" id="mce-error-response" style="display:none"></div>
                <div class="response" id="mce-success-response" style="display:none"></div>
            </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
            <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_7a83c8102ac99628cb490bb82_a2bfc6c050" tabindex="-1" value=""></div>
        </div>
    </form>
    </div>

    <!--End mc_embed_signup-->




	<center>	<p id="demo"></p></center>
    <div class="social-wrapper">
        <a href="https://www.snapchat.com/add/motors.doha" target="_blank"><i class="fa fa-snapchat-square" aria-hidden="true"></i>Doha.cars</a>
        <a href="https://www.facebook.com/MotorsDo7a/" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i>MotorsDoha</a>
        <a href="https://twitter.com/Motors_doha" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i>MotorsDoha</a>
        <a href="https://www.instagram.com/_motorsdoha/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i>MotorsDoha</a>
<!--        <a href="" target="_blank"><i class="fa fa-youtube-square" aria-hidden="true"></i>@GoExploreCity</a>
        <a href="" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i>goexplorecity</a>-->
    </div>
</div>
	
</div>

<style>








</style>
</head>
<body>



<script>
// Set the date we're counting down to
var countDownDate = new Date("Nov 17, 2019 00:00:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = "<span class='days-lable'>" +days + "</span> : <div class='days'>DAYS</div> <span class='hour-lable'>" +hours + "</span> : <div class='hrs'>HRS</div> <span class='minutes-lable'>"
  + minutes + "</span> : <div class='mins'>MINS</div> <span class='second-lable'> " + seconds + " </span><div class='secs'>SECS<div>";

  // document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  // + minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>





</body>
</html>