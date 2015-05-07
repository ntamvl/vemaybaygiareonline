<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 3/6/15
 * Time: 3:26 PM
 */

$main_color =st()->get_option('main_color');

if(isset($_GET['main_color']))
{
    $main_color.='#'.$_GET['main_color'];
}
if(isset($main_color_char))
{
    $main_color=$main_color_char;
}


$hex=st_hex2rgb($main_color);
$star_color=st()->get_option('star_color');

?>
.sort_icon .active,
.woocommerce-ordering .sort_icon a.active{
color:<?php echo esc_attr($main_color)?>;
cursor: default;
}
.package-info-wrapper .icon-group i{
   color:<?php echo esc_attr($main_color)?>;
}
a,
a:hover,
.list-category > li > a:hover,
.pagination > li > a,
.top-user-area .top-user-area-list > li > a:hover,
.sidebar-widget.widget_archive ul> li > a:hover,
.sidebar-widget.widget_categories ul> li > a:hover,
.comment-form .add_rating,
.booking-item-reviews > li .booking-item-review-content .booking-item-review-expand span,
.booking-item-reviews > li .booking-item-rating-stars,
.booking-item-rating .booking-item-rating-stars,
.form-group.form-group-focus .input-icon.input-icon-hightlight,
.search_advance .expand_search_box span,
.booking-item-payment .booking-item-rating-stars .fa-star,
.booking-item-raiting-summary-list > li .booking-item-rating-stars,
.woocommerce .woocommerce-breadcrumb .last,
.product-categories li.current-cat:before,
.product-categories li.current-cat-parent:before,
.product-categories li.current-cat>a,
.product-categories li.current-cat>span,
.woocommerce .star-rating span:before,
.woocommerce ul.products li.product .price,
.woocommerce .woocommerce_paging a,
.woocommerce .product_list_widget ins .amount
{
color:<?php echo esc_attr($main_color)?>
}
::selection {
background: <?php echo esc_attr($main_color)?>;
color: #fff;
}
.text-color,
.share ul li a:hover{
color:<?php echo esc_attr($main_color)?>!important;
}

header#main-header,
.btn-primary,
.post .post-header,
.top-user-area .top-user-area-list > li.top-user-area-avatar > a:hover > img,

.booking-item:hover, .booking-item.active,
.booking-item-dates-change,
.btn-group-select-num >.btn.active, .btn-group-select-num >.btn.active:hover,
.btn-primary:hover,
.booking-item-features > li:hover > i,
.form-control:active,
.form-control:focus,
.fotorama__thumb-border,
.sticky-wrapper.is-sticky .main_menu_wrap
{
border-color:<?php echo esc_attr($main_color)?>;
}



.pagination > li > a.current, .pagination > li > a.current:hover,
.btn-primary,
ul.slimmenu li.active > a, ul.slimmenu li:hover > a,
.nav-drop > .nav-drop-menu > li > a:hover,
.btn-group-select-num >.btn.active, .btn-group-select-num >.btn.active:hover,
.btn-primary:hover,
.pagination > li.active > a, .pagination > li.active > a:hover,
.box-icon, [class^="box-icon-"], [class*=" box-icon-"],
.booking-item-raiting-list > li > div.booking-item-raiting-list-bar > div, .booking-item-raiting-summary-list > li > div.booking-item-raiting-list-bar > div,
.irs-bar,
.nav-pills > li.active > a,
.search-tabs-bg > .tabbable > .nav-tabs > li.active > a,
.search-tabs-bg > .tabbable > .nav-tabs > li > a:hover > .fa,
.irs-slider,
.post .post-header .post-link,
.hover-img .hover-title, .hover-img [class^="hover-title-"], .hover-img [class*=" hover-title-"],
.post .post-header .post-link:hover,
#gotop:hover,
.shop-widget-title,
.woocommerce ul.products li.product .add_to_cart_button,
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content,
.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
.sidebar_section_title,
.shop_reset_filter:hover,
.woocommerce .woocommerce_paging a:hover,
.pagination .page-numbers.current,
.pagination .page-numbers.current:hover,
.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,
.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,
.chosen-container .chosen-results li.highlighted,
.booking-item-payment .booking-item-rating-stars .fa-star-half-o
{
background:<?php echo esc_attr($main_color)?>
}

.datepicker table tr td.active:hover, .datepicker table tr td.active:hover:hover, .datepicker table tr td.active.disabled:hover, .datepicker table tr td.active.disabled:hover:hover, .datepicker table tr td.active:focus, .datepicker table tr td.active:hover:focus, .datepicker table tr td.active.disabled:focus, .datepicker table tr td.active.disabled:hover:focus, .datepicker table tr td.active:active, .datepicker table tr td.active:hover:active, .datepicker table tr td.active.disabled:active, .datepicker table tr td.active.disabled:hover:active, .datepicker table tr td.active.active, .datepicker table tr td.active:hover.active, .datepicker table tr td.active.disabled.active, .datepicker table tr td.active.disabled:hover.active, .open .dropdown-toggle.datepicker table tr td.active, .open .dropdown-toggle.datepicker table tr td.active:hover, .open .dropdown-toggle.datepicker table tr td.active.disabled, .open .dropdown-toggle.datepicker table tr td.active.disabled:hover
{
background-color:<?php echo esc_attr($main_color)?>;

border-color: <?php echo esc_attr($main_color)?>;
}

