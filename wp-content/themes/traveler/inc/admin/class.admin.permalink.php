<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STAdminPermalink
 *
 * Created by ShineTheme
 *
 */
if(!class_exists('STAdminPermalink')) {

    class STAdminPermalink extends STAdmin
    {
        public function __construct() {
            $this->settings_init();
            $this->settings_save();
        }
        public function settings_init()
        {
            add_action( 'current_screen', array( $this, 'conditonal_includes' ) );
        }
        public function conditonal_includes(){
            add_settings_section('traver-permalink', __('Traver permalink base', ST_TEXTDOMAIN), array($this, 'settings'), 'permalink');
        }
        /**
         * Show the settings.
         */
        public function settings() {
            $hotel_permalink = get_option( 'hotel_permalink' ,'st_hotel' );
            $rental_permalink = get_option( 'rental_permalink' ,'st_rental' );
            $car_permalink = get_option( 'car_permalink' ,'st_car' );
            $activity_permalink = get_option( 'activity_permalink' ,'st_activity' );
            $tour_permalink = get_option( 'tour_permalink' ,'st_tour' );
            ?>
            <table class="form-table">
                <tbody>
                <tr>
                    <th><label><?php _e( 'Hotel Custom Base', ST_TEXTDOMAIN ); ?></label></th>
                    <td>
                        <input name="hotel_permalink"  type="text" value="<?php echo esc_attr( $hotel_permalink ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label><?php _e( 'Rental Custom Base', ST_TEXTDOMAIN ); ?></label></th>
                    <td>
                        <input name="rental_permalink"  type="text" value="<?php echo esc_attr( $rental_permalink ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label><?php _e( 'Car Custom Base', ST_TEXTDOMAIN ); ?></label></th>
                    <td>
                        <input name="car_permalink" type="text" value="<?php echo esc_attr( $car_permalink ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label><?php _e( 'Tour Custom Base', ST_TEXTDOMAIN ); ?></label></th>
                    <td>
                        <input name="tour_permalink" type="text" value="<?php echo esc_attr( $tour_permalink ); ?>" class="regular-text code">
                    </td>
                </tr>
                <tr>
                    <th><label><?php _e( 'Activity Custom Base', ST_TEXTDOMAIN ); ?></label></th>
                    <td>
                        <input name="activity_permalink" type="text" value="<?php echo esc_attr( $activity_permalink ); ?>" class="regular-text code">
                    </td>
                </tr>
                </tbody>
            </table>
        <?php
        }

        public function settings_save() {

            if ( ! is_admin() ) {
                return;
            }
            if ( isset( $_POST['hotel_permalink'] )
                || isset( $_POST['rental_permalink'] )
                || isset( $_POST['car_permalink'] )
                || isset( $_POST['tour_permalink'] )
                || isset( $_POST['activity_permalink'] )
            ) {
                update_option( 'hotel_permalink', $_POST['hotel_permalink'] );
                update_option( 'rental_permalink', $_POST['rental_permalink'] );
                update_option( 'car_permalink', $_POST['car_permalink'] );
                update_option( 'tour_permalink', $_POST['tour_permalink'] );
                update_option( 'activity_permalink', $_POST['activity_permalink'] );
            }
        }


    }
    return new STAdminPermalink();
}
