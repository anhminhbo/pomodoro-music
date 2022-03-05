<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Upload audio to Cloudinary
    // Encoded file to be base64
    $name = $_FILES['file']['name'];

    $tmp_name = $_FILES['file']['tmp_name'];
    
    $type = $_FILES['file']['type'];

    $data = file_get_contents($tmp_name);
    $base64 = 'data:audio/' . $type . ';base64,' . base64_encode($data);
   
    // Prepare to send post request via curl
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

    $result = curl_exec($ch);

    // close curl resource to free up system resources
    // (deletes the variable made by curl_init)
    curl_close($ch);

    echo '<pre>';
    print_r($result);
    echo '</pre>';

    $decoded = json_decode($result);
    print_r($decoded->public_id);

    
    // Delete audio from Cloudinary
    $curTime = time();
    $apiSecret = 'RK_Ewbh3205TKxQZ6s4sWMdR3gk';
    $string = 'public_id='.$decoded->public_id.'&timestamp='.$curTime.$apiSecret;
    $apiKey = '483316968652276';
    $signature = hash('sha256',$string);
    echo $string.'<br>';
    echo $signature;
        // Prepare to send post request via curl
    $ch1 = curl_init();
    $post = [
            'public_id' => $decoded->public_id,
            'signature' =>$signature,
            'api_key' => '483316968652276',
            'timestamp' => ''.$curTime,
    ];

    $url = "https://api.cloudinary.com/v1_1/hcgh6liyq/video/destroy";

    curl_setopt($ch1,CURLOPT_URL, $url);
    curl_setopt($ch1,CURLOPT_POSTFIELDS, http_build_query($post));
    curl_setopt($ch1,CURLOPT_POST, true);
    curl_setopt($ch1,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch1,CURLOPT_HTTPHEADER, array(
        'Content-Type:multipart/form-data'
    ));
    
    $result1 = curl_exec($ch1);
    
    echo '<pre>';
    print_r($result1);
    echo '</pre>';

    // close curl resource to free up system resources
    // (deletes the variable made by curl_init)
    curl_close($ch1);


}
