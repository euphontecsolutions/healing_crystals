<?php

/*

  $Id: shopping_cart.php,v 1.2 2003/09/24 14:33:16 wilt Exp $



  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com



  Copyright (c) 2003 osCommerce



  Released under the GNU General Public License

  Shoppe Enhancement Controller - Copyright (c) 2003 WebMakers.com

  Linda McGrath - osCommerce@WebMakers.com

*/



  require("includes/application_top_mobile.php");
/*if($_SESSION['app_product']!=''){
    	$get_old_cc_query = tep_db_query("SELECT * FROM `customers_basket` WHERE `customers_id` = '" . $customer_id . "' AND `products_id` LIKE '%" . $_SESSION['app_product'] . "%'");
	$cc_array = tep_db_fetch_array($get_old_cc_query);
	if($cc_array['products_id']){
		
		$slideOneArr=array();
	$slideOneArr['status']='Success';
	$slideOneArr['error']="";
	}else{
	    	$slideOneArr=array();
	$slideOneArr['status']='Error';
	$slideOneArr['error']="Product not available";
	
	}
    echo  json_encode($slideOneArr);die();
}*/
if($_SESSION['checkout']){
	unset($_SESSION['checkout']);
}
if(tep_session_is_registered('is_retail_store') || tep_session_is_registered('retail_rep')){
    if(isset ($_GET['quick_search']) && $_GET['quick_search'] != '' ){
         $atr_str = '';
        $check_model_query = tep_db_query("SELECT * FROM `products_attributes` where products_attributes_model like '" . $_GET['model'] . "' and products_options_sort_order = '" . $_GET['option'] . "' and products_attributes_retail_units > '0' ");
        if(tep_db_num_rows($check_model_query)){
            $error_check = false;
        }else{
            $error_check = true;
        }

        if($error_check == FALSE){
            $p_che=tep_db_fetch_array($check_model_query);
            $_GET['ovid'] = array('1' => $p_che['options_values_id']);
            $_GET['qty'] = 1;
            $cart->add_cart($p_che['products_id'], $cart->get_quantity(tep_get_uprid($p_che['products_id'], $_GET['ovid'])) + $_GET['qty'], $_GET['ovid']);
            $atr_str = 'success';

        }elseif($error_check == true){
            $atr_str = '<td colspan="4"> This product is not avilable for retail store </td>';
        }else{
            $atr_str = '<td colspan="4"> Requested product is not avilable Please check </td>';
        }
        echo $atr_str;
        exit();

    }
}


  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SHOPPING_CART);
  include(DIR_WS_LANGUAGES . $language . '/modules/order_total/ot_gv.php');
  include(DIR_WS_MODULES . 'order_total/ot_gv.php');
  include(DIR_WS_LANGUAGES . $language . '/modules/order_total/ot_coupon.php');
  include(DIR_WS_MODULES . 'order_total/ot_coupon.php');

  if (!tep_session_is_registered('customer_id')) {

    $navigation->set_snapshot();

  }



  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SHOPPING_CART));

// BOF: WebMakers.com Added: Attributes Sorter and Copier and Quantity Controller

// Validate Cart for checkout

  $valid_to_checkout= true;
$showAdjustmentMsg ='0';
  $cart->get_products(true);
  	$adjustmentMsg = '
We have adjusted your order to reflect our available inventory: ';
if($HTTP_GET_VARS['action']=='adjust_inventory'){
	$products = $cart->get_products();

    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
    	
      if (tep_check_stock($products[$i]['id'], $products[$i]['quantity'])) {
      		$adjustmentMsg.='<br>'.$products[$i]['model'].' '.$products[$i]['name']. ' '. tep_get_products_stock($products[$i]['id']) .' Units available. ';
      		$showAdjustmentMsg='1';
	      $cart->update_quantity($products[$i]['id'],tep_get_products_stock($products[$i]['id']),$products[$i]['attributes']);
    	  
      }
    }   
   
}

  if (!$valid_to_checkout) {

//    $messageStack->add_session('header', 'Please update your order ...', 'error');

//    tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));

  }

// EOF: WebMakers.com Added: Attributes Sorter and Copier and Quantity Controller

