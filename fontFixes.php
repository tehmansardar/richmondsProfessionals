<?php
// Quote Form Ajax
add_action('wp_ajax_nopriv_richmond_food_menu', 'richmond_food_menu_category');
add_action('wp_ajax_richmond_food_menu', 'richmond_food_menu_category');

function richmond_food_menu_category()
{
    echo $catName = $_POST['name'];
    $catSlug = $_POST['slug'];
    die;
    $start_time = microtime(true);
    global $wpdb;
    global $woocommerce_loop;
    do_action('qm/start', 'Start Restaurant');
    // Random ID
    $randno = rand(1000, 9999);

    // Max duration the SQL query result will be kept in transient (in seconds)
    $transient_duration = 60;

    // Restaurant's child category term slugs
    $food_slug = 'food';
    $drink_slug = 'drink';

    // Restaurant product type supported
    $product_types = array('simple', 'variable');


    $woocommerce_loop['columns'] = 3;

    // Get the author ID
    $author_id = get_the_author_meta('ID');

    // Get the ID of the current post
    $post_id = get_the_ID();
    $pods = get_post_meta($post_id, 'restaurant_category', true);

    $categories = get_categories(
        array(
            'child_of' => $pods['term_id'],
            'taxonomy' => 'product_cat',
        )
    );

    $product_categories = array();

    if (!empty($categories)) {
        foreach ($categories as $category) {
            $product_categories[] = $category->slug;
            $term = get_term_by('slug', $category->slug, 'product_cat');
        }
    }


    // Set the order of product tag slugs

    if (!empty($product_categories)) {
        $cat_term_slugs = array_unique($product_categories);
        $cat_term_slugs = array_filter($cat_term_slugs);
    }


    // Display the product items
    foreach ((array) $cat_term_slugs as $cat_term_slug) {

        $products = new WP_Query(array(
            'post_type'         => 'product',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
            'orderby'           => array('title' => 'ASC'),
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $catSlug,
                    'include_children' => true,
                    'operator' => 'IN'
                )
            )
        ));

        if ($products->have_posts()) {
            echo '<div class="listing_product_cat" id="' . $randno . "-" . $catSlug . '">' . $catName . '</a></div>';

            woocommerce_product_loop_start();
            while ($products->have_posts()) : $products->the_post();
                wc_get_template_part('content', 'product');

            endwhile; // end of the loop.
            woocommerce_product_loop_end();
        }
        break;
    }
    woocommerce_reset_loop();
    wp_die();
}
