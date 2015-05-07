<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Custom user menu
 *
 * Created by ShineTheme
 *
 */

$login_fb=st()->get_option('social_fb_login','on');
$login_gg=st()->get_option('social_gg_login','on');
$login_tw=st()->get_option('social_tw_login','on');
if(function_exists('icl_get_languages'))
{
    $langs=icl_get_languages('skip_missing=0');
}
else{
    $langs=array();
}

?>
<div class="col-md-9">
    <div class="top-user-area clearfix">
        <ul class="top-user-area-list list list-horizontal list-border ">
            <?php if(is_user_logged_in()):?>
            <li class="top-user-area-avatar">
                <?php
                $account_dashboard = st()->get_option('page_my_account_dashboard');
                $location='#';
                if(!empty($account_dashboard)){
                    $location = esc_url(add_query_arg( 'page_id', $account_dashboard, home_url() ));
                }
                ?>
                <a href="<?php echo esc_url($location) ?>">
                    <?php
                    $current_user = wp_get_current_user();
                     echo st_get_profile_avatar($current_user->ID,40);
                    echo st_get_language('hi').', '.$current_user->display_name;
                    ?>
                </a>
            </li>
            <li>
                <a href="<?php echo wp_logout_url(home_url())?>"><?php st_the_language('sign_out')?></a>
            </li>
            <?php else: ?>
                <li class="nav-drop">
                    <?php
                    $page_login = st()->get_option('page_user_login');
                    ?>
                    <a href="#" onclick="return false;"><?php st_the_language('sign_in')?><i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></a>
                    <ul class="list nav-drop-menu user_nav_big social_login_nav_drop" >
                        <li><a  class="" href="<?php echo get_permalink($page_login) ?>"><?php st_the_language('sign_in')?></a></li>

                        <?php if($login_fb=="on"): ?>
                        <li><a onclick="return false" class="btn_login_fb_link login_social_link" href="<?php echo STSocialLogin::get_provider_login_url('Facebook') ?>"><?php st_the_language('connect_with')?> <i class="fa fa-facebook"></i></a></li>
                        <?php endif;?>

                        <?php if($login_gg=="on"): ?>
                        <li><a onclick="return false" class="btn_login_gg_link login_social_link" href="<?php echo STSocialLogin::get_provider_login_url('Google') ?>"><?php st_the_language('connect_with')?> <i class="fa fa-google-plus"></i></a></li>

                        <?php endif;?>

                        <?php if($login_tw=="on"): ?>
                        <li><a onclick="return false" class="btn_login_tw_link login_social_link" href="<?php echo STSocialLogin::get_provider_login_url('Twitter') ?>"><?php st_the_language('connect_with')?> <i class="fa fa-twitter"></i></a></li>
                        <?php endif;?>
                    </ul>
                </li>
            <?php endif;?>
            <li class="nav-drop">
                <a class="cursor" ><?php $current_currency=TravelHelper::get_current_currency();
                        if(isset($current_currency['name']))
                        {
                            echo esc_html( $current_currency['name']);

                        }
                        if(isset($current_currency['symbol']))
                        {
                            echo esc_html(' '.$current_currency['symbol']);

                        }

                    ?><i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></a>
                <ul class="list nav-drop-menu">
                    <?php $currency =TravelHelper::get_currency();
                        if(!empty($currency)){
                            foreach($currency as $key=>$value){
                                if($current_currency['name']!=$value['name'])
                                echo '<li><a href="'.esc_url(add_query_arg('currency',$value['name'])).'">'.$value['name'].'<span class="right">'.$value['symbol'].'</span></a>
                                      </li>';
                            }
                        }
                    ?>
                </ul>
            </li>
            <?php if(!empty($langs))
            {

                foreach($langs as $key=>$value){
                    if($value['active']==1){
                $current='
                    <a href="#">
                        <img src="'.$value['country_flag_url'].'" alt="'.$value['native_name'].'" title="'.$value['native_name'].'">'.$value['native_name'].'<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i>
                    </a>';
                        break;
                    }
                }

                echo '<li class="top-user-area-lang nav-drop">
                '.$current.'<ul class="list nav-drop-menu" style="min-width:100px">';
                foreach($langs as $key=>$value){
                    if($value['active']==1) continue;
                    ?>
                    <li>
                        <a title="<?php echo esc_attr($value['native_name']) ?>" href="<?php echo esc_url($value['url']) ?>">
                            <img src="<?php echo esc_attr($value['country_flag_url']) ?>" alt="<?php echo esc_attr($value['native_name']) ?>" title="<?php echo esc_attr($value['native_name']) ?>"><span class="right"><?php echo esc_attr($value['native_name']) ?></span>
                        </a>
                    </li>
                    <?php
                }
                echo '</ul></li>';
            }?>
        </ul>
        <form class="main-header-search" action="<?php echo home_url( '/' ); ?>" method="get">
            <div class="form-group form-group-icon-left">
                <i class="fa fa-search input-icon"></i>
                <input type="text" name="s" value="<?php echo get_search_query() ?>" class="form-control st-top-ajax-search">
                <input type="hidden" name="post_type" value="post">
            </div>
        </form>
    </div>
</div>