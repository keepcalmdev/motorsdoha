<?php
$template_name = 'image-2';

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

echo '<div class="bsaProItemInner" style="background:'.$background_color.'">'; // -- START -- ITEM INNER



		echo '<div class="bsaProItemInner__thumb">'; // -- START -- ITEM THUMB

echo '<div class="bsaProItemInner__img" style="background-image: url(&#39;'.$ad['img'].'&#39;)"></div>'; // -- ITEM -- IMG

		echo '</div>'; // -- END -- ITEM THUMB


		echo '<div class="bsaProItemInner__copy">'; // -- START -- ITEM COPY

		echo '<div class="bsaProItemInner__copyInnerBg" style="background-color:'.$extra_color_1.'"></div>';

		echo '<div class="bsaProItemInner__copyInner">'; // -- START -- ITEM COPY INNER

		echo '<h3 class="bsaProItemInner__title" style="color:'.$title_color.'">'.$ad['title'].'</h3>'; // -- ITEM -- TITLE

		echo '</div>'; // -- END -- ITEM COPY INNER

		echo '</div>'; // -- END -- ITEM COPY



		echo '</div>'; // -- END -- ITEM INNER

		echo '</a>'; // -- END -- LINK

		echo '</div>'; // -- END -- ITEM

	echo '</div>'; // -- END -- ITEMS

	echo '</div>'; // -- END -- CONTAINER
// -- END -- TEMPLATE HTML