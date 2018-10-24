<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script
  src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
  $(document).ready( function () {
    $('#customers').DataTable();
} );
</script>
<style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}
</style>
</head>
<body>
<?php

define("base_url", "http://test.healingcrystals.com/"); 
define("api_path", "api_tracker/"); 

if(function_exists($_GET['fn'])){
	//$_GET['fn']();
//	die('gg');
	if($_GET['ar']){
	    $_GET['fn']($_GET['ar']);
	}else{
	    $_GET['fn']();
	}
}
// Defining function

 
 
function user(){ 
    $servername = "localhost";
        $username = "healingt_euphonuser";
        $password = "S&X7jF;KV3+f";
        $dbname = "healingt_mobileapp";
        echo '<pre>';
        $categoryArr=array();
	$categoryArr['status']='Success';
	$categoryArr['error']="";
	$categoryArr['data']=array();

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    ?>
      


<table id="customers">
<thead>
  <tr>
    <th>S.no</th>
    <th>APP ID</th>
    <th>Customer Id</th>
    <th>Location</th>
    <th>Created</th>
    <th>Token</th>
  </tr>
</thead>
<tbody>
  <?php
 
  $sql = "SELECT * FROM `customer_mobile_app`";
			$results = $conn->query($sql);
			if($results->num_rows > 0){
			    $i=1;
				while($customerArr = $results->fetch_assoc()){
				    echo '<tr>';
				    echo '<td>'.$i.'</td>';
				    echo '<td><a href="'.base_url.api_path.'?fn=user_details&ar='.$customerArr['cma_customers_app_id'].'">'.$customerArr['cma_customers_app_id'].'</a></td>';
				    echo '<td>'.$customerArr['cma_customers_id'].'</td>';
				    echo '<td>'.$customerArr['cma_customers_location'].'</td>';
				    echo '<td>'.$customerArr['cma_customers_updated'].'</td>'; 
				    echo '<td>'.$customerArr['cma_push_token'].'</td>';
				echo '</tr>';
				$i++;
				}
				
				}
				?>
  
</tbody>
</table>


<?php
}

function user_details($user_id){
     $servername = "localhost";
        $username = "healingt_euphonuser";
        $password = "S&X7jF;KV3+f";
        $dbname = "healingt_mobileapp";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
?>
   
<table id="customers">
<thead>
  <tr>
    <th>S.no</th>
    <th>APP ID</th>
    <th>Event</th>
    <th>Action</th>
    <th>Created</th>
  </tr>
</thead>
<tbody>
  <?php
   $sql = "SELECT * FROM `mobile_traceability` WHERE `mt_user_app_id` LIKE '$user_id'  ORDER By `mt_date` DESC";
			$results = $conn->query($sql);
			if($results->num_rows > 0){
			    $i=1;
				while($customerArr = $results->fetch_assoc()){
				    echo '<tr>';
				    echo '<td>'.$i.'</td>';
				    echo '<td>'.$customerArr['mt_user_app_id'].'</td>';
				    echo '<td>'.$customerArr['mt_event'].'</td>';
				    echo '<td>'.$customerArr['mt_action'].'</td>';
				    echo '<td>'.$customerArr['mt_date'].'</td>'; 
				echo '</tr>';
				$i++;
				}
				
				}
				?>
</tbody>
   
</table>
    <?php
}


function user_by_id(){
 
    $servername = "localhost";
        $username = "healingt_euphonuser";
        $password = "S&X7jF;KV3+f";
        $dbname = "healingt_mobileapp";
        echo '<pre>';
        $categoryArr=array();
	$categoryArr['status']='Success';
	$categoryArr['error']="";
	$categoryArr['data']=array();

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    ?>
      


<table id="customers">
<thead>
  <tr>
    <th>S.no</th>
    <th>APP ID</th>
    <th>Customer Id</th>
    <th>Location</th>
    <th>Created</th>
    <th>Token</th>
  </tr>
</thead>
<tbody>
  <?php
 
  $sql = "SELECT * FROM `customer_mobile_app`";
			$results = $conn->query($sql);
			if($results->num_rows > 0){
			    $i=1;
				while($customerArr = $results->fetch_assoc()){
				    echo '<tr>';
				    echo '<td>'.$i.'</td>';
				    echo '<td><a href="'.base_url.api_path.'?fn=user_details&ar='.$customerArr['cma_customers_app_id'].'">'.$customerArr['cma_customers_app_id'].'</a></td>';
				    echo '<td>'.$customerArr['cma_customers_id'].'</td>';
				    echo '<td>'.$customerArr['cma_customers_location'].'</td>';
				    echo '<td>'.$customerArr['cma_customers_updated'].'</td>'; 
				    echo '<td>'.$customerArr['cma_push_token'].'</td>';
				echo '</tr>';
				$i++;
				}
				
				}
				?>
  
</tbody>
</table>


<?php
}

?>
</body>
</html>