<?php
/*
  $Id: checkout_payment.php,v 1.2 2003/09/24 15:34:25 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top_mobile.php');
  require('includes/classes/http_client.php');

// if the customer is not logged on, redirect them to the login page
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
   // tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }
// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    tep_redirect(tep_href_link('shopping_cart_mobile.php'));
  }

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($cart->cartID) && tep_session_is_registered('cartID')) {
    if ($cart->cartID != $cartID) {
      tep_redirect(tep_href_link('checkout_payment_mobile.php', '', 'SSL'));
    }
  }

// if we have been here before and are coming back get rid of the credit covers variable
	if(tep_session_is_registered('credit_covers')) tep_session_unregister('credit_covers');  //ICW ADDED FOR CREDIT CLASS SYSTEM


// Stock Check
  if ( (STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') ) {
    $products = $cart->get_products();
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      if (tep_check_stock($products[$i]['id'], $products[$i]['quantity'])) {
        tep_redirect(tep_href_link('shopping_cart_mobile.php','action=adjust_inventory'));
        break;
      }
    }
  }

// if no shipping destination address was selected, use the customers own address as default
if($_SESSION['cart_address_id']!=''){
	//$_SESSION['customer_default_address_id']=$_SESSION['cart_address_id'];
	$_SESSION['customer_default_shipping_id']=$_SESSION['cart_address_id'];
}
if (!tep_session_is_registered('sendto')) {
    tep_session_register('sendto');
   $customer_default_shipping_id?$sendto = $customer_default_shipping_id:$sendto = $customer_default_address_id;
} else {
// verify the selected shipping address
    $check_address_query = tep_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' and address_book_id = '" . (int)$sendto . "'");
    $check_address = tep_db_fetch_array($check_address_query);
    if ($check_address['total'] != '1') {
      $sendto = $customer_default_address_id;
      if (tep_session_is_registered('shipping')) tep_session_unregister('shipping');
    }
  }

// if no billing destination address was selected, use the customers own address as default

 if (!tep_session_is_registered('billto')) {
    tep_session_register('billto');
    $billto = $customer_default_address_id;
  } else {
// verify the selected billing address
    $check_address_query = tep_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' and address_book_id = '" . (int)$billto . "'");
    $check_address = tep_db_fetch_array($check_address_query);

    if ($check_address['total'] != '1') {
      $billto = $customer_default_address_id;
      if (tep_session_is_registered('payment')) tep_session_unregister('payment');
    }
  }

  require_once(DIR_WS_CLASSES . 'order.php');
  $order = new order;
  require(DIR_WS_CLASSES . 'order_total.php');//ICW ADDED FOR CREDIT CLASS SYSTEM
  $order_total_modules = new order_total;//ICW ADDED FOR CREDIT CLASS SYSTEM



  if (!tep_session_is_registered('comments')) tep_session_register('comments');

  $total_weight = $cart->show_weight();
  $total_count = $cart->count_contents();
  $total_count = $cart->count_contents_virtual(); //ICW ADDED FOR CREDIT CLASS SYSTEM

  if (($order->content_type == 'virtual') || ($order->content_type == 'virtual_weight') ) {
    if (!tep_session_is_registered('shipping')) tep_session_register('shipping');


	$shipping = false;
    $sendto = $customer_default_address_id;
    //tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
  }

  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping;
  if ( defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'true') ) {
    $pass = false;

    switch (MODULE_ORDER_TOTAL_SHIPPING_DESTINATION) {
      case 'national':
        if ($order->delivery['country_id'] == STORE_COUNTRY) {
          $pass = true;
        }
        break;
      case 'international':
        if ($order->delivery['country_id'] != STORE_COUNTRY) {
          $pass = true;
        }
        break;
      case 'both':
        $pass = true;
        break;
    }

    $free_shipping = false;
    if ( ($pass == true) && ($order->info['total'] >= MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER) ) {

$free_shipping = true;

      include(DIR_WS_LANGUAGES . $language . '/modules/order_total/ot_shipping.php');
    }
  } else {
    $free_shipping = false;
  }

//---PayPal WPP Modification START ---//
  if (tep_paypal_wpp_enabled()) {
    $ec_enabled = true;
  } else {
    $ec_enabled = false;
  }

  if ($ec_enabled) {
    if (isset($_GET['ec_cancel']) || (tep_session_is_registered('paypal_ec_token') && !tep_session_is_registered('paypal_ec_payer_id') && !tep_session_is_registered('paypal_ec_payer_info'))) {
      if (tep_session_is_registered('paypal_ec_temp')) tep_session_unregister('paypal_ec_temp');
      if (tep_session_is_registered('paypal_ec_token')) tep_session_unregister('paypal_ec_token');
      if (tep_session_is_registered('paypal_ec_payer_id')) tep_session_unregister('paypal_ec_payer_id');
      if (tep_session_is_registered('paypal_ec_payer_info')) tep_session_unregister('paypal_ec_payer_info');
    }

    $show_payment_page = false;

    $config_query = tep_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_PAYMENT_PAYPAL_DP_DISPLAY_PAYMENT_PAGE' LIMIT 1");
    if (tep_db_num_rows($config_query) > 0) {
      $config_result = tep_db_fetch_array($config_query);
      if ($config_result['configuration_value'] == 'Yes') {
        $show_payment_page = true;
      }
    }
    if (!tep_session_is_registered('payment')) tep_session_register('payment');
      $payment = 'authorizenet';

    $ec_checkout = true;
    if (!tep_session_is_registered('paypal_ec_token') && !tep_session_is_registered('paypal_ec_payer_id') && !tep_session_is_registered('paypal_ec_payer_info')) {
      $ec_checkout = false;
      $show_payment_page = true;
    } else {
      if (!tep_session_is_registered('payment')) tep_session_register('payment');
      $payment = 'paypal_wpp';
    }
  }
//---PayPal WPP Modification END ---//

// get all available shipping quotes
  $quotes = $shipping_modules->quote();
  if($_SESSION['checkout_shipping']!=''){
  	$shipping = $_SESSION['checkout_shipping'];
        if (!tep_session_is_registered('shipping')) tep_session_register('shipping');
        list($module, $method) = explode('_', $shipping);
        if ( is_object($$module) || ($shipping == 'free_free') ) {
          if ($shipping == 'free_free') {
            $quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
            $quote[0]['methods'][0]['cost'] = '0';
          } else {
            $quote = $shipping_modules->quote($method, $module);
          }
          if (isset($quote['error'])) {
            tep_session_unregister('shipping');
          } else {
            if ( (isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost'])) ) {
              $shipping = array('id' => $shipping,
                                'title' => (($free_shipping == true) ?  $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
                                'cost' => $quote[0]['methods'][0]['cost']);
$shipping_cost = $quote[0]['methods'][0]['cost'];
	           }
          }
          $_SESSION['selected_shipping']=$shipping;
          $order->info['shipping_method']=$shipping['title'];
		  $order->info['shipping_cost']=number_format($shipping['cost'],'2');

		  $order->info['total'] = $order->info['subtotal']+$order->info['shipping_cost']+$order->info['tax'];

        }
  }

  // if no shipping method has been selected, automatically select the cheapest method.
// if the modules status was changed when none were available, to save on implementing
// a javascript force-selection method, also automatically select the cheapest shipping
// method if more than one module is now enabled
  if (($order->info['shipping_method']=='' || is_numeric($order->info['shipping_cost'])==false) || !tep_session_is_registered('shipping') || ( tep_session_is_registered('shipping') && ($shipping == false) && (tep_count_shipping_modules() > 1) ) ) $shipping = $shipping_modules->cheapest();
$_SESSION['selected_shipping'] = $shipping;

if($order->info['shipping_method']=='' || is_numeric($order->info['shipping_cost'])==false){
	$order->info['shipping_method']=$shipping['title'];
	$order->info['shipping_cost']=$shipping['cost'];
	$order->info['total'] = $order->info['total']+$order->info['shipping_cost'];

}
$gv_query=tep_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $customer_id . "'");
$acc_gv_amount = 0;
if ($gv_result = tep_db_fetch_array($gv_query)) $acc_gv_amount = $gv_result['amount'];
if($acc_gv_amount > 0){
    tep_session_register('cot_gv');
    $cot_gv = 1;
}
// if ($_SESSION['gv_cc_id'] != '' || (isset($_SESSION['amount_deduced_gv']) && $_SESSION['amount_deduced_gv'] != '') ) $cot_gv = true;
$order_total_modules->pre_confirmation_check();
      $order_total_modules->process();
// load all enabled payment modules
  require(DIR_WS_CLASSES . 'payment_mobile.php');
  $payment_modules = new payment_mobile;

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_PAYMENT);

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));

  $content = 'checkout_payment_mobile';
  $javascript = $content . '.js.php';

  require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/main_page_mobile.tpl.php');

  require(DIR_WS_INCLUDES . 'application_bottom_mobile.php');
?>