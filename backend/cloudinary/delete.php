<?php 
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
?>