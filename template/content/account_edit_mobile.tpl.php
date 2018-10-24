  <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://www.copy.healingcrystals.com/hybrid_api/bootstrap-3.3.7/js/dropdown.js"></script>

  <style type="text/css">

    
table.infoBox tbody tr.infoBoxContents td table {
  display: flex;
  flex-direction: column;
}

table.infoBox tbody tr.infoBoxContents td table tbody tr {
  display: flex;
  flex-direction: row;
  width: 100%;
  justify-content: space-between;
  margin: 10px;
}

table.infoBox tbody tr.infoBoxContents td table tbody tr td:first-child {
  flex-shrink: 2;
  flex-grow: 1;
  flex-basis: 50%;
  font:menu;
}

table.infoBox tbody tr.infoBoxContents td table tbody tr td:nth-child(2) {
  flex-shrink: 1;
  flex-grow: 1;
  flex-basis: 60%;
}

input {

  width: 82%;
  font-size: 15px;
  font:menu;
  padding: 5px;

}
select {

  width: 82%;
  font-size: 17px;
  font:menu;
  padding: 5px;

}

b {
  font-size: 15px;
  font-weight: 700;
}

*:focus {
    outline:none;
}

* {
  text-decoration: none !important;
}

td > img {
  display: none;
}

input[type="image"] {
  width: 37%;
}

.messageStackSuccess {
  font:message-box;
}

.fleck {
  margin-top: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
}
  </style>
    <?php echo tep_draw_form('account_edit_mobile', tep_href_link('account_edit_mobile.php', '', 'SSL'), 'post', 'onSubmit="return check_form(account_edit);"') . tep_draw_hidden_field('action', 'process'); ?><table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">

<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
<!--       <tr>
        <td><?php /*echo tep_draw_separator('pixel_trans.gif', '100%', '10');*/ ?></td>
      </tr> -->
<!--       <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php /*echo HEADING_TITLE;*/ ?></td>
            <td class="pageHeading" align="right"><?php /*echo tep_image(DIR_WS_IMAGES . 'table_background_account.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT);*/ ?></td>
          </tr>
        </table></td>
      </tr> -->
<!--       <tr>
        <td><?php /*echo tep_draw_separator('pixel_trans.gif', '100%', '10');*/ ?></td>
      </tr> -->
     
<?php
// BOF: Lango Added for template MOD
}else{
$header_text = HEADING_TITLE;
}
// EOF: Lango Added for template MOD
?>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>
      <script language="javascript" type="text/javascript">
