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
    <div class="col-sm-6">
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> All Rights Reserved</p>
    </div>
    <div class="col-sm-6">
      <?php dynamic_sidebar('sidebar-bottom'); ?>
    </div>
  </div>
    </div>
</footer>


<?php wp_footer(); ?>
