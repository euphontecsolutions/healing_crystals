   </table></tbody></table>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <style>
   .container {
    padding-left: 14px;
    padding-right:14px;
}
   html, body {
    max-width: 100%;
    overflow-x: hidden;
}
   @media screen and (max-width: 360px) {
  table {
    width: 50%;
  }
  .main-containertable {
    width: 50%;
  }
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
    border-top: 1px solid #ddd0;
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
    /*border-top: 1px solid #ddd;*/

}
TD.pageHeading, TD.nfpageHeading, TD.pageHeadingAllProds, TD.allpicHeading, TD.regularHeading {

    text-align: center;
    width: 50%;

}
}
   .main{
       width:auto;
   }
   .table .table {
    background-color: transparent;
    border-color: transparent;
}
.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    padding: 8px;
    line-height: 1.42857143;
    /*vertical-align: top;*/
   /* border: 0px solid transparent;*/
     background-color: transparent;
}
   hr.style-eight {
height: 10px;
border: 1;
box-shadow: inset 0 9px 9px -3px rgba(11, 99, 184, 0.8);
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
-ms-border-radius: 5px;
-o-border-radius: 5px;
border-radius: 5px;
}
      .grey-text{
          color:#9e9e9e !important;
      }
     /* .Contents{
          background-color: #fff;
          
      }*/
      
     
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

        border-top: 1px solid #d2d2d2;
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
          border-bottom: 1px solid #e0e0e0;
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
      .table-responsive {
    width: 100%;
    margin-bottom: 15px;
    overflow-y: hidden;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    /*border: 1px solid #ddd0;*/
}
.Contents a, .Contents a:hover {
   text-decoration:none; !important
        font-weight:bold; !important
        cursor:default; !important
}
/*body{
	pointer-events: none;
}*/
button{
	pointer-events: all;
}

  </style>
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
            flex-basis: 30%;
          }
          .fexxer_input {
            flex-shrink: 1;
            flex-grow: 1;
            flex-basis: 70%;
          }
        </style>
  <div class="container" >
