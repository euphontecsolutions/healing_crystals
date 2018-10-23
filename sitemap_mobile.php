<?php
/*
  $Id: contact_us.php,v 1.2 2003/09/24 15:34:26 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/


#  3/12/09 edit by Bob <www.site-webmaster.com>:  using standard template for sitemap

require('includes/application_top_mobile.php');

require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SITEMAP);


$breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SITEMAP));

$content = 'sitemap_mobile';

require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);

require(DIR_WS_INCLUDES . 'application_bottom_mobile.php');

?>