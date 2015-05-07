<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Tours content
 *
 * Created by ShineTheme
 *
 */
while(have_posts()){
    the_post();
    the_content();
}
