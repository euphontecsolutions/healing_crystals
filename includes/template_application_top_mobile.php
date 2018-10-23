<?php

/*
  $Id: template_application_top.php,v 1.1.1.1 2003/09/18 19:04:21 wilt Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
 */

class tableBoxMessagestack {

    var $table_border = '0';
    var $table_width = '100%';
    var $table_cellspacing = '0';
    var $table_cellpadding = '2';
    var $table_parameters = '';
    var $table_row_parameters = '';
    var $table_data_parameters = '';

// class constructor
    function tableBoxMessagestack($contents, $direct_output = false) {
        $tableBox1_string = '<table border="' . tep_output_string($this->table_border) . '" width="' . tep_output_string($this->table_width) . '" cellspacing="' . tep_output_string($this->table_cellspacing) . '" cellpadding="' . tep_output_string($this->table_cellpadding) . '"';
        if (tep_not_null($this->table_parameters))
            $tableBox1_string .= ' ' . $this->table_parameters;
        $tableBox1_string .= '>' . "\n";

        for ($i = 0, $n = sizeof($contents); $i < $n; $i++) {
            if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form']))
                $tableBox1_string .= $contents[$i]['form'] . "\n";
            $tableBox1_string .= '  <tr';
            if (tep_not_null($this->table_row_parameters))
                $tableBox1_string .= ' ' . $this->table_row_parameters;
            if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params']))
                $tableBox1_string .= ' ' . $contents[$i]['params'];
            $tableBox1_string .= '>' . "\n";

            if (isset($contents[$i][0]) && is_array($contents[$i][0])) {
                for ($x = 0, $n2 = sizeof($contents[$i]); $x < $n2; $x++) {
                    if (isset($contents[$i][$x]['text']) && tep_not_null($contents[$i][$x]['text'])) {
                        $tableBox1_string .= '    <td';
                        if (isset($contents[$i][$x]['align']) && tep_not_null($contents[$i][$x]['align']))
                            $tableBox1_string .= ' align="' . tep_output_string($contents[$i][$x]['align']) . '"';
                        if (isset($contents[$i][$x]['params']) && tep_not_null($contents[$i][$x]['params'])) {
                            $tableBox1_string .= ' ' . $contents[$i][$x]['params'];
                        } elseif (tep_not_null($this->table_data_parameters)) {
                            $tableBox1_string .= ' ' . $this->table_data_parameters;
                        }
                        $tableBox1_string .= '>';
                        if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form']))
                            $tableBox1_string .= $contents[$i][$x]['form'];
                        $tableBox1_string .= $contents[$i][$x]['text'];
                        if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form']))
                            $tableBox1_string .= '</form>';
                        $tableBox1_string .= '</td>' . "\n";
                    }
                }
            } else {
                $tableBox1_string .= '    <td';
                if (isset($contents[$i]['align']) && tep_not_null($contents[$i]['align']))
                    $tableBox1_string .= ' align="' . tep_output_string($contents[$i]['align']) . '"';
                if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) {
                    $tableBox1_string .= ' ' . $contents[$i]['params'];
                } elseif (tep_not_null($this->table_data_parameters)) {
                    $tableBox1_string .= ' ' . $this->table_data_parameters;
                }
                $tableBox1_string .= '>' . $contents[$i]['text'] . '</td>' . "\n";
            }

            $tableBox1_string .= '  </tr>' . "\n";
            if (isset($contents[$i]['form']) && tep_not_null($contents[$i]['form']))
                $tableBox1_string .= '</form>' . "\n";
        }

        $tableBox1_string .= '</table>' . "\n";

        if ($direct_output == true)
            echo $tableBox1_string;

        return $tableBox1_string;
    }

}

//Lango Added for template mod: BOF
// infobox
//  require(DIR_WS_CLASSES . 'boxes.php');
//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Site thema configuration
$customer_pref_template_query = tep_db_query("select  customers_selected_template as template_selected from " . TABLE_CUSTOMERS . " where customers_id = '" . $customer_id . "'");
$cptemplate = tep_db_fetch_array($customer_pref_template_query);

