<?php
if(!($_POST) || !(isset($_POST["name"])
                && isset($_POST["org"])
                && isset($_POST["email"])
                && isset($_POST["cm"])
                && isset($_POST["phone"])
                && isset($_POST["comment"])
)) {
    echo "Mising Fields";
    exit();
}

header('Access-Control-Allow-Origin: *');

$origin_name = $_POST["name"];
$origin_org = $_POST["org"];
$origin_address = $_POST["email"];
$origin_preference = $_POST["cm"];
$origin_phone = $_POST["phone"];
$origin_message = $_POST["comment"];

$service_id = uniqid();

date_default_timezone_set('America/Chicago');
$origin_datetime = date('m/d/Y h:i:s a', time());

$to = $origin_address;
$subject ='Prime Solutions Biomedical ' . '[Service ID:' . $service_id .']';
$message = 
    'Thank you for reaching out to us, a staff member will be in contact with you shortly.' . "\r\n" .
    'A copy of your contact request has been provided below: ' . "\r\n\n" .
    'Submission recieved ' . $origin_datetime . "\r\n" .
    'Name: ' . $origin_name . "\r\n" .
    'Organization: ' . $origin_org . "\r\n" .
    'Email: ' . $origin_address . "\r\n" .
    'Contact Preference: ' . $origin_preference . "\r\n" .
    ((strcmp("N/A", $origin_phone) == 0) ? '' : 'Phone: ' . $origin_phone . "\r\n") .
    'Comments: ' . $origin_message . "\r\n";
$headers = 
    'From : noreply@psbiomedical.com' . "\r\n" .
    'Content-Type: text/plain; charset=utf-8' . "\r\n" .
    'Bcc : vineyadrian@gmail.com';

if(mail($to, $subject, $message, $headers)) {
    echo "Thank you for contacting us ${origin_name}\nA copy of this form has been sent to your email.";
} else {
    echo "E: Apologies, there was an issue while processing.\nPlease try again later.";
}