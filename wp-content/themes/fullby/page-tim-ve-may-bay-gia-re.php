<?php get_header(); ?>

<div id="container-iframe" class="row">
  <div class="col-sm-12 col-md-12 fill">
    <iframe class="fill" src="http://localhost:3000/booking/roundtrip/SGN/HAN/14-05-2015/19-05-2015/100&source=vemaybay"></iframe>
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
      jQuery('#container-iframe').height($(window).height() - 140);
    });
    $(window).trigger('resize');
  });
</script>
<?php get_footer(); ?>
