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
    <table cellspacing=0 cellpadding=1 width="100%<?php //echo SITE_WIDTH; ?>" border=0 style="background-image:url(<?= DIR_WS_TEMPLATES . TEMPLATE_NAME ?>/images1/header/bg.gif);">
           <tbody>
            <tr class="footer">
                <td colspan="2" align="center"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>
            </tr>
            <tr class="footer">
                <td colspan="2" align="center">&nbsp; <a class="footer" href="<?php echo tep_href_link('article_info.php', 'articles_id=388'); ?>">Wholesale&nbsp;&nbsp;|</a>&nbsp;&nbsp; <a class="footer" href="<?php echo tep_href_link('article_info.php', 'articles_id=12501'); ?>">Disclaimer&nbsp;&nbsp;|</a>&nbsp;&nbsp; <a class="footer" href="<?php echo tep_href_link('article_info.php', 'articles_id=1111'); ?>">About&nbsp;&nbsp;|</a>&nbsp;&nbsp; <a class="footer" href="<?php echo tep_href_link('article_info.php', 'articles_id=1109'); ?>">FAQ&nbsp;&nbsp;|</a>&nbsp;&nbsp; <a class="footer" href="<?php echo tep_href_link('contact_us.php'); ?>">Contact Us</a>
                </td>
            </tr>
            <tr class="footer">
                <td colspan="2" align="center"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '3'); ?></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
            </tr>
            <tr class="footer">
                <td colspan="2">
                    <table cellspacing="0" cellpadding="1" width="100%" border="0">
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
    <?php /*
        <tr>
            <td align="center" class="smallText"><span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=XOP88KjGbp80vCpJj0mRkx71BX0kbaoQjEv8MblDw4thMGou1Jf5VWnXco"></script><br/><a style="font-family: arial; font-size: 9px" href="https://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">SSL</a></span>
        </td>
    </tr>
     * */ ?>
     
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
?>
            
                            </td>
                        </tr>
            </table>
            </td>
            </tr>
            </table>
    </td>
    
</tr>
    </table></td></tr></table>
    
<script src="jquery.MetaData.js" type="text/javascript" language="javascript"></script>
<script src="jquery.rating.js" type="text/javascript" language="javascript"></script>
<link href="jquery.rating.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="wz_tooltip.js"></script>
<script type="text/javascript"> 

function checkEmail() { 
var errorEmail = false;
var errorPurchased = false;
var errorComments = false;
var errorRating = false;
var error = false;
var isChecked=  false;
var isCheckedRating=false;
var msg;
var errorName=false;

if (document.submit_comments.name.value == "" ){
	error = true;
	errorName = true;
}


if (document.submit_comments.email.value == "" ){
	error = true;
	errorEmail = true;
}
else{
	var x=document.forms["submit_comments"]["email"].value;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
   error = true;
	errorEmail = true;
  }
}

for (var i=0; i<document.submit_comments.star1.length; i++) {
      if (document.submit_comments.star1[i].checked == true) {
        	isCheckedRating = true;
        	break;
      }
}

if(isCheckedRating == false){
	error = true;
	errorRating = true;
}

if (document.submit_comments.enquiry.value.length>'2999'){
	error = true;
	errorComments = true;
}

if(error == true){ 
msg = 'Please rectify following errors:\n';	

if(errorEmail == true)msg = msg + '\t-Please double check your email addresses to make sure that they are entered correctly.\n'; 
if(errorName == true)msg = msg + '\t-Please enter your name correctly.\n';
//if(errorPurchased == true)msg = msg + '\t-Please let us know whether you have purchased this product or not.\n'; 
if(errorComments == true)msg = msg + '\t-Please limit your comments to a maximum of 2999 charaters.\n';
if(errorRating == true)msg = '-To post your comment,\n please select a Rating \n for this article..\n';  

alert(msg);
return false;

}else{

	return true;
}
} 



function buttonalert(event)
{
    var button;
   
    if (event.which == null) { 
       var elName = event.srcElement.tagName;           
        button= (event.button < 2) ? "LEFT" :
                  ((event.button == 4) ? "MIDDLE" : "RIGHT");
       
    }
    else
    {
    	var elName = event.target.tagName;
        button= (event.which < 2) ? "LEFT" :
                 ((event.which == 2) ? "MIDDLE" : "RIGHT");
    }
    var currentText = document.getElementById('ratingValue').innerHTML;
    //&nbsp;&nbsp;1 Star (worst)    
    if(button=='LEFT' && (elName!='A') && (elName!='INPUT') && (elName!='TEXTAREA')){
    	//$(this).resetRating(); 
     	//alert();
   		$('div.rating-cancel').rating('select');
    	document.getElementById('ratingValue').innerHTML = '&nbsp;&nbsp;Not Rated';
    }
}
function dont(event)
{
    if (event.preventDefault)
        event.preventDefault();
    else
        event.returnValue= false;
     return false;
}
</script>
    
<?php
      //  }
// EOF: WebMakers.com Added: Center Shop Bottom of the tables are in footer.php
?>