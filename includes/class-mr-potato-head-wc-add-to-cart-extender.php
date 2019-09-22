<?php
/**
 * Created by PhpStorm.
 * User: weskempferjr
 * Date: 2019-09-19
 * Time: 16:32
 */

class Mr_Potato_Head_WC_Add_To_Cart_Extender {


	public function add_actions( $loader ) {

		$loader->add_action('woocommerce_before_add_to_cart_form', $this, 'before_add_to_cart_form_action');
		$loader->add_action('woocommerce_after_add_to_cart_form', $this, 'after_add_to_cart_form_action');
	}

	public function before_add_to_cart_form_action( ) {

		echo '<div class="mph-cart-ext-container">';

	}

	public function after_add_to_cart_form_action() {
		global $product;

		$prod_id = $product->get_id();

		$one_button_add_on_product_id = (int)get_post_meta( $prod_id, 'one_button_add_on_product', true);
		$one_button_add_on_button_text = get_post_meta( $prod_id, 'one_button_add_on_text', true);

		if( $one_button_add_on_product_id && $one_button_add_on_button_text ) {

			echo '<div class="mph-one-button-add-on-container"><button>'.  $one_button_add_on_button_text . ' </button></div>';
		}
		echo '</div>';
	}

}