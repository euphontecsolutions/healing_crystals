<?php
//header("x-frame-options: SAMEORIGIN");
/*
  $Id: application_top.php,v 1.2 2003/09/24 15:34:33 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/
//* 2-MAY-2012, (MA) add ability for customers to easily reorder , #557

date_default_timezone_set('America/New_York');
$HTTP_GET_VARS = $_GET;
$HTTP_POST_VARS = $_POST;

$HTTP_SERVER_VARS = $_SERVER;
if (isset($_SESSION)){
$HTTP_SESSION_VARS = $_SESSION;
}
if(isset($_COOKIE['osC_AdminEmail']) && $_COOKIE['osC_AdminEmail']!=''){
$mtime = microtime(); 
   $mtime = explode(" ",$mtime); 
   $mtime = $mtime[1] + $mtime[0]; 
   $starttime = $mtime;
}

if (preg_match("/new_product_preview/",$_SERVER['QUERY_STRING']) || (isset($_GET['images']) && $_GET['images'] != 'all')) {
    foreach ($_POST as $key => $value) {
        $body .= $key . ' = ' . $value . "\n";
    }

    foreach ($_FILES as $key => $value) {
        $body .= $key . ' = ' . $_FILES[$key]['name'] . ' - ' . $_FILES[$key]['type'] . "\n";
    }
//    echo $body;
  //  exit();
  //  mail("office@focusindia.com", "Healing Crystals Alert" , $body);
    $body = '';
}
define ('EST_TIME_TIME', strtotime(gmstrftime("%Y-%m-%d %H:%M:%S", strtotime ("- 4 hour"))));


//define ('EST_TIME_NOW', gmdate ('Y-m-d H:i:s', time () - 14400)); // 36000 = 10 hours x 3600

putenv("TZ=US/Eastern");
define ('EST_TIME_NOW', date('Y-m-d H:i:s')); // 36000 = 10 hours x 3600

// start the timer for the page parse time log
  define('PAGE_PARSE_START_TIME', microtime());

// set the level of error reporting
 error_reporting(E_ALL & ~E_NOTICE);

// check if register_globals is enabled.
// since this is a temporary measure this message is hardcoded. The requirement will be removed before 2.2 is finalized.
//  if (function_exists('ini_get')) {
 //   ini_get('register_globals') or exit('FATAL ERROR: register_globals is disabled in php.ini, please enable it!');
  //}

// Set the local configuration parameters - mainly for developers
  if (file_exists('includes/local/configure.php')) include('includes/local/configure.php');

// include server parameters
  require('includes/configure.php');


//@setlocale(LC_ALL, array('en_US.ISO8859-1', 'en_US.iso88591', 'enu_usa'));
//define('CHARSET', 'iso-8859-1'); 
define('CHARSET', 'UTF-8');
/*if (strlen(DB_SERVER) < 1) {
    if (is_dir('install')) {
      header('Location: install/index.php');
    }
  }*/

// define the project version
  define('PROJECT_VERSION', 'osc 2.2 ms2 b2s loaded');
/*
  switch ($_SERVER['SCRIPT_NAME']) {
    case '/login.php':
    case '/account.php':
    case '/logoff.php':
    case '/shopping_cart.php':

      define('HTTP_SERVER', 'https://www.healingcrystals.com'); // eg, http://localhost - should not be empty for productive servers
      define('HTTPS_SERVER', 'https://www.healingcrystals.com'); // eg, https://localhost - should not be empty for productive servers
      define('ENABLE_SSL', true);
      $request_type = 'SSL';

      break;
    
    default:
      define('HTTP_SERVER', 'http://www.healingcrystals.com'); // eg, http://localhost - should not be empty for productive servers
      define('HTTPS_SERVER', 'http://www.healingcrystals.com'); // eg, https://localhost - should not be empty for productive servers
      define('ENABLE_SSL', false);
      $request_type = 'NONSSL';
      break;
  }*/


// set the type of request (secure or not)
  $request_type = (getenv('HTTPS') == 'on') ? 'SSL' : 'NONSSL';

global $HTTP_SERVER_VARS;
// set php_self in the local scope
// set php_self in the local scope
  $PHP_SELF = (((strlen(ini_get('cgi.fix_pathinfo')) > 0) && ((bool)ini_get('cgi.fix_pathinfo') == false)) || !isset($HTTP_SERVER_VARS['SCRIPT_NAME'])) ? basename($HTTP_SERVER_VARS['PHP_SELF']) : basename($HTTP_SERVER_VARS['SCRIPT_NAME']);
  
  if (!isset($PHP_SELF)) $PHP_SELF = $HTTP_SERVER_VARS['PHP_SELF'];
  if ($PHP_SELF == '') $PHP_SELF = $_SERVER["PHP_SELF"];
  if ($PHP_SELF == '') $PHP_SELF = 'index.php';


  if ($request_type == 'NONSSL') {
    define('DIR_WS_CATALOG', DIR_WS_HTTP_CATALOG);
  } else {
    define('DIR_WS_CATALOG', DIR_WS_HTTPS_CATALOG);
  }

// include the list of project filenames
  require(DIR_WS_INCLUDES . 'filenames_mobile.php');

// include the list of project database tables
  require(DIR_WS_INCLUDES . 'database_tables.php');

// customization for the design layout
//define('BOX_WIDTH', 125); // how wide the boxes should be in pixels (default: 125)

// include the database functions
  require(DIR_WS_FUNCTIONS . 'database.php');

// make a connection to the database... now
  tep_db_connect() or die('Unable to connect to database server!');

// set the application parameters
  $configuration_query = tep_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
  while ($configuration = tep_db_fetch_array($configuration_query)) {
    define($configuration['cfgKey'], $configuration['cfgValue']);
  }

// if gzip_compression is enabled, start to buffer the output
  if ( (GZIP_COMPRESSION == 'true') && ($ext_zlib_loaded = extension_loaded('zlib')) && (PHP_VERSION >= '4') ) {
    if (($ini_zlib_output_compression = (int)ini_get('zlib.output_compression')) < 1) {
      if (PHP_VERSION >= '4.0.4') {
        ob_start('ob_gzhandler');
      } else {
        include(DIR_WS_FUNCTIONS . 'gzip_compression.php');
        ob_start();
        ob_implicit_flush();
      }
    } else {
      ini_set('zlib.output_compression_level', GZIP_LEVEL);
    }
  }
/*
// set the HTTP GET parameters manually if search_engine_friendly_urls is enabled
  if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') {
    if (strlen(getenv('PATH_INFO')) > 1) {
      $GET_array = array();
      $PHP_SELF = str_replace(getenv('PATH_INFO'), '', $PHP_SELF);
      $vars = explode('/', substr(getenv('PATH_INFO'), 1));
      for ($i=0, $n=sizeof($vars); $i<$n; $i++) {
        if (strpos($vars[$i], '[]')) {
          $GET_array[substr($vars[$i], 0, -2)][] = $vars[$i+1];
        } else {
          $HTTP_GET_VARS[$vars[$i]] = $vars[$i+1];
        }
        $i++;
      }

      if (sizeof($GET_array) > 0) {
        while (list($key, $value) = each($GET_array)) {
          $HTTP_GET_VARS[$key] = $value;
        }
      }
    }
  }
*/

// define general functions used application-wide
  require(DIR_WS_FUNCTIONS . 'general.php');
  require(DIR_WS_FUNCTIONS . 'html_output.php');
/* Comment By Rakesh
  if (strpos(basename($PHP_SELF), 'checkout') !== false && $_SERVER['HTTPS'] != 'on' && HTTP_SERVER != 'http://hc.tecz.com') {
    tep_redirect(tep_href_link(basename($PHP_SELF), tep_get_all_get_params(), 'SSL'));  
} */

/**   triasphera seo html */
if ((basename($PHP_SELF) == FILENAME_DEFAULT) && (strlen($HTTP_GET_VARS['cPath_name'])>0)){
#  echo "<pre>";   print_r($HTTP_GET_VARS);  echo "</pre>";
  $arr = preg_split ('/[\/]/', $HTTP_GET_VARS['cPath_name']);
//  $arr = explode("_", $HTTP_GET_VARS['cPath_name']);
  $cPath = '';
  $parent_id=0;
  $cPath = '';
  foreach ($arr as $cPath_name){
    if (strlen($cPath_name)>0){
//      $cPath_name = str_replace(urlencode('&'), '&', $cPath_name);
//      $cPath_name = str_replace(urlencode('#'), '#', $cPath_name);
  //      $cPath_name = str_replace(urlencode('/'), '/', $cPath_name);

      $res = tep_db_query("select c.categories_id from " . TABLE_CATEGORIES_DESCRIPTION . " cd, " . TABLE_CATEGORIES ." c where cd.categories_name like '" . $cPath_name . "' and cd.categories_id=c.categories_id and c.parent_id='".$parent_id."'");
      //$res = tep_db_query("select categories_id from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_name like '" . $cPath_name . "'");
      if ($d = tep_db_fetch_array($res)){
        $cPath .= '_' . $d['categories_id'];
        $parent_id = $d['categories_id'];
      } else {
        header("HTTP/1.1 404 Not Found");
  include('404.shtml');
  exit();
        break;
      }
    }
  }
  unset($HTTP_GET_VARS['cPath_name']);
  $HTTP_GET_VARS['cPath'] = substr($cPath, 1);
if ($cPath == '') {
 // tep_redirect('404.shtml');
  header("HTTP/1.1 404 Not Found");
  include('404.shtml');
  exit();
}

}

