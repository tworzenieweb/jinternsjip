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

function slide_init() {
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
function slide_updated_messages($messages) {
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
function slide_help_text($contextual_help, $screen_id, $screen) {
	if ('slide' == $screen->id) {
		$contextual_help =
		'<p>' . __('Things to remember when adding a slide:') . '</p>' .
		'<ul>' .
		'<li>' . __('Give the slide a title. The title will be used as the slide\'s headline.') . '</li>' .
		'<li>' . __('Attach a Featured Image to give the slide its background.') . '</li>' .
		'<li>' . __('Enter text into the Visual or HTML area. The text will appear within each slide during transitions.') . '</li>' .
		'</ul>';
	}
	elseif ('edit-slide' == $screen->id) {
		$contextual_help = '<p>' . __('A list of all slides appears below. To edit a slide, click on the slide\'s title.') . '</p>';
	}
	return $contextual_help;
}

add_action( 'add_meta_boxes', 'add_slides_metaboxes' );

function add_slides_metaboxes() {
    
    add_meta_box('youtube', 'Youtube movie ID', 'youtube', 'slide', 'side', 'default');
    
}


function youtube() {
    global $post;
    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="slidemeta_noncename" id="slidemeta_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    // Get the location data if its already been entered
    $youtube = get_post_meta($post->ID, '_youtube', true);
    // Echo out the field
    echo '<input type="text" name="_youtube" value="' . $youtube  . '" class="widefat" />';
}

function youtube_save_slide_meta($post_id, $post) {
    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    
    if(!isset($_POST['slidemeta_noncename']))
    {
        return $post->ID;
    
    }
    else {
        if ( !wp_verify_nonce( $_POST['slidemeta_noncename'], plugin_basename(__FILE__) )) {
            return $post->ID;
        }
    }
    
    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
    {
        return $post->ID;
    }
    
    $slides_meta = array();
    
    // OK, we're authenticated: we need to find and save the data
    // We'll put it into an array to make it easier to loop though.
    $slides_meta['_youtube'] = $_POST['_youtube'];
    // Add values of $events_meta as custom fields
    foreach ($slides_meta as $key => $value) { // Cycle through the $slides_meta array!
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
        if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
            update_post_meta($post->ID, $key, $value);
        } else { // If the custom field doesn't have a value
            add_post_meta($post->ID, $key, $value);
        }
        if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
    }
}

add_action('save_post', 'youtube_save_slide_meta', 1, 2);