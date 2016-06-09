<?php
/**
 * Class to update GCM registration token
 */
//include Config file
require_once "../inc/Config.php";

$response = array();

$param = check_required_param(array("apikey","mobile","gcm_regid"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Invalid parameters";
    json($response);
}

$key = e($_POST["apikey"]);
$mobile = e($_POST["mobile"]);
$token = e($_POST["gcm_regid"]);

//check key
if (!validate_key($key, $mobile)) {
    $response["return"] = false;
    $response["message"] = "Invalid key. Unauthorized access";
    json($response);
}

//check api key
if (!validate_key($key,$mobile)){
    $response["return"] = false;
    $response["message"] = "Invalid key. Unauthorised access";
    json($response);
}

/*
 * Check mobile number is active or not
 * --
 * only allow active numbers to update location
 * */
if (!is_mobile_number_registered($mobile,true)){
    $response["return"] = false;
    $response["message"] = "Inactive or invalid number";
    json($response);
}


//update token in database
Db::update("user",array(
    "gcm_reg_id" => $token
),array("mobile" => $mobile),array("="));

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "Token updated successfully";
}else{
    $response["return"] = false;
    $response["message"] = "Failed to update token";
}
json($response);