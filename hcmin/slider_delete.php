<?php 
require('includes/application_top.php');
require('includes/configure.php');
if(isset($_POST["delete"]))
{
	$v=$_POST['imgdel'];
	 $delete =tep_db_query("select * from info_slider where id='".$v."'");
	 $delete_array = tep_db_fetch_array($delete);

	
unlink("images/". $delete_array['file_name']);
tep_db_query("delete  from info_slider where id='".$delete_array['id']."'");
  header("location:slider_info.php");


}





?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/menu.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">
	.container {
		display: flex;
		flex-direction: row;
		justify-content: flex-start;
	}

	.side_bar {
		flex-grow: 1;
		width: 0%;
		margin-right: 1%;
	}

	.box_large {
		flex-grow: 1;
		margin:1%;
		padding: 1%;
	}

	.add_sliders {
		min-height: 20vh;
		height: auto;
		width:55vw;
		border: 1px solid black;
		display: flex;
		justify-content: center;
		align-items: center;
		margin:5px;
	}

	.imggru {
		height: 100px;
		width: 100px;
		display: none;
	}

</style>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
	$( function() {
	$( "#sortable" ).sortable();
	$( "#sortable" ).disableSelection();
	} );
</script>
</head>
<script language="Javascript1.2">
</script>
<body OnLoad="init()" marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<div class="container">

	<div class="side_bar">
		<table border="0">
		  <tr>
		    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0"  cellspacing="1" cellpadding="1" class="columnLeft">
		<!-- left_navigation //-->
		<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
		<!-- left_navigation_eof //-->
		    </table></td>
		<!-- body_text //-->
		    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
		      <tr>
		        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
		          <tr>
		            
		            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
		          </tr>
		        </table></td>
		      </tr>
		  </table>
		</td>
		</tr>
		</table>
	</div>
	<div class="box_large">

		
<div>

			<h1>Add Slides Here</h1>
			<br>
			<h3>edit content</h3>
		</div>
		


<div class="csk">

                        
                                            







		</div>
		
	
	</div>
</div>
<script>
	$('#imcimg0').hide();
</script>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
<script>
	
function readURL(input,num) {

  if (input.files && input.files[0]) {
    var reader  = new FileReader();
    reader.onload = function(e) {
      $('#imcimg'+num).attr('src', e.target.result);
      $('#imcimg'+num).show();
    }

    reader.readAsDataURL(input.files[0]);
  }
}
$("#imgInp").change(function() {
  readURL(this);
});

function appender() {

	var ping  = $('form.slider_form').children().last().attr('id');
	var numer = ping.slice(10);
	var num = parseInt(numer);
	num +=1;
	

	$('.submit_button').remove();
	$('.slider_form').append('<div class="add_sliders" id="can_change'+num+'"><label for="file"  class="file__heal_02">Image : </label><img id="imcimg'+num+'" style="height: 100px;width: 100px;" src="#" alt="your image" /><input type="file" name="file_heal_'+num+'"  onchange="readURL(this,'+num+');"><label for="title" class="title_heal_01">Title : </label><input type="textarea" name="text_heal_'+num+'"></div>');
	$('#imcimg'+num).hide();
	$('.slider_form').append('<div class="submit_button" id="cad_charge'+num+'"><button type="submit">Submit</button></div>');

}



</script>


</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

