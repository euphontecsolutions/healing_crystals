<?php

require('includes/application_top_mobile.php');
require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_FAQDESK_REVIEWS_ARTICLE_MOBILE);

// lets retrieve all $HTTP_GET_VARS keys and values..
$get_params = tep_get_all_get_params();
$get_params_back = tep_get_all_get_params(array('reviews_id')); // for back button
$get_params = substr($get_params, 0, -1); //remove trailing &
if ($get_params_back != '') {
    $get_params_back = substr($get_params_back, 0, -1); //remove trailing &
} else {
    $get_params_back = $get_params;
}

$breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_FAQDESK_REVIEWS_ARTICLE, $get_params, 'NONSSL'));

$product = tep_db_query("select faqdesk_question from " . TABLE_FAQDESK_DESCRIPTION . " where language_id = '" . $languages_id . "' and faqdesk_id = '" . $HTTP_GET_VARS['faqdesk_id'] . "'");
$product_info_values = tep_db_fetch_array($product);

//$javascript = "support.js";


$content = CONTENT_FAQDESK_REVIEWS_ARTICLE;
require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);
require(DIR_WS_INCLUDES . 'application_bottom_mobile.php');
?>


<?php
/*

	osCommerce, Open Source E-Commerce Solutions ---- http://www.oscommerce.com
	Copyright (c) 2002 osCommerce
	Released under the GNU General Public License

	IMPORTANT NOTE:

	This script is not part of the official osC distribution but an add-on contributed to the osC community.
	Please read the NOTE and INSTALL documents that are provided with this file for further information and installation notes.

	script name:	FaqDesk
	version:		1.2.5
	date:			2003-09-01
	author:			Carsten aka moyashi
	web site:		www..com

*/
?>