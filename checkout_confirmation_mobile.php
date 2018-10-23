<?php 
/*
  $Id: checkout_confirmation.php,v 1.2 2003/09/24 15:34:25 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top_mobile.php');
  require('includes/classes/http_client.php');
  //echo '<pre>';
  //print_r($_SESSION);
  //exit();
if(isset($_POST['daily'])){
    $val = $_POST['daily'];
   /* var_dump($val);*/
    listInsert($val);
}


function listInsert($val){
    $customer_id = $_SESSION['customer_id'];

    $customer = tep_db_query("select customers_firstname,customers_lastname,customers_email_address from " . TABLE_CUSTOMERS . " where customers_id = '" . $customer_id . "'");
    if (tep_db_num_rows($customer) > 0) {
        $customer_result = tep_db_fetch_array($customer);
        $customers_first_name = $customer_result['customers_firstname'];
        $customers_last_name = $customer_result['customers_lastname'];
        $customers_email_address = $customer_result['customers_email_address'];

        $choice = array($val);


        addNewUserForList($customers_first_name,$customers_last_name,$customers_email_address,$choice,true);


    }
}



  if(isset($_GET['action']) && !empty($_GET['action'])){
      $process = false;
      if($_GET['action'] == 'getData'){
          $address_query = tep_db_query("select entry_gender, entry_company, entry_firstname, entry_lastname, entry_street_address, entry_suburb, entry_postcode, entry_city, entry_state, entry_zone_id, entry_country_id from " . TABLE_ADDRESS_BOOK . " where address_book_id = '" . (int)$_GET['addId'] . "'");
          if(tep_db_num_rows($address_query)){
             $address_array = tep_db_fetch_array($address_query); 
             if(empty($address_array['entry_state'])){
                $address_array['entry_state'] = tep_get_zone_name($address_array['entry_country_id'], $address_array['entry_zone_id'], $address_array['entry_state']);
             }
             $address = $address_array['entry_firstname'].'|'.$address_array['entry_lastname'].'|'.$address_array['entry_street_address'].'|'.$address_array['entry_suburb'].'|'.$address_array['entry_postcode'].'|'.$address_array['entry_city'].'|'.$address_array['entry_country_id'].'|'.$address_array['entry_zone_id'].'|'.$address_array['entry_state'];
          }else{
              $address = 'no address found';
          }
          echo $address;
      }elseif($_GET['action'] == 'getzone'){
          $zones_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$_GET['cId'] . "' order by zone_name");
          if(tep_db_num_rows($zones_query)){
              $zones_array = array();
              $zones_array[] = array('id' => '', 'text' => TEXT_SELECT_ZONE);
              while ($zones_values = tep_db_fetch_array($zones_query)) {
                  $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
              }
              echo tep_draw_pull_down_menu('state', $zones_array);
          }else{
              echo 'no zone';
          }
      }elseif($_GET['action'] == 'udateSendto'){
          $sendto = (int)$_GET['addId'];
          if (tep_session_is_registered('shipping')) tep_session_unregister('shipping');
          echo 'success';
      }elseif ($_GET['action'] == 'processData') {
        $process = true;
        $error = false;
        $errorMsg = '';
        $errorMsgState = false;
        $firstname = ucwords(tep_db_prepare_input($_GET['fname']));
        $lastname = ucwords(tep_db_prepare_input($_GET['lname']));
        $street_address = ucwords(tep_db_prepare_input($_GET['add1']));
        $suburb = ucwords(tep_db_prepare_input($_GET['add2']));
        $postcode = tep_db_prepare_input($_GET['pocode']);
        $city = ucwords(tep_db_prepare_input($_GET['city']));
        $country = tep_db_prepare_input($_GET['country']);
        if (ACCOUNT_STATE == 'true') {
            if (isset($_GET['zone_id'])) {
                $zone_id = tep_db_prepare_input($_GET['zone_id']);
            } else {
                $zone_id = false;
            }
            $state = ucwords(tep_db_prepare_input($_GET['state']));
        }
        if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
            $error = true;
            $errorMsg = ENTRY_FIRST_NAME_ERROR."\n";
        }
        if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
            $error = true;
            $errorMsg = ENTRY_LAST_NAME_ERROR."\n";
        }
        if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
            $error = true;
            $errorMsg = ENTRY_STREET_ADDRESS_ERROR."\n";
        }
        if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
            $error = true;
            $errorMsg = ENTRY_POST_CODE_ERROR."\n";
        }
        if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
            $error = true;
            $errorMsg = ENTRY_CITY_ERROR."\n";
        }
        if (!is_numeric($country)) {
            $error = true;
            $errorMsg = ENTRY_COUNTRY_ERROR."\n";
        }
        if (ACCOUNT_STATE == 'true') {
            $zone_id = 0;
            $check_query = tep_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "'");
            $check = tep_db_fetch_array($check_query);
            $entry_state_has_zones = ($check['total'] > 0);
            if ($entry_state_has_zones == true) {
                $zone_query = tep_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' and (zone_name like '" . tep_db_input($state) . "%' or zone_code like '%" . tep_db_input($state) . "%')");
                if (tep_db_num_rows($zone_query) == 1) {
                    $zone = tep_db_fetch_array($zone_query);
                    $zone_id = $zone['zone_id'];
                } else {
                    $error = true;
                    $errorMsgState = true;
                }
            } else {
                if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
                    $error = true;
                    $errorMsg = ENTRY_STATE_ERROR."\n";
                }
            }
        }
        if ($error == false) {
            $sql_data_array = array('entry_firstname' => $firstname,
                                    'entry_lastname' => $lastname,
                                    'entry_street_address' => $street_address,
                                    'entry_postcode' => $postcode,
                                    'entry_city' => $city,
                                    'entry_country_id' => (int)$country);
            if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender;
            if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $company;
            if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $suburb;
            if (ACCOUNT_STATE == 'true') {
                if ($zone_id > 0) {
                    $sql_data_array['entry_zone_id'] = (int)$zone_id;
                    $sql_data_array['entry_state'] = '';
                } else {
                    $sql_data_array['entry_zone_id'] = '0';
                    $sql_data_array['entry_state'] = $state;
                }
            }
            if ($_GET['addId'] != '0') {
                tep_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', "address_book_id = '" . (int)$_GET['addId'] . "' and customers_id ='" . (int)$customer_id . "'");
                $new_address_book_id = $_GET['addId'];
                // reregister session variables
                /*if ( $_GET['addId'] == $customer_default_shipping_id ) {
                    $customer_first_name = $firstname;
                    $customer_country_id = $country;
                    $customer_zone_id = (($zone_id > 0) ? (int)$zone_id : '0');
                    $customer_default_shipping_id = (int)$HTTP_GET_VARS['edit'];
                    $sql_data_array = array('customers_firstname' => $firstname,
                                            'customers_lastname' => $lastname,
                                            'customers_default_shipping_id' => (int)$HTTP_GET_VARS['edit']);
                    if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;
                    tep_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . (int)$customer_id . "'");
                }*/
            } else {
                $sql_data_array['customers_id'] = (int)$customer_id;
                tep_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
                $new_address_book_id = tep_db_insert_id();
                // reregister session variables
                /*if (isset($HTTP_POST_VARS['primary']) && ($HTTP_POST_VARS['primary'] == 'on')) {
                    $customer_first_name = $firstname;
                    $customer_country_id = $country;
                    $customer_zone_id = (($zone_id > 0) ? (int)$zone_id : '0');
                    if (isset($HTTP_POST_VARS['primary']) && ($HTTP_POST_VARS['primary'] == 'on')) 
                        $customer_default_address_id = $new_address_book_id;
                        $sql_data_array = array('customers_firstname' => $firstname,
                                                'customers_lastname' => $lastname);
                    if (ACCOUNT_GENDER == 'true') 
                        $sql_data_array['customers_gender'] = $gender;
                    if (isset($HTTP_POST_VARS['primary']) && ($HTTP_POST_VARS['primary'] == 'on')) 
                        $sql_data_array['customers_default_address_id'] = $new_address_book_id;
                    tep_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . (int)$customer_id . "'");
                }*/
            }
            echo 'success : '.$new_address_book_id;
        }else{
            if($errorMsgState == true){
                echo 'state error : '.$errorMsg;
            }else{
                echo 'error : '.$errorMsg;
            } 
        }
      }elseif($_GET['action'] == 'showShipping'){
          include_once (DIR_WS_LANGUAGES . $language . '/checkout_shipping.php');
          if(!empty($_GET['sendto'])){
            $sendto = (int)$_GET['sendto'];
          }
          $total_weight = $cart->show_weight();
          //if (tep_session_is_registered('shipping')) 
           //   tep_session_unregister('shipping');
          require_once(DIR_WS_CLASSES . 'order.php');
          $order = new order;
          require(DIR_WS_CLASSES . 'order_total.php');//ICW ADDED FOR CREDIT CLASS SYSTEM
          $order_total_modules = new order_total;//ICW ADDED FOR CREDIT CLASS SYSTEM

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
          
          // get all available shipping quotes
            $quotes = $shipping_modules->quote();
            if($_SESSION['checkout_shipping']!=''){
                $shipping = $_SESSION['checkout_shipping'];
                if (!tep_session_is_registered('shipping')) 
                    tep_session_register('shipping');
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
                    $order->info['shipping_cost']=$shipping['cost'];
                    $order->info['total'] = $order->info['subtotal']+$order->info['shipping_cost'];
                }
            }
            if ( !tep_session_is_registered('shipping') || ( tep_session_is_registered('shipping') && ($shipping == false) && (tep_count_shipping_modules() > 1) ) ) 
                $shipping = $shipping_modules->cheapest();
                $_SESSION['selected_shipping'] = $shipping;

            if($order->info['shipping_method']==''){
                $order->info['shipping_method']=$shipping['title'];
                $order->info['shipping_cost']=$shipping['cost'];
                $order->info['total'] = $order->info['total']+$order->info['shipping_cost'];	
            }
            $shipping_output = '<table width="100%">';
            $shipping_output .= '<tr>
                                    <td>
                                        <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td class="main"><b>'. TABLE_HEADING_SHIPPING_METHOD.'</b></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>';
            
            $shipping_output .= '<tr>
                                    <td>
                                        <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
                                            <tr class="infoBoxContents">
                                                <td>
                                                    <table border="0" width="100%" cellspacing="0" cellpadding="2">';

            if (sizeof($quotes) > 1 && sizeof($quotes[0]) > 1) {
                                    $shipping_output .= '<tr>
                                                            <td>'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                            <td class="main" width="50%" valign="top">'. TEXT_CHOOSE_SHIPPING_METHOD.'</td>
                                                            <td class="main" width="50%" valign="top" align="right"><b>' . TITLE_PLEASE_SELECT . '</b><br>' . tep_image(DIR_WS_IMAGES . 'arrow_east_south.gif').'</td>
                                                            <td>'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                        </tr>';
            } elseif ($free_shipping == false && false) {
                                    $shipping_output .= '<tr>
                                                            <td>'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                            <td class="main" width="100%" colspan="2">'. TEXT_ENTER_SHIPPING_INFORMATION.'</td>
                                                            <td>'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                        </tr>';
            }
            if ($free_shipping == true) {
                                    $shipping_output .= '<tr>
                                                            <td>'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                            <td colspan="2" width="100%">
                                                                <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                                                    <tr>
                                                                        <td width="10">'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                                        <td class="main" colspan="3"><b>'. FREE_SHIPPING_TITLE.'</b>&nbsp;'. $quotes[$i]['icon'].'</td>
                                                                        <td width="10">'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                                    </tr>
                                                                    <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, 0)">
                                                                        <td width="10">'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                                        <td class="main" width="100%">'. sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)) . tep_draw_hidden_field('shipping', 'free_free').'</td>
                                                                        <td width="10">'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td>'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                        </tr>';

            } else {
                $radio_buttons = 0;
                //print_r( $quotes );
                for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
                                    $shipping_output .= '<tr>
                                                            <td>'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                            <td colspan="2">
                                                                <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                                                    <tr>
                                                                        <td width="10">'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                                        <td class="main" colspan="3"><b>'. $quotes[$i]['module'].'</b>&nbsp;'. (isset($quotes[$i]['icon']) && tep_not_null($quotes[$i]['icon'])?  $quotes[$i]['icon'] : '') .'</td>
                                                                        <td width="10">'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                                    </tr>';

                    if (isset($quotes[$i]['error'])) {
                                                $shipping_output .= '<tr>
                                                                        <td width="10">'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                                        <td class="main" colspan="3"><div style="background-color: #FF0000; color :#FFFFFF"><b>&nbsp;&nbsp;Invalid Zip Code - Please Enter a valid Zip Code by clicking on Change Address button above</b></div></td>
                                                                        <td width="10">'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                                    </tr>';

                    } else {
                        for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) {
                            // set the radio button to be checked if it is the method chosen
                            $checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $shipping['id']) ? true : false);
                            if ( ($checked == true) || ($n == 1 && $n2 == 1) ) {
                              $shipping_output .= '                  <tr id="defaultSelectedShipping" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffectShipping(this, ' . $radio_buttons . ')">' . "\n";
                            } else {
                              $shipping_output .= '                  <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffectShipping(this, ' . $radio_buttons . ')">' . "\n";
                            }

                                                    $shipping_output .= '<td width="10">'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                                        <td class="main" width="100%">'. $quotes[$i]['methods'][$j]['title'].'</td>';

                            if ( ($n > 1) || ($n2 > 1) ) {

                                                    $shipping_output .= '<td class="main">'. $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))).'</td>
                                                                        <td class="main" align="right">'. tep_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked).'</td>';
                            } else {
                                                    $shipping_output .= '<td class="main" align="right" colspan="2">'. $currencies->format(tep_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax'])) . tep_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']) .'</td>';
                            }
                                                    $shipping_output .= '<td width="10">'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                                    </tr>';
                                $radio_buttons++;
                            }
                        }
                                            $shipping_output .='</table>
                                                            </td>
                                                            <td>'. tep_draw_separator('pixel_trans.gif', '10', '1').'</td>
                                                        </tr>';

                    }
                }

                                $shipping_output .='</table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>';
            $shipping_output .= '</table>';
            echo $shipping_output;
      }
      exit();
  }
	global $cot_gv;
	 //if (!tep_session_is_registered('paypal_ec_token') && !tep_session_is_registered('paypal_ec_payer_id') && !tep_session_is_registered('paypal_ec_payer_info')) {
	if(isset($_POST['cot_gv']) && $_POST['cot_gv'] != ''){
        tep_session_register('cot_gv');
	$cot_gv = $HTTP_POST_VARS['cot_gv']; 
	}

