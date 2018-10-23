<?php
/*
  $Id: articles.php, v1.0 2003/12/04 12:00:00 ra Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
 */
//Function to seperate multiple tags one line
function fix_newlines_for_clean_html($fixthistext)
{
	$fixthistext_array = explode("\n", $fixthistext);
	foreach ($fixthistext_array as $unfixedtextkey => $unfixedtextvalue)
	{
		//Makes sure empty lines are ignores
		if (!preg_match("/^(\s)*$/", $unfixedtextvalue))
		{
			$fixedtextvalue = preg_replace("/>(\s|\t)*</U", ">\n<", $unfixedtextvalue);
			$fixedtext_array[$unfixedtextkey] = $fixedtextvalue;
		}
	}
	return implode("\n", $fixedtext_array);
}

function clean_html_code($uncleanhtml)
{
	//Set wanted indentation
	$indent = "    ";


	//Uses previous function to seperate tags
	$fixed_uncleanhtml = fix_newlines_for_clean_html($uncleanhtml);
	$uncleanhtml_array = explode("\n", $fixed_uncleanhtml);
	//Sets no indentation
	$indentlevel = 0;
	foreach ($uncleanhtml_array as $uncleanhtml_key => $currentuncleanhtml)
	{
		//Removes all indentation
		$currentuncleanhtml = preg_replace("/\t+/", "", $currentuncleanhtml);
		$currentuncleanhtml = preg_replace("/^\s+/", "", $currentuncleanhtml);

		$replaceindent = "";

		//Sets the indentation from current indentlevel
		for ($o = 0; $o < $indentlevel; $o++)
		{
			$replaceindent .= $indent;
		}

		//If self-closing tag, simply apply indent
		if (preg_match("/<(.+)\/>/", $currentuncleanhtml))
		{
			$cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;
		}
		//If doctype declaration, simply apply indent
		else if (preg_match("/<!(.*)>/", $currentuncleanhtml))
		{
			$cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;
		}
		//If opening AND closing tag on same line, simply apply indent
		else if (preg_match("/<[^\/](.*)>/", $currentuncleanhtml) && preg_match("/<\/(.*)>/", $currentuncleanhtml))
		{
			$cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;
		}
		//If closing HTML tag or closing JavaScript clams, decrease indentation and then apply the new level
		else if (preg_match("/<\/(.*)>/", $currentuncleanhtml) || preg_match("/^(\s|\t)*\}{1}(\s|\t)*$/", $currentuncleanhtml))
		{
			$indentlevel--;
			$replaceindent = "";
			for ($o = 0; $o < $indentlevel; $o++)
			{
				$replaceindent .= $indent;
			}

			$cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;
		}
		//If opening HTML tag AND not a stand-alone tag, or opening JavaScript clams, increase indentation and then apply new level
		else if ((preg_match("/<[^\/](.*)>/", $currentuncleanhtml) && !preg_match("/<(link|meta|base|br|img|hr)(.*)>/", $currentuncleanhtml)) || preg_match("/^(\s|\t)*\{{1}(\s|\t)*$/", $currentuncleanhtml))
		{
			$cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;

			$indentlevel++;
			$replaceindent = "";
			for ($o = 0; $o < $indentlevel; $o++)
			{
				$replaceindent .= $indent;
			}
		}
		else
		//Else, only apply indentation
		{$cleanhtml_array[$uncleanhtml_key] = $replaceindent.$currentuncleanhtml;}
	}
	//Return single string seperated by newline
	return implode("\n", $cleanhtml_array);
}
function _href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = false, $search_engine_safe = true) {
    global $request_type, $session_started, $SID;
    define('DIR_WS_HTTP_CATALOG', '/');
    define('HHTTP_SERVER', 'www.healingcrystals.com');
    define('HHTTPS_SERVER', 'www.healingcrystals.com');
    if (!tep_not_null($page)) {
        die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine the page link!<br><br>');
    }
    if ($connection == 'NONSSL') {
        $link = HHTTP_SERVER . DIR_WS_HTTP_CATALOG;
    } elseif ($connection == 'SSL') {
        if (ENABLE_SSL == true) {
            $link = HHTTPS_SERVER . DIR_WS_HTTPS_CATALOG;
        } else {
            $link = HHTTP_SERVER . DIR_WS_HTTP_CATALOG;
        }
    } else {
        die('</td></tr></table></td></tr></table><br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br>Known methods: NONSSL SSL</b><br><br>');
    }
    if (tep_not_null($parameters)) {
        /*         * ******** triasphera se html   *** */
        if ((SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true)) {
            $se_on = true;
        } else {
            $se_on = false;
        }
        global $languages_id;
        if (($page == 'article_info.php') && $se_on) {
            $p = @explode('=', $parameters);
            $a = '';
            $pagelink = '';
            $a = 'a_' . $p[1] . '.php';
            $link .= $a;
            $separator = '?';
        } else {
            $link .= $page . '?' . $parameters;
            $separator = '&';
        }
    } else {
        $link .= $page;
        $separator = '?';
    }
    while ((substr($link, -1) == '&') || (substr($link, -1) == '?'))
        $link = substr($link, 0, -1);
// Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
    if (($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'False')) {
        if (tep_not_null($SID)) {
            $_sid = $SID;
        } elseif (( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == true) ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') )) {
            if (HTTP_COOKIE_DOMAIN != HTTPS_COOKIE_DOMAIN) {
                $_sid = tep_session_name() . '=' . tep_session_id();
            }
        }
    }
    if (isset($_sid)) {
        $link .= $separator . $_sid;
    }
    return $link;
}

function tep_get_articles_url1($aid) {
    //require_once('../includes/functions/html_output.php');
    return _href_link('article_info.php', 'url_id=' . $aid);
}

function array2string($myarray, &$output, &$parentkey) {
    foreach ($myarray as $key => $value) {
        if (is_array($value)) {
            $parentkey .= $key . "^^^";
            array2string($value, $output, $parentkey);
            $parentkey = "";
        } else {
            $output .= $parentkey . $key . "^^^" . $value . "\n\n\n\n\n";
        }
    }
}

function string2array($string, &$myarray) {
    $lines = explode("\n\n\n\n\n", $string);
    foreach ($lines as $value) {
        $items = explode("^^^", $value);
        if (sizeof($items) == 2) {
            $myarray[$items[0]] = $items[1];
        } else if (sizeof($items) == 3) {
            $myarray[$items[0]][$items[1]] = $items[2];
        }
    }
}

require('includes/application_top.php');
require('includes/languages/english/articles.php');
require_once('fckeditor/fckeditor.php');

require_once ( 'includes/parser_urls.php' );

