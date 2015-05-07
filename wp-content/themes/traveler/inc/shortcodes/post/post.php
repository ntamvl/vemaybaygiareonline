<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 12/15/14
 * Time: 11:23 AM
 */

if(!function_exists('st_post_data'))
{
    function st_post_data($attr=array())
    {
        $default=array(
            'field'=>'title',
            'post_id'=>false
        );


        extract(wp_parse_args($attr,$default));

        if(!$post_id and is_single())
        {
            $post_id=get_the_ID();
        }

        if($post_id and is_single()){
            switch($field)
             {
                    case "content":
                        $post=get_post($post_id);
                        $content=$post->post_content;
                        $content = apply_filters('the_content', $content);
                        $content = str_replace(']]>', ']]&gt;', $content);
                    return $content;
                    break;

                case "excerpt":
                    $post=get_post($post_id);
                    if(isset($post->post_excerpt))
                    {
                        return $post->post_excerpt;
                    }
                break;

                case "title":
                    return get_the_title($post_id);
                    break;

            }
        }

    }
}

st_reg_shortcode('st_post_data','st_post_data');