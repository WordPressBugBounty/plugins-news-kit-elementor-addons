<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use Elementor\Controls_Manager;
use Elementor\Plugin;

class Nekit_Document extends Elementor\Core\Base\Document {
	public function get_name() {
		return 'nekit-document';
	}
	
	public static function get_type() {
		return 'nekit-document';
	}
	
	public static function get_title() {
		return esc_html__( 'Nekit Theme Builder', 'news-kit-elementor-addons' );
	}
	
	public static function get_properties() {
		$properties = parent::get_properties();
		$properties['support_kit'] = true;
		$properties['cpt'] = [ 'nekit-mm-cpt' ];
		return $properties;
	}

	function get_post_categories() {
		$base_categories = [];
		$categories = get_terms( [ 'taxonomy'	=>	'category', 'hide_empty'	=>	false] );
		if( !empty( $categories ) ) {
			foreach( $categories as $category ) {
				$base_categories[ $category->term_id ] = esc_html( $category->name ). ' ('.absint( $category->count ). ')';
			}
		}
		return $base_categories;
	}
	
	function get_post_tags() {
		$base_tags = [];
		$tags = get_terms( 'post_tag' );
		if( !empty( $tags ) ) {
			foreach( $tags as $tag ) {
				$base_tags[ $tag->term_id ] = esc_html( $tag->name ). ' ('.absint( $tag->count ). ')';
			}
		}
		return $base_tags;
	}

	function get_post_authors() {
		$base_authors = [];
		$admin_users = get_users(array( 'role__not_in' => 'subscriber', 'fields'  => array('ID','display_name')) );
		if( $admin_users ) {
			foreach( $admin_users as $admin_user ) {
				$base_authors[$admin_user->ID] = $admin_user->display_name;
			}
		}
		return $base_authors;
	}

