    <table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_wishlist.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
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
  $wishlist_array = array();
  $wishlist_query_raw = "select * from " . TABLE_WISHLIST . " where customers_id= '" . (int)$customer_id . "' order by products_name";
  $wishlist_split = new splitPageResults($wishlist_query_raw, MAX_DISPLAY_WISHLIST_PRODUCTS, 'products_id');
  if (($wishlist_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {

?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="smallText"><?php echo $wishlist_split->display_count(TEXT_DISPLAY_NUMBER_OF_WISHLIST); ?></td>
            <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $wishlist_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table></td>
      </tr>

<?php
  }

?>

      <tr>
        <td>
		<table border="0" width="100%" cellspacing="0" cellpadding="2">



<!-- customer_wishlist //-->
<?php
 if ($wishlist_split->number_of_rows > 0) {
    $wishlist_query = tep_db_query($wishlist_split->sql_query);
    //$wishlist_query = tep_db_query($wishlist_query_raw);
    }

    $info_box_contents = array();
 if ($wishlist_split->number_of_rows>0) {

 
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>
<tr>
<?php

    $product_ids = '';
    while ($wishlist = tep_db_fetch_array($wishlist_query)) {
	      $product_ids .= $wishlist['products_id'] . ',';
    }
    $product_ids = substr($product_ids, 0, -1);
?>

<?php
  //  $products_query = tep_db_query("select products_id, products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id in (" . $product_ids . ") and language_id = '" . $languages_id . "' order by products_name");
   	$products_query = tep_db_query("select pd.products_id, pd.products_name, pd.products_description, p.products_image, p.products_price, p.products_tax_class_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id in (" . $product_ids . ") and p.products_id = pd.products_id and pd.language_id = '" . $languages_id . "' order by products_name");
	
	//$products_query = tep_db_query('select products_id, products_name, products_description, products_image,  products_price, products_tax_class_id from from ' . TABLE_WISHLIST . ' where products_id= ' . $product_info['products_id'] . ' and customers_id = ' . (int)$customer_id . ' order by products_name');
	
    $row = 0;
    while ($products = tep_db_fetch_array($products_query)) {
	/*
	  if ($new_price = tep_get_products_special_price($products['products_id'])) {
      $products_price = '<s>' . $currencies->display_price($products['products_price'], tep_get_tax_rate($products['products_tax_class_id'])) . '</s> <span class="productSpecialPrice">' . $currencies->display_price($new_price, tep_get_tax_rate($products['products_tax_class_id'])) . '</span>';
    } else {
      $products_price = $currencies->display_price($products['products_price'], tep_get_tax_rate($products['products_tax_class_id']));
    }
    */
    
    	if ($products['products_price'] == 0){

							$products['products_price'] = tep_get_products_price($products['products_id']);

						}

            if (tep_get_products_special_price($listing['products_id'])) {

              $lc_text = '&nbsp;<s>' .  $currencies->display_price($products['products_price'], tep_get_tax_rate($products['products_tax_class_id'])) . '</s>&nbsp;&nbsp;<span class="productSpecialPrice">' . $currencies->display_price(tep_get_products_special_price($products['products_id']), tep_get_tax_rate($products['products_tax_class_id'])) . '</span>&nbsp;';



            } else {
$products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . $products['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' ");
       $products_attributes = tep_db_fetch_array($products_attributes_query);
       if ($products_attributes['total'] > 0) {
             $min_price = tep_get_options_min_price($products['products_id']);
             $max_price = tep_get_options_max_price($products['products_id']);
             if ($min_price == $max_price) {
        $lc_text = '&nbsp;<font color="#800080">' .  $currencies->display_price($min_price, tep_get_tax_rate($products['products_tax_class_id'])). '</font>&nbsp;';
         } else {
         $lc_text = '&nbsp;<font color="#800080">' .  $currencies->display_price($min_price, tep_get_tax_rate($products['products_tax_class_id'])) . ' - ' . $currencies->display_price($max_price, tep_get_tax_rate($products['products_tax_class_id'])). '</font>&nbsp;';
        }
        $products_options_specials__query = tep_db_query("select products_attributes_special_price from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$products['products_id'] . "' and products_attributes_special_price > 0");
        if (tep_db_num_rows($products_options_specials__query) > 0) {
	     $min_special_price = tep_get_options_min_special_price($products['products_id']);
             $max_special_price = tep_get_options_max_special_price($products['products_id']);
             if ($min_special_price == $max_special_price) {
        $lc_special = '&nbsp;<font color="#800080">' .  $currencies->display_price($min_special_price, tep_get_tax_rate($products['products_tax_class_id'])). '</font>&nbsp;';
         } else {
         $lc_special = '&nbsp;<font color="#800080">' .  $currencies->display_price($min_special_price, tep_get_tax_rate($products['products_tax_class_id'])) . ' - ' . $currencies->display_price($max_special_price, tep_get_tax_rate($products['products_tax_class_id'])). '</font>&nbsp;';
        }
        $lc_text = '&nbsp;<s>' .  $lc_text . '</s>&nbsp;&nbsp;<span class="productSpecialPrice">' . $lc_special. '</span>&nbsp;';
        }
       } else $lc_text = '&nbsp;<font color="#800080">' .  $currencies->display_price($products['products_price'], tep_get_tax_rate($products['products_tax_class_id'])). '</font>&nbsp;';
      }
      $products_price = $lc_text;
      $row++;
?>
			  <td width="50%" valign="top" align="center" class="main"><div align="center"><a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'cPath=' . tep_get_product_path($products['products_id']) . '&products_id=' . $products['products_id'], 'NONSSL'); ?>"><?php echo $products['products_name']; ?></a></div>
				<a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'cPath=' . tep_get_product_path($products['products_id']) . '&products_id=' . $products['products_id'], 'NONSSL'); ?>"><?php echo tep_image(DIR_WS_IMAGES . $products['products_image'], $products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT); ?></a><br>
				<?php echo tep_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '1', '5'); ?><br>Price:&nbsp;<?php echo $products_price; ?><br>
				<a href="<?php echo tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=cust_order&pid=' . $products['products_id'] . '&rfw=1', 'NONSSL'); ?>">Move to Cart</a>&nbsp;|&nbsp;<a href="<?php echo tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=remove_wishlist&pid=' . $products['products_id'], 'NONSSL'); ?>">Delete</a><br>
				<?php echo tep_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '1', '5'); ?></td>
<?php
      if ((($row / 2) == floor($row / 2))) {
?>
  </tr>
  <tr>
    <td colspan="2"><?php echo tep_draw_separator('pixel_black.gif', '100%', '1'); ?></td>
  </tr>
  <tr>
<?php
      }
?>
<?php
    }
?>
	</tr>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
	</table>
	</td></tr>

      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  if (($wishlist_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {

?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="smallText"><?php echo $wishlist_split->display_count(TEXT_DISPLAY_NUMBER_OF_WISHLIST); ?></td>
            <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $wishlist_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table></td>
      </tr>

<?php
  }

?>

<?php
	} else { // Nothing in the customers wishlist

// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>

      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">

      <tr>
        <td class="main" align="center">No products are in your Wishlist</td>
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
        </table></td>
      </tr>

<?php
	}
?>

<!-- customer_wishlist_eof //-->
		</td>
      </tr>
    </table>
