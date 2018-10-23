
   
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style type="text/css">
  panel-body
</style>
<div class="container">
  <table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>"></table>
<?php

if(isset($HTTP_GET_VARS['updateAdd'])&($HTTP_GET_VARS['updateAdd']!='')){
$query = tep_db_query("update customers set customers_default_shipping_id = '".$_GET['updateAdd']."' where customers_id='".$customer_id ."'");
$customer_default_shipping_id = (int)$_GET['updateAdd'];
$HTTP_SESSION_VARS['customer_default_shipping_id']=$_GET['updateAdd'];
$_SESSION['customer_default_shipping_id']=$_GET['updateAdd'];
}

// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
     <div class="row"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <?php if ($_SESSION['checkout']=='cart') { ?>
           <tr style="border: 0px;"><td align="left" style="padding-bottom: 1%;"><a href="/shopping_cart_mobile.php" class="btn btn-info"  style="background-color: #4c6aafad !important; color: #001abc;float: left;">&laquo;  Back To Cart</a>
        </td></tr>
      <?php } ?>
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_address_book.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
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
  if ($messageStack->size('addressbook') > 0) {
?><div class="row">
  <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
      <tr>
        <td><?php echo $messageStack->output('addressbook'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr></table>
    </div>
<?php
  }
?>
    <div class="row">
      <div class="panel panel-default ">
        <div class="panel-heading"><div class="main"><b><?php echo PRIMARY_ADDRESS_TITLE; ?></b></div></div>
        <div class="panel-body">
      <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
          <tr class="Contents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
            <!--   <tr>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                <td class="main" width="50%" valign="top"><?php echo PRIMARY_ADDRESS_DESCRIPTION; ?></td>
                <td align="right" width="50%" valign="top">
                  <table class="table-responsive table-condensed" border="0" cellspacing="0" cellpadding="2">
                  
                </table></td>
              </tr> -->
              <tr>
                    <td class="main" ><?php echo tep_address_label($customer_id, $customer_default_shipping_id, true, ' ', '<br>'); ?></td>
                  </tr>
            </table></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="row" style="margin-bottom: 2%;">
   <table width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td class="main">        <table width="100%" cellspacing="0" cellpadding="0">         <TR>       <?php         if (tep_count_customer_address_book_entries() < MAX_ADDRESS_BOOK_ENTRIES) { ?>                   <td class="smallText" align="left"><?php echo '<a class="btn btn-info btn-block" href="'.tep_href_link(FILENAME_ADDRESS_BOOK_PROCESS, '', 'SSL') . '">' . IMAGE_BUTTON_ADD_ADDRESS. '</a>'; ?></td>                <?php                 }               ?>          </TR>        </table>         </td>
      </tr> </table>
    </div>

<div class="row">
      <div class="panel panel-default ">
        <div class="panel-heading"><div class="main"><b><?php echo ADDRESS_BOOK_TITLE; ?></b></div></div>

        <div class="panel-body">

<table  width="100%" cellspacing="0" cellpadding="2" class="table-responsive table-bordered">
<?php
  $addresses_query = tep_db_query("select address_book_id, entry_firstname as firstname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_suburb as suburb, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "'  order by firstname, lastname");
  while ($addresses = tep_db_fetch_array($addresses_query)) {
    $format_id = tep_get_address_format_id($addresses['country_id']);
?>
              <tr>
                <td>
             
                  <table class="table table-responsive table-bordered">
                  <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onClick="document.location.href='<?php echo tep_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $addresses['address_book_id'], 'SSL'); ?>'">
                    <td class="main" colspan="3"><b><?php echo tep_output_string_protected($addresses['firstname'] . ' ' . $addresses['lastname']); ?></b><?php if ($addresses['address_book_id'] == $customer_default_shipping_id) echo '&nbsp;<small><i>' . PRIMARY_ADDRESS . '</i></small>'; ?></td>
                 
                  </tr>
                  <tr>
                    <td colspan="3"><table class="table-condensed"  >
                      <tr>
                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                        <td class="main"><?php echo tep_address_format($format_id, $addresses, true, ' ', '<br>'); ?></td>
                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr style="border:0px;">   <?php 
                  echo '<td class=""><center><a class="btn btn-success" href="' . tep_href_link('address_book_mobile.php','updateAdd='.$addresses['address_book_id'] , 'SSL') . '">Set as default</a></center></td>';
                  echo '<td class=""><center><a  class="btn btn-primary" href="' . tep_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit=' . $addresses['address_book_id'], 'SSL') . '">'.SMALL_IMAGE_BUTTON_EDIT. '</a></center></td>';
                  echo '<td class=""><center><a style="background-color: #4c6aafad; color: white;" class="btn btn-info btn-sm"  href="' . tep_href_link('address_book_process_mobile.php', 'delete=' . $addresses['address_book_id'], 'SSL') . '">Delete</a></center></td>'; ?></tr>
                </table>
              </td>

              </tr>
<?php
  }
?>
            </table></div></div></div>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
      <div class="row">
      <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
          <tr class="Contents">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
             <!--  <tr> -->
               <!--  <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td> -->
              <!--   <td class="smallText"><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT, '', 'SSL') . '">' . tep_template_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?></td> -->
               <!--  <td class="smallText"><?php echo '<a class="btn btn-info" href="' . tep_href_link('checkout_payment_mobile.php', '', 'SSL') . '">' .IMAGE_BUTTON_BACK. '</a>'; ?></td> -->
              <!--   <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td> -->
              <!-- </tr> -->
            </table></td>
          </tr>
        </table></div>
        <div class="row">
       <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
      <tr>
        <td class="smallText"><?php echo sprintf(TEXT_MAXIMUM_ENTRIES, MAX_ADDRESS_BOOK_ENTRIES); ?></td>
      </tr>
    </table></div>
  </div>

