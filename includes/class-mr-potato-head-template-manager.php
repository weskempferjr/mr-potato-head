<?php
/**
 *
 */

class Mr_Potato_Head_Template_Manager {


	/**
	 * Mr_Potato_Head_Template_Manager constructor.
	 */
	public function __construct() {

	}

	public static function get_date_section_template() {

		return '<div class="mph-group-section">
				<h2>__GROUP_HEADING__</h2>
				<div id="__GROUP_SECTION_ID__" class="pgdb-group-section-content">
				</div>
			</div>';

	}

	public static function get_content_template() {

		return '<div class="mph-post-content-container mph-group-member">
				<div class="mph-post-thumbnail-container pdbd-content-member">
					__THUMBNAIL__
				</div>
				<div class="mph-post-excerpt-container mph-content-member">
					<div class="mph-title-container"><h3>__TITLE__</h3></div>
					<div class="mph-excerpt-container">__EXCERPT__</div>
					<div class="mph-link-container"><a href="__URL__">Read More...</a></div>
				</div>	
			</div>';
	}


	public function woocommerce_locate_templates ( $template, $template_name, $template_path ) {

		global $woocommerce ;

		$_template = $template;

		if ( ! $template_path ) $template_path = $woocommerce->template_url;

		$plugin_path  = plugin_dir_path( dirname( __FILE__ ) )  . 'woocommerce/templates/';

		// Look within passed path within the theme - this is priority
		$template = locate_template(

			array(
				$template_path . $template_name,
				$template_name
			)
		);

		// Modification: Get the template from this plugin, if it exists
		if ( ! $template && file_exists( $plugin_path . $template_name ) )
			$template = $plugin_path . $template_name;

		// Use default template
		if ( ! $template )
			$template = $_template;

		// Return what we found
		return $template;


	}

}