<?php echo tep_draw_form('submit_comments', tep_href_link('submit_comments.php', 'action=submit&products_id='.$HTTP_GET_VARS['products_id']), 'post', 'onSubmit="return checkEmail(submit_comments);"'); ?><table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
 <script src="jquery.form.js" type="text/javascript" language="javascript"></script>
	<script src="jquery.MetaData.js" type="text/javascript" language="javascript"></script>
 <script src="jquery.rating.js" type="text/javascript" language="javascript"></script>
 <link href="jquery.rating.css" type="text/css" rel="stylesheet"/>


<?php






if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {



$header_text = '&nbsp;'



//EOF: Lango Added for template MOD



?>

<script language="javascript"> 

<!-- 

function checkEmail() { 
var errorEmail = false;
var errorPurchased = false;
var errorComments = false;
var errorRating = false;
var error = false;
var isChecked=  false;
var isCheckedRating=false;
var msg;

if (document.submit_comments.email.value != document.submit_comments.email_verify.value || document.submit_comments.email.value.length == 0){
	error = true;
	errorEmail = true;
}

for (var i=0; i<document.submit_comments.products_purchased.length; i++) {
      if (document.submit_comments.products_purchased[i].checked == true) {
        	isChecked = true;
        	break;
      }
}
if(isChecked == false){
	error = true;
	errorPurchased = true;
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
if (document.submit_comments.enquiry.value.length>999){
	error = true;
	errorComments = true;
}

if(error == true){ 
msg = 'Please rectify following errors:\n';	

if(errorEmail == true)msg = msg + '\t-Please double check your email addresses to make sure that they are entered correctly.\n'; 
if(errorPurchased == true)msg = msg + '\t-Please let us know whether you have purchased this product or not.\n'; 
if(errorComments == true)msg = msg + '\t-Please limit your comments to a maximum of 999 charaters.\n';
if(errorRating == true)msg = msg + '\t-Please rate the product.\n';  

alert(msg);
return false;

}else{

	return true;

}

} 

//--> 

</script>



      <tr>



        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">



          <tr>


            <td class="pageHeading"><?php if(!isset($_GET['action']) || ($_GET['action'] != 'success')){echo HEADING_TITLE;}else{echo HEADING_TITLE_SMALL;} ?></td>



            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_contact_us.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>



          </tr>
          
      <tr>



        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>



      </tr>
      <tr>
      	<td>
      		<?php 
      			$img_query = tep_db_query("select products_image from products where products_id like '".$HTTP_GET_VARS['products_id']."'");
      			$img_array = tep_db_fetch_array($img_query);
				  echo tep_image(DIR_WS_IMAGES . $img_array['products_image'], tep_get_products_name($HTTP_GET_VARS['products_id']), '100', '100', '');
      		?>
      	
		</td>
      	<td>
      		<table border="0" width="100%">
      			<tr>


            		<td class="mainCO" colspan="2">Product Model#:&nbsp;&nbsp;<?= tep_get_products_model($HTTP_GET_VARS['products_id'])?></td>



          		</tr>
          		<tr>


            		<td class="mainCO" colspan="2">Product Name:&nbsp;&nbsp;<?= tep_get_products_name($HTTP_GET_VARS['products_id'])?></td>



          		</tr>
      		</table>
		</td>
      </tr>
          

      <tr>



        <td colspan="2"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>



      </tr>

        </table></td>



      </tr>



      <tr>



        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>



      </tr>



<?php



// BOF: Lango Added for template MOD



}else{



$header_text = HEADING_TITLE;



}



// EOF: Lango Added for template MOD



?>







<?php







  function tep_cfg_get_zone_name($zone_id) {



    $zone_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_id = '" . (int)$zone_id . "'");







    if (!tep_db_num_rows($zone_query)) {



      return $zone_id;



    } else {



      $zone = tep_db_fetch_array($zone_query);



      return $zone['zone_name'];



    }



  }



// BOF: Lango Added for template MOD



if (MAIN_TABLE_BORDER == 'yes'){



table_image_border_top(false, false, $header_text);



}



// EOF: Lango Added for template MOD



?>



<?php 

//print_r($messageStack);

  if ($messageStack->size('contact') > 0) {



?>



      <tr>



        <td><?php echo $messageStack->output('contact'); ?></td>



      </tr>



      <tr>



        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>



      </tr>



<?php



  }







  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'success')) {



?>



      <tr>



        <td class="mainCO" align="center"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_man_on_board.gif', HEADING_TITLE, '0', '0', 'align="left"') . TEXT_SUCCESS; ?></td>



      </tr>



      <tr>



        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>



      </tr>



      <tr>



        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">



          <tr class="infoBoxContents">



            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">



              <tr>



                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>



                <td align="right"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_template_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>



                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>



              </tr>



            </table></td>



          </tr>



        </table></td>



      </tr>



<?php



  } else {



?>



      <tr>



        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="contentbox">



          <tr class="infoBoxContents">



            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">



              <tr>



                <td class="mainCO"><?php echo ENTRY_NAME; ?></td>



              </tr>



              <tr>



                <td class="mainCO"><?php echo tep_draw_input_field('name'); ?></td>



              </tr>
              <tr>



                <td class="mainCO"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>



              </tr>



              <tr>

                <?php error_bool($err, "email"); ?><?php echo ENTRY_EMAIL; ?></td>



              </tr>



              <tr>



                <td class="mainCO"><?php echo tep_draw_input_field('email', '', 'size=30'); ?></td>



              </tr>
<tr>



                <td class="mainCO"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>



              </tr>
               <tr>

<script type="text/javascript" language="JavaScript">
<!--
function HideMenus()
{
setTimeout("HideOpenMenus()",1500);
}
function HideOpenMenus()
{
document.getElementById('whyspan').style.display = 'none';
}
//-->
</script>

               

                 <td class="mainCO">Re-enter Email: <small class="whythis" title=""><a tabindex="0" href="submit_comments.php#spamq" style="cursor:help;">(Why?)<span><br>To make sure that we have your correct email address, we ask that you enter it twice.</span> </a></small> </td>



              </tr>



              <tr>



                <td class="mainCO"><?php echo tep_draw_input_field('email_verify', '', 'size=30'); ?></td>



              </tr>
<tr>



                <td class="mainCO"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>



              </tr>

  			  <tr>

                
				<td class="mainCO">Have you purchased this product from us before?</td>



              </tr>



              <tr>
                <td class="mainCO"><input type="radio" name="products_purchased" value="1"/>Yes<input type="radio" name="products_purchased" value="0"/>No<span class="inputRequirement">*</span></td>
              </tr>
				<tr>



                <td class="mainCO"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>



              </tr>
				<tr>

                
				<td class="mainCO">Please Rate this product</td>



              </tr>
              <tr>
                <td class="mainCO">
					<input name="star1" type="radio" value="1" class="star" />
					<input name="star1" type="radio" value="2" class="star"/>
					<input name="star1" type="radio" value="3" class="star"/>
					<input name="star1" type="radio" value="4" class="star"/>
					<input name="star1" type="radio" value="5" class="star"/>
					<span class="mainCO" id="ratingValue"></span>
				</td>
              </tr>
              <tr>



                <td class="mainCO"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>



              </tr>
              <tr>



                <td class="mainCO"><?php echo ENTRY_ENQUIRY; ?></td>



              </tr>



              <tr>



                <td class="mainCO"><?php echo tep_draw_textarea_field('enquiry', 'soft', 50, 15); ?></td>



              </tr>

              
			<tr>



                <td class="mainCO"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '5'); ?></td>



              </tr>


            </table></td>



          </tr>



        </table></td>



      </tr>



      <tr>



        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>



      </tr>



<?php



// BOF: Lango Added for template MOD



if (MAIN_TABLE_BORDER == 'yes'){



table_image_border_bottom();



}



// EOF: Lango Added for template MOD



?>



      <tr>



        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>



      </tr>



      <tr>



        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">



          <tr class="infoBoxContents">



            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">



              <tr>



                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>



                <td align="left"><?php echo tep_template_image_submit('button_submit.gif', 'Submit Comment'); ?></td>



                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>



              </tr>



            </table></td>



          </tr>



        </table></td>



      </tr>



<?php



  }



?>



    </table></form>