$action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');
// check if the catalog image directory exists
if (is_dir(DIR_FS_CATALOG_IMAGES)) {
    if (!is_writeable(DIR_FS_CATALOG_IMAGES))
        $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
} else {
    $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
        <?php
// BOF: WebMakers.com Changed: Header Tag Controller v1.0
// Replaced by header_tags.php
        if (file_exists(DIR_WS_INCLUDES . 'header_tags.php')) {
            require(DIR_WS_INCLUDES . 'header_tags.php');
        } else {
        ?>
            <title>Articles</title>
<?php
        }
// EOF: WebMakers.com Changed: Header Tag Controller v1.0
?>
            <?php
            if(basename($PHP_SELF) == 'articles_short.php' && ((isset($_GET['tPath']) && $_GET['tPath']== 29) || (isset($_GET['tPath'])  && $_GET['tPath'] == 30) )){
            ?>
          <script type="text/javascript" src="ckeditor-4.2/ckeditor.js"></script>
          <?php
            }else{
            ?>
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        <?php
            }
            ?>
        <script type="text/javascript">
            if ( window.CKEDITOR )
            {
                (function()
                {
                    var showCompatibilityMsg = function()
                    {
                        var env = CKEDITOR.env;

                        var html = '<p><strong>Your browser is not compatible with CKEditor.</strong>';

                        var browsers =
                            {
                            gecko : 'Firefox 2.0',
                            ie : 'Internet Explorer 6.0',
                            opera : 'Opera 9.5',
                            webkit : 'Safari 3.0'
                        };

                        var alsoBrowsers = '';

                        for ( var key in env )
                        {
                            if ( browsers[ key ] )
                            {
                                if ( env[key] )
                                    html += ' CKEditor is compatible with ' + browsers[ key ] + ' or higher.';
                                else
                                    alsoBrowsers += browsers[ key ] + '+, ';
                            }
                        }

                        alsoBrowsers = alsoBrowsers.replace( /\+,([^,]+), $/, '+ and $1' );

                        html += ' It is also compatible with ' + alsoBrowsers + '.';

                        html += '</p><p>With non compatible browsers, you should still be able to see and edit the contents (HTML) in a plain text field.</p>';

                        var alertsEl = document.getElementById( 'alerts' );
                        alertsEl && ( alertsEl.innerHTML = html );
                    };

                    var onload = function()
                    {
                        // Show a friendly compatibility message as soon as the page is loaded,
                        // for those browsers that are not compatible with CKEditor.
                        if ( !CKEDITOR.env.isCompatible )
                            showCompatibilityMsg();
                    };
                    // Register the onload listener.
                    if ( window.addEventListener )
                        window.addEventListener( 'load', onload, false );
                    else if ( window.attachEvent )
                        window.attachEvent( 'onload', onload );
                })();
            }
            function fill_tag(tag){
                var old_tag = document.getElementById('taglist').value;
                var new_tag;
                if(old_tag != ''){
                    var temp = new Array();
                    temp = old_tag.split(',');
                    if(temp.indexOf(tag) == -1){
                        new_tag = old_tag + ',' + tag ;
                    }else{
                        new_tag = old_tag;
                    }
                }else{
                    new_tag = tag;
                }
                document.getElementById('taglist').value = new_tag;

            }
            function remove_tags(tag_id){
                var r_tag = 'delete_tag['+tag_id+']';
                var r_span = 'span'+tag_id ;
                document.getElementById(r_tag).value = tag_id;
                document.getElementById(r_span).style.display = 'none';
            }
            // Whether content has exceeded the maximum characters.
var locked;
editor.on( 'key', function( evt ){

   var currentLength = editor.getData().length,
      maximumLength = 200;
   if( currentLength >= maximumLength )
   {
      if ( !locked )
      {
         // Record the last legal content.
         editor.fire( 'saveSnapshot' ), locked = 1;
                        // Cancel the keystroke.
         evt.cancel();
      }
      else
         // Check after this key has effected.
         setTimeout( function()
         {
            // Rollback the illegal one.
            if( editor.getData().length > maximumLength )
               editor.execCommand( 'undo' );
            else
               locked = 0;
         }, 0 );
   }
} );
        </script>

        <link rel="stylesheet" type="text/css" href="includes/stylesheet.css" />
        <script language="javascript" src="includes/general.js"></script>
        <link rel="stylesheet" href="jquery-ui-1.10.3.custom/development-bundle/themes/redmond/jquery.ui.all.css">
	<script src="jquery-ui-1.10.3.custom/development-bundle/jquery-1.9.1.js"></script>
	<script src="jquery-ui-1.10.3.custom/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="jquery-ui-1.10.3.custom/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="jquery-ui-1.10.3.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>

	<script>
            /*$(document).ready(function(){
               // alert('334');
                $("#datepicker").Datepicker();
            });
            alert('223');*/
	$(function() {
		$("#datepicker").datepicker();
	});
	</script>
    </head>

    <body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onLoad="SetFocus();">
        <div id="spiffycalendar" class="text"></div>
        <!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
        <!-- header_eof //-->

        <!-- body //-->
        <table border="0" width="100%" cellspacing="2" cellpadding="2">
            <tr>
                <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
                        <!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
                        <!-- left_navigation_eof //-->
                    </table></td>
                <!-- body_text //-->
                <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2"><tr><td>
                        <?php
                        if ($action == 'new_article') {

                            $parameters = array('articles_name' => '',
                                'articles_description' => '',
                                'articles_comments' => '',
                                'articles_url' => '',
                                'articles_head_title_tag' => '',
                                'articles_head_desc_tag' => '',
                                'articles_head_keywords' => '',
                                'articles_id' => '',
                                'articles_date_added' => '',
                                'articles_last_modified' => 'NOW()',
                                'articles_date_available' => '',
                                'articles_date_added' => '',
                                'articles_status' => '',
                                'authors_id' => '',
                                'articles_image' => '');

                            $aInfo = new objectInfo($parameters);

                            if (isset($HTTP_GET_VARS['aID']) && empty($HTTP_POST_VARS)) {
                                //$article_query = tep_db_query("select ad.articles_name, a.articles_id, ad.articles_description, ad.articles_comments, ad.articles_url, ad.articles_head_title_tag, ad.articles_head_desc_tag, ad.articles_head_keywords_tag, a.articles_id, a.articles_image, a.articles_date_added, a.articles_last_modified, a.twitter_status, ad.twitter_content, ad.facebook_content, a.twitter_url, a.fb_image_url, a.fb_image_link, a.fb_image_desc, a.fb_image_title, DATE_FORMAT( articles_last_modified  ,'%M %e, %Y %r') AS date_modified_formatted, date_format(a.articles_date_available, '%Y-%m-%d') as articles_date_available, date_format(a.articles_date_added, '%m-%d-%y %H:%i') as articles_date_added, date_format(a.twitter_publishing_date, '%m-%d-%y %H:%i:%s') as twitter_publishing_date , a.twitter_error_message, date_format(a.facebook_publishing_date, '%m-%d-%y %H:%i:%s') as facebook_publishing_date , a.facebook_error_message, date_format(a.wordpress_publishing_date, '%m-%d-%y %H:%i:%s') as wordpress_publishing_date , a.wordpress_error_message, a.articles_status, a.authors_id, a.publish_on_hc, a.publish_on_facebook, a.publish_on_twitter, a.publish_on_wordpress from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad where a.articles_id = '" . (int) $HTTP_GET_VARS['aID'] . "' and a.articles_id = ad.articles_id and ad.language_id = '" . (int) $languages_id . "'");
                                $article_query = tep_db_query("select ad.articles_name, a.articles_id, a.links_id, ad.articles_description, ad.articles_comments, ad.articles_url, ad.articles_head_title_tag, ad.articles_head_desc_tag, ad.articles_head_keywords_tag, a.articles_id, a.articles_image, a.articles_video, a.articles_date_added, a.articles_last_modified, a.twitter_status, ad.twitter_content, ad.facebook_content, a.twitter_url, a.fb_image_url, a.fb_image_link, a.fb_image_desc, a.fb_image_title, DATE_FORMAT( articles_last_modified  ,'%M %e, %Y %r') AS date_modified_formatted, a.articles_date_available as 'article_date_avilable_on_hc' ,date_format(a.articles_date_available, '%m/%d/%Y') as articles_date_available, date_format(a.articles_date_available, '%H') as articles_date_available_hour, date_format(a.articles_date_available, '%i') as articles_date_available_min, date_format(a.articles_date_added, '%m-%d-%y %H:%i') as articles_date_added, date_format(a.twitter_publishing_date, '%m-%d-%y %H:%i:%s') as twitter_publishing_date , a.twitter_error_message, date_format(a.facebook_publishing_date, '%m-%d-%y %h:%i:%s') as facebook_publishing_date , a.facebook_error_message, date_format(a.wordpress_publishing_date, '%m-%d-%y %h:%i:%s') as wordpress_publishing_date , a.wordpress_error_message, a.articles_status, a.authors_id, a.publish_on_hc, a.publish_on_facebook, a.publish_on_twitter, a.daily_nugget, a.lists_nugget_id, a.is_daily_nugget_sent, date_format(a.daily_nugget_sent_date, '%m-%d-%y %h:%i:%s') as daily_nugget_sent_date, a.publish_on_wordpress, date_format(atyg.yahoo_groups_publishing_date, '%m-%d-%y %h:%i:%s') as yahoo_groups_publishing_date, atyg.yahoo_groups_error_message, atyg.yahoo_groups_status, atyg.publish_on_yahoo_groups, date_format(atgg.google_groups_publishing_date, '%m-%d-%y %h:%i:%s') as google_groups_publishing_date, atgg.google_groups_error_message, atgg.google_groups_status, atgg.publish_on_google_groups from (" . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad) LEFT JOIN articles_to_yahoo_groups atyg on atyg.articles_id = a.articles_id LEFT JOIN articles_to_google_groups atgg on atgg.articles_id = a.articles_id where a.articles_id = '" . (int)$HTTP_GET_VARS['aID'] . "' and a.articles_id = ad.articles_id and ad.language_id = '" . (int)$languages_id . "'");

                                $article = tep_db_fetch_array($article_query);

                                $aInfo->objectInfo($article);
                                $languages = tep_get_languages();
                                for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                                    $articles_description[$languages[$i]['id']] = tep_get_articles_description($article['articles_id'], $languages[$i]['id']);
                                    $twitter_content[$languages[$i]['id']] = tep_get_twitter_content($article['articles_id'], $languages[$i]['id']);
                                    $facebook_content[$languages[$i]['id']] = tep_get_facebook_content($article['articles_id'], $languages[$i]['id']);
                                }
                                $articles_comments = $article['articles_comments'];
                                //print_r($articles_description);
                            } elseif (tep_not_null($HTTP_POST_VARS)) {
                                $aInfo->objectInfo($HTTP_POST_VARS);
                                $articles_name = $HTTP_POST_VARS['articles_name'];
                                $articles_description = $HTTP_POST_VARS['articles_description'];
                                $articles_comments = $HTTP_POST_VARS['articles_comments'];
                                $twitter_content = $HTTP_POST_VARS['twitter_content'];
                                $facebook_content = $HTTP_POST_VARS['facebook_content'];

                                $articles_url = $HTTP_POST_VARS['articles_url'];
                                $articles_head_title_tag = $HTTP_POST_VARS['articles_head_title_tag'];
                                $articles_head_desc_tag = $HTTP_POST_VARS['articles_head_desc_tag'];
                                $articles_head_keywords_tag = $HTTP_POST_VARS['articles_head_keywords_tag'];
                                $article['articles_date_added'] = $HTTP_POST_VARS['articles_date_added'];
                            }

                            $authors_array = array(array('id' => '', 'text' => TEXT_NONE));
                            $authors_query = tep_db_query("select authors_id, authors_name from " . TABLE_AUTHORS . " order by authors_name");
                            while ($authors = tep_db_fetch_array($authors_query)) {
                                $authors_array[] = array('id' => $authors['authors_id'],
                                    'text' => $authors['authors_name']);
                            }

                            # get selected categories
                            $categories_query_selected = tep_db_query("select topics_id from " . TABLE_ARTICLES_TO_TOPICS . " where articles_id = '" . (int) $HTTP_GET_VARS['aID'] . "'");
                            //$categories_array_selected = array(array('id' => '');
                            $categories_array_selected = array();

                            if (isset($HTTP_POST_VARS['categories_ids'])) {
                                foreach ($HTTP_POST_VARS['categories_ids'] as $id) {
                                    $categories_array_selected[] = $id;
                                }
                            } elseif ($HTTP_GET_VARS['aID'] != '') {
                                while ($categories = tep_db_fetch_array($categories_query_selected)) {
                                    //$categories_array_selected[] = array('id' => $categories['topics_id']);
                                    $categories_array_selected[] = $categories['topics_id'];
                                }
                            }
                            $language_id = 1;

                            $categories_array = tep_get_topic_tree('0', '');
                            $languages = tep_get_languages();

                            if (!isset($aInfo->articles_status))
                                $aInfo->articles_status = '1';
                            switch ($aInfo->articles_status) {
                                case '1':$in_status = true;
                                    $out_status = false;
                                    break;
                                case '0':
                                default: $in_status = false;
                                    $out_status = true;
                                    break;

                            }
                        ?>
                            <link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
                            <script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
                            <script>

                                String.prototype.stripHTML = function()

                                {
                                    var matchTag = /<(?:.|\s)*?>/g;
                                    return this.replace(matchTag, "");
                                };
                                function articleCount(){
                                    var acount = document.getElementById('articles_description_twi[1]').value.stripHTML().length;
                                    var varCount = '140';
                                    if(document.getElementById('articles_description_twi[1]').value.indexOf('http://')<0 && document.getElementById('articles_description_twi[1]').value.indexOf('www.')>-1)varCount='133';
                                    if(acount >varCount){
                                        document.getElementById('count').style.color='#ff0000';
                                    }else{
                                        document.getElementById('count').style.color='#00ff00';
                                    }
                                    document.getElementById('count').innerHTML = 'Short Post Character Count: '+acount;
                                }
                                function fbArticleCount(){
                                    var acount = document.getElementById('articles_description_fb[1]').value.stripHTML().length;
                                    if(acount > '420'){
                                        document.getElementById('fbcount').style.color='#ff0000';
                                    }else{
                                        document.getElementById('fbcount').style.color='#00ff00';
                                    }
                                    document.getElementById('fbcount').innerHTML = 'Medium Post Character Count: '+acount;
                                }
                            </script>
                            <script language="javascript">
                                <!--

                                var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "new_article", "articles_date_available","btnDate2","<?php echo $aInfo->articles_date_available; ?>",scBTNMODE_CUSTOMBLUE);



                                var dateAdd = new ctlSpiffyCalendarBox("dateAdd", "new_article", "articles_date_added","btnDate1","<?php echo $aInfo->articles_date; ?>",scBTNMODE_CUSTOMBLUE);

                                function fillDateAdded(date,hh,mm){
                                    $('input[name=articles_date_available]').val(date);
                                    $('select[name=date_avilable_hour]').val(hh);
                                    $('select[name=date_avilable_min]').val(mm);
                                    //document.new_article.articles_date_added.value= date;
                                }

                                function article_form_check(){
                                    adate = $('input[name=articles_date_available]').val()
                                    //alert = alert(adate);
                                    error = false;
                                    error_msg = '';
                                    if(adate == ''){
                                        error = true;
                                        error_msg =  "* Please submit a posting date first";
                                    }

                                    if(error == true){
                                        alert(error_msg);
                                        $('input[name=articles_date_available]').focus();
                                        return false;
                                    }else{
                                        return true;
                                    }
                                }
                                -->
                            </script>
