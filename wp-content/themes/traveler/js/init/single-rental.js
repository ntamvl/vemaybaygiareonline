/**
 * Created by me664 on 3/3/15.
 */
jQuery(document).ready(function($){

    $('.btn_booking_modal').click(function(){
       var form=$(this).closest('form');
       $('.alert',form).remove();
        var validate_form=true;
        var data=[];

        $('input.required,textarea.required,select.required',form).each(function(){

            $(this).removeClass('error');
            if(!$(this).val()){
                validate_form=false;
                $(this).addClass('error');
            }

            if($(this).attr('name')){
                data.push({
                    'value':$(this).val(),
                    'name':$(this).attr('name')
                });
            }

        });

        if(!validate_form)
        {
            form.prepend('<div class="alert alert-danger">'+st_checkout_text.validate_form+'</div>');
            return false;
        }else
        {
            var tar_get=$(this).data('target');

            for(i=0;i<data.length;i++)
            {
                var val=data[i];
                $(tar_get).find('.booking_modal_form').prepend('<input type="hidden" name="'+val.name+'" value="'+val.value+'">');
            }

            $.magnificPopup.open({
                items: {
                    type: 'inline',
                    src: tar_get
                }

            });
        }
    });


});