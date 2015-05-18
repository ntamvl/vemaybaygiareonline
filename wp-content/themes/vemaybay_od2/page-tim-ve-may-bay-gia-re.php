<?php get_header(); ?>
<?php
  $trip_type = $_GET['trip_type'];
  $departure = $_GET['departure'];
  $destination = $_GET['destination'];
  $from_date = $_GET['from_date'];
  $to_date = $_GET['to_date'];
  $adult = $_GET['adult'];
  $children = $_GET['children'];
  $infant = $_GET['infant'];
  $now = new DateTime();
  $key = md5($now->getTimestamp());
  $search_url = "http://flightbooking.vn/booking/". $trip_type ."/". $departure ."/". $destination .
                  "/". $from_date ."/". $to_date ."/" . $adult . $children . $infant . "/" . $key .
                  "?source=vemaygiareonline-net&iframe_page=true";
?>

<div class="col-md-9 cont-grid iframe-row">
  <div id="container-iframe" class="row">
    <div class="col-sm-12 col-md-12 fill no-margin-lr">
      <img id="loader_box" src="<?php echo get_stylesheet_directory_uri(); ?>/img/loading-2.gif" width="128" height="128" alt="loading gif"/>
      <iframe id="iframe_flights" class="fill" src="<?php echo $search_url; ?>" onload="window.parent.scrollTo(0,0)" allowtransparency="true"></iframe>
      <!-- onload="window.parent.scrollTo(0,0)" allowtransparency="true" -->
    </div>
  </div>
</div>

<div class="col-md-3 sidebar" id="sidebar-iframe">

  <?php get_sidebar( 'primary' ); ?>

</div>

<script type="text/javascript">
  jQuery(document).ready(function(){
    $(window).resize(function() {
      jQuery('#container-iframe').height($(window).height() - 110);
      jQuery('#sidebar-iframe').height($(window).height() - 110);

      // var isMobile = window.matchMedia("only screen and (max-width: 760px)");
      // if (isMobile.matches) {
      //   jQuery('#container-iframe').height($(window).height() - 50);
      //   jQuery('#sidebar-iframe').height($(window).height() - 50);
      // }

      if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        jQuery('#container-iframe').height($(window).height() - 50);
        jQuery('#sidebar-iframe').height($(window).height() - 50);
      }

    });
    $(window).trigger('resize');

    $('#iframe_flights').on('load', function () {
        $('#loader_box').hide();
    });

  });
</script>
<?php get_footer(); ?>
