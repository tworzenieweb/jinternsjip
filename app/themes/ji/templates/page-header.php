<?php $bg = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true); ?>
<div class="page-image text-center" style="background: url(<?php echo $bg[0]; ?>) no-repeat top center;">
    
    <div class="container">
        <h1><?php echo roots_title(); ?></h1>
    </div>
</div>