<?php

/*

  $Id: checkout_process.php,v 1.2 2003/09/24 15:34:25 wilt Exp $



  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com



  Copyright (c) 2003 osCommerce



  Released under the GNU General Public License

*/



  include('includes/application_top.php');
function convert_weight_to_lbs($weight) {
	$weight = number_format(((0.1 / 45.4) * $weight),3,'.',',');
	return $weight;
}

function convert_weight_to_gms($weight) {
	$weight = round((45.4 / 0.1) * $weight);
	return (int)$weight;
}
  require('includes/classes/http_client.php');



// if the customer is not logged on, redirect them to the login page

  if (!tep_session_is_registered('customer_id')) {

    $navigation->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_PAYMENT));

    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));

  }
 
if(($_SESSION['shipping']['cost']=='' || $_SESSION['shipping']['cost']=='0') && (stripos($_SESSION['shipping']['title'],'free')===false && stripos($_SESSION['shipping']['title'],'Pickup')===false))tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'shipping method not selected', 'SSL'));


  if (!tep_session_is_registered('sendto')) {

    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'shipping address is not defined', 'SSL'));

  }



  if ( (tep_not_null(MODULE_PAYMENT_INSTALLED)) && (!tep_session_is_registered('payment')) && ($payment != '')) {

    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'Please select payment method (error)', 'SSL'));

 }

if(isset($_GET['tep_cart_check'])){
  $cart->tep_cart_check_process($_GET);
    die;
}

// avoid hack attempts during the checkout procedure by checking the internal cartID

  if (isset($cart->cartID) && tep_session_is_registered('cartID')) {

    if ($cart->cartID != $cartID) {

      tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));

    }

  }



  include(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_PROCESS);

 require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ORDERS_PRINTABLE);



// load selected payment module

  require(DIR_WS_CLASSES . 'payment.php');

  if ($credit_covers) $payment=''; //ICW added for CREDIT CLASS

  $payment_modules = new payment($payment);




  if ($payment == 'paypal_wpp') {

   $selected_module = $payment;

  $GLOBALS[$selected_module]->enabled = true;

  $GLOBALS['payment_info'] = "Credit Card (Processed by PWPP)";

  };



// load the selected shipping module

  require(DIR_WS_CLASSES . 'shipping.php');

  $shipping_modules = new shipping($shipping);



  require(DIR_WS_CLASSES . 'order.php');

  $order = new order;



// load the before_process function from the payment modules

  //$payment_modules->before_process();



  require(DIR_WS_CLASSES . 'order_total.php');

  $order_total_modules = new order_total;



  $order_totals = $order_total_modules->process();



 	 if ($payment == 'authorizenet' || $payment == 'paypal_wpp') {

   	//$status = '2';
	$status = '100004';

   	$customer_notification = '1';

   } else {

  	$status = $order->info['order_status'];

   	$customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';

   }


   if (tep_session_is_registered('noaccount')) {

	 	$purchased_without_account ='1';

	 } else {

	 	$purchased_without_account = '0';

	 }


  // load the before_process function from the payment modules

  //$payment_modules->before_process();





  //************************************************************

  // Authorizenet ADC Direct Connection

  // Make sure the /catalog/includes/class/order.php is included

  // and $order object is created before this!!!

  if(MODULE_PAYMENT_AUTHORIZENET_STATUS) {

   //include(DIR_WS_MODULES . 'authorizenet_direct.php');

  }

  //************************************************************
//Fetch the last declined order

/*$old_declined_order_query = tep_db_query("select orders_id from orders where orders_status = '100003' and date_purchased >= '".date('Y-m-d H:i:s', strtotime('-15 minutes'))."' and customers_id = '".$customer_id."' and payment_info = '".$GLOBALS['payment_info']."' order by date_purchased DESC limit 1");
if(tep_db_num_rows($old_declined_order_query)){
    $old_declined_order = tep_db_fetch_array($old_declined_order_query);
    $declined_order = new order($old_declined_order['orders_id']);   
    $block_order= false;
    $check_keys_array = array('cc_type','cc_owner','cc_number','cc_expires');
    foreach($check_keys_array as $key){
        //echo $key.'  -->  ' . $order->info[$key] .' == ' .$declined_order->info[$key].'<br>';
        if($order->info[$key] == $declined_order->info[$key]){
            $block_order = true;
        }else{
            $block_order = false;
            break;
        }
    }    
    if($block_order==true) {
        $email_text = 'Following Order was declined but customer tried checking out again using same Card Information within fiteen minutes of this order. Please manually check the order<br><a href="'.tep_href_link('hcmin/orders.php','action=edit&oID='.$old_declined_order['orders_id']).'">'.$old_declined_order['orders_id'].'</a>';
        tep_mail('', 'contact@healingcrystals.com', 'Declined Order', $email_text, '', STORE_OWNER_EMAIL_ADDRESS);
        tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error=temp_order_blocked', 'SSL'));
    }
}*/


// BOF: WebMakers.com Added: Downloads Controller
 $telephone_query= tep_db_query("select customers_telephone from customers where customers_id = '".$customer_id."'");
 $telephone_array = tep_db_fetch_array($telephone_query);
 if($telephone_array['customers_telephone'] == '' || $telephone_array['customers_telephone'] != $_SESSION['telephone']){
     tep_db_query("update customers set customers_telephone = '".(tep_session_is_registered('telephone')?$_SESSION['telephone']:$order->customer['telephone'])."' where customers_id = '".$customer_id."' ");
 }

  $sql_data_array = array('customers_id' => $customer_id,

                          'customers_name' => (tep_session_is_registered('retail_rep') && $_SESSION['retail_rep']!='' ? $_SESSION['retail_cust_fname'].' '.$_SESSION['retail_cust_lname']:$order->customer['firstname'] . ' ' . $order->customer['lastname']),

                          'customers_company' => $order->customer['company'],

                          'customers_street_address' => $order->customer['street_address'],

                          'customers_suburb' => $order->customer['suburb'],

                          'customers_city' => $order->customer['city'],

                          'customers_postcode' => $order->customer['postcode'],

                          'customers_state' => $order->customer['state'],

                          'customers_country' => $order->customer['country']['title'],

                          'customers_telephone' => (tep_session_is_registered('telephone')?$_SESSION['telephone']:$order->customer['telephone']),

                          'customers_email_address' => (tep_session_is_registered('retail_rep') && $_SESSION['retail_rep']!='' && $_SESSION['retail_cust_email']!='' ? $_SESSION['retail_cust_email']:$order->customer['email_address']),

                          'customers_address_format_id' => $order->customer['format_id'],

                          'delivery_name' => $order->delivery['firstname'] . ' ' . $order->delivery['lastname'],

                          'delivery_company' => $order->delivery['company'],

                          'delivery_street_address' => $order->delivery['street_address'],

                          'delivery_suburb' => $order->delivery['suburb'],

                          'delivery_city' => $order->delivery['city'],

                          'delivery_postcode' => $order->delivery['postcode'],

                          'delivery_state' => $order->delivery['state'],

                          'delivery_country' => $order->delivery['country']['title'],

                          'delivery_address_format_id' => $order->delivery['format_id'],

                          'billing_name' => $order->billing['firstname'] . ' ' . $order->billing['lastname'],

                          'billing_company' => $order->billing['company'],

                          'billing_street_address' => $order->billing['street_address'],

                          'billing_suburb' => $order->billing['suburb'],

                          'billing_city' => $order->billing['city'],

                          'billing_postcode' => $order->billing['postcode'],

                          'billing_state' => $order->billing['state'],

                          'billing_country' => $order->billing['country']['title'],

                          'billing_address_format_id' => $order->billing['format_id'],

                          'payment_method' => $order->info['payment_method'],

// BOF: Lango Added for print order mod

                          'payment_info' => $GLOBALS['payment_info'],

// EOF: Lango Added for print order mod

                         // 'cc_type' => $order->info['cc_type'],

                         // 'cc_owner' => $order->info['cc_owner'],

                          //'cc_number' => $order->info['cc_number'],

                          //'cc_expires' => $order->info['cc_expires'],

                          //'cc_cvn' => $order->info['cc_cvn'],

                          'date_purchased' => EST_TIME_NOW,

                          'last_modified' => EST_TIME_NOW,

                          'orders_status' => $status,

                          'currency' => $order->info['currency'],

                          'currency_value' => $order->info['currency_value'],

			  'purchased_without_account' => $purchased_without_account,
  			  
                          'ip_address' => $_SERVER['REMOTE_ADDR'],
      
                          'order_from_retail' => (tep_session_is_registered('retail_rep') && $_SESSION['retail_rep']!='' ? '1':'0'));

  $order_blacklisting=false;
    if($sql_data_array['customers_name'] == '' || $sql_data_array['billing_street_address'] == ''|| $sql_data_array['delivery_street_address'] == '')$order_blacklisting=true;
 if($order->info['comments']!=''){$sendCommentsEmailToKayako = true;$kayakoComments = $order->info['comments'];}