// if the customer is not logged on, redirect them to the login page
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_PAYMENT));
   /* tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));*/
    tep_redirect(tep_href_link('shopping_cart_mobile.php'));
  }

  if(isset($_POST['telephone']) && $_POST['telephone'] != '')
  {
      $telephone = substr($_POST['telephone'] ,0,3).'-'.substr($_POST['telephone'] ,3,3).'-'.substr($_POST['telephone'] ,6);
      
      tep_session_register('telephone');
  }
  if(tep_session_is_registered('retail_rep') && $_SESSION['retail_rep'] != ''){
      $retail_cust_fname = ucfirst($_POST['retail_firstname']);
      $retail_cust_lname = ucfirst($_POST['retail_lastname']);
      $retail_cust_postcode = $_POST['retail_postcode'];
      tep_session_register('retail_cust_fname');
      tep_session_register('retail_cust_lname');
      tep_session_register('retail_cust_postcode');
      $retail_cust_email = $_POST['retail_email'];
      if($retail_cust_email != ''){
          tep_session_register('retail_cust_email');
      }
      
  }
// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
  }

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($cart->cartID) && tep_session_is_registered('cartID')) {
    if ($cart->cartID != $cartID) {
      tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
    }
  }
  
//echo 'Here';
if($HTTP_POST_VARS['subscribe_nl'] == 'on'){
	$sql = tep_db_query("select customers_firstname, customers_lastname, customers_email_address from customers where customers_id = '".$customer_id."'");
	$array= tep_db_fetch_array($sql);
	addconfirmUser($array['customers_firstname'],$array['customers_lastname'],$array['customers_email_address']);
}


  if (isset($HTTP_POST_VARS['payment'])) 
     $payment = $HTTP_POST_VARS['payment'];
  if (!tep_session_is_registered('payment')) tep_session_register('payment');

  if (!tep_session_is_registered('comments')) tep_session_register('comments');
  if (tep_not_null($HTTP_POST_VARS['comments'])) {
    $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);
  }
  
  //---PayPal WPP Modification START ---//
  
 
  if (tep_paypal_wpp_enabled()) { 
    $ec_enabled = true;
  } else {
    $ec_enabled = false;
  }

  if ($ec_enabled) {
    $show_payment_page = false;

    $config_query = tep_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_PAYMENT_PAYPAL_DP_DISPLAY_PAYMENT_PAGE' LIMIT 1");
    if (tep_db_num_rows($config_query) > 0) {
      $config_result = tep_db_fetch_array($config_query);
      if ($config_result['configuration_value'] == 'Yes') {
        $show_payment_page = true;
      }
    }

    $ec_checkout = true;
    if (!tep_session_is_registered('paypal_ec_token') && !tep_session_is_registered('paypal_ec_payer_id') && !tep_session_is_registered('paypal_ec_payer_info')) {
      $ec_checkout = false;
      $show_payment_page = true;
    }
  }

