</tr></tbody></table>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <style type="text/css">
    .table-responsive {
        width: 100%;
        margin-bottom: 5px;
        overflow-y: hidden;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        border:none;
    }
    TD.pageHeading, TD.nfpageHeading, TD.pageHeadingAllProds, TD.allpicHeading, TD.regularHeading {

    text-align: center;
    width: 50%;

}
.pageHeading{
  background-color: transparent;
  width: 100%;
}
TEXTAREA{
          width:100%;
      }
      .contentSF{
          display:none;
      }
      .articleNavigation{
          display:none;
      }
      .headertextsmall{
          display:none;
      }
      .head_img {
          display:flex;
          flex-direction:row;
          justify-content:space-between;

        border-top: 0px solid #d2d2d2;
        padding-top: 30px;
      }
      
      .product_name {
          font-size:12px;
          flex-shrink:1;
              margin-top: 30px;
      }
      .product_img {
          flex-shrink:1;
          box-shadow: 5px 10px 5px 0px #d4d4d4;
      }
      .descrip {
          margin-top: 5%;
          display:flex;
          flex-direction:row;
          justify-content:space-between;
          border-bottom: 0px solid #e0e0e0;
         padding-bottom: 30px;

      }
      
      .text_price {
          padding-left: 10%;
          display:flex;
          flex-direction:column;
          justify-content:space-between;
          color:#000;
          text-align:center;
      }
      .updater{
          margin-left: 10%;
          display:flex;
          flex-direction:column;
          justify-content:space-between;
      }

.previous {
    background-color: #4CAF50;
    color: white;
}
a {
    text-decoration: none;
    display: inline-block;
    padding: 1px 10px;
}

