<?php
  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  include(DIR_WS_CLASSES . 'order.php');

  global $shipping;
  if(!strlen($shipping)>0) {
    $a = explode(';', MODULE_SHIPPING_INSTALLED);
    $shipping = $a[0];
  }
  if ($shipping) {
    $class = substr($shipping, 0, strrpos($shipping, '.'));
    include_once(DIR_FS_CATALOG . DIR_WS_LANGUAGES . $language . '/modules/shipping/' . $shipping);
    include_once(DIR_FS_CATALOG . DIR_WS_MODULES . 'shipping/' . $shipping);
    $GLOBALS[$class] = new $class;
  }

  $currency_select = "select currency from " .  TABLE_ORDERS . " where  orders_id ='" . $HTTP_GET_VARS['oID'] . "'";
  $currency_res = tep_db_query($currency_select);
  if($currency_data = tep_db_fetch_array($currency_res)) {
    $currency = $currency_data['currency'];
  }

  if(strlen($currency) == 0)
    $currency = DEFAULT_CURRENCY;

  // New "Status History" table has different format.
  $OldNewStatusValues = (tep_field_exists(TABLE_ORDERS_STATUS_HISTORY, "old_value") && tep_field_exists(TABLE_ORDERS_STATUS_HISTORY, "new_value"));
  $CommentsWithStatus = tep_field_exists(TABLE_ORDERS_STATUS_HISTORY, "comments");
  $SeparateBillingFields = tep_field_exists(TABLE_ORDERS, "billing_name");

  // Optional Tax Rate/Percent
  $AddShippingTax = "0.0"; // e.g. shipping tax of 17.5% is "17.5"

  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status_query = tep_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "'");
  while ($orders_status = tep_db_fetch_array($orders_status_query)){
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                               'text' => $orders_status['orders_status_name']);
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
  }

  $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : 'edit');

  if (tep_not_null($action)) {
    switch ($action) {
  // Update Order: shipping/payment methods, products qty, details, shipping/billing addresses, totals, status, comment.
      case 'update_order':
        // update invertory
        //print_r($HTTP_POST_VARS);
        //print_r($HTTP_POST_VARS['update_products']);
        $order_id = $HTTP_GET_VARS['oID'];
        $update_products = $HTTP_POST_VARS['update_products'];
        foreach($update_products as $id => $v){
          $uprid = tep_db_fetch_array(tep_db_query("select uprid from " . TABLE_ORDERS_PRODUCTS . " where orders_products_id='" . $id . "' and orders_id='" . $order_id . "'"));
          if(tep_not_null($uprid['uprid'])){
//            update_stock($uprid['uprid'], $v['qty'], $v['old_qty']);
            update_stock($uprid['uprid'], $v['old_qty'] - $v['qty']);
          }
          //print_r($product_id);
          //print_r($v);
        }
        //
        $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);
        $order = new order($oID);
        $status = tep_db_prepare_input($HTTP_POST_VARS['status']);
        $payment_method = tep_db_prepare_input($HTTP_POST_VARS['payment']);
        if($payment_method != "") {
          $class = substr($payment_method, 0, strrpos($payment_method, '.'));
          include(DIR_FS_CATALOG . DIR_WS_LANGUAGES . $language . '/modules/payment/' . $payment_method);
          include(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/' . $payment_method);
          $GLOBALS[$class] = new $class;
          $payment_method_title = $GLOBALS[$class]->title;
          $payment_method_class = $GLOBALS[$class]->code;
          tep_db_query(" update " . TABLE_ORDERS . " set payment_method='" . $payment_method_title . "', payment_class='" . $payment_method_class . "' where orders_id='" . $oID . "'");
        } else {
          tep_db_query(" update " . TABLE_ORDERS . " set payment_class='', payment_method='' where orders_id='" . $oID . "'");
        }
        $shipping = $HTTP_POST_VARS['shipping'];
        if($shipping != "") {
          $class = substr($shipping, 0, strrpos($shipping, '.'));
          $GLOBALS[$class] = new $class;
          $shipping_method_title = $GLOBALS[$class]->title;
          $shipping_method_class = $GLOBALS[$class]->code;
          $sort_order = $GLOBALS[$class]->sort_order;
          tep_db_query(" update " . TABLE_ORDERS . " set shipping_class='" . $shipping_method_class . "' where orders_id='" . $oID . "'");
          $query="select  orders_total_id from " . TABLE_ORDERS_TOTAL . " where orders_id='" . $oID . "' and class ='ot_shipping'";
          $result=tep_db_query($query);
          if(tep_db_num_rows($result)>0) {
            $sql_data_shipping_array = array('title' => $shipping_method_title);
            tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_shipping_array, 'update', ' orders_id="' . $oID . '" and class ="ot_shipping"');
          }  else {
            $query="insert into " . TABLE_ORDERS_TOTAL . " (orders_id, title, text, value, class, sort_order) values ('" . $oID . "', '" . $shipping_method_title . "', '', '','ot_shipping','" . $sort_order . "')";
            $result=tep_db_query($query);
          }
        }

          // Update Products
          if(is_array($update_products)) {
            foreach($update_products as $orders_products_id => $products_details) {
              // Update orders_products Table
              if(($products_details["qty"] > 0)) {
                tep_db_query("update " . TABLE_ORDERS_PRODUCTS . " set products_model = '" . $products_details["model"] . "', products_name = '" . str_replace("'", "&#39;", $products_details["name"]) . "', final_price = '" . $products_details["final_price"] . "', products_tax = '" . $products_details["tax"] . "', products_quantity = '" . $products_details["qty"] . "' where orders_products_id = '$orders_products_id'");
                // Update Any Attributes
                if(is_array($products_details[attributes])) {
                  foreach($products_details["attributes"] as $orders_products_attributes_id => $attributes_details) {
                    tep_db_query("update " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " set products_options = '" . $attributes_details["option"] . "', products_options_values = '" . $attributes_details["value"] . "' where orders_products_attributes_id = '" . $orders_products_attributes_id . "';");
                  }
                }
              } elseif (($products_details["qty"] == 0) || ($products_details["qty"] == '')) {
                tep_db_query("delete from " . TABLE_ORDERS_PRODUCTS . " where orders_products_id = '" . $orders_products_id . "'");
                tep_db_query("delete from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_products_id = '" . $orders_products_id . "'");
              }
            }
          }

// Update shipping/billing addresses.
          $UpdateOrders = "update " . TABLE_ORDERS . " set ";
//        $UpdateOrders = "customers_name = '" . tep_db_input(stripslashes($update_customer_name)) . "', customers_company = '" . tep_db_input(stripslashes($update_customer_company)) . "', customers_street_address = '" . tep_db_input(stripslashes($update_customer_street_address)) . "', customers_suburb = '" . tep_db_input(stripslashes($update_customer_suburb)) . "', customers_city = '" . tep_db_input(stripslashes($update_customer_city)) . "', customers_state = '" . tep_db_input(stripslashes($update_customer_state)) . "', customers_postcode = '" . tep_db_input($update_customer_postcode) . "', customers_country = '" . tep_db_input(stripslashes($update_customer_country)) . "', customers_telephone = '" . tep_db_input($update_customer_telephone) . "', customers_email_address = '" . tep_db_input($update_customer_email_address) . "',";

          $UpdateOrders .= "billing_name = '" . tep_db_input(stripslashes($HTTP_POST_VARS['update_billing_name'])) . "', billing_company = '" . tep_db_input(stripslashes($HTTP_POST_VARS['update_billing_company'])) . "', billing_street_address = '" . tep_db_input(stripslashes($HTTP_POST_VARS['update_billing_street_address'])) . "', billing_suburb = '" . tep_db_input(stripslashes($HTTP_POST_VARS['update_billing_suburb'])) . "', billing_city = '" . tep_db_input(stripslashes($HTTP_POST_VARS['update_billing_city'])) . "', billing_state = '" . tep_db_input(stripslashes($HTTP_POST_VARS['update_billing_state'])) . "', billing_postcode = '" . tep_db_input($HTTP_POST_VARS['update_billing_postcode']) . "', billing_country = '" . tep_db_input(stripslashes($HTTP_POST_VARS['update_billing_country'])) . "',";

          if($payment_method=="")
            $bb=tep_db_input($update_info_payment_method);
          else
            $bb=$payment_method_title;
          $UpdateOrders .= "delivery_name = '" . tep_db_input(stripslashes($HTTP_POST_VARS['update_delivery_name'])) . "', delivery_company = '" . tep_db_input(stripslashes($HTTP_POST_VARS['update_delivery_company'])) . "', delivery_street_address = '" . tep_db_input(stripslashes($HTTP_POST_VARS['update_delivery_street_address'])) . "', delivery_suburb = '" . tep_db_input(stripslashes($HTTP_POST_VARS['update_delivery_suburb'])) . "', delivery_city = '" . tep_db_input(stripslashes($HTTP_POST_VARS['update_delivery_city'])) . "', delivery_state = '" . tep_db_input(stripslashes($HTTP_POST_VARS['update_delivery_state'])) . "', delivery_postcode = '" . tep_db_input($HTTP_POST_VARS['update_delivery_postcode']) . "', delivery_country = '" . tep_db_input(stripslashes($HTTP_POST_VARS['update_delivery_country'])) . "', payment_method = '" . $bb . "', cc_type = '" . tep_db_input($update_info_cc_type) . "', cc_owner = '" . tep_db_input($update_info_cc_owner) . "', cc_number = '" . $HTTP_POST_VARS['update_info_cc_number'] . "', cc_expires = '" . $HTTP_POST_VARS['update_info_cc_expires'] . "',  cc_cvn = '" . $HTTP_POST_VARS['update_info_cc_cvn'] . "'";

          if(!$CommentsWithStatus) {
            $UpdateOrders .= ", comments = '" . tep_db_input($comments) . "'";
          }
          $UpdateOrders .= " where orders_id = '" . tep_db_input($oID) . "';";

          tep_db_query($UpdateOrders);
          $order_updated = true;

          $cart = new shoppingCart($oID);
          $cart->calculate();

          $order = new order($oID); ///update the addresses

        if ($HTTP_POST_VARS['calculate_totals']==1) {

          $shipping_quoted = '';
          $shipping_num_boxes = 1;
          $shipping_weight = $cart->show_weight();

          if (SHIPPING_BOX_WEIGHT >= $shipping_weight*SHIPPING_BOX_PADDING/100) {
            $shipping_weight = $shipping_weight+SHIPPING_BOX_WEIGHT;
          } else {
            $shipping_weight = $shipping_weight + ($shipping_weight*SHIPPING_BOX_PADDING/100);
          }

          if ($shipping_weight > SHIPPING_MAX_WEIGHT) { // Split into many boxes
            $shipping_num_boxes = ceil($shipping_weight/SHIPPING_MAX_WEIGHT);
            $shipping_weight = $shipping_weight/$shipping_num_boxes;
          }


// update totals
          if(is_object($GLOBALS[$class]) && $shipping) {
            $shipping_fee_array =  $GLOBALS[$class]->quote();
            $shipping_fee_methods = $shipping_fee_array['methods'];
            $shipping_fee = $shipping_fee_methods[0]['cost'];
            $sql_data_shipping_array = array('value ' => $shipping_fee,
                                             'text' => $currencies->format($shipping_fee, true, $currency),
                                             'title' => $shipping_fee_array['module'] . '(' . $shipping_fee_methods[0]['title'] . '):');
            tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_shipping_array, 'update', ' orders_id="' . $oID . '" and class="ot_shipping"');
          }
          $order->info['shipping_cost'] = $shipping_fee;
          $order->info['total'] += $shipping_fee;
          require_once(DIR_WS_CLASSES . 'order_total.php');
          $order_total_modules = new order_total;
          $order_totals = $order_total_modules->process();
          for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
            $res = tep_db_query("select count(*) as total from " . TABLE_ORDERS_TOTAL . " where orders_id='" . $oID . "' and class='" . $order_totals[$i]['code'] . "'");
            $d = tep_db_fetch_array($res);
           if ($order_totals[$i]['code'] == 'ot_tax') {
             //$order_totals[$i]['title'] = $order_totals[$i]['code'];
           }
            $sql_data_array = array('title' => $order_totals[$i]['title'],
                                    'text' => $order_totals[$i]['text'],
                                    'value' => $order_totals[$i]['value'],
                                    'sort_order' => $order_totals[$i]['sort_order']);
            if ($d['total']==0){
              $sql_data_array['orders_id'] = $oID;
              $sql_data_array['class'] = $order_totals[$i]['code'];
              tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
            } else {
              tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', "orders_id='" . $oID . "' and class='" . $order_totals[$i]['code'] . "'");
            }
          }
        } else {
          $update_totals = $HTTP_POST_VARS['update_totals'];
//echo "<pre>"; print_r($update_totals); echo "</pre>";
          foreach ($update_totals as $ot){
            if ($ot['value']!=0){
              if (in_array($ot['class'], array('ot_subtotal', 'ot_total'))){

              } else {
                if ($ot['total_id']>0){
                  tep_db_query("update " . TABLE_ORDERS_TOTAL . " set title = '" . $ot['title'] . "', text = '" . $currencies->format($ot['value']) . "', value = '" . $ot['value'] . "', sort_order = '" . $ot['sort_order'] . "' where orders_total_id = '" . $ot['total_id'] . "'");
                } else {
                  tep_db_query("insert into " . TABLE_ORDERS_TOTAL . " set title = '" . $ot['title'] . "', text = '" . $currencies->format($ot['value']) . "', value = '" . $ot['value'] . "', sort_order = '" . $ot['sort_order'] . "', class='" . $ot['class'] . "', orders_id = '" . $HTTP_GET_VARS['oID'] . "'");
                }
              }
            } elseif ($ot['total_id']>0){
                tep_db_query("delete from " . TABLE_ORDERS_TOTAL . " where orders_total_id = '" . $ot['total_id'] . "'");
            }
          }
        }
        // update total in any case
        $res = tep_db_query("select sum(value) as s_value from " . TABLE_ORDERS_TOTAL . " where class<>'ot_total' and orders_id = '" . $HTTP_GET_VARS['oID'] . "'");
        $td = tep_db_fetch_array($res);
        $res = tep_db_query("select orders_total_id from " . TABLE_ORDERS_TOTAL . " where class='ot_total' and orders_id = '" . $HTTP_GET_VARS['oID'] . "'");
        if ($d = tep_db_fetch_array($res)){
          tep_db_query("update " . TABLE_ORDERS_TOTAL . " set value = '" . $td['s_value'] . "', text = '" . $currencies->format($td['s_value']) . "' where orders_total_id = '" . $d['orders_total_id'] . "' and orders_id = '" . $HTTP_GET_VARS['oID'] . "'");
        }

        if ($order_updated) {
          $messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
        }
        $status = tep_db_prepare_input($HTTP_POST_VARS['status']);
        $comments = tep_db_prepare_input($HTTP_POST_VARS['comments']);

