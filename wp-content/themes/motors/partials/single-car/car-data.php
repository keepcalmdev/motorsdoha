<?php
$user_fields = stm_get_user_custom_fields(get_the_author_id());
get_template_part('partials/single-car/car', 'buttons');

 if(!empty($user_fields['phone'])){  
  ?>
<div class="stm-car_dealer-buttons heading-font whatsapp-link">
    <a href="https://wa.me/<?php echo esc_attr($user_fields['phone']); ?>" target="_blank">Contact Whatsapp <i class="fa fa-whatsapp" aria-hidden="true"></i>
 </a>
</div>
  <?php
 }
$data = apply_filters( 'stm_single_car_data', stm_get_single_car_listings() );
$post_id = get_the_ID();
$vin_num = get_post_meta(get_the_id(), 'vin_number', true);
$data_meta = get_post_meta($post_id, 'car_title', true);
?>

<?php if (!empty($data)): ?>
    <div class="single-car-data">
        <?php
        /*If automanager, and no image in admin, set default image carfax*/
        $history_link_1 = get_post_meta(get_the_ID(), 'history_link', true);
        $certified_logo_1 = get_post_meta(get_the_ID(), 'certified_logo_1', true);
        if (stm_check_if_car_imported(get_the_ID()) and empty($certified_logo_1) and !empty($history_link_1)) {
            $certified_logo_1 = 'automanager_default';
        }

        if (!empty($certified_logo_1)):
            if ($certified_logo_1 == 'automanager_default') {
                $certified_logo_1 = array();
                $certified_logo_1[0] = get_template_directory_uri() . '/assets/images/carfax.png';
            } else {
                $certified_logo_1 = wp_get_attachment_image_src($certified_logo_1, 'stm-img-255-135');
            }
            if (!empty($certified_logo_1[0])) {
                $certified_logo_1 = $certified_logo_1[0]; ?>
                <div class="text-center stm-single-car-history-image">
                    <a href="<?php echo esc_url($history_link_1); ?>" target="_blank">
                        <img src="<?php echo esc_url($certified_logo_1); ?>" class="img-responsive dp-in"/>
                    </a>
                </div>
            <?php }
        endif;
        ?>
        <?php if(strpos(get_theme_mod("carguru_style", "STYLE1"), "STYLE") !== false) get_template_part('partials/single-car/car', 'gurus'); ?>

        <table>
            <?php foreach ($data as $data_value): ?>
	            <?php
	            $affix = '';
	            if(!empty($data_value['number_field_affix'])) {
		            $affix = $data_value['number_field_affix'];
	            }
	            ?>

	            
                <?php if ($data_value['slug'] != 'price'): ?>
                    <?php $data_meta = get_post_meta($post_id, $data_value['slug'], true); ?>
                    <?php if ($data_meta !== '' and $data_meta !== 'none'): ?>
                        <tr>
                            <td class="t-label"><?php esc_html_e($data_value['single_name'], 'motors'); ?></td>
                            <?php if (!empty($data_value['numeric']) and $data_value['numeric']): ?>

                                <td class="t-value h6"><?php echo esc_attr(ucfirst($data_meta .' '. $affix)); ?></td>
                            <?php else: ?>
                                <?php
                                $data_meta_array = explode(',', $data_meta);
                                $datas = array();

                                if (!empty($data_meta_array)) {
                                    foreach ($data_meta_array as $data_meta_single) {
                                        $data_meta = get_term_by('slug', $data_meta_single, $data_value['slug']);
                                        if (!empty($data_meta->name)) {
                                            $datas[] = esc_attr($data_meta->name) . $affix;
                                        }
                                    }
                                }


                                ?>

                                <td class="t-value h6"><?php echo implode(', ', $datas); ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>

            <!--VIN NUMBER-->
            <?php if (!empty($vin_num)): ?>
                <tr>
                    <td class="t-label"><?php esc_html_e('Vin', 'motors'); ?></td>
                    <td class="t-value t-vin h6"><?php echo esc_attr($vin_num); ?></td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
<?php endif; ?>



<!-- <script>
    jQuery(function(){
        function getTrans(q, type){
            jQuery.ajax({  
            url: 'https://translation.googleapis.com/language/translate/v2/?key=AIzaSyDcyyYqhqGyd65gSP1CMYPV_hRsTSAGWN0',  
            dataType: 'jsonp',
            data: { q: q,  // text to translate
                    v: '1.0',
                    'target': 'ar',
                    langpair: 'en|es' },   // '|es' for auto-detect
            success: function(result) {
                //alert(result.responseData.translatedText);
                //console.table(result.responseDetails)
                console.log("translation")
                console.log(result)
                if(type == "title"){
                    $("title").html(result.data.translations[0].translatedText)
                    
                }
            },  
            error: function(XMLHttpRequest, errorMsg, errorThrown) {
                //alert(errorMsg);
            }  
        });
        }
        console.log(jQuery("title").html())

        var title = $("title").html()
       // console.log(desc)
        getTrans(title, "title");
        //getTrans(desc, "desc");

    })
</script> -->