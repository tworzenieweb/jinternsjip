<div class="banner-container">

    <div class="container">
        
        <div class="jumbotron">
            <div id="sequence">
                <a href="#" class="sequence-prev">Previous</a>
                <a href="#" class="sequence-next">Next</a>
                <ul class="sequence-canvas">       
                    <?php
                    wp_reset_query();
                    query_posts('posts_per_page=20&post_type=slide&orderby=date&order=DESC');
                    $images = $postsCollection = array();
                    global $post;
                    while (have_posts()) : the_post(); ?>
                        <?php $postsCollection[] = $post; ?>
                        <?php $url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', true); ?>
                        <li data-background="<?php echo $url[0] ?>">
                            <div class="start_anime">

                                <div class="box_area_slider">
                                    <?php $src = sprintf("http://www.youtube.com/embed/%s?wmode=transparent", get_post_meta($post->ID, "_youtube", true)); ?>
                                    <iframe id="player_<?php echo $post->ID; ?>" class="youtube" src="<?php echo $src; ?>" frameborder="0" wmode="Opaque"></iframe>
                                    <?php the_content(); ?>
                                    <a href="#" class="play-button"><span>Play</span></a>
                                </div>

                            </div>
                        </li>
                    <?php endwhile; ?>

                </ul>
                <div class="sequence-pagination">
                    <div class="wrapper-pagination">
                        <ul class="pagination-block">
                    <?php foreach ($postsCollection as $key => $post): ?>
                        <li data-youtube="<?php echo get_post_meta($post->ID, "_youtube", true); ?>">
                            <?php $url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail', true); ?>

                            <a href="#" class="play-button"><span>Play</span></a>
                            <img src="<?php echo $url[0]; ?>" />
                        </li>
                    <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<?php wp_reset_query(); ?>