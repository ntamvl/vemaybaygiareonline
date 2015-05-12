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

<div class="col-md-9 cont-grid">
  <div id="container-iframe" class="row">
    <div class="col-sm-12 col-md-12 fill">
      <iframe class="fill" src="<?php echo $search_url; ?>"></iframe>
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
      jQuery('#container-iframe').height($(window).height() - 120);
      jQuery('#sidebar-iframe').height($(window).height() - 120);
    });
    $(window).trigger('resize');
  });
</script>
<?php get_footer(); ?>
