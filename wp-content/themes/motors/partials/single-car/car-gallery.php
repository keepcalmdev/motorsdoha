<?php
//Getting gallery list
$post_id = get_the_ID();

$gallery = get_post_meta($post_id, 'gallery', true);
$video_preview = get_post_meta($post_id, 'video_preview', true);
$gallery_video = get_post_meta($post_id, 'gallery_video', true);
$special_car = get_post_meta($post_id,'special_car', true);

$badge_text = get_post_meta($post_id,'badge_text',true);
$badge_bg_color = get_post_meta($post_id,'badge_bg_color',true);

//car name
$condition = get_post_meta($post_id,'condition',true);
$car_make = ucfirst(get_post_meta($post_id,'make',true));
$car_model = ucfirst(get_post_meta($post_id,'serie',true));
$car_year = get_post_meta($post_id,'ca-year',true);
$img_alt = "";
$img_alt_prefix = "";
if($condition == "used-cars"){
	$img_alt_prefix = "Used";
} 
$img_alt = $img_alt_prefix . " ". $car_make . " ". $car_model ." ". $car_year;


if(empty($badge_text)) {
    $badge_text = 'Special';
}

$badge_style = '';
if(!empty($badge_bg_color)) {
    $badge_style = 'style=background-color:'.$badge_bg_color.';';
}
$show_favorite = get_theme_mod('enable_favorite_items', true);

?>

<?php if(!has_post_thumbnail() and stm_check_if_car_imported($post_id)): ?>
	<img
		src="<?php echo esc_url(get_stylesheet_directory_uri().'/assets/images/automanager_placeholders/plchldr798automanager.png'); ?>"
		class="img-responsive"
		alt="<?php esc_attr_e('Placeholder', 'motors'); ?>"
		/>
<?php endif; ?>


<div class="stm-car-carousels">

	<!--New badge with videos-->
	<?php $car_media = stm_get_car_medias($post_id); ?>
	<?php if(!empty($car_media['car_videos_count']) and $car_media['car_videos_count'] > 0): ?>
		<div class="stm-car-medias">
			<div class="stm-listing-videos-unit stm-car-videos-<?php echo get_the_id(); ?>">
				<i class="fa fa-film"></i>
				<span><?php echo esc_html($car_media['car_videos_count']); ?> <?php esc_html_e('Video', 'motors'); ?></span>
			</div>
		</div>

		<script>
			jQuery(document).ready(function(){

				jQuery(".stm-car-videos-<?php echo get_the_id(); ?>").on('click', function() {
					jQuery(this).lightGallery({
                        dynamic: true,
                        dynamicEl: [
                            <?php foreach($car_media['car_videos'] as $car_video): ?>
                            {
								src  : "<?php echo esc_url($car_video); ?>"
                            },
                            <?php endforeach; ?>
                        ],
                        download: false,
                        mode: 'lg-fade',
                    })
				}); //click
			}); //ready

		</script>
	<?php endif; ?>
	<?php if(!empty($special_car) and $special_car == 'on'): ?>
		<div class="special-label h5" <?php echo esc_attr($badge_style); ?>>
            <?php printf( _x( '%s', 'Badge text', 'motors' ), $badge_text ); ?>
        </div>
	<?php endif; ?>
	<div class="stm-big-car-gallery">

		<?php if(has_post_thumbnail()):
			$full_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
			//Post thumbnail first ?>
			<div class="stm-single-image" data-id="big-image-<?php echo esc_attr(get_post_thumbnail_id($post_id)); ?>">
                <!--Favorite-->
                <?php if(!empty($show_favorite) and $show_favorite): ?>
                    <div
                            class="stm-listing-favorite"
                            data-id="<?php echo esc_attr(get_the_id()); ?>"
                            data-toggle="tooltip" data-placement="left" title="<?php esc_attr_e('Add to favorites', 'motors') ?>"
                    >
                        <i class="stm-service-icon-staricon"></i>
                    </div>
                <?php endif; ?>
				<a href="<?php echo esc_url($full_src[0]); ?>" class="stm_fancybox" rel="stm-car-gallery">
					<?php the_post_thumbnail('stm-img-796-466', array('class'=>'img-responsive', 'alt'=>$img_alt)); ?>
				</a>
			</div>
		<?php endif; ?>

		<?php if(!empty($video_preview) and !empty($gallery_video)): ?>
			<?php $src = wp_get_attachment_image_src($video_preview, 'stm-img-796-466'); ?>
			<?php if(!empty($src[0])): ?>
				<div class="stm-single-image video-preview" data-id="big-image-<?php echo esc_attr($video_preview); ?>">
					<a class="fancy-iframe" data-url="<?php echo esc_url($gallery_video); ?>">
						<img src="<?php echo esc_url($src[0]); ?>" class="img-responsive" alt="<?php echo $img_alt; //esc_attr_e('Video preview', 'motors'); ?>"/>
					</a>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if(!empty($gallery)): ?>
			<?php foreach ( $gallery as $gallery_image ): ?>
				<?php $src = wp_get_attachment_image_src($gallery_image, 'stm-img-796-466'); ?>
				<?php $full_src = wp_get_attachment_image_src($gallery_image, 'full'); ?>
				<?php if(!empty($src[0]) && $gallery_image != get_post_thumbnail_id(get_the_ID())): ?>
					<div class="stm-single-image" data-id="big-image-<?php echo esc_attr($gallery_image); ?>">
						<a href="<?php echo esc_url($full_src[0]); ?>" class="stm_fancybox" rel="stm-car-gallery">
							<img src="<?php echo esc_url($src[0]); ?>" alt="<?php echo $img_alt;//printf(esc_attr__('%s full','motors'), get_the_title($post_id)); ?>"/>
						</a>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>

        <?php if(!empty($car_media['car_videos_posters']) and !empty($car_media['car_videos'])): ?>
            <?php foreach($car_media['car_videos_posters'] as $k => $val):
                $src = wp_get_attachment_image_src($val, 'stm-img-350-205');
                $videoSrc = (isset($car_media['car_videos'][$k])) ? $car_media['car_videos'][$k] : '';
                if(!empty($src[0])): ?>
                    <div class="stm-single-image video-preview" data-id="big-image-<?php echo esc_attr($val); ?>">
                        <a class="fancy-iframe" data-url="<?php echo esc_url($videoSrc); ?>">
                            <img src="<?php echo esc_url($src[0]); ?>" class="img-responsive" alt="<?php echo $img_alt;//esc_attr_e('Video preview', 'motors'); ?>"/>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

	</div>

	<?php if(has_post_thumbnail() || ( !empty($video_preview) and !empty($gallery_video) ) ): ?>
		<div class="stm-thumbs-car-gallery">

			<?php if(has_post_thumbnail()):
				//Post thumbnail first ?>
				<div class="stm-single-image" id="big-image-<?php echo esc_attr(get_post_thumbnail_id($post_id)); ?>">
					<?php the_post_thumbnail('stm-img-350-205', array('class'=>'img-responsive', 'alt'=>$img_alt)); ?>
				</div>
			<?php endif; ?>

			<?php if(!empty($video_preview) and !empty($gallery_video)): ?>
				<?php $src = wp_get_attachment_image_src($video_preview, 'stm-img-350-205'); ?>
				<?php if(!empty($src[0])): ?>
					<div class="stm-single-image video-preview" data-id="big-image-<?php echo esc_attr($video_preview); ?>">
						<a class="fancy-iframe" data-url="<?php echo esc_url($gallery_video); ?>">
							<img src="<?php echo esc_url($src[0]); ?>" alt="<?php echo $img_alt;//esc_attr_e('Video preview', 'motors'); ?>"/>
						</a>
					</div>
				<?php endif; ?>
			<?php endif; ?>

            <?php if(!empty($gallery)): ?>
				<?php foreach ( $gallery as $gallery_image ): ?>
					<?php $src = wp_get_attachment_image_src($gallery_image, 'stm-img-350-205'); ?>
					<?php if(!empty($src[0]) && $gallery_image != get_post_thumbnail_id(get_the_ID())): ?>
						<div class="stm-single-image" id="big-image-<?php echo esc_attr($gallery_image); ?>">
							<img src="<?php echo esc_url($src[0]); ?>" alt="<?php echo $img_alt;//printf(esc_attr__('%s full','motors'), get_the_title($post_id)); ?>"/>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>

            <?php if(!empty($car_media['car_videos_posters']) and !empty($car_media['car_videos'])): ?>
                <?php foreach($car_media['car_videos_posters'] as $k => $val):
                    $src = wp_get_attachment_image_src($val, 'stm-img-350-205');
                    $videoSrc = (isset($car_media['car_videos'][$k])) ? $car_media['car_videos'][$k] : '';
                    if(!empty($src[0])): ?>
                        <div class="stm-single-image video-preview" data-id="big-image-<?php echo esc_attr($video_preview); ?>">
                            <a class="fancy-iframe" data-url="<?php echo esc_url($videoSrc); ?>">
                                <img src="<?php echo esc_url($src[0]); ?>" alt="<?php echo $img_alt;//esc_attr_e('Video preview', 'motors'); ?>"/>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

		</div>
	<?php endif; ?>
