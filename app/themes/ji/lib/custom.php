<?php

/**
 * Custom functions
 */
function load_google_fonts()
{
    wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800');
    wp_enqueue_style('googleFonts');
}

add_action('wp_print_styles', 'load_google_fonts');

add_action('init', 'slide_init');

function slide_init()
{
    $labels = array(
        'name' => _x('Slides', 'post type general name'),
        'singular_name' => _x('Slide', 'post type singular name'),
        'add_new' => _x('Add new', 'slide'),
        'add_new_item' => __('Add new slide'),
        'edit_item' => __('Edit slide'),
        'new_item' => __('New slide'),
        'view_item' => __('Show slide'),
        'search_items' => __('Search slide'),
        'not_found' => __('No slides'),
        'not_found_in_trash' => __('No slides in bin'),
        'parent_item_colon' => '',
        'menu_name' => 'Slides'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail'),
        'register_meta_box_cb' => 'add_slides_metaboxes'
    );
    register_post_type('slide', $args);
}

/* Update Slide Messages */
add_filter('post_updated_messages', 'slide_updated_messages');

function slide_updated_messages($messages)
{
    global $post, $post_ID;
    $messages['slide'] = array(
        0 => '',
        1 => sprintf(__('Slide updated.'), esc_url(get_permalink($post_ID))),
        2 => __('Custom field updated.'),
        3 => __('Custom field deleted.'),
        4 => __('Slide updated.'),
        5 => isset($_GET['revision']) ? sprintf(__('Slide restored to revision from %s'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
        6 => sprintf(__('Slide published.'), esc_url(get_permalink($post_ID))),
        7 => __('Slide saved.'),
        8 => sprintf(__('Slide submitted.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        9 => sprintf(__('Slide scheduled for: <strong>%1$s</strong>. '), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
        10 => sprintf(__('Slide draft updated.'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
    );
    return $messages;
}

/* Update Slide Help */
add_action('contextual_help', 'slide_help_text', 10, 3);

function slide_help_text($contextual_help, $screen_id, $screen)
{
    if ('slide' == $screen->id)
    {
        $contextual_help = '<p>' . __('Things to remember when adding a slide:') . '</p>' .
                '<ul>' .
                '<li>' . __('Give the slide a title. The title will be used as the slide\'s headline.') . '</li>' .
                '<li>' . __('Attach a Featured Image to give the slide its background.') . '</li>' .
                '<li>' . __('Enter text into the Visual or HTML area. The text will appear within each slide during transitions.') . '</li>' .
                '</ul>';
    } elseif ('edit-slide' == $screen->id)
    {
        $contextual_help = '<p>' . __('A list of all slides appears below. To edit a slide, click on the slide\'s title.') . '</p>';
    }
    return $contextual_help;
}

add_action('add_meta_boxes', 'add_slides_metaboxes');

function add_slides_metaboxes()
{

    add_meta_box('youtube', 'Youtube movie ID', 'youtube', 'slide', 'side', 'default');
}

function youtube()
{
    global $post;
    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="slidemeta_noncename" id="slidemeta_noncename" value="' .
    wp_create_nonce(plugin_basename(__FILE__)) . '" />';
    // Get the location data if its already been entered
    $youtube = get_post_meta($post->ID, '_youtube', true);
    // Echo out the field
    echo '<input type="text" name="_youtube" value="' . $youtube . '" class="widefat" />';
}

function youtube_save_slide_meta($post_id, $post)
{
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times

    if (!isset($_POST['slidemeta_noncename']))
    {
        return $post->ID;
    } else
    {
        if (!wp_verify_nonce($_POST['slidemeta_noncename'], plugin_basename(__FILE__)))
        {
            return $post->ID;
        }
    }

    // Is the user allowed to edit the post or page?
    if (!current_user_can('edit_post', $post->ID))
    {
        return $post->ID;
    }

    $slides_meta = array();

    // OK, we're authenticated: we need to find and save the data
    // We'll put it into an array to make it easier to loop though.
    $slides_meta['_youtube'] = $_POST['_youtube'];
    // Add values of $events_meta as custom fields
    foreach ($slides_meta as $key => $value)
    { // Cycle through the $slides_meta array!
        if ($post->post_type == 'revision')
            return; // Don't store custom data twice
        $value = implode(',', (array) $value); // If $value is an array, make it a CSV (unlikely)
        if (get_post_meta($post->ID, $key, FALSE))
        { // If the custom field already has a value
            update_post_meta($post->ID, $key, $value);
        } else
        { // If the custom field doesn't have a value
            add_post_meta($post->ID, $key, $value);
        }
        if (!$value)
            delete_post_meta($post->ID, $key); // Delete if blank
    }
}

add_action('save_post', 'youtube_save_slide_meta', 1, 2);


add_filter('ajwpqsf_theme_opt', 'my_own_theme');

function my_own_theme($theme)
{
    $theme[] = array(
        'name' => 'jInternship Theme',
        'themeid' => 'jinternship_listing',
        'id' => 'listings_form',
        'class' => 'form-group',
    );

    return $theme;
}

function form_top($args)
{
    ?>

    <h4 class="heading-form">Find your internship.</h4>

    <div class="row">
        <div class="col-sm-12">
            <?php
        }

        function form_bottom($args)
        {
            ?>
        </div>
    </div>
    <?php
}

add_action('awpqsf_form_top', 'form_top', 1, 1);
add_action('awpqsf_form_bottom', 'form_bottom', 1, 1);


// added full path as custom tag for my-custom-management plugin
add_filter('mcm_extend_posts', 'add_tabs_mcm', 1, 2);

function add_tabs_mcm($p, $custom)
{

    $path = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full', true);

    $p['full_path'] = $path[0];

    $p['image_tag'] = strstr($path[0], 'crystal/default.png') !== false ? '' : sprintf('<img src="%s" class="media-object" />', $path[0]);

    $tags = (array) get_the_tags(get_the_ID());
    $tags = current($tags);

    $p['tag'] = $tags ? $tags->name : '';
    $p['custom'] = $custom;

    return $p;
}

add_filter('ajwpqsf_pagination', 'customize_pagination', '', 4);

function customize_pagination($html, $max_num_pages, $pagenumber, $id)
{
    $pages = $max_num_pages;
    $range = 4;
    $showitems = ($range * 2) + 1;
    $paged = $pagenumber;
    if (empty($paged))
    {
        $paged = 1;
    }

    $html = '<input type="hidden" id="curform" value="#ajax_wpqsffrom_' . $id . '">';
    $html .= '<ul class="pagination">';
    //<span>Page ".$paged." of ".$pages."</span>";
    if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
        $html .= '<li><a id="1" class="pagievent" href="#">&laquo; ' . __("First", "AjWPQSF") . '</a></li>';
    $previous = $paged - 1;
    if ($paged > 1 && $showitems < $pages)
        $html .= '<li><a id="' . $previous . '" class="pagievent" href="#">&lsaquo; ' . __("Previous", "AjWPQSF") . '</a></li>';

    for ($i = 1; $i <= $pages; $i++)
    {
        if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ))
        {
            $html .= ($paged == $i) ? '<li class="active"><span>' . $i . '</span></li>' : 
                '<li><a id="' . $i . '" href="#" class="pagievent inactive">' . $i . '</a></li>';
        }
    }

    if ($paged < $pages && $showitems < $pages)
    {
        $next = $paged + 1;
        $html .= '<li><a id="' . $next . '" class="pagievent"  href="#">' . __("Next", "AjWPQSF") . ' &rsaquo;</a></li>';
    }
    if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
    {
        $html .= '<li><a id="' . $pages . '" class="pagievent"  href="#">' . __("Last", "AjWPQSF") . ' &raquo;</a></li>';
    }
    $html .= "</ul>\n";
    
    return $html;
}

add_filter('dgx_donate_giving_levels', 'donation_amounts', '', 1);

function donation_amounts($amounts) {
    
    return array(300,350);
    
}


add_filter('ajax_wpqsf_reoutput', 'customize_output', '', 4);

function customize_output($results, $arg, $id, $getdata)
{

    $apiclass = new ajaxwpqsfclass();
    // The Query
    $query = new WP_Query($arg);
    $html = '';
    // The Loop

    $pagenumber = isset($arg['paged']) ? $arg['paged'] : 1;

    if ($query->have_posts())
    {


        $html .= '<h3 class="heading-results">' . __('Internship search results  :', 'AjWPQSF') . '</h3>';

        $i = 1;
        while ($query->have_posts())
        {
            $query->the_post();

            
            if(($i % 2) == 1) {
                $html .= '<div class="row">';
            }
            
            $html .= '<div class="col-sm-6">';
            $html .= '<div class="entry-summary">';
            $html .= '<h4 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h4>';
            $html .= '<h4>ORGANIZATION ACTIVITIES</h4>';
            $html .= '<p>' . get_post_meta(get_the_ID(), '_organization_activities', true) . '</p>';
            $html .= '<h4>INTERNSHIP DESCRIPTION</h4>';
            $html .= '<p>' . get_the_excerpt() . '</p>';
            $html .= '<h4>Industry:</h4>';
            $html .= '<p>' . get_post_meta(get_the_ID(), '_industry', true) . '</p>';
            $html .= '<h4>Hebrew level:</h4>';
            $html .= '<p>' . get_post_meta(get_the_ID(), '_hebrev_level', true) . '</p>';
            $html .= '</div>';
            $html .= '<a href="' . get_permalink() . '" class="more-link">Read More</a>';
            $html .= '</div>';


             if((++$i % 2) == 1 || $i-1 == $query->post_count) {
                $html .= '</div>';
            }

        }


        $html .= $apiclass->ajax_pagination($pagenumber, $query->max_num_pages, 4, $id);
    } else
    {
        $html .= __('Nothing Found', 'AjWPQSF');
    }
    /* Restore original Post Data */
    wp_reset_postdata();

    return $html;
}

remove_filter('the_content', 'wpautop');

add_shortcode('youtube_list', 'youtube_list_shortcode');

function youtube_list_shortcode()
{


    $args = array('post_type' => 'mcm_youtube', 'posts_per_page' => 5);
    $loop = new WP_Query($args);

    ob_start();

    include __DIR__ . '/../' . 'templates/youtube/list.php';

    $response = ob_get_contents();

    ob_end_flush();
}

add_filter('ajwpqs_cmf_field_checkbox', 'field_checkbox', 1, 10);

function field_checkbox($html, $type, $metakey, $compare, $metaval, $label, $all, $i, $divclass, $formid)
{


    $opts = explode("|", $metaval);
    $html = '<div class="' . $divclass . ' cmfcheckbox-' . $i . ' togglecheck">';
    $html .= '<input type="hidden" name="cmf[' . $i . '][metakey]" value="' . $metakey . '">';
    $html .= '<input type="hidden" name="cmf[' . $i . '][compare]" value="' . $compare . '">';
    if (!empty($all))
    {
        $html .= '<label class="all-labels"><input style="display:none;" type="checkbox" id="cmf-' . $i . '" name="cmf[' . $i . '][call]" class="awpsfcheckall" ><span class="label badge">' . $all . '</span></label> ';
    }
    foreach ($opts as $opt)
    {
        $val = explode('::', $opt);
        $html .= '<label><input style="display:none;" type="checkbox" id="cmf-' . $i . '" name="cmf[' . $i . '][value][]" value="' . $val[0] . '" ><span class="label badge">' . $val[1] . '</span></label> ';
    }
    $html .= '</div>';

    return $html;
}