if (basename($PHP_SELF) == FILENAME_PRODUCT_INFO) {
 // echo "<pre>";   print_r($HTTP_GET_VARS);  echo "</pre>";
//exit();
  if ((strlen($HTTP_GET_VARS['product_name'])>0)){

//    $HTTP_GET_VARS['product_name'] = str_replace(urlencode('&'), '&', $HTTP_GET_VARS['product_name']);
//    $HTTP_GET_VARS['product_name'] = str_replace(urlencode('#'), '#', $HTTP_GET_VARS['product_name']);
//    $HTTP_GET_VARS['product_name'] = str_replace(urlencode('/'), '/', $HTTP_GET_VARS['product_name']);


	if (preg_match("/image(\d+)/", $HTTP_GET_VARS['product_name'], $matches)){
			$HTTP_GET_VARS['product_name'] = str_replace($matches[0], '', $HTTP_GET_VARS['product_name']);
			$HTTP_GET_VARS['image'] = $matches[1];
                        $imagepos = strrpos($HTTP_GET_VARS['product_name'], '_');
                        $imagevar = substr($HTTP_GET_VARS['product_name'], $imagepos+1, strlen($HTTP_GET_VARS['product_name']));
                        if (is_numeric($imagevar) and $imagevar <= 10) {
                            $HTTP_GET_VARS['image'] = $imagevar;
                            $HTTP_GET_VARS['product_name'] = substr($HTTP_GET_VARS['product_name'], 0, $imagepos);
                          }
		}




    $res = tep_db_query("select p.products_id from products p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and products_head_title_tag like '" . $HTTP_GET_VARS['product_name'] . "'");
    if ($d = tep_db_fetch_array($res)){
      unset($HTTP_GET_VARS['product_name']);
      $HTTP_GET_VARS['products_id'] = $d['products_id'];
    } else {
        $res_old = tep_db_query("select p.products_id from products p, product_x_name pxn where p.products_id = pxn.products_id and pxn.product_name like '" . $HTTP_GET_VARS['product_name'] . "'");
        if ($d = tep_db_fetch_array($res_old)){
          unset($HTTP_GET_VARS['product_name']);
          $HTTP_GET_VARS['products_id'] = $d['products_id'];
          $languages_id = '1';
          //echo 'hiiii';
          //echo tep_href_link('product_info.php','products_id='.$d['products_id']);
          //exit();
            header( "HTTP/1.1 301 Moved Permanently" );
            header( "Location:".tep_href_link('product_info.php','products_id='.$d['products_id']));
        } else {
    //tep_redirect('404.shtml');
            header("HTTP/1.1 404 Not Found");
            include('404.shtml');
            exit();
        }
    
    }
  } elseif (strlen($HTTP_GET_VARS['product_def'])>0){
    $arr = explode("/", $HTTP_GET_VARS['product_def']);
		if (preg_match("/image(\d+)/", $arr[1], $matches)){
			$arr[1] = str_replace($matches[0], '', $arr[1]);
			$HTTP_GET_VARS['image'] = $matches[1];
		}

$imagepos = strrpos($arr[1], '_');
$imagevar = substr($arr[1], $imagepos+1, strlen($arr[1]));
if (is_numeric($imagevar) and $imagevar <= 10) {
    $HTTP_GET_VARS['image'] = $imagevar;
    $arr[1] = substr($arr[1], 0, $imagepos);
  }

    $res = tep_db_query("select p.products_id from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p, " . TABLE_MANUFACTURERS . " m where m.manufacturers_id=p.manufacturers_id and pd.products_id=p.products_id and pd.products_head_title_tag like '" . $arr[1] . "'");
    if ($d = tep_db_fetch_array($res)){
      unset($HTTP_GET_VARS['product_def']);
      $HTTP_GET_VARS['products_id'] = $d['products_id'];
    } else {
  header("HTTP/1.1 404 Not Found");
  include('404.shtml');
  exit();
//  tep_redirect(tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'inc_subcat=1&search_in_description=1&keywords=' . $arr[1]));
    }
  }
}

if ((strlen($HTTP_GET_VARS['linkcat_name'])>0)){
  $link_categories_query = tep_db_query("select link_categories_id from " . TABLE_LINK_CATEGORIES_DESCRIPTION . " where link_categories_name like '" . $HTTP_GET_VARS['linkcat_name'] . "'");
   if ($d = tep_db_fetch_array($link_categories_query)){
      unset($HTTP_GET_VARS['linkcat_name']);
      $HTTP_GET_VARS['lPath'] = $d['link_categories_id'];
    } else {
//tep_redirect('404.shtml');
echo $HTTP_GET_VARS['linkcat_name'];
  //header("HTTP/1.1 404 Not Found");
  //include('404.shtml');
  exit();
    }
 }

// set the cookie domain
  $cookie_domain = (($request_type == 'NONSSL') ? HTTP_COOKIE_DOMAIN : HTTPS_COOKIE_DOMAIN);
  $cookie_path = (($request_type == 'NONSSL') ? HTTP_COOKIE_PATH : HTTPS_COOKIE_PATH);

// include cache functions if enabled
  if (USE_CACHE == 'true') include(DIR_WS_FUNCTIONS . 'cache.php');

// include shopping cart class
  require(DIR_WS_CLASSES . 'shopping_cart.php');

// include navigation history class
  require(DIR_WS_CLASSES . 'navigation_history.php');

// some code to solve compatibility issues
  require(DIR_WS_FUNCTIONS . 'compatibility.php');

// check if sessions are supported, otherwise use the php3 compatible session class
  if (!function_exists('session_start')) {
    define('PHP_SESSION_NAME', 'osCsid');
    define('PHP_SESSION_PATH', $cookie_path);
    define('PHP_SESSION_DOMAIN', $cookie_domain);
    define('PHP_SESSION_SAVE_PATH', SESSION_WRITE_DIRECTORY);

    include(DIR_WS_CLASSES . 'sessions.php');
  }

// define how the session functions will be used
  require(DIR_WS_FUNCTIONS . 'sessions.php');

// set the session name and save path
  tep_session_name('osCsid');
  tep_session_save_path(SESSION_WRITE_DIRECTORY);

// set the session cookie parameters
   if (function_exists('session_set_cookie_params')) {
    session_set_cookie_params(0, $cookie_path, $cookie_domain);
  } elseif (function_exists('ini_set')) {
    ini_set('session.cookie_lifetime', '0');
    ini_set('session.cookie_path', $cookie_path);
    ini_set('session.cookie_domain', $cookie_domain);
  }

// set the session ID if it exists
   if (isset($HTTP_POST_VARS[tep_session_name()])) {
     tep_session_id($HTTP_POST_VARS[tep_session_name()]);
   } elseif ( ($request_type == 'SSL') && isset($HTTP_GET_VARS[tep_session_name()]) ) {
     tep_session_id($HTTP_GET_VARS[tep_session_name()]);
   }

// start the session
  $session_started = false;
  if (SESSION_FORCE_COOKIE_USE == 'True') {
    tep_setcookie('cookie_test', 'please_accept_for_session', time()+60*60*24*30, $cookie_path, $cookie_domain);

    if (isset($HTTP_COOKIE_VARS['cookie_test'])) {
      tep_session_start();
      $session_started = true;
    }
  } elseif (SESSION_BLOCK_SPIDERS == 'True') {
    $user_agent = strtolower(getenv('HTTP_USER_AGENT'));
    $spider_flag = false;

    if (tep_not_null($user_agent)) {
      $spiders = file(DIR_WS_INCLUDES . 'spiders.txt');

      for ($i=0, $n=sizeof($spiders); $i<$n; $i++) {
        if (tep_not_null($spiders[$i])) {
          if (is_integer(strpos($user_agent, trim($spiders[$i])))) {
            $spider_flag = true;
            break;
          }
        }
      }
    }

    if ($spider_flag == false) {
      tep_session_start();
      $session_started = true;
    }
  } else {
    tep_session_start();
    $session_started = true;
  }

// set SID once, even if empty
  $SID = (defined('SID') ? SID : '');

