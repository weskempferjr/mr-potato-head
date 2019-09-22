<?php
/**
 * Created by PhpStorm.
 * User: weskempferjr
 * Date: 2019-08-03
 * Time: 15:27
 */

class Mr_Potato_Head_Shortcodes {

	private $settings;


	private static $shortcodes = array(
		'posts_grouped_by_date',
		'posts_grouped_by_data_no_ajax',
		'shortcode_works_here'
	);

	/*
	 * Constructor
	 */

	public function __construct() {
	}


	/*
	 * Called to register all shortcodes for the plugin
	 * @since 1.0.0
	 */

	public function register_shortcodes() {

		foreach ( self::$shortcodes as $shortcode ) {
			add_shortcode( $shortcode, array( $this, $shortcode ) );
		}

	}

	/*
		 * Function: get_shortcodes
		 * @return array shortcodes an array of the plugin shortcode names.
		 */

	public static function get_shortcodes() {
		return self::$shortcodes;
	}

	public function posts_grouped_by_date( $atts ) {


		/** @var  $count integer */

		$atts_actual = shortcode_atts(
			array(
				'count' => 5
			),
			$atts );

		extract( $atts_actual );

		$output = '';
		$output =   '<div id="mph-shortcode" data-count="' . $count . '">' . $output  . '</div>' . '<button id="mph-load-more">'. __('Load more posts', PGDB_TEXTDOMAIN ) . ' </button>';
		$output .= '<div id="mph-bottom-msg"></div>';
		return $output;
	}

	public function posts_grouped_by_date_no_ajax( $atts ) {


		/** @var  $id string */

		$atts_actual = shortcode_atts(
			array(

			),
			$atts );

		extract( $atts_actual );

		$args = array('posts_per_page' => -1, 'orderby' => 'date' );

		$postQuery = new WP_Query($args);

		$date = '';

		$postContent = array(
			'title' => '',
			'thumbnail' => '',
			'excerpt' => ''
		);

		$postList = array();
		$current_post_date = '';

		$output = '';

		if ( $postQuery->have_posts() ) : while ( $postQuery->have_posts() ) : $postQuery->the_post();


			if ( $current_post_date != get_the_date() ) {

				if ( count( $postList) > 0 ) {
					$output .= $this->get_group_section( $postList, $current_post_date );
				}

				$current_post_date = get_the_date();

				$postList = array();
			}

		    $postList[] = array(
			    'title' => get_the_title(),
			    'thumbnail' => get_the_post_thumbnail( get_the_ID(), 'medium'),
			    'excerpt' => get_the_excerpt(),
			    'url'=> get_the_permalink(),
			    'date' => get_the_date()
		    );



		endwhile;
		endif;


		wp_reset_postdata();

		return  '<div class="mph-shortcode">' . $output  . '</div>';



	}

	public function shortcode_works_here( $atts ) {
		/** @var  $message  string */

		$atts_actual = shortcode_atts(
			array(
				'message' => ''
			),
			$atts );

		extract( $atts_actual );

		return '<p class="mph-shortcode mph-sc-works-here">' . __('Short code works here:', MPH_TEXTDOMAIN ) . $message . '</p>';

	}


	private function get_group_section ( $postList, $group_date ) {

		$template = '
			<div class="mph-group-section">
				<h2>__GROUP_HEADING__</h2>
				<div class="mph-group-section-content">
				  __GROUP_CONTENT__
				</div>
			</div>
		';

		$group_content = "";
		foreach ( $postList as $postItem ) {
			$group_content .= $this->get_formatted_content( $postItem );
		}

		$output = str_replace( '__GROUP_HEADING__', $group_date, $template);
		$output = str_replace( '__GROUP_CONTENT__', $group_content, $output);

		return $output;
	}

	private function get_formatted_content( $postContent ) {

		$template = '
			<div class="mph-post-content-container mph-group-member">
				<div class="mph-post-thumbnail-container pdbd-content-member">
					__THUMBNAIL__
				</div>
				<div class="mph-post-excerpt-container mph-content-member">
					<div class="mph-title-container"><h3>__TITLE__</h3></div>
					<div class="mph-excerpt-container">__EXCERPT__</div>
					<div class="mph-link-container"><a href="__URL__">Read More...</a></div>
				</div>	
			</div>
		
		';

		$output = str_replace( '__THUMBNAIL__', $postContent['thumbnail'], $template );
		$output = str_replace( '__TITLE__', $postContent['title'], $output );
		$output = str_replace( '__EXCERPT__', $postContent['excerpt'], $output );
		$output = str_replace( '__url__', $postContent['url'], $output );

		return $output;
	}


}