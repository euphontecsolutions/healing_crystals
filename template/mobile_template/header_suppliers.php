<?php
/*
  $Id: header.php,v 1.42 2003/06/10 18:20:38 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
 */

// WebMakers.com Added: Down for Maintenance
// Hide header if not to show
if (DOWN_FOR_MAINTENANCE_HEADER_OFF == 'false') {
    if (SITE_WIDTH != '100%') {
?>
<div id="fb-root"></div>

			
       <table width="90%" cellpadding="0" cellspacing="0" border="0">
            <tr><td>
                    <table class="maintable" cellspacing="0" cellpadding="0" BORDER="0" width="<?php echo SITE_WIDTH; ?>" align="center" >
                        <tr><td>
                                <table border="0" width="100%" cellpadding="0" cellspacing="0"><tr><td>
                                	
                                	
<?php } ?>							<table border="0" width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td width="100%" align="center" valign="top" style="padding:5px;padding-top: 8px;">
											<a href="http://www.healingcrystals.com/"><img src="<?=STATIC_URL?><?= DIR_WS_TEMPLATES . TEMPLATE_NAME ?>/images/header/logo1.gif" border="0" alt="Promoting the Education and Use of Crystals to Support Healing"  ></a>
											</td>
										</tr>
									</table>

									<table cellspacing="0" cellpadding="0">
                                        <tbody><tr><td colspan="3" height="1">
                                                    <IMG height="1" src="<?=STATIC_URL?><?= DIR_WS_TEMPLATES . TEMPLATE_NAME ?>/images/header/spacer.gif" width="1" border="0" ALT="">
                                                </td></tr>                                           
                                        </tbody>
                                    </table>
                                    <table cellspacing="0" cellpadding="0">
                                        <tbody><tr><td colspan="3" align="right">
                                                    </td></tr>                                           
                                        </tbody>
                                    </table>
<?php
 }
?>