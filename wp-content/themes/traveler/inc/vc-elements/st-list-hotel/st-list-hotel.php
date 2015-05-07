<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name" => __("ST List Hotel", ST_TEXTDOMAIN),
            "base" => "st_list_hotel",
            "content_element" => true,
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("List ID in Hotel", ST_TEXTDOMAIN),
                    "param_name" => "st_ids",
                    "description" =>__("Ids separated by commas",ST_TEXTDOMAIN),
                    'value'=>"",
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Number hotel", ST_TEXTDOMAIN),
                    "param_name" => "st_number_ht",
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
                            __('Rate',ST_TEXTDOMAIN) => 'rate',
                            __('Discount',ST_TEXTDOMAIN)=>'discount'
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
                    "heading" => __("Style hotel", ST_TEXTDOMAIN),
                    "param_name" => "st_style_ht",
                    "description" =>"",
                    'value'=>array(
                        __('BG Last Minute Deal',ST_TEXTDOMAIN)=>'bg_last_minute_deal',
                        __('Last Minute Deals',ST_TEXTDOMAIN)=>'last_minute_deals',
                        __('Hot Deals',ST_TEXTDOMAIN)=>'hot-deals',
                        __('Grid',ST_TEXTDOMAIN)=>'grid',
                        __('Grid Style 2',ST_TEXTDOMAIN)=>'grid2',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Number Hotel of row", ST_TEXTDOMAIN),
                    "param_name" => "st_ht_of_row",
                    'edit_field_class'=>'vc_col-sm-12',
                    "description" =>__('Noticed: the field "Number Hotel of row" only applicable to "Last Minute Deal" style',ST_TEXTDOMAIN),
                    "value" => array(
                        __('Four',ST_TEXTDOMAIN)=>'4',
                        __('Three',ST_TEXTDOMAIN)=>'3',
                        __('Two',ST_TEXTDOMAIN)=>'2',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Only in Featured Location", ST_TEXTDOMAIN),
                    "param_name" => "only_featured_location",
                    'edit_field_class'=>'vc_col-sm-12',
                    "value" => array(
                        __('No',ST_TEXTDOMAIN)=>'no',
                        __('Yes',ST_TEXTDOMAIN)=>'yes',
                    ),
                ),
            )
        ) );
    }

    if(!function_exists('st_vc_list_hotel')){
        function st_vc_list_hotel($attr,$content=false)
        {
            $data = shortcode_atts(
                array(
                    'st_ids' =>"",
                    'st_number_ht' =>0,
                    'st_order'=>'',
                    'st_orderby'=>'',
                    'st_ht_of_row'=>'',
                    'st_style_ht'=>'',
                    'only_featured_location'=>'no'
                ), $attr, 'st_list_hotel' );
            extract($data);


            $query=array(
                'post_type' => 'st_hotel',
                'posts_per_page'=>$st_number_ht,
                'order'=>$st_order,
                'orderby'=>$st_orderby
            );
            if(!empty($st_ids)){
                $query['post__in'] = explode(',',$st_ids);
            }
            if($st_style_ht == 'bg_last_minute_deal'){
                $query=array(
                    'post_type' => 'hotel_room',
                    'posts_per_page'=>1,
                    'meta_key'=>'sale_price_from',
                    'order'=>'desc',
                    'orderby'=>'meta_value',
                    'meta_query'=>array(
                        'key'=>'is_sale_schedule',
                        'value'=>'on',
                        'compare'=>"="
                    )
                );
                $post = query_posts($query);
                $data['info_room'] = $post;
                wp_reset_query();
                if(!empty($post)){
                    $id_hotel = get_post_meta($post[0]->ID ,"room_parent" ,true);
                    $query=array(
                        'post_type' => 'st_hotel',
                        'posts_per_page'=>1,
                        'post__in'=>array($id_hotel),
                    );
                }else{
                    /*$query=array(
                        'post_type' => 'hotel_room',
                        'posts_per_page'=>1,
                        'meta_key'=>'discount_rate',
                        'order'=>'ASC',
                        'orderby'=>'meta_value',
                    );
                    $post = query_posts($query);
                    $data['info_room'] = $post;
                    wp_reset_query();
                    if(!empty($post)) {
                        $id_hotel = get_post_meta($post[0]->ID, "room_parent", true);
                        $query = array(
                            'post_type' => 'st_hotel',
                            'posts_per_page' => 1,
                            'post__in' => array($id_hotel),
                        );
                    }*/
                }

            }
            if($st_orderby == 'sale'){
                $query['meta_key']='total_sale_number';
                $query['orderby']='meta_value';
            }
            if($st_orderby == 'rate'){
                $query['meta_key']='rate_review';
                $query['orderby']='meta_value';
            }
            if($st_orderby=='discount')
            {
                $query['meta_key']='discount_rate';
                $query['orderby']='meta_value';
            }

            if($only_featured_location=='yes'){

                $STLocation=new STLocation();
                $featured=$STLocation->get_featured_ids();

                $query['meta_query'][]=array(
                    'key'=>'id_location',
                    'value'=>$featured,
                    'compare'=>"IN"
                );
            }

            $query=new WP_Query($query);
            $data['query']=$query;

            $r=st()->load_template('vc-elements/st-list-hotel/loop',$st_style_ht,$data);

            wp_reset_query();

            return $r;
        }
    }
    st_reg_shortcode('st_list_hotel','st_vc_list_hotel');