<?php
$template_name = 'flat-2';

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

		echo '<div class="bsaProAnimateThumb">';

		echo '<div class="bsaProItemInner__img" style="background-color: '.$extra_color_1.'">'; // -- START -- ITEM IMG

			echo '<div class="bsaProItemInner__imgSymbol" style="color: '.$extra_color_2.'">';

				echo '<div class="bsaProItemInner__imgSymbolBox"><i style="border-color: '.$extra_color_2.'">&nbsp;&gt;&nbsp;</i></div>';

			echo '</div>';

		echo '</div>'; // -- END -- ITEM IMG

		echo '</div>';

		echo '</div>'; // -- END -- ITEM THUMB


		echo '<div class="bsaProItemInner__copy">'; // -- START -- ITEM COPY

		echo '<div class="bsaProItemInner__copyInner">'; // -- START -- ITEM COPY INNER

		echo '<h3 class="bsaProItemInner__title" style="color:'.$title_color.'">'.$ad['title'].'</h3>'; // -- ITEM -- TITLE

		echo '<p class="bsaProItemInner__desc" style="color:'.$description_color.'">'.$ad['description'].'</p>'; // -- ITEM -- DESCRIPTION

		echo '</div>'; // -- END -- ITEM COPY INNER

		echo '</div>'; // -- END -- ITEM COPY



		echo '</div>'; // -- END -- ITEM INNER

		echo '</a>'; // -- END -- LINK

		echo '</div>'; // -- END -- ITEM

	echo '</div>'; // -- END -- ITEMS

	echo '</div>'; // -- END -- CONTAINER
// -- END -- TEMPLATE HTML
	echo '<style>';
	echo '#bsa-flat-2 .bsaProItemInner__thumb .bsaProItemInner__img .bsaProItemInner__imgSymbol .bsaProItemInner__imgSymbolBox > i {
position: absolute;
font-size: 50px;
    line-height: 55px;
    margin-top: 45px;
}';
	echo '</style>';