<?php echo tep_draw_form('new_article', FILENAME_ARTICLES, 'tPath=' . $tPath . (isset($HTTP_GET_VARS['aID']) ? '&aID=' . $HTTP_GET_VARS['aID'] : '') . '&action=' . (isset($HTTP_GET_VARS['aID']) ? 'update_article' : 'insert_article'), 'post', 'enctype="multipart/form-data" onsubmit="return article_form_check();"'); ?>
                            <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                <tr>
                                    <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td class="pageHeading"><?php echo sprintf(TEXT_NEW_ARTICLE, tep_output_generated_topic_path($current_topic_id)); ?></td>
                                                <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
                                            </tr>
                                        </table></td>
                                </tr>
                                <tr>
                                    <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                </tr>
                                <tr>
                                    <td><table border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td class="main"><?php echo TEXT_ARTICLES_STATUS; ?></td>
                                            <!--td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_radio_field('articles_status', '0', $out_status) . '&nbsp;' . TEXT_ARTICLE_NOT_AVAILABLE . '&nbsp;' . tep_draw_radio_field('articles_status', '1', $in_status) . '&nbsp;' . TEXT_ARTICLE_AVAILABLE; ?>&nbsp;&nbsp; <input type="radio" name="twitter_status" <?php if ($aInfo->twitter_status == 1)
                                            echo 'checked'; ?>/> Twitter, Facebook &amp; Wordpress </td//-->
                                            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_radio_field('articles_status', '0', $out_status) . '&nbsp;' . TEXT_ARTICLE_NOT_AVAILABLE . '&nbsp;' . tep_draw_radio_field('articles_status', '1', $in_status) . '&nbsp;';
                                        echo'Active';
										if($HTTP_GET_VARS['aID']!='') {

                                         	echo '&nbsp;&nbsp;&nbsp;<a href="'.tep_catalog_href_link('article_info.php', 'articles_id='.$HTTP_GET_VARS['aID'].'&preview=on').'" target="_blank">'.tep_image_button("button_preview.gif").'</a>';

                                    	}
										 ?></td>
                                        </tr>




				<?php if ($aInfo->articles_status == 1 && $aInfo->publish_on_hc == 1 && $aInfo->article_date_avilable_on_hc < date('Y-m-d H:i:s')) {
                                            echo'<tr>
            <td colspan="2">' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>
          </tr><tr>
            <td colspan="2" class="main">Published to <a href="http://www.healingcrystals.com/newsfeed.php" target="_blank" style="color:blue; font-size:12px;"><u>HealingCrystals.com</u></a> on  ' . $article['articles_date_available'].' '.$article['articles_date_available_hour'].':'.$article['articles_date_available_min'] . '</tr>'; ?> </td>
                                    <?php }
                                    ?>
                                    <?php if (strpos($aInfo->daily_nugget_sent_date, '00-00-00') === false && $aInfo->daily_nugget_sent_date != '') {
                                            echo'<tr>
            <td colspan="2">' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>
          </tr><tr>
            <td colspan="2" class="main">Published to The Daily Nugget in Phplist on  ' . $aInfo->daily_nugget_sent_date . '</tr>'; ?> </td>
                                    <?php
                                        }
                                     if (strpos($aInfo->twitter_publishing_date, '00-00-00') === false && $aInfo->twitter_publishing_date != '' && $aInfo->twitter_error_message == '') {
                                            echo'<tr>
            <td colspan="2">' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>
          </tr><tr>
            <td colspan="2" class="main">Published to <a href="http://www.twitter.com/crystaltalk" target="_blank" class="main" style="color:blue; font-size:12px;"><u>Twitter</u></a> on  ' . $aInfo->twitter_publishing_date . '</tr>'; ?> </td>
                                    <?php
                                        } elseif ($aInfo->twitter_error_message != '') {
                                            echo'<tr>
            <td colspan="2">' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>
          </tr><tr>
            <td colspan="2" class="main">Error posting to Twitter on  ' . $aInfo->twitter_publishing_date . '&nbsp; <a href="'.tep_href_link('articles.php','aID='.$HTTP_GET_VARS['aID'].'&resend=twitter').'">'.tep_image_button('button_repost.gif', 'RePost').'</a></td></tr>';
                                        }
                                    ?>
                                <?php if (strpos($aInfo->facebook_publishing_date, '00-00-00') === false && $aInfo->facebook_publishing_date != '' && $aInfo->facebook_error_message == '') {
                                            echo'<tr>
            <td colspan="2">' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>
          </tr><tr>
            <td colspan="2" class="main">Published to <a href="http://www.facebook.com/crystaltalk" target="_blank" class="main" style="color:blue; font-size:12px;"><u>Facebook</u></a> on  ' . $aInfo->facebook_publishing_date . '</tr>'; ?> </td>
                                <?php
                                        } elseif ($aInfo->facebook_error_message != '') {
                                            echo'<tr>
            <td colspan="2">' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>
          </tr><tr>
            <td colspan="2" class="main">Error posting to Facebook on  ' . $aInfo->facebook_publishing_date . '&nbsp; <a href="'.tep_href_link('articles.php','aID='.$HTTP_GET_VARS['aID'].'&resend=facebook').'">'.tep_image_button('button_repost.gif', 'RePost').'</a></td></tr>';
                                        }
                                ?>
                                <?php if (strpos($aInfo->wordpress_publishing_date, '00-00-00') === false && $aInfo->wordpress_publishing_date != '' && $aInfo->wordpress_error_message == '') {
                                            echo'<tr>
            <td colspan="2">' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>
          </tr><tr>
            <td colspan="2" class="main">Published to <a href="http://crystaltalk.wordpress.com" target="_blank" class="main" style="color:blue; font-size:12px;"><u>Wordpress</u></a> on  ' . $aInfo->wordpress_publishing_date . '</tr>'; ?> </td>
<?php
                                        } elseif ($aInfo->wordpress_error_message != '') {
                                            echo'<tr>
            <td colspan="2">' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>
          </tr><tr>
            <td colspan="2" class="main">Error posting to Wordpress on  ' . $aInfo->wordpress_publishing_date . '&nbsp; <a href="'.tep_href_link('articles.php','aID='.$HTTP_GET_VARS['aID'].'&resend=wordpress').'">'.tep_image_button('button_repost.gif', 'RePost').'</a></td></tr>';
                                        }
