
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <style>
      .main{
          color: #0b6486 !important;
    font-size: 16px !important;
      }
      
      html, body {
    height: 100%;
    overflow: auto;
    -webkit-overflow-scrolling: touch;
}
 .classic{
  padding-right: 15%;
 }
 .tamed {
  display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #18a7d0;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 2px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
 }

 .pageHeading {
  font:caption;
  color: #102712 !important;
 }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php echo tep_draw_form('create_account', tep_href_link('create_account_mobile.php', '', 'SSL'), 'post', 'onSubmit="return check_form(create_account);" class="tamed"') . tep_draw_hidden_field('action', 'process') . tep_draw_hidden_field('newsletter', '1'); ?>
<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
    
        
<script language="javascript">

var disableScroll = false;
var scrollPos = 0;
function stopScroll() {e.preventDefault();
    disableScroll = true;
    scrollPos = $(window).scrollTop();
}
function enableScroll() {
    disableScroll = false;
}
/*$(function(){
    $(window).bind('scroll', function(){
         if(disableScroll) $(window).scrollTop(scrollPos);
    });
    $(window).bind('touchmove', function(){alert();
         $(window).trigger('scroll');
    });
});
*/
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

    function copyAdrress1(){
       var company  = $("input[name=company]").val();
       var street_address  = $("input[name=street_address]").val();
       var suburb  = $("input[name=suburb]").val();
       var city  = $("input[name=city]").val();
       var state  = $("input[name=state]").val();
       var postcode  = $("input[name=postcode]").val();
       var country  = $("#country option:selected").val();
       
       $("input[name=company2]").val(company);
       $("input[name=street_address2]").val(street_address);
       $("input[name=suburb2]").val(suburb);
       $("input[name=city2]").val(city);
       $("input[name=state2]").val(state);
       $("input[name=postcode2]").val(postcode);
       $("#country2").val(country).change();
        
    }
    
    function flushAdrress1(){
         $("input[name=company2]").val('');
       $("input[name=street_address2]").val('');
       $("input[name=suburb2]").val('');
       $("input[name=city2]").val('');
       $("input[name=state2]").val('');
       $("input[name=postcode2]").val('');
       $("#country2").val('').change();
        
    }
</script>
      
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><center>Sign Up</center></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_account.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
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
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2" style="margin-top: -10px;">
          <tr>
            <td class=""><b><?php echo 'EMAIL/PASSWORD'; ?></b><br><br></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <style>
        .fexer_table {
          display: flex;
          flex-direction: column;
        }
          .fexer_tr {    
            display: flex;
            flex-direction: row;
            width: 100%;
            justify-content: space-between;
          }

          .fexer_text {
            flex-shrink: 2;
            flex-grow: 1;
            flex-basis: 50%;
          }
          .fexxer_input {
            flex-shrink: 1;
            flex-grow: 1;
            flex-basis: 60%;
          }
        </style>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
          <tr class="">
            <td><table border="0" cellspacing="2" cellpadding="2" class="fexer_table" width="100%">