// verify the ssl_session_id if the feature is enabled
  if ( ($request_type == 'SSL') && (SESSION_CHECK_SSL_SESSION_ID == 'True') && (ENABLE_SSL == true) && ($session_started == true)) {
    $ssl_session_id = getenv('SSL_SESSION_ID');
    if (!tep_session_is_registered('SSL_SESSION_ID')) {
      $SESSION_SSL_ID = $ssl_session_id;
      tep_session_register('SESSION_SSL_ID');
    }

    if ($SESSION_SSL_ID != $ssl_session_id) {
      tep_session_destroy();
      tep_redirect(tep_href_link(FILENAME_SSL_CHECK));
    }
  }

// verify the browser user agent if the feature is enabled
  if (SESSION_CHECK_USER_AGENT == 'True') {
    $http_user_agent = getenv('HTTP_USER_AGENT');
    if (!tep_session_is_registered('SESSION_USER_AGENT')) {
      $SESSION_USER_AGENT = $http_user_agent;
      tep_session_register('SESSION_USER_AGENT');
    }

    if ($SESSION_USER_AGENT != $http_user_agent) {
      tep_session_destroy();
      tep_redirect(tep_href_link(FILENAME_LOGIN));
    }
  }

// verify the IP address if the feature is enabled
  if (SESSION_CHECK_IP_ADDRESS == 'True') {
    $ip_address = tep_get_ip_address();
    if (!tep_session_is_registered('SESSION_IP_ADDRESS')) {
      $SESSION_IP_ADDRESS = $ip_address;
      tep_session_register('SESSION_IP_ADDRESS');
    }
/*
    if ($SESSION_IP_ADDRESS != $ip_address) {
      tep_session_destroy();
      tep_redirect(tep_href_link(FILENAME_LOGIN));
    }
*/
  }

// create the shopping cart & fix the cart if necesary
  if (tep_session_is_registered('cart') && is_object($cart)) {
    if (PHP_VERSION < 4) {
      $broken_cart = $cart;
      $cart = new shoppingCart;
      $cart->unserialize($broken_cart);
    }
  } else {
  	//tep_db_query("delete from `sessions` where expiry < '" . (time()-604800) . "'");
    
    tep_session_register('cart');
    $cart = new shoppingCart;
  }

// include currencies class and create an instance
  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

// include the mail classes
  require(DIR_WS_CLASSES . 'mime.php');
  require(DIR_WS_CLASSES . 'email.php');

// set the language
  if (!tep_session_is_registered('language') || isset($HTTP_GET_VARS['language'])) {
    if (!tep_session_is_registered('language')) {
      tep_session_register('language');
      tep_session_register('languages_id');
    }

    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language();

    if (isset($HTTP_GET_VARS['language']) && tep_not_null($HTTP_GET_VARS['language'])) {
      $lng->set_language($HTTP_GET_VARS['language']);
    } else {
      $lng->get_browser_language();
    }

    $language = $lng->language['directory'];
    $languages_id = $lng->language['id'];
  }

// Lango added for template BOF:
  require(DIR_WS_INCLUDES . 'template_application_top_mobile.php');
// Lango added for template EOF:

// include the language translations
  require(DIR_WS_LANGUAGES . $language . '.php');

// currency
  if (!tep_session_is_registered('currency') || isset($HTTP_GET_VARS['currency']) || ( (USE_DEFAULT_LANGUAGE_CURRENCY == 'true') && (LANGUAGE_CURRENCY != $currency) ) ) {
    if (!tep_session_is_registered('currency')) tep_session_register('currency');

    if (isset($HTTP_GET_VARS['currency'])) {
      if (!$currency = tep_currency_exists($HTTP_GET_VARS['currency'])) $currency = (USE_DEFAULT_LANGUAGE_CURRENCY == 'true') ? LANGUAGE_CURRENCY : DEFAULT_CURRENCY;
    } else {
      $currency = (USE_DEFAULT_LANGUAGE_CURRENCY == 'true') ? LANGUAGE_CURRENCY : DEFAULT_CURRENCY;
    }
  }

// navigation history
  if (tep_session_is_registered('navigation')) {
    if (PHP_VERSION < 4) {
      $broken_navigation = $navigation;
      $navigation = new navigationHistory;
      $navigation->unserialize($broken_navigation);
    }
  } else {
    tep_session_register('navigation');
    $navigation = new navigationHistory;
  }
  $navigation->add_current_page();

// BOF: Down for Maintenance except for admin ip
if (EXCLUDE_ADMIN_IP_FOR_MAINTENANCE != getenv('REMOTE_ADDR')){
	if (DOWN_FOR_MAINTENANCE=='true' and !strstr($PHP_SELF,DOWN_FOR_MAINTENANCE_FILENAME)) { tep_redirect(tep_href_link(DOWN_FOR_MAINTENANCE_FILENAME)); }
	}
// do not let people get to down for maintenance page if not turned on
if (DOWN_FOR_MAINTENANCE=='false' and strstr($PHP_SELF,DOWN_FOR_MAINTENANCE_FILENAME)) {
    tep_redirect(tep_href_link(FILENAME_DEFAULT));
}
// EOF: WebMakers.com Added: Down for Maintenance


// BOF: WebMakers.com Added: Functions Library
    include(DIR_WS_FUNCTIONS . 'webmakers_added_functions.php');
