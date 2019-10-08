<?php
/**
 * Created by PhpStorm.
 * User: weskempferjr
 * Date: 2019-10-03
 * Time: 14:06
 */

class Mr_Potato_Head_ALSP_Listing_Manager {


	public function get_listings_by_ids( $ids ) {

		$listings = array();

		$args = array(
			'post_type' => ALSP_POST_TYPE,
			'post__in' => $ids
		);


		$query = new WP_Query( $args );
		if ( $query->have_posts() ) :


			while ( $query->have_posts() ) : $query->the_post();

		      $post_id = get_the_ID();

			  $expire = get_post_meta( $post_id, '_expiration_date', true);

		      $bids = get_post_meta( $post_id, '_listing_bidpost', false);
		      $max_bid = max( $bids );

			   $listing = array(
				   'id' => $post_id,
				   'expire' => $expire,
				   'bid' => $max_bid
			   );

			  $listings[] = $listing;

			endwhile;

			wp_reset_postdata();



	    endif;

	    return $listings ;

	}

}