<?php
/*
  $Id: orders.php,v 1.2 2003/09/24 15:18:15 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
 */


require('includes/application_top.php');
require_once(DIR_FS_ROOT . 'amazon_mws/config.php');
/*error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', TRUE);*/
//BOF:amazon
$amazon_ship_agent = '';
$amazon_track_id = '';
if (!empty($HTTP_GET_VARS['oID'])) {
    $is_amazon_order = amazon_manager::is_amazon_order($HTTP_GET_VARS['oID']);
    if ($is_amazon_order) {
        $sql = tep_db_query("select tracking_number, shipping_agent from amazon_orders where orders_id='" . $HTTP_GET_VARS['oID'] . "' order by date_added desc limit 0, 1");
        if (tep_db_num_rows($sql)) {
            $info = tep_db_fetch_array($sql);
            $amazon_ship_agent = $info['shipping_agent'];
            $amazon_track_id = $info['tracking_number'];
        }
    }
} else {
    $is_amazon_order = false;
}
//EOF:amazon
// require('includes/classes/class.Email.php');
require('../includes/classes/class.Email.php');  
require(DIR_WS_CLASSES . 'currencies.php');
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ORDERS_INVOICE);
$currencies = new currencies();
include(DIR_WS_CLASSES . 'order.php');
include(DIR_FS_CATALOG_LANGUAGES . $language . '/checkout_process.php');
require(DIR_FS_CATALOG_LANGUAGES . $language . '/printorder.php');
$orders_statuses = array();
$orders_status_array = array();
$orders_default_comment_array = array();
$orders_status_query = tep_db_query("select orders_status_id, orders_status_name,orders_status_default_comment from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int) $languages_id . "' order by orders_status_name");
while ($orders_status = tep_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
        //'text' => utf8_decode($orders_status['orders_status_name']));
        'text' => $orders_status['orders_status_name']);
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
    $orders_default_comment_array[$orders_status['orders_status_id']] = addslashes($orders_status['orders_status_default_comment']);
}
if($HTTP_GET_VARS['check_units']==true&& $HTTP_GET_VARS['orders_id']!=''){
    if($HTTP_GET_VARS['type']=='single'){
        $units_query = tep_db_query("select products_attributes_units from products_attributes where products_id = '".tep_get_prid($_GET['uprid'])."' and options_id = '".  tep_get_option_id($_GET['uprid'])."' and options_values_id = '".  tep_get_attributes_id($_GET['uprid'])."'");
        $units = tep_db_fetch_array($units_query);
        if($HTTP_GET_VARS['units']>= $units['products_attributes_units']){
            echo 'ERROR:'."\n\n".'There were not enough units in stock to make this adjustment.'."\n\n".'Adjustment was not entered. '."\n\n".'Please check the unit counts.';
        }else{
            echo '---';
        }
    }else{
        $order = new order($HTTP_GET_VARS['orders_id']);
        $false_units = false;
        for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
            $uprid = $order->products[$i]['uprid'];
            $units_query = tep_db_query("select products_attributes_units from products_attributes where products_id = '".$order->products[$i]['id']."' and options_id = '".  tep_get_option_id($uprid)."' and options_values_id = '".  tep_get_attributes_id($uprid)."'");
            $units = tep_db_fetch_array($units_query);
            $qty = $order->products[$i]['qty'];
            if($qty>=$units['products_attributes_units']){
                $false_units = true;
                break;
             }else{
                $false_units = false;
            }
        }
        //echo $false_units;
        if($false_units == true){
            echo 'ERROR:'."\n\n".'There were not enough units in stock to make this adjustment.'."\n\n".'Adjustment was not entered. '."\n\n".'Please check the unit counts.';

        }else{
            echo '---';
        }
    }
    exit();
}
$action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');
if (tep_not_null($action)) {
    switch ($action) {
        case 'addOptionToInventory':
            $option_id = tep_get_option_id($_GET['uprid']);
            $value_id = tep_get_value_id($_GET['uprid']);
            $product_id = tep_get_prid($_GET['uprid']);
            $q = tep_db_query("select products_attributes_id, only_linked_options, products_attributes_model, products_attributes_name from products_attributes where products_id = '" . $product_id . "' and options_id = '" . $option_id . "' and options_values_id = '" . $value_id . "'");
            $a = tep_db_fetch_array($q);
            $paqty = tep_get_pqty($product_id, $value_id);
            if($a['only_linked_options']=='0'){
            tep_db_query("INSERT INTO `inventory_log` (`log_id`, `products_id`, `products_attributes_id`, orders_id, `units_count`, `units_changed`, `change_date`, `adjustment_type`, admin_user, admin_user_ip) VALUES ('', '" . $product_id . "', '" . $a['products_attributes_id'] . "', '" . $HTTP_GET_VARS['oID'] . "', '" . $paqty . "', '" . $HTTP_GET_VARS['value'] . "', now(), 'Order(ADJ)', '".$_SESSION['login_first_name']."', '".tep_get_ip_address()."')");
            $sql = tep_db_query("update products_attributes set products_attributes_units = products_attributes_units+'" . $HTTP_GET_VARS['value'] . "' where products_id = '" . $product_id . "' and options_id = '" . $option_id . "' and options_values_id = '" . $value_id . "'");
            }
            elseif($a['only_linked_options']=='1'){
                tep_db_query("INSERT INTO `inventory_log` (`log_id`, `products_id`, `products_attributes_id`, orders_id, `units_count`, `units_changed`, `change_date`, `adjustment_type`, admin_user, admin_user_ip) VALUES ('', '" . $product_id . "', '" . $a['products_attributes_id'] . "', '" . $HTTP_GET_VARS['oID'] . "', '', '" . $HTTP_GET_VARS['value'] . "', now(), 'Order(ADJ)', '".$_SESSION['login_first_name']."', '".tep_get_ip_address()."')");
            }
            $linked_products_options_query = tep_db_query("select products_attributes_id, products_id, options_id, options_values_id, products_attributes_units, linked_options_quantity from products_attributes pa, linked_products_options l where l.child_products_id = pa.products_id and l.child_options_id = pa.options_id and l.child_options_values_id = pa.options_values_id and parent_products_id = '" .$product_id . "' and parent_options_values_id = '" . $value_id . "' and parent_options_id = '" . $option_id . "'");
            if(tep_db_num_rows($linked_products_options_query)){
                while($linked_products_options = tep_db_fetch_array($linked_products_options_query)){
                    $inv_update = array('products_attributes_units' => ($linked_products_options['products_attributes_units']+($HTTP_GET_VARS['value']*$linked_products_options['linked_options_quantity'])));
                    tep_db_perform('products_attributes', $inv_update, 'update', "products_attributes_id = '".$linked_products_options['products_attributes_id']."'");
                    //echo 'Update Log';
                    tep_db_query("INSERT INTO `inventory_log` (`log_id`, `products_id`, `products_attributes_id`, orders_id, `units_count`, `units_changed`, `change_date`, `adjustment_type`, admin_user, admin_user_ip) VALUES ('', '".$linked_products_options['products_id']."', '" . $linked_products_options['products_attributes_id'] . "', '".$HTTP_GET_VARS['oID']."', '" . ($linked_products_options['products_attributes_units']) . "', '".($HTTP_GET_VARS['value']*$linked_products_options['linked_options_quantity'])."', now(), 'Order(ADJ)', '".$_SESSION['login_first_name']."', '".tep_get_ip_address()."')");
                }
            }
            $order_status_query = tep_db_query("select orders_status from orders where orders_id = '" . $HTTP_GET_VARS['oID'] . "'");
            $order_status = tep_db_fetch_array($order_status_query);
            $comment = 'Current Unit Count: ' . $paqty . '<br/>' . $HTTP_GET_VARS['value'] . ' Unit(s) added back into Inventory.<br/>New Unit Count: ' . ($paqty + $HTTP_GET_VARS['value']) . '<br/>Product Model: ' . $a['products_attributes_model'] . '<br/>Product Name: ' . tep_get_products_name($product_id) . '<br/>Product Option Text: ' . $a['products_attributes_name'];
            tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int) $HTTP_GET_VARS['oID'] . "', '" . $order_status ['orders_status'] . "', now(), '0', '" . tep_db_input($comment) . "')");

            //BOF:mod 20111031
            $product_id_        = $product_id;
            $option_id_         = $option_id;
            $option_value_id_   = $value_id;
            include('amazon_inventory_feed_single_item.php');
            //EOF:mod 20111031

            tep_redirect(tep_href_link('orders.php', tep_get_all_get_params(array('action')) . '&action=edit'));
            break;
        case 'removeOptionFromInventory':
            $option_id = tep_get_option_id($_GET['uprid']);
            $value_id = tep_get_value_id($_GET['uprid']);
            $product_id = tep_get_prid($_GET['uprid']);
            $q = tep_db_query("select products_attributes_id, only_linked_options, products_attributes_model, products_attributes_name from products_attributes where products_id = '" . $product_id . "' and options_id = '" . $option_id . "' and options_values_id = '" . $value_id . "'");
            $a = tep_db_fetch_array($q);
            $paqty = tep_get_pqty($product_id, $value_id);
            if($a['only_linked_options']=='0'){
            tep_db_query("INSERT INTO `inventory_log` (`log_id`, `products_id`, `products_attributes_id`, orders_id, `units_count`, `units_changed`, `change_date`, `adjustment_type`, admin_user, admin_user_ip) VALUES ('', '" . $product_id . "', '" . $a['products_attributes_id'] . "', '" . $HTTP_GET_VARS['oID'] . "', '" . $paqty . "', '-" . $HTTP_GET_VARS['value'] . "', now(), 'Order(ADJ)', '".$_SESSION['login_first_name']."', '".tep_get_ip_address()."')");
            $sql = tep_db_query("update products_attributes set products_attributes_units = products_attributes_units-'" . $HTTP_GET_VARS['value'] . "' where products_id = '" . $product_id . "' and options_id = '" . $option_id . "' and options_values_id = '" . $value_id . "'");
            }elseif($a['only_linked_options']=='1'){
                tep_db_query("INSERT INTO `inventory_log` (`log_id`, `products_id`, `products_attributes_id`, orders_id, `units_count`, `units_changed`, `change_date`, `adjustment_type`, admin_user, admin_user_ip) VALUES ('', '" . $product_id . "', '" . $a['products_attributes_id'] . "', '" . $HTTP_GET_VARS['oID'] . "', '', '-" . $HTTP_GET_VARS['value'] . "', now(), 'Order(ADJ)', '".$_SESSION['login_first_name']."', '".tep_get_ip_address()."')");
            }
            $linked_products_options_query = tep_db_query("select products_attributes_id, products_id, options_id, options_values_id, products_attributes_units, linked_options_quantity from products_attributes pa, linked_products_options l where l.child_products_id = pa.products_id and l.child_options_id = pa.options_id and l.child_options_values_id = pa.options_values_id and parent_products_id = '" .$product_id . "' and parent_options_values_id = '" . $value_id . "' and parent_options_id = '" . $option_id . "'");
            if(tep_db_num_rows($linked_products_options_query)){
                while($linked_products_options = tep_db_fetch_array($linked_products_options_query)){
                    $inv_update = array('products_attributes_units' => ($linked_products_options['products_attributes_units']-($HTTP_GET_VARS['value']*$linked_products_options['linked_options_quantity'])));
                    tep_db_perform('products_attributes', $inv_update, 'update', "products_attributes_id = '".$linked_products_options['products_attributes_id']."'");
                    //echo 'Update Log';
                    tep_db_query("INSERT INTO `inventory_log` (`log_id`, `products_id`, `products_attributes_id`, orders_id, `units_count`, `units_changed`, `change_date`, `adjustment_type`, admin_user, admin_user_ip) VALUES ('', '".$linked_products_options['products_id']."', '" . $linked_products_options['products_attributes_id'] . "', '".$HTTP_GET_VARS['oID']."', '" . ($linked_products_options['products_attributes_units']) . "', '-".($HTTP_GET_VARS['value']*$linked_products_options['linked_options_quantity'])."', now(), 'Order(ADJ)', '".$_SESSION['login_first_name']."', '".tep_get_ip_address()."')");
                }
            }
            $order_status_query = tep_db_query("select orders_status from orders where orders_id = '" . $HTTP_GET_VARS['oID'] . "'");
            $order_status = tep_db_fetch_array($order_status_query);
            $comment = 'Current Unit Count: ' . $paqty . '<br/>' . $HTTP_GET_VARS['value'] . ' Unit(s) taken out of Inventory.<br/>New Unit Count: ' . ($paqty - $HTTP_GET_VARS['value']) . '<br/>Product Model: ' . $a['products_attributes_model'] . '<br/>Product Name: ' . tep_get_products_name($product_id) . '<br/>Product Option Text: ' . $a['products_attributes_name'];
            tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int) $HTTP_GET_VARS['oID'] . "', '" . $order_status ['orders_status'] . "', now(), '0', '" . tep_db_input($comment) . "')");

            //BOF:mod 20111031
            $product_id_        = $product_id;
            $option_id_         = $option_id;
            $option_value_id_   = $value_id;
            include('amazon_inventory_feed_single_item.php');
            //EOF:mod 20111031

            tep_redirect(tep_href_link('orders.php', tep_get_all_get_params(array('action')) . '&action=edit'));
            break;
        case 'charge_customer':
            //Get The Order Details
            $oID = $HTTP_GET_VARS['oID'];
            $order = new order($HTTP_GET_VARS['oID']);
            $credit_card_number = GPGDecrypt($order->info['encrypted_cc_number'], '91C8FD42', $HTTP_GET_VARS['password']);
            if (strlen($credit_card_number) != '16') {
                tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action', 'password', 'amount')) . 'action=edit&ac_password=wrong'));
            }
            $credit_card_expires = GPGDecrypt($order->info['encrypted_cc_expires'], '91C8FD42', $HTTP_GET_VARS['password']);
            $credit_card_month = substr($credit_card_expires, 0, 2);
            $credit_card_yr = substr($credit_card_expires, 2, 4);
            $credit_card_year = substr(date('Y'), 0, 2) . $credit_card_yr;
            $credit_card_cvn = GPGDecrypt($order->info['encrypted_cc_cvn'], '91C8FD42', $HTTP_GET_VARS['password']);
            $name_array = explode(' ', $order->customer['name']);
            $name_array_l = array_reverse($name_array);
            $last_name = $name_array_l['0'];
            $first_name = '';
            for ($x = 0; $x < (sizeof($name_array) - 1); $x++) {
                if ($x != '0'
                    )$first_name .= ' ';
                $first_name .= $name_array[$x];
            }

            $State = tep_get_zone_id($order->customer['country']['id'], $order->customer['state']);
            $zone_id = tep_get_zone_code($order->customer['country']['id'], $State, $order->customer['state']);

            //Include the Paypal Classfiles
            if (trim(MODULE_PAYMENT_PAYPAL_DP_PEAR_PATH) != '') {
                if (is_dir(MODULE_PAYMENT_PAYPAL_DP_PEAR_PATH)) {
                    $inc = ini_get('include_path');
                    $inc_exp = explode(PATH_SEPARATOR, $inc);
                    if (!in_array(MODULE_PAYMENT_PAYPAL_DP_PEAR_PATH, $inc_exp)) {
                        ini_set('include_path', $inc . PATH_SEPARATOR . MODULE_PAYMENT_PAYPAL_DP_PEAR_PATH);
                    }
                }
            }
            require_once 'Services/PayPal.php';
            require_once 'Services/PayPal/Profile/Handler/Array.php';
            require_once 'Services/PayPal/Profile/API.php';
            require_once 'Services/PayPal/Type/RefundTransactionRequestType.php';
            require_once 'Services/PayPal/Type/RefundTransactionResponseType.php';

            //Start the Paypal Execution
            $handler = & ProfileHandler_Array::getInstance(array(
                        'username' => MODULE_PAYMENT_PAYPAL_DP_API_USERNAME,
                        'certificateFile' => MODULE_PAYMENT_PAYPAL_DP_CERT_PATH,
                        'subject' => '',
                        'environment' => MODULE_PAYMENT_PAYPAL_DP_SERVER));

            $pid = ProfileHandler::generateID();

            // Set up your API credentials, PayPal end point, and API version.
            $profile = new APIProfile($pid, $handler);
            $profile->setAPIUsername(MODULE_PAYMENT_PAYPAL_DP_API_USERNAME);
            $profile->setAPIPassword(MODULE_PAYMENT_PAYPAL_DP_API_PASSWORD);
            //$profile->setSignature('');
            $profile->setCertificateFile(MODULE_PAYMENT_PAYPAL_DP_CERT_PATH);
            $profile->setEnvironment(MODULE_PAYMENT_PAYPAL_DP_SERVER);
            //--------------------------------------------------

            $dp_request = & Services_PayPal::getType('DoDirectPaymentRequestType');
            $dp_request->setVersion("51.0");

            // Set request-specific fields.
            //$dp_request->setTransactionId('example_transaction_id', 'iso-8859-1');

            $paymentType = 'Sale';    // or 'Authorization'
            $firstName = $first_name;
            $lastName = $last_name;
            $creditCardType = $order->info['cc_type'];
            $creditCardNumber = $credit_card_number;
            $expDateMonth = $credit_card_month;
            // Month must be padded with leading zero
            $padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);

            $expDateYear = $credit_card_year;
            $cvv2Number = $credit_card_cvn;
            $address1 = $order->customer['street_address'];
            $address2 = $order->customer['suburb'];
            $city = $order->customer['city'];
            $state = $zone_id;
            $zip = $order->customer['postcode'];
            $country = $order->customer['country']['iso_code_2'];   // UNITED_STATES or other valid country
            $amount = $HTTP_GET_VARS['amount'];
            $currencyID = 'USD';      // or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
            // setup the DoDirectPayment Request Payment details.
            $OrderTotal = & Services_PayPal::getType('BasicAmountType');
            $OrderTotal->setattr('currencyID', $currencyID);
            $OrderTotal->setval($amount, 'iso-8859-1');

            $shipTo = & Services_PayPal::getType('AddressType');
            $shipTo->setName($firstName . ' ' . $lastName);
            $shipTo->setStreet1($address1);
            $shipTo->setStreet2($address2);
            $shipTo->setCityName($city);
            $shipTo->setStateOrProvince($state);
            $shipTo->setCountry($country);
            $shipTo->setPostalCode($zip);

            $PaymentDetails = & Services_PayPal::getType('PaymentDetailsType');
            $PaymentDetails->setOrderTotal($OrderTotal);
            $PaymentDetails->setShipToAddress($shipTo);

            // Set up credit card info.
            $person_name = & Services_PayPal::getType('PersonNameType');
            $person_name->setFirstName($firstName);
            $person_name->setLastName($lastName);

            $payer = & Services_PayPal::getType('PayerInfoType');
            $payer->setPayerName($person_name);
            $payer->setPayerCountry($country);
            $payer->setAddress($shipTo);

            $card_details = & Services_PayPal::getType('CreditCardDetailsType');
            $card_details->setCardOwner($payer);
            $card_details->setCreditCardType($creditCardType);
            $card_details->setCreditCardNumber($creditCardNumber);
            $card_details->setExpMonth($padDateMonth);
            $card_details->setExpYear($expDateYear);
            $card_details->setCVV2($cvv2Number);

            $dp_details = & Services_PayPal::getType('DoDirectPaymentRequestDetailsType');
            $dp_details->setPaymentDetails($PaymentDetails);
            $dp_details->setCreditCard($card_details);
            $dp_details->setIPAddress($_SERVER['SERVER_ADDR']);
            $dp_details->setPaymentAction($paymentType);

            $dp_request->setDoDirectPaymentRequestDetails($dp_details);

            $caller = & Services_PayPal::getCallerServices($profile);

            // Execute SOAP request.
            $response = $caller->DoDirectPayment($dp_request);

            switch ($response->getAck()) {
                case 'Success':
                case 'SuccessWithWarning':
                    // Extract the response details.
                    $tranID = $response->getTransactionID();
                    $avsCode = $response->getAVSCode();
                    $cvv2 = $response->getCVV2Code();
                    $amt = $response->getAmount()->_value;
                    $currencyID = $response->getAmount()->getattr('currencyID');
                    $amt_display = "$currencyID $amt";
                    //exit('Direct Payment Completed Successfully: ' . print_r($response, true));
                    $comment = $amt . 'USD charged as additional charge<br>Transaction ID: ' . $tranID . '<br>Payment Type: Credit Card (Processed by PWPP)<br>Payment Status: Completed<br>AVS Code: ' . $avsCode . '<br>CVV2 Code: ' . $cvv2;
                    $ac_msg = 'Additional Charge Successful';
                    $ac_status = 'success';
                    break;
                default:
                    //exit('DoDirectPayment failed: ' . print_r($response, true));
                    $comment = 'Additional Charge Payment Failed';
                    $ac_msg = 'Additional Charge Failed';
                    $ac_status = 'error';
                    break;
            }
            $order_status_query = tep_db_query("select orders_status from orders where orders_id = '" . $_GET['oID'] . "'");
            $order_status = tep_db_fetch_array($order_status_query);
            tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int) $_GET['oID'] . "', '" . $order_status['orders_status'] . "', now(), '0', '" . tep_db_input($comment) . "')");
            $messageStack->add_session($ac_msg, $ac_status);
            tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action', 'password', 'amount')) . 'action=edit'));
            break;
            case 'test_refund':
        	$oID = $HTTP_GET_VARS['oID'];
            $value = $HTTP_GET_VARS['value'];
            $order = new order($oID);
            $aff_order_id_query = tep_db_query("select aa.affiliate_id, affiliate_percent as percentage from affiliate_affiliate aa, affiliate_sales asa where aa.affiliate_id = asa.affiliate_id and asa.affiliate_orders_id = '" . (int) $oID . "' ");
            if(tep_db_num_rows($aff_order_id_query)){
            	$aff_order_detail = tep_db_fetch_array($aff_order_id_query);
            	$affiliate_id = $aff_order_detail['affiliate_id'];
            	$refund_comission_for_this_order = ($aff_order_detail['percentage']/100)*$value;
            	updateAffiliateComissionsRefund($affiliate_id, $oID, $refund_comission_for_this_order);
            }
                $gross_amt = $value;
                $comment = $gross_amt . 'TEST REFUND FOR AFFILIATE MOD<br>';
                $refund_msg = 'Refund was successful';
                $refund_status = 'success';
            $order_status_query = tep_db_query("select orders_status from orders where orders_id = '" . $oID . "'");
            $order_status = tep_db_fetch_array($order_status_query);
            tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int) $oID . "', '" . $order_status['orders_status'] . "', now(), '0', '" . tep_db_input($comment) . "')");
            $messageStack->add_session($refund_msg, $refund_status);
            tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action', 'old_action', 'value', 'transaction_id')) . 'action=edit'));
            break;
         case 'refund_authorize':
            $oID = $HTTP_GET_VARS['oID'];
            $transaction_id = $HTTP_POST_VARS['transaction_id'];
            $old_action = $HTTP_GET_VARS['old_action'];
            $value = $HTTP_POST_VARS['refund_amount'];
            $order = new order($oID);
            $super_password = CC_DECRYPT_PASSWORD;
            
            if ($order->info['encrypted_cc_number'] != '' && $super_password ) {
                $cc_number = GPGDecrypt($order->info['encrypted_cc_number'], '51213E37', $super_password);                
            } else {
            $cc_number =  $order->info['cc_number'];
            }
            if ($order->info['encrypted_cc_expires'] != '') {
                $cc_expires = GPGDecrypt($order->info['encrypted_cc_expires'], '51213E37', $super_password);
            } else {
            $cc_expires =  $order->info['cc_expires'];
            
            }
            
            //echo 'test by mohit cc no :'.$cc_number;
            //exit();
 
            require('AuthnetXML.class.php');
            $xml = new AuthnetXML(MODULE_PAYMENT_AUTHORIZENET_LOGIN, MODULE_PAYMENT_AUTHORIZENET_TXNKEY, AuthnetXML::USE_DEVELOPMENT_SERVER);
            $xml->createTransactionRequest(array(
                'transactionRequest' => array(
                    'transactionType' => 'refundTransaction',
                    'amount' => $value,
                    'payment' => array(
                        'creditCard' => array(
                            'cardNumber' => $cc_number,
                            'expirationDate' => $cc_expires                           
                        )
                    ),
                    'refTransId' => $transaction_id
                ),
            ));
    		
            if($xml->isSuccessful()){
                $refund_tran_ID = $xml->transactionResponse->transId;
                $gross_amt = $value;
                $comment = $gross_amt . 'USD Refunded<br>Transaction ID:' . $refund_tran_ID;
                $refund_msg = 'Refund was successful';
                $refund_status = 'success';
                $aff_order_id_query = tep_db_query("select aa.affiliate_id, affiliate_percent as percentage from affiliate_affiliate aa, affiliate_sales asa where aa.affiliate_id = asa.affiliate_id and asa.affiliate_orders_id = '" . (int) $oID . "' ");
            if(tep_db_num_rows($aff_order_id_query)){
            	$aff_order_detail = tep_db_fetch_array($aff_order_id_query);
            	$affiliate_id = $aff_order_detail['affiliate_id'];
            	$refund_comission_for_this_order = ($aff_order_detail['percentage']/100)*$value;
            	updateAffiliateComissionsRefund($affiliate_id, $oID, $refund_comission_for_this_order);
               }
            }else{
                    $comment = 'Authorize.net Refund Transaction Failed<br/>'.$xml->messages->message->text . "<br>" . $xml->transactionResponse->errors->error->errorText;
                    $refund_msg = 'Refund Transaction Failed';
                    $refund_status = 'error';
            }
            $order_status_query = tep_db_query("select orders_status from orders where orders_id = '" . $oID . "'");
            $order_status = tep_db_fetch_array($order_status_query);
            tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int) $oID . "', '" . $order_status['orders_status'] . "', now(), '0', '" . tep_db_input($comment) . "')");
            $messageStack->add_session($refund_msg, $refund_status);
            tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action', 'old_action', 'value', 'transaction_id')) . 'action=edit'));
            break;
        case 'refund_paypal':
            $oID = $HTTP_GET_VARS['oID'];
            $transaction_id = $HTTP_GET_VARS['transaction_id'];
            $old_action = $HTTP_GET_VARS['old_action'];
            $value = $HTTP_GET_VARS['value'];
            $order_total_query = tep_db_query("select value from orders_total where orders_id = '" . $oID . "' and class= 'ot_total'");
            $order_total = tep_db_fetch_array($order_total_query);
            if ($value == $order_total['value']) {
                $refund_type = 'Full';
            } else {
                $refund_type = 'Partial';
            }
            $aff_order_id_query = tep_db_query("select aa.affiliate_id, affiliate_percent as percentage from affiliate_affiliate aa, affiliate_sales asa where aa.affiliate_id = asa.affiliate_id and asa.affiliate_orders_id = '" . (int) $oID . "' ");
            if(tep_db_num_rows($aff_order_id_query)){
            	$aff_order_detail = tep_db_fetch_array($aff_order_id_query);
            	$affiliate_id = $aff_order_detail['affiliate_id'];
            	$refund_comission_for_this_order = ($aff_order_detail['percentage']/100)*$value;
            	updateAffiliateComissionsRefund($affiliate_id, $oID, $refund_comission_for_this_order);
            }
            if (trim(MODULE_PAYMENT_PAYPAL_DP_PEAR_PATH) != '') {
                if (is_dir(MODULE_PAYMENT_PAYPAL_DP_PEAR_PATH)) {
                    $inc = ini_get('include_path');
                    $inc_exp = explode(PATH_SEPARATOR, $inc);
                    if (!in_array(MODULE_PAYMENT_PAYPAL_DP_PEAR_PATH, $inc_exp)) {
                        ini_set('include_path', $inc . PATH_SEPARATOR . MODULE_PAYMENT_PAYPAL_DP_PEAR_PATH);
                    }
                }
            }
            require_once 'Services/PayPal.php';
            require_once 'Services/PayPal/Profile/Handler/Array.php';
            require_once 'Services/PayPal/Profile/API.php';
            require_once 'Services/PayPal/Type/RefundTransactionRequestType.php';
            require_once 'Services/PayPal/Type/RefundTransactionResponseType.php';

            $environment = 'live'; // or 'beta-sandbox' or 'sandbox'
            //--------------------------------------------------
            // PROFILE
            //--------------------------------------------------
            /**
             *                    W A R N I N G
             * Do not embed plaintext credentials in your application code.
             * Doing so is insecure and against best practices.
             *
             * Your API credentials must be handled securely. Please consider
             * encrypting them for use in any production environment, and ensure
             * that only authorized individuals may view or modify them.
             */
            $handler = & ProfileHandler_Array::getInstance(array(
                        'username' => MODULE_PAYMENT_PAYPAL_DP_API_USERNAME,
                        'certificateFile' => MODULE_PAYMENT_PAYPAL_DP_CERT_PATH,
                        'subject' => '',
                        'environment' => MODULE_PAYMENT_PAYPAL_DP_SERVER));

            $pid = ProfileHandler::generateID();

            // Set up your API credentials, PayPal end point, and API version.
            $profile = new APIProfile($pid, $handler);

            $profile->setAPIUsername(MODULE_PAYMENT_PAYPAL_DP_API_USERNAME);
            $profile->setAPIPassword(MODULE_PAYMENT_PAYPAL_DP_API_PASSWORD);
            //$profile->setSignature('');
            $profile->setCertificateFile(MODULE_PAYMENT_PAYPAL_DP_CERT_PATH);
            $profile->setEnvironment(MODULE_PAYMENT_PAYPAL_DP_SERVER);
            //--------------------------------------------------

            $refund_request = & Services_PayPal::getType('RefundTransactionRequestType');
            $refund_request->setVersion("51.0");

            // Set request-specific fields.
            $refund_request->setTransactionId($transaction_id, 'iso-8859-1');
            $refundType = $refund_type; // or 'Partial'
            $amount = $value;    // required if Partial.
            $memo = 'Refund From HealingCrystals';     // required if Partial.
            $currencyID = 'USD'; // or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')

            $refund_request->setRefundType($refundType, 'iso-8859-1');

            if (strcasecmp($refundType, 'Partial') == 0) {
                if (isset($amount)) {
                    $Amount = & Services_PayPal::getType('BasicAmountType');
                    $Amount->setattr('currencyID', $currencyID);
                    $Amount->setval($amount, 'iso-8859-1');
                    $refund_request->setAmount($Amount);
                } else {
                    exit('Partial Refund Amount is not specified.');
                }

                if (isset($memo)) {
                    $refund_request->setMemo($memo, 'iso-8859-1');
                } else {
                    exit('Partial Refund Memo is not specified.');
                }
            }

            $caller = & Services_PayPal::getCallerServices($profile);

            // Execute SOAP request.
            $response = $caller->RefundTransaction($refund_request);

            switch ($response->getAck()) {
                case 'Success':
                case 'SuccessWithWarning':
                    // Extract the response details.
                    $refund_tran_ID = $response->getRefundTransactionID();
                    $gross_amt_obj = $response->getGrossRefundAmount();
                    $gross_amt = $gross_amt_obj->_value;
                    $currency_cd = $gross_amt_obj->_attributeValues['currencyID'];
                    //exit('Refund Completed Successfully: ' . print_r($response, true));
                    $comment = $gross_amt . $currency_cd . ' Refunded<br>Transaction ID:' . $refund_tran_ID;
                    $refund_msg = 'Refund was successful';
                    $refund_status = 'success';
                    break;


                default:
                    //exit('RefundTransaction failed: ' . print_r($response, true));
                    //error in refund, mail response to the developer
                    tep_mail('Mohit - Focusindia', 'Mohit@focusindia.com', 'Paypal Refund Failed', $response, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
                    $comment = 'Paypal Refund Transaction Failed';
                    $refund_msg = 'Refund Transaction Failed';
                    $refund_status = 'error';
                    break;
            }
            $order_status_query = tep_db_query("select orders_status from orders where orders_id = '" . $oID . "'");
            $order_status = tep_db_fetch_array($order_status_query);
            tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int) $oID . "', '" . $order_status['orders_status'] . "', now(), '0', '" . tep_db_input($comment) . "')");
            $messageStack->add_session($refund_msg, $refund_status);
            tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action', 'old_action', 'value', 'transaction_id')) . 'action=edit'));
            break;
        case 'send_invoice':

            $oID = $HTTP_GET_VARS['oID'];
            $order = new order($HTTP_GET_VARS['oID']);
            $sendto = $HTTP_GET_VARS['email'];
            $payment_info_result = array();

            $payment_info_query = tep_db_query("select payment_info from " . TABLE_ORDERS . " where orders_id = '" . (int) $HTTP_GET_VARS['oID'] . "'");

            $payment_info_result = tep_db_fetch_array($payment_info_query);

            $payment_info_one = $payment_info_result['payment_info'];

            $payment_info = substr($payment_info_one, 0, 50);

            $orders_history_query = tep_db_query("select comments from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . (int) $HTTP_GET_VARS['oID'] . "' order by date_added limit 1");

            $orders_history = tep_db_fetch_array($orders_history_query);

            $order->info['comments'] = $orders_history['comments'];

            for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
                $products_ordered_attributes = '';
                if (isset($order->products[$i]['attributes'])) {
                    $attributes_exist = '1';
                    for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++) {
                        $products_ordered_attributes .= "\n\t" . $order->products[$i]['attributes'][$j]['option'] . ' ' . $order->products[$i]['attributes'][$j]['value'];
                    }
                }
                $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "\n";
            }
            $date_purchased = $order->info['date_purchased'];

            $year = (int) substr($date_purchased, 0, 4);

            $month = (int) substr($date_purchased, 5, 2);

            $day = (int) substr($date_purchased, 8, 2);

            $hour = (int) substr($date_purchased, 11, 2);

            $minute = (int) substr($date_purchased, 14, 2);

            $second = (int) substr($date_purchased, 17, 2);

            $date_purchased1 = mktime($hour, $minute, $second, $month, $day, $year);

            $order_day = date("M d, Y", $date_purchased1);

            $order_time = date("H:i:s", $date_purchased1);

            $count_orders_query = tep_db_query("select count(*) as total from orders where orders_status != '100001' and orders_status != '100003' and customers_id = '" . (int) $order->customer['customer_id'] . "'");
            $count_orders = tep_db_fetch_array($count_orders_query);
            $total_orders = $count_orders['total'];
            /* EDITED FOR CORRECT ORDER DATE BY SA */
            $email_order .= STORE_NAME . "\n" .
                    EMAIL_SEPARATOR . "\n" .
                    EMAIL_TEXT_ORDER_NUMBER . ' ' . $HTTP_GET_VARS['oID'] . "\n" .
                    EMAIL_TEXT_INVOICE_URL . ' ' . 'http://healingcrystals.com/account_history_info.php?order_id=' . $HTTP_GET_VARS['oID'] . "\n" .
                    EMAIL_TEXT_DATE_ORDERED . ' ' . $order_day . ' at ' . $order_time . ' (' . $total_orders . ')' . "\n\n";

            if ($order->info['comments'] != '') {

                $comments = $order->info['comments'];

                $email_order .= tep_db_output($order->info['comments']) . "\n\n";
            }
            /* MOD FOR COUPON COMMENTS -05/11/2008 By SA */
            $coupon_comments = tep_get_coupon_comments($HTTP_GET_VARS['oID']);
            if ($coupon_comments != '') {
                $email_order .= 'Special Coupon - ' . stripcslashes(tep_db_output($coupon_comments)) . "\n\n";
            }

            $email_order .= EMAIL_TEXT_PRODUCTS . "\n" .
                    EMAIL_SEPARATOR . "\n" .
                    $products_ordered .
                    EMAIL_SEPARATOR . "\n";

            for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {

                $email_order .= strip_tags($order->totals[$i]['title']) . ' ' . strip_tags($order->totals[$i]['text']) . "\n";
            }

            if ($order->content_type != 'virtual') {

                $email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" .
                        EMAIL_SEPARATOR . "\n" .
                        '<DIV style="FONT: 11pt arial"><b>' .
                        strtoupper(tep_address_format($order->delivery['format_id'], $order->delivery, 0, '', "\n")) . '</b></div>' . "\n";
            }
            $email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" .
                    EMAIL_SEPARATOR . "\n" .
                    tep_address_format($order->customer['format_id'], $order->billing, 0, '', "\n") . "\n\n";



            $email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" .
                    EMAIL_SEPARATOR . "\n";

            if (preg_match("/credit/i", $payment_info_one)) {
                $payment_info_one = 'Credit Card';
            }
            $email_order .= $payment_info_one . "\n\n";

            if ($order->info['payment_method'] == 'Check/Money Order (Payable to Healing Crystals) - International Checks not accepted') {

                $email_order .= 'Please make checks payable to: Healing Crystals

							and mail payment to:' . "\n\n" . 'Healing Crystals' . "\n" . '800 Lake Windermere Ct.' . "\n" . 'Great Falls, VA 22066-1532' . "\n";
            }
			$email_order = nl2br($email_order);
			$email_order .= '<a class="property" href="' . tep_href_link('summary_mpd.php','order_id='.$HTTP_GET_VARS ['oID']) . '">Summary Metaphysical Descriptions</a> - View the short metaphysical descriptions for each crystal in this order. ' . "<br/>" . '<a class="property" href="' . tep_href_link('detailed_mpd.php','order_id='.$HTTP_GET_VARS ['oID']) . '">Detailed Metaphysical Descriptions</a> - View the detailed metaphysical descriptions for each crystal in this order.' . "<br/>" . ' <a class="property" href="' . tep_href_link('products_description.php','order_id='.$HTTP_GET_VARS ['oID']) . '">Product Descriptions</a> - View the product descriptions for each item in this order.' ;
