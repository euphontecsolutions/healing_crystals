<?php
require('includes/application_top_mobile.php');
if (!tep_session_is_registered('customer_id')) {

    $navigation->set_snapshot();

    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));

  }

if (!isset($HTTP_GET_VARS['order_id']) || (isset($HTTP_GET_VARS['order_id']) && !is_numeric($HTTP_GET_VARS['order_id']))) {

    tep_redirect(tep_href_link('account_history_info_mobile.php', '', 'SSL'));

  }

  

  $cust_ids_array = explode(',', $_SESSION['customers_other_id']);

  $customer_info_query = tep_db_query("select customers_id from " . TABLE_ORDERS . " where orders_id = '". (int)$HTTP_GET_VARS['order_id'] . "'");

  $customer_info = tep_db_fetch_array($customer_info_query);

  if (!in_array($customer_info['customers_id'], $cust_ids_array)) {

    tep_redirect(tep_href_link('account_history_info_mobile.php', '', 'SSL'));

  }


  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ACCOUNT_HISTORY_INFO);



  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));

  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));

  $breadcrumb->add(sprintf(NAVBAR_TITLE_3, $HTTP_GET_VARS['order_id']), tep_href_link('account_history_info_mobile', 'order_id=' . $HTTP_GET_VARS['order_id'], 'SSL'));



  require(DIR_WS_CLASSES . 'order.php');

  $order = new order($HTTP_GET_VARS['order_id']);



  $content = 'account_history_info_mobile';

  $javascript = 'popup_window.js';

  require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);



  require(DIR_WS_INCLUDES . 'application_bottom_mobile.php');

?>

