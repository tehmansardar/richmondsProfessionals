<?php

error_reporting(0);

// Include Files
// include get_theme_file_path('/frontFixes0.php');
include get_theme_file_path('/frontFixes.php');


// Enqueue child theme style.css

add_action('wp_enqueue_scripts', function () {

    wp_enqueue_style('child-style', get_stylesheet_uri());



    if (is_rtl()) {

        wp_enqueue_style('mylisting-rtl', get_template_directory_uri() . '/rtl.css', [], wp_get_theme()->get('Version'));
    }

    wp_register_script('frontFxies', get_theme_file_uri() . '/js/frontFixes.js', [], '', true);
    wp_enqueue_script('frontFxies');
}, 500);
add_action('admin_init', 'admin_custom_js');
function admin_custom_js()
{
    wp_enqueue_script('javascript_file', get_stylesheet_directory_uri() . '/js/admin-custom.js');
}

add_filter('woocommerce_add_to_cart_redirect',  'redirect_to_menu');
function redirect_to_menu()
{
    if (isset($_COOKIE['companyLink'])) {
        return $_COOKIE['companyLink'];
    }
}



// Happy Coding :)

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
