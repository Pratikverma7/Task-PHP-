<?php
$phone_number = "913XXXXXXx7993";
$customer_id = "C257EEBF-7290-46A1-XXXXx-E1C6CFXXXXXXXXX2";
$api_key = "2egC4ZguCcTpzg0yXXXXXXXXXXXX90W9MwvXXXXXXXXXXXXXXXXXXXXrQtYzLtvXIkKCMvk+AoWFg==";
var_dump(isValidPhoneNumber($phone_number, $customer_id, $api_key));

function isValidPhoneNumber($phone_number, $customer_id, $api_key) 
{
    $api_url = "https://rest-ww.telesign.com/v1/phoneid/$phone_number";
    
    $ch = curl_init($api_url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Basic " . base64_encode("$customer_id:$api_key"),
            "Content-Type: application/x-www-form-urlencoded"
        ]
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

   
    if ($http_code !== 200 || !$response) return false;

    $data = json_decode($response, true);

    return in_array($data['numbering']['phone_type'] ?? '', ["FIXED_LINE", "MOBILE", "VOIP", "PREPAID"], true);
}

?>