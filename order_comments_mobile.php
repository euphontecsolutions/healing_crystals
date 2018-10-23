<?php

/**
 * @author Shantnu
 * @copyright 2009
 */

require('includes/application_top_mobile.php');
if (!tep_session_is_registered('customer_id')) {
	$navigation->set_snapshot(array('mode' => 'SSL', 'page' =>  'order_comments_mobile.php?order_id='.$HTTP_GET_VARS['order_id']));
	tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
}
include(DIR_WS_CLASSES.'order.php');
if($HTTP_GET_VARS['action'] == 'submit'){
	$error=false;
	foreach($HTTP_POST_VARS as $key => &$value){
		$HTTP_SESSION_VARS[$key] = $value;
	}
	$order = new order($HTTP_GET_VARS['order_id']);
	//First we will loop for error checking coz we do not want to insert one comment and then show error
	for($i=0;$i<sizeof($order->products);$i++){
		if($HTTP_POST_VARS['enquiry'][$i]!=''){
			if($HTTP_POST_VARS['star1'][$i]<'1'){
				$error = true;
				$messageStack->add_session('contact','Please rate the product for which you have entered a comment');
				
				tep_redirect(tep_href_link('order_comments_mobile.php', 'order_id='.$HTTP_GET_VARS['order_id']));
			}
		}				
	}
	//Now we will loop to insert comments
	if($error==false){
		for($i=0;$i<sizeof($order->products);$i++){
			if($HTTP_POST_VARS['enquiry'][$i]!=''){
				$sql_data_array = array('orders_id' => $HTTP_GET_VARS['order_id'],
				                        'customers_id' => $customer_id,
										'customers_name' =>$order->customer['name'],
										'customers_email_address' =>$order->customer['email_address'],
										'comments'=>tep_db_prepare_input($HTTP_POST_VARS['enquiry'][$i]),
										'rating' => $HTTP_POST_VARS['star1'][$i],						
										'comments_status' => '0',
										'comment_date_added' => 'now()',
										'products_id'=>$order->products[$i]['id'],
										'product_purchased' => '1');
						   	$comments_query = tep_db_query("select * from products_comments where orders_id='" . (int)$HTTP_GET_VARS ['order_id'] . "' and customers_id='" . (int)$customer_id . "' and products_id = '" . $order->products [$i] ['id'] . "'");
            if (tep_db_num_rows($comments_query) >0) {
				tep_db_perform('products_comments', $sql_data_array, 'update', "orders_id='" . (int)$HTTP_GET_VARS ['order_id'] . "' and customers_id='" . (int)$customer_id . "' and products_id = '" . $order->products [$i] ['id'] . "'");
			} else {					
			tep_db_perform('products_comments', $sql_data_array);
			}
			}
		}	
		if(SEND_COMMENTS_EMAIL_TO!=''){
			
			$subject = 'Order Comment Submitted';
			$text = '<a href="http://www.healingcrystals.com/admin/products_comments.php">http://www.healingcrystals.com/admin/products_comments.php</a>'."\n".'This email has been sent to notify you that a product comment has been submitted for this item:'."\n\n";
			tep_mail('', SEND_COMMENTS_EMAIL_TO, $subject, $text, 'HealingCrystals.com', 'orders@healingcrystals.com',true);
		}
		tep_redirect(tep_href_link('order_comments_mobile.php','action=success&order_id='.$HTTP_GET_VARS['order_id']));
	}	
}
$breadcrumb->add('Order Comments', tep_href_link('order_comments_mobile.php'));
$content = 'order_comments_mobile';
require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);
require(DIR_WS_INCLUDES . 'application_bottom_mobile.php');
?>