<?php
//* 2-MAY-2012, (MA) add ability for customers to easily reorder , #557 Bof
function tep_get_qty_based_actual_price($pid, $optid, $ovid, $qty){
	global $currencies;
	$products_options = tep_db_query("select pa.products_attributes_name, products_attributes_units, only_linked_options, pa.options_values_price, pa.price_prefix, pa.products_attributes_special_price, pa.special_end_date, pa.special_start_date, pa.product_attribute_qty_1, pa.product_attribute_price_1, pa.product_attribute_qty_2, pa.product_attribute_price_2, pa.product_attribute_qty_3, pa.product_attribute_price_3, pa.product_attribute_qty_4, pa.product_attribute_price_4, pa.product_attribute_qty_5, pa.product_attribute_price_5, product_attribute_spe_price_1, product_attribute_spe_price_2, product_attribute_spe_price_3, product_attribute_spe_price_4, product_attribute_spe_price_5, items_per_unit, selling_unit_type from " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $pid . "' and pa.options_id = '" . $optid . "' and pa.options_values_id = '".$ovid."' and pa.product_attributes_status = '1' and pa.options_values_price IS NOT NULL ");
	$products_options_values = tep_db_fetch_array($products_options);
	
	if(($products_options_values['special_end_date'] > date('Y-m-d H:i:s') ||($products_options_values['special_end_date']=='0000-00-00 00:00:00')) && $products_options_values['special_start_date'] < date('Y-m-d H:i:s') && $products_options_values['special_start_date']!='0000-00-00 00:00:00'){
		$special_price = $products_options_values['products_attributes_special_price'];
	}else{
		$special_price = 0;
		for($qbp = 1; $qbp <= 5; $qbp++){
			$products_options_values['product_attribute_spe_price_' . $qbp] = 0;
		}
	}
	
	$price = tep_get_price_special($pid, $products_options_values['options_values_price'], $special_price);
	
	if (tep_get_price_special($pid, $products_options_values['options_values_price'], $special_price) == 0){
		$price_default = $products_options_values['options_values_price'];
			
	}else{
		$special_saving = number_format(((($products_options_values['options_values_price']-$products_options_values['products_attributes_special_price'])/$products_options_values['options_values_price'])*100),0);
		$price_default = tep_get_price_special($pid, $products_options_values['options_values_price'], $special_price);		
	}	
	$price_tip = '';
	$l_limit = 1;
	$maxQtyBr = 1;
	$qtyBrArray = array();
	$pricelimit = array();
	
	for($x=1;$x<5;$x++){
        if(tep_not_null($products_options_values['product_attribute_price_'.$x]) && $products_options_values['product_attribute_price_'.$x] > 0 && $products_options_values['product_attribute_price_'.($x+1)] > 0 )
		$qtyBrArray[] = $products_options_values['product_attribute_qty_'.$x];
    }
    for($x=1;$x<=5;$x++){			
		if(!tep_not_null($products_options_values['product_attribute_price_'.$x])) $products_options_values['product_attribute_price_'.$x] = 0.0;
		if(!tep_not_null($products_options_values['product_attribute_spe_price_'.$x])) $products_options_values['product_attribute_spe_price_'.$x] = 0.0;
		if(!tep_not_null($products_options_values['product_attribute_qty_'.$x])) $products_options_values['product_attribute_qty_'.$x] = 0;			
	}
		
	$optionarray = array($products_options_values['product_attribute_qty_1'],$products_options_values['product_attribute_qty_2'],$products_options_values['product_attribute_qty_3'],$products_options_values['product_attribute_qty_4'],$products_options_values['product_attribute_qty_5'],$currencies->format($price_default),($price_default==''?'0.0000':$price_default));
	$optionpricearray = array($products_options_values['product_attribute_price_1'],$currencies->format($products_options_values['product_attribute_price_1']),$products_options_values['product_attribute_spe_price_1'],$currencies->format($products_options_values['product_attribute_spe_price_1']),$products_options_values['product_attribute_price_2'],$currencies->format($products_options_values['product_attribute_price_2']),$products_options_values['product_attribute_spe_price_2'],$currencies->format($products_options_values['product_attribute_spe_price_2']),$products_options_values['product_attribute_price_3'],$currencies->format($products_options_values['product_attribute_price_3']),$products_options_values['product_attribute_spe_price_3'],$currencies->format($products_options_values['product_attribute_spe_price_3']),$products_options_values['product_attribute_price_4'],$currencies->format($products_options_values['product_attribute_price_4']),$products_options_values['product_attribute_spe_price_4'],$currencies->format($products_options_values['product_attribute_spe_price_4']),$products_options_values['product_attribute_price_5'],$currencies->format($products_options_values['product_attribute_price_5']),$products_options_values['product_attribute_spe_price_5'],$currencies->format($products_options_values['product_attribute_spe_price_5']));
			$activePrice = 0;
			$selectedLi = 1;
			if($optionpricearray[$pid][$optid][$ovid][0] != 0.00)	{
				if($optionpricearray[2] != 0.00){
					$price = $optionpricearray[3];
					$activePrice = $optionpricearray[2];
				}else{
					$price = $optionpricearray[1];
					$activePrice = $optionpricearray[0];
				}
				$selectedLi = 1;
			}
			if($optionpricearray[4] != 0.00 && $qty > $optionarray[0])	{
				if($optionpricearray[6] != 0.00){
					$price = $optionpricearray[7];
					$activePrice = $optionpricearray[6];
				}else{
					$price = $optionpricearray[5];
					$activePrice = $optionpricearray[4];
				}
				$selectedLi = 2;
			}
			if($optionpricearray[8] != 0.00 && $qty > $optionarray[1] )	{
				if($optionpricearray[10] != 0.00){
					$price = $optionpricearray[11];
					$activePrice = $optionpricearray[10];
				}else{
					$price = $optionpricearray[9];
					$activePrice = $optionpricearray[8];
				}
				$selectedLi = 3;
			}
			if($optionpricearray[12] != 0.00 && $qty > $optionarray[2] )	{
				if($optionpricearray[14] != 0.00){
					$price = $optionpricearray[15];
					$activePrice = $optionpricearray[14];
				}else{
					$price = $optionpricearray[13];
					$activePrice = $optionpricearray[12];
				}
				$selectedLi = 4;
			}
			if($optionpricearray[16] != 0.00 && $qty > $optionarray[3] )	{
				if($optionpricearray[18] != 0.00){
					$price = $optionpricearray[19];
					$activePrice = $optionpricearray[18];
				}else{
					$price = $optionpricearray[17];
					$activePrice = $optionpricearray[16];
				}
				$selectedLi = 5;				
			}
			if($price == ''){
				$price = $optionarray[5];
				$activePrice = $optionarray[6];
				$selectedLi = 1;				 
			}
		
	$price_final = '('.$price.' ea.) '. $currencies->currencies[$_SESSION['currency']]['symbol_left'] .number_format(($qty*$activePrice),2,'.','');
	$return_array = array($price,$price_final);
	return	$return_array;
}


