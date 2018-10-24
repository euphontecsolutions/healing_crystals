<?php echo tep_draw_form('create_account', tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'), 'post', 'onSubmit="return check_form(create_account);"') . tep_draw_hidden_field('action', 'process') . tep_draw_hidden_field('newsletter', '1'); ?><table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
    
        
<script language="javascript">
function validatephone(xxxxx) 
{
    var maintainplus = '';
    var numval = xxxxx.value
    if ( numval.charAt(0)=='+' )
    {
        var maintainplus = '';
    }
    curphonevar = numval.replace(/[\\A-Za-z!"�$%^&\-\)\(*+_={};:'@#~,.�\/<>\" "\?|`�\]\[]/g,'');
    xxxxx.value = maintainplus + curphonevar;
    var maintainplus = '';
    xxxxx.focus;
}
</script>
      
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_account.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td align="center" width="25%">
						<table border="0" width="100%" cellspacing="0" cellpadding="0">
              				<tr>
              					<td width="50%"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
              					<td><?php echo tep_image(DIR_WS_IMAGES . 'checkout_bullet.gif'); ?></td>
                				<td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
				            </tr>
			            </table>
					</td>
					<td align="center" width="25%">
						<table border="0" width="100%" cellspacing="0" cellpadding="0">
              				<tr>
              					<td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
              					<td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
				            </tr>
			            </table>
					</td>	
		            <td align="center" width="25%">
						<table border="0" width="100%" cellspacing="0" cellpadding="0">
              				<tr>
              					<td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
              					<td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
				            </tr>
			            </table>
					</td>		            
		            <td align="center" width="25%">
						<table border="0" width="100%" cellspacing="0" cellpadding="0">
              				<tr>
              					<td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '100%', '1'); ?></td>
              					<td width="50%"><?php echo tep_draw_separator('pixel_silver.gif', '1', '5'); ?></td>
              					<td width="50%"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
				            </tr>
			            </table>
					</td>
          		</tr>
				<tr>         
					<td align="center" width="25%" class="checkoutBarCurrent">Login/Signup<br/>Step 1</td>
		            <td align="center" width="25%" class="checkoutBarTo">Select Products<br/>Step 2</td>	
		            <td align="center" width="25%" class="checkoutBarTo">Enter Payment/Delivery Info<br/>Step 3</td>
		            <td align="center" width="25%" class="checkoutBarTo">Review Order<br/>Step 4</td>
		        </tr>
     		</table>
     	</td>
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
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>
      <tr>
        <td class="smallText"><br><?php echo sprintf(TEXT_ORIGIN_LOGIN, tep_href_link(FILENAME_LOGIN, tep_get_all_get_params(), 'SSL')); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  if ($messageStack->size('create_account') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('create_account'); ?></td>
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
            <td class="main"><b><?php echo CATEGORY_PERSONAL; ?></b></td>
           <td class="inputRequirement" align="right"><?php echo FORM_REQUIRED_INFORMATION; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">
<?php
  if (ACCOUNT_GENDER == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_GENDER; ?></td>
                <td class="main"><?php echo tep_draw_radio_field('gender', 'm') . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . tep_draw_radio_field('gender', 'f') . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . (tep_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  }
?>
              <tr>
                <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
                <td class="main"><?php echo tep_draw_input_field('firstname') . '&nbsp;' . (tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
                <td class="main"><?php echo tep_draw_input_field('lastname') . '&nbsp;' . (tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_PASSWORD; ?></td>
                <td class="main"><?php echo tep_draw_password_field('password') . '&nbsp;' . (tep_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></td>
                <td class="main"><?php echo tep_draw_password_field('confirmation') . '&nbsp;' . (tep_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  if (ACCOUNT_DOB == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
                <td class="main"><?php echo tep_draw_input_field('dob') . '&nbsp;' . (tep_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="inputRequirement">' . ENTRY_DATE_OF_BIRTH_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  }
?>
              
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo CATEGORY_CONTACT; ?></b></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
                <td class="main"><?php echo tep_draw_input_field('email_address') . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
                <td class="main"><?php //echo '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>';?><?php echo tep_draw_input_field('telephone','','onkeyup="validatephone(this);"') . '&nbsp;' . (tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?></td>
              </tr>              
            </table></td>
          </tr>
        </table></td>
      </tr>

      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo CATEGORY_ADDRESS; ?></b></td>
      </tr>
      <tr>
        <td><table id="billingAdd"  border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">
            <?php
  if (ACCOUNT_COMPANY == 'true') {
?>
      
   
              <tr>
                <td class="main"><?php echo ENTRY_COMPANY; ?></td>
                <td class="main"><?php echo tep_draw_input_field('company') . '&nbsp;' . (tep_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?></td>
              </tr>
            
<?php
  }
?>
              <tr>
                <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>
                <td class="main"><?php echo tep_draw_input_field('street_address', '', 'id="street_address"') . '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_SUBURB; ?></td>
                <td class="main"><?php echo tep_draw_input_field('suburb', '', 'id="suburb"') . '&nbsp;' . (tep_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  }
?>
              <tr>
                <td class="main"><?php echo ENTRY_CITY; ?></td>
                <td class="main"><?php echo tep_draw_input_field('city', '', 'id="city"') . '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  if (ACCOUNT_STATE == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_STATE; ?></td>
                <td class="main">
<?php
    if ($process == true) {
      if ($entry_state_has_zones == true) {
        $zones_array = array();
        $zones_array[] = array('id' => '', 'text' => TEXT_SELECT_ZONE);
        $zones_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' order by zone_name");
        while ($zones_values = tep_db_fetch_array($zones_query)) {
          $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
        }
        echo tep_draw_pull_down_menu('state', $zones_array, '', 'id="state"');
      } else {
        echo tep_draw_input_field('state', '', 'id="state"');
      }
    } else {
      echo tep_draw_input_field('state', '', 'id="state"');
    }

    if (tep_not_null(ENTRY_STATE_TEXT)) echo '&nbsp;<span class="inputRequirement">' . ENTRY_STATE_TEXT.'</span>';
?>
                </td>
              </tr>
<?php
  }
?>
              <tr>
                <td class="main"><?php echo ENTRY_POST_CODE; ?></td>
                <td class="main"><?php echo tep_draw_input_field('postcode', '', 'id="postcode"') . '&nbsp;' . (tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?></td>
              </tr>

              <tr>
                <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
                <td class="main"><?php echo tep_get_country_list('country', ((int)$country != '' ? (int)$country : ''), 'id="country"') . '&nbsp;' . (tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr> 
      <tr>
        <td class="main"><b>SHIPPING ADDRESS</b><input type="checkbox" name="copyadd" value="1" onclick="javascript:if(this.checked){copyAdrress();}else{flushAdrress();}"> Same as Billing Address (Auto-Fill).</td>
      </tr>
      <tr>
        <td><table id="shippingAdd" border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" cellspacing="2" cellpadding="2">
            <?php
  if (ACCOUNT_COMPANY == 'true') {
?>
      
   
              <tr>
                <td class="main"><?php echo ENTRY_COMPANY; ?></td>
                <td class="main"><?php echo tep_draw_input_field('company2') . '&nbsp;' . (tep_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?></td>
              </tr>
            
<?php
  }
?>
              <tr>
                <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>
                <td class="main"><?php echo tep_draw_input_field('street_address2', '', 'id="street_address2"') . '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_SUBURB; ?></td>
                <td class="main"><?php echo tep_draw_input_field('suburb2', '', 'id="suburb2"') . '&nbsp;' . (tep_not_null(ENTRY_SUBURB_TEXT) ? '': ''); ?></td>
              </tr>
<?php
  }
?>
              <tr>
                <td class="main"><?php echo ENTRY_CITY; ?></td>
                <td class="main"><?php echo tep_draw_input_field('city2', '', 'id="city2"') . '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  if (ACCOUNT_STATE == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_STATE; ?></td>
                <td class="main">
<?php
    if ($process == true) {
      if ($entry_state_has_zones == true) {
        $zones_array = array();
        $zones_array[] = array('id' => '', 'text' => TEXT_SELECT_ZONE);
        $zones_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' order by zone_name");
        while ($zones_values = tep_db_fetch_array($zones_query)) {
          $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
        }
        echo tep_draw_pull_down_menu('state2', $zones_array, '', 'id="state2"');
      } else {
        echo tep_draw_input_field('state2', '', 'id="state2"');
      }
    } else {
      echo tep_draw_input_field('state2', '', 'id="state2"');
    }

    if (tep_not_null(ENTRY_STATE_TEXT)) echo '<span class="inputRequirement">' . ENTRY_STATE_TEXT . '</span>';
?>
                </td>
              </tr>
<?php
  }
?>
              <tr>
                <td class="main"><?php echo ENTRY_POST_CODE; ?></td>
                <td class="main"><?php echo tep_draw_input_field('postcode2', '', 'id="postcode2"') . '&nbsp;' . (tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?></td>
              </tr>

              <tr>
                <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
                <td class="main"><?php echo tep_get_country_list('country2', ((int)$country2 != '' ? (int)$country2 : ''), 'id="country2"') . '&nbsp;' . (tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
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
<tr class="infoBoxContents">
            <td class="main"><span class="inputRequirement">*</span> Required fields to create an account.</td>
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
                <td><?php echo tep_template_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></form>