.datepicker table tr td.today:before, .datepicker table tr td.today:hover:before, .datepicker table tr td.today.disabled:before, .datepicker table tr td.today.disabled:hover:before{
border-bottom-color: <?php echo esc_attr($main_color)?>;
}

.box-icon:hover, [class^="box-icon-"]:hover, [class*=" box-icon-"]:hover
{
background:rgba(<?php echo esc_attr($hex[0].','.$hex[1].','.$hex[2].',0.7') ?>);
}

.woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled:hover, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce #respond input#submit.alt:disabled[disabled]:hover, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt:disabled[disabled], .woocommerce a.button.alt:disabled[disabled]:hover, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt:disabled[disabled], .woocommerce button.button.alt:disabled[disabled]:hover, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt.disabled:hover, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled:hover, .woocommerce input.button.alt:disabled[disabled], .woocommerce input.button.alt:disabled[disabled]:hover
{
    background:rgba(<?php echo esc_attr($hex[0].','.$hex[1].','.$hex[2].',0.7') ?>);
}

.booking-item-reviews > li .booking-item-review-person-avatar:hover
{
-webkit-box-shadow: 0 0 0 2px <?php echo esc_attr($main_color)?>;
box-shadow: 0 0 0 2px <?php echo esc_attr($main_color)?>;
}
ul.slimmenu li.current-menu-item > a, ul.slimmenu li:hover > a,
.menu .current-menu-ancestor >a,
.product-info-hide .product-btn:hover
{
background:<?php echo esc_attr($main_color)?>;
color:white;
}

.menu .current-menu-item > a
{
background:<?php echo esc_attr($main_color)?> !important;
color:white !important;
}


.i-check.checked, .i-radio.checked
{

border-color: <?php echo esc_attr($main_color)?>;
background: <?php echo esc_attr($main_color)?>;
}


.i-check.hover, .i-radio.hover
{
border-color: <?php echo esc_attr($main_color)?>;
}


.irs-diapason{

background: <?php echo esc_attr($main_color)?>;
}

<?php if($star_color):?>
    .booking-item-rating .fa ,
    .booking-item.booking-item-small .booking-item-rating-stars,
    .comment-form .add_rating,
    .booking-item-payment .booking-item-rating-stars .fa-star{
    color:<?php echo esc_attr($star_color)?>
    }
<?php endif;?>





<?php $color_featured = st()->get_option('st_text_featured_color');
      $bg_featured = st()->get_option('st_text_featured_bg');
?>
.st_featured{
 color: <?php echo esc_attr($color_featured) ?>;
 background: <?php echo esc_attr($bg_featured) ?>;
}

.st_featured::before {
   border-color: <?php echo esc_attr($bg_featured) ?> <?php echo esc_attr($bg_featured) ?> transparent transparent;
}
.st_featured::after {
    border-color: <?php echo esc_attr($bg_featured) ?> transparent <?php echo esc_attr($bg_featured) ?> <?php echo esc_attr($bg_featured) ?>;
}
.featured_single .st_featured::before{
   border-color: transparent <?php echo esc_attr($bg_featured) ?> transparent transparent;
}



.item-nearby .st_featured{
   padding: 0 13px 0 0;
}
.item-nearby .st_featured::before {
    right: 0px;
    left: auto;
    border-color: transparent transparent <?php echo esc_attr($bg_featured) ?> <?php echo esc_attr($bg_featured) ?>;
    top: -10px;
}
.item-nearby .st_featured::after {
   left: -28px;
   right:auto;
   border-width:14px;
   border-color: <?php echo esc_attr($bg_featured) ?> <?php echo esc_attr($bg_featured) ?> <?php echo esc_attr($bg_featured) ?> transparent  ;
}
.item-nearby .st_featured{
  font: bold 14px/28px Cambria,Georgia,Times,serif;
}

<?php  if(st()->get_option('right_to_left') == 'on' ){ ?>
    .st_featured{
       padding: 0 13px 0 3px;
    }
    .st_featured::before {
        border-color: <?php echo esc_attr($bg_featured) ?> transparent transparent <?php echo esc_attr($bg_featured) ?>;
    }
    .st_featured::after {
        border-color: <?php echo esc_attr($bg_featured) ?> <?php echo esc_attr($bg_featured) ?> <?php echo esc_attr($bg_featured) ?> transparent;
    }
    .featured_single .st_featured::before {
        border-color: transparent transparent transparent <?php echo esc_attr($bg_featured) ?> ;
        right: -34px;
    }
    .item-nearby  .st_featured::before {
    border-color: <?php echo esc_attr($bg_featured) ?> transparent transparent <?php echo esc_attr($bg_featured) ?>;
    }

    .item-nearby .st_featured {
        bottom: 10px;
        left: -10px;
        right: auto;
        top: auto;
         padding: 0  0 0 13px;
    }
    .item-nearby  .st_featured::before {
        left: 0;
        right:auto;
    }
    .item-nearby .st_featured::before {
          border-color: <?php echo esc_attr($bg_featured) ?> <?php echo esc_attr($bg_featured) ?> transparent transparent;
    }
    .item-nearby .st_featured::after {
        border-color: <?php echo esc_attr($bg_featured) ?>  transparent <?php echo esc_attr($bg_featured) ?> <?php echo esc_attr($bg_featured) ?>;
        border-width: 14px;
        right: -27px;
    }
    .featured_single {
        padding-left: 70px;
        padding-right: 0px;
    }
<?php } ?>
