<?php
/**
 * Main Banner Widget Five
 * 
 * @package News Kit Elementor Addons
 * @since 1.0.0
 */
 namespace Nekit_Widgets;
 use Nekit_Widget_Base;
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
class Main_Banner_Widget_Five extends \Nekit_Widget_Base\Base {
	protected $widget_name = 'nekit-main-banner-five';
	public static $widget_count = 'five';

	public function get_categories() {
		return [ 'nekit-post-layouts-widgets-group' ];
	}

	public function get_custom_help_url() {
		return 'https://blazethemes.com/plugins/blaze-elementor/addons/#banner-widget-five';
	}

	public function get_keywords() {
		return [ 'news', 'banner', 'slider' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'general_section',
			[
				'label' => esc_html__( 'General', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'widget_actions',
			[
				'label' =>  esc_html__( 'Widget Actions', 'news-kit-elementor-addons' ),
				'show_label'    =>  false,
				'type'  =>   \Elementor\Controls_Manager::RAW_HTML,
				'raw'   =>  '<div class="nekit-action-buttons-wrap"><a target="_blank" href="https://prev.blazethemes.com/news-elementor/main-banner-five" class="button-item preview-button">' .esc_html__( "Preview", "news-kit-elementor-addons" ). '</a><a href="#" class="button-item preview-library-button">' .esc_html__( "Widget Library", "news-kit-elementor-addons" ). '</a></div>',
				'content_classes'   =>  'nekit-button-actions'
			]
		);
		
		$this->add_control(
			'main_banner_sorting_heading', [
				'label'	=> esc_html( 'Main Banner Sorting', 'news-kit-elementor-addons'),
				'type'	=> \Elementor\Controls_Manager::HEADING,
				'seperator'	=> 'before'
			]
		);

		$this->add_control(
			'main_banner_sorting',
			[
				'label' => esc_html__( 'Hold and drag the item to change its order', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'type' => 'sortable-control',
				'default'	=> ['main-banner-wrap', 'trailing-posts',],
				'options'	=> array(
					'main-banner-wrap'	=> array(
						'label'	=> esc_html__( 'Main Banner Wrap', 'news-kit-elementor-addons' )
					),
					'trailing-posts'	=> array(
						'label'	=> esc_html__( 'Trailing Posts', 'news-kit-elementor-addons' )
					),
				)
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'slider_posts_query_section',
			[
				'label' => esc_html__( 'Slider Post Query', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);
		$this->add_post_type_select_control( 'slider_post_custom_post_types' );
		$this->add_taxonomy_select_control( 'slider_post_custom_taxonomies', 'Select Taxonomies', [
			'dependency'	=>	'slider_post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'slider_post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_post_order_select_control('slider_post_order');
		$this->add_control(
			'slider_post_count',
			[
				'label' => esc_html__( 'Number of posts to display', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => nekit_get_widgets_post_count_max( $this->widget_name ),
				'step' => 1,
				'default' => 4
			]
		);
		$this->add_authors_select_control('slider_post_authors');
		$this->add_categories_select_control( 'slider_post_categories', [
			'dependency'	=>	'slider_post_custom_taxonomies',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'slider_post_custom_taxonomies',
						'operator'	=>	'!=',
						'value'	=>	''
					],
					[
						'name'	=>	'slider_post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_tags_select_control( 'slider_post_tags', [
			'dependency'	=>	'slider_post_custom_taxonomies',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'slider_post_custom_post_types',
						'operator'	=>	'contains',
						'value'	=>	'post'
					]
				]
			]
		] );
		$this->add_posts_include_select_control( 'slider_post_to_include', 'post', 'Posts', [
			'dependency'	=>	'slider_post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'slider_post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		
		$this->add_control(
			'slider_post_offset',
			[
				'label' => esc_html__( 'Offset', 'news-kit-elementor-addons' ),
				'description' => esc_html__( 'Number of post to displace or pass over.', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 200,
				'step' => 1,
				'default' => 0
			]
		);
		$this->add_posts_exclude_select_control( 'slider_post_to_exclude', 'post', 'Posts', [
			'dependency'	=>	'slider_post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'slider_post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_control(
			'slider_post_hide_post_without_thumbnail',
			[
				'label' => esc_html__( 'Hide Posts with no featured image', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition'	=> apply_filters( 'nekit_query_control_condition_filter', [ 'post_order'	=> 'random' ] )
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'slider_posts_elements_settings_section',
			[
				'label' => esc_html__( 'Slider Post Elements Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'slider_show_post_title',
			[
				'label' => esc_html__( 'Show Post Title', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_control(
			'slider_show_post_categories',
			[
				'label' => esc_html__( 'Show Post Categories', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);

		$this->add_post_element_date_control('slider_');

		$this->add_control(
			'slider_show_post_excerpt',
			[
				'label' => esc_html__( 'Show Post Excerpt', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no'
			]
		);

		$this->add_control(
			'slider_show_post_excerpt_length',
			[
				'label' => esc_html__( 'Excerpt length', 'news-kit-elementor-addons' ),
				'description' => esc_html__( 'It counts the number of words', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'default' => 10,
				'condition' =>  apply_filters( 'nekit_widget_post_excerpt_condition_filter', [
                    'slider_show_post_excerpt' =>  'pro'
                ])
			]
		);

		$this->add_control(
			'slider_post_elements_align_heading',
			[
				'label' => esc_html__( 'Elements Alignment', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'slider_post_elements_align',
			[
				'label' => esc_html__( 'Elements Alignment', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'news-kit-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'toggle' => false,
				'frontend_available' => true,
				'selectors' => [
					'{{WRAPPER}} .main-banner-slider .post-element, {{WRAPPER}} .main-banner-slider .post-element .post-title, {{WRAPPER}} .main-banner-slider .post-element .post-excerpt' => 'text-align: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'slider_posts_elements_sorting',
			[
				'label'	=>	esc_html__( 'Elements Sorting', 'news-kit-elementor-addons' ),
				'description'	=>	esc_html__( 'Hold and drag the item to change its order', 'news-kit-elementor-addons' ),
				'label_block'	=> true,
				'type' => 'sortable-control',
				'default'	=> ['post-meta', 'post-title', 'post-excerpt'],
				'options'	=> array(
					'post-meta'	=> array(
						'label'	=> esc_html__( 'Categories / Date', 'news-kit-elementor-addons' )
					),
					'post-title'	=> array(
						'label'	=> esc_html__( 'Post Title', 'news-kit-elementor-addons' )
					),
					'post-excerpt'	=> array(
						'label'	=> esc_html__( 'Post Excerpt', 'news-kit-elementor-addons' )
					)
				),
                'condition' => apply_filters( 'nekit_elements_sorting_condition_filter', [
                    'slider_post_elements_align' => 'pro'
                ])
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'slider_settings_section',
			[
				'label' => esc_html__( 'Slider Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'main_banner_slider_auto',
			[
				'label' => esc_html__( 'Enable auto slide', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);
		$this->add_control(
			'main_banner_slider_arrows',
			[
				'label' => esc_html__( 'Show slider arrow', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);
		$this->add_control(
			'main_banner_slider_loop',
			[
				'label' => esc_html__( 'Enable slider loop', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);
		$this->add_control(
			'main_banner_slider_dots',
			[
				'label' => esc_html__( 'Show slider dots', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);
		$this->add_control(
			'main_banner_slider_fade',
			[
				'label'	=>	esc_html__( 'Show slider Fade', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'yes'
			]
		);
		$this->add_control(
			'show_slider_arrow_on_hover',
			[
				'label'	=>	esc_html__( 'Show slider arrow on hover', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'default'	=>	'yes',
				'return_value'	=>	'yes'
			]
		);
		$this->add_control(
			'main_banner_slider_speed',
			[
				'label' => esc_html__( 'Slider speed', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 50000,
				'step' => 100,
				'default' => 300
			]
		);
		$this->insert_divider();
		$this->add_control(
            'main_banner_slider_controller_prev_icon',
            [
                'label' =>  esc_html__( 'Prev Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
				'label_block'  =>  false,
                'skin'  =>  'inline',
				'recommended'   => [
					'fa-solid'  => ['angle-left','angle-double-left','caret-left','chevron-left','hand-point-left','arrow-left','arrow-circle-left','arrow-alt-circle-left'],
					'fa-regular'  => ['hand-point-left','arrow-alt-circle-left']
				],
                'default'   =>  [
                    'value' =>  'fas fa-chevron-left',
                    'library'   =>  'fa-solid'
				]
            ]
        );

		$this->add_control(
            'main_banner_slider_controller_next_icon',
            [
                'label' =>  esc_html__( 'Next Icon', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::ICONS,
                'label_block'  =>  false,
                'skin'  =>  'inline',
				'recommended'   => [
					'fa-solid'  => ['angle-right','angle-double-right','caret-right','chevron-right','hand-point-right','arrow-right','arrow-circle-right','arrow-alt-circle-right'],
					'fa-regular'  => ['hand-point-right','arrow-alt-circle-right']
				],
                'default'   =>  [
                    'value' =>  'fas fa-chevron-right',
                    'library'   =>  'fa-solid'
				]
            ]
        );

		$this->add_responsive_control(
			'main_banner_slider_icon_size',
			[
				'label' => esc_html__( 'Icon size', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 12
				],
				'selectors' => [
					'{{WRAPPER}} .slick-arrow i' => 'font-size: {{SIZE}}{{UNIT}};'
				]
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'trailing_post_query_section',
			[
				'label' => esc_html__( 'Trailing Posts Query', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_post_type_select_control( 'trailing_post_custom_post_types' );
		$this->add_taxonomy_select_control( 'trailing_post_custom_taxonomies', 'Select Taxonomies', [
			'dependency'	=>	'trailing_post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'trailing_post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_post_order_select_control('trailing_post_order');
		$this->add_control(
			'trailing_post_count',
			[
				'label' => esc_html__( 'Number of posts to display', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => nekit_get_widgets_post_count_max( $this->widget_name . '-trail' ),
				'step' => 1,
				'default' => 8
			]
		);
		$this->add_authors_select_control('trailing_post_authors');

		$this->add_categories_select_control( 'trailing_post_categories', [
			'dependency'	=>	'trailing_post_custom_taxonomies',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'trailing_post_custom_taxonomies',
						'operator'	=>	'!=',
						'value'	=>	''
					],
					[
						'name'	=>	'trailing_post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_tags_select_control( 'trailing_post_tags', [
			'dependency'	=>	'trailing_post_custom_taxonomies',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'trailing_post_custom_post_types',
						'operator'	=>	'contains',
						'value'	=>	'post'
					]
				]
			]
		] );
		$this->add_posts_include_select_control( 'trailing_post_to_include', 'post', 'Posts', [
			'dependency'	=>	'trailing_post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'trailing_post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);

		$this->add_control(
			'trailing_post_offset',
			[
				'label' => esc_html__( 'Offset', 'news-kit-elementor-addons' ),
				'description' => esc_html__( 'Number of post to displace or pass over.', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 200,
				'step' => 1,
				'default' => 0
			]
		);
		$this->add_posts_exclude_select_control( 'trailing_post_to_exclude', 'post', 'Posts', [
			'dependency'	=>	'trailing_post_custom_post_types',
			'conditions'	=>	[
				'terms'	=>	[
					[
						'name'	=>	'trailing_post_custom_post_types',
						'operator'	=>	'!=',
						'value'	=>	''
					]
				]
			]
		]);
		$this->add_control(
			'trailing_post_hide_post_without_thumbnail',
			[
				'label' => esc_html__( 'Hide Posts with no featured image', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition'	=> apply_filters( 'nekit_query_control_condition_filter', [ 'post_order'	=> 'random' ] )
			]
		);
		$this->end_controls_section();

        $this->start_controls_section(
			'trailing_posts_column_settings',
			[
				'label'	=>	esc_html__( 'Trailing Posts Column Title Settings', 'news-kit-elementor-addons' ),
				'tab'	=>	\Elementor\Controls_Manager::TAB_CONTENT
			]
		);

        $this->add_control(
            'show_column_title',
            [
                'label' =>  esc_html__( 'Show title', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::SWITCHER,
                'label_on'  =>  esc_html__( 'Show', 'news-kit-elementor-addons' ),
                'label_off'  =>  esc_html__( 'Hide', 'news-kit-elementor-addons' ),
                'return_value'  =>  'yes',
                'default'   =>  'yes'
            ]
        );

        $this->add_control(
            'column_title',
            [
                'label' =>  esc_html__( 'Title', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::TEXT,
                'default'   =>  esc_html__( 'Editor Picks', 'news-kit-elementor-addons' )
            ]
        );

        $this->add_control(
            'column_title_alignment',
            [
                'label' =>  esc_html__( 'Alignment', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::CHOOSE,
                'default'   =>  'left',
                'toggle'    =>  false,
                'options'   =>  [
                    'left'  =>  [
                        'title' =>  esc_html__( 'Left', 'news-kit-elementor-addons' ),
                        'icon'  =>  ' eicon-text-align-left'
                    ],
                    'center'  =>  [
                        'title' =>  esc_html__( 'Center', 'news-kit-elementor-addons' ),
                        'icon'  =>  ' eicon-text-align-center'
                    ],
                    'right'  =>  [
                        'title' =>  esc_html__( 'Right', 'news-kit-elementor-addons' ),
                        'icon'  =>  ' eicon-text-align-right'
                    ]
                ],
				'frontend_available' => true,
                'selectors' =>  [
                    '{{WRAPPER}} .trailing-posts-column-title'   =>  'text-align:{{VALUE}}'
                ]
            ]

        );

        $this->end_controls_section();
		
		$this->start_controls_section(
			'trailing_posts_elements_settings_section',
			[
				'label' => esc_html__( 'Trailing Posts Elements Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'trailing_posts_show_post_title',
			[
				'label' => esc_html__( 'Show Post Title', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off' => esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_post_element_date_control();

		$this->end_controls_section();

        $this->start_controls_section(
            'advertisement_settings',
            [
                'label' =>  esc_html__( 'Advertisement Settings', 'news-kit-elementor-addons' ),
                'tab'  =>  \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

		$this->add_control(
			'show_advertisement',
			[
				'label'	=>	esc_html__( 'Show Advertisement', 'news-kit-elementor-addons' ),
				'type'	=>	\Elementor\Controls_Manager::SWITCHER,
				'label_on'	=>	esc_html__( 'Show', 'news-kit-elementor-addons' ),
				'label_off'	=>	esc_html__( 'Hide', 'news-kit-elementor-addons' ),
				'return_value'	=>	'yes',
				'default'	=>	'no',
				'description'	=>	esc_html__( 'Advertisement will be displayed randomly.', 'news-kit-elementor-addons' )
			]
		);

        $this->add_control(
            'advertisement_thumbnail',
            [
                'label' =>  esc_html__( 'Thumbnail', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::MEDIA,
                'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition'	=>	[
					'show_advertisement'	=>	'yes'
				]
            ]
        );

        $this->add_control(
            'advertisement_url',
            [
                'label' =>  esc_html__( 'Advertisement Url', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::URL,
                'label_block'   =>  true,
                'options'   =>  [ 'url', 'is_external', 'nofollow' ],
                'default'   =>  [
                    'url'   =>  '',
                    'is_external'   =>  false,
                    'nofollow'  =>  true
				],
				'condition'	=>	[
					'show_advertisement'	=>	'yes'
				]
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
			'animation_settings_section',
			[
				'label' => esc_html__( 'Animation Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->post_title_animation_type_control();

		$this->add_control(
			'image_hover_animation',
			[
				'label' => esc_html__( 'Image Hover Animation', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'posts_image_settings_section',
			[
				'label' => esc_html__( 'Image Settings', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => esc_html__( 'Image Sizes', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'large',
				'label_block'   => true,
				'options' => $this->get_image_sizes()
			]
		);
		
		$this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'image_border',
                'selector'  =>  '{{WRAPPER}} .post-thumb-wrap, {{WRAPPER}} .trailing-post-column-one .post-thumb, {{WRAPPER}} .trailing-posts-secondary .post-thumb'
            ]
        );

		$this->add_responsive_control(
            'image_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px' ],
                'label_block'   =>  true,
                'selectors' =>  [
                    '{{WRAPPER}} .post-thumb-wrap, {{WRAPPER}} .trailing-post-column-one .post-thumb, {{WRAPPER}} .trailing-posts-secondary .post-thumb'  =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

		$this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'  => 'image_box_shadow',
                'selector'=> '{{WRAPPER}} .post-thumb-wrap, {{WRAPPER}} .trailing-post-column-one .post-thumb, {{WRAPPER}} .trailing-posts-secondary .post-thumb'
            ]
        );
		$this->end_controls_section();

		$this->start_controls_section(
            'general_styles',
            [
                'label' =>  esc_html__( 'General', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        $this->general_styles_primary_color_control();

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => esc_html__( 'Column Gap', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => nekit_get_widgets_column_gap_max(),
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-banner-wrap .row' => 'margin-inline: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .nekit-banner-wrap .main-banner-wrap, {{WRAPPER}} .nekit-banner-wrap .trailing-posts-primary' => 'padding: 0 {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .nekit-banner-wrap .trailing-posts' => 'column-gap: calc( 2 * {{SIZE}}{{UNIT}} );'
				]
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => esc_html__( 'Row Gap', 'news-kit-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => nekit_get_widgets_row_gap_max(),
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .nekit-banner-wrap .trailing-posts' => 'row-gap: calc( 2 * {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .nekit-banner-wrap .trailing-post-column-one article + article, {{WRAPPER}} .nekit-banner-wrap .trailing-posts-secondary' => 'margin-top: calc( 2 * {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .nekit-banner-wrap .trailing-post-column-two article + article'	=>	'margin-top: calc( {{SIZE}}{{UNIT}} ); padding-top: calc( {{SIZE}}{{UNIT}} );',
					'{{WRAPPER}} .nekit-banner-wrap .post-thumb-wrap'	=>	'height: calc(370px + {{SIZE}}{{UNIT}});'
				]
			]
		);
        $this->end_controls_section();

		$this->start_controls_section(
			'slider_post_title_section_typography',
			[
				'label' => esc_html__( 'Slider Post Title', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'slider_post_title_typography',
					'selector' => '{{WRAPPER}} .main-banner-slider .post-title',
				]
			);

			$this->start_controls_tabs(
				'slider_post_title_style_tabs'
			);
			$this->start_controls_tab(
				'slider_post_title_initial_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'slider_post_title_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000',
					'selectors' => [
						'{{WRAPPER}} .main-banner-slider .post-title a' => 'color: {{VALUE}}',
					],
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'slider_post_title_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'slider_post_title_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .main-banner-slider .post-title a:hover' => 'color: {{VALUE}}',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->insert_divider();
			$this->add_control(
				'slider_show_post_title_background_color',
				[
					'label'=> esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .main-banner-slider .post-title a' => 'background-color: {{VALUE}}'
					]
				]
			);

			$this->add_responsive_control(
				'slider_show_post_title_padding', [
					'label'=> esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'=>[ 'px','em','%','custom' ],
					'selectors'=>
						[
						'{{WRAPPER}} .main-banner-wrap .post-title a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
	
			$this->add_responsive_control(
				'slider_show_post_title_margin',[
					'label'=> esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'=>[ 'px','em','%','custom' ],
					'default'=>[
						'top'    => 15,
						'right'  => 0,
						'bottom' => 0,
						'left'   => 0,
						'unit'   =>'px',
						'isLinked' => true
					],
					'selectors'=>
						[
						'{{WRAPPER}} .main-banner-wrap .post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'slider_post_excerpt_section_typography',
			[
				'label' => esc_html__( 'Slider Post Excerpt', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'slider_post_excerpt_typography',
					'selector' => '{{WRAPPER}} .main-banner-slider .post-excerpt',
				]
			);
			
			$this->add_control(
				'slider_post_excerpt_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000',
					'selectors' => [
						'{{WRAPPER}} .main-banner-slider .post-excerpt' => 'color: {{VALUE}}',
					],
				]
			);

			$this->insert_divider();
			$this->add_control(
				'slider_post_excerpt_background_color',
				[
					'label'=> esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .main-banner-slider .post-excerpt' => 'background-color: {{VALUE}}'
					]
				]
			);

			$this->add_responsive_control(
				'slider_post_excerpt_padding', [
					'label'=> esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'=>[ 'px','em','%','custom' ],
					'selectors'=>
						[
						'{{WRAPPER}} .main-banner-slider .post-excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
	
			$this->add_responsive_control(
				'slider_post_excerpt_margin',[
					'label'=> esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'=>[ 'px','em','%','custom' ],
					'default'=>[
						'top'    => 7,
						'right'  => 0,
						'bottom' => 0,
						'left'   => 0,
						'unit'   =>'px',
						'isLinked' => true
					],
					'selectors'=>
						[
						'{{WRAPPER}} .main-banner-slider .post-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'slider_post_categories_section_typography',
			[
				'label' => esc_html__( 'Slider Post Categories', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'slider_post_categories_typography',
					'selector' => '{{WRAPPER}} .main-banner-slider .post-categories a',
				]
			);

			$this->start_controls_tabs(
				'slider_post_categories_style_tabs'
			);
			$this->start_controls_tab(
				'slider_post_categories_initial_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'slider_post_categories_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#fff',
					'selectors' => [
						'{{WRAPPER}} .main-banner-slider .post-categories a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'slider_post_categories_background_color',
					'selector'  =>  '{{WRAPPER}} .main-banner-slider .post-categories a',
					'exclude'   =>  ['image']
				]
			);
			
			$this->add_control(
                'slider_post_categories_border_radius',
                [
                    'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ), 
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'selectors' =>  [
                        '{{WRAPPER}} .main-banner-slider .post-categories a' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

			$this->end_controls_tab();
			$this->start_controls_tab(
				'slider_post_categories_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'slider_post_categories_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .main-banner-slider .post-categories li:hover a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Background::get_type(),
				[
					'name'  =>  'slider_post_categories_background_color_hover',
					'selector'  =>  '{{WRAPPER}} .main-banner-slider .post-categories a:hover',
					'exclude'   =>  ['image']
				]
			);

			$this->add_control(
                'slider_post_categories_border_radius_hover',
                [
                    'label' =>  esc_html__( 'Hover Border Radius(px)', 'news-kit-elementor-addons' ), 
                    'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                    'selectors' =>  [
                        '{{WRAPPER}} .main-banner-slider .post-categories a:hover' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                    ]
                ]
            );

			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->insert_divider();

			$this->add_responsive_control(
				'slider_post_categories_padding', [
					'label'=> esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'=>[ 'px','em','%','custom' ],
					'default'=>[
						'top'    => '3',
						'right'  => '7',
						'bottom' => '3',
						'left'   => '7',
						'unit'   =>'px',
						'isLinked' => true
					],
					'selectors'=>
						[
							'{{WRAPPER}} .main-banner-slider .post-categories a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
						]
				]
			);
	
			$this->add_responsive_control(
				'slider_post_categories_margin',[
					'label'=> esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'=>[ 'px','em','%','custom' ],
					'default'=>[
						'top'    => 0,
						'right'  => 10,
						'bottom' => 0,
						'left'   => 0,
						'unit'   =>'px',
						'isLinked' => true
					],
					'selectors'=>
						[
						'{{WRAPPER}} .main-banner-slider .post-categories a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
			'slider_post_date_section_typography',
			[
				'label' => esc_html__( 'Slider Post Date', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'slider_post_date_typography',
					'selector' => '{{WRAPPER}} .main-banner-slider .published-date-context, {{WRAPPER}} .main-banner-slider .post-published-date',
				]
			);

			$this->start_controls_tabs(
				'slider_post_date_style_tabs'
			);
			$this->start_controls_tab(
				'slider_post_date_initial_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'slider_post_date_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#8A8A8C',
					'selectors' => [
						'{{WRAPPER}} .main-banner-slider .published-date-context, {{WRAPPER}} .main-banner-slider .post-published-date' => 'color: {{VALUE}}',
					],
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'slider_post_date_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'slider_post_date_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .main-banner-slider .date-meta-wrap:hover .published-date-context, {{WRAPPER}} .main-banner-slider .date-meta-wrap:hover .post-published-date' => 'color: {{VALUE}}',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->insert_divider();
			$this->add_control(
				'slider_post_date_background_color',
				[
					'label'=> esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .main-banner-slider .date-meta-wrap' => 'background-color: {{VALUE}}'
					]
				]
			);

			$this->add_responsive_control(
				'slider_post_date_padding', [
					'label'=> esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'=>[ 'px','em','%','custom' ],
					'selectors'=>
						[
							'{{WRAPPER}} .main-banner-slider .date-meta-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
						]
				]
			);
	
			$this->add_responsive_control(
				'slider_post_date_margin',[
					'label'=> esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'=>[ 'px','em','%','custom' ],
					'selectors'=>
						[
						'{{WRAPPER}} .main-banner-slider .date-meta-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					],
				]
			);
		$this->end_controls_section();

		$this->start_controls_section(
            'slider_controls',
            [
                'label' =>  esc_html__( 'Slider Controls', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'slider_controls_padding',
            [
                'label' =>  esc_html__( 'Padding', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    =>  [ 'px', '%', 'em', 'custom' ],
                'default'   =>  [
                    'top'   =>  8,
                    'right' =>  12,
                    'bottom'    =>  8,
                    'left'  =>  12,
                    'unit'  =>  'px',
                    'isLinked'  =>  true
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' =>  'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ] 
            ]
        );
        $this->insert_divider();
        $this->add_control(
            'slider_controls_color_heading',
            [
                'label' =>  esc_html__( 'Colors', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->start_controls_tabs(
            'slider_controls_tabs'
        );
            $this->start_controls_tab(
                'slider_controls_initial_tab',
                [
                    'label' =>  esc_html__( 'Initial', 'news-kit-elementor-addons' ),
                ]
            );

            $this->add_control(
                'slider_controls_arrow_color',
                [
                    'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000000',
                    'selectors' =>  [
                        '{{WRAPPER}} .slick-arrow i' => 'color:{{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'slider_controls_initial_background_color',
                    'selector'  =>  '{{WRAPPER}} .slick-arrow',
                    'exclude'   =>  ['image'],
                    'fields_options'    =>  [
                        'background'    =>  [
                            'default'   => 'classic',
                        ],
                        'color' =>  [
                            'default'   =>  '#ffffff'
                        ]
                    ]
                ]
            );
            $this->end_controls_tab();
            $this->start_controls_tab(
                'slider_controls_hover_tab',
                [
                    'label' =>  esc_html__( 'Hover', 'news-kit-elementor-addons' )
                ]
            );

            $this->add_control(
                'slider_controls_arrows_hover_color',
                [
                    'label' =>  esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
                    'type'  =>  \Elementor\Controls_Manager::COLOR,
                    'default'   =>  '#000000',
                    'selectors' =>  [
                        '{{WRAPPER}} .slick-arrow:hover i' => 'color:{{VALUE}}'
                    ]
                ]
            );

            $this->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'  =>  'slider_controls_arrows_hover_background_color',
                    'selector'  =>  '{{WRAPPER}} .slick-arrow:hover',
                    'exclude'   =>  ['image'],
                    'fields_options'    =>  [
                        'background'    =>  [
                            'default'   => 'classic',
                        ],
                        'color' =>  [
                            'default'   =>  '#ffffffd9'
                        ]
                    ]
                ]
            );

            $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->insert_divider();
        $this->add_control(
            'slider_controls_box_shadow_heading',
            [
                'label' =>  esc_html__( 'Box Shadow', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'slider_controls_box_shadow',
				'selector' => '{{WRAPPER}} .slick-arrow'
			]
		);
        $this->insert_divider();
        $this->add_control(
            'slider_controls_border_settings_heading',
            [
                'label' =>  esc_html__( 'Border Settings', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'slider_controls_width',
				'selector' => '{{WRAPPER}} .slick-arrow'
			]
		);

        $this->add_control(
            'slider_controls_radius',
            [
                'label' =>  esc_html__( 'Border Radius', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  1000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .slick-arrow'   =>  'border-radius:{{VALUE}}px'
                ]
            ]
        );
        $this->end_controls_section();
		$this->add_image_overlay_section();
        $this->start_controls_section(
            'trailing_posts_column_title_styles',
            [
                'label' =>  esc_html__( 'Trailing Posts Column Title Styles', 'news-kit-elementor-addons' ),
                'tab'   =>  \Elementor\Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'  =>  'column_title_typography',
                'selector'  =>  '{{WRAPPER}} .trailing-posts-column-title',
            ]
        );

        $this->add_control(
            'column_title_color',
            [
                'label' =>  esc_html__( 'Color', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::COLOR,
                'default'   =>  '#000000',
                'selectors' =>  [
                    '{{WRAPPER}} .trailing-posts-column-title'  =>  'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'  =>  'column_title_background',
                'selector'  =>  '{{WRAPPER}} .trailing-posts-column-title',
                'exclude'   =>  ['image']
            ]
        );

        $this->add_responsive_control(
				'post_column_title_padding', [
					'label'=> esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'=>[ 'px','em','%','custom' ],
					'selectors'=>
						[
						'{{WRAPPER}} .trailing-posts-column-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
	
			$this->add_responsive_control(
				'post_column_title_margin',[
					'label'=> esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'=>[ 'px','em','%','custom' ],
					'selectors'=>
						[
						'{{WRAPPER}} .trailing-posts-column-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					],
				]
			);

        $this->end_controls_section();

		$this->start_controls_section(
			'trailing_posts_title_section_typography',
			[
				'label' => esc_html__( 'Trailing Posts Title Typography', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'trailing_posts_title_typography',
					'fields_options' => [
						'typography' => [
							'default' => 'custom'
						],
						'font_size' => [
							'default' => [
								'unit' => 'px',
								'size' => 14
							]
						]
					],
					'selector' => '{{WRAPPER}} .trailing-posts .post-title',
				]
			);
		
			$this->start_controls_tabs(
				'trailing_posts_title_style_tabs'
			);
			$this->start_controls_tab(
				'trailing_posts_title_initial_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'trailing_posts_title_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .trailing-posts .post-title a' => 'color: {{VALUE}}',
					],
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'trailing_posts_title_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'trailing_posts_title_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .trailing-posts .post-title a:hover' => 'color: {{VALUE}}',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->insert_divider();
			$this->add_control(
				'trailing_posts_title_background_color',
				[
					'label'=> esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::COLOR,
					'selectors'=>
						[
						'{{WRAPPER}} .trailing-posts .post-title a' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'trailing_posts_title_padding',[
					'label'=> esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'=>[ 'px','em','%','custom' ],
					'selectors'=>
						[
						'{{WRAPPER}} .trailing-posts .post-title a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					],
				]
			);
	
			$this->add_responsive_control(
				'trailing_posts_title_margin',[
					'label'=> esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::DIMENSIONS,
					'selectors'=>
						[
						'{{WRAPPER}} .trailing-posts .post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					],
				]
			);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'trailing_posts_date_section_typography',
			[
				'label' => esc_html__( 'Trailing Posts Date Typography', 'news-kit-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'news-kit-elementor-addons' ),
					'name' => 'trailing_posts_date_typography',
					'selector' => '{{WRAPPER}} .trailing-posts .published-date-context, {{WRAPPER}} .trailing-posts .post-published-date',
				]
			);
		
			$this->start_controls_tabs(
				'trailing_posts_date_style_tabs'
			);
			$this->start_controls_tab(
				'trailing_posts_date_initial_tab',
				[
					'label' => esc_html__( 'Initial', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'trailing_posts_date_color',
				[
					'label' => esc_html__( 'Text Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .trailing-posts .post-published-date, {{WRAPPER}} .trailing-posts .published-date-context' => 'color: {{VALUE}}'
					]
				]
			);
			
			$this->end_controls_tab();
			$this->start_controls_tab(
				'trailing_posts_date_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'news-kit-elementor-addons' ),
				]
			);
			
			$this->add_control(
				'trailing_posts_date_hover_color',
				[
					'label' => esc_html__( 'Hover Color', 'news-kit-elementor-addons' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .trailing-posts .date-meta-wrap:hover .post-published-date, {{WRAPPER}} .trailing-posts .date-meta-wrap:hover .published-date-context' => 'color: {{VALUE}}'
					]
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->insert_divider();
			$this->add_control(
				'trailing_posts_date_background_color',
				[
					'label'=> esc_html__( 'Background Color', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .trailing-posts .date-meta-wrap' => 'background-color: {{VALUE}}'
					]
				]
			);

			$this->add_responsive_control(
				'trailing_posts_date_padding',[
					'label'=> esc_html__( 'Padding', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'=>[ 'px','em','%','custom' ],
					'selectors'=>	[
						'{{WRAPPER}} .date-meta-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
	
			$this->add_responsive_control(
				'trailing_posts_date_margin',[
					'label'=> esc_html__( 'Margin', 'news-kit-elementor-addons' ),
					'type'=>\Elementor\Controls_Manager::DIMENSIONS,
					'size_units'=>[ 'px','em','%','custom' ],
					'selectors'=>	[
						'{{WRAPPER}} .date-meta-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
					]
				]
			);
		$this->end_controls_section();

        $this->start_controls_section(
            'advertisement_styles',
            [
                'label' =>  esc_html__( 'Advertisement Styles', 'news-kit-elementor-addons' ),
                'tab' =>   \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'  =>  'advertisement_border',
                'selector'  =>  '{{WRAPPER}} .advertisement-thumbnail-wrap img'
            ]
        );

        $this->add_control(
            'advertisement_border_radius',
            [
                'label' =>  esc_html__( 'Border Radius(px)', 'news-kit-elementor-addons' ),
                'type'  =>  \Elementor\Controls_Manager::NUMBER,
                'min'   =>  0,
                'max'   =>  10000,
                'step'  =>  1,
                'default'   =>  0,
                'selectors' =>  [
                    '{{WRAPPER}} .advertisement-thumbnail-wrap img' =>  'border-radius: {{VALUE}}px'
                ]
            ]
        );

        $this->end_controls_section();
	}

	public function get_main_banner_article( $args ) {
		?>
			<article class="post-item items-wrap<?php if(!has_post_thumbnail( $args['popular_post_id'] ) ){ echo esc_attr(' no-feat-img' );} ?>">
				<figure class="post-thumb">
					<?php
						if( has_post_thumbnail( $args['popular_post_id'] ) ) : ?>
							<a href="<?php echo esc_url( get_the_permalink( $args['popular_post_id'] ) ); ?>">
								<div class="post-thumb-parent<?php if( $args['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
									<img <?php echo wp_kses_post($args['imageClass']); ?> src="<?php echo esc_url( get_the_post_thumbnail_url( $args['popular_post_id'], $args['image_size'] ) ); ?>"/>
								</div>
							</a>
							<?php 
						endif;
					?>
				</figure>
				<div class="post-element">
					<?php
						if( $args['trail_key'] < 3 || isset( $args['secondary_trail'] ) ) :
							if( $args['show_post_date'] == 'yes' ):
								echo wp_kses_post(nekit_get_posts_date([
									'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
									'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
										'value' =>  'fas fa-calendar',
										'library'   =>  'fa-solid'
									]
								]));
							endif;
						endif;
						if( $args['trailing_posts_show_post_title'] == 'yes' ) : ?>
							<h2 <?php echo wp_kses_post($args['titleClass']); ?>><a href="<?php the_permalink( $args['popular_post_id'] ); ?>"><?php echo wp_kses_post( get_the_title( $args['popular_post_id'] ) ); ?></a></h2>
						<?php 
						endif; 
						if( $args['trail_key'] >= 3 && ! isset( $args['secondary_trail'] ) ) :
							if( $args['show_post_date'] == 'yes' ):
								echo wp_kses_post(nekit_get_posts_date([
									'base'  =>  isset( $settings['post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
									'icon'  =>  isset( $settings['post_date_icon'] ) ? $settings['post_date_icon'] : [
										'value' =>  'fas fa-calendar',
										'library'   =>  'fa-solid'
									]
								]));
							endif;
						endif;
					?>
				</div>
			</article>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$trail_close_column_two = 8;
		if( $settings['show_advertisement'] == 'yes' ) {
			$trail_close_column_two = 6;
			$advertisement_thumbnail = ( $settings['advertisement_thumbnail']['url'] ) ? '<a '. $this->get_render_attribute_string( 'advertisement_link' ) . 'class="advertisement-thumbnail-wrap">'. '<img src="' . esc_attr( $settings['advertisement_thumbnail']['url'] ) . '"></a>' : '';
			$full_advertisement = '<div class="advertisement items-wrap">' . $advertisement_thumbnail . '</div>';
		}
		//  post title attributes
		$titleClass = 'post-title';
		if( $settings['post_title_animation_choose'] == 'elementor' ) {
            if( $settings['post_title_hover_animation'] ) $titleClass .= esc_attr( " elementor-animation-".$settings['post_title_hover_animation'] );
        } else {
            if( $settings['post_title_custom_animation'] ) $titleClass .= esc_attr( " custom-animation--" . $settings['post_title_custom_animation'] );
        }
		$imageClass = '';
		if ( $settings['image_hover_animation'] ) {
			$imageClass = 'elementor-animation-' . $settings['image_hover_animation'];
		}
        if ( ! empty( $settings['advertisement_url']['url'] ) ) {
			$this->add_link_attributes( 'advertisement_link', $settings['advertisement_url'] );
		}
		$this->add_render_attribute( 'image_hover', 'class', $imageClass );
		$this->add_render_attribute( 'title_hover', 'class', $titleClass );
		?>
		<section class="nekit-widget-section nekit-banner-wrap main-banner-section banner-layout--five <?php echo esc_attr( 'section-column-order--' . implode('--',$settings['main_banner_sorting']) ); ?> <?php echo ( $settings['show_slider_arrow_on_hover'] == 'yes' ) ? esc_attr( 'arrow-on-hover--on' ) : esc_attr( 'arrow-on-hover--off' ); ?>">
            <div class="news-elementor-container">
                <div class="row">
					<?php 
						foreach( $settings['main_banner_sorting'] as $main_banner_sort ):
							switch( $main_banner_sort ):
								case 'main-banner-wrap': ?>
									<div class="main-banner-wrap">
										<div class="main-banner-slider" data-auto="<?php echo esc_attr( wp_json_encode( $settings['main_banner_slider_auto'] == 'yes' ) ); ?>" data-arrows="<?php echo esc_attr( wp_json_encode( $settings['main_banner_slider_arrows'] == 'yes' ) ); ?>" data-dots="<?php echo esc_attr( wp_json_encode( $settings['main_banner_slider_dots'] == 'yes' ) ); ?>" data-loop="<?php echo esc_attr( wp_json_encode( $settings['main_banner_slider_loop'] == 'yes' ) ); ?>" data-speed="<?php echo esc_attr($settings['main_banner_slider_speed']); ?>" data-prev-icon="<?php echo esc_attr(nekit_get_base_attribute_value([ 'icon'	=> $settings['main_banner_slider_controller_prev_icon'] ])); ?>" data-next-icon="<?php echo esc_attr(nekit_get_base_attribute_value([ 'icon'	=> $settings['main_banner_slider_controller_next_icon'] ])); ?>" data-fade="<?php echo esc_attr( wp_json_encode( $settings['main_banner_slider_fade'] == 'yes' ) ); ?>">
											<?php
												$slider_posts_args = $this->get_posts_args_for_query('slider_post');
												$slider_post_query = new \WP_Query($slider_posts_args);
												if( $slider_post_query->have_posts() ) :
													while( $slider_post_query->have_posts() ) : $slider_post_query->the_post();
														?>
															<article class="post-item slide-item <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?>">
																<div class="post_slider_template_five">
																	<figure class="post-thumb-wrap">
																		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
																			<div class="post-thumb-parent<?php if( $settings['image_overlay_option'] == 'yes' ) echo ' has-image-overlay'; ?>">
																				<?php 
																					if( has_post_thumbnail()) {
																						the_post_thumbnail( $settings['image_size'], array(
																							'title' => the_title_attribute(array(
																								'echo'  => false
																							)),
																							'class'	=> esc_attr($imageClass)
																						));
																					}
																				?>
																			</div>
																		</a>
																	</figure>
																	<div class="post-element">
																		<?php
																			$slider_posts_elements_sorting = isset( $settings['slider_posts_elements_sorting'] ) ? $settings['slider_posts_elements_sorting']: ['post-meta', 'post-title', 'post-excerpt'];
																			foreach( $slider_posts_elements_sorting as $slider_posts_element ) :
																				switch($slider_posts_element) {
																					case 'post-meta':?>
																						<div class="post-meta">
																							<?php
																								if( $settings['slider_show_post_categories'] == 'yes' ) nekit_get_post_categories( get_the_ID(), 2 );

																								if( $settings['slider_show_post_date'] == 'yes' ) echo wp_kses_post(nekit_get_posts_date([
																									'base'  =>  isset( $settings['slider_post_date_icon_position'] ) ? $settings['post_date_icon_position'] : 'prefix',
																									'icon'  =>  isset( $settings['slider_post_date_icon'] ) ? $settings['post_date_icon'] : [
																										'value' =>  'fas fa-calendar',
																										'library'   =>  'fa-solid'
																									],
																									'url'	=>	'yes'
																								]));
																							?>
																						</div>
																					<?php 
																								break;
																					case 'post-title': 
																								if( $settings['slider_show_post_title'] == 'yes' ): ?>
																									<h2 <?php echo wp_kses_post($this->get_render_attribute_string( 'title_hover' )); ?>><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
																								<?php endif;
																						break;
																					case 'post-excerpt': 
																									if( $settings['slider_show_post_excerpt'] == 'yes' ) :
																										nekit_get_post_excerpt_output($settings['slider_show_post_excerpt_length'] ? $settings['slider_show_post_excerpt_length']: 0);
																									endif;
																						break;
																				}
																			endforeach;
																		?>
																	</div>
																</div>
															</article>
														<?php
													endwhile;
													wp_reset_postdata();
												endif;
											?>
										</div>
									</div>
								<?php break;

								case 'trailing-posts': ?>
									<div class="trailing-posts-primary">
                                        <?php
                                            if( $settings['show_column_title'] == 'yes' ) echo '<h2 class="trailing-posts-column-title">' . esc_html( $settings['column_title'] ) . '</h2>';
											echo '<div class="trailing-posts-column-wrap trailing-posts">';
												$trailing_post_args = $this->get_posts_args_for_query('trailing_post');
												$trailing_posts = get_posts( $trailing_post_args );
												$total_posts = count( $trailing_posts );
												$advertisement = wp_rand(3, 6);
												if( $trailing_posts ) :
													foreach( $trailing_posts as $trail_key => $trail_post ) :
														$popular_post_id = $trail_post->ID;
														if( $trail_key === 0 ) echo '<div class="trailing-post-column-one">';
															if( $trail_key == 3 ) echo '<div class="trailing-post-column-two">';
																$article_args = [
																	'popular_post_id'	=>	$popular_post_id,
																	'image_overlay_option'	=>	$settings['image_overlay_option'],
																	'image_size'	=>	$settings['image_size'],
																	'show_post_date'	=>	$settings['show_post_date'],
																	'post_date_icon'	=>	$settings['post_date_icon'],
																	'post_date_icon_position'	=>	$settings['post_date_icon_position'],
																	'trailing_posts_show_post_title'	=>	$settings['trailing_posts_show_post_title'],
																	'imageClass'	=>	$this->get_render_attribute_string( 'image_hover' ),
																	'titleClass'	=>	$this->get_render_attribute_string( 'title_hover' ),
																	'trail_key'	=>	$trail_key,
																	'image_overlay_option'	=> $settings['image_overlay_option']
																];
																if( $settings['show_advertisement'] == 'yes' && $trail_key == $advertisement ) echo wp_kses_post($full_advertisement);
																$this->get_main_banner_article( $article_args );
																if( $settings['show_advertisement'] == 'yes' && $advertisement == 6 && $trail_key + 1 == 6 ) echo wp_kses_post($full_advertisement);
															if( $trail_key === 2 ) {
																echo '</div><!-- .trailing-post-column-one -->';
															} else if( $trail_key + 1 == $trail_close_column_two ) {
																echo '</div><!-- .trailing-post-column-two -->';
																break;
															} else if( $trail_key + 1 == $total_posts ) {
																echo '</div><!-- .trailing-posts-count-end -->';
															}
													endforeach;
												endif;
											echo '</div><!-- .trailing-posts-column-wrap -->';
										?>
									</div>
								<?php break;
							endswitch;
						endforeach;
                    ?>
				</div>
				<?php 
					if( $settings['show_advertisement'] == 'yes' && $total_posts > 6 )  {
						$article_args['secondary_trail'] = true;
						echo '<div class="trailing-posts-secondary trailing-posts">';
							for( $trailpost_start = 6; $trailpost_start < $total_posts; $trailpost_start++ ) {
								$article_args['popular_post_id'] = $trailing_posts[$trailpost_start]->ID;
								$this->get_main_banner_article( $article_args );
							}
						echo '</div> <!-- .trailing-posts-secondary -->';
					} else if( $total_posts > 8 ) {
						$article_args['secondary_trail'] = true;
						echo '<div class="trailing-posts-secondary trailing-posts">';
							for( $trailpost_start = 8; $trailpost_start < $total_posts; $trailpost_start++ ) {
								$article_args['popular_post_id'] = $trailing_posts[$trailpost_start]->ID;
								$this->get_main_banner_article( $article_args );
							}
						echo '</div> <!-- .trailing-posts-secondary -->';
					}
				?>
			</div>
		</section>
		<?php
	}
}