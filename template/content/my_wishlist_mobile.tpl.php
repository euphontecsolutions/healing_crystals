<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>

.head
{
	border-bottom-width: 2px;
	border-bottom-color: white;
	border-bottom-style: solid;
	}

	@media only screen and (max-width: 823px) {
   
       #head1
{
	border-top-width: 1px;
	border-top-color: white;
	border-top-style: solid;
}

	.head
{
	
	border-bottom-style: none;
	font-weight: bold;
	

	}
	
	div.product
	{
		padding-top: 20px;
background-color:white;
max-height: 100%;

	}
	.product1
	{
		padding-top: 5px;
		
	}

	.name
	{
	    font-family: inherit;
    font-weight: 500;
    line-height: 1.1;
	font-size: 18px;
	color: grey;
text-align: justify;
}

		.name1
	{
		font-size: 18px;
		color: grey;
    font-family: inherit;
    font-weight: 500;
    line-height: 1.1;
text-align: justify;
		
	}
	.val
	{
		border-width: 1px;
		border-color: black;
		background-color: white;
		font-size: 16px;
		
	}
	.cart
	{
		background-color:#5bc0de;
		height: 50px;
	}
	#quantity
	{
		max-width: 30%;
		
	}

	.inline1{ 
display: inline-block; 

margin-right: 20px
}
.head3
{
	border-width: 1px;
		border-color: black;
	
		font-size: 16px;
}
.move{

}
.move1 {

    width: 65%;

}


input[type=text] {
   /* height: 20px;*/
  
    box-sizing: border-box;
}
.prod
{
	display: none;
}
}
}

	</style>

<script  type="text/javascript">
    function toggleLeftMenu(image){

        if(image.src.indexOf('images/button_menu_open.gif')!= -1){
            image.src='images/button_menu_close.gif';
        }else{
            image.src='images/button_menu_open.gif';
        }
        var elm = document.getElementById('columnLeft').style.display;
        if(elm.indexOf('none') != -1){
            //alert(elm);
            document.getElementById('columnLeft').style.display = 'block';
        }else{
            document.getElementById('columnLeft').style.display = 'none';
        }
    }


</script>
<div class="container">
<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
	<?php $sc         = $_GET['sc']; if($sc=="1"){ ?><a href="/shopping_cart_mobile.php" class="btn btn-info" style="background-color: #4c6aafad !important; color: #001abc;">&laquo; Back To Cart</a></br></br> <div><b><?php echo 'My Wishlist'; ?></b></div><?php  } else{ } ?>

    <!--<tr>
        <td class="pageHeading" width="100%"><table width="100%"><tr><td align="left" class="pageHeading" valign="bottom">
                        <?php //echo'<img src="images/button_menu_close.gif" alt="Toggle Left Navigation Menu" border="0" id="toggleLeftBar" height="18"  onclick="toggleLeftMenu(this);" style="vertical-align:middle;"/>';
                        ?>
                        &nbsp;&nbsp;
                        <?php
                        //echo $breadcrumb->trail();
                        ?></td>
                </tr></table></td>
    </tr>-->    


<tr>

  <td>
  <script type="text/javascript">
