<?php $post = $post = get_page_by_path('listings'); ?>
<?php $bg = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', true); ?>
<div class="page-image text-center" style="background: url(<?php echo $bg[0]; ?>) no-repeat top center;">
    
    <div class="container">
        <h1><a href="<?php echo get_permalink($post->ID); ?>">Listings</a></h1>
    </div>
</div>