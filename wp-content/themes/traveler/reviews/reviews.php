<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Reviews
 *
 * Created by ShineTheme
 *
 */
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
    return;

$potype = get_post_type(get_the_ID());
$obj = get_post_type_object( $potype );
$name = $obj->labels->singular_name;

$is_review_need_booked=STReview::is_review_need_booked();
?>
<div id="comments" class="comments-area">


    <?php
    if ( have_comments() ) : ?>

        <ul class="booking-item-reviews list">
            <?php
            wp_list_comments( array(
                'style'       => 'ul',
                'short_ping'  => true,
                'avatar_size' => 74,
                'callback'=>array('TravelHelper','reviewlist')
            ) );
            ?>
        </ul><!-- .comment-list -->
        <div class="gap gap-small"></div>
        <div class="row wrap">
            <div class="col-md-5">
                <p ><small><?php


                        $number=get_comments_number();
                        if($number>1){
                            $name = $obj->labels->name;
                            printf(st_get_language('s_reviews'),$number);
                        }else{
                            printf(st_get_language('s_review'),$number);
                            $name = $obj->labels->singular_name;
                        }
                        if($name == 'Hotels'){
                            $name = $obj->labels->singular_name;
                        }

                        echo ' '.st_get_language('on_this').' '.$name.' &nbsp;&nbsp; '.st_get_language('showing')
                        ?>


                <?php
                $limit=get_option('comments_per_page');
                $page = get_query_var('cpage');
                        if ( !$page )
                            $page = 1;

                $page--;

                $to=($page+1)*$limit;

                if(get_comments_number()<$to)
                {
                    $to=get_comments_number();
                }
                        printf(st_get_language('d_to_d'),($limit*$page)+1,$to)?></small>
                </p>
            </div>
            <div class="col-md-7">

                <?php
                // Are there comments to navigate through?
                if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
                    TravelHelper::comments_paging();
                    ?>

                <?php endif; // Check for comment navigation ?>

            </div>
        </div>


        <?php if ( ! comments_open() && get_comments_number() ) : ?>
            <p class="no-comments"><?php st_the_language('review_are_closed'); ?></p>
        <?php endif; ?>
    <?php endif; // have_comments() ?>
        <div class="gap gap-small"></div>
        <?php
        if(!STReview::check_reviewed() and !STReview::user_booked() and $is_review_need_booked):?>
        <!-- Message for commenter-->
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo ('<h5>'.st_get_language('want_to_write_a_review').'</h5>
                    <p>'.st_get_language('only_verified_guests').'</p>
                    ')?>

        </div>
        <!-- End Message for commenter-->
        <?php endif;?>


            <?php
            $commenter = wp_get_current_commenter();
            $comment_form = array(
                'title_reply'          => st_get_language('write_a_review'),
                'title_reply_to'       => st_get_language('leave_a_reply_to').__( ' %s', ST_TEXTDOMAIN ),
                'comment_notes_before' => '',
                'fields'               => array(
                    'author' => '<div class="row">
							                <div class="form-group">
							                    <div class="col-md-6">' .
                        '<input id="author"  name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true"  class="form-control" placeholder="'.st_get_language('Name*').'" />
							                     </div>   ',
                    'email'  => '<div class="col-md-6">' .
                        '<input  placeholder="'.__('Your email address *',ST_TEXTDOMAIN).'"  class="form-control" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></div>
							                </div>
							                </div><!--End row-->',
                ),
                'label_submit'  => st_get_language('leave_a_review'),
                'logged_in_as'  => '',
                'comment_field' => '',
                'comment_notes_after'=>''
            );

            $comment_form['comment_field'] = '
                                                <input name="comment_type" value="st_reviews" type="hidden">
                                                <div class="form-group">
                                                    <label>'.st_get_language('your_rating').'</label>
                                                    <ul class="icon-list add_rating icon-group booking-item-rating-stars">
                                                            <li class=""><i class="fa fa-star-o"></i>
                                                            </li>
                                                            <li class=""><i class="fa fa-star-o"></i>
                                                            </li>
                                                            <li class=""><i class="fa fa-star-o"></i>
                                                            </li>
                                                            <li class=""><i class="fa fa-star-o"></i>
                                                            </li>
                                                            <li class=""><i class="fa fa-star-o"></i>
                                                            </li>
                                                    </ul>
                                                    <input name="comment_rate" class="comment_rate" type="hidden">
                                                </div>';

            $comment_form['comment_field'].='<div class="form-group">
                                            <label>'.st_get_language('review_title').'</label>
                                            <input class="form-control" type="text" name="comment_title">
                                        </div>';

            $comment_form['comment_field'].='<div class="form-group">
                                            <label>'.st_get_language('review_text').'</label>
                                            <textarea name="comment" id="comment" class="form-control" rows="6"></textarea>
                                        </div>

                                        ';

            if(is_user_logged_in()):
                $comment_form_arg=apply_filters('wp_review_form_args',$comment_form);

                if(STReview::check_reviewable()):
                    echo '<div class="box bg-gray">';
                    comment_form( $comment_form_arg );
                    echo "</div>";
                endif;
                if(STReview::check_reviewed()):
                    echo '<div class="box bg-gray">';
                    echo st_get_language('you_have_been_post_a_review').' '.$name;

                    echo '</div>';
                endif;
            else:
                echo '<div class="box bg-gray">';
                echo sprintf( st_get_language('you_must').'<a href="%s">log in </a>'.st_get_language('to_write_review'),get_permalink(st()->get_option('user_login_page')));
                echo '</div>';
            endif;
            ?>
</div><!-- #comments -->