function tep_get_qty_based_price($pid, $optid, $ovid){
	global $currencies;
	$products_options = tep_db_query("select pa.products_attributes_name, products_attributes_units, only_linked_options, pa.options_values_price, pa.price_prefix, pa.products_attributes_special_price, pa.special_end_date, pa.special_start_date, pa.product_attribute_qty_1, pa.product_attribute_price_1, pa.product_attribute_qty_2, pa.product_attribute_price_2, pa.product_attribute_qty_3, pa.product_attribute_price_3, pa.product_attribute_qty_4, pa.product_attribute_price_4, pa.product_attribute_qty_5, pa.product_attribute_price_5, product_attribute_spe_price_1, product_attribute_spe_price_2, product_attribute_spe_price_3, product_attribute_spe_price_4, product_attribute_spe_price_5, items_per_unit, selling_unit_type from " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $pid . "' and pa.options_id = '" . $optid . "' and pa.options_values_id = '".$ovid."' and pa.product_attributes_status = '1' and pa.options_values_price IS NOT NULL ");
	$products_options_values = tep_db_fetch_array($products_options);
	
	if(($products_options_values['special_end_date'] > date('Y-m-d H:i:s') ||($products_options_values['special_end_date']=='0000-00-00 00:00:00')) && $products_options_values['special_start_date'] < date('Y-m-d H:i:s') && $products_options_values['special_start_date']!='0000-00-00 00:00:00'){
		$special_price = $products_options_values['products_attributes_special_price'];
	}else{
		$special_price = 0;
		for($qbp = 1; $qbp <= 5; $qbp++){
			$products_options_values['product_attribute_spe_price_' . $qbp] = 0;
		}
	}
	
	$price = tep_get_price_special($pid, $products_options_values['options_values_price'], $special_price);
	
	if (tep_get_price_special($pid, $products_options_values['options_values_price'], $special_price) == 0){
		$price_default = $products_options_values['options_values_price'];
			
	}else{
		$special_saving = number_format(((($products_options_values['options_values_price']-$products_options_values['products_attributes_special_price'])/$products_options_values['options_values_price'])*100),0);
		$price_default = tep_get_price_special($pid, $products_options_values['options_values_price'], $special_price);
		
	}
	
	$price_tip = '';
	$l_limit = 1;
	$maxQtyBr = 1;
	$qtyBrArray = array();
	$pricelimit = array();
	
	for($x=1;$x<5;$x++){
        if(tep_not_null($products_options_values['product_attribute_price_'.$x]) && $products_options_values['product_attribute_price_'.$x] > 0 && $products_options_values['product_attribute_price_'.($x+1)] > 0 )
		$qtyBrArray[] = $products_options_values['product_attribute_qty_'.$x];
    }
    for($x=1;$x<=5;$x++){			
		if(!tep_not_null($products_options_values['product_attribute_price_'.$x])) $products_options_values['product_attribute_price_'.$x] = 0.0;
		if(!tep_not_null($products_options_values['product_attribute_spe_price_'.$x])) $products_options_values['product_attribute_spe_price_'.$x] = 0.0;
		if(!tep_not_null($products_options_values['product_attribute_qty_'.$x])) $products_options_values['product_attribute_qty_'.$x] = 0;			
	}
	$option_script .= 'optionarray['.$pid.']=' . 'new Array();'. "\n";
	$option_script .= 'optionarray['.$pid.']['.$optid.']=' . 'new Array();'. "\n";
	$option_price_script .= 'optionpricearray['.$pid.']=' . 'new Array();'. "\n";
	$option_price_script .= 'optionpricearray['.$pid.']['.$optid.']=' . 'new Array();'. "\n";
	$option_script .= 'optionarray['.$pid.']['.$optid.']['.$ovid.'] = ' . 'new Array(' . $products_options_values['product_attribute_qty_1'] . ',' . $products_options_values['product_attribute_qty_2'] . ',' . $products_options_values['product_attribute_qty_3'] . ',' . $products_options_values['product_attribute_qty_4'] . ',' . $products_options_values['product_attribute_qty_5'] . ',\'' . $currencies->format($price_default) . '\',' . ($price_default==''?'0.0000':$price_default) . ');';
	$option_price_script .= 'optionpricearray['.$pid.']['.$optid.']['.$ovid.'] = ' . 'new Array(' . $products_options_values['product_attribute_price_1'] . ',"' . $currencies->format($products_options_values['product_attribute_price_1']) . '",' . $products_options_values['product_attribute_spe_price_1'] . ',"' . $currencies->format($products_options_values['product_attribute_spe_price_1']) . '",' . $products_options_values['product_attribute_price_2'] . ',"' . $currencies->format($products_options_values['product_attribute_price_2']) . '",' . $products_options_values['product_attribute_spe_price_2'] . ',"' . $currencies->format($products_options_values['product_attribute_spe_price_2']) . '",' . $products_options_values['product_attribute_price_3'] . ',"' . $currencies->format($products_options_values['product_attribute_price_3']) . '",' . $products_options_values['product_attribute_spe_price_3'] . ',"' . $currencies->format($products_options_values['product_attribute_spe_price_3']) . '",' . $products_options_values['product_attribute_price_4'] . ',"' . $currencies->format($products_options_values['product_attribute_price_4']) . '",' . $products_options_values['product_attribute_spe_price_4'] . ',"' . $currencies->format($products_options_values['product_attribute_spe_price_4']) . '",' . $products_options_values['product_attribute_price_5'] . ',"' . $currencies->format($products_options_values['product_attribute_price_5']) . '",' . $products_options_values['product_attribute_spe_price_5'] . ',"' . $currencies->format($products_options_values['product_attribute_spe_price_5']) . '");';
	$return_value = "\n" .$option_script . "\n" .$option_price_script;
	return	$return_value;
}
//* 2-MAY-2012, (MA) add ability for customers to easily reorder , #557 Eof
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
<?php echo '<a href="/account_mobile.php?user_id='.$customer_id.'" class="btn btn-info" style="background-color: #4c6aafad !important; color: #001abc;float: left;">«  Back To Orders</a><br><br><br>';?>
      <div>
        <div><div class="table table-responsive table-condensed">
          
              
            <div class="pageHeading" style="border: none;"><?php echo HEADING_TITLE; ?></div>
           <!-- <div class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_history.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></div>
          -->
        </div></div>
      </div>
      <div>
        <!-- <div><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></div> -->
      </div>
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
      <div>
        <div><div class="col-md-12">
          <div>
            <div class="main" colspan="2"><b><?php echo sprintf(HEADING_ORDER_NUMBER, $HTTP_GET_VARS['order_id']) . ' <small>(' . $order->info['orders_status'] . ')</small>'; ?></b><?php

