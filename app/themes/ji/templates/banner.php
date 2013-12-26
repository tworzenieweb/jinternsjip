<div class="banner-container">

    <div class="container">


        <div class="jumbotron">
            <div id="sequence">
                <a href="#" class="sequence-prev">Previous</a>
                <a href="#" class="sequence-next">Next</a>
                <ul class="sequence-canvas unstyled">       
                    <?php
                    $args = array('post_type' => 'slide', 'posts_per_page' => 5);
                    $loop = new WP_Query($args);
                    while ($loop->have_posts()) : $loop->the_post();
                        ?>
                        <li class="animate-in ">
                            <div class="start_anime">

                                <div class="box_area_slider">

                                    <div class="col-sm-7 " data-youtube="<?php echo get_post_meta($post->ID, "_youtube", true); ?>">

                                        <?php the_content(); ?>

                                        <a href="#" class="play-button"><span>Play</span></a>
                                    </div>

                                </div>

                            </div>
                        </li>
<?php endwhile; ?> 

                </ul>
            </div>
        </div>
    </div>

</div>