//---PayPal WPP Modification END ---//
// load the selected payment module
  require(DIR_WS_CLASSES . 'payment_mobile.php');
  if ($credit_covers) $payment=''; //ICW added for CREDIT CLASS

  $payment_modules = new payment_mobile($payment);

//ICW ADDED FOR CREDIT CLASS SYSTEM
  require(DIR_WS_CLASSES . 'order_total.php');
  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

 
  


  $payment_modules->update_status();

//ICW ADDED FOR CREDIT CLASS SYSTEM
  $order_total_modules = new order_total;

 if (!tep_session_is_registered('paypal_ec_token') && !tep_session_is_registered('paypal_ec_payer_id') && !tep_session_is_registered('paypal_ec_payer_info')) {

//ICW ADDED FOR CREDIT CLASS SYSTEM
  $order_total_modules->collect_posts();
  }
  
 if ( (tep_not_null(MODULE_PAYMENT_INSTALLED)) && ((!tep_session_is_registered('payment')) or $payment == '')) {
    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'Please select payment method (error)', 'SSL'));
 }
 
//ICW ADDED FOR CREDIT CLASS SYSTEM
 // $order_total_modules->pre_confirmation_check();

  $total_weight = $cart->show_weight();
  $total_count = $cart->count_contents();

  // load the selected shipping module
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping();

