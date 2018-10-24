<?php ob_start();?>
<!doctype html>
<html <?php echo HTML_PARAMS; ?>>
<head>
</pre>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
<meta name="avgthreatlabs-verification" content="911cbfb2a2019e26cb59574f72a80e5e74198d5e" />
<meta property="og:image" content="/images/amethsyt.jpg"/>
<meta property="og:image" content="/images/mandala400.jpg"/>
<meta property="og:image" content="/images/fbMandala.png"/>
<meta property="og:title" content="HealingCrystals.Com"/>
<meta property="og:url" content="<?php echo HTTP_SERVER; ?>"/>
<meta property="og:description" content="A metaphysical crystal shop, with free resources, wholesale crystals, accessories and much more!"/>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<?php 

if (file_exists(DIR_WS_INCLUDES . 'header_tags.php')) {
            require(DIR_WS_INCLUDES . 'header_tags.php');
        } else {
        ?>
<title><?php echo TITLE ?></title>
<?php
        }
        ?>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Cooper Black">
<link rel="stylesheet" type="text/css" href="/fonts/Tahoma.ttf">
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<?php
		//echo '<pre>';print_r($_GET); echo '</pre>'; exit;


        if (basename($PHP_SELF) == 'sale_specials_text.php' || basename($PHP_SELF) == 'sale_specials.php') {
            echo '<link rel="canonical" href="' . tep_href_link('specials.html') . '">';
        } elseif (basename($PHP_SELF) == 'articles.php' && ($_GET['tPath'] == '3' || $_GET['tPath'] == '13')) {
            echo '<link rel="canonical" href="' . tep_href_link('articles.php', 'tPath=3') . '">';
        } elseif (basename($PHP_SELF) == 'product_info.php') {

            echo '<link rel="canonical" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $HTTP_GET_VARS['products_id']) . '">';
        }elseif (basename($PHP_SELF) == 'products.php') {
            echo '<link rel="canonical" href="' . tep_href_link('products.php', tep_get_all_get_params(array('products_display','action'))) . '">';
        }
		elseif (basename($PHP_SELF) == 'products1.php') {

            echo '<link rel="canonical" href="' . tep_href_link('products1.php', tep_get_all_get_params(array('products_display','action'))) . '">';
        } elseif (basename($PHP_SELF) == 'index.php' && !isset($HTTP_GET_VARS['cPath']) || basename($PHP_SELF) == 'index-copy.php' && !isset($HTTP_GET_VARS['cPath']) || basename($PHP_SELF) == 'index-copy1.php' && !isset($HTTP_GET_VARS['cPath'])) {

            echo '<link rel="canonical" href="/">';
        } elseif (basename($PHP_SELF) == 'article_info.php') {
            echo '<link rel="canonical" href="' . tep_href_link('article_info.php', 'articles_id=' . $HTTP_GET_VARS['articles_id']) . '">';
        }     
               if (basename($PHP_SELF) == 'subscribe.php' || basename($PHP_SELF) == 'rewards_subscribe.php'){
                    ?>
<link rel="stylesheet" type="text/css" href="<?=STATIC_URL?>templates/New4/stylesheet_subs.css">
<?php
                }elseif (basename($PHP_SELF) == 'products.php' && $_GET['category'] == 'C'){ ?>
<link rel="stylesheet" type="text/css" href="<?=STATIC_URL?>templates/New4/stylesheet_latest.css">
<?php
                }elseif (basename($PHP_SELF) == 'index-copy5.php'){ ?>
<link rel="stylesheet" type="text/css" href="<?=STATIC_URL?>templates/New4/stylesheet_latest.css">
<?php
                }
                else {?>
<link rel="stylesheet" type="text/css" href="<?=STATIC_URL?>templates/New4/stylesheet_latest.css">
<?php
                }
    ?>
<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php echo tep_href_link('newsFeed.xml'); ?>">
<?php
        if ($javascript) {
            require(DIR_WS_JAVASCRIPT . $javascript);
        }
        ?>
