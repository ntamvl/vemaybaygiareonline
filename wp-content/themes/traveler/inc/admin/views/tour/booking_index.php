<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Admin tour booking index
 *
 * Created by ShineTheme
 *
 */


//$arg=array(
//    'post_type'=>'st_order_item',
//    'posts_per_page'=>5,
//    'paged'=>isset($_GET['paged'])?$_GET['paged']:1,
//);
//query_posts($arg);
$page=isset($_GET['paged'])?$_GET['paged']:1;
$limit=20;
$offset=($page-1)*$limit;

$data=STAdmin::get_history_bookings('st_tours',$offset,$limit);
$posts=$data['rows'];
$total=ceil($data['total']/$limit);

global $wp_query;

$paging=array();

$paging['base']=admin_url('edit.php?post_type=st_tours&page=st_tours_booking%_%');
$paging['format']='&paged=%#%';
$paging['total']=$total;
$paging['current']=$page;



echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
echo '<h2>'.__('Tour Booking',ST_TEXTDOMAIN).'<a href="'.admin_url('edit.php?post_type=st_tours&page=st_tours_booking&section=add_booking').'" class="add-new-h2">'.__('Add New',ST_TEXTDOMAIN).'</a></h2>';

    STAdmin::message();
?>
<form id="posts-filter" action="<?php echo admin_url('edit.php?post_type=st_tours&page=st_tours_booking')?>" method="post">

    <?php wp_nonce_field('shb_action','shb_field')?>
    <div class="tablenav top">
        <div class="alignleft actions bulkactions">
            <label for="bulk-action-selector-top" class="screen-reader-text"><?php _e('Select bulk action',ST_TEXTDOMAIN)?></label><select name="st_action" id="bulk-action-selector-top">
                <option value="-1" selected="selected"><?php _e('Bulk Actions',ST_TEXTDOMAIN)?></option>
                <option value="delete"><?php _e('Delete Permanently',ST_TEXTDOMAIN)?></option>
            </select>
            <input type="submit" name="" id="doaction" class="button action" value="<?php _e('Apply',ST_TEXTDOMAIN)?>">
        </div>
        <div class="tablenav-pages">
            <span class="displaying-num"><?php echo sprintf(_n('%s item','%s items',$data['total']),$data['total'],ST_TEXTDOMAIN)  ?></span>
            <?php echo paginate_links($paging)?>

        </div>
    </div>

    <table class="wp-list-table widefat fixed posts">
        <thead>
            <tr>
                <th class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-1"><?php _e('Select All',ST_TEXTDOMAIN)?></label>
                    <input  type="checkbox" id="cb-select-all-1">
                </th>

                <th class="manage-column">
                    <a href="#"><span><?php _e('Customer',ST_TEXTDOMAIN)?></span><span class="sorting-indicator"></span></a>
                </th>

                <th class="manage-column">
                    <a href="#"><span><?php _e('Name',ST_TEXTDOMAIN)?></span><span class="sorting-indicator"></span></a>
                </th>
                <th class="manage-column">
                    <a href="#"><span><?php _e('Type Tour',ST_TEXTDOMAIN)?></span><span class="sorting-indicator"></span></a>
                </th>
                <th class="manage-column">
                    <a href="#"><span><?php _e('Date',ST_TEXTDOMAIN)?></span><span class="sorting-indicator"></span></a>
                </th>
                <th class="manage-column " width="7%">
                    <a href="#"><span><?php _e('Number',ST_TEXTDOMAIN)?></span><span class="sorting-indicator"></span></a>
                </th>
                <th class="manage-column" width="7%">
                    <a href="#"><span><?php _e('Price',ST_TEXTDOMAIN)?></span><span class="sorting-indicator"></span></a>
                </th>
                <th class="manage-column"  width="10%">
                    <a href="#"><span><?php _e('Created Date',ST_TEXTDOMAIN)?></span><span class="sorting-indicator"></span></a>
                </th>
                <th class="manage-column " width="7%">
                    <a href="#"><span><?php _e('Status',ST_TEXTDOMAIN)?></span><span class="sorting-indicator"></span></a>
                </th>
                <th class="manage-column " width="10%">
                    <a href="#"><span><?php _e('Payment Method',ST_TEXTDOMAIN)?></span><span class="sorting-indicator"></span></a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php

                $i=0;

                if(!empty($posts)) {
                    foreach($posts as $key=>$value) {
                        //setup_postdata($value);
                        $i++;
                        $post_id=$value->ID;
                        $item_id = get_post_meta($post_id, 'item_id', true);
                        $order_id =$post_id;
                        ?>
                        <tr class="<?php if ($i % 2 == 0) echo 'alternate'; ?>">
                            <th scope="row" class="check-column">
                                <input id="cb-select-39" type="checkbox" name="post[]" value="<?php echo esc_attr( $post_id)?>">

                                <div class="locked-indicator"></div>
                            </th>

                            <td class="post-title page-title column-title">
                                <strong><a class="row-title"
                                           href="<?php echo admin_url('edit.php?post_type=st_tours&page=st_tours_booking&section=edit_order_item&order_item_id=' . $post_id); ?>"
                                           title=""><?php
                                        $order = $post_id;
                                        if ($order) {
                                            $name = get_post_meta($order, 'st_first_name', true);
                                            if (!$name) {
                                                $name = get_post_meta($order, 'st_name', true);
                                            }
                                            if (!$name) {
                                                $name = get_post_meta($order, 'st_email', true);
                                            }
                                            echo esc_html( $name);
                                        }

                                        ?></a></strong>

                                <div class="row-actions">
                                    <a href="<?php echo admin_url('edit.php?post_type=st_tours&page=st_tours_booking&section=edit_order_item&order_item_id=' . $post_id); ?>"><?php _e('Edit',ST_TEXTDOMAIN)?></a> |
                                    <a href="<?php echo admin_url('edit.php?post_type=st_tours&page=st_tours_booking&section=resend_email_tours&order_item_id=' . $post_id); ?>"><?php _e('Resend Email',ST_TEXTDOMAIN)?></a>
                                </div>
                            </td>
                            <td class="post-title page-title column-title">
                                <?php
                                if ($item_id) {
                                    echo "<a href='" . get_edit_post_link($item_id) . "' target='_blank'>" . get_the_title($item_id) . "</a>";
                                }
                                ?>
                            </td>
                            <?php
                            $st_cart_info = get_post_meta($post_id,'st_cart_info',true);
                            if($st_cart_info){
                                $st_cart_info = $st_cart_info[$item_id]['data'];
                                $type_tour = $st_cart_info['type_tour'];

                                $duration=isset($st_cart_info['duration'])?$st_cart_info['duration']:0;
                            }else
                            {
                                $duration=0;
                                $type_tour='daily_tour';
                            }

                            ?>
                            <?php if($type_tour == 'specific_date'){ ?>
                                <td class="post-title page-title column-title">
                                    <?php _e('Specific Date',ST_TEXTDOMAIN) ?>
                                </td>
                            <?php }else{ ?>
                                <td class="post-title page-title column-title">
                                    <?php _e('Daily Tour',ST_TEXTDOMAIN) ?>
                                </td>
                            <?php } ?>

                            <?php if($type_tour == 'daily_tour'){ ?>
                                <td class="post-title page-title column-title">
                                    <?php $date=  isset($st_cart_info['check_in'])?$st_cart_info['check_in']:false; ;if($date) echo date('m/d/Y',strtotime($date));


                                    if($duration){
                                        $date2=strtotime( '+'.$duration.' days',strtotime($date));
                                        echo ' - '.date('m/d/Y',$date2);
                                    }
                                    ?>
                                </td>
                            <?php }else{ ?>
                                <td class="post-title page-title column-title">
                                    <?php $date= isset($st_cart_info['check_in'])?$st_cart_info['check_in']:false;if($date) echo date('m/d/Y',strtotime($date)); ?> -
                                    <?php $date= isset($st_cart_info['check_out'])?$st_cart_info['check_out']:false;if($date) echo date('m/d/Y',strtotime($date)); ?>
                                </td>
                            <?php } ?>

                            <td class="post-title page-title column-title">
                                <?php echo get_post_meta($post_id, 'item_number', true) ?>
                            </td>
                            <td class="post-title page-title column-title">
                               <?php //echo TravelHelper::format_money(number_format((float) STCart::get_order_item_total($post_id,get_post_meta($order_id,'st_tax',true)),0) );
                               $price=(STCart::get_order_item_total($post_id,get_post_meta($order_id,'st_tax',true)) );
                               $currency=get_post_meta($order_id,'st_currency',true);
                               echo TravelHelper::format_money_raw($price,$currency);
                               ?>
                            </td>
                            <td class="post-title page-title column-title">
                                <?php echo date(get_option('date_format'),strtotime($value->post_date)) ?>
                            </td>
                            <td class="post-title page-title column-title">
                                <?php echo get_post_meta($order_id, 'status', true) ?>
                            </td>
                            <td class="post-title page-title column-title">
                                <?php
                                    echo STPaymentGateways::get_gatewayname(get_post_meta($order_id,'payment_method',true));
                                 ?>
                            </td>
                        </tr>
                    <?php
                    }
                }

            ?>
        </tbody>
    </table>
    <div class="tablenav bottom">
        <div class="tablenav-pages">
            <span class="displaying-num"><?php echo sprintf(_n('%s item','%s items',$data['total']),$data['total'],ST_TEXTDOMAIN)  ?></span>
            <?php echo paginate_links($paging)?>

        </div>
    </div>

    <?php wp_reset_query();?>
</form>
</div>

