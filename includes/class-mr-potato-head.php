<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://tnotw.com
 * @since      1.0.0
 *
 * @package    Mr_Potato_Head
 * @subpackage Mr_Potato_Head/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Mr_Potato_Head
 * @subpackage Mr_Potato_Head/includes
 * @author     Wendy Emerson <wendybreaksout@gmail.com>
 */
class Mr_Potato_Head {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Mr_Potato_Head_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'MR_POTATO_HEAD_VERSION' ) ) {
			$this->version = MR_POTATO_HEAD_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'mr-potato-head';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$this->register_shortcodes();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Mr_Potato_Head_Loader. Orchestrates the hooks of the plugin.
	 * - Mr_Potato_Head_i18n. Defines internationalization functionality.
	 * - Mr_Potato_Head_Admin. Defines all hooks for the admin area.
	 * - Mr_Potato_Head_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mr-potato-head-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mr-potato-head-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mr-potato-head-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mr-potato-head-public.php';

		// $this->loader = new Mr_Potato_Head_Loader();


		/**
		 * The class responsible post post type related requests
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'model/class-post-post-type.php';

		/**

		/**
		 * The class responsible defining and adding shortcodes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mr-potato-head-shortcodes.php';



		/**
		 * The classes responsible for handling ajax requests
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mr-potato-head-ajax.php';

		/*
		 * The client template manager returns templates to be used on the client side.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mr-potato-head-template-manager.php';


		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mr-potato-head-wc-add-to-cart-extender.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mph-post-expiration-manager.php';




		$this->loader = new Mr_Potato_Head_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Mr_Potato_Head_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Mr_Potato_Head_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Mr_Potato_Head_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Mr_Potato_Head_Public( $this->get_plugin_name(), $this->get_version() );

		$ajax_controller = new Mr_Potato_Head_Ajax_Controller();

		$template_manager = new Mr_Potato_Head_Template_Manager();



		$this->loader->add_filter( 'woocommerce_locate_template', $template_manager, 'woocommerce_locate_templates', 10, 3);

		if ( $this->has_shortcodes() ) {

			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'localize_scripts');


			$this->loader->add_action('wp_ajax_nopriv_mph_ajax' , $ajax_controller, 'mr_potato_head_ajax');
			$this->loader->add_action('wp_ajax_mph_ajax' , $ajax_controller, 'mr_potato_head_ajax');


		}

		$cart_extender = new Mr_Potato_Head_WC_Add_To_Cart_Extender();
		$cart_extender->add_actions( $this->get_loader() );

		$template_manager = new Mr_Potato_Head_Template_Manager() ;
		$template_manager->add_filters(  $this->get_loader() );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Mr_Potato_Head_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register shortcodes
	 */
	private function register_shortcodes() {
		$shortcodes = new Mr_Potato_Head_Shortcodes();
		$shortcodes->register_shortcodes();
	}



	private function has_shortcodes() {

		global $post;

		$post_type = get_post_type();

		$has_shortcodes = false;
		if ( $post_type == "post"|| $post_type == "page" ) {

			foreach( Mr_Potato_Head_Shortcodes::get_shortcodes() as $shortcode ) {
				if ( has_shortcode( $post->post_content, $shortcode ) ) {
					$has_shortcodes = true;
					break;
				}
			}
		}
		// return $has_shortcodes;
		// TODO: this does not work since post for page with shortcode must not be initialize yet.
		return true;
	}

}
