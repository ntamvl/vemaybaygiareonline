<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 11/24/14
 * Time: 8:58 AM
 */
class STCustomOptiontree
{
    public  $url;
    public $dir;

    function __construct()
    {

        $this->dir=st()->dir('plugins/custom-option-tree');
        $this->url=st()->url('plugins/custom-option-tree');


        add_action('admin_enqueue_scripts',array($this,'add_scripts'));
    }

    function init()
    {


        if( !class_exists( 'OT_Loader' ) ) return false;


        //Default Fields
        add_filter( 'ot_post_select_ajax_unit_types', array($this,'ot_post_select_ajax_unit_types'), 10, 2 );


        add_filter( 'ot_option_types_array', array($this,'ot_add_custom_option_types') );
        add_action('wp_ajax_st_post_select_ajax',array($this,'st_post_select_ajax'));


        //Extra Fields

        $files= array_filter(glob($this->dir.'/fields/*'), 'is_file');

        if(!empty($files))
        {
            foreach($files as $key=>$value)
            {
               include_once $value;
            }
        }

        //Custom CSS Output
        include_once $this->dir.'/custom-css-output.php';

    }

    function add_scripts()
    {
        wp_register_script('select2',$this->url.'/js/select2-3.5.2/select2.min.js',array('jquery'),null,true);
        wp_register_style('select2',$this->url.'/js/select2-3.5.2/select2.css');
    }
    function st_post_select_ajax()
    {

        if(!current_user_can('edit_pages')) return;

        $result=array(
            'total_count'=>0,
            'items'=>array(),
        );

        $q=STInput::get('q');
        $post_type=STInput::get('post_type');

        if($q)
        {
            if(!$post_type) $post_type='st_hotel';
            query_posts(array(
                'post_type'=>$post_type,
                'posts_per_page'=>20,
                's'=>$q
            ));

            while(have_posts())
            {
                the_post();
                $result['items'][]=array(
                    'id'=>get_the_ID(),
                    'name'=>get_the_title(),
                    'description'=>"ID: ".get_the_ID()
                );

            }

            global $wp_query;

            $result['total_count']=$wp_query->found_posts;

            wp_reset_query();
        }

        echo json_encode($result);
        die();

    }

    function ot_post_select_ajax_unit_types($array, $id )
    {
        return apply_filters( 'post_select_ajax', $array, $id );
    }

    function ot_add_custom_option_types( $types ) {
        $types['post_select_ajax']       = __('Post Select Ajax',ST_TEXTDOMAIN);

        return $types;
    }




}


$a=new STCustomOptiontree();
$a->init();


if(!function_exists('ot_type_post_select_ajax')):
function ot_type_post_select_ajax($args = array())
{
    $st_custom_ot=new STCustomOptiontree();

    $url=$st_custom_ot->url;

    wp_enqueue_script('st_post_select_ajax',$url.'/js/st_post_select_ajax.js',array('select2'),null,true);
    wp_enqueue_style('st_post_select_ajax',$url.'/css/post_select_ajax.css',array('select2'));


    $default=array(

        'field_post_type'=>'st_hotel',
        'field_desc'=>__('Search for a Item',ST_TEXTDOMAIN)
    );



    $args=wp_parse_args($args,$default);


    extract($args);

    $post_type=$field_post_type;

    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-post_select_ajax ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
    /* description */
    echo balanceTags($has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '');
    /* format setting inner wrapper */
        echo '<div class="format-setting-inner">';
        /* allow fields to be filtered */
        $post_select_ajax = apply_filters( 'ot_recognized_post_select_ajax_fields', $field_value, $field_id );

            $pl_name='';
            $pl_desc='';
            if($field_value)
            {
                $pl_name=get_the_title($field_value);
                $pl_desc="ID: ".get_the_ID($field_value);
            }

            $post_type_json=$post_type;

            echo '<div class="option-tree-ui-post_select_ajax-input-wrap">';
            echo "<input data-pl-name='{$pl_name}' data-pl-desc='{$pl_desc}' data-placeholder='{$field_desc}' value='{$field_value}' data-post-type='{$post_type_json}' type=hidden class='st_post_select_ajax' id='". esc_attr( $field_id ) . "' name='". esc_attr( $field_name ) ."'/>";
            echo '</div>';
        echo '</div>';
    echo '</div>';
}
endif;