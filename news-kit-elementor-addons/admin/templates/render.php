<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Nekit_Render_Templates setup
 *
 * @since 1.0
 */
class Nekit_Render_Templates_Html {
	/**
	** Current Builder Id.
	*/
	private $current_builder_id;

	function set_current_builder_id($id) {
		$this->current_builder_id = $id;
	}
    /**
    ** Check if a Template has Conditions
    */
	public function is_template_available($type) {
		if( is_page() ) {
			if( $type == 'header' ) {
				$child_page = is_front_page() ? 'singular-frontpage' : 'singular-page';
				$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => $child_page]);
				if( $page_header ) {
					if( get_post_status($page_header) ) {
						$this->current_builder_id = $page_header;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'footer' ) {
				$child_page = is_front_page() ? 'singular-frontpage' : 'singular-page';
				$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => $child_page]);
				if( $page_footer ) {
					if( get_post_status($page_footer) ) {
						$this->current_builder_id = $page_footer;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'single' ) {
				$child_page = is_front_page() ? 'frontpage' : 'pages-nekitallnekit';
				$single_template = nekit_get_conditions_settings_builder_id(['parent' => 'single-builder','child' => $child_page]);
				if( $single_template ) {
					if( get_post_status($single_template) ) {
						$this->current_builder_id = $single_template;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			}
		} else if( is_singular('post') ) {
			if( $type == 'header' ) {
				$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'singular-post']);
				if( $page_header ) {
					if( get_post_status($page_header) ) {
						$this->current_builder_id = $page_header;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'footer' ) {
				$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'singular-post']);
				if( $page_footer ) {
					if( get_post_status($page_footer) ) {
						$this->current_builder_id = $page_footer;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'single' ) {
				$single_template = nekit_get_conditions_settings_builder_id(['parent' => 'single-builder','child' => 'posts-nekitallnekit']);
				if( $single_template ) {
					if( get_post_status($single_template) ) {
						$this->current_builder_id = $single_template;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			}
		} else if( is_home() ) {
			if( $type == 'header' ) {
				$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'home']);
				if( $page_header ) {
					if( get_post_status($page_header) ) {
						$this->current_builder_id = $page_header;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'footer' ) {
				$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'home']);
				if( $page_footer ) {
					if( get_post_status($page_footer) ) {
						$this->current_builder_id = $page_footer;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'archive' ) {
				$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'archiveposts']);
				if( $archive_template ) {
					if( get_post_status($archive_template) ) {
						$this->current_builder_id = $archive_template;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			}
		} else if( is_archive() ) {
			if( $type == 'header' ) {
				if( is_category() ) {
					$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'archives-category']);
				} else if( is_tag() ) {
					$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'archives-tag']);
				} else if( is_author() ) {
					$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'archives-author']);
				} else if( is_date() ) {
					$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'archives-date']);
				} else if( is_search() ) {
					$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'archives-search']);
				}
				if( $page_header ) {
					if( get_post_status($page_header) ) {
						$this->current_builder_id = $page_header;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'footer' ) {
				if( is_category() ) {
					$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'archives-category']);
				} else if( is_tag() ) {
					$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'archives-tag']);
				} else if( is_author() ) {
					$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'archives-author']);
				} else if( is_date() ) {
					$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'archives-date']);
				} else if( is_search() ) {
					$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'archives-search']);
				}
				if( $page_footer ) {
					if( get_post_status($page_footer) ) {
						$this->current_builder_id = $page_footer;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'archive' ) {
				if( is_category() ) {
					$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'archivepostcategories-nekitallnekit']);
				} else if( is_tag() ) {
					$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'archiveposttags-nekitallnekit']);
				} else if( is_author() ) {
					$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'archiveauthor-nekitallnekit']);
				} else if( is_date() ) {
					$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'datearchive']);
				}
				if( $archive_template ) {
					if( get_post_status($archive_template) ) {
						$this->current_builder_id = $archive_template;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			}
		} else if( is_search() ) {
			if( $type == 'header' ) {
				$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'archives-search']);
				if( $page_header ) {
					if( get_post_status($page_header) ) {
						$this->current_builder_id = $page_header;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'footer' ) {
				$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'archives-search']);
				if( $page_footer ) {
					if( get_post_status($page_footer) ) {
						$this->current_builder_id = $page_footer;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'archive' ) {
				$archive_template = nekit_get_conditions_settings_builder_id(['parent' => 'archive-builder','child' => 'searchresultsarchive']);
				if( $archive_template ) {
					if( get_post_status($archive_template) ) {
						$this->current_builder_id = $archive_template;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			}
		} else if( is_404() ) {
			if( $type == 'header' ) {
				$page_header = nekit_get_conditions_settings_builder_id(['parent' => 'header-builder','child' => 'singular-404page']);
				if( $page_header ) {
					if( get_post_status($page_header) ) {
						$this->current_builder_id = $page_header;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == 'footer' ) {
				$page_footer = nekit_get_conditions_settings_builder_id(['parent' => 'footer-builder','child' => 'singular-404page']);
				if( $page_footer ) {
					if( get_post_status($page_footer) ) {
						$this->current_builder_id = $page_footer;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else if( $type == '404' ) {
				$error_page_template = nekit_get_conditions_settings_builder_id(['parent' => '404-builder','child' => '404page']);
				if( $error_page_template ) {
					if( get_post_status($error_page_template) ) {
						$this->current_builder_id = $error_page_template;
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

    /**
    ** Current html template
    */
    public function current_builder_template( $template_id = 0 ) {
		$template_id = ( $template_id != 0 ) ? $template_id : $this->current_builder_id;
		$elementor = \Elementor\Plugin::instance();
		$builder_content = $elementor->frontend->get_builder_content_for_display($template_id);
		return $builder_content;
    }
}