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
  $search_url = "http://192.168.1.40:3000/booking/". $trip_type ."/". $departure ."/". $destination .
                  "/". $from_date ."/". $to_date ."/" . $adult . $children . $infant . "&source=vemaygiareonline-net";
?>

<div id="container-iframe" class="row">
  <div class="col-sm-12 col-md-12 fill">
    <iframe class="fill" src="<?php echo $search_url; ?>"></iframe>
    <!-- onload="window.parent.scrollTo(0,0)" allowtransparency="true" -->
    <!-- <div class="panel panel-default fill">
        <div class="panel-body fill">
          <h1>Searching</h1>
        </div>
      <div> -->
  </div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function(){
    $(window).resize(function() {
      jQuery('#container-iframe').height($(window).height() - 110);
    });
    $(window).trigger('resize');
  });
</script>
<?php get_footer(); ?>
