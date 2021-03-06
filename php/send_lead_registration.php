<?php
/**
* Follow Up Boss API examples.
*
* Sends a lead into Follow Up Boss when they submit a general lead capture form
* on a website or in a mobile app. This can be used with any form such as:
*   - Registration on an IDX website
*   - Tips for buying your first home
*   - Receive a free market report
*
* @link https://api.followupboss.com/api-documentation/
*/

// API key for demo account, replace with your own API key
$apiKey = '7a5bad2cf150b388a7ecf1dca94d5e2d14694a';

// event data
$data = array(
    "source" => "MyAwesomeWebsite.com",
    "type" => "Registration",
    "person" => array(
        "firstName" => "John",
        "lastName" => "Smith",
        "emails" => array(array("value" => "john.smith@example.com")),
        "phones" => array(array("value" => "555-555-5555")),
        "tags" => array("Free Market Report")
    )
);

// init cURL
$ch = curl_init('https://api.followupboss.com/v1/events');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ':');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// depending on your system, you may need to specify CA bundle file
// cURL CA bundle can be downloaded from http://curl.haxx.se/ca/cacert.pem
//curl_setopt($ch, CURLOPT_CAINFO, '/path/to/ca-bundle.crt');

// make API call
$response = curl_exec($ch);
if ($response === false) {
    exit('cURL error: ' . curl_error($ch) . "\n");
}

// check HTTP status code
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($code == 201) {
    echo "New contact created.\n";
} elseif ($code == 200) {
    echo "Existing contact updated.\n";
} else {
    echo "Error, status code: {$code}\n";
}

// dump response
if ($response) {
    $response = json_decode($response);
    var_dump($response);
}

?>