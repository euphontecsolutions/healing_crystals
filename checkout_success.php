<?php

/*
  $Id: checkout_success.php,v 1.2 2003/09/24 15:34:26 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
 * * HISTORY OF CHANGES
 * 20 March 2012 (SA) Ticket #578: Modify out of stock report and create low inventory email from its results
*/

  require('includes/application_top.php');

  
/*  ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);*/


// if the customer is not logged on, redirect them to the shopping cart page
  if (!tep_session_is_registered('customer_id')) {
    tep_redirect(tep_href_link(FILENAME_DEFAULT));
  }

  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'update')) {
    $notify_string = 'action=notify&';
    $notify = $HTTP_POST_VARS['notify'];
    if (!is_array($notify)) $notify = array($notify);
    for ($i=0, $n=sizeof($notify); $i<$n; $i++) {
      $notify_string .= 'notify[]=' . $notify[$i] . '&';
    }
    if (strlen($notify_string) > 0) $notify_string = substr($notify_string, 0, -1);
	
	if( (isset($HTTP_POST_VARS['notify'])) && (count($HTTP_POST_VARS['notify']) > 0) ){
		tep_redirect(tep_href_link(FILENAME_DEFAULT, $notify_string));
	}else{
		tep_redirect(tep_href_link(FILENAME_DEFAULT));
	}
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CHECKOUT_SUCCESS);

  $breadcrumb->add(NAVBAR_TITLE_1);

  $paypalipn_query = tep_db_query("select o.orders_status,p.* from " . TABLE_ORDERS . " o, " . TABLE_PAYPALIPN_TXN . " p where p.item_number = o.orders_id AND o.customers_id = '" . (int)$customer_id . "' order by o.date_purchased desc limit 1");
  if (tep_db_num_rows($paypalipn_query) >0) {
  $paypalipn = tep_db_fetch_array($paypalipn_query);
  } else {
$paypalipn = array();
}

  if ($paypalipn['ipn_result']=='VERIFIED') {
    if ($paypalipn['payment_status']=='Completed') {
      $NAVBAR_TITLE_2 = PAYPAL_NAVBAR_TITLE_2_OK;
      $HEADING_TITLE = PAYPAL_HEADING_TITLE_OK; 
      $TEXT_SUCCESS = PAYPAL_TEXT_SUCCESS_OK; 
    } else if ($paypalipn['payment_status']=='Pending') { 
      $NAVBAR_TITLE_2 = PAYPAL_NAVBAR_TITLE_2_PENDING; 
      $HEADING_TITLE = PAYPAL_HEADING_TITLE_PENDING; 
      $TEXT_SUCCESS = PAYPAL_TEXT_SUCCESS_PENDING; 
    }; 
    $cart->reset(TRUE); 
  } else if ($paypalipn['ipn_result']=='INVALID') { 
    $NAVBAR_TITLE_2 = PAYPAL_NAVBAR_TITLE_2_FAILED; 
    $HEADING_TITLE = PAYPAL_HEADING_TITLE_FAILED; 
    $TEXT_SUCCESS = PAYPAL_TEXT_SUCCESS_FAILED; 
  } else if ($paypalipn['orders_status']==99999) { 
      $NAVBAR_TITLE_2 = PAYPAL_NAVBAR_TITLE_2_PENDING; 
      $HEADING_TITLE = PAYPAL_HEADING_TITLE_PENDING; 
      $TEXT_SUCCESS = PAYPAL_TEXT_SUCCESS_PENDING; 
  } else { 
    $NAVBAR_TITLE_2 = NAVBAR_TITLE_2; 
    $HEADING_TITLE = HEADING_TITLE; 
    $TEXT_SUCCESS = TEXT_SUCCESS; 
  };
  $breadcrumb->add($NAVBAR_TITLE_2);

  $global_query = tep_db_query("select global_product_notifications from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . (int)$customer_id . "'");
  $global = tep_db_fetch_array($global_query);

$authorize_status_query = tep_db_query("select o.orders_status, o.cc_number, o.payment_method, o.cc_cvn, o.cc_expires, o.authorize_trx_id, o.inventory_update from orders o where o.orders_id = '".(int)$HTTP_GET_VARS['order_id']."'");
    $orders_array = tep_db_fetch_array($authorize_status_query);  
    $orders_query = tep_db_query("select orders_id, ip_address from " . TABLE_ORDERS . " where customers_id = '" . (int)$customer_id . "' order by date_purchased desc limit 1");
    $orders = tep_db_fetch_array($orders_query);
    $orders_history_query = tep_db_query("select comments from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . (int)$HTTP_GET_VARS['order_id'] . "' order by date_added");
    if (tep_db_num_rows($orders_history_query)) {
        $ord_history = array();
      while ($orders_history = tep_db_fetch_array($orders_history_query)) {     
          $ord_history[] = $orders_history['comments'];   
      }      
    }
    $products_array = array();
    //$products_query = tep_db_query("select products_id, products_name from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$orders['orders_id'] . "' order by products_name");
    $products_query = tep_db_query("select products_id, uprid, products_quantity, products_name, products_model, final_price, options_values_price from " . TABLE_ORDERS_PRODUCTS . " op, orders_products_attributes opa where op.orders_products_id = opa.orders_products_id and op.orders_id = '" . (int)$orders['orders_id'] . "' order by products_name");
    $gv_price = 0;
    $gift_voucher =false;
    $inventory_added_back_flag = false;
    $removeFromWholesale = array();
    $paypal_eCheck_order = false;
    // echo "<pre>";
    // var_dump($orders_array);
    // var_dump($_SESSION);
    // die();
    /*sendMessage($user_id='',$subject='',$description='',$status='')*/
/*    require 'notification_mobile.php';
    if($orders_array['orders_status']=='2') {
        $user_id = $_SESSION['customer_id'];
        $subject = "Healing Crystals Order Successful";
        $description = "Your order placed Successfully";
        
        sendMessage($user_id,$subject,$description);

    }*/
    
    if($orders_array['orders_status'] == '100004'){        
        foreach($ord_history as $comment){
            if(stripos($comment,'paypal')!==false && stripos($comment,'echeck')!==false){
                $paypal_eCheck_order = true;
                tep_mail('','aarora@hitaishin.com', 'Paypal eCheck Order', 'Check Order id: '.$HTTP_GET_VARS['order_id'], '', 'orders@ffbh.org');
                break;
            }
        }
    }
    
    while ($products = tep_db_fetch_array($products_query)) {
    	if(!isset($removeFromWholesale[$products['products_id']]))$removeFromWholesale[$products['products_id']]=false;
    	 if ($global['global_product_notifications'] != '1') {
      $products_array[] = array('id' => $products['products_id'],
                                'text' => $products['products_name']);
    	 }
if($products['products_model'] == 'VGIFT'){
      		
            $gift_voucher = true;
            for($count=0; $count<$products['products_quantity']; $count++){
                $gv_price_array[$y] = ($products['options_values_price']);
                $y++;
            }
            
        }
        //if($customer_id=='15133')print_r($gv_price_array);
      $ovarray = explode('}', $products['uprid']);
      $ovid = $ovarray['1'];
      $optid_array  = explode('{',$ovarray['0']);
      $optid = $optid_array['1'];
      $attributes_id_query = tep_db_query("select products_attributes_name, products_attributes_id, products_attributes_units, products_attributes_retail_units, only_linked_options, low_unit_count,product_attribute_qty_1, product_attribute_qty_2, product_attribute_qty_3, product_attribute_qty_4, product_attribute_qty_5, option_inventory_status, products_attributes_model,lower(products_attributes_name) as attributes_name, action_request from products_attributes where products_id = '".$products['products_id']."' and options_id = '".$optid."' and options_values_id = '".$ovid."'");
      $attributes_array = tep_db_fetch_array($attributes_id_query);
   // print_r($orders_array);
      if(!tep_session_is_registered('retail_rep') && !tep_session_is_registered('is_retail_store')){
            if($attributes_array['products_attributes_units'] < '1' && $attributes_array['option_inventory_status'] == 'ActiveLimited'){
                //tep_db_query("update  " . TABLE_PRODUCTS_ATTRIBUTES . " set option_inventory_status = 'Discontinue', product_attributes_status = '0', is_amazon_ok = '0', special_start_date = '', special_end_date = '', products_attributes_special_price = '', product_attribute_spe_price_1 = '', product_attribute_spe_price_2 = '', product_attribute_spe_price_3 = '', product_attribute_spe_price_4 = '' , product_attribute_spe_price_5 = '' where products_attributes_id = '".$attributes_array['products_attributes_id']."'");
            }
        }
            if($orders_array['inventory_update']=='0'){
          tep_db_query("update orders set inventory_update = '1' where orders_id = '".$orders['orders_id']."'");
    		if($orders_array['orders_status'] == '2' || ($orders_array['orders_status'] == '100000')  || $paypal_eCheck_order==true){
				////code moved from checkout_process.php on 11 July' 2011 starts
				$prid = $products['products_id'];
				$ov_id = $ovid;
                                $discontinue_flag = true;
                                if($attributes_array['only_linked_options']=='1' && !tep_session_is_registered('retail_rep')){
                                    $discontinue_flag = false;
                                    $linked_products_options_query = tep_db_query("select products_attributes_units, option_inventory_status, products_attributes_name, linked_options_quantity, child_products_id, child_options_id, child_options_values_id from products_attributes pa, linked_products_options l where l.child_products_id = pa.products_id and l.child_options_id = pa.options_id and l.child_options_values_id = pa.options_values_id and parent_products_id = '" .$products['products_id'] . "' and parent_options_values_id = '" . $ovid . "' and parent_options_id = '" . $optid . "'");
                                    if(tep_db_num_rows($linked_products_options_query)){
                                        while($linked_products_options = tep_db_fetch_array($linked_products_options_query)){
                                            if($linked_products_options['products_attributes_units']<$linked_products_options['linked_options_quantity']){
                                                $discontinue_flag = true;
                                                if($linked_products_options['products_attributes_units']<=0 && ( $linked_products_options['option_inventory_status'] == 'Discontinue' || $linked_products_options['option_inventory_status'] == 'Sleep' || stripos($linked_products_options['products_attributes_name'],'clearance')!==false)){
                                                    tep_db_query("update  " . TABLE_PRODUCTS_ATTRIBUTES . " set product_attributes_status = '0', is_amazon_ok = '0', special_start_date = '', special_end_date = '', products_attributes_special_price = '', product_attribute_spe_price_1 = '', product_attribute_spe_price_2 = '', product_attribute_spe_price_3 = '', product_attribute_spe_price_4 = '' , product_attribute_spe_price_5 = '' where products_id = '" . (int) $linked_products_options['child_products_id'] . "' and options_values_id  = '" . $linked_products_options['child_options_values_id'] . "'");
						}                                               
                                            }                                          
                                        }
                                    }
                                }
                if ($attributes_array['products_attributes_units'] == 0 && $discontinue_flag == true && !tep_session_is_registered('retail_rep')){
					if ($attributes_array['option_inventory_status'] == 'Discontinue' || $attributes_array['option_inventory_status'] == 'Sleep' || strpos($attributes_array['attributes_name'], 'clearance') !== false) {
						tep_db_query("update  " . TABLE_PRODUCTS_ATTRIBUTES . " set product_attributes_status = '0', is_amazon_ok = '0', special_start_date = '', special_end_date = '', products_attributes_special_price = '', product_attribute_spe_price_1 = '', product_attribute_spe_price_2 = '', product_attribute_spe_price_3 = '', product_attribute_spe_price_4 = '' , product_attribute_spe_price_5 = '' where products_id = '" . (int) $prid . "' and options_values_id  = '" . $ov_id . "'");
						$active_attributes_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int) $prid . "' and product_attributes_status = '1'");
						$active_attributes_check = tep_db_fetch_array($active_attributes_check_query);
						if($attributes_array['option_inventory_status'] == 'Order' )tep_db_query("update  " . TABLE_PRODUCTS_ATTRIBUTES . " set option_inventory_status = 'Sleep' where products_id = '" . (int) $prid . "' and options_values_id  = '" . $ov_id . "'");
						
						if ($active_attributes_check['total'] < 1) {							
						  if(strpos($attributes_array['attributes_name'], 'clearance') !== false || $attributes_array['option_inventory_status'] == 'Sleep' || $attributes_array['option_inventory_status'] == 'Discontinue'){
							tep_db_query("update products set  products_status = '0', is_amazon_ok ='0' where products_id = '" . (int) $prid . "'");
						  }
                                                  if($attributes_array['option_inventory_status'] == 'Discontinue'){
							
							$status_attributes_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int) $prid . "' and option_inventory_status != 'Discontinue'");
							$status_attributes_check = tep_db_fetch_array($status_attributes_check_query);
							if ($status_attributes_check['total'] < 1) { 
								//tep_db_query("update  " . TABLE_PRODUCTS . " set products_status = '0' where products_id = '" . (int) $prid . "'");
								tep_db_query("update products_attributes set special_start_date = '', special_end_date = '', special_start_date = '', special_end_date = '', products_attributes_special_price = '', product_attribute_spe_price_1 = '', product_attribute_spe_price_2 = '', product_attribute_spe_price_3 = '', product_attribute_spe_price_4 = '' , product_attribute_spe_price_5 = '' WHERE products_id = '".(int) $prid."'");
								$new_products_model = 'D' . $attributes_array['products_attributes_model'];
								tep_db_query("update products set  products_status = '0', is_amazon_ok 	='0', products_model = '" . $new_products_model . "' where products_id = '" . (int) $prid . "'");
								tep_db_query("update " . TABLE_PRODUCTS_ATTRIBUTES . " set products_attributes_model = '" . $new_products_model . "' where products_id = '" . (int) $prid . "'");
								tep_db_query("update invoices_to_product_options set products_model = '" . $new_products_model . "' where products_id = '" . (int) $prid . "'");
								tep_db_query("update purchase_invoices_linked_products set model = '" . $new_products_model . "' where products_id = '" . (int) $prid . "'");
							}
						  }
						}
					}					
				}
                                
                                
				//unit sell in last 1 year
                                $totalqty = '';
                                $uprid = $products['uprid'];
                                $productsell_in_1_year_query = tep_db_query("select sum(op.products_quantity) as total_qty from orders o, orders_products op where op.orders_id = o.orders_id and op.uprid = '".$uprid."' and (o.orders_status = '3' or o.orders_status = '5') and o.date_purchased between DATE_SUB(NOW(), INTERVAL 1 year) and NOW()");
                                if(tep_db_num_rows($productsell_in_1_year_query)){
                                    $productsell_in_1_year_array = tep_db_fetch_array($productsell_in_1_year_query);
                                    $p_qty = $products['products_quantity'];
                                    $totalqty = $p_qty + $productsell_in_1_year_array['total_qty'];
                                    tep_db_query("update products_attributes set units_sold_last_year = '".$totalqty."' where products_attributes_id = '".$attributes_array['products_attributes_id']."'");
                                }
                                //unit sell in last 1 year
                                
                                
				//20 March 2012 (SA) Ticket #578: Modify out of stock report and create low inventory email from its results BOF
                                
                                $combine_low_unit_query = tep_db_query("select combined_low_unit from products where products_id = '".$prid."'");
                                $combine_low_unit = tep_db_fetch_array($combine_low_unit_query);
                                if(tep_session_is_registered('retail_rep')){
                                    if ( ($attributes_array['products_attributes_retail_units'] < $attributes_array['low_unit_count'] || $attributes_array['products_attributes_retail_units'] < $combine_low_unitar['combined_low_unit']) && $attributes_array['only_linked_options']=='0'  &&  !in_array($attributes_array['action_request'],array('create order','check in','purchase invoice','worksheet pending'))){
                                        if ($attributes_array['products_attributes_units'] < $attributes_array['low_unit_count'] || $attributes_array['products_attributes_units'] < $combine_low_unit['combined_low_unit']){
					$zmodelquery = tep_db_query("select linked_products_id from products p where products_id = '".$prid."'");
					$zmodel = tep_db_fetch_array($zmodelquery);
                                       $set_to_count= true;
                                        if($zmodel['linked_products_id']!=''){
                                                $linked_backstock_products = explode(',',$zmodel['linked_products_id']);
                                                foreach($linked_backstock_products as $linked_prids){
                                                    $backstock_units_query = tep_db_query("select products_attributes_units from products_attributes where products_id = '".$linked_prids."' and products_attributes_units > 0");
                                                    if(tep_db_num_rows($backstock_units_query)){
						tep_db_query("update  ".TABLE_PRODUCTS_ATTRIBUTES . " set action_request = 'sort' where products_id = '" . (int) $prid . "' and options_values_id  = '" . $ov_id . "'");
                                                        $set_to_count= false;
                                                        break;
					}else{
                                                        $set_to_count= true;
					}
				}			
					}
                                            if($set_to_count== true && !in_array($attributes_array['option_inventory_status'],array('Sleep','Discontinue','ActiveLimited','Linked')))tep_db_query("update  ".TABLE_PRODUCTS_ATTRIBUTES . " set action_request = 'reorder' where products_id = '" . (int) $prid . "' and options_values_id  = '" . $ov_id . "'");
                                        }else{
                                            tep_db_query("update  ".TABLE_PRODUCTS_ATTRIBUTES . " set action_request = 'sort' where products_id = '" . (int) $prid . "' and options_values_id  = '" . $ov_id . "'");
                                        }
                                    }
                                  }elseif ((int)$attributes_array['products_attributes_units'] < (int)$attributes_array['low_unit_count']  && $attributes_array['only_linked_options'] == '0' && !in_array($attributes_array['action_request'],array('create order','check in','purchase invoice','worksheet pending','sort'))){
					$zmodelquery = tep_db_query("select linked_products_id from products p where products_id = '".$prid."'");
					$zmodel = tep_db_fetch_array($zmodelquery);
                                        $set_to_count = true;
                                        if($zmodel['linked_products_id']!=''){
                                            $linked_backstock_products = explode(',',$zmodel['linked_products_id']);
                                            foreach($linked_backstock_products as $linked_prids){
                                                $backstock_units_query = tep_db_query("select products_attributes_units from products_attributes where products_id = '".$linked_prids."' and products_attributes_units > 0");
                                                if(tep_db_num_rows($backstock_units_query)){
                                                    tep_db_query("update  ".TABLE_PRODUCTS_ATTRIBUTES . " set action_request = 'Sort Z Backstock' where products_id = '" . (int) $prid . "' and options_values_id  = '" . $ov_id . "'");
                                                    $set_to_count = false;
                                                    break;
                                                }else{
                                                    $set_to_count = true;
                                                }
                                            }			
					}
                                        if($set_to_count == true){
                                            $reciprocal_linked_products_query = tep_db_query("select products_id, linked_products_id from products where linked_products_id like '%".(int) $prid."%'");
                                            $linked_prodcucts_id_array = array();
                                            while($reciprocal_linked_products_array = tep_db_fetch_array($reciprocal_linked_products_query)){
                                                $res_link_id = array();
                                                $res_link_id = explode(',',$reciprocal_linked_products_array['linked_products_id']);
                                                if(is_array($res_link_id) && !empty($res_link_id) && in_array((int) $prid, $res_link_id) && !in_array($reciprocal_linked_products_array['products_id'], $linked_prodcucts_id_array)){
                                                    $linked_prodcucts_id_array[]=$reciprocal_linked_products_array['products_id'];
                                                    $lpidCount++;
                                                }
                                            }
                                            if(is_array($linked_prodcucts_id_array) && !empty ($linked_prodcucts_id_array)){
                                                foreach($linked_prodcucts_id_array as $linked_prids){
                                                    $backstock_units_query = tep_db_query("select products_attributes_units from products_attributes where products_id = '".$linked_prids."' and products_attributes_units > 0");
                                                    if(tep_db_num_rows($backstock_units_query)){
                                                        tep_db_query("update  ".TABLE_PRODUCTS_ATTRIBUTES . " set action_request = 'Sort Z Backstock' where products_id = '" . (int) $prid . "' and options_values_id  = '" . $ov_id . "'");
                                                        $set_to_count= false;
                                                        break;
                                                    }else{
                                                        $set_to_count= true;
                                                    }
                                                }
                                            }
                                        }
                                        
                                        //modification for new backstock functionality bof
                                        if($set_to_count == true){
                                            $new_linked_products_query = tep_db_query("SELECT * FROM `linked_backstock_items` WHERE `products_id` = '".(int)$prid."' and ( `products_attributes_id` = '".$attributes_array['products_attributes_id']."' or `products_attributes_id` = '0')");
                                            $linked_prodcucts_id_array = array();
                                            $res_link_pid = array();
                                            $res_link_paid = array();
                                            while($new_linked_products_array = tep_db_fetch_array($new_linked_products_query)){
                                                
                                                if(!in_array($new_linked_products_array['linked_products_id'],$res_link_pid)){
                                                    $res_link_pid[] = $new_linked_products_array['linked_products_id'];
                                                }
                                                if(!is_array($res_link_paid[$new_linked_products_array['linked_products_id']])){
                                                    $res_link_paid[$new_linked_products_array['linked_products_id']] = array();                                                    
                                                }
                                                //if(!is_array($new_linked_products_array['linked_products_id'])){$new_linked_products_array['linked_products_id'] = array();}
                                                
                                                if(!in_array($new_linked_products_array['linked_products_attributes_id'],$res_link_paid[$new_linked_products_array['linked_products_id']])){
                                                    $res_link_paid[$new_linked_products_array['linked_products_id']][] = $new_linked_products_array['linked_products_attributes_id'];
                                                }
                                                
                                            }
                                            $flag_backstock = '0';
                                            if(is_array($res_link_pid) && !empty ($res_link_pid)){
                                                foreach($res_link_pid as $val){
                                                    if($flag_backstock == '1'){
                                                        break;
                                                    }
                                                    if(is_array($res_link_paid[$val]) && $set_to_count == true){
                                                        if(!empty ($res_link_paid[$val])){
                                                            foreach($res_link_paid[$val] as $value1){
                                                                if($flag_backstock == '1'){
                                                                    break;
                                                                }
                                                                if($value1 == '0'){
                                                                    $backstock_units_query = tep_db_query("select products_attributes_units from products_attributes where products_id = '".$val."' and products_attributes_units > 0");
                                                                }else{
                                                                    $backstock_units_query = tep_db_query("select products_attributes_units from products_attributes where products_id = '".$val."' and products_attributes_id = '".$value1."' and products_attributes_units > 0");
                                                                }
                                                                if(tep_db_num_rows($backstock_units_query)){
                                                                    tep_db_query("update  ".TABLE_PRODUCTS_ATTRIBUTES . " set action_request = 'Sort Z Backstock' where products_id = '" . (int) $prid . "' and options_values_id  = '" . $ov_id . "'");
                                                                    $set_to_count = false;
                                                                    $flag_backstock = '1';
                                                                    break;
                                                                }else{
                                                                    $set_to_count= true;
                                                                }
                                                            }   
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        //modification for new backstock functionality eof
                                        
                                        
					if($set_to_count== true && !in_array($attributes_array['option_inventory_status'],array('Sleep','Discontinue','ActiveLimited','Linked')))tep_db_query("update  ".TABLE_PRODUCTS_ATTRIBUTES . " set action_request = 'reorder' where products_id = '" . (int) $prid . "' and options_values_id  = '" . $ov_id . "'");
				
                                //program script to not change linked units to Reorder Action Request	
				}elseif($attributes_array['only_linked_options']=='1'){
                                   $linked_products_optionsforar_query = tep_db_query("select products_attributes_units, action_request, option_inventory_status, low_unit_count, linked_options_quantity, child_products_id, child_options_id, child_options_values_id from products_attributes pa, linked_products_options l where l.child_products_id = pa.products_id and l.child_options_id = pa.options_id and l.child_options_values_id = pa.options_values_id and parent_products_id = '" .$products['products_id'] . "' and parent_options_values_id = '" . $ovid . "' and parent_options_id = '" . $optid . "'");
                                    if(tep_db_num_rows($linked_products_optionsforar_query)){
                                        while($linked_products_optionsforar = tep_db_fetch_array($linked_products_optionsforar_query)){
                                            $combine_low_unitar_query = tep_db_query("select combined_low_unit from products where products_id = '".$linked_products_optionsforar['child_products_id']."'");
                                            $combine_low_unitar = tep_db_fetch_array($combine_low_unitar_query);
                                
                                            if (( (int)($linked_products_optionsforar['products_attributes_units']/$linked_products_optionsforar['linked_options_quantity']) < $linked_products_optionsforar['low_unit_count'] || (int)($linked_products_optionsforar['products_attributes_units']/$linked_products_optionsforar['linked_options_quantity']) < $combine_low_unitar['combined_low_unit']) &&  !in_array($linked_products_optionsforar['action_request'],array('create order','check in','purchase invoice','worksheet pending'))){
                                                if(!in_array($linked_products_optionsforar['option_inventory_status'],array('Sleep','Discontinue','ActiveLimited')))tep_db_query("update  ".TABLE_PRODUCTS_ATTRIBUTES . " set action_request = 'reorder' where products_id = '" . $linked_products_optionsforar['child_products_id'] . "' and options_values_id  = '" . $linked_products_optionsforar['child_options_values_id'] . "'");
                                            }
                                        }
                                    }
                                    $uprid = $products['products_id'].'{'.$optid.'}'.$ovid;
                                    $products_units = tep_get_products_stock($uprid);
                                    if ($products_units < $attributes_array['low_unit_count']  && !in_array($attributes_array['action_request'],array('create order','check in','purchase invoice','worksheet pending')) && !in_array($attributes_array['option_inventory_status'],array('Sleep','Discontinue','ActiveLimited'))){
                                        tep_db_query("update  ".TABLE_PRODUCTS_ATTRIBUTES . " set action_request = 'reorder' where products_id = '" . (int) $products['products_id'] . "' and options_values_id  = '" . $ovid . "'");
                                    }
                                } 
                                
                                //20 March 2012 (SA) Ticket #578: Modify out of stock report and create low inventory email from its results EOF
				////code moved from checkout_process.php on 11 July' 2011 ends 
                      //check Low unit
                        //if($attributes_array['products_attributes_units']<=$attributes_array['low_unit_count'])tep_db_query ("UPDATE products_attributes SET option_inventory_status = 'Low/Out Of Stock' WHERE products_attributes_id = '".$attributes_array['products_attributes_id']."'");
                        if($attributes_array['products_attributes_units']<1 && $attributes_array['only_linked_options']=='0')tep_db_query("update products_attributes set special_start_date = '', special_end_date = '', products_attributes_special_price = '' WHERE products_attributes_id = '".$attributes_array['products_attributes_id']."'");
                        //Code added for wholesale tags 7July2011 Shantnu BOF
            if ($attributes_array['products_attributes_units'] < 10 && $attributes_array['only_linked_options']=='0' && ($attributes_array['product_attribute_qty_1']>8 || $attributes_array['product_attribute_qty_2']>8 || $attributes_array['product_attribute_qty_3']>8 || $attributes_array['product_attribute_qty_4']>8 || $attributes_array['product_attribute_qty_5']>8))$removeFromWholesale[$products['products_id']]=true;
            //Code added for wholesale tags 7July2011 Shantnu EOF
			//blacklisted code starts			
			if (tep_session_is_registered('order_from_blacklisted')) {
				tep_db_query("update orders set orders_status = '100004' where orders_id = '".(int)$orders['orders_id']."'");
			  	$sql_data_array = array('orders_id' => $orders['orders_id'],
	
									  'orders_status_id' => '100004',
			
									  'date_added' => EST_TIME_NOW,
			
									  'customer_notified' => '0',
			
									  'comments' => 'Customer is Blacklisted, Order moved back to pending status, Contact a Manager');
	
				tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
				tep_session_unregister('order_from_blacklisted');
			}			
			//blacklisted code ends
                        }else{
							//Order is not marked as Payment Recieved, Adjust inventory back to original Value
							//tep_db_query("update products_attributes set products_attributes_units = '".$attributes_array['products_attributes_units']+$products['products_quantity']."' where products_id = '".$products['products_id']."' and products_attributes_id = '".$attributes_array['products_attributes_id']."'");
							$inventory_added_back_flag = true;
				 			if($attributes_array['only_linked_options']=='0'){
				 			$inv_update = array('products_attributes_units' => ($attributes_array['products_attributes_units']+$products['products_quantity']));
	 						tep_db_perform('products_attributes', $inv_update, 'update', "products_id = '".$products['products_id']."' and products_attributes_id = '".$attributes_array['products_attributes_id']."'");
                                                        //echo 'Update Log';
                                                            tep_db_query("INSERT INTO `inventory_log` (`log_id`, `products_id`, `products_attributes_id`, orders_id, `units_count`, `units_changed`, `change_date`, `adjustment_type`, products_attributes_name) VALUES ('', '".$products['products_id']."', '" . $attributes_array['products_attributes_id'] . "', '".$orders['orders_id']."', '" . ($attributes_array['products_attributes_units']) . "', '".$products['products_quantity']."', now(), 'Order','".  addslashes($attributes_array['products_attributes_name'])."')");
                                                            //products_id = '".$products['products_id']."' and options_id = '".$optid."' and options_values_id = '".$ovid."'
                                                        }elseif($attributes_array['only_linked_options']=='1'){
                                                           tep_db_query("INSERT INTO `inventory_log` (`log_id`, `products_id`, `products_attributes_id`, orders_id, `units_count`, `units_changed`, `change_date`, `adjustment_type`, products_attributes_name) VALUES ('', '".$products['products_id']."', '" . $attributes_array['products_attributes_id'] . "', '".$orders['orders_id']."', '', '".$products['products_quantity']."', now(), 'Order','".  addslashes($attributes_array['products_attributes_name'])."')");
                                                        }
                                                        $linked_products_options_query = tep_db_query("select products_attributes_name, products_attributes_id, products_id, options_id, options_values_id, products_attributes_units from products_attributes pa, linked_products_options l where l.child_products_id = pa.products_id and l.child_options_id = pa.options_id and l.child_options_values_id = pa.options_values_id and parent_products_id = '" .$products['products_id'] . "' and parent_options_values_id = '" . $ovid . "' and parent_options_id = '" . $optid . "'");
                                                        if(tep_db_num_rows($linked_products_options_query)){
                                                            while($linked_products_options = tep_db_fetch_array($linked_products_options_query)){
                                                                $inv_update = array('products_attributes_units' => ($linked_products_options['products_attributes_units']+$products['products_quantity']));
                                                                tep_db_perform('products_attributes', $inv_update, 'update', "products_attributes_id = '".$linked_products_options['products_attributes_id']."'");
                                                                //echo 'Update Log';
                                                                tep_db_query("INSERT INTO `inventory_log` (`log_id`, `products_id`, `products_attributes_id`, orders_id, `units_count`, `units_changed`, `change_date`, `adjustment_type`, products_attributes_name) VALUES ('', '".$linked_products_options['products_id']."', '" . $linked_products_options['products_attributes_id'] . "', '".$orders['orders_id']."', '" . ($linked_products_options['products_attributes_units']) . "', '".$products['products_quantity']."', now(), 'Order', '" . addslashes($linked_products_options['products_attributes_name']) . "')");
                                                            }
                                                        }
			           }
                                   //BOF:mod 20111031
        $product_id_        = $products['products_id'];
        $option_id_         = $optid;
        $option_value_id_   = $ovid;
        include('amazon_inventory_feed_single_item.php');
        //EOF:mod 20111031
            }
   
  		}
  		foreach($removeFromWholesale as $products_id => $key){
    		if($key==true)tep_db_query("delete from products_specific_property where products_id = '".$products_id."' and lower(property_name) = 'wholesale'");
		}
  		if($inventory_added_back_flag==true){
  			 $comment_data_array = array('orders_id' => $orders['orders_id'],

                          'orders_status_id' => $orders_array['orders_status'],

                          'date_added' => EST_TIME_NOW,

                          'customer_notified' => '0',

                          'comments' => 'Inventory added back in stock.');

  			tep_db_perform(TABLE_ORDERS_STATUS_HISTORY, $comment_data_array);
  		}

   if($orders_array['orders_status']=='2'){
       $checkTransactionId = false;
       foreach($ord_history as $history){
           if(preg_match("/Transaction ID/i", $history)){
               $checkTransactionId=true;
               break;
           }
       }
       if($orders_array['authorize_trx_id'] == '' && $checkTransactionId==false){        
        $subject = 'HealingCrystals.com - Order Alert';
        $msg_body = 'Order# ' . $HTTP_GET_VARS['order_id'].' was accepted as Payment Received into the system, however the system cannot find a transation id#.'."\n".'Please check this order manually.';
        $pos = strpos($orders_array['payment_method'], 'Gift Voucher');
        if($pos === false)tep_mail('', SEND_EXTRA_ORDER_EMAILS_TO, $subject, $msg_body, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, true);
  tep_mail('', 'aarora@hitaishin.com', $subject, $msg_body, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, true);
        
       }    
	if($gift_voucher==true){
    	$gv_message = '';    	
    	//foreach($gv_price_array as $gv_price){
    	$query = tep_db_query("select coupon_code from " . TABLE_COUPONS . "  where created_from_orderid = '".$HTTP_GET_VARS['order_id']."'");
    	if(tep_db_num_rows($query) == sizeof($gv_price_array)){
    		$x=0;
    		while($array = tep_db_fetch_array($query)){
    			$id1[$x] = $array['coupon_code'];
    			$x++;
    		}	
		}else{
			foreach($gv_price_array as $key => &$gv_price){
				$idx = create_coupon_code(); 
       			$expire_date = date("Y-m-d H:i:s",mktime(0, 0, 0, date("m")  , date("d"), date("Y")+2));
       			$insert_query = tep_db_query("insert into " . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created, created_from_orderid, coupon_expire_date) values ('" . $idx . "', 'G', '" . $gv_price . "', now(), '".$HTTP_GET_VARS['order_id']."', '".$expire_date."')");
      			$insert_id = tep_db_insert_id($insert_query);
      			$insert_query = tep_db_query("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $insert_id ."', '0', 'Admin', '', now() )"); 	
      			$id1[$key] = $idx;
			}       
       }
       $j=1;
       foreach($id1 as $idc){
       		$gv_message .= '<table><tr><td>Your Gift Voucher '.$j.': <b>'.$idc.'</b><br>Please make a note of your Gift Voucher, and use it in your next purchase or <a href="'.tep_href_link('gv_redeem.php', 'gv_no='.$idc).'">redeem it now</a> or <a href="'.tep_href_link('gv_send.php', 'new_gv='.$idc).'">mail it to a friend</a>!<br></td></tr></table>';
       		$j++;
       }
    }
   }
   /*if($orders_array['cc_number'] != ''){
   	$cc_number = $orders_array['cc_number'];
   	$cc_cvn = $orders_array['cc_cvn'];
   	$cc_expires = $orders_array['cc_expires'];
   	$encrypted_cc_number = gpg_encrypt("${cc_number}", '/usr/bin/gpg' , '/home/healingc/.gnupg', '51213E37');;
   	$encrypted_cc_cvn = gpg_encrypt("${cc_cvn}", '/usr/bin/gpg' , '/home/healingc/.gnupg', '51213E37');;
   	$encrypted_cc_expires =gpg_encrypt("${cc_expires}", '/usr/bin/gpg' , '/home/healingc/.gnupg', '51213E37');;
	$update_query = tep_db_query("update orders set encrypted_cc_number = '".$encrypted_cc_number[0]."', encrypted_cc_expires = '".$encrypted_cc_expires[0]."', encrypted_cc_cvn = '".$encrypted_cc_cvn[0]."' where orders_id = '".$HTTP_GET_VARS['order_id']."' ");
		//Remove CC info for this order from orders Table
	$clear_cc_query = tep_db_query("update orders set cc_number = '', cc_expires = '', cc_cvn = '' where orders_id = '".$HTTP_GET_VARS['order_id']."' ");	
}*/
  $content = CONTENT_CHECKOUT_SUCCESS;
	// PWA:  Added a check for a Guest checkout and cleared the session - 030411 v0.71
	if (tep_session_is_registered('noaccount')) {
	 $order_update = array('purchased_without_account' => '1');
	 tep_db_perform(TABLE_ORDERS, $order_update, 'update', "orders_id = '".$orders['orders_id']."'");
	//  tep_db_query("insert into " . TABLE_ORDERS . " (purchased_without_account) values ('1') where orders_id = '" . (int)$orders['orders_id'] . "'");
	 tep_db_query("delete from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . tep_db_input($customer_id) . "'");
	 tep_db_query("delete from " . TABLE_CUSTOMERS . " where customers_id = '" . tep_db_input($customer_id) . "'");
	 tep_db_query("delete from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . tep_db_input($customer_id) . "'");
	 tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . tep_db_input($customer_id) . "'");
	 tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . tep_db_input($customer_id) . "'");
	 tep_db_query("delete from " . TABLE_WHOS_ONLINE . " where customer_id = '" . tep_db_input($customer_id) . "'");
	 tep_session_destroy();
//	 $content = CONTENT_CHECKOUT_SUCCESS_EMPTY;
	}
	

  if (tep_paypal_wpp_enabled()) {
    if ($paypal_ec_temp) {
        tep_session_unregister('customer_id');
        tep_session_unregister('customer_default_address_id');
        tep_session_unregister('customer_first_name');
        tep_session_unregister('customer_country_id');
        tep_session_unregister('customer_zone_id');
        tep_session_unregister('comments');
        //$cart->reset();
        tep_db_query("delete from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "'");
        tep_db_query("delete from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
        tep_db_query("delete from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . (int)$customer_id . "'");
        tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$customer_id . "'");
        tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . (int)$customer_id . "'");
        tep_db_query("delete from " . TABLE_WHOS_ONLINE . " where customer_id = '" . (int)$customer_id . "'");
    }

    tep_session_unregister('paypal_ec_temp');
    tep_session_unregister('paypal_ec_token');
    tep_session_unregister('paypal_ec_payer_id');
    tep_session_unregister('paypal_ec_payer_info');
  }
 //---PayPal WPP Modification END ---//
tep_session_unregister('gv_code');
tep_session_unregister('gv_coupon_amount');
tep_session_unregister('tax_key');
tep_session_unregister('tax_value');
tep_session_unregister('checkout_payment');
tep_session_unregister('checkout_shipping');
tep_session_unregister('checkout_comments');
tep_session_unregister('checkout_subscribe_nl');
tep_session_unregister('checkout_gv_redeem_code');
tep_session_unregister('paypalwpp_cc_firstname');
tep_session_unregister('paypalwpp_cc_lastname');
tep_session_unregister('paypalwpp_cc_number');
tep_session_unregister('paypalwpp_cc_checkcode');
tep_session_unregister('checkout_authorizenet_cc_firstname');
tep_session_unregister('checkout_authorizenet_cc_lastname');
tep_session_unregister('checkout_authorizenet_cc_type');
tep_session_unregister('checkout_authorizenet_cc_number');
tep_session_unregister('checkout_authorizenet_cc_expires_month');
tep_session_unregister('checkout_authorizenet_cc_expires_year');
tep_session_unregister('checkout_authorizenet_cc_cvv2');
tep_session_unregister('selected_shipping');
tep_session_unregister('shipping');
  $javascript = 'popup_window_1.js';
  
  $lookup = CheckIpLocation($orders['ip_address']);	
if (isset($lookup['error']) && $lookup['error'] != '') {
	$ip_location = $lookup['error'];
} else {
$ip_location = $lookup['city'] . ', ' . $lookup['region_name'] . ', ' . $lookup['country_name'] . ' ' . ($lookup['postcode'] != '' ? $lookup['postcode'] :''); 
}
/*===========================================================*/
    if($_SESSION['is_mobile']==1){
      require 'push.php';

      if($orders_array['orders_status']!='') {

      $sql = "SELECT * FROM `orders_status` WHERE `orders_status_id` = '".$orders_array['orders_status']."'";
      $result      = tep_db_query($sql);
      $data        = tep_db_fetch_array($result);

      $user_id     = $_SESSION['customer_id'];
 /*     echo "<pre>";
      print_r($data);
      die();*/
      $subject     =/* $data['orders_status_name']*/"Payment Received- Order(".$orders['orders_id'].")";
      $description = /*$data['orders_status_default_comment']*/"Thank you again for your order(".$orders['orders_id'].") and for your recent payment. This email is to confirm that we have now received payment for your order and your order is in queue for packing.

We will send you another email confirmation when your order is shipped. 

Have a great day!

Love and Harmony,

Shawn Adler
www.HealingCrystals.com";
$description2 = tep_convert_linefeeds(array("\r\n", "\n", "\r"), '<br>', $description);;

      sendMessage($user_id,$subject,$description,$description2);

      }
     
 tep_redirect(tep_href_link('checkout_success_mobile.php?order_id='.$orders['orders_id']));
  }
/*===========================================================*/

  require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
<!-- Google Tag Manager -->
<script>/*(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-MG6VQZX');*/</script>
<!-- End Google Tag Manager -->

