<?php if($loop->have_posts()): ?>
<div class="row">
    <div class="xs-col-10">
        <?php $loop->the_post(); ?>
        
        <iframe id="ytplayer" type="text/html" width="100%" height="345"
                src="http://www.youtube.com/embed/<?php echo get_post_meta(get_the_ID(), "_youtube_id", true); ?>"
                frameborder="0" />
        
    </div>
    <div class="xs-col-2">
        <ul class="list-unstyled thumbnails-youtube">
            <?php while ($loop->have_posts()): $loop->the_post(); ?>
                <li>
                    <img src="http://img.youtube.com/vi/<?php echo get_post_meta(get_the_ID(), "_youtube_id", true); ?>/1.jpg" />
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>
<?php endif; ?>