<?php
  if (ACCOUNT_GENDER == 'true') {
?>
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_GENDER; ?></td>
                <td class="fexxer_input"><?php echo tep_draw_radio_field('gender', 'm') . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . tep_draw_radio_field('gender', 'f','class="form-control"') . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . (tep_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  }
?>
<!--<tr class="fexer_tr"><td class="fexer_text"><?php echo ENTRY_EMAIL_ADDRESS . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo '<input type="text" name="email_address" autocomplete="off" class="form-control" onclick="stopScroll()">'. '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
              </tr>-->
              
              <tr class="fexer_tr"><td class="fexer_text"><?php echo ENTRY_EMAIL_ADDRESS . '&nbsp;' . (tep_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><input type="email" name="email_address" autocomplete="off" class="form-control" onclick="stopScroll()">&nbsp;<span class="inputRequirement"></span></td>
              </tr>
             
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_PASSWORD. '&nbsp;' . (tep_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_password_field('password','','class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
              </tr>
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_PASSWORD_CONFIRMATION. '&nbsp;' . (tep_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_password_field('confirmation','','class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
              </tr>
<?php
  if (ACCOUNT_DOB == 'true') {
?>
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_DATE_OF_BIRTH . '&nbsp;' . (tep_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="inputRequirement">' . ENTRY_DATE_OF_BIRTH_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_input_field('dob','','class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
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
        <td class=""><b><?php echo CATEGORY_CONTACT; ?></b><br><br></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
          <tr class="">
            <td><table class="fexer_table" border="0" cellspacing="2" cellpadding="2"  width="100%">
               <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_FIRST_NAME . '&nbsp;' . (tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_input_field('firstname','','class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>': ''); ?></td>
              </tr>
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_LAST_NAME. '&nbsp;' . (tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_input_field('lastname','','class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
              </tr>
              <!--<tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_TELEPHONE_NUMBER . '&nbsp;' . (tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php //echo '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>';?><?php echo tep_draw_input_field('telephone','','onkeyup="validatephone(this);" class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
              </tr>   -->
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_TELEPHONE_NUMBER . '&nbsp;' . (tep_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><input type="number" name="telephone" onkeyup="validatephone(this);" class="form-control">&nbsp;<span class="inputRequirement"></span></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>

      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class=""><b><?php echo CATEGORY_ADDRESS; ?></b><br><br></td>
      </tr>
      <tr>
        <td><table id="billingAdd"  border="0" width="100%" cellspacing="1" cellpadding="2" class="">
          <tr class="">
            <td><table class="fexer_table" border="0" cellspacing="2" cellpadding="2"  width="100%">
            <?php
  if (ACCOUNT_COMPANY == 'true') {
?>
      
   
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_COMPANY . '&nbsp;' . (tep_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_input_field('company','','class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
              </tr>
            
<?php
  }
?>
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_STREET_ADDRESS. '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_input_field('street_address', '', 'id="street_address" class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
              </tr>
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_SUBURB . '&nbsp;' . (tep_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_input_field('suburb', '', 'id="suburb" class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
              </tr>
<?php
  }
?>
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_CITY. '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_input_field('city', '', 'id="city" class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
              </tr>
<?php
  if (ACCOUNT_STATE == 'true') {
?>
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_STATE;  if (tep_not_null(ENTRY_STATE_TEXT)) echo '&nbsp;<span class="inputRequirement">' . ENTRY_STATE_TEXT.'</span>';?></td>
                <td class="fexxer_input">
<?php
    if ($process == true) {
      if ($entry_state_has_zones == true) {
        $zones_array = array();
        $zones_array[] = array('id' => '', 'text' => TEXT_SELECT_ZONE);
        $zones_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' order by zone_name");
        while ($zones_values = tep_db_fetch_array($zones_query)) {
          $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
        }
        echo tep_draw_pull_down_menu('state', $zones_array, '', 'id="state" class="form-control"');
      } else {
        echo tep_draw_input_field('state', '', 'id="state" class="form-control"');
      }
    } else {
      echo tep_draw_input_field('state', '', 'id="state" class="form-control"');
    }

   
?><br>
                </td>
              </tr>
<?php
  }
?>
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_POST_CODE. '&nbsp;' . (tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_input_field('postcode', '', 'id="postcode" class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
              </tr>

              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_COUNTRY . '&nbsp;' . (tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_get_country_list('country', ((int)$country != '' ? (int)$country : ''), 'id="country" class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
     
      <tr>
        <td class=""><b>SHIPPING ADDRESS</b><br>
        <br><input type="checkbox" name="copyadd" value="1" onclick="copyAdrress()"> Same as Billing Address (Auto-Fill).
        </td>
      </tr>
      <tr>
        <td><table id="shippingAdd" border="0" width="100%" cellspacing="1" cellpadding="2" class="">
          <tr class="">
            <td><table class="fexer_table" border="0" cellspacing="2" cellpadding="2"  width="100%">
            <?php
  if (ACCOUNT_COMPANY == 'true') {
?>
      
   
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_COMPANY. '&nbsp;' . (tep_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_input_field('company2','',' class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement clasic"></span>': ''); ?></td>
              </tr>
            
<?php
  }
?>
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_STREET_ADDRESS. '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement clasic">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_input_field('street_address2', '', 'id="street_address2" class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
              </tr>
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_SUBURB. '&nbsp;' . (tep_not_null(ENTRY_SUBURB_TEXT) ? '': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_input_field('suburb2', '', 'id="suburb2" class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_SUBURB_TEXT) ? '': ''); ?></td>
              </tr>
<?php
  }
?>
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_CITY . '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement clasic">' . ENTRY_CITY_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_input_field('city2', '', 'id="city2" class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement clasic"></span>': ''); ?></td>
              </tr>
<?php
  if (ACCOUNT_STATE == 'true') {
?>
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_STATE;if (tep_not_null(ENTRY_STATE_TEXT)) echo '<span class="inputRequirement clasic">' . ENTRY_STATE_TEXT . '</span>'; ?></td>
                <td class="fexxer_input">
<?php
    if ($process == true) {
      if ($entry_state_has_zones == true) {
        $zones_array = array();
        $zones_array[] = array('id' => '', 'text' => TEXT_SELECT_ZONE);
        $zones_query = tep_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' order by zone_name");
        while ($zones_values = tep_db_fetch_array($zones_query)) {
          $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
        }
        echo tep_draw_pull_down_menu('state2', $zones_array, '', 'id="state2" class="form-control"');
      } else {
        echo tep_draw_input_field('state2', '', 'id="state2" class="form-control"');
      }
    } else {
      echo tep_draw_input_field('state2', '', 'id="state2" class="form-control"');
    }

   
?><br>
                </td>
              </tr>
<?php
  }
?>
              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_POST_CODE . '&nbsp;' . (tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_draw_input_field('postcode2', '', 'id="postcode2" class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
              </tr>

              <tr class="fexer_tr">
                <td class="fexer_text"><?php echo ENTRY_COUNTRY. '&nbsp;' . (tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
                <td class="fexxer_input"><?php echo tep_get_country_list('country2', ((int)$country2 != '' ? (int)$country2 : ''), 'id="country2" class="form-control"') . '&nbsp;' . (tep_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement"></span>': ''); ?></td>
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

<tr class="">
            <td class=""><span class="inputRequirement">*</span> Required fields to create an account.</td>
          </tr>
     
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
          <tr class="">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td><?php echo tep_template_image_submit('mob_submit.png', IMAGE_BUTTON_CONTINUE,'style="margin-top: -27px;"'); ?></td>
                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></form>