// initialized for the email confirmation
        $products_ordered = '';
        for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
//------ select customer choosen option --------
          $attributes_exist = '0';
          $products_ordered_attributes = '';
          if (isset($order->products[$i]['attributes'])) {
            $attributes_exist = '1';
            for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
              if (DOWNLOAD_ENABLED == 'true') {
                $attributes_query = "select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename
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
                $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $languages_id . "' and poval.language_id = '" . $languages_id . "'");
              }
              $attributes_values = tep_db_fetch_array($attributes);

              $products_ordered_attributes .= "\n\t" . $attributes_values['products_options_name'] . ' ' . $attributes_values['products_options_values_name'];
            }
          }
//------customer choosen option eof ----

          $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . ' (' . $order->products[$i]['model'] . ') = ' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . $products_ordered_attributes . "\n";
        }
// Update Status History & Email Customer if Necessary
        tep_db_query("update " . TABLE_ORDERS . " set orders_status = '" . tep_db_input($status) . "' where orders_id = '" . tep_db_input($oID) . "'");
        if ($order->info['orders_status'] != $status) {
          // Notify Customer
          $customer_notified = '0';
          if (isset($HTTP_POST_VARS['notify']) && ($HTTP_POST_VARS['notify'] == 'on')) {
            $notify_comments = '';
            if (isset($HTTP_POST_VARS['notify_comments']) && ($HTTP_POST_VARS['notify_comments'] == 'on')) {
              $notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $comments) . "\n\n";
            }
            // lets start with the email confirmation
            if (!tep_session_is_registered('noaccount')) {
              $email_order = //EMAIL_TEXT_HEADER. "\n" .
                             STORE_NAME . "\n" .
                             EMAIL_SEPARATOR . "\n" .
                             EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n" .
                             EMAIL_TEXT_INVOICE_URL . ' ' . HTTP_SERVER.DIR_WS_CATALOG.FILENAME_CATALOG_ACCOUNT_HISTORY_INFO. '?order_id=' . $oID . "\n" .
                             EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n";
              if ($order->info['comments']) {
                $email_order .= tep_db_output($order->info['comments']) . "\n\n";
              }
              $email_order .= EMAIL_TEXT_PRODUCTS . "\n" .
                              EMAIL_SEPARATOR . "\n" .
                              $products_ordered .
                              EMAIL_SEPARATOR . "\n";
              } else {
              $email_order = STORE_NAME . "\n" .
                             EMAIL_SEPARATOR . "\n" .
                             EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n" .
                             EMAIL_TEXT_DATE_ORDERED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n";
              if ($order->info['comments']) {
                $email_order .= tep_db_output($order->info['comments']) . "\n\n";
              }
              $email_order .= EMAIL_TEXT_PRODUCTS . "\n" .
                              EMAIL_SEPARATOR . "\n" .
                              $products_ordered .
                              EMAIL_SEPARATOR . "\n";
              }

              $totals_query = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$oID . "' order by sort_order");
              $order->totals = array();
              while ($totals = tep_db_fetch_array($totals_query)) {
                $email_order .= strip_tags($totals['title']) . ' ' . strip_tags($totals['text']) . "\n";
              }


              if ($order->content_type != 'virtual') {
                $email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" .
                                EMAIL_SEPARATOR . "\n" .
                                tep_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', "\n") . "\n";
              }

              $email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" .
                              EMAIL_SEPARATOR . "\n" .
                              /*tep_address_label($customer_id, $billto, 0, '', "\n") . "\n\n";*/
                              tep_address_format($order->billing['format_id'], $order->billing, 1, ' ', "\n") . "\n\n";


              $query=" select payment_class from ".TABLE_ORDERS." where orders_id='".$oID."'";
              $result=tep_db_query($query);
              $array=tep_db_fetch_array($result);
              $payment_class=$array['payment_class'];
              if($payment_class != "") {
                $module=$payment_class;
                if (is_object($$payment)) {
                  $email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" .
                                  EMAIL_SEPARATOR . "\n";
                  $payment_class = $$payment;
                  $email_order .= $payment_class->title . "\n\n";
                  if ($payment_class->email_footer) {
                    $email_order .= $payment_class->email_footer . "\n\n";
                  }
                }
              }
              $email_order=str_replace("&nbsp;", " ", $email_order);

              tep_mail($order->customer['firstname'] . ' ' . $order->customer['lastname'], $order->customer['email_address'], EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
              // send emails to other people
              if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
                tep_mail('', SEND_EXTRA_ORDER_EMAILS_TO, EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
              }

              $check_status_query = tep_db_query("select customers_name, customers_email_address, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");
              $check_status = tep_db_fetch_array($check_status_query);

             // $email = sprintf(EMAIL_TEXT_CHANGE_OF_ORDER_STATUS_TO_SHIPPED_TEXT, $check_status['customers_name'], tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL'));
              $email = sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]);
              $notify_comments . sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]);
              tep_mail($check_status['customers_name'], $check_status['customers_email_address'], EMAIL_TEXT_SUBJECT, nl2br($email), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
             
              require '../push.php';

              if(isset($orders_status_array[$status])) {

              $sql = "SELECT * FROM `orders_status` WHERE `orders_status_name` LIKE '".$orders_status_array[$status]."'";

              $result      = tep_db_query($sql);
              $data        = tep_db_fetch_array($result);
              $user_id     = $order->customer['customer_id'];
              $subject     = $data['orders_status_name'];
              $description = $data['orders_status_default_comment'];

              sendMessage($user_id,$subject,$description);
              }

              $customer_notified = '1';
          }
          if($CommentsWithStatus) {
            tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . tep_db_input($oID) . "', '" . tep_db_input($status) . "', now(), " . tep_db_input($customer_notified) . ", '" . tep_db_input($comments)  . "')");
          } else {
            if($OldNewStatusValues) {
              tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, new_value, old_value, date_added, customer_notified) values ('" . tep_db_input($oID) . "', '" . tep_db_input($status) . "', '" . $order->info['orders_status'] . "', now(), " . tep_db_input($customer_notified) . ")");
            } else {
              tep_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified)
              values ('" . tep_db_input($oID) . "', '" . tep_db_input($status) . "', now(), " . tep_db_input($customer_notified) . ")");
            }
          }
        }

        tep_redirect(tep_href_link(FILENAME_EDIT_ORDERS, "oID=" . $oID));