//ICW Credit class amendment Lines below repositioned
//  require(DIR_WS_CLASSES . 'order_total.php');
//  $order_total_modules = new order_total;
 //   if (!tep_session_is_registered('shipping')) tep_session_register('shipping');

    if ( (tep_count_shipping_modules() > 0) || ($free_shipping == true) ) {        
      if ( (isset($HTTP_POST_VARS['shipping'])) && (strpos($HTTP_POST_VARS['shipping'], '_')) ) {           
        $shipping = $HTTP_POST_VARS['shipping'];
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
              //added to ensure we get free and standard resolved
              $newMethodIdetifer = 0; if($method == 'Standard' && sizeof($quote[0]['methods'])>1)$newMethodIdetifer='1';
            if ( (isset($quote[0]['methods'][$newMethodIdetifer]['title'])) && (isset($quote[0]['methods'][$newMethodIdetifer]['cost'])) ) {
              $shipping = array('id' => $shipping,
                                'title' => (($free_shipping == true) ?  $quote[0]['methods'][$newMethodIdetifer]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][$newMethodIdetifer]['title'] . ')'),
                                'cost' => $quote[0]['methods'][$newMethodIdetifer]['cost']);
$shipping_cost = $quote[0]['methods'][$newMethodIdetifer]['cost'];
	           }
          }
        } else {
          tep_session_unregister('shipping');
        }
      }
    } else {
      $shipping = false;
    }

