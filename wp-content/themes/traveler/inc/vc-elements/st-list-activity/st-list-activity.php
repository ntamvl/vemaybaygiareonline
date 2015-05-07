<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name" => __("ST List Activity", ST_TEXTDOMAIN),
            "base" => "st_list_activity",
            "content_element" => true,
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("List ID in Activity", ST_TEXTDOMAIN),
                    "param_name" => "st_ids",
                    "description" =>__("Ids separated by commas",ST_TEXTDOMAIN),
                    'value'=>"",
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Number", ST_TEXTDOMAIN),
                    "param_name" => "st_number",
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
                            __('Price',ST_TEXTDOMAIN) => 'sale' ,
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
                    "heading" => __("Number of row", ST_TEXTDOMAIN),
                    "param_name" => "st_of_row",
                    'edit_field_class'=>'vc_col-sm-12',
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

    if(!function_exists('st_vc_list_activity')){
        function st_vc_list_activity($attr,$content=false)
        {
            $data = shortcode_atts(
                array(
                    'st_ids' =>"",
                    'st_number' =>0,
                    'st_order'=>'',
                    'st_orderby'=>'',
                    'st_of_row'=>'',
                    'only_featured_location'=>'',
                ), $attr, 'st_list_activity' );
            extract($data);

            $page=STInput::request('paged');
            if(!$page)
            {
                $page=get_query_var('paged');
            }
            $query=array(
                'post_type' => 'st_activity',
                'posts_per_page'=>$st_number,
                'paged'=> $page ,
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
            if($st_orderby == 'rate'){
                $query['meta_key']='rate_review';
                $query['orderby']='meta_value';
            }
            if($st_orderby == 'discount'){
                $query['meta_key']='discount';
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

            query_posts($query);

            $r="<div class='list_tours'>".st()->load_template('vc-elements/st-list-activity/loop','',$data)."</div>";

            wp_reset_query();

            return $r;
        }
    }
    st_reg_shortcode('st_list_activity','st_vc_list_activity');