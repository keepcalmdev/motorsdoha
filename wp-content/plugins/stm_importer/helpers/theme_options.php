<?php
function stm_get_layout_options($layout)
{
	$options = call_user_func('stm_theme_options_' . $layout);
	$options = json_decode($options, true);
	$options['show_page_title'] = 'false';

	foreach ($options as $k => $option) {
	    set_theme_mod($k, $option);
    }
}

function stm_theme_options_car_dealer()
{
	$json = '';
	return $json;
}
function stm_theme_options_listing()
{
	$json = '';
	return $json;
}
function stm_theme_options_motorcycle()
{
	$json = '{
      "boats_header_layout": "car_dealer",
      "top_bar_enable": false,
      "header_bg_color": "#0e1315",
      "header_socials_enable": "facebook,instagram,google-plus,youtube-play",
      "socials_link": "facebook=%23&twitter=&vk=&instagram=%23&behance=&dribbble=&flickr=&git=&linkedin=&pinterest=&yahoo=&delicious=&dropbox=&reddit=&soundcloud=&google=&google-plus=%23&skype=&youtube=&youtube-play=%23&tumblr=&whatsapp=",
      "logo_width": "126",
      "typography_body_color": "#ffffff",
      "typography_menu_color": "#ffffff",
      "typography_heading_color": "#ffffff",
      "listing_directory_title_frontend": "{category_type} {condition} {ca-year} {make} {serie}",
      "show_test_drive": true,
      "show_compare": true,
      "show_share": true,
      "listing_archive": "639",
      "listing_directory_title_default": "Vehicles for sale",
      "show_listing_stock": true,
      "show_listing_compare": true,
      "show_listing_test_drive": true,
      "show_listing_quote": false,
      "show_listing_trade": false,
      "show_listing_calculate": false,
      "show_listing_vin": true,
      "listing_grid_choices": "9,12,18,27",
      "listing_grid_choice": "12",
    }';
	return $json;
}
function stm_theme_options_boats()
{
	$json = '';
	return $json;
}
function stm_theme_options_service()
{
	$json = '';
	return $json;
}
function stm_theme_options_car_rental()
{
	$json = '{
      "0": false,
      "custom_css_post_id": -1,
      "top_bar_enable": true,
      "top_bar_login": false,
      "top_bar_address": "",
      "top_bar_menu": false,
      "top_bar_socials_enable": "facebook,twitter,instagram,linkedin,google-plus,youtube-play",
      "socials_link": "facebook=%23&twitter=%23&vk=%23&instagram=%23&behance=%23&dribbble=%23&flickr=%23&git=%23&linkedin=%23&pinterest=%23&yahoo=%23&delicious=%23&dropbox=&reddit=&soundcloud=&google=&google-plus=%23&skype=&youtube=&youtube-play=%23&tumblr=&whatsapp=",
      "top_bar_bg_color": "#2a4045",
      "header_bg_color": "#23393d",
      "top_bar_address_mobile": false,
      "top_bar_working_hours": "",
      "top_bar_working_hours_mobile": false,
      "top_bar_phone": "",
      "top_bar_phone_mobile": false,
      "logo_width": "126",
      "menu_top_margin": "16",
      "socials_widget_enable": "facebook,twitter,instagram,google-plus,youtube-play",
      "footer_socials_enable": "facebook,twitter",
      "footer_bg_color": "#23393d",
      "footer_copyright_color": "#23393d",
      "shop_sidebar": "0",
      "rental_datepick": "210",
      "site_bg_color": "#ffffff",
      "typography_body_color": "#2a4045",
      "typography_menu_color": "#232628",
      "typography_heading_color": "#2a4045",
      "order_received": "287",
      "logo_margin_top": "10"
    }';
	return $json;
}
function stm_theme_options_car_magazine()
{
	$json = '{
      "typography_body_font_family": "Open Sans",
      "typography_menu_font_family": "Montserrat",
      "typography_heading_font_family": "Montserrat",
      "typography_h1_font_size": "60",
      "logo_width": "194",
      "top_bar_enable": false,
      "header_socials_enable": "facebook,twitter",
      "socials_link": "facebook=https%3A%2F%2Ffacebook.com&twitter=https%3A%2F%2Ftwitter.com&vk=&instagram=&behance=&dribbble=&flickr=&git=&linkedin=&pinterest=&yahoo=&delicious=&dropbox=&reddit=&soundcloud=&google=&google-plus=&skype=&youtube=&youtube-play=&tumblr=&whatsapp=",
      "google_api_key": "AIzaSyD1WlC7K5CuuX55i6V45Be3o-4ic_KcG2w",
      "typography_h4_font_size": "22",
      "typography_h5_font_size": "20",
      "typography_h6_font_size": "18",
      "events_archive": "grid",
      "events_archive_paginatin_style": "pagination",
      "events_per_page": "3",
      "events_subtitle": "Find interesting trade shows & conferences to attend",
      "events_archive_sidebar_position": "right",
      "review_per_page": "4",
      "review_archive_paginatin_style": "load_more",
      "sidebar_position": "right",
      "listing_archive": "2490",
      "listing_sidebar": "no_sidebar"
    }';
	return $json;
}

