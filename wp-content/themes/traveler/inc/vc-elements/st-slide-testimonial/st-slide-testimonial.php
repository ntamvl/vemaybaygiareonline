<?php
    if(function_exists('vc_map')){
        vc_map(
            array(
                "name" => __("ST Slide Testimonial", ST_TEXTDOMAIN),
                "category"=>"Shinetheme",
                "base" => "st_slide_testimonial",
                "as_parent" => array('only' => 'st_testimonial_item'),
                "content_element" => true,
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                "icon" => "icon-st",
                "params" => array(
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Speed", ST_TEXTDOMAIN),
                        "param_name" => "st_speed",
                        "description" =>__("Ex : 500ms",ST_TEXTDOMAIN),
                        'value'=>'500'
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Auto Play Time", ST_TEXTDOMAIN),
                        "param_name" => "st_play",
                        "description" =>__("Set 0 to turn off autoplay",ST_TEXTDOMAIN),
                        'value'=>'4500'
                    ),
                )
            )
        );
        vc_map(
            array(
                "name" => __("Testimonial Item", ST_TEXTDOMAIN),
                "base" => "st_testimonial_item",
                "content_element" => true,
                "as_child" => array('only' => 'st_slide_testimonial'),
                "icon" => "icon-st",
                "params" => array(
                    array(
                        "type" => "attach_image",
                        "holder" => "div",
                        "heading" => __("Avatar", ST_TEXTDOMAIN),
                        "param_name" => "st_avatar",
                        "description" =>"",
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Name", ST_TEXTDOMAIN),
                        "param_name" => "st_name",
                        "description" =>"",
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Sub", ST_TEXTDOMAIN),
                        "param_name" => "st_sub",
                        "description" =>"",
                    ),
                    array(
                        "type" => "textarea",
                        "holder" => "div",
                        "heading" => __("Description", ST_TEXTDOMAIN),
                        "param_name" => "st_desc",
                        "description" =>"",
                    ),
                    array(
                        "type" => "attach_image",
                        "holder" => "div",
                        "heading" => __("Background", ST_TEXTDOMAIN),
                        "param_name" => "st_bg",
                        "description" =>"",
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "heading" => __("Position", ST_TEXTDOMAIN),
                        "param_name" => "st_pos",
                        "description" =>"",
                        'value'=>array(
                            'right'=>'7',
                            'left'=>'0'
                        )
                    ),
                )
            )
        );
    }
    if ( class_exists( 'WPBakeryShortCodesContainer' ) and !class_exists('WPBakeryShortCode_st_slide_testimonial') ) {
        class WPBakeryShortCode_st_slide_testimonial extends WPBakeryShortCodesContainer {
            protected function content($arg, $content = null) {
                $data = shortcode_atts(
                    array(
                        'st_speed' =>500,
                        'st_play' => 4500,
                    ), $arg, 'st_slide_testimonial' );
                extract($data);
                $content = do_shortcode($content);
                $r =  '<!-- TOP AREA -->
                <div class="top-area show-onload">
                    <div class="bg-holder full">
                        <div class="bg-front bg-front-mob-rel">
                            <div class="container" style="position: relative">
                                 '.st()->load_template('vc-elements/st-search/search','form',array('st_style_search' =>'style_1', 'st_box_shadow'=>'no' ,'class'=>'search-tabs-abs-bottom') ).'
                             </div>
                        </div>
                        <div class="owl-carousel owl-slider owl-carousel-area visible-lg" id="slide-testimonial" data-speed="'.$st_speed.'" data-play="'.$st_play.'">
                          '.$content.'
                        </div>
                    </div>
                </div>
                <!-- END TOP AREA  -->';
                return $r;
            }
        }
    }
    if ( class_exists( 'WPBakeryShortCode' ) and !class_exists('WPBakeryShortCode_st_testimonial_item') ) {
        class WPBakeryShortCode_st_testimonial_item extends WPBakeryShortCode {
            protected function content($arg, $content = null) {
                $data = shortcode_atts(
                    array(
                        'st_avatar' =>0,
                        'st_name' => 0,
                        'st_sub'=>'',
                        'st_desc'=>'',
                        'st_bg'=>'',
                        'st_pos'=>''
                    ), $arg, 'st_testimonial_item' );
                extract($data);
                $text = st()->load_template('vc-elements/st-slide-testimonial/loop',false,$data);
                return $text;
            }
        }
    }
