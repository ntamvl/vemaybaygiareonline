<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Custom option theme option
 *
 * Created by ShineTheme
 *
 */
    if(!class_exists('TravelHelper')) return;
$custom_settings = array(

    'sections'        => array(
        array(
            'id'          => 'option_general',
            'title'       => __( '<i class="fa fa-tachometer"></i> General Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_style',
            'title'       => __( '<i class="fa fa-paint-brush"></i> Styling Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_featured',
            'title'       => __( '<i class="fa fa-flag-checkered"></i> Featured Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_blog',
            'title'       => __( '<i class="fa fa-bold"></i> Blog Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_page',
            'title'       => __( '<i class="fa fa-file-text"></i> Page Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_booking',
            'title'       => __( '<i class="fa fa-book"></i> Booking Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_tax',
            'title'       => __( '<i class="fa fa-exchange"></i> Tax Options', ST_TEXTDOMAIN )
        ),
//        array(
//            'id'          => 'option_location',
//            'title'       => __( 'Location Options', ST_TEXTDOMAIN )
//        ),
        array(
          'id'            =>'option_review',
           'title'        =>__('<i class="fa fa-comments-o"></i> Review Options',ST_TEXTDOMAIN)
        ),
        array(
            'id'          => 'option_hotel',
            'title'       => __( '<i class="fa fa-building"></i> Hotel Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_rental',
            'title'       => __( '<i class="fa fa-home"></i> Rental Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_car',
            'title'       => __( '<i class="fa fa-car"></i> Car Options', ST_TEXTDOMAIN )
        ),
//        array(
//            'id'          => 'option_cruise',
//            'title'       => __( 'Cruise Options', ST_TEXTDOMAIN )
//        ),
        array(
            'id'          => 'option_activity_tour',
            'title'       => __( '<i class="fa fa-suitcase"></i> Tour Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_activity',
            'title'       => __( '<i class="fa fa-ticket"></i> Activity Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_partner',
            'title'       => __( '<i class="fa fa-users"></i> Partner Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_search',
            'title'       => __( '<i class="fa fa-search"></i> Search Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_email',
            'title'       => __( '<i class="fa fa-envelope"></i> Email Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_social',
            'title'       => __( '<i class="fa fa-facebook-official"></i> Social Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_404',
            'title'       => __( '<i class="fa fa-exclamation-triangle"></i> 404 Options', ST_TEXTDOMAIN )
        ),
        array(
            'id'          => 'option_shop',
            'title'       => __( '<i class="fa fa-exclamation-triangle"></i> Shop Options', ST_TEXTDOMAIN )
        ),
//        array(
//            'id'          => 'option_recaptcha',
//            'title'       => __( 'reCAPTCHA Options', ST_TEXTDOMAIN )
//        ),
        array(
            'id'          => 'option_advance',
            'title'       => __( '<i class="fa fa-cogs"></i> Advance Options', ST_TEXTDOMAIN )
        )
    ),
    'settings'        => array(
        array(
            'id'          => 'st_text_featured',
            'label'       => __('Text Featured',ST_TEXTDOMAIN),
            'desc'        => 'Text Featured',
            'type'        => 'text',
            'section'     => 'option_featured',
            'class'       => '',
            'std'         =>'Featured'
        ),
        array(
            'id'          => 'st_text_featured_color',
            'label'       => __('Text Color',ST_TEXTDOMAIN),
            'desc'        => 'Text Color',
            'type'        => 'colorpicker',
            'section'     => 'option_featured',
            'class'       => '',
            'std'         =>'#fff',
        ),
        array(
            'id'          => 'st_text_featured_bg',
            'label'       => __('Background color',ST_TEXTDOMAIN),
            'desc'        => 'Background color',
            'type'        => 'colorpicker',
            'section'     => 'option_featured',
            'class'       => '',
            'std'         =>'#19A1E5',
        ),
        array(
            'id'          => 'gen_enable_smscroll',
            'label'       => __( 'Enable Nice Scroll', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'This allows you to turn on or off <em>Nice Scroll Effect</em>',ST_TEXTDOMAIN ),
            'type'        => 'on-off',
            'section'     => 'option_general',
            'std'=>'off'
        ),

        array(
            'id'          => 'gen_enable_sticky_menu',
            'label'       => __( 'Enable Sticky Menu', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'This allows you to turn on or off <em>Sticky Menu Feature</em>',ST_TEXTDOMAIN ),
            'type'        => 'on-off',
            'section'     => 'option_general',
            'std'=>'off'
        ),

        array(
            'id'          => 'favicon',
            'label'       => __( 'Favicon', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'This allows you to change favicon of your website',ST_TEXTDOMAIN ),
            'type'        => 'upload',
            'section'     => 'option_general',
            'std'=>get_template_directory_uri().'/img/favicon.png'
        )
    ,array(
            'id'          => 'logo',
            'label'       => __( 'Logo', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'This allows you to change logo',ST_TEXTDOMAIN ),
            'type'        => 'upload',
            'section'     => 'option_general',
            'std'=>get_template_directory_uri().'/img/logo.png'
        ),array(
            'id'          => 'logo_retina',
            'label'       => __( 'Logo Retina', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'Note: You MUST re-name Logo Retina to logo-name@2x.ext-name. Example:<br>
                                    Logo is: <em>my-logo.jpg</em><br>Logo Retina must be: <em>my-logo@2x.jpg</em>  ' ,ST_TEXTDOMAIN ),
            'type'        => 'upload',
            'section'     => 'option_general',
            'std'=>get_template_directory_uri().'/img/logo@2x.png'
        ),
        array(
            'id'          => 'st_seo_option',
            'label'       => __('SEO options',ST_TEXTDOMAIN),
            'desc'        => '',
            'std'         => '',
            'type'        => 'on-off',
            'section'     => 'option_general',
            'class'       => '',
        ),
        array(
            'id'          => 'st_seo_title',
            'label'       => __('SEO Title',ST_TEXTDOMAIN),
            'desc'        => '',
            'std'         => '',
            'type'        => 'text',
            'section'     => 'option_general',
            'class'       => '',
            'condition'   => 'st_seo_option:is(on)',
        ),
        array(
            'id'          => 'st_seo_desc',
            'label'       => __('SEO Description',ST_TEXTDOMAIN),
            'desc'        => '',
            'std'         => '',
            'rows'        =>'5',
            'type'        => 'textarea-simple',
            'section'     => 'option_general',
            'class'       => '',
            'condition'   => 'st_seo_option:is(on)',
        ),
        array(
            'id'          => 'st_seo_keywords',
            'label'       => __('SEO Keywords',ST_TEXTDOMAIN),
            'desc'        => '',
            'std'         => '',
            'rows'        =>'5',
            'type'        => 'textarea-simple',
            'section'     => 'option_general',
            'class'       => '',
            'condition'   => 'st_seo_option:is(on)',
        ),
        array(
            'id'          => 'footer_template',
            'label'       => __( 'Page for footer', ST_TEXTDOMAIN ),
            'type'        => 'page-select',
            'section'     => 'option_general',
        ),
        array(
            'id'          => 'enable_user_online_noti',
            'label'       => __( 'Enable User Online Notification', ST_TEXTDOMAIN ),
            'type'        => 'on-off',
            'section'     => 'option_general',
            'std'         =>'on'
        ),
        array(
            'id'          => 'enable_last_booking_noti',
            'label'       => __( 'Enable Last Booking Notification', ST_TEXTDOMAIN ),
            'type'        => 'on-off',
            'section'     => 'option_general',
            'std'         =>'on'
        ),
        array(
            'id'          => 'noti_position',
            'label'       => __( 'Notification Position', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_general',
            'std'         =>'topRight',
            'choices'     =>array(
                array(
                    'label'     =>__('Top Right',ST_TEXTDOMAIN),
                    'value'     =>'topRight'
                ),
                array(
                    'label'     =>__('Top Left',ST_TEXTDOMAIN),
                    'value'     =>'topLeft'
                ),
                array(
                    'label'     =>__('Bottom Right',ST_TEXTDOMAIN),
                    'value'     =>'bottomRight'
                ),
                array(
                    'label'     =>__('Bottom Left',ST_TEXTDOMAIN),
                    'value'     =>'bottomLeft'
                )
            ),
        ),
        array(
            'id'          => 'st_weather_temp_unit',
            'label'       => __( 'Weather Temp Unit', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_general',
            'std'         =>'c',
            'choices'     =>array(
                array(
                    'label'     =>__('Fahrenheit (f)',ST_TEXTDOMAIN),
                    'value'     =>'f'
                ),
                array(
                    'label'     =>__('Celsius (c)',ST_TEXTDOMAIN),
                    'value'     =>'c'
                ),
                array(
                    'label'     =>__('Kelvin (k)',ST_TEXTDOMAIN),
                    'value'     =>'k'
                ),
            ),
        )


        /*--------------Begin Tax Options------------*/
        ,array(
            'id'          => 'tax_enable',
            'label'       => __( 'Enable Tax', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'Enable tax calculations' ,ST_TEXTDOMAIN ),
            'type'        => 'on-off',
            'section'     => 'option_tax',
            'std'     =>'off'
        )
        ,array(
            'id'          => 'tax_value',
            'label'       => __( 'Tax percentage', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'Tax percentage' ,ST_TEXTDOMAIN ),
            'type'        => 'numeric-slider',
            'section'     => 'option_tax',
            'min_max_step'     =>'0,100,1',
            'condition'  =>'tax_enable:is(on)',
            'std'         =>10
        )
        /*--------------End Tax Options------------*/




        /*--------------Review Options------------*/
        ,array(
            'id'             =>'review_need_booked',
            'label'          =>__('Only Booked User Can Review',ST_TEXTDOMAIN),
            'desc'           =>__('<em>ON:</em> Only booked user can review<br><em>OFF:</em>Allow users to add a review where they have not booked',ST_TEXTDOMAIN),
            'section'        =>'option_review',
            'type'           =>'on-off',
            'std'            =>'on'
        )
        /*--------------End Review Options------------*/





        /*--------------Blog Options------------*/
        ,array(
                'id'          => 'blog_sidebar_pos',
                'label'       => __( 'Sidebar Position', ST_TEXTDOMAIN ),
                'desc'        =>  __( 'You can choose No sidebar, Left Sidebar and Right Sidebar' ,ST_TEXTDOMAIN ),
                'type'        => 'select',
                'section'     => 'option_blog',
                'choices'   =>array(
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

                ),
                'std'          =>'right'
            )
            ,array(
                'id'          => 'blog_sidebar_id',
                'label'       => __( 'Widget Area', ST_TEXTDOMAIN ),
                'desc'        =>  __( 'You can choose from the list' ,ST_TEXTDOMAIN ),
                'type'        => 'sidebar-select',
                'section'     => 'option_blog',
                'std'         =>'blog-sidebar',
            ),
        /*--------------End Blog Options------------*/
        /*--------------Page Options------------*/
        array(
            'id'          => 'page_my_account_dashboard',
            'label'       => __( 'My account dashboard page', ST_TEXTDOMAIN ),
            'desc'        =>  __( '' ,ST_TEXTDOMAIN ),
            'type'        => 'page-select',
            'section'     => 'option_page',
        ),
        array(
            'id'          => 'page_redirect_to_after_login',
            'label'       => __( 'Redirect to after login', ST_TEXTDOMAIN ),
            'desc'        =>  __( '' ,ST_TEXTDOMAIN ),
            'type'        => 'page-select',
            'section'     => 'option_page',
        ),
        array(
            'id'          => 'page_redirect_to_after_logout',
            'label'       => __( 'Redirect to after logout', ST_TEXTDOMAIN ),
            'desc'        =>  __( '' ,ST_TEXTDOMAIN ),
            'type'        => 'page-select',
            'section'     => 'option_page',
        ),
        array(
            'id'          => 'page_user_login',
            'label'       => __( 'User Login', ST_TEXTDOMAIN ),
            'desc'        =>  __( '' ,ST_TEXTDOMAIN ),
            'type'        => 'page-select',
            'section'     => 'option_page',
        ),
        array(
            'id'          => 'page_checkout',
            'label'       => __( 'Checkout Page', ST_TEXTDOMAIN ),
            'desc'        =>  __( '' ,ST_TEXTDOMAIN ),
            'type'        => 'page-select',
            'section'     => 'option_page',
        ),
        array(
            'id'          => 'page_payment_success',
            'label'       => __( 'Payment Success Page', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'Payment Success or Thank you page' ,ST_TEXTDOMAIN ),
            'type'        => 'page-select',
            'section'     => 'option_page',
        ),
        array(
            'id'          => 'page_order_confirm',
            'label'       => __( 'Order Confirm Page', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'Order Confirm Page' ,ST_TEXTDOMAIN ),
            'type'        => 'page-select',
            'section'     => 'option_page',
        ),
        array(
            'id'          => 'page_terms_conditions',
            'label'       => __( 'Terms and Conditions Page', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'Terms and Conditions Page' ,ST_TEXTDOMAIN ),
            'type'        => 'page-select',
            'section'     => 'option_page',
        ),

        /*--------------End Page Options------------*/
        /*------------- Styling Option----------*/


        array(
            'id'          => 'right_to_left',
            'label'       => __( 'Right to left', ST_TEXTDOMAIN ),
            'desc'        =>  __( '' ,ST_TEXTDOMAIN ),
            'type'        => 'on-off',
            'section'     => 'option_style',
            'output'      =>'',
            'std'=>'off'
        ),
        array(
            'id'          => 'typography',
            'label'       => __( 'Typography', ST_TEXTDOMAIN ),
            'desc'        =>  __( '' ,ST_TEXTDOMAIN ),
            'type'        => 'typography',
            'section'     => 'option_style',
            'output'      =>'body'
        ),
        array(
            'id'          => 'google_fonts',
            'label'       => __( 'Google Fonts', ST_TEXTDOMAIN ),
            'desc'        =>  __( '' ,ST_TEXTDOMAIN ),
            'type'        => 'google-fonts',
            'section'     => 'option_style',
        ),
        array(
            'id'          => 'star_color',
            'label'       => __( 'Star Color', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'Star Color' ,ST_TEXTDOMAIN ),
            'type'        => 'colorpicker',
            'section'     => 'option_style',
        ),
        array(
            'id'          => 'heading_fonts',
            'label'       => __( 'Heading fonts', ST_TEXTDOMAIN ),
            'desc'        =>  __( '' ,ST_TEXTDOMAIN ),
            'type'        => 'typography',
            'section'     => 'option_style',
            'output'      =>'h1,h2,h3,h4,h5,h6'
        ),
        array(
            'id'          => 'style_layout',
            'label'       => __( 'Layout', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'You can choose Wide or Boxed layout' ,ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_style',
            'choices'   =>array(
                array(
                    'value'=>'wide',
                    'label'=>__('Wide',ST_TEXTDOMAIN)
                ),
                array(
                    'value'=>'boxed',
                    'label'=>__('Boxed',ST_TEXTDOMAIN)
                )

            )
        ),
        array(
            'id'          => 'body_background',
            'label'       => __( 'Body Background', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'Body Background' ,ST_TEXTDOMAIN ),
            'type'        => 'background',
            'section'     => 'option_style',
            'output'=>'body'
        ),
        array(
            'id'          => 'main_wrap_background',
            'label'       => __( 'Main wrap background', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'Main wrap background' ,ST_TEXTDOMAIN ),
            'type'        => 'background',
            'section'     => 'option_style',
            'output'    =>'.global-wrap'
        ),
        array(
            'id'          => 'header_background',
            'label'       => __( 'Header background', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'Header Background' ,ST_TEXTDOMAIN ),
            'type'        => 'background',
            'section'     => 'option_style',
            'output'    =>'.header-top'
        ),
        array(
            'id'          => 'style_default_scheme',
            'label'       => __( 'Default Color Scheme', ST_TEXTDOMAIN ),
            'desc'       => __( 'Select Default Color Scheme or choose your own main color bellow', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_style',
            'output'      =>'',
            'std'=>'',
            'choices'           =>array(
                array('label'=>'-- Please Select ---','value'=>''),
                array('label'=>'Bright Turquoise','value'=>'#0EBCF2'),
                array('label'=>'Turkish Rose','value'=>'#B66672'),
                array('label'=>'Salem','value'=>'#12A641'),
                array('label'=>'Hippie Blue','value'=>'#4F96B6'),
                array('label'=>'Mandy','value'=>'#E45E66'),
                array('label'=>'Green Smoke','value'=>'#96AA66'),
                array('label'=>'Horizon','value'=>'#5B84AA'),
                array('label'=>'Cerise','value'=>'#CA2AC6'),
                array('label'=>'Brick red','value'=>'#cf315a'),
                array('label'=>'De-York','value'=>'#74C683'),
                array('label'=>'Shamrock','value'=>'#30BBB1'),
                array('label'=>'Studio','value'=>'#7646B8'),
                array('label'=>'Leather','value'=>'#966650'),
                array('label'=>'Denim','value'=>'#1A5AE4'),
                array('label'=>'Scarlet','value'=>'#FF1D13'),
            )
        ),
        array(
            'id'          => 'main_color',
            'label'       => __( 'Main Color', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'Choose your theme\'s main color' ,ST_TEXTDOMAIN ),
            'type'        => 'colorpicker',
            'section'     => 'option_style',
            'std'         =>'#ed8323'
        ),
        array(
            'id'          => 'custom_css',
            'label'       => __( 'Custom CSS', ST_TEXTDOMAIN ),
            'desc'        =>  __( '' ,ST_TEXTDOMAIN ),
            'type'        => 'css',
            'section'     => 'option_style',
        ),

        /*------------ Advance Option------------*/

        array(
            'id'          => 'adv_compress_html',
            'label'       => __( 'Compress HTML', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'This allows you to compress HTML code.',ST_TEXTDOMAIN ),
            'type'        => 'on-off',
            'section'     => 'option_advance',
            'std'=>'off'
        )
        ,array(
            'id'          => 'adv_before_body_content',
            'label'       => __( 'Before Body Content', ST_TEXTDOMAIN ),
            'desc'        =>  sprintf(__( 'Right after the opening %s tag.',ST_TEXTDOMAIN ),esc_html('<body>')),
            'type'        => 'textarea-simple',
            'section'     => 'option_advance',
            //'std'=>'off'
        )
        ,array(
            'id'          => 'edv_enable_demo_mode',
            'label'       => __( 'Enable Demo Mode', ST_TEXTDOMAIN ),
            'desc'        =>  __('Do some magical',ST_TEXTDOMAIN),
            'type'        => 'on-off',
            'section'     => 'option_advance',
            'std'         => 'off',
            //'std'=>'off'
        )
        ,array(
            'id'          => 'edv_share_code',
            'label'       => __( 'Custom Share Code', ST_TEXTDOMAIN ),
            'desc'        =>  __('You you want change the share code in single item. Change this<br><code>[__post_permalink__]</code> for Permalink<br><code>[__post_title__]</code> for Title',ST_TEXTDOMAIN),
            'type'        => 'textarea-simple',
            'section'     => 'option_advance',
            'std'=>'<li><a href="https://www.facebook.com/sharer/sharer.php?u=[__post_permalink__]&amp;title=[__post_title__]" target="_blank" original-title="Facebook"><i class="fa fa-facebook fa-lg"></i></a></li>
        <li><a href="http://twitter.com/share?url=[__post_permalink__]&amp;title=[__post_title__]" target="_blank" original-title="Twitter"><i class="fa fa-twitter fa-lg"></i></a></li>
        <li><a href="https://plus.google.com/share?url=[__post_permalink__]&amp;title=[__post_title__]" target="_blank" original-title="Google+"><i class="fa fa-google-plus fa-lg"></i></a></li>
        <li><a class="no-open" href="javascript:void((function()%7Bvar%20e=document.createElement(\'script\');e.setAttribute(\'type\',\'text/javascript\');e.setAttribute(\'charset\',\'UTF-8\');e.setAttribute(\'src\',\'http://assets.pinterest.com/js/pinmarklet.js?r=\'+Math.random()*99999999);document.body.appendChild(e)%7D)());" target="_blank" original-title="Pinterest"><i class="fa fa-pinterest fa-lg"></i></a></li>
        <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=[__post_permalink__]&amp;title=[__post_title__]" target="_blank" original-title="LinkedIn"><i class="fa fa-linkedin fa-lg"></i></a></li>'
        )
        /*------------- Booking Option --------------*/
        ,array(
            'id'          =>'booking_modal',
            'label'       =>__('Booking with Modal',ST_TEXTDOMAIN),
            'type'        =>'on-off',
            'std'         =>'off',
            'section'     => 'option_booking',
        )
        ,array(
            'id'          =>'booking_enable_captcha',
            'label'       =>__('Booking Enable Captcha',ST_TEXTDOMAIN),
            'type'        =>'on-off',
            'std'         =>'on',
            'section'     => 'option_booking',
        )
        ,array(
            'id'          =>'booking_card_accepted',
            'label'       =>__('Card Accepted',ST_TEXTDOMAIN),
            'desc'       =>__('Card Accepted',ST_TEXTDOMAIN),
            'type'        =>'list-item',
            'settings'    =>array(
                array(
                    'id'     =>'image',
                    'label'  =>__('Image',ST_TEXTDOMAIN),
                    'desc'  =>__('Image',ST_TEXTDOMAIN),
                    'type'  =>'upload'
                )
            ),
            'std'         =>array(
                array(
                    'title'=>'Master Card',
                    'image'=>get_template_directory_uri().'/img/card/mastercard.png'
                ),
                array(
                    'title'=>'JCB',
                    'image'=>get_template_directory_uri().'/img/card/jcb.png'
                ),
                array(
                    'title'=>'Union Pay',
                    'image'=>get_template_directory_uri().'/img/card/unionpay.png'
                ),
                array(
                    'title'=>'VISA',
                    'image'=>get_template_directory_uri().'/img/card/visa.png'
                ),
                array(
                    'title'=>'American Express',
                    'image'=>get_template_directory_uri().'/img/card/americanexpress.png'
                ),
            ),
            'section'     => 'option_booking',
        )
        ,array(
            'id'          => 'booking_currency',
            'label'       => __( 'Currency List', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'This allows you to add currency to your website',ST_TEXTDOMAIN ),
            'type'        => 'Slider',
            'section'     => 'option_booking',
            'settings'    =>array(
                array(

                    'id'=>'name',
                    'label'=>__('Currency Name',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'=>TravelHelper::ot_all_currency()
                ), array(

                    'id'=>'symbol',
                    'label'=>__('Currency Symbol',ST_TEXTDOMAIN),
                    'type'=>'text',
                    'operator'    => 'and'
                ), array(

                    'id'=>'rate',
                    'label'=>__('Exchange rate',ST_TEXTDOMAIN),
                    'type'=>'text',
                    'operator'    => 'and',
                    'desc'=>__('Exchange rate vs Primary Currency',ST_TEXTDOMAIN)
                )

            ),
            'std'         =>array(
                array(
                    'title'         =>'USD',
                    'name'          =>'USD',
                    'symbol'        =>'$',
                    'rate'          =>1
                ),
                array(
                    'title'         =>'EUR',
                    'name'          =>'EUR',
                    'symbol'        =>'€',
                    'rate'          =>0.796491
                ),
                array(
                    'title'         =>'GBP',
                    'name'          =>'GBP',
                    'symbol'        =>'£',
                    'rate'          =>0.636169
                ),
            )

        )
        ,array(
                'id'          => 'booking_primary_currency',
                'label'       => __( 'Primary Currency', ST_TEXTDOMAIN ),
                'desc'        =>  __( 'This allows you to set Primary Currency to your website',ST_TEXTDOMAIN ),
                'type'        => 'select',
                'section'     => 'option_booking',
                'choices'    =>TravelHelper::get_currency(true),
                'std'         =>'USD'

            )

        ,array(
            'id'          => 'booking_currency_pos',
            'label'       => __( 'Currency Position', ST_TEXTDOMAIN ),
            'desc'        =>  __( 'This controls the position of the currency symbol.<br>Ex: $400 or 400 $',ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_booking',
            'choices'     =>array(
                    array(
                        'value'=>'left',
                        'label'=>__('Left (£99.99)',ST_TEXTDOMAIN),
                    ),
                    array(
                        'value'=>'right',
                        'label'=>__('Right (99.99£)',ST_TEXTDOMAIN),
                    ),
                    array(
                        'value'=>'left_space',
                        'label'=>__('Left with space (£ 99.99)',ST_TEXTDOMAIN),
                    ),
                    array(
                        'value'=>'right_space',
                        'label'=>__('Right with space (99.99 £)',ST_TEXTDOMAIN),
                    )
            ),
            'std'           =>'left'
        ),
        array(
            'id'        =>'booking_currency_precision',
            'label'     =>__('Currency decimal',ST_TEXTDOMAIN),
            'desc'     =>__('Sets the number of decimal points.',ST_TEXTDOMAIN),
            'section'   =>'option_booking',
            'type'      =>'numeric-slider',
            'min_max_step'=>'0,5,1',
            'std'       =>2
        )
        ,
//        array(
//            'id'          => 'booking_allow_func',
//            'label'       => __( 'Allow Booking functions for:', ST_TEXTDOMAIN ),
//            'desc'        =>  __( 'This allows you enable booking features(included search tab, book and order) on each object
//',ST_TEXTDOMAIN ),
//            'type'        => 'Checkbox',
//            'section'     => 'option_booking',
//            'choices'     =>array(
//                array(
//                    'value'=>'hotel',
//                    'label'=>__('Hotel',ST_TEXTDOMAIN),
//                ),
//                array(
//                    'value'=>'cars',
//                    'label'=>__('Cars',ST_TEXTDOMAIN),
//                ),
////                array(
////                    'value'=>'cruise',
////                    'label'=>__('Cruise',ST_TEXTDOMAIN),
////                ),
//                array(
//                    'value'=>'rental',
//                    'label'=>__('Rental',ST_TEXTDOMAIN),
//                ),
//                array(
//                    'value'=>'activity',
//                    'label'=>__('Activity',ST_TEXTDOMAIN),
//                ),
//                array(
//                    'value'=>'tour',
//                    'label'=>__('Tour',ST_TEXTDOMAIN),
//                ),
//            )
//
//        ),

        /*------------- End Booking Option --------------*/
        /*------------- Begin Location Option --------------*/

        /*------------- End Location Option --------------*/


        /*------------- Hotel Option --------------*/

        array(
            'id'          => 'hotel_posts_per_page',
            'label'       => __( 'Posts Per Page', ST_TEXTDOMAIN ),
            'desc'       => __( 'Posts Per Page', ST_TEXTDOMAIN ),
            'type'        => 'numeric-slider',
            'min_max_step'   =>'1,50,1',
            'section'     => 'option_hotel',
            'std'         =>'12'

        )
        ,array(
            'id'          => 'hotel_single_layout',
            'label'       => __( 'Hotel Detail Layout', ST_TEXTDOMAIN ),
            'type'        => 'select',
            //'post_type'   =>'st_layouts',
            'section'     => 'option_hotel',
            'choices'     => st_get_layout('st_hotel')
        )
        ,array(
            'id'          => 'hotel_search_layout',
            'label'       => __( 'Hotel Search Layout', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_hotel',
            'choices'     => st_get_layout('st_hotel')
        )
        ,array(
            'id'          => 'hotel_max_adult',
            'label'       => __( 'Max Adult In Room', ST_TEXTDOMAIN ),
            'desc'       => __( 'Max Adult In Room', ST_TEXTDOMAIN ),
            'type'        => 'text',
            'section'     => 'option_hotel',
            'std'         =>14

        )
        ,array(
            'id'          => 'hotel_max_child',
            'label'       => __( 'Max Child In Room', ST_TEXTDOMAIN ),
            'desc'       => __( 'Max Child In Room', ST_TEXTDOMAIN ),
            'type'        => 'text',
            'section'     => 'option_hotel',
            'std'         =>14

        ),
        array(
            'id'          => 'hotel_review',
            'label'       => __( 'Enable Review', ST_TEXTDOMAIN ),
            'type'        => 'on-off',
            'section'     => 'option_hotel',
            'std'         =>'on'

        ),
//        array(
//            'id'          => 'hotel_check_review_admin',
//            'label'       => __( 'Review must be approve by admin', ST_TEXTDOMAIN ),
//            'type'        => 'on-off',
//            'section'     => 'option_hotel',
//            'condition'   => 'hotel_review:is(on)',
//        ),
        array(
            'id'          => 'hotel_review_stats',
            'label'       => __( 'Hotel Review Stats', ST_TEXTDOMAIN ),
            'desc'       => __( 'Hotel Review Stats', ST_TEXTDOMAIN ),
            'type'        => 'list-item',
            'section'     => 'option_hotel',
            'condition'   => 'hotel_review:is(on)',
            'settings'    =>array(
                array(
                    'id'=>'name',
                    'label'=>__('Stat Name',ST_TEXTDOMAIN),
                    'type'=>'textblock',
                    'operator'    => 'and',
                )
            ),
            'std'         =>array(

                array('title'=>'Sleep'),
                array('title'=>'Location'),
                array('title'=>'Service'),
                array('title'=>'Clearness'),
                array('title'=>'Rooms'),
            )
        ),
        array(
            'id'          => 'hotel_sidebar_pos',
            'label'       => __( 'Sidebar Position', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_hotel',
            'choices'   =>array(
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

            ),
            'std'=>'left'

        ),
        array(
            'id'          => 'hotel_sidebar_area',
            'label'       => __( 'Sidebar Area', ST_TEXTDOMAIN ),
            'type'        => 'sidebar-select',
            'section'     => 'option_hotel',
        ),
        array(
            'id'            =>'is_featured_search_hotel',
            'label'         =>__('Feature only top search',ST_TEXTDOMAIN),
            'type'          =>'on-off',
            'std'           =>'off',
            'section'       =>'option_hotel'
        ),
        array(
            'id'          => 'hotel_search_fields',
            'label'       => __( 'Hotel Search Fields', ST_TEXTDOMAIN ),
            'desc'       => __( 'Hotel Search Fields', ST_TEXTDOMAIN ),
            'type'        => 'list-item',
            'section'     => 'option_hotel',
            'std'         =>array(
                array(
                    'title'=>'Where',
                    'name'=>'location',
                    'layout_col'=>4

                ),
                array(
                    'title'=>'Check in',
                    'name'=>'checkin',
                    'layout_col'=>2
                ),
                array(
                    'title'=>'Check out',
                    'name'=>'checkout',
                    'layout_col'=>2
                ),
                array(
                    'title'=>'Rooms',
                    'name'=>'room_num',
                    'layout_col'=>2
                ),
                array(
                    'title'=>'Adult',
                    'name'=>'adult',
                    'layout_col'=>2
                )
            ),
            'settings'    =>array(
                array(
                    'id'=>'name',
                    'label'=>__('Field name',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'     =>STHotel::get_search_fields_name()
                ),
                array(
                    'id'=>'layout_col',
                    'label'=>__('Layout 1 Size',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'std'         =>4,
                    'choices'   =>array(
                        array(
                            'value'=>'1',
                            'label'=>__('column 1',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'2',
                            'label'=>__('column 2',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'3',
                            'label'=>__('column 3',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'4',
                            'label'=>__('column 4',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'5',
                            'label'=>__('column 5',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'6',
                            'label'=>__('column 6',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'7',
                            'label'=>__('column 7',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'8',
                            'label'=>__('column 8',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'9',
                            'label'=>__('column 9',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'10',
                            'label'=>__('column 10',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'11',
                            'label'=>__('column 11',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'12',
                            'label'=>__('column 12',ST_TEXTDOMAIN)
                        ),
                    ),
                ),
                array(
                    'id'=>'layout2_col',
                    'label'=>__('Layout 2 Size',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'std'        =>4,
                    'choices'   =>array(
                        array(
                            'value'=>'1',
                            'label'=>__('column 1',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'2',
                            'label'=>__('column 2',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'3',
                            'label'=>__('column 3',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'4',
                            'label'=>__('column 4',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'5',
                            'label'=>__('column 5',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'6',
                            'label'=>__('column 6',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'7',
                            'label'=>__('column 7',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'8',
                            'label'=>__('column 8',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'9',
                            'label'=>__('column 9',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'10',
                            'label'=>__('column 10',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'11',
                            'label'=>__('column 11',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'12',
                            'label'=>__('column 12',ST_TEXTDOMAIN)
                        ),
                    ),
                ),
                array(
                    'id'=>'taxonomy',
                    'label'=>__('Taxonomy',ST_TEXTDOMAIN),
                    'condition'   => 'name:is(taxonomy)',
                    'operator'=>'or',
                    'type'=>'select',
                    'choices'=>st_get_post_taxonomy('st_hotel')
                )

            )
        ),
//        array(
//            'id'          => 'hotel_allow_search_advance',
//            'label'       => __( 'Allow Search Advance Field', ST_TEXTDOMAIN ),
//            'type'        => 'on-off',
//            'section'     => 'option_hotel',
//            'std'         =>'off'
//        ),
//        array(
//            'id'          => 'hotel_search_advance',
//            'label'       => __( 'Hotel Search Advance', ST_TEXTDOMAIN ),
//            'type'        => 'Slider',
//            'section'     => 'option_hotel',
//            'condition'   => 'hotel_allow_search_advance:is(on)',
//            'settings'    =>array(
//                array(
//                    'id'=>'name',
//                    'label'=>__('Field',ST_TEXTDOMAIN),
//                    'type'=>'select',
//                    'operator'    => 'and',
//                    'choices'     =>STHotel::get_search_fields_name()
//
//                ),
//                array(
//                    'id'=>'layout_col',
//                    'label'=>__('Layout 1 Size',ST_TEXTDOMAIN),
//                    'type'=>'select',
//                    'operator'    => 'and',
//                    'std'       =>4,
//                    'choices'   =>array(
//                        array(
//                            'value'=>'1',
//                            'label'=>__('column 1',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'2',
//                            'label'=>__('column 2',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'3',
//                            'label'=>__('column 3',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'4',
//                            'label'=>__('column 4',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'5',
//                            'label'=>__('column 5',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'6',
//                            'label'=>__('column 6',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'7',
//                            'label'=>__('column 7',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'8',
//                            'label'=>__('column 8',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'9',
//                            'label'=>__('column 9',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'10',
//                            'label'=>__('column 10',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'11',
//                            'label'=>__('column 11',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'12',
//                            'label'=>__('column 12',ST_TEXTDOMAIN)
//                        ),
//                    ),
//                ),
//                array(
//                    'id'=>'layout2_col',
//                    'label'=>__('Layout 2 Size',ST_TEXTDOMAIN),
//                    'type'=>'select',
//                    'operator'    => 'and',
//                    'std'       =>4,
//                    'choices'   =>array(
//                        array(
//                            'value'=>'1',
//                            'label'=>__('column 1',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'2',
//                            'label'=>__('column 2',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'3',
//                            'label'=>__('column 3',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'4',
//                            'label'=>__('column 4',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'5',
//                            'label'=>__('column 5',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'6',
//                            'label'=>__('column 6',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'7',
//                            'label'=>__('column 7',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'8',
//                            'label'=>__('column 8',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'9',
//                            'label'=>__('column 9',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'10',
//                            'label'=>__('column 10',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'11',
//                            'label'=>__('column 11',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'12',
//                            'label'=>__('column 12',ST_TEXTDOMAIN)
//                        ),
//                    ),
//                ),
//                array(
//                    'id'=>'taxonomy',
//                    'label'=>__('Taxonomy',ST_TEXTDOMAIN),
//                    'choices'=>st_get_post_taxonomy('st_hotel'),
//                    'operator'    => 'and',
//                    'type'              =>'select'
//                ),
//            )
//        ),
        array(
            'id'          => 'hotel_nearby_range',
            'label'       => __( 'Hotel Nearby Range', ST_TEXTDOMAIN ),
            'type'        => 'text',
            'section'     => 'option_hotel',
            'desc'        => __('This allows you to change max range of nearby hotel (in km)',ST_TEXTDOMAIN),
            'std'         =>10
        ),
        array(
            'id'          => 'hotel_unlimited_custom_field',
            'label'       => __( 'Hotel custom field', ST_TEXTDOMAIN ),
            'type'        => 'Slider',
            'section'     => 'option_hotel',
            'desc'        => __('Hotel custom field',ST_TEXTDOMAIN),
            'settings'    =>array(
                array(
                    'id'=>'type_field',
                    'label'=>__('Field type',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'     =>array(
                        array(
                            'value'=>'text',
                            'label'=>__('Text flied',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'date-picker',
                            'label'=>__('Date flied',ST_TEXTDOMAIN)
                        ),
                    )

                ),
                array(
                    'id'=>'default_field',
                    'label'=>__('Default',ST_TEXTDOMAIN),
                    'type'=>'text',
                    'operator'    => 'and'
                ),

            ),
        ),
        /*------------- End Hotel Option --------------*/
        /*------------- Rental Option -----------------*/

        array(
            'id'          => 'rental_single_layout',
            'label'       => __( 'Rental Single Layout', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_rental',
            'choices'     => st_get_layout('st_rental')

        ),array(
            'id'          => 'rental_search_layout',
            'label'       => __( 'Rental Search Layout', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_rental',
            'choices'     => st_get_layout('st_rental')

        ),array(
            'id'          => 'rental_review',
            'label'       => __( 'Enable Review', ST_TEXTDOMAIN ),
            'type'        => 'on-off',
            'section'     => 'option_rental',
            'std'         =>'on'

        ),
//        array(
//            'id'          => 'rental_check_review_admin',
//            'label'       => __( 'Review must be approve by admin', ST_TEXTDOMAIN ),
//            'type'        => 'on-off',
//            'section'     => 'option_rental',
//            'condition'   => 'rental_review:is(on)',
//        ),
        array(
            'id'          => 'rental_review_stats',
            'label'       => __( 'Rental Review Stats', ST_TEXTDOMAIN ),
            'desc'       => __( 'Rental Review Stats', ST_TEXTDOMAIN ),
            'type'        => 'list-item',
            'section'     => 'option_rental',
            'condition'   => 'rental_review:is(on)',
            'settings'    =>array(
                array(
                    'id'=>'name',
                    'label'=>__('Stat Name',ST_TEXTDOMAIN),
                    'type'=>'textblock',
                )
            ),
            'std'         =>array(

                array('title'=>'Sleep'),
                array('title'=>'Location'),
                array('title'=>'Service'),
                array('title'=>'Clearness'),
                array('title'=>'Rooms'),
            )
        ),
        array(
            'id'          => 'rental_sidebar_pos',
            'label'       => __( 'Sidebar Position', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_rental',
            'choices'   =>array(
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

            ),
            'std'=>'left'

        ),
        array(
            'id'          => 'rental_sidebar_area',
            'label'       => __( 'Sidebar Area', ST_TEXTDOMAIN ),
            'type'        => 'sidebar-select',
            'section'     => 'option_rental',
            'std'         =>'rental-sidebar'

        ),
        array(
            'id'            =>'is_featured_search_rental',
            'label'         =>__('Feature only top search',ST_TEXTDOMAIN),
            'type'          =>'on-off',
            'std'           =>'off',
            'section'       =>'option_rental'
        ),
        array(
            'id'          => 'rental_search_fields',
            'label'       => __( 'Rental Search Fields', ST_TEXTDOMAIN ),
            'type'        => 'Slider',
            'section'     => 'option_rental',
            'settings'    =>array(
                array(
                    'id'=>'name',
                    'label'=>__('Field name',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'            =>STRental::get_search_fields_name()
                ),
                array(
                    'id'=>'layout_col',
                    'label'=>__('Large-box column size',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'   =>array(
                        array(
                            'value'=>'1',
                            'label'=>__('column 1',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'2',
                            'label'=>__('column 2',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'3',
                            'label'=>__('column 3',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'4',
                            'label'=>__('column 4',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'5',
                            'label'=>__('column 5',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'6',
                            'label'=>__('column 6',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'7',
                            'label'=>__('column 7',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'8',
                            'label'=>__('column 8',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'9',
                            'label'=>__('column 9',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'10',
                            'label'=>__('column 10',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'11',
                            'label'=>__('column 11',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'12',
                            'label'=>__('column 12',ST_TEXTDOMAIN)
                        ),
                    ),
                ),
                array(
                    'id'=>'layout_col2',
                    'label'=>__('Small-box column size',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'   =>array(
                        array(
                            'value'=>'1',
                            'label'=>__('column 1',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'2',
                            'label'=>__('column 2',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'3',
                            'label'=>__('column 3',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'4',
                            'label'=>__('column 4',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'5',
                            'label'=>__('column 5',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'6',
                            'label'=>__('column 6',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'7',
                            'label'=>__('column 7',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'8',
                            'label'=>__('column 8',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'9',
                            'label'=>__('column 9',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'10',
                            'label'=>__('column 10',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'11',
                            'label'=>__('column 11',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'12',
                            'label'=>__('column 12',ST_TEXTDOMAIN)
                        ),
                    ),
                ),
                array(
                    'id'=>'taxonomy',
                    'label'=>__('Taxonomy',ST_TEXTDOMAIN),
                    'condition'   => 'name:is(taxonomy)',
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'    =>st_get_post_taxonomy('st_rental')
                ),
            ),
            'std'               =>array(
                array(
                    'title'       =>'Where are you going?',
                    'name'        =>'location',
                    'layout_col'  =>'4',
                    'layout_col2' =>'12'
                ),
                array(
                    'title'       =>'Check in',
                    'name'        =>'checkin',
                    'layout_col'  =>'2',
                    'layout_col2' =>'3'
                ),
                array(
                    'title'       =>'Check out',
                    'name'        =>'checkout',
                    'layout_col'  =>'2',
                    'layout_col2' =>'3'
                ),
                array(
                    'title'       =>'Rooms',
                    'name'        =>'room_num',
                    'layout_col'  =>'2',
                    'layout_col2' =>'3'
                ),
                array(
                    'title'       =>'Adults',
                    'name'        =>'adult',
                    'layout_col'  =>'2',
                    'layout_col2' =>'3'
                )
            )
        ),
//        array(
//            'id'          => 'rental_allow_search_advance',
//            'label'       => __( 'Allow Search Advance Field', ST_TEXTDOMAIN ),
//            'type'        => 'on-off',
//            'section'     => 'option_rental',
//        ),
//        array(
//            'id'          => 'rental_search_advance',
//            'label'       => __( 'Rental Search Advance', ST_TEXTDOMAIN ),
//            'type'        => 'Slider',
//            'section'     => 'option_rental',
//            'condition'   => 'rental_allow_search_advance:is(on)',
//            'settings'    =>array(
//                array(
//                    'id'=>'name',
//                    'label'=>__('Field name',ST_TEXTDOMAIN),
//                    'type'=>'select',
//                    'operator'    => 'and',
//                    'choices'               =>STRental::get_search_fields_name()
//                ),
//                array(
//                    'id'=>'layout_col',
//                    'label'=>__('Large-box Column',ST_TEXTDOMAIN),
//                    'type'=>'select',
//                    'operator'    => 'and',
//                    'choices'   =>array(
//                        array(
//                            'value'=>'1',
//                            'label'=>__('column 1',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'2',
//                            'label'=>__('column 2',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'3',
//                            'label'=>__('column 3',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'4',
//                            'label'=>__('column 4',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'5',
//                            'label'=>__('column 5',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'6',
//                            'label'=>__('column 6',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'7',
//                            'label'=>__('column 7',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'8',
//                            'label'=>__('column 8',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'9',
//                            'label'=>__('column 9',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'10',
//                            'label'=>__('column 10',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'11',
//                            'label'=>__('column 11',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'12',
//                            'label'=>__('column 12',ST_TEXTDOMAIN)
//                        ),
//                    ),
//                ),
//                array(
//                    'id'=>'layout_col2',
//                    'label'=>__('Small-box Column',ST_TEXTDOMAIN),
//                    'type'=>'select',
//                    'operator'    => 'and',
//                    'choices'   =>array(
//                        array(
//                            'value'=>'1',
//                            'label'=>__('column 1',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'2',
//                            'label'=>__('column 2',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'3',
//                            'label'=>__('column 3',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'4',
//                            'label'=>__('column 4',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'5',
//                            'label'=>__('column 5',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'6',
//                            'label'=>__('column 6',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'7',
//                            'label'=>__('column 7',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'8',
//                            'label'=>__('column 8',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'9',
//                            'label'=>__('column 9',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'10',
//                            'label'=>__('column 10',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'11',
//                            'label'=>__('column 11',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'=>'12',
//                            'label'=>__('column 12',ST_TEXTDOMAIN)
//                        ),
//                    ),
//                ),
//                array(
//                    'id'=>'taxonomy',
//                    'label'=>__('taxonomy',ST_TEXTDOMAIN),
//                    'type'=>'select',
//                    'operator'    => 'and',
//                    'choices'   =>st_get_post_taxonomy('rental')
//
//                ),
//            )
//        ),
//        array(
//            'id'                =>'rental_custom_fields',
//            'label'             =>__('Custom Fields',ST_TEXTDOMAIN),
//            'type'              =>'list-item',
//            'section'           =>'option_rental',
//            'desc'              =>__('This allows use add unlimited custom fields to rental',ST_TEXTDOMAIN),
//            'settings'          =>array(
//                array(
//                    'id'            =>"field_name",
//                    'label'         =>__('Field Name',ST_TEXTDOMAIN),
//                    'type'          =>'text',
//                    'desc'          =>__('Please use uppercase with dash. Ex:"rental_built_in"',ST_TEXTDOMAIN)
//                ),
//                array(
//                    'id'            =>"field_type",
//                    'label'         =>__('Field Type',ST_TEXTDOMAIN),
//                    'type'          =>'select',
//                    'choices'       =>array(
//                        array(
//                            'value'     =>'text',
//                            'label'     =>__('Text',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'     =>'textarea',
//                            'label'     =>__('Textarea',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'     =>'date',
//                            'label'     =>__('Date',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'     =>'colorpicker',
//                            'label'     =>__('Colorpicker',ST_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'     =>'on-off',
//                            'label'     =>__('On/Off',ST_TEXTDOMAIN)
//                        ),
//                    )
//
//                ),
//                array(
//                    'id'        =>'icon',
//                    'label'     =>__('Icon',ST_TEXTDOMAIN),
//                    'desc'     =>__('Custom Icon for this field',ST_TEXTDOMAIN),
//                    'type'      =>'text'
//                ),
//                array(
//                    'id'        =>'show_in_list',
//                    'label'     =>__('Show in list',ST_TEXTDOMAIN),
//                    'desc'     =>__('Show in list',ST_TEXTDOMAIN),
//                    'type'      =>'on-off',
//                    'std'       =>'on'
//                )
//
//            ),
//            'std'               =>array(
//                array(
//                    'title'     =>__('Adults',ST_TEXTDOMAIN),
//                    'field_type'    =>'text',
//                    'field_name'    =>'_rental_adult',
//                    'icon'          =>'fa-male',
//                    'show_in_list'  =>'on'
//                ),
//                array(
//                    'title'     =>__('Bedrooms',ST_TEXTDOMAIN),
//                    'field_type'    =>'text',
//                    'field_name'    =>'_rental_bedrooms',
//                    'icon'          =>'im-bed',
//                    'show_in_list'  =>'on'
//                ),
//                array(
//                    'title'     =>__('Bathrooms',ST_TEXTDOMAIN),
//                    'field_type'    =>'text',
//                    'field_name'    =>'_rental_bathrooms',
//                    'icon'          =>'im-shower',
//                    'show_in_list'  =>'on'
//                ),
//            )
//        ),
        array(
            'id'          => 'rental_unlimited_custom_field',
            'label'       => __( 'Rental custom field', ST_TEXTDOMAIN ),
            'type'        => 'Slider',
            'section'     => 'option_rental',
            'desc'        => __('Rental custom field',ST_TEXTDOMAIN),
            'settings'    =>array(
                array(
                    'id'=>'type_field',
                    'label'=>__('Field type',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'     =>array(
                        array(
                            'value'=>'text',
                            'label'=>__('Text flied',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'date-picker',
                            'label'=>__('Date flied',ST_TEXTDOMAIN)
                        ),
                    )

                ),
                array(
                    'id'=>'default_field',
                    'label'=>__('Default',ST_TEXTDOMAIN),
                    'type'=>'text',
                    'operator'    => 'and'
                ),

            ),
        ),

        /*------------ End Rental Option --------------*/

        /*------------- Cars Option -----------------*/


        array(
            'id'          => 'cars_single_layout',
            'label'       => __( 'Cars Single Layout', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_car',
            'choices'     => st_get_layout('st_cars')
        ),
        array(
            'id'          => 'cars_layout_layout',
            'label'       => __( 'Cars Search Layout', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_car',
            'choices'     => st_get_layout('st_cars')

        ),
        array(
            'id'          =>'cars_price_unit',
            'label'       =>__('Price Unit',ST_TEXTDOMAIN),
            'type'        =>'select',
            'section'     =>'option_car',
            'choices'     =>STCars::get_option_price_unit(),
            'std'         =>'day'
        ),
        array(
            'id'            =>'is_featured_search_car',
            'label'         =>__('Feature only top search',ST_TEXTDOMAIN),
            'type'          =>'on-off',
            'std'           =>'off',
            'section'       =>'option_car'
        ),
        array(
            'id'          => 'car_search_fields',
            'label'       => __( 'Car Search Fields', ST_TEXTDOMAIN ),
            'desc'       => __( 'Car Search Fields', ST_TEXTDOMAIN ),
            'type'        => 'Slider',
            'section'     => 'option_car',
            'settings'    =>array(
                array(
                    'id'=>'layout_col_normal',
                    'label'=>__('Layout Normal size',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'   =>array(
                        array(
                            'value'=>'1',
                            'label'=>__('column 1',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'2',
                            'label'=>__('column 2',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'3',
                            'label'=>__('column 3',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'4',
                            'label'=>__('column 4',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'5',
                            'label'=>__('column 5',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'6',
                            'label'=>__('column 6',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'7',
                            'label'=>__('column 7',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'8',
                            'label'=>__('column 8',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'9',
                            'label'=>__('column 9',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'10',
                            'label'=>__('column 10',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'11',
                            'label'=>__('column 11',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'12',
                            'label'=>__('column 12',ST_TEXTDOMAIN)
                        ),
                    ),
                ),
                array(
                    'id'=>'field_atrribute',
                    'label'=>__('Field Atrribute',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'     =>STCars::get_search_fields_name()
                ),
                array(
                    'id'=>'taxonomy',
                    'label'=>__('Taxonomy',ST_TEXTDOMAIN),
                    'condition'   => 'field_atrribute:is(taxonomy)',
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'    =>st_get_post_taxonomy('st_cars')
                ),
            ),
            'std'           =>array(
                array('title'=>'Pick-up-From','layout_col_normal'=>6,'field_atrribute'=>'pick-up-form'),
                array('title'=>'Drop-off To','layout_col_normal'=>6,'field_atrribute'=>'drop-off-to'),
                array('title'=>'Pick-up Date ,Pick-up Time','layout_col_normal'=>6,'field_atrribute'=>'pick-up-date-time'),
                array('title'=>'Drop-off Date ,Drop-off Time','layout_col_normal'=>6,'field_atrribute'=>'drop-off-date-time'),
            )
        ),
        array(
            'id'          => 'car_search_fields_box',
            'label'       => __( 'Car Search Fields Box', ST_TEXTDOMAIN ),
            'desc'       => __( 'Car Search Fields Box', ST_TEXTDOMAIN ),
            'type'        => 'Slider',
            'section'     => 'option_car',
            'settings'    =>array(
                array(
                    'id'=>'layout_col_box',
                    'label'=>__('Layout Box size',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'   =>array(
                        array(
                            'value'=>'1',
                            'label'=>__('column 1',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'2',
                            'label'=>__('column 2',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'3',
                            'label'=>__('column 3',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'4',
                            'label'=>__('column 4',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'5',
                            'label'=>__('column 5',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'6',
                            'label'=>__('column 6',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'7',
                            'label'=>__('column 7',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'8',
                            'label'=>__('column 8',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'9',
                            'label'=>__('column 9',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'10',
                            'label'=>__('column 10',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'11',
                            'label'=>__('column 11',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'12',
                            'label'=>__('column 12',ST_TEXTDOMAIN)
                        ),
                    ),
                ),
                array(
                    'id'=>'field_atrribute',
                    'label'=>__('Field Atrribute',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'     =>STCars::get_search_fields_name()
                ),
                array(
                    'id'=>'taxonomy',
                    'label'=>__('Taxonomy',ST_TEXTDOMAIN),
                    'condition'   => 'field_atrribute:is(taxonomy)',
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'    =>st_get_post_taxonomy('st_cars')
                ),
            ),
            'std'           =>array(
                array('title'=>'Pick-up From','layout_col_box'=>6,'field_atrribute'=>'pick-up-form'),
                array('title'=>'Drop-off To','layout_col_box'=>6,'field_atrribute'=>'drop-off-to'),
                array('title'=>'Pick-up Date','layout_col_box'=>3,'field_atrribute'=>'pick-up-date'),
                array('title'=>'Pick-up Time','layout_col_box'=>3,'field_atrribute'=>'pick-up-time'),
                array('title'=>'Drop-off Date','layout_col_box'=>3,'field_atrribute'=>'drop-off-date'),
                array('title'=>'Drop-off Time','layout_col_box'=>3,'field_atrribute'=>'drop-off-time'),

            )
        ),
        array(
            'id'          => 'st_cars_unlimited_custom_field',
            'label'       => __( 'Cars custom field', ST_TEXTDOMAIN ),
            'type'        => 'Slider',
            'section'     => 'option_car',
            'desc'        => __('Cars custom field',ST_TEXTDOMAIN),
            'settings'    =>array(
                array(
                    'id'=>'type_field',
                    'label'=>__('Field type',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'     =>array(
                        array(
                            'value'=>'text',
                            'label'=>__('Text flied',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'date-picker',
                            'label'=>__('Date flied',ST_TEXTDOMAIN)
                        ),
                    )

                ),
                array(
                    'id'=>'default_field',
                    'label'=>__('Default',ST_TEXTDOMAIN),
                    'type'=>'text',
                    'operator'    => 'and'
                ),

            ),
        ),

        /*------------ End Car Option --------------*/



        /*------------ Begin Email Option --------------*/

//        array(
//            'id'          => 'email_enable_to_admin',
//            'label'       => __( 'Enable Email to Administator', ST_TEXTDOMAIN ),
//            'type'        => 'on-off',
//            'section'     => 'option_email',
//            'desc'        =>__('Enable Email to Administator about new Booking',ST_TEXTDOMAIN),
//            'std'         =>'on'
//
//        ),

//        array(
//            'id'          => 'email_subject',
//            'label'       => __( 'Email Subject', ST_TEXTDOMAIN ),
//            'type'        => 'text',
//            'section'     => 'option_email',
//            'desc'        =>__('Email Subject',ST_TEXTDOMAIN),
//
//        ),

        array(
            'id'          => 'email_from',
            'label'       => __( 'Email From Name', ST_TEXTDOMAIN ),
            'desc'       => __( 'Email From Name', ST_TEXTDOMAIN ),
            'type'        => 'text',
            'section'     => 'option_email',
            'std'         =>'Traveler Shinetheme'

        ),array(
            'id'          => 'email_from_address',
            'label'       => __( 'Email From Address', ST_TEXTDOMAIN ),
            'desc'       => __( 'Email From Address', ST_TEXTDOMAIN ),
            'type'        => 'text',
            'section'     => 'option_email',
            'std'        =>'traveler@shinetheme.com'

        )
        ,array(
            'id'          => 'email_logo',
            'label'       => __( 'Logo in Email', ST_TEXTDOMAIN ),
            'type'        => 'upload',
            'section'     => 'option_email',
            'desc'        =>__('Logo in Email',ST_TEXTDOMAIN),
            'std'         =>get_template_directory_uri().'/img/logo.png'

        ),
        array(
            'id'          =>'enable_email_for_custommer',
            'label'       =>__('Email after booking for custommer',ST_TEXTDOMAIN),
            'desc'        =>__('Email after booking for custommer',ST_TEXTDOMAIN),
            'type'        =>'on-off',
            'std'         =>'on',
            'section'     => 'option_email',
        ),
        array(
            'id'          =>'enable_email_for_admin',
            'label'       =>__('Email after booking for Admin',ST_TEXTDOMAIN),
            'desc'        =>__('Email after booking for Admin',ST_TEXTDOMAIN),
            'type'        =>'on-off',
            'std'         =>'on',
            'section'     => 'option_email',
        ),
        array(
            'id'          =>'email_admin_address',
            'label'       =>__('Admin Email Address',ST_TEXTDOMAIN),
            'desc'        =>__('Booking information will be sent to here',ST_TEXTDOMAIN),
            'type'        =>'text',
            'condition'   =>'enable_email_for_admin:is(on)',
            'section'     => 'option_email',
        ),

        array(
            'id'          =>'enable_email_for_owner_item',
            'label'       =>__('Email after booking for Owner Item',ST_TEXTDOMAIN),
            'desc'        =>__('Email after booking for Owner Item',ST_TEXTDOMAIN),
            'type'        =>'on-off',
            'std'         =>'on',
            'section'     => 'option_email',
        ),

        /*------------ End Email Option --------------*/

        /*------------- Activity - Tour Option  -----------------*/

        array(
            'id'          => 'activity_tour_review',
            'label'       => __( 'Enable Review', ST_TEXTDOMAIN ),
            'type'        => 'on-off',
            'section'     => 'option_activity_tour',
            'std'         =>'std'

        ),
        array(
            'id'          => 'tours_layout',
            'label'       => __( 'Tours Layout', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_activity_tour',
            'choices'     => st_get_layout('st_tours')
        ),
        array(
            'id'          => 'tours_search_layout',
            'label'       => __( 'Tours Search Layout', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_activity_tour',
            'choices'     => st_get_layout('st_tours')
        ),
        array(
            'id'          => 'tours_similar_tour',
            'label'       => __( 'Similar Tour display number ', ST_TEXTDOMAIN ),
            'type'        => 'text',
            'section'     => 'option_activity_tour',
            'std'         => '5',
            'desc'        =>__('Similar Tour display number',ST_TEXTDOMAIN)
        ),

        array(
            'id'          => 'activity_tour_check_review_admin',
            'label'       => __( 'Review must be approve by admin', ST_TEXTDOMAIN ),
            'type'        => 'on-off',
            'section'     => 'option_activity_tour',
            'condition'   => 'activity_tour_review:is(on)',
        ),
        array(
            'id'            =>'is_featured_search_tour',
            'label'         =>__('Feature only top search',ST_TEXTDOMAIN),
            'type'          =>'on-off',
            'std'           =>'off',
            'section'       =>'option_activity_tour'
        ),
        array(
            'id'            =>'is_featured_search_tour',
            'label'         =>__('Feature only top search',ST_TEXTDOMAIN),
            'type'          =>'on-off',
            'std'           =>'off',
            'section'       =>'option_activity_tour'
        ),
        array(
            'id'          => 'activity_tour_search_fields',
            'label'       => __( 'Tour Search Fields', ST_TEXTDOMAIN ),
            'desc'        => __( 'Tour Search Fields', ST_TEXTDOMAIN ),
            'type'        => 'Slider',
            'section'     => 'option_activity_tour',
            'settings'    =>array(

                array(
                    'id'=>'layout_col',
                    'label'=>__('Layout 1 size',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'   =>array(
                        array(
                            'value'=>'1',
                            'label'=>__('column 1',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'2',
                            'label'=>__('column 2',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'3',
                            'label'=>__('column 3',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'4',
                            'label'=>__('column 4',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'5',
                            'label'=>__('column 5',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'6',
                            'label'=>__('column 6',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'7',
                            'label'=>__('column 7',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'8',
                            'label'=>__('column 8',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'9',
                            'label'=>__('column 9',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'10',
                            'label'=>__('column 10',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'11',
                            'label'=>__('column 11',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'12',
                            'label'=>__('column 12',ST_TEXTDOMAIN)
                        ),
                    ),
                ),
                array(
                    'id'=>'layout2_col',
                    'label'=>__('Layout 2 Size',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'std'        =>4,
                    'choices'   =>array(
                        array(
                            'value'=>'1',
                            'label'=>__('column 1',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'2',
                            'label'=>__('column 2',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'3',
                            'label'=>__('column 3',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'4',
                            'label'=>__('column 4',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'5',
                            'label'=>__('column 5',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'6',
                            'label'=>__('column 6',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'7',
                            'label'=>__('column 7',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'8',
                            'label'=>__('column 8',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'9',
                            'label'=>__('column 9',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'10',
                            'label'=>__('column 10',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'11',
                            'label'=>__('column 11',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'12',
                            'label'=>__('column 12',ST_TEXTDOMAIN)
                        ),
                    ),
                ),
                array(
                    'id'=>'tours_field_search',
                    'label'=>__('Field Atrribute',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'   =>STTour::get_search_fields_name(),
                ),
                array(
                    'id'=>'taxonomy',
                    'label'=>__('Taxonomy',ST_TEXTDOMAIN),
                    'condition'   => 'tours_field_search:is(taxonomy)',
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'    =>st_get_post_taxonomy('st_tours')
                ),
            ),
            'std'         =>array(
                array('title'=>'Address','layout_col'=>6,'layout2_col'=>6,'tours_field_search'=>'address'),
                array('title'=>'Departure date','layout_col'=>3,'layout2_col'=>3,'tours_field_search'=>'check_in'),
                array('title'=>'Arrive date','layout_col'=>3,'layout2_col'=>3,'tours_field_search'=>'check_out'),
            )
        ),
        array(
            'id'          => 'tours_unlimited_custom_field',
            'label'       => __( 'Tours custom field', ST_TEXTDOMAIN ),
            'type'        => 'Slider',
            'section'     => 'option_activity_tour',
            'desc'        => __('Tours custom field',ST_TEXTDOMAIN),
            'settings'    =>array(
                array(
                    'id'=>'type_field',
                    'label'=>__('Field type',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'     =>array(
                        array(
                            'value'=>'text',
                            'label'=>__('Text flied',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'date-picker',
                            'label'=>__('Date flied',ST_TEXTDOMAIN)
                        ),
                    )

                ),
                array(
                    'id'=>'default_field',
                    'label'=>__('Default',ST_TEXTDOMAIN),
                    'type'=>'text',
                    'operator'    => 'and'
                ),

            ),
        ),

        /*------------- Activity - Tour Option  -----------------*/

        /*------------- Activity Option  -----------------*/

        array(
            'id'          => 'activity_review',
            'label'       => __( 'Enable Review', ST_TEXTDOMAIN ),
            'type'        => 'on-off',
            'section'     => 'option_activity',
            'std'         =>'std'

        ),

        array(
            'id'          => 'activity_layout',
            'label'       => __( 'Activity Layout', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_activity',
            'choices'     => st_get_layout('st_activity')
        ),
        array(
            'id'          => 'activity_search_layout',
            'label'       => __( 'Activity Search Layout', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_activity',
            'choices'     => st_get_layout('st_activity')
        ),
        array(
            'id'            =>'is_featured_search_activity',
            'label'         =>__('Feature only top search',ST_TEXTDOMAIN),
            'type'          =>'on-off',
            'std'           =>'off',
            'section'       =>'option_activity'
        ),
        array(
            'id'          => 'activity_search_fields',
            'label'       => __( 'Activity Search Fields', ST_TEXTDOMAIN ),
            'type'        => 'Slider',
            'section'     => 'option_activity',
            'settings'    =>array(

                array(
                    'id'=>'layout_col',
                    'label'=>__('Layout 1 size',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'   =>array(
                        array(
                            'value'=>'1',
                            'label'=>__('column 1',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'2',
                            'label'=>__('column 2',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'3',
                            'label'=>__('column 3',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'4',
                            'label'=>__('column 4',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'5',
                            'label'=>__('column 5',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'6',
                            'label'=>__('column 6',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'7',
                            'label'=>__('column 7',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'8',
                            'label'=>__('column 8',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'9',
                            'label'=>__('column 9',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'10',
                            'label'=>__('column 10',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'11',
                            'label'=>__('column 11',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'12',
                            'label'=>__('column 12',ST_TEXTDOMAIN)
                        ),
                    ),
                ),
                array(
                    'id'=>'layout2_col',
                    'label'=>__('Layout 2 Size',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'std'        =>4,
                    'choices'   =>array(
                        array(
                            'value'=>'1',
                            'label'=>__('column 1',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'2',
                            'label'=>__('column 2',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'3',
                            'label'=>__('column 3',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'4',
                            'label'=>__('column 4',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'5',
                            'label'=>__('column 5',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'6',
                            'label'=>__('column 6',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'7',
                            'label'=>__('column 7',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'8',
                            'label'=>__('column 8',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'9',
                            'label'=>__('column 9',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'10',
                            'label'=>__('column 10',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'11',
                            'label'=>__('column 11',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'12',
                            'label'=>__('column 12',ST_TEXTDOMAIN)
                        ),
                    ),
                ),
                array(
                    'id'=>'activity_field_search',
                    'label'=>__('Field Atrribute',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'   =>STActivity::get_search_fields_name()
                ),
                array(
                    'id'=>'taxonomy',
                    'label'=>__('Taxonomy',ST_TEXTDOMAIN),
                    'condition'   => 'activity_field_search:is(taxonomy)',
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'    =>st_get_post_taxonomy('st_activity')
                ),
            ),
            'std'         =>array(
                array('title'=>'Address','layout_col'=>3,'layout2_col'=>6,'activity_field_search'=>'address'),
                array('title'=>'From','layout_col'=>3,'layout2_col'=>3,'activity_field_search'=>'check_in'),
                array('title'=>'To','layout_col'=>3,'layout2_col'=>3,'activity_field_search'=>'check_out'),
            )
        ),
        array(
            'id'          => 'st_activity_unlimited_custom_field',
            'label'       => __( 'Activity custom field', ST_TEXTDOMAIN ),
            'type'        => 'Slider',
            'section'     => 'option_activity',
            'desc'        => __('Activity custom field',ST_TEXTDOMAIN),
            'settings'    =>array(
                array(
                    'id'=>'type_field',
                    'label'=>__('Field type',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'operator'    => 'and',
                    'choices'     =>array(
                        array(
                            'value'=>'text',
                            'label'=>__('Text flied',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'date-picker',
                            'label'=>__('Date flied',ST_TEXTDOMAIN)
                        ),
                    )

                ),
                array(
                    'id'=>'default_field',
                    'label'=>__('Default',ST_TEXTDOMAIN),
                    'type'=>'text',
                    'operator'    => 'and'
                ),
            ),
        ),


        /*------------- Activity  Option  -----------------*/

        /*------------- Option Partner Option --------------------*/

        array(
            'id'          => 'partner_enable_feature',
            'label'       => __( 'Enable Partner Feature', ST_TEXTDOMAIN ),
            'type'        => 'on-off',
            'section'     => 'option_partner',
            'std'         =>'off',
        ),
        array(
            'id'          => 'partner_post_by_admin',
            'label'       => __( 'Partner\'s Post must be aprroved by admin', ST_TEXTDOMAIN ),
            'type'        => 'on-off',
            'section'     => 'option_partner',
            'std'         =>'on'
        ),
        array(
            'id'          => 'list_partner',
            'label'       => __( 'List Partner', ST_TEXTDOMAIN ),
            'type'        => 'list-item',
            'section'     => 'option_partner',
            'std'         =>'on',
            'settings'    =>array(
                array(
                    'id'=>'id_partner',
                    'label'=>__('Select Partner',ST_TEXTDOMAIN),
                    'type'=>'select',
                    'desc'=>__('Select Partner',ST_TEXTDOMAIN),
                    'choices'   =>array(
                        array(
                            'value'=>'hotel',
                            'label'=>__('Hotel',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'rental',
                            'label'=>__('Rental',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'car',
                            'label'=>__('Car',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'tour',
                            'label'=>__('Tour',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'activity',
                            'label'=>__('Activity',ST_TEXTDOMAIN)
                        ),
                    )
                )
            ),
            'std'           =>array(
                array(
                    'title'             =>'Hotel',
                    'id_partner'         =>'hotel',
                ),
                array(
                    'title'             =>'Rental',
                    'id_partner'         =>'rental',
                ),
                array(
                    'title'             =>'Car',
                    'id_partner'         =>'car',
                ),
                array(
                    'title'             =>'Tour',
                    'id_partner'         =>'tour',
                ),
                array(
                    'title'             =>'Activity',
                    'id_partner'         =>'activity',
                ),

            )
        ),

        /*------------- End Option Partner Option --------------------*/

        /*------------- Search Option -----------------*/
        array(
            'id'          =>'search_enable_preload',
            'label'       =>__('Search enable Preload',ST_TEXTDOMAIN),
            'desc'        =>__('Search enable Preload',ST_TEXTDOMAIN),
            'type'        =>'on-off',
            'section'     =>'option_search'  ,
            'std'         =>'on'
        ),
        array(
            'id'          =>'search_preload_image',
            'label'       =>__('Search Preload Image',ST_TEXTDOMAIN),
            'desc'        =>__('Search Preload Image',ST_TEXTDOMAIN),
            'type'        =>'upload',
            'section'     =>'option_search'  ,
            'condition'   =>'search_enable_preload:is(on)'
        ),
        array(
            'id'          => 'search_results_view',
            'label'       => __( 'Search results default view', ST_TEXTDOMAIN ),
            'type'        => 'select',
            'section'     => 'option_search',
            'desc'        =>__('List view or Grid view',ST_TEXTDOMAIN),
            'choices'     =>array(
                array(
                    'value'=>'list',
                    'label'=>__('List view',ST_TEXTDOMAIN)
                ),
                array(
                    'value'=>'grid',
                    'label'=>__('Grid view',ST_TEXTDOMAIN)
                ),
            )
        ),
//        array(
//            'id'          => 'search_price_range_min',
//            'label'       => __( 'Price Range Min', ST_TEXTDOMAIN ),
//            'type'        => 'text',
//            'section'     => 'option_search',
//            'desc'        => __('Minimum value of price range used in search form (usually 0)',ST_TEXTDOMAIN),
//            'std'         => '0'
//        ),
//        array(
//            'id'          => 'search_price_range_max',
//            'label'       => __( 'Price Range Max', ST_TEXTDOMAIN ),
//            'type'        => 'text',
//            'section'     => 'option_search',
//            'desc'        => __('Maximum value of price range used in search form',ST_TEXTDOMAIN),
//            'std'         => '500'
//        ),
//        array(
//            'id'          => 'search_price_range_step',
//            'label'       => __( 'Price Range Step', ST_TEXTDOMAIN ),
//            'type'        => 'text',
//            'section'     => 'option_search',
//            'desc'        => __('Step value of price range used in search form',ST_TEXTDOMAIN),
//            'std'         => '0'
//        ),
        array(
            'id'          => 'search_tabs',
            'label'       => __( 'Search Tabs:', ST_TEXTDOMAIN ),
            'desc'       => __( 'Search Tabs on home page', ST_TEXTDOMAIN ),
            'type'        => 'list-item',
            'section'     => 'option_search',
            'settings'    =>array(
                array(
                    'id'=>'check_tab',
                    'label'=>__('Show tab',ST_TEXTDOMAIN),
                    'type'=>'on-off',
                    'desc'=>__('',ST_TEXTDOMAIN)
                ),
                array(
                    'id'=>'tab_icon',
                    'label'=>__('Icon',ST_TEXTDOMAIN),
                    'type'=>'text',
                    'desc'=>__('This allows you to change icon next to the title',ST_TEXTDOMAIN)
                ),
                array(
                    'id'=>'tab_search_title',
                    'label'=>__('Form Title',ST_TEXTDOMAIN),
                    'type'=>'text',
                    'desc'=>__('This allows you to change the text above the form',ST_TEXTDOMAIN)
                ),
                array(
                    'id'=>'tab_name',
                    'label'=>__('Choose Tab',ST_TEXTDOMAIN),
                    'type'          =>'select',
                    'choices'       =>array(
                        array(
                            'value'=>'hotel',
                            'label'=>__('Hotel',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'rental',
                            'label'=>__('Rental',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'tour',
                            'label'=>__('Tour',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'cars',
                            'label'=>__('Car',ST_TEXTDOMAIN)
                        ),
                        array(
                            'value'=>'activities',
                            'label'=>__('Activities',ST_TEXTDOMAIN)
                        )
                    )
                )
            ),
            'std'           =>array(
                array(
                    'title'             =>'Hotel',
                    'check_tab'         =>'on',
                    'tab_icon'          =>'fa-building-o',
                    'tab_search_title'  =>'Search and Save on Hotels',
                    'tab_name'          =>'hotel'
                ),
                array(
                    'title'             =>'Cars',
                    'check_tab'         =>'on',
                    'tab_icon'          =>'fa-car',
                    'tab_search_title'  =>'Search for Cheap Rental Cars',
                    'tab_name'          =>'cars'
                ),
                array(
                    'title'             =>'Tours',
                    'check_tab'         =>'on',
                    'tab_icon'          =>'fa-flag-o',
                    'tab_search_title'  =>'Tours',
                    'tab_name'          =>'tour'
                ),
                array(
                    'title'             =>'Rentals',
                    'check_tab'         =>'on',
                    'tab_icon'          =>'fa-home',
                    'tab_search_title'  =>'Find Your Perfect Home',
                    'tab_name'          =>'rental'
                ),
                array(
                    'title'             =>'Activity',
                    'check_tab'         =>'on',
                    'tab_icon'          =>'fa-bolt',
                    'tab_search_title'  =>'Find Your Perfect Activity',
                    'tab_name'          =>'activities'
                ),
            )
        ),
//        array(
//            'id'          => 'search_date_format',
//            'label'       => __( 'Search Date Format', ST_TEXTDOMAIN ),
//            'type'        => 'text',
//            'section'     => 'option_search',
//            'desc'        => __('Read more about date format <a href="http://php.net/manual/en/function.date.php" target="_blank">here</a>',ST_TEXTDOMAIN),
//            'std'         => 'm/d/Y'
//        ),
        /*------------ End Search Option --------------*/


        /*------------- User Option  --------------------*/
        array(
            'id'=>'404_bg',
            'label'=>__('404 Background',ST_TEXTDOMAIN),
            'type'        => 'upload',
            'section'     => 'option_404',
        ),
        array(
            'id'=>'404_text',
            'label'=>__('404 Text',ST_TEXTDOMAIN),
            'type'        => 'textarea',
            'rows'        => '3',
            'section'     => 'option_404',
        )
        /*------------- End User Option  --------------------*/
        /*------------- Begin Social Option  --------------------*/
        ,array(
            'id'            =>'social_fb_login',
            'label'         =>__('Facebook Login',ST_TEXTDOMAIN),
            'type'          =>'on-off',
            'std'           =>'on',
            'section'       =>'option_social'
        )
        ,array(
            'id'            =>'social_gg_login',
            'label'         =>__('Google Login',ST_TEXTDOMAIN),
            'type'          =>'on-off',
            'std'           =>'on',
            'section'       =>'option_social'
        )
        ,array(
            'id'            =>'social_tw_login',
            'label'         =>__('Twitter Login',ST_TEXTDOMAIN),
            'type'          =>'on-off',
            'std'           =>'on',
            'section'       =>'option_social'
        )
        /*------------- End Social Option  --------------------*/
        /*------------- Begin  option_recaptcha Option  --------------------*/
//        ,array(
//            'id'            =>'recaptcha_key',
//            'label'         =>__('reCAPTCHA Site Key',ST_TEXTDOMAIN),
//            'desc'         =>__('reCAPTCHA Site Key',ST_TEXTDOMAIN),
//            'type'          =>'text',
//            'std'           =>'6LfOAAETAAAAAGMpKXOEfaXJAjmQxD8oG7_zrO1w',
//            'section'       =>'option_recaptcha'
//        )
//        ,array(
//            'id'            =>'recaptcha_secretkey',
//            'label'         =>__('reCAPTCHA Secret Key',ST_TEXTDOMAIN),
//            'desc'         =>__('reCAPTCHA Secret Key',ST_TEXTDOMAIN),
//            'type'          =>'text',
//            'std'           =>'6LfOAAETAAAAAOoVLsmhL8a2xR4NUvWRKR2nNGn3',
//            'section'       =>'option_recaptcha'
//        )
        /*------------- End option_recaptcha Option  --------------------*/

        /*----------------Begin Shop ----------------------*/
        ,array(
            'id'            =>'shop_default_list_view',
            'type'          =>'select',
            'label'         =>__("Default List View Style",ST_TEXTDOMAIN),
            'choices'       =>array(
                array(
                    'value'            =>'grid',
                    'label'            =>__('Grid',ST_TEXTDOMAIN)
                ),
                array(
                    'value'            =>'list',
                    'label'            =>__('List',ST_TEXTDOMAIN)
                ),
            ),
            'std'           =>'grid',
            'section'       =>'option_shop'
        ),
        array(
            'id'            =>'shop_sidebar_pos',
            'label'         =>__('Shop Archive Sidebar',ST_TEXTDOMAIN),
            'desc'          =>__('Shop Archive Sidebar',ST_TEXTDOMAIN),
            'type'          =>'select',
            'choices'       =>array(
                array(
                    'label'     =>__('No Sidebar',ST_TEXTDOMAIN),
                    'value'     =>'no'
                ),
                array(
                    'label'     =>__('Left Sidebar',ST_TEXTDOMAIN),
                    'value'     =>'left'
                ),
                array(
                    'label'     =>__('Right Sidebar',ST_TEXTDOMAIN),
                    'value'     =>'right'
                ),

            ),
            'section'       =>'option_shop',
            'std'           =>'left'
        ),
        array(
            'id'            =>'shop_sidebar_id',
            'label'         =>__('Shop Archive Sidebar ID',ST_TEXTDOMAIN),
            'desc'          =>__('Shop Archive Sidebar ID',ST_TEXTDOMAIN),
            'type'          =>'sidebar-select',
            'section'       =>'option_shop',
            'std'           =>'shop'
        ),
        array(
            'id'            =>'shop_single_sidebar_pos',
            'label'         =>__('Product Sidebar',ST_TEXTDOMAIN),
            'desc'          =>__('Product Sidebar',ST_TEXTDOMAIN),
            'type'          =>'select',
            'choices'       =>array(
                array(
                    'label'     =>__('No Sidebar',ST_TEXTDOMAIN),
                    'value'     =>'no'
                ),
                array(
                    'label'     =>__('Left Sidebar',ST_TEXTDOMAIN),
                    'value'     =>'left'
                ),
                array(
                    'label'     =>__('Right Sidebar',ST_TEXTDOMAIN),
                    'value'     =>'right'
                ),

            ),
            'section'       =>'option_shop',
            'std'           =>'left'
        ),
        array(
            'id'            =>'shop_single_sidebar_id',
            'label'         =>__('Product Sidebar ID',ST_TEXTDOMAIN),
            'desc'          =>__('Product Sidebar ID',ST_TEXTDOMAIN),
            'type'          =>'sidebar-select',
            'section'       =>'option_shop',
            'std'           =>'shop'
        )
        /*----------------End Shop ----------------------*/



    )
);
$custom_settings = apply_filters('st_option_tree_settings', $custom_settings);
