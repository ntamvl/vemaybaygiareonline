<?php
if(!function_exists('st_thumbnail_cars_func'))
{
    function st_thumbnail_cars_func()
    {
        if(is_singular('st_cars'))
        {
            return st()->load_template('cars/elements/image','featured');
        }
    }
    st_reg_shortcode('st_thumbnail_cars','st_thumbnail_cars_func');
}

if(!function_exists('st_excerpt_cars_func'))
{
    function st_excerpt_cars_func()
    {
        if(is_singular('st_cars'))
        {
            return '<p class="text-small">'.get_the_excerpt()."</p><hr>";
        }
    }
    st_reg_shortcode('st_excerpt_cars','st_excerpt_cars_func');
}

if(!function_exists('st_detail_date_location_cars_func'))
{
    function st_detail_date_location_cars_func()
    {
        if(is_singular('st_cars'))
        {
            $default=array(
                'drop-off'=>__('none',ST_TEXTDOMAIN),
                'pick-up'=>__('none',ST_TEXTDOMAIN),
                'location_id_drop_off'=>'',
                'location_id_pick_up'=>'',
            );

            $_REQUEST=wp_parse_args($_REQUEST,$default);

            if(!empty($_REQUEST['pick-up-date'])){
                $pick_up_date =  mysql2date( 'F j, Y', $_REQUEST['pick-up-date']);
            }else{
                $pick_up_date = date( 'F j, Y', strtotime("now"));
            }
            if(!empty($_REQUEST['pick-up-time'])){
                $pick_up_time = $_REQUEST['pick-up-time'];
            }else{
                $pick_up_time ="12:00 AM";
            }
            if(STInput::request("location_id_pick_up")){
                 $address_pick_up = get_the_title(STInput::request("location_id_pick_up"));
            }else{
                 $address_pick_up = STInput::request('pick-up');
            }
            $pick_up = '<h5>'.st_get_language('car_pick_up').':</h5>
            <p><i class="fa fa-map-marker box-icon-inline box-icon-gray"></i>'.$address_pick_up.'</p>
            <p><i class="fa fa-calendar box-icon-inline box-icon-gray"></i>'.$pick_up_date.'</p>
            <p><i class="fa fa-clock-o box-icon-inline box-icon-gray"></i>'.$pick_up_time.'</p>';

            if(!empty($_REQUEST['drop-off-date'])){
                $drop_off_date =  mysql2date( 'F j, Y', $_REQUEST['drop-off-date']);
            }else{$drop_off_date = $pick_up_date = date( 'F j, Y', strtotime("+1 day"));}

            if(!empty($_REQUEST['drop-off-time'])){
                $drop_off_time = $_REQUEST['drop-off-time'];
            }else{ $drop_off_time ="12:00 AM"; }
            if(STInput::request('location_id_drop_off')){
                $address_drop_off = get_the_title(STInput::request('location_id_drop_off'));
            }else{
                $address_drop_off = STInput::request('drop-off');
            }
            $drop_off = '   <h5>'.st_get_language('car_drop_off').':</h5>
                            <p><i class="fa fa-map-marker box-icon-inline box-icon-gray"></i>'.$address_drop_off.'</p>
                            <p><i class="fa fa-calendar box-icon-inline box-icon-gray"></i>'.$drop_off_date.'</p>
                            <p><i class="fa fa-clock-o box-icon-inline box-icon-gray"></i>'.$drop_off_time.'</p>';

            $logo = get_post_meta(get_the_ID(),'cars_logo',true);
            if(!empty($logo)){
                $logo = '<img src="'.bfi_thumb($logo,array('width'=>'120','height'=>'120')).'" alt="logo" />';
            }
            $about = get_post_meta(get_the_ID(),'cars_about',true);
            if(!empty($about)){
                $about = ' <h5>'.st_get_language('car_about').'</h5>
                          <p>'.get_post_meta(get_the_ID(),'cars_about',true).'</p>';
            }

            return '<div class="booking-item-deails-date-location">
                            <ul>
                                <li class="text-center">
                                    '.$logo.'
                                </li>
                                <li>
                                    <p class="f-20 text-center">'.get_post_meta(get_the_ID(),'cars_name',true).'</p>
                                </li>
                                <li>
                                    <h5>'.st_get_language('car_phone').':</h5>
                                    <p><i class="fa fa-phone box-icon-inline box-icon-gray"></i>'.get_post_meta(get_the_ID(),'cars_phone',true).'</p>
                                </li>
                                 <li>
                                    <h5>'.st_get_language('car_email').':</h5>
                                    <p><i class="fa fa-envelope-o box-icon-inline box-icon-gray"></i>'.get_post_meta(get_the_ID(),'cars_email',true).'</p>
                                </li>
                                <li>
                                    '.$about.'
                                </li>
                                <li>'.$pick_up.'</li>
                                <li>'.$drop_off.'</li>
                            </ul>
                            <a href="#search-dialog" data-effect="mfp-zoom-out" class="btn btn-primary popup-text" href="#">'.st_get_language('change_location_and_date').'</a>
                        </div>';
        }
    }
    st_reg_shortcode('st_detail_date_location_cars','st_detail_date_location_cars_func');
}

if(!function_exists('st_car_video'))
{
    function st_car_video($attr=array())
    {
        if(is_singular('st_cars'))
        {
            if($video=get_post_meta(get_the_ID(),'video',true)){
                return "<div class='media-responsive'>".wp_oembed_get($video)."</div>";
            }
        }
    }
}
st_reg_shortcode('st_car_video','st_car_video');