function validatephone(xxxxx) 
{
    var maintainplus = '';
    var numval = xxxxx.value
    if ( numval.charAt(0)=='+' )
    {
        var maintainplus = '';
    }
    curphonevar = numval.replace(/[\\A-Za-z!"£$%^&\-\)\(*+_={};:'@#~,.Š\/<>\" "\?|`¬\]\[]/g,'');
    xxxxx.value = maintainplus + curphonevar;
    var maintainplus = '';
    xxxxx.focus;
}
</script>
<?php
  if ($messageStack->size('account_edit') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('account_edit'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main"><b><?php echo MY_ACCOUNT_TITLE; ?></b></td>
                <!-- <td class="inputRequirement" align="right"><?php /*echo FORM_REQUIRED_INFORMATION;*/ ?></td> -->
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
              <tr class="infoBoxContents">
                <td><table border="0" cellspacing="2" cellpadding="2">
<?php
  if (ACCOUNT_GENDER == 'true') {
    if (isset($gender)) {
      $male = ($gender == 'm') ? true : false;
    } else {
      $male = ($account['customers_gender'] == 'm') ? true : false;
    }
    $female = !$male;
?>
                  <tr>
                    <td class="main"><?php echo ENTRY_GENDER; ?></td>
                    <td class="main"><?php echo tep_draw_radio_field('gender', 'm', $male) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . tep_draw_radio_field('gender', 'f', $female) . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . (tep_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); ?></td>
                  </tr>
<?php
  }
?>
                  <tr>
                    <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
                    <td class="main"><?php echo tep_draw_input_field('firstname', $account['customers_firstname']) . '&nbsp;' . (tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?></td>
                  </tr>
                  <tr>
                    <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
                    <td class="main"><?php echo tep_draw_input_field('lastname', $account['customers_lastname']) . '&nbsp;' . (tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?></td>
                  </tr>
<?php
  if (ACCOUNT_DOB == 'true') {
?>
                  <tr>
                    <td class="main"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
                    <td class="main"><?php echo tep_draw_input_field('dob', tep_date_short($account['customers_dob'])) . '&nbsp;' . (tep_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="inputRequirement">' . ENTRY_DATE_OF_BIRTH_TEXT . '</span>': ''); ?></td>
                  </tr>
<?php
  }
?>
                 <!-- <tr>
                    <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
                    <td class="main"><?php echo tep_draw_input_field('email_address', $account['customers_email_address']) . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
                  </tr>-->
                  <tr>
                    <td class="main">E-Mail Address:</td>
                    <td class="main"><input type="email" name="email_address" value="<?php echo $account['customers_email_address'];?>"><?php echo  '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
                  </tr>
                  <!--<tr>
                    <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
                    <td class="main"><?php echo tep_draw_input_field('telephone', $account['customers_telephone'],'onkeyup="validatephone(this);"') . '&nbsp;' . (tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?></td>
                  </tr>-->
                  <tr>
                    <td class="main">Telephone Number:</td>
                    <td class="main"><input type="number" name="telephone" value="<?php echo $account['customers_telephone'];?>" onkeyup="validatephone(this);"><?php echo  '&nbsp;' . (tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?></td>
                  </tr>
                  <tr>
                    <td class="main">Fax Number:</td>
                    <td class="main"><input type="number" name="fax" value="<?php echo $account['customers_fax'];?>">&nbsp;</td>
                  </tr>
                 <!-- <tr>
                    <td class="main"><?php echo ENTRY_FAX_NUMBER; ?></td>
                    <td class="main"><?php echo tep_draw_input_field('fax', $account['customers_fax']) . '&nbsp;' . (tep_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_FAX_NUMBER_TEXT . '</span>': ''); ?></td>
                  </tr>-->
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
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
      </tr>		 <tr>        <td><table border="0" width="100%" cellspacing="1" cellpadding="2">                <tr>            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">              <tr>                <td class="main"><b>My Billing Address</b></td>                <td class="inputRequirement" align="right">&nbsp;</td>              </tr>            </table></td>          </tr>          <tr class="infoBoxContents">            <td><table border="0" width="100%" cellspacing="0" cellpadding="2"  class="infoBox">              <tr>                
        <td><?php include(DIR_WS_MODULES . 'billing_address_book_details.php'); ?></td>              </tr>            </table></td>          </tr>        </table></td>      </tr>      <tr>        <!-- <td><?php /*echo tep_draw_separator('pixel_trans.gif', '100%', '10');*/ ?></td> -->      </tr>
        <tr></tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="fleck">
                <!-- <td width="10"><?php /*echo tep_draw_separator('pixel_trans.gif', '10', '1');*/ ?></td> -->
                <!-- <td><?php /*echo '<a href="' . $_SERVER['HTTP_REFERER'] . '">' . tep_template_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>';*/ ?></td> -->
                <td align="left">
          <center><a class="btn btn-primary" href="/address_book_mobile.php" style="color: white;">View/ Edit Shipping address</a></center>
        </td><td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
				<td align="right">
                <?php if($_SESSION['redirectV']==''){
                	if(strpos($_SERVER['HTTP_REFERER'],'checkout_payment.php')>0)
                		$_SESSION['redirectV']=$_SERVER['HTTP_REFERER'];
                	else
                		$_SESSION['redirectV']=tep_href_link('account.php');	
                }?>
                <input type="hidden" name="redirect" value="<?php echo $_SESSION['redirectV'];?>"/>
                <?php echo '<button class="btn btn-primary btn-block" type="submit"> Save'.  tep_draw_separator('pixel_trans.gif', '10', '1').'</button>'; ?></td>
              
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></form>
