<?php
// ##########  Do not delete these lines
if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])){
    die ('Please do not load this page directly. Thanks!'); }
if ( post_password_required() ) { ?>
    <p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'kubrick'); ?></p>
<?php
    return; }
// ##########  End do not delete section

// Display Comments Section
if ( have_comments() ) : ?>
    <h3 id="comments"><?php comments_number('No Responses', 'One Response', '% Responses');?> </h3>
        <div class="navigation">
            <div class="alignleft"><?php previous_comments_link() ?></div>
            <div class="alignright"><?php next_comments_link() ?></div>
        </div>
    <ol class="commentlist">
     <?php
     wp_list_comments(array(
      // see http://codex.wordpress.org/Function_Reference/wp_list_comments
      // 'login_text'        => 'Login to reply',
      // 'callback'          => null,
      // 'end-callback'      => null,
      // 'type'              => 'all',
       'avatar_size'       => 64,
      // 'reverse_top_level' => null,
      // 'reverse_children'  =>
      ));
      ?>
    </ol>
        <div class="navigation">
            <div class="alignleft"><?php previous_comments_link() ?></div>
            <div class="alignright"><?php next_comments_link() ?></div>
        </div>
    <?php
    if ( ! comments_open() ) : // There are comments but comments are now closed
        echo"<p class='nocomments'>Comments are closed.</p>";
    endif;

else : // I.E. There are no Comments
    if ( comments_open() ) : // Comments are open, but there are none yet
        // echo"<p>Be the first to write a comment.</p>";
    else : // comments are closed
        echo"<p class='nocomments'>Comments are closed.</p>";
    endif;
endif;

$fields =  array(

  'author' =>
    '<p class="comment-form-author"><label for="author">' . __( 'Họ tên', 'domainreference' ) . '</label> ' .
    ( $req ? '<span class="required">*</span>' : '' ) .
    '<input id="author" name="author" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) .
    '" size="30"' . $aria_req . ' /></p>',

  'email' =>
    '<p class="comment-form-email"><label for="email">' . __( 'Email', 'domainreference' ) . '</label> ' .
    ( $req ? '<span class="required">*</span>' : '' ) .
    '<input id="email" name="email" type="text" class="form-control" value="' . esc_attr(  $commenter['comment_author_email'] ) .
    '" size="30"' . $aria_req . ' /></p>',

  // 'url' =>
  //   '<p class="comment-form-url"><label for="url">' . __( 'Website', 'domainreference' ) . '</label>' .
  //   '<input id="url" name="url" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
  //   '" size="30" /></p>',
);

// Display Form/Login info Section
// the comment_form() function handles this and can be used without any paramaters simply as "comment_form()"
comment_form(array(
  // see codex http://codex.wordpress.org/Function_Reference/comment_form for default values
  // tutorial here http://blogaliving.com/wordpress-adding-comment_form-theme/
  'comment_field' => '<p><label for="comment">' . __( 'Nội dung', 'domainreference' ) . '</label> <textarea name="comment" id="comment" class="form-control" cols="58" rows="10" tabindex="4" aria-required="true"></textarea></p>',
  'label_submit' => 'Gửi ',
  'comment_notes_after' => '',
  'fields' => apply_filters( 'comment_form_default_fields', $fields ),
  ));

// RSS comments link
echo '<div class="comments_rss">';
post_comments_feed_link('RSS Feed');
echo '</div>';

?>