// EOF: WebMakers.com Added: Downloads Controller
/*if( $order->info['cc_number'] != ''){
   	$cc_number = $order->info['cc_number'];
   	$cc_cvn = $order->info['cc_cvn'];
   	$cc_expires = $order->info['cc_expires'];
   	$encrypted_cc_number = gpg_encrypt("${cc_number}", '/usr/bin/gpg' , '/home/healingc/.gnupg', '91C8FD42');;
   	$encrypted_cc_cvn = gpg_encrypt("${cc_cvn}", '/usr/bin/gpg' , '/home/healingc/.gnupg', '91C8FD42');;
   	$encrypted_cc_expires =gpg_encrypt("${cc_expires}", '/usr/bin/gpg' , '/home/healingc/.gnupg', '91C8FD42');;
	$sql_data_array ['encrypted_cc_number'] = $encrypted_cc_number[0];
        $sql_data_array ['encrypted_cc_expires'] = $encrypted_cc_expires[0];
        $sql_data_array ['encrypted_cc_cvn'] = $encrypted_cc_cvn[0];
        //$update_query = tep_db_query("update orders set encrypted_cc_number = '".$encrypted_cc_number[0]."', encrypted_cc_expires = '".$encrypted_cc_expires[0]."', encrypted_cc_cvn = '".$encrypted_cc_cvn[0]."' where orders_id = '".$HTTP_GET_VARS['order_id']."' ");
	//Remove CC info for this order from orders Table
	//$clear_cc_query = tep_db_query("update orders set cc_number = ' ', cc_expires = ' ', cc_cvn = ' ' where orders_id = '".$HTTP_GET_VARS['order_id']."' ");	
}*/
  tep_db_perform(TABLE_ORDERS, $sql_data_array);

  $insert_id = tep_db_insert_id();
if(tep_session_is_registered('retail_rep') && $_SESSION['retail_rep']!=''){
    $sql_data_array = array('orders_id' => $insert_id,
                            'customer_first_name' => $_SESSION['retail_cust_fname'],
                            'customer_last_name' => $_SESSION['retail_cust_lname'],
                            'customer_email_id' => $_SESSION['retail_cust_email'],
                            'customer_post_code' => $_SESSION['retail_cust_postcode']);
    tep_db_perform('orders_to_retail_customers', $sql_data_array);
}
  for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {

    $sql_data_array = array('orders_id' => $insert_id,

                            'title' => $order_totals[$i]['title'],

                            'text' => $order_totals[$i]['text'],

                            'value' => $order_totals[$i]['value'],

                            'class' => $order_totals[$i]['code'],

                            'sort_order' => $order_totals[$i]['sort_order']);

    tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

  }



  //$customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';

  $sql_data_array = array('orders_id' => $insert_id,

                          'orders_status_id' => $status,

                          'date_added' => EST_TIME_NOW,

                          'customer_notified' => $customer_notification,

                          'comments' => $order->info['comments']);

  tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);


