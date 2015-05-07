<?php
$img_bg = wp_get_attachment_image_src($st_bg,'full');
$img_avatar = wp_get_attachment_image_src($st_avatar,'full');
$class_bg_img = Assets::build_css(" background: url(".$img_bg[0].") ");
?>
<div class="bg-holder full">
    <div class="bg-mask"></div>
    <div class="bg-img <?php echo esc_attr($class_bg_img) ?>"></div>
    <div class="bg-content">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-md-offset-<?php echo esc_attr($st_pos) ?>">
                    <!-- START TESTIMONIAL -->
                    <div class="testimonial text-white mt50">
                        <div class="testimonial-inner">
                            <blockquote>
                                <p><?php echo esc_html($st_desc); ?></p>
                            </blockquote>
                        </div>
                        <div class="testimonial-author">
                            <img src="<?php echo bfi_thumb(esc_url($img_avatar[0]) , array('width'=>50))  ?>" alt="<?php echo esc_html($st_name); ?>" title="<?php echo esc_html($st_name); ?>" />
                            <p class="testimonial-author-name"><?php echo esc_html($st_name); ?></p>
                            <cite>
                                <?php echo esc_html($st_sub); ?>
                            </cite>
                        </div>
                    </div>
                    <!-- END TESTIMONIAL -->
                </div>
            </div>
        </div>
    </div>
</div>