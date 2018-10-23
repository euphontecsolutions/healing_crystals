<?php
require('includes/application_top.php');
$slider_id = $_GET['slider_id'];
$select = "SELECT * FROM `intro_slider` WHERE `is_id` = '".$slider_id."'";
$row = tep_db_query($select);
$array=tep_db_fetch_array($row);

?>
<html>
	<head>
		<title>slider preview</title>
		<style>

					/* width */
			::-webkit-scrollbar {
			    width: 5px;
			}

			/* Track */
			::-webkit-scrollbar-track {
			    box-shadow: inset 0 0 5px grey; 
			    border-radius: 10px;
			}
			 
			/* Handle */
			::-webkit-scrollbar-thumb {
			    background: #808080;
			    border-radius: 5px;
			}

			/* Handle on hover */
			::-webkit-scrollbar-thumb:hover {
			    background: #808080; 
			}
			.container{
				width:75.1mm;
				height:129.38mm;
				border:10px solid #9688888a;
				border-top-width:30px;
				border-bottom-width:20px;
				border-radius: 10px;
				overflow: auto;	
			}
			.container * {
				max-width: 67.1mm;
			}
		</style>
	</head>
	<body>

	<center><h3>Iphone 7</h3>
	<div class="container">
	<?= $array['is_text'];?>
	</div>
	</center>	
	</body>
</html>