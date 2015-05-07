<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name" => __("ST Slide Location", ST_TEXTDOMAIN),
            "base" => "st_slide_location",
            "content_element" => true,
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params" => array(
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
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Number Location", ST_TEXTDOMAIN),
                    "param_name" => "st_number",
                    "description" =>"",
                    'value'=>4,
                    'dependency' => array(
                        'element' => 'is_featured',
                        'value' => array( 'yes' )
                    ),
                ),
                array(
                    "type" => "st_post_type_location",
                    "holder" => "div",
                    "heading" => __("Select Location ", ST_TEXTDOMAIN),
                    "param_name" => "st_list_location",
                    "description" =>"",
                    'dependency' => array(
                        'element' => 'is_featured',
                        'value' => array( 'no' )
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style show ", ST_TEXTDOMAIN),
                    "param_name" => "st_style",
                    "description" =>"",
                    'value'=>array(
                        __('Text info center',ST_TEXTDOMAIN)=>'style_1',
                        __('Show box find',ST_TEXTDOMAIN)=>'style_2',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Weather show ", ST_TEXTDOMAIN),
                    "param_name" => "st_weather",
                    "description" =>"",
                    'value'=>array(
                        __('Yes',ST_TEXTDOMAIN)=>'yes',
                        __('No',ST_TEXTDOMAIN)=>'no',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Height", ST_TEXTDOMAIN),
                    "param_name" => "st_height",
                    "description" =>"",
                    'value'=>array(
                        __('Full height',ST_TEXTDOMAIN)=>'full',
                        __('Half height',ST_TEXTDOMAIN)=>'half',
                    ),
                ),
            )
        ) );
    }

    if(!function_exists('st_vc_slide_location')){
        function st_vc_slide_location($attr,$content=false)
        {
            $data = shortcode_atts(
                array(
                    'st_type'=>'',
                    'is_featured' =>'no',
                    'st_number' =>4,
                    'st_list_location' =>0,
                    'st_weather'=>'no',
                    'st_style'=>'style_1',
                    'st_height'=>'full'
                ), $attr, 'st_slide_location' );
            extract($data);
            $query=array(
                'post_type' => 'location',

            );
            if($is_featured == 'yes'){
                $query['posts_per_page']= $st_number;
                $query['orderby']='meta_value_num';
                $query['meta_query']=array(
                    array(
                        'key'     => 'is_featured',
                        'value'   => 'on',
                        'compare' => '=',
                    ),
                );
            }else{
                $ids = explode(',',$st_list_location);
                $query['post__in']= $ids ;
            }
            query_posts($query);
            $txt='';
            while(have_posts()){
                the_post();
                if($st_style == 'style_1'){
                    $txt .= st()->load_template('vc-elements/st-slide-location/loop-style','1',$data);
                }
                if($st_style == 'style_2'){
                    $txt .= st()->load_template('vc-elements/st-slide-location/loop-style','2',$data);
                }

            }
            wp_reset_query();
            if($st_height == 'full'){
                $class = 'top-area show-onload';
            }else{
                $class = 'special-area';
            }


            if($st_style == 'style_1') {
                $r = '<div class="'.$class.'">
                    <div class="owl-carousel owl-slider owl-carousel-area" id="owl-carousel-slider">
                    ' . $txt . '
                    </div>
                  </div>';
            }
            if($st_style == 'style_2') {
                $r = '<div class="'.$class.'">
                <div class="bg-holder full">
                    <div class="bg-front bg-front-mob-rel">
                        <div class="container">
                        '.st()->load_template('vc-elements/st-search/search','form',array('st_style_search' =>'style_2', 'st_box_shadow'=>'no' ,'class'=>'search-tabs-abs mt50','title'=>STLanguage::st_get_language('find_your_perfect_trip')) ).'
                        </div>
                    </div>
                    <div class="owl-carousel owl-slider owl-carousel-area visible-lg" id="owl-carousel-slider">
                      '.$txt.'
                    </div>
                </div>
            </div>';
            }
            if(empty($txt)){
                $r="";
            }
            return $r;
        }
    }
    st_reg_shortcode('st_slide_location','st_vc_slide_location');