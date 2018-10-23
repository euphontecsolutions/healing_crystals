<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style>
@media screen and (max-width: 359px) {

  table#cart thead { display: none; }
  table#cart tbody td { display: block; padding: 6px; min-width:110px;}
  table#cart tbody tr td:first-child { background: #f8f8f9; color: #777; }
  table#cart tbody td:before {
    content: attr(data-th); font-weight: bold;
    display: inline-block; width: 8rem;
  }
  
  .cart_refresh{
    width: 25%;
  font-size: 52%;
    padding: 3% 0% 3% 0%;
    margin: 0% 0% 0% 0%;

}
   .cart_remove{
    width:25%;
  }
   .cart_move{
    width:25%;
  }
  .cart_quantity{
    width:25%;
  }
  
  table#cart tfoot td{display:block; }
  table#cart tfoot td .btn{display:block;}
  
}
.lds-roller {
  display: none;
  position: fixed;
  width: 70px;
  height: 70px;
  left: 50%;
  top: 50%; 
  margin-left: -35px;
  margin-top: -35px;
  z-index: 88888;
}
.lds-roller div {
  animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  transform-origin: 32px 32px;
}
.lds-roller div:after {
  content: " ";
  display: block;
  position: absolute;
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #191212b3;
  margin: -3px 0 0 -3px;
}
.lds-roller div:nth-child(1) {
  animation-delay: -0.036s;
}
.lds-roller div:nth-child(1):after {
  top: 50px;
  left: 50px;
}
.lds-roller div:nth-child(2) {
  animation-delay: -0.072s;
}
.lds-roller div:nth-child(2):after {
  top: 54px;
  left: 45px;
}
.lds-roller div:nth-child(3) {
  animation-delay: -0.108s;
}
.lds-roller div:nth-child(3):after {
  top: 57px;
  left: 39px;
}
.lds-roller div:nth-child(4) {
  animation-delay: -0.144s;
}
.lds-roller div:nth-child(4):after {
  top: 58px;
  left: 32px;
}
.lds-roller div:nth-child(5) {
  animation-delay: -0.18s;
}
.lds-roller div:nth-child(5):after {
  top: 57px;
  left: 25px;
}
.lds-roller div:nth-child(6) {
  animation-delay: -0.216s;
}
.lds-roller div:nth-child(6):after {
  top: 54px;
  left: 19px;
}
.lds-roller div:nth-child(7) {
  animation-delay: -0.252s;
}
.lds-roller div:nth-child(7):after {
  top: 50px;
  left: 14px;
}
.lds-roller div:nth-child(8) {
  animation-delay: -0.288s;
}
.lds-roller div:nth-child(8):after {
  top: 45px;
  left: 10px;
}
@keyframes lds-roller {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
/*.spaceloader{
  height: 1px;
}*/
hr {

    margin-top: 6px;
    margin-bottom: 20px;
    border: 0;
        border-top-color: currentcolor;
        border-top-style: none;
        border-top-width: 0px;
    border-top: 1px solid #eee;

}
</style>
<script type="text/javascript">
$(document).ready(function() {
  $('.lds-roller').css('display','none');
});


</script>
<script type="text/javascript">
function deleteProduct(url){
    var result = confirm("Are you sure you want to delete this item?");
if (result) {
    window.location =url;
}
}
function orderLabels(elm, uprid){
   if(elm.checked){
        var url = 'shopping_cart_mobile.php?action=add_label&pid='+uprid;    
   }else{
       var url = 'shopping_cart_mobile.php?action=remove_label&pid='+uprid;  
   }
   location.href= url;
}
function hideImages(){

	var col = document.getElementById('table1').getElementsByTagName("img");
	for(var i=0; i<col.length; i++){
		if( col[i].src.indexOf('pixel_trans') == '-1' && col[i].src.indexOf('button_save_later.gif') == '-1' && col[i].src.indexOf('button_remove.gif') == '-1'){
			if(col[i].style.display != 'none'){
				col[i].style.display = 'none';
			}else{
				col[i].style.display = 'block';
			}
		}
	}
}
function display_wish_link(){
	var check_val = document.getElementById('share_list').value;
	if(check_val == 'on'){
		document.getElementById('share_wishlist_link').style.display = 'inline';
		document.getElementById('share_list').value = 'off';
	}else{
		document.getElementById('share_wishlist_link').style.display = 'none';
		document.getElementById('share_list').value = 'on';
	}

}
    <?php if(tep_session_is_registered('is_retail_store') || tep_session_is_registered('retail_rep')){ ?> 
    function quick_display_result(modeloption){
      //  alert(modeloption);
        if(modeloption.indexOf("-") >= 0){
            var modelOptionArray = modeloption.split("-");
            var url = 'shopping_cart.php?quick_search=true&model='+modelOptionArray[0]+'&option='+modelOptionArray[1];
           // alert(url);
              $.ajax({
                url: url, 
                success: function(data){
               // alert(data);
                if(data == 'success'){
                   document.location.reload(true);
              } else if(data != ''){
           var htm = data;
           $('#displayQuickResult').html(htm);
         }
      }, 
      error: function(request, err_msg, exc){
      alert(err_msg);
     }
    });
     }else if(modeloption != ''){
       alert('please enter correct format (model-option)');
     }
  }
  
  /*$('form[name="cart_quantity"]').submit(function(e){alert();
	e.preventDefault();
	quick_display_result($('input[name="model_option"]').val());
  });*/
    <? }?>
</script>
<style>
    
    .table>tbody>tr>td, .table>tfoot>tr>td{
    vertical-align: middle;
}
@media screen and (max-width: 600px) {
    table#cart tbody td .form-control{
		width:20%;
		display: inline !important;
	}
	.actions .btn{
		width:36%;
		margin:1.5em 0;
	}
	
	.actions .btn-info{
		float:left;
	}
	.actions .btn-danger{
		float:right;
	}
	
	table#cart thead { display: none; }
	table#cart tbody td { display: block; padding: 6px; min-width:110px;}
	table#cart tbody tr td:first-child { background: #f8f8f9; color: #777; }
	table#cart tbody td:before {
		content: attr(data-th); font-weight: bold;
		display: inline-block; width: 8rem;
	}
	
	
	
	table#cart tfoot td{display:block; }
	table#cart tfoot td .btn{display:block;}
	
}

