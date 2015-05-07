<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STAttribute
 *
 * Created by ShineTheme
 *
 */ 
if(!class_exists('STAttribute'))
{

    class STAttribute extends STAdmin
    {

        private $option_holder_name='st_attribute_taxonomy';

        function __construct()
        {

        }
        function init()
        {
            //Check delete when availabe
            $this->delete_attributes();

            $attr_list=$this->get_attributes();

            if(!empty($attr_list))
            {
                foreach($attr_list as $key=>$value)
                {
                    // Add columns
                    add_filter( 'manage_edit-'.$key.'_columns', array( $this, 'product_cat_columns' ) );
                    add_filter( 'manage_'.$key.'_custom_column', array( $this, 'product_cat_column' ), 10, 3 );
                }
            }


            $this->add_meta_field();

            //Enqueue font Icons

            add_action('admin_enqueue_scripts',array($this,'add_font_icons'));



            //Atribute
            $this->save_attributes();
        }
        function add_font_icons()
        {

            wp_enqueue_style('font-awesome.css',get_template_directory_uri().'/css/font-awesome.css');
            wp_enqueue_style('icomoon.css',get_template_directory_uri().'/css/icomoon.css');
        }



        public function product_cat_column( $columns, $column, $id ) {

            if ( $column == 'icon' ) {

                $icon=get_tax_meta($id,'st_icon');


                $columns .= '<i style="font-size:24px" class="'.TravelHelper::handle_icon($icon).'"></i>';



            }

            return $columns;
        }

        public function product_cat_columns( $columns ) {
            $new_columns          = array();
            $new_columns['cb']    = $columns['cb'];
            $new_columns['icon'] = __( 'Icon', ST_TEXTDOMAIN );

            unset( $columns['cb'] );

            return array_merge( $new_columns, $columns );
        }

        function add_meta_field()
        {

            if (is_admin()){


                $attr_list=$this->get_attributes();

                $pages=array();

                if(!empty($attr_list))
                {
                    foreach($attr_list as $key=>$value)
                    {
                        $pages[]=$key;
                    }
                }

                /*
                 * prefix of meta keys, optional
                 */
                $prefix = 'st_';
                /*
                 * configure your meta box
                 */
                $config = array(
                    'id' => 'st_extra_infomation',          // meta box id, unique per meta box
                    'title' => __('Extra Information',ST_TEXTDOMAIN),          // meta box title
                    'pages' =>$pages,        // taxonomy name, accept categories, post_tag and custom taxonomies
                    'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
                    'fields' => array(),            // list of meta fields (can be added by field arrays)
                    'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
                    'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
                );

                if(!class_exists('Tax_Meta_Class'))
                {
                    STFramework::write_log('Tax_Meta_Class not found in class.attribute.php line 121');
                    return;
                }

                /*
                 * Initiate your meta box
                 */
                $my_meta =  new Tax_Meta_Class($config);

                /*
                 * Add fields to your meta box
                 */

                //text field
                $my_meta->addText($prefix.'icon',array('name'=> __('Icon',ST_TEXTDOMAIN),
                    'desc' => __('Example: <br>Input "fa-desktop" for <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank" >Fontawesome</a>,<br>Input "im-pool" for <a href="https://icomoon.io/" target="_blank">Icomoon</a>  ',ST_TEXTDOMAIN)));

                //Image field
                //$my_meta->addImage($prefix.'image',array('name'=> __('Image ',ST_TEXTDOMAIN),
                // 'desc'=>__('If dont like the icon, you can use image instead',ST_TEXTDOMAIN)));
                //file upload field

                /*
                 * Don't Forget to Close up the meta box decleration
                 */
                //Finish Meta Box Decleration
                $my_meta->Finish();
            }

        }

        function delete_attributes()
        {
            if(isset($_REQUEST['delete']) and $_REQUEST['delete'])
            {
                $tax=$_REQUEST['delete'];
                check_admin_referer('st_delete_attribute_'.$tax);

                $all=$this->get_attributes();

                unset($all[$tax]);

                update_option($this->option_holder_name,$all);
                wp_safe_redirect(admin_url('admin.php?page=hotel_attributes'));
                die;

            }
        }
        function save_attributes()
        {

            //Save Attribute
            if(isset($_REQUEST['st_save_attribute']))
            {
                check_admin_referer('st_save_attribute');

                $action=isset($_REQUEST['edit'])?'edit':'add';

                $all=$this->get_attributes();

                if(is_array($all))
                {
                    $attribute_label   = ( isset( $_POST['attribute_label'] ) )   ? (string) stripslashes( $_POST['attribute_label'] ) : '';
                    $attribute_name    = ( isset( $_POST['attribute_name'] ) )    ?  stripslashes( (string) $_POST['attribute_name'] ) : '';
                    $attribute_type    = ( isset( $_POST['attribute_type'] ) )    ? (string) stripslashes( $_POST['attribute_type'] ) : 0;
                    $attribute_post_type = ( isset( $_POST['attribute_post_type'] ) ) ? $_POST['attribute_post_type']: '';


                    // Auto-generate the label or slug if only one of both was provided
                    if ( ! $attribute_label ) {
                        $attribute_label = ucfirst( $attribute_name );
                    }
                    if ( ! $attribute_name ) {
                        $attribute_name = sanitize_title_with_dashes( stripslashes( $attribute_label  ));
                        $attribute_name=str_replace('-','_',$attribute_name);
                        $attribute_name=mb_strtolower($attribute_name);
                    }elseif($action=='add' or ($action='edit' and !$attribute_name) ){

                        $attribute_name = sanitize_title_with_dashes( stripslashes( $attribute_label  ));
                        $attribute_name=mb_strtolower($attribute_name);
                    }else{
                        $attribute_name=mb_strtolower($attribute_name);
                    }

                    // Forbidden attribute names
                    // http://codex.wordpress.org/Function_Reference/register_taxonomy#Reserved_Terms
                    $reserved_terms = array(
                        'attachment', 'attachment_id', 'author', 'author_name', 'calendar', 'cat', 'category', 'category__and',
                        'category__in', 'category__not_in', 'category_name', 'comments_per_page', 'comments_popup', 'cpage', 'day',
                        'debug', 'error', 'exact', 'feed', 'hour', 'link_category', 'm', 'minute', 'monthnum', 'more', 'name',
                        'nav_menu', 'nopaging', 'offset', 'order', 'orderby', 'p', 'page', 'page_id', 'paged', 'pagename', 'pb', 'perm',
                        'post', 'post__in', 'post__not_in', 'post_format', 'post_mime_type', 'post_status', 'post_tag', 'post_type',
                        'posts', 'posts_per_archive_page', 'posts_per_page', 'preview', 'robots', 's', 'search', 'second', 'sentence',
                        'showposts', 'static', 'subpost', 'subpost_id', 'tag', 'tag__and', 'tag__in', 'tag__not_in', 'tag_id',
                        'tag_slug__and', 'tag_slug__in', 'taxonomy', 'tb', 'term', 'type', 'w', 'withcomments', 'withoutcomments', 'year',
                    );

                    // Error checking
                    if ( ! $attribute_name || ! $attribute_label ) {
                        $error = __( 'Please, provide an attribute name, slug and type.', ST_TEXTDOMAIN );
                    } elseif ( strlen( $attribute_name ) >= 28 ) {
                        $error = sprintf( __( 'Slug “%s” is too long (28 characters max). Shorten it, please.', ST_TEXTDOMAIN ), sanitize_title( $attribute_name ) );
                    } elseif ( in_array( $attribute_name, $reserved_terms ) ) {
                        $error = sprintf( __( 'Slug “%s” is not allowed because it is a reserved term. Change it, please.', ST_TEXTDOMAIN ), sanitize_title( $attribute_name ) );
                    } else {

                        $taxonomy_exists = taxonomy_exists(  $attribute_name  );

                        if ( 'add' === $action && $taxonomy_exists ) {
                            $error = sprintf( __( 'Slug “%s” is already in use. Change it, please.', ST_TEXTDOMAIN ), sanitize_title( $attribute_name ) );
                        }
                        if ( 'edit' === $action ) {
                            $old_attribute_name=$_GET['edit'];
                            if ( $old_attribute_name != $attribute_name &&  $old_attribute_name  != $attribute_name && $taxonomy_exists ) {
                                $error = sprintf( __( 'Slug “%s” is already in use. Change it, please.', ST_TEXTDOMAIN ), sanitize_title( $attribute_name ) );
                            }
                        }

                        if(!isset($error) or !$error)
                        {

                            $all[$attribute_name]=array(
                                'name'=>$attribute_label,
                                'post_type'=>$attribute_post_type,
                                'hierarchical'=>absint((int)$attribute_type)

                            );
                            update_option($this->option_holder_name,$all);
                        }

                        if(isset($error) and $error)
                        {
                            wp_die($error);
                        }

                    }

                    if(isset($error) and $error)
                    {
                        wp_die($error);
                    }
                }


            }
        }




        function get_attributes()
        {
            return get_option($this->option_holder_name,array());
        }

        function content()
        {
            if(isset($_GET['edit']) and $_GET['edit'])
            {
                $tax=$_GET['edit'];
                $all=$this->get_attributes();

                if(isset($all[$tax]))
                {
                    $all[$tax]['tax']=$tax;
                    return $this->load_view('attributes/edit',false,array('row'=>$all[$tax]));

                }else{

                    wp_safe_redirect(admin_url('admin.php?page=hotel_attributes'));
                    die;
                }


            }

            return $this->load_view('attributes/index');

        }

        function find_attribute($attr,$return_type='bool')
        {
            $all=$this->get_attributes();

            switch($return_type)
            {
                case "bool":
                    if(isset($all[$attr])) return true; return false;
                    break;

                case "array";
                    return isset($all[$attr])?$all[$attr]:array();
                    break;
            }
        }
    }

    $a=new STAttribute();
    $a->init();
}