//        tep_redirect(tep_href_link(FILENAME_ORDERS, "action=edit&oID=" . $oID));
      break;
      // Add a Product
      case 'add_product':
        if($step == 3) {
          // Get Order Info
          $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);
          $qty = tep_db_prepare_input($HTTP_POST_VARS['add_product_quantity']);
          $order = new order($oID);
          $query = "select shipping_class from " . TABLE_ORDERS . " where orders_id='" . $HTTP_GET_VARS['oID'] . "'";
          $result=tep_db_query($query);
          if(tep_db_num_rows($result)>0) {
            $array=tep_db_fetch_array($result);
            $shipping_class=$array['shipping_class'];
            if(strlen(trim($shipping_class))>0) {
              $shipping=$shipping_class.".php";
              $class = $shipping_class;
              include_once(DIR_FS_CATALOG . DIR_WS_LANGUAGES . $language . '/modules/shipping/' . $shipping);
              include_once(DIR_FS_CATALOG . DIR_WS_MODULES . 'shipping/' . $shipping);
              $GLOBALS[$class] = new $class;
            }
          }
          $AddedOptionsPrice = 0;
          $add_product_options = $HTTP_POST_VARS['add_product_options'];
          //print_r($add_product_options);
          $uprid = tep_get_uprid($add_product_products_id, $add_product_options);
          // Get Product Attribute Info
          if(is_array($add_product_options)) {
            ksort($add_product_options);
            foreach($add_product_options as $option_id => $option_value_id) {
              $result = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_ATTRIBUTES . " pa LEFT JOIN " . TABLE_PRODUCTS_OPTIONS . " po ON po.products_options_id=pa.options_id LEFT JOIN " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov ON pov.products_options_values_id=pa.options_values_id WHERE products_id='" . $add_product_products_id . "' and options_id=" . $option_id . " and options_values_id='" . $option_value_id . "'");
              $row = tep_db_fetch_array($result);
              if (is_array($row))
              {
                extract($row, EXTR_PREFIX_ALL, "opt");
                if ($opt_price_prefix == '+') {
                  $AddedOptionsPrice += $opt_options_values_price;
                } else {
                  $AddedOptionsPrice -= $opt_options_values_price;
                }
                $option_value_details[$option_id][$option_value_id] = array ("options_values_price" => $opt_options_values_price);
                $option_names[$option_id] = $opt_products_options_name;
                $option_values_names[$option_value_id] = $opt_products_options_values_name;
              }
            }
          }
//          update_stock($uprid, $qty, 0, $add_product_options);
          update_stock($uprid, -$qty);

          // Get Product Info
          $InfoQuery = "select p.products_model, p.products_price, pd.products_name, p.products_tax_class_id from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on pd.products_id=p.products_id where p.products_id='$add_product_products_id'";
          $result = tep_db_query($InfoQuery);
          if(tep_db_num_rows($result)>0){
            $row = tep_db_fetch_array($result);
            extract($row, EXTR_PREFIX_ALL, "p");

            $ProductsTax = tep_get_tax_rate($p_products_tax_class_id, $order->delivery['country']['id'], $order->delivery['zone_id']);

            $Query = "insert into " . TABLE_ORDERS_PRODUCTS . " set orders_id = " . $oID . ", products_id = '" . $add_product_products_id . "', products_model = '" . $p_products_model . "', products_name = '" . str_replace("'", "&#39;", $p_products_name) . "', products_price = '" . $p_products_price . "', final_price = '" . ($p_products_price + $AddedOptionsPrice) . "', products_tax = '" . $ProductsTax . "', products_quantity = '" . $add_product_quantity . "', uprid='" . $uprid . "' ";
            tep_db_query($Query);
            $new_product_id = tep_db_insert_id();
            if(is_array($add_product_options)) {
              foreach($add_product_options as $option_id => $option_value_id) {
                $Query = "insert into " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " set orders_id = " . $oID . ", orders_products_id = " . $new_product_id . ", products_options = '" . $option_names[$option_id] . "', products_options_values = '" . $option_values_names[$option_value_id] . "', options_values_price = '" . $option_value_details[$option_id][$option_value_id]["options_values_price"] . "', price_prefix = '+';";
                tep_db_query($Query);
              }
            }
          }
