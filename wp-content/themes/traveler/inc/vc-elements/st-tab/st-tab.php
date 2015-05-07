<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name" => __("ST Tab", ST_TEXTDOMAIN),
            "base" => "st_tab",
            "as_parent" => array('only' => 'st_tab_item'),
            "content_element" => true,
            "show_settings_on_create" => false,
            "js_view" => 'VcColumnView',
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params" => array(

            )
        ) );
        vc_map( array(
            "name" => __("ST Tab item", ST_TEXTDOMAIN),
            "base" => "st_tab_item",
            "content_element" => true,
            "as_child" => array('only' => 'st_tab'),
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

    if ( class_exists( 'WPBakeryShortCodesContainer' ) and !class_exists('WPBakeryShortCode_st_tab')) {
        class WPBakeryShortCode_st_tab extends WPBakeryShortCodesContainer {
            protected function content($arg, $content = null) {
                global $st_title_tb;$st_title_tb="";
                global $i_tab;$i_tab=0;
                global $id_rand ; $id_rand = rand();
                $content_data= st_remove_wpautop($content);
                $id = rand();
                $r = '<div class="tabbable st_tab_'.esc_attr($id_rand).'" style="">

                            <ul id="myTab'.$id.'" class="nav nav-tabs myTab">
                              '.$st_title_tb.'
                            </ul>
                            <div id="myTabContent'.$id.'" class="tab-content">
                              '.$content_data.'
                            </div>

                    </div>';
                unset($st_title_tb);
                unset($id_rand);
                return $r;
            }
        }
    }
    if ( class_exists( 'WPBakeryShortCode' ) and !class_exists('WPBakeryShortCode_st_tab_item') ) {
        class WPBakeryShortCode_st_tab_item extends WPBakeryShortCode {
            protected function content($arg, $content = null) {
                global $st_title_tb;
                global $i_tab;
                global $id_rand;
                $data = shortcode_atts(array(
                    'st_title' =>"",
                ), $arg,'st_tab_item');
                extract($data);
                if($i_tab == '0'){
                    $class_active = "active";
                }else{
                    $class_active="";
                }
                $st_title_tb .= '<li class="'.esc_attr($class_active).'">
                               <a href="#tab-'.esc_attr($id_rand).'-'.esc_attr($i_tab).'" data-toggle="tab">'.$st_title.'</a>
                             </li>';
                $text = '<div class="tab-pane fade '.esc_attr($class_active).' in " id="tab-'.esc_attr($id_rand).'-'.esc_attr($i_tab).'">
                     '.$content.'
                     </div>';
                $i_tab++;
                return $text;
            }
        }
    }