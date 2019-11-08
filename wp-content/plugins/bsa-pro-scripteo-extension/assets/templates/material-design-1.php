<?php
$template_name = 'material-design-1';

// -- START -- IF EXAMPLE TEMPLATE
$ad = array(
	"template" 		=> $template_name,
	"id" 			=> 0,
	"title" 		=> ( isset($ad_title) ? $ad_title : '' ),
	"description" 	=> ( isset($ad_desc) ? $ad_desc : '' ),
	"url" 			=> ( isset($link_link_url) ? $link_link_url : '' ),
	"img" 			=> ( isset($ad_img) ? $ad_img : '' )
);
// -- END -- IF EXAMPLE TEMPLATE



// -- START -- TEMPLATE HTML
echo '<div id="bsa-'.$template_name.'" class="bsaProContainer bsa-'.$template_name.' bsa-pro-col-1">'; // -- START -- CONTAINER

echo '<div class="bsaProItems">'; // -- START -- ITEMS



if ( isset($ad['id']) && $ad['id'] != 0 ) {  // -- COUNTING FUNCTION (DO NOT REMOVE!)
	$model = new BSA_PRO_Model();
	$model->bsaProCounter($ad['id']);
}

echo '<div class="bsaProItem'.(($ad_animation == "none") ? " animated" : "").'" data-animation="' . $ad_animation . '" style="' . ( $ad_animation == "none" OR $ad_animation == NULL ? 'opacity:1' : '' ) . '">'; // -- START -- ITEM

echo '<div class="bsaProItemInner">'; // -- START -- ITEM INNER



echo '<div class="bsaProItemInner__thumb">'; // -- START -- ITEM THUMB

echo '<div class="bsaProItemInner__img" style="background-image: url(&#39;'.$ad['img'].'&#39;)"></div>'; // -- ITEM -- IMG

echo '</div>'; // -- END -- ITEM THUMB


echo '<div class="bsaProItemInner__copy z-depth-2" style="background-color:'.$background_color.'">'; // -- START -- ITEM COPY

echo '<div class="bsaProItemInner__copyInner">'; // -- START -- ITEM COPY INNER

echo '<h3 class="bsaProItemInner__title" style="color:'.$title_color.'">'.$ad['title'].'</h3>'; // -- ITEM -- TITLE

echo '<p class="bsaProItemInner__desc" style="color:'.$description_color.'">'.$ad['description'].'</p>'; // -- ITEM -- DESCRIPTION

echo '</div>'; // -- END -- ITEM COPY INNER

echo '</div>'; // -- END -- ITEM COPY



echo '<div class="bsaProItemInner__button">'; // -- START -- ITEM BUTTON

echo '<div class="bsaProItemInner__buttonInner">'; // -- START -- ITEM BUTTON INNER

if ( isset($ad['url']) && $ad['url'] != '' ) { // -- START -- LINK

	echo '<a href="'.$ad['url'].'" ' . ( $link_link_new_tab == true ? 'target="_blank"' : null ) . ( $link_link_title == true ? 'title="'.$link_link_title.'"' : null ).' class="bsaProItem__url bsaProItemInner__btn btn-floating btn-large waves-effect waves-light" style="background-color:'.$extra_color_1.'">';

} else {

	echo '<a href="#">';
}// -- ITEM -- BTN

echo '<i style="color:'.$extra_color_2.'">&nbsp;&gt;&nbsp;</i>';

echo '</a>'; // -- ITEM -- BTN

echo '</div>'; // -- END -- ITEM BUTTON INNER

echo '</div>'; // -- END -- ITEM BUTTON



echo '</div>'; // -- END -- ITEM INNER

echo '</div>'; // -- END -- ITEM

//		echo '</a>'; // -- END -- LINK

echo '</div>'; // -- END -- ITEMS

echo '</div>'; // -- END -- CONTAINER
// -- END -- TEMPLATE HTML
echo '<style>';
echo '#material-design-1 .bsaProItemInner__thumb .bsaProItemInner__img .bsaProItemInner__imgSymbol .bsaProItemInner__imgSymbolBox > i {
position: absolute;
font-size: 50px;
    line-height: 55px;
    margin-top: 45px;
}';
echo '</style>';