?>
                                <?php if(strpos($aInfo->yahoo_groups_publishing_date, '00-00-00') === false  && $aInfo->yahoo_groups_publishing_date!='' && $aInfo->yahoo_groups_error_message=='') {
                                        echo'<tr>
            <td colspan="2">'. tep_draw_separator('pixel_trans.gif', '1', '10').'</td>
          </tr><tr>
            <td colspan="2" class="main">Published to <a href="http://health.groups.yahoo.com/group/Healing-Crystals/" target="_blank" class="main" style="color:blue; font-size:12px;"><u>Yahoo Groups</u></a> on  '.$aInfo->yahoo_groups_publishing_date.'</tr>'; ?> </td>
                                        <?php }elseif($aInfo->yahoo_groups_error_message!='') {
                                        echo'<tr>
            <td colspan="2">'. tep_draw_separator('pixel_trans.gif', '1', '10').'</td>
          </tr><tr>
            <td colspan="2" class="main">Error posting to Yahoo Groups on  '.$aInfo->yahoo_groups_publishing_date.'&nbsp; <a href="'.tep_href_link('articles.php','aID='.$HTTP_GET_VARS['aID'].'&resend=yahoo').'">'.tep_image_button('button_repost.gif', 'RePost').'</a></td></tr>';
                                    }
                                    ?>
                                <?php if(strpos($aInfo->google_groups_publishing_date, '00-00-00') === false  && $aInfo->google_groups_publishing_date!='' && $aInfo->google_groups_error_message=='') {
                                        echo'<tr>
            <td colspan="2">'. tep_draw_separator('pixel_trans.gif', '1', '10').'</td>
          </tr><tr>
            <td colspan="2" class="main">Published to <a href="http://groups.google.com/group/healing-crystals-group" target="_blank" class="main" style="color:blue; font-size:12px;"><u>Google Groups</u></a> on  '.$aInfo->google_groups_publishing_date.'</tr>'; ?> </td>
                                        <?php }elseif($aInfo->google_groups_error_message!='') {
                                        echo'<tr>
            <td colspan="2">'. tep_draw_separator('pixel_trans.gif', '1', '10').'</td>
          </tr><tr>
            <td colspan="2" class="main">Error posting to Google Groups on  '.$aInfo->google_groups_publishing_date.'&nbsp; <a href="'.tep_href_link('articles.php','aID='.$HTTP_GET_VARS['aID'].'&resend=google').'">'.tep_image_button('button_repost.gif', 'RePost').'</a></td></tr>';
                                    }
                                    ?>

                                    <tr>
                                        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="main">Instructions:</td>
                                        <td class="main"><?php echo tep_draw_textarea_field('articles_comments[1]', 'soft', '100', '11', $articles_comments); ?></td>
                                </tr>
								<?php
								$dtime = date('m/d/Y');
                                                                $dtime_hour = date('H');
                                                                $dtime_min = date('i');
								echo '<tr>
            <td colspan="2">' . tep_draw_separator('pixel_trans.gif', '1', '10') . '</td>
          </tr><tr>
            <td colspan="2" class="main"><input id="postImme" type="checkbox" onclick="javascript:if(this.checked==true){fillDateAdded(\'' . $dtime . '\',\'' . $dtime_hour . '\',\'' . $dtime_min . '\');}else{fillDateAdded(\'\',\'\',\'\');}">&nbsp;Post Immediately (Auto-Fill Date)</td></tr>'; ?>
                                <tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                </tr>
                                <tr>
                                    <td class="main"><?php echo 'Posting Date:'; ?>
                                    </td>
                                    <td class="main"><?php
                                    $hour_array = array();
                                    for($i = 0; $i < 24; $i++){
                                        $hour_array[] = array('id'=>($i<10?'0'.$i:$i),'text'=>($i<10?'0'.$i:$i));
                                    }
                                    $min_array = array();
                                    for($i = 0; $i < 60; $i++){
                                        $min_array[] = array('id'=>($i<10?'0'.$i:$i),'text'=>($i<10?'0'.$i:$i));
                                    }
                                    ?>
                                        <INPUT id="datepicker" style="text-align: center;" NAME="articles_date_available" TYPE="text" SIZE="10" MAXLENGTH="30"  VALUE="<?php echo $article['articles_date_available']; ?>" /><small>(MM/DD/YYYY)</small>&nbsp;<?php echo tep_draw_pull_down_menu('date_avilable_hour',$hour_array,$article['articles_date_available_hour']);?>&nbsp;<small>hh</small>&nbsp;:&nbsp;<?php echo tep_draw_pull_down_menu('date_avilable_min',$min_array,$article['articles_date_available_min']);?>&nbsp;<small>mm</small>
                                    </td>
                                </tr>
								<tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                </tr>
                                <tr>
                                    <td class="main">Date&nbsp;Modified:</td>
                                    <td class="main">
										<?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;';
                                        echo $article['date_modified_formatted'];
