<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Rental header
 *
 * Created by ShineTheme
 *
 */
?>
<header class="">
    <h2 class="lh1em featured_single"><?php the_title()?><?php echo STFeatured::get_featured(); ?></h2>
    <p class="lh1em text-small"><i class="fa fa-map-marker"></i> <?php echo get_post_meta(get_the_ID(),'address',true) ?></p>
    <ul class="list list-inline text-small">

        <?php if($email=get_post_meta(get_the_ID(),'agent_email',true)):?>
            <li><a href="mailto:<?php echo esc_attr($email)?>"><i class="fa fa-envelope"></i> <?php st_the_language('rental_agent_mail')?></a>
            </li>
        <?php endif;?>

        <?php if($website=get_post_meta(get_the_ID(),'agent_website',true)):?>
            <li><a target="_blank" href="<?php echo esc_url( $website )?>"> <i class="fa fa-home"></i> <?php st_the_language('rental_agent_website')?></a>
            </li>
        <?php endif;?>

        <?php if($phone=get_post_meta(get_the_ID(),'agent_phone',true)):?>
            <li><a href="tel:<?php echo str_replace(' ','',trim($phone)) ?>"> <i class="fa fa-phone"></i> <?php echo esc_html( $phone)?></a>
            </li>
        <?php endif;?>


    </ul>
</header>