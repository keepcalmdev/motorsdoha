<?php
if(empty($affix)) {$affix = "";}
if(empty($start_value)) {$start_value = 0;}
if(empty($end_value)) {$end_value = 0;}
?>
<script type="text/javascript">
    var stmOptions_<?php echo esc_attr($js_slug); ?>;
    (function ($) {
        $(document).ready(function () {

            var minTxt = "Min";
            var maxTxt = "Max";
            var lang = $('html').attr("lang")
            if(lang !== "en-US") {
                minTxt = "الحد الأدنى";
                maxTxt = "أقصى";
            }

            var affix = "<?php echo esc_js($affix); ?>";
            var stmMinValue = <?php echo esc_js($start_value); ?>;
            var stmMaxValue = <?php echo esc_js($end_value); ?>;
            stmOptions_<?php echo esc_attr($js_slug); ?> = {
                range: true,
                min: <?php echo esc_js($start_value); ?>,
                max: <?php echo esc_js($end_value); ?>,
                values: [<?php echo esc_js($min_value); ?>, <?php echo esc_js($max_value); ?>],
                step: 1,
                slide: function (event, ui) {
                    var max = $( ".stm-price-range" ).slider( "option", "max" );
                    var min = $( ".stm-price-range" ).slider( "option", "min" );
                    //set min
                    if(ui.values[0] == min) {
                        $("#stm_filter_min_<?php echo esc_attr($slug); ?>").val(minTxt);
                    } else {
                        $("#stm_filter_min_<?php echo esc_attr($slug); ?>").val(ui.values[0]);                        
                    }
                    //set max
                    if(ui.values[1] == max) {
                        $("#stm_filter_max_<?php echo esc_attr($slug); ?>").val(maxTxt);
                    } else {
                        $("#stm_filter_max_<?php echo esc_attr($slug); ?>").val(ui.values[1]);
                    }

                    <?php if($slug == 'price'): ?>
                    var stmCurrency = "<?php echo esc_js(stm_get_price_currency()); ?>";
                    var stmPriceDel = "<?php echo esc_js(get_theme_mod('price_delimeter',' ')); ?>";
                    var stmCurrencyPos = "<?php echo esc_js(get_theme_mod('price_currency_position', 'left')); ?>";
                    var stmText = stm_get_price_view(ui.values[0], stmCurrency, stmCurrencyPos, stmPriceDel ) + ' - ' + stm_get_price_view(ui.values[1], stmCurrency, stmCurrencyPos, stmPriceDel );
                    <?php else: ?>
                    var stmText = ui.values[0] + affix + ' — ' + ui.values[1] + affix;
                    <?php endif; ?>

                    $('.filter-<?php echo esc_attr($slug); ?> .stm-current-slider-labels').html(stmText);
                }
            };
            $(".stm-<?php echo esc_attr($slug); ?>-range").slider(stmOptions_<?php echo esc_attr($js_slug); ?>);


            $("#stm_filter_min_<?php echo esc_attr($slug); ?>").val($(".stm-<?php echo esc_attr($slug); ?>-range").slider("values", 0));
            $("#stm_filter_max_<?php echo esc_attr($slug); ?>").val($(".stm-<?php echo esc_attr($slug); ?>-range").slider("values", 1));

            $("#stm_filter_min_price").val(minTxt);
            $("#stm_filter_max_price").val(maxTxt);

            $("#stm_filter_min_<?php echo esc_attr($slug); ?>").keyup(function () {
                $(".stm-<?php echo esc_attr($slug); ?>-range").slider("values", 0, $(this).val());
            });

            $("#stm_filter_min_<?php echo esc_attr($slug); ?>").focusout(function () {
                if ($(this).val() < stmMinValue) {
                    $(".stm-<?php echo esc_attr($slug); ?>-range").slider("values", 0, stmMinValue);
                    $(this).val(stmMinValue);
                }
                if($(this).val() == stmMinValue) {$(this).val(minTxt)}
            });

            $("#stm_filter_max_<?php echo esc_attr($slug); ?>").keyup(function () {
                $(".stm-<?php echo esc_attr($slug); ?>-range").slider("values", 1, $(this).val());
            });

            $("#stm_filter_max_<?php echo esc_attr($slug); ?>").focusout(function () {
                if ($(this).val() > stmMaxValue) {
                    $(".stm-<?php echo esc_attr($slug); ?>-range").slider("values", 1, stmMaxValue);
                    $(this).val(stmMaxValue);
                }
                if($(this).val() == stmMaxValue) {$(this).val(maxTxt)}
            });
        })
    })(jQuery);
</script>