</style>
<!------ Include the above in your HEAD tag ---------->

<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>



<div class="container">
    <div><b><?php echo HEADING_TITLE; ?></b></div>
<?php
   /* var_dump($cart->get_products());
    die(); */
?>
      <?php if (!tep_session_is_registered('customer_id')) {
      }else{
        echo tep_draw_form('cart_quantity', tep_href_link('shopping_cart_mobile.php', 'action=update_product', 'SSL')); echo tep_draw_hidden_field('empty_cart', ''); 
    $info_box_contents = array();
  
    $any_out_of_stock = 0;
    $products = $cart->get_products();
    if(empty($products)) {
        ?>
        <table border="0" width="100%" cellspacing="0" cellpadding="0" style="background-color: grey;color: white;margin-top: 5%;">

          <tr>
 
            <td class="pageHeading" style="color: white;">No items in cart</td>

            <td class="pageHeading" align="right" ></td>

          </tr>

        </table>
        <?php
    }
    else {
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
        
// Push all attributes information in an array
      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        while (list($option, $value) = each($products[$i]['attributes'])) {
          echo tep_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
          $attributes = tep_db_query("select popt.products_options_name, poval.products_options_values_name, pa.products_attributes_name, pa.options_values_price, pa.price_prefix, pa.products_attributes_special_price, pa.special_end_date, pa.special_start_date 
                                      from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
                                      where pa.products_id = '" . $products[$i]['id'] . "'
                                       and pa.options_id = '" . $option . "'
                                       and pa.options_id = popt.products_options_id
                                       and pa.options_values_id = '" . $value . "'
                                       and pa.options_values_id = poval.products_options_values_id
                                       and popt.language_id = '" . $languages_id . "'
                                       and poval.language_id = '" . $languages_id . "'");
          $attributes_values = tep_db_fetch_array($attributes);

          $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
          $products[$i][$option]['options_values_id'] = $value;
          $products[$i][$option]['products_attributes_name'] = stripslashes($attributes_values['products_attributes_name']);
//          $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
          $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
          if (($attributes_values['special_end_date'] > date('Y-m-d h:i:s') || ($attributes_values['special_end_date'] == '0000-00-00 00:00:00')) && $attributes_values['special_start_date'] < date('Y-m-d h:i:s') && $products_options_values['special_start_date']!='0000-00-00 00:00:00') {
          $products[$i]['special_price'] = $attributes_values['products_attributes_special_price'];
		  }else{
		  $products[$i]['special_price'] ='';
		  }
          $products[$i]['regular_price'] = $products[$i][$option]['options_values_price'];
          $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
        }
      }
    }

    for ($i=0, $n=sizeof($products); $i<$n; $i++) {$products_name='';$any_out_of_stock=0;
      if (($i/2) == floor($i/2)) {
        $info_box_contents[] = array('params' => 'class="productListing-even"');
      } else {
        $info_box_contents[] = array('params' => 'class="productListing-odd"');
      }

      $cur_row = sizeof($info_box_contents) - 1;
      $product_name = '<div class="row">' .
                       '    <div class="" style="width: 100%;"><center>'.($products[$i]['image']!=''?'<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']) . '">' . tep_image(DIR_WS_IMAGES . $products[$i]['image'], $products[$i]['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a>':'&nbsp;').'</center></div><br>' .
                       '    <div class="col-md-8"><center><a href="#"><b>' . stripslashes($products[$i]['name']) . '</b></a></center></div>';

      if (STOCK_CHECK == 'true') {
        $stock_check = tep_check_stock($products[$i]['id'], (isset($_SESSION['oos_prods_qty'][$products[$i]['id']]) ? $_SESSION['oos_prods_qty'][$products[$i]['id']] : $products[$i]['quantity']));
        if (tep_not_null($stock_check)) {
          $any_out_of_stock = 1;
         /* $product_name .=  tep_draw_separator('pixel_trans.gif', '5', '3').$stock_check;*/
        }
      }
      if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
        reset($products[$i]['attributes']);
        while (list($option, $value) = each($products[$i]['attributes'])) {
          $products_name .=  stripslashes($products[$i][$option]['products_options_name']). ' ' . stripslashes($products[$i][$option]['products_attributes_name']) . '<br>';
          //Price when added to cart
$price_added =0;
$product_cart_id    = $products[$i]['id'];
$cart_query = tep_db_query("SELECT * FROM `customers_basket` WHERE products_id='".$product_cart_id."'");
       $cart_array = tep_db_fetch_array($cart_query);
       $price_added = $cart_array['app_added_price'];
              if($products[$i]['final_price']!=$price_added && $price_added!='') {           
                 /* $products_name .='<span style="color:#555; font:small-caption;font-style: italic;">Note:Price at the time of checkout was $'.$price_added.'<span>';*/
          }
        }
      }
     
      $unit_special_price = '';


      if ($products[$i]['special_price'] > 0 && $products[$i]['regular_price'] == $products[$i]['quantity_dis_price'] && $products[$i]['special_price'] == $products[$i]['final_price']) {
	  	$unit_special_price = '<s><font color="#800080">' . $currencies->display_price($products[$i]['quantity_dis_price'], tep_get_tax_rate($products[$i]['tax_class_id'])) . '</s></font> ';
	  }elseif ($products[$i]['regular_price'] != $products[$i]['quantity_dis_price']) {
	  	$unit_special_price = '<s><font color="#800080">' . $currencies->display_price($products[$i]['quantity_dis_price'], tep_get_tax_rate($products[$i]['tax_class_id'])) . '</s></font> ';
	  }
if (STOCK_CHECK == 'true') {
        $stock_check = tep_check_stock($products[$i]['id'], (isset($_SESSION['oos_prods_qty'][$products[$i]['id']]) ? $_SESSION['oos_prods_qty'][$products[$i]['id']] : $products[$i]['quantity']));
        if (tep_not_null($stock_check)) {
          $any_out_of_stock = 1;

          $products_name .=  tep_draw_separator('pixel_trans.gif', '5', '3').$stock_check;
        }
      }
                                              
                                              $unit_special_price . '<b  style="width: 31%;
    float: left;
    margin-left: 12px;">' . $currencies->display_price($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id'])) . '</b>';
                                              '<div class="col-md-12"><div><div style="width: 8%; float: left;">'.tep_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="1" maxlength="4" style="width: 60%;"') . tep_draw_hidden_field('products_id[]', $products[$i]['id']).'</div><div  align="left">'. tep_template_image_submit('button_update_cart.gif', IMAGE_BUTTON_UPDATE_CART, 'onClick="document.forms[\'cart_quantity\'].submit();" ').'</div></div><div><div  align="left"><a href="'.$_SERVER['PHP_SELF'] . '?action=add_to_wishlist&products_id='.$products[$i]['id'].'&qty='.$products[$i]['quantity'].'" >'.tep_template_image_button('button_save_later.gif', IMAGE_BUTTON_SAVE_LATER).'</a></div></div><div><div align="left" ><a href="'.$_SERVER['PHP_SELF'] . '?action=remove_product&products_id='.$products[$i]['id'].'" >'.tep_template_image_button('button_remove.gif', IMAGE_BUTTON_REMOVE).'</a></div></div></div><hr class="style-eight" />';
                                             
?>
	<table id="cart" class="table table-condensed" >
    				<thead>
						<tr>
							<th style="width:50%">Product</th>
							<th style="width:10%">Price</th>
							<th style="width:8%">Quantity</th>
							<th style="width:22%" class="text-center">Subtotal</th>
							<th style="width:10%"></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="row">
									<div class="col-sm-2 " style=""><center><?php echo tep_image(DIR_WS_IMAGES . $products[$i]['image'], $products[$i]['name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);?></center></div>
									<div class="col-sm-10">
										<h4 class="nomargin"><?php echo stripslashes($products[$i]['name'])?></h4>
										<p style="color:#777;font-size: 12px;"><?php echo $products_name;?></p>
									</div>
								</div>
							</td>
							<?php 
							 $unit_special_price = '';


      if ($products[$i]['special_price'] > 0 && $products[$i]['regular_price'] == $products[$i]['quantity_dis_price'] && $products[$i]['special_price'] == $products[$i]['final_price']) {
	  	$unit_special_price = '<s><font color="#800080">' . $currencies->display_price($products[$i]['quantity_dis_price'], tep_get_tax_rate($products[$i]['tax_class_id'])) . '</s></font> ';
	  }elseif ($products[$i]['regular_price'] != $products[$i]['quantity_dis_price']) {
	  	$unit_special_price = '<s><font color="#800080">' . $currencies->display_price($products[$i]['quantity_dis_price'], tep_get_tax_rate($products[$i]['tax_class_id'])) . '</s></font> ';
	  }
	  ?>
							<td data-th="Price" style="background: white;">
							    <?php echo $unit_special_price . '<b>' . $currencies->display_price($products[$i]['final_price'], tep_get_tax_rate($products[$i]['tax_class_id'])) . '</b>';?></td>
							<td data-th="Quantity" style="background: white;">
							    <input type="number" name="cart_quantity[]" value="<?php echo $products[$i]['quantity'];?>" size="1" maxlength="4" style="width: 8%;">
								<?php echo tep_draw_hidden_field('products_id[]', $products[$i]['id']);?>
							
								<button class="btn btn-info btn-sm" onclick="document.forms['cart_quantity'].submit();" ><i class="fa fa-refresh"></i></button>
								
								<a class="btn btn-primary btn-sm cart_refresh" href="<?php echo $_SERVER['PHP_SELF'] . '?action=add_to_wishlist&products_id='.$products[$i]['id'].'&qty='.$products[$i]['quantity'];?>" alt="Remove from Shopping Cart and Add to Wish List" title=" Remove from Shopping Cart and Add to Wish List " >
								  <!--   <input type="button"  border="0" style="background-color:#777; width: 31%;

font-size: 9px;"  value=""/> -->
							Move to Wishlist</a>
							<!--<a href="<?php echo $_SERVER['PHP_SELF'] . '?action=remove_product&products_id='.$products[$i]['id'].'&qty='.$products[$i]['quantity'];?>" >-->
								 <input type="button" onclick="deleteProduct('<?php echo $_SERVER['PHP_SELF'] . '?action=remove_product&products_id='.$products[$i]['id'].'&qty='.$products[$i]['quantity'];?>')" class="btn btn-danger btn-sm " style="background-color:#777;" value="X"/>
								 <!--</a>-->
							</td>
							
						</tr>
					</tbody>
<?php 
 if ($any_out_of_stock == 1) {
      if (STOCK_ALLOW_CHECKOUT == 'false') {
     echo '<div><div  align="center"><div class="col-md-12"><div><div class="stockWarning" align="center">'.OUT_OF_STOCK_CANT_CHECKOUT.'<br><br></div></div></div></div></div>';
      }
	}elseif($showAdjustmentMsg == '1'){
    	echo '<div><div  align="center"><div class="col-md-12"><div><div class="stockWarning" align="center">'.$adjustmentMsg.'<br><br></div></div></div></div></div>';
    }
?>
<?php } ?>
<td ><center><strong><?php echo SUB_TITLE_SUB_TOTAL.' '. $currencies->format($cart->show_total()); ?></strong></center></td>
<?php
if ($cc_id != '') {
       $amount_query = tep_db_query("select coupon_amount, coupon_type, coupon_code from coupons where coupon_id = '".$cc_id."' and coupon_type != 'G'");
       $amount_array = tep_db_fetch_array($amount_query);
       $cc_coupon_amount = $amount_array['coupon_code'];
       tep_session_register('cc_coupon_amount');
       if($amount_array['coupon_type'] == 'P'){
        $coupon_less_amount = ': -'.$currencies->format($amount_array['coupon_amount']/100*$cart->show_total());

       }elseif($amount_array['coupon_type'] == 'S'){
        $coupon_less_amount = '';

       }elseif($amount_array['coupon_type'] == 'C'){
        $coupon_less_amount = ': -'.$currencies->format($amount_array['coupon_amount']/100*$cart->show_total());

       }else{
       $coupon_less_amount = ': -'.$currencies->format($amount_array['coupon_amount']);

       }
        ?>
      <td>
        <div class="main"><b>Discount Coupon: <?php echo $cc_coupon_amount.$coupon_less_amount; ?></b></div>
      </td>
    <?php }?>
    <?php
     if ($gv_code && $gv_coupon_amount != '') {
         $amount_query = tep_db_query("select coupon_amount, coupon_type from coupons where coupon_code = '".$gv_code."' and coupon_type = 'G'");
       $amount_array = tep_db_fetch_array($amount_query);

       if($amount_array['coupon_type'] == 'P'){
        if($amount_array['coupon_amount']/100*$cart->show_total() < $cart->show_total()){
       $amnt = $currencies->format($amount_array['coupon_amount']/100*$cart->show_total());
       }else{
       $amnt = $currencies->format($cart->show_total());
       }
        $gv_less_amount = ': -'.$amnt;

       }elseif($amount_array['coupon_type'] == 'S'){
        $gv_less_amount = '';

       }elseif($amount_array['coupon_type'] == 'C'){
        if($amount_array['coupon_amount']/100*$cart->show_total() < $cart->show_total()){
       $amnt = $currencies->format($amount_array['coupon_amount']/100*$cart->show_total());
       }else{
       $amnt = $currencies->format($cart->show_total());
       }
        $gv_less_amount = ': -'.$amnt;

       }else{
        if($amount_array['coupon_amount'] < $cart->show_total()){
       $amnt = $currencies->format($amount_array['coupon_amount']);
       }else{
       $amnt = $currencies->format($cart->show_total());
       }
       $gv_less_amount = ': -'.$amnt;

       }
       ?>
      <td class="row">
        <div  class="col-sm-10">Gift Voucher: <?php echo $gv_coupon_amount.$gv_less_amount; ?></div>
      </td>
    <?php } 
    if($gv_result['amount'] > 0){?>
    <td class="row">
        <div class="col-sm-10">Gift Voucher Balance available for this purchase: <?php echo $currencies->format($gv_result['amount']); ?></div>
      </td>
<?php
    } ?> 
<?php  if(tep_session_is_registered('customer_id')){ $user_id = $customer_id;}
 ?>
<td ><center><a class="btn btn-info btn-block" href="/my_wishlist_mobile.php?user_id=<?php echo $user_id; ?>&sc=1">View My Wishlist</a></center></td>

<?php
    if($customer_id){?>
    
  					<tbody>
    					<tr>
        					<td style="background:rgba(0,0,0,.0001);color:#000099;">
                              <div class="row">
                                  <div class="col-sm-10 " >
                                      <?php
                                        $gv_query=tep_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $customer_id . "'");
                                        $acc_gv_amount = 0;
                                       if ($gv_result = tep_db_fetch_array($gv_query)) $acc_gv_amount = $gv_result['amount'];
                                      ?>
                                   <b> Coupons and Gift Vouchers<?php echo  $acc_gv_amount>0?'&nbsp(Current Balance = '.$currencies->format($acc_gv_amount).') ':'';?></b>
                                   </div>
                   <?php } ?>    
                        
                        <script type="text/javascript">
function popup(url)
   {
        popwin=window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=400,height=100,screenX=50,screenY=50,top=150,left=150');
	    popwin.focus();
   }
</script>
<style>

</style>
<hr></hr>
                           <div class="col-sm-10 " >
                                   
                                    <?php

if (($_SESSION['cc_id']!= '' )|| ($_SESSION['gv_cc_id']!= '' && $_SESSION['gv_coupon_amount']!= '')){
include(DIR_WS_MODULES . 'coupon_help_tip.php');

}	echo tep_draw_form('redeem_coupon', tep_href_link('shopping_cart_mobile.php', 'action=redeem', 'SSL'), 'post');?>
   
        <b>Enter Coupon Code:</b><!-- <center> --><input type="text" name="gv_redeem_code" style="width:70%;" class="form-control col-sm-8">
            <input type="submit" class="btn btn-info btn-sm form-control col-sm-4"  alt="IMAGE_REDEEM_VOUCHER" value="Apply" title=" IMAGE_REDEEM_VOUCHER "><!-- </center> -->
            </form>

                                  </div>    
                              </div>
                           </br>
                              <div class="row">
                                  <div class="col-sm-12 " ><b>Gift Wrap and Labeling</b>
                                  <hr></hr>
                                  <?php
                                            $labelProductsIdQuery = tep_db_query("select products_id from products where products_model = 'LABEL'");
                                            $labelProductsIdArray = tep_db_fetch_array($labelProductsIdQuery);
                                            $labelProductsId = $labelProductsIdArray['products_id'];
                                            $giftWrapProductsIdQuery = tep_db_query("select products_id from products where products_model = 'GIFTRAP'");
                                            $giftWrapProductsIdArray = tep_db_fetch_array($giftWrapProductsIdQuery);
                                            $giftWrapProductsId = $giftWrapProductsIdArray['products_id'];
                                            $label_uprid = $labelProductsId . '{1}1';
                                            $giftwrap_uprid = $giftWrapProductsId . '{1}1';
                                            $lablesChecked = '';
                                            $giftWrapChecked = '';
                                            if (isset($cart->contents[$label_uprid]))
                                                $lablesChecked = 'checked';
                                            if (isset($cart->contents[$giftwrap_uprid]))
                                                $giftWrapChecked = 'checked';
                                            ?>
                                           <!--  <br>
                                            <hr></hr> -->
                                            <input type="checkbox" name="buyLabel" onclick="orderLabels(this, '<?= $giftWrapProductsId; ?>')" <?= $giftWrapChecked; ?>/> Gift Wrap Order for $5.00</span>&nbsp;&nbsp;&nbsp;&nbsp;<br><span style="color:#555; font:small-caption;">***WE DO NOT GIFT WRAP INTERNATIONAL ORDERS.***</span>
                                              <div class="spaceloader">  </div><input type="checkbox" name="buyLabel" onclick="orderLabels(this, '<?= $labelProductsId; ?>')" <?= $lablesChecked; ?>/> Label All Stones for $0.00 <a href="javascript:void();" style="text-decoration:none;" rel="shoppingCartTT" title="In order to offer the lowest prices possible, we don't usually label all of our stones.<br/>If you would like us to label all of your stones, Now we can do that free.</br></br>* Some grab bags and mixed assortments are pre-mixed with a wide assortment of</br>stones and cannot be labeled."></a></span>&nbsp;&nbsp;&nbsp;&nbsp;<br><span style="color:#555; font:small-caption;">*** LABELS NOT AVAILABLE FOR ASSORTMENTS, GRAB BAGS OR OTHER MIXES. ***</span>
                                             
                                              
                                  </div>
                                  </div>
                            </td>
                            <td >
                              <div class="row">
                               
                                  <div class="col-sm-12 " id="shippings"> <!-- <center> --><b><!-- <h3> --><!-- Shipping  --><!-- Options --><!-- </h3> --></b><!-- </center> -->
                                      <?php
// WebMakers.com Added: Shipping Estimator
  if (SHOW_SHIPPING_ESTIMATOR=='true') {
    ?><style type="text/css">
    #shippings table tbody td::before {

    content: none;
    font-weight: none;
    display: none;
    width: 0rem;

}

  
.main-container #mainContentTD .contentbox {

      margin-top: -7%;

}
</style><?php
 require(DIR_WS_MODULES . 'shipping_estimator_mobile.php'); ?>
