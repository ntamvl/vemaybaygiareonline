<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name" => __("ST List Rental", ST_TEXTDOMAIN),
            "base" => "st_list_rental",
            "content_element" => true,
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("List ID in Rental", ST_TEXTDOMAIN),
                    "param_name" => "st_ids",
                    "description" =>__("Ids separated by commas",ST_TEXTDOMAIN),
                    'value'=>"",
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Number", ST_TEXTDOMAIN),
                    "param_name" => "number",
                    "description" =>"",
                    'value'=>4,
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Order By", ST_TEXTDOMAIN),
                    "param_name" => "st_orderby",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-6',
                    'value'=>function_exists('st_get_list_order_by')?st_get_list_order_by(
                        array(
                            __('Sale',ST_TEXTDOMAIN) => 'sale' ,
                            __('Featured',ST_TEXTDOMAIN) => 'featured' ,
                        )
                    ):array(),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Order",ST_TEXTDOMAIN),
                    "param_name" => "st_order",
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
                    "heading" => __("Number of row", ST_TEXTDOMAIN),
                    "param_name" => "number_of_row",
                    'edit_field_class'=>'vc_col-sm-12',
                    "description" =>__('',ST_TEXTDOMAIN),
                    "value" => array(
                        __('Four',ST_TEXTDOMAIN)=>'4',
                        __('Three',ST_TEXTDOMAIN)=>'3',
                        __('Two',ST_TEXTDOMAIN)=>'2',
                    ),
                ),
            )
        ) );
    }

    if(!function_exists('st_vc_list_rental')){
        function st_vc_list_rental($attr,$content=false)
        {
            $data = shortcode_atts(
                array(
                    'st_ids'=>'',
                    'taxonomy'=>'',
                    'number' =>0,
                    'st_order'=>'',
                    'st_orderby'=>'',
                    'number_of_row'=>4,
                ), $attr, 'st_list_rental' );
            extract($data);


            $query=array(
                'post_type' => 'st_rental',
                'posts_per_page'=>$number,
                'order'=>$st_order,
                'orderby'=>$st_orderby
            );
            if(!empty($st_ids)){
                $query['post__in'] = explode(',',$st_ids);
            }
            if($st_orderby == 'sale'){
                $query['meta_key']='price';
                $query['orderby']='meta_value';
            }
            if($st_orderby == 'featured'){
                $query['meta_key']='cars_set_as_featured';
                $query['orderby']='meta_value';
            }

            query_posts($query);
            $txt = '';
            while(have_posts()){
                the_post();
                $txt .= st()->load_template('vc-elements/st-list-rental/loop','list',array('attr'=>$attr,'data'=>$data));;
            }
            wp_reset_query();
            return '<div class="row row-wrap">'.$txt.'</div>';
        }
    }
    st_reg_shortcode('st_list_rental','st_vc_list_rental');