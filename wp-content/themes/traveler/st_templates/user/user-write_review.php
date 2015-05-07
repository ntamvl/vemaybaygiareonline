<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User write review
 *
 * Created by ShineTheme
 *
 */
$item_id=STInput::get('item_id');
$comment_post_id=apply_filters('st_real_comment_post_id',$item_id);
$title=get_the_title($item_id);


?>
<div class="st-create">
    <h3><?php printf(st_get_language('user_write_review_for'),$title) ?></h3>
</div>
<?php if ( ! comments_open($comment_post_id) && get_comments_number($comment_post_id) ) : ?>
    <div class="alert alert-danger"><?php st_the_language('review_are_closed'); ?></div>
<?php else: ?>

    <form action="" method="post" enctype="multipart/form-data"  id="comments" class="comment-form">
        <input name="item_id" value="<?php echo STInput::get('item_id')?>" type="hidden">
        <?php wp_nonce_field('st_user_settings','st_user_write_review')?>
        <?php
        $comment_form = array(
            'title_reply'          => st_get_language('write_a_review'),
            'title_reply_to'       => st_get_language('leave_a_reply_to_s'),
            'comment_notes_before' => '',
            'fields'               => array(
                'author' => '<div class="row">
							                <div class="form-group">
							                    <div class="col-md-6">' .
                    '<input id="author"  name="author" type="text" value="" size="30" aria-required="true"  class="form-control" placeholder="'.st_get_language('name').'" />
							                     </div>   ',
                'email'  => '<div class="col-md-6">' .
                    '<input  placeholder="'.st_get_language('your_email_address').'"  class="form-control" id="email" name="email" type="text" value="" size="30" aria-required="true" /></div>
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
            $comment_form_arg=apply_filters('wp_review_form_args',$comment_form,$comment_post_id);
            if(STReview::check_reviewable($comment_post_id)):
                comment_form( $comment_form_arg,$comment_post_id );
            else:
                echo "<div class='alert alert-danger'>";
                st_the_language('reviewing_are_not_available');
                echo "</div>";
            endif;
        else:
            echo sprintf( st_get_language('you_must').'<a href="%s">log in </a>'.st_get_language('to_write_review'),get_permalink(st()->get_option('user_login_page')));
        endif;
        ?>
    </form>
<?php endif;?>