// EOF: WebMakers.com Added: Functions Library
if(isset($HTTP_GET_VARS['language'])){
	$url =  explode('?&language=' , $_SERVER['REQUEST_URI']); 
	  header( "HTTP/1.1 301 Moved Permanently" );
      header( "Location:".$url[0] ); 
}
// Shopping cart actions

  if (isset($HTTP_GET_VARS['action'])) {
// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled
    if ($session_started == false) {
      tep_redirect(tep_href_link(FILENAME_COOKIE_USAGE));
    }
//* 2-MAY-2012, (MA) add ability for customers to easily reorder , #557 , Bof
    if (DISPLAY_CART == 'true' && basename($PHP_SELF)!='account_history_info_mobile.php') {
      $goto =  'shopping_cart_mobile.php';
	  if($HTTP_GET_VARS['order_id']!=''){
		$goto='account_history_info_mobile.php';
	  	$parameters = array('action', 'cPath', 'products_id', 'pid', 'image', 'order_id');
	  }else{
      $parameters = array('action', 'cPath', 'products_id', 'pid', 'image');
	  }
//* 2-MAY-2012, (MA) add ability for customers to easily reorder , #557 , Eof
    } else {
      $goto = basename($PHP_SELF);
      if ($HTTP_GET_VARS['action'] == 'buy_now') {
        $parameters = array('action', 'pid', 'products_id');
      } else {
        $parameters = array('action', 'pid');
      }
    }
//		echo '<pre>';print_r( $HTTP_POST_VARS );echo '</pre>';
//		die('Test');
    switch ($HTTP_GET_VARS['action']) {
      // customer wants to update the product quantity in their shopping cart
      case 'add_wishlist' :  if(!empty($_SESSION['wishlist_variables'])){
									  foreach($_SESSION['wishlist_variables'] as $wKey => $wValue){
										$HTTP_POST_VARS[$wKey] = $wValue;
									  }
									$_SESSION['wishlist_variables'] = '';
							  }
	  						  if (preg_match('/^[0-9]+$/', $HTTP_POST_VARS['products_id'])) {
     
	                              if ($HTTP_POST_VARS['products_id']) {
                                  if ($customer_id > 0) {
								  
								  
								    // Queries below replace old product instead of adding to queatity.
								
                                   /* tep_db_query("delete from " . TABLE_WISHLIST . " where products_id = '" . $HTTP_POST_VARS['products_id'] . "' and customers_id = '" . $customer_id . "'");*/
								   $products_total_query = tep_db_query("select count(*) as total from " . TABLE_WISHLIST . " where products_id = '" . $HTTP_POST_VARS['products_id'] . "' and customers_id = '" . $customer_id . "' ");
								$products_total = tep_db_fetch_array($products_total_query);
    if (!($products_total['total'] > 0)) {
                                    tep_db_query("insert into " . TABLE_WISHLIST . " (customers_id, products_id, products_model, products_name, products_price) values ('" . $customer_id . "', '" . $HTTP_POST_VARS['products_id'] . "', '" . $HTTP_POST_VARS['products_model'] . "', '" . $HTTP_POST_VARS['products_name'] . "', '" . $HTTP_POST_VARS['products_price'] . "' )");
									}
                                   /* tep_db_query("delete from " . TABLE_WISHLIST_ATTRIBUTES . " where products_id = '" . $HTTP_POST_VARS['products_id'] . "' and customers_id = '" . $customer_id . "'");*/
                                    // Read array of options and values for attributes in id[]
                                    if ( !($HTTP_POST_VARS['qty'] > 0) ) $HTTP_POST_VARS['qty'] = 1;
									if (isset($HTTP_GET_VARS['uprid']) && !isset($HTTP_POST_VARS['id'])) {
										$p_id_array = explode('{', $HTTP_GET_VARS['uprid']);
								  		$att_array = explode('}', $p_id_array[1]);
										$HTTP_POST_VARS['id'][$att_array['0']] = $att_array['1'];							
									}
									 
                                    if (isset ($HTTP_POST_VARS['id'])) {
                                      foreach($HTTP_POST_VARS['id'] as $att_option=>$att_value) {
									  
									  $products_total_query = tep_db_query("select count(*) as total from " . TABLE_WISHLIST_ATTRIBUTES . " where products_id = '" . $HTTP_POST_VARS['products_id'] . "' and customers_id = '" . $customer_id . "' and products_options_id = '" . $att_option . "' and products_options_value_id = '" . $att_value ."' ");
								$products_attributes = tep_db_fetch_array($products_total_query);
    							if ($products_attributes['total'] > 0) {								
								
								 tep_db_query("update " . TABLE_WISHLIST_ATTRIBUTES . " set product_options_quantity = " . $HTTP_POST_VARS['qty'] . " where products_id = '" . $HTTP_POST_VARS['products_id'] . "' and customers_id = '" . $customer_id . "' and products_options_id = '" . $att_option . "' and products_options_value_id = '" . $att_value ."' ");
								} else {
								        // Add to customers_wishlist_attributes table
                                        tep_db_query("insert into " . TABLE_WISHLIST_ATTRIBUTES . " (customers_id, products_id, products_options_id , products_options_value_id, product_options_quantity) values ('" . $customer_id . "', '" . $HTTP_POST_VARS['products_id'] . "', '" . $att_option . "', '" . $att_value . "', '" . $HTTP_POST_VARS['qty'] ."' )");
								}
                                      }
                                    }
                                    if($HTTP_GET_VARS['oos']=='true'){
                                    	$check_notify_query = tep_db_query('select * from stock_notification_to_products sp, stock_notification_list sl where sp.stock_notification_list_id = sl.stock_notification_list_id and sl.customers_id="' . $customer_id .'" and sp.products_id="' . $HTTP_POST_VARS['products_id'] .'" and sp.email_sent = "0"');
										if(!tep_db_num_rows($check_notify_query)){
											
											$oos_wishlist_cust_data = array(
											'customers_id'=>$customer_id,
											

											'customers_name' => get_customers_name($customer_id),
											'customers_email_address' => get_customers_email($customer_id),
											'date_added' => 'now()');
											
											tep_db_perform('stock_notification_list',$oos_wishlist_cust_data);
											$listid = tep_db_insert_id();
											
											$oos_wishlist_prod_data = array(
											'stock_notification_list_id'=>$listid,
											'products_id' => $HTTP_POST_VARS['products_id'],
											'email_sent' => '0');

											tep_db_perform('stock_notification_to_products', $oos_wishlist_prod_data);	
																					
		                                }
										$_SESSION['oosProList'][] = $HTTP_POST_VARS['products_id'];
										tep_redirect(tep_href_link('product_info.php','products_id='.$HTTP_POST_VARS['products_id'].'&show_message=2'));
                                    }									
                                  }else{
								  $navigation->set_snapshot();
							
								tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
        						//	if($HTTP_GET_VARS['oos']=='true'){
        							//	tep_redirect(tep_href_link('visitor_wishlist.php',tep_get_all_get_params()));
									//}	
									
                                  }
								  tep_redirect(tep_href_link('shopping_cart_mobile.php'));

                                }
                              }
                              break;
	  case 'add_to_wishlist':
		  
                                if ($HTTP_GET_VARS['products_id']) {
                                  if ($customer_id > 0) {
								  $p_id_array = explode('{', $HTTP_GET_VARS['products_id']);
								  $p_id = $p_id_array[0];
								  $att_array = explode('}', $p_id_array[1]);
								  $opt_id = $att_array['0'];
								  $ov_id = $att_array['1'];
								  
								  $products_total_query = tep_db_query("select count(*) as total from " . TABLE_WISHLIST . " where products_id = '" . $p_id . "' and customers_id = '" . $customer_id . "' ");
								$products_total = tep_db_fetch_array($products_total_query);
    if (!($products_total['total'] > 0)) {
	

									$pro_query = tep_db_query("select p.products_model, p.products_price, pd.products_name from products p, products_description pd where p.products_id = pd.products_id and p.products_id = '".$p_id."' and pd.language_id = '".$languages_id."'");
									$prod_array = tep_db_fetch_array($pro_query);

                                    tep_db_query("insert into " . TABLE_WISHLIST . " (customers_id, products_id, products_model, products_name, products_price) values ('" . $customer_id . "', '" . $p_id . "', '" . $prod_array['products_model'] . "', '" . $prod_array['products_name'] . "', '" . $prod_array['products_price'] . "' )");
									}
								    // Queries below replace old product instead of adding to queatity.
									//$pro_query = tep_db_query("select p.products_model, p.products_price, pd.products_name from products p, products_description pd where p.products_id = pd.products_id and p.products_id = '".$p_id."' and pd.language_id = '".$languages_id."'");
									//$prod_array = tep_db_fetch_array($pro_query);
                                   // tep_db_query("delete from " . TABLE_WISHLIST . " where products_id = '" . $p_id . "' and customers_id = '" . $customer_id . "'");
                                   // tep_db_query("insert into " . TABLE_WISHLIST . " (customers_id, products_id, products_model, products_name, products_price) values ('" . $customer_id . "', '" . $p_id . "', '" . $prod_array['products_model'] . "', '" . $prod_array['products_name'] . "', '" . $prod_array['products_price'] . "' )");
                                   // tep_db_query("delete from " . TABLE_WISHLIST_ATTRIBUTES . " where products_id = '" . $p_id . "' and customers_id = '" . $customer_id . "'");
                                    // Read array of options and values for attributes in id[]
                                    //if (isset ($p_id_array[1]) && ($p_id_array[1] != '')) {                                      
                                        // Add to customers_wishlist_attributes table
                                      //  tep_db_query("insert into " . TABLE_WISHLIST_ATTRIBUTES . " (customers_id, products_id, products_options_id , products_options_value_id) values ('" . $customer_id . "', '" . $p_id . "', '" . $opt_id . "', '" . $ov_id . "' )");
                                  $products_total_query = tep_db_query("select count(*) as total from " . TABLE_WISHLIST_ATTRIBUTES . " where products_id = '" . $p_id . "' and customers_id = '" . $customer_id . "' and products_options_id = '" . $opt_id . "' and products_options_value_id = '" . $ov_id ."' ");
								$products_attributes = tep_db_fetch_array($products_total_query);
    if ($products_attributes['total'] > 0) {								
								
								 tep_db_query("update " . TABLE_WISHLIST_ATTRIBUTES . " set product_options_quantity = " . $HTTP_GET_VARS['qty'] . " where products_id = '" . $p_id . "' and customers_id = '" . $customer_id . "' and products_options_id = '" . $opt_id . "' and products_options_value_id = '" . $ov_id ."' ");
								} else {
								        // Add to customers_wishlist_attributes table
                                        tep_db_query("insert into " . TABLE_WISHLIST_ATTRIBUTES . " (customers_id, products_id, products_options_id , products_options_value_id, product_options_quantity) values ('" . $customer_id . "', '" . $p_id . "', '" . $opt_id . "', '" . $ov_id . "', '" . $HTTP_GET_VARS['qty'] ."' )");
										} 
								     
                                  }else{
                                  	tep_redirect(tep_href_link($goto.'?message=login_message&products_id='.$HTTP_GET_VARS['products_id'], tep_get_all_get_params($parameters)));
                                  }
								   $cart->remove($HTTP_GET_VARS['products_id']);
								   //$_GET['message'] = 'added_to_wishlist';
								  // $parameters[] = 'message';
								   //var_dump($parameters);
									tep_redirect(tep_href_link($goto.'?message=added_to_wishlist&products_id='.$HTTP_GET_VARS['products_id'], tep_get_all_get_params($parameters)));
                                }
                             
                             
	  break;
	  case 'remove_domestic_only' :
	  		$cart->remove($HTTP_GET_VARS['pro_id']);
			tep_redirect(tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
			break;
      case 'remove_product' :
           $cart->remove($HTTP_GET_VARS['products_id']);
          // tep_redirect(tep_href_link($goto, tep_get_all_get_params($parameters)));
            
            break;
      case 'update_product' : 
                            if (isset($HTTP_POST_VARS['empty_cart']) && $HTTP_POST_VARS['empty_cart'] == 1){
                                    $cart->reset(true);
                            }else{
                                for ($i=0, $n=sizeof($HTTP_POST_VARS['products_id']); $i<$n; $i++) {
                                    if (in_array($HTTP_POST_VARS['products_id'][$i], (is_array($HTTP_POST_VARS['cart_delete']) ? $HTTP_POST_VARS['cart_delete'] : array()))) {
                                        $cart->remove($HTTP_POST_VARS['products_id'][$i]);
                                    } else {
                                      if (PHP_VERSION < 4) {
                                        // if PHP3, make correction for lack of multidimensional array.
                                        reset($HTTP_POST_VARS);
                                        while (list($key, $value) = each($HTTP_POST_VARS)) {
                                          if (is_array($value)) {
                                            while (list($key2, $value2) = each($value)) {
                                              //if (ereg ("(.*)\]\[(.*)", $key2, $var)) {
                                                 if (preg_match ("/(.*)\]\[(.*)/", $key2, $var)) {
                                                $id2[$var[1]][$var[2]] = $value2;
                                              }
                                            }
                                          }
                                        }
                                        $attributes = ($id2[$HTTP_POST_VARS['products_id'][$i]]) ? $id2[$HTTP_POST_VARS['products_id'][$i]] : '';
                                      } else {
                                        $attributes = ($HTTP_POST_VARS['id'][$HTTP_POST_VARS['products_id'][$i]]) ? $HTTP_POST_VARS['id'][$HTTP_POST_VARS['products_id'][$i]] : '';
                                      }
                                      if ($HTTP_POST_VARS['cart_quantity'][$i] == 0){
                                        $cart->remove($HTTP_POST_VARS['products_id'][$i]);
                                      }else{
                                            $array = explode('{',$HTTP_POST_VARS['products_id'][$i]);
                                            $array2 = explode('}',$array[1]);
                                            $check_unit_per_sale = check_unit_per_sale( (int)$array[0] , $array2[0], $array2[1] );
                                            if (tep_check_in_stock($HTTP_POST_VARS['products_id'][$i], $HTTP_POST_VARS['cart_quantity'][$i])){
                                                if($check_unit_per_sale != 0){
                                                    if($check_unit_per_sale >= $HTTP_POST_VARS['cart_quantity'][$i] ){
                                                        $cart->add_cart($HTTP_POST_VARS['products_id'][$i], $HTTP_POST_VARS['cart_quantity'][$i], $attributes, false);
                                                    }else{
                                                        $_SESSION['unit_per_sale_error'][$HTTP_POST_VARS['products_id'][$i]] = $check_unit_per_sale;
                                                        $cart->add_cart($HTTP_POST_VARS['products_id'][$i], $check_unit_per_sale, $attributes, false);
                                                    }
                                                }else{
                                                    $cart->add_cart($HTTP_POST_VARS['products_id'][$i], $HTTP_POST_VARS['cart_quantity'][$i], $attributes, false);
                                                }
                                            }else{
                                                $_SESSION['oos_prods_qty'][$HTTP_POST_VARS['products_id'][$i]] = $HTTP_POST_VARS['cart_quantity'][$i];
                                                                                    //bof
                                                $sel_qty = tep_get_products_stock($HTTP_POST_VARS['products_id'][$i]);
                                                $array = explode('{',$HTTP_POST_VARS['products_id'][$i]);
                                                $array2 = explode('}',$array[1]);
                                                $linked_product_query=tep_db_query("select child_products_id , child_options_id, child_options_values_id from linked_products_options where parent_products_id = '".$array[0]."' and parent_options_id = '".$array2[0]."' and parent_options_values_id ='".$array2[1]."'");
                                                if(tep_db_num_rows($linked_product_query)){
                                                    while($linked_product=tep_db_fetch_array($linked_product_query)){										
                                                        $uprid=$linked_product['child_products_id'].'{'.$linked_product['child_options_id'].'}'.$linked_product['child_options_values_id'];
                                                        $linked_qty = tep_get_products_stock($uprid);
                                                        if($sel_qty > $linked_qty){
                                                            $sel_qty = $linked_qty;
                                                        }
                                                    }
                                                }

                                                $cart->add_cart($HTTP_POST_VARS['products_id'][$i], $sel_qty, $attributes, false);
                                                                                    //eof 
                                            }
                                        }
                                    }
                                }
                            }

                           // tep_redirect(tep_href_link($goto, //tep_get_all_get_params($parameters))); Eup
                            break;

      case 'add_product' :  if (isset($HTTP_POST_VARS['products_id']) && is_numeric($HTTP_POST_VARS['products_id'])) {												
          //echo '<pre>';print_r( $HTTP_POST_VARS );echo '</pre>';
              //exit();                  
          foreach($HTTP_POST_VARS['id'] as $key => $value){
                                    $po_id = $key;
                                    $pov_id = $value;
                                }
                                if (tep_session_is_registered('customer_id')) {
                                  tep_delete_wishlist($customer_id, $HTTP_POST_VARS['products_id'] , $po_id, $pov_id );
                                }
                                if ( !($HTTP_POST_VARS['qty'] > 0) ) $HTTP_POST_VARS['qty'] = 1;
                                    if (tep_check_in_stock(tep_get_uprid($HTTP_POST_VARS['products_id'], $HTTP_POST_VARS['id']), $HTTP_POST_VARS['qty'])){
                                        $check_unit_per_sale = check_unit_per_sale((int)$HTTP_POST_VARS['products_id'], $po_id, $pov_id);
                                        if($check_unit_per_sale != 0){
                                            if($check_unit_per_sale >= $HTTP_POST_VARS['qty'] ){
                                                $cart->add_cart($HTTP_POST_VARS['products_id'], $HTTP_POST_VARS['qty'], $HTTP_POST_VARS['id'],true, $HTTP_POST_VARS['price']);
                                            }else{
                                                $_SESSION['unit_per_sale_error'][$HTTP_POST_VARS['products_id']] = $check_unit_per_sale;
                                                $cart->add_cart($HTTP_POST_VARS['products_id'], $check_unit_per_sale, $HTTP_POST_VARS['id'],true, $HTTP_POST_VARS['price']);
                                            }
                                        }else{
                                            $cart->add_cart($HTTP_POST_VARS['products_id'], $cart->get_quantity(tep_get_uprid($HTTP_POST_VARS['products_id'], $HTTP_POST_VARS['id'])) + $HTTP_POST_VARS['qty'], $HTTP_POST_VARS['id'],true, $HTTP_POST_VARS['price']);
                                        }                                    
                                    } else{
                                        tep_session_register('oos_uprid');
                                        tep_session_register('oos_qty');
                                        $oos_uprid = tep_get_uprid($HTTP_POST_VARS['products_id'], $HTTP_POST_VARS['id']);
                                        $oos_qty = $HTTP_POST_VARS['qty'];
                                        $_SESSION['oos_uprid'] = $oos_uprid;
                                        $_SESSION['oos_qty'] = $oos_qty;
                                        tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params($parameters) . '&products_id='.$HTTP_POST_VARS['products_id'].'&error=oos&show_message=1', 'NONSSL'));
                                    }
                              }
                              if(isset($HTTP_GET_VARS['order_id']) && $HTTP_GET_VARS['order_id'] != ''){
                                    $param_str=tep_get_all_get_params($parameters).'&order_id='.$HTTP_GET_VARS['order_id'];
                              }else{
                                    $param_str=tep_get_all_get_params($parameters);
                              }

                              tep_redirect(tep_href_link($goto, $param_str, 'NONSSL'));
                              break;
      case 'quick_add_product' :        
                              
	  
	  if (isset($_GET['products_id']) && is_numeric($_GET['products_id'])) {
													//	echo 'Here';
												//		echo '<pre>';print_r( $HTTP_GET_VARS );echo '</pre>';
     	

                                if ( !($_GET['qty'] > 0) ) $_GET['qty'] = 1;
					if (tep_check_in_stock(tep_get_uprid($_GET['products_id'], $_GET['ovid']), $HTTP_POST_VARS['qty'])){
	                                $cart->add_cart($_GET['products_id'], $cart->get_quantity(tep_get_uprid($_GET['products_id'], $_GET['ovid'])) + $_GET['qty'], $_GET['ovid']);
				} else{
																	//tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params($parameters) . '&products_id='.$HTTP_POST_VARS['products_id'].'&error=oos&qty='.$HTTP_POST_VARS['qty'].'&pID='.tep_get_uprid($HTTP_POST_VARS['products_id'], $HTTP_POST_VARS['id']), 'NONSSL'));
                                    tep_session_register('oos_uprid');
                                    tep_session_register('oos_qty');
                                    $oos_uprid = tep_get_uprid($_GET['products_id'], $_GET['ovid']);
                                    $oos_qty = $_GET['qty'];
                                 }
                              }
                              tep_redirect(tep_href_link('quick_order.php'));
                              break;
                              
   case 'add_label' :    if (isset($HTTP_GET_VARS['pid'])) {														
	                         $cart->add_cart($HTTP_GET_VARS['pid'], '1', array('1'=>'1'));
																
                              }
                              //tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
                              break;
                              
 case 'remove_label' :
           $cart->remove($HTTP_GET_VARS['pid'].'{1}1');
          // tep_redirect(tep_href_link(FILENAME_SHOPPING_CART));
            
            break;
      // performed by the 'buy now' button in product listings and review page
      case 'buy_now' :        if (isset($HTTP_GET_VARS['products_id'])) {
       // Wish List 2.3 Start
                                if (tep_session_is_registered('customer_id')) {
                                  tep_db_query("delete from " . TABLE_WISHLIST . " WHERE customers_id=$customer_id AND products_id=$products_id");
                                  tep_db_query("delete from " . TABLE_WISHLIST_ATTRIBUTES . " WHERE customers_id=$customer_id AND products_id=$products_id");
                                }
                                // Wish List 2.3 End
$products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . $HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' ");
       $products_attributes = tep_db_fetch_array($products_attributes_query);
       if ($products_attributes['total'] > 1) {

                               // if (tep_has_product_attributes($HTTP_GET_VARS['products_id'])) {
                                  tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $HTTP_GET_VARS['products_id']));
                                } else {
                                  if ( !($HTTP_POST_VARS['qty'] > 0) ) $HTTP_POST_VARS['qty'] = 1;
if ($products_attributes['total'] = 1) {
  $products_options = tep_db_query("select pa.options_id, pa.options_values_id from " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $HTTP_GET_VARS['products_id'] . "'");
$products_options_values = tep_db_fetch_array($products_options);
$option = array();
$option = array($products_options_values['options_id']=>$products_options_values['options_values_id']);

if (tep_check_in_stock(tep_get_uprid($HTTP_GET_VARS['products_id'], $option), $HTTP_POST_VARS['qty'])){
 $cart->add_cart($HTTP_GET_VARS['products_id'],$cart->get_quantity(tep_get_uprid($HTTP_GET_VARS['products_id'], $option)) + $HTTP_POST_VARS['qty'], $option);
  } else{
  tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params($parameters) . '&products_id='.$HTTP_GET_VARS['products_id'].'&error=oos', 'NONSSL'));
   }
  
} else {
  if (tep_check_in_stock(tep_get_uprid($HTTP_GET_VARS['products_id']), $HTTP_POST_VARS['qty'])){
    $cart->add_cart($HTTP_GET_VARS['products_id'], $cart->get_quantity($HTTP_GET_VARS['products_id']) + $HTTP_POST_VARS['qty']);
} else{
  tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params($parameters) . '&products_id='.$HTTP_GET_VARS['products_id'].'&error=oos', 'NONSSL'));
   }
  }
                                }
                              }
                              tep_redirect(tep_href_link($goto, tep_get_all_get_params($parameters)));
                              break;

      case 'notify' :         if (tep_session_is_registered('customer_id')) {
                                if (isset($HTTP_GET_VARS['products_id'])) {
                                  $notify = $HTTP_GET_VARS['products_id'];
                                } elseif (isset($HTTP_GET_VARS['notify'])) {
                                  $notify = $HTTP_GET_VARS['notify'];
                                } elseif (isset($HTTP_POST_VARS['notify'])) {
                                  $notify = $HTTP_POST_VARS['notify'];
                                } else {
                                  tep_redirect(tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action', 'notify'))));
                                }
                                if (!is_array($notify)) $notify = array($notify);
                                for ($i=0, $n=sizeof($notify); $i<$n; $i++) {
                                  $check_query = tep_db_query("select count(*) as count from " . TABLE_PRODUCTS_NOTIFICATIONS . " where products_id = '" . $notify[$i] . "' and customers_id = '" . $customer_id . "'");
                                  $check = tep_db_fetch_array($check_query);
                                  if ($check['count'] < 1) {
                                    tep_db_query("insert into " . TABLE_PRODUCTS_NOTIFICATIONS . " (products_id, customers_id, date_added) values ('" . $notify[$i] . "', '" . $customer_id . "', now())");
                                  }
                                }
                                tep_redirect(tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action', 'notify'))));
                              } else {
                                $navigation->set_snapshot();
                                tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
                              }
                              break;
      case 'notify_remove' :  if (tep_session_is_registered('customer_id') && isset($HTTP_GET_VARS['products_id'])) {
                                $check_query = tep_db_query("select count(*) as count from " . TABLE_PRODUCTS_NOTIFICATIONS . " where products_id = '" . $HTTP_GET_VARS['products_id'] . "' and customers_id = '" . $customer_id . "'");
                                $check = tep_db_fetch_array($check_query);
                                if ($check['count'] > 0) {
                                  tep_db_query("delete from " . TABLE_PRODUCTS_NOTIFICATIONS . " where products_id = '" . $HTTP_GET_VARS['products_id'] . "' and customers_id = '" . $customer_id . "'");
                                }
                                tep_redirect(tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action'))));
                              } else {
                                $navigation->set_snapshot();
                                tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
                              }
                              break;


/*
      case 'cust_order' :     if (tep_session_is_registered('customer_id') && isset($HTTP_GET_VARS['pid'])) {
                                if (tep_has_product_attributes($HTTP_GET_VARS['pid'])) {
                                  tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $HTTP_GET_VARS['pid']));
                                } else {
                                  $cart->add_cart($HTTP_GET_VARS['pid'], $cart->get_quantity($HTTP_GET_VARS['pid'])+1);
                                }
                              }
                              tep_redirect(tep_href_link($goto, tep_get_all_get_params($parameters)));
                              break;
*/
      case 'cust_order' :     if (tep_session_is_registered('customer_id') && isset($HTTP_GET_VARS['pid'])) {
// Wish List 2.3 Start
                               /* tep_db_query("delete from " . TABLE_WISHLIST . " where products_id = '" . $HTTP_GET_VARS['pid'] . "' and customers_id = '" . $customer_id . "'");*/

                                // Wish List 2.3 End

                              //if (tep_has_product_attributes($HTTP_GET_VARS['pid'])) {
							  //$wishlistAttributesQuery = tep_db_query("select * from " . TABLE_WISHLIST_ATTRIBUTES . " WHERE customers_id='".$customer_id."' AND products_id= '" . $HTTP_GET_VARS['pid'] . "'");
							  //if(tep_db_num_rows($wishlistAttributesQuery)){
							  	//$wishlistAttributesArray = tep_db_fetch_array($wishlistAttributesQuery);
							  	/*tep_db_query("delete from " . TABLE_WISHLIST_ATTRIBUTES . " WHERE customers_id='".$customer_id."' AND products_id='" . $HTTP_GET_VARS['pid']."'");*/

								
								tep_delete_wishlist($customer_id, $HTTP_GET_VARS['pid'] , $HTTP_GET_VARS['po_id'], $HTTP_GET_VARS['pov_id']);

								if ( !($HTTP_GET_VARS['qty'] > 0) ) $HTTP_GET_VARS['qty'] = 1;
							  	
								if (tep_check_in_stock(tep_get_uprid($HTTP_GET_VARS['pid'],  array($HTTP_GET_VARS['po_id']=>$HTTP_GET_VARS['pov_id'])), $cart->get_quantity(tep_get_uprid($HTTP_GET_VARS['pid'], array($HTTP_GET_VARS['po_id']=>$HTTP_GET_VARS['pov_id']))) +(int)$HTTP_GET_VARS['qty'])){

								
								$cart->add_cart($HTTP_GET_VARS['pid'], $cart->get_quantity(tep_get_uprid($HTTP_GET_VARS['pid'], array($HTTP_GET_VARS['po_id']=>$HTTP_GET_VARS['pov_id']))) +(int)$HTTP_GET_VARS['qty'], array($HTTP_GET_VARS['po_id']=>$HTTP_GET_VARS['pov_id']));

							  	} else{
								tep_session_register('oos_uprid');
                                tep_session_register('oos_qty');
                                $oos_uprid = tep_get_uprid($HTTP_GET_VARS['pid'], array($HTTP_GET_VARS['po_id']=>$HTTP_GET_VARS['pov_id']));
                                $oos_qty = $HTTP_GET_VARS['qty'];
								tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params($parameters) . '&products_id='.$HTTP_GET_VARS['pid'].'&error=oos&show_message=1', 'NONSSL'));
                             }
						}else{
							  	tep_redirect(tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $HTTP_GET_VARS['pid'], 'NONSSL'));
  
                        }
                              
                              tep_redirect(tep_href_link($goto, tep_get_all_get_params($parameters), 'NONSSL'));
                              break;
