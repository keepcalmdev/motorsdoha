<?php
$template_name = 'paper-note-3';

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

if ( isset($ad['url']) && $ad['url'] != '' ) { // -- START -- LINK

	echo '<a class="bsaProItem__url" href="'.$ad['url'].'" ' . ( $link_link_new_tab == true ? 'target="_blank"' : null ) . ( $link_link_title == true ? 'title="'.$link_link_title.'"' : null ).'>';

} else {

	echo '<a href="#">';
}

echo '<div class="bsaProItemInner bsaAnimateCircle">'; // -- START -- ITEM INNER


		echo '
		<div class="bsaReveal bsaCircle_wrapper bsaProItemInner__copy">
			<div class="bsaCircle">
			';

		echo '<p class="bsaProItemInner__desc" style="color:'.$description_color.'">'.$ad['description'].'</p>'; // -- ITEM -- DESCRIPTION

		echo '
			</div>
		</div>

		<div class="bsaSticky bsaAnimateCircle">
			<div class="bsaFront bsaCircle_wrapper bsaAnimateCircle">
				<div class="bsaCircle bsaAnimateCircle"></div>
			</div>
		</div>
		';

		echo '<h3 class="bsaProItemInner__title" style="color:'.$title_color.'">'.$ad['title'].'</h3>'; // -- ITEM -- TITLE

		echo '
		<div class="bsaSticky bsaAnimateCircle">
			<div class="bsaBack bsaCircle_wrapper bsaAnimateCircle">
			<div class="bsaCircle bsaAnimateCircle"></div>
			</div>
		</div>
		';



		echo '</div>'; // -- END -- ITEM INNER

		echo '</a>'; // -- END -- LINK

		echo '</div>'; // -- END -- ITEM

	echo '</div>'; // -- END -- ITEMS

	echo '</div>'; // -- END -- CONTAINER
// -- END -- TEMPLATE HTML

$background = ($background_color != '') ? $background_color : NULL;
$bgGradientFront = ($extra_color_1 != '') ? 'bottom, transparent 75%, '.$extra_color_1.' 95%' : NULL;
$bgGradientBack = ($extra_color_1 != '') ? 'bottom, transparent, '.$extra_color_1 : NULL;
$backgroundBack = ($extra_color_2 != '') ? $extra_color_2 : NULL;

echo '
<style>
#bsa-paper-note-3 .bsaProItemInner .bsaFront .bsaCircle{
	margin-top: -10px;
	background: '.$background.';

	background-image: -webkit-linear-gradient('.$bgGradientFront.');
	background-image: -moz-linear-gradient('.$bgGradientFront.');
	background-image: linear-gradient('.$bgGradientFront.');
}
#bsa-paper-note-3 .bsaProItemInner:hover .bsaFront .bsaCircle {
	background-color: '.$background.';
}
#bsa-paper-note-3 .bsaProItemInner .bsaBack .bsaCircle{
	margin-top: -130px;
	background-color: '.$background.';

	background-image: -webkit-linear-gradient('.$bgGradientBack.');
	background-image: -moz-linear-gradient('.$bgGradientBack.');
	background-image: linear-gradient('.$bgGradientBack.');
}
#bsa-paper-note-3 .bsaProItemInner .bsaReveal .bsaCircle{
	background: '.$backgroundBack.';
}
</style>
';