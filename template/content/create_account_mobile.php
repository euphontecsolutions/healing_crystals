<?php

        $token      = $_GET['token'];
        $app_id    = $_GET['app_id'];
       
        
  require('includes/application_top_mobile.php');
  require('includes/classes/http_client.php');
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CREATE_ACCOUNT);


 if($app_id !=''){
     $_SESSION['app_id']=$app_id;
  $mobile_metaQuery = tep_db_query("select app_id from customer_meta_mobile where app_id = '".$app_id."' AND category=1");
  $app_meta_dataArray = tep_db_fetch_array($mobile_metaQuery);
  $date = date("Y-m-d H:i:s");
  if($app_meta_dataArray==''){
  tep_db_query("insert into customer_meta_mobile (app_id, created_date,category) values ('" .$app_id. "', '".$date."',1)");
  }else{
      
      tep_db_query("update customer_meta_mobile set flag = '0' where app_id = '" .$app_id . "'");
  }
 }
  $process = false;

  if (isset($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == 'process')) {

    $process = true;



    if (ACCOUNT_GENDER == 'true') {

      if (isset($HTTP_POST_VARS['gender'])) {

        $gender = tep_db_prepare_input($HTTP_POST_VARS['gender']);

      } else {

        $gender = false;

      }

    }

    $firstname = ucwords(tep_db_prepare_input($HTTP_POST_VARS['firstname']));

    $lastname = ucwords(tep_db_prepare_input($HTTP_POST_VARS['lastname']));

    if (ACCOUNT_DOB == 'true') $dob = tep_db_prepare_input($HTTP_POST_VARS['dob']);

    $email_address = tep_db_prepare_input($HTTP_POST_VARS['email_address']);

    if (ACCOUNT_COMPANY == 'true') $company = tep_db_prepare_input($HTTP_POST_VARS['company']);
     if (ACCOUNT_COMPANY == 'true') $company2 = tep_db_prepare_input($HTTP_POST_VARS['company2']);

    $street_address = tep_db_prepare_input($HTTP_POST_VARS['street_address']);

    if (ACCOUNT_SUBURB == 'true') $suburb = tep_db_prepare_input($HTTP_POST_VARS['suburb']);

    $postcode = tep_db_prepare_input($HTTP_POST_VARS['postcode']);

    $city = tep_db_prepare_input($HTTP_POST_VARS['city']);

    if (ACCOUNT_STATE == 'true') {

      $state = tep_db_prepare_input($HTTP_POST_VARS['state']);

      if (isset($HTTP_POST_VARS['zone_id'])) {

        $zone_id = tep_db_prepare_input($HTTP_POST_VARS['zone_id']);

      } else {

        $zone_id = false;

      }

    }

    $country = tep_db_prepare_input($HTTP_POST_VARS['country']);
    
    $street_address2 = tep_db_prepare_input($HTTP_POST_VARS['street_address2']);

    if (ACCOUNT_SUBURB == 'true') $suburb2 = tep_db_prepare_input($HTTP_POST_VARS['suburb2']);

    $postcode2 = tep_db_prepare_input($HTTP_POST_VARS['postcode2']);

    $city2 = tep_db_prepare_input($HTTP_POST_VARS['city2']);

    if (ACCOUNT_STATE == 'true') {

      $state2 = tep_db_prepare_input($HTTP_POST_VARS['state2']);

      if (isset($HTTP_POST_VARS['zone_id2'])) {

        $zone_id2 = tep_db_prepare_input($HTTP_POST_VARS['zone_id2']);

      } else {

        $zone_id2= false;

      }

    }

    $country2 = tep_db_prepare_input($HTTP_POST_VARS['country2']);
    

    $telephone = tep_db_prepare_input($HTTP_POST_VARS['telephone']);

    $fax = tep_db_prepare_input($HTTP_POST_VARS['fax']);

    if (isset($HTTP_POST_VARS['newsletter'])) {

      $newsletter = tep_db_prepare_input($HTTP_POST_VARS['newsletter']);

    } else {

      $newsletter = false;

    }

    $password = tep_db_prepare_input($HTTP_POST_VARS['password']);

    $confirmation = tep_db_prepare_input($HTTP_POST_VARS['confirmation']);



    $error = false;



    if (ACCOUNT_GENDER == 'true') {

      if ( ($gender != 'm') && ($gender != 'f') ) {

        $error = true;



        $messageStack->add('create_account', ENTRY_GENDER_ERROR);

      }

    }



    if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {

      $error = true;



      $messageStack->add('create_account', ENTRY_FIRST_NAME_ERROR);

    }



    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {

      $error = true;



      $messageStack->add('create_account', ENTRY_LAST_NAME_ERROR);

    }



    if (ACCOUNT_DOB == 'true') {

      if (checkdate(substr(tep_date_raw($dob), 4, 2), substr(tep_date_raw($dob), 6, 2), substr(tep_date_raw($dob), 0, 4)) == false) {

        $error = true;



        $messageStack->add('create_account', ENTRY_DATE_OF_BIRTH_ERROR);

      }

    }



    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {

      $error = true;



      $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR);

    } elseif (tep_validate_email($email_address) == false) {

      $error = true;



      $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);

    } else {

      $check_email_query = tep_db_query("select customers_id as id, customers_paypal_ec as ec from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
 if (tep_db_num_rows($check_email_query) > 0) {
      $check_email = tep_db_fetch_array($check_email_query);
      if ($check_email['ec'] == '1') {
          //It's a temp account, so delete it and let the user create a new one
          tep_db_query("delete from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$check_email['id'] . "'");
          tep_db_query("delete from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$check_email['id'] . "'");
          tep_db_query("delete from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . (int)$check_email['id'] . "'");
          tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . (int)$check_email['id'] . "'");
          tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . (int)$check_email['id'] . "'");
          tep_db_query("delete from " . TABLE_WHOS_ONLINE . " where customer_id = '" . (int)$check_email['id'] . "'");
        } else {


/*

      if ($check_email['total'] > 0) {



        $error = true;

        $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);

      }

*/

// DDB - 040616 - PWA

//      if ($check_email['total'] > 0) {

//        $error = true;

//        $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);

//      }

		    	$get_customer_info = tep_db_query("select customers_id, customers_email_address, purchased_without_account from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");

				$customer_info = tep_db_fetch_array($get_customer_info); 

				$customer_id = $customer_info['customers_id']; 

				$customer_email_address = $customer_info['customers_email_address']; 

				$customer_pwa = $customer_info['purchased_without_account']; 

				if ($customer_pwa !='1') 

				{

		        $error = true;

		        $messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);

				} else {   

					tep_db_query("delete from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . $customer_id . "'");   

					tep_db_query("delete from " . TABLE_CUSTOMERS . " where customers_id = '" . $customer_id . "'");   

					tep_db_query("delete from " . TABLE_CUSTOMERS_INFO . " where customers_info_id = '" . $customer_id . "'");   

					tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id = '" . $customer_id . "'");   

					tep_db_query("delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id = '" . $customer_id . "'");   

					tep_db_query("delete from " . TABLE_WHOS_ONLINE . " where customer_id = '" . $customer_id . "'"); 

				}  

      }

	// END

    }
 }


    if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {

      $error = true;



      $messageStack->add('create_account', ENTRY_STREET_ADDRESS_ERROR);

    }



    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {

      $error = true;



      $messageStack->add('create_account', ENTRY_POST_CODE_ERROR);

    }



    if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {

      $error = true;



      $messageStack->add('create_account', ENTRY_CITY_ERROR);

    }



    if (is_numeric($country) == false) {

      $error = true;



      $messageStack->add('create_account', ENTRY_COUNTRY_ERROR);

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



          $messageStack->add('create_account', ENTRY_STATE_ERROR_SELECT);

        }

      } else {

        if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {

          $error = true;



          $messageStack->add('create_account', ENTRY_STATE_ERROR);

        }

      }

    }