$coupon_query = tep_db_query("select coupon_id, coupon_code, coupon_amount, date_format(coupon_expire_date,'%m/%d/%y') as expires_on from coupons where created_from_orderid = '".$HTTP_GET_VARS['order_id']."' and coupon_type = 'G' order by date_created DESC limit 1");
    if(tep_db_num_rows($coupon_query))echo'<a href="'.  tep_href_link('voucherImage.php','oID='.$HTTP_GET_VARS['order_id']).'" target="_blank">View and Print your Gift Voucher </a>';

          ?></div>
          </div>
          <div>
            <div class="smallText"><?php echo HEADING_ORDER_DATE . ' ' . tep_date_long($order->info['date_purchased']); ?></div>
            <div class="smallText" ><?php echo HEADING_ORDER_TOTAL . ' ' . $order->info['total']; ?></div>
          </div>

		  
      <div>
        <div><div class="">
          <div class=" Contents">
<?php
  if ($order->delivery != false) {
?>


            <!-- <div width="30%" valign="top"> --><div class="panel panel-default">
            	<div class="panel-heading"><div class="main"><b><?php echo HEADING_DELIVERY_ADDRESS; ?></b></div></div>
              <div class="panel-body">
                <!-- <div class="main"><b><?php echo HEADING_DELIVERY_ADDRESS; ?></b></div> -->
              <!-- </div> -->
              <!-- <div> -->
                <div class="main"><?php echo tep_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br>'); ?></div>

              </div>
             <!--  <div class="panel-footer"></div> --></div>
              <div class="panel panel-default">
<?php
    if (tep_not_null($order->info['shipping_method'])) {
?>
            <div class="panel-heading">
                <div class="main"><b><?php echo HEADING_SHIPPING_METHOD; ?></b></div>
              </div>
              <div class="panel-body">
                <div class="main"><?php echo $order->info['shipping_method']; ?></div>
              </div>
             <!--  <div class="panel-footer"></div> -->
<?php
    }
?>
            </div><!-- </div> -->
<?php
  }
