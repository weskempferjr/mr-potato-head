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



	public function mr_potato_head_ajax() {
		self::execute_request();
	}

}


?>