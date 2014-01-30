<?php while (have_posts()) : the_post(); ?>
  <div class="entry-content">
      
      <h2><?php the_title(); ?></h2>
      
      <h3>ORGANIZATION ACTIVITIES</h3>
      
      <p><?php echo get_post_meta(get_the_ID(), '_organization_activities', true) ?></p>
      
      <h3>INTERNSHIP DESCRIPTION</h3>
      
      <?php echo get_the_content(null, true); ?>
      
      <?php $details = array(
          '_qualifications' => 'Qualifications',
          '_industry' => 'Industry',
          '_benefits' => 'Benefits',
          '_hebrev_level' => 'Hebrew level',
          '_notes' => 'Notes'
      ); ?>
      
      <?php foreach($details as $key => $label): ?>
      
        <?php $content = get_post_meta(get_the_ID(), $key, true); ?>
        <?php if($content): ?>
            <h3><?php echo strtoupper($label); ?>:</h3>
            <p><?php echo $content; ?></p>
        <?php endif; ?>
      <?php endforeach; ?>
      
  </div>
<?php endwhile; ?>