$giftVoucherLink = '';
  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {

// Stock Update - Joao Correia

    if (STOCK_LIMITED == 'true') {

      if (DOWNLOAD_ENABLED == 'true') {

        $stock_query_raw = "SELECT products_quantity, pad.products_attributes_filename

                            FROM " . TABLE_PRODUCTS . " p

                            LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES . " pa

                             ON p.products_id=pa.products_id

                            LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad

                             ON pa.products_attributes_id=pad.products_attributes_id

                            WHERE p.products_id = '" . tep_get_prid($order->products[$i]['id']) . "'";

// Will work with only one option for downloadable products

// otherwise, we have to build the query dynamically with a loop

        $products_attributes = $order->products[$i]['attributes'];

        if (is_array($products_attributes)) {

          $stock_query_raw .= " AND pa.options_id = '" . $products_attributes[0]['option_id'] . "' AND pa.options_values_id = '" . $products_attributes[0]['value_id'] . "'";

        }

        $stock_query = tep_db_query($stock_query_raw);

      } else {

        $stock_query = tep_db_query("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");

      }

    }


    //Add Cost to Products
    $cost = '';
    $products_id_array = explode('{', $order->products[$i]['id']);
    $options_id_array = explode('}', $products_id_array[1]);
    $cost_query = tep_db_query("select cost, products_attributes_weight from products_attributes where products_id = '" . tep_get_prid($order->products[$i]['id']) . "' and options_id = '" .$options_id_array[0] . "' and options_values_id = '" . $options_id_array[1] . "'");
    $cost_array = tep_db_fetch_array($cost_query);
    $linked_products_options_cost_query = tep_db_query("select cost, linked_options_quantity from products_attributes pa, linked_products_options l where l.child_products_id = pa.products_id and l.child_options_id = pa.options_id and l.child_options_values_id = pa.options_values_id and parent_products_id = '" . tep_get_prid($order->products[$i]['id']) . "' and parent_options_values_id = '" . $options_id_array[1] . "' and parent_options_id = '" . $options_id_array[0] . "'");
    while($linked_products_options_cost = tep_db_fetch_array($linked_products_options_cost_query)){
    	$cost_array['cost'] += $linked_products_options_cost['cost'];
    }
    if ($cost_array['cost'] > 0) {
        $cost = ($cost_array['cost']);
    } 
    /*else {
        $products_query_raw = "select p.products_id, p.products_model, p.products_cost, p.products_cost_manual, product_unit from products p where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'";
        $products_query = tep_db_query($products_query_raw);
        $products = tep_db_fetch_array($products_query);
        $costQuery = tep_db_query("select pid.total_cost_unit, pid.unit_cost from purchase_invoices pi, purchase_invoices_details pid, purchase_invoices_linked_products  pilp where pi.invoice_id = pid.invoice_id and pilp.purchase_invoices_details_id = pid.purchase_invoices_details_id and pilp.model = '" . $entry['products_model'] . "' order by pi.invoice_date DESC limit 1");
        $costArray = tep_db_fetch_array($costQuery);
        if ($costArray['unit_cost'] > '0') {
            $unit = (string) $costArray['total_cost_unit'];
            $unitPrice = (float) $costArray['unit_cost'];
        } else {
            $unit = $products['product_unit'];
            $unitPrice = $products['products_cost_manual'] != '' && $products['products_cost_manual'] > 0 ? $products['products_cost_manual'] : $products['products_cost'];
        }
        switch ($unit) {
            case 'Pc.':
            case 'pc.':
                //$value = $products['products_cost_manual']!='' && $products['products_cost_manual'] > 0 ? $products['products_cost_manual']:$products['products_cost'];
                $value = $unitPrice;
                $name = 'per piece';
                break;
            case 'kg.':
            case 'Kg.':
                //$value = (($products['products_cost_manual']!='' && $products['products_cost_manual'] > 0) ? $products['products_cost_manual'] : $products['products_cost']);
                $value = $unitPrice;
                $name = 'per kilo';
                break;
            case 'Gr.':
                $value = ($unitPrice * 1000);
                $name = 'per kilo';
                break;
            case 'Lb.':
            case 'Lb':
            case 'lb.':
                //$value = ($unitPrice/0.454);
                $value = ($unitPrice / 0.454);
                //$name = 'per pound';
                $name = 'per kilo';
                break;
            case 'Oz.':
                $value = ($unitPrice * 0.02835);
                $name = 'per kilo';
                break;
            case 'Ct.':
                $value = ($unitPrice * 0.0002);
                $name = 'per kilo';
                break;
            default:
                $value = $unitPrice;
                $name = 'per piece';
                break;
        }
        if ($name == 'per piece') {
            $cost_unit = $value;
        } elseif ($name == 'per kilo') {
            $cost_unit = ($value * convert_weight_to_gms($cost_array['products_attributes_weight']) / 1000);
        }
        $cost = $cost_unit;
    } */
    $sql_data_array = array('orders_id' => $insert_id,
                            'products_id' => tep_get_prid($order->products[$i]['id']),
                            'products_model' => $order->products[$i]['model'],
                            'products_name' => $order->products[$i]['name'],
                            'products_price' => $order->products[$i]['price'],
                            'final_price' => $order->products[$i]['final_price'],
                            'products_tax' => $order->products[$i]['tax'],
                            'products_quantity' => $order->products[$i]['qty'],
                            'uprid' => normalize_id($order->products[$i]['id']),
                            'order_cost'=>(round($cost,2)*$order->products[$i]['qty']),
                            'sort_order'=>($order->products[$i]['model'] == 'GIFTRAP' || tep_get_prid($order->products[$i]['id']) == '3093' ? '1':($order->products[$i]['model'] == 'LABEL' || tep_get_prid($order->products[$i]['id']) == '3094' ? '2' : '3')));
if(stripos($order->products[$i]['model'],'GIFT')!==false)$giftVoucherLink='<a href="'.  tep_href_link('voucherImage.php','oID='.$insert_id).'" target="_blank">View and Print your Gift Voucher </a>';

    tep_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);

    $order_products_id = tep_db_insert_id();
    //Linked Products Options
    $linked_options = false;
    $linked_products_options_query = tep_db_query("select products_attributes_name, products_attributes_id, products_id, options_id, options_values_id, products_attributes_units, products_attributes_retail_units, cost, linked_options_quantity from products_attributes pa, linked_products_options l where l.child_products_id = pa.products_id and l.child_options_id = pa.options_id and l.child_options_values_id = pa.options_values_id and parent_products_id = '" . $order->products[$i]['id'] . "' and parent_options_values_id = '" . $options_id_array[1] . "' and parent_options_id = '" . $options_id_array[0] . "'");
    if(tep_db_num_rows($linked_products_options_query)){
    	$linked_options = true;
    	while($linked_products_options = tep_db_fetch_array($linked_products_options_query)){
    		$data_array = array('orders_products_id'=>$order_products_id,'linked_products_id'=>$linked_products_options['products_id'],'linked_options_id'=>$linked_products_options['options_id'],'linked_options_values_id'=>$linked_products_options['options_values_id'], 'linked_options_cost'=>$linked_products_options['cost']);
    		tep_db_perform('orders_linked_products_options', $data_array);
    		tep_db_query("update  ".TABLE_PRODUCTS_ATTRIBUTES . " set ".(tep_session_is_registered('retail_rep') && $_SESSION['retail_rep']!=''? 'products_attributes_retail_units = products_attributes_retail_units -'.($order->products[$i]['qty']*$linked_products_options['linked_options_quantity']):'products_attributes_units = products_attributes_units - '.($order->products[$i]['qty']*$linked_products_options['linked_options_quantity'])).", date_last_purchased = '" . EST_TIME_NOW . "' where products_id = '".(int)$linked_products_options['products_id']."' and options_values_id  = '".$linked_products_options['options_values_id']."'");
    		tep_db_query("update " . TABLE_PRODUCTS . " set products_ordered = products_ordered + " . sprintf('%d', ($order->products[$i]['qty']*$linked_products_options['linked_options_quantity'])) . " where products_id = '" . $linked_products_options['products_id'] . "'");
    		tep_db_query("update products_attributes set options_units_sold = options_units_sold+ " . sprintf('%d', ($order->products[$i]['qty']*$linked_products_options['linked_options_quantity'])) . " where products_id = '" . $linked_products_options['products_id'] . "' AND options_id = '" . $linked_products_options['options_id'] . "' AND options_values_id = '" . $linked_products_options['options_values_id'] . "'");
    		tep_db_query("INSERT INTO `inventory_log` (`log_id`, `products_id`, `products_attributes_id`, orders_id, `units_count`, `units_changed`, `change_date`, `adjustment_type`,products_attributes_name) VALUES ('', '".$linked_products_options['products_id']."', '" . $linked_products_options['products_attributes_id'] . "', '".$insert_id."', '" . (tep_session_is_registered('retail_rep') && $_SESSION['retail_rep']!=''?$linked_products_options['products_attributes_retail_units']:$linked_products_options['products_attributes_units']) . "', '-".($order->products[$i]['qty']*$linked_products_options['linked_options_quantity'])."', now(), ".(tep_session_is_registered('retail_rep') && $_SESSION['retail_rep']!=''?"'Retail Order'":"'Order'").",'".addslashes($linked_products_options['products_attributes_name'])."')");
        }
    }
   // $order_total_modules->update_credit_account($i);//ICW ADDED FOR CREDIT CLASS SYSTEM

