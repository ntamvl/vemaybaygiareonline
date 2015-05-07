<?php
    /**
     * @package WordPress
     * @subpackage Traveler
     * @since 1.0
     *
     * Class STLocation
     *
     * Created by ShineTheme
     *
     */
    if (!class_exists('STLocation')) {
        class STLocation extends TravelerObject
        {

            function init()
            {
                parent::init();
                $this->init_metabox();


                add_action('wp_ajax_st_search_location', array($this, 'search_location'));
                add_action('wp_ajax_nopriv_st_search_location', array($this, 'search_location'));
            }

            function get_featured_ids($arg = array())
            {
                $default = array(
                    'posts_per_page' => 10,
                    'post_type'      => 'location'
                );

                extract(wp_parse_args($arg, $default));

                $ids = array();

                $query = array(
                    'posts_per_page' => $posts_per_page,
                    'post_type'      => $post_type,
                    'meta_key'       => 'is_featured',
                    'meta_value'     => 'on'
                );

                $q = new WP_Query($query);

                while ($q->have_posts()) {
                    $q->the_post();
                    $ids[] = get_the_ID();
                }

                //wp_reset_query();

                return $ids;
            }

            function search_location()
            {
                //Small security
                check_ajax_referer('st_search_security', 'security');

                $s = STInput::get('s');
                $arg = array(
                    'post_type'      => 'location',
                    'posts_per_page' => 10,
                    's'              => $s
                );

                if ($s) {
                    //$arg['meta_compare']='OR';
//            $arg['meta_query'][]=array(
//                'key'=>'zipcode',
//                'value'=>$s,
//                'compare'=>'LIKE'
//            );
//
//            $arg['meta_query']['relation']='or';
                }

                global $wp_query;

                query_posts($arg);
                $r = array();

                while (have_posts()) {
                    the_post();

                    $r['data'][] = array(
                        'title' => get_the_title(),
                        'id'    => get_the_ID(),
                        'type'  => __('Location', ST_TEXTDOMAIN)
                    );
                }
                wp_reset_query();
                echo json_encode($r);

                die();
            }

            function init_metabox()
            {

                $this->metabox[] = array(
                    'id'       => 'st_location',
                    'title'    => __('Location Setting', ST_TEXTDOMAIN),
                    'pages'    => array('location'),
                    'context'  => 'normal',
                    'priority' => 'high',
                    'fields'   => array(
                        array(
                            'label' => __('Location Information', ST_TEXTDOMAIN),
                            'id'    => 'detail_tab',
                            'type'  => 'tab'
                        ),
                        array(
                            'label' => __('Logo', ST_TEXTDOMAIN),
                            'id'    => 'logo',
                            'type'  => 'upload',
                            'desc'  => __('logo', ST_TEXTDOMAIN),
                        ),
                        array(
                            'label' => __('Set as Featured', ST_TEXTDOMAIN),
                            'id'    => 'is_featured',
                            'type'  => 'on-off',
                            'desc'  => __('Set this location is featured', ST_TEXTDOMAIN),
                            'std'   => 'off'
                        ),
                        array(
                            'label' => __('Zip Code', ST_TEXTDOMAIN),
                            'id'    => 'zipcode',
                            'type'  => 'text',
                            'desc'  => __('Zip code of this location', ST_TEXTDOMAIN),
                        ),
                        array(
                            'label' => __('Latitude', ST_TEXTDOMAIN),
                            'id'    => 'map_lat',
                            'type'  => 'text',
                            'desc'  => __('Latitude <a href="http://www.latlong.net/" target="_blank">Get here</a>', ST_TEXTDOMAIN),
                        ),

                        array(
                            'label' => __('Longitude', ST_TEXTDOMAIN),
                            'id'    => 'map_lng',
                            'type'  => 'text',
                            'desc'  => __('Longitude', ST_TEXTDOMAIN),
                        ),
                        array(
                            'label' => __('Sale setting', ST_TEXTDOMAIN),
                            'id'    => 'sale_number_tab',
                            'type'  => 'tab'
                        ),

                        array(
                            'label' => __('Total Sale Number', ST_TEXTDOMAIN),
                            'id'    => 'total_sale_number',
                            'type'  => 'text',
                            'desc'  => __('Total Number Booking', ST_TEXTDOMAIN),
                        ),
                        array(
                            'label' => __('Rate setting', ST_TEXTDOMAIN),
                            'id'    => 'rate_number_tab',
                            'type'  => 'tab'
                        ),

                        array(
                            'label' => __('Rate Review', ST_TEXTDOMAIN),
                            'id'    => 'rate_review',
                            'type'  => 'text',
                            'desc'  => __('', ST_TEXTDOMAIN),
                        ),
                    )
                );
            }


        }

        $a = new STLocation();
        $a->init();
    }
