<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name" => __("ST List Location", ST_TEXTDOMAIN),
            "base" => "st_list_location",
            "content_element" => true,
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("List ID in Loaction", ST_TEXTDOMAIN),
                    "param_name" => "st_ids",
                    "description" =>__("Ids separated by commas",ST_TEXTDOMAIN),
                    'value'=>"",
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Type", ST_TEXTDOMAIN),
                    "param_name" => "st_type",
                    "description" =>"",
                    'value'=>array(
                        __('Hotel',ST_TEXTDOMAIN)=>'st_hotel',
                        __('Car',ST_TEXTDOMAIN)=>'st_cars',
                        __('Tour',ST_TEXTDOMAIN)=>'st_tours',
                        __('Rental',ST_TEXTDOMAIN)=>'st_rental',
                        __('Activities',ST_TEXTDOMAIN)=>'st_activity',
//                __('Cruise',ST_TEXTDOMAIN)=>'cruise',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Show Only Featured Location", ST_TEXTDOMAIN),
                    "param_name" => "is_featured",
                    "description" =>__("Show Only Featured Location",ST_TEXTDOMAIN),
                    'value'=>array(
                        __("No",ST_TEXTDOMAIN)=>'no',
                        __("Yes",ST_TEXTDOMAIN)=>'yes',
                    ),
                    'edit_field_class'=>'vc_col-sm-6',
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Number Location", ST_TEXTDOMAIN),
                    "param_name" => "st_number",
                    "description" =>"",
                    'value'=>4,
                    'edit_field_class'=>'vc_col-sm-6',
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Items per row", ST_TEXTDOMAIN),
                    "param_name" => "st_col",
                    "description" =>"",
                    "value" => array(
                        __('Four',ST_TEXTDOMAIN)=>'4',
                        __('Three',ST_TEXTDOMAIN)=>'3',
                        __('Two',ST_TEXTDOMAIN)=>'2',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style location",ST_TEXTDOMAIN),
                    "param_name" => "st_style",
                    "value" => array(
                        __('Normal',ST_TEXTDOMAIN)=>'normal',
                        __('Curved',ST_TEXTDOMAIN)=>'curved',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Show Logo",ST_TEXTDOMAIN),
                    "param_name" => "st_show_logo",
                    'edit_field_class'=>'vc_col-sm-6',
                    "value" => array(
                        __('Yes',ST_TEXTDOMAIN)=>'yes',
                        __('No',ST_TEXTDOMAIN)=>'no',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Logo Position",ST_TEXTDOMAIN),
                    "param_name" => "st_logo_position",
                    'edit_field_class'=>'vc_col-sm-6',
                    "value" => array(
                        __('Left',ST_TEXTDOMAIN)=>'left',
                        __('Right',ST_TEXTDOMAIN)=>'right',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Order By", ST_TEXTDOMAIN),
                    "param_name" => "st_orderby",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-6',
                    'value'=>function_exists('st_get_list_order_by')? st_get_list_order_by(
                        array(
                            __('Sale',ST_TEXTDOMAIN) => 'sale' ,
                            __('Rate',ST_TEXTDOMAIN) => 'rate',
                            __('Min Price',ST_TEXTDOMAIN) => 'price',
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
            )
        ) );
    }

    if(!function_exists('st_vc_list_location')){
        function st_vc_list_location($attr,$content=false)
        {
            $data = shortcode_atts(
                array(
                    'st_ids' =>"",
                    'st_type'=>'st_hotel',
                    'is_featured' =>'no',
                    'st_number' =>0,
                    'st_col'=>4,
                    'st_style'=>'',
                    'st_show_logo'=>'',
                    'st_logo_position'=>'',
                    'st_orderby'=>'',
                    'st_order'=>'',
                ), $attr, 'st_list_location' );
            extract($data);
            $query=array(
                'post_type' => 'location',
                'posts_per_page'=>$st_number,
                'order'=>$st_order,
                'orderby'=>$st_orderby
            );
            if(!empty($st_ids)){
                $query['post__in'] = explode(',',$st_ids);
            }
            if($st_orderby == 'price'){
                $query['meta_key']='min_price_'.$st_type.'';
                $query['orderby']='meta_value';
            }
            if($st_orderby == 'sale'){
                $query['meta_key']='total_sale_number';
                $query['orderby']='meta_value';
            }
            if($st_orderby == 'rate'){
                $query['meta_key']='review_'.$st_type.'';
                $query['orderby']='meta_value';
            }
            if($is_featured == 'yes'){
                $query['orderby']='meta_value_num';
                $query['meta_query']=array(
                    array(
                        'key'     => 'is_featured',
                        'value'   => 'on',
                        'compare' => '=',
                    ),
                );
            }
            query_posts($query);
            $r =  st()->load_template('vc-elements/st-list-location/loop',$st_style,$data); ;
            wp_reset_query();
            return $r;
        }
    }
    st_reg_shortcode('st_list_location','st_vc_list_location');