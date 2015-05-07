<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tours image featured
 *
 * Created by ShineTheme
 *
 */
    if(has_post_thumbnail()){
        the_post_thumbnail( 'full');
    }else{
        echo st_get_default_image() ;
    }
