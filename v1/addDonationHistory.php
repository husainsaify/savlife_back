<?php
/**
 * API to add donation history
 */

$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey","mobile","date"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$mobile = e($_POST["mobile"]);
$date = e($_POST["date"]);

//check api key
if (!validate_key($apikey,$mobile)){
    $response["return"] = false;
    $response["message"] = "Invalid key. Unauthorised access";
    json($response);
}

//check mobile number is active
if (!is_mobile_number_registered($mobile,true)){
    $response["return"] = false;
    $response["message"] = "Invalid or Inactive mobile number";
    json($response);
}

Db::insert("donation_history",array(
    "mobile" => $mobile,
    "date" => $date
));

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "Donation History added";
}else{
    $response["return"] = false;
    $response["message"] = "Failed to add donation history";
}
json($response);