<?php
    if(function_exists('vc_map')){
        $list_taxonomy = st_list_taxonomy('st_cars');
        $list_taxonomy = array_merge(array("---Select---"=>""),$list_taxonomy);
        $param = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("List ID in Car", ST_TEXTDOMAIN),
                "param_name" => "st_ids",
                "description" =>__("Ids separated by commas",ST_TEXTDOMAIN),
                'value'=>"",
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Select Taxonomy", ST_TEXTDOMAIN),
                "param_name" => "taxonomy",
                "description" =>"",
                "value" => st_list_taxonomy('st_cars'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Number cars", ST_TEXTDOMAIN),
                "param_name" => "st_number_cars",
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
                "heading" => __("Number Car of row", ST_TEXTDOMAIN),
                "param_name" => "st_cars_of_row",
                'edit_field_class'=>'vc_col-sm-12',
                "description" =>__('',ST_TEXTDOMAIN),
                "value" => array(
                    __('Four',ST_TEXTDOMAIN)=>'4',
                    __('Three',ST_TEXTDOMAIN)=>'3',
                    __('Two',ST_TEXTDOMAIN)=>'2',
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Sort By Taxonomy", ST_TEXTDOMAIN),
                "param_name" => "sort_taxonomy",
                "description" =>"",
                "value" => $list_taxonomy,
            ),
        );

        $data_vc=STCars::get_taxonomy_and_id_term_car();
        $param = array_merge($param ,$data_vc['list_vc']);
        vc_map( array(
            "name" => __("ST List Cars", ST_TEXTDOMAIN),
            "base" => "st_list_cars",
            "content_element" => true,
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params" => $param
        ) );
    }
    if(!function_exists('st_vc_list_cars')){
        function st_vc_list_cars($attr,$content=false)
        {
            $data_vc=STCars::get_taxonomy_and_id_term_car();
            $param = array(
                'st_ids'=>'',
                'taxonomy'=>'',
                'st_number_cars' =>0,
                'st_order'=>'',
                'st_orderby'=>'',
                'st_cars_of_row'=>'',
                'sort_taxonomy'=>''
            );
            $param = array_merge($param , $data_vc['list_id_vc']);
            $data = shortcode_atts(
                $param, $attr, 'st_list_cars' );
            extract($data);
            $query=array(
                'post_type' => 'st_cars',
                'posts_per_page'=>$st_number_cars,
                'order'=>$st_order,
                'orderby'=>$st_orderby
            );
            if(!empty($st_ids)){
                $query['post__in'] = explode(',',$st_ids);
            }
            if($st_orderby == 'sale'){
                $query['meta_key']='cars_price';
                $query['orderby']='meta_value';
            }
            if($st_orderby == 'featured'){
                $query['meta_key']='cars_set_as_featured';
                $query['orderby']='meta_value';
            }
            if(!empty($sort_taxonomy)){
                if(isset($attr["id_term_".$sort_taxonomy]))
                {
                    $id_term = $attr["id_term_".$sort_taxonomy];
                    $query['tax_query']=array(
                        array(
                            'taxonomy'=>$sort_taxonomy,
                            'field'   => 'id',
                            'terms'   =>explode(',',$id_term)
                        ),
                    );
                }

            }

            query_posts($query);
            $txt = '';
            while(have_posts()){
                the_post();
                $txt .= st()->load_template('vc-elements/st-list-cars/loop','list',array('attr'=>$attr,'data'=>$data));;
            }
            wp_reset_query();
            return '<div class="row row-wrap">'.$txt.'</div>';
        }
    }
    st_reg_shortcode('st_list_cars','st_vc_list_cars');