<?php
/**
 * Created by PhpStorm.
 * User: weskempferjr
 * Date: 2019-10-16
 * Time: 11:03
 */

class Mr_Potato_Head_Menu_Pages {


	public function __construct() {

	}

	public function admin_menu_pages(){
		// Add the top-level admin menu
		$page_title = 'MPH Plugin Setings';
		$menu_title = 'MPH';
		$capability = 'manage_options';
		$menu_slug = 'mph-settings';
		$function = 'mph_settings';

		$mph_settings = new Mr_Potato_Head_Settings();

		add_menu_page($page_title, $menu_title, $capability, $menu_slug, array($mph_settings, 'settings_page')) ;

		// Add submenu page with same slug as parent to ensure no duplicates
		$sub_menu_title = 'Settings';
		add_submenu_page($menu_slug, $page_title, $sub_menu_title, $capability, $menu_slug, array( $mph_settings, 'settings_page'));



	}

	public function mph_settings() {
		$mph_settings = new Mr_Potato_Head_Settings();
		$mph_settings->settings_init();
	}



}