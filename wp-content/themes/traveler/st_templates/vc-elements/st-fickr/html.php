<ul data-uid="<?php echo esc_html($st_user) ?>" data-num="<?php echo esc_attr($st_number) ?>" class="flickr_items clearfix  list-unstyled"></ul>
<script>
    jQuery(document).ready(function($){
        $('.flickr_items').each(function(){

            var user_id=$(this).data('uid');
            var me=$(this);
            var num=$(this).data('num');
            console.log(num);
            if(user_id){
                $.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?id="+user_id+"&format=json&jsoncallback=?", function(data) {
                    for (var i=0; i <= num; i++) {
                        var pic 		= data.items[i];
                        var smallpic 	= pic.media.m.replace('_m.jpg', '_s.jpg');
                        console.log(i);
                        var item = $("<li><a title='" + pic.title + "' href='" + pic.link + "' target='_blank'><img width=\"75px\" height=\"75px\" src='" + smallpic + "' /></a></li>");
                        me.append(item);
                    }
                });
            }
        });
    });
</script>