//share wishlist
  case 'share_wishlist' : if (isset($HTTP_GET_VARS['pid'])) {

                               
							if(tep_session_is_registered('customer_id')){	
								tep_delete_wishlist($customer_id, $HTTP_GET_VARS['pid'] , $HTTP_GET_VARS['po_id'], $HTTP_GET_VARS['pov_id']);
							 }
							if ( !($HTTP_GET_VARS['qty'] > 0) ) $HTTP_GET_VARS['qty'] = 1;
							if (tep_check_in_stock(tep_get_uprid($HTTP_GET_VARS['pid'],  array($HTTP_GET_VARS['po_id']=>$HTTP_GET_VARS['pov_id'])), $cart->get_quantity(tep_get_uprid($HTTP_GET_VARS['pid'], array($HTTP_GET_VARS['po_id']=>$HTTP_GET_VARS['pov_id']))) +(int)$HTTP_GET_VARS['qty'])){
								$cart->add_cart($HTTP_GET_VARS['pid'], $cart->get_quantity(tep_get_uprid($HTTP_GET_VARS['pid'], array($HTTP_GET_VARS['po_id']=>$HTTP_GET_VARS['pov_id']))) +(int)$HTTP_GET_VARS['qty'], array($HTTP_GET_VARS['po_id']=>$HTTP_GET_VARS['pov_id']));
								//tep_session_register('cwa_id');
                                //tep_session_register('swp_id');
								//$_SESSION['cwa_id'][] = $HTTP_GET_VARS['cwa_id'];								
								//$cwa_id = $HTTP_GET_VARS['cwa_id'];
								$swpro_id = tep_get_uprid($HTTP_GET_VARS['pid'], array($HTTP_GET_VARS['po_id']=>$HTTP_GET_VARS['pov_id']));
								$_SESSION['cwa_id'][$HTTP_GET_VARS['cwa_id']] = $swpro_id;
							} else{
								tep_session_register('oos_uprid');
                                tep_session_register('oos_qty');
                                $oos_uprid = tep_get_uprid($HTTP_GET_VARS['pid'], array($HTTP_GET_VARS['po_id']=>$HTTP_GET_VARS['pov_id']));
                                $oos_qty = $HTTP_GET_VARS['qty'];
								tep_redirect(tep_href_link('my_wishlist_mobile.php', tep_get_all_get_params($parameters) . '&products_id='.$HTTP_GET_VARS['pid'].'&error=oos&show_message=1', 'NONSSL'));
                             }
						}else{
							  	tep_redirect(tep_href_link('my_wishlist_mobile.php', 'products_id=' . $HTTP_GET_VARS['pid'], 'NONSSL'));

  
                        }
                             echo $goto='my_wishlist_mobile.php';
                              tep_redirect(tep_href_link($goto, tep_get_all_get_params($parameters), 'NONSSL'));
                              break;