tep_session_register('cc_id');
if(tep_session_is_registered('customer_id')){
	$get_old_cc_query = tep_db_query("select basket_cc_id from customers_basket where customers_id = '".$customer_id."'");
	$cc_array = tep_db_fetch_array($get_old_cc_query);
	if($cc_array['basket_cc_id'] > 0){
		$cc_id = $cc_array['basket_cc_id'];
	}
}
if(isset($_GET['tep_cart_check'])){
	$cart->tep_cart_check_process($_GET);
    die;
}
  if ($HTTP_POST_VARS['gv_redeem_code']) {
  
  	//// Sumit Code to check coupon code generator id and afliated id is same or not START
    $affiliate_id3 = "SELECT `affiliate_id` FROM `".TABLE_COUPONS."` WHERE `coupon_code` = '".$HTTP_POST_VARS['gv_redeem_code']."'";
	$affiliate_id2 = mysql_query($affiliate_id3);
	$affiliate_idd = mysql_fetch_object($affiliate_id2);
	$affiliate_ied = $affiliate_idd->affiliate_id;
	if($customer_id!=$affiliate_ied): 
	//// Sumit Code to check coupon code generator id and afliated id is same or not END
  
$coupon_query = tep_db_query("select coupon_type from coupons where coupon_code = '".$HTTP_POST_VARS['gv_redeem_code']."' ");
$coupon_array = tep_db_fetch_array($coupon_query);
$coupon_amount = '';
if($coupon_array['coupon_type'] == 'G'){
$class = 'ot_gv';
}else{
$class = 'ot_coupon';
}
$GLOBALS[$class] = new $class;
   // print_r($_POST);
   
$GLOBALS[$class]->collect_posts('shopping_cart_mobile.php');
	//SUMIT START
		endif;
	//SUMIT END
  }
 
