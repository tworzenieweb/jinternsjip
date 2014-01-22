<div class="banner-container">

    <div class="container">

        <div class="jumbotron">
            <div id="sequence">
                <a href="#" class="sequence-prev">Previous</a>
                <a href="#" class="sequence-next">Next</a>
                <ul class="sequence-canvas">       
                    <?php
                    $bannerArgs = array('post_type' => 'slide', 'posts_per_page' => 5);
                    $loopBaner = new WP_Query($bannerArgs);
                    $images = $postsCollection = array();
                    while ($loopBaner->have_posts()) : $loopBaner->the_post();
                        ?>
                        <?php $postsCollection[] = $post; ?>
                        <?php $url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', true); ?>
                        <li data-youtube="<?php echo get_post_meta($post->ID, "_youtube", true); ?>" data-background="<?php echo $url[0] ?>">
                            <div class="start_anime">

                                <div class="box_area_slider">
                                    <?php the_content(); ?>
                                    <a href="#" class="play-button"><span>Play</span></a>

                                </div>

                            </div>
                        </li>
                    <?php endwhile; ?>
                    <?php wp_reset_query(); ?>

                </ul>
                <ul class="sequence-pagination">
                    <?php foreach ($postsCollection as $key => $post): ?>
                        <li>
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