<script language="javascript" type="text/javascript" src="<?=STATIC_URL?>jqueryAndTabs.js.php"></script>
<script type="text/javascript">
            $(document).ready(function(){
                $('#shortSurvey').submit(function(){                          
                    $.ajax({
                        type: "POST",
                        url: "saveSurveyResults.php",
                        async: false,
                        data: { sid: $('input[name=surveyid]').val(), gid: $('input[name=groupid]').val(), qid: $('input[name=questionid]').val(), answer: $('input[name=answer]:checked').val() },
                        success: function(data) {                                
                                $('#shortSurveyDiv').html(data);
                            }
                        });
                    return false
                });
            });
        </script>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5JDPDKS');</script>
    <!-- End Google Tag Manager -->

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=healingcrystals"></script>
<style>
#showLeftMenuButton img {
	display: none;
}
body > pre {display: none;}
</style>
</head>
<body <?php
        if (isset($HTTP_GET_VARS['image'])) {
            echo ' "onLoad="document.getElementById(\'products_image\').scrollIntoView(true); init()"';
        } else {
            echo 'onload="init()"';
        } ?>>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5JDPDKS"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<script type="text/javascript" src="wz_tooltip.js"></script>
<?php require(DIR_WS_INCLUDES . 'warnings.php'); ?>
<?php

        if($HTTP_GET_VARS['screenshot_preview']!='1'){
                if(!isset($HTTP_GET_VARS['vendor'])){
                      if (basename($PHP_SELF) == 'subscribe.php'){
                          require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/header_cutpolishedlatest.php');
                     //   require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/header_subs.php');
                       } /*elseif (basename($PHP_SELF) == 'sale_specials.php'){
                          require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/header_cutpolishedlatest12.php');
                     //   require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/header_subs.php');
                       }*/ else{
                        require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/header_cutpolishedlatest.php');
                        }
                }else{
                        require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/header_suppliers.php');
                }
        }
			  
        ?>
