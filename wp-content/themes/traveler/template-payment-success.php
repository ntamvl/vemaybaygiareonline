<?php
    /*
     * Template Name: Payment Success
    */
    /**
     * @package WordPress
     * @subpackage Traveler
     * @since 1.0
     *
     * Template Name : Payment success
     *
     * Created by ShineTheme
     *
     */

    $order_code = STInput::get('order_code');
    $user_id=get_current_user_id();


//    if (!$order_code or get_post_meta($order_code,'id_user',true)!=$user_id) {
//        wp_redirect(home_url('/'));
//        exit;
//    }


    get_header();

    $order_item = get_post($order_code);
    wp_reset_postdata();

    $payment_method = get_post_meta($order_item->ID, 'payment_method', true);

?>
    <div class="gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <i class="fa fa-check round box-icon-large box-icon-center box-icon-success mb30"></i>

                <h2 class="text-center">
                    <?php if ($payment_method == 'paypal') {
                        echo get_post_meta($order_code, 'pp_firstname', true) . ' ' . get_post_meta($order_code, 'pp_lastname', true);
                    } elseif ($user_id = get_post_meta($order_code, 'id_user', true)) {
                        $user_info = get_userdata($user_id);
                        if (isset($user_info->first_name)) {
                            echo esc_html($user_info->first_name);
                        }
                    }
                        echo ', ';

                        if (get_post_meta($order_code, 'payment_method', true) == 'submit_form') {
                            st_the_language('your_order_was_successful');
                        } else
                            st_the_language('your_payment_was_successful');
                    ?>
                </h2>
                <h5 class="text-center mb30"><?php st_the_language('booking_details_has_been_sent_to');
                        echo get_post_meta($order_code, 'st_email', true) ?> </h5>

                <p><strong><?php st_the_language('booking_number') ?></strong> <?php echo esc_html($order_code) ?></p>

                <p>
                    <strong><?php st_the_language('booking_date') ?></strong> <?php echo get_the_time(get_option('date_format'), $order_code) ?>
                </p>

                <p><strong><?php st_the_language('booking_method') ?></strong> <?php

                        echo STPaymentGateways::get_gatewayname(get_post_meta($order_code, 'payment_method', true));

                    ?></p>
                <table cellpadding="0" cellspacing="0" width="100%" class="tb_list_cart">
                    <thead>
                    <tr>
                        <td>
                            *
                        </td>
                        <td class="text-center">
                            <?php st_the_language('item') ?>
                        </td>
                        <td>
                            <?php st_the_language('infomation') ?>
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $total = 0;
                        $i = 0;
                        $key = get_post_meta($order_code, 'item_id', true);

                        $value = array(
                            'number' => get_post_meta($order_code, 'item_number', true),
                            'price'  => get_post_meta($order_code, 'item_price', true),
                            'data'   => array(
                                'check_in'  => get_post_meta($order_code, 'check_in', true),
                                'check_out' => get_post_meta($order_code, 'check_out', true),
                                'room_id'   => get_post_meta($order_code, 'room_id', true)
                            )
                        );
                        $check_in = get_post_meta($order_code, 'check_in', true);
                        $check_out = get_post_meta($order_code, 'check_out', true);
                        $datediff = STDate::date_diff(strtotime($check_in), strtotime($check_out));
                        $number = get_post_meta($order_code, 'item_number', true);
                        $price = get_post_meta($order_code, 'item_price', true);
                        if (!$number) $number = 1;

                        $post_type = get_post_type($key);
                        if ($post_type == "st_cars") {
                            $total += STCars::get_price_car_by_order_item($order_code);
                        } else if ($post_type == "st_hotel") {
                            if ($datediff >= 1) {
                                $total += ($price) * $datediff * $number;
                            } else {
                                $total += $price * $number;
                            }
                        } elseif ($post_type == "st_tours") {
                            $total += STCart::get_order_item_total($order_code, get_post_meta($order_code, 'st_tax', true));
                        } else {

                            $total += $price * $number;
                        }
                        $i++;


                        switch ($post_type) {
                            case "st_hotel":
                                echo st()->load_template('hotel/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                                break;
                            case "st_tours":
                                echo st()->load_template('tours/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                                break;
                            case "st_cars":
                                echo st()->load_template('cars/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                                break;
                            case "st_activity":
                                echo st()->load_template('activity/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                                break;
                            case "st_rental":
                                echo st()->load_template('rental/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                                break;
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2" style="
border-left: 1px solid #bcbcbc;
border-bottom: 1px solid #bcbcbc;
padding: 6px;
background: #e4e4e4;"></td>
                        <td style="
border-bottom: 1px solid #bcbcbc;
border-right:1px solid #bcbcbc;
padding: 6px;
background: #e4e4e4;">
                            <table cellspacing="0px" cellpadding="0" width="100%" class="tb_cart_total">
                                <tr>
                                    <td style="border-bottom: 1px dashed #ccc;padding:10px;">
                                        <strong><?php st_the_language('sub_total') ?></strong></td>
                                    <td style="border-bottom: 1px dashed #ccc;padding:10px;"><?php echo TravelHelper::format_money($total); ?></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px dashed #ccc;padding:10px;">
                                        <strong><?php st_the_language('tax') ?></strong></td>
                                    <td style="border-bottom: 1px dashed #ccc;padding:10px;"><?php
                                            $tax = get_post_meta($order_code, 'st_tax', true);
                                            if (!$tax) {
                                                $tax = STCart::get_tax();
                                            }
                                            $tax_amount = ($total / 100) * $tax;
                                            echo TravelHelper::format_money($tax_amount);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px dashed #ccc;padding:10px;">
                                        <strong><?php st_the_language('total') ?></strong></td>
                                    <td style="border-bottom: 1px dashed #ccc;padding:10px;">
                                        <?php echo TravelHelper::format_money($total + $tax_amount) ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tfoot>
                </table>
                <h2 style=";
                margin-top: 50px;"><?php st_the_language('customer_infomation') ?></h2>
                <table cellpadding="0" cellspacing="0" width="100%" border="0px" class="mb30 tb_cart_customer">
                    <tbody>
                    <tr>
                        <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <strong><?php st_the_language('first_name') ?></strong></td>
                        <td align="right" class="text-right" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <?php echo get_post_meta($order_code, 'st_first_name', true) ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <strong><?php st_the_language('last_name') ?></strong></td>
                        <td align="right" class="text-right" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <?php echo get_post_meta($order_code, 'st_last_name', true) ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <strong><?php st_the_language('email') ?></strong></td>
                        <td align="right" class="text-right" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <?php echo get_post_meta($order_code, 'st_email', true) ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <strong><?php st_the_language('phone') ?></strong></td>
                        <td align="right" class="text-right" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <?php echo get_post_meta($order_code, 'st_phone', true) ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <strong><?php st_the_language('address_line_1') ?></strong></td>
                        <td align="right" class="text-right" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <?php echo get_post_meta($order_code, 'st_address', true) ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <strong><?php st_the_language('address_line_2') ?></strong></td>
                        <td align="right" class="text-right" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <?php echo get_post_meta($order_code, 'st_address2', true) ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <strong><?php st_the_language('city') ?></strong></td>
                        <td align="right" class="text-right" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <?php echo get_post_meta($order_code, 'st_city', true) ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <strong><?php st_the_language('state_province_region') ?></strong></td>
                        <td align="right" class="text-right" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <?php echo get_post_meta($order_code, 'st_province', true) ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <strong><?php st_the_language('zip_code_postal_code') ?></strong></td>
                        <td align="right" class="text-right" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <?php echo get_post_meta($order_code, 'st_zip_code', true) ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <strong><?php st_the_language('country') ?></strong></td>
                        <td align="right" class="text-right" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <?php echo get_post_meta($order_code, 'st_country', true) ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
                            <strong><?php st_the_language('special_requirements') ?></strong></td>
                        <td align="right" class="text-right"
                            style="border-bottom: 1px dashed #ccc;padding:10px;vertical-align: top">
                            <?php echo get_post_meta($order_code, 'st_note', true) ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php if (is_user_logged_in()):
                    $page_user = st()->get_option('page_my_account_dashboard');
                    if ($link = get_permalink($page_user)):
                        ?>
                        <div class="text-center mg20">
                            <a href="<?php echo esc_url($link)?>" class="btn btn-primary"><i
                                    class="fa fa-book"></i> <?php st_the_language('booking_management') ?></a>
                        </div>
                    <?php endif; endif; ?>
            </div>
        </div>

    </div>
<?php
    get_footer();