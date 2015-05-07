jQuery(document).ready(function($){
    $('.btn_add_wishlist').click(function(){
        console.log(st_params.ajax_url);
        $.ajax({
            url: st_params.ajax_url,
            type: "POST",
            data: {
                action      : "st_add_wishlist",
                data_id     : $(this).data('id'),
                data_type   : $(this).data('type')
            },
            dataType: "json",
            beforeSend: function() {

            }
        }).done(function( html ) {
            $('.btn_add_wishlist').html(html.icon).attr("data-original-title",html.title);
        });
    });

    $('.btn_remove_wishlist').click(function(){
        var $this = $(this);
        $.ajax({
            url: st_params.ajax_url,
            type: "POST",
            data: {
                action      : "st_remove_wishlist",
                data_id     : $(this).data('id'),
                data_type   : $(this).data('type')
            },
            dataType: "json",
            beforeSend: function() {
                $('.post-'+$this.attr('data-id')+' .user_img_loading').show();
            }
        }).done(function( html ) {
            if(html.status == 'true'){
                $('.post-'+html.msg).html( console_msg(html.type , html.content ) ).attr("data-original-title",html.title);;
            }else{
                $('.post-'+html.msg).append( console_msg(html.type , html.content ) ).attr("data-original-title",html.title);;
            }
        });
    });
    $('.btn_load_more_wishlist').click(function(){
        var $this = $(this);
        var txt_me =$this.html();
        $.ajax({
            url: st_params.ajax_url,
            type: "GET",
            data: {
                action      : "st_load_more_wishlist",
                data_per    : $('.btn_load_more_wishlist').attr('data-per'),
                data_next    : $('.btn_load_more_wishlist').attr('data-next')
            },
            dataType: "json",
            beforeSend: function() {
                $this.html('Loading...');
            }
        }).done(function( html ) {
            $this.html(txt_me);
            $('#data_whislist').append(html.msg);
            if(html.status == 'true'){
                console.log(html);
                $('.btn_load_more_wishlist').attr('data-per' , html.data_per );
            }else{
                $('.btn_load_more_wishlist').attr('disabled','disabled');
                $('.btn_load_more_wishlist').html('No More');
            }

        });
    });

    $('#btn_add_media').click(function(){
        $('#my_image_upload').click();
    });
    $('#my_image_upload').change(function(){
        $('#submit_my_image_upload').click();
    });

    $('.btn_remove_post_type').click(function(){
        var $this = $(this);
        $.ajax({
            url: st_params.ajax_url,
            type: "POST",
            data: {
                action      : "st_remove_post_type",
                data_id     : $(this).attr('data-id'),
                data_id_user   : $(this).attr('data-id-user')
            },
            dataType: "json",
            beforeSend: function() {
                $('.post-'+$this.attr('data-id')+' .user_img_loading').show();
            }
        }).done(function( html ) {
            console.log(html);
            if(html.status == 'true'){
                $('.post-'+html.msg).html( console_msg(html.type , html.content ) );
            }else{
                $('.post-'+html.msg).append( console_msg(html.type , html.content ) );
            }

        });
    });
    function console_msg( type , content ){
        var txt = '<div class="alert alert-'+type+'"> <button data-dismiss="alert" type="button" class="close"><span aria-hidden="true">×</span> </button> <p class="text-small">'+content+'</p> </div>';
        return txt;
    }

    $('#btn_check_insert_post_type_hotel').click(function(){
        var dk = true;
        if(kt_rong('title','Warning : Title could not left empty')!=true){
            dk = false;
        }
        if(kt_chieudai('title','Warning : Title no shorter than 6 characters',6)!=true){
            dk = false;
        }
        if(kt_rong('desc','Warning : Description could not left empty')!=true){
            dk = false;
        }
        if(kt_rong('id_location','Warning : Location could not left empty')!=true){
            dk = false;
        }
        if(kt_rong('address','Warning : Address could not left empty')!=true){
            dk = false;
        }
        if(kt_rong('email','Warning : Email could not left empty')!=true){
            dk = false;
        }
        if(checkEmail('email','Warning : Email is invalid')!=true){
            dk = false;
        }
        if(kt_rong('website','Warning : Website could not left empty')!=true){
            dk = false;
        }
        if(kt_rong('phone','Warning : Phone could not left empty')!=true){
            dk = false;
        }
        if(kt_rong('map_lat','Warning : Latitude could not left empty')!=true){
            dk = false;
        }
        if(kt_rong('map_lng','Warning : Longitude could not left empty')!=true){
            dk = false;
        }
        if(dk == true){
            console.log('Submit create hotel !');
            $('#btn_insert_post_type_hotel').click();
        }

    });

    $('#btn_check_insert_post_type_room').click(function(){
        var dk = true;
        if(kt_rong('title','Warning : Title could not left empty')!=true){
            dk = false;
        }
        if(kt_chieudai('title','Warning : Title no shorter than 4 characters',4)!=true){
            dk = false;
        }
        if(kt_rong('room_parent','Warning : Hotel could not left empty')!=true){
            dk = false;
        }
        if(kt_rong('number_room','Warning : Number Room could not left empty')!=true){
            dk = false;
        }
        if(kt_rong('price','Warning : Price Per night could not left empty')!=true){
            dk = false;
        }
        if(kt_rong('room_footage','Warning : Room footage could not left empty')!=true){
            dk = false;
        }

        if(dk == true){
            console.log('Submit create hotel !');
            $('#btn_insert_post_type_room').click();
        }
    });

    /* Tours */

    $('#btn_check_insert_post_type_tours').click(function(){
        var dk = true;
        if(kt_rong('title','Warning : Title could not left empty')!=true){
            dk = false;
        }
        if(kt_chieudai('title','Warning : Title no shorter than 4 characters',4)!=true){
            dk = false;
        }
        if(dk == true){
            console.log('Submit create Tours !');
            $('#btn_insert_post_type_tours').click();
        }
    });

    /* activity */
    $('#btn_check_insert_activity').click(function(){
        var dk = true;
        if(kt_rong('title','Warning : Title could not left empty')!=true){
            dk = false;
        }
        if(kt_chieudai('title','Warning : Title no shorter than 4 characters',4)!=true){
            dk = false;
        }
        if(dk == true){
            console.log('Submit create Activity !');
            $('#btn_insert_post_type_activity').click();
        }
    });

    /* Cars */
    $('#btn_check_insert_cars').click(function(){
        var dk = true;
        if(kt_rong('title','Warning : Title could not left empty')!=true){
            dk = false;
        }
        if(kt_chieudai('title','Warning : Title no shorter than 4 characters',4)!=true){
            dk = false;
        }
        if(dk == true){
            console.log('Submit create Cars !');
            $('#btn_insert_post_type_cars').click();
        }
    });

    /* Rental */
    $('#btn_check_insert_post_type_rental').click(function(){
        var dk = true;
        if(kt_rong('title','Warning : Title could not left empty')!=true){
            dk = false;
        }
        if(kt_chieudai('title','Warning : Title no shorter than 4 characters',4)!=true){
            dk = false;
        }
        if(dk == true){
            console.log('Submit create Rental !');
            $('#btn_insert_post_type_rental').click();
        }
    });

    /* Cruise */
    $('#btn_check_insert_post_type_cruise').click(function(){
        var dk = true;
        if(kt_rong('title','Warning : Title could not left empty')!=true){
            dk = false;
        }
        if(kt_chieudai('title','Warning : Title no shorter than 4 characters',4)!=true){
            dk = false;
        }
        if(dk == true){
            console.log('Submit create cruise !');
            $('#btn_insert_post_type_cruise').click();
        }
    });

    /* Cruise Cabin */
    $('#btn_check_insert_cruise_cabin').click(function(){
        var dk = true;
        if(kt_rong('title','Warning : Title could not left empty')!=true){
            dk = false;
        }
        if(kt_chieudai('title','Warning : Title no shorter than 4 characters',4)!=true){
            dk = false;
        }
        if(dk == true){
            console.log('Submit create cruise !');
            $('#btn_insert_cruise_cabin').click();
        }
    });

    function kt_rong(div,thongbao){
        var value = $('#'+div).val();
        if(value=="" ||value==null)
        {
            $('.console_msg_'+div).html( console_msg('danger',thongbao) );
            $('#'+div).css('borderColor',"red");
            return false;
        }else{
            $('.console_msg_'+div).html('');
            $('#'+div).css('borderColor',"#C6DBE0");
            return true;
        }
    }
    function kt_chieudai(div,thongbao,chieudai){
        var value = $('#'+div).val();
        if(value.length ==chieudai || value.length <chieudai)
        {
            $('.console_msg_'+div).html( console_msg('danger',thongbao) );
            $('#'+div).css('borderColor',"red");
            return false;
        }else{
            $('.console_msg_'+div).html('');
            $('#'+div).css('borderColor',"#C6DBE0")
            ;return true;
        }
    }
    function kt_so(div,thongbao){
        var value = $('#'+div).val();
        if(isNaN(value)==true)
        {
            $('.console_msg_'+div).html( console_msg('danger',thongbao) );
            $('#'+div).css('borderColor',"red");
            return false;
        }else{
            $('.console_msg_'+div).html('');
            $('#'+div).css('borderColor',"#C6DBE0");
            return true;
        }
    }
    function checkEmail(div,thongbao) {
        var value = $('#'+div).val();
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)){
            $('.console_msg_'+div).html('');
            $('#'+div).css('borderColor',"#C6DBE0");
            return true;
        }else{
            $('.console_msg_'+div).html( console_msg('danger',thongbao) );
            $('#'+div).css('borderColor',"red");
            return false;
        }
    }

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        $('.data_lable').val(label);
    });
    $('.btn_del_avatar').click(function(){
        $('#id_avatar_user_setting').val('');
        $('.data_lable').val('');
        $(this).parent().remove();
    });

    function str2num(val)
    {
        val = '0' + val;
        val = parseFloat(val);
        return val;
    }


    /* load more histtory book */
    $('.btn_load_his_book').click(function(){
        var $this = $(this);
        var txt_me =$this.html();
        $.ajax({
            url: st_params.ajax_url,
            type: "GET",
            data: {
                action      : "st_load_more_history_book",
                paged    : $('.btn_load_his_book').attr('data-per'),
                show        : "json"
            },
            dataType: "json",
            beforeSend: function() {
                $this.html('Loading...');
            }
        }).done(function( html ) {
            $this.html(txt_me);

            if(html.status == 'true'){
                console.log(html);
                $('.btn_load_his_book').attr('data-per' , html.data_per );
                $('#data_history_book').append(html.html);
            }else{
                $('.btn_load_his_book').attr('disabled','disabled');
                $('.btn_load_his_book').html('No More');
            }

        });
    });

    $('#btn_add_program').click(function(){
        var html = $('#html_program').html();
        console.log(html);
        $('#data_program').append(html);
    });
    $('#btn_add_equipment_item').click(function(){
        var html = $('#html_equipment_item').html();
        console.log(html);
        $('#data_equipment_item').append(html);
    });

    $('#btn_add_features').click(function(){
        var html = $('#html_features').html();
        console.log(html);
        $('#data_features').append(html);
        $('.taxonomy_car').each(function() {
            var $this = $(this);
            var $select_index = $this.context.options.selectedIndex;
            var $icon = $($this.context.options[$select_index]).attr('data-icon');
            $this.parent().find('i').removeAttr('class').attr('class',$icon+' input-icon input-icon-hightlight');
        });

    });

    $('#btn_add_features_rental').click(function(){
        var html = $('#html_features_rental').html();
        console.log(html);
        $('#data_features_rental').append(html);
    });

    $(document).on('click', '.btn_del_program', function() {
        $(this).parent().parent().parent().remove();
    });

    $(document).on('change', '.taxonomy_car', function() {
        var $this = $(this);
        var $select_index = $this.context.options.selectedIndex;
        var $icon = $($this.context.options[$select_index]).attr('data-icon');
        $this.parent().find('i').removeAttr('class').attr('class',$icon+' input-icon input-icon-hightlight');
    });

    $('#menu_partner').click(function(){
         var type = $('#sub_partner').css('display');
        console.log(type);
         if(type == "none"){
             $('#sub_partner').slideDown(1000);
             $('.icon_partner').removeClass("fa-angle-left").addClass("fa-angle-down");
         }else{
             $('#sub_partner').slideUp(1000);
             $('.icon_partner').removeClass("fa-angle-down").addClass("fa-angle-left");
         }
    });

    if($('#sub_partner').find('.active').length > 0){
        $('.icon_partner').removeClass("fa-angle-left").addClass("fa-angle-down");
        $('#sub_partner').parent().addClass('active');
        $('#sub_partner').css('display','block');
    }


});