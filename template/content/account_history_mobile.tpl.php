    <script type="text/javascript" src="wz_tooltip.js"></script>
    <table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
<?php
// BOF: Lango Added for template MOD
if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'
//EOF: Lango Added for template MOD
?>  
       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_history.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
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
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_top(false, false, $header_text);
}
// EOF: Lango Added for template MOD
?>
      <tr>
        <td>
<?php
  $orders_total = tep_count_customer_orders();

  if ($orders_total > 0) {
// Changed for Paypal IPN Mod
//    $history_query_raw = "select o.orders_id, o.date_purchased, o.delivery_name, o.billing_name, ot.text as order_total, s.orders_status_name from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS_STATUS . " s where o.customers_id = '" . (int)$customer_id . "' and o.orders_id = ot.orders_id and ot.class = 'ot_total' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' order by orders_id DESC";
//Here is the new line for paypal IPN
     
      if($_SESSION['customers_other_id']=='' || !isset($_SESSION['customers_other_id']))$_SESSION['customers_other_id']=$customer_id;
  
      $history_query_raw = "select o.orders_id, o.date_purchased, o.delivery_name, o.billing_name, ot.text as order_total, s.orders_status_name from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS_STATUS . " s where o.customers_id in (" . $_SESSION['customers_other_id'] . ") and o.orders_id = ot.orders_id and ot.class = 'ot_total' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and o.orders_status != '99999' and o.orders_status != '100001' and o.orders_status != '100003' order by orders_id DESC";
//End Paypal IPN Mod
    $history_split = new splitPageResults($history_query_raw, MAX_DISPLAY_ORDER_HISTORY);
    $history_query = tep_db_query($history_split->sql_query);

    while ($history = tep_db_fetch_array($history_query)) {
      $products_query = tep_db_query("select count(*) as count from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$history['orders_id'] . "'");
      $products = tep_db_fetch_array($products_query);

      if (tep_not_null($history['delivery_name'])) {
        $order_type = TEXT_ORDER_SHIPPED_TO;
        $order_name = $history['delivery_name'];
      } else {
        $order_type = TEXT_ORDER_BILLED_TO;
        $order_name = $history['billing_name'];
      }
?>
          <table border="0" width="100%" cellspacing="0" cellpadding="2">
            <tr>
              <td class="main"><?php echo '<b>' . TEXT_ORDER_NUMBER . '</b> ' . $history['orders_id']; ?></td>
              <td class="main" align="right"><?php echo '<b>' . TEXT_ORDER_STATUS . '</b> ' . $history['orders_status_name']; ?></td>
            </tr>
          </table>
          <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
            <tr class="infoBoxContents">
              <td><table border="0" width="100%" cellspacing="2" cellpadding="4">
                <tr>
                 <?php
            $check_comments_query = tep_db_query("select count(*) as total from products_comments where orders_id='" . (int)$history['orders_id'] . "' and customers_id='" . (int)$customer_id . "'");
            $check = tep_db_fetch_array($check_comments_query);
            if ($check['total'] > 0) {
            	$comment_image = 'button_view_comment.gif';
				$comment_alt = 'View/Edit your Review or Comment';
			} else {
	            $comment_image = 'button_place_a_review.gif';
				$comment_alt = 'Place a Review or Comment';
			}
                        $giftVoucherLink = '';
$coupon_query = tep_db_query("select coupon_id, coupon_code, coupon_amount, date_format(coupon_expire_date,'%m/%d/%y') as expires_on from coupons where created_from_orderid = '".$history['orders_id']."' and coupon_type = 'G' order by date_created DESC limit 1");
    if(tep_db_num_rows($coupon_query))$giftVoucherLink='<a href="'.  tep_href_link('voucherImage.php','oID='.$history['orders_id']).'" target="_blank">View and Print your Gift Voucher </a>';

			?>
                  <td class="main" width="50%" valign="top"><?php echo '<b>' . TEXT_ORDER_DATE . '</b> ' . tep_date_long($history['date_purchased']) . '<br>'.$giftVoucherLink.'<br/><b>' . $order_type . '</b> ' . tep_output_string_protected($order_name); ?><br/><br/><?php echo '<a href="' . tep_href_link('order_comments.php','order_id=' . $history['orders_id'], 'SSL') . '">' . tep_template_image_button($comment_image, $comment_alt) . '</a>'; ?></td>
                  <td class="main" width="30%" valign="top"><?php echo '<b>' . TEXT_ORDER_PRODUCTS . '</b> ' . $products['count'] . '<br><b>' . TEXT_ORDER_COST . '</b> ' . strip_tags($history['order_total']); ?></td>
                  <td class="main" width="20%" valign="top"><?php echo '<a href="' . tep_href_link(FILENAME_ACCOUNT_HISTORY_INFO, (isset($HTTP_GET_VARS['page']) ? 'page=' . $HTTP_GET_VARS['page'] . '&' : '') . 'order_id=' . $history['orders_id'], 'SSL') . '">' . tep_template_image_button('small_view.gif', SMALL_IMAGE_BUTTON_VIEW) . '</a>'; ?></td>
                </tr>
				<tr>
				  <td colspan="3" align="left">
				    <a class="property" href="<?php echo tep_href_link('summary_mpd.php','order_id='.$history['orders_id']); ?>">Summary Metaphysical Descriptions</a> - View the short metaphysical descriptions for each crystal in this order. 
				  </td>
				</tr>
				<tr>
				  <td colspan="3" align="left">
				    <a class="property" href="<?php echo tep_href_link('detailed_mpd.php','order_id='.$history['orders_id']); ?>">Detailed Metaphysical Descriptions</a> - View the detailed metaphysical descriptions for each crystal in this order. 
				  </td>
				</tr>
				<tr>
				  <td colspan="3" align="left">
				    <a class="property" href="<?php echo tep_href_link('products_description.php','order_id='.$history['orders_id']); ?>">Product Descriptions</a> - View the product descriptions for each item in this order. 
				  </td>
				</tr>
              </table></td>
            </tr>
          </table>
          <table border="0" width="100%" cellspacing="0" cellpadding="2">
            <tr>
              <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
          </table>
<?php
    }
  } else {
?>
          <table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
            <tr class="infoBoxContents">
              <td><table border="0" width="100%" cellspacing="2" cellpadding="4">
                <tr>
                  <td class="main"><?php echo TEXT_NO_PURCHASES; ?></td>
                </tr>
              </table></td>
            </tr>
          </table>
<?php
  }
?>
        </td>
      </tr>
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
<?php
  if ($orders_total > 0) {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="smallText" valign="top"><?php echo $history_split->display_count(TEXT_DISPLAY_NUMBER_OF_ORDERS); ?> &nbsp;&nbsp;&nbsp;<a href="javascript: void(0);" onmouseover="Tip('If you have ordered under multiple accounts and would like to recover your order history,<br>please <a href=\'http://www.healingcrystals.com/contact_us.php\'>Contact Us</a> and send us the following information:<br><br>First Name<br>Last Name<br>Delivery Address for older orders<br>Approximate Date for older orders<br><br>After receiving this information, we will do our best to recover your old account history for you.<br><br>Thanks again for shopping with us!<br><br>Crystal Blessings,<br><br>The Healing Crystals Team')"  onmouseout="UnTip()">More orders under a different account?</a></td>
            <td class="smallText" align="right"><?php echo TEXT_RESULT_PAGE . ' ' . $history_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  }
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
                
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table>