?></div>
<div class=""><!-- <div class="">
          <div class=" Contents"> -->
	
            <!-- <div width="<?php echo (($order->delivery != false) ? '70%' : '100%'); ?>" valign="top"> --><!-- <div border="0" width="100%" cellspacing="0" cellpadding="0"> -->
              <!-- <div> -->
              <div class="panel panel-default ">
              	<div class="panel-heading"><div class="main"><b><?php echo 'Product Info'; ?></b></div></div>
              <div class="panel panel-default" style="margin-bottom: 0px;">
              	<table border="1"  cellspacing="0" cellpadding="2" class="fexer_table table table-bordered" >
<?php
  if (sizeof($order->info['tax_groups']) > 1) {
?>
                 <!--  <tr class="fexer_tr">
                    <td class="main fexer_text" ><b><?php echo HEADING_PRODUCTS; ?></b></td> -->
					<?php //* 2-MAY-2012, (MA) add ability for customers to easily reorder , #557 Bof?>
					<!-- <td class="main fexer_text" align="center"><b><?php echo 'Quantity'; ?></b></td>
					<td class="main fexer_text" align="center"><b><?php echo 'Unit Price'; ?></b></td> -->
					<?php //* 2-MAY-2012, (MA) add ability for customers to easily reorder , #557 Bof?>
                   <!--  <td class="smallText fexer_text" align="center"><b><?php echo HEADING_TAX; ?></b></td>
                    <td class="smallText fexer_text" align="center"><b><?php echo HEADING_TOTAL; ?></b></td>
                  </tr> -->
<?php
  } else {
?>
                  <!-- <tr class="fexer_tr"> -->
                    <?php //* 2-MAY-2012, (MA) add ability for customers to easily reorder , #557 Bof?>
                  <!--   <td class="main fexer_text"  align="center"><b><?php echo HEADING_PRODUCTS; ?></b></td>
					<td class="main fexer_text" align="center"><b><?php echo 'Quantity'; ?></b></td>
					<td class="main fexer_text" align="center"><b><?php echo 'Unit Price'; ?></b></td>
					<td class="main fexer_text" align="center"><b><?php echo HEADING_TOTAL; ?></b></td> -->                  	
					<?php //* 2-MAY-2012, (MA) add ability for customers to easily reorder , #557 Eof?>
                <!--   </tr> -->
<?php
  }
//* 2-MAY-2012, (MA) add ability for customers to easily reorder , #557 Bof
  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
    echo '<tr class="fexer_tr">' . "\n" .
         '';
          if (sizeof($order->info['tax_groups']) > 1) {?>
 <td class="main fexer_text" width="30%"><b><?php echo HEADING_PRODUCTS; ?></b></td>
  <?php } else {?>
<td class="main fexer_text" width="30%"><b><?php echo HEADING_PRODUCTS; ?></b></td> <?php
 }
         echo '<td class="main fexxer_input" width="70%">' . $order->products[$i]['name'] ;
    if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
        echo '</br><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . '</i></small>';
      //start of add to cart 
	   //end of add to cart
//* 2-MAY-2012, (MA) add ability for customers to easily reorder , #557 Eof
      }
    }

    echo '</td></tr>';

	echo '<tr class="fexer_tr" >';
   if (sizeof($order->info['tax_groups']) > 1) { ?>
 <td class="main fexer_text" width="30%"><b><?php echo 'Quantity'; ?></b></td>
  <?php } else { ?>
<td class="main fexer_text" width="30%"><b><?php echo 'Quantity'; ?></b></td>
<?php }
  echo '<td class="main fexxer_input" width="70%">' . $order->products[$i]['qty'] . '</td></tr>';
    echo '<tr class="fexer_tr">';
   if (sizeof($order->info['tax_groups']) > 1) { ?>
 <td class="main fexer_text" width="30%"><b><?php echo 'Unit Price'; ?></b></td>
  <?php } else { ?>
<td class="main fexer_text" width="30%"><b><?php echo 'Unit Price'; ?></b></td>
<?php }
  echo '<td class="main fexxer_input" width="70%">' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) . '</td></tr>' ;
      echo '<tr class="fexer_tr">';
    if (sizeof($order->info['tax_groups']) > 1) {?>
       <td class="smallText fexxer_inputt" width="30%"><b><?php echo HEADING_TAX; ?></b></td><?php
      echo '<td class="main fexxer_input" width="70%">' . tep_display_tax_value($order->products[$i]['tax']) . '%</td></tr>' . "\n";
    }
     echo '<tr class="fexer_tr" style="border-bottom-color: black; border-bottom-style: solid;">';
   if (sizeof($order->info['tax_groups']) > 1) { ?>
  <td class="smallText fexer_text" width="30%"><b><?php echo HEADING_TOTAL; ?></b></td>
  <?php } else { ?>
<td class="main fexer_text" width="30%"><b><?php echo HEADING_TOTAL; ?></b></td>
<?php }
    echo '<td class="main fexxer_input" width="70%">' . $currencies->format(tep_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</td></tr>' .
         '          </tr>' . "\n";
        // echo '<td></td>';
  }
