<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Activity content
 *
 * Created by ShineTheme
 *
 */
global $wp_query;
$activity=new STActivity();
$allOrderby=$activity->getOrderby();
?>
<div class="row">
    <div class="col-md-12">
        <!--<div class="nav-drop booking-sort">
            <?php /*$allOrderby=$activity->getOrderby();
            */?>
            <h5 class="booking-sort-title">
                <a href="#" onclick="return false" >
                    <?php /*st_the_language('sort') ; _e(':',ST_TEXTDOMAIN);
                    if(is_array($allOrderby))
                    {
                        //Reset
                        reset($allOrderby);
                        //$first=$allOrderby[1];

                        if($order=STInput::get('orderby') and isset($allOrderby[$order])){
                            echo esc_html( $allOrderby[$order]['name']);
                        }elseif(isset($first))
                        {
                            echo esc_html( $first['name']);
                        }
                    }
                    */?>
                    <i class="fa fa-angle-down"></i>
                    <i class="fa fa-angle-up"></i>
                </a>
            </h5>
            <ul class="nav-drop-menu">
                <?php /*if(!empty($allOrderby) and is_array($allOrderby)):
                    foreach($allOrderby as $key=>$value)
                    {
                        echo '<li><a href="'.TravelHelper::build_url('orderby',$key).'">'.$value['name'].'</a>';
                    }
                endif;
                */?>
            </ul>
        </div>-->
        <?php
        if(!empty($attr)){
            extract($attr);
        }else{
            $st_style='1';
        }
        $style = STInput::request('style');
        if(!empty($style)){
            $st_style = $style ;
        }
        ?>
        <div class="sort_top">
            <div class="row">
                <div class="col-md-10 col-sm-9">
                    <ul class="nav nav-pills">
                        <?php
                        $active = STInput::request('orderby');
                        if(!empty($allOrderby) and is_array($allOrderby)):
                            foreach($allOrderby as $key=>$value)
                            {
                                if($active == $key){
                                    echo '<li class="active"><a href="'.TravelHelper::build_url('orderby',$key).'">'.$value['name'].'</a>';
                                }elseif($key == 'new' and empty($active)){
                                    echo '<li class="active"><a href="'.TravelHelper::build_url('orderby',$key).'">'.$value['name'].'</a>';
                                }else{
                                    echo '<li><a href="'.TravelHelper::build_url('orderby',$key).'">'.$value['name'].'</a>';

                                }
                            }
                        endif;
                        ?>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-3 text-center">
                    <div class="sort_icon fist"><a class="<?php if($st_style=='2')echo'active'; ?>" href="<?php echo TravelHelper::build_url('style','2') ?>"><i class="fa fa-th-large "></i></a></div>
                    <div class="sort_icon last"><a class="<?php if($st_style=='1')echo'active'; ?>" href="<?php echo TravelHelper::build_url('style','1') ?>"><i class="fa fa-list "></i></a></div>
                </div>
            </div>
        </div>
        <?php

        if($st_style == '1'){
            echo st()->load_template('activity/elements/loop/loop-1');
        }
        if($st_style == '2'){
            echo st()->load_template('activity/elements/loop/loop-2');
        }
        ?>

        <div class="row">
            <div class="col-sm-12">
                <hr>
            </div>
            <div class="col-md-6">
                <p>
                    <small><?php echo balanceTags($activity->get_result_string())?>.
                        <?php
                        if($wp_query->found_posts):
                            st_the_language('showing');
                            $page=get_query_var('paged');
                            $posts_per_page=get_query_var('posts_per_page');
                            if(!$page) $page=1;

                            $last=$posts_per_page*($page);

                            if($last>$wp_query->found_posts) $last=$wp_query->found_posts;
                            echo ' '.($posts_per_page*($page-1)+1).' - '.$last;
                        endif;
                        ?>
                    </small>
                </p>
                <?php
                TravelHelper::paging(); ?>
            </div>
            <div class="col-md-6 text-right">
                <p>
                    <?php st_the_language('not_what_you_looking_for') ?>
                    <a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">
                        <?php st_the_language('try_your_search_again') ?>
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>