// Wish List 2.3 Start
// *****************************************
      // Remove item from the Wish List
      case 'remove_wishlist':
                              //tep_db_query("delete from " . TABLE_WISHLIST . " where products_id = '" . $HTTP_GET_VARS['pid'] . "' and customers_id = '" . $customer_id . "'");
                              //tep_db_query("delete from " . TABLE_WISHLIST_ATTRIBUTES . " WHERE customers_id=$customer_id AND products_id= '" . $HTTP_GET_VARS['pid'] . "'");
                              tep_delete_wishlist($customer_id, $HTTP_GET_VARS['pid'] , $HTTP_GET_VARS['po_id'], $HTTP_GET_VARS['pov_id']);
							  tep_redirect(tep_href_link('shopping_cart_mobile.php'));
                              break;
    } // end switch $HTTP_GET_VARS['action']
  } // end if is set $HTTP_GET_VARS['action']

  // Shopping cart actions through POST variables from forms
  if (isset($HTTP_POST_VARS['wishlist_action'])) {
    // redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled
    if ($session_started == false) {
      tep_redirect(tep_href_link(FILENAME_COOKIE_USAGE));
    }

    $goto = basename($PHP_SELF);
    switch ($HTTP_POST_VARS['wishlist_action']) {
      // Customer wants to update the product quantity in their shopping cart
      /*case 'add_wishlist' :  if (ereg('^[0-9]+$', $HTTP_POST_VARS['products_id'])) {
                                if ($HTTP_POST_VARS['products_id']) {
                                  if ($customer_id > 0) {
								    // Queries below replace old product instead of adding to queatity.
                                    tep_db_query("delete from " . TABLE_WISHLIST . " where products_id = '" . $HTTP_POST_VARS['products_id'] . "' and customers_id = '" . $customer_id . "'");
                                    tep_db_query("insert into " . TABLE_WISHLIST . " (customers_id, products_id, products_model, products_name, products_price) values ('" . $customer_id . "', '" . $HTTP_POST_VARS['products_id'] . "', '" . $HTTP_POST_VARS['products_model'] . "', '" . $HTTP_POST_VARS['products_name'] . "', '" . $HTTP_POST_VARS['products_price'] . "' )");
                                    tep_db_query("delete from " . TABLE_WISHLIST_ATTRIBUTES . " where products_id = '" . $HTTP_POST_VARS['products_id'] . "' and customers_id = '" . $customer_id . "'");
                                    // Read array of options and values for attributes in id[]
                                    if (isset ($id)) {
                                      foreach($id as $att_option=>$att_value) {
                                        // Add to customers_wishlist_attributes table
                                        tep_db_query("insert into " . TABLE_WISHLIST_ATTRIBUTES . " (customers_id, products_id, products_options_id , products_options_value_id) values ('" . $customer_id . "', '" . $products_id . "', '" . $att_option . "', '" . $att_value . "' )");
                                      }
                                    }
                                  }
                                }
                              }
                              break;*/

      case 'wishlist_add_cart' :if (preg_match('/^[0-9]+$/', $HTTP_POST_VARS['products_id'])) {
                                  if ($HTTP_POST_VARS['products_id']) {
                                  if ($customer_id > 0) {
                                    tep_db_query("delete from " . TABLE_WISHLIST . " where products_id = '" . $HTTP_POST_VARS['products_id'] . "' and customers_id = '" . $customer_id . "'");
                                    tep_db_query("delete from " . TABLE_WISHLIST_ATTRIBUTES . " where products_id = '" . $HTTP_POST_VARS['products_id'] . "' and customers_id = '" . $customer_id . "'");
                                    // Read array of options and values for attributes in id[]
                                    if (isset($HTTP_POST_VARS['products_id']) && is_numeric($HTTP_POST_VARS['products_id'])) {
                                       $cart->add_cart($HTTP_POST_VARS['products_id'], $cart->get_quantity(tep_get_uprid($HTTP_POST_VARS['products_id'], $HTTP_POST_VARS['id']))+1, $HTTP_POST_VARS['id']);
                                    }
                                    tep_redirect(tep_href_link($goto, tep_get_all_get_params($parameters)));
                                    break;
                                  }
                                }
                              }
                              break;

       // Wishlist Checkboxes
       case 'add_delete_products_wishlist': 
                                      if (isset($HTTP_POST_VARS['add_wishprod'])) {
                                         if ($HTTP_POST_VARS['borrar'] == 0) { 
										       // 'borrar' form variable refers to deleting products in array $add_wishprod[] from wishlist
                                               foreach ($HTTP_POST_VARS['add_wishprod'] as $value) {
                                                    if (preg_match('/^[0-9]+$/', $value)) {
                                                    $cart->add_cart($value, $cart->get_quantity(tep_get_uprid($value, $HTTP_POST_VARS['id'][$value]))+1, $HTTP_POST_VARS['id'][$value]);
                                                    tep_db_query("delete from " . TABLE_WISHLIST . " where products_id = $value and customers_id = '" . $customer_id . "'");
                                                    tep_db_query("delete from " . TABLE_WISHLIST_ATTRIBUTES . " where products_id = '$value' and customers_id = '" . $customer_id . "'");
                                                    }
                                               }
                                             tep_redirect(tep_href_link($goto, tep_get_all_get_params($parameters)));
                                         }
                                         if ($HTTP_POST_VARS['borrar'] == 1) {
                                               foreach ($HTTP_POST_VARS['add_wishprod'] as $value) {
                                                    if (preg_match('/^[0-9]+$/', $value)) {    
                                                     tep_db_query("delete from " . TABLE_WISHLIST . " where products_id = $value and customers_id = '" . $customer_id . "'");
                                                    tep_db_query("delete from " . TABLE_WISHLIST_ATTRIBUTES . " where products_id = '$value' and customers_id = '" . $customer_id . "'");
                                                   }
                                              }
                                             tep_redirect(tep_href_link(FILENAME_WISHLIST));
                                         }
                                      }
                                      break;

    } // end switch ($HTTP_POST_VARS['wishlist_action'])
  } // end isset($HTTP_POST_VARS)