if ($HTTP_GET_VARS['selected_template'] != '') {
    tep_db_query("update " . TABLE_CUSTOMERS . " set customers_selected_template = '".$HTTP_GET_VARS['templateID']."' where customers_id = '" . $customer_id . "'");
    $_SESSION['templateSelected'] = $HTTP_GET_VARS['selected_template'];
    define(TEMPLATE_NAME, $HTTP_GET_VARS['selected_template']);
    define(TEMPLATE_STYLE, DIR_WS_TEMPLATES . TEMPLATE_NAME . "/stylesheet.css");
    define(TEMPLATE_STYLE_ORIGINAL, DIR_WS_TEMPLATES . DEFAULT_TEMPLATE . "/stylesheet_original.css");
    require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/boxes.tpl.php');
} else if ($_SESSION['templateSelected']!='') {
    define(TEMPLATE_NAME, $_SESSION['templateSelected']);
    define(TEMPLATE_STYLE, DIR_WS_TEMPLATES . TEMPLATE_NAME . "/stylesheet.css");
    define(TEMPLATE_STYLE_ORIGINAL, DIR_WS_TEMPLATES . DEFAULT_TEMPLATE . "/stylesheet_original.css");
    require(DIR_FS_CATALOG . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/boxes.tpl.php');
} else if (tep_not_null($cptemplate['template_selected'])) {
    $_SESSION['templateSelected'] = $cptemplate['template_selected'];
    define(TEMPLATE_NAME, $cptemplate['template_selected']);
    define(TEMPLATE_STYLE, DIR_WS_TEMPLATES . TEMPLATE_NAME . "/stylesheet.css");
    define(TEMPLATE_STYLE_ORIGINAL, DIR_WS_TEMPLATES . TEMPLATE_NAME . "/stylesheet_original.css");
    require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/boxes.tpl.php');
} else if (tep_not_null(DEFAULT_TEMPLATE)) {
    $_SESSION['templateSelected'] = DEFAULT_TEMPLATE;
    define(TEMPLATE_NAME, DEFAULT_TEMPLATE);
    define(TEMPLATE_STYLE, DIR_WS_TEMPLATES . DEFAULT_TEMPLATE . "/stylesheet.css");
    define(TEMPLATE_STYLE_ORIGINAL, DIR_WS_TEMPLATES . DEFAULT_TEMPLATE . "/stylesheet_original.css");
    require(DIR_FS_CATALOG . DIR_WS_TEMPLATES . DEFAULT_TEMPLATE . '/boxes.tpl.php');
} else {
     $_SESSION['templateSelected'] = 'Original';
    tep_db_query('UPDATE configuration SET configuration_value = "Original" WHERE configuration_title="default theme"');
    define(TEMPLATE_NAME, 'Original');
    define(TEMPLATE_STYLE, DIR_WS_TEMPLATES . TEMPLATE_NAME . "/dora.css");
    require(DIR_FS_CATALOG . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/boxes.tpl.php');
}
//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

if (file_exists(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/extra_html_output.php')) {
    require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/extra_html_output.php');
}
//Lango Added for template mod: EOF
//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

$template_query = tep_db_query("select * from " . TABLE_TEMPLATE . " where template_name = '" . TEMPLATE_NAME . "'");
$template = tep_db_fetch_array($template_query);

define('TEMPLATE_ID', $template[template_id]);
define('CELLPADDING_MAIN', $template[template_cellpadding_main]);
define('CELLPADDING_LEFT', $template[template_cellpadding_left]);
define('CELLPADDING_RIGHT', $template[template_cellpadding_right]);
define('CELLPADDING_SUB', $template[template_cellpadding_sub]);
define('DISPLAY_COLUMN_LEFT', $template[include_column_left]);
define('DISPLAY_COLUMN_RIGHT', $template[include_column_right]);

define('SITE_WIDTH', $template[site_width]);
define('BOX_WIDTH_LEFT', $template[box_width_left]);
define('BOX_WIDTH_RIGHT', $template[box_width_right]);
//define('SHOW_HEADING_TITLE_ORIGINAL', $template[show_page_descriptions]);
define('SIDE_BOX_LEFT_WIDTH', $template[side_box_left_width]);
define('SIDE_BOX_RIGHT_WIDTH', $template[side_box_right_width]);
define('MAIN_TABLE_BORDER', $template[main_table_border]);
define('SHOW_HEADER_LINK_BUTTONS', $template[show_header_link_buttons]);
define('SHOW_CART_IN_HEADER', $template[cart_in_header]);
define('SHOW_LANGUAGES_IN_HEADER', $template[languages_in_header]);
define('SHOW_HEADING_TITLE_ORIGINAL', $template[show_heading_title_original]);
define('INCLUDE_MODULE_ONE', $template[module_one]);
define('INCLUDE_MODULE_TWO', $template[module_two]);
define('INCLUDE_MODULE_THREE', $template[module_three]);
define('INCLUDE_MODULE_FOUR', $template[module_four]);
define('INCLUDE_MODULE_FIVE', $template[module_five]);
define('INCLUDE_MODULE_SIX', $template[module_six]);
define('SHOW_CUSTOMER_GREETING', $template[customer_greeting]);

// define('TEXT_GREETING_PERSONAL', stripslashes($template[edit_customer_greeting_personal]));
// define('TEXT_GREETING_PERSONAL_RELOGON', stripslashes($template[edit_customer_greeting_personal]));
// define('TEXT_GREETING_GUEST', stripslashes($template[edit_greeting_guest]));
//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
////
// The HTML image wrapper function
function tep_image_infobox($corner, $alt = '', $width = '', $height = '', $params = '') {


    $image = '<img src="' . DIR_WS_TEMPLATES . TEMPLATE_NAME . '/images/infobox/' . $corner . '" border="0" alt="' . $alt . '"';
    if ($alt) {
        $image .= ' title=" ' . $alt . ' "';
    }
    if ($width) {
        $image .= ' width="' . $width . '"';
    }
    if ($height) {
        $image .= ' height="' . $height . '"';
    }
    if ($params) {
        $image .= ' ' . $params;
    }
    $image .= '>';

    return $image;
}

//for templatebox
if ($HTTP_GET_VARS['action']) {
    switch ($HTTP_GET_VARS['action']) {
        case 'update_template':

            if ($template >= '1') {
                $thema_template = tep_db_prepare_input($HTTP_POST_VARS['template']);
                tep_db_query("update " . TABLE_CUSTOMERS . " set customers_selected_template = '$thema_template' where customers_id = '" . $customer_id . "'");
                tep_redirect(tep_href_link(basename(FILENAME_DEFAULT)));
            }
            break;
    }
}
?>