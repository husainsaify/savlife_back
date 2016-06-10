<?php
/**
 * API to send push notification to server
 */
$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey","username","title","message"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$admin_username = e($_POST["username"]);
$title = e($_POST["title"]);
$message = e($_POST["message"]);


//check api key
if (!validate_key($apikey,$admin_username)){
    $response["return"] = false;
    $response["message"] = "Invalid key. Unauthorised access";
    json($response);
}

//check username is register
if (!check_admin_username_registered($admin_username)){
    $response["return"] = false;
    $response["message"] = "Invalid or inactive admin";
    json($response);
}

//send push notification
PushNotification::sendToTopic("global",$title,$message,PushNotification::$TYPE_REFER_ALERT);
$response["return"] = true;
$response["message"] = "Push notification send successfully";
json($response);