//------insert customer choosen option to order--------

    $attributes_exist = '0';

    $products_ordered_attributes = '';

    if (isset($order->products[$i]['attributes'])) {

      $attributes_exist = '1';

      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {

        if (DOWNLOAD_ENABLED == 'true') {

          $attributes_query = "select popt.products_options_name, poval.products_options_values_name, pa.products_attributes_name, pa.products_attributes_id, pa.products_attributes_units, pa.products_attributes_retail_units, pa.only_linked_options, pa.options_values_price, pa.price_prefix, pa.products_attributes_special_price, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename

                               from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa

                               left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad

                                on pa.products_attributes_id=pad.products_attributes_id

                               where pa.products_id = '" . $order->products[$i]['id'] . "'

                                and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'

                                and pa.options_id = popt.products_options_id

                                and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'

                                and pa.options_values_id = poval.products_options_values_id

                                and popt.language_id = '" . $languages_id . "'

                                and poval.language_id = '" . $languages_id . "'";

          $attributes = tep_db_query($attributes_query);

        } else {

          $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.products_attributes_name, pa.products_attributes_id, pa.products_attributes_units, pa.products_attributes_retail_units, pa.only_linked_options, pa.options_values_price, pa.price_prefix, pa.products_attributes_special_price, pa.only_linked_options from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $languages_id . "' and poval.language_id = '" . $languages_id . "'");

        }

        $attributes_values = tep_db_fetch_array($attributes);


		///quantity based discount starts
		$attribute_price = $order->products[$i]['quantity_dis_price'];
		if($order->products[$i]['quantity_dis_price'] != $attributes_values['options_values_price']){
			$attribute_spl_price = $order->products[$i]['final_price'];			
		}elseif(($order->products[$i]['quantity_dis_price'] == $attributes_values['options_values_price']) && $attributes_values['products_attributes_special_price'] != $order->products[$i]['final_price']){
			$attribute_spl_price = 0.00;
		}else{
			$attribute_spl_price = $attributes_values['products_attributes_special_price'];
		}                
            $sql_data_array = array('orders_id' => $insert_id,
                                    'orders_products_id' => $order_products_id,
                                    'products_options' => $attributes_values['products_options_name'],
                                    'products_options_values' => $attributes_values['products_attributes_name'],
                                    'options_values_price' => $attribute_price,
                                    'options_values_special_price' => $attribute_spl_price,
                                    'price_prefix' => $attributes_values['price_prefix'],
                                    'options_cost'=>round($cost, 2));	
        tep_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);
        if ((DOWNLOAD_ENABLED == 'true') && isset($attributes_values['products_attributes_filename']) && tep_not_null($attributes_values['products_attributes_filename'])) {
            if($attributes_values['products_attributes_maxcount']=='0')$attributes_values['products_attributes_maxcount']= DOWNLOAD_MAX_COUNT;
          $sql_data_array = array('orders_id' => $insert_id,
                                  'orders_products_id' => $order_products_id,
                                  'orders_products_filename' => $attributes_values['products_attributes_filename'],
                                  'download_maxdays' => $attributes_values['products_attributes_maxdays'],
                                  'download_count' => $attributes_values['products_attributes_maxcount']);
          tep_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
        }
        $products_ordered_attributes .= "<br/>" . $attributes_values['products_options_name'] . ' ' . $attributes_values['products_attributes_name'];
      }
    }
    if(!empty($HTTP_SESSION_VARS['cwa_id']) && in_array($order->products[$i]['id'], $HTTP_SESSION_VARS['cwa_id'])){
            $key_loc = array_search($order->products[$i]['id'], $HTTP_SESSION_VARS['cwa_id']);
            if (tep_not_null($HTTP_SESSION_VARS['cwa_id'][$key_loc])) {	  
              tep_db_query("update customers_wishlist_attributes set shared_purchase='1', shared_purchase_qty='" . $order->products[$i]['qty'] . "', shared_purchase_orders_id='" . $insert_id . "' where customers_wishlist_attributes_id = '" . $key_loc . "'");
            }
    }
  }
  // load the before_process function from the payment modules
  $payment_modules->before_process();
 for ($i=0,$j=1, $n=sizeof($order->products); $i<$n; $i++) {
// Stock Update - Joao Correia
    if (STOCK_LIMITED == 'true') {
      if (DOWNLOAD_ENABLED == 'true') {
        $stock_query_raw = "SELECT products_quantity, pad.products_attributes_filename
                            FROM " . TABLE_PRODUCTS . " p
                            LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                             ON p.products_id=pa.products_id
                            LEFT JOIN " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                             ON pa.products_attributes_id=pad.products_attributes_id
                            WHERE p.products_id = '" . tep_get_prid($order->products[$i]['id']) . "'";
// Will work with only one option for downloadable products
// otherwise, we have to build the query dynamically with a loop
        $products_attributes = $order->products[$i]['attributes'];
        if (is_array($products_attributes)) {
          $stock_query_raw .= " AND pa.options_id = '" . $products_attributes[0]['option_id'] . "' AND pa.options_values_id = '" . $products_attributes[0]['value_id'] . "'";
        }
        $stock_query = tep_db_query($stock_query_raw);
      } else {
        $stock_query = tep_db_query("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");

      }
    }
$order_total_modules->update_credit_account($i);//ICW ADDED FOR CREDIT CLASS SYSTEM
// Update products_ordered (for bestsellers list)
tep_db_query("update " . TABLE_PRODUCTS . " set products_ordered = products_ordered + " . sprintf('%d', $order->products[$i]['qty']) . " where products_id = '" . tep_get_prid($order->products[$i]['id']) . "'");
tep_db_query("update products_attributes set options_units_sold = options_units_sold+ " . sprintf('%d', $order->products[$i]['qty']) . " where products_id = '" . tep_get_prid($order->products[$i]['id']) . "' AND options_id = '" . $products_attributes[0]['option_id'] . "' AND options_values_id = '" . $products_attributes[0]['value_id'] . "'");
$inventoryCommentCheckQuery = tep_db_query("select count(*) as total from orders_status_history where orders_id = '".$insert_id."' and comments like 'Inventory taken out of stock'");
$inventoryCommentCheck = tep_db_fetch_array($inventoryCommentCheckQuery);
if($inventoryCommentCheck['total']==0){
    $comment_data_array = array('orders_id' => $insert_id,
                              'orders_status_id' => $status,
                              'date_added' => EST_TIME_NOW,
                              'customer_notified' => '0',
                              'comments' => 'Inventory taken out of stock');
      tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $comment_data_array);
}
	
    $order_total_modules->update_credit_account($i);//ICW ADDED FOR CREDIT CLASS SYSTEM

//------insert customer choosen option to order--------

    $attributes_exist = '0';

    $products_ordered_attributes = '';

    if (isset($order->products[$i]['attributes'])) {

      $attributes_exist = '1';

      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {

        if (DOWNLOAD_ENABLED == 'true') {

          $attributes_query = "select pa.products_attributes_name, pa.products_attributes_id, products_attributes_units, products_attributes_retail_units, only_linked_options, popt.products_options_name, poval.products_options_values_name, pa.products_attributes_name, pa.options_values_price, pa.price_prefix, pa.products_attributes_special_price, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename

                               from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa

                               left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad

                                on pa.products_attributes_id=pad.products_attributes_id

                               where pa.products_id = '" . $order->products[$i]['id'] . "'

                                and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'

                                and pa.options_id = popt.products_options_id

                                and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'

                                and pa.options_values_id = poval.products_options_values_id

                                and popt.language_id = '" . $languages_id . "'

                                and poval.language_id = '" . $languages_id . "'";

          $attributes = tep_db_query($attributes_query);

        } else {

          $attributes = tep_db_query("select pa.products_attributes_id, products_attributes_units, products_attributes_retail_units, only_linked_options, popt.products_options_name, poval.products_options_values_name, pa.products_attributes_name, pa.options_values_price, pa.price_prefix, pa.products_attributes_special_price from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $languages_id . "' and poval.language_id = '" . $languages_id . "'");

        }

        $attributes_values = tep_db_fetch_array($attributes);        
        ////echo 'Update Log';
		$uprid = tep_get_uprid($order->products[$i]['id'], array($products_attributes[0]['option_id'] => $products_attributes[0]['value_id']));
        $check_unit = (tep_session_is_registered('retail_rep') && $_SESSION['retail_rep'] != '' ? $attributes_values['products_attributes_retail_units']:$attributes_values['products_attributes_units']);
           if($linked_options == false || $check_unit > 0){
		
            tep_db_query("INSERT INTO `inventory_log` (`log_id`, `products_id`, `products_attributes_id`, orders_id, `units_count`, `units_changed`, `change_date`, `adjustment_type`, products_attributes_name) VALUES ('', '".$order->products[$i]['id']."', '" . $attributes_values['products_attributes_id'] . "', '".$insert_id."', '" . (tep_session_is_registered('retail_rep') && $_SESSION['retail_rep']!=''?$attributes_values['products_attributes_retail_units']:$attributes_values['products_attributes_units']) . "', '-".$order->products[$i]['qty']."', now(), ".(tep_session_is_registered('retail_rep') && $_SESSION['retail_rep']!=''?"'Retail Order'":"'Order'").",'".addslashes($attributes_values['products_attributes_name'])."')");
            $query = tep_db_query("update  ".TABLE_PRODUCTS_ATTRIBUTES . " set ".(tep_session_is_registered('retail_rep') && $_SESSION['retail_rep']!=''?"products_attributes_retail_units = products_attributes_retail_units":"products_attributes_units = products_attributes_units" )."- ".$order->products[$i]['qty'].", date_last_purchased = '" . EST_TIME_NOW . "' where products_id = '" . tep_get_prid($order->products[$i]['id']) . "' AND options_id = '" . $products_attributes[0]['option_id'] . "' AND options_values_id = '" . $products_attributes[0]['value_id'] . "'");
            $check_quantity_query = tep_db_query("select products_id, products_attributes_units, products_attributes_retail_units, products_attributes_name, option_email_notification from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . tep_get_prid($order->products[$i]['id']) . "' AND options_id = '" . $products_attributes[0]['option_id'] . "' AND options_values_id = '" . $products_attributes[0]['value_id'] . "'");
            
            $check_quantity = tep_db_fetch_array($check_quantity_query);        
            $count_level = STOCK_REORDER_LEVEL;
            switch(strtoupper($order->products[$i]['model'][0])){
               case 'A':
                   $count_level = REORDER_LEVEL_A;
                   break;
               case 'C':
                   $count_level = REORDER_LEVEL_C;
                   break;
               case 'N':
                   $count_level = REORDER_LEVEL_N;
                   break;
               case 'J':
                   $count_level = REORDER_LEVEL_J;
                   break;
               case 'T':
                   $count_level = REORDER_LEVEL_T;
                   break;
               case 'V':
                   $count_level = REORDER_LEVEL_V;
                   break;
            }            
            if ($check_quantity['products_attributes_units'] < $count_level) {
			    
				$last_prod_update_query = tep_db_query("update ".TABLE_ORDERS_PRODUCTS." set last_product = '1' where products_id = '".(int)$order->products[$i]['id']."' and orders_id = '".(int)$insert_id."' and uprid = '".$uprid."' ");
                $email = 'true';
            }	 
        }elseif($attributes_values['only_linked_options']=='1'){
            tep_db_query("INSERT INTO `inventory_log` (`log_id`, `products_id`, `products_attributes_id`, orders_id, `units_count`, `units_changed`, `change_date`, `adjustment_type`,products_attributes_name) VALUES ('', '".$order->products[$i]['id']."', '" . $attributes_values['products_attributes_id'] . "', '".$insert_id."', '', '-".$order->products[$i]['qty']."', now(), 'Order','".addslashes($attributes_values['products_attributes_name'])."')");
        }
        $products_ordered_attributes .= "<br/>" . stripslashes($attributes_values['products_options_name']) . ' ' . stripslashes($attributes_values['products_attributes_name']);

      }

    }

//------insert customer choosen option eof ----

    $total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);

    $total_tax += tep_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];

    $total_cost += $total_products_price;



    $products_ordered .= $order->products[$i]['qty'] . ' x ' . stripslashes($order->products[$i]['name']) . ' (' . $order->products[$i]['model'] . ') = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . stripslashes($products_ordered_attributes);