function stm_theme_options_car_dealer_two()
{
	$json = '{
	"top_bar_address":"1840 E Garvey Ave South West Covina, CA 91791",
	 "top_bar_working_hours":"Work Hours",
	 "top_bar_menu":false,
	 "top_bar_socials_enable":"facebook,twitter,instagram,linkedin,google-plus,youtube-play",
	 "socials_link":"facebook=https%3A%2F%2Fwww.facebook.com%2F&twitter=https%3A%2F%2Ftwitter.com%2F&vk=&instagram=https%3A%2F%2Fwww.instagram.com%2F&behance=&dribbble=&flickr=&git=&linkedin=https%3A%2F%2Fwww.linkedin.com%2F&pinterest=&yahoo=&delicious=&dropbox=&reddit=&soundcloud=&google=&google-plus=https%3A%2F%2Fplus.google.com%2F&skype=&youtube=https%3A%2F%2Fwww.youtube.com%2F&youtube-play=https%3A%2F%2Fwww.youtube.com%2F&tumblr=&whatsapp=",
	 "listing_filter_position":"right",
	 "listing_directory_title_frontend":"{make} {serie} {ca-year} {body} {condition}",
	 "compare_page":"2144",
	 "site_demo_mode":false,
	 "footer_socials_enable":
	 "facebook,twitter,instagram,linkedin,youtube-play",
	 "show_history":true,
	 "google_api_key":"AIzaSyD1WlC7K5CuuX55i6V45Be3o-4ic_KcG2w",
	 "show_listing_share":true,
	 "show_listing_certified_logo_2":true,
	 "user_image_size_limit":"2000",
	 "distance_search":"5500",
	 "header_sticky":true,
	 "show_generated_title_as_label":true,
	 "user_premoderation":true,
	 "site_style":"site_style_default",
	 "site_style_base_color_listing":"#3350b8",
	 "site_style_secondary_color_listing":"#ffb100",
	 "site_style_base_color":"#4971ff",
	 "site_style_secondary_color":"#ffb129",
	 "site_boxed":false,
	 "typography_body_font_family":"Open Sans",
	 "custom_css":"",
	 "bg_image":"stm-background-customizer-box_img_5",
	 "enable_search":true,
	 "view_type":"grid",
	 "listing_sidebar":"no_sidebar",
	 "dealer_premoderation":false,
	 "enable_location":true,
	 "price_delimeter":" ",
	 "show_certified_logo_1":true,
	 "show_certified_logo_2":true,
	 "stm_show_number":false,
	 "dealer_post_images_limit":"4",
	 "listing_grid_choice":"9",
	 "enable_favorite_items":true,
	 "header_compare_show":true,
	 "header_cart_show":true,
	 "show_print_btn":true,
	 "top_bar_address_mobile":false,
	 "top_bar_working_hours_mobile":true,
	 "top_bar_phone_mobile":true,
	 "distance_measure_unit":"kilometers",
	 "logo_width":"140",
	 "top_bar_login":false,
	 "typography_menu_font_family":"Montserrat",
	 "typography_menu_font_size":"13",
	 "typography_menu_color":"#ffffff",
	 "typography_heading_font_family":"Montserrat",
	 "typography_body_font_size":"16",
	 "typography_h3_font_size":"24",
	 "socials_widget_enable":"facebook,twitter,instagram,dribbble,linkedin,pinterest",
	 "listing_directory_title_default":"Vehicles for sale",
	 "stm_single_car_page":"",
	 "shop_sidebar_position":"right",
	 "show_pdf":false
	 }';
	return $json;
}


