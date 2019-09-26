<?php
/**
 * Created by PhpStorm.
 * User: weskempferjr
 * Date: 2019-09-22
 * Time: 14:47
 */

class MPH_Post_Expiration_Manager {

	public function expiration_content_filter( $template_path ) {

		// str_replace('.tpl.php', '', $template_path ) . '-custom.tpl.php'

		$filtered_template_path  = dirname( plugin_dir_path(__FILE__ ) ) . '/alsp/'  . str_replace('.tpl.php', '', $template_path ) . '-custom.tpl.php';

		if ( is_file( $filtered_template_path )) {
			$template_path =  str_replace( '-custom', '' , $filtered_template_path) ;
		}

		return $template_path;



	}

	public function add_expiration_pre_content( $listing ) {
		echo '<div class="expiration-info-container" style="display: none"></div>';

	}

	public function add_filters( $loader ) {
		// $loader->add_filter('the_content', $this ,'expiration_content_filter');
		// $loader->add_filter('alsp_listing_display_template', $this ,'expiration_content_filter');
		$loader->add_filter('alsp_frontent_render', $this ,'expiration_content_filter');

		//alsp_frontent_render

	}

	public function add_actions ( $loader ) {
		$loader->add_action('alsp_listing_pre_content_html', $this, 'add_expiration_pre_content');
		$loader->add_action('alsp_listing_title_html', $this, 'add_expiration_pre_content');
	}


// alsp_listing_pre_content_html
}