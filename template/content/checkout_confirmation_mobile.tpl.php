<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://www.copy.healingcrystals.com/hybrid_api/bootstrap-3.3.7/js/dropdown.js"></script><style>
    #blanket{
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 5;
    }    
    #blanketDiv{
        background-color: #FFFFFF;
        height: 75%;
        margin: 50px 10%;
        opacity: 1;
        position: absolute;
        top: 10px;
        width: 80%;
        z-index: 6;
        overflow: hidden;
    }
    #address_fields{
        display: none;
    }
    #shippingDetails{
        display: none;
    }
 
.panel {
    padding: 1%;
    margin-top: 1%;
    margin-bottom: 1%;
}
.headingpay {

    padding-right: 14%;

}
.paymentpay{

}
</style>
<script>
    var selected;

function selectRowEffect(object, buttonSelect) {
  if (!selected) {
    if (document.getElementById) {
      selected = document.getElementById('defaultSelected');
    } else {
      selected = document.all['defaultSelected'];
    }
  }

  if (selected) selected.className = 'moduleRow';
  object.className = 'moduleRowSelected';
  selected = object;

// one button is not an array
  if (document.checkout_address.address[0]) {
    document.checkout_address.address[buttonSelect].checked=true;
  } else {
    document.checkout_address.address.checked=true;
  }
}

function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}
function showBlanket(){
    $("#blanket").toggle();
}
function addNewEntry(){
    $('#address_list').toggle();
    $('#address_fields').toggle();
}
function backFromshippingMethod(){
    $('#address_list').toggle();
    $('#shippingDetails').toggle();
}
function editEntry(entryId){
    var url = 'checkout_confirmation.php?action=getData&addId='+entryId; 
    $('input[name=addId]').val(entryId);
    $.post(url, function(data) {
        if(data != 'no address found'){
            //alert(data);
            var add = data.split("|");
            var fname = add[0];
            var lname = add[1];
            var add1 = add[2];
            var add2 = add[3];
            var pocode = add[4];
            var city = add[5];
            var country = add[6];
            var zoneid = add[7];
            var state = add[8];
            $('input[name=firstname]').val(fname);
            $('input[name=lastname]').val(lname);
            $('input[name=street_address]').val(add1);
            $('input[name=suburb]').val(add2);
            $('input[name=postcode]').val(pocode);
            $('input[name=city]').val(city);
            $('input[name=state]').val(state);
            $('select[name=country]').val(country);
        }
    });
    $('#address_list').toggle();
    $('#address_fields').toggle();
}
function get_all_zone(countryId){
    var url = 'checkout_confirmation.php?action=getzone&cId='+countryId;
    $.post(url, function(data) {
        if (data != 'no zone'){
            $('#stateData').html(data);
        }
    });
}
function setDefault(){
    var selAddId = $('input[name=address]:checked').val();
    var url = 'checkout_confirmation.php?action=udateSendto&addId='+selAddId;
    $.post(url, function(data) {
        if(data == 'success'){
            showShippingMethod(selAddId);
            $('#address_list').toggle();
            $('#shippingMethod').html('<div style="margin: auto; width: 37%;"><img src="images/loader1.gif"></div>');
            $('#shippingDetails').toggle();
        }
    });
} 
function processData(){
    var fname = $('input[name=firstname]').val();
    var lname = $('input[name=lastname]').val();
    var add1 = $('input[name=street_address]').val();
    var add2 = $('input[name=suburb]').val();
    var pocode = $('input[name=postcode]').val();
    var city = $('input[name=city]').val();
    if($('select[name=state]').length){
        var state = $('select[name=state]').val();
    }else{
        var state = $('input[name=state]').val();
    }
    var country = $('select[name=country]').val();
    var addId = $('input[name=addId]').val();
    var error = false;
    var errorMsg = '';
    if(fname == '' || fname.length < 3){
        error = true;
        errorMsg = errorMsg + '* first name must be grater than 2 chracters '+"\n";
    }
    if(lname == '' || lname.length < 3){
        error = true;
        errorMsg = errorMsg + '* last name must be grater than 2 chracters '+"\n";
    }
    if(add1 == '' || add1.length < 5){
        error = true;
        errorMsg = errorMsg + '* address1 must be contain 5 chracters '+"\n";
    }
    if(pocode == '' ){
        error = true;
        errorMsg = errorMsg + '* postcode must not be empty '+"\n";
    }
    if(city == '' ){
        error = true;
        errorMsg = errorMsg + '* city must not be empty '+"\n";
    }
    if(state == '' ){
        error = true;
        errorMsg = errorMsg + '* state must not be empty '+"\n";
    }
    if(country == '' ){
        error = true;
        errorMsg = errorMsg + '* Please select a country  '+"\n";
    }
    if(error == false){
        var url = 'checkout_confirmation.php?action=processData&addId='+addId+'&fname='+fname+'&lname='+lname+'&add1='+add1+'&add2='+add2+'&pocode='+pocode+'&city='+city+'&state='+state+'&country='+country;
        $.post(url, function(data) {
            var splitData = data.split(" : ");
            if(splitData[0] == 'success'){
                showShippingMethod(splitData[1]);
                $('#address_fields').toggle();
                $('#shippingMethod').html('<div style="margin: auto; width: 37%;"><img src="images/loader1.gif"></div>');
                $('#shippingDetails').toggle();
            }else if(splitData[0] == 'state error'){
                get_all_zone(country);
                $('#showError').css('color','red');
                $('#showError').html(splitData[1]+'select a state from state dropdown list');
            }else if(splitData[0] == 'error'){
                $('#showError').css('color','red');
                $('#showError').html(splitData[1]);
            }
            
        });
    }else{
        alert (errorMsg);
    }
}
function showShippingMethod(sendto){
    var url = 'checkout_confirmation.php?action=showShipping&sendto='+sendto;
    $.post(url, function(data) {
        $('#shippingMethod').html(data);
    });
}
</script>    
<div class="container">
<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">

