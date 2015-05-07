<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Rental result
 *
 * Created by ShineTheme
 *
 */
$default=array(
    'style'=>'list'
);
global $wp_query;

if(isset($arg)){
    extract(wp_parse_args($arg,$default));
}else{
    extract($default);
}
if(STInput::get('style')){
    $style=STInput::get('style');
}
$object=new STRental();
$allOrderby=$object->getOrderby();
?>
<div class="nav-drop booking-sort">
</div>

<div class="sort_top">
    <div class="row">
        <div class="col-md-10 col-sm-9">
            <ul class="nav nav-pills">
                <?php
                $active = STInput::request('orderby');
                if(!empty($allOrderby) and is_array($allOrderby)):$i=0;
                    foreach($allOrderby as $key=>$value)
                    {
                        $i++;
                        $class='';
                        if($key==$active){
                            $class='active';
                        }elseif($i==1 and !$active){
                            $class='active';
                        }
                        echo '<li class="'.$class.'"><a href="'.TravelHelper::build_url('orderby',$key).'">'.$value['name'].'</a>';
                    }
                endif;
                ?>
            </ul>
        </div>
        <div class="col-md-2 col-sm-3 text-center">
            <div class="sort_icon fist"><a class="<?php if($style=='grid')echo'active'; ?>" href="<?php echo TravelHelper::build_url('style','grid') ?>"><i class="fa fa-th-large "></i></a></div>
            <div class="sort_icon last"><a class="<?php if($style=='list')echo'active'; ?>" href="<?php echo TravelHelper::build_url('style','list') ?>"><i class="fa fa-list "></i></a></div>
        </div>
    </div>
</div>
<?php   echo st()->load_template('rental/loop',false,array('style'=>$style));?>
<div class="row" style="margin-bottom: 40px;">
    <div class="col-sm-12">
        <hr>
    </div>
    <div class="col-md-6">
        <p>
            <small><?php echo balanceTags($object->get_result_string())?>. &nbsp;&nbsp;
                <?php
                if($wp_query->found_posts):
                    st_the_language('rental_showing');
                    $page=get_query_var('paged');
                    $posts_per_page=get_query_var('posts_per_page');
                    if(!$page) $page=1;

                    $last=$posts_per_page*($page)+1;

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
            <?php st_the_language('rental_not_what_you_looking_for') ?>
            <a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">
                <?php st_the_language('rental_try_your_search_again') ?>
            </a>
        </p>
    </div>
</div>
