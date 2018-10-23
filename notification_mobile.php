<?php

	// $subject =  "Healing Crystals";
	// $descript = "The healing crystals test notification";
	// $user_id = '3432345';
	// sendMessage($user_id,$subject,$descript);
	function sendMessage($user_id='',$subject='',$description=''){

		$servername = "localhost";
        $username = "copyache_new";
        $password = ",&B.9X1G_yoC";
        $dbname = "copyache_10nov17";

        $player_ids = array();
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$find_player_id="SELECT `cma_onesignal_key` FROM `customer_mobile_app` WHERE `cma_customers_id`='".$user_id."'";
		$array_of_div_ids = $conn->query($find_player_id);
		if (mysqli_num_rows($array_of_div_ids) > 0) {
			while($row = mysqli_fetch_assoc($array_of_div_ids)) {
				 $row['cma_onesignal_key'];
				 array_push($player_ids,$row['cma_onesignal_key']);
			}

		}
		else {
			
		}

		$headings = array(
			"en" => "Healing Crystals",
			);
		$content  = array(
			"en" => $subject,
			);

		
		$fields = array(
			'app_id' => "c550f5cf-4f18-4796-9891-58a30dd755dc",
			'include_player_ids' => array("c57f07ba-3092-4ce3-a56c-d1c14c16904d"),
			'data' => array("user_id" => $user_id),
			'contents' => $content,
			'headings' => $headings
		);
		
		$fields = json_encode($fields);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);


		$sql="INSERT INTO `customer_mobile_notification`(`cn_user_id`, `cn_subject`, `cn_description`) VALUES ('".$user_id."','".$subject."','".$description."')";


		$conn->query($sql);
		$conn->close();
	}
?>