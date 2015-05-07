/**
 * Created by me664 on 1/13/15.
 */
jQuery(document).ready(function($){
    if(typeof $.fn.sticky!='undefined'){
        var topSpacing=0;
        if($(window).width()>481 && $('body').hasClass('admin-bar')){
            topSpacing=$('#wpadminbar').height();
        }
        console.log(topSpacing);

        $('.enable_sticky_menu .main_menu_wrap').sticky({topSpacing:topSpacing});
    }


    if($('body').hasClass('search_enable_preload'))
    {
        window.setTimeout(function(){
            $('.full-page-absolute').fadeOut().addClass('.hidden');
        },3000);
    }
    /*Begin gotop*/
    $('#gotop').click(function(){
        $("body,html").animate({
            scrollTop:0
        },1000,function(){
            $('#gotop').fadeOut();
        });
    });

    $(window).scroll(function(){
        var scrolltop=$(window).scrollTop();

        if(scrolltop>200){
            $('#gotop').fadeIn();
        }else{
            $('#gotop').fadeOut();
        }

    });

    var top_ajax_search=$('.st-top-ajax-search');

    top_ajax_search.typeahead({
            hint: true,
            highlight: true,
            minLength: 3,
            limit: 8
        },
        {
            source: function(q, cb) {
                $('.st-top-ajax-search').parent().addClass('loading');
                return $.ajax({
                    dataType: 'json',
                    type: 'get',
                    url: st_params.site_url,
                    data:{
                        security:st_params.st_search_nonce,
                        action:'st_top_ajax_search',
                        s:q
                    },
                    cache:true,
                    success: function(data) {
                        $('.st-top-ajax-search').parent().removeClass('loading');
                        var result = [];
                        if(data.data){
                            $.each(data.data, function(index, val) {
                                result.push({
                                    value: val.title,
                                    location_id:val.id,
                                    type_color:'success',
                                    type:val.type,
                                    url:val.url
                                });
                            });
                            cb(result);
                            console.log(result);
                        }

                    },
                    error:function(e){
                        $('.st-top-ajax-search').parent().removeClass('loading');
                    }
                });
            },
            templates: {
                suggestion: Handlebars.compile('<p class="search-line-item"><label class="label label-{{type_color}}">{{type}}</label><strong> {{value}}</strong></p>')
            }
        });

    top_ajax_search.bind('typeahead:selected', function(obj, datum, name) {
        if(datum.url){
            window.location.href=datum.url;
        }
    });

    // Single Tours
    $('.st_tour_number').change(function(){
        var $number = $(this).val();
        $('.st_tour_number').val($number);
    });
    $('.tour_book_date').change(function(){
        var $number = $(this).val();
        $('.tour_book_date').val($number);
    });
    $('.st_tour_adult').change(function(){
        var $number = $(this).val();
        $('.st_tour_adult').val($number);
    });

    $('.st_tour_children').change(function(){
        var $number = $(this).val();
        $('.st_tour_children').val($number);
    });

    if($.fn.chosen){
        $(".chosen_select").chosen();
    }

    $('.woocommerce-ordering .posts_per_page').change(function(){
        $('.woocommerce-ordering').submit();
    });
    var product_timeout;
    $('.woocommerce li.product').hover(function(){
        var me=$(this);
        product_timeout=window.setTimeout(function(){
            me.find('.product-info-hide').slideDown('fast');
        },250);
    },function(){
        window.clearTimeout(product_timeout);
        var me=$(this);
        me.find('.product-info-hide').slideUp('fast');
    });

});