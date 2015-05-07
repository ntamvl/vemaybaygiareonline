<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STDate
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STDate'))
{
    class STDate
    {
        static function date_diff($date_1 , $date_2 , $differenceFormat = '%a' )
        {
            $datetime1 = new DateTime();
            $datetime1->setTimestamp((float)$date_1);
            $datetime2 = new DateTime();
            $datetime2->setTimestamp((float)$date_2);

            $interval = date_diff($datetime1, $datetime2);

            return $interval->format($differenceFormat);

        }
        static function timestamp_diff($date1,$date2)
        {
            $total_time= $date2-$date1;

            $hours      = floor($total_time /3600);

            return $hours;
        }

        static function date_diff2($date_1 , $date_2 , $differenceFormat = '%a' ){
            $date_1=strtotime($date_1);
            $date_2=strtotime($date_2);
            $datetime1 = new DateTime();
            $datetime1->setTimestamp((float)$date_1);
            $datetime2 = new DateTime();
            $datetime2->setTimestamp((float)$date_2);

            $interval = date_diff($datetime1, $datetime2);

            return $interval->format($differenceFormat);
        }
        static function date_diff_with_format($date_1 , $date_2, $differenceFormat = '%a')
        {
            $format=st()->get_option('search_date_format','m/d/Y');
            $datetime1=date_create_from_format($format,$date_1);
            $datetime2=date_create_from_format($format,$date_2);

            $interval = date_diff($datetime1, $datetime2);
            return $interval->format($differenceFormat);
        }
    }
}