/*

if ($HTTP_POST_VARS['gv_redeem_code'] || $cc_id) {
// get some info from the coupon table
if (!isset($HTTP_POST_VARS['gv_redeem_code'])) {
       $coupon_query=tep_db_query("select coupon_code from " . TABLE_COUPONS . " where coupon_id='".$cc_id."' and coupon_active='Y'");
       $coupon_result=tep_db_fetch_array($coupon_query);
       $HTTP_POST_VARS['gv_redeem_code'] = $coupon_result['coupon_code'];
       }
	$coupon_query=tep_db_query("select coupon_id, coupon_amount, coupon_code, coupon_type, coupon_minimum_order,uses_per_coupon, uses_per_user, restrict_to_products,restrict_to_categories from " . TABLE_COUPONS . " where coupon_code='".$HTTP_POST_VARS['gv_redeem_code']."' and coupon_active='Y'");
	$coupon_result=tep_db_fetch_array($coupon_query);

	if ($coupon_result['coupon_type'] != 'G') {
$cc_code = $HTTP_POST_VARS['gv_redeem_code'];
tep_session_register('cc_code');
		if (tep_db_num_rows($coupon_query)==0) {
			tep_redirect(tep_href_link(FILENAME_SHOPPING_CART, 'coupon_error=ot_coupon&error=' . urlencode(ERROR_NO_INVALID_REDEEM_COUPON), 'SSL'));
		}

		$date_query=tep_db_query("select coupon_start_date from " . TABLE_COUPONS . " where coupon_start_date <= now() and coupon_code='".$cc_code."'");

		if (tep_db_num_rows($date_query)==0) {
			tep_redirect(tep_href_link(FILENAME_SHOPPING_CART, 'coupon_error=ot_coupon&error=' . urlencode(ERROR_INVALID_STARTDATE_COUPON), 'SSL'));
		}

		$date_query=tep_db_query("select coupon_expire_date from " . TABLE_COUPONS . " where coupon_expire_date >= now() and coupon_code='".$cc_code."'");

    if (tep_db_num_rows($date_query)==0) {
			tep_redirect(tep_href_link(FILENAME_SHOPPING_CART, 'coupon_error=ot_coupon&error=' . urlencode(ERROR_INVALID_FINISDATE_COUPON), 'SSL'));
		}

		if (tep_session_is_registered('customer_id')) {
		$coupon_count = tep_db_query("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $coupon_result['coupon_id']."'");
		$coupon_count_customer = tep_db_query("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $coupon_result['coupon_id']."' and customer_id = '" . $customer_id . "'");

		if (tep_db_num_rows($coupon_count)>=$coupon_result['uses_per_coupon'] && $coupon_result['uses_per_coupon'] > 0) {
			tep_redirect(tep_href_link(FILENAME_SHOPPING_CART, 'coupon_error='.$this->code.'&error=' . urlencode(ERROR_INVALID_USES_COUPON . $coupon_result['uses_per_coupon'] . TIMES ), 'SSL'));
		  }
		

		if (tep_db_num_rows($coupon_count_customer)>=$coupon_result['uses_per_user'] && $coupon_result['uses_per_user'] > 0) {
			tep_redirect(tep_href_link(FILENAME_SHOPPING_CART, 'coupon_error=ot_coupon&error=' . urlencode(ERROR_INVALID_USES_USER_COUPON . $coupon_result['uses_per_user'] . TIMES ), 'SSL'));
		  }
		}
		if ($coupon_result['coupon_type']=='S') {
			$cc_coupon_amount = 'Free Shipping ';
		} else {
			$cc_coupon_amount = $currencies->format($coupon_result['coupon_amount']) . ' OFF ';
		}
		if ($coupon_result['coupon_type']=='P') $cc_coupon_amount = (int)$coupon_result['coupon_amount'] . '% OFF ';
		if ($coupon_result['coupon_type']=='C') {
			$cc_coupon_amount = 'Free Shipping + '. $coupon_result['coupon_amount'] . '% OFF ';
		}
		if ($coupon_result['coupon_minimum_order']>0) $cc_coupon_amount .= 'on orders greater than ' . $coupon_result['coupon_minimum_order'];
		if (!tep_session_is_registered('cc_id')) tep_session_register('cc_id'); //Fred - this was commented out before
		$cc_id = $coupon_result['coupon_id']; //Fred ADDED, set the global and session variable
		$cc_coupon_amount = $cc_code . ' - '  . $cc_coupon_amount;
		tep_session_register('cc_coupon_amount');
		//tep_redirect(tep_href_link(FILENAME_SHOPPING_CART, 'error='.$this->code.'&error=' . urlencode(ERROR_REDEEMED_AMOUNT), 'SSL')); // Added in v5.13a by Rigadin
		// $_SESSION['cc_id'] = $coupon_result['coupon_id']; //Fred commented out, do not use $_SESSION[] due to backward comp. Reference the global var instead.
	  }elseif($coupon_result['coupon_type'] == 'G'){
	  	$gv_code = $HTTP_POST_VARS['gv_redeem_code'];
tep_session_register('gv_code');	    
	      if (tep_session_is_registered('customer_id')) {
		$gv_coupon_count = tep_db_query("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $coupon_result['coupon_id']."'");
		$gv_coupon_count_customer = tep_db_query("select coupon_id from " . TABLE_COUPON_REDEEM_TRACK . " where coupon_id = '" . $coupon_result['coupon_id']."' and customer_id = '" . $customer_id . "'");

		if (tep_db_num_rows($gv_coupon_count)>=$coupon_result['uses_per_coupon'] && $coupon_result['uses_per_coupon'] > 0) {
			tep_redirect(tep_href_link(FILENAME_SHOPPING_CART, 'coupon_error='.$this->code.'&error=' . urlencode(ERROR_INVALID_USES_COUPON . $coupon_result['uses_per_coupon'] . TIMES ), 'SSL'));
		  }

		if (tep_db_num_rows($gv_coupon_count_customer)>=$coupon_result['uses_per_user'] && $coupon_result['uses_per_user'] > 0) {
			tep_redirect(tep_href_link(FILENAME_SHOPPING_CART, 'coupon_error=ot_coupon&error=' . urlencode(ERROR_INVALID_USES_USER_COUPON . $coupon_result['uses_per_user'] . TIMES ), 'SSL'));
		  }
$cot_gv = true;
    tep_gv_account_update($customer_id, $gv_id);
		}
		if ($coupon_result['coupon_type']=='S') {
			$gv_coupon_amount = 'Free Shipping ';
		} else {
			$gv_coupon_amount = $currencies->format($coupon_result['coupon_amount']) . ' OFF ';
		}
		if ($coupon_result['coupon_type']=='P') $gv_coupon_amount = (int)$coupon_result['coupon_amount'] . '% OFF ';
	  if ($coupon_result['coupon_type']=='C') {
			$gv_coupon_amount = 'Free Shipping + '. $coupon_result['coupon_amount'] . '% OFF ';
		}
		if ($coupon_result['coupon_minimum_order']>0) $gv_coupon_amount .= 'on orders greater than ' . $coupon_result['coupon_minimum_order'];
		if (!tep_session_is_registered('gv_cc_id')) tep_session_register('gv_cc_id'); 
		$gv_cc_id = $coupon_result['coupon_id']; 
		$gv_coupon_amount = $gv_code . ' - '  . $gv_coupon_amount;
		tep_session_register('gv_coupon_amount');
	  }
	} // ENDIF code entered*/
	// v5.13a If no code entered and coupon redeem button pressed, give an alarm
//print_r($_SESSION);
  $content = 'shopping_cart_mobile';



  require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);



  require(DIR_WS_INCLUDES . 'application_bottom_mobile.php');

?>