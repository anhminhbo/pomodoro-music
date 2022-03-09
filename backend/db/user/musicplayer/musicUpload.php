<?php
// Connect to db
require_once '../../connection.php';

$respJson = [
    "error" => 'no error',
    "message" => 'default'
];

ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '100M');

if ($_POST['songTitle']&& $_POST['songSinger'
]&& isset($_POST['userid'])) {
    // Upload audio to Cloudinary
    // Encoded song upload to be base64
    $name = $_FILES['songUpload']['name'];

    $tmp_name = $_FILES['songUpload']['tmp_name'];
    echo $tmp_name;
    $type = $_FILES['songUpload']['type'];

    $data = file_get_contents($tmp_name);
    $base64 = 'data:audio/' . $type . ';base64,' . base64_encode($data);
   
    // Prepare to send post request via curl to upload song to Cloudinary
    $ch = curl_init();
    $post = [
            'file' => $base64,
            'upload_preset' => 'minh_upload',
    ];

    $url = "https://api.cloudinary.com/v1_1/hcgh6liyq/video/upload";

    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($post));
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_HTTPHEADER, array(
        'Content-Type:multipart/form-data'
    ));

    $resultUploadCloudinary = curl_exec($ch);

    // close curl resource to free up system resources
    // (deletes the variable made by curl_init)
    curl_close($ch);

    $decodedResultUploadCloudinary = json_decode($resultUploadCloudinary);


    // Insert in songs table the data from Cloudinary

    // public id is to delete audio file in cloudinary
    // secure url is to display audio in html
    $cloudinaryPublicId = $decodedResultUploadCloudinary->public_id;
    $cloudinarySecureUrl = $decodedResultUploadCloudinary->secure_url;


    $songTitle = $_POST['songTitle'];
    $songSinger = $_POST['songSinger'];
    $userid = (int)$_POST['userid'];

    $queryInsert = "INSERT INTO `heroku_6ce1a7fbfb7f295`.songs 
    (title, singer, song_url, user_id, public_id)
     values( '$songTitle','$songSinger','$cloudinarySecureUrl'
     ,$userid,'$cloudinaryPublicId')";

    $resultInsert = mysqli_query($conn,$queryInsert);

    if (!$resultInsert) {
        $respJson["message"] = 'Upload song failed';
        $respJson["error"] = "".mysqli_error($conn);
        mysqli_close($conn);
        echo json_encode($respJson);
        exit();
    }

    mysqli_close($conn);

    $respJson["fileUploadData"] = [
        'path' => $cloudinarySecureUrl,
        'deletePublic' => $cloudinaryPublicId
    ];
    
    $respJson["message"] = 'Upload song successfully';
    echo json_encode($respJson);

    // // Delete audio from Cloudinary
    // $curTime = time();
    // $apiSecret = 'RK_Ewbh3205TKxQZ6s4sWMdR3gk';
    // $string = 'public_id='.$decoded->public_id.'&timestamp='.$curTime.$apiSecret;
    // $apiKey = '483316968652276';
    // $signature = hash('sha256',$string);
    // echo $string.'<br>';
    // echo $signature;
    //     // Prepare to send post request via curl
    // $ch1 = curl_init();
    // $post = [
    //         'public_id' => $decoded->public_id,
    //         'signature' =>$signature,
    //         'api_key' => '483316968652276',
    //         'timestamp' => ''.$curTime,
    // ];

    // $url = "https://api.cloudinary.com/v1_1/hcgh6liyq/video/destroy";

    // curl_setopt($ch1,CURLOPT_URL, $url);
    // curl_setopt($ch1,CURLOPT_POSTFIELDS, http_build_query($post));
    // curl_setopt($ch1,CURLOPT_POST, true);
    // curl_setopt($ch1,CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch1,CURLOPT_HTTPHEADER, array(
    //     'Content-Type:multipart/form-data'
    // ));
    
    // $result1 = curl_exec($ch1);
    
    // echo '<pre>';
    // print_r($result1);
    // echo '</pre>';

    // // close curl resource to free up system resources
    // // (deletes the variable made by curl_init)
    // curl_close($ch1);


}