	protected function register_controls() {
		if( get_post_meta( get_the_ID(), 'builder_type', true ) == 'archive-builder' ) {
			$pages_args = [
				'recent-posts'  => esc_html__( 'Recent posts', 'news-kit-elementor-addons' ),
				'date-archives' => esc_html__( 'Date Archives', 'news-kit-elementor-addons' ),
				'author-archives'   => esc_html__( 'Author Archives', 'news-kit-elementor-addons' ),
				'categories-archives'=> esc_html__( 'Categories Archives', 'news-kit-elementor-addons' ),
				'tags-archives' => esc_html__( 'Tags Archives', 'news-kit-elementor-addons' ),
				'search-results'    => esc_html__( 'Search Results', 'news-kit-elementor-addons' )
			];
		} else {
			$pages_args = [
				'posts'  => esc_html__( 'Posts', 'news-kit-elementor-addons' ),
				'pages'  => esc_html__( 'Pages', 'news-kit-elementor-addons' )
			];
		}
		/**
		 * MARK: NEWS ELEMENTOR PREVIEW
		 */
		$this->start_controls_section(
			'nekit_preview_section',
			[
				'label' => esc_html__( 'News Elementor Preview Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
			]
		);

		$this->add_control(
			'nekit_preview_page',
			[
				'label' => esc_html__( 'Preview archive page', 'news-kit-elementor-addons' ),
				'type'  => \Elementor\Controls_Manager::SELECT,
				'default'   => ( get_post_meta( get_the_ID(), 'builder_type', true ) == 'archive-builder' ) ? 'recent-posts': 'posts',
				'label_block'   => true,
				'options'   => $pages_args
			]
		);

		$this->add_control(
			'nekit_archive_preview_author',
			[
				'label' => esc_html__( 'Preview archive page', 'news-kit-elementor-addons' ),
				'show_label'    => false, 
				'type'  => \Elementor\Controls_Manager::SELECT,
				'default'   => '',
				'label_block'   => true,
				'options'   => $this->get_post_authors(),
				'condition' => [
					'nekit_preview_page'    => 'author-archives'
				]
			]
		);

		$this->add_control(
			'nekit_archive_preview_category',
			[
				'label' => esc_html__( 'Preview category page', 'news-kit-elementor-addons' ),
				'show_label'    => false, 
				'type'  => \Elementor\Controls_Manager::SELECT,
				'default'   => '',
				'label_block'   => true,
				'options'   => $this->get_post_categories(),
				'condition' => [
					'nekit_preview_page'    => 'categories-archives'
				]
			]
		);

		$this->add_control(
			'nekit_archive_preview_tag',
			[
				'label' => esc_html__( 'Preview tag page', 'news-kit-elementor-addons' ),
				'show_label'    => false, 
				'type'  => \Elementor\Controls_Manager::SELECT,
				'default'   => '',
				'label_block'   => true,
				'options'   => $this->get_post_tags(),
				'condition' => [
					'nekit_preview_page'    => 'tags-archives'
				]
			]
		);

		$this->add_control(
			'nekit_archive_preview_search',
			[
				'label' => esc_html__( 'Search Term', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'news', 'news-kit-elementor-addons' ),
				'placeholder' => esc_html__( 'Type your search keyword . .', 'news-kit-elementor-addons' ),
				'condition' => [
					'nekit_preview_page' => 'search-results',
				]
			]
		);

		$this->add_control(
			'nekit_single_preview_post',
			[
				'label'	=> esc_html__( 'Post', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'type' => 'nekit-select2-extend',
				'options'	=> 'select2extend/get_posts_by_post_type',
				'query_slug'	=> 'post',
				'condition' => [
					'nekit_preview_page' => 'posts',
				]
			]
		);

		$this->add_control(
			'nekit_single_preview_page',
			[
				'label'	=> esc_html__( 'Page', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'type' => 'nekit-select2-extend',
				'options'	=> 'select2extend/get_posts_by_post_type',
				'query_slug'	=> 'page',
				'condition' => [
					'nekit_preview_page' => 'pages',
				]
			]
		);

		$this->add_control(
			'preview_settings_actions',
			[
				'label' => esc_html__( 'Save Settings', 'news-kit-elementor-addons' ),
				'show_label'	=> false,
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => '<div class="nekit-save-preview-settings">' .esc_html__( "Save and Preview", "news-kit-elementor-addons" ). '</div>',
				'content_classes' => 'nekit-button-actions'
			]
		);
		$this->end_controls_section();
			
		// Default Document Settings
		parent::register_controls();
	}

	public function get_tax_query_args( $tax, $terms ) {
		$terms = empty($terms) ? [ 'all' ] : $terms;
		$args = [
			'tax_query' => [
				[
					'taxonomy' => $tax,
					'terms' => $terms,
					'field' => 'term_id',
				],
			],
		];

		return $args;
	}

	public function get_document_query_args() {
		$settings = $this->get_settings();
		$args = false;
		$source = $settings['nekit_preview_page'];
		// Default Archives
		switch ( $source ) {
			case 'recent-posts': $args = [ 
										'post_type' => 'post'
									];
								break;
			case 'categories-archives': 
				$args = $this->get_tax_query_args( 'category', $settings['nekit_archive_preview_category'] );
								break;
			case 'tags-archives': $args = $this->get_tax_query_args( 'post_tag', $settings['nekit_archive_preview_tag'] );
								break;
			case 'date-archives': $args = [
										'year'	=>	date('Y')
			];
								break;
			case 'author-archives': $args = [ 
										'author' => $settings['nekit_archive_preview_author']
									];
								break;
			case 'search-results':  $args = [ 
										's' => $settings['nekit_archive_preview_search']
									];
								break;
			case 'pages':  // Get Post
							$page = get_posts( [
								'post_type' => 'page',
								'numberposts' => 1,
								'orderby' => 'date',
								'order' => 'DESC',
								'suppress_filters' => false,
							]);
							$args = [ 'post_type' => 'page' ];
				
							// Last Post for Single Pages
							if( isset( $settings['nekit_single_preview_page'] ) && $settings['nekit_single_preview_page'] ) {
								$args['p'] = $settings['nekit_single_preview_page'];
							} else if ( ! empty( $post ) ) {
								$args['p'] = $post[0]->ID;
							}
						break;
		}

		// Default
		if ( false === $args ) {
			// Get Post
			$post = get_posts( [
				'post_type' => 'post',
				'numberposts' => 1,
				'orderby' => 'date',
				'order' => 'DESC',
				'suppress_filters' => false
			]);
			$args = [ 'post_type' => 'post' ];

			// last post for single pages
			if( isset( $settings['nekit_single_preview_post'] ) && $settings['nekit_single_preview_post'] ) {
				$args['p'] = $settings['nekit_single_preview_post'];
			} else if ( ! empty( $post ) ) {
				$args['p'] = $post[0]->ID;
			}
		}

		return $args;
	}

	public function switch_to_preview_query() {
		if ( 'nekit-mm-cpt' === get_post_type( get_the_ID() ) ) {
			$document = Elementor\Plugin::instance()->documents->get_doc_or_auto_save( get_the_ID() );
			Elementor\Plugin::instance()->db->switch_to_query( $document->get_document_query_args() );
		}
	}

	public function get_content( $with_css = false ) {
		$this->switch_to_preview_query();
		$content = parent::get_content( $with_css );
		Elementor\Plugin::instance()->db->restore_current_query();
		return $content;
	}

	public function print_content() {
		$plugin = Plugin::elementor();

		if ( $plugin->preview->is_preview_mode( $this->get_main_id() ) ) {
			echo ''. wp_kses_post( $plugin->preview->builder_wrapper( '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			echo ''. wp_kses_post( $this->get_content() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	public static function get_preview_as_default() {
		return '';
	}

	public static function get_preview_as_options() {
		return [];
	}
	
	public function get_elements_raw_data( $data = null, $with_html_content = false ) {
		$this->switch_to_preview_query();

		$editor_data = parent::get_elements_raw_data( $data, $with_html_content );

		Elementor\Plugin::instance()->db->restore_current_query();

		return $editor_data;
	}

	public function render_element( $data ) {
		$this->switch_to_preview_query();
		$render_html = parent::render_element( $data );

		Elementor\Plugin::instance()->db->restore_current_query();

		return $render_html;
	}
}