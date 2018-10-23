<?php

  require('includes/application_top_mobile.php');
 //Modifictaion for Remember Me otpion(SA) 16 April 2009 BOF
      tep_autologincookie(false);
//Modifictaion for Remember Me otpion(SA) 16 April 2009 EOF

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_LOGOFF);

  $breadcrumb->add(NAVBAR_TITLE);

  tep_session_unregister('customer_id');
  tep_session_unregister('customer_default_address_id');
  tep_session_unregister('customer_default_shipping_id');
  tep_session_unregister('cart_address_id');
  tep_session_unregister('customer_first_name');
  tep_session_unregister('customer_country_id');
  tep_session_unregister('customer_zone_id');
  tep_session_unregister('comments');
//ICW - logout -> unregister GIFT VOUCHER sessions - Thanks Fredrik
  tep_session_unregister('gv_id');
  tep_session_unregister('cc_id');
   tep_session_unregister('cc_code');
    tep_session_unregister('cc_coupon_amount');
       tep_session_unregister('gv_code');
    tep_session_unregister('gv_coupon_amount');
	tep_session_unregister('checkout_payment');
tep_session_unregister('checkout_shipping');
tep_session_unregister('selected_shipping');
tep_session_unregister('shipping');
tep_session_unregister('checkout_comments');
tep_session_unregister('checkout_subscribe_nl');
tep_session_unregister('checkout_gv_redeem_code');
tep_session_unregister('paypalwpp_cc_firstname');
tep_session_unregister('paypalwpp_cc_lastname');
tep_session_unregister('paypalwpp_cc_number');
tep_session_unregister('paypalwpp_cc_checkcode');
tep_session_unregister('wishlist_variables');
tep_session_unregister('master_login');
tep_session_unregister('customers_other_id');
tep_session_unregister('affiliate_ref');
tep_session_unregister('affiliate_id');
tep_session_unregister('cwa_id');
tep_session_unregister('oosProList');
tep_session_destroy();
//ICW - logout -> unregister GIFT VOUCHER sessions  - Thanks Fredrik
  $cart->reset();

 unset($_COOKIE['customer_id']);
 unset($_COOKIE['customer_default_address_id']);
 unset($_COOKIE['customer_first_name']);
 unset($_COOKIE['customer_country_id']);
 unset($_COOKIE['customer_zone_id']);
 unset($_COOKIE['comments']);
//session_destroy();


  require(DIR_WS_INCLUDES . 'application_bottom_mobile.php');
?>
