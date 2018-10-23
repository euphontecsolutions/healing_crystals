<?php
/*  $Id: checkout_problems.php  
osCommerce, Open Source E-Commerce Solutions  
http://www.oscommerce.com  
Copyright (c) 2003 osCommerce  
Released under the GNU General Public License*/ 

require('includes/application_top_mobile.php'); 
require(DIR_WS_LANGUAGES . $language . '/checkout_problems.php');
if(isset($_GET['action']) && $_GET['action']=='submit'){	
	if($HTTP_POST_VARS['anti_spam'] != $_SESSION['security_code']){
		tep_redirect(tep_href_link('checkout_problems_mobile.php', 'error=security_code'));
	}else{
		//EMAIL THE SUBMITTED FORM TO ADMIN
		$message = 'A checkout problem form has been submitted on your website with following details:'."\n";
		$message .= 'Browser:'."\t".$HTTP_POST_VARS['browser']."\n";
		$message .= 'Error Page:'."\t".$HTTP_POST_VARS['referer']."\n";
		$message .= 'Error Message:'."\t".$HTTP_POST_VARS['error']."\n";
		$message .= 'Email:'."\t".$HTTP_POST_VARS['email']."\n";
		if(tep_session_is_registered('customer_id')){
			$message .= 'Customer Id:'."\t".$customer_id."\n";
		}
		$message .= 'Please review the checkout process!'."\n";
		//tep_mail('',SEND_CONTACT_EMAILS_TO, 'Checkout Problems Form Submitted', $message, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
		tep_redirect(tep_href_link('checkout_problems_mobile.php', 'message=sent'));		
	}
}


$content = 'checkout_problems_mobile';  
require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);  
require(DIR_WS_INCLUDES . 'application_bottom_mobile.php');

?>