$articles_included = array();
for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
	$article_name = '';
	$product_article_image = '';
	$article_description = '';
	$stone_name = '';
	$article_id_query = tep_db_query("SELECT sn.stone_name, sn.stone_name_id, sn.detailed_mpd from products_properties pp, stone_names sn where pp.property_id=1 and sn.stone_name=pp.property_value and pp.products_id = " . $order->products [$i] ['id']  );
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
				$product_article_image = '<img width="100" height="100" src="http://' . $article_details['articles_url'] . '" ALT=""  BORDER="0">';
				$article_description = $article_details['articles_description'];
			}
		}
}
$email_order .= '<table border="0" width="100%" cellspacing="2" cellpadding="2"><tr><td class="main" width="40%" valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0"><tr><td class="main" valign="top"><b>Product Name:  ' . $order->products[$i]['name'] . '</b></td></tr><tr><td class="main" valign="top">' . $product_article_image . '</td></tr>';
foreach($products_for_this_stone as $image_array){
                           $email_order .= '<tr>
			  <td class="main"><b>Product Name:  ' . $image_array['products_name'] . '</b>
			  </td>
			</tr>
		    <tr>
			  <td class="main"><img width="100" height="100" src="'. HTTP_SERVER . DIR_WS_HTTP_CATALOG . DIR_WS_IMAGES . $image_array['products_image']  . '" ALT=""  BORDER="0">
			  </td>
			</tr>';
                       }
