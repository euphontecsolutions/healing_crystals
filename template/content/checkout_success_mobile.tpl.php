
 <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script>

      $(function(){
    /*$('a').each(function() {
        $(this).attr('href', 'checkout_success_mobile.php');
        
    });*/
    $("a").click(function() {
   // return false;
});
});
  </script>
  
    <?php echo tep_draw_form('order', tep_href_link(FILENAME_CHECKOUT_SUCCESS, 'action=update', 'SSL')); ?><table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB;?>">
   <!--    <tr>
              <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr> -->

<?php

/*
echo $_SESSION["order_id"];*/


     $order_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where customers_id = '" . (int)$customer_id . "'");
     $order_number = tep_db_fetch_array($order_query);



?>

      <tr>
        <td><table border="0" width="100%" cellspacing="4" cellpadding="2">
          <!--tr>
            <td valign="top"><?php echo tep_image(DIR_WS_IMAGES . 'table_background_man_on_board.gif', $HEADING_TITLE); ?></td>
            <td valign="top" class="main"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?><div align="center" class="pageHeading"><?php echo HEADING_TITLE_1 . $HTTP_GET_VARS['order_id'] . HEADING_TITLE_2; ?>&nbsp;&nbsp;&nbsp;<?php echo '<a href="javascript:popupOrder(\'' .  (HTTP_SERVER . DIR_WS_CATALOG . 'invoice/invoice_'.$HTTP_GET_VARS['order_id'].'.pdf') . '\')">'; ?>View And Print Invoice</a></div>

            </td></tr//-->
<?php if (DOWNLOAD_ENABLED == 'true'){
        include(DIR_WS_MODULES . 'downloads.php');
        ?>
        <!--     <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '20'); ?></td>
    </tr> -->
            <?php
        } ?>
            <tr><td colspan="2">
	    <?php
$payment_query = tep_db_query("select payment_method from " . TABLE_ORDERS . " where orders_id = '" . (int)$HTTP_GET_VARS['order_id'] . "'");
    $payment = tep_db_fetch_array($payment_query);

    if (preg_match('/Check/i', $payment['payment_method'])) {
     // echo TEXT_SUCCESS_CHECK;
      } else {
	//echo TEXT_SUCCESS;
	} 
	    require(DIR_WS_CLASSES.'order.php');
        $order = new order($HTTP_GET_VARS['order_id']);
$mpd_content = '<a class="property" href="' . tep_href_link('summary_mpd.php','order_id='.$HTTP_GET_VARS['order_id']) . '">Summary Metaphysical Descriptions</a> - View the short metaphysical descriptions for each crystal in this order.
				 <br>
				 <a class="property" href="' . tep_href_link('detailed_mpd.php','order_id='.$HTTP_GET_VARS['order_id']) . '">Detailed Metaphysical Descriptions</a> - View the detailed metaphysical descriptions for each crystal in this order.
				 <br>
				 <a class="property" href="' . tep_href_link('products_description.php','order_id='.$HTTP_GET_VARS['order_id']) . '">Product Descriptions</a> - View the product descriptions for each item in this order.
				 <br>';




