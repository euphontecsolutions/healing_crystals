   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">   
    <table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>" style="margin-left: 2%;">
<?php
// BOF: Lango Added for template MOD
/*if (SHOW_HEADING_TITLE_ORIGINAL == 'yes') {
$header_text = '&nbsp;'*/
//EOF: Lango Added for template MOD
?>
 <!--      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
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
      </tr> -->
     
<?php
// BOF: Lango Added for template MOD
/*}else{*/
/*$header_text = HEADING_TITLE;
}*/
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
  if ($messageStack->size('account') > 0) {
?>
      <tr>
        <td><?php echo $messageStack->output('account'); ?></td>
      </tr>
   <!--    <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr> -->
<?php
  }
?>
<tr>
    <td >
		<?php 
			$pageTemplateQuery = tep_db_query("select page_and_email_templates_content from page_and_email_templates where page_and_email_templates_key = 'PAGE_TEMPLATE_ACCOUNT_HISTORY'");
			$pageTemplateArray = tep_db_fetch_array($pageTemplateQuery);
			echo $pageTemplateArray['page_and_email_templates_content']; 
		?>
	</td>
  </tr>
<!--   <tr>
     <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
  </tr> -->
<?php
  if (tep_count_customer_orders() > 0) {
?>
     
      <tr width="100%">
        <td width="100%"><table border="0" width="100%" cellspacing="1" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents" style="text-decoration: none;" width="100%">
            <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
if($_SESSION['customers_other_id']=='' || !isset($_SESSION['customers_other_id']))$_SESSION['customers_other_id']=$customer_id;
    $orders_query = tep_db_query("select o.orders_id, o.date_purchased, o.delivery_name, o.delivery_country, o.billing_name, o.billing_country, ot.text as order_total, s.orders_status_name from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS_STATUS . " s where o.customers_id in (" . $_SESSION['customers_other_id'] . ") and o.orders_id = ot.orders_id and ot.class = 'ot_total' and o.orders_status = s.orders_status_id and s.language_id = '" . (int)$languages_id . "' and o.orders_status != '99999' and o.orders_status != '100001' and o.orders_status != '100003' order by orders_id desc");
    while ($orders = tep_db_fetch_array($orders_query)) {
      if (tep_not_null($orders['delivery_name'])) {
        $order_name = $orders['delivery_name'];
        $order_country = $orders['delivery_country'];
      } else {
        $order_name = $orders['billing_name'];
        $order_country = $orders['billing_country'];
      }
?>
<!--<div class="container"  onClick="document.location.href='<?php echo tep_href_link('account_history_info_mobile.php', 'order_id=' . $orders['orders_id'], 'SSL'); ?>'">-->
<div class="container"  ><?php $d=strtotime($orders['date_purchased']); ?>
  <h4><?php echo date("d M Y", $d); ?></h4>
  <div class="row" style="background-color:#e6f2ff;">
    <div class="col-sm-3" >
      <p><?php echo '#' . $orders['orders_id']; ?></p>
    </div>
    <div class="col-sm-3" >
      <p><?php echo tep_output_string_protected($order_name) . ', ' . $order_country; ?></p>
    </div>
    
    <div class="col-sm-3" >
      <p><?php echo $orders['orders_status_name']; ?></p>
    </div>
    <div class="col-sm-3" >
      <p><?php echo $orders['order_total']; ?></p>
    </div>
  </div>
   <div class="row" style="margin-top: 3%;">
    <center>
    <?php
					$check_comments_query = tep_db_query("select count(*) as total from products_comments where orders_id='" . (int)$orders['orders_id'] . "' and customers_id='" . (int)$customer_id . "'");
            $check = tep_db_fetch_array($check_comments_query);
            if ($check['total'] > 0) {
            	$comment_image = 'button_view_comment.gif';
				$comment_alt = 'View/Edit your Review or Comment';
			} else {
	            $comment_image = 'button_place_a_review.gif';
				$comment_alt = 'Place a Review or Comment';
			}
echo '<a class="btn btn-primary" style="color:white" href="' . tep_href_link('account_history_info_mobile.php', 'order_id=' . $orders['orders_id'], 'SSL') . '">' .SMALL_IMAGE_BUTTON_VIEW.'</a>   '  . '<a class="btn btn-primary" style="color:white"; href="' . tep_href_link('order_comments_mobile.php','order_id=' . $orders['orders_id'], 'SSL') . '">' . $comment_alt . '</a>';  ?></center></div>
</div>			
 <tr>
        <td colspan="5"><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
    }
?>
                </table></td>
                <td><?php echo tep_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }else {
        ?>
        <table border="0" width="100%" cellspacing="0" cellpadding="0" style="background-color: grey;color: white;margin-top: 5%;">

          <tr>
 
            <td class="pageHeading" style="color: white;">No records here!</td>

            <td class="pageHeading" align="right" ></td>

          </tr>

        </table>
        <?php
    }
?>
    
<?php
// BOF: Lango Added for template MOD
if (MAIN_TABLE_BORDER == 'yes'){
table_image_border_bottom();
}
// EOF: Lango Added for template MOD
?>
    </table>
