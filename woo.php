https://woocommerce.com/document/woocommerce-shortcodes/
<?php 


// mini cart woocommerce_mini_cart
function custom_mini_cart() { 
    echo '<li> <a href="'.wc_get_cart_url() .'" class="dropdown-back" data-toggle="dropdown"> ';
    echo '<i class="fa fa-shopping-cart" aria-hidden="true"></i>';
    echo '<div class="basket-item-count" style="display: inline;">';
        echo '<span class="cart-items-count count">';
            echo WC()->cart->get_cart_contents_count();
        echo '</span>';
    echo '</div>';
    echo '</a></li>';
  
        echo '<div class="widget_shopping_cart_content">';
                  woocommerce_mini_cart();
            echo '</div>';

      }
add_shortcode( 'bio-mini-cart', 'custom_mini_cart' );
?>


<a href="<?php echo wc_get_cart_url() ?>">Cart</a>
<a href="<?php echo wc_get_checkout_url() ?>">Checkout</a>
<?php
	$url = wc_get_endpoint_url( 'add-payment-method', '', wc_get_checkout_url() );
?>
<a href="<?php echo $url ?>">Add Payment Method</a>

<a href="<?php echo wc_get_page_permalink( 'myaccount' ) ?>">My account</a>

<?php $orders_url = wc_get_account_endpoint_url( 'orders' ); ?>
<a href="<?php echo wc_get_page_permalink( 'shop' ) ?>">Continue shopping</a>
<?php
/**
 * @snippet       [recently_viewed_products] Shortcode - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 5.1
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_shortcode( 'recently_viewed_products', 'bbloomer_recently_viewed_shortcode' );
 
function bbloomer_recently_viewed_shortcode() {
 
   $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array();
   $viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );
 
   if ( empty( $viewed_products ) ) return;
    
   $title = '<h3>Recently Viewed Products</h3>';
   $product_ids = implode( ",", $viewed_products );
 
   return $title . do_shortcode("[products ids='$product_ids']");
   
}

==================================================================
add_filter ( 'woocommerce_account_menu_items', 'misha_one_more_link' );
function misha_one_more_link( $menu_links ){
	
	$new = array( 'professional-details' => 'Professional Details' );
	// or in case you need 2 links
	// $new = array( 'link1' => 'Link 1', 'link2' => 'Link 2' );

	// array_slice() is good when you want to add an element between the other ones
	$menu_links = array_slice( $menu_links, 0, 1, true ) 
	+ $new 
	+ array_slice( $menu_links, 1, NULL, true );
	return $menu_links; 
}

add_filter( 'woocommerce_get_endpoint_url', 'nfc_hook_endpoint', 10, 4 );
function nfc_hook_endpoint( $url, $endpoint, $value, $permalink ){
 
	if( $endpoint === 'professional-details' ) { 
		// ok, here is the place for your custom URL, it could be external
		$url = site_url().'/my-account/professional-details/'; 
	}
	return $url;
 
}

// reorder

function nfc_reorder_my_account_menu() {
    $newtaborder = array(
        'dashboard'             => __( 'Dashboard', 'woocommerce' ),
        'edit-account'          => __( 'Account Details', 'woocommerce' ),
        'professional-details'  => __( ' Professional Details', 'woocommerce' ),
        'entries'          => __( 'Requests', 'woocommerce' ),
        'messages'       => __( 'Messages', 'woocommerce' ),
        'edit-account'          => __( 'Bank Account', 'woocommerce' ),
        'payments'       => __( 'Payments', 'woocommerce' ),
		'woo-wallet'       => __( 'My Wallet', 'woocommerce' ),
		'customer-logout'       => __( 'Logout', 'woocommerce' ),
    );
    return $newtaborder;
}
add_filter ( 'woocommerce_account_menu_items', 'nfc_reorder_my_account_menu' );

https://isotropic.co/reorder-woocommerce-account-tabs/
https://codex.wordpress.org/Plugin_API/Action_Reference
===============================================================

https://stackoverflow.com/questions/42223765/get-the-order-id-from-the-current-user-orders-in-woocommerce

## ==> Define HERE the statuses of that orders 
$order_statuses = array('wc-on-hold', 'wc-processing', 'wc-completed');

## ==> Define HERE the customer ID
$customer_user_id = get_current_user_id(); // current user ID here for example

// Getting current customer orders
$customer_orders = wc_get_orders( array(
    'meta_key' => '_customer_user',
    'meta_value' => $customer_user_id,
    'post_status' => $order_statuses,
    'numberposts' => -1
) );


// Loop through each customer WC_Order objects
foreach($customer_orders as $order ){

    // Order ID (added WooCommerce 3+ compatibility)
    $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;

    // Iterating through current orders items
    foreach($order->get_items() as $item_id => $item){

        // The corresponding product ID (Added Compatibility with WC 3+) 
        $product_id = method_exists( $item, 'get_product_id' ) ? $item->get_product_id() : $item['product_id'];

        // Order Item data (unprotected on Woocommerce 3)
        if( method_exists( $item, 'get_data' ) ) {
             $item_data = $item->get_data();
             $subtotal = $item_data['subtotal'];
        } else {
             $subtotal = wc_get_order_item_meta( $item_id, '_line_subtotal', true );
        }

        // TEST: Some output
        echo '<p>Subtotal: '.$subtotal.'</p><br>';

        // Get a specific meta data
        $item_color = method_exists( $item, 'get_meta' ) ? $item->get_meta('pa_color') : wc_get_order_item_meta( $item_id, 'pa_color', true );

        // TEST: Some output
        echo '<p>Color: '.$item_color.'</p><br>';
    }
} 

============================

function nfc_user_order_listing_detail(){
	if ( is_user_logged_in() ){ 
	  $current_user = wp_get_current_user();
		echo $user_id = $current_user->ID;	  
		$customer_orders = get_posts( array(
						'meta_key'    => '_customer_user',
						'meta_value'  => $user_id,
						'post_type'   => 'shop_order',
						'post_status' => array_keys( wc_get_order_statuses() ),
						'numberposts' => -1
					));
			$my_posts = get_posts( $customer_orders );

		if( ! empty( $my_posts ) ){
			$output = 'user id: '.$user_id .'<ul>';
			foreach ( $my_posts as $p ){			
				$booking_id = $p->ID ;
				$output .= '<li>( '. $booking_id .' )' . $p->post_title . '</li>';
				
				$listing_id = get_post_meta($booking_id,"rz_listing",true);
				$output .='rz_listing id: '.$listing_id;
			}
				$output .= '<ul>';
		}
		echo $output; 
	}
} 

==============================================================
Set product sale price programmatically in WooCommerce 3
https://stackoverflow.com/questions/48763989/set-product-sale-price-programmatically-in-woocommerce-3

https://www.businessbloomer.com/woocommerce-set-override-product-price-programmatically/ 


/**
 * @snippet       Alter Product Pricing Part 1 - WooCommerce Product
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 4.1
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_filter( 'woocommerce_get_price_html', 'bbloomer_alter_price_display', 9999, 2 );
 
function bbloomer_alter_price_display( $price_html, $product ) {
    
    // ONLY ON FRONTEND
    if ( is_admin() ) return $price_html;
    
    // ONLY IF PRICE NOT NULL
    if ( '' === $product->get_price() ) return $price_html;
    
    // IF CUSTOMER LOGGED IN, APPLY 20% DISCOUNT   
    if ( wc_current_user_has_role( 'customer' ) ) {
        $orig_price = wc_get_price_to_display( $product );
        $price_html = wc_price( $orig_price * 0.80 );
    }
    
    return $price_html;
 
}
 
/**
 * @snippet       Alter Product Pricing Part 2 - WooCommerce Cart/Checkout
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 4.1
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_action( 'woocommerce_before_calculate_totals', 'bbloomer_alter_price_cart', 9999 );
 
function bbloomer_alter_price_cart( $cart ) {
 
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
 
    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) return;
 
    // IF CUSTOMER NOT LOGGED IN, DONT APPLY DISCOUNT
    if ( ! wc_current_user_has_role( 'customer' ) ) return;
 
    // LOOP THROUGH CART ITEMS & APPLY 20% DISCOUNT
    foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
        $product = $cart_item['data'];
        $price = $product->get_price();
        $cart_item['data']->set_price( $price * 0.80 );
    }
 
}
//**** https://quadlayers.com/update-product-price-programmatically-in-woocommerce/ **** /////
//  woocommerce dynamic pricing programmatically
//   1) Update product price when a checkbox is selected
//// 1.1 Add the checkbox input field to the products page

add_action('woocommerce_after_add_to_cart_button', 'add_check_box_to_product_page', 30 );
function add_check_box_to_product_page(){ ?>     
       <div style="margin-top:20px">           
<label for="extra_pack"> <?php _e( 'Extra packaging', 'quadlayers' ); ?>
<input type="checkbox" name="extra_pack" value="extra_pack"> 
</label>
                    
</div>
     <?php
}
//// 1.2 Update the price when the user adds a product to the cart
add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_data', 10, 3 );
 
function add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
     // get product id & price
    $product = wc_get_product( $product_id );
    $price = $product->get_price();
    // extra pack checkbox
    if( ! empty( $_POST['extra_pack'] ) ) {
       
        $cart_item_data['new_price'] = $price + 15;
    }
return $cart_item_data;
}
//// 1.3 Recalculate the total price of the cart
add_action( 'woocommerce_before_calculate_totals', 'before_calculate_totals', 10, 1 );
 
function before_calculate_totals( $cart_obj ) {
if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
return;
}
// Iterate through each cart item
foreach( $cart_obj->get_cart() as $key=>$value ) {
if( isset( $value['new_price'] ) ) {
$price = $value['new_price'];
$value['data']->set_price( ( $price ) );
}
}
}

// 2. Edit the product price based on user roles
function add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
    // get product id & price
   $product = wc_get_product( $product_id );
   $price = $product->get_price();
   if(// Is logged in && is customer role
       is_user_logged_in()==true&& wc_current_user_has_role( 'customer' )){
       
        $cart_item_data['new_price'] = $price * 0.8;
   }
return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_data', 10, 3 );

// 3. Update product price based on product taxonomy
add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_data', 10, 3 );
 
function add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
     // get product id & price
    $product = wc_get_product( $product_id );
    $price = $product->get_price();
    $terms = get_the_terms( $product_id, 'product_cat' );
    // Category match ! apply discount
    if($terms[0]->name=='Posters'){                    
        $cart_item_data['new_price'] = $price + 20;
     }   
return $cart_item_data;
 
}
 
?>

===================================================================
woocmerce : woocommerce woocomerce woo E-com
https://stackoverflow.com/questions/24575035/woocommerce-create-load-more-products-with-ajax/24598744
https://techcresendo.com/woocommerce-fatal-error-actionscheduler-php-lines/
https://clicknathan.com/web-design/woocommerce-actionscheduler-table-error/
https://codecanyon.net/item/lumise-product-designer-woocommerce-wordpress/21222684

Set product sale price programmatically in WooCommerce 3
https://stackoverflow.com/questions/48763989/set-product-sale-price-programmatically-in-woocommerce-3

https://www.businessbloomer.com/woocommerce-set-override-product-price-programmatically/ 
https://stackoverflow.com/questions/62748334/how-can-we-display-the-edit-account-form-using-shortcode
https://remicorson.com/customise-woocommerce-checkout-fields-based-on-products-in-cart/
https://remicorson.com/how-to-customize-the-woocommerce-checkout-page/
https://isotropic.co/reorder-woocommerce-account-tabs/

https://wordpress.org/plugins/checkout-for-paypal/ 
https://wordpress.org/plugins/wordpress-easy-paypal-payment-or-donation-accept-plugin/
https://wordpress.org/plugins/wp-paypal/


 Add to Cart URL
 https://www.businessbloomer.com/woocommerce-custom-add-cart-urls-ultimate-guide/  
 
Woo cart and checkout
https://wordpress.org/plugins/woo-checkout-on-popup-free/
https://wordpress.org/plugins/instantio/

Sale Tax:
https://wordpress.org/plugins/simple-sales-tax/

https://rudrastyh.com/woocommerce/add-product-to-cart-programmatically.html
https://rudrastyh.com/woocommerce/get-number-of-items-in-cart.html

https://woocommerce.com/document/setting-up-taxes-in-woocommerce/
https://woocommerce.com/document/woocommerce-shipping-and-tax/woocommerce-tax/ 
https://rudrastyh.com/woocommerce

// payment gateway Checkout 
https://wordpress.org/plugins/mycryptocheckout/
Zelle : https://wordpress.org/plugins/wc-zelle/
crypto : https://wordpress.org/plugins/triplea-cryptocurrency-payment-gateway-for-woocommerce/
cashapp : https://wordpress.org/plugins/wc-cashapp/ 


order:
https://wordpress.org/plugins/order-import-export-for-woocommerce/
