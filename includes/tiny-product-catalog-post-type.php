<?php
/* register the new post type: product */
function tpcatalog_register_post_type() {
    add_theme_support('post-thumbnails');

    $labels = array(
        'name' => 'Tuotteet',
        'singular_name' => 'Tuote',
        'add_new' => 'Uusi tuote',
        'add_new_item' => 'Lisää uusi tuote',
        'edit_item' => 'Muokkaa tuotetta',
        'new_item' => 'Uusi tuote',
        'view_item' => 'Selaa tuotetta',
        'search_items' => 'Etsi tuotteita',
        'not_found' => 'Tuotteita ei löytynyt',
        'not_found_in_trash' => 'Tuotteita ei löytynyt roskakorista'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'hierachical' => false,
        'supports' => array('title', 'editor', 'thumbnail','custom-fields'),
        'rewrite' => array('slug' => 'tuote'),
        'show_in_rest' => true,
    );

    register_post_type('tpcatalog_product', $args);
}

add_action('init', 'tpcatalog_register_post_type');

/* Add price box */
function tpcatalog_add_custom_box() {
    add_meta_box(
     'tpcatalog_price_id',
     'Hinta',
     'tpcatalog_price_box_html', 
     'tpcatalog_product' 
     );
}

add_action('add_meta_boxes', 'tpcatalog_add_custom_box');

function tpcatalog_price_box_html($post) {
    $value = get_post_meta($post->ID, '_tpcatalog_meta_price', true);
    ?>
    <label for="tpcatalog_price">Hinta</label>
    <input type="text" id="tpcatalog_price" name="tpcatalog_price" value="<?php echo $value; ?>">
    <?php
}

/* save post meta */
function tpcatalog_save_postdata($post_id) {
    if (array_key_exists('tpcatalog_price', $_POST)) {
        update_post_meta(
            $post_id,
            '_tpcatalog_meta_price',
            sanitize_text_field($_POST['tpcatalog_price'])
        );
    }
}

add_action('save_post', 'tpcatalog_save_postdata');

/* register new taxonomy: product category */
// register custom post type to work with
function lc_create_post_type() {
    // set up labels
    $labels = array (
    'name' => 'Events',
    'singular_name' => 'Event',
    'add_new' => 'Add New Event',
    'add_new_item' => 'Add New Event',
    'edit_item' => 'Edit Event',
    'new_item' => 'New Event',
    'all_items' => 'All Events',
    'view_item' => 'View Event',
    'search_items' => 'Search Events',
    'not_found' => 'No Events Found',
    'not_found_in_trash' => 'No Events found in Trash',
    'parent_item_colon' => '',
    'menu_name' => 'Events',
    );
    //register post type
    register_post_type ( 'event', array(
    'labels' => $labels,
    'has_archive' => true,
    'public' => true,
    'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'thumbnail','page-attributes' ),
    'taxonomies' => array( 'post_tag', 'category' ),
    'exclude_from_search' => false,
    'capability_type' => 'post',
    'rewrite' => array( 'slug' => 'events' ),
    )
    );
    }
    add_action( 'init', 'lc_create_post_type' );



?>