///////////////////////////////////////
// update totals
          $cart = new shoppingCart($oID);
          $cart->calculate();
          $shipping_quoted = '';
          $shipping_num_boxes = 1;
          $shipping_weight = $cart->show_weight();
          if (SHIPPING_BOX_WEIGHT >= $shipping_weight*SHIPPING_BOX_PADDING/100) {
            $shipping_weight = $shipping_weight+SHIPPING_BOX_WEIGHT;
          } else {
            $shipping_weight = $shipping_weight + ($shipping_weight*SHIPPING_BOX_PADDING/100);
          }
          if ($shipping_weight > SHIPPING_MAX_WEIGHT) { // Split into many boxes
            $shipping_num_boxes = ceil($shipping_weight/SHIPPING_MAX_WEIGHT);
            $shipping_weight = $shipping_weight/$shipping_num_boxes;
          }
          if(is_object($GLOBALS[$class])) {// shipping class
            $shipping_fee_array =  $GLOBALS[$class]->quote();
            $shipping_fee_methods = $shipping_fee_array['methods'];
            $shipping_fee = $shipping_fee_methods[0]['cost'];
            $sql_data_shipping_array = array('value ' => $shipping_fee,
                                             'text' => $currencies->format($shipping_fee, true, $currency),
                                             'title' => $shipping_fee_array['module'] . '(' . $shipping_fee_methods[0]['title'] . '):');
            tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_shipping_array, 'update', ' orders_id="' . $oID . '" and class="ot_shipping"');
          }
          // recreate order in order to recalculate totals and update shipping costs
          $order = new order($oID);
          $order->info['shipping_cost'] = $shipping_fee;
          $order->info['total'] += $shipping_fee;
          require_once(DIR_WS_CLASSES . 'order_total.php');
          $order_total_modules = new order_total;
          $order_totals = $order_total_modules->process();
          for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
            $res = tep_db_query("select count(*) as total from " . TABLE_ORDERS_TOTAL . " where orders_id='" . $oID . "' and class='" . $order_totals[$i]['code'] . "'");
            $d = tep_db_fetch_array($res);
            $sql_data_array = array('title' => $order_totals[$i]['title'],
                                    'text' => $order_totals[$i]['text'],
                                    'value' => $order_totals[$i]['value'],
                                    'sort_order' => $order_totals[$i]['sort_order']);
            if ($d['total']==0){
              $sql_data_array['orders_id'] = $oID;
              $sql_data_array['class'] = $order_totals[$i]['code'];
              tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
            } else {
              tep_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', "orders_id='" . $oID . "' and class='" . $order_totals[$i]['code'] . "'");
            }
            // update total in any case (as there are custom total field)
            $res = tep_db_query("select sum(value) as s_value from " . TABLE_ORDERS_TOTAL . " where class<>'ot_total' and orders_id = '" . $HTTP_GET_VARS['oID'] . "'");
            $td = tep_db_fetch_array($res);
            $res = tep_db_query("select orders_total_id from " . TABLE_ORDERS_TOTAL . " where class='ot_total' and orders_id = '" . $HTTP_GET_VARS['oID'] . "'");
            if ($d = tep_db_fetch_array($res)){
              tep_db_query("update " . TABLE_ORDERS_TOTAL . " set value = '" . $td['s_value'] . "' where orders_total_id = '" . $d['orders_total_id'] . "' and orders_id = '" . $HTTP_GET_VARS['oID'] . "'");
            }
          }
          tep_redirect(tep_href_link(FILENAME_EDIT_ORDERS, "oID=" . $oID));
        }
      break;
    }
  }

  if (($action == 'edit') && isset($HTTP_GET_VARS['oID'])) {
    $oID = tep_db_prepare_input($HTTP_GET_VARS['oID']);

    $orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");
    $order_exists = true;
    if (!tep_db_num_rows($orders_query)) {
      $order_exists = false;
      $messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
    }
  }
  // added by Art. Start
  $fields = array("cc_number", "cc_type", "cc_owner", "cc_expires", "cc_cvn");
  $js_arrs  = 'var fields = new Array("' . implode('", "', $fields) . '");' . "\n";
  foreach($fields as $field){
    $js_arrs .= 'var ' . $field . ' = new Array();' . "\n";
  }
  // added by Art. Stop
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js">
</script>
<!-- added by Art. Start -->
<script language="javascript">
      <?php echo $js_arrs;?>
      function select_cc(cc){
        var f = document.edit_order;
        f.update_info_cc_type.value = cc_type[cc];
        f.update_info_cc_owner.value = cc_owner[cc];
        f.update_info_cc_number.value = cc_number[cc];
        f.update_info_cc_expires.value = cc_expires[cc];
        f.update_info_cc_cvn.value = cc_cvn[cc];
      }