$email_order .= '<tr><td class="main" valign="top">' . $stone_name . '</td></tr></table></td><td class="main" width="60%" valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0"><tr><td class="main" valign="top">	' . $article_name . '</td></tr><tr><td class="main" valign="top">' . stripslashes($article_description) . '</td></tr></table></td></tr><tr><td colspan="2" align="center">Metaphysical Descriptions provided by www.HealingCrystals.com<br />"Promoting the education and use of crystals to support healing"</td></tr></table>';
}
            $textVersion = $email_order;
            unset($msg);
            //** !!!! SEND AN HTML EMAIL w/ATTACHMENT !!!!
            //** create the new message using the to, from, and email subject.
            $tmpfname = DIR_FS_CATALOG . 'invoice/invoice_' . $_GET['oID'] . '.pdf';
            if(!is_file($tmpfname)){
                $HTTP_GET_VARS['generate_from_admin'] = 'true';
                   include_once('../sendinvoice_pdf.php');
            }
            $Sender = $order->customer['email_address'];
            $Recipiant = $sendto;
            $Cc = "";
            $Bcc = "";
            define('EMAIL_INVOICE_SUBJECT', 'HealingCrystals.com - Order# %s');
            $msg = new NewEmail($Recipiant, $Sender, sprintf(EMAIL_INVOICE_SUBJECT, $HTTP_GET_VARS['oID']));
            $msg->Cc = $Cc;
            $msg->Bcc = $Bcc;
            //** set the message to be text only and set the email content.
            $msg->TextOnly = false;
            $msg->Content = callback($textVersion);
            //** attach this scipt itself to the message.
            $msg->Attach($tmpfname, "application/pdf");
            //** send the email message.
            $SendSuccess = $msg->Send();
            $messageStack->add_session('Invoice Sent', 'success');
            unlink(DIR_FS_CATALOG . 'invoice/invoice_' . $_GET['oID'] . '.pdf');
            tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=edit'));
            break;
        case 'update_order':       

            $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);
            $order = new order($HTTP_GET_VARS['oID']);
            $status = tep_db_prepare_input($HTTP_POST_VARS['status']);
            $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);
            //BOF:amazon
            $txtShipAgt = tep_db_prepare_input($HTTP_POST_VARS['txtShipAgt']);
            $txtTrackID = tep_db_prepare_input($HTTP_POST_VARS['txtTrackID']);
            //EOF:amazon
            $order_updated = false;
            $check_status_query = tep_db_query("select customers_name, customers_email_address, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = '" . (int) $oID . "'");
            $check_status = tep_db_fetch_array($check_status_query);
            if ($status == '100001' && $HTTP_POST_VARS['restore'] == '1') {
                //  tep_cancel_order($oID);
                // $comments = 'Products <b>ADDED BACK</b> into inventory<br>' . $comments;
            }
/*=========================================================================*/
/*      require('../push.php');
      if($HTTP_POST_VARS['notify'] == 'on') {
      $sql = "SELECT * FROM `orders_status` WHERE `orders_status_id` = '".$check_status['orders_status']."'";
      $result      = tep_db_query($sql);
      $data        = tep_db_fetch_array($result);
      $user_id     = $order->customer['customer_id'];
      $subject     = $data['orders_status_name'];
      $description = $data['orders_status_default_comment'];
      sendMessage($user_id,$subject,$description);
      }*/
/*=========================================================================*/
            // BOF: WebMakers.com Added: Downloads Controller
            // always update date and time on order_status
            //BOF:amazon
           if (is_amazon_order($HTTP_GET_VARS['oID']) && $check_status['orders_status']!='5') {
                if ($status == '5') {
                    $sql = tep_db_query("select internal_id from amazon_orders where orders_id='" . $HTTP_GET_VARS['oID'] . "' order by date_added desc limit 0, 1");
                    if (tep_db_num_rows($sql)) {
                        $info = tep_db_fetch_array($sql);
                        tep_db_query("update amazon_orders set tracking_number='" . $txtTrackID . "', shipping_agent='" . $txtShipAgt . "' where internal_id='" . $info['internal_id'] . "'");
                    }
                    $amazon = new amazon_manager('mws');
                    $amazon->submit_order_fulfillment_feed($HTTP_GET_VARS['oID'], true);
                }
            }
            //EOF:amazon
            // original        if ( ($check_status['orders_status'] != $status) || tep_not_null($comments)) {
            if (($check_status['orders_status'] != $status) || $comments != '' || ($status == DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE)) {
                if ($check_status['orders_status'] == '100001' && ($check_status['orders_status'] != $status)) {
                    //$comments = 'Products <b>TAKEN OUT</b> of inventory<br>' . $comments;
                    // tep_update_inventory($oID);
                }
                tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . tep_db_input($status) . "', last_modified = now() where orders_id = '" . (int) $oID . "'");
                $check_status_query2 = tep_db_query("select customers_name, customers_email_address, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = '" . (int) $oID . "'");
                $check_status2 = tep_db_fetch_array($check_status_query2);
                if ($check_status2['orders_status'] == DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE) {
                    tep_db_query("update " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " set download_maxdays = '" . tep_get_configuration_key_value('DOWNLOAD_MAX_DAYS') . "', download_count = '" . tep_get_configuration_key_value('DOWNLOAD_MAX_COUNT') . "' where orders_id = '" . (int) $oID . "'");
                }
                // EOF: WebMakers.com Added: Downloads Controller
                $customer_notified = '0';
                //if($status == '3' || $status =='5')$HTTP_POST_VARS['notify'] = 'on';
                if (isset($HTTP_POST_VARS['notify']) && ($HTTP_POST_VARS['notify'] == 'on')) {
             
                    $pwa_check_query = tep_db_query("select purchased_without_account, date_format(date_purchased, '%Y-%m-%d') as order_date from " . TABLE_ORDERS . " where orders_id = '" . tep_db_input($oID) . "'");
                    $pwa_check = tep_db_fetch_array($pwa_check_query);
                    $amazon_check_query = tep_db_query("select internal_id from amazon_orders where orders_id = '" . tep_db_input($oID) . "'");
                    if(($status == '3' || $status =='5') && $comments=='' && (tep_db_num_rows($amazon_check_query)==0)){

                    	$ship_company_query = tep_db_query("select title from orders_total where class = 'ot_shipping' and orders_id = '".tep_db_input($oID)."'");
                    	$ship_company = tep_db_fetch_array($ship_company_query);
                    	if(stripos($ship_company['title'], 'usps')!== false){
                    		$emailTemplateQuery = tep_db_query("select page_and_email_templates_content from page_and_email_templates where page_and_email_templates_key = 'EMAIL_TEMPLATE_SHIPPED_MESSAGE'");
                    		$emailTemplateArray = tep_db_fetch_array($emailTemplateQuery);
                    	}elseif(stripos($ship_company['title'], 'fedex')!== false){
                    		$emailTemplateQuery = tep_db_query("select page_and_email_templates_content from page_and_email_templates where page_and_email_templates_key = 'EMAIL_TEMPLATE_SHIPPED_MESSAGE_FEDEX'");
                    		$emailTemplateArray = tep_db_fetch_array($emailTemplateQuery);
                    	}
                    	$variableToBeReplaced = array('{order_number}', '{invoice_link}', '{order_date}', '{tracking_num}','{new_status}','USPS Track and Confirm','USPS Delivery Confirm','{metaphysical_description}');
                        $trackingNumQuery = tep_db_query("select comments from orders_status_history where orders_id = '".$oID."' and comments like '%Delivery Confirmation:%'");
                        if(tep_db_num_rows($trackingNumQuery)){
                        $trackingNumArray = tep_db_fetch_array($trackingNumQuery);
                        $tn_Array = explode('<br/>',$trackingNumArray['comments']);
                        $tn_Array2 = explode(': ',$tn_Array[0]);
                        $tn_Array3 = explode('<br>',$tn_Array2[1]);
                        $tracking_num = strip_tags($tn_Array3[0]);
                        $tracking_link = '<a href="http://trkcnfrm1.smi.usps.com/PTSInternetWeb/InterLabelInquiry.do?origTrackNum='.$tracking_num.'" target="_blank"><u><font color="blue">USPS Track and Confirm</font></u></a>';
                        }else{
                            $fedExtrackingNumQuery = tep_db_query("select comments from orders_status_history where orders_id = '".$oID."' and comments like '%Tracking number%'");
                            if(tep_db_num_rows($fedExtrackingNumQuery)){
                            $fedExtrackingNumArray = tep_db_fetch_array($fedExtrackingNumQuery);
                            $fedExtn_Array = explode('Tracking number ',$fedExtrackingNumArray['comments']);
                            $tracking_num = $fedExtn_Array[1];
                            $tracking_link = '<a href="http://www.fedex.com/Tracking?cntry_code=us&tracknumber_list='.$tracking_num.'&language=english" target="_blank"><u><font color="blue">FedEx Track and Confirm</font></u></a>';

                            }else{
                          $tracking_num = '';
                          $tracking_link = '<a href="http://trkcnfrm1.smi.usps.com/PTSInternetWeb/InterLabelInquiry.do?origTrackNum='.$tracking_num.'" target="_blank"><u><font color="blue">USPS Track and Confirm</font></u></a>';
                            }
                        }
                        $mpd_content = '<a class="property" href="' . tep_catalog_href_link('summary_mpd.php','order_id='.$oID) . '">Summary Metaphysical Descriptions</a> - View the short metaphysical descriptions for each crystal in this order.
				 <br>
				 <a class="property" href="' . tep_catalog_href_link('detailed_mpd.php','order_id='.$oID) . '">Detailed Metaphysical Descriptions</a> - View the detailed metaphysical descriptions for each crystal in this order.
				 <br>
				 <a class="property" href="' . tep_catalog_href_link('products_description.php','order_id='.$oID) . '">Product Descriptions</a> - View the product descriptions for each item in this order.
				 <br>';
                        $articles_included = array();
                        for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {

                                $article_name = '';
                                $product_article_image = '';
                                $article_description = '';
                                $stone_name = '';
                                $article_id_query = tep_db_query("SELECT sn.stone_name, sn.stone_name_id, p.products_image, sn.detailed_mpd from stone_names sn, products_to_stones p2s, products p where p2s.stone_name_id = sn.stone_name_id and p2s.products_id=p.products_id and p2s.products_id = '" . $order->products [$i] ['id'] . "' limit 1");

                                        $article_id = tep_db_fetch_array($article_id_query);
                                        if(!in_array($article_id['stone_name_id'], $articles_included)){
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
                                       $articles_included[] = $article_id['stone_name_id'];
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
                                                </tr>';
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
                                                </tr>
                                          </table>
                                        </td>
                                        <td class="main" width="60%" valign="top">
                                        <SPAN CLASS="MPDTitle">

                                                        ' . $article_name . '
                                                        </span>

                                                        ' . htmlspecialchars_decode(stripslashes($article_description)) . '

                                        </td>
                                  </tr>
                                  <tr><td colspan="2" align="center">Metaphysical Descriptions provided by www.HealingCrystals.com<br />"Promoting the education and use of crystals to support healing"</td></tr>
                                </table>';
                                                }
                                        }
                                        }
                        }
                        $variableToBeAdded = array($oID, '<a href="'.HTTP_CATALOG_SERVER.DIR_WS_CATALOG.'invoice/invoice_'.$oID.'.pdf">'.HTTP_CATALOG_SERVER.DIR_WS_CATALOG.'invoice/invoice_'.$oID.'.pdf</a>', $pwa_check['order_date'],$tracking_num,'Shipped',$tracking_link,$tracking_link,$mpd_content);

                    //    $variableToBeAdded = array($oID, '<a href="'.HTTP_CATALOG_SERVER.DIR_WS_CATALOG.'invoice/invoice_'.$oID.'.pdf">'.HTTP_CATALOG_SERVER.DIR_WS_CATALOG.'invoice/invoice_'.$oID.'.pdf</a>', $pwa_check['order_date'],$tn_Array3[0],'Shipped',$tracking_link);
                        $email = callback(str_replace($variableToBeReplaced, $variableToBeAdded, $emailTemplateArray['page_and_email_templates_content']));
                        $comments = $email;
                    }else{
                    $notify_comments = '';
                    // BOF: WebMakers.com Added: Downloads Controller - Only tell of comments if there are comments
                    if (isset($HTTP_POST_VARS['notify_comments']) && ($HTTP_POST_VARS['notify_comments'] == 'on')) {
                        $notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $comments) . "\n\n";
                    }
                    // EOF: WebMakers.com Added: Downloads Controller
                    if ($pwa_check['purchased_without_account'] != '1') {
                        $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . tep_date_long($check_status['date_purchased']) . "\n\n" . $notify_comments . sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]);
                    } else {
                        $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . tep_date_long($check_status['date_purchased']) . "\n\n" . $notify_comments . sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]);
                    }
                    }
                    $mimemessage = new email(array('X-Mailer: osCommerce'));
                    $mimemessage->add_html($email);
                    $mimemessage->build_message();
                    $mimemessage->send($check_status['customers_name'], $check_status['customers_email_address'], STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, EMAIL_TEXT_SUBJECT);
                    $customer_notified = '1';
                    /*=========================================================================*/
      require('../push.php');
      if($HTTP_POST_VARS['notify'] == 'on') {
      $sql = "SELECT * FROM `orders_status` WHERE `orders_status_id` = '".$check_status['orders_status']."'";
      $result      = tep_db_query($sql);
      $data        = tep_db_fetch_array($result);
      $user_id     = $order->customer['customer_id'];
      $subject     = /*$data['orders_status_name']*/"Order Update(".$oID.")";
      $description = /*$data['orders_status_default_comment']*/$email;
      /*$description2 = str_replace(".",".</br>",$email);*/
      $description2 = tep_convert_linefeeds(array("\r\n", "\n", "\r"), '<br>', $email);
      sendMessage($user_id,$subject,$description,$description2);
      }
/*=========================================================================*/
                }
                if (isset($HTTP_POST_VARS['print']) && ($HTTP_POST_VARS['print'] == 'on')) {
					$comment_printed_on_picking_invoice = 1;
				}else{
					$comment_printed_on_picking_invoice = 0;
				}
                /*if (isset($HTTP_POST_VARS['print']) && ($HTTP_POST_VARS['print'] == 'on')) {
                    $commentToBePrinted = $HTTP_POST_VARS['comments'];
                    require_once('fpdf/fpdf.php');
                    require_once('fpdf/fpdi.php');
                    $pdf = & new FPDI();
                    $pdf->addPage();
                    $pdf->setSourceFile('../adminInvoice/invoice_' . $oID . '.pdf');
                    $pc =$pdf->parsers['../adminInvoice/invoice_' . $oID . '.pdf']->page_count;
                    for($pcn=1; $pcn<=$pc; $pcn++){
                        $tplIdx = $pdf->importPage($pcn);
                        $pdf->useTemplate($tplIdx);
                        if($pcn==1){
                            $pdf->SetFont('Arial', 'B', 8);
                            $pdf->SetTextColor(0, 0, 0);
                            $pdf->SetY(10);
                            $pdf->SetX(14);
                            $pdf->SetFillColor('255','255','255');

                            $pdf->MultiCell(100, 6, $commentToBePrinted, 0, 'C','1');
                        }
                        $pdf->addPage();
                    }
                    $pdf->Output('../adminInvoice/invoice_' . $oID . '.pdf', 'F');
                }*/
                tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments, comment_printed_on_picking_invoice) values ('" . (int) $oID . "', '" . tep_db_input($status) . "', now(), '" . tep_db_input($customer_notified) . "', '" . tep_db_input($comments) . "', '" . tep_db_input($comment_printed_on_picking_invoice) . "')");
				$order_updated = true;
				if($comment_printed_on_picking_invoice){
					$HTTP_GET_VARS['generate_from_admin'] = 'true';
                	include_once('../admininvoice_pdf.php');
				}
            }
            //echo $oID;
            //exit();
            updateAffiliateComissions($oID);
            if ($order_updated == true) {
                $messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
            } else {
                $messageStack->add_session(WARNING_ORDER_NOT_UPDATED, 'warning');
            }

            tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=edit'));

          /* $redirection_link_url=tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=edit');
            header("Location:".$redirection_link_url);*/
            
            break;
        case 'deleteconfirm':
            $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);

            tep_remove_order($oID, $HTTP_POST_VARS['restock']);

            tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action'))));
            break;
        case 'add_product':
            $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);

            $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);

            tep_cancel_order($oID);

            $comments = 'Products <b>ADDED BACK</b> into inventory<br>' . $comments;
            $status = tep_db_prepare_input($HTTP_POST_VARS['status']);

            tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, date_added, comments, orders_status_id) values ('" . (int) $oID . "', now(), '" . tep_db_input($comments) . "', '" . $status . "')");
            tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=edit'));

            break;

        case 'remove_product':
            $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);

            $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);

            tep_update_inventory($oID);

            $comments = 'Products <b>REMOVED</b> from inventory<br>' . $comments;
            $status = tep_db_prepare_input($HTTP_POST_VARS['status']);

            tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, date_added, comments, orders_status_id) values ('" . (int) $oID . "', now(), '" . tep_db_input($comments) . "', '" . $status . "')");
            tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=edit'));

            break;
        case 'super_login':


            $super_password = tep_db_prepare_input($HTTP_POST_VARS['super_password']);
            $enc_cc_number = tep_db_prepare_input($HTTP_POST_VARS['encrypted_cc_number']);
            $enc_cc_cvn = tep_db_prepare_input($HTTP_POST_VARS['encrypted_cc_cvn']);
            $enc_cc_expires = tep_db_prepare_input($HTTP_POST_VARS['encrypted_cc_expires']);
            if ($super_password == '') {
                $HTTP_GET_VARS['decrypt'] = 0;
                $super_user = 0;
                tep_session_register('super_user');
                tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=edit'));
            } else {
                $HTTP_GET_VARS['decrypt'] = 1;
                $dec_cc_number = GPGDecrypt($enc_cc_number, '51213E37', $super_password);
                //echo $dec_cc_number . '-'. strlen($dec_cc_number);

                if (strlen($dec_cc_number) == '16') {
                    tep_session_register('super_password');

                    $super_user = 1;
                    tep_session_register('super_user');
                    tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=edit'));
                } else {
                    $super_user = 0;
                    tep_session_register('super_user');
                    tep_redirect(tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=edit&password=wrong'));
                }
            }
            break;
    }
}