a:hover {
    background-color: #ddd;
    color: black;
}
.container {
    padding-right: 13%;
    padding-left: 11%;
    margin-right: auto;
    margin-left: auto;
}
/* On screens that are 600px or less, set the background color to olive */
@media screen and (max-width: 600px) {
/*  body {
    background-color: red;
  }*/
    table {
    width: 100%;
  }
  .main-container {
    width: 100%;
  }
/*  img {
    width: 50%;
  }
*/
element {

}
.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {

    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 0px solid #ddd0;
    background-color: transparent;
    padding: 0px;
}
.table-condensed > tbody > tr > td, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > td, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > thead > tr > th {

    padding: 5px;

}
.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {

    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 0px solid #ddd;

}
TD.pageHeading, TD.nfpageHeading, TD.pageHeadingAllProds, TD.allpicHeading, TD.regularHeading {

    text-align: center;
    width: 50%;

}
}
   @media screen and (max-width: 360px) {
/*  table {
    width: 50%;
  }*/
  .main-containertable {
    width: 50%;
  }
}
@media screen and (max-width: 767px) {
    .table-responsive {
        width: 100%;
        margin-bottom: 5px;
        overflow-y: hidden;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        border:none;
    }
}
select{
  width:80%;
}
 </style>
 <div class="container">
    <?php echo tep_draw_form('checkout_address', tep_href_link('checkout_payment_address_mobile.php', '', 'SSL'), 'post', ' class="" style="background-color:transparent;" onSubmit="return check_form_optional(checkout_address);"'); ?>
   <!--  <table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>"> -->
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?><div class="row">
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="background-color: transparent;margin-bottom: 2%;">
      <tr style="border: 0px;"><td align="left"><a href="/checkout_payment_mobile.php" class="btn btn-info"  style="background-color: #4c6aafad !important; color: #001abc;float: left;">&laquo;  Back To Payment</a>
        </td></tr>
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            
          </tr>
        </table></div>
     
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
<?php
  if ($messageStack->size('checkout_address') > 0) {
?><div class="row">
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php echo $messageStack->output('checkout_address'); ?></td>
      </tr>
      </table>
    </div>
<?php
  }

  if ($process == false) {
?><div class="row">
    <table border="0" width="100%" cellspacing="0" >
          <tr>
            <td class="main"><b><?php echo TABLE_HEADING_PAYMENT_ADDRESS; ?></b></td>
          </tr>
        </table>
      </div>
        <div class="row">
     <table border="0" width="100%" cellspacing="1"  class="">
          <tr class="">
            <td><table border="0" width="100%" cellspacing="0" >
              <tr>
                
                <td class="main" width="50%" ><?php echo TEXT_SELECTED_PAYMENT_DESTINATION; ?></td>
                <td align="right" width="50%" ><table border="0" cellspacing="0" >
                  <tr>
                    <td class="main" ><?php echo tep_address_label($customer_id, $billto, true, ' ', '<br>'); ?></td>
                    
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table></div>
      
<?php
    if ($addresses_count > 1) {
?>
<div class="row">
  <table border="0" width="100%" cellspacing="0" >
          <tr>
            <td class="main"><b><?php echo TABLE_HEADING_ADDRESS_BOOK_ENTRIES; ?></b></td>
          </tr>
        </table></div>
        <div class="row">
        <table border="0" width="100%" cellspacing="1"  class="">
          <tr class="">
            <td><table border="0" width="100%" cellspacing="0" >
              <tr>
                
                <td class="main" width="50%" ><?php echo TEXT_SELECT_OTHER_PAYMENT_DESTINATION; ?></td>
                <!-- <td class="main" width="50%"  align="right"><?php echo '<b>' . TITLE_PLEASE_SELECT . '</b><br>' . tep_image(DIR_WS_IMAGES . 'arrow_east_south.gif'); ?></td> -->
                
              </tr>
<?php
      $radio_buttons = 0;

      $addresses_query = tep_db_query("select address_book_id, entry_firstname as firstname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_suburb as suburb, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . $customer_id . "'");
      while ($addresses = tep_db_fetch_array($addresses_query)) {
        $format_id = tep_get_address_format_id($addresses['country_id']);
?>
              <tr>
                
                <td colspan="2"><table border="0" width="100%" cellspacing="0" >
<?php
       if ($addresses['address_book_id'] == $billto) {
          echo '<tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
        } else {
          echo '<tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
        }
?>
                   
                    <td class="main" colspan="2"><b><?php echo $addresses['firstname'] . ' ' . $addresses['lastname']; ?></b></td>
                    <td class="main" align="right"><?php echo tep_draw_radio_field('address', $addresses['address_book_id'], ($addresses['address_book_id'] == $billto)); ?></td>
                   
                  </tr>
                  <tr>
                   
                    <td colspan="3"><table border="0" cellspacing="0" >
                      <tr>
                       
                        <td class="main"><?php echo tep_address_format($format_id, $addresses, true, ' ', ', '); ?></td>
                       
                      </tr>
                    </table></td>
                   
                  </tr>
                </table></td>
                
              </tr>
<?php
        $radio_buttons++;
      }
?>
            </table></td>
      
      
<?php
    }
  }

  if ($addresses_count < MAX_ADDRESS_BOOK_ENTRIES) {
?>
     <div class="row"> <table border="0" width="100%" cellspacing="0" >
          <tr>
            <td class="main"><b><?php echo TABLE_HEADING_NEW_PAYMENT_ADDRESS; ?></b></td>
          </tr>
        </table>
      </div>
        <div class="row">
    <table border="0" width="100%" cellspacing="1"  class="">
          <tr class="">
            <td><table border="0" width="100%" cellspacing="0" >
              <tr>
                
                <td class="main" ><?php echo TEXT_CREATE_NEW_PAYMENT_ADDRESS; ?></td>
                
              </tr>
              <tr>
                
                <td><table border="0" width="100%" cellspacing="0" >
                  <tr>
                   
                    <td><?php require(DIR_WS_MODULES . 'checkout_new_address.php'); ?></td>
                   
                  </tr>
                </table></td>
                
              </tr>
            </table></td>
          </tr>
        </table></div>
<?php
  }
?>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?><div class="row"><table border="0" width="100%" cellspacing="1" style="margin-top: 3%;">
          <tr class="">
            <td><table border="0" width="100%" cellspacing="0" >
              <tr>
          <!--       <td class="main"><?php echo '<b>' . TITLE_CONTINUE_CHECKOUT_PROCEDURE . '</b><br>' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></td> -->
                <td class="main" style="margin-top: 5%;" >
                 <!--  <?php echo tep_draw_hidden_field('action', 'submit') . tep_template_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td> -->
                 

                <input type="hidden" name="action" value="submit">
               <!--  <input type="image" src="/templates/New4/images/buttons/english/button_continue.gif" alt="Continue" title=" Continue "></td> -->
               <center><input class="btn btn-success btn-block" type="submit" value="<?php echo IMAGE_BUTTON_CONTINUE; ?>" ></center>
             
              </tr>

            </table></td>
          </tr>
        </table></div>
<?php
  if ($process == true) {
?>
<div class="row">
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php echo '<a href="' . tep_href_link('checkout_payment_address_mobile.php', '', 'SSL') . '">' . tep_template_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td>
      </tr></table></div>
<?php
  }
?>
</form>
    </div>
