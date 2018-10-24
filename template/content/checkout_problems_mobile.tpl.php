<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<div class="container">
	<table border="0" width="100%" cellspacing="0" cellpadding="<?php echo CELLPADDING_SUB; ?>">
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
            <td class="pageHeading" align="right">&nbsp;</td>
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
<tr>
	<td><table border="0" width="100%" cellspacing="0" cellpadding="0">
		<?php 
			if($HTTP_GET_VARS['message']== 'sent'){
		?>
		<tr>
			<td class="main"><p>Thank you for letting us know about your checkout issue. We promise to look into the issue right away. If you included your email address, we will email you back to let you know what we find.</p></td>
		</tr>
		
		<?php 
			}else{
		?>
		<?php echo tep_draw_form('checkout_problem', tep_href_link('checkout_problems_mobile.php?action=submit'), 'post');?>		
		<tr>
			<td class="main">Please let us know if you are having problems checking out. To help us fix the problem, please answer a few questions below and we promise to reply to you personally to address the issue:</td>
		</tr>
		
		<tr>
			<td class="main"><table>
				<tr>
					<td class="main">1. What Browser are you using?</td>
				</tr>
				<tr>
					<td class="main">
						<input type="radio" name="browser" value="Internet Explorer">Internet Explorer<br>
						<input type="radio" name="browser" value="Mozilla FireFox">Mozilla FireFox<br>
						<input type="radio" name="browser" value="Google Chrome">Google Chrome<br>
						<input type="radio" name="browser" value="Safari">Safari<br>
						<input type="radio" name="browser" value="AOL">AOL<br>
						<input type="radio" name="browser" value="Other/Don't know">Other/Don't know<br>				
					</td>
				</tr>				
			</table></td>
		</tr>
		
		<tr>
			<td class="main"><table>
				<tr>
					<td class="main">2. What page are you on when you get the error?</td>
				</tr>
				<tr>
					<td class="main">
						<input type="radio" name="referer" value="shopping_cart.php">Shopping Cart (shopping_cart.php) <br>
						<input type="radio" name="referer" value="checkout_payment.php">Payment Page (checkout_payment.php)  <br>
						<input type="radio" name="referer" value="checkout_confirmation.php">Confirmation Page (checkout_confirmation.php)  <br>				
					</td>
				</tr>				
			</table></td>
		</tr>
			
		<tr>
			<td class="main"><table>
				<tr>
					<td class="main">3. Please describe the error that you are receiving:</td>
				</tr>
				<tr>
					<td class="main">
						<?php echo tep_draw_textarea_field('error','wrap','200','6');?>				
					</td>
				</tr>				
			</table></td>
		</tr>
		
		<tr>
			<td class="main"><table>
				<tr>
					<td class="main">4. If you would like us to respond to you by email, please include your email address below:</td>
				</tr>
				<tr>
					<td class="main">
						<?php echo tep_draw_input_field('email');?>				
					</td>
				</tr>				
			</table></td>
		</tr>
						
		<tr>
			<td class="main"><table>				
				<tr>
                	<td class="main" <?php if($_GET['error']=='security_code')echo 'style="background-color:red"';?>>Anti-Spam Question: <small class="whythis" title="">(Why?) <span>To make sure that you&#8217;re a customer and not a computer, we ask that you answer this simple question.</span></small> </td>
              	</tr>
              	<tr>
                	<td class="main" <?php if($_GET['error']=='security_code')echo 'style="background-color:red"';?>><img src="CaptchaSecurityImages.php?width=100&height=40&characters=5" />&nbsp;&nbsp;<?php echo tep_draw_input_field('anti_spam'); ?></td>
				</tr>											
			</table></td>
		</tr>
		
		<tr>
			<td class="main" width="100%"><table>				
				<tr>
					<td class="main" align="right" width="100%"><!-- <?php echo tep_template_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE); ?> -->
						<center><button type="submit" class="btn btn-success">
						<?php echo IMAGE_BUTTON_CONTINUE; ?></button></center>
					</td>
				</tr>							
			</table></td>
		</tr>
		</form>
		<?php } 
		if($HTTP_GET_VARS['message']=='sent'){?>
		<tr>
					<td class="main" align="right" width="100%">
						<center><a href="/" class="btn btn-success">
						<?php echo IMAGE_BUTTON_CONTINUE; ?></a></center></td>
				</tr>
		<?php }
		?>
		
	</table></td>
</tr>
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
</table>
</div>