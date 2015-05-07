<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * List all function helper
 *
 * Created by ShineTheme
 *
 */
if(!function_exists('st_hex2rgb')){

    function st_hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }
}
if(!function_exists('st_get_list_taxonomy_id'))
{
    function st_get_list_taxonomy_id($tax = 'category', $array = array())
    {

        $taxonomies = get_terms($tax, $array);

        $r = array();

        $r[__('All Categories', ST_TEXTDOMAIN)] = 0;


        if (!is_wp_error($taxonomies)) {

            foreach ($taxonomies as $key => $value) {
                # code...
                $r[$value->name] = $value->term_id;
            }
        }

        return $r;
    }
}
if(!function_exists('st_get_list_order_by'))
{
    function st_get_list_order_by($arg = null)
    {
        $list = array(
            __('None', ST_TEXTDOMAIN) => 'none',
            __('ID', ST_TEXTDOMAIN) => 'ID',
            __('Author', ST_TEXTDOMAIN) => 'author',
            __('Title', ST_TEXTDOMAIN) => 'title',
            __('Name', ST_TEXTDOMAIN) => 'name',
            __('Type', ST_TEXTDOMAIN) => 'type',
            __('Date', ST_TEXTDOMAIN) => 'date',
            __('Modified', ST_TEXTDOMAIN) => 'modified',
            __('Parent', ST_TEXTDOMAIN) => 'parent',
            __('Rand', ST_TEXTDOMAIN) => 'rand',
            __('Comment Count', ST_TEXTDOMAIN) => 'comment_count',
        );
        if (!empty($arg) && is_array($arg)) {

            foreach ($arg as $k => $v) {
                $list[$k] = $v;
            }
        }
        return $list;
    }
}


if(!function_exists('st_remove_wpautop'))
{
    function st_remove_wpautop($content){
        if(function_exists('wpb_js_remove_wpautop'))
        {
            $content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
            return do_shortcode( shortcode_unautop( $content) );
        }
    }
}
if(!function_exists('st_paging_nav'))
{
    function st_paging_nav($title = null)
    {

        // Don't print empty markup if there's only one page.
        if ($GLOBALS['wp_query']->max_num_pages < 2) {
            return;
        }
        $paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
        $pagenum_link = html_entity_decode(get_pagenum_link());
        $query_args = array();
        $url_parts = explode('?', $pagenum_link);

        if (isset($url_parts[1])) {
            wp_parse_str($url_parts[1], $query_args);
        }

        $pagenum_link = esc_url(remove_query_arg(array_keys($query_args), $pagenum_link));
        $pagenum_link = trailingslashit($pagenum_link) . '%_%';

        $format = $GLOBALS['wp_rewrite']->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
        $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';

        // Set up paginated links.
        $links = paginate_links(array(
            'base' => $pagenum_link,
            'format' => $format,
            'total' => $GLOBALS['wp_query']->max_num_pages,
            'current' => $paged,
            'mid_size' => 3,
            'add_args' => array_map('urlencode', $query_args),
            'prev_text' => __('&larr; Previous', ST_TEXTDOMAIN),
            'next_text' => __('Next &rarr;', ST_TEXTDOMAIN),
        ));
        if ($links) :
            ?>
            <nav class="navigation paging-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php echo ($title) ?></h1>

                <div class="pagination loop-pagination pagination">
                    <?php echo balanceTags($links); ?>
                </div>
                <!-- .pagination -->
            </nav><!-- .navigation -->
        <?php
        endif;
    }
}
if(!function_exists('st_handle_icon_class'))
{
    function st_handle_icon_class($class)
    {
        $class = ltrim($class);

        //Detech Fontawesome Icon

        if (substr($class, 0, 2) == 'fa') {
            return "fa " . $class;
        }
    }
}
if(!function_exists('st_handle_icon_tag'))
{
    function st_handle_icon_tag($class, $required_handle_class = true, $holder = "i")
    {
        if ($required_handle_class) {
            $class = st_handle_icon_class($class);
        }

        if ($class) {
            return "<" . $holder . ' class="' . $class . '"></' . $holder . '>';
        }
    }
}
if(!function_exists('st_hext2rgb'))
{
    function st_hext2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }
}
if(!function_exists('st_get_profile_avatar'))
{
    function st_get_profile_avatar( $id ,$size){
        $gravatar_me_id = get_user_meta($id, 'st_avatar', true);

        if(!empty($gravatar_me_id)){
            $gravatar_pic_url = wp_get_attachment_image_src($gravatar_me_id, 'full');
            $data_size = array('width'=>$size,'height'=>$size);
            if(!empty($gravatar_pic_url[0]))
            {
                $gravatar_pic_url = '<img alt="avatar" width='.$size.' height='.$size.' src="'.bfi_thumb($gravatar_pic_url[0],$data_size).'" class="avatar avatar-96 photo origin round" >';
            }else{
                $gravatar_pic_url = get_avatar($id,$size);
            }
        }else{
            $gravatar_pic_url = get_avatar($id,$size);
        }
        return $gravatar_pic_url;
    }
}