<?php

// BOF: Lango Added for template MOD

if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {

$header_text = '&nbsp;'

//EOF: Lango Added for template MOD

#  9/19/08 edit by Bob <www.site-webmaster.com>: 
#  added FOOTER_CONTINUE_CHECKOUT_PROCEDURE & right aligned buttons 2 places
 
?>


      <tr>

        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">

          <tr>

            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>

            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_confirmation.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>

          </tr>

        </table></td>

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

<?php

// BOF: Lango Added for template MOD

if (MAIN_TABLE_BORDER == 'yes'){

table_image_border_bottom();

}

// EOF: Lango Added for template MOD

?>

      <tr>

        <td><?php 
         if (isset($$payment->form_action_url)) {

    $form_action_url = $$payment->form_action_url;

  } else {

    $form_action_url = tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');

  }



  echo tep_draw_form('checkout_confirmation', $form_action_url, 'post','onSubmit="return checkFields(checkout_confirmation);"');
        
  ?><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

          <tr class="infoBoxContents">

            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

              <tr>


<?php

  


  if (is_array($payment_modules->modules)) {

    echo $payment_modules->process_button();

  }

?>

              </tr>

            </table></td>

          </tr>

        </table></form></td>

      </tr>


      <tr>

        <td>
         </td>

      </tr>
      <tr><td>
        <!-- starting payment --><div class="panel panel-default "><h4><b>Item Description</b></h4><div class="panel-body"><table border="0" width="100%" cellspacing="0" cellpadding="0">

              <tr>

                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php

  if (sizeof($order->info['tax_groups']) > 1) {

?>

                  <tr>

                    <td class="main" colspan="2"><?php echo '<b>' . HEADING_PRODUCTS . '</b> <a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td>

                    <td class="smallText" align="right"><b><?php echo HEADING_TAX; ?></b></td>

                    <td class="smallText" align="right"><b><?php echo HEADING_TOTAL; ?></b></td>

                  </tr>

<?php

  } else {

?>

                  <tr>

                    <td class="main" colspan="3"><?php echo '<b>' . HEADING_PRODUCTS . '</b> <a href="' . tep_href_link(FILENAME_SHOPPING_CART) . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td>

                  </tr>

<?php

  } ?><?php



  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {

    echo '          <tr>' . "\n" .

         '            <td class="main" align="right" valign="top" width="30">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .

         '            <td class="main" valign="top">' . stripslashes($order->products[$i]['name']);



    if (STOCK_CHECK == 'true') {

      echo tep_check_stock($order->products[$i]['id'], $order->products[$i]['qty']);

    }



    if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {

      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {

        echo '<br><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . stripslashes($order->products[$i]['attributes'][$j]['value']) . '</i></small>';

      }

    }



    echo '</td>' . "\n"; 



    if (sizeof($order->info['tax_groups']) > 1) echo '            <td class="main" valign="top" align="right">' . tep_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n";



    echo '            <td class="main" align="right" valign="top">' . $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . '</td>' . "\n" .

         '          </tr>' . "\n";

  }

?>

                </table></td>

              </tr>

            </table>
            <!-- ending payments --></div></div>
            <!-- =========== -->
            <div class="panel panel-default "><div class="panel-body" ><table border="0" cellspacing="0" cellpadding="2">

<?php

  if (MODULE_ORDER_TOTAL_INSTALLED) {

   // $order_total_modules->process();

    echo $order_total_modules->output();

  }

?>

            </table></div></div>
            <!-- =============== -->
      </td></tr>


      <tr>

        <td>

          <!-- billing starts -->
          <div class="panel panel-default "><?php echo HEADING_BILLING_INFORMATION; ?><!-- <h4><b>Item Description</b></h4> --><div class="panel-body">
            <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

          <tr>

            <td width="50%" valign="top">
               <div class="panel panel-default " style="margin-right:1%;text-align: left;padding-left: 1px;padding:0%;float: left; "><div class="panel-body" >
                <table border="0" width="100%" cellspacing="0" cellpadding="2">

              <tr>

                <? //---PayPal WPP Modification START ---// ?>

<? //I did this because $order->billing is getting erased somewhere and I haven't found where yet ?>

<?php if ($ec_checkout && $ec_enabled) { ?>

                <td class="main"></td>

              </tr>

              <tr>

                <td class="main"><?php echo ($ec_checkout ? MODULE_PAYMENT_PAYPAL_EC_TEXT_TITLE : MODULE_PAYMENT_PAYPAL_DP_TEXT_TITLE); ?></td>

              </tr>

              <tr>

<?php } else { ?>

              <td class="main"><?php echo '<b>' . HEADING_BILLING_ADDRESS . '</b><a href="' . tep_href_link('checkout_payment_address_mobile.php', '', 'SSL') . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>';?></td>
             <!--  <td class="main"><?php echo '<b>' . HEADING_BILLING_ADDRESS . '</b>';?></td> -->

              </tr>

              <tr>

                <td class="main"><?php echo tep_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br>'); ?></td>

              </tr>

             

<?php } ?>



            </table></div></div></td>

            <td width="0%;"  valign="top"> <!-- delivery starts -->
          <div class="panel panel-default "  style="margin-left:1%;padding-right: 1px;padding:0%; float: right; "><div class="panel-body" >
            <table border="0" width="100%" cellspacing="1" cellpadding="2" >

       

<?php

  if ($sendto != false) {

?>

            <tr>

              <tr>

              

              <!--   <td class="main"><?php echo '<b>' . HEADING_DELIVERY_ADDRESS . '</b><a href="#" onclick="showBlanket(); return false;"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td> -->
                <td class="main"><?php echo '<b>' . HEADING_DELIVERY_ADDRESS . '</b><a href="' . tep_href_link('address_book_mobile.php', 'checkout=cart', 'SSL') .'"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td>



              </tr>

              <tr>

                <td class="main"><?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br>'); ?></td>

              </tr>

            <!-- shipping method -->

<?php

  }

?><tr>

            <td width="<?php echo (($sendto != false) ? '70%' : '100%'); ?>" valign="top">
              </td>

          </tr>

        </table></div></div>
        <!-- delivery ends --></td>

          </tr>

        </table></div></div>
        <!-- Billing ends --></td>

      </tr>
      <tr><td>  <!-- shipping method starts -->
              <div class="panel panel-default "><div class="panel-body" style="padding: 0px;">
                <table border="0" width="100%" cellspacing="0" cellpadding="2">
          
<?php

    if ($order->info['shipping_method']) {

?>

              <tr>

                <td class="main"><?php echo '<b>' . HEADING_SHIPPING_METHOD . '</b> <a href="' . tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL') . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td>

              </tr>

              <tr>

                <td class="main"><?php echo $order->info['shipping_method']; ?></td>

              </tr>

<?php

    }

?>
        </table></div></div>
      </td></tr>


      <!-- payment method -->

           <tr><td>  <!-- shipping method starts -->
              <div class="panel panel-default "><div class="panel-body" style="padding: 0px;">
                <table border="0" width="100%" cellspacing="0" cellpadding="2">
     <tr>

  <?php    if ($show_payment_page || !$ec_enabled) {

?>

                <td class="main"><?php echo '<b>' . HEADING_PAYMENT_METHOD . '</b> <a href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td>

<?php } else { ?>

                <td class="main"><?php echo '<b>' . HEADING_PAYMENT_METHOD . '</b>'; ?></td>

<?php } ?>

<? //---PayPal WPP Modification END ---// ?>



              </tr>

              <tr>

               <? //---PayPal WPP Modification START ---// ?>

<?php if ($ec_checkout && $ec_enabled) { ?>

                <td class="main"><?php echo MODULE_PAYMENT_PAYPAL_EC_TEXT_TITLE; ?></td>

<?php } else { ?>

                <td class="main"><?php echo $order->info['payment_method']; ?></td>

<?php } ?>

<? //---PayPal WPP Modification END ---// ?>



              </tr>
        </table></div></div>
      </td></tr>
      <!-- payment method ends -->


  <tr><td>  <!-- shipping method starts -->
              <div class="panel panel-default "><div class="panel-body" style="padding: 0px;">
                <table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php

// BOF: Lango modified for print order mod

  if (is_array($payment_modules->modules)) {

    if ($confirmation = $payment_modules->confirmation()) {

      $payment_info = $confirmation['title'];

      if (!tep_session_is_registered('payment_info')) tep_session_register('payment_info');

// EOF: Lango modified for print order mod

?>

      <tr>

        <td class="main"><b><?php echo HEADING_PAYMENT_INFORMATION; ?></b></td>

      </tr>
<?php if(tep_session_is_registered('retail_rep') && $_SESSION['retail_rep'] != ''){ ?>
    <tr>

        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

          <tr class="infoBoxContents">

            <td><table border="0" cellspacing="0" cellpadding="2">

      <tr>

                  <td class="main" colspan="4"><?php echo 'Make Payable To: <u>'.ucfirst($_SESSION['retail_cust_fname']).'</u> <u>'.ucfirst($_SESSION['retail_cust_lname']).'</u>'.(tep_session_is_registered('retail_cust_email')?'<br/><br/> Mail Payment To: '.$_SESSION['retail_cust_email']:''); ?></td>

              </tr>

            </table></td>

          </tr>

        </table></td>

      </tr>

<?php }else{?>
      <tr>

        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

          <tr class="infoBoxContents">

            <td><table border="0" cellspacing="0" cellpadding="2">

              <tr>

                <td class="main" colspan="4"><?php echo $confirmation['title']; ?></td>

              </tr>

<?php

      for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++) {

?>

              <tr>

                <td class="main"><?php echo $confirmation['fields'][$i]['title']; ?></td>
                 <td class="main"><?php echo stripslashes($confirmation['fields'][$i]['field']); ?></td>

              </tr>

<?php

      }

?>

            </table></td>

          </tr>

        </table></td>

      </tr>

<?php

    } ?>
      </table></div></div>
      </td></tr>
    <?php
    }

  }