if (($action == 'edit') && isset($HTTP_GET_VARS['oID'])) {

    $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);

    $orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . (int) $oID . "'");
    $order_exists = true;
    if (!tep_db_num_rows($orders_query)) {
        $order_exists = false;
        $messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
    }
}
// BOF: WebMakers.com Added: Additional info for Orders
// Look up things in orders
$the_extra_query = tep_db_query("select * from " . TABLE_ORDERS . " where orders_id = '" . (int) $oID . "'");
$the_extra = tep_db_fetch_array($the_extra_query);
$the_customers_id = $the_extra['customers_id'];
// Look up things in customers
$the_extra_query = tep_db_query("select * from " . TABLE_CUSTOMERS . " where customers_id = '" . $the_customers_id . "'");
$the_extra = tep_db_fetch_array($the_extra_query);
$the_customers_fax = $the_extra['customers_fax'];
// EOF: WebMakers.com Added: Additional info for Orders
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
        <title><?php echo TITLE; ?></title>
        <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
        <script language="javascript" src="includes/menu.js"></script>
        <script language="Javascript1.2">
            function Decrypt(encryptedMessage){
                alert(encryptedMessage);
            }
        </script>
        <script language="Javascript1.2"><!-- // load htmlarea
            // MaxiDVD Added WYSIWYG HTML Area Box + Admin Function v1.7 - 2.2 MS2 HTML Email HTML - <head>
            _editor_url = "<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_ADMIN; ?>htmlarea/";  // URL to htmlarea files
            var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
            if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
            if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
            if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
<?php if (HTML_AREA_WYSIWYG_BASIC_EMAIL == 'Basic') { ?>  if (win_ie_ver >= 5.5) {

        document.write('<scr' + 'ipt src="' +_editor_url+ 'editor_basic.js"');

        document.write(' language="Javascript1.2"></scr' + 'ipt>');

    } else { document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>'); }

<?php } else { ?> if (win_ie_ver >= 5.5) {

        document.write('<scr' + 'ipt src="' +_editor_url+ 'editor_advanced.js"');

        document.write(' language="Javascript1.2"></scr' + 'ipt>');

    } else { document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>'); }

<?php } ?>

// --></script>

        <script language="JavaScript" src="htmlarea/validation.js"></script>
        <script language="javascript" src="includes/general.js"></script>
        <script language="javascript"><!--
    function ajaxRequest(){
 var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"] //activeX versions to check for in IE
 if (window.ActiveXObject){ //Test for support for ActiveXObject in IE first (as XMLHttpRequest in IE7 is broken)
  for (var i=0; i<activexmodes.length; i++){
   try{
    return new ActiveXObject(activexmodes[i])
   }
   catch(e){
    //suppress error
   }
  }
 }
 else if (window.XMLHttpRequest) // if Mozilla, Safari etc
  return new XMLHttpRequest()
 else
  return false
}
function checkUnits(orders_id, type, units, uprid, redirectTO){
var url = "orders.php?check_units=true&orders_id="+orders_id+"&type="+type+"&units="+units+"&uprid="+uprid;
var mygetrequest=new ajaxRequest()
mygetrequest.onreadystatechange=function(){
    if (mygetrequest.readyState==4){
        if (mygetrequest.status==200 || window.location.href.indexOf("http")==-1){
               var resp = mygetrequest.responseText;
               if(resp == '---'){
                   location.href = redirectTO;
               }else{
                alert(resp);
               }
        }
        else{
            alert("An error has occured making the request")
        }
    }
}
mygetrequest.open("GET", url, true)
mygetrequest.send(null)
}
    function echeck(str) {

        var at="@"
        var dot="."
        var lat=str.indexOf(at)
        var lstr=str.length
        var ldot=str.indexOf(dot)
        if (str.indexOf(at)==-1){
            alert("Invalid E-mail ID")
            return false
        }

        if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
            alert("Invalid E-mail ID")
            return false
        }

        if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
            alert("Invalid E-mail ID")
            return false
        }

        if (str.indexOf(at,(lat+1))!=-1){
            alert("Invalid E-mail ID")
            return false
        }

        if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
            alert("Invalid E-mail ID")
            return false
        }

        if (str.indexOf(dot,(lat+2))==-1){
            alert("Invalid E-mail ID")
            return false
        }

        if (str.indexOf(" ")!=-1){
            alert("Invalid E-mail ID")
            return false
        }

        return true
    }
    function popupWindow(url) {
        window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=650,height=500,screenX=150,screenY=150,top=150,left=150')
    }

    function checkstatus()
    {
        var myform = document.forms["status"];
        var currentstatus = myform.status.options[myform.status.selectedIndex].value;
        if (currentstatus == "100001") {
            if (confirm("Are you sure that you want to add the items from this order back into inventory?")) {
                myform.restore.value = "1";
            }
        }

        return true;
    }
    function sendInvoice(url){
        var email = window.prompt("please enter email address to whom you want to send invoice");
        if(echeck(email) == true){
            var sendURL = url + '&email='+email;
            location.href=sendURL;
        }else sendInvoice(url);
    }
    //--></script>
        <style>
            .dataTableContentO {
                color:#000000;
                font-family:Verdana,Arial,sans-serif;
                font-size:13px;
            }
            a.addRemove:hover{
                font-size: 13px;
                text-decoration: underline;
                font-weight: bold;
            }
        </style>
        <script language="javascript"><!--
    var comment_array = new Array();
<?php
for ($i = 0, $n = sizeof($orders_statuses); $i < $n; $i++) {
    if ($orders_default_comment_array[$orders_statuses[$i]['id']] != '') {

        $status_comment = nl2br($orders_default_comment_array[$orders_statuses[$i]['id']]);
        $status_comment = str_replace("\r", "", $status_comment);
        $status_comment = str_replace("\n", "", $status_comment);
        $status_comment = str_replace("\n\r", "", $status_comment);

        echo 'comment_array["' . $orders_statuses[$i]['id'] . '"] = "' . $status_comment . '";' . "\n";
    } else {
        echo 'comment_array["' . $orders_statuses[$i]['id'] . '"] = "";' . "\n";
    }
}
?>
function updateDefaultComment() {
var selected_value = document.forms["status"].status.options[document.forms["status"].status.selectedIndex].value;
var newComment = comment_array[selected_value];
if (newComment == "") {
    document.forms["status"].comments.value = document.forms["status"].comments.value;
} else {
    document.forms["status"].comments.value = document.forms["status"].comments.value + "<br>" + newComment;
}

}
function selectField(Ref){
Ref.select();
Ref.focus();
}

//--></script>

        <SCRIPT language=javascript src="editor/inhtml.js"></SCRIPT>

    </head>
    <body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
        <!-- header //-->
<?php
require(DIR_WS_INCLUDES . 'header.php');
?>

        <!-- header_eof //-->

        <!-- body //-->
        <table border="0" width="100%" cellspacing="2" cellpadding="2">
            <tr>
                <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
                        <!-- left_navigation //-->
        <?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
                        <!-- left_navigation_eof //-->
                    </table></td>
                <!-- body_text //-->
                <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2" id="mainTable">