<?php
  }
?>
                                      </div>
                                      </div>
                                      </td>
                        </tr>
                        
                    <tbody>
 
    
    
    
    
    
<tfoot>
    <tr>
    

    <tr>

        <?php /*<?php echo tep_href_link('checkout_payment_mobile.php', '', 'SSL');?>*/ ?>
        <td><button type="button" onclick="show_loaders2();"  class="btn btn-success btn-block" id="checkoutbutton">Checkout <i class="fa fa-angle-right"></i></button></td>
    </tr>
<!--       <script type="text/javascript">
    $(function(){
      $('.lds-roller').css('display','none');
      $('checkoutbutton').on('click', function(){
       $('.lds-roller').css('display','initial');
        setTimeout(function()
            { 
               window.location.href = '<?php echo tep_href_link('checkout_payment_mobile.php', '', 'SSL');?>';
             }, 3000);
              $('.lds-roller').css('display','none');
      });
    });
     </script> -->
<script type="text/javascript">
         function show_loaders2() {
          /*$('.lds-roller').css('display','initial');*/
          $('#checkoutbutton').prop('disabled', true);
        setTimeout(function()
            { 
               window.location.href = '<?php echo tep_href_link('checkout_payment_mobile.php', '', 'SSL');?>';
             }, 3000);
           $('.lds-roller').css('display','none');
        }
      </script>
      <!--   <td><center><a href="<?php echo tep_href_link('checkout_payment_mobile.php', '', 'SSL');?>" style="
background-color:#44c767;
-moz-border-radius:6px;
-webkit-border-radius:6px;
border-radius:6px;
border:1px solid #18ab29;
display:inline-block;
cursor:pointer;
color:#000000;
font:caption;
padding:7px 100px;
text-decoration:none;">Checkout</center></td> -->
    </tr>
</tfoot>
</table>
</form>
<?php   }
      }
?>

</div>
