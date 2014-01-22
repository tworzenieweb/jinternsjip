<?php if($loop->have_posts()): ?>
<div class="row youtube-component">
    <div class="col-xs-10">
        <div class="border">
        <?php $loop->the_post(); ?>
        <iframe class="ytplayer" type="text/html" width="100%" height="345" src="http://www.youtube.com/embed/<?php echo get_post_meta(get_the_ID(), "_youtube_id", true); ?>&amp;autoplay=0&amp;cc_load_policy=1&amp;hd=1&amp;controls=1&amp;autohide=1&amp;rel=0&amp;modestbranding=1&amp;showinfo=0&amp;wmode=opaque&amp;html5=1" frameborder="0"></iframe>
        </div>
    </div>
    <div class="col-xs-2">
        <ul class="list-unstyled thumbnails-youtube">
            <?php while ($loop->have_posts()): $loop->the_post(); ?>
                <li>
                    <a href="http://www.youtube.com/embed/<?php echo get_post_meta(get_the_ID(), "_youtube_id", true); ?>&amp;autoplay=0&amp;cc_load_policy=1&amp;hd=1&amp;controls=1&amp;autohide=1&amp;rel=0&amp;modestbranding=1&amp;showinfo=0&amp;wmode=opaque&amp;html5=1" class="change-movie" title="<?php the_title(); ?>" data-toggle="tooltip">
                        <img src="http://img.youtube.com/vi/<?php echo get_post_meta(get_the_ID(), "_youtube_id", true); ?>/1.jpg" />
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>
<?php endif; ?>