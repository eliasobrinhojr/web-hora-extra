<?php

$url = "https://7fe570a0-d561-4b3e-ba13-2111e678baa1.pushnotifications.pusher.com/publish_api/v1/instances/7fe570a0-d561-4b3e-ba13-2111e678baa1/publishes";
$key = "Bearer 63C6E1B8328259D9557038F9EEF3B3D0D808F829CF7FAF64A9A5AB3D9A52A401";
$headers = array
    (
    'Authorization: '.$key,
    'Content-Type: application/json'
);

$object = new stdClass();
$object->interests = ["extra"];
$object->fcm = array("notification" => [
                "title" => $_GET['empresa'],
                "body" => $_GET['setor'],
                "tag" => $_GET['empresa'].$_GET['setor']
            ]);



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($object));
$result = curl_exec($ch);
curl_close($ch);
//echo $result;
//echo '<hr><br>';
//echo json_encode($object);
