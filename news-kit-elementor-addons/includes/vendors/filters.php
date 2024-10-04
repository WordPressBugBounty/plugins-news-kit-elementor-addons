<?php
/**
 * List of all filters 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'nekit_posts_date_apply_url_filter', function($html) {
    return '<span class="date-meta-wrap post-meta-item"><a href="' .esc_url(get_the_permalink()). '" target="'.esc_attr($html[1]).'">' .$html[0]. '</a></span>';
});
add_filter( 'nekit_posts_date_filter', function($html) {
    return '<span class="date-meta-wrap post-meta-item">' .$html. '</span>';
});
add_filter( 'nekit_posts_comments_filter', function($html) {
    return '<span class="comments-meta-wrap post-meta-item"><a href="'.esc_url(get_the_permalink()) .'#comments">' .$html. '</a></span>';
});
add_filter( 'nekit_posts_author_apply_url_filter', function($html) {
    return '<span class="author-meta-wrap post-meta-item"><a href="' .esc_url(get_author_posts_url(get_the_author_meta( 'ID' ))). '" target="'. esc_attr($html[1]) .'">' .$html[0]. '</a></span>';
});
add_filter( 'nekit_posts_author_filter', function($html) {
    return '<span class="author-meta-wrap post-meta-item">' .$html. '</span>';
});

add_filter( 'nekit_posts_category_filter', function($html) {
    return '<div class="category-wrap">' .$html. '</div>';
});

add_filter( 'nekit_theme_builder_callback_value_filter', function($type,$page) {
    switch($type) {
        case 'builder-callback-condition': $condition_value = 'entire-site';
                                        break;
        case 'inner-builder-callback-condition': $new_value = explode( '-', $page );
                                                $condition_value = $new_value[0] . '-nekitallnekit';
                                            break;
        default: $condition_value = 'entire-site';
    }
    return $condition_value;
}, 10, 2);

add_filter('nekit_array_pop_filter', function($array) {
    // Use array_pop to remove the last value from the array
    array_pop($array);

    return $array;
});