if (($order->content_type == 'virtual') || ($order->content_type == 'virtual_weight') ) {
    if (!tep_session_is_registered('shipping')) tep_session_register('shipping');
    //$shipping = false;
             $shipping = array('id' => 'free_free',
                                'title' => FREE_SHIPPING_TITLE,
                                'cost' => '0');
$shipping_cost = '0';
    $sendto = $customer_default_address_id;
    //tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
  } else {
       // if(isset($HTTP_POST_VARS['shipping']))$shipping= $HTTP_POST_VARS['shipping'];
// if no shipping method has been selected, redirect the customer to the shipping method selection page
//if (!tep_session_is_registered('shipping') || $shipping == '' || strlen($shipping) < 2 || $shipping == 'undefined') { 

      if (!tep_session_is_registered('shipping') || $shipping == '' || !is_array($shipping) || $shipping == 'undefined') {
    
         tep_session_unregister('shipping');
		tep_session_unregister('selected_shipping');
		tep_session_unregister('checkout_shipping');

 		tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  }
  
}

//Code added for coupon - Kavita (BEGIN)

$check_total = $order->info['total'];
if ($HTTP_POST_VARS['gv_redeem_code']) {
  
// get some info from the coupon table

      $coupon_query=tep_db_query("select coupon_id, coupon_amount, coupon_type, coupon_minimum_order,

                                       uses_per_coupon, uses_per_user, restrict_to_products,

                                       restrict_to_categories from " . TABLE_COUPONS . "

                                       where coupon_code='".$HTTP_POST_VARS['gv_redeem_code']." '
									   and `affiliate_id` <> '".$customer_id."'	
                                       and coupon_active='Y'");
				// and `affiliate_id` <> '".$customer_id."'	added by sumit kumar upadhyay

      $coupon_result=tep_db_fetch_array($coupon_query);

 if ($coupon_result['coupon_type']=='F') {
   $coupon_amount = $coupon_result['coupon_amount'];
   if (($coupon_amount < $check_total) && (is_array($payment_modules->modules)) && (sizeof($payment_modules->modules) > 1) && (!is_object($$payment))) {
    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
   } 
} elseif ( (is_array($payment_modules->modules)) && (sizeof($payment_modules->modules) > 1) && (!is_object($$payment))) {
    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));


}

