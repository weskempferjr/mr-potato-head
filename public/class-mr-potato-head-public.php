<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://tnotw.com
 * @since      1.0.0
 *
 * @package    Mr_Potato_Head
 * @subpackage Mr_Potato_Head/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mr_Potato_Head
 * @subpackage Mr_Potato_Head/public
 * @author     Wendy Emerson <wendybreaksout@gmail.com>
 */
class Mr_Potato_Head_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	private $public_js_handle = 'mph-public-js';
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mr_Potato_Head_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mr_Potato_Head_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mr-potato-head-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mr_Potato_Head_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mr_Potato_Head_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mr-potato-head-public.js', array( 'jquery' ), $this->version, false );

	}
	/**
	 * Runs wp_localize_script in order to pass localized strings to javascripts.
	 */
	public function localize_scripts () {


		$wp_js_info = array('site_url' => __(site_url()));

		wp_localize_script( $this->public_js_handle , 'objectl10n', array(
			'wpsiteinfo' => $wp_js_info,
			'sliderOn' => false,
			'get_posts_error' => __('Error retrieving posts.',  MPH_TEXTDOMAIN ),
			'get_post_error' =>  __('Error retrieving post.',  MPH_TEXTDOMAIN ),
			'no_more_posts_msg' => __('No more posts to load', MPH_TEXTDOMAIN ),
			'date_section_template' => Mr_Potato_Head_Template_Manager::get_date_section_template(),
			'content_template' => Mr_Potato_Head_Template_Manager::get_content_template(),
			'is_user_logged_in' => is_user_logged_in(),
			'mobile_breakpoint' => 667,
			'display_mobile_format' => true
		));
	}
}
