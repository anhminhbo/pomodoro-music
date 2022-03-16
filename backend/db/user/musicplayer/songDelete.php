<?php 

    $respJson = [
        "error" => 'no error',
        "message" => 'default'
    ];

    if(isset($_POST['userid']) && $_POST['deletePublic'] && $_POST['songid']) {
    $userid = (int) $_POST['userid'];
    $deletePublic = $_POST['deletePublic'];
    $songid = (int) $_POST['songid'];


    // Delete audio from Cloudinary
    $curTime = time();
    $apiSecret = 'RK_Ewbh3205TKxQZ6s4sWMdR3gk';
    $string = 'public_id='.$deletePublic.'&timestamp='.$curTime.$apiSecret;
    $apiKey = '483316968652276';
    $signature = hash('sha256',$string);

        // Prepare to send post request via curl
    $ch = curl_init();
    $post = [
            'public_id' => $deletePublic,
            'signature' =>$signature,
            'api_key' => '483316968652276',
            'timestamp' => ''.$curTime,
    ];

    $url = "https://api.cloudinary.com/v1_1/hcgh6liyq/video/destroy";

    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($post));
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_HTTPHEADER, array(
        'Content-Type:multipart/form-data'
    ));
    
    $resultDeleteCloudinary = curl_exec($ch);


    // close curl resource to free up system resources
    // (deletes the variable made by curl_init)
    curl_close($ch);
    
    $decodedResultDeleteCloudinary = json_decode($resultDeleteCloudinary);
    
    // If delete Cloudinary not success
    if (!$decodedResultDeleteCloudinary->result == "ok") {
        $respJson["message"] = 'Delete song failed';
        $respJson["error"] = $decodedResultDeleteCloudinary->error->message;
        echo json_encode($respJson);
        exit();
    }

    // Connect to db
    require_once '../../connection.php';

    $queryDelete = "DELETE FROM `heroku_6ce1a7fbfb7f295`.songs 
    WHERE id = $songid";

    $resultDelete = mysqli_query($conn,$queryDelete);

    // If delete song in Db failed
    if (!$resultDelete) {
        $respJson["message"] = 'Delete song failed';
        $respJson["error"] = "".mysqli_error($conn);
        mysqli_close($conn);
        echo json_encode($respJson);
        exit();
    }


    mysqli_close($conn);
    $respJson["message"] = 'Delete song successfully';
    echo json_encode($respJson);
    }

?>