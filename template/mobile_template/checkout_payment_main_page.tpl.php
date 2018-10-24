<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<?php require(DIR_WS_INCLUDES . 'meta_tags.php'); ?>
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
<?php if ($javascript) { require(DIR_WS_JAVASCRIPT . $javascript); } ?>
<SCRIPT TYPE="text/javascript">
function popupWindow2(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=800,screenX=50,screenY=50,top=50,left=50')
}

function init() {
	if (!document.getElementById) return false;
	var f = document.getElementById('auto_off');
	var u = f.elements[0];
	f.setAttribute("autocomplete", "off");
	u.focus();
	}

</script>
</head>
<!---body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" onClick="hide();" onResize="hide();" <?php if (isset($HTTP_GET_VARS['image'])) echo 'onLoad="document.getElementById(\'products_image\').scrollIntoView(true);"'?>//-->
<body <?php if (isset($HTTP_GET_VARS['image'])){ echo 'onLoad="document.getElementById(\'products_image\').scrollIntoView(true);init()"';}else{ echo 'onload="init()"';  }?>>

<!-- header //-->
<?php require(DIR_WS_TEMPLATES . TEMPLATE_NAME .'/header.php'); ?>
<!-- header_eof //-->
<!-- body //-->
<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_MAIN; ?>">
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
?>
<!-- content //-->
    <td width="100%" valign="top">
<?php
  if (isset($content_template)) {
    require(DIR_WS_CONTENT . $content_template);
  } else {
    require(DIR_WS_CONTENT . $content . '.tpl.php');
  }
?>
    </td>
<!-- content_eof //-->
<?php
// WebMakers.com Added: Down for Maintenance
// Hide column_right.php if not to show


if (DISPLAY_COLUMN_RIGHT == 'yes')  {
if (DOWN_FOR_MAINTENANCE =='false' || DOWN_FOR_MAINTENANCE_COLUMN_RIGHT_OFF =='false') {
?>
    <td width="<?php echo BOX_WIDTH_RIGHT; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH_RIGHT; ?>" cellspacing="0" cellpadding="<?php echo CELLPADDING_RIGHT; ?>">
<!-- right_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_right.php'); ?>
<!-- right_navigation_eof //-->
    </table></td>
<?php
}
}
?>
  </tr>
					<tr>
          <td colspan="4"><?=tep_draw_separator("spacer.gif", '1', '12')?></td>
        </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_TEMPLATES . TEMPLATE_NAME .'/footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
