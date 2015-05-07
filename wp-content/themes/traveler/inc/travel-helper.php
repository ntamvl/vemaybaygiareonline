<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class Traver Helper
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('TravelHelper'))
{

    class TravelHelper{
        public static $all_currency;
        static function  init()
        {
            add_action( 'init',array(__CLASS__,'location_session'),1 );
            add_action('init',array(__CLASS__,'change_current_currency'));

            self::$all_currency=array (
                'ALL' => 'Albania Lek',
                'AFN' => 'Afghanistan Afghani',
                'ARS' => 'Argentina Peso',
                'AWG' => 'Aruba Guilder',
                'AUD' => 'Australia Dollar',
                'AZN' => 'Azerbaijan New Manat',
                'BSD' => 'Bahamas Dollar',
                'BBD' => 'Barbados Dollar',
                'BDT' => 'Bangladeshi taka',
                'BYR' => 'Belarus Ruble',
                'BZD' => 'Belize Dollar',
                'BMD' => 'Bermuda Dollar',
                'BOB' => 'Bolivia Boliviano',
                'BAM' => 'Bosnia and Herzegovina Convertible Marka',
                'BWP' => 'Botswana Pula',
                'BGN' => 'Bulgaria Lev',
                'BRL' => 'Brazil Real',
                'BND' => 'Brunei Darussalam Dollar',
                'KHR' => 'Cambodia Riel',
                'CAD' => 'Canada Dollar',
                'KYD' => 'Cayman Islands Dollar',
                'CLP' => 'Chile Peso',
                'CNY' => 'China Yuan Renminbi',
                'COP' => 'Colombia Peso',
                'CRC' => 'Costa Rica Colon',
                'HRK' => 'Croatia Kuna',
                'CUP' => 'Cuba Peso',
                'CZK' => 'Czech Republic Koruna',
                'DKK' => 'Denmark Krone',
                'DOP' => 'Dominican Republic Peso',
                'XCD' => 'East Caribbean Dollar',
                'EGP' => 'Egypt Pound',
                'SVC' => 'El Salvador Colon',
                'EEK' => 'Estonia Kroon',
                'EUR' => 'Euro Member Countries',
                'FKP' => 'Falkland Islands (Malvinas) Pound',
                'FJD' => 'Fiji Dollar',
                'GHC' => 'Ghana Cedis',
                'GIP' => 'Gibraltar Pound',
                'GTQ' => 'Guatemala Quetzal',
                'GGP' => 'Guernsey Pound',
                'GYD' => 'Guyana Dollar',
                'HNL' => 'Honduras Lempira',
                'HKD' => 'Hong Kong Dollar',
                'HUF' => 'Hungary Forint',
                'ISK' => 'Iceland Krona',
                'INR' => 'India Rupee',
                'IDR' => 'Indonesia Rupiah',
                'IRR' => 'Iran Rial',
                'IMP' => 'Isle of Man Pound',
                'ILS' => 'Israel Shekel',
                'JMD' => 'Jamaica Dollar',
                'JPY' => 'Japan Yen',
                'JEP' => 'Jersey Pound',
                'KZT' => 'Kazakhstan Tenge',
                'KPW' => 'Korea (North) Won',
                'KRW' => 'Korea (South) Won',
                'KGS' => 'Kyrgyzstan Som',
                'LAK' => 'Laos Kip',
                'LVL' => 'Latvia Lat',
                'LBP' => 'Lebanon Pound',
                'LRD' => 'Liberia Dollar',
                'LTL' => 'Lithuania Litas',
                'MKD' => 'Macedonia Denar',
                'MYR' => 'Malaysia Ringgit',
                'MUR' => 'Mauritius Rupee',
                'MXN' => 'Mexico Peso',
                'MNT' => 'Mongolia Tughrik',
                'MZN' => 'Mozambique Metical',
                'NAD' => 'Namibia Dollar',
                'NPR' => 'Nepal Rupee',
                'ANG' => 'Netherlands Antilles Guilder',
                'NZD' => 'New Zealand Dollar',
                'NIO' => 'Nicaragua Cordoba',
                'NGN' => 'Nigeria Naira',
                'NOK' => 'Norway Krone',
                'OMR' => 'Oman Rial',
                'PKR' => 'Pakistan Rupee',
                'PAB' => 'Panama Balboa',
                'PYG' => 'Paraguay Guarani',
                'PEN' => 'Peru Nuevo Sol',
                'PHP' => 'Philippines Peso',
                'PLN' => 'Poland Zloty',
                'QAR' => 'Qatar Riyal',
                'RON' => 'Romania New Leu',
                'RUB' => 'Russia Ruble',
                'SHP' => 'Saint Helena Pound',
                'SAR' => 'Saudi Arabia Riyal',
                'RSD' => 'Serbia Dinar',
                'SCR' => 'Seychelles Rupee',
                'SGD' => 'Singapore Dollar',
                'SBD' => 'Solomon Islands Dollar',
                'SOS' => 'Somalia Shilling',
                'ZAR' => 'South Africa Rand',
                'LKR' => 'Sri Lanka Rupee',
                'SEK' => 'Sweden Krona',
                'CHF' => 'Switzerland Franc',
                'SRD' => 'Suriname Dollar',
                'SYP' => 'Syria Pound',
                'TWD' => 'Taiwan New Dollar',
                'THB' => 'Thailand Baht',
                'TTD' => 'Trinidad and Tobago Dollar',
                'TRY' => 'Turkey Lira',
                'TRL' => 'Turkey Lira',
                'TVD' => 'Tuvalu Dollar',
                'UAH' => 'Ukraine Hryvna',
                'GBP' => 'United Kingdom Pound',
                'USD' => 'United States Dollar',
                'UYU' => 'Uruguay Peso',
                'UZS' => 'Uzbekistan Som',
                'VEF' => 'Venezuela Bolivar',
                'VND' => 'Viet Nam Dong',
                'YER' => 'Yemen Rial',
                'ZWD' => 'Zimbabwe Dollar'
            );
        }

        static function ot_all_currency()
        {
            $a=array();

            foreach(self::$all_currency as $key=>$value)
            {
                $a[]=array(
                    'value'=>$key,
                    'label'=>$value.'('.$key.' )'
                );
            }

            return $a;
        }

        /**
         * @todo Setup Session
         *
         *
         * */
        static function location_session () {
            if(!session_id()) {
                session_start();
            }
        }


        /**
         * Return All Currencies
         *
         *
         * */
        static function get_currency($theme_option=false)
        {
            $all= apply_filters('st_booking_currency', st()->get_option('booking_currency'));

            //return array for theme options choise
            if($theme_option){
                $choice=array();

                if(!empty($all) and is_array($all))
                {


                    foreach($all as $key=>$value)
                    {
                        $choice[]=array(

                            'label'=>$value['title'],
                            'value'=>$value['name']
                        );
                    }

                }
                return $choice;
            }
            return $all;
        }




        /**
         * return Default Currency
         *
         *
         * */
        static function get_default_currency($need=false)
        {

            $primary=st()->get_option('booking_primary_currency');

            $primary_obj=self::find_currency($primary);

            if($primary_obj )
            {
                if($need and isset($primary_obj[$need])) return $primary_obj[$need];
                return $primary_obj;
            }else{

                //If user dont set the primary currency, we take the first of list all currency
                $all_currency=self::get_currency();



                if(isset($all_currency[0])){
                    if($need and isset($all_currency[0][$need])) return $all_currency[0][$need];
                    return $all_currency[0];
                }
            }


        }

        /**
         * return Current Currency
         *
         *
         * */
        static function get_current_currency($need=false)
        {

            //Check session of user first

            if(isset($_SESSION['currency']['name']))
            {
                $name=$_SESSION['currency']['name'];

                if($session_currency=self::find_currency($name))
                {
                    if($need and isset($session_currency[$need])) return $session_currency[$need];
                    return $session_currency;
                }
            }

            return self::get_default_currency($need);
        }


        /**
         * @todo Find currency by name, return false if not found
         *
         *
         * */
        static  function find_currency($currency_name,$compare_key='name')
        {
            $currency_name=esc_attr($currency_name);

            $all_currency=self::get_currency();

            if(!empty($all_currency)){
                foreach($all_currency as $key)
                {
                    if($key[$compare_key]==$currency_name)
                    {
                        return $key;
                    }
                }
            }
            return false;
        }

        /**
         * Change Default Currency
         * @param currency_name
         *
         * */

        static function  change_current_currency()
        {

            if(isset($_GET['currency']) and $_GET['currency'] and $new_currency=self::find_currency($_GET['currency']))
            {
                $_SESSION['currency']=$new_currency;
            }
        }

        /**
         *
         * Conver money from default currency to current currency
         *
         *
         *
         * */
        static function convert_money($money=false)
        {
            if(!$money) $money=0;

            $current_rate=self::get_current_currency('rate');
            $current=self::get_current_currency('name');

            $default=self::get_default_currency('name');

            if($current!=$default)
                return $money*$current_rate;
            return $money;


        }

        /**
         *
         * Format Money
         *
         *
         *
         * */
        static function format_money($money=false,$need_convert=true,$precision=0)
        {
            $money=(float)$money;
            $precision=st()->get_option('booking_currency_precision',2);

            if($money == 0){
                return __("Free",ST_TEXTDOMAIN);
            }

            if($need_convert){
                $money=self::convert_money($money);
            }


            if($precision){
                $money=round($money,$precision);
            }

            $symbol=self::get_current_currency('symbol');

            $template=st()->get_option('booking_currency_pos');

            if(!$template)
            {
                $template='left';
            }

            $money=number_format((float)$money,$precision);

            switch($template)
            {


                case "right":
                    $money_string= $money.$symbol;
                    break;
                case "left_space":
                    $money_string=$symbol." ".$money;
                    break;

                case "right_space":
                    $money_string=$money." ".$symbol;
                    break;
                case "left":
                default:
                    $money_string= $symbol.$money;
                    break;


            }

            return $money_string;

        }

        static function format_money_raw($money,$symbol,$precision=2)
        {
            if($money == 0){
                return __("Free",ST_TEXTDOMAIN);
            }

            if(!$symbol){
                $symbol=self::get_current_currency('symbol');
            }

            if($precision){
                $money=round($money,$precision);
            }

            $template=st()->get_option('booking_currency_pos');

            if(!$template)
            {
                $template='left';
            }

            $money=number_format((float)$money,0);

            switch($template)
            {


                case "right":
                    $money_string= $money.$symbol;
                    break;
                case "left_space":
                    $money_string=$symbol." ".$money;
                    break;

                case "right_space":
                    $money_string=$money." ".$symbol;
                    break;
                case "left":
                default:
                    $money_string= $symbol.$money;
                    break;


            }

            return $money_string;
        }





        static function build_url($name,$value){
            $all=$_GET;
            $current_url=self::current_url();
            $all[$name]=$value;
            return esc_url($current_url.'?'.http_build_query ($all));
        }
        static function build_url_array($key,$name,$value,$add=true){
            $all=$_GET;
            $current_url=self::current_url();
            //$all[$key][$name]=$value;

            $val=isset($all[$key][$name])?$all[$key][$name]:'';

            if($add)
            {
                $value_array=explode(',',$val);
                $value_array[]=$value;

            }else{

                $value_array=explode(',',$val);
                unset($value_array[$value]);
                if(!empty($value_array))
                {
                    foreach($value_array as $k=>$v){
                        if($v==$value) unset( $value_array[$k]);
                    }
                }

            }
            $all[$key][$name]=implode(',',$value_array);

            return $current_url.'?'.http_build_query ($all);
        }
        static function build_url_auto_key($key,$value,$add=true){
            $all=$_GET;
            $current_url=self::current_url();

            $val=isset($all[$key])?$all[$key]:'';
            $value_array=array();
            $url=$current_url;

            if($add){

                if($val){
                    $value_array=explode(',',$val);
                }
                $value_array[]=$value;

            }else{

                $value_array=explode(',',$val);
                if(!empty($value_array))
                {
                    foreach($value_array as $k=>$v){
                        if($v==$value) unset( $value_array[$k]);
                    }

                }

            }

            $new_val=implode(',',$value_array);
            if($new_val){
                $all[$key]=$new_val;
            }else{
                $all[$key]='';
            }

            $all['paged']='';

            $url= esc_url(add_query_arg($all,$url));

            return $url;
        }

        static function checked_array($key,$need)
        {
            $found=false;
            if(!empty($key))
            {
                foreach($key as $k=>$v){
                    if($need==$v){
                        return true;
                    }
                }
            }

            return $found;
        }
        static function get_js_date_format()
        {
            return 'mm/dd/yyyy';
//        $format=st()->get_option('search_date_format','m/d/Y');
//        return st_dateformat_PHP_to_jQueryUI($format);
        }
        static function build_url_muti_array($key,$name,$name_2,$value){
            $all=$_GET;
            $current_url=self::current_url();
            $all[$key][$name][$name_2]=$value;
            return $current_url.'?'.http_build_query($all);
        }

        static function current_url()
        {

            $pageURL = 'http';
            if (isset($_SERVER['HTTPS']) and $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
            $pageURL .= "://";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["SCRIPT_NAME"];
            } else {
                $pageURL .= $_SERVER["SERVER_NAME"].parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            }
            $pageURL=rtrim($pageURL,'index.php');
            return $pageURL;
        }

        static function paging()
        {
            // Don't print empty markup if there's only one page.
            if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
                return;
            }

            $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
            $pagenum_link = html_entity_decode( get_pagenum_link() );
            $query_args   = array();
            $url_parts    = explode( '?', $pagenum_link );

            if ( isset( $url_parts[1] ) ) {
                wp_parse_str( $url_parts[1], $query_args );
            }

            $pagenum_link = esc_url(remove_query_arg( array_keys( $query_args ), $pagenum_link ));
            $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

            $format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
            $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

            // Set up paginated links.
            $links = paginate_links( array(
                'base'     => $pagenum_link,
                'format'   => $format,
                'total'    => $GLOBALS['wp_query']->max_num_pages,
                'current'  => $paged,
                'mid_size' => 1,
                // 'add_args' => array_map( 'urlencode', $query_args ),
                'add_args' =>$query_args,
                'prev_text' => __( 'Previous Page', ST_TEXTDOMAIN ),
                'next_text' => __( 'Next Page', ST_TEXTDOMAIN ),
                'type'      =>'list'
            ) );


            if ( $links ) :
                $links=str_replace('page-numbers','pagination', balanceTags ($links));
                $links=str_replace('<span','<a',$links);
                $links=str_replace('</span>','</a>',$links);
                ?>
                <?php echo str_replace('page-numbers','pagination', balanceTags ($links));//do not use esc_html() with  paginate_links() result ?>
            <?php
            endif;
        }
        static function comments_paging()
        {
            ob_start();

            paginate_comments_links(
                array('type'=>'list',
                    'prev_text' => __( 'Previous Page', ST_TEXTDOMAIN ),
                    'next_text' => __( 'Next Page', ST_TEXTDOMAIN ),));

            $links=@ob_get_clean();


            if ( $links ) :
                $links=str_replace('page-numbers','pagination pull-right', balanceTags ($links));
                $links=str_replace('<span','<a',$links);
                $links=str_replace('</span>','</a>',$links);
                ?>
                <?php echo str_replace('page-numbers','pagination', balanceTags ($links));//do not use esc_html() with  paginate_links() result ?>
            <?php
            endif;
        }

        static function comments_list($comment, $args, $depth )
        {
            //get_template_part('single/comment','list');

            $file=locate_template('single/comment-list.php');

            if(is_file($file))

                include($file);
        }

        static function cutnchar($str,$n)
        {
            if(strlen($str)<$n) return $str;
            $html = substr($str,0,$n);
            $html = substr($html,0,strrpos($html,' '));
            return $html.'...';
        }

        static function  get_orderby_list()
        {
            return array(
                'none'=>'None',
                'ID'=>"ID",
                'author'=>'Author',
                'title'=>'Title',
                'name'=>"Name",
                'date'=>"Date",
                'modified'=>'Modified Date',
                'parent'=>'Parent',
                'rand'=>'Random',
                'comment_count'=>'Comment Count',

            );

        }

        static function reviewlist()
        {
            $file=locate_template('reviews/review-list.php');

            if(is_file($file))

                include($file);
        }

        static function rate_to_string($star,$max=5)
        {
            $html='';

            if($star>$max) $star=$max;

            $moc1=(int)$star;

            for($i=1;$i<=$moc1;$i++ )
            {
                $html.='<li><i class="fa fa-star"></i></li>';
            }

            $new=$max-$star;

            $du=$star-$moc1;
            if($du>=0.2 and $du<=0.9){
                $html.='<li><i class="fa fa-star-half-o"></i></li>';
            }elseif($du){
                $html.='<li><i class="fa fa-star-o"></i></li>';
            }

            for($i=1;$i<=$new;$i++ )
            {
                $html.='<li><i class="fa fa-star-o"></i></li>';
            }

            return apply_filters('st_rate_to_string',$html);

        }

        static function add_read_more($content,$max_string=200)
        {
            $all=strlen($content);

            if(strlen($content)<$max_string) return $content;
            $html = substr($content,0,$max_string);
            $html = substr($html,0,strrpos($html,' '));


            return $html.'<span class="booking-item-review-more">'.substr($content,-($all-strrpos($html,' '))).'</span>';


        }

        static function  cal_rate($number,$total)
        {
            if(!$total) return 0;
            return round(($number/$total)*100);
        }

        static function handle_icon($string)
        {
            if(strpos($string,'im-')===0)
            {
                $icon= "im ".$string;
            }elseif(strpos($string,'fa-')===0)
            {
                $icon= "fa ".$string;
            }elseif(strpos($string,'ion-')===0)
            {
                $icon= "ion ".$string;
            }else{
                $icon=$string;
            }

            //return "<i class=''>"
            return $icon;
        }

        static function find_in_array($item=array(),$item_key=false,$item_value=false,$need=false){
            if(!empty($item)){
                foreach($item as $key=>$value)
                {
                    if($item_value==$value[$item_key]){
                        if($need and isset($value[$need])) return $value[$need];
                        return $value;
                    }
                }
            }
        }

        static function get_location_temp($post_id=false)
        {

            $dataWeather=self::_get_location_weather($post_id);

            $c=0;
            if(isset($dataWeather->main->temp)){
                $k=$dataWeather->main->temp;
                $temp_format = st()->get_option('st_weather_temp_unit','c');
                $c = self::_change_temp($k,$temp_format);
            }
            $icon='';
            if(!empty($dataWeather->weather[0]->icon)){
                $icon = self::get_weather_icons($dataWeather->weather[0]->icon);
            }
            return array(
                'temp'=>$c,
                'icon'=>$icon
            );
        }
        static function _change_temp($value,$type='k'){
            if($type == 'c'){
                $value=$value-273.15;
            }
            if($type == 'f'){
                $c = $value-273.15;
                $value = $c * 1.8 + 32 ;
            }
            $value = number_format((float)$value,1);
            return $value;
        }
        static function get_weather_icons($id_icon=null){
            // API http://openweathermap.org/weather-conditions
            switch($id_icon){
                case "01d":
                    return '<i class="wi wi-solar-eclipse loc-info-weather-icon"></i>';
                    break;
                case "02d":
                    return '<i class="wi wi-day-cloudy loc-info-weather-icon"></i>';
                    break;
                case "03d":
                    return '<i class="wi wi-cloud loc-info-weather-icon"></i>';
                    break;
                case "04d":
                    return '<i class="wi wi-cloudy loc-info-weather-icon"></i>';
                    break;
                case "09d":
                    return '<i class="wi wi-snow-wind loc-info-weather-icon"></i>';
                    break;
                case "10d":
                    return '<i class="wi wi-day-rain-mix loc-info-weather-icon"></i>';
                    break;
                case "11d":
                    return '<i class="wi wi-day-storm-showers loc-info-weather-icon"></i>';
                    break;
                case "13d":
                    return '<i class="wi wi-showers loc-info-weather-icon"></i>';
                    break;
                case "50d":
                    return '<i class="wi wi-windy loc-info-weather-icon"></i>';
                    break;
                case "01n":
                    return '<i class="wi wi-night-clear loc-info-weather-icon"></i>';
                    break;
                case "02n":
                    return '<i class="wi wi-night-cloudy loc-info-weather-icon"></i>';
                    break;
                case "03n":
                    return '<i class="wi wi-cloud loc-info-weather-icon"></i>';
                    break;
                case "04n":
                    return '<i class="wi wi-cloudy loc-info-weather-icon"></i>';
                    break;
                case "09n":
                    return '<i class="wi wi-snow-wind loc-info-weather-icon"></i>';
                    break;
                case "10n":
                    return '<i class="wi wi-night-alt-rain-mix loc-info-weather-icon"></i>';
                    break;
                case "11n":
                    return '<i class="wi wi-day-storm-showers loc-info-weather-icon"></i>';
                    break;
                case "13n":
                    return '<i class="wi wi-showers loc-info-weather-icon"></i>';
                    break;
                case "50n":
                    return '<i class="wi wi-windy loc-info-weather-icon"></i>';
                    break;
            }

        }

        private static function _get_location_weather($post_id=false)
        {
            if(!$post_id) $post_id=get_the_ID();

            $lat=get_post_meta($post_id,'map_lat',true);
            $lng=get_post_meta($post_id,'map_lng',true);


            if($lat and $lng){
                $url="http://api.openweathermap.org/data/2.5/weather?lat=".$lat.'&lon='.$lng;
            }else{
                $url="http://api.openweathermap.org/data/2.5/weather?q=".get_the_title($post_id);
            }
            $cache=get_transient('st_weather_location_'.$post_id);

            $dataWeather=null;

            if($cache===false){
                $raw_geocode = wp_remote_get($url);

                $body=wp_remote_retrieve_body($raw_geocode);
                $body=json_decode($body);
                if(isset($body->main->temp))
                    set_transient( 'st_weather_location_'.get_the_ID(), $body, 60*60*12 );
                $dataWeather=$body;
            }else{
                $dataWeather=$cache;
            }
            return $dataWeather;
        }

        private static function _change_weather_icon($icon_old,$icon_new){

            if(strpos($icon_old,'d')!==FALSE)
            {
                return str_replace('-night-','-day-',$icon_new);
            }else{
                return str_replace('-day-','-night-',$icon_new);
            }
        }


        static function get_weather_icon($location_id=fasle)
        {
            if(!$location_id) $location_id=get_the_ID();

            $dataWeather=self::_get_location_weather($location_id);

            $c=0;
            if(isset($dataWeather->weather->id)){
                $w_id=$dataWeather->weather->id;
                $old_icon=$dataWeather->weather->id;

                switch($w_id){
                    case 200:
                        //$c=self::_change_weather_icon('')
                }
            }

            return $c;
        }

        static function st_get_field_search($post_type)
        {
            if(!empty($post_type)){
                switch($post_type){
                    case "st_hotel":
                        $data_field = STHotel::get_search_fields_name();
                        break;
                    case "st_rental":
                        $data_field = STRental::get_search_fields_name();
                        break;
                    case "st_cars":
                        $data_field = STCars::get_search_fields_name();
                        break;
                    case "st_tours":
                        $data_field = STTour::get_search_fields_name();
                        break;
                    case "st_activity":
                        $data_field = STActivity::get_search_fields_name();
                        break;
                }
                if(!empty($data_field) and is_array($data_field)){
                    foreach($data_field as $k => $v){
                        $list_field[$v['label']] =  $v['value'] ;
                    }
                    return $list_field;
                }
            }else{
                return false;
            }
        }

    }

    TravelHelper::init();
}