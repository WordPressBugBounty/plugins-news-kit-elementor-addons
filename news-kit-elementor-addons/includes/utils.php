<?php
/**
 * Plugin utilities class
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Utilities;

class Utils {
    public static function registered_widgets() {
        return apply_filters( 'nekit_registered_widgets_filter', array(
            "advanced-heading-icon" => [
                'name'  => esc_html__( 'Advanced Heading Icon', 'news-kit-elementor-addons' ),
                'category'  => 'advanced-heading'
            ],
            "archive-posts" => [
                'name'  => esc_html__( 'Archive Posts', 'news-kit-elementor-addons' ),
                'category'  => 'archive'
            ],
            "archive-title" => [
                'name'  => esc_html__( 'Archive Title', 'news-kit-elementor-addons' ),
                'category'  => 'archive'
            ],
            "back-top-top" => [
                'name'  => esc_html__( 'Back To Top', 'news-kit-elementor-addons' ),
                'category'  => 'back-to-top'
            ],
            "breadcrumb" => [
                'name'  => esc_html__( 'Breadcrumb', 'news-kit-elementor-addons' ),
                'category'  => 'breadcrumb'
            ],
            "categories-collection" => [
                'name'  => esc_html__( 'Categories Collection', 'news-kit-elementor-addons' ),
                'category'  => 'categories-collection'
            ],
            "date-and-time" => [
                'name'  => esc_html__( 'Date and Time', 'news-kit-elementor-addons' ),
                'category'  => 'date-and-time'
            ],
            "full-width-banner" => [
                'name'  => esc_html__( 'Full Width Banner', 'news-kit-elementor-addons' ),
                'category'  => 'full-width-banner'
            ],
            "live-now-button" => [
                'name'  => esc_html__( 'live Now Button', 'news-kit-elementor-addons' ),
                'category'  => 'live-now-button'
            ],
            "live-search" => [
                'name'  => esc_html__( 'Live Search', 'news-kit-elementor-addons' ),
                'category'  => 'live-search'
            ],
            "mailbox" => [
                'name'  => esc_html__( 'Mailbox', 'news-kit-elementor-addons' ),
                'category'  => 'mailbox'
            ],
            "main-banner-one" => [
                'name'  => esc_html__( 'Main Banner One', 'news-kit-elementor-addons' ),
                'category'  => 'banner'
            ],
            "main-banner-two" => [
                'name'  => esc_html__( 'Main Banner Two', 'news-kit-elementor-addons' ),
                'category'  => 'banner'
            ],
            "main-banner-three" => [
                'name'  => esc_html__( 'Main Banner Three', 'news-kit-elementor-addons' ),
                'category'  => 'banner'
            ],
            "main-banner-four" => [
                'name'  => esc_html__( 'Main Banner Four', 'news-kit-elementor-addons' ),
                'category'  => 'banner'
            ],
            "main-banner-five" => [
                'name'  => esc_html__( 'Main Banner Five', 'news-kit-elementor-addons' ),
                'category'  => 'banner'
            ],
            "news-block-one" => [
                'name'  => esc_html__( 'News Block 1', 'news-kit-elementor-addons' ),
                'category'  => 'block'
            ],
            "news-block-two" => [
                'name'  => esc_html__( 'News Block 2', 'news-kit-elementor-addons' ),
                'category'  => 'block'
            ],
            "news-block-three" => [
                'name'  => esc_html__( 'News Block 3', 'news-kit-elementor-addons' ),
                'category'  => 'block'
            ],
            "news-block-four" => [
                'name'  => esc_html__( 'News Block 4', 'news-kit-elementor-addons' ),
                'category'  => 'block'
            ],
            "news-carousel-one" => [
                'name'  => esc_html__( 'News Carousel One', 'news-kit-elementor-addons' ),
                'category'  => 'carousel'
            ],
            "news-carousel-two" => [
                'name'  => esc_html__( 'News Carousel Two', 'news-kit-elementor-addons' ),
                'category'  => 'carousel'
            ],
            "news-carousel-three" => [
                'name'  => esc_html__( 'News Carousel Three', 'news-kit-elementor-addons' ),
                'category'  => 'carousel'
            ],
            "news-filter-one" => [
                'name'  => esc_html__( 'News Filter One', 'news-kit-elementor-addons' ),
                'category'  => 'filter'
            ],
            "news-filter-two" => [
                'name'  => esc_html__( 'News Filter Two', 'news-kit-elementor-addons' ),
                'category'  => 'filter'
            ],
            "news-filter-three" => [
                'name'  => esc_html__( 'News Filter Three', 'news-kit-elementor-addons' ),
                'category'  => 'filter'
            ],
            "news-filter-four" => [
                'name'  => esc_html__( 'News Filter Four', 'news-kit-elementor-addons' ),
                'category'  => 'filter'
            ],
            "news-grid-one" => [
                'name'  => esc_html__( 'News Grid One', 'news-kit-elementor-addons' ),
                'category'  => 'grid'
            ],
            "news-grid-two" => [
                'name'  => esc_html__( 'News Grid Two', 'news-kit-elementor-addons' ),
                'category'  => 'grid'
            ],
            "news-grid-three" => [
                'name'  => esc_html__( 'News Grid Three', 'news-kit-elementor-addons' ),
                'category'  => 'grid'
            ],
            "news-timeline" => [
                'name'  => esc_html__( 'News Timeline', 'news-kit-elementor-addons' ),
                'category'  => 'news-timeline'
            ],
            "phone-call" => [
                'name'  => esc_html__( 'Phone Call', 'news-kit-elementor-addons' ),
                'category'  => 'phone-call'
            ],
            "popular-opinions" => [
                'name'  => esc_html__( 'Popular Opinions', 'news-kit-elementor-addons' ),
                'category'  => 'popular-opinion'
            ],
            "random-news" => [
                'name'  => esc_html__( 'Random News', 'news-kit-elementor-addons' ),
                'category'  => 'random-news'
            ],
            "single-author-box" => [
                'name'  => esc_html__( 'Single Author Box', 'news-kit-elementor-addons' ),
                'category'  => 'single-author-box'
            ],
            "single-author" => [
                'name'  => esc_html__( 'Single Author', 'news-kit-elementor-addons' ),
                'category'  => 'single-author'
            ],
            "single-categories" => [
                'name'  => esc_html__( 'Single Categories', 'news-kit-elementor-addons' ),
                'category'  => 'single-categories'
            ],
            "single-comment-box" => [
                'name'  => esc_html__( 'Single Comment Box', 'news-kit-elementor-addons' ),
                'category'  => 'single-comment-box'
            ],
            "single-comment" => [
                'name'  => esc_html__( 'Single Comment', 'news-kit-elementor-addons' ),
                'category'  => 'single-comment'
            ],
            "single-date" => [
                'name'  => esc_html__( 'Single Date', 'news-kit-elementor-addons' ),
                'category'  => 'single-date'
            ],
            "single-featured-image" => [
                'name'  => esc_html__( 'Single Featured Image', 'news-kit-elementor-addons' ),
                'category'  => 'single-featured-image'
            ],
            "single-post-navigation" => [
                'name'  => esc_html__( 'Single Post Navigation', 'news-kit-elementor-addons' ),
                'category'  => 'single-post-navigation'
            ],
            "single-related-post" => [
                'name'  => esc_html__( 'Single Related post', 'news-kit-elementor-addons' ),
                'category'  => 'single-related-post'
            ],
            "single-table-of-content" => [
                'name'  => esc_html__( 'Single Table Of Content', 'news-kit-elementor-addons' ),
                'category'  => 'single-table-of-content'
            ],
            "single-tags" => [
                'name'  => esc_html__( 'Single Tags', 'news-kit-elementor-addons' ),
                'category'  => 'single-tags'
            ],
            "single-title" => [
                'name'  => esc_html__( 'Single Title', 'news-kit-elementor-addons' ),
                'category'  => 'single-title'
            ],
            "site-logo-title" => [
                'name'  => esc_html__( 'Site Logo Title', 'news-kit-elementor-addons' ),
                'category'  => 'site-logo-title'
            ],
            "site-nav-mega-menu" => [
                'name'  => esc_html__( 'Site Nav Mega Menu', 'news-kit-elementor-addons' ),
                'category'  => 'site-nav-mega-menu'
            ],
            "theme-mode" => [
                'name'  => esc_html__( 'Theme Mode', 'news-kit-elementor-addons' ),
                'category'  => 'theme-mode'
            ],
            "ticker-news-one" => [
                'name'  => esc_html__( 'Ticker News One', 'news-kit-elementor-addons' ),
                'category'  => 'ticker'
            ],
            "ticker-news-two" => [
                'name'  => esc_html__( 'Ticker News Two', 'news-kit-elementor-addons' ),
                'category'  => 'ticker'
            ],
            "video-playlist" => [
                'name'  => esc_html__( 'Video Playlist', 'news-kit-elementor-addons' ),
                'category'  => 'video-playlist'
            ],
            "news-list-one"   => [
                'name'  => esc_html__( 'News List 1', 'news-kit-elementor-addons' ),
                'category'  => 'list'
            ],
            "news-list-two"   => [
                'name'  => esc_html__( 'News List 2', 'news-kit-elementor-addons' ),
                'category'  => 'list'
            ],
            "news-list-three"   => [
                'name'  => esc_html__( 'News List 3', 'news-kit-elementor-addons' ),
                'category'  => 'list'
            ],
            "news-list-two"   => [
                'name'  => esc_html__( 'News List 2', 'news-kit-elementor-addons' ),
                'category'  => 'list'
            ],
            "tags-cloud"   => [
                'name'  => esc_html__( 'Tag Cloud', 'news-kit-elementor-addons' ),
                'category'  => 'tags-cloud'
            ],
            "tags-cloud-animation"   => [
                'name'  => esc_html__( 'Tags Cloud Animation', 'news-kit-elementor-addons' ),
                'category'  => 'tags-cloud-animation'
            ]
        ));
    }
    
    // Theme Builder Template Check
	public static function is_theme_builder_template() {
		$current_page = get_post(get_the_ID());

		if ( $current_page ) {
			return strpos($current_page->post_name, 'user-archive') !== false || strpos($current_page->post_name, 'user-single') !== false || strpos($current_page->post_name, 'user-product') !== false;
		} else {
			return false;
		}
	}

    public static function library_widgets_data() {
        $library_widgets_data = file_get_contents( NEKIT_PATH . '/library/assets/library.json' );
        return apply_filters( 'nekit_library_get_widgets_data', $library_widgets_data );
    }

    public static function library_pages_data() {
        $library_pages_data = file_get_contents( NEKIT_PATH . '/library/assets/library-pages.json' );
        return apply_filters( 'nekit_library_get_pages_data', $library_pages_data );
    }

    public function clear_theme_filters() {
        remove_filter( 'get_the_archive_title_prefix', 'nekit_prefix_string' ); // remove filter applied to the archive title
    }
}