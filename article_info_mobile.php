<?php
/*
  $Id: article_info.php, v1.0 2003/12/04 12:00:00 ra Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top_mobile.php');
  if($_GET['articles_id'] == '4045' ){
      tep_redirect(tep_href_link('affiliate_faq.php'));
  }
if(isset($HTTP_GET_VARS['twitter_url']) && $HTTP_GET_VARS['twitter_url']!=''){
	$idquery = tep_db_query("select articles_id from articles where twitter_url = '".$HTTP_GET_VARS['twitter_url']."'");
	$idarray = tep_db_fetch_array($idquery);
	$HTTP_GET_VARS['articles_id'] = $idarray['articles_id'];
	Header( "HTTP/1.1 301 Moved Permanently" );
	Header( "Location:".tep_href_link('article_info.php','articles_id='.$HTTP_GET_VARS['articles_id']) );
}
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_ARTICLE_INFO);
/*if($_GET['action'] == 'text_only'){
	if($_POST['hide_images'] == 'yes'){
		$hide_products_images = '1';
		tep_session_register('hide_products_images');
	}elseif(isset($_POST['show_images']) && ($_POST['show_images'] == '1')){
		$hide_products_images = '0';
		tep_session_register('hide_products_images');
	}
}*/
 $hide_products_images=0;//new  changes 16-10-15
if($_GET['action'] == 'text_only'){
	if($_POST['hide_images'] == 'yes' || $_GET['hide_images'] == 'yes'){
		$hide_products_images = '1';
		tep_session_register('hide_products_images');
	}elseif(isset($_POST['show_images']) && ($_POST['show_images'] == '1') || (isset($_GET['show_images']) && ($_GET['show_images'] == '1'))){
		$hide_products_images = '0';
		tep_session_register('hide_products_images');
	}
}
/*
//new code 15-10-2015 5:13 PM
if($HTTP_GET_VARS['articles_id']==2793)
{
		$hide_products_images = '1';
		tep_session_register('hide_products_images');
}
elseif($_GET['action'] == 'text_only'){
//	print_r($_POST);
	if($_POST['hide_images'] == 'yes' || $_GET['hide_images'] == 'yes'){
		$hide_products_images = '1';
		tep_session_register('hide_products_images');
	}elseif(isset($_POST['show_images']) && ($_POST['show_images'] == '1') || (isset($_GET['show_images']) && ($_GET['show_images'] == '1'))){
		$hide_products_images = '0';
		tep_session_register('hide_products_images');
	}
}*/

if($hide_products_images == '1'){
	$value = 'no';
}else{
	$value = 'yes';
}
  $article_check_query = tep_db_query("select count(*) as total from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad where a.articles_status = '1' and a.articles_id = '" . (int)$HTTP_GET_VARS['articles_id'] . "' and ad.articles_id = a.articles_id and ad.language_id = '" . (int)$languages_id . "'");
  if($HTTP_GET_VARS['preview']=='on')$article_check_query = tep_db_query("select count(*) as total from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad where a.articles_id = '" . (int)$HTTP_GET_VARS['articles_id'] . "' and ad.articles_id = a.articles_id and ad.language_id = '" . (int)$languages_id . "'");
  $article_check = tep_db_fetch_array($article_check_query);
  
  $content = 'article_info_mobile';

require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/' . TEMPLATENAME_MAIN_PAGE);
require(DIR_WS_INCLUDES . 'application_bottom_mobile.php');
?>
