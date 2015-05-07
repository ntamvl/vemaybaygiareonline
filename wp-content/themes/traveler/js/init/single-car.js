/**
 * Created by me664 on 3/2/15.
 */

jQuery(document).ready(function($){

    var message_box=$('.car_booking_form .message_box');
    var car_booking_form=$('.car_booking_form');

    $('.car_booking_form input[type=submit]').click(function(){
        if(validate_car_booking()){
            car_booking_form.submit();
        }else
        {
            return false;
        }

    });

    $('.car_booking_form .btn_booking_modal').click(function(){
        if(validate_car_booking()){
            var tar_get=$(this).data('target');

            $.magnificPopup.open({
                items: {
                    type: 'inline',
                    src: tar_get
                }

            });
        }
    });

    function validate_car_booking()
    {
        var form_validate=true;

        message_box.html('');
        message_box.removeClass('alert');

        var data_price_cars=car_booking_form.find('.data_price_cars').val();

        try{
            data=JSON.parse(data_price_cars);

            if(
              !data.pick_up
            ||!data.drop_off
            ){
                form_validate=false;
                $('.popup-text[href=#search-dialog]').trigger('click');
            }

        }catch(e){
            console.log(e);
        }

        return form_validate;
    }
});