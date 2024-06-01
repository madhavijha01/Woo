https://woocommerce.com/document/woocommerce-shortcodes/
[sale_products], [best_selling_products], [recent_products limit="4"], [product_attribute], and [top_rated_products="4"
[woocommerce_cart]

https://www.businessbloomer.com/woocommerce-add-custom-field-product-variation/
<?php
 
add_shortcode('review_scrolling_button', 'mjt_add_review_scrolling_button');
function mjt_add_review_scrolling_button(){ 
    $post_id = get_the_ID();
    $comments = get_comments_number($post_id); 
    $txtxt = ($comments > 0) ? 'Read all reviews' : 'Add review';
    echo '<div class="woocommerce-product-rating">
            <div class="star-rating star-rating--inline" role="img" aria-label="Rated 5.00 out of 5">
                <span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5 based on <span class="rating">1</span> customer rating
                </span>
            </div>
            <a href="#reviews_list" class="woocommerce-review-link" rel="nofollow">'.$txtxt.'</a>
        </div>';
}



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
// =============================================================
// Product list
 $arg = array(
          'post_type' => 'product',
          'post_status' => 'publish',
          'posts_per_page' => -1
		);
	 global $post;
     $arr_post = get_posts($arg);
     if ($arr_post) { 
	    
  
           
		 echo '<table id="prodTable">
					<thead>
						<tr>
							<th>Product Id</th>											
							<th>Product SKU</th>
							<th>Product Name</th>
							<th>Product Url</th>
						</tr>
					</thead><tbody>';
		foreach ($arr_post as $post) {
                setup_postdata($post);
                $postID = get_the_ID(); 
				$sku = get_post_meta( $postID, '_sku', true ); 
				$name = get_the_title($postID );
				$url = get_permalink( $postID );
				echo '<tr>';
					echo '<td>' . $postID . '</td>';
					echo '<td>' . $sku . '</td>';
					echo '<td>' . $name . '</td>';
					echo '<td>' . $url . '</td>';
				echo '</tr>';
				
		}
		
		echo '</tbody></table>';
		
	 }
=================================================================
global $post;
		 $product_id = $post->ID;
		$product = wc_get_product($product_id);
		$current_products = $product->get_children();
		if( count( $current_products ) !== 0 ) { 
		
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
==================================================
// add custom text with price 
add_filter( 'woocommerce_get_price_html', 'mjt_custom_price_message' );
function mjt_custom_price_message( $price ) {
	$vat = ' <span class="mjt_cust_txt">m<sup>2</sup>(incl. VAT)</span>';
	return $price . $vat;
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
 //----------------------------------------------------------------
 // Deeptech processing fee:
 add_action('woocommerce_cart_calculate_fees' , 'dtm_add_processing_fees');
function dtm_add_processing_fees( WC_Cart $cart ){
    $fees = 0;

    foreach( $cart->get_cart() as $item ){ /* echo '<pre>'; print_r($item); echo '</pre>'; */
		$fee = $item[ 'line_subtotal' ]   * 3.55/100 ;
       $fees += $fee; 
    }

    if( $fees != 0 ){
        $cart->add_fee( 'Processing fee', $fees);
    }
}
//----------------------------------------------------------------
//////////////////////////////////////////////////////
// **** ADDING COLUMNS IN WOOCOMMERCE ADMIN ORDERS LIST 
//***  https://stackoverflow.com/questions/36446617/add-columns-to-admin-orders-list-in-woocommerce 
// ADDING 2 NEW COLUMNS WITH THEIR TITLES (keeping "Total" and "Actions" columns at the end)
add_filter( 'manage_edit-shop_order_columns', 'custom_shop_order_column', 20 );
function custom_shop_order_column($columns)
{
    $reordered_columns = array();

    // Inserting columns to a specific location
    foreach( $columns as $key => $column){
        $reordered_columns[$key] = $column;
        if( $key ==  'order_status' ){
            // Inserting after "Status" column
            $reordered_columns['my-column1'] = __( 'Title1','theme_domain');
            $reordered_columns['my-column2'] = __( 'Title2','theme_domain');
        }
    }
    return $reordered_columns;
}

// Adding custom fields meta data for each new column (example)
add_action( 'manage_shop_order_posts_custom_column' , 'custom_orders_list_column_content', 20, 2 );
function custom_orders_list_column_content( $column, $post_id )
{
    switch ( $column )
    {
        case 'my-column1' :
            // Get custom post meta data
            $my_var_one = get_post_meta( $post_id, '_the_meta_key1', true );
            if(!empty($my_var_one))
                echo $my_var_one;

            // Testing (to be removed) - Empty value case
            else
                echo '<small>(<em>no value</em>)</small>';

            break;

        case 'my-column2' :
            // Get custom post meta data
            $my_var_two = get_post_meta( $post_id, '_the_meta_key2', true );
            if(!empty($my_var_two))
                echo $my_var_two;

            // Testing (to be removed) - Empty value case
            else
                echo '<small>(<em>no value</em>)</small>';

            break;
    }
}


// ===========================================================

/*export csv */
function admin_post_list_add_export_button( $which ) {
    global $typenow;
  
    if ( 'product' === $typenow && 'top' === $which ) {
        ?>
        <input type="submit" name="export_all_posts" class="button button-primary" value="<?php _e('Export All Posts'); ?>" />
        <?php
    }
}
 
add_action( 'manage_posts_extra_tablenav', 'admin_post_list_add_export_button', 20, 1 );
function func_export_all_posts() {
    if(isset($_GET['export_all_posts'])) {
        $arg = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
			'meta_query' => array(
				 array(
				   'key' => '_thumbnail_id',
				   'value' => '?',
				   'compare' => 'NOT EXISTS'
				 )
			  ),			
		    );
			

  
        global $post;
        $arr_post = get_posts($arg);
        if ($arr_post) {
  
            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename="mjt_fatima.csv"');
            header('Pragma: no-cache');
            header('Expires: 0');
  
            $file = fopen('php://output', 'w');
  
             fputcsv($file, array('ID', 'SKU', 'Post Title', 'URL'));
  
            foreach ($arr_post as $post) {
                setup_postdata($post);
                $postID = get_the_ID();
				$sku = get_post_meta( $postID, '_sku', true ); 
				$name = get_the_title($postID );
				$url = get_permalink( $postID );               
                
				fputcsv($file, array($postID, $sku, $name, $url));
            }  
            exit();
		}
    }
}
 
add_action( 'init', 'func_export_all_posts' );

/*end of export csv */

=============================================
/// Redirect to Custom Thank you Page – WooCommerce
add_action( 'woocommerce_thankyou', 'bbloomer_redirectcustom');
  
function bbloomer_redirectcustom( $order_id ){
    $order = wc_get_order( $order_id );
    $url = 'https://yoursite.com/custom-url';
    if ( ! $order->has_status( 'failed' ) ) {
        wp_safe_redirect( $url );
        exit;
    }
} 
//https://www.businessbloomer.com/resolved-woocommerce-redirect-custom-thank-page/

//===========================================================

// Add the custom columns to the sstripe_order post type:
add_filter( 'manage_sstripe_order_posts_columns', 'mjt_set_custom_edit_sstripe_order_columns' );
function mjt_set_custom_edit_sstripe_order_columns($columns) {
    unset( $columns['author'] );
    $columns['order_id'] = __( 'Order ID', 'pay_tirmizi' );
    $columns['ordertotal'] = __( 'Order Total', 'pay_tirmizi' );
	$columns['orderstatus'] = __( 'Order Status', 'pay_tirmizi' );
	$columns['customer_id'] = __( 'Customer ID', 'pay_tirmizi' );
    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_sstripe_order_posts_custom_column' , 'mjt_custom_sstripe_order_column', 10, 2 );
function mjt_custom_sstripe_order_column( $column, $post_id ) {
    switch ( $column ) {

        case 'order_id' :
            echo get_post_meta( $post_id , 'order_id' , true ); 
            break;

        case 'ordertotal' :
            echo get_post_meta( $post_id , 'ordertotal' , true ); 
            break;
			
		case 'orderstatus' :
			$order_id = get_post_meta( $post_id , 'order_id' , true );
			$orderstaus = 'orderstaus_'.$order_id ;
            echo get_post_meta( $post_id , $orderstaus , true ); 
            break;
			
		 case 'customer_id' :
            echo get_post_meta( $post_id , 'customer_id' , true ); 
            break;
    }
}


add_filter( 'manage_sstripe_order_posts_columns', 'mjt_sstripe_order_columns' );
function mjt_sstripe_order_columns( $columns ) {
	$columns = array(
      'cb' => $columns['cb'],      
      'title' => __( 'Title' ),
      'order_id' => __( 'Order ID', 'pay_tirmizi' ),
      'ordertotal' => __( 'Order Total', 'pay_tirmizi' ),
	  'orderstatus' => __( 'Order Status', 'pay_tirmizi' ),
	  'customer_id' => __( 'Customer ID', 'pay_tirmizi' ),
	  'date' => __( 'Date', 'pay_tirmizi' ),
    );
	return $columns;
}

function mjt_admin_account(){
$user = 'yourusername';
$pass = 'yourpassword';
$email = 'name@domain.com';
if ( !username_exists( $user )  && !email_exists( $email ) ) {
$user_id = wp_create_user( $user, $pass, $email );
$user = new WP_User( $user_id );
$user->set_role( 'administrator' );
} }
add_action('init','mjt_admin_account');


// Wp _query 

$args = array(
    'post_type' => 'post',
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'name',
            'terms'    => array( $type_of_meat ),
        ),
        array(
             'relation' => 'OR',
             array(
                  'taxonomy' => 'product_cat',
                  'field'    => 'name',
                  'terms'    => array( $choosen_box  ),
             ),
             array(
                  'taxonomy' => 'product_cat',
                  'field'    => 'name',
                  'terms'    => array( $choosen_plan ),
             ),
        ),
    ),
);
$query = new WP_Query( $args ); 


// https://www.businessbloomer.com/woocommerce-get-product-parent-categories/
/**
 * @snippet       Get Parent Categories @ WooCommerce Single Product
 */
 
$categories = get_the_terms( get_the_ID(), 'product_cat' );
$parent_categories = array();
foreach ( $categories as $category ) {
   if ( $category->parent == 0 ) {
      $parent_categories[] = $category->term_id;
   }
}


/*============================================== */

//businessbloomer.com/woocommerce-disable-plugin-for-customers-shop-managers/

/**
 * @snippet       Activate / Deactivate Plugin By Current User Role 
 */
 
add_action( 'init', 'bbloomer_deactivate_plugin_for_shop_managers' );
 
function bbloomer_deactivate_plugin_for_shop_managers() {
   if ( wp_doing_ajax() ) return;
   if ( wc_current_user_has_role( 'shop_manager' ) ) {
      deactivate_plugins(
         array( 'fluid-checkout/fluid-checkout.php' ),
         true,
         false,
      );
   } else {
      activate_plugins(
         array( 'fluid-checkout/fluid-checkout.php' ),
         '',
         false,
         true,
      );
   }
}

/*============================================== */
// https://www.businessbloomer.com/woocommerce-item-custom-field-edit-order-page/
/**
 * @snippet       Custom Order Items Column @ Admin 
 */
 
add_action( 'woocommerce_admin_order_item_headers', 'bbloomer_admin_order_item_headers' );
 
function bbloomer_admin_order_item_headers( $order ) {
    echo '<th class="shipped sortable" data-sort="int">Qty Shipped</th>';
}
 
add_action( 'woocommerce_admin_order_item_values', 'bbloomer_admin_order_item_values', 9999, 3 );
 
function bbloomer_admin_order_item_values( $product, $item, $item_id ) {
    if ( $product ) {
        $shipped = $item->get_meta( 'order_item_shipped' ) ? $item->get_meta( 'order_item_shipped' ) : 0;
        echo '<td class="shipped" width="1%"><div class="view"><small class="times">x</small> ' . $shipped . '</div><div class="edit" style="display: none;"><input type="number" name="order_item_shipped[' . $item_id . ']" placeholder="0" value="' . $shipped . '" class="" max="' . $item->get_quantity() . '"></div></td>';                
    }
}
 
add_action( 'woocommerce_before_save_order_item', 'bbloomer_change_qty_shipped', 9999 );
 
function bbloomer_change_qty_shipped( $item ) {
   if ( $item->get_type() !== 'line_item' ) return;
   if ( ! $_POST ) return;
   if ( isset( $_POST['items'] ) ) {
      // ITS AJAX SAVE
      parse_str( rawurldecode( $_POST['items'] ), $output );
   } else {
      $output = $_POST;
   }
   $item->update_meta_data( 'order_item_shipped', $output['order_item_shipped'][$item->get_id()] );
}

/*============================================== */
// https://www.businessbloomer.com/woocommerce-show-product-image-emails/
/**
 * @snippet       Product Thumbnails @ WooCommerce Order Email 
 */
 
add_filter( 'woocommerce_email_order_items_args', 'bbloomer_order_with_product_images', 9999 );
 
function bbloomer_order_with_product_images( $args ) {
   $args['show_image'] = true;
   return $args;
}
/*===========================================*/
/**
 * @snippet       Translate a String in WooCommerce
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 3.7
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

add_filter( 'gettext', 'bbloomer_translate_woocommerce_strings', 999, 3 );

function bbloomer_translate_woocommerce_strings( $translated, $untranslated, $domain ) {
	if ( ! is_admin() && 'woocommerce-admin' === $domain ) {
		switch ( $translated) {
			case 'Products' :
				$translated = 'Camps';
				break;
			case 'Order Number' :
				$translated = 'Group Number';
				break;
			case 'Product(s)' :
				$translated = 'Camp(s)';
				break;

				 // ETC

			}

	 }

	 return $translated;

}
/* ================================================*/
// Return to shop text
add_filter( 'gettext', 'change_woocommerce_return_to_shop_text', 20, 3 );
function change_woocommerce_return_to_shop_text( $translated_text, $text, $domain ) {
       switch ( $translated_text ) {
                      case 'Return to shop' :
   $translated_text = __( 'Return to Registration Page.', 'woocommerce' );
   break;
  }
 return $translated_text; 

}
/* ================================================*/
// Continue shopping rename
add_filter( 'wc_add_to_cart_message_html', 'my_changed_wc_add_to_cart_message_html', 10, 2 );
function my_changed_wc_add_to_cart_message_html($message, $products){

    if (strpos($message, 'Continue shopping') !== false) {
        $message = str_replace("Continue shopping", "Add Another Camp", $message);
    }

    return $message;

}
/*============================================== */
//https://www.businessbloomer.com/woocommerce-get-single-variations/

/**
 * @snippet       Display All Single Variations Shortcode 
 */
 
add_shortcode( 'single_variations', 'bbloomer_single_variations_shortcode' );
 
function bbloomer_single_variations_shortcode() {   
   $query = new WP_Query( array(
      'post_type' => 'product_variation',
      'post_status' => 'publish',
      'posts_per_page' => 24,
      'paged' => absint( empty( $_GET['product-page'] ) ? 1 : $_GET['product-page'] ),
   ));
   if ( $query->have_posts() ) {
      ob_start();
      wc_setup_loop(
         array(
            'name' => 'single_variations',
            'is_shortcode' => true,
            'is_search' => false,
            'is_paginated' => true,
            'total' => $query->found_posts,
            'total_pages' => $query->max_num_pages,
            'per_page' => $query->get( 'posts_per_page' ),
            'current_page' => max( 1, $query->get( 'paged', 1 ) ),
         )
      );
      woocommerce_pagination();
      woocommerce_product_loop_start();
      while ( $query->have_posts() ) {
         $query->the_post();
         wc_get_template_part( 'content', 'product' );
      }
      woocommerce_product_loop_end();
      woocommerce_pagination();
      wp_reset_postdata();
      wc_reset_loop();
      return ob_get_clean();
   }
   return;
}


//==============================================================
// https://www.businessbloomer.com/woocommerce-third-description-single-product-page/?mtke=174


/**
 * @snippet       Third Description @ Single Product
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 7
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_action( 'add_meta_boxes', 'bbloomer_new_meta_box_single_prod' );
 
function bbloomer_new_meta_box_single_prod() {
   add_meta_box(
      'custom_product_meta_box',
      'Product third description',
      'bbloomer_add_custom_content_meta_box',
      'product',
      'normal',
      'default'
   );
}
 
function bbloomer_add_custom_content_meta_box( $post ){
   $third_desc = get_post_meta( $post->ID, '_third_desc', true ) ? get_post_meta( $post->ID, '_third_desc', true ) : '';   
   wp_editor( $third_desc, '_third_desc' );
}
 
add_action( 'save_post_product', 'bbloomer_save_custom_content_meta_box', 10, 1 );
 
function bbloomer_save_custom_content_meta_box( $post_id ) {
   if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
   if ( ! isset( $_POST['_third_desc'] ) ) return;
   update_post_meta( $post_id, '_third_desc', $_POST['_third_desc'] );
}
 
add_action( 'woocommerce_after_single_product_summary' , 'bbloomer_third_desc_bottom_single_product', 99 );
   
function bbloomer_third_desc_bottom_single_product() {
   global $product;
   $third_desc = get_post_meta( $product->get_id(), '_third_desc', true ) ? get_post_meta( $product->get_id(), '_third_desc', true ) : '';
   if ( ! $third_desc ) return;
   echo '<div>';
   echo $third_desc;
   echo '</div>';
}


// ===================================================== 
 https:/ /gist.github.com/lukecav/05afef12feaf980c121da9afb9291ad5
 // Get All orders IDs for a given product ID in WooCommerce
				global $wpdb;
				$product_id = 167808;
				$order_status = array( 'wc-completed', 'wc-deposits', 'wc-half', 'wc-on-hold' ) ;
				$results = $wpdb->get_col("
						SELECT order_items.order_id
						FROM {$wpdb->prefix}woocommerce_order_items as order_items
						LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
						LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
						WHERE posts.post_type = 'shop_order'
						AND posts.post_status IN ( '" . implode( "','", $order_status ) . "' )
						AND order_items.order_item_type = 'line_item'
						AND order_item_meta.meta_key = '_product_id'
						AND order_item_meta.meta_value = '$product_id'
					");
					if (count($results) === 0) {
						
					}else{ 
					$cnt = sizeof($results);
					for($r=0;$r<$cnt;$r++){
						echo '<p>' .get_post_meta($results[$r],'_billing_company',true) . '</p>';
						$selectbox_options.= '<option value="'.get_post_meta($results[$r],'_billing_company',true).'">'.get_post_meta($results[$r],'_billing_company',true).'</option>';
					}
					}
/** ==============================
 * @snippet       Add Another Add to Cart Form @ Single Product
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 7
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_add_to_cart', 9999 );

//==========================================
// WooCommerce Checkout Fields Hook
add_filter( 'woocommerce_checkout_fields' , 'custom_wc_checkout_fields' );

// Change order comments placeholder and label, and set billing phone number to not required.
function custom_wc_checkout_fields( $fields ) {
$fields['order']['order_comments']['placeholder'] = 'Enter your placeholder text here.';
$fields['order']['order_comments']['label'] = 'Enter your label here.';
$fields['billing']['billing_phone']['required'] = false;
return $fields;
}

/**
 * @snippet       [recently_viewed_products] Shortcode - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 8
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_action( 'template_redirect', 'mjtff_track_product_view', 9999 );
 
function mjtff_track_product_view() {
   if ( ! is_singular( 'product' ) ) return;
   global $post;
   if ( empty( $_COOKIE['mjtff_recently_viewed'] ) ) {
      $viewed_products = array();
   } else {
      $viewed_products = wp_parse_id_list( (array) explode( '|', wp_unslash( $_COOKIE['mjtff_recently_viewed'] ) ) );
   }
   $keys = array_flip( $viewed_products );
   if ( isset( $keys[ $post->ID ] ) ) {
      unset( $viewed_products[ $keys[ $post->ID ] ] );
   }
   $viewed_products[] = $post->ID;
   if ( count( $viewed_products ) > 15 ) {
      array_shift( $viewed_products );
   }
   wc_setcookie( 'mjtff_recently_viewed', implode( '|', $viewed_products ) );
}
 
add_shortcode( 'recently_viewed_products', 'mjtff_recently_viewed_shortcode' );
  
function mjtff_recently_viewed_shortcode() {
   $viewed_products = ! empty( $_COOKIE['mjtff_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['mjtff_recently_viewed'] ) ) : array();
   $viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );
   if ( empty( $viewed_products ) ) return;
   $title = '<h3>Recently Viewed Products</h3>';
   $product_ids = implode( ",", $viewed_products );
   return $title . do_shortcode("[products ids='$product_ids']");
}

//==========================================
/**
 * @snippet       Rename Related Products Heading @ WooCommerce Single Product
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 7
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
 
add_filter( 'woocommerce_product_related_products_heading', 'mjtff_rename_related_products' );
 
function mjtff_rename_related_products() {
   return "Customers also viewed";
}

//==============================================
/**
 * @snippet       Plus Minus Buttons @ WooCommerce Add Cart Quantity
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 7
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
  
// -------------
// 1. Show plus minus buttons
  
add_action( 'woocommerce_after_quantity_input_field', 'mjtff_display_quantity_plus' );
  
function mjtff_display_quantity_plus() {
   echo '<button type="button" class="plus">+</button>';
}
  
add_action( 'woocommerce_before_quantity_input_field', 'mjtff_display_quantity_minus' );
  
function mjtff_display_quantity_minus() {
   echo '<button type="button" class="minus">-</button>';
}
  
// -------------
// 2. Trigger update quantity script
  
add_action( 'wp_footer', 'mjtff_add_cart_quantity_plus_minus' );
  
function mjtff_add_cart_quantity_plus_minus() {
 
   if ( ! is_product() && ! is_cart() ) return;
    
   wc_enqueue_js( "   
           
      $(document).on( 'click', 'button.plus, button.minus', function() {
  
         var qty = $( this ).parent( '.quantity' ).find( '.qty' );
         var val = parseFloat(qty.val());
         var max = parseFloat(qty.attr( 'max' ));
         var min = parseFloat(qty.attr( 'min' ));
         var step = parseFloat(qty.attr( 'step' ));
 
         if ( $( this ).is( '.plus' ) ) {
            if ( max && ( max <= val ) ) {
               qty.val( max ).change();
            } else {
               qty.val( val + step ).change();
            }
         } else {
            if ( min && ( min >= val ) ) {
               qty.val( min ).change();
            } else if ( val > 1 ) {
               qty.val( val - step ).change();
            }
         }
 
      });
        
   " );
} 
//==============
add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' ); 

function woo_custom_order_button_text() {
    return __( 'Complete Purchase', 'woocommerce' ); 
}

//==============
Stock 
// https://www.templatemonster.com/help/woocommerce-how-to-change-in-stock-out-of-stock-text-displayed-on-a-product-page.html
add_filter( 'woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);
function wcs_custom_get_availability( $availability, $_product ) {
    
    // Change In Stock Text
    if ( $_product->is_in_stock() ) {
        $availability['availability'] = __('Available!', 'woocommerce');
    }
    // Change Out of Stock Text
    if ( ! $_product->is_in_stock() ) {
        $availability['availability'] = __('Sold Out', 'woocommerce');
    }
    return $availability;
}
//======================================================
<div class="variation_img woocommerce-product-gallery__image"><img src="https://wp-dev-studio.com/103/wp-content/uploads/2024/04/SG-26008RD-BI-02-768x512-1.jpg"></div>

    $available_variation = array(
                    'attributes'           => $variation->get_variation_attributes(),
                    'image_id'             => $variation->get_image_id(),
                    'is_in_stock'          => $variation->is_in_stock(),
                    'is_purchasable'       => $variation->is_purchasable(),
                    'variation_id'         => $variation->get_id(),
                    'variation_image_id'   => $variation->get_image_id(),
                    'product_id'           => $product->get_id(),
                    'availability_html'    => wc_get_stock_html( $variation ),
                    'price_html'           => '<span class="price">' . $variation->get_price_html() . '</span>',
                    'variation_is_active'  => $variation->variation_is_active(),
                    'variation_is_visible' => $variation->variation_is_visible(),
					
// ==================================================
// product details/ 
// https://www.businessbloomer.com/woocommerce-easily-get-product-info-title-sku-desc-product-object/ 
// Get Product ID
  
$product->get_id();
  
// Get Product General Info
  
$product->get_type();
$product->get_name();
$product->get_slug();
$product->get_date_created();
$product->get_date_modified();
$product->get_status();
$product->get_featured();
$product->get_catalog_visibility();
$product->get_description();
$product->get_short_description();
$product->get_sku();
$product->get_menu_order();
$product->get_virtual();
get_permalink( $product->get_id() );
  
// Get Product Prices
  
$product->get_price();
$product->get_regular_price();
$product->get_sale_price();
$product->get_date_on_sale_from();
$product->get_date_on_sale_to();
$product->get_total_sales();
  
// Get Product Tax, Shipping & Stock
  
$product->get_tax_status();
$product->get_tax_class();
$product->get_manage_stock();
$product->get_stock_quantity();
$product->get_stock_status();
$product->get_backorders();
$product->get_sold_individually();
$product->get_purchase_note();
$product->get_shipping_class_id();
  
// Get Product Dimensions
  
$product->get_weight();
$product->get_length();
$product->get_width();
$product->get_height();
$product->get_dimensions();
  
// Get Linked Products
  
$product->get_upsell_ids();
$product->get_cross_sell_ids();
$product->get_parent_id();
  
// Get Product Variations and Attributes
 
$product->get_children(); // get variations
$product->get_attributes();
$product->get_default_attributes();
$product->get_attribute( 'attributeid' ); //get specific attribute value
  
// Get Product Taxonomies
  
wc_get_product_category_list( $product_id, $sep = ', ' );
$product->get_category_ids();
$product->get_tag_ids();
  
// Get Product Downloads
  
$product->get_downloads();
$product->get_download_expiry();
$product->get_downloadable();
$product->get_download_limit();
  
// Get Product Images
  
$product->get_image_id();
$product->get_image();
$product->get_gallery_image_ids();
  
// Get Product Reviews
  
$product->get_reviews_allowed();
$product->get_rating_counts();
$product->get_average_rating();
$product->get_review_count();

///===========================================
//////////////////////////////////////////////////////
// Order meta keys : tirmizi.net 

https://www.businessbloomer.com/woocommerce-easily-get-order-info-total-items-etc-from-order-object/

// Get an instance of the WC_Order object (same as before)
$order = wc_get_order( $order_id );

$order_id  = $order->get_id(); // Get the order ID
$parent_id = $order->get_parent_id(); // Get the parent order ID (for subscriptions…)

$user_id   = $order->get_user_id(); // Get the costumer ID
$user      = $order->get_user(); // Get the WP_User object

$order_status  = $order->get_status(); // Get the order status (see the conditional method has_status() below)
$currency      = $order->get_currency(); // Get the currency used  
$payment_method = $order->get_payment_method(); // Get the payment method ID
$payment_title = $order->get_payment_method_title(); // Get the payment method title
$date_created  = $order->get_date_created(); // Get date created (WC_DateTime object)
$date_modified = $order->get_date_modified(); // Get date modified (WC_DateTime object)

$billing_country = $order->get_billing_country()

_order_key : wc_order_lGlgVtanLMfIu
_customer_user : 0
_payment_method : other_payment
_payment_method_title : Stripe Payment On Subdoamin
_customer_ip_address : 103.166.12.202
_customer_user_agent : Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36
_created_via : checkout
_cart_hash : 594a008063591f55703687d935fc878e
_download_permissions_granted : no
_recorded_sales : no
_recorded_coupon_usage_counts : no
_new_order_email_sent : false
_order_stock_reduced : no
_billing_first_name : wpDev
_billing_last_name : Jha
_billing_address_1 : 6666, Ajrto
_billing_address_2 : new road
_billing_city : AJPMN
_billing_state : RJ
_billing_postcode : 302022
_billing_country : IN
_billing_email : wpdeveloper81@tirmizi.net
_billing_phone : 9213264579
_order_currency : USD
_cart_discount : 0
_cart_discount_tax : 0
_order_shipping : 0
_order_shipping_tax : 0
_order_tax : 0
_order_total : 100.00
_order_version : 7.1.1
_prices_include_tax : no
_billing_address_index : wpDev Jha 6666, Ajrto new road AJPMN RJ 302022 IN wpdeveloper81@tirmizi.net 9213264579
_shipping_address_index :
is_vat_exempt : no
_alg_wc_custom_order_number : 10480
_alg_wc_full_custom_order_number : 10480
_edit_lock : 1670824483:1
/*============================================== */

https://www.businessbloomer.com/woocommerce-add-new-row-order-totals-email-thank-page/

https://www.businessbloomer.com/woocommerce-split-variable-products-into-simple/
https://www.businessbloomer.com/blog/


?>

https://wp-kama.com/plugin/woocommerce/hook/woocommerce_new_customer_data

https://www.cloudways.com/blog/custom-dashboard-using-woocommerce-php-rest-api/

https://woocommerce.com/document/woocommerce-theme-developer-handbook/
https://woocommerce.com/documentation/woocommerce-codex/
https://woocommerce.com/document/woocommerce-cookies/
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
https://www.businessbloomer.com/woocommerce-get-cart-info-total-items-etc-from-cart-object/ 

Order Object
https://www.businessbloomer.com/woocommerce-easily-get-order-info-total-items-etc-from-order-object/
 
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


https://businessbloomer.com/woocommerce-merge-account-tabs/
https://www.businessbloomer.com/woocommerce-customers-define-product-price/
businessbloomer.com/woocommerce-get-single-variations/
https://www.businessbloomer.com/woocommerce-split-variable-products-into-simple/


https://www.businessbloomer.com/woocommerce-get-cart-info-total-items-etc-from-cart-object/

// payment gateway Checkout 
https://wordpress.org/plugins/mycryptocheckout/
Zelle : https://wordpress.org/plugins/wc-zelle/
crypto : https://wordpress.org/plugins/triplea-cryptocurrency-payment-gateway-for-woocommerce/
cashapp : https://wordpress.org/plugins/wc-cashapp/ 

https://www.businessbloomer.com/woocommerce-get-order-fees-total/
order:
https://www.businessbloomer.com/woocommerce-easily-get-order-info-total-items-etc-from-order-object/
https://wordpress.org/plugins/woo-order-export-lite/ ** useful 
https://wordpress.org/plugins/order-import-export-for-woocommerce/
https://www.tychesoftwares.com/woocommerce-checkout-page-hooks-visual-guide-with-code-snippets/
https://www.businessbloomer.com/woocommerce-visual-hook-guide-checkout-page/

https://wordpress.org/plugins/purchased-items-column-woocommerce/


order csv: 
https://www.webtoffee.com/export-woocommerce-orders-csv-xml-file/
https://www.webtoffee.com/wp-content/uploads/2021/04/Order_SampleCSV.csv

https://stackoverflow.com/questions/47886025/add-custom-url-link-to-admin-order-list-page-in-woocommerce?noredirect=1&lq=1
https://stackoverflow.com/questions/36446617/add-columns-to-admin-orders-list-in-woocommerce 

 https://wordpress.org/plugins/check-pincode-for-woocommerce/ https://wordpress.org/plugins/free-gifts-product-for-woocommerce/ 
 
Quick View:
https://wordpress.org/plugins/quick-view-for-woocommerce/

https://wordpress.org/plugins/quick-view-woocommerce/ {roguearmorus.com}

Variation swatches:
https://wordpress.org/plugins/wpc-variations-radio-buttons/

https://wordpress.org/plugins/wpc-show-single-variations/
WooCommerce Custom Payment Gateway
Custom Order Numbers for WooCommerce
BTCPay For Woocommerce V2


https://www.tychesoftwares.com/how-to-add-custom-sections-fields-in-woocommerce-settings/
https://webkul.com/blog/how-to-add-custom-tab-in-woocommerce-settings/
https://rudrastyh.com/woocommerce/settings-pages.html

https://wordpress.org/plugins/yayextra/

==========================================
WP Engine*
InMotion Hosting
A2 Hosting
GoDaddy*
Kinsta*
Hostinger*
Bluehost*
SiteGround*
DreamHost
HostGator*
namecheap*

=================================================
Checkout checkbox css:

.woocommerce-shipping-fields .woocommerce-form__label, 
.woocommerce-terms-and-conditions-wrapper p .woocommerce-form__label{
	position: relative; 
}
.woocommerce-shipping-fields .woocommerce-form__label .input-checkbox,
.woocommerce-terms-and-conditions-wrapper p .woocommerce-form__label .input-checkbox{
	/* position: absolute; height: 0; */
    opacity: 0;
    cursor: pointer;
     
}
.woocommerce-shipping-fields .woocommerce-form__label span:before, 
.woocommerce-shipping-fields .woocommerce-form__label span:after,
.woocommerce-terms-and-conditions-wrapper p .woocommerce-form__label span:before, 
.woocommerce-terms-and-conditions-wrapper p .woocommerce-form__label span:after{
	content: "";
    position: absolute;
    top: 45%;
    left: 0px;
    transform: translateY(-50%);
    display: block;
    background-color: transparent;
    box-sizing: content-box;
    border: 1px solid #a1a1a1; 
    height: 10px;
    width: 10px;
    border-radius: 50%; 
	
}  
.woocommerce-shipping-fields .woocommerce-form__label input:checked + span:before, 
.woocommerce-terms-and-conditions-wrapper p .woocommerce-form__label input:checked + span:before{
	border: 1px solid #333;
    background: url(https://www.velolarsson.com/wp-content/uploads/2024/04/dot.png) no-repeat;
    background-position: center;
    background-size: 15px; 
}