</div>


<!--Enable carousel-->
<script>
	jQuery(document).ready(function($){
		var big = $('.stm-big-car-gallery');
		var small = $('.stm-thumbs-car-gallery');
		var flag = false;
		var duration = 800;

		var owlRtl = false;
		if( $('body').hasClass('rtl') ) {
			owlRtl = true;
		}

		big
			.owlCarousel({
				rtl: owlRtl,
				items: 1,
				smartSpeed: 800,
				dots: false,
				nav: false,
				margin:0,
				autoplay: false,
				loop: false,
				responsiveRefreshRate: 1000
			})
			.on('changed.owl.carousel', function (e) {
				$('.stm-thumbs-car-gallery .owl-item').removeClass('current');
				$('.stm-thumbs-car-gallery .owl-item').eq(e.item.index).addClass('current');
				if (!flag) {
					flag = true;
					small.trigger('to.owl.carousel', [e.item.index, duration, true]);
					flag = false;
				}
			});

		small
			.owlCarousel({
				rtl: owlRtl,
				items: 5,
				smartSpeed: 800,
				dots: false,
				margin: 22,
				autoplay: false,
				nav: true,
				loop: false,
				navText: [],
				responsiveRefreshRate: 1000,
				responsive:{
					0:{
						items:2
					},
					500:{
						items:4
					},
					768:{
						items:5
					},
					1000:{
						items:5
					}
				}
			})
			.on('click', '.owl-item', function(event) {
				big.trigger('to.owl.carousel', [$(this).index(), 400, true]);
			})
			.on('changed.owl.carousel', function (e) {
				if (!flag) {
					flag = true;
					big.trigger('to.owl.carousel', [e.item.index, duration, true]);
					flag = false;
				}
			});

		if($('.stm-thumbs-car-gallery .stm-single-image').length < 6) {
			$('.stm-single-car-page .owl-controls').hide();
			$('.stm-thumbs-car-gallery').css({'margin-top': '22px'});
		}
	})
</script>