if($i<($n-1)){
	$products_ordered .= '<br/>';
}
$j++;

  }





	// [[

  $res = tep_db_query("select op.products_quantity, uprid from " . TABLE_ORDERS_PRODUCTS . " op where orders_id='" . $insert_id . "'");

$email = 'false';
if(!tep_session_is_registered('retail_rep') && $_SESSION['retail_rep']== ''){
  while($d = tep_db_fetch_array($res)){

    if(tep_not_null($d['uprid'])){
    $prid = tep_get_prid($d['uprid']);
	$ov_id = tep_get_attributes_id($d['uprid']);
    $option_email_query = tep_db_query("select products_id, products_attributes_units, products_attributes_name, option_email_notification, option_inventory_status, products_attributes_model, options_id from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '".(int)$prid."' and options_values_id  = '".tep_get_attributes_id($d['uprid'])."'");
        $option_email = tep_db_fetch_array($option_email_query);
	if($option_email['option_email_notification']!=''){
			$email_content = 'This email was sent by the Healing Crystals shopping cart to notify you that a '.tep_get_products_name($option_email['products_id']).', Option: '.$option_email['products_attributes_name'].', was sold on '.date('m/d/y').' to '.$order->customer['firstname'] . ' ' . $order->customer['lastname'].' ('.$order->customer['email_address'].').';
		  
			tep_mail('', $option_email['option_email_notification'], 'Sale Notification - Order #'.$insert_id, $email_content, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, true);	   	
			//tep_mail('', 'shantnu@focusindia.com', 'Sale Notification - Order #'.$insert_id, $email_content, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, true);
	}
	//following commented code has been moved to checkout_success.php on 11 July' 2011
	//if ((($option_email['option_inventory_status'] == 'Discontinue') || ($option_email['option_inventory_status'] == 'order') || ($option_email['option_inventory_status'] == 'Sleep')) && (($option_email['products_attributes_units'] - $d['products_quantity']) == 0)) {
	/*if (($option_email['products_attributes_units'] - $d['products_quantity']) == 0) {
		if ($option_email['option_inventory_status'] == 'Order'){
			tep_db_query("update  ".TABLE_PRODUCTS_ATTRIBUTES . " set option_inventory_status = 'Sleep', option_inventory_change_date = now() where products_id = '" . (int) $prid . "' and options_values_id = '" . $ov_id . "'");
		}
		tep_db_query("update  " . TABLE_PRODUCTS_ATTRIBUTES . " set product_attributes_status = '0' where products_id = '" . (int) $prid . "' and options_values_id  = '" . $ov_id . "'");
		$active_attributes_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int) $prid . "' and product_attributes_status = '1'");
		$active_attributes_check = tep_db_fetch_array($active_attributes_check_query);
		if ($active_attributes_check['total'] < 1) {
			tep_db_query("update  " . TABLE_PRODUCTS . " set products_status = '0' where products_id = '" . (int) $prid . "'");
		
			if ($option_email['option_inventory_status'] == 'Discontinue') {
				$new_products_model = 'D' . $option_email['products_attributes_model'];
				tep_db_query("update products set products_model = '" . $new_products_model . "' where products_id = '" . (int) $prid . "'");
				tep_db_query("update " . TABLE_PRODUCTS_ATTRIBUTES . " set products_attributes_model = '" . $new_products_model . "' where products_id = '" . (int) $prid . "'");
				tep_db_query("update invoices_to_product_options set products_model = '" . $new_products_model . "' where products_id = '" . (int) $prid . "'");
				tep_db_query("update purchase_invoices_details set model = '" . $new_products_model . "' where products_id = '" . (int) $prid . "'");
			}
		}
	}
	
	if ((((substr($option_email['products_attributes_model'],0,1) == 'T') || (substr($option_email['products_attributes_model'],0,1) == 't')) && ($option_email['products_attributes_units'] - $d['products_quantity']) <= 25) || (((substr($option_email['products_attributes_model'],0,1) != 'T') && (substr($option_email['products_attributes_model'],0,1) != 't')) && ($option_email['products_attributes_units'] - $d['products_quantity']) <= 10) ) {
		$zmodelquery = tep_db_query("select products_attributes_id from products_attributes pa where products_attributes_model = 'Z" . $option_email['products_attributes_model'] . "'");			
		if(tep_db_num_rows($zmodelquery)){
			tep_db_query("update  ".TABLE_PRODUCTS_ATTRIBUTES . " set action_request = 'sort' where products_id = '" . (int) $prid . "' and options_values_id  = '" . $ov_id . "'");
		}else{
			tep_db_query("update  ".TABLE_PRODUCTS_ATTRIBUTES . " set action_request = 'count' where products_id = '" . (int) $prid . "' and options_values_id  = '" . $ov_id . "'");
		}
    }*/
	

    }

  }
if ($email == 'true') {

    $email_inventory = '<a href="https://www.healingcrystals.com/hcmin/stats_inventory.php?type=outofstock_expanded&view=input&tf_earliest_day=9000&status_sort=None"><u>Go to Out of Inventory Report page in admin</u></a><br><br>';

$res = tep_db_query("select * from " . TABLE_PRODUCTS_ATTRIBUTES . " where  products_attributes_units <" . STOCK_REORDER_LEVEL . " order by date_last_purchased desc, products_attributes_units  ");

    while ($e = tep_db_fetch_array($res)){

	     $email_inventory .= tep_get_products_name($e['products_id']) . ' (' . $e['products_attributes_model'] . ') ('.$e['products_attributes_name'].')- ' . $e['products_attributes_units'] . ' - ' . tep_date_short($e['date_last_purchased']). ' ' . "<br>";

      }

//      if (strlen(trim($email_inventory)) > 0) {
//
//        tep_mail(STORE_OWNER, 'orders@healingcrystals.com', 'Inventory critical quantity notification', $email_inventory, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, true);
//
//        tep_mail(STORE_OWNER, 'packingroom@healingcrystals.com', 'Inventory critical quantity notification', $email_inventory, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, true);
//    }
      }
}

  $order_total_modules->apply_credit();//ICW ADDED FOR CREDIT CLASS SYSTEM

