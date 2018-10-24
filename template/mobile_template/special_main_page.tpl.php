<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<?php //require(DIR_WS_INCLUDES . 'meta_tags.php'); ?>
<?php
// BOF: WebMakers.com Changed: Header Tag Controller v1.0
// Replaced by header_tags.php

if ( file_exists(DIR_WS_INCLUDES . 'header_tags.php') ) {
  require(DIR_WS_INCLUDES . 'header_tags.php');
} else {
?> 
  <title><?php echo TITLE ?></title>
<?php
}
// EOF: WebMakers.com Changed: Header Tag Controller v1.0
?>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="<? echo TEMPLATE_STYLE;?>">
<!--[if lt IE 7]>
<script language="JavaScript">
function correctPNG() // correctly handle PNG transparency in Win IE 5.5 & 6.
{
   var arVersion = navigator.appVersion.split("MSIE")
   var version = parseFloat(arVersion[1])
   if ((version >= 5.5) && (document.body.filters))
   {
      for(var i=0; i<document.images.length; i++)
      {
         var img = document.images[i]
         var imgName = img.src.toUpperCase()
         if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
         {
            var imgID = (img.id) ? "id='" + img.id + "' " : ""
            var imgClass = (img.className) ? "class='" + img.className + "' " : ""
            var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
            var imgStyle = "display:inline-block;" + img.style.cssText
            if (img.align == "left") imgStyle = "float:left;" + imgStyle
            if (img.align == "right") imgStyle = "float:right;" + imgStyle
            if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
            var strNewHTML = "<span " + imgID + imgClass + imgTitle
            + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
            + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
            + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>"
            img.outerHTML = strNewHTML
            i = i-1
         }
      }
   }
}
window.attachEvent("onload", correctPNG);
</script>
<![endif]-->

<?php if ($javascript) { require(DIR_WS_JAVASCRIPT . $javascript); } ?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" onClick="hide();" onResize="hide();" <?php if (isset($HTTP_GET_VARS['image'])) echo 'onLoad="document.getElementById(\'products_image\').scrollIntoView(true);"'?>>
<!-- warnings //-->
<?php require(DIR_WS_INCLUDES . 'warnings.php'); ?>
<!-- warning_eof //-->

<!-- header //-->
<?php require(DIR_WS_TEMPLATES . TEMPLATE_NAME .'/header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_MAIN; ?>" background="<?php echo DIR_WS_TEMPLATES . TEMPLATE_NAME;?>/images/bg_cat4.gif">
  <tr>
<?php 
if (DOWN_FOR_MAINTENANCE == 'true') { 
  $maintenance_on_at_time_raw = tep_db_query("select last_modified from " . TABLE_CONFIGURATION . " WHERE configuration_key = 'DOWN_FOR_MAINTENANCE'"); 
  $maintenance_on_at_time= tep_db_fetch_array($maintenance_on_at_time_raw); 
  define('TEXT_DATE_TIME', $maintenance_on_at_time['last_modified']); 
} 
?> 
<?php
if (DISPLAY_COLUMN_LEFT == 'yes')  {
// WebMakers.com Added: Down for Maintenance
// Hide column_left.php if not to show
if (DOWN_FOR_MAINTENANCE =='false' || DOWN_FOR_MAINTENANCE_COLUMN_LEFT_OFF =='false') {
  if (!isset($HTTP_GET_VARS['image'])){
?>
<td width="<?php echo BOX_WIDTH_LEFT; ?>" valign="top">
<!--	<table border="0" width="<?php echo BOX_WIDTH_LEFT; ?>" cellspacing="0" cellpadding="<?php echo CELLPADDING_LEFT; ?>">-->

<TABLE cellSpacing=0 width=190 border=0 style="border-collapse: collapse" cellpadding="0">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
</table>

	</td>
		<td><?=tep_draw_separator("spacer.gif", '11', '1')?></td>
<?php
    }
  }
}
?>  
  
    <td width="100%" valign="top">
<?php
  require(DIR_WS_CONTENT . 'special_product_info.tpl.php');
?>
    </td>
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_TEMPLATES . TEMPLATE_NAME .'/footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
