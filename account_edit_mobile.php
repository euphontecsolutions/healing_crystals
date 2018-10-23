<?php
/*
  $Id: account_edit.php,v 1.2 2003/09/24 13:57:00 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top_mobile.php');

    $user_id    = $_GET['user_id'];

        
        $check_customer_query = tep_db_query("SELECT * FROM `customer_mobile_app` WHERE `cma_customers_id`='".$user_id."'");

    if (tep_db_fetch_array($check_customer_query)) {
       // $user_id=274422;


    $check_customer_query = tep_db_query("select customers_id, customers_firstname, is_customer_blacklisted, customers_password, password_updated, customers_email_address, customers_default_address_id, customers_default_shipping_id, ip_address, affiliate_id from " . TABLE_CUSTOMERS . " where customers_id = '" . $user_id . "'");

    if (!tep_db_num_rows($check_customer_query)) {   
		
        $error = true;
    } else {
        $error = false;
        $check_customer = tep_db_fetch_array($check_customer_query);


            if (SESSION_RECREATE == 'True') {

                tep_session_recreate();
            }



            $check_country_query = tep_db_query("select entry_country_id, entry_zone_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int) $check_customer['customers_id'] . "' and address_book_id = '" . (int) $check_customer['customers_default_address_id'] . "'");

            if (tep_db_num_rows($check_country_query) > 0) {
                $check_country = tep_db_fetch_array($check_country_query);
                $customer_id = $check_customer['customers_id'];
                $customer_default_address_id = $check_customer['customers_default_address_id'];
            } else {
                $check_country_query = tep_db_query("select entry_country_id, entry_zone_id, address_book_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int) $check_customer['customers_id'] . "' limit 1");
                $check_country = tep_db_fetch_array($check_country_query);
                $customer_id = $check_customer['customers_id'];
                $customer_default_address_id = $check_country['address_book_id'];
            }


            if ($check_customer['customers_default_shipping_id'] != '0') {
                $checkShippingAddress = tep_db_query("select count(*) as total from address_book where address_book_id = '" . $check_customer['customers_default_shipping_id'] . "' and customers_id = '" . (int) $check_customer['customers_id'] . "'");
                $checkShippingArray = tep_db_fetch_array($checkShippingAddress);
                if ($checkShippingArray['total'] > 0
                    )$customer_default_shipping_id = $check_customer['customers_default_shipping_id'];
                else
                    $customer_default_shipping_id = $customer_default_address_id;
            }else {
                $customer_default_shipping_id = $customer_default_address_id;
            }


            $customer_first_name = $check_customer['customers_firstname'];

            $customer_country_id = $check_country['entry_country_id'];

            $customer_zone_id = $check_country['entry_zone_id'];

            if ($check_customer['ip_address'] == ''
                )tep_db_query("update customers set ip_address = '" . $_SERVER['REMOTE_ADDR'] . "' where customers_id = '" . $customer_id . "'");
            tep_session_register('customer_id');
        $_SESSION['customer_id']=$customer_id;
$_SESSION['is_mobile']=1;
            tep_session_register('customer_default_address_id');
            tep_session_register('customer_default_shipping_id');

            tep_session_register('customer_first_name');

            tep_session_register('customer_country_id');

            tep_session_register('customer_zone_id');
//Modifictaion for Remember Me otpion(SA) 16 April 2009 BOF
            if ((ALLOW_AUTOLOGONLOGON == 'false') || ($HTTP_POST_VARS['remember_me'] == '')) {
                tep_autologincookie(false);
            } else {
                tep_autologincookie(true);
            }
//Modifictaion for Remember Me otpion(SA) 16 April 2009 EOF


            tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_of_last_logon = now(), customers_info_number_of_logons = customers_info_number_of_logons+1 where customers_info_id = '" . (int) $customer_id . "'");



           
// restore cart contents

            $cart->restore_contents();

            
///duplicate customer check
            $login_cust_query = tep_db_query("select c.customers_firstname, c.customers_lastname, c.customers_default_address_id, LOWER(a.entry_city) as entry_city, a.entry_state, a.entry_zone_id from customers c, address_book a where a.customers_id = c.customers_id and a.address_book_id = c.customers_default_address_id and c.customers_id = '" . $customer_id . "'");
            $login_cust = tep_db_fetch_array($login_cust_query);
            $fname = strtolower($login_cust['customers_firstname']);
            $lname = strtolower($login_cust['customers_lastname']);

           
            //$p = tep_db_query("SELECT customers_id, customers_default_address_id FROM customers where LOWER(customers_firstname) = '" . $fname . "' and LOWER(customers_lastname) = '" . $lname . "' and customers_id != '" . $customer_id . "' order by customers_firstname");
            //$id_string = $customer_id . ',';
            $p = tep_db_query("SELECT customers_id, customers_default_address_id FROM customers where LOWER(customers_firstname) = '" . addslashes($fname) . "' and LOWER(customers_lastname) = '" . addslashes($lname) . "' and customers_id != '" . $customer_id . "' order by customers_firstname");
            $id_string = $customer_id . ',';
            if (tep_db_num_rows($p)) {
                if ($login_cust['entry_zone_id'] != 0) {
                    $st_query = tep_db_query("select zone_name from zones where zone_id = '" . $login_cust['entry_zone_id'] . "'");
                    $st_array = tep_db_fetch_array($st_query);
                    $login_cust['entry_state'] = $st_array['zone_name'];
                }
            }
            while ($b = tep_db_fetch_array($p)) {
                $q = tep_db_query("select customers_id, entry_state, entry_zone_id from address_book where address_book_id = '" . $b['customers_default_address_id'] . "' and LOWER(entry_city) = '" . addslashes($login_cust['entry_city']) . "'");
                $a = tep_db_fetch_array($q);
                if ($a['entry_zone_id'] != 0) {
                    $st_new_query = tep_db_query("select zone_name from zones where zone_id = '" . $a['entry_zone_id'] . "'");
                    $st_array_new = tep_db_fetch_array($st_new_query);
                    $a['entry_state'] = $st_array_new['zone_name'];
                }
                if (strtolower($a['entry_state']) == strtolower($login_cust['entry_state'])) {
                    $id_string .= $a['customers_id'] . ',';
                }
            }
            $id_string = substr($id_string, 0, -1);

            tep_db_query("update customers set customers_other_id = '" . $id_string . "' where customers_id = '" . $customer_id . "'");
            $_SESSION['customers_other_id'] = $id_string;
///duplicate customer check


 if($check_customer['affiliate_id']!=''){
                $affiliate_id = $check_customer['affiliate_id'];
                tep_session_register('affiliate_id');
                //updateAffiliateComissions($affiliate_id);
                $date_now = date('Ymd');
                tep_db_query("update " . TABLE_AFFILIATE . " set affiliate_date_of_last_logon = now(), affiliate_number_of_logons = affiliate_number_of_logons + 1 where affiliate_id = '" . $affiliate_id . "'");
                if ($cart->count_contents() < 1 && sizeof($navigation->snapshot) == 0)tep_redirect(tep_href_link(FILENAME_AFFILIATE_SUMMARY,'','SSL'));
            }else{
                //check Affiliate
                $affQ = tep_db_query("select affiliate_id from affiliate_affiliate where affiliate_email_address = '".$email_address."' ");
                if(tep_db_num_rows($affQ)){
                    $affA = tep_db_fetch_array($affQ);
                    $affiliate_id = $affA['affiliate_id'];
                    tep_db_query("update customers set affiliate_id = '".$affiliate_id."' where customers_id = '".$customer_id."'");
                    tep_session_register('affiliate_id');
                    $date_now = date('Ymd');
                    tep_db_query("update " . TABLE_AFFILIATE . " set affiliate_date_of_last_logon = now(), affiliate_number_of_logons = affiliate_number_of_logons + 1 where affiliate_id = '" . $affiliate_id . "'");
                }
            }
            //if($customer_id=='15133')
            

            if (sizeof($navigation->snapshot) > 0) {
                 
                $origin_href = tep_href_link($navigation->snapshot['page'], tep_array_to_string($navigation->snapshot['get'], array(tep_session_name())), $navigation->snapshot['mode']);

                if ($navigation->snapshot['page'] == 'wishlist.php') {
                    foreach ($navigation->snapshot['post'] as $key => $value) {
                        $HTTP_SESSION_VARS['wishlist_variables'][$key] = $value;
                    }
                }
                $navigation->clear_snapshot();

                tep_redirect($origin_href);
            } 
        

        //}
    }

  
// needs to be included earlier to set the success message in the messageStack
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT_EDIT);

  if (isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'process')) {
  	
    if (ACCOUNT_GENDER == 'true') $gender = tep_db_prepare_input($HTTP_POST_VARS['gender']);
    $firstname = tep_db_prepare_input($HTTP_POST_VARS['firstname']);
    $bfirstname = tep_db_prepare_input($HTTP_POST_VARS['bfirstname']);
    $lastname = tep_db_prepare_input($HTTP_POST_VARS['lastname']);
    $blastname = tep_db_prepare_input($HTTP_POST_VARS['blastname']);
    if (ACCOUNT_DOB == 'true') $dob = tep_db_prepare_input($HTTP_POST_VARS['dob']);
    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);
    $telephone = tep_db_prepare_input($HTTP_POST_VARS['telephone']);
    $fax = tep_db_prepare_input($HTTP_POST_VARS['fax']);

    $error = false;
    
  $street_address = ucwords(tep_db_prepare_input($HTTP_POST_VARS['bstreet_address']));

    if (ACCOUNT_SUBURB == 'true') $suburb = ucwords(tep_db_prepare_input($HTTP_POST_VARS['bsuburb']));

    $postcode = tep_db_prepare_input($HTTP_POST_VARS['bpostcode']);

    $city = ucwords(tep_db_prepare_input($HTTP_POST_VARS['bcity']));

    $country = tep_db_prepare_input($HTTP_POST_VARS['bcountry']);
	$company = tep_db_prepare_input($HTTP_POST_VARS['bcompany']);

    if (ACCOUNT_STATE == 'true') {

      if (isset($HTTP_POST_VARS['zone_id'])) {

        $zone_id = tep_db_prepare_input($HTTP_POST_VARS['zone_id']);

      } else {

        $zone_id = false;

      }

      $state = ucwords(tep_db_prepare_input($HTTP_POST_VARS['bstate']));

    }
    if (ACCOUNT_GENDER == 'true') {
      if ( ($gender != 'm') && ($gender != 'f') ) {
        $error = true;

        $messageStack->add('account_edit', ENTRY_GENDER_ERROR);
      }
    }

    if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('account_edit', ENTRY_FIRST_NAME_ERROR);
    }
  if (strlen($bfirstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('account_edit', ENTRY_FIRST_NAME_ERROR);
    }

    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('account_edit', ENTRY_LAST_NAME_ERROR);
    }
  if (strlen($blastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('account_edit', ENTRY_LAST_NAME_ERROR);
    }

    if (ACCOUNT_DOB == 'true') {
      if (!checkdate(substr(tep_date_raw($dob), 4, 2), substr(tep_date_raw($dob), 6, 2), substr(tep_date_raw($dob), 0, 4))) {
        $error = true;

        $messageStack->add('account_edit', ENTRY_DATE_OF_BIRTH_ERROR);
      }
    }

    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('account_edit', ENTRY_EMAIL_ADDRESS_ERROR);
    }

    if (!tep_validate_email($email_address)) {
      $error = true;

      $messageStack->add('account_edit', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    }

    $check_email_query = tep_db_query("select count(*) as total from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "' and customers_id != '" . (int)$customer_id . "'");
    $check_email = tep_db_fetch_array($check_email_query);
    if ($check_email['total'] > 0) {
      $error = true;

      $messageStack->add('account_edit', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
    }

    if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
      $error = true;

      $messageStack->add('account_edit', ENTRY_TELEPHONE_NUMBER_ERROR);
    }
  if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {

      $error = true;



      $messageStack->add('addressbook', ENTRY_STREET_ADDRESS_ERROR);

    }



    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {

      $error = true;



      $messageStack->add('addressbook', ENTRY_POST_CODE_ERROR);

    }



    if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {

      $error = true;



      $messageStack->add('addressbook', ENTRY_CITY_ERROR);

    }



    if (!is_numeric($country)) {

      $error = true;



      $messageStack->add('addressbook', ENTRY_COUNTRY_ERROR);

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



          $messageStack->add('addressbook', ENTRY_STATE_ERROR_SELECT);

        }

      } else {

        if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {

          $error = true;



          $messageStack->add('addressbook', ENTRY_STATE_ERROR);

        }

      }

    }

    if ($error == false) {
      $sql_data_array = array('customers_firstname' => $firstname,
                              'customers_lastname' => $lastname,
                              'customers_email_address' => $email_address,
                              'customers_telephone' => $telephone,
                              'customers_fax' => $fax);

      if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;
      if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = tep_date_raw($dob);

      tep_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . (int)$customer_id . "'");

      tep_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_account_last_modified = now() where customers_info_id = '" . (int)$customer_id . "'");

      $sql_data_array = array('entry_firstname' => $firstname,
                              'entry_lastname' => $lastname);

      tep_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', "customers_id = '" . (int)$customer_id . "' and address_book_id = '" . (int)$customer_default_address_id . "'");
      
      $sql_data_array = array('entry_firstname' => $bfirstname,

                              'entry_lastname' => $blastname,

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

        tep_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', "address_book_id = '" . (int)$customer_default_address_id . "' and customers_id ='" . (int)$customer_id . "'");

// reset the session variables
      $customer_first_name = $firstname;
/* $messageStack->add_session('account_edit', SUCCESS_ACCOUNT_UPDATED, 'success');*/
  $messageStack->add('account_edit', SUCCESS_ACCOUNT_UPDATED, 'success');


		$redirectV = '';	
      /*tep_redirect($HTTP_POST_VARS['redirect']);*/
    }
  }
}
  $account_query = tep_db_query("select customers_gender, customers_firstname, customers_lastname, customers_dob, customers_email_address, customers_telephone, customers_fax from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
  $account = tep_db_fetch_array($account_query);

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'));

  $content = 'account_edit_mobile';
  $javascript = 'form_check.js.php'; 

  require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_WS_INCLUDES . 'application_bottom_mobile.php');
?>