function stm_theme_options_listing_two()
{
	$json = '{
	"google_api_key":"AIzaSyD1WlC7K5CuuX55i6V45Be3o-4ic_KcG2w",
	"typography_body_font_family":"Open Sans",
	"typography_body_font_size":"13",
	"typography_body_line_height":"20",
	"typography_body_color":"#888888",
	"typography_menu_font_family":"Montserrat",
	"typography_menu_font_size":"14",
	"typography_menu_color":"#ffffff",
	"typography_heading_font_family":"Montserrat",
	"top_bar_bg_color":"#1a2c33",
	"top_bar_menu":true,
	"top_bar_address":"",
	"top_bar_address_mobile":false,
	"top_bar_working_hours":"",
	"top_bar_working_hours_mobile":false,
	"top_bar_phone":"",
	"top_bar_phone_mobile":false,
	"top_bar_socials_enable":"facebook,twitter,instagram,linkedin,google-plus,youtube-play",
	"top_bar_login":false,
	"header_socials_enable":"",
	"socials_link":"facebook=https%3A%2F%2Ffacebook.com&twitter=https%3A%2F%2Ftwitter.com&vk=&instagram=https%3A%2F%2Finstagram%2Ccom&behance=&dribbble=&flickr=&git=&linkedin=https%3A%2F%2Flinkedin.com&pinterest=&yahoo=&delicious=&dropbox=&reddit=&soundcloud=&google=&google-plus=https%3A%2F%2Fplus.google.com&skype=&youtube=&youtube-play=https%3A%2F%2Fyoutube.com&tumblr=&whatsapp=",
	"listing_archive":"4046",
	"typography_h2_font_size":"28",
	"footer_sidebar_count":"3",
	"footer_socials_enable":"facebook,twitter,instagram,google-plus,youtube-play",
	"menu_top_margin":"15",
	"dealer_list_page":"4370",
	"login_page":"4375",
	"user_add_car_page":"4353",
	"enable_plans":true,
	"pricing_link":"4038",
	"site_style":"site_style_default",
	"site_style_base_color":"#dd2146",
	"site_style_secondary_color":"#c9c012",
	"site_style_base_color_listing":"#c9c012",
	"site_style_secondary_color_listing":"#c9c012",
	"compare_page":"4372"
	}';
	return $json;
}


function stm_theme_options_listing_three()
{
    $json = '{
        "0":false,
        "custom_css_post_id":-1,
        "google_api_key":"AIzaSyD1WlC7K5CuuX55i6V45Be3o-4ic_KcG2w",
        "typography_body_font_family":"Open Sans",
        "typography_body_font_size":"13",
        "typography_body_line_height":"20",
        "typography_body_color":"#888888",
        "typography_menu_font_family":"Montserrat",
        "typography_menu_font_size":"14",
        "typography_menu_color":"#ffffff",
        "typography_heading_font_family":"Montserrat",
        "logo":"http:\/\/motorstest.loc\/wp-content\/uploads\/2018\/07\/logo-motors-listing-3.svg",
        "top_bar_bg_color":"#1a2c33",
        "top_bar_menu":true,
        "top_bar_address":"",
        "top_bar_address_mobile":false,
        "top_bar_working_hours":"",
        "top_bar_working_hours_mobile":false,
        "top_bar_phone":"",
        "top_bar_phone_mobile":false,
        "top_bar_socials_enable":"facebook,twitter,instagram,linkedin,google-plus,youtube-play",
        "top_bar_login":false,
        "header_socials_enable":"",
        "socials_link":"facebook=https%3A%2F%2Ffacebook.com&twitter=https%3A%2F%2Ftwitter.com&vk=&instagram=https%3A%2F%2Finstagram%2Ccom&behance=&dribbble=&flickr=&git=&linkedin=https%3A%2F%2Flinkedin.com&pinterest=&yahoo=&delicious=&dropbox=&reddit=&soundcloud=&google=&google-plus=https%3A%2F%2Fplus.google.com&skype=&youtube=&youtube-play=https%3A%2F%2Fyoutube.com&tumblr=&whatsapp=",
        "listing_archive":"4046",
        "typography_h2_font_size":"28",
        "footer_sidebar_count":"3",
        "footer_socials_enable":"facebook,twitter,instagram,google-plus,youtube-play",
        "menu_top_margin":"15",
        "dealer_list_page":"4370",
        "login_page":"4375",
        "user_add_car_page":"4353",
        "header_listing_btn_link":"\/classified-three\/add-a-car",
        "enable_plans":true,"pricing_link":"4038",
        "site_style":"site_style_default",
        "site_style_base_color":"#ff9501",
        "site_style_secondary_color":"#cc7700",
        "site_style_base_color_listing":"#ff9500",
        "site_style_secondary_color_listing":"#cc7710",
        "compare_page":"4372",
        "price_delimeter":",",
        "footer_bg_color":"#1a2c33",
        "footer_copyright_color":"#1a2c33",
        "listing_directory_title_frontend":"{condition} {ca-year} {make} {serie}",
        "user_sidebar":"4387",
        "dealer_sidebar":"4387"
    }';
	return $json;
}