</script>
<!-- added by Art. Stop -->
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
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
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if (($action == 'edit') && ($order_exists == true)) {
    $order = new order($oID);
?>


      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?> #<?php echo $oID; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="pageHeading" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_ORDERS,  'action=edit&oID=' . $oID) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
          </tr>
        </table></td>
      </tr>


<!-- Begin Addresses Block -->
      <tr><?php echo tep_draw_form('edit_order', "edit_orders.php", tep_get_all_get_params(array('action','paycc')) . 'action=update_order');
      $cart = new shoppingCart($oID);
      $cart->calculate();
      //echo '<pre>'; print_r($cart);echo '</pre>'; echo '<pre>'; print_r($order);echo '</pre>';
      ?>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td colspan="3"><?php echo tep_draw_separator();?></td>
          </tr>
          <tr>
            <!-- Customer Info Block -->
            <td valign="top"><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td colspan='2' class="main" valign="top"><b><?php echo ENTRY_CUSTOMER; ?></b></td>
              </tr>
              <tr>
                <td colspan='2' class="main"><?php echo show_address_entry('update_customer_', $order->customer, true);?></td>
              </tr>
            </table></td>
            <!-- Billing Address Block -->
            <td valign="top"><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td colspan='2' class="main" valign="top"><b><?php echo ENTRY_BILLING_ADDRESS; ?></b></td>
              </tr>
              <tr>
                <td colspan='2' class="main"><?php echo show_address_entry('update_billing_', $order->billing);?></td>
              </tr>
            </table></td>
            <!-- Shipping Address Block -->
            <td valign="top"><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_SHIPPING_ADDRESS; ?></b></td>
              </tr>
              <tr>
                <td class="main"><?php echo show_address_entry('update_delivery_', $order->delivery); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
<!-- End Addresses Block -->
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<!-- Begin Phone/Email Block -->
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo ENTRY_TELEPHONE_NUMBER; ?></b></td>
            <td class="main"><input name='update_customer_telephone' size='15' value='<?php echo $order->customer['telephone']; ?>'></td>
          </tr>
          <tr>
            <td class="main"><b><?php echo ENTRY_EMAIL_ADDRESS; ?></b></td>
            <td class="main"><input name='update_customer_email_address' size='35' value='<?php echo $order->customer['email_address']; ?>'></td>
          </tr>
        </table></td>
      </tr>
<!-- End Phone/Email Block -->

      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>

<!--begin select shipping and payment Block-->
<?
  $include_modules = array();
  if (tep_not_null(MODULE_SHIPPING_INSTALLED)) {
      $modules = explode(';', MODULE_SHIPPING_INSTALLED);

     $query=" select shipping_class from ".TABLE_ORDERS." where orders_id='".$oID."'";
     $result=tep_db_query($query);
     $array=tep_db_fetch_array($result);
     $current_shipping_class_id=$array['shipping_class'].".php";


      if ( (tep_not_null($module)) && (in_array(substr($module['id'], 0, strpos($module['id'], '_')) . '.' . substr($PHP_SELF, (strrpos($PHP_SELF, '.')+1)), $modules)) ) {
        $include_modules[] = array('class' => substr($module['id'], 0, strpos($module['id'], '_')), 'file' => substr($module['id'], 0, strpos($module['id'], '_')) . '.' . substr($PHP_SELF, (strrpos($PHP_SELF, '.')+1)));
      } else {
        reset($modules);
        while (list(, $value) = each($modules)) {
          $class = substr($value, 0, strrpos($value, '.'));
          $include_modules[] = array('class' => $class, 'file' => $value);
        }
      }

      $n = sizeof($include_modules);
      for ($i=0; $i<$n; $i++) {
        include_once(DIR_FS_CATALOG . DIR_WS_LANGUAGES . $language . '/modules/shipping/' . $include_modules[$i]['file']);
        include_once(DIR_FS_CATALOG . DIR_WS_MODULES . 'shipping/' . $include_modules[$i]['file']);

        $GLOBALS[$include_modules[$i]['class']] = new $include_modules[$i]['class'];
      }
    }

    $shipping_array = array();
    $i = 0;
    foreach($include_modules as $ell) {
      $shipping_array[$i]['id'] = $ell['file'];
      $shipping_array[$i]['text'] = $GLOBALS[$ell['class']]->title;
      $i++;
    }

      if (tep_not_null(MODULE_PAYMENT_INSTALLED)) {
        $query=" select payment_method from ".TABLE_ORDERS." where orders_id='".$oID."'";
        $result=tep_db_query($query);
        $array=tep_db_fetch_array($result);
        //$current_payment_class_id=$array['payment_class'].".php";
        $current_payment_class=$array['payment_method'];
        $modules = explode(';', MODULE_PAYMENT_INSTALLED);
        $include_modules = array();
        if ( (tep_not_null($module)) && (in_array($module . '.' . substr($PHP_SELF, (strrpos($PHP_SELF, '.')+1)), $modules)) ) {
          $this->selected_module = $module;
          $include_modules[] = array('class' => $module, 'file' => $module . '.php');
        } else {
          reset($modules);
          while (list(, $value) = each($modules)) {
            $class = substr($value, 0, strrpos($value, '.'));
            $include_modules[] = array('class' => $class, 'file' => $value);
          }
        }

        $n = sizeof($include_modules);
        for ($i=0; $i<$n; $i++) {
          include(DIR_FS_CATALOG . DIR_WS_LANGUAGES . $language . '/modules/payment/' . $include_modules[$i]['file']);
          include(DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/' . $include_modules[$i]['file']);

          $GLOBALS[$include_modules[$i]['class']] = new $include_modules[$i]['class'];
        }

        if ( (tep_not_null($module)) && (in_array($module, $modules)) && (isset($GLOBALS[$module]->form_action_url)) ) {
          $this->form_action_url = $GLOBALS[$module]->form_action_url;
        }
      }

    $payment_array = array();
    $i = 0;
    foreach($include_modules as $ell) {
        $payment_array[$i]['id'] = $ell['file'];
        $payment_array[$i]['text'] = $GLOBALS[$ell['class']]->title;
        if ($current_payment_class == $payment_array[$i]['text']) {
          $current_payment_class_id =$payment_array[$i]['id'];
          }
        $i++;
    }
?>
      <tr>
        <td><?php if (count($shipping_array)>0) echo tep_draw_pull_down_menu('shipping', $shipping_array,$current_shipping_class_id)?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_pull_down_menu('payment', $payment_array, $current_payment_class_id)?>
        <!-- added by Art. Start -->
        <?php
          if (in_array($order->info['payment_class'], array("cc", 'cnet'))) {
//          if ($order->info['payment_method'] == "Credit Card") {
            $customers_id_query="select customers_id from ".TABLE_ORDERS." where orders_id='".$oID."'";
            $result=tep_db_query($customers_id_query);
            $array=tep_db_fetch_array($result);
            $customers_id=$array['customers_id'];
            $cc_numbers_query="select distinct(cc_number) from ".TABLE_ORDERS." where customers_id='".$customers_id."' and cc_number<>''";
            $result=tep_db_query($cc_numbers_query);
            if(tep_db_num_rows($result)>0){
              $cc_numbers_array=array();
              $i=0;
              while($array=tep_db_fetch_array($result)){
                $cc_numbers_array[$i]['id']=$array['cc_number'];
                $cc_numbers_array[$i]['text']=$array['cc_number'];
                $i++;
              }
//'onchange="this.form.update_info_cc_number.value=this.form.cc_numbers.value;"'
              echo tep_draw_pull_down_menu('cc_numbers', $cc_numbers_array, $order->info['cc_number'],'onchange="select_cc(this.options[this.selectedIndex].value);" onclick="select_cc(this.options[this.selectedIndex].value);"');
              $cc_query = tep_db_query("select distinct(cc_number),cc_type,cc_owner,cc_expires,cc_cvn from " . TABLE_ORDERS ." where customers_id = '" . $customers_id . "' and cc_number<>''");
              $js_arrs = '';
              while ($d = tep_db_fetch_array($cc_query)){
                foreach($fields as $field){
                  $js_arrs .= '' . $field . '[' . $d['cc_number'] . '] = "' . $d[$field] . '";' . "\n";
                }
              }
              echo '<script>' . $js_arrs . '</script>' ;
            }
          }
        ?>
        <!-- added by Art. Stop -->
        </td>
      </tr>
  <?php if ($order->info['cc_type'] || $order->info['cc_owner'] || (in_array($order->info['payment_class'], array("cc", 'cnet'))) || $order->info['cc_number']) { ?>
    <!-- Begin Credit Card Info Block -->
      <tr>
        <td><table cellpadding=0 cellspacing=0 border=0>
          <tr>
            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_TYPE; ?></td>
            <td class="main"><input name='update_info_cc_type' size='10' value='<?php echo $order->info['cc_type']; ?>'></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_OWNER; ?></td>
            <td class="main"><input name='update_info_cc_owner' size='20' value='<?php echo $order->info['cc_owner']; ?>'></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_NUMBER; ?></td>
            <td class="main"><input name='update_info_cc_number' size='20' value='<?php echo $order->info['cc_number']; ?>'></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_CVN; ?></td>
            <td class="main"><input name='update_info_cc_cvn' size='4' value='<?php echo $order->info['cc_cvn']; ?>'></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_EXPIRES; ?></td>
            <td class="main"><input name='update_info_cc_expires' size='4' value='<?php echo $order->info['cc_expires']; ?>'></td>
          </tr>
        </table></td>
      </tr>
    <!-- End Credit Card Info Block -->
  <?php } ?>


      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<!-- End Payment Block -->

      <tr>
  <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>

<!-- Begin Products Listing Block -->
      <tr>
  <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
    <tr class="dataTableHeadingRow">
      <td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>
      <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_TAX; ?></td>
      <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_UNIT_PRICE; ?></td>
      <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_PRICE; ?></td>
    </tr>

  <!-- Begin Products Listings Block -->
  <?
        // Override order.php Class's Field Limitations
    $index = 0;
    $order->products = array();
    $orders_products_query = tep_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$oID . "'");
    while ($orders_products = tep_db_fetch_array($orders_products_query)) {
    $order->products[$index] = array('qty' => $orders_products['products_quantity'],
                                        'name' => str_replace("'", "&#39;", $orders_products['products_name']),
                                        'model' => $orders_products['products_model'],
                                        'tax' => $orders_products['products_tax'],
                                        'price' => $orders_products['products_price'],
                                        'final_price' => $orders_products['final_price'],
                                        'orders_products_id' => $orders_products['orders_products_id']);

    $subindex = 0;
    $attributes_query_string = "select * from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . (int)$oID . "' and orders_products_id = '" . (int)$orders_products['orders_products_id'] . "'";
    $attributes_query = tep_db_query($attributes_query_string);

    if (tep_db_num_rows($attributes_query)) {
    while ($attributes = tep_db_fetch_array($attributes_query)) {
      $order->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options'],
                                                               'value' => $attributes['products_options_values'],
                                                               'prefix' => $attributes['price_prefix'],
                                                               'price' => $attributes['options_values_price'],
                                                               'orders_products_attributes_id' => $attributes['orders_products_attributes_id']);
    $subindex++;
    }
    }
    $index++;
    }
