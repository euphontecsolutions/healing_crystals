<?php
require('includes/application_top.php');
$slider_id = $_GET['slider_id'];
$select = "SELECT * FROM `intro_slider` WHERE `is_id` = '".$slider_id."'";
$row = tep_db_query($select);
$array=tep_db_fetch_array($row);
sdsd
?>
<html>
	<head>
		<title>slider frame</title>
		<style>
		</style>
	</head>
	<body>
	<?= $array['is_text']; ?>
	</body>
</html>