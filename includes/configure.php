<?php
ob_start();
/*

  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com



  Copyright (c) 2003 osCommerce



  Released under the GNU General Public License

*/



// Define the webserver and path parameters

// * DIR_FS_* = Filesystem directories (local/physical)

// * DIR_WS_* = Webserver directories (virtual/URL)
 
  define('HTTP_SERVER', 'http://test.healingcrystals.com'); // eg, http://localhost - should not be empty for productive servers

  define('HTTPS_SERVER', 'https://test.healingcrystals.com'); // eg, https://localhost - should not be empty for productive servers

  //define('HTTPS_SERVER_SSL', 'https://www.healingcrystals.com');

  define('ENABLE_SSL', true); // secure webserver for checkout procedure?

  define('HTTP_COOKIE_DOMAIN', 'test.healingcrystals.com');

  define('HTTPS_COOKIE_DOMAIN', 'test.healingcrystals.com');

  define('HTTP_COOKIE_PATH', '/');

  define('HTTPS_COOKIE_PATH', '/');

  define('DIR_WS_HTTP_CATALOG', '/');

  define('DIR_WS_HTTPS_CATALOG', '/');

  define('DIR_WS_IMAGES', 'images/');

  define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');

  define('DIR_WS_INCLUDES', 'includes/');

  define('DIR_WS_BOXES', DIR_WS_INCLUDES . 'boxes/');

  define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');

  define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');

  define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');

  define('DIR_WS_LANGUAGES', DIR_WS_INCLUDES . 'languages/');



//Added for BTS1.0

  define('DIR_WS_TEMPLATES', 'templates/');

  define('DIR_WS_CONTENT', DIR_WS_TEMPLATES . 'content/');

  define('DIR_WS_JAVASCRIPT', DIR_WS_INCLUDES . 'javascript/');

//End BTS1.0

  define('DIR_WS_DOWNLOAD_PUBLIC', '/pub/');

  //BOF:mod amazon_mws

  define('DIR_FS_ROOT', '/home/healingt/');

  //EOF:mod amazon_mws

  define('DIR_FS_CATALOG', '/home/healingt/public_html/');

  define('DIR_FS_ADMIN', DIR_FS_CATALOG .  'hcmin/');

  define('DIR_FS_DOWNLOAD', DIR_FS_CATALOG . '/download/');

  define('DIR_FS_DOWNLOAD_PUBLIC', DIR_FS_CATALOG . '/pub/');



// define our database connection

  define('DB_SERVER', 'localhost'); // eg, localhost - should not be empty for productive servers
  //define('DB_DATABASE', 'healint_new');
define('DB_DATABASE', 'healingt_mobileapp');
 // define('DB_SERVER_USERNAME', 'healingt_user');
  define('DB_SERVER_USERNAME', 'healingt_euphonuser');

  //define('DB_SERVER_PASSWORD', 'wqPNMkmd82LKql');//f1rNlztl9Vy6RcK
 // define('DB_SERVER_PASSWORD', 'Madept');
  //define('DB_DATABASE', 'healint_new');
  
  define('DB_SERVER_PASSWORD', 'S&X7jF;KV3+f');
  
  

  define('USE_PCONNECT', 'false'); // use persistent connections?

  define('STORE_SESSIONS', ''); // leave empty '' for default handler or set to 'mysql'



  define('DB_LIST_USERNAME', 'healingc_lists');

  //define('DB_LIST_PASSWORD', 'bocFUCMNvDeHXYP54weWGUD3Z');

  define('DB_LIST_PASSWORD', 'lH?v9nPsiPTN');

  define('DB_LIST_DATABASE', 'healingc_lists');

  define('DB_KAYAKO_SERVER', 'host4.healingcrystals.com'); 

  define('DB_KAYAKO_USERNAME', 'helpdesk_kayako');

  define('DB_KAYAKO_PASSWORD', 'Z3BPvoAUHr8Ta');

  define('DB_KAYAKO_DATABASE', 'helpdesk_kayako');



  //define('MASTER_PASS', 'crystals111');

?>