?>


<?php

  if (tep_not_null($order->info['comments'])) {

?>

      <tr>

        <td class="main"><?php echo '<b>' . HEADING_ORDER_COMMENTS . '</b> <a href="' . tep_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '"><span class="orderEdit">(' . TEXT_EDIT . ')</span></a>'; ?></td>

      </tr>

      <tr>

        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

          <tr class="infoBoxContents">

            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

              <tr>

                <td class="main"><?php echo nl2br(tep_output_string_protected($order->info['comments'])) . tep_draw_hidden_field('comments', $order->info['comments']); ?></td>

              </tr>

            </table></td>

          </tr>

        </table></td>

      </tr>

<?php

  }

?>
 <tr>

        <td><?php  if (isset($$payment->form_action_url)) {

    $form_action_url = $$payment->form_action_url;

  } else {

    $form_action_url = tep_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');

  }



  echo tep_draw_form('checkout_confirmation', $form_action_url, 'post','onSubmit="return checkFields(checkout_confirmation);"');
        ?><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">

          <tr class="infoBoxContents">

            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">

              <tr>


<?php

  


  if (is_array($payment_modules->modules)) {

    echo $payment_modules->process_button();

  }

?>



                <td class="main"></td>

                <td align="left" id="processpayment1" class="processpayment">
           <!--      <?php //echo TITLE_CONTINUE_CHECKOUT_PROCEDURE; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  //echo tep_template_image_submit('button_place_order.gif', IMAGE_BUTTON_CONFIRM_ORDER) . '' . "\n<BR><SMALL>" . FOOTER_CONTINUE_CHECKOUT_PROCEDURE . '</SMALL>';?> -->
                 <button type="submit" class="btn btn-primary btn-block">Place Order</button>
                
                </td>

                <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?><img src="images/ajax-loader.gif" id="loadingimage1" alt="Processing Order" width="1" height="1"></td>





              </tr>

            </table></td>

          </tr>

        </table></form></td>

      </tr>
      <tr><td class="main" style="font-size:15px;"><br><b><i>If you are experiencing any errors on our website or if you are having problems checking out, please <a class="main" href="<?php echo tep_href_link('checkout_problems_mobile.php');?>" class="main"><u>Let Us Know</u></a>.</i></b></td></tr>
