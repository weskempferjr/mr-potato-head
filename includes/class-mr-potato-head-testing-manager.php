<?php
/**
 * Created by PhpStorm.
 * User: weskempferjr
 * Date: 2019-10-16
 * Time: 13:51
 */

class Mr_Potato_Head_Testing_Manager {

	public function test_closing( $post_id ) {

		$current_expiration = intval( get_post_meta( $post_id, '_expiration_date', true ) );

		if ( $current_expiration === 0 ) {
			return false;
		}
		update_post_meta( $post_id, '_saved_expiration_date', $current_expiration );
		$time_now = time();
		$options = get_option( TNOTW_MPH_OPTIONS_NAME );

		$resetable_timer_threshold = intval( $options[ 'mph_resetable_timer_threshold'] );

		$test_expiration = $time_now + ( $resetable_timer_threshold ) ;

		update_post_meta( $post_id, '_expiration_date', $test_expiration );

		return $test_expiration  ;

	}


	public function restore_expiration ( $post_id ) {

		$saved_expiration = intval( get_post_meta( $post_id, '_saved_expiration_date', true ) );

		if ( $saved_expiration === 0 ) {
			return false;
		}

		update_post_meta( $post_id, '_expiration_date', $saved_expiration );

		return $saved_expiration ;
	}
}