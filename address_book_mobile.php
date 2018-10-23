<?php
/*
  $Id: address_book.php,v 1.2 2003/09/24 13:57:00 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top_mobile.php');

  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }
  if($_GET['checkout']=='cart'){
  $_SESSION['checkout'] = "cart";
}
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ADDRESS_BOOK);

  $breadcrumb->add(NAVBAR_TITLE_1, tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));

  $content = 'address_book_mobile';
  $javascript = CONTENT_ADDRESS_BOOK .'.js';

  require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_WS_INCLUDES . 'application_bottom_mobile.php');
?>