// lets start with the email confirmation

$payment_class = $$payment;


/*
if ($payment ==  'moneyorder') {

      $email_order = $payment_class->email_header . "<hr><hr>\n\n";

    }*/




$raw_date = EST_TIME_NOW;

   $year = (int)substr($raw_date, 0, 4);

    $month = (int)substr($raw_date, 5, 2);

    $day = (int)substr($raw_date, 8, 2);

    $hour = (int)substr($raw_date, 11, 2);

    $minute = (int)substr($raw_date, 14, 2);

    $second = (int)substr($raw_date, 17, 2);

    $date_purchased = mktime($hour,$minute,$second,$month,$day,$year);

   $order_day = date("M d, Y", $date_purchased);

   $order_time = date("H:i:s", $date_purchased);



   
   $count_orders_query = tep_db_query("select count(*) as total from orders where orders_status != '100001' and orders_status != '100003' and customers_id = '" . (int)$customer_id . "'");

   $count_orders = tep_db_fetch_array($count_orders_query);

   $total_orders = $count_orders['total'];
   
    /* MOD FOR COUPON COMMENTS -05/11/2008 By SA*/
	/* $coupon_comments = tep_get_coupon_comments($insert_id);
	 if($coupon_comments != ''){
	   $email_order .= 'Special Coupon - ' . stripcslashes(tep_db_output($coupon_comments)) . "\n\n";   
	 }*/

$invoice_link = '<a href="'.tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $insert_id, 'SSL', false).'" target="_blank">'.tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id=' . $insert_id, 'SSL', false).'</a>';
	$order_date=  strftime(DATE_FORMAT_LONG) . ' at ' .$order_time;
$customer_total_orders_count = $total_orders; 	 
if ($order->info['comments'])$order_comments = ''.nl2br($order->info['comments']).'';






$order_product_details = $products_ordered;
$order_payment_details = '';





for ($i=0,$j=1,$n=sizeof($order_totals); $i<$n; $i++) {

    $order_payment_details .= strip_tags($order_totals[$i]['title']) . ' ' . strip_tags($order_totals[$i]['text']);
   if($j<$n)$order_payment_details.='<br/>';
   $j++;

  }



 //  $email_order .= '<br>' . sprintf(DATE_OF_ORDER, $order_day, $order_time ) . ' (' . $total_orders . ')';
if ($order->content_type != 'virtual') {







   $shipping_address = tep_address_label_html($customer_id, $sendto, 0, '', "<br/>");

  }
$billing_address = tep_address_label_html($customer_id, $billto, 0, '', "<br/>");









if (is_object($$payment)) {

    
	
	
	
	$payment_info_query = tep_db_query("select payment_info from " . TABLE_ORDERS . " where orders_id = '". $insert_id . "'");

  $payment_info_result = tep_db_fetch_array($payment_info_query);

  $payment_info = $payment_info_result['payment_info'];

if (preg_match("/credit/i", $payment_info)) {
  $payment_info = 'Credit Card';

  }

    $order_payment_method = $payment_info . "" ;



    if ($payment_class->email_footer) {

      $order_payment_method .= $payment_class->email_footer . "";

    }

  }
 /* MOD FOR ATTACHING PDF INVOICE FOR EVERY ORDER By SA*/
  //tep_mail($order->customer['firstname'] . ' ' . $order->customer['lastname'], $order->customer['email_address'], sprintf(EMAIL_TEXT_SUBJECT, $insert_id), $email_order, STORE_NAME, STORE_OWNER_EMAIL_ADDRESS);

 $order = new order($insert_id);

  $payment_info_result = array();

	$payment_info_query = tep_db_query("select payment_info from " . TABLE_ORDERS . " where orders_id = '". $insert_id . "'");

 	$payment_info_result = tep_db_fetch_array($payment_info_query);

  $payment_info = $payment_info_result['payment_info'];
  $mpd_content = '<a class="property" href="' . tep_href_link('summary_mpd.php','order_id='.$insert_id) . '">Summary Metaphysical Descriptions</a> - View the short metaphysical descriptions for each crystal in this order.
				 <br>
				 <a class="property" href="' . tep_href_link('detailed_mpd.php','order_id='.$insert_id) . '">Detailed Metaphysical Descriptions</a> - View the detailed metaphysical descriptions for each crystal in this order.
				 <br>
				 <a class="property" href="' . tep_href_link('products_description.php','order_id='.$insert_id) . '">Product Descriptions</a> - View the product descriptions for each item in this order.
				 <br>';
    $articles_included = array();
  $products_for_this_stone = array();
for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
	$article_name = '';
	$product_article_image = '';
	$article_description = '';
	$stone_name = '';
	$article_id_query = tep_db_query("SELECT sn.stone_name, sn.stone_name_id, p.products_image, sn.detailed_mpd from stone_names sn, products_to_stones p2s, products p where p2s.stone_name_id = sn.stone_name_id and p2s.products_id=p.products_id and p2s.products_id = '" . $order->products [$i] ['id'] . "' limit 1");

		$article_id = tep_db_fetch_array($article_id_query);
		if(!in_array($article_id['stone_name_id'], $articles_included)){
                    $articles_included[] =$article_id['stone_name_id'];
                    $products_for_this_stone = array();
                    for ($x=0, $y=sizeof($order->products); $x<$y; $x++) {
                        if($order->products [$x] ['id'] != $order->products [$i] ['id']){
                            $stone_id_query = tep_db_query("SELECT sn.stone_name_id, p.products_image, pd.products_name from stone_names sn, products_to_stones p2s, products p, products_description pd where p2s.stone_name_id = sn.stone_name_id and pd.products_id = p.products_id and pd.language_id = '1' and p2s.products_id=p.products_id and p2s.products_id = '" . $order->products [$x] ['id'] . "' limit 1");
                            $stone_id = tep_db_fetch_array($stone_id_query);
                            if($stone_id['stone_name_id'] == $article_id['stone_name_id']){
                                $products_for_this_stone[] = $stone_id;
                            }
                        }
                    }
                    
                if($article_id['stone_name'] != ''){
			$stone_name = 'Stone Name:  ' . $article_id['stone_name'];
		}
		if($article_id['detailed_mpd'] !=0){
			$article_details_query = tep_db_query("select ad.articles_id, ad.articles_name, ad.articles_description, ad.articles_url from articles_description ad where ad.articles_id=".$article_id['detailed_mpd']);
			if(tep_db_num_rows($article_details_query)){
				$article_details = tep_db_fetch_array($article_details_query);
				$article_name = $article_details['articles_name'];
				$product_article_image = '<img width="100" height="100" src="'. HTTP_SERVER . DIR_WS_HTTP_CATALOG . DIR_WS_IMAGES . $article_id['products_image'] . '" ALT=""  BORDER="0">';
				$article_description = $article_details['articles_description'];

				$mpd_content .= '<table border="0" width="100%" cellspacing="2" cellpadding="4">
	  <tr>
	    <td class="main" width="40%" valign="top">
		  <table border="0" width="100%" cellspacing="2" cellpadding="0">
		    <tr>
			  <td class="main"><b>Product Name:  ' . $order->products[$i]['name'] . '</b>
			  </td>
			</tr>
		    <tr>
			  <td class="main">' . $product_article_image . '
			  </td>
			</tr>
		    ';
                       foreach($products_for_this_stone as $image_array){
                           $mpd_content .= '<tr>
			  <td class="main"><b>Product Name:  ' . $image_array['products_name'] . '</b>
			  </td>
			</tr>
		    <tr>
			  <td class="main"><img width="100" height="100" src="'. HTTP_SERVER . DIR_WS_HTTP_CATALOG . DIR_WS_IMAGES . $image_array['products_image']  . '" ALT=""  BORDER="0">
			  </td>
			</tr>';
                       }         
		  $mpd_content .= '<tr>
			  <td class="main">
			  ' . $stone_name . '
			  </td>
			</tr></table>
		</td>
		<td class="main" width="60%" valign="top">
		<SPAN CLASS="MPDTitle">

				' . $article_name . '
				</span>

				' . stripslashes($article_description) . '

		</td>
	  </tr>
	  <tr><td colspan="2" align="center">Metaphysical Descriptions provided by www.HealingCrystals.com<br />"Promoting the education and use of crystals to support healing"</td></tr>
	</table>';
			}
		}
                }

}
  $payment_info = $payment_info_result['payment_info'];
  $emailTemplateQuery = tep_db_query("select page_and_email_templates_content from page_and_email_templates where page_and_email_templates_key = 'EMAIL_TEMPLATE_ORDER_CONFIRMATION'");
