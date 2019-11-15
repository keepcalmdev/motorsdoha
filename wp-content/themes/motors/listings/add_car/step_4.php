<?php if(empty($id)):?>
    <div class="stm-form-4-videos clearfix">
        <div class="stm-car-listing-data-single stm-border-top-unit ">
            <div class="title heading-font"><?php esc_html_e('Add Videos', 'motors'); ?></div>
            <span class="step_number step_number_4 heading-font"><?php esc_html_e('step', 'motors'); ?> 4</span>
        </div>
        <div class="stm-add-videos-unit">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="stm-video-units">
                        <div class="stm-video-link-unit-wrap">
                            <div class="heading-font">
                                <span class="video-label"><?php esc_html_e('Video link', 'motors'); ?></span> <span
                                    class="count">1</span></div>
                            <div class="stm-video-link-unit">
                                <input type="text" name="stm_video[]"/>
                                <div class="stm-after-video"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="stm-simple-notice">
                        <i class="fa fa-info-circle"></i>
                        <?php esc_html_e('If you don\'t have the videos handy, don\'t worry. You can add or edit them after you complete your ad using the "Manage Your Ad" page.', 'motors'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>
    <?php $video = get_post_meta($id, 'gallery_video', true); ?>

    <div class="stm-form-4-videos clearfix">
        <div class="stm-car-listing-data-single stm-border-top-unit ">
            <div class="title heading-font"><?php esc_html_e('Add Videos', 'motors'); ?></div>
            <span class="step_number step_number_4 heading-font"><?php esc_html_e('step', 'motors'); ?> 4</span>
        </div>
        <?php $has_videos = false; ?>
        <div class="stm-add-videos-unit">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="stm-video-units">
                        <div class="stm-video-link-unit-wrap">
                            <div class="heading-font">
                                <span class="video-label"><?php esc_html_e('Video link', 'motors'); ?></span> <span
                                    class="count">1</span>
                            </div>
                            <?php
                            $video = get_post_meta($id, 'gallery_video', true);
                            if (empty($video)) {
                                $video = '';
                            } else {
                                $has_videos = true;
                            }
                            ?>
                            <div class="stm-video-link-unit">
                                <input type="text" name="stm_video[]" value="<?php echo esc_url($video); ?>"/>
                                <div class="stm-after-video active"></div>
                            </div>
                            <?php if ($has_videos): ?>
                                <?php $gallery_videos = get_post_meta($id, 'gallery_videos', true);
                                if (!empty($gallery_videos)): ?>
                                    <?php foreach ($gallery_videos as $gallery_video): ?>
                                        <div class="stm-video-link-unit">
                                            <input type="text" name="stm_video[]"
                                                   value="<?php echo esc_url($gallery_video); ?>"/>
                                            <div class="stm-after-video active"></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="stm-simple-notice">
                        <i class="fa fa-info-circle"></i>
                        <?php esc_html_e('If you don\'t have the videos handy, don\'t worry. You can add or edit them after you complete your ad using the "Manage Your Ad" page.', 'motors'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

    <div class="stm-form-1-quarter">
    </div>

    <div class="stm-form-4-videos clearfix">
        <div class="stm-car-listing-data-single stm-border-top-unit " style="border: 0px;">
            <div class="title heading-font">360 Link</div>
        </div>
        <div class="stm-add-videos-unit">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="stm-video-units">
                        <div class="stm-video-link-unit-wrap">
                            <div class="heading-font">
                                <span class="video-label">360 link</span></div>
                            <div class="stm-video-link-unit">
                                <input type="text" name="stm_s_s_image_360" value="<?php echo base64_decode(get_post_meta($_GET['item_id'], 'image_360', true)); ?>" placeholder="360 Link">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>