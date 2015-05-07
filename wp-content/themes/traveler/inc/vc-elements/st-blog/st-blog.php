<?php
    if(function_exists('vc_map')) {
        vc_map( array(
            "name" => __("ST Blog", ST_TEXTDOMAIN),
            "base" => "st_blog",
            "content_element" => true,
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style",ST_TEXTDOMAIN),
                    "param_name" => "st_style",
                    "value" => array(
                        __("Style one",ST_TEXTDOMAIN)=>"style1",
                        __("Style two",ST_TEXTDOMAIN)=>"style2",
                    )
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Number post",ST_TEXTDOMAIN),
                    "param_name" => "st_blog_number_post",
                    "value" => '4',
                    "description" => __("Post number",ST_TEXTDOMAIN)
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Number post of row",ST_TEXTDOMAIN),
                    "param_name" => "st_blog_style",
                    "value" => '',
                    "description" => __("Number colums show in a row ",ST_TEXTDOMAIN),
                    "value" => array(
                        __('Four',ST_TEXTDOMAIN)=>'4',
                        __('Three',ST_TEXTDOMAIN)=>'3',
                        __('Two',ST_TEXTDOMAIN)=>'2',
                    ),
                ),
                array(
                    "type" => "checkbox",
                    "holder" => "div",
                    "heading" => __("Category",ST_TEXTDOMAIN),
                    "param_name" => "st_category",
                    "value" => st_get_list_taxonomy_id('category')
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Order",ST_TEXTDOMAIN),
                    "param_name" => "st_blog_order",
                    'value'=>array(
                        __('Asc',ST_TEXTDOMAIN)=>'asc',
                        __('Desc',ST_TEXTDOMAIN)=>'desc'
                    ),
                    'edit_field_class'=>'vc_col-sm-6',
                    "description" => __("",ST_TEXTDOMAIN)
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Order By",ST_TEXTDOMAIN),
                    "param_name" => "st_blog_orderby",
                    "value" =>st_get_list_order_by(),
                    'edit_field_class'=>'vc_col-sm-6',
                    "description" => __("",ST_TEXTDOMAIN)
                ),
            )
        ) );
    }
    if(!function_exists('st_vc_blog')){
        function st_vc_blog($attr,$content=false)
        {
            $data = shortcode_atts(
                array(
                    'st_blog_number_post' =>5,
                    'st_blog_orderby' => 0,
                    'st_blog_order'=>'',
                    'st_blog_style'=>'',
                    'st_category'=>'',
                    'st_style'=>'style1'

                ), $attr, 'st_blog' );
            extract($data);
            $query=array(
                'post_type' => 'post',
                'orderby'=>$st_blog_orderby,
                'order'=>$st_blog_order,
                'posts_per_page'=>$st_blog_number_post,
            );
            if($st_category != '0' && $st_category != '')
            {
                $query['tax_query'][]=array(
                    'taxonomy'=>'category',
                    'terms'=>explode(',',$st_category)
                );
            }
            query_posts($query);
            $txt='';
            while(have_posts()){
                the_post();
                if($st_style == 'style1'){
                    $txt .= st()->load_template('vc-elements/st-blog/loop',false,$data);
                }
                if($st_style == 'style2'){
                    $txt .= st()->load_template('vc-elements/st-blog/loop2',false,$data);
                }
            }
            wp_reset_query();
            $r =  '<div class="row row-wrap">
                 '.$txt.'
               </div>';
            return $r;
        }
    }
    st_reg_shortcode('st_blog','st_vc_blog');