function stm_theme_options_auto_parts()
{
    $json = '{
        "custom_css_post_id":-1,
        "wcmap_single_product_sidebar":"244",
        "shop_sidebar":"239",
        "site_style_base_color": "#ffcc12",
        "site_style_secondary_color": "#6c98e1",
        "typography_body_font_family":"Open Sans",
        "typography_body_color":"#595959",
        "typography_menu_font_family":"Sunflower",
        "typography_menu_color":"#ffffff",
        "typography_heading_font_family":"Sunflower",
        "typography_heading_color":"#191919",
        "typography_body_line_height":"26",
        "typography_menu_font_size":"15",
        "socials_link":"facebook=https%3A%2F%2Ffacebook.com&twitter=https%3A%2F%2Ftwitter.com&vk=&instagram=https%3A%2F%2Finstagram.com&behance=&dribbble=&flickr=&git=&linkedin=&pinterest=&yahoo=&delicious=&dropbox=&reddit=&soundcloud=&google=&google-plus=https%3A%2F%2Fgoogle.com&skype=&youtube=&youtube-play=https%3A%2F%2Fyoutube.com&tumblr=&whatsapp=",
        "socials_widget_enable":"facebook,twitter,instagram,google-plus,youtube-play",
        "prefooter_sb":"257",
        "wcmap_single_product_template":"template_sidebar",
        "sidebar":"no_sidebar",
        "sidebar_position":"right",
        "footer_bg_color": "#191919"
        }';

	return $json;
}

