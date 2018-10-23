<?php

/*

  $Id: password_forgotten.php,v 1.2 2003/09/24 14:33:16 wilt Exp $



  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com



  Copyright (c) 2003 osCommerce



  Released under the GNU General Public License

*/
 
 $app_id    = $_GET['app_id'];


  require('includes/application_top_mobile.php');


if($app_id !=''){
     $_SESSION['app_id']=$app_id;
  $mobile_metaQuery = tep_db_query("select app_id from customer_meta_mobile where app_id = '".$app_id."' AND category=2");
  $app_meta_dataArray = tep_db_fetch_array($mobile_metaQuery);
  $date = date("Y-m-d H:i:s");
  if($app_meta_dataArray==''){
  tep_db_query("insert into customer_meta_mobile (app_id, created_date,category) values ('" .$app_id. "', '".$date."',2)");
  }else{
      
      tep_db_query("update customer_meta_mobile set flag = '0' where app_id = '" .$app_id . "'");
  }
 }
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PASSWORD_FORGOTTEN);



  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'process')) {

    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);


    if(isset($_GET['frm']) && $_GET['frm'] == 'af'){
        $check_customer_query = tep_db_query("select affiliate_id, affiliate_firstname, affiliate_lastname, affiliate_password from affiliate_affiliate where affiliate_email_address = '" . tep_db_input($email_address) . "'");
    }else{
        $check_customer_query = tep_db_query("select customers_firstname, customers_lastname, customers_password, customers_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
    }
    if (tep_db_num_rows($check_customer_query)) {

      $check_customer = tep_db_fetch_array($check_customer_query);

function randomize() {
$stone_names_query = tep_db_query("select stone_name from stone_names order by rand() limit 0,1");
$stone_names = tep_db_fetch_array($stone_names_query);

    $a = strtolower($stone_names['stone_name']);
    $a = str_replace(' ','',$a);
    $a = $a.rand(100,999);
  return $a;

       }
        $new_password = randomize();
        //echo $new_password;exit;
     // $new_password = tep_create_random_value_lwrcase(ENTRY_PASSWORD_MIN_LENGTH, 'chars');
      $crypted_password = tep_encrypt_password($new_password);

      if(isset($_GET['frm']) && $_GET['frm'] == 'af'){
          tep_db_query("update affiliate_affiliate set affiliate_password = '" . tep_db_input($crypted_password) . "' where affiliate_id = '" . (int)$check_customer['affiliate_id'] . "'");
          tep_mail($check_customer['affiliate_firstname'] . ' ' . $check_customer['affiliate_lastname'], $email_address, EMAIL_PASSWORD_REMINDER_SUBJECT, sprintf(EMAIL_PASSWORD_REMINDER_BODY, $new_password), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
           tep_db_query("update customer_meta_mobile set flag = '1', customer_id = '".(int)$customer_id."' where app_id = '" .$_SESSION['app_id'] . "' AND category=2");
          $messageStack->add_session('login', SUCCESS_PASSWORD_SENT, 'success');
          tep_redirect(tep_href_link('affiliate_affiliate.php', '', 'SSL'));
      }else{
          tep_db_query("update " . TABLE_CUSTOMERS . " set customers_password = '" . tep_db_input($crypted_password) . "' where customers_id = '" . (int)$check_customer['customers_id'] . "'");
          tep_mail($check_customer['customers_firstname'] . ' ' . $check_customer['customers_lastname'], $email_address, EMAIL_PASSWORD_REMINDER_SUBJECT, sprintf(EMAIL_PASSWORD_REMINDER_BODY, $new_password), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
       tep_db_query("update customer_meta_mobile set flag = '1', customer_id = '".(int)$customer_id."' where app_id = '" .$_SESSION['app_id'] . "' AND category=2");
          $messageStack->add('password_forgotten_success', 'TEXT_NO_EMAIL_ADDRESS_FOUND');
        
      }
    } else {

      $messageStack->add('password_forgotten', TEXT_NO_EMAIL_ADDRESS_FOUND);

    }

  }



  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_LOGIN, '', 'SSL'));

  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_PASSWORD_FORGOTTEN, '', 'SSL'));



  $content = 'password_forgotten_mobile';



  require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);



  require(DIR_WS_INCLUDES . 'application_bottom.php');

?>