$emailTemplateArray = tep_db_fetch_array($emailTemplateQuery);

$variableToBeReplaced = array('{order_number}','{invoice_link}','{order_date}','{customer_total_orders_count}','{order_comments}','{ordered_products_details}','{order_payment_details}','{delivery_address_details}','{billing_address_details}','{payment_details}','{metaphysical_description}','{gift_voucher}',"\n");
$variableToBeAdded= array($insert_id,$invoice_link,$order_date,$customer_total_orders_count,$order_comments,$order_product_details,$order_payment_details,$shipping_address,$billing_address,$order_payment_method,$mpd_content,$giftVoucherLink,'');
$email_order = str_replace($variableToBeReplaced,$variableToBeAdded,$emailTemplateArray['page_and_email_templates_content']);


   unset($msg);
if(tep_session_is_registered('retail_rep') && $_SESSION['retail_rep'] != '' && $_SESSION['retail_cust_email'] != ''){
      
      $msg = new NewEmail($_SESSION['retail_cust_email'], STORE_OWNER_EMAIL_ADDRESS, sprintf(EMAIL_TEXT_SUBJECT, $insert_id));
      $msg->TextOnly = false;
      $msg->Content = callback($email_order);
      require_once("sendinvoice_pdf.php");
      require_once("admininvoice_pdf.php");
      $msg->Attach($tmpfname, "application/pdf");
      $SendSuccess = $msg->Send();
  }else{
     if ($payment_class->code != 'moneyorder') { 
 $textVersion =  $email_order;
 //echo $email_order;
 unset($msg);
//** !!!! SEND AN HTML EMAIL w/ATTACHMENT !!!!
//** create the new message using the to, from, and email subject.



  $Sender = $order->customer['email_address'];

  $Recipiant = SEND_EXTRA_ORDER_EMAILS_TO;

//$Recipiant = "shantnu@focusindia.com";

  $Cc = "";

  $Bcc = "";





  $msg = new NewEmail($Recipiant, $Sender, sprintf(EMAIL_TEXT_SUBJECT, $insert_id));

  $msg->Cc = $Cc;

  $msg->Bcc = $Bcc;



//** set the message to be text only and set the email content.



  $msg->TextOnly = false;

  $msg->Content = callback($textVersion);



//** attach this scipt itself to the message.





  //$msg->Attach($tmpfname, "text/plain");

 // $msg->Attach(DIR_FS_CATALOG.'/invoice/healing_crystals_logo.gif', "image/gif");



  require_once("sendinvoice_pdf.php");
  require_once("admininvoice_pdf.php");

  $msg->Attach($tmpfname, "application/pdf");





//** send the email message.



  $SendSuccess = $msg->Send();
     }



 // }
   unset($msg);
  $msg = new NewEmail($order->customer['email_address'], STORE_OWNER_EMAIL_ADDRESS, sprintf(EMAIL_TEXT_SUBJECT, $insert_id));
  $msg->TextOnly = false;
  $msg->Content = callback($email_order);
    require_once("sendinvoice_pdf.php");
	require_once("admininvoice_pdf.php");
  $msg->Attach($tmpfname, "application/pdf");
  $SendSuccess = $msg->Send();
  }
if($sendCommentsEmailToKayako == true)
	tep_mail('','contact@healingcrystals.com','Customer Comment from Order#: '.$insert_id,$kayakoComments,$order->customer['customers_name'],$order->customer['email_address']);	

