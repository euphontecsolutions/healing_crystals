   </table></tbody></table>
<!--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
 
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 
  <script src="https://maxcdn.bootsdivapcdn.com/bootsdivap/3.3.7/js/bootsdivap.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootsdivapcdn.com/bootsdivap/3.3.7/css/bootsdivap.min.css">
 <script src="jquery.MetaData.js" type="text/javascript" language="javascript"></script>
<script src="jquery.rating.js" type="text/javascript" language="javascript"></script>
<link href="jquery.rating.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">
	function checkRating(id, rid){
	
		if(document.getElementById(id).value.length>0){
			alert(document.getElementById(rid));
		}
	}
</script>
<style type="text/css">
	   .container {
    padding-left: 14px;
    padding-right:14px;
}
.btn-primary.focus, .btn-primary:focus {
    color: #fff;
    background-color: #286090;
    border-color: #122b40;
}
.btn-primary.focus, .btn-primary:focus {
    color: #fff;
    background-color: #286090;
    border-color: #122b40;
}
.btn.focus, .btn:focus, .btn:hover {
    color: #333;
    text-decoration: none;
}
.btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus {
    outline: 5px auto -webkit-focus-ring-color;
    outline-offset: -2px;
}
.btn-group-xs > .btn, .btn-xs {
    padding: 1px 5px;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 3px;
}
.btn-primary {
    color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
}
.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
    border-radius: 4px;
}
</style>
<div class="container">
<?php
if ($messageStack->size ( 'contact' ) > 0) {
	?>
      <div>
		<div><?php
	echo $messageStack->output ( 'contact' );
	?></div>
	</div>
<?php
}
if (isset ( $HTTP_GET_VARS ['action'] ) && ($HTTP_GET_VARS ['action'] == 'success')) {	?>
	<div>
		<div class="mainCO" align="center"><?php
		$pageTemplateQuery = tep_db_query("select page_and_email_templates_content from page_and_email_templates where page_and_email_templates_key = 'PAGE_TEMPLATE_ORDER_COMMENTS'");
$pageTemplateArray = tep_db_fetch_array($pageTemplateQuery);
echo $pageTemplateArray['page_and_email_templates_content'];
	?></div>
	</div>
<?php
} else if ($HTTP_GET_VARS ['order_id'] == '') {
	echo '<div><div></div></div>';
	echo '<div><div class="pageHeading" align="center">Order do not exist!!!</div></div>';
	echo '<div><div></div></div>';
} else {
	if($_SESSION['customers_other_id']=='' || !isset($_SESSION['customers_other_id']))$_SESSION['customers_other_id']=$customer_id;
	
	//check if the given order is for this customer
	$check_query = tep_db_query ( "select count(*) as total from orders where orders_id = '" . $HTTP_GET_VARS ['order_id'] . "' and customers_id in (" . $_SESSION['customers_other_id'] . ")" );
	$check_array = tep_db_fetch_array ( $check_query );
	echo '<a href="/account_mobile.php?user_id='.$customer_id.'" class="btn btn-info" style="background-color: #4c6aafad !important; color: #001abc;float: left;">«  Back To Orders</a><br><br><br>';
	if ($check_array ['total'] == '0') {
		echo '<div><div></div></div>';
		echo '<div><div class="pageHeading" align="center">You can not comment on this order!!!</div></div>';
		echo '<div><div></div></div>';
	} else {
		$order = new order ( $HTTP_GET_VARS ['order_id'] );
		echo '<div><div colspan="2"></div></div>';
		echo '<div><div class="pageHeading" style="font-size:17px; margin-top: 10px;" align="left" colspan="2">Thank you for your order# ' . $HTTP_GET_VARS ['order_id'] . ' on ' . date('d F Y', strtotime(tep_date_short ( $order->info ['date_purchased'] ))) . '</div></div>';
		echo '<div><div colspan="2"></div></div>';

		?><br>
				<div>
		<div class="mainCO" style="font-size:12px;">We really care about what you think. To help us
		improve our product selection and to let other customers know what you

		think about certain items, please enter your ratings and comments
		below for each item that you purchased.<br />
		<br />
		You can rate and comment on as many (or as few) items as you like.
		Even if you have comments on only 1 or 2 items, this feedback will be
		very useful to us and to other visitors.</div>
	</div><br>
				<?php
		echo '<div><div colspan="2"></div></div>';

		?>
				<div>
		<div colspan="2">
		<form name="orderComments" method="post"
			action="order_comments_mobile.php?action=submit&order_id=<?=$HTTP_GET_VARS ['order_id'];?>">
		<div border="0" width="100%" cellpadding="1" cellspacing="1">
					<?php
		for($i = 0; $i < sizeof ( $order->products ); $i ++) {
			//Get the images 400 by 400 to show them in hover
			$sql = tep_db_query ( "select p.products_image, p.products_image_xl_1, p.products_image_xl_2, p.products_image_xl_3, p.products_image_xl_4, p.products_image_xl_5, p.products_image_xl_6, p.products_image_xl_7, p.products_image_xl_8, p.products_image_xl_9, p.products_image_xl_10 from products p where p.products_id = '" . $order->products [$i] ['id'] . "'" );
			$row = tep_db_fetch_array ( $sql );

			
			echo '<div><div></div></div>';
			echo '<div>
							  	<div class="mainCO">
									<div border="0" width="100%" cellpadding="0" cellspacing="0">
										<div>
										<div width="550" align="left" valign="top" nowrap><div border="0" cellpadding="0" cellspacing="0"><div>
											<div class="mainCO" valign="top" width="10%"><a href="' . tep_href_link ( 'product_info.php', 'products_id=' . $order->products [$i] ['id'] ) . '" target="_blank" class="ocLinks">' . $order->products [$i] ['model'] . '</a></div><div class="mainCO" valign="top" align="left" width="40%">' . $order->products [$i] ['name'] . '<br>' . $order->products [$i] ['adivivibutes'] [0] ['value'] . '</div>
											
																			
										</div><div><div></div></div>
										<div>
											<div class="mainCO" valign="top" width="100%" colspan="2">Rating (1 to 5 Stars) </div>
										</div><br>
										<div><div class="mainCO" valign="top" align="left" colspan="2">
												<input name="star1[' . $i . ']" id="starx' . $i . '" type="radio" value="1" class="star"/>
												<input name="star1[' . $i . ']" id="starx' . $i . '" type="radio" value="2" class="star"/>
												<input name="star1[' . $i . ']" id="starx' . $i . '" type="radio" value="3" class="star"/>
												<input name="star1[' . $i . ']" id="starx' . $i . '" type="radio" value="4" class="star"/>
												<input name="star1[' . $i . ']" id="starx' . $i . '" type="radio" value="5" class="star"/>
											</div></div>
										<div><div></div></div><br><br>
											<div class="row">
										<center>	<div class="mainCO" valign="top" colspan="2">Comments:<br/>' . tep_draw_textarea_field ( 'enquiry[' . $i . ']', 'soft', 75, 6, '', 'id="enquiry' . $i . '" required ' ) . tep_draw_hidden_field ( 'products_id[' . $i . ']', $order->products [$i] ['id'] ) . '</div></center>
										</div>
										</div></div>
										<div rowspan="2" width="10">&nbsp;</div>
										<div rowspan="2" valign="top" align="left" height="90"  CLASS="hoverbox"><center>';
			foreach ( $row as $key => &$value ) {
				if ($value != '') {
					echo '<a href="#" border="0" onclick="return false;" CLASS="MPDPicture">';
					echo tep_image ( DIR_WS_IMAGES . $value, '', '75', '75' ) . '';
					//echo tep_image ( DIR_WS_IMAGES . $value, '', '', '', 'class="preview1"' ) . '';
					echo '</a>';
				}
			}
			echo '</center></div></div></div></div></div>';
		}
		?>
		<div><div class="row">
		    
			<center><button type="submit" class="btn btn-primary btn-xs">Submit</button></center>
		</div>
			</div>
		</div>
		</form>
		</div>
	</div>
				<?php
	}
}
?>
</div>