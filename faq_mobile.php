<?php
/*
  $Id: allprods.php,v 1.7 2002/12/02

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce
  Copyright (c) 2002 HMCservices

  Released under the GNU General Public License
*/

  require('includes/application_top_mobile.php');
  include(DIR_WS_LANGUAGES . $language . '/' . FILENAME_FAQ);

// Set number of columns in listing
	define ('NR_COLUMNS', 1);
//
  $breadcrumb->add(HEADING_TITLE, tep_href_link(FILENAME_FAQ, '', 'NONSSL'));

  /*$content = CONTENT_FAQ_MOBILE;*/
  $content = 'faq_mobile';

  require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

  require(DIR_WS_INCLUDES . 'application_bottom_mobile.php');
?>
