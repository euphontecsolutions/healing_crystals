<?php
/*
  $Id: wishlist_help.php,v 1  2002/11/09 wib

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top_mobile.php');

  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }
  
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_WISHLIST);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_WISHLIST, '', 'NONSSL'));

  $content = /*CONTENT_WISHLIST*/'wishlist_mobile';

  require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
