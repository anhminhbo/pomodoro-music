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

		// Query to db to search for user playlist
		$userid = (int)$_POST['userid'];

		// $userid = 1;


		// prepare query statement
		$querySelect = "SELECT * FROM `heroku_6ce1a7fbfb7f295`.songs 
		WHERE user_id = $userid LIMIT 20";

		// execute query
		$resultSelect = mysqli_query($conn,$querySelect);

		// If no playlist -> return error
		if (mysqli_num_rows($resultSelect) == 0) {
			//close db connection when finished
			mysqli_close($conn);
			$respJson["message"] = 'Fetch playlist failed';
			$respJson["error"] = 'No playlist exists';

			echo json_encode($respJson);
			exit();
		}

		// If playlist exists -> return playlist to client
		// Prepare query

		$respJson["playlist"] = array();
        while($row = mysqli_fetch_assoc($resultSelect)) {
			$modifiedRow = [
				"id" => $row["id"],
				"deletePublic" => $row["public_id"],
				"path" => $row["song_url"],
				"title" => $row['title'],
				"singer" => $row["singer"]
			];
			array_push($respJson["playlist"],$modifiedRow);
        }

		mysqli_close($conn);

		$respJson["message"] = 'Playlist exists';
		echo json_encode($respJson);
	}
	
?>