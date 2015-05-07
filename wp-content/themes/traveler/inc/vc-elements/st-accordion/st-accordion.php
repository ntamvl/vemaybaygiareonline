<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name" => __("ST Accordion", ST_TEXTDOMAIN),
            "base" => "st_accordion",
            "as_parent" => array('only' => 'st_accordion_item'),
            "content_element" => true,
            "show_settings_on_create" => false,
            "js_view" => 'VcColumnView',
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params" => array(

            )
        ) );
        vc_map( array(
            "name" => __("ST Accordion item", ST_TEXTDOMAIN),
            "base" => "st_accordion_item",
            "content_element" => true,
            "as_child" => array('only' => 'st_accordion'),
            "icon" => "icon-st",
            "params" => array(
                // add params same as with any other content element
                array(
                    "type" => "textfield",
                    "heading" => __("Title", ST_TEXTDOMAIN),
                    "param_name" => "st_title",
                    "description" =>"",
                ),
                array(
                    "type" => "textarea_html",
                    "heading" => __("Content", ST_TEXTDOMAIN),
                    "param_name" => "content",
                    "description" =>"",
                ),
            )
        ) );
    }
    if ( class_exists( 'WPBakeryShortCodesContainer' ) and !class_exists('WPBakeryShortCode_st_accordion')) {
        class WPBakeryShortCode_st_accordion extends WPBakeryShortCodesContainer {
            protected function content($arg, $content = null) {
                global $i_tab;$i_tab=0;
                $content_data= st_remove_wpautop($content);
                $r = '<div id="accordion" class="panel-group">'.$content_data.'</div>';
                unset($st_title_tb);
                unset($id_rand);
                return $r;
            }
        }
    }
    if ( class_exists( 'WPBakeryShortCode' ) and !class_exists('WPBakeryShortCode_st_accordion_item')) {
        class WPBakeryShortCode_st_accordion_item extends WPBakeryShortCode {
            protected function content($arg, $content = null) {
                global $i_tab;
                $data = shortcode_atts(array(
                    'st_title' =>"",
                ), $arg,'st_tab_item');
                extract($data);
                if($i_tab == '0'){
                    $class_active = "in";
                }else{
                    $class_active="";
                }
                $id = rand();
                $text = '<div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                   <a href="#collapse-'.$id.'" data-parent="#accordion" data-toggle="collapse" class="">'.$st_title.'</a>
                                </h4>
                            </div>
                            <div id="collapse-'.$id.'" class="panel-collapse collapse '.$class_active.'" >
                                <div class="panel-body">'.$content.'</div>
                            </div>
                     </div>';
                $i_tab++;
                return $text;
            }
        }
    }