?>
                </table></div></div>
            <!--   </div> -->
           <!--  </div> --><!-- </div> -->
        <!--   </div>
      </div> --></div>
        </div></div>
      </div>
   <div class="panel panel-default">
     <div class="panel-heading">
        <div class="main"><b><?php echo HEADING_BILLING_INFORMATION; ?></b></div>
      </div>
        <div class="panel-body ">
          <div class="Contents">
            <!-- <div width="30%" valign="top"> -->
            <!-- 	<div class="table table-responsive table-condensed"> -->
            		<div class="panel panel-default">
               <div class="panel-heading">
                <div class="main"><b><?php echo HEADING_BILLING_ADDRESS; ?></b></div>
              </div>
             <div class="panel-body">
                <div class="main"><?php echo tep_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br>'); ?></div>
              </div>
          </div>
          <div class="panel panel-default">
             <div class="panel-heading">
                <div class="main"><b><?php echo HEADING_PAYMENT_METHOD; ?></b></div>
              </div>
             <div class="panel-body">
                <div class="main">
				<?php 
   $method = $order->info['payment_info'];
				
				echo $method; ?></div>
              </div>
          </div>
           <!--  </div> --><!-- </div> -->

            <div class="panel panel-default">
            	  <div class="panel-heading">
        <div class="main"><b><?php echo "Sub-Total"; ?></b></div>
      </div><div class="panel-body">
      	<table class="table table-responsive" style="text-align: right;">
      	 <?php
  for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
    echo '<tr>' . "\n" .
         '<td class="main">' . $order->totals[$i]['title'] . '</div>' . "\n" .
         '<td class="main">' . $order->totals[$i]['text'] . '</div>' . "\n" .
         '</tr>' . "\n";
  }
?></table>
            </div></div>
          </div>
        </div>
   </div>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="main"><b><?php echo HEADING_ORDER_HISTORY; ?></b></div>
      </div>
     <div class="panel-body">

        <div class="table table-responsive table-condensed ">
          <div class="Contents">
            <div valign="top"><div class="table table-responsive table-condensed">
<?php
  $statuses_query = tep_db_query("select os.orders_status_name, osh.date_added, osh.comments from " . TABLE_ORDERS_STATUS . " os, " . TABLE_ORDERS_STATUS_HISTORY . " osh where osh.orders_id = '" . (int)$HTTP_GET_VARS['order_id'] . "' and osh.orders_status_id = os.orders_status_id and os.language_id = '" . (int)$languages_id . "' and osh.customer_notified = '1' order by osh.date_added");
  while ($statuses = tep_db_fetch_array($statuses_query)) {
    echo '              <div>' . "\n" .
         '                <div class="main" valign="top" width="70">' . date('F d Y h:i:s', strtotime($statuses['date_added'])) . '</div>' . "\n" .
         '                <div class="main" valign="top" width="170">' . $statuses['orders_status_name'] . '</div>' . "\n" .
         '                <div class="main" valign="top">' . (empty($statuses['comments']) ? '&nbsp;' : nl2br($statuses['comments'])) . '</div>' . "\n" .
         '              </div>' . "\n";
  }
?>
            </div></div>
          </div>
        </div></div></div>
    
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
<?php
  if (DOWNLOAD_ENABLED == 'true') include(DIR_WS_MODULES . 'downloads.php');
?>
      <div>
        <!-- <div><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></div> -->
      </div>
   
    </div>