function addToCart(url, id){
	var qtyId = 'wishlist_qty_'+id;
	var rUrl = url + document.getElementById(qtyId).value;
	location.href = rUrl;
}
</script>
<?php  
if($_GET['show_message']==1){
?>
<div style="color:red;">This product is out of stock</div>
<?php
} 
  $wishlist_array = array();
  $wishlist_query_raw = tep_db_query("select distinct(wl.products_id) from " . TABLE_WISHLIST . " wl, " . TABLE_WISHLIST_ATTRIBUTES . " wla where wl.customers_id= '" . (int)$c_id . "' and wl.customers_id=wla.customers_id and wl.products_id=wla.products_id order by wla.shared_purchase ASC, ABS(wla.product_options_quantity - wla.shared_purchase_qty) DESC, products_name");
  
    $info_box_contents = array();
   // $info_box_contents[0][] = array('align' => 'center',
    //                                'params' => 'class="productListing-heading"',
     //                               'text' => TABLE_HEADING_REMOVE);
    /*$info_box_contents[0][] = array('align' => 'left',
    								'params' => '',
									'text' =>'<tr><td colspan=4>'.$msg.'</td></tr>');*/
    $info_box_contents[0][] = array('align' => 'left',
									'params' => 'class="productListing-heading"',
                                     );

    $info_box_contents[0][] = array('align' => 'left',
                                    'params' => 'class="productListing-heading"',
                                    );

    $info_box_contents[0][] = array('align' => 'center',
                                    'params' => 'class="productListing-heading"',
                                    );

    $info_box_contents[0][] = array('align' => 'right',
                                    'params' => 'class="productListing-heading"',
                                    );
  $any_out_of_stock = 0;
  
  $product_ids = '';
  $i = 0;
  while($wishlist = tep_db_fetch_array($wishlist_query_raw)) {
    $product_ids .= $wishlist['products_id'] . ',';
    $products_query = tep_db_query("select pd.products_id, pd.products_name, pd.products_description, p.products_image, p.products_price, p.products_tax_class_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id =" . $wishlist['products_id'] . " and p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' ");
    //$row = 0;
    $products_detail = tep_db_fetch_array($products_query); 
	
	
	$wishlist_products_attributes_query = tep_db_query("select customers_wishlist_attributes_id, shared_purchase_qty, shared_purchase, product_options_quantity, products_options_id, products_options_value_id from " . TABLE_WISHLIST_ATTRIBUTES . " where products_id = '" . $products_detail['products_id'] . "' and customers_id = '" . (int)$c_id . "' order by shared_purchase ASC, ABS(product_options_quantity - shared_purchase_qty) DESC");
	
	$no_of_products = tep_db_num_rows($wishlist_products_attributes_query);
	
	while($wishlist_products_attributes = tep_db_fetch_array($wishlist_products_attributes_query))
	{
	  if($wishlist_products_attributes['shared_purchase'] == '1'){
	    $wishlist_products_attributes['product_options_quantity'] -= $wishlist_products_attributes['shared_purchase_qty'];
	    if($wishlist_products_attributes['product_options_quantity'] < 0){
			$wishlist_products_attributes['product_options_quantity'] = 0;
		}
	  }
	  $products_options_query = tep_db_query("select products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . $wishlist_products_attributes['products_options_id'] . "' ");
	  $products_options = tep_db_fetch_array($products_options_query);
	  
	  $products_attributes_query = tep_db_query("select products_attributes_name, options_values_price, pa.products_attributes_special_price, pa.special_end_date, product_attribute_qty_1, product_attribute_price_1, product_attribute_qty_2, product_attribute_price_2, product_attribute_qty_3, product_attribute_price_3, product_attribute_qty_4, product_attribute_price_4, product_attribute_qty_5, product_attribute_price_5, product_attribute_spe_price_1, product_attribute_spe_price_2, product_attribute_spe_price_3, product_attribute_spe_price_4, product_attribute_spe_price_5 from " . TABLE_PRODUCTS_ATTRIBUTES . " pa where products_id = '" . $products_detail['products_id'] . "' and options_id = '" . $wishlist_products_attributes['products_options_id'] . "' and options_values_id = '" . $wishlist_products_attributes['products_options_value_id']  . "' ");
	  	
	  $products_attributes = tep_db_fetch_array($products_attributes_query);
	
	  if(($products_attributes['special_end_date']> date('Y-m-d h:i:s') || ($products_attributes['special_end_date']== '0000-00-00 00:00:00')) && $products_attributes['products_attributes_special_price'] > 0 ){
	    $products_special_price = $products_attributes['options_values_price'];
		$products_attributes['options_values_price'] = $products_attributes['products_attributes_special_price'];	  	
	  }else{
	  	$products_special_price = '';
	  }
	 
	    if (($i/2) == floor($i/2)) {
        $info_box_contents[] = array('params' => 'class="productListing-even"');
      } else {
        $info_box_contents[] = array('params' => 'class="productListing-odd"');
      }

      $cur_row = sizeof($info_box_contents) ;
	 
	  $products_name = '<table valign="top" border="0" cellspacing="2" cellpadding="2" >' .
                       '  <tr>' .
                       '    <td  class="productListing-data" align="center" >' . tep_image(DIR_WS_IMAGES . $products_detail['products_image'], $products_detail['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</td>' .
                       '    <td class="productListing-data" valign="top"><b class="name"  style="margin-left: 4px;">' . $products_detail['products_name'] . '</b>';

      if (STOCK_CHECK == 'true') {
	  	$wPrid = $products_detail['products_id'] . '{'.$wishlist_products_attributes['product_options_id'].'}'.$wishlist_products_attributes['products_options_value_id'];
        $stock_check = tep_check_stock($wPrid, $wishlist_products_attributes['product_options_quantity']);
        if (tep_not_null($stock_check)) {
          $any_out_of_stock = 1;

          $products_name .= tep_draw_separator('pixel_trans.gif', '5', '3').$stock_check;
        }
      }
	  $products_name .= '<br><br><small><i class="name1" style="color:#777;font-size: 12px;"> - ' . $products_options['products_options_name'] . ' ' . $products_attributes["products_attributes_name"] . '</i></small>';
	  
	  $products_name .= '    </td>' .
                        '  </tr>' .
                        '</table>';
						
	  $unit_special_price = '';
	  
	  if($products_attributes['product_attribute_price_1'] > 0 )	{
	    		if($products_attributes['product_attribute_spe_price_1'] > 0){
					$products_attributes['options_values_price'] = $products_attributes['product_attribute_spe_price_1'];
					$products_special_price = $products_attributes['product_attribute_price_1'];
				}else{
					$products_attributes['options_values_price'] = $products_attributes['product_attribute_price_1'];
					$products_special_price = '';
				}		
	  }
	  if($products_attributes['product_attribute_price_2'] > 0 && $wishlist_products_attributes['product_options_quantity'] > $products_attributes['product_attribute_qty_1'])	{
				if($products_attributes['product_attribute_spe_price_2'] > 0){
					$products_attributes['options_values_price'] = $products_attributes['product_attribute_spe_price_2'];
					$products_special_price = $products_attributes['product_attribute_price_2'];
				}else{
					$products_attributes['options_values_price'] = $products_attributes['product_attribute_price_2'];
					$products_special_price = '';
				}
	  }
	  if($products_attributes['product_attribute_price_3'] > 0 && $wishlist_products_attributes['product_options_quantity'] > $products_attributes['product_attribute_qty_2'] )	{
				if($products_attributes['product_attribute_spe_price_3'] > 0){
					$products_attributes['options_values_price'] = $products_attributes['product_attribute_spe_price_3'];
					$products_special_price = $products_attributes['product_attribute_price_3'];
				}else{
					$products_attributes['options_values_price'] = $products_attributes['product_attribute_price_3'];
					$products_special_price = '';
				}	
	  }
	  if($products_attributes['product_attribute_price_4'] > 0 && $wishlist_products_attributes['product_options_quantity'] > $products_attributes['product_attribute_qty_3'])	{
				if($products_attributes['product_attribute_spe_price_4'] > 0){
					$products_attributes['options_values_price'] = $products_attributes['product_attribute_spe_price_4'];
					$products_special_price = $products_attributes['product_attribute_price_4'];
				}else{
					$products_attributes['options_values_price'] = $products_attributes['product_attribute_price_4'];
					$products_special_price = '';
				}
	  }
	  if($products_attributes['product_attribute_price_5'] > 0 && $wishlist_products_attributes['product_options_quantity'] > $products_attributes['product_attribute_qty_4'])	{
				if($products_attributes['product_attribute_spe_price_5'] > 0){
					$products_attributes['options_values_price'] = $products_attributes['product_attribute_spe_price_5'];
					$products_special_price = $products_attributes['product_attribute_price_5'];
				}else{
					$products_attributes['options_values_price'] = $products_attributes['product_attribute_price_5'];
					$products_special_price = '';
				}
	  }
	  
      if ($products_special_price != '') {
	  	$unit_special_price = '<s><font color="#800080">' . $currencies->display_price($products_special_price, tep_get_tax_rate($products_detail['tax_class_id'])) . '</s></font> ';
	  }
	
      
      $info_box_contents[$cur_row][] = array('params' => 'class="productListing-data"',
                                             'text' =>'<p class="head" id="head1"><b class="prod">Product Name</b></p>'.'<div class="product">'.'<P class="product1">'. $products_name.'</p>'.'</div>');
      $info_box_contents[$cur_row][] = array(
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => '<div class="inline1"><p class="head">Unit Cost</p></div>'.'<div class="inline1"><p class="head3">'.$unit_special_price . '<b>' . $currencies->display_price($products_attributes["options_values_price"], tep_get_tax_rate($products_detail['tax_class_id'])) . '</b>'.'</p></div>');
									
	 
	 
	  $info_box_contents[$cur_row][] = array(
                                             'params' => 'class="productListing-data move" valign="top"',
                                             'text' => '<div class="inline1" style="margin-left: -14px;"><div class="col-sm-12"><p class="head" id="quantity" style="float:left;margin-top: 2px;">Quantity&nbsp;&nbsp;</p></div>'.'<input type="text" class="form-control" style="width:19%; float:left"  name="wishlist_qty" value="' . $wishlist_products_attributes['product_options_quantity'] . '"   id="wishlist_qty_'.$i.'" />&nbsp;&nbsp;<a href="#"  style="width:95px; float:left; margin-left: 1%; color:white;" class="btn btn-primary btn-block" onClick="addToCart(\'' . tep_href_link('shopping_cart_mobile.php', tep_get_all_get_params(array("action","qty","c_id")) . 'action=share_wishlist&pid=' . $products_detail["products_id"] . '&rfw=1&po_id='.$wishlist_products_attributes["products_options_id"].'&pov_id='.$wishlist_products_attributes['products_options_value_id'] . '&cwa_id=' . $wishlist_products_attributes['customers_wishlist_attributes_id'] . '&qty=', 'NONSSL').'\',\''.$i.'\'); return false;" onmouseover="Tip(\'Move this item from your Wish List to your Shopping Cart\')" onmouseout="UnTip()" >Move to cart</a>' 
											 . '<td align="center" colspan="2"></div>');
      $info_box_contents[$cur_row][] = array(
                                             'params' => 'class="productListing-data" valign="top"',
                                             'text' => '<div class="inline1"><p class="head" id="head4">Total Cost</p></div>'.'<div class="inline1"><b class="val">' . $currencies->format($products_attributes["options_values_price"] * $wishlist_products_attributes['product_options_quantity']) . '</b></div>');
                                           
   		$i++;	
	}	

                                           
   		$i++;		 
										 
  }
      if (tep_db_num_rows($wishlist_query_raw) > 0) {
    new productListingBox($info_box_contents, 'table1');  }else{
 
        ?>
        <table border="0" width="100%" cellspacing="0" cellpadding="0" style="background-color: grey;color: white;margin-top: 5%;">

          <tr>
 
            <td class="pageHeading" style="color: white;">No products in wish list</td>

            <td class="pageHeading" align="right" ></td>

          </tr>

        </table>
        <?php
    }
  /*  new productListingBox($info_box_contents, 'table1');*/
	?>
  </td>
</tr>
</table>
</div>