//if(strlen($street_address2) > 0){
    if (strlen($street_address2) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {

      $error = true;



      $messageStack->add('create_account', ENTRY_STREET_ADDRESS_ERROR);

    }



    if (strlen($postcode2) < ENTRY_POSTCODE_MIN_LENGTH) {

      $error = true;



      $messageStack->add('create_account', ENTRY_SHIPPING_POST_CODE_ERROR);

    }



    if (strlen($city2) < ENTRY_CITY_MIN_LENGTH) {

      $error = true;



      $messageStack->add('create_account', ENTRY_SHIPPING_CITY_ERROR);

    }



    if (is_numeric($country2) == false) {

      $error = true;



      $messageStack->add('create_account', ENTRY_SHIPPING_COUNTRY_ERROR);

    }



    if (ACCOUNT_STATE == 'true') {

      $zone_id2 = 0;

      $check_query2 = tep_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country2 . "'");

      $check = tep_db_fetch_array($check_query2);

      $entry_state_has_zones2 = ($check['total'] > 0);

      if ($entry_state_has_zones2 == true) {

        $zone_query2 = tep_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country2 . "' and (zone_name like '" . tep_db_input($state2) . "%' or zone_code like '%" . tep_db_input($state2) . "%')");

        if (tep_db_num_rows($zone_query2) == 1) {

          $zone2 = tep_db_fetch_array($zone_query2);

          $zone_id2 = $zone2['zone_id'];

        } else {

          $error = true;



          $messageStack->add('create_account', ENTRY_SHIPPING_STATE_ERROR_SELECT);

        }

      } else {

        if (strlen($state2) < ENTRY_STATE_MIN_LENGTH) {

          $error = true;



          $messageStack->add('create_account', ENTRY_SHIPPING_STATE_ERROR);

        }

      }

    }
    
          //Check USPS API For address
    if((int)$country == SHIPPING_ORIGIN_COUNTRY){
        $addressVerificationXml = '<AddressValidateRequest USERID="' . MODULE_SHIPPING_USPS_USERID . '"><Address ID="0"><Address1></Address1>
<Address2>'.$street_address.'</Address2><City>'.$city.'</City><State>'.$state.'</State><Zip5>'.$postcode.'</Zip5><Zip4></Zip4></Address></AddressValidateRequest>';
        //echo     $addressVerificationXml;     
        $http = new httpClient();               
                 $http->Connect('production.shippingapis.com', 80);
                 $http->addHeader('Host', 'production.shippingapis.com');
                 $http->addHeader('User-Agent', 'osCommerce');
                 $http->addHeader('Connection', 'Close');
                 //echo '/shippingapi.dll?API=Verify&XML=' . urlencode($addressVerificationXml);
                 
                 $http->Get('/shippingapi.dll?API=Verify&XML=' . urlencode($addressVerificationXml));
                 $respBody = $http->getBody();
                 
                 //echo $respBody;
                 //exit;
                 $http->Disconnect();
                 if (preg_match('/<Error>/', $respBody)) {
                    $error = true;
                    $messageStack->add('create_account','Your address failed USPS Adrress Verification, Please enter correct Address');
                }
    }
