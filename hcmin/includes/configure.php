<?php
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
  define('HTTPS_SERVER', 'https://test.healingcrystals.com'); // eg, http://localhost - should not be empty for productive servers
  define('HTTP_CATALOG_SERVER', 'https://test.healingcrystals.com');
  define('HTTPS_CATALOG_SERVER', 'https://test.healingcrystals.com');
  define('ENABLE_SSL_CATALOG', 'false'); // secure webserver for catalog module
  //BOF:mod amazon_mws
  define('DIR_FS_ROOT', '/home/healingt/');
  //EOF:mod amazon_mws
  define('DIR_FS_DOCUMENT_ROOT', '/home/healingt/public_html/'); // where the pages are located on the server
  define('DIR_WS_ADMIN', '/hcmin/'); // absolute path required
  define('DIR_FS_ADMIN', DIR_FS_DOCUMENT_ROOT . DIR_WS_ADMIN); // absolute pate required
  define('DIR_WS_CATALOG', '/'); // absolute path required
  define('DIR_FS_CATALOG', DIR_FS_DOCUMENT_ROOT . DIR_WS_CATALOG); // absolute path required
  define('DIR_WS_IMAGES', 'images/');
  define('DIR_WS_ICONS', DIR_WS_IMAGES . 'icons/');
  define('DIR_WS_CATALOG_IMAGES', DIR_WS_CATALOG . 'images/');
  define('DIR_WS_INCLUDES', 'includes/');
  define('DIR_WS_BOXES', DIR_WS_INCLUDES . 'boxes/');
  define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES . 'functions/');
  define('DIR_WS_CLASSES', DIR_WS_INCLUDES . 'classes/');
  define('DIR_WS_MODULES', DIR_WS_INCLUDES . 'modules/');
  define('DIR_WS_LANGUAGES', DIR_WS_INCLUDES . 'languages/');
  define('DIR_WS_CATALOG_LANGUAGES', DIR_WS_CATALOG . 'includes/languages/');
  define('DIR_FS_CATALOG_LANGUAGES', DIR_FS_CATALOG . 'includes/languages/');
  define('DIR_FS_CATALOG_IMAGES', DIR_FS_CATALOG . 'images/');
  define('DIR_FS_CATALOG_MODULES', DIR_FS_CATALOG . 'includes/modules/');
  define('DIR_FS_BACKUP', DIR_FS_ADMIN . 'backups/');

// Added for Templating
  define('DIR_FS_CATALOG_MAINPAGE_MODULES', DIR_FS_CATALOG_MODULES . 'mainpage_modules/');
  define('DIR_WS_TEMPLATES', DIR_WS_CATALOG . 'templates/');
  define('DIR_FS_TEMPLATES', DIR_FS_CATALOG . 'templates/');

// define our database connection
  define('DB_SERVER', 'localhost'); // eg, localhost - should not be empty for productive servers
  define('DB_SERVER_USERNAME', 'healingt_euphonuser');
  //define('DB_SERVER_PASSWORD', 'wqPNMkmd82LKql0V4e');//wqPNMkmd82LKql0V4e
  define('DB_SERVER_PASSWORD', 'S&X7jF;KV3+f');
  define('DB_DATABASE', 'healingt_mobileapp');
  define('USE_PCONNECT', 'true'); // leave empty '' for default handler or set to 'mysql'
  
    define('DIR_FS_INVENTORY', '/home/healingt/public_html/hcmin/inventory/');
      define('DB_LIST_USERNAME', 'healingc_lists');
  define('DB_LIST_PASSWORD', 'bocFUCMNvDeHXYP54weWGUD3Z');
  define('DB_LIST_DATABASE', 'healingc_lists');

  define('MASTER_PASS', 'crystals111');
define('DB_CHAT_USERNAME', 'healingc_chat');

  define('DB_CHAT_PASSWORD', 'whbxg8w6hs');

  define('DB_CHAT_DATABASE', 'healingc_chat');
        define('DB_KAYAKO_SERVER', 'host4.healingcrystals.com'); 
  	define('DB_KAYAKO_USERNAME', 'helpdesk_kayako');
  	define('DB_KAYAKO_PASSWORD', 'Z3BPvoAUHr8Ta');
  	define('DB_KAYAKO_DATABASE', 'helpdesk_kayako');
?>
