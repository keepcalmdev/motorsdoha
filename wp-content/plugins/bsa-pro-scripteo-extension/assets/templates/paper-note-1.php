<?php
$template_name = 'paper-note-1';

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

echo '<div class="bsaProItemInner bsaNote bsaRounded" style="background:'.$background_color.'">'; // -- START -- ITEM INNER



echo '<div class="bsaProItemInner__copy">'; // -- START -- ITEM COPY

echo '<div class="bsaProItemInner__copyInner">'; // -- START -- ITEM COPY INNER

echo '<h3 class="bsaProItemInner__title" style="color:'.$title_color.'">'.$ad['title'].'</h3>'; // -- ITEM -- TITLE

echo '<p class="bsaProItemInner__desc" style="color:'.$description_color.'">'.$ad['description'].'</p>'; // -- ITEM -- DESCRIPTION

if ( $ad['url'] != '' && $ad['url'] != '#' ) {
	echo '<span class="bsaProItemInner__url" style="color:'.$url_color.'">' . $ad['url'] . '</span>'; // -- ITEM -- URL
}

echo '</div>'; // -- END -- ITEM COPY INNER

echo '</div>'; // -- END -- ITEM COPY



echo '</div>'; // -- END -- ITEM INNER

echo '</a>'; // -- END -- LINK

echo '</div>'; // -- END -- ITEM

echo '</div>'; // -- END -- ITEMS

echo '</div>'; // -- END -- CONTAINER
// -- END -- TEMPLATE HTML

$bgNote = ($extra_color_1 != '') ? $extra_color_1 : NULL;
$borderNote = ($extra_color_2 != '') ? $extra_color_2.' '.$extra_color_2.' transparent transparent' : NULL;

echo '
<style>
#bsa-paper-note-1 .bsaProItemInner.bsaNote:before {
	background: '.$bgNote.';
}
#bsa-paper-note-1 .bsaProItemInner.bsaNote.bsaRounded:before {
	border-color: '.$borderNote.';
}
</style>
';