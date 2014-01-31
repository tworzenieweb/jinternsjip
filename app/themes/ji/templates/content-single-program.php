<?php while (have_posts()) : the_post(); ?>
  <div class="entry-content">
      
      <h2><?php the_title(); ?></h2>
      
      
      <?php echo get_the_content(null, true); ?>
      
  </div>
<?php endwhile; ?>