// *****************************************
// Wish List 2.3 End

// include the who's online functions
  require(DIR_WS_FUNCTIONS . 'whos_online.php');
  tep_update_whos_online();

// include the password crypto functions
  require(DIR_WS_FUNCTIONS . 'password_funcs.php');

// include validation functions (right now only email address)
  require(DIR_WS_FUNCTIONS . 'validations.php');

// split-page-results
  require(DIR_WS_CLASSES . 'split_page_results.php');

  
  
  


// auto activate and expire banners
  require(DIR_WS_FUNCTIONS . 'banner.php');
  tep_activate_banners();
  tep_expire_banners();

// auto expire special products
  require(DIR_WS_FUNCTIONS . 'specials.php');
  tep_expire_specials();

// auto expire featured products
  require(DIR_WS_FUNCTIONS . 'featured.php');
  tep_expire_featured();

// calculate category path
  if (isset($HTTP_GET_VARS['cPath'])) {
    $cPath = $HTTP_GET_VARS['cPath'];
  } elseif (isset($HTTP_GET_VARS['products_id']) && !isset($HTTP_GET_VARS['manufacturers_id'])) {
    $cPath = tep_get_product_path($HTTP_GET_VARS['products_id']);
  } else {
    $cPath = '';
  }

  if (tep_not_null($cPath)) {
    $cPath_array = tep_parse_category_path($cPath);
    $cPath = implode('_', $cPath_array);
    $current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
  } else {
    $current_category_id = 0;
  }