for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {

	$article_name = '';
	$product_article_image = '';
	$article_description = '';
	$stone_name = '';
	$article_id_query = tep_db_query("SELECT sn.stone_name, p.products_image, sn.detailed_mpd from stone_names sn, products_to_stones p2s, products p where p2s.stone_name_id = sn.stone_name_id and p2s.products_id=p.products_id and p2s.products_id = '" . $order->products [$i] ['id'] . "' limit 1");

		$article_id = tep_db_fetch_array($article_id_query);
		if($article_id['stone_name'] != ''){
			$stone_name = 'Stone Name:  ' . $article_id['stone_name'];
		}
		if($article_id['detailed_mpd'] !=0){
			$article_details_query = tep_db_query("select ad.articles_id, ad.articles_name, ad.articles_description, ad.articles_url from articles_description ad where ad.articles_id=".$article_id['detailed_mpd']);
			if(tep_db_num_rows($article_details_query)){
				$article_details = tep_db_fetch_array($article_details_query);
				$article_name = $article_details['articles_name'];
				$product_article_image = '<img width="100" height="100" src="'. HTTP_SERVER . DIR_WS_HTTP_CATALOG . DIR_WS_IMAGES . $article_id['products_image'] . '" ALT=""  BORDER="0">';
				$article_description = $article_details['articles_description'];

				$mpd_content .= '<table border="0" width="100%" cellspacing="2" cellpadding="4">
	  <tr>
	    <td class="main" width="40%" valign="top">
		  <table border="0" width="100%" cellspacing="2" cellpadding="0">
		    <tr>
			  <td class="main"><b>Product Name:  ' . $order->products[$i]['name'] . '</b>
			  </td>
			</tr>
		    <tr>
			  <td class="main">' . $product_article_image . '
			  </td>
			</tr>
		    <tr>
			  <td class="main">
			  ' . $stone_name . '
			  </td>
			</tr>
		  </table>
		</td>
		<td class="main" width="60%" valign="top">
		<SPAN CLASS="MPDTitle">

				' . $article_name . '
				</span>

				' . stripslashes($article_description) . '

		</td>
	  </tr>
	  <tr><td colspan="2" align="center">Metaphysical Descriptions provided by www.HealingCrystals.com<br />"Promoting the education and use of crystals to support healing"</td></tr>
	</table>';
                        }
                }
}
$gvMessage = '';

    $gvQ = tep_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id='" . $customer_id . "'");
    if ($gvR = tep_db_fetch_array($gvQ)) {
        if ($gvR['amount'] > 0) {
            $gvMessage = 'You have funds in your Gift Voucher Account. <br>
                         If you would like to send those funds as a gift to another person, please <a href="'.tep_href_link(FILENAME_GV_SEND).'" class="pageResults"><b>click here</b></a>';
        }
    }
    $giftVoucherLink = '';
    $coupon_query = tep_db_query("select coupon_id, coupon_code, coupon_amount, date_format(coupon_expire_date,'%m/%d/%y') as expires_on from coupons where created_from_orderid = '" . $HTTP_GET_VARS['order_id'] . "' and coupon_type = 'G' order by date_created DESC limit 1");
    if (tep_db_num_rows($coupon_query)) $giftVoucherLink = 'View and print your Gift Voucher <a href="' . tep_href_link('voucherImage.php', 'oID=' . $HTTP_GET_VARS['order_id']) . '" target="_blank">here</a>';

	$pageTemplateQuery = tep_db_query("select page_and_email_templates_content from page_and_email_templates where page_and_email_templates_key = 'PAGE_TEMPLATE_ORDER_SUCCESS'");
$pageTemplateArray = tep_db_fetch_array($pageTemplateQuery);
$variableToBeReplaced = array('{order_number}','{invoice_link}','{metaphysical_description}', '{gift_voucher}', '{gift_voucher_message}');
$variableToBeAdded= array($HTTP_GET_VARS['order_id'],'<a href="javascript:popupOrder(\'' .  (HTTP_SERVER . DIR_WS_CATALOG . 'invoice/invoice_'.$HTTP_GET_VARS['order_id'].'.pdf') . '\')">View And Print Invoice</a>',$mpd_content, $giftVoucherLink,$gvMessage);
$pageTemplateArray['page_and_email_templates_content']= str_replace($variableToBeReplaced,$variableToBeAdded,$pageTemplateArray['page_and_email_templates_content']);
$articles1 = str_replace('"http://www.healingcrystals.com/images/logo_img1.png"','"http://www.healingcrystals.com/images/HcFamily/ar1111-1.jpg" width="100%"',$pageTemplateArray['page_and_email_templates_content']);
$articles2 = str_replace('"http://www.healingcrystals.com/images/social_sites.jpg"','"http://www.healingcrystals.com/images/social_sites.jpg" width="100%"',$articles1);
?><!-- <img alt="" src="http://www.healingcrystals.com/images/HcFamily/ar1111-1.jpg" width="100%" height="53"> --><?php
echo $articles2;
?>
<!-- <img alt="" src="http://www.healingcrystals.com/images/social_sites.jpg" width="100%" height="70"> --><?php
/*echo $pageTemplateArray['page_and_email_templates_content'];*/
	    ?>
		</td>
          </tr>




		  <tr><td colspan="2" align="center"><?php echo $gv_message;?></td></tr>
            <?php //if (DOWNLOAD_ENABLED == 'true') include(DIR_WS_MODULES . 'downloads.php'); ?>
        </table></td>
      </tr>
     <!--  <tr>
              <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr> -->
      <tr>
			<td>
				<table border="0" width="100%" cellspacing="0" cellpadding="2" class="infoBox">
          <tr class="infoBoxContents">
            <td><table border="0" width="100%" cellspacing="1" cellpadding="2">
              <tr>
							    <!--    <td align="left" class="main"><?php echo '<a href="javascript:popupOrder(\'' .  (HTTP_SERVER . DIR_WS_CATALOG . FILENAME_ORDERS_PRINTABLE) . '?' . (tep_get_all_get_params(array('order_id')) . 'order_id=' . $HTTP_GET_VARS['order_id']) . '\')">' . tep_template_image_button('button_printorder.gif', IMAGE_BUTTON_PRINT_ORDER) . '</a>'; ?></td> //-->
							        <td align="left" class="main">
