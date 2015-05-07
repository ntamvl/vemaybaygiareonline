<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name" => __("ST Icon", ST_TEXTDOMAIN),
            "base" => "st_icon",
            "content_element" => true,
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Tooltip", ST_TEXTDOMAIN),
                    "param_name" => "st_tooltip",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-6'
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Position Tooltip", ST_TEXTDOMAIN),
                    "param_name" => "st_pos_tooltip",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-6',
                    'value'=>array(
                        __('No',ST_TEXTDOMAIN)=>'none',
                        __('Top',ST_TEXTDOMAIN)=>'top',
                        __('Bottom',ST_TEXTDOMAIN)=>'bottom',
                        __('Left',ST_TEXTDOMAIN)=>'left',
                        __('Right',ST_TEXTDOMAIN)=>'right'
                    )
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Icon", ST_TEXTDOMAIN),
                    "param_name" => "st_icon",
                    "description" =>"",
                    'edit_field_class'=>'st_iconpicker vc_col-sm-12'
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "heading" => __("Color Icon", ST_TEXTDOMAIN),
                    "param_name" => "st_color_icon",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-3'
                ),
                array(
                    "type" => "colorpicker",
                    "holder" => "div",
                    "heading" => __("To Color Icon", ST_TEXTDOMAIN),
                    "param_name" => "st_to_color",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-3',
                    'value'=>''
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Aligment", ST_TEXTDOMAIN),
                    "param_name" => "st_aligment",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-3',
                    'value'=>array(
                        __('No',ST_TEXTDOMAIN)=>'box-icon-none',
                        __('Left',ST_TEXTDOMAIN)=>'box-icon-left',
                        __('Right',ST_TEXTDOMAIN)=>'box-icon-right',
                        __('Center',ST_TEXTDOMAIN)=>'box-icon-center'
                    )
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Size Icon", ST_TEXTDOMAIN),
                    "param_name" => "st_size_icon",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-3',
                    'value'=>array(
                        __('Small',ST_TEXTDOMAIN)=>'box-icon-sm',
                        __('Medium',ST_TEXTDOMAIN)=>'box-icon-md',
                        __('Big',ST_TEXTDOMAIN)=>'box-icon-big',
                        __('Large',ST_TEXTDOMAIN)=>'box-icon-large',
                        __('Huge',ST_TEXTDOMAIN)=>'box-icon-huge',
                    )
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Round Icon", ST_TEXTDOMAIN),
                    "param_name" => "st_round",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-3',
                    'value'=>array(
                        __('No',ST_TEXTDOMAIN)=>'',
                        __('Yes',ST_TEXTDOMAIN)=>'round',
                    )
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Box icon border", ST_TEXTDOMAIN),
                    "param_name" => "st_border",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-3',
                    'value'=>array(
                        __('No',ST_TEXTDOMAIN)=>'',
                        __('Normal',ST_TEXTDOMAIN)=>'box-icon-border',
                        __('Dashed',ST_TEXTDOMAIN)=>'box-icon-border-dashed',
                    )
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Animation", ST_TEXTDOMAIN),
                    "param_name" => "st_animation",
                    "description" =>__("http://daneden.github.io/animate.css/",ST_TEXTDOMAIN),
                    'edit_field_class'=>'vc_col-sm-6',
                    'value'=>''
                ),
            )
        ) );
    }

    if(!function_exists('st_vc_icon')){
        function st_vc_icon($attr,$content=false)
        {
            $data = shortcode_atts(
                array(
                    'st_tooltip' =>'',
                    'st_pos_tooltip' =>'',
                    'st_icon' =>'',
                    'st_color_icon'=>'',
                    'st_to_color'=>'',
                    'st_size_icon'=>'',
                    'st_round'=>'',
                    'st_border'=>'',
                    'st_animation'=>'',
                    'st_aligment'=>''
                ), $attr, 'st_about_icon' );
            extract($data);

            $class_bg_color = Assets::build_css("background: ".$st_color_icon."");
            $class_bg_to_color = Assets::build_css("background: ".$st_to_color.";
                                                border-color: ".$st_to_color.";
                                                ",":hover");
            if($st_animation == "border-rise"){
                $class__ = Assets::build_css("box-shadow: 0 0 0 2px ".$st_to_color." ",":after");
                $class_bg_to_color =  $class_bg_to_color." ".$class__;
            }


            if(!empty($st_border)){
                $class_bg_color = Assets::build_css("border-color: ".$st_color_icon.";
                                                 color: ".$st_color_icon.";");
            }
            if(!$st_pos_tooltip or $st_pos_tooltip != 'none'){
                $html_tooltip = 'data-placement="'.$st_pos_tooltip.'" title="" rel="tooltip" data-original-title="'.$st_tooltip.'"';
            }else{$html_tooltip="";}

            if(!empty($st_animation)){
                $animate = "animate-icon-".$st_animation;
            }else{$animate = "";}

            $txt ='<i class="fa '.$st_icon.' '.$st_size_icon.' '.$st_border.' '.$st_aligment.' '.$class_bg_color.' '.$st_round.' '.$class_bg_to_color.' '.$animate.' " '.$html_tooltip.'> </i>';
            return $txt;
        }
    }
    st_reg_shortcode('st_icon','st_vc_icon');