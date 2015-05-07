<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Review list
 *
 * Created by ShineTheme
 *
 */

$comment=$GLOBALS['comment'];
/* override default avatar size */
$args['avatar_size'] = 70;
if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) :

    //Do not allow pingback

    ?>
<?php else :

    $comment_class='';

    empty( $args['has_children'] ) ? '' :$comment_class.= 'parent';

    ?>
<li id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment_class ); ?>>
    <div class="row">
        <div class="col-md-2">
            <div class="booking-item-review-person">
                <a class="booking-item-review-person-avatar round" href="#">
                    <?php
                    $comment_id=    get_comment_ID();
                    $user_id=get_comment($comment_id)->user_id;
                    echo st_get_profile_avatar( $user_id,70); ?>
                </a>
                <p class="booking-item-review-person-name"><?php printf( __( '%s', ST_TEXTDOMAIN ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
                </p>
                <p class="booking-item-review-person-loc"><?php
                    echo get_user_meta($user_id,'st_address',true)?></p>
                <small>
                    <a href="#"><?php  $review= STUser::count_review($user_id);

                        //echo esc_attr($review);

                        ?>
                        <?php
                            if($review==0){
                                st_the_language('0_review');
                            }elseif($review==1) {
                                st_the_language('1_review');
                            }else{
                                printf(__('%d ', ST_TEXTDOMAIN).st_get_language('reviews'),$review);
                            }
                        ?>

                    </a>
                </small>
            </div>
        </div>

        <div class="col-md-10">
            <div class="booking-item-review-content">
                <?php if($comment_title=get_comment_meta(get_comment_ID(),'comment_title',true)):

                ?>
                <h5>"<?php echo balanceTags($comment_title) ?>"</h5>
                <?php endif;?>

                <?php if($comment_rate=(int)get_comment_meta(get_comment_ID(),'comment_rate',true)):

                    ?>
                    <ul class="icon-group booking-item-rating-stars">
                        <?php
                        if(!$comment_rate) $comment_rate=1;
                          echo  TravelHelper::rate_to_string($comment_rate);
                        ?>

                    </ul>
                <?php endif;?>

                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php st_the_language('your_comment_is_awaiting_moderation'); ?></p>
                <?php endif; ?>
                <div class="comment-content">
                    <?php
                    $max_string=200;
                    $text=get_comment_text();

                    echo TravelHelper::add_read_more($text,$max_string);

                    ?>
                </div>

                <div class="<?php  /*if($max_string<strlen($text))*/ echo 'booking-item-review-more-content'?>">
                    <?php do_action('st_review_more_content',$comment_id)?>
                </div>
                <?php //if($max_string<strlen($text)):?>

                    <div class="booking-item-review-expand"><span class="booking-item-review-expand-more"><?php st_the_language('More')?> <i class="fa fa-angle-down"></i></span><span class="booking-item-review-expand-less"><?php st_the_language('Less')?> <i class="fa fa-angle-up"></i></span>
                    </div>
                <?php //endif;?>

                <p class="booking-item-review-rate"><?php st_the_language('was_this_review_helpful')?>
                    <?php $review_obj=new STReview();
                    if($review_obj->check_like($comment_id)):
                        ?>
                            <a data-id="<?php echo esc_attr($comment_id); ?>" class="st-like-review fa fa-thumbs-o-down box-icon-inline round" href="#"></a><b class="text-color"> <?php echo get_comment_meta($comment_id,'_comment_like_count',true) ?></b>

                        <?php
                            else:
                        ?>

                            <a data-id="<?php echo esc_attr($comment_id); ?>" class="st-like-review fa fa-thumbs-o-up box-icon-inline round" href="#"></a><b class="text-color"> <?php echo get_comment_meta($comment_id,'_comment_like_count',true) ?></b>
                        <?php endif; ?>
                </p>
            </div>
        </div>
<?php
endif;