if ($_SESSION['customer_id'] != '' && stripos($shipping['title'], 'free')!==false) {
     $shippAddQuery = tep_db_query("select lower(entry_street_address) as entry_street_address, entry_postcode, lower(entry_city) as entry_city from address_book where address_book_id = '".$_SESSION['customer_default_shipping_id']."'");
     $shippAddArray = tep_db_fetch_array($shippAddQuery); 
     $shippAddArray['entry_city'] = str_replace("'", "\'", $shippAddArray['entry_city']);
     $existingOrderQuery = tep_db_query("select orders_id as 'ord' from orders where customers_id = '" . $_SESSION['customer_id'] . "' and orders_status = '2' and orders_id != '" . $insert_id . "'and lower(delivery_street_address) = '".addslashes($shippAddArray['entry_street_address'])."' and lower(delivery_city) = '".  addslashes($shippAddArray['entry_city'])."' and delivery_postcode = '".$shippAddArray['entry_postcode']."' order by date_purchased DESC");
    if (tep_db_num_rows($existingOrderQuery) && stripos($order->info['shipping_method'],'free')!==false) {
         $existingOIdsArray = array();
       while( $existingOrderArray = tep_db_fetch_array($existingOrderQuery)){
           $existingOIdsArray[] =  $existingOrderArray['ord'];
       }
       $existingOidString = implode(',',$existingOIdsArray);
       if($existingOidString == ''){
            $combined_orders_string =  $oID;
       }else{
            $combined_orders_string =  $existingOidString.','.$oID;
       }
       tep_db_query("update orders set combined_orders_ids = '".$combined_orders_string."' where orders_id in (".$combined_orders_string.")");
        require_once('hcmin/fpdf/fpdf.php');
        require_once('hcmin/fpdf/fpdi.php');
       foreach($existingOIdsArray as $eOid){
        $pdf = & new FPDI();
        $pdf->addPage();
        $pdf->setSourceFile(DIR_FS_CATALOG . '/adminInvoice/invoice_' . $eOid . '.pdf');
        $pc =$pdf->parsers[DIR_FS_CATALOG . '/adminInvoice/invoice_' . $eOid . '.pdf']->page_count;
//        // import page 1
//        $tplIdx = $pdf->importPage(1);
//// use the imported page and place it at point 10,10 with a width of 100 mm
//        $pdf->useTemplate($tplIdx);
//
//        $pdf->SetFont('Arial', 'B', 8);
//        $pdf->SetTextColor(0, 0, 255);
//        $pdf->SetY(0);
//        $pdf->SetX(40);
//        $pdf->SetFillColor('255','255','255');
//
//        $pdf->MultiCell(100, 6, "Please combine Order " . $existingOidString . " and Order " . $oID, 0, 'C','1');
        for($pcn=1; $pcn<=$pc; $pcn++){
            $tplIdx = $pdf->importPage($pcn);
            $pdf->useTemplate($tplIdx);
            if($pcn==1){
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->SetTextColor(0, 0, 255);
                $pdf->SetY(16);
                $pdf->SetX(40);
                $pdf->SetFillColor('255','255','255');

                $pdf->MultiCell(0, 6, "Please combine Order " . $existingOidString . " and Order " . $oID, 0, 'C','1');
            }
            if($pc > 1 && $pcn < $pc) $pdf->addPage();             
        }
        $pdf->Output(DIR_FS_CATALOG . '/adminInvoice/invoice_' . $eOid . '.pdf', 'F');
        }
    }
}
$total_query= tep_db_query("select value from orders_total where orders_id = '".$insert_id."' and class = 'ot_subtotal'");
if(tep_db_num_rows($total_query) > '0'){
    $total_array = tep_db_fetch_array($total_query);
    if($total_array['value'] > '150'){    	
    //$subject = 'www.HealingCrystals.com '. TITLE_PRINT_ORDER . ' #' . $insert_id.' - High Order Amount';
        $total_total_query= tep_db_query("select value from orders_total where orders_id = '".$insert_id."' and class = 'ot_total'");        
        $total_total = tep_db_fetch_array($total_total_query);
        $subject = 'HC Order #' . $insert_id.' - High Dollar Amount $'.  number_format($total_total['value'],'2').' ('.tep_get_customer_total_orders($order->customer['id']).')';
        
        $msg_body = 'This email has been sent to notify you that we have received an order exceeding $150.00. Please check order details manually.<br><br>Order#: <a href="https://www.healingcrystals.com/hcmin/orders.php?selected_box=customers&page=1&oID='.$insert_id.'&action=edit">'.$insert_id.'</a><br>Company Name:'.$order->customer['company'].'<br>Customer Name: <a href="https://www.healingcrystals.com/hcmin/customers.php?page=1&cID='.$order->customer['id'].'&action=edit">'.$order->customer['name'].'</a><br>Number of Previous Orders: <a href="https://www.healingcrystals.com/hcmin/customer_order.php?customer_id='.$order->customer['id'].'">'.tep_get_customer_total_orders($order->customer['id']).'</a><br><br>Billing Address:<br>'.$order->billing['street_address'].',<br>'.$order->billing['city'].'&nbsp;  '.$order->billing['state'].'&nbsp; '.$order->billing['postcode'].'<br><br>Shipping Address:<br>'.$order->delivery['street_address'].',<br>'.$order->delivery['city'].'&nbsp;  '.$order->delivery['state'].'&nbsp; '.$order->delivery['postcode'] . '<br><br>' .callback($email_order);

   tep_mail('', HIGH_ORDER_EMAILS_TO, $subject, $msg_body, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, true);
   
   }
    
}
require ('includes/modules/blacklisted_check_script.php');

$safe_ips_array = explode(',',SAFE_IP_ADDRESSES);
if(!in_array($_SERVER['REMOTE_ADDR'],$safe_ips_array)){
$blackListedIpsQuery = tep_db_query("select ip_address, customers_firstname, customers_lastname from customers where is_customer_blacklisted = '1' and (ip_address = '".$_SERVER['REMOTE_ADDR']."') LIMIT 1");
    if(tep_db_num_rows($blackListedIpsQuery)){
        $order_blacklisting=true;
        $blackListedIpsCheck = tep_db_fetch_array($blackListedIpsQuery);
        $lookup = CheckIpLocation($blackListedIpsCheck['ip_address']);
        if (isset($lookup['error']) && $lookup['error'] != '') {
            $ip_location = $lookup['error'];
        } else {
            $ip_location = $lookup['city'] . ', ' . $lookup['region_name'] . ', ' . $lookup['country_name'] . ' ' . ($lookup['postcode'] != '' ? $lookup['postcode'] :'');
        }
        $ipContent = 'Blacklisted IP:&nbsp;'.$blackListedIpsCheck['ip_address'].'<br/>'.'Blacklisted IP Location:&nbsp;'.$ip_location.'<br/>'.'Name Associated with Blacklisted IP:&nbsp;'.$blackListedIpsCheck['customers_firstname'].' '.$blackListedIpsCheck['customers_lastname'].'<br/>';
    	$blackListedOrderEmailIpContent = $ipContent.'Following order was received from a balck listed IP:<br/>Customer\'s Name:&nbsp;&nbsp;&nbsp;'.$order->customer['name'].'<br/>Order #:&nbsp;&nbsp;&nbsp;<a href="'.tep_href_link('hcmin/orders.php','action=edit&oID='.$insert_id).'">'.$insert_id.'</a><br/>Amount:&nbsp;&nbsp;&nbsp;'.$total_array['value'];
    	tep_mail('', BLACKLIST_EMAIL_ALERT, 'HC Alert - Order Received from Blacklisted IP', $blackListedOrderEmailIpContent, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, true);
    }
}
$customerBlackListedQuery= tep_db_query("select is_customer_blacklisted, customers_firstname, customers_lastname from customers where customers_id = '".$customer_id."'");
    $customerBlackListedArray = tep_db_fetch_array($customerBlackListedQuery);
    if(($customerBlackListedArray['is_customer_blacklisted']=='1')||$order_blacklisting==true){    


    	$blackListedOrderEmailContent = 'Customer\'s Name:&nbsp;&nbsp;&nbsp;'.$order->customer['name'].'<br/>Order #:&nbsp;&nbsp;&nbsp;<a href="'.tep_href_link('hcmin/orders.php','action=edit&oID='.$insert_id).'">'.$insert_id.'</a><br/>Amount:&nbsp;&nbsp;&nbsp;'.$total_array['value'];
    	tep_mail('', BLACKLIST_EMAIL_ALERT, 'HC Alert - Order Received from Blacklisted Customer', $blackListedOrderEmailContent, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, true);
    	//tep_mail('','shantnu@focusindia.com', 'HC Alert - Order Received from Blacklisted Customer', $blackListedOrderEmailContent, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, true);
		$order_from_blacklisted = true;
		tep_session_register('order_from_blacklisted');
        /*tep_db_query("update orders set orders_status = '100004' where orders_id = '".$insert_id."'");
          $sql_data_array = array('orders_id' => $insert_id,

                          'orders_status_id' => '100004',

                          'date_added' => EST_TIME_NOW,

                          'customer_notified' => '0',

                          'comments' => 'Customer is Blacklisted, Order moved back to pending status, Contact a Manager');

        tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);*/
    }


  // Include OSC-AFFILIATE

  //require(DIR_WS_INCLUDES . 'affiliate_checkout_process.php');



// load the after_process function from the payment modules

  $payment_modules->after_process();



  $cart->reset(true);



// unregister session variables used during checkout

  tep_session_unregister('retail_cust_fname');
  
  tep_session_unregister('retail_cust_lname');
  
  tep_session_unregister('retail_cust_postcode');
  
  if(tep_session_is_registered('retail_cust_email'))tep_session_unregister('retail_cust_email');
  
  tep_session_unregister('sendto');

  tep_session_unregister('billto');

  tep_session_unregister('shipping');

  tep_session_unregister('payment');

  tep_session_unregister('comments');

  tep_session_unregister('card');

	if(tep_session_is_registered('credit_covers')) tep_session_unregister('credit_covers');

  $order_total_modules->clear_posts();//ICW ADDED FOR CREDIT CLASS SYSTEM

// BOF: Lango added for print order mod

  tep_redirect(tep_href_link('checkout_success_mobile.php', 'order_id='. $insert_id, 'SSL'));

// EOF: Lango added for print order mod

  require(DIR_WS_INCLUDES . 'application_bottom.php');

?>