if($HTTP_POST_VARS['payment'] == 'paypal_wpp' && ($HTTP_POST_VARS['paypalwpp_cc_number'] == '') && ($HTTP_POST_VARS['gv_redeem_code'])){

    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
}
  
  } elseif ( (is_array($payment_modules->modules)) && (sizeof($payment_modules->modules) > 1) && (!is_object($$payment)) && ($payment != 'paypal_express')  && (!$credit_covers) ) {
     
    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));

  }


//Code added for coupon - Kavita (END)

	$order = new order;

// ICW CREDIT CLASS Amended Line
//  if ( ( is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && !is_object($$payment) ) || (is_object($$payment) && ($$payment->enabled == false)) ) {
  if ( (is_array($payment_modules->modules)) && (sizeof($payment_modules->modules) > 1) && (!is_object($$payment)) && ($payment != 'paypal_express') && (!$credit_covers) ) {
    tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
  }

  if (is_array($payment_modules->modules)) {
    $payment_modules->pre_confirmation_check();
  }
//die('modules2');
// Stock Check
  $any_out_of_stock = false;
  if (STOCK_CHECK == 'true') {
    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
      if (tep_check_stock($order->products[$i]['id'], $order->products[$i]['qty'])) {
        $any_out_of_stock = true;
      }
    }
    // Out of Stock
    if ( (STOCK_ALLOW_CHECKOUT != 'true') && ($any_out_of_stock == true) ) {
      tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
    }
  }

// if no shipping method has been selected, redirect the customer to the shipping method selection page
 if (!tep_session_is_registered('shipping')) {
   tep_redirect(tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  }

//  $order = new order;
//ICW ADDED FOR CREDIT CLASS SYSTEM
  $order_total_modules->process();
  $order_total_modules->pre_confirmation_check();

//if($_SESSION['customer_id']=='15133'){
    if(stripos($order->info['payment_method'],'gift')!==false){
        $gv_am_query = tep_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $customer_id . "'");
        $gv_am_result = tep_db_fetch_array($gv_am_query);             
        $totalToBeChecked = ($order->info['subtotal'] + $order->info['shipping_cost']+ $order->info['tax']) -$order->info['coupon'] -$order->info['discount_on_total'];
        if(($totalToBeChecked > $gv_am_result['amount'])) {
                tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
        }
    }
//}
//osc_wrt($order);
if ($HTTP_POST_VARS['payment'] == "paypal_express") {
   tep_redirect(tep_href_link('ec_process.php', '', 'SSL'));
   }
  require(DIR_WS_LANGUAGES . $language . '/' . 'checkout_confirmation.php');

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2);

  $content = 'checkout_confirmation_mobile';/*CONTENT_CHECKOUT_CONFIRMATION_MOBILE;*/
$javascript = 'checkout_confirmation.js.php';
  require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);
  

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>