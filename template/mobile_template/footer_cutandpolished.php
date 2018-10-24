<?php
/*
  $Id: footer.php,v 1.26 2003/02/10 22:30:54 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
 */



// WebMakers.com Added: Down for Maintenance
// Hide footer.php if not to show
if (DOWN_FOR_MAINTENANCE_FOOTER_OFF == 'false') {
    require(DIR_WS_INCLUDES . 'counter.php');
?>
    <table cellspacing=0 cellpadding=1 width="100%<?php //echo SITE_WIDTH; ?>" border=0 style="background-image:url('templates/New/images/header/bg.gif');">
           <tbody>
            <tr class="footer">
                <td colspan="2" align="center"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '7'); ?></td>
            </tr>
            <tr class="footer">
                <td colspan="2" align="center">&nbsp; <a class="footer" href="<?php echo tep_href_link('article_info.php', 'articles_id=388'); ?>">Wholesale&nbsp;&nbsp;|</a>&nbsp;&nbsp; <a class="footer" href="<?php echo tep_href_link('article_info.php', 'articles_id=1111'); ?>">About Us&nbsp;&nbsp;|</a>&nbsp;&nbsp; <a class="footer" href="<?php echo tep_href_link('article_info.php', 'articles_id=1109'); ?>">FAQ&nbsp;&nbsp;|</a>&nbsp;&nbsp; <a class="footer" href="<?php echo tep_href_link('contact_us.php'); ?>">Contact Us</a>
                </td>
            </tr>
            <tr class="footer">
                <td colspan="2" align="center"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
            </tr>
            <tr class="footer"> 
                <td colspan="2"><table cellspacing="0" cellpadding="1" width="100%" border="0">
                        <tr class="footer">
                            <td height="31" class="footerHits">&nbsp;&nbsp;<?php echo strftime(DATE_FORMAT_LONG); ?>&nbsp;&nbsp;</td>
                            <td height="31" class="footer" align="right">&nbsp;&nbsp;<a href="<?php echo tep_href_link('report_error.php'); ?>" style="color:#ffffff;">Report an Error</a>&nbsp;&nbsp;</td>
                            <td height="31" class="footerHits" align="right">&nbsp;&nbsp;<?php echo number_format($counter_now) . ' ' . FOOTER_TEXT_REQUESTS_SINCE . ' ' . $counter_startdate_formatted; ?>&nbsp;&nbsp;</td>
                        </tr>
                    </table></td></tr>
        </tbody>
    </table>
    <br>


    <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" class="smallText">
         <?php   echo FOOTER_TEXT_BODY;
# 4/6/09 edit by Bob <www.site-webmaster.com>: added tracking code:
            include ( DIR_WS_INCLUDES . 'google-analytics-tracking-code.incl.php');
            ?>
        </td>
    </tr>
</table>
<?php
        }
        if ($banner = tep_banner_exists('dynamic', '468x50')) {
?>
            <br>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center"><?php echo tep_display_banner('static', $banner); ?></td>
                </tr>
            </table>
<?php
        }
?>

<?php
// BOF: WebMakers.com Added: Center Shop Bottom of the tables are in footer.php
        //if (CENTER_SHOP_ON == '1') {
if(basename($PHP_SELF) == 'products.php' && $_GET['category'] == 'C'){
    
}else{
?>
            
            </td></tr></table>
    <?php }?>
            </td></tr>
            </table>
            </td>
<!--            <td  width="18%" class="backgroundgradientrighttoleft">
                &nbsp;
                    
                </td>-->
            </tr>
            </table></td></tr></table>
<?php
      //  }
// EOF: WebMakers.com Added: Center Shop Bottom of the tables are in footer.php
?>