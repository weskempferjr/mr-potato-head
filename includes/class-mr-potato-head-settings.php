<?php
/**
 * Created by PhpStorm.
 * User: weskempferjr
 * Date: 2019-10-16
 * Time: 10:21
 */

class Mr_Potato_Head_Settings {

	/*
	 * Sets the name of plugin option.
	 */
	private $options_name = TNOTW_MPH_OPTIONS_NAME;

	/*
	 * Default values for plugin options are defined here.
	 * These values are recorded in wp_option at activation time.
	 *
	 */
	private $default_use_widget_area = false;
	private $default_remove_data_on_uninstall = false;
	private $version = MR_POTATO_HEAD_VERSION ;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

	}


	/*
	 * Get the plugin option name.
	 *
	 * @return string plugin option name.
	 */
	public function get_options_name() {
		return $this->options_name;
	}


	/*
	 * This function is called at activation time and by the constructor. It records
	 * the plugin settings default values in the wp_options table.
	 * If the plugin options already exist in the database, they
	 * are not overwritten.
	 *
	 * @since 1.0.0
	 */
	public function add_option_defaults() {

		if ( current_user_can('activate_plugins') ) {
			$options = array();
			$options['mph_remove_data_on_uninstall'] = $this->default_remove_data_on_uninstall;
			$options['version'] = $this->version ;
			$options['mph_resetable_timer_threshold'] = 240;
			$options['mph_retrieve_post_data_interval'] = 30;
			$options['mph_retrieve_post_data_interval_closing'] = 5;


			add_option( $this->options_name, $options );
		}

	}




	/*
	 * This function was intended to be called to delete the
	 * options from the database.
	 *
	 * @todo Can this delete_options() be removed.
	 * @since 1.0.0
	 */

	public function delete_options() {
		if ( current_user_can('delete_plugins') ) {
			delete_option($this->options_name );
		}
	}







	/*
	 * Return "remove data on uninstall" flag. If true, all
	 * data and settings associated with the plugin are to be delete.
	 *
	 * @since 1.0.0
	 *
	 * @param none
	 * @return boolean remove_plugin_data_on_uninstall
	 */
	public function get_remove_data_on_uninstall() {
		$option = get_option( $this->options_name);
		return $option['mph_remove_data_on_uninstall'];
	}





	/*
	 *
	 */
	public function get_resetable_timer_threshold() {
		$option = get_option( $this->options_name);
		return $option['mph_resetable_timer_threshold'];
	}

	/*
	 *
	 */
	public function get_retrieve_post_data_interval() {
		$option = get_option( $this->options_name);
		return $option['mph_retrieve_post_data_interval'];
	}

	/*
	 *
	 */
	public function get_retrieve_post_data_interval_closing() {
		$option = get_option( $this->options_name);
		return $option['mph_retrieve_post_data_interval_closing'];
	}


	/*
	 * This method defines the plugin setting page.
	 *
	 * @since 1.0.0
	 *
	 * @param none
	 * @return void
	 */
	public function settings_init(  ) {

		register_setting( 'mph-settings-group', $this->options_name, array( $this, 'sanitize') );

		add_settings_section(
			'mph-settings-general-section',
			__( 'MPH General Settings', MPH_TEXTDOMAIN ),
			array($this, 'mph_settings_general_info'),
			'mph-settings-page'
		);

		add_settings_field(
			'mph_remove_data_at_uninstall',
			__( 'Remove plugin posts, settings, and other data on deactivation.', MPH_TEXTDOMAIN ),
			array($this, 'mph_remove_data_render'),
			'mph-settings-page',
			'mph-settings-general-section'
		);



		add_settings_field(
			'mph_resetable_timer_threshold',
			__( 'Resetable Timer Threshold (seconds)', MPH_TEXTDOMAIN ),
			array($this, 'mph_resetable_timer_threshold_render'),
			'mph-settings-page',
			'mph-settings-general-section'
		);

		add_settings_field(
			'mph_retrieve_post_data_interval',
			__( 'Retreive Post Data Threshold (seconds)', MPH_TEXTDOMAIN ),
			array($this, 'mph_retrieve_post_data_interval_render'),
			'mph-settings-page',
			'mph-settings-general-section'
		);

		add_settings_field(
			'mph_retrieve_post_data_interval_closing',
			__( 'Retreive Post Data Threshold Closing (seconds)', MPH_TEXTDOMAIN ),
			array($this, 'mph_retrieve_post_data_interval_closing_render'),
			'mph-settings-page',
			'mph-settings-general-section'
		);




	}

	/*
	 * Calls add_options_page to register the page and menu item.
	 *
	 * @since 1.0.0
	 *
	 * @param none
	 * @return integer map_desc_excerpt_len
	 */
	public function add_mph_options_page( ) {

		// Add the top-level admin menu
		$page_title = 'MPH Plugin Setings';
		$menu_title = 'MPH';
		$capability = 'manage_options';
		$menu_slug = 'mph-settings';
		$function = 'settings_page';
		add_options_page($page_title, $menu_title, $capability, $menu_slug, array($this, $function)) ;


	}

	/*
	 * Defines and displays the plugin settings page.
	 * @since 1.0.0
	 *
	 * @param none
	 * @return none
	 */
	public function settings_page(  ) {

		$this->add_option_defaults();

		?>
		<div class="wrap">
			<form action='options.php' method='post'>

				<h2><?php _e('MPH Settings', MPH_TEXTDOMAIN ) ;?></h2>
				<div id="mph-settings-container">
					<?php

					settings_fields( 'mph-settings-group' );
					do_settings_sections( 'mph-settings-page' );
					submit_button();
					?>
				</div>
			</form>

            <div id="test-closing-container">
                <form id="test-closing-form" action="/wp-admin/admin-ajax.php?action=mph_ajax&fn=test_closing" method="post">
                    <input type="number" name="listing_post_id" value="">
                    <button type"submit"><?php _e('Test Closing', MPH_TEXTDOMAIN ) ;?></button>
                </form>
            </div>

            <div id="restore-expiration-container">
                <form id="restore-expiration-form" action="/wp-admin/admin-ajax.php?action=mph_ajax&fn=restore_expiration" method="post">
                    <input type="number" name="listing_post_id" value="">
                    <button type"submit"><?php _e('Restore Expiration', MPH_TEXTDOMAIN ) ;?></button>
                </form>
            </div>

		</div>
		<?php

	}



	/*
	 * Render the remove data on unsinstal checkbox field.
	 * @since 1.0.0
	 */
	public function mph_remove_data_render(  ) {

		$options = get_option( $this->options_name );
		?>
		<input id="remove_mph_data_input" type="checkbox" name="tnotw_mph_settings[mph_remove_data_on_uninstall]" <?php checked( $options['mph_remove_data_on_uninstall'], 1 ); ?> value='1'>
		<br><label for="remove_mph_data_input"><em>Leave this unchecked unless you really want to remove the posts you have created using this plugin.</em></label>
		<?php

	}





	/*
	 *
	 *
    */
	public function mph_resetable_timer_threshold_render(  ) {

		$options = get_option( $this->options_name );
		?>
		<input type="number" size="10" name="tnotw_mph_settings[mph_resetable_timer_threshold]"
		       value="<?php echo $options['mph_resetable_timer_threshold']; ?>">
		<?php
	}

	public function mph_retrieve_post_data_interval_render(  ) {

		$options = get_option( $this->options_name );
		?>
        <input type="number" size="10" name="tnotw_mph_settings[mph_retrieve_post_data_interval]"
               value="<?php echo $options['mph_retrieve_post_data_interval']; ?>">
		<?php
	}


	public function mph_retrieve_post_data_interval_closing_render(  ) {

		$options = get_option( $this->options_name );
		?>
        <input type="number" size="10" name="tnotw_mph_settings[mph_retrieve_post_data_interval_closing]"
               value="<?php echo $options['mph_retrieve_post_data_interval_closing']; ?>">
		<?php
	}


	/*
	 * Sanitize user input before passing values on to update options.
	 * @since 1.0.0
	 */
	public function sanitize( $input ) {

		$new_input = array();

		if( isset( $input['mph_remove_data_on_uninstall'] ) ) {
			$new_input['mph_remove_data_on_uninstall'] = boolval( $input['mph_remove_data_on_uninstall'] );
		}
		else {
			// set to default
			$new_input['mph_remove_data_on_uninstall'] = false ;
		}



		if( isset( $input['mph_resetable_timer_threshold'] ) )
			$new_input['mph_resetable_timer_threshold'] = intval( $input['mph_resetable_timer_threshold'] );

		if( isset( $input['mph_retrieve_post_data_interval'] ) )
			$new_input['mph_retrieve_post_data_interval'] = intval( $input['mph_retrieve_post_data_interval'] );


		if( isset( $input['mph_retrieve_post_data_interval_closing'] ) )
			$new_input['mph_retrieve_post_data_interval_closing'] = intval( $input['mph_retrieve_post_data_interval_closing'] );


		if( isset( $input['version'] ) )
		    $new_input['version'] = sanitize_text_field( $input['version']);


		return $new_input ;
	}

	/*
	 * Render general settings section info.
	 * @since 1.0.0
	 */
	public function mph_settings_general_info () {
		echo '<p>' . __("General settings for MPH Plugin", MPH_TEXTDOMAIN) . '</p>';
	}





	/*
	 * Places link to settings page under the Plugins->Installed Plugins listing entry.
	 * It is intended to be called via add_filter.
	 *
	 * @param array $links an array of existing action links.
	 *
	 * @return $links with
	 * @since 1.0.0
	 */
	public function action_links( $links ) {

		array_unshift( $links,'<a href="http://support.tnotw.com/support/home" target="_blank">FAQ</a>' );
		array_unshift($links, '<a href="'. get_admin_url(null, 'options-general.php?page=mph-settings') .'">Settings</a>');

		return $links;


	}


}