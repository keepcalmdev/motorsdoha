<?php 
$filter = stm_listings_filter();
$condition ="";
while(list($key, $value) = each($filter["options"]["condition"])){

        if($value["selected"] && $value["label"]){
            $condition = $value["label"];
            break;
        }
    }  
$post_id = get_the_ID();
//car name
$car_make = ucfirst(get_post_meta($post_id,'make',true));
$car_model = ucfirst(get_post_meta($post_id,'serie',true));
$car_year = get_post_meta($post_id,'ca-year',true);
$img_alt = "";
$img_alt_prefix = "";

if($condition == "Used"){
	$img_alt_prefix = "Used";
} 
$img_alt = $img_alt_prefix . " ". $car_make . " ". $car_model ." ". $car_year;
?>
<div class="image">
	<!--Video-->
	<?php stm_listings_load_template('loop/list/video'); ?>

	<a href="<?php the_permalink() ?>" class="rmv_txt_drctn">
		<div class="image-inner">

			<!--Badge-->
			<?php stm_listings_load_template('loop/default/list/badge'); ?>

			<?php if(has_post_thumbnail()):
                $size = (stm_is_listing_two()) ? 'stm-img-255-160' : 'medium';

				the_post_thumbnail($size, array('class' => 'img-responsive', "alt"=>$img_alt));
			else:
			?>
				<img
					src="<?php echo esc_url(get_stylesheet_directory_uri().'/assets/images/plchldr350.png'); ?>"
					class="img-responsive "
					alt="<?php esc_attr_e('Placeholder', 'motors'); ?>"
				/>
			<?php endif; ?>
		</div>
	</a>
</div>