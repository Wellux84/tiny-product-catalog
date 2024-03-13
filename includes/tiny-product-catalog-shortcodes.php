<?php
function tpcatalog_shortcode($tpc_attr) {
    $default = array(
        'category' => 'all'
    );
    $cat = shortcode_atts($default, $tpc_attr);

    if ($cat['category'] == 'all') {
        $args = array(
            'post_type' => 'tpcatalog_product',
            'post_status' => 'publish', // 'publish' or 'draft' or 'pending' or 'private' or 'trash' or 'any'
            'orderby' => 'title',
            'order' => 'ASC', // 'ASC' or 'DESC
        );
    } else {
        $args = array(
            'post_type' => 'tpcatalog_product',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'tpcatalog_category',
                    'field' => 'slug',
                    'terms' => $cat['category']
                )
            )
        );
    }
    $text = '<div class="tiny-product-catalog">';
    $loop = new WP_Query($args);
    if ($loop->have_posts()) {
        while ($loop->have_posts()) {
            $loop->the_post();
            $price = get_post_meta(get_the_ID(), '_tpcatalog_meta_price', true);
            $text .= '<section class="tiny-product"><h3>' . get_the_title() . '</h3>';
            $text .= '<p>' .$price . '</p>';
            $text .= get_the_post_thumbnail();
            $text .= '<p>' . get_the_content() . '</p></section>';
        }
    } else {
        $text .= '<p>Ei tuotteita</p>';
    }

    $text .='</div>';

    wp_reset_postdata();

    return $text;
}

add_shortcode('tiny-product-catalog', 'tpcatalog_shortcode');

?>