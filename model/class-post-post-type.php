<?php

/**
 * Encapsulates attributes and behavior of the posts post type.
 *
 * @link       http://guestaba.com
 * @since      1.0.0
 *
 * @package    CrowdMap
 * @subpackage CrowdMap/model
 */

/**
 * Post Post Type class
 *
 * Defines attribues and behavior of the Post post type
 *
 *
 * @since      1.0.0
 * @package    CrowdMap
 * @subpackage CrowdMap/model
 * @author     Wes Kempfer <wkempferjr@tnotw.com>
 */
class Post_Post_Type {

	/**
	 *  String to define post type name.
	 *  @since	1.0.0
	 *  @access	protected
	 *  @var String  $post_type  Stores post_type name
	 */
	protected $post_type ;

	/**
	 * Array for storing UI labels for Post custom post type
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var     array    $labels   Stores UI labels for Post CPT
	 */
	protected $labels;

	/**
	 * Array for storing argument passed to register_post_type
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var     array    $args   Stores UI labels for Post CPT
	 */
	protected $args;

	/**
	 * Constructor for Post Post Type
	 * Initializes labels and args for registration.
	 * @since    1.0.0
	 */

	public function __construct() {

		$this->post_type = 'posts';

		$theme = wp_get_theme();
		$text_domain = PGDB_TEXTDOMAIN;

		$this->labels = array(
			'name'                => __( 'Post Listings', $text_domain ),
			'singular_name'       => __( 'Post', $text_domain ),
			'menu_name'           => __( 'Post', $text_domain ),
			'parent_item_colon'   => __( 'Parent Post:', $text_domain ),
			'all_items'           => __( 'All Post', $text_domain ),
			'view_item'           => __( 'View Post', $text_domain ),
			'add_new_item'        => __( 'Add New Post', $text_domain ),
			'add_new'             => __( 'Add New', $text_domain ),
			'edit_item'           => __( 'Edit Post', $text_domain ),
			'update_item'         => __( 'Update Post', $text_domain ),
			'search_items'        => __( 'Search Post', $text_domain ),
			'not_found'           => __( 'No Post found', $text_domain ),
			'not_found_in_trash'  => __( 'No Post found in Trash', $text_domain )
		);

		$this->args = array(
			'label'               => __( 'Post', $text_domain ),
			'labels'              => $this->labels,
			'description'         => __('Display your works by filters','purepress'),
			'supports'            => array( 'title', 'editor','excerpt', 'author', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'thumbnail' ,'comments' ),
			'hierarchical'        => true,
			'public'              => true,

			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,

			'query_var'           => true,
			'publicly_queryable'  => true,

			'exclude_from_search' => false,
			'has_archive'         => false,

			'can_export'          => true,
			'menu_position'       => 5,
			'rewrite'             => array(
				'slug'            => 'posts',
				'with_front'      => true,
				'pages'           => true,
				'feeds'           => true,
			),
			'capability_type'     => 'post',
			'taxonomies'          => array( 'category', 'post_tag' )
		);

	}

	/*
	 * Register post type
	 * 
	 * @since 1.0.0
	 * 
	 * @param none
	 * @return void
	 */
	public function register() {
		// Do nothing. This post type is registered.
	}


	/*
	 * Remove post actions
	 * 
	 * @since 1.0.0
	 * 
	 * @param none
	 * @return void
	 */

	public function remove_post_actions($actions) {
		if ( 'posts' === get_post_type() ) {
			unset( $actions['trash'] );
		}
		return $actions;;
	}



	/*
	 * Get page by slug. Post support function.
	 * 
	 * @since 1.0.0
	 */
	public function get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ) {
		global $wpdb;
		$page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s", $page_slug, $post_type ) );
		if ( $page )
			return get_page($page, $output);
		return null;
	}


	/*
	 * Add to query. Post support function.
	 * 
	 * @since 1.0.0
	 */
	public function add_to_query( $query ) {
		if ( is_home() && $query->is_main_query()  && $query->is_search  && $query->is_category )
			$query->set( 'post_type', array( 'post', 'page', 'posts' ) );
		return $query;
	}

	/*
	 * Query post type. Post support function.
	 * 
	 * @since 1.0.0
	 */
	public function query_my_post_types( &$query ) {
		// Do this for all category and tag pages, can be extended to is_search() or is_home() ...
		if ( is_category() || is_tag() ) {
			$post_type = $query->get( 'post_type' );
			// ... if no post_type was defined in query then set the defaults ...
			if ( empty( $post_type ) ) {
				$query->set( 'post_type', array(
					'post',
					'posts'
				) );
			}
		}
	}





	/**
	 *
	 * Get post list by post ID .
	 *
	 * @since 1.0.0
	 * @param string $postID
	 * @throws Exception if get_post_meta cannot retrieve list.
	 *
	 */
	public static function get_post( $post_id ) {

		$post = get_post( $post_id );

		$post = self::get_array( $post );

		return $post;
	}


	public static function get_posts( $count, $current_offset=0 ) {


		$post_type = 'post' ;


		$args = array(
			'post_type'      => isset( $post_type ) ? $post_type : 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $count,
			'offset'         => $current_offset
		);


		$post_query = new WP_Query( $args );

		$posts = array();

		while ( $post_query->have_posts() ) : $post_query->the_post();
			$post_id = get_the_ID();
			$posts[] = Post_Post_Type::get_array( get_post( $post_id));


		endwhile;

		wp_reset_postdata();

		return $posts;

	}




	public static function get_array( $post ) {


		$post = array(
			'id' => $post->ID,
			'title' => $post->post_title,
			'excerpt' => get_the_excerpt( $post->ID ),
			'author' => get_the_author( $post->ID),
			'thumbnail' => get_the_post_thumbnail($post->ID, 'medium'),
			'date' => $post->post_date,
			'timestamp' => get_post_time('U', true, $post),
			'post_type' => get_post_meta( $post->ID, 'post_type', true),
			'url' => get_post_permalink( $post->ID )
		);

		return $post;

	}



}
?>