?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                </tr>
                                <tr>
                                    <td class="main"><?php echo 'Categories: '; ?></td>
                                    <td class="main"><?php //echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_mselect_menu('categories_ids[]', $categories_array, $categories_array_selected, 'size=10'); ?>
                                    <?php
                                        for ($i = 0; $i < sizeof($categories_array); $i++) {
                                            if (in_array($categories_array[$i]['id'], $categories_array_selected)) {
                                                $checked = true;
                                            }elseif (isset($_GET['tPath']) && $_GET['tPath'] == '30' && $_GET['tPath'] == $categories_array[$i]['id']){
                                                $checked = true;
                                            } else {
                                                $checked = false;
                                            }
                                            //echo tep_draw_checkbox_field('categories_ids[' . $i . ']', $categories_array[$i]['id'], $checked, '', 'onclick="if(this.checked==true)document.getElementById(\'publish_on_hc\').checked=true;"') . '&nbsp;' . $categories_array[$i]['text'] . '<br>';
											echo tep_draw_checkbox_field('categories_ids[' . $i . ']', $categories_array[$i]['id'], $checked) . '&nbsp;' . $categories_array[$i]['text'] . '<br>';
                                        }
                                    ?>
                                        </span></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                </tr>
                                <tr>
                                    <td class="main" valign="top">Publish To:</td>
                                    <td>	<table>
                                            <tr><td class="main"><input type="checkbox" name="publish_on_twitter" <?php if ($aInfo->publish_on_twitter == 1)
                                            echo 'checked'; ?>/>Twitter</td></tr>
                                            <tr><td class="main"><input type="checkbox" name="publish_on_facebook" <?php if ($aInfo->publish_on_facebook == 1)
                                            echo 'checked'; ?>/>Facebook</td></tr>
                                            <tr><td class="main"><input type="checkbox" name="publish_on_wordpress" <?php if ($aInfo->publish_on_wordpress == 1)
                                            echo 'checked'; ?>/>Wordpress</td></tr>
                                             <tr><td class="main"><input type="checkbox" name="publish_on_yahoo_groups" <?php if($aInfo->publish_on_yahoo_groups==1) echo 'checked';?>/>Yahoo Groups</td></tr>
                                            <tr><td class="main"><input type="checkbox" name="publish_on_google_groups" <?php if($aInfo->publish_on_google_groups==1) echo 'checked';?>/>Google Groups</td></tr>

                                            <tr><td class="main"><input type="checkbox" name="publish_on_hc" id="publish_on_hc"<?php if ($aInfo->publish_on_hc == 1)
                                            echo 'checked'; ?>/>Healingcrystals.com</td></tr>
                                            <tr><td class="main"><input type="checkbox" name="daily_nugget" <?php if ($aInfo->daily_nugget == '1')
                                            echo 'checked'; ?>/>The Daily Nugget<input type="hidden" name="is_daily_nugget_sent" value="<?php echo $aInfo->is_daily_nugget_sent ; ?>"><input type="hidden" name="lists_nugget_id" value="<?php echo $aInfo->lists_nugget_id ; ?>"></td></tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                        </tr>

                                        <tr>
                                            <td class="main"><?php echo TEXT_ARTICLES_AUTHOR; ?></td>
                                            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_pull_down_menu('authors_id', $authors_array, $aInfo->authors_id); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                        </tr>
                            <?php
                                        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                            ?>
                                            <tr>
                                                <td class="main"><?php if ($i == 0)
                                                echo TEXT_ARTICLES_NAME; ?></td>
                                                <td class="main">
