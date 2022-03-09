<?php
// For register page 
// Connect to db
    require_once '../../connection.php';

	$respJson = [
		"error" => 'no error',
		"message" => 'default'
	];


	// Check if userid in post request exist
	if (isset($_POST['userid']) && isset($_POST['break'])
     && isset($_POST['work'])) {

		// Query to db to search for user timer
		$userid = (int)$_POST['userid'];
		$work = (int)$_POST['work'];
		$break = (int)$_POST['break'];


		// prepare query statement
		$queryUpdate = "UPDATE `heroku_6ce1a7fbfb7f295`.timers 
        SET work = $work, break = $break
        WHERE user_id = $userid";

		// execute query
		$resultUpdate = mysqli_query($conn,$queryUpdate);

		// If update failed -> return update failed
		if (!$resultUpdate) {
			//close db connection
			$respJson["message"] = 'Update timer failed';
            $respJson["error"] = "".mysqli_error($conn);

            mysqli_close($conn);

			echo json_encode($respJson);
			exit();
		}

		// If update successful -> return update successful
		mysqli_close($conn);

		$respJson["message"] = 'Update timer succesfully';
		echo json_encode($respJson);
	}
	
?>