<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_MAIN; ?>" class="main-container">
	<tr>
		<?php
                if (DOWN_FOR_MAINTENANCE == 'true') {
                    $maintenance_on_at_time_raw = tep_db_query("select last_modified from " . table_CONFIGURATION . " WHERE configuration_key = 'DOWN_FOR_MAINTENANCE'");
                    $maintenance_on_at_time = tep_db_fetch_array($maintenance_on_at_time_raw);
                    define('TEXT_DATE_TIME', $maintenance_on_at_time['last_modified']);
                }
                ?>
		<?php
                if($HTTP_GET_VARS['screenshot_preview']!='1' && (!isset($HTTP_GET_VARS['vendor']))){
                
                if (DISPLAY_COLUMN_LEFT == 'yes') {
// WebMakers.com Added: Down for Maintenance
// Hide column_left.php if not to show
                    $visible = 'block';
                    if (basename($PHP_SELF) != 'product_info.php'){
					//$visible = 'none';
                    	if (DOWN_FOR_MAINTENANCE == 'false' || DOWN_FOR_MAINTENANCE_COLUMN_LEFT_OFF == 'false') {
                        //if (!isset($HTTP_GET_VARS['image'])){
                ?>
		<td class="leftNav TDw100"  width="<?php //echo BOX_WIDTH_LEFT; ?>" valign="top" id="columnLeft" ><table id="leftmenubutton" cellSpacing=0 width=0  border=0 style="border-collapse: collapse; display:<?php echo $tbl_left_style ?>;" cellpadding="0">
				<?php 
                            if (basename($PHP_SELF) == 'cards.php'){
                              require(DIR_WS_INCLUDES . 'column_left_cards.php'); 
                           }
//                            elseif(basename($PHP_SELF) == 'products.php' && $_GET['category'] == 'C'){
//                               //  require(DIR_WS_INCLUDES . 'column_left.php'); 
//                            }elseif(basename($PHP_SELF) == 'products.php' && $_GET['category'] == 'T'){
//                               //  require(DIR_WS_INCLUDES . 'column_left.php'); 
//                            }elseif(basename($PHP_SELF) == 'products.php' && $_GET['category'] == 'J'){
//                               //  require(DIR_WS_INCLUDES . 'column_left.php'); 
//                            }elseif(basename($PHP_SELF) == 'products.php' && $_GET['category'] == 'N'){
//                               //  require(DIR_WS_INCLUDES . 'column_left.php'); 
//                            }elseif(basename($PHP_SELF) == 'products.php' && $_GET['category'] == 'NQ'){
//                               //  require(DIR_WS_INCLUDES . 'column_left.php'); 
//                            } elseif(basename($PHP_SELF) == 'index-copy5.php'){
//                               //  require(DIR_WS_INCLUDES . 'column_left.php'); 
//                            }elseif(basename($PHP_SELF) == 'grading_summary.php'){
//                               //  require(DIR_WS_INCLUDES . 'column_left.php'); 
//                            }
                           //echo $PHP_SELF.'<br>'.$_GET['category'];
                           /*die;*/
                           if(basename($PHP_SELF) == 'products.php' && $_GET['category'] == 'J'){
                            require(DIR_WS_INCLUDES . 'column_left.php'); 
                           }
                           if(basename($PHP_SELF) == 'products.php' && $_GET['category'] == 'C'){
                            require(DIR_WS_INCLUDES . 'column_left.php'); 
                           }
                           if(basename($PHP_SELF) == 'articles.php'){
                            require(DIR_WS_INCLUDES . 'column_left.php'); 
                           }
                           

                           if(basename($PHP_SELF) == 'index.php'){
                            require(DIR_WS_INCLUDES . 'column_left.php'); 
                           }
                          /* else
                           {  
                            require(DIR_WS_INCLUDES . 'column_left.php'); 
                            } */   ?>
			</table></td>
		<?php
						}
                    }
                }
                ?>
		<td class="TDw100"><?= tep_draw_separator("spacer.gif", '10', '1') ?></td>
		<?php
                }
                ob_flush();
               // ob_start();
                ?>
		<?php
			   //echo $_GET['category'];
			   /*if($HTTP_GET_VARS['show']=='crystals')

				{	
				$HTTP_GET_VARS['category']='J';
				}
				*/
				 //echo '<pre>';print_r($HTTP_GET_VARS);echo '</pre>';
                if(basename($PHP_SELF) == 'grading_summary.php'){
                    ?>
		<td class="TDw100" width="80%" valign="top" id="mainContentTD"><?php if($HTTP_GET_VARS['screenshot_preview']!='1')
                    { 
                            if(tep_session_is_registered('is_retail_store')){
                                echo HEADING_TOP;
                            }
                            if(basename($PHP_SELF) == 'products1.php'){
                            require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/pageheading1.php'); }
                            else{ 
                            require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/pageheading.php'); 

                            }
                    }
			?>
			<?php
					
                    if (isset($content_template)) {
                        require(DIR_WS_CONTENT . $content_template);
                    } else {
                        require(DIR_WS_CONTENT . $content . '.tpl.php');
                    }
                    ob_flush();
                   //  ob_start();
                    //echo basename($PHP_SELF);
                    ?></td>
		<?php
                }else{?>
		<td class="TDw100" width="100%" valign="top" id="mainContentTD"><?php if($HTTP_GET_VARS['screenshot_preview']!='1')
                    { 
                            if(tep_session_is_registered('is_retail_store')){
                                echo HEADING_TOP;
                            }
                            if(basename($PHP_SELF) == 'products1.php'){
                            require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/pageheading1.php'); }
                            else{ 
                            require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/pageheading.php'); 

                            }
                    }
			?>
			<?php
					
					if (isset($content_template)) {
                        require(DIR_WS_CONTENT . $content_template);
                    } else {
						// echo DIR_WS_CONTENT . $content . '.tpl.php';
                        require(DIR_WS_CONTENT . $content . '.tpl.php');
				    }
                    ob_flush();
                   //  ob_start();
                    //echo basename($PHP_SELF);
                    ?></td>
		<?php } ?>
		<td class="TDw100" ><?= tep_draw_separator("spacer.gif", '1', '1') ?></td>
		<?php
// WebMakers.com Added: Down for Maintenance
// Hide column_right.php if not to show
				$products_single_image_array = array();
                    if (DISPLAY_COLUMN_RIGHT == 'yes' || (basename($PHP_SELF) == 'index-copy2.php' && !isset($HTTP_GET_VARS['cPath'])) || (basename($PHP_SELF) == 'index-copy1.php' && !isset($HTTP_GET_VARS['cPath'])) || (basename($PHP_SELF) == 'index-copy.php' && !isset($HTTP_GET_VARS['cPath'])) || (basename($PHP_SELF) == FILENAME_DEFAULT && !isset($HTTP_GET_VARS['cPath']))) {
                        if (DOWN_FOR_MAINTENANCE == 'false' || DOWN_FOR_MAINTENANCE_COLUMN_RIGHT_OFF == 'false') {
                ?>
		
		<!--                        <td style="max-width:180px;" width="180" valign="top" align="right">
                            <table border="0" width="180" cellspacing="0" cellpadding="2" style="max-width:180px">
                                <tr>
                                    <td>
                                        <table cellspacing="0" cellpadding="0" border="0" class="leftNavTable">
                                            <tr>
                                                <td valign="bottom">
                                                    <div class="glossymenuHeader" style="width:180px;margin-bottom:5px;">
                                                        <a class="menuitemNE menuitem" href="javascript:void(0);">Featured Item</a>
                                                        <div  class="submenurightContent" style="max-width:180px;">
                                                            <table class="submenuAff" cellpadding="0" cellspacing="0" width="100%" align="center">
                                                                <tr>
                                                                    <td style="padding: 11px 17px;">
                                                                        <?php
                                                                    //    $featured_query = tep_db_query("select f.products_id, f.expires_date, p.products_image, pd.products_name from featured f, products p, products_description pd where f.products_id = p.products_id and f.products_id = pd.products_id and p.products_status = '1' and f.status = '1' and p.products_image != '' and (f.expires_date > now() || f.expires_date = '0000-00-00 00:00:00' )");
                                                                     //   $num_rows = tep_db_num_rows($featured_query);
//                                                                        $fpnameStr = '';
//                                                                        $fimgsString = '';
//                                                                        $display = true;
//                                                                        while($featured = tep_db_fetch_array($featured_query)){

                                                                                //$fimgsString .= '["images/' . $featured['products_image'] . '", "' . tep_href_link('product_info.php', 'products_id=' . $featured['products_id']) . '","","' . $featured['products_name'] . '"]' . ($x<$num_rows ? ',' : '');
//                                                                                $fimgsString .= '<img onclick="location.href=\'' . tep_href_link('product_info.php', 'products_id=' . $featured['products_id']) . '\'" src="images/' . $featured['products_image'] . '" alt="" ' . ($display ? '' : ' style="display:none;" ') . '>';
//                                                                                $fpnameStr .= '<span class="fpname" ' . ($display ? '' : ' style="display:none;" ') . '  onclick="location.href=\'' . tep_href_link('product_info.php', 'products_id=' . $featured['products_id']) . '\'">' . $featured['products_name'] . '</span>';
//                                                                                $products_single_image_array[] = 'images/' . $featured['products_image'];
//                                                                                $display = false;
                                                                                //$src = 'images/'.$featured['products_image'];
                                                                       // }

                                                                        ?>

                                                                        <div id="s1" class="ffadein"><?php 
//                                                                        echo $fimgsString;
                                                                        ?>							
                                                                        </div>
                                                                        <div id="s1" class="ffadename"><?php 
                                                                     //   echo $fpnameStr;
                                                                        ?>							
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
            

            
                                            <tr>
                                                <td valign="bottom" style="max-width:180px;">
                                                    <div class="glossymenuHeader" style="width:180px;margin-bottom:5px;"><a class="menuitemNE menuitem" href="javascript:void(0);">On Sale Today</a>
                                                        <div style="max-width:180px;" class="submenurightContent">
                                                            <table class="submenuAff" cellpadding="0" cellspacing="0" width="100%" align="center">
                                                                <tr>
                                                                    <td style="padding: 11px 17px;">
                                                                        <?php
//                                                                       $specials_query = tep_db_query("select s.products_id, s.expires_date, p.products_image, pd.products_name from specials s, products p, products_description pd where s.products_id = p.products_id and s.products_id = pd.products_id and p.products_status = '1' and p.products_image != '' and (s.expires_date > now() || s.expires_date = '0000-00-00 00:00:00' )");
//                                                                       $num_rows = tep_db_num_rows($specials_query); 
//                                                                       $osimgsString = '';
//                                                                       $ospnameStr = '';
//                                                                       $display = true;
//                                                          while($specials = tep_db_fetch_array($specials_query)){
//                                                              $osimgsString .= '<img onclick="location.href=\'' . tep_href_link('product_info.php', 'products_id=' . $specials['products_id']) . '\'" src="images/' . $specials['products_image'] . '" alt="" ' . ($display ? '' : ' style="display:none;" ') . '>';
//                                                                                                  $ospnameStr .= '<span class="fpname" ' . ($display ? '' : ' style="display:none;" ') . '  onclick="location.href=\'' . tep_href_link('product_info.php', 'products_id=' . $specials['products_id']) . '\'">' . $specials['products_name'] . '</span>';
//                                                                                                  $productsImages = 'images/' . $specials['products_image'];
//                                                                                                //  $products_single_image_array[] = 'images/' . $specials['products_image'];                                                        
                                                                                             //     $display = false;
                                                     //     }

                                                               ?>
                                                                    <div id="s2" class="ffadein">
                                                                        <?php 
                                                                          //  echo $osimgsString;
                                                                        ?>							
                                                                    </div>
                                                                    <div id="s2" class="ffadename"><?php 
                                                                   // echo $ospnameStr;
                                                                    ?>							
                                                                    </div>
                                                                </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
     
                            
         <?php
           // if (DISPLAY_COLUMN_RIGHT == 'yes' || (basename($PHP_SELF) != 'index-copy2.php' && !isset($HTTP_GET_VARS['cPath']))){
               ?>
                                            <tr>
                                                <td valign="bottom">
                                                    <div class="glossymenuHeader" style="width:180px;margin-bottom:5px;">
                                                        <div  class="submenurightContent">
                                                            <table class="submenuAff" cellpadding="0" cellspacing="0" width="100%" align="center">
                                                                <tr><td align="center" style="padding:5px;">
                                                                        <img src="images/Metaphysical_Info.gif" align="middle" class="home_thumb" height="80" width="150" alt="metaphysical-info_1" />
                                                                </td></tr>
                                                                <tr><td align="center" style="padding:5px;">
                                                                        <img src="images/Facebook&More.gif" align="middle" class="home_thumb" height="80" width="150" alt="FacebookandMore" />
                                                                </td></tr>
                                                                <tr><td align="center" style="padding:5px;">
                                                                        <img src="images/Affiliate_Program.gif" align="middle" class="home_thumb" height="80" width="150" alt="Affiliate_Prorgram" />
                                                                </td></tr>
                                                                <tr><td align="center" style="padding:5px;">
                                                                        <img src="images/product_catalog.gif" align="middle" class="home_thumb" height="80" width="150" alt="Product-Catalog" />
                                                                </td></tr>
                                                                <tr><td align="center" style="padding:5px;">
                                                                        <img src="images/Crystal_Cards.gif" align="middle" class="home_thumb" height="80" width="150" alt="crystal_card" />
                                                                </td></tr>
                                                                <tr><td align="center" style="padding:5px;">
                                                                        <img src="images/Contests&Survey.gif" align="middle" class="home_thumb" height="80" width="150" alt="Surveys" />
                                                                </td></tr>
                                                                <tr><td align="center" style="padding:5px;">
                                                                        <img src="images/newsletter_archive.gif" align="middle" class="home_thumb" height="80" width="150" alt="Newsletter_Archive" />
                                                                </td></tr>
                                                            </table>                
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
            <?php
                                                   //   }
                                                            ?>
           
                <?php
            //if (DISPLAY_COLUMN_RIGHT == 'yes' || (basename($PHP_SELF) == 'index-copy2.php' && !isset($HTTP_GET_VARS['cPath']))){
               ?>
                                            <tr>
                                               <td valign="bottom">
                                                   <div class="glossymenuHeader" style="width:190px;margin-bottom:5px;"><a class="menuitemNE menuitem" href="<?php //echo tep_href_link('articles.php','tPath=2')?>">Monthly Newsletter</a></div>
                                                                       <form NAME="nLetter" ACTION="/subscribe.php" METHOD="get">
                                                   <table border="0" cellspacing="0" cellpadding="0"><tr><td colspan="2"><input type="text"  style="width:120px; font-size: 14px; height: 24px;" name="email_address" id="nlEmail"/></td><td> <div class="glossymenuHeader" style="width:70px;"><a class="menuitemC" href="javascript:void(0);" onClick="document.nLetter.submit();">Sign Up</a></div></td></tr></table>
                                                                       </form>
                                               </td>
                                           </tr>
            <?php
          //  }
            ?>
            
            
                <?php
         //   if (DISPLAY_COLUMN_RIGHT == 'yes' || (basename($PHP_SELF) == 'index-copy2.php' && !isset($HTTP_GET_VARS['cPath']))){
               ?>
            <tr>
                <td valign="bottom">
                    <div class="glossymenuHeader"><a class="menuitem menuitemAff submenuleftheader" href="javascript:void(0);">Make Money<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;as an Affiliate</a>
                            <div class="submenuleft">
                                <table class="submenuAff" cellpadding="0" cellspacing="0" width="100%">
								<?php   //if (tep_session_is_registered('affiliate_id')) { ?>
									<tr>
										<td>
											<?php //echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'SSL') . '">' . BOX_AFFILIATE_SUMMARY . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php //echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_ACCOUNT, '', 'SSL'). '">' . BOX_AFFILIATE_ACCOUNT . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php //echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_PAYMENT, '', 'SSL'). '">' . BOX_AFFILIATE_PAYMENT . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php //echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_CLICKS, '', 'SSL'). '">' . BOX_AFFILIATE_CLICKRATE . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php// echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_SALES, '', 'SSL'). '">' . BOX_AFFILIATE_SALES . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php// echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_BANNERS). '">Affiliate Products' . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php// echo '<a href="' . tep_href_link(FILENAME_CONTACT_US). '">' . BOX_AFFILIATE_CONTACT . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php //echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_FAQ). '">' . BOX_AFFILIATE_FAQ . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php// echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_TERMS, '', 'SSL') . '">' . 'Affiliate Terms' . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php //echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_LOGOUT). '">' . BOX_AFFILIATE_LOGOUT . '</a>'; ?>
										</td>
									</tr>
								<?php// }else{ ?>
									<tr>
										<td>
											<?php //echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_INFO). '">' . BOX_AFFILIATE_INFO . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php //echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_FAQ). '">' . BOX_AFFILIATE_FAQ . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php //echo '<a href="' . tep_href_link(FILENAME_AFFILIATE_TERMS, '', 'SSL') . '">' . 'Affiliate Terms' . '</a>'; ?>
										</td>
									</tr>
									<tr>
										<td>
											<?php// echo '<a href="' . tep_href_link(FILENAME_AFFILIATE, '', 'SSL') . '">' . BOX_AFFILIATE_LOGIN . '</a>'; ?>
										</td>
									</tr>									
								<?php //} ?>
                                                                        
								</table>
                            </div>
                     </div>
                </td>
            </tr>
            <?php //} ?>
		</table>
                 
			</td></tr>
							
                        </table>
                        </td>-->
		
		<?php
                        }
                        else{
                        ?>
		<td class="TDw100">&nbsp;</td>
		<?php
                        }
                }else{
                    ?>
		<td class="TDw100">&nbsp;</td>
		<?php
                }
                ?>
	</tr>
	<tr class="d-none">
		<td colspan="5"><?= tep_draw_separator("spacer.gif", '1', '60') ?></td>
	</tr>
</table>
<?php
			 
                                      if (basename($PHP_SELF) == 'products.php' && $_GET['category'] == 'C'){
		   	 		require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/footer_cutandpolished.php');
                                      // }elseif (basename($PHP_SELF) == 'products1.php' && $_GET['category'] == 'C'){
		   	 		//require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/footer_cutandpolished.php');
                                       }
                                        else
                                            if($HTTP_GET_VARS['screenshot_preview']!='1')
				{
		 			require(DIR_WS_TEMPLATES . TEMPLATE_NAME . '/footer.php'); 
		 		}
		 ?>
<?php	//if(basename($PHP_SELF) == 'products.php' || basename($PHP_SELF) == 'tags.php' || basename($PHP_SELF) == 'products_by_chemical_composition.php' || basename($PHP_SELF) == 'sale_specials.php' || basename($PHP_SELF) == 'clearance-crystals.php' || basename($PHP_SELF)=='best-selling-crystals.php' || basename($PHP_SELF) == 'new_options.php' || basename($PHP_SELF) == 'random_products.php'){ ?>
<div id="dhtmltooltip"></div>
<style type="text/css">
		.ddimgtooltip{box-shadow: 3px 3px 5px #818181; -webkit-box-shadow: 3px 3px 5px #818181;-moz-box-shadow: 3px 3px 5px #818181;display:none;position:absolute;border:1px solid black;background:white;color: black;z-index:2000;padding: 4px;}
		</style>
<SCRIPT TYPE="text/javascript">
function timerHover(imgHtml){
	//setTimeout(tick, 500);
	showtip(imgHtml);
	//window.setTimeout("function(){showtip(imgHtml);}",5000);
	//document.onmousemove=positiontip;	
	//window.setTimeout("showtip('"+imgHtml+"');",500);	
}
function tick() {}
var tmo;
var curMenu;
var timer;
 //3000 miliseconds Change to edit delay in drop down menu
var isOver=false;
var timer2;
//var offsetxpoint=-100 //Customize x offset of tooltip
//var offsetypoint=-30 //Customize y offset of tooltip
var offsetxpoint=25 //Customize x offset of tooltip
var offsetypoint=100 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false	
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""
function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}
function showtip(thetext){
if (ns6||ie){
tipobj.style.width="400px"
tipobj.innerHTML=thetext
enabletip=true
return false
} 
}
function positiontip(e){ 
if (enabletip){
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.clientY : event.clientY;
var scurY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX : window.innerWidth-e.clientX-offsetxpoint
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY : window.innerHeight-e.clientY
var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000
if (rightedge<(400+30))
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : (window.pageXOffset+e.clientX-tipobj.offsetWidth-25)+"px"
else if (curX<500)
tipobj.style.left=curX+25
else
tipobj.style.left=curX+offsetxpoint+"px"
if(curY > 425){
tipobj.style.top = scurY-425 + "px";
}else if (bottomedge > 425){
tipobj.style.top=ie? scurY + 20+"px" : scurY + 20+"px"
}else if (bottomedge<tipobj.offsetHeight){
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight+offsetypoint+25+"px"
}else{
tipobj.style.top=scurY-offsetypoint+"px"
}
// COMMENT out the next line to disable tool tips 
 tmo=setTimeout("tipobj.style.visibility='visible'",500);
}
}
function positiontipD(e){ 
if (enabletip){
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.clientY : event.clientY;
var scurY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX : window.innerWidth-e.clientX-offsetxpoint
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY : window.innerHeight-e.clientY
var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000
//alert(tipobj.offsetWidth);
if (rightedge<(400+30))
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : (window.pageXOffset+e.clientX-tipobj.offsetWidth-25)+"px"
else if (curX<500)
tipobj.style.left=curX+25
else
tipobj.style.left=curX+offsetxpoint+"px"
if(curY > 425){
tipobj.style.top = scurY-425 + "px";
//alert("000"+curY);
}else if (bottomedge > 425){
tipobj.style.top=ie? scurY + 20+"px" : scurY + 20+"px"
}else if (bottomedge<tipobj.offsetHeight){
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight+offsetypoint+25+"px"
}else{
tipobj.style.top=scurY-offsetypoint+"px"
}
}
}
function hidetip(){
	if (ns6||ie){
		clearTimeout(tmo);
		enabletip=false
		tipobj.style.visibility="hidden"
		tipobj.style.left="-1000px"
		tipobj.style.backgroundColor=''
		tipobj.style.width=''
		
	}
}
document.onmousemove=positiontipD;
$("a.imgover").mouseover (function(e){
	positiontip(e);
});
$("a.imgoverarticle").mouseover (function(e){
	positiontip(e);
});





$('.imgoutarticle').bind('mouseover',function(){
    imgLink = $(this).attr('src');
    imgHtml = '<img src="'+imgLink+'" height="400" width="400">';
    showtip(imgHtml);
});


$( ".imgoutarticle" ).bind( "mouseout", function() {
    hidetip();
});
</script>
<?php //} ?>
<?php if (basename($PHP_SELF) == 'grading_summary.php' || basename($PHP_SELF) == 'product_info.php' || basename($PHP_SELF) == 'products.php' || basename($PHP_SELF) == 'tags.php') {
        ?>
<script language="JavaScript" type="text/javascript" src="<?=STATIC_URL?>includes/wz1_tooltip.js"></script>
<?php } 
    if(basename($PHP_SELF) == 'affiliate_signup.php'||basename($PHP_SELF) == 'affiliate_details.php')
{?>
<script language="JavaScript" type="text/javascript" src="wz_tooltip.js"></script>
<?php } ?>
<script type="text/javascript">
                            function getElementsByClassName(className, tag, elm){
                                var testClass = new RegExp("(^|\\s)" + className + "(\\s|$)");
                                var tag = tag || "*";
                                var elm = elm || document;
                                var elements = (tag == "*" && elm.all)? elm.all : elm.getElementsByTagName(tag);
                                var returnElements = [];
                                var current;
                                var length = elements.length;
                                for(var i=0; i<length; i++){
                                    current = elements[i];
                                    if(testClass.test(current.className)){
                                        returnElements.push(current);
                                    }
                                }
                                return returnElements;
                            }
                            var classArray =  new Array();
                            classArray[0] = 'pageHeading';
                            classArray[1] = 'pageHeading3';
                            classArray[2] = 'allPicHeading';
                            for(var i=0; i<classArray.length; i++){                                
                                if(getElementsByClassName(classArray[i], 'td', document.getElementById('mainContentTD')).length>'0'){
                                    var elm = getElementsByClassName(classArray[i], 'td', document.getElementById('mainContentTD'))[0];
                                  //alert(elm.offsetWidth);
								 	var tdWidth = '650';
									var readCommentsElm = document.getElementById('readComments');
									if(readCommentsElm){
									
										if(readCommentsElm.innerHTML.indexOf('Comment')>0)tdWidth='480';
									}
									var siblingWidth = 0;
									var elmSib = elm.nextSibling;
									if(elmSib != null){
										siblingWidth = elmSib.offsetWidth;
									}
									if(elm.offsetWidth > tdWidth && siblingWidth > 150){
									    var text = elm.innerHTML;
                                        elm.innerHTML = '';
                                        var textNode = document.createTextNode('');
                                        var newRow = document.createElement('tr');
                                        var newTd = document.createElement('td');
                                        
                                        //newTd.setAttribute('colspan','2');
                                        //newTd.setAttribute('class',classArray[i]);
                                        newTd.setAttribute('id','pheading');
										newTd.appendChild(textNode);
                                        newRow.appendChild(newTd);
                                        elm.parentNode.parentNode.appendChild(newRow);
                                        document.getElementById('pheading').innerHTML = text;
										document.getElementById('pheading').className = classArray[i];
										document.getElementById('pheading').colSpan = '2';
                                        break;
                                    }
                                }
                            }
                        </script>
<?php if(basename($_SERVER['SCRIPT_NAME'])=='products.php' || basename($_SERVER['SCRIPT_NAME']) == 'tags.php'){
          echo '<script type="text/javascript">
checkall();
</script>';
        }
        ?>
<script type="text/javascript">
function timerHoverSlideShow(pid){
	
	showtip('<div style="background-color:white;"><center><img src=images/loading1.gif/></center></div>');
	$.ajax({
		  type: "GET",
		  url: "getimagesHTML.php",
		  data: "pid="+pid,
		  success: function( msg ) {
                            showtip(msg);
                            var totalImg = $("#slideshow > img").size();
                            var newcount = 2;
                            if(parseInt(totalImg) > 1){
                              //var preCount = 1;
                              
                              setInterval(function() {
                                  $("#slideshow > img").hide();
                                  $('#img-'+newcount).show();
                                  
                                  if(parseInt(newcount) == parseInt(totalImg)){
                                     newcount = 1; 
                                  }else{
                                      newcount++;
                                  }
                                  

                              }, 3000);
                              /*$('.slideshow').cycle({
                                            fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
                                            speed: 500
                                    });*/
                            }
                        }
		});	
	
}
</script> 
<script type="text/javascript" src="http://cloud.github.com/downloads/malsup/cycle/jquery.cycle.all.latest.js"></script> 
<script type="text/javascript">
/*$(document).ready(function() {
    $('#s1').cycle({
        fx:    'fade', 
    	timeout: 9000,
       pause: 9
	});
     
});*/


</script>
</body>
</html>
<?php ob_end_flush();?>