<?php
        if (($action == 'edit') && ($order_exists == true)) {
//             if(!is_file(DIR_FS_CATALOG . 'invoice/invoice_' . $_GET['oID'] . '.pdf')){
//                $HTTP_GET_VARS['generate_from_admin'] = 'true';
//                   include_once('../sendinvoice_pdf.php');
//            }
//            if(!is_file(DIR_FS_CATALOG . 'adminInvoice/invoice_' . $_GET['oID'] . '.pdf')){
//                $HTTP_GET_VARS['generate_from_admin'] = 'true';
//                   include_once('../admininvoice_pdf.php');
//            }
            $order = new order($oID);
?>
                            <tr>
                                <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
                                            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>

                                            <!--td class="pageHeading" align="right">
<?php if ((!tep_not_null($order->info['authorize_trx_id'])) && (!tep_not_null($order->info['transaction_id'])))
                echo '<a href="' . tep_href_link("edit_orders.php", tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> &nbsp; '; ?>

<?php echo '<a href="' . tep_href_link(FILENAME_CUSTOMERS, 'action=edit&cID=' . $order->customer['customer_id']) . '">' . tep_image_button('button_profile.gif', 'Customer\'s Profile') . '</a>&nbsp;<a href="' . tep_href_link('customer_order.php', 'oID=' . $HTTP_GET_VARS['oID'] . '&customer_id=' . $order->customer['customer_id']) . '">' . tep_image_button('button_list_orders.gif', 'Customer\'s Order') . '</a>&nbsp;<a href="#" onclick="sendInvoice(\'' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=send_invoice') . '\'); return false;">' . tep_image_button('button_send_invoice.gif', 'Send Invoice') . '</a>&nbsp;&nbsp;';
?>
                                            <a onClick="popupWindow('<?php echo tep_href_link('printLabelPopup.php', tep_get_all_get_params()); ?>')" href="javascript: void(0);"> <?php echo tep_image_button('button_print_label.gif', 'Print Labels'); ?> </a>&nbsp;

<?php echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?>
                                        </td//-->



                                        <td class="pageHeading" align="right">

                        <?php
                        if ((!tep_not_null($order->info ['authorize_trx_id'])) && (!tep_not_null($order->info ['transaction_id'])))
                            echo '<a href="' . tep_href_link("edit_orders.php", tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> &nbsp; ';
                        ?>

<!---->
<?php
//                        // echo '<a href="' . tep_href_link ( FILENAME_CUSTOMERS, 'action=edit&cID=' . $order->customer ['customer_id'] ) . '">' . tep_image_button ( 'button_profile.gif', 'Customer\'s Profile' ) . '</a>&nbsp;<a href="' . tep_href_link ( 'customer_order.php', 'oID=' . $HTTP_GET_VARS ['oID'] . '&customer_id=' . $order->customer ['customer_id'] ) . '">' . tep_image_button ( 'button_list_orders.gif', 'Customer\'s Order' ) . '</a>&nbsp;<a href="javascript:popupWindow(\'' . (HTTP_SERVER . DIR_WS_CATALOG . 'invoice/invoice_' . $HTTP_GET_VARS ['oID'] . '.pdf') . '\')">' . tep_image_button ( 'button_customer_invoice.gif', 'Print master invoice that was created at checkout' ) . '</a>&nbsp;<a href="javascript:popupWindow(\'../adminInvoice/invoice_' . $HTTP_GET_VARS ['oID'] . '.pdf\')">' . tep_image_button ( 'button_packing_invoice.gif', IMAGE_ORDERS_PACKINGSLIP ) . '</a>&nbsp;<a href="#" onclick="sendInvoice(\'' . tep_href_link ( FILENAME_ORDERS, tep_get_all_get_params ( array ('action' ) ) . 'action=send_invoice' ) . '\'); return false;">' . tep_image_button ( 'button_send_invoice.gif', 'Send Invoice' ) . '</a>&nbsp;&nbsp;';
//                        echo '<a href="' . tep_href_link(FILENAME_CUSTOMERS, 'action=edit&cID=' . $order->customer ['customer_id']) . '">' . tep_image_button('button_profile.gif', 'Customer\'s Profile') . '</a>&nbsp;
//                        <a href="' . tep_href_link('customer_order.php', 'oID=' . $HTTP_GET_VARS ['oID'] . '&customer_id=' . $order->customer ['customer_id']) . '">' . tep_image_button('button_list_orders.gif', 'Customer\'s Order') . '</a>&nbsp;
//                        <a href="javascript:popupWindow(\'' . (HTTP_SERVER . DIR_WS_CATALOG . 'invoice/invoice_' . $HTTP_GET_VARS ['oID'] . '.pdf') . '\')">' . tep_image_button('button_customer_invoice.gif', 'Print master invoice that was created at checkout') . '</a>&nbsp;
//                        <a href="javascript:popupWindow(\'createPackingList.php?oID=' . $oID . '\')">' . tep_image_button('button_packinglist.gif', 'Packing List') . '</a>&nbsp;
//                        <a href="javascript:popupWindow(\'../adminInvoice/invoice_' . $HTTP_GET_VARS ['oID'] . '.pdf\')">' . tep_image_button('button_packing_invoice.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>&nbsp;
//                        <a href="#" onclick="sendInvoice(\'' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=send_invoice') . '\'); return false;">' . tep_image_button('button_send_invoice.gif', 'Send Invoice') . '</a>&nbsp;&nbsp;';
//?>

                                            <?php
                                            // echo '<a href="' . tep_href_link ( FILENAME_CUSTOMERS, 'action=edit&cID=' . $order->customer ['customer_id'] ) . '">' . tep_image_button ( 'button_profile.gif', 'Customer\'s Profile' ) . '</a>&nbsp;<a href="' . tep_href_link ( 'customer_order.php', 'oID=' . $HTTP_GET_VARS ['oID'] . '&customer_id=' . $order->customer ['customer_id'] ) . '">' . tep_image_button ( 'button_list_orders.gif', 'Customer\'s Order' ) . '</a>&nbsp;<a href="javascript:popupWindow(\'' . (HTTP_SERVER . DIR_WS_CATALOG . 'invoice/invoice_' . $HTTP_GET_VARS ['oID'] . '.pdf') . '\')">' . tep_image_button ( 'button_customer_invoice.gif', 'Print master invoice that was created at checkout' ) . '</a>&nbsp;<a href="javascript:popupWindow(\'../adminInvoice/invoice_' . $HTTP_GET_VARS ['oID'] . '.pdf\')">' . tep_image_button ( 'button_packing_invoice.gif', IMAGE_ORDERS_PACKINGSLIP ) . '</a>&nbsp;<a href="#" onclick="sendInvoice(\'' . tep_href_link ( FILENAME_ORDERS, tep_get_all_get_params ( array ('action' ) ) . 'action=send_invoice' ) . '\'); return false;">' . tep_image_button ( 'button_send_invoice.gif', 'Send Invoice' ) . '</a>&nbsp;&nbsp;';
                                            echo '<a href="' . tep_href_link(FILENAME_CUSTOMERS, 'action=edit&cID=' . $order->customer ['customer_id']) . '">' . tep_image_button('button_profile.gif', 'Customer\'s Profile') . '</a>&nbsp;<a href="' . tep_href_link('customer_order.php', 'oID=' . $HTTP_GET_VARS ['oID'] . '&customer_id=' . $order->customer ['customer_id']) . '">' . tep_image_button('button_list_orders.gif', 'Customer\'s Order') . '</a>&nbsp';

                                            ?>
                                            <?php
                                            $urlsss = $_SERVER['HTTP_HOST'];

                                            if (strpos($urlsss,'www.test.healingcrystals.com:8888') !== false) {

                                                echo '<a href="javascript:popupWindow(\'http://' . $_SERVER['HTTP_HOST'] . '/sendinvoice_pdf.php?oID=' . $HTTP_GET_VARS ['oID'] . '&generate_from_admin=true&download=false'.'\')">' . tep_image_button('button_customer_invoice.gif', 'Print master invoice that was created at checkout') . '</a>
                                            &nbsp;<a href="javascript:popupWindow(\'http://' . $_SERVER['HTTP_HOST'] . '/hcmin/createPackingList.php?oID=' . $HTTP_GET_VARS ['oID'] . '\')">' . tep_image_button('button_packinglist.gif', 'Packing List') . '</a>
                                            &nbsp;<a href="javascript:popupWindow(\'http://' . $_SERVER['HTTP_HOST'] . '/admininvoice_pdf.php?oID=' . $HTTP_GET_VARS ['oID'] . '&generate_from_admin=true&download=false'.'\')">' . tep_image_button('button_packing_invoice.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>&nbsp;&nbsp;';
                                            }else{
                                                echo '<a href="javascript:popupWindow(\'https://' . $_SERVER['HTTP_HOST'] . '/sendinvoice_pdf.php?oID=' . $HTTP_GET_VARS ['oID'] . '&generate_from_admin=true&download=false'.'\')">' . tep_image_button('button_customer_invoice.gif', 'Print master invoice that was created at checkout') . '</a>
                                            &nbsp;<a href="javascript:popupWindow(\'https://' . $_SERVER['HTTP_HOST'] . '/hcmin/createPackingList.php?oID=' . $HTTP_GET_VARS ['oID'] . '\')">' . tep_image_button('button_packinglist.gif', 'Packing List') . '</a>
                                            &nbsp;&nbsp;<a href="javascript:popupWindow(\'https://' . $_SERVER['HTTP_HOST'] . '/admininvoice_pdf.php?oID=' . $HTTP_GET_VARS ['oID'] . '&generate_from_admin=true&download=false'.'\')">' . tep_image_button('button_packing_invoice.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>&nbsp;&nbsp;';
                                            }
                                            echo '<a href="#" onclick="sendInvoice(\'' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=send_invoice') . '\'); return false;">' . tep_image_button('button_send_invoice.gif', 'Send Invoice') . '</a>';
                                            ?>








                                            <a onClick="popupWindow('<?php echo tep_href_link('printLabelPopup.php', tep_get_all_get_params()); ?>')" href="<?php //echo tep_href_link ( 'stoneNameLabel_pdf.php', tep_get_all_get_params ( array ('oID' ) ) . 'oID=' . $HTTP_GET_VARS ['oID'] ); ?>javascript: void(0);"> <?php echo tep_image_button('button_print_label.gif', 'Print Labels'); ?> </a>


<?php
                                        echo '&nbsp;<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>';
?>
                                        </td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                        <td colspan="3"><?php echo tep_draw_separator(); ?></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                <tr>
                                                    <td class="main" valign="top"><b><?php echo ENTRY_BILLING_ADDRESS; ?></b></td>
                                                    <td class="main"><?php echo tep_address_format($order->customer['format_id'], $order->customer, 1, '', '<br>'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
                                                </tr>
<?php
                                            //BOF:amazon
                                            if ($is_amazon_order) {
                                                $dtls = get_amazon_order_details($HTTP_GET_VARS['oID']);
?>
                                                    <tr>
                                                        <td class="main" valign="top"><b><?php echo 'Amazon#'; ?></b></td>
                                                        <td class="main"><?php echo $dtls['amazon_order_id']; ?></td>
                                                    </tr>
<?php
                                            }
                                            //EOF:amazon
?>
<?php if ($order->customer ['notes'] != '') { ?>
                                        </tr>
                                        <tr>
                                            <td class="main"><b><?php
                                                echo 'Notes';
?></b></td>
                                            <td class="main"><font color="red"><?php
                                                echo $order->customer ['notes'];
?></font></td>
                                        <tr>





                                        <tr>
                                            <td colspan="2"><?php
                                                echo tep_draw_separator('pixel_trans.gif', '1', '5');
?></td>
                                    </tr>

                                                <?php } ?>
                                    <tr>
                                        <td class="main"><b>Customers Name:</b></td>
                                        <td class="main"><?php
                                                echo $order->customer ['name'] . '&nbsp;<a href="http://www.google.com/search?q=' . $order->customer ['name'] . '" target="_blank" class="spc"><input style="text-decoration:none;" type="button" value="Check Name" /></a>';
                                                ?></td>
                                    </tr>
                                    <tr>
                                        <td class="main"><b><?php
                                                echo ENTRY_TELEPHONE_NUMBER;
                                                ?></b></td>
                                        <td class="main"><?php
                                                echo $order->customer ['telephone'] . '&nbsp;<a href="http://www.google.com/search?q=' . $order->customer ['telephone'] . '" target="_blank" class="spc"><input style="text-decoration:none;" type="button" value="Check Number" /></a>';
                                                ?></td>
                                    </tr>
<?php
// BOF: WebMakers.com Added: Downloads Controller - Extra order info
?>
                                    <tr>
                                        <td class="main"><b><?php echo 'FAX #:'; ?></b></td>
                                            <td class="main"><?php echo $the_customers_fax; ?></td>
                                        </tr>
<?php
// EOF: WebMakers.com Added: Downloads Controller
?>
                                                <tr>
                                                    <td class="main"><b><?php
                                                echo ENTRY_EMAIL_ADDRESS;
?></b></td>
                                            <td class="main"><?php
                                                echo '<a href="mailto:' . $order->customer ['email_address'] . '"><u>' . $order->customer ['email_address'] . '</u></a>' . '&nbsp;<a href="http://www.google.com/search?q=' . $order->customer ['email_address'] . '" target="_blank" class="spc"><input style="text-decoration:none;" type="button" value="Check Email" /></a>';
                                                ;
?></td>
                                        </tr>
                                        <tr>
                                            <td class="main"><b>Order I.P. Address</b></td>
                                            <td class="main"><?php
                                                echo $order->info ['ip_address'];
?></td>
                                        </tr>
                                        <tr>
                                            <td class="main"><b>Order IP Location:</b></td>
                                            <td class="main">
<?php
                                                if ($is_amazon_order == 1)$order->info['ip_location'] = 'Amazon';
                                                if ($order->info['ip_location'] == '' || (strtolower($order->info['ip_location']) == 'discontinued')) {
//                                                    $lookup = CheckIpLocation($order->info['ip_address']);
//                                                    if (isset($lookup['error']) && $lookup['error'] != '') {
//                                                        $ip_location = $lookup['error'];
//                                                    } else {
//                                                        $ip_location = $lookup['city'] . ', ' . $lookup['region_name'] . ', ' . $lookup['country_name'] . ' ' . ($lookup['postcode'] != '' ? $lookup['postcode'] : '');
//                                                    }
//
//                                                    tep_db_query("update orders set ip_location='" . tep_db_input($ip_location) . "' where orders_id = '" . (int) $HTTP_GET_VARS ['oID'] . "'");
//                                                    echo $ip_location;
                                                } else {
                                                    echo $order->info ['ip_location'];
                                                }
?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="main"><b>Regisration I.P. Address</b></td>
                                            <td class="main"><?php
                                                $custIPQuery = tep_db_query("select ip_address from customers where customers_id = '" . $order->customer['customer_id'] . "'");
                                                $custIP = tep_db_fetch_array($custIPQuery);
                                                echo $custIP['ip_address'] ? $custIP['ip_address'] : 'IP information not available.';
?></td>
                                        </tr>
                                        <tr>
                                            <td class="main"><b>Regisration I.P. Location</b></td>
                                            <td class="main"><?php
                                                if ($is_amazon_order == 1
                                                    )$regIpLocation = 'Amazon';
                                                if ($custIP['ip_address'] != '') {
//                                                    $lookup = CheckIpLocation($custIP['ip_address']);
//                                                    if (isset($lookup['error']) && $lookup['error'] != '') {
//                                                        $regIpLocation = $lookup['error'];
//                                                    } else {
//                                                        $regIpLocation = $lookup['city'] . ', ' . $lookup['region_name'] . ', ' . $lookup['country_name'] . ' ' . ($lookup['postcode'] != '' ? $lookup['postcode'] : '');
//                                                    }
//                                                    echo $regIpLocation;
                                                } else {
                                                    echo 'IP location not available.';
                                                }
?></td>
                                        </tr>

                            </tr>
                            <tr>
                                <td class="main"><b><?php echo '# of Orders: '; ?></b></td>
<?php
                                                $count_orders_query = tep_db_query("select count(*) as total from orders where orders_status != '100001' and orders_status != '100003' and customers_id = '" . (int) $the_customers_id . "'");
                                                $count_orders = tep_db_fetch_array($count_orders_query);
                                                $total_orders = $count_orders['total'];
?>
                                <td class="main"><a href="customer_order.php?customer_id=<?=(int) $the_customers_id . '&oID=' . $oID; ?>"><u><?php echo $total_orders; ?></u></a></td>
                        </tr>
                        <tr>
                            <td class="main"><b>Follow-up Email:</b></td>
                            <td class="main"><?php if($order->customer['is_customer_blacklisted'] != '1'){
                                            echo $order->info['order_follow_email_sent_on'];}
?></td>
                        </tr>
                        <tr>
                            <td class="main"><b>We Miss You Email:</b></td>
                            <td class="main"><?php
                            if($order->customer['is_customer_blacklisted'] != '1'){
                                            echo $order->info['we_miss_you_email_sent_on'];}
?></td>
                        </tr>

                        <tr>
                            <td class="main"><b>Reviewed Order:</b></td>
                            <td class="main"><?php
                                            $comment_added = 'No';
                                            for ($y = 0; $y <= sizeof($order->products); $y++) {
                                                $sql = tep_db_query("select count(*) as total from products_comments where products_id = '" . $order->products[$y]['id'] . "' and (customers_id = '" . $order->customer['customer_id'] . "' or customers_email_address = '" . $order->customer['email_address'] . "')");
                                                //	echo "select count(*) as total from products_comments where products_id = '".$order->products[$y]['id']."' and (customers_id = '".$order->customer['customer_id']."' or customers_email_address = '".$order->customer['email_address']."')";
                                                $arr = tep_db_fetch_array($sql);
                                                if ($arr['total'] > 0) {
                                                    $comment_added = 'Yes';
                                                    break;
                                                } else {
                                                    $comment_added = 'No';
                                                }
                                            }
                                            echo $comment_added;
?></td>
                                        </tr>
										<?php
										$aff_order_id_query = tep_db_query("select aa.affiliate_firstname, aa.affiliate_lastname from affiliate_affiliate aa, affiliate_sales asa where aa.affiliate_id = asa.affiliate_id and asa.affiliate_orders_id = '" . (int) $HTTP_GET_VARS ['oID'] . "' ");
										if(tep_db_num_rows($aff_order_id_query)){
										$aff_order_detail = tep_db_fetch_array($aff_order_id_query);
										?>
										<tr>
                            				<td class="main"><b>Affiliate Sale:</b></td>
											<td class="main"><a href="<?php echo tep_href_link('affiliate_sales.php'); ?>" target="_blank" ><?php echo $aff_order_detail['affiliate_firstname'] . ' ' . $aff_order_detail['affiliate_lastname'] ; ?></a></td>
										</tr>
										<?php
										}
										?>
                                    </table></td>
                                <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                        <tr>
                                            <td class="main" valign="top"><b><?php echo ENTRY_SHIPPING_ADDRESS; ?></b></td>
                                            <?php 
                                                                                                                            //print_r($order->delivery['country']);
                                            $delivery_str  = $order->delivery['street_address'].','.($order->delivery['suburb'] != ''? $order->delivery['suburb'].',':'').($order->delivery['city'] != ''? $order->delivery['city'].',':'').$order->delivery['postcode'].','.$order->delivery['state'].','.$order->delivery['country']['title'];
                                            $delivery_str = str_replace(' ', '+', $delivery_str)
                                            ?>
                                        <td class="main">

                                            <?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br>'); ?><br />
<!--                                            --><?php
//                                            $urlsss = $_SERVER[HTTP_HOST];
//
//                                            if (strpos($urlsss,'www.test.healingcrystals.com:8888') !== false) {
//
//                                                echo '<a href="http://' . $_SERVER['HTTP_HOST'] . '/sendinvoice_pdf.php?oID=' . $HTTP_GET_VARS ['oID'] . '&generate_from_admin=true">' . tep_image_button('button_customer_invoice.gif', 'Print master invoice that was created at checkout') . '</a>
//                                            &nbsp;<a href="http://' . $_SERVER['HTTP_HOST'] . '/admininvoice_pdf.php?oID=' . $HTTP_GET_VARS ['oID'] . '&generate_from_admin=true">' . tep_image_button('button_packing_invoice.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>
//                                            &nbsp;<a href="http://' . $_SERVER['HTTP_HOST'] . '/hcmin/createPackingList.php?oID=' . $HTTP_GET_VARS ['oID'] . '">' . tep_image_button('button_packinglist.gif', 'Packing List') . '</a>&nbsp;&nbsp;';
//                                            }else{
//                                            echo '<a href="https://' . $_SERVER['HTTP_HOST'] . '/sendinvoice_pdf.php?oID=' . $HTTP_GET_VARS ['oID'] . '&generate_from_admin=true">' . tep_image_button('button_customer_invoice.gif', 'Print master invoice that was created at checkout') . '</a>
//                                            &nbsp;<a href="https://' . $_SERVER['HTTP_HOST'] . '/admininvoice_pdf.php?oID=' . $HTTP_GET_VARS ['oID'] . '&generate_from_admin=true">' . tep_image_button('button_packing_invoice.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>
//                                            &nbsp;<a href="https://' . $_SERVER['HTTP_HOST'] . '/hcmin/createPackingList.php?oID=' . $HTTP_GET_VARS ['oID'] . '">' . tep_image_button('button_packinglist.gif', 'Packing List') . '</a>&nbsp;&nbsp;';
//                                            }
//                                            ?>
                                            <input type="button" name="Edit" value="Edit" onClick="popupWindow('edit_shipping_address.php?oID=<?= $oID ?>')"/>&nbsp;<a href="https://maps.google.com/maps?q=<?php echo $delivery_str;?>" target="_blank" class="spc"><input type="button" value="Google Map"/></a>






                                        </td>
                                    </tr>
                                </table></td>
                                <!-- td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                  <tr>
                                    <td class="main" valign="top"><b><?php echo ENTRY_BILLING_ADDRESS; ?></b></td>
                                    <td class="main"><?php echo tep_address_format($order->billing['format_id'], $order->billing, 1, '', '<br>'); ?></td>
                                  </tr>
                                </table></td//-->
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
            <tr>
                <td><table border="0" cellspacing="0" cellpadding="2">
<?php
// BOF: WebMakers.com Added: Show Order Info
?>
                        <!-- add Order # // -->
                                <?php if ($order->customer['is_customer_blacklisted'] == '1') {
 ?>
                            <tr>
                                <td class="main" colspan="2"><font color="red">
                                        This customer is currently blacklisted. An email alert will be sent if this customer places another order.</font></td>
                            </tr>
<?php } ?>
                        <tr>
                            <td class="main"><b>Order # </b></td>
                            <td class="main"><?php echo tep_db_input($oID); ?>&nbsp;&nbsp;&nbsp;<a href="http://help-desk.healingcrystals.com/staff/index.php?_m=tickets&_a=manageorders&orderid=<?php echo $oID; ?>" class="spc" target="_blank"><input type="button" value="Help Desk Tickets"></a>&nbsp;&nbsp;</td>
                        </tr>
                        <!-- add date/time // -->
                        <tr>
                            <td class="main"><b>Order Date & Time</b></td>
                            <td class="main"><?php echo tep_datetime_short($order->info['date_purchased']); ?></td>
                        </tr>
                        <!-- add date/time // -->
                        <?php if($order->info['order_admin'] != 'Showroom'){?>
                        <tr>
                            <td class="main"><b><?php echo TEXT_ADMIN ?></b></td>
                                                <td class="main"><?php echo $order->info['order_admin']; ?></td>
                                            </tr>
                                            <?php }
                                            
                                            if($order->info['order_admin'] != 'Showroom'){?>
                                            <tr>
                                                <td class="main"><b><?php echo TEXT_CUSTOMER_ADMIN ?></b></td>
                                                <td class="main"><?php echo $order->customer['admin']; ?></td>
                                            </tr>
                                            <?php }else{
                                                ?>
                                            <tr>
                                                <td class="main"><b><?php echo 'Ordered From:'; ?></b></td>
                                                <td class="main"><?php echo $order->info['order_admin']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="main"><b><?php echo TEXT_CUSTOMER_ADMIN ?></b></td>
                                                <td class="main"><?php echo $order->customer['admin']; ?></td>
                                            </tr>
<?php
                                            } ?>
                                            
<?php                   
// EOF: WebMakers.com Added: Show Order Info
                                            if (preg_match('/paypal/i', $order->info['payment_method']) && preg_match('/express/i', $order->info['payment_info'])) {
                                                $method = 'Paypal Express';
                                            } elseif (preg_match('/paypal/i', $order->info['payment_method']) && (preg_match('/credit card/i', $order->info['payment_info']) || preg_match('/Direct/i', $order->info['payment_info']))) {
                                                $method = 'Credit Card - Paypal';
                                            } elseif (preg_match('/authorize.net/i', $order->info['payment_method'])) {
                                                $method = 'Credit Card - Authorize.net';
                                            } else {
                                                $method = $order->info['payment_method'];
                                            }
?>
                                            <tr>
                                                <td class="main"><b><?php echo ENTRY_PAYMENT_METHOD; ?></b></td>
                                                <td class="main">
<?php
                                            echo ($is_amazon_order ? $order->info['payment_method'] : $order->info['payment_info']);
                                            //echo $order->info['payment_info'];//$method;
?>
                                                </td>
                                            </tr>
            <?php
//authorize here
// {{

                                            switch (MODULE_PAYMENT_AUTHORIZENET_TYPE) {
                                                case 'Auth':
                                                    $type = 'AUTH_ONLY';
                                                    break;
                                                case 'Capture':
                                                    $type = 'AUTH_CAPTURE';
                                                    break;
                                                default:
                                                    $type = 'AUTH_CAPTURE';
                                                    break;
                                            }

                                            $res = tep_db_query("SELECT authorize_trx_id, authorize_finished, capture_date FROM " . TABLE_ORDERS . " WHERE orders_id = " . tep_db_input($oID));
                                            $data = tep_db_fetch_array($res);
                                            if (tep_not_null($data['authorize_trx_id'])) {
            ?>
                                        <tr>
                                            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="main"><?php echo 'Credit Card Name'; ?></td>
                                                    <td class="main"><?php echo stripslashes($order->info['cc_owner']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="main"><?php echo AUTHORIZE_TRANSACTION_CODE; ?></td>
                                                    <td class="main"><?php echo $data['authorize_trx_id']; ?></td>
                                                </tr>
                                                
            <?php
                                                if ($data['authorize_finished'] == '1') {
            ?>
                                                    <tr>
                                                        <td class="main"><?php echo AUTHORIZE_TRANSACTION_CAPTURED; ?></td>
                                                        <td class="main"><?php echo tep_date_long($data['capture_date']); ?></td>
                                                    </tr>
            <?php
                                                } elseif ($data['authorize_finished'] == '2') {
            ?>
                                                    <tr>
                                                        <td class="main"><?php echo 'Transaction Voided'; ?></td>
                                                        <td class="main"><?php echo tep_date_long($data['capture_date']); ?></td>
                                                    </tr>
<?php
                                                } else {
                                                    // if orders_status == delivered - allow complete transaction
                                                    /*        if( $order->info['orders_status'] == MODULE_PAYMENT_IPAYMENT_DELIVERED_STATUS_ID )
                                                      {
                                                      global $HTTP_SERVER_VARS, $order, $customer_id;
                                                     */
                                                    $process_button_string = tep_draw_hidden_field('x_Login', MODULE_PAYMENT_AUTHORIZENET_LOGIN) .
                                                            tep_draw_hidden_field('x_Tran_Key', MODULE_PAYMENT_AUTHORIZENET_TXNKEY) .
//        x_tran_key
                                                            tep_draw_hidden_field('x_trans_id', $data['authorize_trx_id']) .
                                                            tep_draw_hidden_field('x_Description', '') .
                                                            tep_draw_hidden_field('x_Card_Num', $order->info['cc_number']) .
                                                            tep_draw_hidden_field('x_Exp_Date', $order->info['cc_expires']) .
                                                            tep_draw_hidden_field('x_Amount', number_format($order->info['total'], 2)) .
                                                            tep_draw_hidden_field('x_ADC_Delim_Data', 'TRUE') .
                                                            tep_draw_hidden_field('x_ADC_URL', 'FALSE') .
                                                            tep_draw_hidden_field('x_Type', 'PRIOR_AUTH_CAPTURE') . //AUTH_CAPTURE, AUTH_ONLY
                                                            tep_draw_hidden_field('x_Method', ((MODULE_PAYMENT_AUTHORIZENET_METHOD == 'Credit Card') ? 'CC' : 'ECHECK')) .
                                                            tep_draw_hidden_field('x_Version', '3.1') .
                                                            tep_draw_hidden_field('x_Cust_ID', $customer_id) .
                                                            tep_draw_hidden_field('x_Email_Customer', ((MODULE_PAYMENT_AUTHORIZENET_EMAIL_CUSTOMER == 'True') ? 'TRUE' : 'FALSE')) .
                                                            tep_draw_hidden_field('x_Email_Merchant', ((MODULE_PAYMENT_AUTHORIZENET_EMAIL_MERCHANT == 'True') ? 'TRUE' : 'FALSE')) .
                                                            /*                               tep_draw_hidden_field('x_first_name', $order->billing['name']) .
                                                              tep_draw_hidden_field('x_last_name', $order->billing['name']) .
                                                              tep_draw_hidden_field('x_address', $order->billing['street_address']) .
                                                              tep_draw_hidden_field('x_city', $order->billing['city']) .
                                                              tep_draw_hidden_field('x_state', $order->billing['state']) .
                                                              tep_draw_hidden_field('x_zip', $order->billing['postcode']) .
                                                              tep_draw_hidden_field('x_country', $order->billing['country']['title']) .
                                                              tep_draw_hidden_field('x_phone', $order->customer['telephone']) .
                                                              tep_draw_hidden_field('x_email', $order->customer['email_address']) .
                                                              tep_draw_hidden_field('x_ship_to_first_name', $order->delivery['firstname']) .
                                                              tep_draw_hidden_field('x_ship_to_last_name', $order->delivery['lastname']) .
                                                              tep_draw_hidden_field('x_ship_to_address', $order->delivery['street_address']) .
                                                              tep_draw_hidden_field('x_ship_to_city', $order->delivery['city']) .
                                                              tep_draw_hidden_field('x_ship_to_state', $order->delivery['state']) .
                                                              tep_draw_hidden_field('x_ship_to_zip', $order->delivery['postcode']) .
                                                              tep_draw_hidden_field('x_ship_to_country', $order->delivery['country']['title']) . */
                                                            tep_draw_hidden_field('x_Customer_IP', $HTTP_SERVER_VARS['REMOTE_ADDR']);
                                                    if (MODULE_PAYMENT_AUTHORIZENET_TESTMODE == 'Test')
                                                        $process_button_string .= tep_draw_hidden_field('x_Test_Request', 'TRUE');

                                                    $process_button_string .= tep_draw_hidden_field(tep_session_name(), tep_session_id());
?>
                                                    <tr>
                                                    <form action="<?php echo tep_href_link(FILENAME_ORDERS_CAPTURE, tep_get_all_get_params()); ?>" method="post">
                                                        <td>
            <?php echo $process_button_string; ?><input type="Submit" value=" <?php echo AUTHORIZE_COMPLETE_TRANSACTION; ?> ">
                                                        </td>
                                                    </form>
            <?php
                                                    $process_button_string = tep_draw_hidden_field('x_Login', MODULE_PAYMENT_AUTHORIZENET_LOGIN) .
                                                            tep_draw_hidden_field('x_Tran_Key', MODULE_PAYMENT_AUTHORIZENET_TXNKEY) .
                                                            tep_draw_hidden_field('x_trans_id', $data['authorize_trx_id']) .
                                                            tep_draw_hidden_field('x_Description', '') .
                                                            tep_draw_hidden_field('x_Card_Num', $order->info['cc_number']) .
                                                            tep_draw_hidden_field('x_Exp_Date', $order->info['cc_expires']) .
                                                            tep_draw_hidden_field('x_Amount', number_format($order->info['total'], 2)) .
                                                            tep_draw_hidden_field('x_ADC_Delim_Data', 'TRUE') .
                                                            tep_draw_hidden_field('x_ADC_URL', 'FALSE') .
                                                            tep_draw_hidden_field('x_Type', 'VOID') .
                                                            tep_draw_hidden_field('x_Method', ((MODULE_PAYMENT_AUTHORIZENET_METHOD == 'Credit Card') ? 'CC' : 'ECHECK')) .
                                                            tep_draw_hidden_field('x_Version', '3.1') .
                                                            tep_draw_hidden_field('x_Cust_ID', $customer_id) .
                                                            tep_draw_hidden_field('x_Email_Customer', ((MODULE_PAYMENT_AUTHORIZENET_EMAIL_CUSTOMER == 'True') ? 'TRUE' : 'FALSE')) .
                                                            tep_draw_hidden_field('x_Email_Merchant', ((MODULE_PAYMENT_AUTHORIZENET_EMAIL_MERCHANT == 'True') ? 'TRUE' : 'FALSE')) .
                                                            tep_draw_hidden_field('x_Customer_IP', $HTTP_SERVER_VARS['REMOTE_ADDR']);
                                                    if (MODULE_PAYMENT_AUTHORIZENET_TESTMODE == 'Test')
                                                        $process_button_string .= tep_draw_hidden_field('x_Test_Request', 'TRUE');

                                                    $process_button_string .= tep_draw_hidden_field(tep_session_name(), tep_session_id());
            ?>
                                                    <form action="<?php echo tep_href_link(FILENAME_ORDERS_VOID, tep_get_all_get_params()); ?>" method="post">
                                                <td>
<?php echo $process_button_string; ?><input type="Submit" value=" Void ">
                                                </td>
                                            </form>
                                </tr>
            <?php
                                                }
                                            }
                                            //     }
// }}
//end of authorize here
            ?>

                                <tr>
                                    <td class="main">
            <?php
                                            if ($order->info['payment_class'] == 'cnet') {
                                                $data = tep_db_fetch_array(tep_db_query('select capture_date, settlement_date, transaction_id, approval_code from ' . TABLE_ORDERS . ' where orders_id=' . tep_db_input($oID)));
                                                if (!tep_not_null($data['approval_code'])) {
                                                    $process_button_string =
                                                            tep_draw_hidden_field('merchantId', MODULE_PAYMENT_CNET_MERCHANT_ID) .
                                                            tep_draw_hidden_field('terminalId', MODULE_PAYMENT_CNET_TERMINAL_ID) .
                                                            tep_draw_hidden_field('amount', number_format(tep_round($order->info['total'], 2), 2)) .
                                                            tep_draw_hidden_field('tax', number_format(tep_round($order->info['tax'], 2), 0)) .
                                                            tep_draw_hidden_field('cardNum', $CardNumber) .
                                                            tep_draw_hidden_field('expDate', date("my", mktime(0, 0, 0, $this->cc_expires_month, 1, $order->info['cc_expires']))) .
                                                            tep_draw_hidden_field('verificationCode', $order->info['cc_cvv']) .
                                                            tep_draw_hidden_field('transactionNum', $order->customer['customer_id'] . date('i')) .
                                                            tep_draw_hidden_field('requestType', MODULE_PAYMENT_CNET_REQUEST_TYPE) .
                                                            tep_draw_hidden_field('avsAddress', $order->billing['street_address'] . ' ' . $order->billing['suburb'] . ' ' . $order->billing['city']) .
                                                            tep_draw_hidden_field('avsZip', $order->billing['postcode']) .
                                                            tep_draw_hidden_field('cc_card_type', $order->info['cc_type']) .
                                                            tep_draw_hidden_field('cc_fullname', $order->info['cc_owner']) .
                                                            tep_draw_hidden_field('osCsid', tep_session_id());
            ?>
                                                            <form action="<?php echo tep_href_link('orders_void.php', tep_get_all_get_params()); ?>" method="post">
<?php echo $process_button_string; ?><input type="Submit" value=" Capture ">
                                                            </form>
<?php
                                                } else {
                                                    echo AUTORIZATION_DATE . tep_datetime_short($data['capture_date']) . '<br>';
                                                    echo APPROVAL_CODE . $data['approval_code'] . '<br>';
                                                    if (tep_not_null($data['settlement_date']))
                                                        echo SETTLEMENT_DATE . tep_datetime_short($data['settlement_date']) . '<br>';
                                                }
                                            }
?>
                                        </td>
                                    </tr>

        <?php
                                            $raw_date = $order->info['date_purchased'];
                                            $year = (int) substr($raw_date, 0, 4);
                                            $month = (int) substr($raw_date, 5, 2);
                                            $day = (int) substr($raw_date, 8, 2);
                                            $hour = (int) substr($raw_date, 11, 2);
                                            $minute = (int) substr($raw_date, 14, 2);
                                            $second = (int) substr($raw_date, 17, 2);
                                            $order_time = mktime($hour, $minute, $second, $month, $day, $year) + (90 * 24 * 60 * 60);
                                            if (tep_not_null($order->info['cc_type']) || tep_not_null($order->info['cc_owner']) || tep_not_null($order->info['cc_number'])) {
                                                if ($order_time > time()) {
        ?>
                                        <tr>
                                            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="main"><?php echo ENTRY_CREDIT_CARD_TYPE; ?></td>
                                                <td class="main"><?php echo $order->info['cc_type']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="main"><?php echo ENTRY_CREDIT_CARD_OWNER; ?></td>
                                                <td class="main"><?php echo stripslashes($order->info['cc_owner']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="main"><?php echo ENTRY_CREDIT_CARD_NUMBER; ?></td>
                                                        <td class="main"><?php
                                                    if ($HTTP_GET_VARS['decrypt'] == 1) {
                                                        if ($super_user == 0) {
                                                            if ($HTTP_GET_VARS['password'] == 'wrong') {
                                                                echo '<span align="center">Invalid Password Given for Decryption! Try Again! </span>';
                                                            }
                                                            echo '<div align="center"><form action="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=super_login') . '" method="post"><table><tr><td>Password:</td><td><input type="password" name="super_password"></td><input type="hidden" name="encrypted_cc_number" value="' . $order->info['encrypted_cc_number'] . '"><input type="hidden" name="encrypted_cc_cvn" value="' . $order->info['encrypted_cc_cvn'] . '"><input type="hidden" name="encrypted_cc_expires" value="' . $order->info['encrypted_cc_expires'] . '"></tr><tr><td colspan="2"><input type="submit" value="submit" name="Go"></td></tr></table></form></div> ';
                                                        }
                                                    }
                                                    if (tep_not_null($order->info['encrypted_cc_number']) && ($super_user == 0)) {
                                                        $HTTP_GET_VARS['decrypt'] = 1;
                                                        echo '--hidden--&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=edit') . '"><input type="button" name="decrypt" value="Decrypt"></a>&nbsp;';
                                                    } elseif ($super_user == '1' && ($order->info['encrypted_cc_number'] != '')) {
                                                        echo GPGDecrypt($order->info['encrypted_cc_number'], '51213E37', $super_password);
                                                    } else {
                                                        echo $order->info['cc_number'];
                                                    }
        ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="main"><?php echo ENTRY_CVN_NUMBER; ?></td>
                                                        <td class="main"><?php
                                                    if (tep_not_null($order->info['encrypted_cc_cvn']) && ($super_user == 0)) {

                                                        $HTTP_GET_VARS['decrypt'] = 1;
                                                        echo '--hidden--&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=edit') . '"><input type="button" name="decrypt" value="Decrypt"></a>&nbsp;';
                                                    } elseif ($super_user == '1' && ($order->info['encrypted_cc_cvn'] != '')) {
                                                        echo GPGDecrypt($order->info['encrypted_cc_cvn'], '51213E37', $super_password);
                                                    } else {
                                                        echo $order->info['cc_cvn'];
                                                    } ?></td>
                                            </tr>
                                            <tr>
                                                <td class="main"><?php echo ENTRY_CREDIT_CARD_EXPIRES; ?></td>
                                                <td class="main"><?php
                                                    if (tep_not_null($order->info['encrypted_cc_expires']) && ($super_user == 0)) {

                                                        $HTTP_GET_VARS['decrypt'] = 1;
                                                        echo '--hidden--&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=edit') . '"><input type="button" name="decrypt" value="Decrypt"></a>&nbsp;';
                                                    } elseif ($super_user == '1' && ($order->info['encrypted_cc_expires'] != '')) {
                                                        echo GPGDecrypt($order->info['encrypted_cc_expires'], '51213E37', $super_password);
                                                    } else {
                                                        echo $order->info['cc_expires'];
                                                    }
        ?></td>
                                            </tr>
        <?php
                                                } else {
        ?>
                                            <tr>
                                                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="main"><?php echo ENTRY_CREDIT_CARD_TYPE; ?></td>
                                                <td class="main"><?php echo 'Hidden'; //$order->info['cc_type'];  ?></td>
                                            </tr>
                                            <tr>
                                                <td class="main"><?php echo ENTRY_CREDIT_CARD_OWNER; ?></td>
                                                <td class="main"><?php echo 'Hidden'; //$order->info['cc_owner']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="main"><?php echo ENTRY_CREDIT_CARD_NUMBER; ?></td>
                                                <td class="main"><?php echo 'Hidden'; //$order->info['cc_number']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="main"><?php echo ENTRY_CVN_NUMBER; ?></td>
                                                <td class="main"><?php echo 'Hidden'; //$order->info['cc_cvn']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="main"><?php echo ENTRY_CREDIT_CARD_EXPIRES; ?></td>
                                                        <td class="main"><?php echo 'Hidden'; //$order->info['cc_expires']; ?></td>
                                                    </tr>
<?php
                                                }
                                            }
?>
                                            <script type="text/javascript">
                                            var keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

                                            function encode64(input) {
                                            var output = "";
                                            var chr1, chr2, chr3;
                                            var enc1, enc2, enc3, enc4;
                                            var i = 0;

                                            do {
                                                chr1 = input.charCodeAt(i++);
                                                chr2 = input.charCodeAt(i++);
                                                chr3 = input.charCodeAt(i++);

                                                enc1 = chr1 >> 2;
                                                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                                                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                                                enc4 = chr3 & 63;

                                                if (isNaN(chr2)) {
                                                    enc3 = enc4 = 64;
                                                } else if (isNaN(chr3)) {
                                                    enc4 = 64;
                                                }

                                                output = output + keyStr.charAt(enc1) + keyStr.charAt(enc2) +
                                                    keyStr.charAt(enc3) + keyStr.charAt(enc4);
                                            } while (i < input.length);

                                            return output;
                                            }
                                            function addOptionToInventory(uprid){
                                            var value = prompt('Enter Units to Add back into Inventory!');
                                            if(value>0){
                                                var url = '<?php echo tep_href_link('orders.php', tep_get_all_get_params(array('action'))); ?>'+'&action=addOptionToInventory&uprid='+uprid+'&value='+value;
                                                location.href = url;
                                            }else return false;
                                            }
                                            function removeOptionFromInventory(uprid){
                                            var value = prompt('Enter Units to Remove from Inventory!');
                                            if(value>0){
                                                var url = '<?php echo tep_href_link('orders.php', tep_get_all_get_params(array('action'))); ?>'+'&action=removeOptionFromInventory&uprid='+uprid+'&value='+value;
                                                checkUnits('<?php echo $HTTP_GET_VARS['oID']; ?>', 'single', value, uprid, url);
                                            }else return false;
                                            }
                                            
                                            function checkPaymentMethod(tid, value, password , payment_via){
                                            var encryptedPassword = encode64(password);

                                                
                                                    if(encryptedPassword=='cmVmdW5kczk5OTk='){
                                                        if(payment_via == 'paypal'){                                                   
                                                            if(tid!='-' && value!=''){
                                                                location.href = 'orders.php?action=refund_paypal&transaction_id='+tid+'&value='+value+'&oID=<?php echo $HTTP_GET_VARS['oID']; ?>&old_action=edit';
                                                            }else if(value==''){
                                                                alert('Please specify amount to be refunded');
                                                            }else{
                                                                alert('We can only refund payments made by Paypal at this time');
                                                            }
                                                        }else if (payment_via == 'authorizenet'){
                                                            //var super_password = $('input[name=super_password]').val();
                                                            //if(super_password != ''){
                                                            if(tid!='-' && value!=''){
                                                                //$('input[name=super_password]').val(super_password);
                                                                $('#refund_authorize').submit();
                                                                //location.href = 'orders.php?action=refund_authorize&transaction_id='+tid+'&value='+value+'&oID=<?php echo $HTTP_GET_VARS['oID']; ?>&old_action=edit&super_password='+super_password;
                                                            }else if(value==''){
                                                                alert('Please specify amount to be refunded');
                                                            }else{
                                                                alert('We can only refund payments made by Authorize.net at this time');
                                                            }
                                                            /*}else{
                                                                alert('Please entered the Password to decrypt the Credit Card Information');
                                                                $('input[name=super_password]').focus();
                                                                return false;
                                                            }*/
                                                        }else{
                                                    alert('You have entered wrong Password!');
                                                    return false;
                                                }
                                                    }else{
                                                        alert('You have entered wrong Password!');
                                                        return false;
                                            }
                                                                                           
                                            }
                                            </script>
<?php
                                            $orders_paypal_query = tep_db_query("select comments from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . (int) $HTTP_GET_VARS['oID'] . "' order by date_added");
                                            if (tep_db_num_rows($orders_paypal_query)) {
                                                $paypal_comments = '';
                                                while ($orders_paypal = tep_db_fetch_array($orders_paypal_query)) {
                                                    if (preg_match("/Transaction ID/i", $orders_paypal['comments'])) {
                                                        $paypal_comments = $orders_paypal['comments'];
                                                        break;
                                                    }
                                                }
                                            }
                                            $transaction_id = '-';
                                            if ($paypal_comments != '') {
                                                $tid_array = explode('Payment Type', $paypal_comments);
                                                $tid_array_2 = explode(':', $tid_array[0]);
                                                $transaction_id = trim($tid_array_2[1]);
                                                
                                                if(strstr($tid_array[1], 'Authorize.net')){
                                                    $payment_via = 'authorizenet';
                                                }else{
                                                    $payment_via = 'paypal';
                                                }
                                            }
?>
                                            <tr>
                                                <td class="main">Additional Charge:</td>
                                                <td class="main">
                                                    <input type="text" name="additional_charge" id="additional_charge"/>
                                                </td>
                                            </tr>
<?php
                                            $string = '';
                                            if ($HTTP_GET_VARS['ac_password'] == 'wrong'
                                                )$string = 'bgcolor="red"'; ?>
                                            <tr>
                                                <td class="main" <?= $string; ?>>Password for Additional Charge:</td>
    <td class="main" <?= $string; ?>>
        <input type="password" name="ac_paswword" id="ac_password"/>
        <input type="submit" name="Charge Customer" value="Charge Customer" onClick="location.href='/hcmin/orders.php?action=charge_customer&oID='+<?= $HTTP_GET_VARS['oID']; ?>+'&amount='+document.getElementById('additional_charge').value+'&password='+document.getElementById('ac_password').value"/>
<?php if ($HTTP_GET_VARS['ac_password'] == 'wrong')
    echo'Wrong Password given!'; ?>
    </td>
</tr>
<tr><td colspan="2">
<form name="refund_amount" id="refund_authorize" action="orders.php?oID=<?php echo $_GET['oID'];?>&action=refund_authorize&old_action=edit" method="post" >
<table style="background-color:#C9F5FF;">
<tr>
    <td class="main">Refund Amount:</td>
    <td class="main">
        <input type="text" name="refund_amount" id="refund_amount"></td>
</tr>
<tr>
    <?php if($payment_via == 'authorizenet'){?>
        
    <td class="main">Password for Refund:</td>
    <td class="main">
        <input type="password" name="paypal_password" id="paypal_password">
        
        <input type="hidden" name="transaction_id" value="<?php echo $transaction_id; ?>">
        <input type="button" name="Issue Refund!" value="Issue Refund" onClick="checkPaymentMethod('<?php echo $transaction_id; ?>', document.getElementById('refund_amount').value, document.getElementById('paypal_password').value,  '<?php echo $payment_via; ?>');"></td><?/*</tr>
<tr><td>Password to Decrypt Credit Card Information : </td><td><input type="password" name="super_password" ></td>
    */
         }else{?>
            
            
    <td class="main">Password for Refund:</td>
    <td class="main">
        
        <input type="password" name="paypal_password" id="paypal_password">

        <input type="button" name="Issue Refund!" value="Issue Refund" onClick="checkPaymentMethod('<?php echo $transaction_id; ?>', document.getElementById('refund_amount').value, document.getElementById('paypal_password').value, '<?php echo $payment_via; ?>');"></td>
    <?php } ?>
</tr></table>
</form></td></tr>

<?php
if ($order->info['currency'] == '') {
    $order->info['currency'] = DEFAULT_CURRENCY;
}
?>
</table></td>
</tr>
<tr>
    <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
</tr>
<tr>
    <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
            <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>
                <td class="dataTableHeadingContent">Weight</td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TAX; ?></td>
                <td class="dataTableHeadingContent" align="center">Cost</td>
                <td class="dataTableHeadingContent" align="center">%</td>
<?php if ($order->info['currency'] != DEFAULT_CURRENCY) { ?>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_PRICE . '(' . $order->info['currency'] . ')'; ?>
<?php } ?>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_PRICE; ?></td>
                <td class="dataTableHeadingContent" align="center">Total Cost</td>
<?php if ($order->info['currency'] != DEFAULT_CURRENCY) {
 ?>
                    <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_TOTAL . '(' . $order->info['currency'] . ')'; ?></td>
<?php } ?>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_TOTAL; ?></td>
            </tr>
<?php
$total_cost = '';
$total_price = '';
for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {
    echo '          <tr class="dataTableRow">' . "\n" . '            <td class="dataTableContentO" valign="top" align="left"><a style="cursor:pointer;" class="addRemove"  onclick="addOptionToInventory(\'' . $order->products[$i]['uprid'] . '\');return false;">[+]</a>&nbsp;&nbsp;<a style="cursor:pointer;" class="addRemove" onclick="removeOptionFromInventory(\'' . $order->products[$i]['uprid'] . '\');return false;">[-]</a>&nbsp;&nbsp;&nbsp;' . $order->products [$i] ['qty'] . '&nbsp;x</td>' . "\n" . '            <td class="dataTableContentO" valign="top">' . stripslashes($order->products [$i] ['name']);

    if (isset($order->products [$i] ['attributes']) && (sizeof($order->products [$i] ['attributes']) > 0)) {
        for ($j = 0, $k = sizeof($order->products [$i] ['attributes']); $j < $k; $j++) {
            echo '<br><nobr>&nbsp;<i> - ' . $order->products [$i] ['attributes'] [$j] ['option'] . ': ' . stripslashes($order->products [$i] ['attributes'] [$j] ['value']);
            $special_price = (int) $order->products [$i] ['attributes'] [$j] ['special_price'];
            if ($special_price > 0) {

                if ($order->products [$i] ['attributes'] [$j] ['price'] != '0')
                    echo ' (' . $order->products [$i] ['attributes'] [$j] ['prefix'] . '<s>' . $currencies->default_format($order->products [$i] ['attributes'] [$j] ['price'], $order->info ['currency']) . '</s> ' . $currencies->format($order->products [$i] ['attributes'] [$j] ['special_price'], $order->info ['currency']) . ')';
            } else {
                if ($order->products [$i] ['attributes'] [$j] ['price'] != '0')
                    echo ' (' . $order->products [$i] ['attributes'] [$j] ['prefix'] . $currencies->default_format($order->products [$i] ['attributes'] [$j] ['price'], $order->info ['currency']) . ')';
            }

            echo '</i></nobr>';
        }
    }
    $linked_cost = '';
    //echo "select linked_options_cost from orders_linked_products_options where orders_products_id = '".$order->products[$i]['opid']."'";
    $linked_options_query = tep_db_query("select linked_options_cost from orders_linked_products_options where orders_products_id = '".$order->products[$i]['opid']."'");
    while($linked_options_array = tep_db_fetch_array($linked_options_query)){
        $linked_cost += $linked_options_array['linked_options_cost'];
    }
    echo '            </td>' . "\n" . '            <td class="dataTableContentO" valign="top"><a href="' . tep_href_link('view_inventory.php', tep_get_all_get_params(array('oID', 'action')) . 'pID=' . $order->products [$i] ['id']) . '">' . $order->products [$i] ['model'] . '</a></td>' . "\n" . '            <td class="dataTableContentO" valign="top">' . tep_get_option_weight($order->products [$i] ['uprid']) . '</td>' . "\n" .
                       '<td class="dataTableContentO" align="right" valign="top">' . tep_display_tax_value($order->products [$i] ['tax']) . '%</td><td class="dataTableContentO" align="right" valign="top">' . ($order->products [$i] ['cost']>0?'$'.number_format($order->products [$i] ['cost'],2):'') .($linked_cost>0?'( +$'.number_format($linked_cost,2).' )':''). '</td><td class="dataTableContentO" align="right" valign="top">' . $order->products [$i] ['cost_of_goods'] . '</td>' . "\n";
		   // '<td class="dataTableContentO" align="right" valign="top">' . tep_display_tax_value($order->products [$i] ['tax']) . '%</td><td class="dataTableContentO" align="right" valign="top">$' . $order->products [$i] ['cost'] .($linked_cost>0?'( +$'.number_format($linked_cost,2).' )':''). '</td><td class="dataTableContentO" align="right" valign="top">' . $order->products [$i] ['cost_of_goods'] . '</td>' . "\n";
    if ($order->info ['currency'] != DEFAULT_CURRENCY) {
        echo '        <td class="dataTableContentO" align="center" valign="top"><b>' . $currencies->format($order->products [$i] ['final_price'], true, $order->info ['currency'], $order->info ['currency_value']) . '</b></td>' . "\n";
    }

    echo '        <td class="dataTableContentO" align="center" valign="top"><b>' . $currencies->default_format($order->products [$i] ['final_price'], $order->info ['currency']) . '</b></td>' . "\n";
   $total_cost += ($order->products [$i] ['cost']* $order->products [$i] ['qty']);
   $total_price += ($order->products [$i] ['final_price'] * $order->products [$i] ['qty']);
    echo '<td class="dataTableContentO" valign="top">' . ($order->products [$i] ['cost']>'0.00'?'$'.number_format($order->products [$i] ['cost']* $order->products [$i] ['qty'],'2'):'' ). '</td>';
    if ($order->info ['currency'] != DEFAULT_CURRENCY) {
        echo '        <td class="dataTableContentO" align="center" valign="top"><b>' . $currencies->format($order->products [$i] ['final_price'] * $order->products [$i] ['qty'], true, $order->info ['currency'], $order->info ['currency_value']) . '</b></td>' . "\n";
    }

    echo '        <td class="dataTableContentO" align="center" valign="top"><b>' . $currencies->default_format($order->products [$i] ['final_price'] * $order->products [$i] ['qty'], $order->info ['currency']) . '</b></td>' . "\n";
    echo '      </tr>' . "\n";
}
?>
            <tr>
            <td align="right" colspan="5">&nbsp;</td>
                <td align="left" colspan="3" class="dataTableContentO">$<?php echo number_format($total_cost, 2); ?> / $<?php echo number_format(($total_price - $total_cost), 2) . '(' . number_format(($total_cost / $total_price * 100), 2) . '%)'; ?></td>
            </tr>
              <tr>
                  <td align="right" colspan="8">
                   <?php echo tep_draw_separator('pixel_trans.gif','100%','10');?>
                  </td>
              </tr>
            <tr>
                <td align="right" colspan="8">
                    <table border="0" cellspacing="0" cellpadding="2">
            <?php

            for ($i = 0, $n = sizeof($order->totals); $i < $n; $i++) {
                if(stripos($order->totals [$i] ['title'],'shipping')!==false && $order->delivery['country']['id']!='223'){
                    $shippingStr = '&nbsp;&nbsp;<td style="cusror:pointer;color:blue;text-decoration:underline;font-weight:bold;" onmouseout="tooltip.hide();" onmouseover="tooltip.show(\'International Shipping Charges are custom programmed to be:<br>- $6.00 Flat Rate for orders under $25.00<br>and<br>- $9.00 Flat Rate + 10% of the order amount for orders over $25.00<br>OR<br>-Actual Priority Mail shipping estimate<br>whichever is less.\');">?</td>';
                }else $shippingStr = '';
                echo '              <tr>' . "\n" . '                <td align="right" class="dataTableContentO">' . $order->totals [$i] ['title'].'</td>' . "\n" . '                <td align="right" class="smallText">' . $currencies->default_format($order->totals [$i] ['value'], $order->info ['currency']) . '</td>' . $shippingStr . "\n" . '              </tr>' . "\n";
            }
            ?>
                    </table>
                </td>
            </tr>
        </table></td>
</tr>
<tr>
    <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
</tr>
<tr>
    <td class="main"><table border="1" cellspacing="0" cellpadding="5">
            <tr>
                <td class="smallText" align="center"><b><?php echo TABLE_HEADING_DATE_ADDED; ?></b></td>
                <td class="smallText" align="center"><b><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></b></td>
                <td class="smallText" align="center"><b><?php echo 'Note Printed'; ?></b></td>
                <td class="smallText" align="center"><b><?php echo TABLE_HEADING_STATUS; ?></b></td>
                <td class="smallText" align="center"><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
            </tr>
                        <?php
                        $orders_history_query = tep_db_query("select comment_printed_on_picking_invoice, orders_status_id, date_added, customer_notified, comments from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . (int) $oID . "' order by date_added");
                        if (tep_db_num_rows($orders_history_query)) {
                            while ($orders_history = tep_db_fetch_array($orders_history_query)) {
                                echo '          <tr>' . "\n" .
                                '            <td class="smallText" align="center">' . tep_datetime_short($orders_history['date_added']) . '</td>' . "\n" .
                                '            <td class="smallText" align="center">';
                                if ($orders_history['customer_notified'] == '1') {
                                    echo tep_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
                                } else {
                                    echo tep_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
                                }
                                echo '            <td class="smallText" align="center">';
                                if ($orders_history['comment_printed_on_picking_invoice'] == '1') {
                                    echo tep_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
                                } else {
                                    echo tep_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
                                }
                                echo '            <td class="smallText">' . $orders_status_array[$orders_history['orders_status_id']] . '</td>' . "\n" .
                                '            <td class="smallText">' . htmlspecialchars_decode(nl2br($orders_history['comments'])) . '&nbsp;</td>' . "\n" .
                                '          </tr>' . "\n";
                            }
                        } else {
                            echo '          <tr>' . "\n" .
                            '            <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
                            '          </tr>' . "\n";
                        }
                        ?>

            <?php

                        $defaultComment = $orders_default_comment_array[$order->info['orders_status']];
            ?>
                    </table></td>
            </tr>
            <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
            </tr>
            <?php echo tep_draw_form('status', FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=update_order', 'post', 'onsubmit="javascript:return status_form_onsubmit();"') . tep_draw_hidden_field('restore', '0');
                //echo tep_draw_form('status', FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=edit', 'post', 'onsubmit="javascript:return status_form_onsubmit();"') . tep_draw_hidden_field('restore', '0');
             ?>
            <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
            <tr>
                <td><table border="0" cellspacing="0" cellpadding="2">
                        <tr>
                            <td><table border="1" cellspacing="0" cellpadding="2">
                                    <tr>
                                        <td class="main" colspan="2"><b><?php echo ENTRY_STATUS; ?></b>
                                            <script type="text/javascript">
                                        function get_amazon_order_status(){
                                            return '5';
                                        }

                                        function status_onchange(drpRef){

                                        }

                                        function status_form_onsubmit(){
                                            var passed = true;
                                            var status = document.getElementById('status');
                                            var divAmzn = document.getElementById('divAmzn');
                                            var txtShipAgt = document.getElementById('txtShipAgt');
                                            var txtTrackID = document.getElementById('txtTrackID');
                                            if(status.options[status.options.selectedIndex].value != oldStatus && (oldStatus == '100005' || oldStatus == '3' || oldStatus == '5')){
                                                var answer = confirm('Are you sure you want to change the order stautus?');
                                                if(answer){
                                                    passed = true;
                                                }else{
                                                    return false;
                                                }
                                            }
                                            if (status.options[status.options.selectedIndex].value==get_amazon_order_status()){
                                                if (txtShipAgt.value==''){
                                                    alert('Enter shipping agent');
                                                    txtShipAgt.focus();
                                                    txtShipAgt.select();
                                                    passed = false
                                                }else if(txtTrackID.value==''){
                                                    alert('Enter shipment tracking ID');
                                                    txtTrackID.focus();
                                                    txtTrackID.select();
                                                    passed = false
                                                }else if('<?php echo $order->info['orders_status'] ?>' == '5'){
                                                    passed = true
                                                }else {
                                                    passed = confirm('This action will initiate the process of firing order fulfillment feed to Amazon.\nTo proceed anyways click "OK" else "Cancel"');
                                                }
                                            }
                                            return passed;
                                        }
                                            </script>
<?php
echo '<script type="text/javascript">var oldStatus = \''.$order->info['orders_status'].'\';</script>';
                        echo tep_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status'], ' id="status"');
                        if ($is_amazon_order) {
                            echo '<div id="divAmzn" style="margin:5px;display:block;background-color:yellow;">' .
                            //'<div id="divAmzn" style="margin:5px;display:none;background-color:yellow;">' .
                            'Ship Agent: <input type="text" id="txtShipAgt" name="txtShipAgt" maxlength="50" size="10" value="' . $amazon_ship_agent . '">' .
                            '&nbsp;&nbsp;' .
                            'Tracking ID: <input type="text" id="txtTrackID" name="txtTrackID" maxlength="50" size="10" value="' . $amazon_track_id . '">' .
                            '</div>';
                        }
?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="main"><b><?php echo ENTRY_NOTIFY_CUSTOMER; ?></b> <?php echo tep_draw_checkbox_field('notify', '', false); ?></td>
                                                    <td class="main"><b><?php echo ENTRY_NOTIFY_COMMENTS; ?></b>

<?php echo tep_draw_checkbox_field('notify_comments', '', true); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="main" colspan="2"><b>Print on Picking Invoice</b> <?php echo tep_draw_checkbox_field('print', '', false); ?></td>

                                                </tr>
                                            </table></td>
                                        <td valign="top"><?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE); ?></td>

                <td valign="top"><a href="<?= tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=add_product'); ?>"><img src="images/button_add_product_inv.gif" alt="Add Product in Inventory" border="0"></a></td>
                <td valign="top" onclick="checkUnits('<?php echo $HTTP_GET_VARS['oID']?>','all','0','0','<?= tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=remove_product');?>')"><img src="images/button_remove_product_inv.gif" alt="Remove Product from Inventory" border="0"></td>
            </tr>
        </table></td>
</tr>
<tr>
    <td colspan="2" align="right"><?php echo '<a href="javascript:popupWindow(\'' . (HTTP_SERVER . DIR_WS_CATALOG . 'invoice/invoice_' . $HTTP_GET_VARS['oID'] . '.pdf') . '\')">' . tep_image_button('button_print_invoice.gif', 'Print master invoice that was created at checkout') . '</a>&nbsp;<a href="javascript:popupWindow(\'' . (HTTP_SERVER . DIR_WS_CATALOG . 'hcmin/invoice_pdf.php?oID=' . $HTTP_GET_VARS['oID']) . '\')">' . tep_image_button('button_old_invoice.gif', 'PDF Invoice (version: August, 2009)') . '</a> <a href="javascript:popupWindow(\'../adminInvoice/invoice_' . $HTTP_GET_VARS ['oID'] . '.pdf\')">' . tep_image_button('button_packing_invoice.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a> <a href="#" onclick="sendInvoice(\'' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action')) . 'action=send_invoice') . '\'); return false;">' . tep_image_button('button_send_invoice.gif', 'Send Invoice') . '</a> <a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('action'))) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
</tr>
<tr>
    <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
</tr>
<tr>
    <td class="main"><br><b><?php echo TABLE_HEADING_COMMENTS; ?>
            <br>

            <input type="button" value="Rich Edit" onClick="edit(comments)">&nbsp;&nbsp;<input type="button" value="Add Pre-defined Text" onClick="updateDefaultComment()">
        </b></td>
</tr>
<tr>
    <td class="main">
<?php echo tep_draw_textarea_field('comments', 'soft', '100', '20', ''); ?></td>

<?php /*
                                  if (HTML_AREA_WYSIWYG_DISABLE_EMAIL == 'Enable') { ?>

                                  <script language="JavaScript1.2" defer>

                                  // MaxiDVD Added WYSIWYG HTML Area Box + Admin Function v1.7 - 2.2 MS2 HTML Email HTML - <body>

                                  var config = new Object();  // create new config object

                                  config.width = "<?php echo EMAIL_AREA_WYSIWYG_WIDTH; ?>px";

                                  config.height = "<?php echo EMAIL_AREA_WYSIWYG_HEIGHT; ?>px";

                                  config.bodyStyle = 'background-color: <?php echo HTML_AREA_WYSIWYG_BG_COLOUR; ?>; font-family: "<?php echo HTML_AREA_WYSIWYG_FONT_TYPE; ?>"; color: <?php echo HTML_AREA_WYSIWYG_FONT_COLOUR; ?>; font-size: <?php echo HTML_AREA_WYSIWYG_FONT_SIZE; ?>pt;';

                                  config.debug = <?php echo HTML_AREA_WYSIWYG_DEBUG; ?>;

                                  editor_generate('comments',config);
                                  </script>

                                  <?php }

                                  // MaxiDVD Added WYSIWYG HTML Area Box + Admin Function v1.7 - 2.2 MS2 HTML Email HTML - <body>
                                 */
?>


                            </form>
                            </tr>

    <?php
                            } else {
    ?>
                            <tr>
                                <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
                                            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
                                            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
                                                    <tr><?php echo tep_draw_form('orders', FILENAME_ORDERS, '', 'get'); ?>
                                                        <td class="smallText" align="right"><?php echo 'Search Orders - by Order Number: ' . ' ' . tep_draw_input_field('oID', '', 'size="12" id="oID"') . tep_draw_hidden_field('action', 'edit'); ?><script type="text/javascript">
                                                    selectField(document.getElementById('oID'));
                                                            </script></td></form></tr>
                                                    <tr> <?php echo tep_draw_form('orders', FILENAME_ORDERS, '', 'get'); ?> <td class="smallText" align="right"><?php echo 'Search by Customer First Name, Last Name or Email: ' . tep_draw_input_field('lastname', '', 'size="20"'); ?></td>
                                                        </form></tr>
                                                    <tr> <?php echo tep_draw_form('orders', FILENAME_ORDERS, '', 'get'); ?> <td class="smallText" align="right"><?php echo 'Search Orders - by Address fields or Amounts: ' . tep_draw_input_field('address', '', 'size="20"'); ?></td>
                                                        </form></tr>
                                                    <tr><?php echo tep_draw_form('status', FILENAME_ORDERS, '', 'get'); ?>
                                                        <td class="smallText" align="right"><?php echo HEADING_TITLE_STATUS . ' ' . tep_draw_pull_down_menu('status', array_merge(array(array('id' => '', 'text' => TEXT_ALL_ORDERS)), $orders_statuses), '', 'onChange="this.form.submit();"'); ?></td>
                                                        </form></tr>
                                                </table></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                                                    <tr class="dataTableHeadingRow">
                                                        <td class="dataTableHeadingContent" width="15">&nbsp;</td>
                                                        <td class="dataTableHeadingContent" width="15"><?php echo 'Order #'.(isset($HTTP_GET_VARS['cID']) && $HTTP_GET_VARS['cID'] != '' ? ' / GV code' :'' ); ?></td>
                                                            <td class="dataTableHeadingContent" width="15"><?php echo 'Payment'; ?></td>
                                                            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMERS; ?></td>
                                                            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></td>
                                                            <td class="dataTableHeadingContent" align="right">Shipping</td>
                                                            <td class="dataTableHeadingContent" align="center"><?php echo (isset($HTTP_GET_VARS['cID']) && $HTTP_GET_VARS['cID'] != '' ? 'Date' : TABLE_HEADING_DATE_PURCHASED); ?></td>
                                                            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                                                            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
                                                        </tr>
<?php
                                if (isset($HTTP_GET_VARS['cID'])) {
                                    $cID = tep_db_prepare_input($HTTP_GET_VARS['cID']);
                                    $orders_query_raw = "select o.settlement_date, o.approval_code, o.transaction_id, o.orders_id, o.customers_name, o.customers_id, o.customers_id, o.payment_method, o.payment_info, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.value as order_total, o.order_from_retail from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int) $cID . "' and o.orders_status = s.orders_status_id and s.language_id = '" . (int) $languages_id . "' and ot.class = 'ot_total' order by orders_id DESC";
                                } elseif (isset($HTTP_GET_VARS['status']) && $HTTP_GET_VARS['status'] != '') {
                                    $status = tep_db_prepare_input($HTTP_GET_VARS['status']);
                                    $orders_query_raw = "select o.settlement_date, o.approval_code, o.transaction_id, o.orders_id, o.customers_name, o.customers_id, o.payment_method,o.payment_info, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.value as order_total, o.order_from_retail from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . (int) $languages_id . "' and s.orders_status_id = '" . (int) $status . "' and ot.class = 'ot_total' order by o.orders_id DESC";
                                } elseif (isset($HTTP_GET_VARS['lastname'])) {
                                    $orders_query_raw = "select o.settlement_date, o.approval_code, o.transaction_id, o.orders_id, o.customers_name, o.customers_id, o.payment_method,o.payment_info, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.value as order_total, o.order_from_retail from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . (int) $languages_id . "' and (o.customers_name like '%" . addslashes($HTTP_GET_VARS['lastname']) . "%' or o.customers_email_address like '" . addslashes($HTTP_GET_VARS['lastname']) . "') and ot.class = 'ot_total' order by o.orders_id DESC";
                                } elseif (isset($HTTP_GET_VARS['address'])) {
                                    $orders_query_raw = "select o.settlement_date, o.approval_code, o.transaction_id, o.orders_id, o.customers_name, o.customers_id, o.payment_method, o.payment_info,o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.value as order_total, o.order_from_retail from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . (int) $languages_id . "' and (o.customers_street_address like '%" . addslashes($HTTP_GET_VARS['address']) . "%' || o.customers_suburb like '%" . addslashes($HTTP_GET_VARS['address']) . "%' || o.customers_city like '%" . addslashes($HTTP_GET_VARS['address']) . "%' || o.customers_postcode like '%" . addslashes($HTTP_GET_VARS['address']) . "%' || o.customers_state like '%" . addslashes($HTTP_GET_VARS['address']) . "%' || o.customers_country like '%" . addslashes($HTTP_GET_VARS['address']) . "%' || o.delivery_street_address like '%" . addslashes($HTTP_GET_VARS['address']) . "%' || o.delivery_suburb like '%" . addslashes($HTTP_GET_VARS['address']) . "%' || o.delivery_city like '%" . addslashes($HTTP_GET_VARS['address']) . "%' || o.delivery_postcode like '%" . addslashes($HTTP_GET_VARS['address']) . "%' || o.delivery_state like '%" . addslashes($HTTP_GET_VARS['address']) . "%' || o.delivery_country like '%" . addslashes($HTTP_GET_VARS['address']) . "%' or ot.value = '" . $HTTP_GET_VARS ['address'] . "') and ot.class = 'ot_total' order by o.orders_id DESC";
                                } else {
                                    $orders_query_raw = "select o.settlement_date, o.approval_code, o.transaction_id, o.orders_id, o.customers_name, o.customers_id, o.payment_method, o.payment_info, o.orders_status, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.value as order_total, o.order_from_retail from " . TABLE_ORDERS . " o left join " . TABLE_ORDERS_TOTAL . " ot on (o.orders_id = ot.orders_id), " . TABLE_ORDERS_STATUS . " s where o.orders_status = s.orders_status_id and s.language_id = '" . (int) $languages_id . "' and ot.class = 'ot_total' order by o.orders_id DESC";
                                }

                                if (isset($HTTP_GET_VARS['per_page']) && $HTTP_GET_VARS['per_page'] != '') {
                                    $per_page = $HTTP_GET_VARS['per_page'];
                                } else {
                                    $per_page = 100;
                                }

                                $orders_split = new splitPageResults($HTTP_GET_VARS['page'], $per_page, $orders_query_raw, $orders_query_numrows);
                                $rows = $per_page * ((int) $HTTP_GET_VARS['page'] - 1);
                                $orders_query = tep_db_query($orders_query_raw);
                                while ($orders = tep_db_fetch_array($orders_query)) {
                                    if (isset($HTTP_GET_VARS['cID']) && (preg_match('/Gift Voucher/i', $orders['payment_method']))) {
                                        $get_coupon_code_query = tep_db_query("SELECT c.coupon_code, c.coupon_id, c.coupon_amount, crt.redeem_date FROM coupon_email_track cet, coupon_redeem_track crt, coupons c WHERE c.coupon_id = crt.coupon_id and c.coupon_type = 'G' and cet.coupon_id = crt.coupon_id and order_id = '".$orders['orders_id']."' group by cet.coupon_id ");
                                        $totalgv = tep_db_num_rows($get_coupon_code_query);
                                        if($totalgv > 0){
                                            $get_coupon_code = tep_db_fetch_array($get_coupon_code_query);
                                            $gv_code = $get_coupon_code['coupon_code'];
                                        }else{
                                            $gv_code = '';
                                        }
                                    }else{
                                        $totalgv = 0;
                                        $gv_code = '';
                                    }
                                    $rows = $rows + 1;
                                    if ((!isset($HTTP_GET_VARS['oID']) || (isset($HTTP_GET_VARS['oID']) && ($HTTP_GET_VARS['oID'] == $orders['orders_id']))) && !isset($oInfo)) {
                                        $oInfo = new objectInfo($orders);
                                    }

                                    if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) {
                                        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit') . '\'">' . "\n";
                                    } else {
                                        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id']) . '\'">' . "\n";
                                    }
                                    $shipping_query = tep_db_query("select title from orders_total where orders_id = '" . $orders ['orders_id'] . "' and class = 'ot_shipping'");
                                    $shipping_array = tep_db_fetch_array($shipping_query);
                                    $shipStr = '-';
                                    if (strpos(strtolower($shipping_array['title']), 'fedex') > -1
                                            )$shipStr = 'FedEx';
                                    elseif (strpos(strtolower($shipping_array['title']), 'first-class mail international package') > -1
                                        )$shipStr = 'IntlFC';elseif (strpos(strtolower($shipping_array['title']), 'first class') > -1 || (strpos(strtolower($shipping_array['title']), 'first-class') >  -1)
                                        )$shipStr = 'FirstC';
                                    elseif (strpos(strtolower($shipping_array['title']), 'parcel') > -1
                                        )$shipStr = 'Parcel';
                                    elseif (strpos(strtolower($shipping_array['title']), 'priority mail international') > -1
                                        )$shipStr = 'IntlPri';
                                    elseif (strpos(strtolower($shipping_array['title']), 'express mail international') > -1
                                        )$shipStr = 'IntlExp';
                                    elseif (strpos(strtolower($shipping_array['title']), 'priority') > -1
                                        )$shipStr = 'Priority';
                                    elseif (strpos(strtolower($shipping_array['title']), 'standard') > -1
                                            )$shipStr = 'Standard';
                                    
?>

                                    <td class="dataTableContent" align="center"><?php echo $rows; ?></td>
                                    <td class="dataTableContent" align="left" nowrap><?php
                                    echo $orders['orders_id'];
                                    $count_orders1_query = tep_db_query("select count(*) as total from orders where orders_status != '100001' and orders_status != '100003' and customers_id = '" . (int) $orders ['customers_id'] . "'");
                                    $count_orders1 = tep_db_fetch_array($count_orders1_query);
                                    $total_orders1 = $count_orders1 ['total'];
                                    if ($total_orders1 > 1
                                        )echo ' (' . $total_orders1 . ')';
                                    if (isset($HTTP_GET_VARS['cID']) && $gv_code != '') {
                                        echo ' / '.$gv_code;
                                    }
?></td>
                        <?php
                                    $method = '';
                                    // EOF: WebMakers.com Added: Show Order Info
                                    if ($orders['orders_status'] == 100003) {
                                        $method = 'Declined';
                                    } elseif ((preg_match('/paypal/i', $orders['payment_method']) && preg_match('/express/i', $orders['payment_info'])) || ( preg_match('/credit card/i', $orders['payment_method']) && preg_match('/paypal/i', $orders['payment_info']))) {
                                        $method = 'Paypal';
                                    } elseif (preg_match('/paypal/', $orders['payment_method']) && (preg_match('/credit card/i', $orders['payment_info']) || preg_match('/Direct/i', $orders['payment_info'])) || preg_match('/PWPP/i', $orders['payment_info'])) {
                                        $method = 'CC';
                                    } elseif (preg_match('/authorize.net/i', $orders['payment_method']) || preg_match('/Auth.net/i', $orders['payment_info'])) {
                                        $method = 'A.net';
                                    } elseif (preg_match('/Amazon/i', $orders['payment_method'])) {
                                        $method = 'Amazon';
                                    } elseif (preg_match('/Money Order/i', $orders['payment_method']) || preg_match('/Check/i', $orders['payment_method'])) {
                                        $method = 'Check/MO ';
                                    } elseif (preg_match('/cash/i', $orders['payment_method']) && preg_match('/Delivery/i', $orders['payment_method'])) {
                                        $method = 'CashonD ';
                                    } elseif (preg_match('/Gift Voucher/i', $orders['payment_method'])) {
                                        $method = 'GV';
                                    } else {
                                        $method = $orders['payment_method'];
                                    }
                                    
                                    if ($orders['order_from_retail'] == '1')$shipStr = 'Showroom  Pickup';
                        ?>

                                    <td class="dataTableContent" align="center"><?php echo $method; ?></td>
                                    <td class="dataTableContent"><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders['orders_id'] . '&action=edit') . '">' . tep_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $orders['customers_name']; ?></td>
                                    <td class="dataTableContent" align="right"><?php echo ($gv_code  != '' ? $currencies->default_format($get_coupon_code['coupon_amount'], $orders['currency']) :$currencies->default_format($orders['order_total'], $orders['currency'])); ?></td>
                                    <td class="dataTableContent" align="center"><?php echo $shipStr; ?></td>
                                    <td class="dataTableContent" align="center"><?php echo ($gv_code  != '' ? tep_datetime_short($get_coupon_code['redeem_date']):tep_datetime_short($orders['date_purchased'])); ?></td>
                                    <td class="dataTableContent" align="right"><?php echo ($gv_code  != '' ? '' : $orders['orders_status_name']); ?></td>
                                    <td class="dataTableContent" align="right"><?php
                                    if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) {
                                        echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', '');
                                    } else {
                                        echo '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>';
                                    } ?>&nbsp;</td>
                        </tr>
<?php
                                }
?>
                    <tr>
                        <td colspan="8"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                                <tr>
                                    <td class="smallText" valign="top"><?php echo $orders_split->display_count($orders_query_numrows, $per_page, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
                                    <td class="smallText" align="right"><?php echo $orders_split->display_links($orders_query_numrows, $per_page, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page'], tep_get_all_get_params(array('page', 'oID', 'action'))); ?></td>
                            </tr>
                            <?php if (isset($HTTP_GET_VARS['per_page']) && $HTTP_GET_VARS['per_page'] != '') {
 ?>
                                <tr>
                                    <td colspan="6" align="right">[<a href="<?php echo tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('per_page', 'page', 'oID', 'action'))); ?>">Display 100 Per Page</a>]</td>
                                                </tr>

<?php } else { ?>
                                                <tr>
                                                    <td colspan="6" align="right">[<a href="<?php echo tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('per_page', 'page', 'oID', 'action')) . 'per_page=' . MAX_DISPLAY_SEARCH_RESULTS); ?>">Display <?php echo MAX_DISPLAY_SEARCH_RESULTS; ?> Per Page</a>]</td>
                                                </tr>
<?php } ?>

                                        </table></td>
                                </tr>
                            </table></td>
<?php
                                $heading = array();
                                $contents = array();

                                switch ($action) {
                                    case 'delete':
                                        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ORDER . '</b>');

                                        $contents = array('form' => tep_draw_form('orders', FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=deleteconfirm'));
                                        $contents[] = array('text' => TEXT_INFO_DELETE_INTRO . '<br><br>');
                                        $contents[] = array('text' => TEXT_INFO_DELETE_DATA . '&nbsp;' . $oInfo->customers_name . '<br>');
                                        $contents[] = array('text' => TEXT_INFO_DELETE_DATA_OID . '&nbsp;<b>' . $oInfo->orders_id . '</b><br>');
                                        $contents[] = array('text' => '<br>' . tep_draw_checkbox_field('restock') . ' ' . TEXT_INFO_RESTOCK_PRODUCT_QUANTITY);
                                        $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . ' <a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
                                        break;


                                    default:
                                        if (isset($oInfo) && is_object($oInfo)) {
                                            $heading[] = array('text' => '<b>[' . $oInfo->orders_id . ']&nbsp;&nbsp;' . tep_datetime_short($oInfo->date_purchased) . '</b>');

//        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a>');
//        $contents[] = array('text' => '<br>' . TEXT_DATE_ORDER_CREATED . ' ' . tep_date_short($oInfo->date_purchased));


                                            if (tep_not_null($oInfo->last_modified))
                                                $contents[] = array('text' => TEXT_DATE_ORDER_LAST_MODIFIED . ' ' . tep_date_short($oInfo->last_modified));

                                            if (!tep_not_null($oInfo->approval_code) && !tep_not_null($oInfo->transaction_id)) {
                                                $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS, tep_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a> <a href="' . tep_href_link(FILENAME_EDIT_ORDERS, 'oID=' . $oInfo->orders_id) . '">' . tep_image_button('button_update.gif', IMAGE_UPDATE) . '</a>');
                                            }

                                            $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link('../invoice/invoice_' . $oInfo->orders_id . '.pdf') . '" TARGET="_blank">' . tep_image_button('button_invoice.gif', IMAGE_ORDERS_INVOICE) . '</a> <a href="' . tep_href_link(FILENAME_ORDERS_PACKINGSLIP, 'oID=' . $oInfo->orders_id) . '" TARGET="_blank">' . tep_image_button('button_packingslip.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>');
                                            $contents[] = array('text' => '<br>' . TEXT_DATE_ORDER_CREATED . ' ' . tep_date_short($oInfo->date_purchased));

                                            if (preg_match('/paypal/i', $oInfo->payment_method) && preg_match('/express/i', $oInfo->payment_info)) {
                                                $method = 'Paypal Express';
                                            } elseif (preg_match('/paypal/i', $oInfo->payment_method) && (preg_match('/credit card/i', $oInfo->payment_info) || preg_match('/Direct/i', $oInfo->payment_info))) {
                                                $method = 'Credit Card - Paypal';
                                            } elseif (preg_match('/authorize.net/i', $oInfo->payment_method)) {
                                                $method = 'Credit Card - Authorize.net';
                                            } else {
                                                $method = $oInfo->payment_method;
                                            }
                                            //$contents[] = array('text' => '<br>' . TEXT_INFO_PAYMENT_METHOD . ' '  .$method);
                                            $contents[] = array('text' => '<br>' . TEXT_INFO_PAYMENT_METHOD . ' ' . $oInfo->payment_info);
                                        }
                                        break;
                                }

                                if ((tep_not_null($heading)) && (tep_not_null($contents))) {
                                    echo '            <td width="25%" valign="top">' . "\n";

                                    $box = new box;
                                    echo $box->infoBox($heading, $contents);

                                    echo '            </td>' . "\n";
                                }
?>
                            </tr>
                            </table></td>
                            </tr>
    <?php
                            }
    ?>
                        </table></td>
                        <!-- body_text_eof //-->
                        <script type="text/javascript">
                        var array = document.getElementById('mainTable').getElementsByTagName('a');
                        for(var i=0; i<array.length;i++){
                            array[i].setAttribute('style','color:blue;text-decoration:underline;');
                        }
                        $( ".spc" ).each(function() {
                            $( this ).css( "text-decoration" , "none");
                        });
                        </script>
                        </tr>
                        </table>
                        <!-- body_eof //-->

                        <!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
                        <!-- footer_eof //-->
                        <br>
                        </body>
                        </html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>