if(!function_exists('st_breadcrumbs'))
{
    function st_breadcrumbs()
    {

        global $post;
        $sep=' > ';

        if (!is_home()) {
            echo '<li><a href="'.home_url().'">'.st_get_language('home').'</a></li>';

            if (is_category() || is_single()) {
                $cats = get_the_category($post->ID);
                foreach ($cats as $cat) {
                    echo '<li><a href="#">'.balanceTags($cat->cat_name).'</a></li>';
                }
                do_action('st_single_breadcrumb',$sep);
                if (is_single()) {
                    echo '<li class="active">'.get_the_title().'</li>';
                }
            } elseif (is_page()) {
                if ($post->post_parent) {
                    $anc = get_post_ancestors($post->ID);
                    $anc_link = get_page_link($post->post_parent);

                    foreach ($anc as $ancestor) {
                        $output =  '<li><a href="'.$anc_link.'">'.get_the_title($ancestor).'</a></li>';
                    }
                    echo balanceTags($output);
                    echo '<li class="active">'.get_the_title().'</li>';
                } else {
                    echo '<li class="active">'.get_the_title().'</li>';
                }
            }elseif (is_search()) {
                $s = STInput::get('s');
                if( !empty($_REQUEST['location_id']) ){
                    $location_id = $_REQUEST['location_id'];
                    $parent = array_reverse(get_post_ancestors($location_id));

                    foreach($parent as $k=>$v){
                        // $url = TravelHelper::bui
                        $post_type = STInput::request('post_type');
                        echo '<li><a href="'.home_url('?s='.STInput::request('s').'&post_type='.$post_type.'&location_id='.$v).'">'.get_the_title($v).'</a></li>';
                    }
                    echo '<li class="active">'.get_the_title($location_id).'</li>';
                }else if(!empty($_REQUEST['pick-up'])){
                    $s = $_REQUEST['pick-up'];
                    echo '<li class="active">'.st_get_language('search_results').'</li>';
                    echo esc_html('"'.$s.'"');
                }else{
                    echo '<li class="active">'.st_get_language('search_results').esc_html('"'.$s.'"').'</li>';
                }
            }
        } elseif (is_tag()) {
            single_tag_title();
        } elseif (is_day()) {
            echo __("Archive: ", ST_TEXTDOMAIN);
            the_time('F jS, Y');
            echo '</li>';
        } elseif (is_month()) {
            echo __("Archive: ", ST_TEXTDOMAIN);
            the_time('F, Y');
            echo '</li>';
        } elseif (is_year()) {
            echo __("Archive: ", ST_TEXTDOMAIN);
            the_time('Y');
            echo '</li>';
        } elseif (is_author()) {
            echo __("Author's archive: ", ST_TEXTDOMAIN);
            echo '</li>';
        } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
            echo __("Blog Archive: ", ST_TEXTDOMAIN);
            echo '';
        } elseif (is_search()) {
            echo '<li class="active">'.st_get_language('search_results').'</li>';
        }
    }
}
if(!function_exists('st_get_default_image'))
{
    function st_get_default_image()
    {
        return "<img class alt='default-image' src='".get_template_directory_uri().'/img/no-image.png'."'/>";
    }
}

if(!function_exists('st_get_post_taxonomy'))
{
    function st_get_post_taxonomy($post_type='post',$for_ot=true)
    {
        $tax=get_object_taxonomies($post_type,'object');

        $r=array();

        if(!empty($tax))
        {
            foreach($tax as $key=>$value)
            {
                if($for_ot == true){
                    $r[]=array(
                        'value'=>$value->name,
                        'label'=>$value->label
                    );
                }else{
                    $r[]=array(
                        'value'=>$value->name,
                        'label'=>$value->label
                    );
                }

            }
        }
        return $r;
    }
}

