<?php
    if(function_exists('vc_map')){
        vc_map( array(
            "name" => __("ST Gallery", ST_TEXTDOMAIN),
            "base" => "st_gallery",
            "content_element" => true,
            "icon" => "icon-st",
            "category"=>"Shinetheme",
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Number images", ST_TEXTDOMAIN),
                    "param_name" => "st_number_image",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-3',
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Animation effects", ST_TEXTDOMAIN),
                    "param_name" => "st_effect",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-3',
                    'value'=>array(
                        __('Default',ST_TEXTDOMAIN)=>'',
                        __('Zoom out',ST_TEXTDOMAIN)=>'mfp-zoom-out',
                        __('Zoom in',ST_TEXTDOMAIN)=>'mfp-zoom-in',
                        __('Fade',ST_TEXTDOMAIN)=>'mfp-fade',
                        __('Move horizontal',ST_TEXTDOMAIN)=>'mfp-move-horizontal',
                        __('Move from top',ST_TEXTDOMAIN)=>'mfp-move-from-top',
                        __('Newspaper',ST_TEXTDOMAIN)=>'mfp-newspaper',
                        __('3D unfold',ST_TEXTDOMAIN)=>'mfp-3d-unfold',
                    )
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Number Columns", ST_TEXTDOMAIN),
                    "param_name" => "st_col",
                    'edit_field_class'=>'vc_col-sm-3',
                    "value" => array(
                        __('Four',ST_TEXTDOMAIN)=>'4',
                        __('Three',ST_TEXTDOMAIN)=>'3',
                        __('Two',ST_TEXTDOMAIN)=>'2',
                    ),
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Icon hover", ST_TEXTDOMAIN),
                    "param_name" => "st_icon",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-3',
                    'value'=>"fa-plus"
                ),
                array(
                    "type" => "attach_images",
                    "holder" => "div",
                    "heading" => __("List Image", ST_TEXTDOMAIN),
                    "param_name" => "st_images_in",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-12',
                ),
                array(
                    "type" => "attach_images",
                    "holder" => "div",
                    "heading" => __("Images not in", ST_TEXTDOMAIN),
                    "param_name" => "st_images_not_in",
                    "description" =>"",
                    'edit_field_class'=>'vc_col-sm-12',
                ),
            )
        ) );
    }

    if(!function_exists('st_vc_gallery')){
        function st_vc_gallery($attr,$content=false)
        {
            $data = shortcode_atts(
                array(
                    'st_number_image'=>'',
                    'st_col'=>'5',
                    'st_images_not_in'=>'',
                    'st_images_in'=>'',
                    'st_effect'=>'mfp-zoom-out',
                    'st_icon'=>'fa-plus'
                ), $attr, 'st_gallery' );
            extract($data);
            $query_images_args = array(
                'post_type' => 'attachment',
                'post_mime_type' =>'image',
                'post_status' => 'inherit',
                'posts_per_page'=>$st_number_image,
                'post__not_in'=>explode(',',$st_images_not_in),
                'post__in'=>explode(',',$st_images_in)
            );
            $list = query_posts($query_images_args);
            $txt='';
            foreach ($list as $k=>$v){
                $col = 12 / $st_col ;
                $params = array( 'width' => 800, 'height' => 600);
                // $size = getimagesize($v->guid);
                //if($size[0] > 300 and $size[1] > 300 ) {
                $txt .= '<div class="col-md-' . $col . '">
                        <a class="hover-img popup-gallery-image" href="' . $v->guid . '" data-effect="'.$st_effect.'">
                            <img src="' . bfi_thumb($v->guid, $params) . '" alt="image" />
                            <i class="fa '.$st_icon.' round box-icon-small hover-icon i round"></i>
                        </a>
                    </div>';
                //  }
            }
            wp_reset_query();
            if($st_number_image > $list_in = count(explode(',',$st_images_in)) ) {
                $query_images_args = array(
                    'post_type' => 'attachment',
                    'post_mime_type' =>'image',
                    'post_status' => 'inherit',
                    'posts_per_page'=>$st_number_image - $list_in,
                    'post__not_in'=>explode(',',$st_images_not_in.','.$st_images_in),
                );
                $list = query_posts($query_images_args);
                foreach ($list as $k=>$v){
                    $col = 12 / $st_col ;
                    $params = array( 'width' => 800, 'height' => 600);
                    // $size = getimagesize($v->guid);
                    // if($size[0] > 300 and $size[1] > 300 ){
                    $txt .= '<div class="col-md-'.$col.'">
                        <a class="hover-img popup-gallery-image" href="'.$v->guid.'" data-effect="'.$st_effect.'">
                            <img src="'.bfi_thumb($v->guid, $params ).'" alt="image" />
                            <i class="fa fa-plus round box-icon-small hover-icon i round"></i>
                        </a>
                    </div>';
                    //  }
                }
                wp_reset_query();
            }
            $r =  '<div id="popup-gallery">
                    <div class="row row-col-gap">
                      '.$txt.'
                    </div>
                </div>';
            return $r;
        }
    }
    st_reg_shortcode('st_gallery','st_vc_gallery');