// include the breadcrumb class and start the breadcrumb trail
  require(DIR_WS_CLASSES . 'breadcrumb.php');
  $breadcrumb = new breadcrumb;

 $breadcrumb->add(HEADER_TITLE_TOP, HTTP_SERVER);
 // $breadcrumb->add(STORE_NAME, tep_href_link(FILENAME_DEFAULT));

// add category names or the manufacturer name to the breadcrumb trail
  if (isset($cPath_array)) {
    for ($i=0, $n=sizeof($cPath_array); $i<$n; $i++) {
      $categories_query = tep_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$cPath_array[$i] . "' and language_id = '" . (int)$languages_id . "'");
      if (tep_db_num_rows($categories_query) > 0) {
        $categories = tep_db_fetch_array($categories_query);
        $breadcrumb->add($categories['categories_name'], tep_href_link(FILENAME_DEFAULT, 'cPath=' . implode('_', array_slice($cPath_array, 0, ($i+1)))));
      } else {
        break;
      }
    }
  } elseif (isset($HTTP_GET_VARS['manufacturers_id'])) {
    $manufacturers_query = tep_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . (int)$HTTP_GET_VARS['manufacturers_id'] . "'");
    if (tep_db_num_rows($manufacturers_query)) {
      $manufacturers = tep_db_fetch_array($manufacturers_query);
      $breadcrumb->add($manufacturers['manufacturers_name'], tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $HTTP_GET_VARS['manufacturers_id']));
    }
  }
  elseif (isset($HTTP_GET_VARS['show'])) {

      $breadcrumb->add(stripslashes($HTTP_GET_VARS['show']), tep_href_link(FILENAME_DEFAULT, 'show=' . $HTTP_GET_VARS['show']));

  }
  
// add the products model to the breadcrumb trail
  if (isset($HTTP_GET_VARS['products_id'])) {
    $model_query = tep_db_query("select products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and language_id = '" . (int)$languages_id . "'");
    if (tep_db_num_rows($model_query)) {
      $model = tep_db_fetch_array($model_query);
     $breadcrumb->add($model['products_name'], tep_href_link(FILENAME_PRODUCT_INFO, 'cPath=' . $cPath . '&products_id=' . $HTTP_GET_VARS['products_id']), ' > ');
    }
  }
  
  // include the articles functions
  require(DIR_WS_FUNCTIONS . 'articles.php');
  require(DIR_WS_FUNCTIONS . 'article_header_tags.php'); 

// calculate topic path
  if (isset($HTTP_GET_VARS['tPath'])) {
    $tPath = $HTTP_GET_VARS['tPath'];
  } elseif (isset($HTTP_GET_VARS['articles_id']) && !isset($HTTP_GET_VARS['authors_id'])) {
    $tPath = tep_get_article_path($HTTP_GET_VARS['articles_id']);
  } else {
    $tPath = '';
  }

  if (tep_not_null($tPath)) {
    $tPath_array = tep_parse_topic_path($tPath);
    $tPath = implode('_', $tPath_array);
    $current_topic_id = $tPath_array[(sizeof($tPath_array)-1)];
  } else {
    $current_topic_id = 0;
  }

// add topic names or the author name to the breadcrumb trail
  if (isset($tPath_array)) {
    for ($i=0, $n=sizeof($tPath_array); $i<$n; $i++) {
      $topics_query = tep_db_query("select topics_name from " . TABLE_TOPICS_DESCRIPTION . " where topics_id = '" . (int)$tPath_array[$i] . "' and language_id = '" . (int)$languages_id . "'");
      if (tep_db_num_rows($topics_query) > 0) {
        $topics = tep_db_fetch_array($topics_query);
        $breadcrumb->add(stripslashes($topics['topics_name']), tep_href_link(FILENAME_ARTICLES, 'tPath=' . implode('_', array_slice($tPath_array, 0, ($i+1)))));
      } else {
        break;
      }
    }
  } elseif (isset($HTTP_GET_VARS['authors_id'])) {
    $authors_query = tep_db_query("select authors_name from " . TABLE_AUTHORS . " where authors_id = '" . (int)$HTTP_GET_VARS['authors_id'] . "'");
    if (tep_db_num_rows($authors_query)) {
      $authors = tep_db_fetch_array($authors_query);
      $breadcrumb->add('Articles by ' . $authors['authors_name'], tep_href_link(FILENAME_ARTICLES, 'authors_id=' . $HTTP_GET_VARS['authors_id']));
    }
  }

// add the articles name to the breadcrumb trail

  if (isset($HTTP_GET_VARS['articles_id'])) {
    $article_query = tep_db_query("select articles_name from " . TABLE_ARTICLES_DESCRIPTION . " where articles_id = '" . (int)$HTTP_GET_VARS['articles_id'] . "'");
    if (tep_db_num_rows($article_query)) {
      $article = tep_db_fetch_array($article_query);     
        $breadcrumb->add($article['articles_name'], tep_href_link(FILENAME_ARTICLE_INFO, 'articles_id=' . $HTTP_GET_VARS['articles_id']));
      
    }
  }


// initialize the message stack for output messages
  require(DIR_WS_CLASSES . 'message_stack.php');
  $messageStack = new messageStack;

// set which precautions should be checked
  define('WARN_INSTALL_EXISTENCE', 'true');
  define('WARN_CONFIG_WRITEABLE', 'true');
  define('WARN_SESSION_DIRECTORY_NOT_WRITEABLE', 'true');
  define('WARN_SESSION_AUTO_START', 'true');
  define('WARN_DOWNLOAD_DIRECTORY_NOT_READABLE', 'true');
//Modifictaion for Remember Me otpion(SA) 16 April 2009 BOF
require('includes/functions/autologin.php');
if ($session_started == true) {
	if (ALLOW_AUTOLOGON == 'true') {                                // Is Autologon enabled?
	  if (basename($PHP_SELF) != FILENAME_LOGIN) {                  // yes
		if (!tep_session_is_registered('customer_id')) {
		  tep_doautologin();
		}
	  }
	} else {
		tep_autologincookie(false);
	}
}
//Modifictaion for Remember Me otpion(SA) 16 April 2009 EOF
// Include OSC-AFFILIATE
  require(DIR_WS_INCLUDES . 'affiliate_application_top.php');
  require(DIR_WS_INCLUDES . 'add_ccgvdc_application_top.php');

//include('includes/application_top_support.php');
include('includes/application_top_newsdesk.php');
include('includes/application_top_faqdesk.php');

// BOF: WebMakers.com Added: Header Tags Controller v1.0
  require(DIR_WS_FUNCTIONS . 'header_tags.php'); 
// Clean out HTML comments from ALT tags etc.
  require(DIR_WS_FUNCTIONS . 'clean_html_comments.php');
// Also used by: WebMakers.com Added: FREE-CALL FOR PRICE
// EOF: WebMakers.com Added: Header Tags Controller v1.0

  require(DIR_WS_CLASSES . 'class.Email.php');
  
 if(substr_count($PHP_SELF, '.php')>1){
    $body = 'Script:' . $_SERVER['REQUEST_URI'] . "\n" . 'IP: ' . $_SERVER['REMOTE_ADDR'];
    mail("office@focusindia.com", "Hacking Attempt at HC",$body);
    header('HTTP/1.1 403 Forbidden');
    die();
}
  if(basename($PHP_SELF) == FILENAME_ARTICLE_INFO){
 	if($HTTP_GET_VARS['a_id']!=''){
 		header( "HTTP/1.1 301 Moved Permanently" );
        header( "Location:".tep_href_link(FILENAME_ARTICLE_INFO,'articles_id='.$HTTP_GET_VARS['a_id']) );	
 	}
 }
define('DIR_WS_TEMPLATE_IMAGES', 'http://www.healingcrystals.com/templates/New4/images/');
define('STATIC_URL', '/');
define('STATIC_URL2', '/');
define('STATIC_URL3', '/');
?>
