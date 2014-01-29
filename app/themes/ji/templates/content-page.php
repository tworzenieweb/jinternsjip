<?php while (have_posts()) : the_post(); ?>
  <?php the_content(); ?>
  <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php endwhile; ?>
<div class="fb-like" data-href="https://www.facebook.com/JInternship" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>