</table>
<div id="blanket">
    <div id="blanketDiv"> 
        <div style="width:20px; color: black; margin-right: 10px; margin-top: 10px; float:right;"><a href="#" onclick="showBlanket(); return false;"><b>x</b></a></div>
        <div style="width:96%; padding:20px; overflow-x: scroll; overflow-y: scroll; max-height: 100%;">
            <div id="address_list">
                <table width="100%" cellspacing="0" cellpading="0" id="address_data">
                  <!--   <tr>
                        <td class="main"><b><?php echo 'Default Address'; ?></b></td>
                    </tr> -->
                 <!--    <tr>
                        <td><table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
                          <tr class="">
                            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                              <tr>
                                <td align="left" width="50%" valign="top"><table border="0" cellspacing="0" cellpadding="2">
                                  <tr>
                               
                                    <td class="main" ><?php echo tep_address_label($customer_id, $customer_default_shipping_id, true, ' ', '<br>'); ?></td>
                                   
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table></td>
                    </tr> -->
                    <tr>
                        <td class="main">        
                            <table width="100%" cellspacing="0" cellpadding="0">        	
                                <tr>        		
                                    <td class="main" width="20%"><b><?php echo 'More Shipping Addresses'; ?></b></td>				
                            <?php if (tep_count_customer_address_book_entries() < MAX_ADDRESS_BOOK_ENTRIES) { ?>								                
                                    <td class="smallText" align="left"><?php echo '<a class="btn btn-info" href="#" onclick="addNewEntry(); return false;">' . IMAGE_BUTTON_ADD_ADDRESS. '</a>'; ?></td>
                            <?php } ?>        	
                                </tr>        
                            </table>         
                        </td>
                    </tr>      
                    <tr>
                        <td>
                            <table border="0" width="100%" cellspacing="1" cellpadding="2" class="">
                          <tr class="">
                            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                <?php
                $radio_buttons = 0;
                  $addresses_query = tep_db_query("select address_book_id, entry_firstname as firstname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_suburb as suburb, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "'  order by firstname, lastname");
                  /*while ($addresses = tep_db_fetch_array($addresses_query)) {
                    $format_id = tep_get_address_format_id($addresses['country_id']);
                
                              if ($addresses['address_book_id'] == $sendto) {

          echo '                  <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";

        } else {

          echo '                  <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";

        } ?>
                                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                                  <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">
                                    <td class="main"><b><?php echo tep_output_string_protected($addresses['firstname'] . ' ' . $addresses['lastname']); ?></b><?php if ($addresses['address_book_id'] == $customer_default_shipping_id) echo '&nbsp;<small><i>' . PRIMARY_ADDRESS . '</i></small>'; ?></td>
                                    <td class="main" align="right"><?php echo '<a href="#" onclick="setDefault(\''.$addresses['address_book_id'].'\')">' . tep_template_image_button('set_as_default.gif', 'set_as_default_button') . '</a> <a href="#" onclick="editEntry(\''.$addresses['address_book_id'].'\'); return false;">' . tep_template_image_button('small_edit.gif', SMALL_IMAGE_BUTTON_EDIT) . '</a> '; ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><table border="0" cellspacing="0" cellpadding="2">
                                      <tr>
                                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                        <td class="main"><?php echo tep_address_format($format_id, $addresses, true, ' ', '<br>'); ?></td>
                                        <td width="10"><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                </table></td>
                                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
                              </tr>
                <?php
                  }*/
    while ($addresses = tep_db_fetch_array($addresses_query)) {
        $format_id = tep_get_address_format_id($addresses['country_id']);

?>
              <tr>
                <td colspan="2">
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
       if ($addresses['address_book_id'] == $sendto) {
          echo '        <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
        } else {
          echo '        <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
        }

?>
                            <td width="100%">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="main" colspan="2"><b><?php echo tep_output_string_protected($addresses['firstname'] . ' ' . $addresses['lastname']); ?></b></td>            
                                        <td class="main" align="right"><?php echo tep_draw_radio_field('address', $addresses['address_book_id'], ($addresses['address_book_id'] == $sendto)); ?></td>
                                        <td align="right" nowrap><?php echo '&nbsp;&nbsp;<a class="btn btn-info" href="#" onclick="editEntry(\''.$addresses['address_book_id'].'\'); return false;">' .SMALL_IMAGE_BUTTON_EDIT . '</a>&nbsp;&nbsp;'; ?></td>
                                      
                                    </tr>
                                    <tr>
                                     
                                        <td colspan="3">
                                            <table border="0" cellspacing="0" cellpadding="2">
                                                <tr>
                                                  
                                                    <td class="main"><?php echo tep_address_format($format_id, $addresses, true, ' ', ', '); ?></td>
                                                  
                                                </tr>
                                            </table>
                                        </td>
                                        

                                    </tr>
                                </table>
                            </td>
                    </tr>

                </table>
                </td>
              </tr>

<?php

        $radio_buttons++;

      }
                ?>
                            </table></td>
                          </tr>
                          <tr>
                              <td>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                        <tr>
                                            <td class="main"><b>Continue Checkout Procedure</b><br>to select the preferred shipping method.</td>
                                            <td align="right" class="main"><a href="#" onclick="setDefault(); return false;"><?php echo tep_template_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></a></td>
                                        </tr>
                                  </table>
                              </td>
                          </tr>
                        </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="address_fields">
                <table  width="100%" cellspacing="0" cellpading="0" id="address_details">
                 
                    <tr><td id="showError"></td></tr>
                 
                    <tr>
                        <td><?php include(DIR_WS_MODULES . 'address_book_details.php'); ?></td>
                    </tr>
                 
                    
                    <tr>
                        <td>
                            <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
                                <tr class="infoBoxContents">
                                  <td>
                                      <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                          <tr>
                                              <td align="left"><a href="#" onclick="addNewEntry(); return false;"><?php echo tep_template_image_button('button_back.gif', IMAGE_BUTTON_CONTINUE); ?></a></td>
                                              <td align="right"><a href="#" onclick="processData(); return false;"><?php echo tep_template_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></a></td>
                                          </tr>
                                      </table>
                                  </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="shippingDetails">
                <form method="post" action="<?php echo tep_href_link('checkout_confirmation.php','','SSL');?>" name="confirmation">
                <?php
                foreach($_POST as $key => $val){
                    if($key == 'shipping'){
                        continue;
                    }
                    echo tep_draw_hidden_field($key,$val);
                }
                ?>
                    
                    <table width="100%" cellspacing="0" cellpading="0" >
                        <tr>
                            <td class="main"><b>As per new address following shipping options are available please select one</b></td>
                        </tr>
                        <tr>
                            <td><div id="shippingMethod" style="width:100%"><div style="margin: auto; width: 37%;"><img src="images/loader1.gif"></div></div></td>
                        </tr>
                        <tr>
                            <td>
                                <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
                                    <tr class="infoBoxContents">
                                      <td>
                                          <table border="0" width="100%" cellspacing="0" cellpadding="2">
                                              <tr>
                                                  <td align="left"><a href="#" onclick="backFromshippingMethod(); return false;"><?php echo tep_template_image_button('button_back.gif', IMAGE_BUTTON_CONTINUE); ?></a></td>
                                                  <td align="right"><?php echo tep_draw_hidden_field('action', 'process') . tep_template_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
                                              </tr>
                                          </table>
                                      </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

</div>