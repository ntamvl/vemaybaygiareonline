/**
 * Created by me664 on 12/29/14.
 */
jQuery(document).ready(function($){

    $(document).on('click','.payment_gateway_item .st_payment_gatewaw_submit',function(){
        var me=$(this).parents('.booking_modal_form');

        $(this).next('.icon_loading').remove();
        $(this).after('<span class="icon_loading"><i class="fa fa-spin fa-refresh"></i></span>');

        submit_form(me,$(this));
    });

    $(document).on('click','.btn_hotel_booking',function(){
        var form=$(this).closest('form');
        if(!checkRequiredBooking(form))
        {
            return false;
        }

        var tar_get=$(this).data('target');

        $.magnificPopup.open({
            items: {
                type: 'inline',
                src: tar_get
            }

        });

    });
    function do_scrollTo(el)
    {
        if(el.length){
            var top=el.offset().top;
            if($('#wpadminbar').length && $('#wpadminbar').css('position')=='fixed')
            {
                top-=32;
            }
            top-=50;
            $('html,body').animate({
                'scrollTop':top
            },500);
        }
    }

    function setMessage(holder,message,type)
    {
        if(typeof  type=='undefined'){
            type='infomation';
        }
        var html='<div class="alert alert-'+type+'">'+message+'</div>';
        if(!holder.length) return;
        holder.html('');
        holder.html(html);
        do_scrollTo(holder);
    }


    function checkRequiredBooking(searchbox)
    {
        var searchform=$('.booking-item-dates-change');
        if(typeof searchbox!="undefined")
        {
            var data=searchbox.find('input,select,textarea').serializeArray();
        }

        var dataobj = {};
        for (var i = 0; i < data.length; ++i)
            dataobj[data[i].name] = data[i].value;

        var holder=$('.search_room_alert');

        holder.html('');
        if(dataobj.room_num_search=="1"){
            if(dataobj.adult_num=="" || dataobj.child_num=='' ||typeof dataobj.adult_num=='undefined' || typeof dataobj.child_num=='undefined'){

                setMessage(holder,st_hotel_localize.booking_required_adult_children,'danger');
                return false;
            }

        }
        if(dataobj.check_in=="" || dataobj.check_out=='')
        {
            if(dataobj.check_in==""){
                searchform.find('[name=start]').addClass('error');
            }
            if(dataobj.check_out==""){
                searchform.find('[name=end]').addClass('error');
            }
            setMessage(holder,st_hotel_localize.is_not_select_date,'danger');
            return false;
        }

        return true;

    }

    function submit_form(me,clicked)
    {
        var data=me.find("select,textarea, input").serializeArray();

        me.find('.form-control').removeClass('error');


        data.push(
            {
                name:'action',
                value:'booking_form_submit'
            }
        );


        me.find('.form_alert').addClass('hidden');
        var dataobj = {};

        var form_validate=true;


        for (var i = 0; i < data.length; ++i)
        {
            dataobj[data[i].name] = data[i].value;
            var name=data[i].name;

        }
        me.find('input.required,select.required,textarea.required').removeClass('error');
        me.find('input.required,select.required,textarea.required').each(function(){
            if(!$(this).val())
            {
                $(this).addClass('error');
                form_validate=false;

            }
        });



        dataobj[clicked.attr('name')]=clicked.attr('value');

        if(form_validate==false){
            me.find('.form_alert').addClass('alert-danger').removeClass('hidden');
            me.find('.form_alert').html(st_checkout_text.validate_form);
            me.find('.icon_loading').remove();
            return false;
        }

        //term_condition
        if(!dataobj.term_condition){
            me.find('.form_alert').addClass('alert-danger').removeClass('hidden');
            me.find('.form_alert').html(st_checkout_text.error_accept_term);

            me.find('.icon_loading').remove();
            return false;
        }
        //console.log(dataobj);


        me.addClass('loading');
        $.ajax({
            'type':'post',
            'dataType':'json',
            'url':st_params.ajax_url,
            'data':dataobj,
            'success':function(data){
                me.removeClass('loading');

                if(data.message){
                    me.find('.form_alert').addClass('alert-danger').removeClass('hidden');
                    me.find('.form_alert').html(data.message);
                }

                if(data.redirect){
                    window.location.href=data.redirect;
                }

                me.find('.icon_loading').remove();

                var widget_id='st_recaptchar_'+dataobj.item_id;

                get_new_captcha(me);
            },
            error:function(data){

                me.removeClass('loading');
                alert('Ajax Fail');

                me.find('.icon_loading').remove();

                var widget_id='st_recaptchar_'+dataobj.item_id;

                get_new_captcha(me);

            }
        });

        function get_new_captcha(me)
        {
            var captcha_box=me.find('.captcha_box');
            url=captcha_box.find('.captcha_img').attr('src');
            captcha_box.find('.captcha_img').attr('src',url);
        }
    }
});