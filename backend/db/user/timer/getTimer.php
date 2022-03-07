<?php
// For register page 
// Connect to db
    require_once '../../connection.php';

	$respJson = [
		"error" => 'no error',
		"message" => 'default'
	];


	// Check if userid in post request exist
	if (isset($_POST['userid'])) {

		// Query to db to search for user timer
		$userid = (int)$_POST['userid'];

		// prepare query statement
		$querySelect = "SELECT * FROM `heroku_6ce1a7fbfb7f295`.timers 
		WHERE user_id = $userid";

		// execute query
		$resultSelect = mysqli_query($conn,$querySelect);

		// If no timer exist -> return default mode 25/5
		if (mysqli_num_rows($resultSelect) == 0) {
			//close db connection when finished
			mysqli_close($conn);
			$respJson["message"] = 'Fetch timer failed';
			$respJson["error"] = 'No timer exists';

			echo json_encode($respJson);
			exit();
		}

		// If timer exists -> return last mode user was using
		// Prepare query
		$row = mysqli_fetch_assoc($resultSelect);

		mysqli_close($conn);

		$respJson["timerData"] = [
			"work" => $row["work"],
			"break" => $row["break"],
		];
		$respJson["message"] = 'Timer exists';
		echo json_encode($respJson);
	}
	
?>