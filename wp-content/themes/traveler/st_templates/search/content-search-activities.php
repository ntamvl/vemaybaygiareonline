<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Content search activity
 *
 * Created by ShineTheme
 *
 */
$activity=new STActivity();
$fields=$activity->get_search_fields();
?>

<h2><?php echo esc_html($st_title_search) ?></h2>
<form role="search" method="get" class="search" action="<?php echo home_url( '/' ); ?>">
    <input type="hidden" name="s" value="">
    <input type="hidden" name="post_type" value="st_activity">
    <div class="<?php  if($st_direction=='horizontal') echo 'row';?>">
        <?php
        if(!empty($fields))
        {
            foreach($fields as $key=>$value)
            {
                $name=$value['activity_field_search'];
                $size='4';
                if($st_style_search=="style_1")
                {
                    $size=$value['layout_col'];
                }else
                {
                    if($value['layout2_col'])
                    {
                        $size=$value['layout2_col'];
                    }
                }
                if($st_direction!='horizontal'){
                    $size='x';
                }
                ?>
                <div class="col-md-<?php echo esc_attr($size);
                ?>">
                    <?php echo st()->load_template('activity/elements/search/field',$name,array('data'=>$value,'field_size'=>$field_size)) ?>
                </div>
            <?php
            }
        }?>
    </div>
    <button class="btn btn-primary btn-lg" type="submit"><?php st_the_language('search_for_activity')?></button>
</form>
