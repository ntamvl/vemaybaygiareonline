<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User overview
 *
 * Created by ShineTheme
 *
 */
?>
<?php $data = STUser_f::get_info_total_traveled(); ?>
<?php wp_enqueue_script('st-gmap-init'); ?>
<h4><?php st_the_language('user_total_traveled') ?></h4>
<ul class="list list-inline user-profile-statictics mb30">
    <li><i class="fa fa-building-o user-profile-statictics-icon"></i>
        <h5><?php echo esc_html($data['st_hotel']) ?></h5>
        <p><?php if($data['st_hotel'] > 1)st_the_language('hotels');else st_the_language('hotel'); ?></p>
    </li>
    <li><i class="fa fa-home user-profile-statictics-icon"></i>
        <h5><?php echo esc_html($data['st_rental']) ?></h5>
        <p><?php if($data['st_rental'] > 1)st_the_language('rentals');else st_the_language('rental'); ?></p>
    </li>
    <li><i class="fa fa-car  user-profile-statictics-icon"></i>
        <h5><?php echo esc_html($data['st_cars']) ?></h5>
        <p><?php if($data['st_cars'] > 1)st_the_language('cars');else st_the_language('car'); ?></p>
    </li>
    <li><i class="fa fa-flag-o user-profile-statictics-icon"></i>
        <h5><?php echo esc_html($data['st_tours']) ?></h5>
        <p><?php if($data['st_tours'] > 1)st_the_language('tours');else st_the_language('tour'); ?></p>
    </li>
    <li><i class="fa fa-bolt user-profile-statictics-icon"></i>
        <h5><?php echo esc_html($data['st_activity']) ?></h5>
        <p><?php if($data['st_activity'] > 1)st_the_language('activities');else st_the_language('activity'); ?></p>
    </li>
</ul>
<div>
    <div>
        <div class="st_google_map_user"></div>
    </div>
    <script>

        jQuery(function($){
            $('.st_google_map_user').gmap3({
                map:{
                    options:{
                        zoom: 5
                    }
                },
                marker:{
                    values:[<?php
                     foreach($data['address'] as $k=> $v){
                        echo '{address:"'.$v.'", data:"'.$v.'"},';
                     }
                     ?>],
                    options:{
                        draggable: true
                    },
                    events:{
                        mouseover: function(marker, event, context){
                            var map = $(this).gmap3("get"),
                                infowindow = $(this).gmap3({get:{name:"infowindow"}});
                            if (infowindow){
                                infowindow.open(map, marker);
                                infowindow.setContent(context.data);
                            } else {
                                $(this).gmap3({
                                    infowindow:{
                                        anchor:marker,
                                        options:{content: context.data}
                                    }
                                });
                            }
                        },
                        mouseout: function(){
                            var infowindow = $(this).gmap3({get:{name:"infowindow"}});
                            if (infowindow){
                                infowindow.close();
                            }
                        }
                    }
                }
            });
        });
    </script>

</div>