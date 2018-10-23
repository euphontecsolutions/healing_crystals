<?php

define('API_ACCESS_KEY','AAAAbBtHP9I:APA91bG6h9qaPK5PwyTRe2l60m9VeEzMPefAqITYzk8zuLOBHB3UtmEhKlXt5tSMNZtaxImjJU73E900JXO5N-9fc_kyPZ2ZMR-w9830QskOM2qKojWrDU49lxJxeR0iM4FrB5hzMq-Y');
 $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
 // $token='1:464314122194:android:0a7cc51bad3af702';

    // $notification = [
    //         'title' =>'title',
    //         'body' => 'body of message.',
    //         // 'icon' =>'myIcon', 
    //         // 'sound' => 'mySound'
    //     ];
    //     $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

    //     $fcmNotification = [
    //         // // 'registration_id' => '', //multple token array
    //         'to' => '9c015dbd-ad61-4ad8-97f9-cc41ffd3992b',
    //         'notification' => $notification,
    //         'data' => $extraNotificationData
    //     ];

    //     $headers = [
    //         'Authorization: key=' . API_ACCESS_KEY,
    //         'Content-Type: application/json'
    //     ];


    // $ch = curl_init();

    // curl_setopt($ch, CURLOPT_URL,$fcmUrl);
    // curl_setopt($ch, CURLOPT_POST, true);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
    // $result = curl_exec($ch);
    // curl_close($ch);

    // var_dump($result);
    // echo $result;


	// $subject =  "Healing Crystals";
	// $descript = "The healing crystals test notification";
	// $user_id = '3432345';
	// sendMessage($user_id,$subject,$descript);
	function sendMessage($user_id='',$subject='',$description='',$description2=''){

		$servername = "localhost";
		$username = "healingt_euphonuser";
		$password = "S&X7jF;KV3+f";
		$dbname = "healingt_mobileapp";
		$registration_ids = array();
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$select_every_app_ids="SELECT `cma_push_token` FROM `customer_mobile_app` WHERE `cma_customers_id`='".$user_id."' ORDER BY 'cma_push_token'";

		$array_of_app_ids = $conn->query($select_every_app_ids);
		if (mysqli_num_rows($array_of_app_ids) > 0) {
			while($row = mysqli_fetch_assoc($array_of_app_ids)) {
				 array_push($registration_ids,$row['cma_push_token']);
			}

		}
		else {
			exit();
		}


		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
		// $token='1:464314122194:android:0a7cc51bad3af702';

		$notification = [
		'title' =>$subject,
		'body' => $description,
		// 'icon' =>'myIcon', 
		// 'sound' => 'mySound'
		];
		$extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

		$fcmNotification = [
		// // 'registration_ids' => '', //multple token array
		'registration_ids' => $registration_ids,
		'notification' => $notification,
		'data' => $extraNotificationData
		];


		$headers = [
		'Authorization: key=' . API_ACCESS_KEY,
		'Content-Type: application/json'
		];


		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,$fcmUrl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
		$result = curl_exec($ch);
		curl_close($ch);

		
		$sql="INSERT INTO `customer_mobile_notification`(`cn_user_id`, `cn_subject`, `cn_description`) VALUES ('".$user_id."','".$subject."','".$description2."')";


		$conn->query($sql);
		$conn->close();

	}
?>