<!--                                        --><?php //echo '<a href="javascript:popupOrder(\'' .  (HTTP_SERVER . DIR_WS_CATALOG . 'invoice/invoice_'.$HTTP_GET_VARS['order_id'].'.pdf') . '\')">' . tep_template_image_button('button_printorder.gif', IMAGE_BUTTON_PRINT_ORDER) . '</a>'; ?>
                                        <?php
                                        $urlsss = $_SERVER['HTTP_HOST'];

                                        if (strpos($urlsss,'www.test.healingcrystals.com:8888') !== false) {
                                            //echo '<a href="javascript:popupWindow(\'http://' . $_SERVER['HTTP_HOST'] . '/sendinvoice_pdf.php?oID=' . $HTTP_GET_VARS['order_id'] . '&generate_from_admin=true&download=false' . '\')">' . tep_template_image_button('button_printorder.gif', IMAGE_BUTTON_PRINT_ORDER) . '</a>';
                                        }else{
                                            //echo '<a href="javascript:popupWindow(\'https://' . $_SERVER['HTTP_HOST'] . '/sendinvoice_pdf.php?oID=' . $HTTP_GET_VARS['order_id'] . '&generate_from_admin=true&download=false' . '\')">' . tep_template_image_button('button_printorder.gif', IMAGE_BUTTON_PRINT_ORDER) . '</a>';

                                        }
                                        ?>
                                    </td>
<!--                    <td class=main>
                        <a href="<?php echo tep_href_link(FILENAME_REVIEWS_WRITE); ?>"><?php echo  tep_template_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW); ?></a>
                    </td>-->
                    <!--<td class="main">
                        <a href="<?php echo tep_href_link(FILENAME_TELL_A_FRIEND);?>"><?php echo tep_template_image_button('button_tell_friend.gif', IMAGE_BUTTON_TELL_A_FRIEND);?></a>
                    </td>
  						      <td align="right" class="main"><?php echo tep_template_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>
  						      <td align="left" class="main"><?php echo tep_template_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?></td>-->
  						    <!--   <input type="button" class="btn btn-success btn-block" style="color: #fff;background-color: #5cb85c;border: 0;font-size: 20px;border-color: #4cae4c;" value="Back To Home" onclick="mobileHomeRedirect()"> -->
							</tr>
						</table>
					</td></tr></table>
			</td>
      </tr>
    </table></form>

    <?php
    $ob=$order;
    $trans=array();
    $order_id=$HTTP_GET_VARS['order_id'];
    $pro=$ob->products;
    $totals=$ob->totals;

    foreach ($totals as $t){
//        print_r($t['class']);
        if($t['class'] == 'ot_total')
            $trans['revenue']=$t['value'];
        elseif ($t['class'] == 'ot_shipping')
            $trans['shipping']=$t['value'];

    }

    $trans['id']=$order_id;
    $trans['affiliation']='Healing Crystals';
    $trans['currency']=$ob->info['currency'];
//    echo json_encode($trans);

    $items=[];
    foreach ($pro as $p) {
        $item = [];
        $item['id']=$order_id;
        $item['name']=htmlentities(addslashes($p['name']));
        $item['sku']=$p['model'];
        $item['quantity']=$p['qty'];
        $item['price']=$p['final_price'];
        array_push($items,$item);


    }

    $trans=json_encode($trans);

    ?>
<script>

function mobileHomeRedirect(){
    var url = 'checkout_success_mobile.php?set_flag=1';
    $.ajax({
        url: url,
        success: function(data){
      },
      });
}
    window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
            ga('create', 'UA-8259967-1', 'auto') ;
    ga('require', 'ecommerce');
    ga('ecommerce:addTransaction',JSON.parse('<?= $trans ?>'));
    <?php
    foreach ($items as $itm){
        ?>
    console.log('<? json_encode($itm) ?>');
    ga('ecommerce:addItem', JSON.parse('<?= json_encode($itm) ?>'));
<?php
    }

    ?>
    ga('ecommerce:send');
    ga('ecommerce:clear');
   
</script>