<?php echo tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('articles_name[' . $languages[$i]['id'] . ']', (isset($articles_name[$languages[$i]['id']]) ? $articles_name[$languages[$i]['id']] : tep_get_articles_name($aInfo->articles_id, $languages[$i]['id'])), 'size="105"'); ?></td>
                                            </tr>
<?php
                                        }
?>

                                <tr>
                                    <td class="main">Articles Tags:</td>
                                    <td class="main"><?php echo tep_draw_input_field('taglist', '', 'id="taglist" size="75"'); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?php
                                        echo tep_draw_separator('pixel_trans.gif', '100%', '5');
?></td>
                            </tr>
                            <tr>
                                <td class="main"></td>
                                <td class="main">
                                    <div>Current tags:(click to delete)</div>
                                    <div id="current_tags" class="current_tags" style="border:1px solid #cccccc;">
<?php
                                        $current_tags_query = tep_db_query("select tag_id from tags_to_articles where articles_id = '" . $HTTP_GET_VARS['aID'] . "'");
                                        while ($current_tags = tep_db_fetch_array($current_tags_query)) {
                                            $tag_name = tep_get_tag_name($current_tags['tag_id']);
                                            echo '<span id="span' . $current_tags['tag_id'] . '" style="padding-left:20px; padding-right:20px; text-align:center;"><a href="javascript: void(0);" class="delete_tag" onclick="remove_tags(\'' . $current_tags['tag_id'] . '\');">' . tep_draw_separator('pixel_trans.gif', '10', '10') . $tag_name . '</a></span>';
                                            echo '<input type="hidden" name="delete_tag[' . $current_tags['tag_id'] . ']" id="delete_tag[' . $current_tags['tag_id'] . ']" value="">';
                                        }
?>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?php
                                        echo tep_draw_separator('pixel_trans.gif', '100%', '5');
