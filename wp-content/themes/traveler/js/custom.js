jQuery(document).ready(function($){

    "use strict";

    $('ul.slimmenu').slimmenu({
        resizeWidth: '992',
        collapserTitle: 'Main Menu',
        animSpeed: 250,
        indentChildren: true,
        childrenIndenter: ''
    });


    // Countdown
    $('.countdown').each(function() {
        var count = $(this);
        var count = $(this);
        $(this).countdown({
            zeroCallback: function(options) {
                var newDate = new Date(),
                    newDate = newDate.setHours(newDate.getHours() + 130);

                $(count).attr("data-countdown", newDate);
                $(count).countdown({
                    unixFormat: true
                });
            }
        });
    });


    $('.btn').button();

    $("[rel='tooltip']").tooltip();

    $('.form-group').each(function() {
        var self = $(this),
            input = self.find('input');

        input.focus(function() {
            self.addClass('form-group-focus');
        })

        input.blur(function() {
            if (input.val()) {
                self.addClass('form-group-filled');
            } else {
                self.removeClass('form-group-filled');
            }
            self.removeClass('form-group-focus');
        });
    });

    $('.typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 3,
            limit: 8
        }, {
            source: function(q, cb) {
                return $.ajax({
                    dataType: 'json',
                    type: 'get',
                    url: 'http://gd.geobytes.com/AutoCompleteCity?callback=?&q=' + q,
                    chache: false,
                    success: function(data) {
                        var result = [];
                        $.each(data, function(index, val) {
                            result.push({
                                value: val
                            });
                        });
                        cb(result);
                    }
                });
            }
        });

    $('.typeahead_location').typeahead({
            hint: true,
            highlight: true,
            minLength: 3,
            limit: 8
        },
        {
            source: function(q, cb) {
                return $.ajax({
                    dataType: 'json',
                    type: 'get',
                    url: st_params.ajax_url,
                    data:{
                        security:st_params.st_search_nonce,
                        action:'st_search_location',
                        s:q
                    },
                    cache: true,
                    success: function(data) {
                        var result = [];
                        if(data.data){
                            $.each(data.data, function(index, val) {
                                result.push({
                                    value: val.title,
                                    location_id:val.id,
                                    type_color:'success',
                                    type:val.type
                                });
                            });
                            cb(result);
                        }

                    }
                });
            },
            templates: {
                suggestion: Handlebars.compile('<p><label class="label label-{{type_color}}">{{type}}</label><strong> {{value}}</strong></p>')
            }
        });
    $('.typeahead_location').bind('typeahead:selected', function(obj, datum, name) {
        var parent=$(this).parents('.form-group');
        parent.find('.location_id').val(datum.location_id);
    });
    $('.typeahead_location').keyup(function(){
        var parent=$(this).parents('.form-group');
        parent.find('.location_id').val('');
    });

    $('input.date-pick, .input-daterange, .date-pick-inline').datepicker({
        todayHighlight: true
    });




    //$('input.date-pick, .input-daterange input[name="start"]').datepicker(/*'setDate', 'today'*/);
    //$('.input-daterange input[name="end"]').datepicker(/*'setDate', '+1d'*/);



    $('.input-daterange input[name="start"]').each(function(){
        var form=$(this).closest('form');
        var me=$(this);
        $(this).datepicker(
            'setStartDate','today'
        );
        $(this).datepicker().on('changeDate', function(e) {

                var new_date= e.date;
                console.log(new_date);
                new_date.setDate(new_date.getDate() + 1);
                form.find('.input-daterange [name="end"]').datepicker('setStartDate',new_date);
            }
        );

        form.find('.input-daterange [name="end"]').datepicker(
            'setStartDate','+1d'
        );
        form.find('.input-daterange [name="end"]').on('changeDate', function(e) {

                var new_date= e.date;
                console.log(new_date);
                new_date.setDate(new_date.getDate() - 1);
                me.datepicker('setEndDate',new_date);
            }
        );
    })

    $('.pick-up-date').each(function(){
        var form=$(this).closest('form');
        var me=$(this);
        $(this).datepicker(
            'setStartDate','today'
        );
        $(this).datepicker().on('changeDate', function(e) {
                var new_date= e.date;
                console.log(new_date);
                new_date.setDate(new_date.getDate() + 1);
                form.find('.drop-off-date').datepicker('setStartDate',new_date);
            }
        );

        form.find('.drop-off-date').datepicker(
            'setStartDate','+1d'
        );
        form.find('.drop-off-date').on('changeDate', function(e) {

                var new_date= e.date;
                console.log(new_date);
                new_date.setDate(new_date.getDate() - 1);
                me.datepicker('setEndDate',new_date);
            }
        );
    })

    $('.tour_book_date').datepicker(
        'setStartDate','today'
    );
    $('.tour_book_date').datepicker(
        'setDate','today'
    );

    /*$('.tour_book_date').datepicker(
        'setStartDate',$('.tour_book_date').attr('data-start')
    );
    $('.tour_book_date').datepicker(
        'setEndDate',$('.tour_book_date').attr('data-end')
    );
    $('.tour_book_date').datepicker(
        'setDate',$('.tour_book_date').attr('')
    );*/


    /*$('.pick-up-date').datepicker(
        'setStartDate','today'
    );
    $('.drop-off-date').datepicker(
        'setStartDate','+1d'
    );
    if($('.pick-up-date').val()){
        console.log($('.pick-up-date').val());
        $('.pick-up-date').datepicker('setDate', $('.pick-up-date').val());
    }else{
        $('.pick-up-date').datepicker('setDate', 'today');
    }
    if($('.drop-off-date').val()){
        $('.drop-off-date').datepicker('setDate', $('.drop-off-date').val());
    }else{
        $('.drop-off-date').datepicker('setDate', '+1d');
    }*/

    $('input.time-pick').timepicker({
        minuteStep: 15,
        showInpunts: false
    })

    $('input.date-pick-years').datepicker({
        startView: 2
    });




    $('.booking-item-price-calc .checkbox label').click(function() {
        var checkbox = $(this).find('input'),
            // checked = $(checkboxDiv).hasClass('checked'),
            checked = $(checkbox).prop('checked'),
            price = parseInt($(this).find('span.pull-right').html().replace('$', '')),
            eqPrice = $('#car-equipment-total'),
            tPrice = $('#car-total'),
            eqPriceInt = parseInt(eqPrice.attr('data-value')),
            tPriceInt = parseInt(tPrice.attr('data-value')),
            value,
            animateInt = function(val, el, plus) {
                value = function() {
                    if (plus) {
                        return el.attr('data-value', val + price);
                    } else {
                        return el.attr('data-value', val - price);
                    }
                };
                return $({
                    val: val
                }).animate({
                    val: parseInt(value().attr('data-value'))
                }, {
                    duration: 500,
                    easing: 'swing',
                    step: function() {
                        if (plus) {
                            el.text(Math.ceil(this.val));
                        } else {
                            el.text(Math.floor(this.val));
                        }
                    }
                });
            };
        if (!checked) {
            animateInt(eqPriceInt, eqPrice, true);
            animateInt(tPriceInt, tPrice, true);
        } else {
            animateInt(eqPriceInt, eqPrice, false);
            animateInt(tPriceInt, tPrice, false);
        }
    });


    $('div.bg-parallax').each(function() {
        var $obj = $(this);
        if($(window).width() > 992 ){
            $(window).scroll(function() {
                var animSpeed;
                if ($obj.hasClass('bg-blur')) {
                    animSpeed = 10;
                } else {
                    animSpeed = 15;
                }
                var yPos = -($(window).scrollTop() / animSpeed);
                var bgpos = '50% ' + yPos + 'px';
                $obj.css('background-position', bgpos);

            });
        }
    });



    $(document).ready(
        function() {




            // Owl Carousel
            var owlCarousel = $('#owl-carousel'),
                owlItems = owlCarousel.attr('data-items'),
                owlCarouselSlider = $('#owl-carousel-slider'),
                owlNav = owlCarouselSlider.attr('data-nav');
            // owlSliderPagination = owlCarouselSlider.attr('data-pagination');

            owlCarousel.owlCarousel({
                items: owlItems,
                navigation: true,
                navigationText: ['', '']
            });

            owlCarouselSlider.owlCarousel({
                slideSpeed: 300,
                paginationSpeed: 400,
                // pagination: owlSliderPagination,
                singleItem: true,
                navigation: true,
                navigationText: ['', ''],
                transitionStyle: 'fade',
                autoPlay: 4500
            });


        // footer always on bottom
        var docHeight = $(window).height();
       var footerHeight = $('#main-footer').height();
       var footerTop = $('#main-footer').position().top + footerHeight;

       if (footerTop < docHeight) {
        $('#main-footer').css('margin-top', (docHeight - footerTop) + 'px');
       }
        }


    );
    $(document).ready(function(){
        $('#slide-testimonial').each(function(){
            var $this = $(this);
            $this.owlCarousel({
                slideSpeed: $this.attr('data-speed'),
                paginationSpeed: 400,
                // pagination: owlSliderPagination,
                singleItem: true,
                navigation: true,
                navigationText: ['', ''],
                transitionStyle: 'fade',
                autoPlay: $this.attr('data-play')
            });
        })
    });


    $('.nav-drop').click(function(){
        if($(this).hasClass('active-drop'))
        {
            $(this).removeClass('active-drop');
        }else
        {
            $('.nav-drop').removeClass('active-drop');
            $(this).addClass('active-drop');

        }
    });


    $(document).mouseup(function (e)
    {
        var container = $(".nav-drop");

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $('.nav-drop').removeClass('active-drop');
        }
    });

    $(".price-slider").each(function(){
        var min=$(this).data('min');
        var max=$(this).data('max');
        var step=$(this).data('step');

        var value=$(this).val();

        var from=value.split(';');

        var to=from[1]
        from=from[0];

        var arg={
            min: min,
            max: max,
            type: 'double',
            prefix: "$",
            // maxPostfix: "+",
            prettify: false,
            grid: true,
            step:step,
            grid_snap:true,
            onFinish:function(data){
                //console.log(data);
                //console.log(window.location.href);
            },
            from:from,
            to:to
        };

        if(!step){
            delete arg.step;
            delete arg.grid_snap;
        }

        console.log(arg);

        //console.log(min);
        $(this).ionRangeSlider(arg);
    });
    $("#price-slider").ionRangeSlider({
        min: 130,
        max: 575,
        type: 'double',
        prefix: "$",
        // maxPostfix: "+",
        prettify: false,
        grid: true
    });

    $('.i-check, .i-radio').iCheck({
        checkboxClass: 'i-check',
        radioClass: 'i-radio'
    });



    $('.booking-item-review-expand').click(function(event) {
        var parent = $(this).parent('.booking-item-review-content');
        if (parent.hasClass('expanded')) {
            parent.removeClass('expanded');
        } else {
            parent.addClass('expanded');
        }
    });
    $('.expand_search_box').click(function(event) {
        var parent = $(this).parent('.search_advance');
        if (parent.hasClass('expanded')) {
            parent.removeClass('expanded');
        } else {
            parent.addClass('expanded');
        }
    });


    $('.stats-list-select > li > .booking-item-rating-stars > li').each(function() {
        var list = $(this).parent(),
            listItems = list.children(),
            itemIndex = $(this).index(),
             parentItem=list.parent();

        $(this).hover(function() {
            for (var i = 0; i < listItems.length; i++) {
                if (i <= itemIndex) {
                    $(listItems[i]).addClass('hovered');
                } else {
                    break;
                }
            };
            $(this).click(function() {
                for (var i = 0; i < listItems.length; i++) {
                    if (i <= itemIndex) {
                        $(listItems[i]).addClass('selected');
                    } else {
                        $(listItems[i]).removeClass('selected');
                    }
                };

                parentItem.children('.st_review_stats').val(itemIndex+1);

            });
        }, function() {
            listItems.removeClass('hovered');
        });
    });



    $('.booking-item-container').children('.booking-item').click(function(event) {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).parent().removeClass('active');
        } else {
            $(this).addClass('active');
            $(this).parent().addClass('active');
            $(this).delay(1500).queue(function() {
                $(this).addClass('viewed')
            });
        }
    });


    //$('.form-group-cc-number input').payment('formatCardNumber');
    //$('.form-group-cc-date input').payment('formatCardExpiry');
    //$('.form-group-cc-cvc input').payment('formatCardCVC');




    if ($('#map-canvas').length) {
        var map,
            service;

        jQuery(function($) {
            $(document).ready(function() {
                var latlng = new google.maps.LatLng(40.7564971, -73.9743277);
                var myOptions = {
                    zoom: 16,
                    center: latlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: false
                };

                map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);


                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                });
                marker.setMap(map);


                $('a[href="#google-map-tab"]').on('shown.bs.tab', function(e) {
                    google.maps.event.trigger(map, 'resize');
                    map.setCenter(latlng);
                });
            });
        });
    }


    $('.card-select > li').click(function() {
         var self = this;
        $(self).addClass('card-item-selected');
        $(self).siblings('li').removeClass('card-item-selected');
        $('.form-group-cc-number input').click(function() {
            $(self).removeClass('card-item-selected');
        });
    });
    // Lighbox gallery
    $('#popup-gallery').each(function() {
        $(this).magnificPopup({
            delegate: 'a.popup-gallery-image',
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    });

    $('.st-popup-gallery').each(function() {
        $(this).magnificPopup({
            delegate: '.st-gp-item',
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    });

    // Lighbox image
    $('.popup-image').magnificPopup({
        type: 'image'
    });

    // Lighbox text
    $('.popup-text').magnificPopup({
        removalDelay: 500,
        closeBtnInside: true,
        callbacks: {
            beforeOpen: function() {
                this.st.mainClass = this.st.el.attr('data-effect');
            }
        },
        midClick: true
    });

    // Lightbox iframe
    $('.popup-iframe').magnificPopup({
        dispableOn: 700,
        type: 'iframe',
        removalDelay: 160,
        mainClass: 'mfp-fade',
        preloader: false
    });


    $('.form-group-select-plus').each(function() {
        var self = $(this),
            btnGroup = self.find('.btn-group').first(),
            select = self.find('select');
        btnGroup.children('label').last().click(function() {
            btnGroup.addClass('hidden');
            select.removeClass('hidden');
        });
        btnGroup.children('label').click(function(){
            var c=$(this);
            select.find('option[value='+ c.children('input').val()+']').prop('selected','selected');
            if(!c.hasClass('active'))
            select.trigger('change');
        });
    });
    // Responsive videos
    $(document).ready(function() {
        //$("body").fitVids();
    });

    //$(function($) {
    //    $("#twitter").tweet({
    //        username: "remtsoy", //!paste here your twitter username!
    //        count: 3
    //    });
    //});

    //$(function($) {
    //    $("#twitter-ticker").tweet({
    //        username: "remtsoy", //!paste here your twitter username!
    //        page: 1,
    //        count: 20
    //    });
    //});

    $(document).ready(function() {
        var ul = $('#twitter-ticker').find(".tweet-list");
        var ticker = function() {
            setTimeout(function() {
                ul.find('li:first').animate({
                    marginTop: '-4.7em'
                }, 850, function() {
                    $(this).detach().appendTo(ul).removeAttr('style');
                });
                ticker();
            }, 5000);
        };
        ticker();
    });
    $(function() {
        var $girl_ri = $('#ri-grid');
        if($.fn.gridrotator!== undefined){
            $girl_ri.gridrotator({
                rows: $girl_ri.attr('data-row'),
                columns: $girl_ri.attr('data-col'),
                animType: 'random',
                animSpeed: 1200,
                interval: $girl_ri.attr('data-speed'),
                step: 'random',
                preventClick: false,
                maxStep: 2,
                w992: {
                    rows: 5,
                    columns: 4
                },
                w768: {
                    rows: 6,
                    columns: 3
                },
                w480: {
                    rows: 8,
                    columns: 3
                },
                w320: {
                    rows: 5,
                    columns: 4
                },
                w240: {
                    rows: 6,
                    columns: 4
                }
            });
        }


    });


    $(function() {
        if($.fn.gridrotator!== undefined) {
            $('#ri-grid-no-animation').gridrotator({
                rows: 4,
                columns: 8,
                slideshow: false,
                w1024: {
                    rows: 4,
                    columns: 6
                },
                w768: {
                    rows: 3,
                    columns: 3
                },
                w480: {
                    rows: 4,
                    columns: 4
                },
                w320: {
                    rows: 5,
                    columns: 4
                },
                w240: {
                    rows: 6,
                    columns: 4
                }
            });
        }

    });

    var tid = setInterval(tagline_vertical_slide, 2500);

    // vertical slide
    function tagline_vertical_slide() {
        var curr = $("#tagline ul li.active");
        curr.removeClass("active").addClass("vs-out");
        setTimeout(function() {
            curr.removeClass("vs-out");
        }, 500);

        var nextTag = curr.next('li');
        if (!nextTag.length) {
            nextTag = $("#tagline ul li").first();
        }
        nextTag.addClass("active");
    }

    function abortTimer() { // to be called when you want to stop the timer
        clearInterval(tid);
    }

    $('#comments #submit').addClass('btn btn-primary');


    //Button Like Review
    $('.st-like-review').click(function(e){

        e.preventDefault();

        var me=$(this);


        if(!me.hasClass('loading'))
        {
            var comment_id=me.data('id');
            var loading=$('<i class="loading_icon fa fa-spinner fa-spin"></i>');

            me.addClass('loading');
            me.before(loading);

            $.ajax({

                url:st_params.ajax_url,
                type:'post',
                dataType:'json',
                data:{
                  action:'like_review',
                  comment_ID:comment_id
                },
                success:function(res)
                {
                    if(res.status)
                    {
                        if(res.data.like_status)
                        {
                            me.addClass('fa-thumbs-o-down').removeClass('fa-thumbs-o-up');
                        }else
                        {
                            me.addClass('fa-thumbs-o-up').removeClass('fa-thumbs-o-down');
                        }

                        if(typeof res.data.like_count!=undefined)
                        {
                            res.data.like_count=parseInt(res.data.like_count);
                            me.next('.text-color').html(' '+res.data.like_count);
                        }
                    }else
                    {
                        if(res.error.error_message)
                        {
                            alert(res.error.error_message);
                        }
                    }
                    me.removeClass('loading');
                    loading.remove();
                },
                error:function(res){
                    console.log(res);
                    alert('Ajax Faild');
                    me.removeClass('loading');
                    loading.remove();
                }
            });
        }


    });

    //Button Like Review
    $('.st-like-comment').click(function(e){

        e.preventDefault();

        var me=$(this);


        if(!me.hasClass('loading'))
        {
            var comment_id=me.data('id');
            var loading=$('<i class="loading_icon fa fa-spinner fa-spin"></i>');

            me.addClass('loading');
            me.before(loading);

            $.ajax({

                url:st_params.ajax_url,
                type:'post',
                dataType:'json',
                data:{
                    action:'like_review',
                    comment_ID:comment_id
                },
                success:function(res)
                {
                    console.log(res);
                    if(res.status)
                    {
                        if(res.data.like_status)
                        {
                            me.addClass('fa-heart').removeClass('fa-heart-o');
                        }else
                        {
                            me.addClass('fa-heart-o').removeClass('fa-heart');
                        }

                        if(typeof res.data.like_count!=undefined)
                        {
                            res.data.like_count=parseInt(res.data.like_count);
                            me.next('.text-color').html(' '+res.data.like_count);
                        }
                    }else
                    {
                        if(res.error.error_message)
                        {
                            alert(res.error.error_message);
                        }
                    }
                    me.removeClass('loading');
                    loading.remove();
                },
                error:function(res){
                    console.log(res);
                    alert('Ajax Faild');
                    me.removeClass('loading');
                    loading.remove();
                }
            });
        }


    });




    // vc-element cars
    $('.singe_cars .iCheck-helper').click(function(){
        var price_total_item = 0;
        var person_ob = new Object();
       $('.singe_cars').find('.equipment').each(function(event){
            if($(this)[0].checked == true){
                person_ob[ $(this).attr('data-title') ] = str2num($(this).attr('data-price'));
                price_total_item = price_total_item + str2num($(this).attr('data-price'));
            }
        });
        $('.data_price_items').val( JSON.stringify(person_ob) );

        var price_total = price_total_item + str2num($('.st_cars_price').attr('data-value'));
        $.ajax({
            url: st_params.ajax_url,
            type: "POST",
            data: {
                action           : "st_price_cars",
                price_total_item : price_total_item,
                price_total      : price_total
            },
            dataType: "json",
            beforeSend: function() {
                $('.cars_price_img_loading ').html('<div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>');
            }
        }).done(function( html ) {
            $('.st_data_car_equipment_total').attr('data-value',html.price_total_item_number).html(html.price_total_item_text);
            $('.data_price_total').val(html.price_total_number);
            $('.st_data_car_total').html(html.price_total_text);
            $('.cars_price_img_loading ').html('');
        });
    });
    function str2num(val)
    {
        val = '0' + val;
        val = parseFloat(val);
        return val;
    }

    $('.share li>a').click(function(){
        var href=$(this).attr('href');
        if(href && $(this).hasClass('no-open')==false){


            popupwindow(href,'',600,600);
            return false;
        }
    });

    function popupwindow(url, title, w, h) {
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
    }

    $('.social_login_nav_drop .login_social_link').click(function(){
            var href=$(this).attr('href');

            popupwindow(href,'',600,450);
            return false;
        }

    );


    // Reload for social window login

});

