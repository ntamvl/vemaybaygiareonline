<?php get_header(); ?>

<!-- <div class="row featured">
  <div class="col-sm-12 col-md-12 item-featured">

</div> -->

<div class="col-md-12 cont-grid featured-2" id="search-box-container">
  <div class="panel panel-default panel-search-box">
    <div class="panel-body">
      <?php get_template_part( 'search-box' ); ?>
    </div>
  </div>
  <br/>
</div>

<script type="text/javascript">
  jQuery(document).ready(function(){
    $(window).resize(function() {
      // jQuery('#search-box-container').height($(window).height() - $('.navbar').outerHeight() - $('.footer').outerHeight() - 80);
      jQuery('.featured-2').height($(window).height() - 110);
    });
    $(window).trigger('resize');
    if ( $(window).height() > $('#search-box-container').outerHeight() + 60 ) {
      jQuery('.footer').addClass('enclose');
    }

    // var isMobile = window.matchMedia("only screen and (max-width: 760px)");
    // if (isMobile.matches) {
    //   jQuery('#container-iframe').height($(window).height() - 50);
    //   jQuery('#sidebar-iframe').height($(window).height() - 50);
    // }

    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
      jQuery('#container-iframe').height($(window).height() - 50);
      jQuery('#sidebar-iframe').height($(window).height() - 50);
    }

    // $('body').css('overflow', 'hidden');

  });
</script>

<?php get_footer(); ?>