//}

//    if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {

//      $error = true;



//      $messageStack->add('create_account', ENTRY_TELEPHONE_NUMBER_ERROR);

//    }





    if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {

      $error = true;



      $messageStack->add('create_account', ENTRY_PASSWORD_ERROR);

    } elseif ($password != $confirmation) {

      $error = true;



      $messageStack->add('create_account', ENTRY_PASSWORD_ERROR_NOT_MATCHING);

    }

$password = strtolower($password);


    if ($error == false) {

      $sql_data_array = array('customers_firstname' => $firstname,

                              'customers_lastname' => $lastname,

                              'customers_email_address' => $email_address,

                              'customers_telephone' => $telephone,

                              'customers_fax' => $fax,

                              'customers_newsletter' => $newsletter,

                              'customers_password' => tep_encrypt_password($password),
                              'password_updated' => '1',
      						  'ip_address'=>$_SERVER['REMOTE_ADDR']);



      if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;

      if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = tep_date_raw($dob);



      tep_db_perform(TABLE_CUSTOMERS, $sql_data_array);



      $customer_id = tep_db_insert_id();



      $sql_data_array = array('customers_id' => $customer_id,

                              'entry_firstname' => $firstname,

                              'entry_lastname' => $lastname,

                              'entry_street_address' => $street_address,

                              'entry_postcode' => $postcode,

                              'entry_city' => $city,

                              'entry_country_id' => $country);



      if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender;

      if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $company;

      if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $suburb;

      if (ACCOUNT_STATE == 'true') {

        if ($zone_id > 0) {

          $sql_data_array['entry_zone_id'] = $zone_id;

          $sql_data_array['entry_state'] = '';

        } else {

          $sql_data_array['entry_zone_id'] = '0';

          $sql_data_array['entry_state'] = $state;

        }

      }



      tep_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);



      $address_id = tep_db_insert_id();

$sql_data_array = array('customers_id' => $customer_id,

                              'entry_firstname' => $firstname,

                              'entry_lastname' => $lastname,

                              'entry_street_address' => $street_address2,

                              'entry_postcode' => $postcode2,

                              'entry_city' => $city2,

                              'entry_country_id' => $country2);



      if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender;

      if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $company2;

      if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $suburb2;

      if (ACCOUNT_STATE == 'true') {

        if ($zone_id2 > 0) {

          $sql_data_array['entry_zone_id'] = $zone_id2;

          $sql_data_array['entry_state'] = '';

        } else {

          $sql_data_array['entry_zone_id'] = '0';

          $sql_data_array['entry_state'] = $state2;

        }

      }



      tep_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
      $address_id2 = tep_db_insert_id();

      tep_db_query("update " . TABLE_CUSTOMERS . " set customers_default_address_id = '" . (int)$address_id . "', customers_default_shipping_id = '".(int)$address_id2."' where customers_id = '" . (int)$customer_id . "'");



      tep_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$customer_id . "', '0', now())");


