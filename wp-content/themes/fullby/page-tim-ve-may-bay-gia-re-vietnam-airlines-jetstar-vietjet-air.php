<?php get_header(); ?>

<!-- <div class="row featured">
  <div class="col-sm-12 col-md-12 item-featured">

</div> -->

<div class="col-md-12 cont-grid" id="search-box-container">
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
    });
    $(window).trigger('resize');
    jQuery('.footer').addClass('enclose');

  });
</script>

<?php get_footer(); ?>
