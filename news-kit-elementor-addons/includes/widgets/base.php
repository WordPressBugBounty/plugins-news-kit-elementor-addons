<?php
/**
 * Back To Top Widget 
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
namespace Nekit_Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Base extends \Elementor\Widget_Base {
	private $divider = 0;
	public function get_name() {
		return $this->widget_name;
	}

    public function get_title() {
		return nekit_get_widgets_info($this->widget_name)['title'];
	}
	
	public function get_icon() {
		return esc_attr( 'nekit-icon ' . nekit_get_widgets_info($this->widget_name)['icon'] );
	}

	public function get_categories() {
		return [ 'nekit-widgets-group' ];
	}

	function add_layouts_skin_control() {
		$this->add_control(
			'widget_skin',
			[
				'label' => esc_html__( 'Skin', 'news-kit-elementor-addons' ),
				'type'  => \Elementor\Controls_Manager::SELECT,
                'default'   => 'classic',
				'options'   => [
                    'classic'   => esc_html__( 'Classic', 'news-kit-elementor-addons' ),
                    'card'  => esc_html__( 'Card', 'news-kit-elementor-addons' )
                ]
			]
		);
	}

	function get_item_orientation_control() {
		$this->add_control(
			'items_orientation',
			[
				'label' => esc_html__( 'Items Orientation', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'horizontal' => [
						'title' => esc_html__( 'Horizontal', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-navigation-horizontal'
					],
					'vertical' => [
						'title' => esc_html__( 'Vertical', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-navigation-vertical'
					]
				],
				'default' => 'horizontal',
				'toggle' => false
			]
		);
	}

	function insert_divider() {
		$this->divider++;
		$this->add_control(
			$this->widget_name . $this->divider,
			[
				'type'	=>	\Elementor\Controls_Manager::DIVIDER
			]
		);
	}

	function add_post_order_select_control($name = 'post_order') {
		$this->add_control(
			$name,
			[
				'label' =>  esc_html__( 'Post Order', 'news-kit-elementor-addons' ),
				'type'  =>  \Elementor\Controls_Manager::SELECT,
				'default'   =>  'date-desc',
				'label_block'   =>  true,
				'options'   =>  nekit_get_widgets_post_order_options_array()
			]
		);
	}

	function add_authors_select_control( $name = 'post_authors' , $label = 'Post' ) {
		$this->add_control(
			$name,
			[
				'label'	=> esc_html( $label ) . esc_html__( ' authors', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'multiple'	=> true,
				'type' => 'nekit-select2-extend',
				'options'	=> 'select2extend/get_users',
				'condition'	=> apply_filters( 'nekit_query_control_condition_filter', [ 'post_order'	=> 'random' ] )
			]
		);
	}

	function add_categories_select_control($name = 'post_categories') {
		$this->add_control(
			$name,
			[
				'label'	=> esc_html__( 'Post categories', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'multiple'	=> true,
				'type' => 'nekit-select2-extend',
				'options'	=> 'select2extend/get_taxonomies',
				'query_slug'	=> 'category'
			]
		);
	}

	function add_tags_select_control($name = 'post_tags') {
		$this->add_control(
			$name,
			[
				'label'	=> esc_html__( 'Post tags', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'multiple'	=> true,
				'type' => 'nekit-select2-extend',
				'options'	=> 'select2extend/get_taxonomies',
				'query_slug'	=> 'post_tag',
				'condition'	=> apply_filters( 'nekit_query_control_condition_filter', [ 'post_order'	=> 'random' ] )
			]
		);
	}

	function add_posts_exclude_select_control($name = 'post_to_exclude', $query_slug = 'post', $label = 'Posts' ) {
		$this->add_control(
			$name,
			[
				'label'	=> $label . esc_html__( ' to exclude', 'news-kit-elementor-addons' ),
				'description'	=> $label . esc_html__( ' to exclude from the query', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'multiple'	=> true,
				'type'	=> 'nekit-select2-extend',
				'options'	=> 'select2extend/get_posts_by_post_type',
				'query_slug'=> $query_slug,
				'condition'	=> apply_filters( 'nekit_query_control_condition_filter', [ 'post_order'	=> 'random' ] )
			]	
		);
	}
	function add_posts_include_select_control($name = 'post_to_include', $query_slug = 'post', $label = 'Posts' ) {
		$this->add_control(
			$name,
			[
				'label'	=> $label . esc_html__( ' to include', 'news-kit-elementor-addons' ),
				'description'	=> $label . esc_html__( ' to include in the query', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'multiple'	=> true,
				'type'	=> 'nekit-select2-extend',
				'options'	=> 'select2extend/get_posts_by_post_type',
				'query_slug'=> $query_slug
			]	
		);
	}

	function add_post_element_author_control() {
		$this->add_control(
			'show_post_author',
			[
				'label' => esc_html__( 'Show Post Author', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'post_author_icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'prefix',
				'label_block'   => false,
				'options' => [
					'prefix'	=> esc_html__( 'Before', 'news-kit-elementor-addons' ),
					'suffix'	=> esc_html__( 'After', 'news-kit-elementor-addons' )
				],
				'condition'	=> apply_filters( 'nekit_widget_post_author_condition_filter', [
					'show_post_author'	=> 'pro'
				])
			]
		);
		
		$this->add_control(
            'post_author_icon',
            [
                'label' =>  esc_html__( 'Author Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
				'label_block'   => false,
                'skin'  =>  'inline',
				'recommended'	=> [
					'fa-solid'	=> ['users','user','users-cog','user-tie','user-tag','user-shield','user-secret','user-plus','user-nurse','user-md','user-graduate','user-friends','user-edit','user-cog','user-circle','user-check','user-astronaut','user-alt','feather','highlighter','pen'],
					'fa-regular'	=> ['user','user-circle']
				],
                'default'   =>  [
                    'value' =>  'far fa-user-circle',
                    'library'   =>  'fa-regular'
				],
				'separator'	=> 'after',
				'condition'	=> apply_filters( 'nekit_widget_post_author_condition_filter', [
					'show_post_author'	=> 'pro'
				])
            ]
        );
	}

	function add_post_element_date_control( $prefix = '' ) {
		$this->add_control(
			$prefix . 'show_post_date',
			[
				'label'	=> esc_html__( 'Show Post Date', 'news-kit-elementor-addons' ),
				'type'	=> \Elementor\Controls_Manager::SWITCHER,
				'label_on'	=> esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default'	=> 'yes'
			]
		);

		$this->add_control(
			$prefix . 'post_date_icon_position',
			[
				'label'	=> esc_html__( 'Icon Position', 'news-kit-elementor-addons' ),
				'type'	=> \Elementor\Controls_Manager::SELECT,
				'default' => 'prefix',
				'label_block'   => false,
				'options' => [
					'prefix'	=> esc_html__( 'Before', 'news-kit-elementor-addons' ),
					'suffix'	=> esc_html__( 'After', 'news-kit-elementor-addons' )
				],
				'condition'	=> apply_filters( 'nekit_widget_post_date_condition_filter', [
					$prefix . 'show_post_date'	=> 'pro'
				])
			]
		);
		
		$this->add_control(
            $prefix . 'post_date_icon',
            [
                'label' =>  esc_html__( 'Date Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
				'label_block'   => false,
                'skin'  =>  'inline',
				'recommended'	=> [
					'fa-solid'	=> ['clock','calendar','calendar-week','calendar-times','calendar-plus','calendar-minus','calendar-day','calendar-check','calendar-alt','hour-glass'],
					'fa-regular'	=> ['clock','calendar','calendar-week','calendar-times','calendar-plus','calendar-minus','calendar-day','calendar-check','calendar-alt','hour-glass']
				],
                'default'   => [
                    'value' =>  'fas fa-calendar',
                    'library'   =>  'fa-solid'
				],
				'condition'	=> apply_filters( 'nekit_widget_post_date_condition_filter', [
					$prefix . 'show_post_date'	=> 'pro'
				])
            ]
        );
	}

	function add_post_element_comments_control() {
		$this->add_control(
			'show_post_comments',
			[
				'label' => esc_html__( 'Show Post Comments', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes'
			]
		);

		$this->add_control(
			'post_comments_icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'prefix',
				'label_block'   => false,
				'options' => [
					'prefix'	=> esc_html__( 'Before', 'news-kit-elementor-addons' ),
					'suffix'	=> esc_html__( 'After', 'news-kit-elementor-addons' )
				],
				'condition'	=> apply_filters( 'nekit_widget_post_comments_condition_filter', [
					'show_post_comments'	=> 'pro'
				])
			]
		);

		$this->add_control(
            'post_comments_icon',
            [
                'label' =>  esc_html__( 'Comments Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
				'label_block'   => false,
                'skin'  =>  'inline',
				'recommended'	=> [
					'fa-solid'	=> ['comments','comment','comments-dollar','comment-dots','comment-alt'],
					'fa-regular'	=> ['comments','comment','comment-dots','comment-alt']
				],
                'default'   =>  [
                    'value' =>  'far fa-comment',
                    'library'   =>  'fa-regular'
				],
				'separator'	=> 'after',
				'condition'	=> apply_filters( 'nekit_widget_post_comments_condition_filter', [
					'show_post_comments'	=> 'pro'
				])
            ]
        );
	}

	function add_card_skin_style_control() {
		$this->start_controls_section(
            'card_skin_styles',
            [
                'label' =>  esc_html__( 'Card Skin Styles', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'post_background_color',
                'selector'  =>  '{{WRAPPER}} .skin--card .nekit-item-box-wrap, {{WRAPPER}} .skin--card.nekit-news-grid-two-posts-wrap .post-element, 
                {{WRAPPER}} .skin--card.nekit-news-carousel-three-posts-wrap .post-element, {{WRAPPER}} .nekit-news-list-two-posts-wrap.skin--card .post-title,
                {{WRAPPER}} .nekit-archive-posts-wrap.layout--three.skin--card .post-element, {{WRAPPER}} .nekit-archive-posts-wrap.layout--four.skin--card .post-title',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic'
                    ],
                    'color' => [
                        'default' => '#ffffff'
                    ]
                ],
                'exclude'   =>  ['image']
            ]
        );

		$this->add_control(
			'card_hover_effects_dropdown',
			[
				'label'	=>	esc_html__( 'Hover Effects', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SELECT,
				'options'	=>	nekit_get_card_skin_effects_array(),
				'default'	=>	'none'
			]
		);
        $this->insert_divider();
        $this->start_controls_tabs(
            'card_skin_box_shadow_tabs'
        );

            $this->start_controls_tab(
                'card_skin_box_shadow_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  => 'card_initial_background',
                    'selector'=> '{{WRAPPER}} .skin--card .nekit-item-box-wrap',
					'exclude'	=>	['image']
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'  => 'card_initial_box_shadow',
                    'selector'=> '{{WRAPPER}} .skin--card .nekit-item-box-wrap'
                ]
            );
            $this->end_controls_tab();
            $this->start_controls_tab(
                'card_skin_box_shadow_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'	=> 'card_hover_background_color',
                    'selector'	=> '{{WRAPPER}} .skin--card .nekit-item-box-wrap:hover',
					'exclude'	=>	['image']
                ]
            );
            $this->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name'  => 'card_hover_box_shadow',
                    'selector'=> '{{WRAPPER}} .skin--card .nekit-item-box-wrap:hover'
                ]
            );
            $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->insert_divider();

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'	=>	'card_border',
				'selector'	=>	'{{WRAPPER}} .skin--card .nekit-item-box-wrap'
			]
		);		

        $this->add_responsive_control(
            'card_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .skin--card .nekit-item-box-wrap'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'default'   =>  [
                    'top'   =>  7,
                    'right' =>  7,
                    'bottom'    =>  7,
                    'left'  =>  7,
                    'unit'  =>  'px',
                    'isLinked'  =>  true,
                ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .skin--card .nekit-item-box-wrap'  =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();
	}

	function add_image_overlay_section() {
		$this->start_controls_section(
            'image_overlay',
            [
                'label' =>  esc_html__( 'Image Overlay', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'image_overlay_option',
            [
                'label' =>  esc_html__( 'Show image overlay', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes'
            ]
        );

        $this->start_controls_tabs(
            'image_overlay_tabs'
        );
            $this->start_controls_tab(
                'image_overlay_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'	=>  'image_overlay_initial_background_color',
                    'selector'  =>  '{{WRAPPER}} .has-image-overlay::before',
                    'exclude'   =>  ['image']
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Css_Filter::get_type(),
                [
                    'name'  =>  'image_overlay_initial_css_filter',
                    'selector'  =>  '{{WRAPPER}} .post-item img'
                ]
            );
            $this->end_controls_tab();
            $this->start_controls_tab(
                'image_overlay_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'	=>  'image_overlay_hover_background_color',
                    'selector'  =>  '{{WRAPPER}} .post-item:hover .has-image-overlay::before',
                    'exclude'   =>  ['image']
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Css_Filter::get_type(),
                [
                    'name'  =>  'image_overlay_hover_css_filter',
                    'selector'  =>  '{{WRAPPER}} .post-item:hover img'
                ]
            );
            $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->insert_divider();
        $this->add_responsive_control(
            'image_overlay_width',
            [
                'label' =>  esc_html__( 'Width', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'size_units'    =>  ['%'],
                'range' =>  [
                    '%' =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  100,
                    'unit'  =>  '%'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .has-image-overlay::before'    =>  'width:{{SIZE}}%'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_overlay_height',
            [
                'label' =>  esc_html__( 'Height', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SLIDER,
                'size_units'    =>  ['%'],
                'range' =>  [
                    '%' =>  [
                        'min'   =>  0,
                        'max'   =>  100,
                        'step'  =>  1
                    ]
                ],
                'default'   =>  [
                    'size'  =>  100,
                    'unit'  =>  '%'
                ],
                'selectors' =>  [
                    '{{WRAPPER}} .has-image-overlay::before'    =>  'height:{{SIZE}}%'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_overlay_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .has-image-overlay::before'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );
        $this->end_controls_section();
	}
	
	// Get list of html tags
	public function get_html_tags() {
		return apply_filters( 'nekit_widgets_html_tags_array_filter', [
			'h1'	=> 'H1',
			'h2'	=> 'H2',
			'h3'	=> 'H3',
			'h4'	=> 'H4',
			'h5'	=> 'H5',
			'h6'	=> 'H6',
			'div'	=> 'div',
			'span'	=> 'span',
			'p'	=> 'P'
		]);
	}

	// badges option array
	public function get_posts_badges() {
		return apply_filters( 'nekit_widgets_html_tags_array_filter', [
			'categories'	=> esc_html__( 'Categories', 'news-kit-elementor-addons' ),
			'tags'	=> esc_html__( 'Tags', 'news-kit-elementor-addons' ),
			'date'	=> esc_html__( 'Date', 'news-kit-elementor-addons' ),
			'author'	=> esc_html__( 'Author', 'news-kit-elementor-addons' ),
			'caption'	=> esc_html__( 'Featured Image Caption', 'news-kit-elementor-addons' )
		]);
	}

	// Get list of image sizes
	public function get_image_sizes() {
		$sizes_lists = [];
		$images_sizes = get_intermediate_image_sizes();
		if( $images_sizes ) {
			foreach( $images_sizes as $size ) {
				$sizes_lists[$size] = $size;
			}
		}
		return $sizes_lists;
	}

	function post_title_animation_type_control() {
        $this->add_control(
            'post_title_animation_choose',
            [
                'label' =>  esc_html__( 'Post Title Animation Type', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'options'   =>  [
                    'custom' =>  [
                        'title' =>  esc_html__( 'Custom', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-custom'
                    ],
                    'elementor' =>  [
                        'title' =>  esc_html__( 'Elementor', 'news-kit-elementor-addons' ),
                        'icon'  =>  'eicon-elementor'
                    ]
                ],
                'label_block'   =>  true,
                'default'   =>  'custom',
                'toggle'    =>  false
            ]
        );

        $this->add_control(
            'post_title_custom_animation',
            [
                'label' =>  esc_html__( 'Custom Animation', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SELECT,
                'options'   =>  nekit_get_post_title_animation_effects_array(),
                'label_block'   =>  true,
                'default'   =>  'none',
                'condition' =>  [
                    'post_title_animation_choose'   =>  'custom'
                ]
            ]
        );

        $this->add_control(
            'post_title_hover_animation',
            [
                'label' =>  esc_html__( 'Elementor Animation', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HOVER_ANIMATION,
                'condition' =>  [
                    'post_title_animation_choose'   =>  'elementor'
                ]
            ]
        );
		$this->insert_divider();
    }
	
	function general_styles_primary_color_control() {
		$this->add_control(
			'general_styles_primary_color',
			[
				'label'	=>	esc_html__( 'Primary Color', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::COLOR,
				'default'	=>	'#969696',
				'selectors'	=>	[
					'{{WRAPPER}} .custom-animation--one a'	=>	'background-image: linear-gradient(transparent calc( 100% - 2px), {{VALUE}} 1px )',
					'{{WRAPPER}} .custom-animation--two a'	=>	'background-image: linear-gradient(to right,{{VALUE}},{{VALUE}} 50%,currentColor 50%);',
					'{{WRAPPER}} .custom-animation--three a'	=>	'background-image: linear-gradient(90deg,{{VALUE}} 0,{{VALUE}} 94%);',
					'{{WRAPPER}} .custom-animation--four a:hover'	=>	'background-image: linear-gradient({{VALUE}},{{VALUE}});',
					'{{WRAPPER}} .custom-animation--five a'	=>	'background-image: linear-gradient({{VALUE}},{{VALUE}});',
					'{{WRAPPER}} .custom-animation--six a'	=>	'background-image: linear-gradient(currentColor, currentColor), linear-gradient( currentColor, currentColor ), linear-gradient({{VALUE}}, {{VALUE}});',
					'{{WRAPPER}} .custom-animation--seven a'	=>	'background-image: linear-gradient(transparent calc(100% - 10px), {{VALUE}} 30px);',
					'{{WRAPPER}} .custom-animation--eight a'	=>	'background-image: linear-gradient(to bottom, {{VALUE}}, {{VALUE}}), linear-gradient(to left, currentColor, currentColor);',
					'{{WRAPPER}} .custom-animation--nine a'	=>	'background-image: linear-gradient(to bottom, {{VALUE}}, {{VALUE}}), linear-gradient(to bottom, currentColor, currentColor);',
					'{{WRAPPER}} .custom-animation--ten a'	=>	'background-image: linear-gradient(to bottom, {{VALUE}} 45%, currentColor 55%);',
					'{{WRAPPER}} .nekit-banner-wrap .slick-active button:before'	=>	'background-color: {{VALUE}};'
				]
			]
		);
	}

	// prepare the args array for widget query
	function get_posts_args_for_query( $prefix = 'post' ) {
		$settings = $this->get_settings_for_display();
		$post_order = ( strpos( $settings[$prefix . '_order'], '-pro' ) === false ) ? $settings[$prefix . '_order']: 'date-desc';
		$post_order_split = explode( '-', $post_order );
		$post_count = $settings[$prefix . '_count'];
		$post_categories = $settings[$prefix . '_categories'];
		$post_tags = $settings[$prefix . '_tags'];
		$post_authors = $settings[$prefix . '_authors'];
		$posts_args = [
			'post_type' => 'post',
			'orderby'	=> $post_order_split[0],
			'order'	=> $post_order_split[1],
			'posts_per_page'	=> absint( $post_count )
		];
		if( $settings[$prefix . '_offset'] > 0 ) $posts_args['offset'] = absint( $settings[$prefix . '_offset'] );
		if($post_categories) $posts_args['cat'] = implode( ',', $post_categories );
		if($post_authors) $posts_args['author'] = implode( ',', $post_authors );
		if($post_tags) $posts_args['tag__in'] = $post_tags;
		if( $settings[$prefix . '_hide_post_without_thumbnail'] === 'yes' ) {
			$posts_args['meta_query'] = [
				[
					'key' => '_thumbnail_id',
					'compare' => 'EXISTS'
				]
			];
		}
		if( $settings[$prefix . '_to_exclude'] ) $posts_args['post__not_in'] = $settings[$prefix . '_to_exclude'];
		if( isset( $settings[$prefix . '_to_include'] ) ) :
			if( $settings[$prefix . '_to_include'] ) $posts_args['post__in'] = $settings[$prefix . '_to_include'];
		endif;
		return apply_filters( 'nekit_widgets_query_args_filter', $posts_args );
	}
}

function nekit_get_widgets_info($widget_name = '') {
	$widgets = [
		'nekit-ticker-news-one'	=> [
			'title'	=> esc_html__( 'Ticker News - Marquee', 'news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-ticker-news-one'
		],
		'nekit-ticker-news-two'	=>	[
			'title'	=>	esc_html__( 'Ticker News - Slider', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-ticker-news-slider'
		],
		'nekit-main-banner-one'	=> [
			'title'	=> esc_html__( 'Main Banner 1', 'news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-main-banner-one'
		],
		'nekit-main-banner-two'	=> [
			'title'	=> esc_html__( 'Main Banner 2', 'news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-main-banner-two'
		],
		'nekit-main-banner-three'	=> [
			'title'	=> esc_html__( 'Main Banner 3', 'news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-main-banner-three'
		],
		'nekit-main-banner-four'	=> [
			'title'	=> esc_html__( 'Main Banner 4', 'news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-main-banner-four'
		],
		'nekit-main-banner-five'	=>	[
			'title'	=>	esc_html__( 'Main Banner 5', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-main-banner-five'
		],
		'nekit-site-nav-mega-menu'	=> [
			'title'	=> esc_html__( 'Site Nav Mega Menu', 'news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-site-mega-menu'
		],
		'nekit-site-nav-menu'	=> [
			'title'	=> esc_html__( 'Site Nav Menu', 'news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-site-nav-menu'
		],
		'nekit-archive-title'	=> [
			'title'	=> esc_html__( 'Archive Title', 'news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-single-title'
		],
		'nekit-archive-posts'	=> [
			'title'	=> esc_html__( 'Archive Posts', 'news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-archive-posts'
		],
		'nekit-single-title'	=> [
			'title'	=> esc_html__( 'Single Title', 'news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-single-title'
		],
		'nekit-back-to-top'	=> [
			'title'	=> esc_html__( 'Back To Top', 'news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-back-to-top'
		],
		'nekit-date-and-time'	=> [
			'title'	=> esc_html( 'Date and Time', 'news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-date-time'
		],
		'nekit-video-playlist'	=> [
			'title'	=> esc_html( 'Video Playlist', 'news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-video-playlist'
		],
		'nekit-full-width-banner'	=>	[
			'title'	=>	esc_html__( 'Full Width Banner', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-full-width-banner'
		],
		'nekit-categories-collection'	=>	[
			'title'	=>	esc_html__( 'Categories Collection', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-categories-collection'
		],
		'nekit-news-timeline'	=>	[
			'title'	=>	esc_html__( 'News Timeline', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-news-timeline'
		],
		'nekit-advanced-heading-icon'	=>	[
			'title'	=>	esc_html__( 'Advanced Heading', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-advanced-heading'
		],
		'nekit-single-featured-image'	=>	[
			'title'	=>	esc_html__( 'Single Featured Image', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-featured-image'
		],
		'nekit-single-content'	=>	[
			'title'	=>	esc_html__( 'Single Content', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-single-content'
		],
		'nekit-single-tags'	=>	[
			'title'	=>	esc_html__( 'Single Tags', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-tags-cloud'
		],
		'nekit-news-carousel-one'	=>	[
			'title'	=>	esc_html__( 'News Carousel 1', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-carousel-one'
		],
		'nekit-news-carousel-two'	=>	[
			'title'	=>	esc_html__( 'News Carousel 2', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-carousel-two'
		],
		'nekit-news-carousel-three'	=>	[
			'title'	=>	esc_html__( 'News Carousel 3', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-carousel-three'
		],
		'nekit-news-grid-one'	=>	[
			'title'	=>	esc_html__( 'News Grid 1', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-grid-one'
		],
		'nekit-news-grid-two'	=>	[
			'title'	=>	esc_html__( 'News Grid 2', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-grid-two'
		],
		'nekit-news-grid-three'	=>	[
			'title'	=>	esc_html__( 'News Grid 3', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-grid-three'
		],
		'nekit-news-list-one'	=>	[
			'title'	=>	esc_html__( 'News List 1', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-list-one'
		],
		'nekit-news-list-two'	=>	[
			'title'	=>	esc_html__( 'News List 2', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-list-two'
		],
		'nekit-news-list-three'	=>	[
			'title'	=>	esc_html__( 'News List 3', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-list-three'
		],
		'nekit-single-categories'	=>	[
			'title'	=>	esc_html__( 'Single Category','news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-tags-cloud'
		],
		'nekit-single-date'	=>	[
			'title'	=>	esc_html__( 'Single Date','news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-single-date'
		],
		'nekit-single-author'	=>	[
			'title'	=>	esc_html__( 'Single Author','news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-single-author'
		],
		'nekit-single-author-box'	=>	[
			'title'	=>	esc_html__( 'Single Author Box','news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-single-author-box'
		],
		'nekit-single-comment'	=>	[
			'title'	=>	esc_html__( 'Single Comment','news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-single-comment'
		],
		'nekit-single-comment-box'	=>	[
			'title'	=>	esc_html__( 'Single Comment Box','news-kit-elementor-addons' ),
			'icon'	=> 'icon-nekit-single-comment-box'
		],
		'nekit-single-related-post'	=>	[
			'title'	=>	esc_html__( 'Single Related Post', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-grid-one'
		],
		'nekit-single-post-navigation'	=>	[
			'title'	=>	esc_html__( 'Single Post Navigation', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-single-post-navigation'
			
		],
		'nekit-single-table-of-content'	=>	[
			'title'	=>	esc_html__( 'Single Table of Content', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-table-of-content'
			
		],
		'nekit-news-block-one'	=>	[
			'title'	=>	esc_html__( 'News Block 1', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-news-block-one'
			
		],
		'nekit-news-block-two'	=>	[
			'title'	=>	esc_html__( 'News Block 2', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-news-block-two'
		],
		'nekit-news-block-three'	=>	[
			'title'	=>	esc_html__( 'News Block 3', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-news-block-three'
		],
		'nekit-news-block-four'	=>	[
			'title'	=>	esc_html__( 'News Block 4', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-news-block-four'
		],
		'nekit-news-filter-one'	=>	[
			'title'	=>	esc_html__( 'News Filter 1', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-news-filter-one'
		],
		'nekit-news-filter-two'	=>	[
			'title'	=>	esc_html__( 'News Filter 2', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-news-filter-two'
		],
		'nekit-news-filter-three'	=>	[
			'title'	=>	esc_html__( 'News Filter 3', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-news-filter-three'
		],
		'nekit-news-filter-four'	=>	[
			'title'	=>	esc_html__( 'News Filter 4', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-news-filter-four'
		],
		'nekit-live-now-button'	=>	[
			'title'	=>	esc_html__( 'Live Now Button', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-live-now-button'
		],
		'nekit-live-search'	=>	[
			'title'	=>	esc_html__( 'Live Search', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-live-search'
		],
		'nekit-mailbox'	=>	[
			'title'	=>	esc_html__( 'Mailbox', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-mailbox'
		],
		'nekit-phone-call'	=>	[
			'title'	=>	esc_html__( 'Phone Call', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-phone-call'
		],
		'nekit-popular-opinions'	=>	[
			'title'	=>	esc_html__( 'Popular Opinions', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-popular-opinions'
		],
		'nekit-random-news'	=>	[
			'title'	=>	esc_html__( 'Random News', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-random-news'
		],
		'nekit-theme-mode'	=>	[
			'title'	=>	esc_html__( 'Theme Mode', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-theme-mode'
		],
		'nekit-site-logo-title'	=>	[
			'title'	=>	esc_html__( 'Site Logo & Title', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-site-logo'
		],
		'nekit-breadcrumb'	=>	[
			'title'	=>	esc_html__( 'Breadcrumb', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-breadcrumb'
		],
		'nekit-social-share'	=>	[
			'title'	=>	esc_html__( 'Social Share', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-social-share'
		],
		'nekit-tags-cloud'	=>	[
			'title'	=>	esc_html__( 'Tags Cloud', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-tags-cloud'
		],
		'nekit-tags-cloud-animation'	=>	[
			'title'	=>	esc_html__( 'Tags Cloud Animation', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-tags-cloud-animation'
		],
		'nekit-canvas-menu'	=>	[
			'title'	=>	esc_html__( 'Canvas Menu', 'news-kit-elementor-addons' ),
			'icon'	=>	'icon-nekit-canvas-menu'
		]
	];
	return $widgets[$widget_name];
}