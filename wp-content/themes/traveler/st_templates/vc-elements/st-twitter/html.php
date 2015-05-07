
<div class="st_twitter <?php  echo esc_attr($class) ?>" id="">
    <div class=" owl-carousel owl-theme" id="owl-twitter" >
       <?php echo balanceTags($html); ?>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {

        $("#owl-twitter").owlCarousel({

            navigation : true, // Show next and prev buttons
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem:true,
            navigationText :	["",""],
            pagination:false,
            autoPlay:true
            // "singleItem:true" is a shortcut for:
            // items : 1,
            // itemsDesktop : false,
            // itemsDesktopSmall : false,
            // itemsTablet: false,
            // itemsMobile : false
        });
    });
</script>