if(!function_exists('st_get_link_with_search')){
    function st_get_link_with_search($link=false,$need=array(),$data=array())
    {
        $form_data=array();
        if(!empty($need))
        {
            foreach($need as $key){
                if(isset($data[$key])){
                    $form_data[$key]=$data[$key];
                }
            }
        }

        return esc_url(add_query_arg($form_data,$link));

    }
}


if(!function_exists('st_get_the_excerpt_max_charlength'))
{
    function st_get_the_excerpt_max_charlength($charlength) {
        $excerpt = get_the_excerpt();
        $charlength++;
        $txt ='';
        if ( mb_strlen( $excerpt ) > $charlength ) {
            $subex = mb_substr( $excerpt, 0, $charlength - 5 );
            $exwords = explode( ' ', $subex );
            $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
            if ( $excut < 0 ) {
                $txt .= mb_substr( $subex, 0, $excut );
            } else {
                $txt .= $subex;
            }
            $txt .= '...';
        } else {
            $txt .= $excerpt;
        }
        return $txt;
    }
}
if(!function_exists('st_implode'))
{
    function st_implode($char, $array)
    {
        $r='';
        if(is_array($array) and !empty($array)){
            foreach($array as $val)
            {
                if(is_string($val)){
                    $r.=$val.$char;
                }
            }
        }

        return rtrim($r,$char);
    }
}
if(function_exists('st_is_ajax')==false)
{
    function st_is_ajax()
    {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        }
        {
            return false;
        }
    }
}


if(!function_exists('st_get_language'))
{
    function st_get_language($key)
    {
        if(class_exists('STLanguage')) {
            return STLanguage::st_get_language($key);
        } else{
            global $st_language;
            if(!empty($st_language[$key])){
                return $st_language[$key];
            }else{
                return $key;
            }
        }
    }
}

if(!function_exists('st_the_language'))
{
    function st_the_language($key)
    {
        if(class_exists('STLanguage'))
        {
            STLanguage::st_the_language($key);
        }else
        {
            global $st_language;
            if(!empty($st_language[$key])){
                echo balanceTags($st_language[$key]);
            }else{
                echo balanceTags($key);
            }
        }
    }
}

if(!function_exists('st_dateformat_PHP_to_jQueryUI'))
{
    function st_dateformat_PHP_to_jQueryUI($php_format)
    {
        $SYMBOLS_MATCHING = array(
            // Day
            'd' => 'dd',
            'D' => 'D',
            'j' => 'd',
            'l' => 'DD',
            'N' => '',
            'S' => '',
            'w' => '',
            'z' => 'o',
            // Week
            'W' => '',
            // Month
            'F' => 'MM',
            'm' => 'mm',
            'M' => 'M',
            'n' => 'm',
            't' => '',
            // Year
            'L' => '',
            'o' => '',
            'Y' => 'yy',
            'y' => 'y',
            // Time
            'a' => '',
            'A' => '',
            'B' => '',
            'g' => '',
            'G' => '',
            'h' => '',
            'H' => '',
            'i' => '',
            's' => '',
            'u' => ''
        );
        $jqueryui_format = "";
        $escaping = false;
        for($i = 0; $i < strlen($php_format); $i++)
        {
            $char = $php_format[$i];
            if($char === '\\') // PHP date format escaping character
            {
                $i++;
                if($escaping) $jqueryui_format .= $php_format[$i];
                else $jqueryui_format .= '\'' . $php_format[$i];
                $escaping = true;
            }
            else
            {
                if($escaping) { $jqueryui_format .= "'"; $escaping = false; }
                if(isset($SYMBOLS_MATCHING[$char]))
                    $jqueryui_format .= $SYMBOLS_MATCHING[$char];
                else
                    $jqueryui_format .= $char;
            }
        }
        return $jqueryui_format;
    }
}

if(!function_exists('st_fix_iframe_w3c'))
{
    function st_fix_iframe_w3c($iframe)
    {
        $iframe=str_replace('webkitallowfullscreen','',$iframe);
        $iframe=str_replace('frameborder="0"','',$iframe);
        $iframe=str_replace('mozallowfullscreen','',$iframe);
        return $iframe;
    }
}
if(!function_exists('st_get_discount_value'))
{
    function st_get_discount_value($number,$percent=0,$format_money=true)
    {
        if($percent>100) $percent=100;

        $rs= $number-($number/100)*$percent;

        if($format_money) return TravelHelper::format_money($rs);
        return $rs;
    }
}

    if(!function_exists('st_is_https'))
    {
        function st_is_https()
        {
            if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
                // no SSL request
                return false;
            }
            return true;
        }
    }