?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td ><table cellpadding="0" cellspacing="0" border="0"><tr>
                                                <td>
                                                    <table cellpadding="0" cellspacing="5" border="1" width="100%">
                                                        <tr>
                                                            <td class="main">
    				    Most Recently Used Tags:(click to add)
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="main">
<?php
                                        $recently_used_tag_query = tep_db_query("select tag_name from taglist order by last_added desc limit 10");
                                        while ($recently_used_tag = tep_db_fetch_array($recently_used_tag_query)) {
                                            echo '<a href="javascript: void(0)" onclick="fill_tag(\'' . $recently_used_tag['tag_name'] . '\')" >' . $recently_used_tag['tag_name'] . '</a>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                        }
?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table cellpadding="0" cellspacing="5" border="1" width="100%">
                                                    <tr>
                                                        <td class="main">
				    Most Popular Tags:(click to add)
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="main">
<?php
                                        $popular_tag_query = tep_db_query("select tag_name from taglist order by tag_usage desc limit 10");
                                        while ($popular_tag = tep_db_fetch_array($popular_tag_query)) {
                                            echo '<a href="javascript: void(0)" onclick="fill_tag(\'' . $popular_tag['tag_name'] . '\')" >' . $popular_tag['tag_name'] . '</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                        }
?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr></table></td>
                            </tr>

                            <?php
                                        $_POST['articles_head_title_tag'] = '';

                                        $_POST['articles_head_desc_tag'] = '';

                                        $_POST['articles_head_keywords_tag'] = '';
                            ?>


                                        <tr>
                                            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                        </tr>





                                        <td class="main">Healing Crystals Post URL:</td>
                                        <td class="main">

                                <?php
                                        $urlid = get_rand_id(3);
                                        echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;';

                                        if ($HTTP_GET_VARS['aID'] != '' && $aInfo->twitter_url != '') {
                                            echo '<a href="'.tep_catalog_href_link('article_info.php', 'articles_id='.$HTTP_GET_VARS['aID'].'&preview=on').'" target="_blank">'.tep_get_articles_url1($aInfo->twitter_url).'</a>';
                                            echo tep_draw_hidden_field('twitter_url', $aInfo->twitter_url);
                                        } else {
                                            echo tep_draw_hidden_field('twitter_url', $urlid) . tep_get_articles_url1($urlid);
                                        }
                                ?>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td class="main" colspan="2">Twitter Revisions:</td>
                                </tr>
                                <tr>
                                    <td class="main" colspan="2">
                                        <table border="0">
                                <?php
                                    $ii=1;
                                    $revision_query = tep_db_query("select * from articles_revision where articles_id = '".$aInfo->articles_id."' and article_type = 't' order by date_added ASC");
                                    while($revision_array = tep_db_fetch_array($revision_query)){
                                        echo '<tr><td class="main"><input type="radio" name="loadRevision" onclick="document.getElementById(\'articles_description_twi[1]\').innerHTML=\''.callback(htmlspecialchars($revision_array['articles_description'])).'\';"/>Version# '.$ii.' saved by '.$revision_array['user'] .' on '.  $revision_array['date_added'].'</td></tr>';
                                        $ii++;
                                    }
                                ?>
                                        </table>
                                    </td>
                                </tr>
                                    <tr>
                                        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="main" colspan="2" width="100%"><span id="count" style="color:00ff00; padding-right:25px;">Short Post Character Count: 0</span>

										<span class="main">(140 Character Limit <i>133 in case of inserting link without http</i>)</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                </tr>
                                <tr><td class="main" valign="top">Short Post:<br />- Twitter</td><td><?php echo tep_draw_textarea_field('twitter_content[1]', 'soft', '100', '2', stripslashes($twitter_content[1]), 'id="articles_description_twi[1]" onKeyUp="articleCount();"'); ?></td></tr>
                                <tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                        </tr>
                                        <tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                        </tr>
                                        <tr>
                                    <td class="main" colspan="2">Facebook Revisions:</td>
                                </tr>
                                <tr>
                                    <td class="main" colspan="2">
                                        <table border="0">
                                <?php
                                    $ii=1;
                                    $revision_query = tep_db_query("select * from articles_revision where articles_id = '".$aInfo->articles_id."' and article_type = 'f' order by date_added ASC");
                                    while($revision_array = tep_db_fetch_array($revision_query)){
                                        echo '<tr><td class="main"><input type="radio" name="loadRevision" onclick="document.getElementById(\'articles_description_fb[1]\').innerHTML=\''.callback(htmlspecialchars($revision_array['articles_description'])).'\';"/>Version# '.$ii.' saved by '.$revision_array['user'] .' on '.  $revision_array['date_added'].'</td></tr>';
                                        $ii++;
                                    }
                                ?>
                                        </table>
                                    </td>
                                </tr>
<?php // if($_GET['tPath']==17){ ?>
                                        <tr>
                                            <td class="main" colspan="2" width="100%"><span id="fbcount" style="color:00ff00; padding-right:25px;">Medium Post Character Count: 0</span>

											<span class="main">(420 Character Limit)</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                        </tr>
                                        <tr><td class="main" valign="top" nowrap="nowrap">Medium Post:<br />- Facebook<br />- Wordpress<br />- Yahoo Groups<br />- Google Groups</td><td><?php echo tep_draw_textarea_field('facebook_content[1]', 'soft', '100', '7', stripslashes($facebook_content[1]), 'id="articles_description_fb[1]" onKeyUp="fbArticleCount();"'); ?></td></tr>
                                <tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                </tr>

                                <tr><td class="main">Facebook Image Title:</td><td><?php echo tep_draw_input_field('fb_image_title', $aInfo->fb_image_title); ?>&nbsp;(Image Title Required to Post Image on FB) </td></tr>
                                <tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                </tr>
                                <tr><td class="main" valign="top">Facebook Image URL:</td>
                                    <td class="main">
                                    <?php
                                    if (strpos($aInfo->facebook_publishing_date, '00-00-00') === false && $aInfo->facebook_publishing_date != '' && $aInfo->facebook_error_message == ''){
                                        echo $aInfo->fb_image_url!=''?'<input type="hidden" name="fb_image_url" value="'.$aInfo->fb_image_url.'"/><img src="'.$aInfo->fb_image_url.'" border="0"/>':tep_draw_file_field('fb_image_url', $aInfo->fb_image_url);
                                    }else{
                                        if($aInfo->fb_image_url!=''){
                                            echo tep_draw_file_field('fb_image_url');
                                            echo tep_draw_checkbox_field('delete_fb_image','1').'Delete Image<br/>';
                                            echo '<input type="hidden" name="fb_image_url" value="'.$aInfo->fb_image_url.'"/><img src="'.$aInfo->fb_image_url.'" border="0"/>';
                                        }else{
                                            echo tep_draw_file_field('fb_image_url', $aInfo->fb_image_url);

                                        }

                                    }
?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                </tr>
                                <tr><td class="main">Facebook Image Link:</td><td><?php echo tep_draw_input_field('fb_image_link', $aInfo->fb_image_link); ?></td></tr>
                                <tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                </tr>
                                <tr><td class="main">Facebook Image Description:</td><td><?php echo tep_draw_textarea_field('fb_image_desc', 'soft', '100', '2', $aInfo->fb_image_desc); ?></td></tr>
                                <tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                </tr>
                                 <tr>
                                    <td class="main" colspan="2">Article Revisions:</td>
                                </tr>
                                <tr>
                                    <td class="main" colspan="2">
                                        <table border="0">
                                <?php
                                    $ii=1;
                                    $revision_query = tep_db_query("select * from articles_revision where articles_id = '".$aInfo->articles_id."' order by date_added ASC");
                                    while($revision_array = tep_db_fetch_array($revision_query)){
                                        echo '<tr><td class="main"><input type="radio" name="loadRevision" onclick="document.getElementById(\'editor1\').innerHTML=\''.callback(htmlspecialchars($revision_array['articles_description'])).'\';CKEDITOR.instances.editor1.setData(\''.callback(htmlspecialchars($revision_array['articles_description'])).'\')"/>Version# '.$ii.' saved by '.$revision_array['user'] .' on '.  $revision_array['date_added'].'</td></tr>';
                                        $ii++;
                                    }
                                ?>
                                        </table>
                                    </td>
                                </tr>
                                 <tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                </tr>
                                <tr><td class="main">Healing Crystals Post:</td><td>
                                    <?php
                                    /*if($HTTP_GET_VARS['kayako_comment_id']!='' && $HTTP_GET_VARS['aID'] == ''){
                                       $link = mysql_connect('localhost', DB_KAYAKO_USERNAME, DB_KAYAKO_PASSWORD);
                                       mysql_select_db(DB_KAYAKO_DATABASE);
                                      // echo "select contents from swticketposts where ticketpostid = '".$HTTP_GET_VARS['kayako_comment_id']."'";
                                       $commentQuery = mysql_query("select contents from swticketposts where ticketpostid = '".$HTTP_GET_VARS['kayako_comment_id']."'");
                                       if(mysql_num_rows($commentQuery)){
                                           $comment_array = mysql_fetch_array($commentQuery);
                                           $articles_description[1] = clean_html_code($comment_array['contents']);

                                       }
                                       mysql_close();
                                       tep_db_connect();
                                    }*/
                                    ?>
                                        <textarea class="ckeditor" cols="100" id="editor1" name="articles_description[1]" rows="40"><?php echo $articles_description[1]; ?></textarea>
                                    </td></tr>
                                <tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                </tr>
                                            <script>
                                                CKEDITOR.replace( 'editor1', {
                                                    height: 300,
                                                    filebrowserUploadUrl: "./upload.php",
                                                


                                                } );
                                            </script>




                                <script>
<?php //if($_GET['tPath']==17){ ?>
            articleCount();

                                </script>
                                <tr>
                                    <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                </tr>

                                        <tr>
                                            <td class="dataTableRow" valign="top"><span class="main">Add Image to Article:</span></td>
<?php if ((HTML_AREA_WYSIWYG_DISABLE_JPSY == 'Disable') or (HTML_AREA_WYSIWYG_DISABLE == 'Disable')) { ?>
                                                <td class="dataTableRow" valign="top"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('articles_image') . '<br>'; ?>
<?php } else { ?>
                                                    <td class="dataTableRow" valign="top"><span class="smallText"><?php
                                            echo '<table border="0" cellspacing="0" cellpadding="0"><tr><td class="main">' . tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp; </td><td class="dataTableRow">' . tep_draw_textarea_field('articles_image', 'soft', '70', '2', $aInfo->articles_image) . tep_draw_hidden_field('articles_previous_image', $aInfo->articles_image) . '</td></tr></table>';
                                        } if
                                        (($HTTP_GET_VARS['aID']) && ($aInfo->articles_image) != '')
                                            echo tep_draw_separator('pixel_trans.gif', '24', '17" align="left') . $aInfo->articles_image . tep_image(DIR_WS_CATALOG_IMAGES . $aInfo->articles_image, $aInfo->articles_image, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'align="left" hspace="0" vspace="5"') . tep_draw_hidden_field('articles_previous_image', $aInfo->articles_image) . '<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="unlink_image" value="yes">Unlink Image<br>' . tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_image" value="yes">Delete Image<br>' . tep_draw_separator('pixel_trans.gif', '1', '42'); ?></span></td>
                            </tr>

                            <?php
                                        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
?>
                                            <tr>
                                                <td class="main"><?php if ($i == 0)
                                                echo 'Existing Image URL:'. '<br><small>' . TEXT_ARTICLES_URL_WITHOUT_HTTP . '</small>'; ?></td>
                                                <td class="main"><?php echo tep_image(DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field('articles_url[' . $languages[$i]['id'] . ']', (isset($articles_url[$languages[$i]['id']]) ? $articles_url[$languages[$i]['id']] : tep_get_articles_url($aInfo->articles_id, $languages[$i]['id'])), 'size="35"'); ?></td>
                                            </tr>
<?php
                                        }
?>
                           <tr>
                                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                            </tr>
							<tr>
                                <td class="dataTableRow" valign="top"><span class="main">Upload Video:</span></td>
                                <td class="dataTableRow" valign="top"><span class="smallText"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_file_field('articles_video') . '<br>'; ?>
                                       <?php
					if(($HTTP_GET_VARS['aID']) && ($aInfo->articles_video) != '')
                           echo tep_draw_separator('pixel_trans.gif', '24', '17" align="left') . $aInfo->articles_video . tep_draw_hidden_field('articles_previous_video', $aInfo->articles_video) . '<br>'. tep_draw_separator('pixel_trans.gif', '5', '15') . '&nbsp;<input type="checkbox" name="delete_video" value="yes">Delete Video<br>' . tep_draw_separator('pixel_trans.gif', '1', '42');

						   ?>
						   </span>
						   </td>
                            </tr>
							<tr>
                                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
                            </tr>
                            <?php
                            $link_array = array();
                            if($aInfo->links_id!=''){
                            $link_query = tep_db_query("select l.links_url, ld.links_title, ld.links_description, lc.link_categories_name from links l, links_description ld, links_to_link_categories l2c, link_categories_description lc where l.links_id = ld.links_id and ld.language_id = 1 and l2c.links_id = l.links_id and l2c.link_categories_id = lc.link_categories_id and lc.language_id = 1 and l.links_id = ".$aInfo->links_id);
                            $link_array = tep_db_fetch_array($link_query);
                            echo tep_draw_hidden_field('links_id',$aInfo->links_id);
                            }
                            ?>
                            <tr>
                                <td class="main"><?php echo 'Link Title:'; ?></td>
                                <td class="main"><?php echo tep_draw_input_field('links_title', $link_array['links_title'], 'maxlength="64"  SIZE="40"', false); ?></td>
                            </tr>
                            <tr>
                                <td class="main"><?php echo 'Link URL:'; ?></td>
                                <td class="main"><?php echo tep_draw_input_field('links_url', $link_array['links_url']!=''?$link_array['links_url']:'http://', 'maxlength="255" SIZE="55"', false); ?></td>
                            </tr>
                            <tr>
<?php
                                                $categories_array = array();
                                                $categories_array[] = array('id' => '', 'text' => 'Select Link Category');
                                                $categories_query = tep_db_query("select lcd.link_categories_id, lcd.link_categories_name from " . TABLE_LINK_CATEGORIES_DESCRIPTION . " lcd where language_id = '" . (int) $languages_id . "' order by lcd.link_categories_name");
                                                while ($categories_values = tep_db_fetch_array($categories_query)) {
                                                    $categories_array[] = array('id' => $categories_values['link_categories_name'], 'text' => $categories_values['link_categories_name']);
                                                }
?>
                                                <td class="main"><?php echo 'Link Category:'; ?></td>
                                                <td class="main"><?php echo tep_draw_pull_down_menu('links_category', $categories_array, $link_array['link_categories_name'], '', false); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="main"><?php echo 'Link Description'; ?></td>
                                                <td class="main"><?php echo tep_draw_textarea_field('links_description', 'hard', 100, 6, $link_array['links_description']); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                                            </tr>
                                        </table></td>
                            </tr>
                            <tr>
                                <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                            </tr>
                            <tr>
                                <td class="main" align="right"><?php echo tep_image_submit('button_save.gif', 'Save') . '&nbsp;&nbsp;<a href="' . tep_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . (isset($HTTP_GET_VARS['aID']) ? '&aID=' . $HTTP_GET_VARS['aID'] : '' . '&empty=1')) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>'; ?></td>
                            </tr>
                        </table></form>
<?php
                                                //MaxiDVD Added WYSIWYG HTML Area Box + Admin Function v1.7 - 2.2 MS2 Articles Description HTML - </form>
                                                if (ARTICLE_WYSIWYG_ENABLE == 'Enable') {
?>
                                                    <script language="JavaScript1.2" defer>
                                                        var config = new Object();  // create new config object
                                                        config.width = "<?php echo ARTICLE_MANAGER_WYSIWYG_WIDTH; ?>px";
                                                        config.height = "<?php echo ARTICLE_MANAGER_WYSIWYG_HEIGHT; ?>px";
                                                        config.bodyStyle = 'background-color: <?php echo ARTICLE_MANAGER_WYSIWYG_BG_COLOUR; ?>; font-family: "<?php echo ARTICLE_MANAGER_WYSIWYG_FONT_TYPE; ?>"; color: <?php echo ARTICLE_MANAGER_WYSIWYG_FONT_COLOUR; ?>; font-size: <?php echo ARTICLE_MANAGER_WYSIWYG_FONT_SIZE; ?>pt;';
                                                        config.debug = <?php echo ARTICLE_MANAGER_WYSIWYG_DEBUG; ?>;
<?php for ($i = 0, $n = sizeof($languages); $i < $n; $i++) { ?>
                                                                //editor_generate('articles_description[<?php echo $languages[$i]['id']; ?>]',config);
<?php } ?>
                                                                config.height = "35px";
                                                                config.bodyStyle = 'background-color: white; font-family: Arial; color: black; font-size: 12px;';
                                                                config.toolbar = [ ['InsertImageURL'] ];
                                                                config.OscImageRoot = '<?= trim(HTTP_SERVER . DIR_WS_CATALOG_IMAGES) ?>';
                                                    </script>
<?php
                                                }
                                            }
?>
                                        </td>
                                        <!-- body_text_eof //-->
                                        </tr>
                                        </table>
                                        <!-- body_eof //-->

                                        <!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
                                        <!-- footer_eof //-->
                                        <br>
                                        </body>
                                        </html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