//echo "<pre>"; print_r($order->products);echo "</pre>";
  for ($i=0; $i<sizeof($order->products); $i++) {
    $orders_products_id = $order->products[$i]['orders_products_id'];

    $RowStyle = "dataTableContent";

    echo '    <tr class="dataTableRow">' . "\n" .
       '      <td class="' . $RowStyle . '" valign="top" align="right">' . "<input name='update_products[$orders_products_id][qty]' size='2' value='" . $order->products[$i]['qty'] . "'>&nbsp;x</td>\n" . tep_draw_hidden_field('update_products[' . $orders_products_id . '][old_qty]', $order->products[$i]['qty']) .
       '      <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][name]' size='25' value='" . $order->products[$i]['name'] . "'>";

    // Has Attributes?
    if (sizeof($order->products[$i]['attributes']) > 0) {
      for ($j=0; $j<sizeof($order->products[$i]['attributes']); $j++) {
        $orders_products_attributes_id = $order->products[$i]['attributes'][$j]['orders_products_attributes_id'];
        echo '<br><nobr><small>&nbsp;<i> - ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][option]' size='6' value='" . $order->products[$i]['attributes'][$j]['option'] . "'>" . ': ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][value]' size='10' value='" . $order->products[$i]['attributes'][$j]['value'] . "'>";
        echo '</i></small></nobr>' . tep_draw_hidden_field('update_products[' . $orders_products_id . '][attrib][' . $orders_products_attributes_id . ']', $orders_products_attributes_id);
      }
    }

    echo '      </td>' . "\n" .
         '      <td class="' . $RowStyle . '" valign="top">' . "<input name='update_products[$orders_products_id][model]' size='12' value='" . $order->products[$i]['model'] . "'>" . '</td>' . "\n" .
         '      <td class="' . $RowStyle . '" align="center" valign="top">' . "<input name='update_products[$orders_products_id][tax]' size='3' value='" . tep_display_tax_value($order->products[$i]['tax']) . "'>" . '%</td>' . "\n" .
         '      <td class="' . $RowStyle . '" align="right" valign="top">' . "<input name='update_products[$orders_products_id][final_price]' size='5' value='" . number_format($order->products[$i]['final_price'], 2, '.', '') . "'>" . '</td>' . "\n" .
         '      <td class="' . $RowStyle . '" align="right" valign="top">' . $currencies->format($order->products[$i]['final_price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</td>' . "\n" .
         '    </tr>' . "\n";
  }
  ?>
  <!-- End Products Listings Block -->

  <!-- Begin Order Total Block -->
    <tr>
      <td align="right" colspan="6"><table border="0" cellspacing="0" cellpadding="2" width="100%">
        <tr>
          <td align='center' valign='top' class=main><br><a href="<? echo tep_href_link(FILENAME_EDIT_ORDERS, 'oID=' . $oID . '&action=add_product&step=1'); ?>"><u><b><?php echo TEXT_ADD_A_NEW_PRODUCT; ?></b></u></a></td>
          <td align='right'><table border="0" cellspacing="0" cellpadding="2">
<?php
// Override order.php Class's Field Limitations
  $sort_orders = array();
  $totals_query = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$oID . "' order by sort_order");
  $order->totals = array();
  $TotalsArray = array();
  while ($totals = tep_db_fetch_array($totals_query)) {
    $order->totals[] = array('title' => $totals['title'],
                             'text' => $totals['text'],
                             'class' => $totals['class'],
                             'value' => $totals['value'],
                             'orders_total_id' => $totals['orders_total_id']);
    $sort_orders[] = $totals['sort_order'];
    $TotalsArray[] = array("Name" => $totals['title'],
                           "Price" => number_format($totals['value'], 2, '.', ''),
                           "Class" => $totals['class'],
                           "sort_order" => $totals['sort_order'],
                           "TotalID" => $totals['orders_total_id']);
  }
  rsort($sort_orders);
  if (($sort_orders[0]-1)<=$sort_orders[1]){
    $new_sort_order = $sort_orders[0];
    $TotalsArray[count($TotalsArray)-1]["sort_order"] = $new_sort_order + 1;
  } else {
    $new_sort_order = $sort_orders[1]+1;
  }
  $TotalsArray[] = array("Name" => "          ", "Price" => "", "Class" => "ot_custom", "TotalID" => "0", 'sort_order' => $new_sort_order);
  foreach($TotalsArray as $TotalIndex => $TotalDetails) {
    $TotalStyle = "smallText";
    if(($TotalDetails["Class"] == "ot_subtotal") || ($TotalDetails["Class"] == "ot_total")) {
      echo  '       <tr>' . "\n" .
        '   <td class="main" align="right"><b>' . $TotalDetails["Name"] . '</b></td>' .
        '   <td class="main"><b>' . $TotalDetails["Price"] .
            "<input name='update_totals[$TotalIndex][title]' type='hidden' value='" . trim($TotalDetails["Name"]) . "' size='" . strlen($TotalDetails["Name"]) . "' >" .
            "<input name='update_totals[$TotalIndex][value]' type='hidden' value='" . $TotalDetails["Price"] . "' size='6' >" .
            "<input name='update_totals[$TotalIndex][class]' type='hidden' value='" . $TotalDetails["Class"] . "'>\n" .
            "<input type='hidden' name='update_totals[$TotalIndex][total_id]' value='" . $TotalDetails["TotalID"] . "'>" . '</b></td>' .
        '       </tr>' . "\n";
      echo tep_draw_hidden_field('update_totals[' . $TotalIndex . '][sort_order]', $TotalDetails['sort_order']);
    } elseif($TotalDetails["Class"] == "ot_tax") {
      echo  '       <tr>' . "\n" .
        '   <td align="right" class="' . $TotalStyle . '">' . "<input name='update_totals[$TotalIndex][title]' size='" . strlen(trim($TotalDetails["Name"])) . "' value='" . trim($TotalDetails["Name"]) . "'>" . '</td>' . "\n" .
        '   <td class="main"><b>' . "<input name='update_totals[$TotalIndex][value]' size='6' value='" . $TotalDetails["Price"] . "'>" .
            "<input name='update_totals[$TotalIndex][value]' type='hidden' value='" . $TotalDetails["Price"] . "' size='6' >" .
            "<input name='update_totals[$TotalIndex][class]' type='hidden' value='" . $TotalDetails["Class"] . "'>\n" .
            "<input type='hidden' name='update_totals[$TotalIndex][total_id]' value='" . $TotalDetails["TotalID"] . "'>" . '</b></td>' .
        '       </tr>' . "\n";
      echo tep_draw_hidden_field('update_totals[' . $TotalIndex . '][sort_order]', $TotalDetails['sort_order']);
    } else {
      echo  '       <tr>' . "\n" .
        '   <td align="right" class="' . $TotalStyle . '">' . "<input name='update_totals[$TotalIndex][title]' size='" . strlen(trim($TotalDetails["Name"])) . "' value='" . trim($TotalDetails["Name"]) . "'>" . '</td>' . "\n" .
        '   <td align="right" class="' . $TotalStyle . '">' . "<input name='update_totals[$TotalIndex][value]' size='6' value='" . $TotalDetails["Price"] . "'>" .
            "<input type='hidden' name='update_totals[$TotalIndex][class]' value='" . $TotalDetails["Class"] . "'>" .
            "<input type='hidden' name='update_totals[$TotalIndex][total_id]' value='" . $TotalDetails["TotalID"] . "'>" .
            '</td>' . "\n" .
        '       </tr>' . "\n";
      echo tep_draw_hidden_field('update_totals[' . $TotalIndex . '][sort_order]', $TotalDetails['sort_order']);
    }
  }
?>
            <tr>
              <td class=main align="right"><?php echo TEXT_CALCULATE_TOTALS; ?></td>
              <td class=main><?php echo tep_draw_checkbox_field('calculate_totals', '1', true); ?></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
  <!-- End Order Total Block -->

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
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_STATUS; ?></b></td>
            <? if($CommentsWithStatus) { ?>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
            <? } ?>
          </tr>
<?php
    $orders_history_query = tep_db_query("select * from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . tep_db_input($oID) . "' order by date_added");
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
        echo '            <td class="smallText">' . $orders_status_array[$orders_history['orders_status_id']] . '</td>' . "\n";

        if($CommentsWithStatus) {
        echo '            <td class="smallText">' . nl2br(tep_db_output($orders_history['comments'])) . '&nbsp;</td>' . "\n";
        }

        echo '          </tr>' . "\n";
      }
    } else {
        echo '          <tr>' . "\n" .
             '            <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
             '          </tr>' . "\n";
    }
