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
                                    <?php the_content(); ?>
                                    <a href="#" class="play-button"><span>Play</span></a>
                                    <?php $src = sprintf("http://www.youtube.com/v/%s?enablejsapi=1&autoplay=0&cc_load_policy=1&hd=1&controls=1&autohide=1&rel=0&modestbranding=1&showinfo=0&wmode=transparent", get_post_meta($post->ID, "_youtube", true)); ?>
                                    <iframe enablejsapi="1" data-id="<?php echo get_post_meta($post->ID, "_youtube", true); ?>" id="player_<?php echo $post->ID; ?>" style="width:100%; height:100%; position: absolute; top:0; left:0; z-index: 9999999; display: none;" class="youtube" type="text/html" src="<?php echo $src; ?>"></iframe>
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