function stm_theme_options_listing_four()
{
    $json = '{
            "custom_css_post_id":-1,
            "logo":"http:\/\/motors.stylemixthemes.com\/classified-four\/wp-content\/uploads\/sites\/13\/2015\/11\/logo@2x.png",
            "logo_width":"138",
            "menu_top_margin":"0",
            "top_bar_enable":true,
            "header_socials_enable":"facebook,twitter,vk",
            "footer_socials_enable":"facebook,twitter,instagram",
            "listing_archive":"639",
            "classic_listing_title_bg":"http:\/\/motorswp.stm\/wp-content\/uploads\/2016\/12\/car-listing-bg.jpg",
            "classic_listing_title":"Inventory",
            "show_stock":true,
            "show_test_drive":true,
            "show_compare":true,
            "show_share":true,
            "show_pdf":false,
            "sidebar":"651",
            "sidebar_blog":"651",
            "sidebar_position":"right",
            "socials_link":"facebook=https%3A%2F%2Fwww.facebook.com%2F&twitter=https%3A%2F%2Fwww.twitter.com%2F&vk=&instagram=https%3A%2F%2Fwww.instagram.com%2F&behance=&dribbble=&flickr=&git=&linkedin=https%3A%2F%2Fwww.linkedin.com%2F&pinterest=&yahoo=&delicious=&dropbox=&reddit=&soundcloud=&google=https%3A%2F%2Fgoogle.com&google-plus=https%3A%2F%2Fplus.google.com&skype=&youtube=https%3A%2F%2Fwww.youtube.com%2F&youtube-play=https%3A%2F%2Fwww.youtube.com%2Fplay&tumblr=&whatsapp=",
            "socials_widget_enable":"facebook,twitter,instagram,google-plus,youtube-play",
            "enable_recaptcha":true,
            "smooth_scroll":true,
            "custom_css":"",
            "listing_grid_choice":"9",
            "listing_filter_position":"left",
            "show_certified_logo_1":false,
            "show_certified_logo_2":false,
            "header_compare_show":false,
            "header_cart_show":false,
            "site_style":"site_style_default",
            "site_style_base_color":"#dd8411",
            "default_interest_rate":"2",
            "default_month_period":"12",
            "default_down_payment":"1000",
            "show_featured_btn":false,
            "show_vin":true,
            "show_registered":true,
            "show_history":true,
            "show_print_btn":true,
            "show_listing_test_drive":false,
            "show_trade_in":true,
            "show_offer_price":true,
            "listing_grid_choices":"9,12,18,27",
            "price_currency_position":"left",
            "enable_search":true,
            "carguru":"<script>\nCarGurus = window.CarGurus || { DealRatingBadge: { } };\nCarGurus.DealRatingBadge.options = {\n \"style\": \"STYLE1\",\n \"minRating\": \"GOOD_PRICE\",\n \"defaultHeight\": \"60\"\n};\n\n(function() {\n    var script = document.createElement(\'script\');\n    script.src = \"https:\/\/static.cargurus.com\/js\/api\/en_US\/1.0\/dealratingbadge.js\";\n    script.async = true;\n    var entry = document.getElementsByTagName(\'script\')[0];\n    entry.parentNode.insertBefore(script, entry);\n})();\n<\/script>",
            "header_bg_color":"#232628",
            "site_boxed":false,
            "site_style_secondary_color":"#ce25e8",
            "header_main_phone_label":"Sales",
            "enable_features_search":true,
            "price_delimeter":".",
            "price_currency":" $   ",
            "header_address_url":"",
            "top_bar_working_hours_mobile":true,
            "listing_view_type":"list",
            "carguru_style":"STYLE2",
            "carguru_min_rating":"GREAT_PRICE",
            "carguru_default_height":"80",
            "enable_preloader":false,
            "top_bar_wpml_switcher":true,
            "show_listing_certified_logo_1":false,
            "currency_list":"{\"currency\":\"Euro,Yuan\",\"symbol\":\"E  , Y \",\"to\":\"3,6\"}",
            "listing_sidebar":"primary_sidebar",
            "price_currency_name":"USD",
            "show_calculator":false,
            "show_listing_share":false,
            "footer_copyright_text":"\u00a9 2019 <a href=\"http:\/\/www.stylemixthemes.com\/\">Stylemix Themes<\/a><span class=\"divider\"><\/span>Trademarks and brands are the property of their respective owners.",
            "footer_bg_color":"#25252b",
            "footer_copyright_color":"#25252b",
            "distance_measure_unit":"kilometers",
            "listing_directory_title_frontend":"{make} {serie} {ca-year}",
            "distance_search":"10000",
            "enable_location":false,"top_bar_address":"1010 Moon ave, New York, NY USA",
            "top_bar_working_hours":"Mon - Sat 8.00 - 19.00",
            "top_bar_phone":"+1 212-226-31261",
            "sidebars_widgets":{"time":1528086171,"data":{"wp_inactive_widgets":[],"default":["search-2","text-7","tag_cloud-2","archives-2","recent-posts-4"],"footer":["stm_text-2","text-6","stm-recent-posts-2","socials-2","mc4wp_form_widget-2","text-3","text-4","text-5"],"shop":[],"stm_listing_car":["stm_similar_cars-2","car_location-2","car_location-3"],"stm_boats_car":[]}},
            "login_page":"2601",
            "dealer_list_page":"2604",
            "user_sidebar":"2606",
            "dealer_sidebar":"2607",
            "user_add_car_page":"2611",
            "dealer_pay_per_listing":true,
            "dealer_payments_for_featured_listing":true,
            "pay_per_listing_price":"5",
            "featured_listing_price":"4.7",
            "pricing_link":"2614",
            "dealer_premoderation":true,
            "dealer_review_moderation":true,
            "enable_plans":true,
            "typography_body_font_family":"Open Sans",
            "typography_menu_font_family":"Montserrat",
            "typography_heading_font_family":"Montserrat",
            "header_listing_btn_link":"\/classified-four\/add-a-car",
            "top_bar_address_mobile":true,"header_main_phone":"878-9674-4455",
            "header_secondary_phone_1":"878-3853-9576",
            "header_secondary_phone_2":"878-0505-0440",
            "show_generated_title_as_label":false,
            "show_listing_certified_logo_2":false,
            "listing_directory_enable_dealer_info":true,
            "shop_sidebar_position":"left",
            "dealer_post_limit":"10"}';

	return $json;
}
