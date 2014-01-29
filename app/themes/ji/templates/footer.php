<footer class="content-info" role="contentinfo">
    <div class="container">
  <div class="row">
    <div class="col-lg-12">
      <?php dynamic_sidebar('sidebar-footer'); ?>
    </div>
  </div>
    </div>
</footer>
<footer class="bottomlinks" role="bottomlinks">
    <div class="container">
  <div class="row">
    <div class="col-sm-4">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> All Rights Reserved</p>
    </div>
    <div class="col-sm-8">
      <?php dynamic_sidebar('sidebar-bottom'); ?>
    </div>
  </div>
    </div>
</footer>


<?php wp_footer(); ?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>