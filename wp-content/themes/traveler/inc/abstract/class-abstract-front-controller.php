<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 4/9/15
 * Time: 3:12 PM
 */

if(!class_exists('ST_Abstract_Front_Controller'))
{
    abstract class ST_Abstract_Front_Controller extends ST_Abstract_Controller
    {

        function __construct($arg=array())
        {
            parent::__construct($arg);
        }
    }
}