/*if ($newsletter == '1') {
    addconfirmUser($firstname, $lastname, $email_address);
   }*/
      if (SESSION_RECREATE == 'True') {

        tep_session_recreate();

      }



      $customer_first_name = $firstname;

      $customer_default_address_id = $address_id;
      
      $customer_default_shipping_id = $address_id2;

      $customer_country_id = $country;

      $customer_zone_id = $zone_id;

      tep_session_register('customer_id');

      tep_session_register('customer_first_name');

      tep_session_register('customer_default_address_id');
      
      tep_session_register('customer_default_shipping_id');

      tep_session_register('customer_country_id');

      tep_session_register('customer_zone_id');



// restore cart contents

      $cart->restore_contents();



// build the message content

      $name = $firstname . ' ' . $lastname;

/*

      if (ACCOUNT_GENDER == 'true') {

         if ($gender == 'm') {

           $email_text = sprintf(EMAIL_GREET_MR, $lastname);

         } else {

           $email_text = sprintf(EMAIL_GREET_MS, $lastname);

         }

      } else {

        $email_text = sprintf(EMAIL_GREET_NONE, $firstname);

      }



      //$email_text .= EMAIL_WELCOME . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_WARNING;
		$email_text .= EMAIL_WELCOME . EMAIL_TEXT;



// ICW - CREDIT CLASS CODE BLOCK ADDED  ******************************************************* BEGIN

  if (NEW_SIGNUP_GIFT_VOUCHER_AMOUNT > 0) {

    $coupon_code = create_coupon_code();

    $insert_query = tep_db_query("insert into " . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created) values ('" . $coupon_code . "', 'G', '" . NEW_SIGNUP_GIFT_VOUCHER_AMOUNT . "', now())");

    $insert_id = tep_db_insert_id($insert_query);

    $insert_query = tep_db_query("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $insert_id ."', '0', 'Admin', '" . $email_address . "', now() )");



    $email_text .= sprintf(EMAIL_GV_INCENTIVE_HEADER, $currencies->format(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT)) . "\n" .

                   sprintf(EMAIL_GV_REDEEM, $coupon_code) . "\n" .

                   EMAIL_GV_LINK . tep_href_link(FILENAME_GV_REDEEM, 'gv_no=' . $coupon_code,'NONSSL', false) . "\n";

  }

  if (NEW_SIGNUP_DISCOUNT_COUPON != '') {

		$coupon_code = NEW_SIGNUP_DISCOUNT_COUPON;

    $coupon_query = tep_db_query("select * from " . TABLE_COUPONS . " where coupon_code = '" . $coupon_code . "'");

    $coupon = tep_db_fetch_array($coupon_query);

		$coupon_id = $coupon['coupon_id'];		

    $coupon_desc_query = tep_db_query("select * from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" . $coupon_id . "' and language_id = '" . (int)$languages_id . "'");

    $coupon_desc = tep_db_fetch_array($coupon_desc_query);

    $insert_query = tep_db_query("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $coupon_id ."', '0', 'Admin', '" . $email_address . "', now() )");

    $email_text .= EMAIL_COUPON_INCENTIVE_HEADER .  "\n" ;
    if ($coupon_desc['coupon_description'] != '') {
               $email_text .= $coupon_desc['coupon_description'] ."\n" ;
               }
                $email_text .=sprintf(EMAIL_COUPON_REDEEM, $coupon['coupon_code']) . "\n" . "\n";

  }

    $email_text .= EMAIL_CONTACT . EMAIL_WARNING;
*/
// ICW - CREDIT CLASS CODE BLOCK ADDED  ******************************************************* END

$emailTemplateQuery = tep_db_query("select page_and_email_templates_content from page_and_email_templates where page_and_email_templates_key = 'EMAIL_TEMPLATE_NEW_CUSTOMER'");
$emailTemplateArray = tep_db_fetch_array($emailTemplateQuery);

$variableToBeReplaced = array('{customers_firstname}','{customers_lastname}','{customers_email_address}');
$variableToBeAdded= array($firstname,$lastname,$email_address);
$email_text = str_replace($variableToBeReplaced,$variableToBeAdded,$emailTemplateArray['page_and_email_templates_content']);
      tep_mail($name, $email_address, EMAIL_SUBJECT, callback($email_text), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS,true);


     tep_db_query("update customer_meta_mobile set flag = '1', customer_id = '".(int)$customer_id."' where app_id = '" .$_SESSION['app_id'] . "' AND category=1");
      /*tep_redirect(tep_href_link(FILENAME_CREATE_ACCOUNT_SUCCESS, '', 'SSL'));*/
        $messageStack->add('create_account', 'Account created successfully','success');

    }

  }



  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));



  $content = 'create_account_mobile';

  $javascript = 'form_check.js.php';

  require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);



  require(DIR_WS_INCLUDES . 'application_bottom.php');
       
   

?>