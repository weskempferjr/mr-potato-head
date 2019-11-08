<?php
/**
 * Created by PhpStorm.
 * User: weskempferjr
 * Date: 2019-09-22
 * Time: 14:47
 */

class MPH_Post_Expiration_Manager {

	public function expiration_content_filter( $template_path ) {
		
		$filtered_template_path  = dirname( plugin_dir_path(__FILE__ ) ) . '/alsp/'  . str_replace('.tpl.php', '', $template_path ) . '-custom.tpl.php';

		if ( is_file( $filtered_template_path )) {
			$template_path =  str_replace( '-custom', '' , $filtered_template_path) ;
		}

		return $template_path;



	}

	public function add_expiration_pre_content( $listing ) {
		echo '<div class="expiration-info-container" style="display: none"></div>';

	}

	public function resetExpirationOnBid(  $message_id, $message, $inserted_message ) {


		if ( $inserted_message->post_content == "New Bid" ) {
			$expiration_date = get_post_meta( $message['message_post_id'] , '_expiration_date', true);

			$time_remaining = $expiration_date - time();

			// TODO: make threshold an option.
			$options = get_option( TNOTW_MPH_OPTIONS_NAME );
			$resetable_timer_threshold = $options['mph_resetable_timer_threshold'];

			if ( $time_remaining < $resetable_timer_threshold ) {
				$expiration_date += $resetable_timer_threshold - $time_remaining ;
				update_post_meta( $message['message_post_id'], '_expiration_date', $expiration_date );
			}

		}
	}

	/*
	 * This function is called via the pre_post_update function. If a post is an alsp_listing,
	 * post_status is pending and if the expiration date is less than 1 week, set status back to published.
	 *
	 */
	public function preserve_published_status_after_update( $post_id, $after_post, $before_post ) {

		$post_type = $before_post->post_type;
		$before_status = $before_post->post_status ;
		$after_status = $after_post->post_status ;

		if ( $post_type == 'alsp_listing' && $before_status == 'publish'  && $after_status == 'pending') {

			$expire = intval( get_post_meta( $post_id, '_expiration_date', true) );
			$now = time();

			$updated_post = $after_post ;
			$updated_post->post_status = 'publish';

			if (   $now < $expire ) {
				wp_update_post( $updated_post );
			}

		}

	}

	public function add_filters( $loader ) {
		// $loader->add_filter('the_content', $this ,'expiration_content_filter');
		// $loader->add_filter('alsp_listing_display_template', $this ,'expiration_content_filter');
		$loader->add_filter('alsp_frontent_render', $this ,'expiration_content_filter');

		//alsp_frontent_render

	}

	public function add_actions ( $loader ) {
		// $loader->add_action('alsp_listing_pre_content_html', $this, 'add_expiration_pre_content');
		// $loader->add_action('alsp_listing_title_html', $this, 'add_expiration_pre_content');

		$loader->add_action('difp_action_message_after_send', $this, 'resetExpirationOnBid', 10, 3);
		$loader->add_action('post_updated', $this, 'preserve_published_status_after_update', 10, 3);
	}


// alsp_listing_pre_content_html
}