<?php //* 2-MAY-2012, (MA) add ability for customers to easily reorder , #557 Bof?>
<script type="text/javascript">
function get_attr_price(pid,ovid,optid,qty){

	var opt_val_id = '';
	var price = '';
	var optionarray = new Array();
	var optionpricearray = new Array();
	//var optionarray[pid][optid][ovid] = new Array();
	//var optionpricearray[pid + '-' + optid + '-' + ovid] = new Array();
	<?php echo $qtyarray; ?>
	//try{
//alert(attr_count);
		var price_id = 'pricetop-'+pid+'{'+optid+'}'+ovid ;
		if(ovid > 0){	
			opt_val_id = pid+optid+ovid ;
			//alert(optionarray[pid][optid][ovid]);
			var activePrice = 0;
			var selectedLi = 1;
			//alert(optionpricearray[pid][optid][ovid]);
			if(optionpricearray[pid][optid][ovid][0] != 0.00)	{
				if(optionpricearray[pid][optid][ovid][2] != 0.00){
					price = optionpricearray[pid][optid][ovid][3];
					activePrice = optionpricearray[pid][optid][ovid][2];
				}else{
					price = optionpricearray[pid][optid][ovid][1];
					activePrice = optionpricearray[pid][optid][ovid][0];
				}
				selectedLi = 1;
			}
			if(optionpricearray[pid][optid][ovid][4] != 0.00 && qty > optionarray[pid][optid][ovid][0])	{
				if(optionpricearray[pid][optid][ovid][6] != 0.00){
					price = optionpricearray[pid][optid][ovid][7];
					activePrice = optionpricearray[pid][optid][ovid][6];
				}else{
					price = optionpricearray[pid][optid][ovid][5];
					activePrice = optionpricearray[pid][optid][ovid][4];
				}
				selectedLi = 2;
			}
			if(optionpricearray[pid][optid][ovid][8] != 0.00 && qty > optionarray[pid][optid][ovid][1] )	{
				if(optionpricearray[pid][optid][ovid][10] != 0.00){
					price = optionpricearray[pid][optid][ovid][11];
					activePrice = optionpricearray[pid][optid][ovid][10];
				}else{
					price = optionpricearray[pid][optid][ovid][9];
					activePrice = optionpricearray[pid][optid][ovid][8];
				}
				selectedLi = 3;
			}
			if(optionpricearray[pid][optid][ovid][12] != 0.00 && qty > optionarray[pid][optid][ovid][2] )	{
				if(optionpricearray[pid][optid][ovid][14] != 0.00){
					price = optionpricearray[pid][optid][ovid][15];
					activePrice = optionpricearray[pid][optid][ovid][14];
				}else{
					price = optionpricearray[pid][optid][ovid][13];
					activePrice = optionpricearray[pid][optid][ovid][12];
				}
				selectedLi = 4;
			}
			if(optionpricearray[pid][optid][ovid][16] != 0.00 && qty > optionarray[pid][optid][ovid][3] )	{
				if(optionpricearray[pid][optid][ovid][18] != 0.00){
					price = optionpricearray[pid][optid][ovid][19];
					activePrice = optionpricearray[pid][optid][ovid][18];
				}else{
					price = optionpricearray[pid][optid][ovid][17];
					activePrice = optionpricearray[pid][optid][ovid][16];
				}
				selectedLi = 5;				
			}
			if(price == ''){
				price = optionarray[pid][optid][ovid][5];
				activePrice = optionarray[pid][optid][ovid][6];
				selectedLi = 1;				 
			}	
			/*for(i=1; i <= 5; i++){
				if(document.getElementById("li["+opt_val_id+"]["+i+"]"))
					document.getElementById("li["+opt_val_id+"]["+i+"]").style.fontWeight = 'normal';
			}*/
			//document.getElementById("li["+opt_val_id+"]["+selectedLi+"]").style.fontWeight = 'bold';
			price = '(' + price +' ea.) ' + '<?php echo $currencies->currencies[$_SESSION['currency']]['symbol_left']; ?>' + (parseFloat(qty*activePrice)).toFixed(2);
			document.getElementById(price_id).innerHTML = price;
		}else{
		document.getElementById(price_id).innerHTML = '';
		}
	/*}
	catch(e){
	}*/
}
</script>
<?php //* 2-MAY-2012, (MA) add ability for customers to easily reorder , #557 Eof?>