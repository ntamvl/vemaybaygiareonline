<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Initialize the custom Meta Boxes.
 *
 * Created by ShineTheme
 *
 */
$custom_metabox[] = array(
    'id'          => 'demo_meta_box',
    'title'       => __( 'Demo Meta Box', ST_TEXTDOMAIN),
    'desc'        => '',
    'pages'       => array( 'post' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
        array(
            'label'       => __( 'Information', ST_TEXTDOMAIN),
            'id'          => 'infomation_tab',
            'type'        => 'tab'
        ),

        array(
            'label'       => __( 'Gallery', ST_TEXTDOMAIN),
            'id'          => 'gallery',
            'type'        => 'gallery',
            'desc'        =>  __( 'This is a Gallery option type', ST_TEXTDOMAIN),

        ),array(
            'label'       => __( 'Media(Video URL or Audio URL)', ST_TEXTDOMAIN),
            'id'          => 'media',
            'type'        => 'text',
            'desc'        =>  __( 'This field for Audio and Video Post Format', ST_TEXTDOMAIN),

        ),array(
            'label'       => __( 'Link', ST_TEXTDOMAIN),
            'id'          => 'link',
            'type'        => 'text',
            'desc'        =>  __( 'This is a Link option type', ST_TEXTDOMAIN),

        ),
        array(
            'label'       => __( 'Post Sidebar Setting', ST_TEXTDOMAIN),
            'id'          => 'sidebar_tab_post',
            'type'        => 'tab'
        ),
        array(
            'id'          => 'post_sidebar_pos',
            'label'       => __( 'Sidebar Position', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'You can choose No sidebar, Left Sidebar and Rigt Sidebar' ,ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_blog',
            'choices'   =>array(
                array(
                    'value'=>'',
                    'label'=>__('---Select---',ST_TEXTDOMAIN)
                ),
                array(
                    'value'=>'no',
                    'label'=>__('No',ST_TEXTDOMAIN)
                ),
                array(
                    'value'=>'left',
                    'label'=>__('Left',ST_TEXTDOMAIN)
                ),
                array(
                    'value'=>'right',
                    'label'=>__('Right',ST_TEXTDOMAIN)
                )

            )
        ),
        array(
            'label'       => __( 'Select Sidebar', ST_TEXTDOMAIN),
            'id'          => 'post_sidebar',
            'type'        => 'sidebar-select',
        ),

    )
);


//Pages
$custom_metabox[] = array(
    'id'          => 'st_footer_social',
    'title'       => __( 'Page Setting', ST_TEXTDOMAIN),
    'desc'        => '',
    'pages'       => array( 'page' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
        array(
            'label'       => __( 'Template Comming Soon Setting', ST_TEXTDOMAIN),
            'id'          => 'detail_tab',
            'type'        => 'tab'
        ),
        array(
            'label'       => __( 'Data date countdown', ST_TEXTDOMAIN),
            'id'          => 'data_countdown',
            'type'        => 'date-picker',
            'desc'        => __( 'Input ', ST_TEXTDOMAIN),
        ),
        array(
            'label'       => __( 'Footer Social', ST_TEXTDOMAIN),
            'id'          => 'footer_social',
            'type'        => 'textarea',
            'desc'        => __( 'Input html social', ST_TEXTDOMAIN),
            'rows'         => 3
        ),
        array(
            'label'       => __( 'Login page Setting', ST_TEXTDOMAIN),
            'id'          => 'login_tab',
            'type'        => 'tab'
        ),
        array(
            'label'       => __( 'Button sing in', ST_TEXTDOMAIN),
            'id'          => 'btn_sing_in',
            'type'        => 'text',
            'value'        => __( 'Sing in', ST_TEXTDOMAIN),
            'desc'        => __( 'Input text', ST_TEXTDOMAIN),
        ),
        array(
            'label'       => __( 'Button sing up', ST_TEXTDOMAIN),
            'id'          => 'btn_sing_up',
            'type'        => 'text',
            'value'       => __( 'Sign up for Traveler', ST_TEXTDOMAIN),
            'desc'        => __( 'Input text', ST_TEXTDOMAIN),
        ),
    )
);

$custom_metabox[] = array(
    'id'          => 'st_footer_page',
    'title'       => __( 'Page Options', ST_TEXTDOMAIN),
    'desc'        => '',
    'pages'       => array( 'page','product' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
        array(
            'label'       => __( 'Footer Template', ST_TEXTDOMAIN),
            'id'          => 'footer_template',
            'type'        => 'page-select',
            'desc'        => __( 'Select custom footer template from pages', ST_TEXTDOMAIN),
        ),
        array(
            'id'          => 'post_sidebar_pos',
            'label'       => __( 'Sidebar Position', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'You can choose No sidebar, Left Sidebar and Rigt Sidebar' ,ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_blog',
            'choices'   =>array(
                array(
                    'value'=>'',
                    'label'=>__('--- Select ---',ST_TEXTDOMAIN)
                ),
                array(
                    'value'=>'no',
                    'label'=>__('No',ST_TEXTDOMAIN)
                ),
                array(
                    'value'=>'left',
                    'label'=>__('Left',ST_TEXTDOMAIN)
                ),
                array(
                    'value'=>'right',
                    'label'=>__('Right',ST_TEXTDOMAIN)
                )

            )
        ),
        array(
            'label'       => __( 'Select Sidebar', ST_TEXTDOMAIN),
            'id'          => 'post_sidebar',
            'type'        => 'sidebar-select',
        ),

    )
);


    $custom_metabox[] = array(
        'id'       => 'st_custom_type_layout',
        'title'    => __('Layout Options', ST_TEXTDOMAIN),
        'desc'     => '',
        'pages'    => array('st_layouts'),
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'label' => __('Type Layout Options', ST_TEXTDOMAIN),
                'id'    => 'type_layout_tab',
                'type'  => 'tab'
            ),
            array(
                'label'   => __('Type Layout', ST_TEXTDOMAIN),
                'id'      => 'st_type_layout',
                'type'    => 'select',
                'choices' => array(
                    array(
                        'value' => 'st_hotel',
                        'label' => __('Hotel', ST_TEXTDOMAIN)
                    ),
                    array(
                        'value' => 'st_rental',
                        'label' => __('Rental', ST_TEXTDOMAIN)
                    ),
                    array(
                        'value' => 'st_activity',
                        'label' => __('Activity', ST_TEXTDOMAIN)
                    ),
                    array(
                        'value' => 'st_tours',
                        'label' => __('Tour', ST_TEXTDOMAIN)
                    ),
                    array(
                        'value' => 'st_cars',
                        'label' => __('Car', ST_TEXTDOMAIN)
                    )
                )
            )
        )
    );





