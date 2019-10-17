<?php


/**
 * This class receives ajax requests for the plugin.
 *
 * @since      1.0.0
 * @package    CrowdMap
 * @subpackage CrowdMap/includes
 * @author     Wes Kempfer <wkempferjr@tnotw.com>
 */

class Mr_Potato_Head_Ajax_Controller {

	/*
	 * Function: execute_request
	 * 
	 * This function is registered as the ajax responder for the
	 * plugin in Wordpress. It calls subordinate functions in order
	 * to satisfy the request. The return string from the subordinate
	 * function is output as a client response directly in this function.
	 * 
	 * If an exception is caught by this function, data related to the
	 * exception are formated and sent as an error response to the
	 * client. 
	 * 
	 * @param none directly. Reads $_REQUEST for 'fn' (function) parameter. 
	 * 
	 * 
	 * 
	 */

	public static function execute_request() {

		try {
			switch($_REQUEST['fn']){
				

				case 'get_posts':
					// If  not set, consider it an invalid request.
					if ( !isset( $_REQUEST['count']) || $_REQUEST['count'] == 'undefined' ) {
						throw new Exception(__('Invalid get proposals request. "count" is not defined.', PGDB_TEXTDOMAIN ) );
					}

					if ( !isset( $_REQUEST['currentOffset']) || $_REQUEST['currentOffset'] == 'undefined' ) {
						throw new Exception(__('Invalid get posts request. The "currentOffset" param is not set', PGDB_TEXTDOMAIN ) );
					}
					$output = self::get_posts( $_REQUEST['count'], $_REQUEST['currentOffset']  );
					if ( $output === false ) {
						throw new Exception(__('Could not get get posts as requested.', PGDB_TEXTDOMAIN ) );
					}
					break;

				case 'get_auction_data':
					// If  not set, consider it an invalid request.
					if ( !isset( $_REQUEST['auctions']) || $_REQUEST['auctions'] == 'undefined' ) {
						throw new Exception(__('Invalid get auction data request. Necessary parameters are not defined.', PGDB_TEXTDOMAIN ) );
					}

					$output = self::get_auction_data( $_REQUEST['auctions'] );
					if ( $output === false ) {
						throw new Exception(__('Could not get get posts as requested.', PGDB_TEXTDOMAIN ) );
					}
					break;


				case 'test_closing' :

					if ( !isset( $_REQUEST['listing_post_id']) || $_REQUEST['listing_post_id'] == 'undefined' ) {
						throw new Exception(__('Invalid test closing request. Necessary parameters are not defined.', PGDB_TEXTDOMAIN ) );

					}

					$output = self::test_closing( $_REQUEST['listing_post_id'] );
					break;

				case 'restore_expiration' :

					if ( !isset( $_REQUEST['listing_post_id']) || $_REQUEST['listing_post_id'] == 'undefined' ) {
						throw new Exception(__('Invalid restore expiration request. Necessary parameters are not defined.', PGDB_TEXTDOMAIN ) );
					}

					$output = self::restore_expiration( $_REQUEST['listing_post_id'] );
					break;

			
				default:
					$output = __('Unknown ajax request sent from client.', PGDB_TEXTDOMAIN );
					break;

			}
		}
		catch ( Exception $e ) {
			$errorData = array(
				'errorData' => 'true',
				'errorMessage' => $e->getMessage(),
				'errorTrace' => $e->getTraceAsString()
			);
			$output = $errorData;
		}

		// Convert $output to JSON and echo it to the browser 

		$output=json_encode($output);
		if(is_array($output)){
			print_r($output);
		}
		else {
			echo  $output ;
		}
		die;
	}


	private static function get_posts( $count, $current_offset ) {

		$count = intval(( $_REQUEST['count']));
		$current_offset = intval(( $_REQUEST['currentOffset']));

		return Post_Post_Type::get_posts( $count, $current_offset );
	}

	// TODO: add sanitize
	private static function get_auction_data( $auctions ) {

		$ids = array();

		foreach ( $auctions as $auction ) {
			$ids[] = $auction['id'];
		}

		if ( count( $ids) > 0 ) {
			$listingManager = new Mr_Potato_Head_ALSP_Listing_Manager();
			return $listingManager->get_listings_by_ids( $ids );
		}
	}

	private static function test_closing( $post_id ) {

		$closing_post_id = sanitize_text_field( $post_id );
		$testing_mgr = new Mr_Potato_Head_Testing_Manager();

		$retval =  $testing_mgr->test_closing( $closing_post_id );

		if ( ! $retval ) {
			return sprintf( __('Could not set expiration time for post %s. Check post ID', MPH_TEXTDOMAIN), $closing_post_id );
		}

		return sprintf( __( 'Post %s expiration time set to %d to test auction close.', MPH_TEXTDOMAIN ), $closing_post_id, $retval );


	}

	private static function restore_expiration( $post_id ) {

		$closing_post_id = sanitize_text_field( $post_id );
		$testing_mgr = new Mr_Potato_Head_Testing_Manager();

		$retval =  $testing_mgr->restore_expiration( $closing_post_id );

		if ( ! $retval ) {
			return sprintf( __('Could not restore expiration time for post %s. Check post ID', MPH_TEXTDOMAIN), $closing_post_id );
		}

		return sprintf( __( 'Post %s expiration time set to %d.', MPH_TEXTDOMAIN ), $closing_post_id, $retval );


	}



	public function mph_ajax() {
		self::execute_request();
	}

}


?>