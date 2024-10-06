<?php
    include '../../../config/function.php';

    echo  "Success"; //This is a simple
    $data = isset( $_GET['data'] ) ? $_GET['data'] : '';
    $decodeddata = base64_decode( $data );

    $json_string = substr($decodeddata, strpos($decodeddata, '{'));

    // Decode the JSON string
    $response = json_decode($json_string, true);
    
    if($response['status'] !== 'COMPLETE'){
        echo "transaction failed";
    }

    $message = $response['signed_field_names'];

    $array = explode(",", $message);
    $signaturemessage = "";
    foreach ($array as $value) {
        $signaturemessage = $signaturemessage.$value.'='.$response[$value].',';
    }
    $signaturemessage = rtrim($signaturemessage, ',');

    $secret = "8gBm/:&EnhH.1/q";
    $s = hash_hmac('sha256', "$signaturemessage", $secret, true);
    $signature = base64_encode($s);

    echo '<br>';
    if ($signature == $response['signature']) {
        redirect('../../medicine.php','Your Order has been submitted.');
    }
?>