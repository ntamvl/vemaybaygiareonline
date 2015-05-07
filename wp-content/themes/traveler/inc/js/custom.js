/*

jQuery(document).ready(function($){
    $(document).on('click','#btn_add_filter','',function(){
        $('.tmp_data_add_type').show();
        $('.div_title_filter').show();
    });

    $(document).on('click','.add_type','',function(){
        var $this = $(this);
        var data_type = $this.attr('data-type');
        var data_value =$this.attr('data-value');

        var data_json = '';
        $('.data_json').each(function(){
            data_json = $(this).val();
        });
        if(data_json != ''){
            data_json = JSON.parse(data_json);
        }
        var title_filter ='';
        $('.title_filter').each(function(){
             title_filter = $(this).val();
        });


        $.ajax({
            url: ajaxurl,
            type: "GET",
            data: {
                action          : "add_type_widget",
                data_type       : data_type ,
                data_json       : data_json ,
                title_filter    : title_filter,
                data_value      : data_value
            },
            dataType: "json",
            beforeSend: function() {

            }
        }).done(function( html ) {
            $('.data_json').each(function(){
               $(this).val( JSON.stringify(html) );
            });
            $('.data_widget').each(function(){
              $(this).append(html.data_html)
            });
            $('.title_filter').each(function(){
                $(this).val('');
            });

        });

    });

    $(document).on('click','.list_taxonomy','',function(){
        $.ajax({
            url: ajaxurl,
            type: "GET",
            data: {
                action          : "load_list_taxonomy"
            },
            dataType: "html",
            beforeSend: function() {

            }
        }).done(function( html ) {
            $('.tmp_data_add_type').each(function(){
                $(this).hide();
            });

            $('.tmp_data_taxonomy').each(function(){
                $(this).show();
                $(this).html( html );
            });

        });

    });

    $(document).on('click','.btn_del_tmp_data_taxonomy','',function(){
          $('.tmp_data_taxonomy').each(function(){
              $(this).html('');
          });
    });





});
*/