?>
        </table></td>
      </tr>
      <tr><?php// echo tep_draw_form('update_status', "edit_orders.php", tep_get_all_get_params(array('action','paycc')) . 'action=update_status'); ?>
        <td class="main"><br><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
      </tr>
      <tr>
        <td class="main">
        <?
        if($CommentsWithStatus) {
          echo tep_draw_textarea_field('comments', 'soft', '60', '5');
  }
  else
  {
    echo tep_draw_textarea_field('comments', 'soft', '60', '5', $order->info['comments']);
  }
  ?>
        </td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>

      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo ENTRY_STATUS; ?></b>
            <?php echo tep_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status']); ?></td>
          </tr>
          <tr>
            <td class="main"><b><?php echo ENTRY_NOTIFY_CUSTOMER; ?></b> <?php echo tep_draw_checkbox_field('notify', '', false); ?></td>
          </tr>
          <? if($CommentsWithStatus) { ?>
          <tr>
                <td class="main"><b><?php echo ENTRY_NOTIFY_COMMENTS; ?></b> <?php echo tep_draw_checkbox_field('notify_comments', '', true); ?></td>
          </tr>
          <? } ?>
        </table></td>
      </tr>

      <tr>
        <td align='center' valign="top"><?php echo tep_image_submit('button_update.gif', IMAGE_UPDATE); ?></td>
      </tr>
      </form>
<?php
  }
