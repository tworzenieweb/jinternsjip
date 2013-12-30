<div class="banner-container">

    <div class="container">



        <div class="jumbotron">
            <div id="sequence">
                <a href="#" class="sequence-prev">Previous</a>
                <a href="#" class="sequence-next">Next</a>
                <ul class="sequence-canvas">       
                    <?php
                    $args = array('post_type' => 'slide', 'posts_per_page' => 5);
                    $loop = new WP_Query($args);
                    $images = $posts = array();
                    while ($loop->have_posts()) : $loop->the_post();
                        ?>
                        <?php $posts[] = $post; ?>
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

                </ul>
                <ul class="sequence-pagination">
                    <?php foreach ($posts as $key => $post): ?>
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

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <iframe width="100%" height="300" frameborder="0" allowfullscreen="true"></iframe>
                </div>
            </div>
        </div>
    </div>