if($action == "add_product") {
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo ADDING_TITLE; ?> #<?php echo $oID; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="pageHeading" align="right"><?php echo '<a href="' . tep_href_link(FILENAME_EDIT_ORDERS, tep_get_all_get_params(array('action', 'step') )) . '">' . tep_image_button('button_back.gif', IMAGE_BACK) . '</a>'; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border='0' cellpadding=2 cellspacing=0>
          <tr>
            <td class="main">
              <?php // Step 1: Choose Product
                echo tep_draw_form('search', FILENAME_EDIT_ORDERS, '', 'get') . tep_draw_hidden_field(tep_session_name(), tep_session_id()) . tep_draw_hidden_field('action', $HTTP_GET_VARS['action']) . tep_draw_hidden_field('oID', $oID);
                echo HEADING_TITLE_SEARCH_PRODUCTS;
              ?>
            </td>
            <td class="main" colspan=2><?php echo tep_draw_input_field('search');?></td>
            <td class="main"><?php //echo tep_image_submit('button_select.gif', IMAGE_SELECT);?></td>
          </tr>
<? if (strlen($HTTP_GET_VARS['search'])){
    $products_array = array();
    $products_query = tep_db_query("select p.products_id, pd.products_name, p.products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status =1 and p.products_id = pd.products_id and (pd.products_name like '%" . $HTTP_GET_VARS['search']. "%' or p.products_model like '%" . $HTTP_GET_VARS['search']. "%' or p.products_price like '%" . $HTTP_GET_VARS['search']. "%' ) and pd.language_id = '" . (int)$languages_id . "' order by products_name");
    while ($products = tep_db_fetch_array($products_query)) {
      $products_array[] = array('id' => $products['products_id'], 'text' => $products['products_name'] . ' (' . $currencies->format($products['products_price']) . ')');
    }
  } else {
    $products_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p");
    $d = tep_db_fetch_array($products_query);
    $products_array = array();
    if ($d['total'] <= MAX_PRODUCTS_PULLDOWN_WO_FILTER){
      $products_query = tep_db_query("select p.products_id, pd.products_name, p.products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where  p.products_status = 1 and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by products_name");
      while ($products = tep_db_fetch_array($products_query)) {
        $products_array[] = array('id' => $products['products_id'], 'text' => $products['products_name'] . ' (' . $currencies->format($products['products_price']) . ')');
      }
    } else {
      $products_array[] = array('id' => 0, 'text' => TEXT_APPLY_FILTER);
    }
  }
?>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCT; ?></td>
            <td class="main" colspan=2><?php
              echo tep_draw_pull_down_menu('add_product_products_id', $products_array);
              if (count($products_array)>0)
                echo tep_draw_hidden_field('step','2');?>
            </td>
            <td class="main"><?php
              echo tep_image_submit('button_select.gif', IMAGE_SELECT, (count($products_array)>0?'name="select"':''));?>
            </td>
          </form>
          </tr>
        </td>
      </tr>
      <tr>
<?php
    if (isset($HTTP_GET_VARS['select_x']) || isset($HTTP_GET_VARS['select_y'])) {
      echo tep_draw_form('add_product', FILENAME_EDIT_ORDERS, tep_get_all_get_params(array('step')));
      // Get Options for Products
      $result = tep_db_query("SELECT * FROM " . TABLE_PRODUCTS_ATTRIBUTES . " pa LEFT JOIN " . TABLE_PRODUCTS_OPTIONS . " po ON po.products_options_id=pa.options_id LEFT JOIN " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov ON pov.products_options_values_id=pa.options_values_id WHERE products_id='$add_product_products_id'");
      if(tep_db_num_rows($result) != 0) {
        ?>
        <td class="main"><?php echo TEXT_OPTIONS; ?></td>
        <?php
        while($row = tep_db_fetch_array($result)) {
          extract($row, EXTR_PREFIX_ALL, "db");
          $Options[$db_products_options_id] = $db_products_options_name;
          $ProductOptionValues[$db_products_options_id][$db_products_options_values_id] = $db_products_options_values_name;
        }
        foreach($ProductOptionValues as $OptionID => $OptionValues) {
          if (!$OptionID) continue;
?>
          <td class=main><b><?php echo $Options[$OptionID];?>:</b></td>
          <td><select name='add_product_options[<?php echo $OptionID?>]' >
<?php
              foreach($OptionValues as $OptionValueID => $OptionValueName) {
                echo "<option value='$OptionValueID'>" . $OptionValueName . "</option>\n";
              }
?>
            </select>
          </td>
          <td class=main></td>
        </tr>
        <tr>
          <td class=main></td>
          <?
        }
      }
      ?>
        </tr>
        <tr>
          <td class="main" valign='top'><?php echo TEXT_QUANTITY?></td>
          <td class="main" valign='top' colspan=2><?php echo tep_draw_input_field('add_product_quantity', '1', 'size="2"'); ?></td>
          <td class="main" valign='top'><?php echo tep_image_submit('button_insert.gif', IMAGE_INSERT) . tep_draw_hidden_field('add_product_products_id', $HTTP_GET_VARS['add_product_products_id']) . tep_draw_hidden_field('step', 3) ; ?></td>
        </form>
      </tr>
<?php
    }
      ?>
        </table></td>
      </tr>
<?php
}
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?
  ////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // Function    : tep_get_country_id
  //
  // Arguments   : country_name   country name string
  //
  // Return      : country_id
  //
  // Description : Function to retrieve the country_id based on the country's name
  //
  ////////////////////////////////////////////////////////////////////////////////////////////////
  function tep_get_country_id($country_name) {

    $country_id_query = tep_db_query("select * from " . TABLE_COUNTRIES . " where countries_name = '" . $country_name . "'");

    if (!tep_db_num_rows($country_id_query)) {
      return 0;
    }
    else {
      $country_id_row = tep_db_fetch_array($country_id_query);
      return $country_id_row['countries_id'];
    }
  }

  ////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // Function    : tep_get_country_iso_code_2
  //
  // Arguments   : country_id   country id number
  //
  // Return      : country_iso_code_2
  //
  // Description : Function to retrieve the country_iso_code_2 based on the country's id
  //
  ////////////////////////////////////////////////////////////////////////////////////////////////
  function tep_get_country_iso_code_2($country_id) {

    $country_iso_query = tep_db_query("select * from " . TABLE_COUNTRIES . " where countries_id = '" . $country_id . "'");

    if (!tep_db_num_rows($country_iso_query)) {
      return 0;
    }
    else {
      $country_iso_row = tep_db_fetch_array($country_iso_query);
      return $country_iso_row['countries_iso_code_2'];
    }
  }


  ////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // Function    : tep_field_exists
  //
  // Arguments   : table  table name
  //               field  field name
  //
  // Return      : true/false
  //
  // Description : Function to check the existence of a database field
  //
  ////////////////////////////////////////////////////////////////////////////////////////////////
  function tep_field_exists($table,$field) {

    $describe_query = tep_db_query("describe $table");
    while($d_row = tep_db_fetch_array($describe_query))
    {
      if ($d_row["Field"] == "$field")
      return true;
    }

    return false;
  }

  ////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // Function    : tep_html_quotes
  //
  // Arguments   : string any string
  //
  // Return      : string with single quotes converted to html equivalent
  //
  // Description : Function to change quotes to HTML equivalents for form inputs.
  //
  ////////////////////////////////////////////////////////////////////////////////////////////////
  function tep_html_quotes($string) {
    return str_replace("'", "&#39;", $string);
  }

  ////////////////////////////////////////////////////////////////////////////////////////////////
  //
  // Function    : tep_html_unquote
  //
  // Arguments   : string any string
  //
  // Return      : string with html equivalent converted back to single quotes
  //
  // Description : Function to change HTML equivalents back to quotes
  //
  ////////////////////////////////////////////////////////////////////////////////////////////////
  function tep_html_unquote($string) {
    return str_replace("&#39;", "'", $string);
  }

require(DIR_WS_INCLUDES . 'application_bottom.php');


function show_address_entry($prefix, $entry, $hidden=false){
  if ($hidden){
    $str = '';
    $str .= '        <table width="100%" border="0">';
    $str .= '          <tr><td width="50%" class="main">' . ENTRY_NAME . '</td>';
    $str .= '          <td width="50%" class="main">' . tep_html_quotes($entry['name']) . tep_draw_hidden_field($prefix . 'name', $entry['name']) . '</td></tr>';
    $str .= '          <tr><td width="50%" class="main">' . ENTRY_COMPANY . '</td>';
    $str .= '          <td width="50%" class="main">' . tep_html_quotes($entry['company']) . tep_draw_hidden_field($prefix . 'company', $entry['company']) . '</td></tr>';
    $str .= '          <tr><td width="50%" class="main">' . ENTRY_STREET_ADDRESS . '</td>';
    $str .= '          <td width="50%" class="main">' . tep_html_quotes($entry['street_address']) . tep_draw_hidden_field($prefix . 'street_address', $entry['street_address']) . '</td></tr>';
    $str .= '          <tr><td width="50%" class="main">' . ENTRY_SUBURB . '</td>';
    $str .= '          <td width="50%" class="main">' . tep_html_quotes($entry['suburb']) . tep_draw_hidden_field($prefix . 'suburb', $entry['suburb']) . '</td></tr>';
    $str .= '          <tr><td width="50%" class="main">' . ENTRY_CITY . '</td>';
    $str .= '          <td width="50%" class="main">' . tep_html_quotes($entry['city']) . tep_draw_hidden_field($prefix . 'city', $entry['city']) . '</td></tr>';
    $str .= '          <tr><td width="50%" class="main">' . ENTRY_STATE . '</td>';
    $str .= '          <td width="50%" class="main">' . tep_html_quotes($entry['state']) . tep_draw_hidden_field($prefix . 'state', $entry['state']) . '</td></tr>';
    $str .= '          <tr><td width="50%" class="main">' . ENTRY_POST_CODE . '</td>';
    $str .= '          <td width="50%" class="main">' . tep_html_quotes($entry['postcode']) . tep_draw_hidden_field($prefix . 'postcode', $entry['postcode']) . '</td></tr>';
    $str .= '          <tr><td width="50%" class="main">' . ENTRY_COUNTRY . '</td>';
    if (is_array($entry['country'])){
      $str .= '          <td width="50%" class="main">' . tep_html_quotes($entry['country']['title']) . tep_draw_hidden_field($prefix . 'country', $entry['country']['title']) . '</td></tr>';
    } else {
      $str .= '          <td width="50%" class="main">' . tep_html_quotes($entry['country']) . tep_draw_hidden_field($prefix . 'country', $entry['country']) . '</td></tr>';
    }
    $str .= '          </table>';
  } else {
    $str = '';
    $str .= '        <table width="100%" border="0">';
    $str .= '          <tr><td width="50%" class="main">' . ENTRY_NAME . '</td>';
    $str .= '            <td width="50%" class="main">' . tep_draw_input_field($prefix . 'name', $entry['name'],  'size="25"') . '</td></tr>';
    $str .= '          <tr><td class="main">' . ENTRY_COMPANY . '</td>';
    $str .= '          <td class="main">' . tep_draw_input_field($prefix . 'company', $entry['company'],  'size="25"') . '</td></tr>';

    $str .= '          <tr><td class="main">' . ENTRY_STREET_ADDRESS . '</td>';
    $str .= '          <td class="main">' . tep_draw_input_field($prefix . 'street_address', $entry['street_address'],  'size="25"') . '</td></tr>';
    $str .= '          <tr><td class="main">' . ENTRY_SUBURB . '</td>';
    $str .= '          <td class="main">' . tep_draw_input_field($prefix . 'surburb', $entry['surburb'],  'size="25"') . '</td></tr>';
    $str .= '          <tr><td class="main">' . ENTRY_CITY . '</td>';
    $str .= '          <td class="main">' . tep_draw_input_field($prefix . 'city', $entry['city'],  'size="25"') . '</td></tr>';
    $str .= '          <tr><td class="main">' . ENTRY_STATE . '</td>';
    if (is_array($entry['country'])){
      $res = tep_db_query("select * from " . TABLE_COUNTRIES . " where countries_id = '" . $entry['country']['id'] . "'");
    } else {
      $res = tep_db_query("select * from " . TABLE_COUNTRIES . " where countries_name like '" . $entry['country'] . "'");
    }
    $d = tep_db_fetch_array($res);
    $res = tep_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id='" . $d['countries_id'] . "'");
    $check = tep_db_fetch_array($res);
    if ($check['total']>0){
      $zones_query = tep_db_query("select zone_id, zone_name from " . TABLE_ZONES . " where zone_country_id = '" . $d['countries_id'] . "' order by zone_name");
      $zones_array = array();
      while ($zones = tep_db_fetch_array($zones_query)) {
        $zones_array[] = array('id' => $zones['zone_name'],
                               'text' => $zones['zone_name']);
      }
      $str .= '          <td class="main">' . tep_draw_pull_down_menu($prefix . 'state', $zones_array, $entry['state'],  'style="width:165px"') . '</td></tr>';
    } else {
      $str .= '          <td class="main">' . tep_draw_input_field($prefix . 'state', $entry['state'],  'size="25"') . '</td></tr>';
    }
    $str .= '          <tr><td class="main">' . ENTRY_POST_CODE . '</td>';
    $str .= '          <td class="main">' . tep_draw_input_field($prefix . 'postcode', $entry['postcode'],  'size="25"') . '</td></tr>';
    $str .= '          <tr><td class="main">' . ENTRY_COUNTRY . '</td>';

    if ($d['countries_id']){
      $countries_query = tep_db_query("select countries_id, countries_name from " . TABLE_COUNTRIES . " order by countries_name");
      $countries_array = array();
      while ($countries = tep_db_fetch_array($countries_query)) {
        $countries_array[] = array('id' => $countries['countries_name'],
                                   'text' => $countries['countries_name']);
      }
      $str .= '          <td class="main">' . tep_draw_pull_down_menu($prefix . 'country', $countries_array, $d['countries_name'], 'style="width:165px"') . '</td></tr>';
    } else {
      $str .= '          <td class="main">' . tep_draw_input_field($prefix . 'country', $entry['country'],  'style="width:100px"') . '</td></tr>';
    }
    $str .= '          </table>';
  }
  return $str;
}
?>
