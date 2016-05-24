<?php
/**
 * API to update user location,
 * City name,
 * latitude
 * longitude
 */

$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey","mobile","city","latitude","longitude"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$mobile = e($_POST["mobile"]);
$city = e(strtolower($_POST["city"]));
$latitude = e($_POST["latitude"]);
$longitude = e($_POST["longitude"]);

//check api key
if (!validate_key($apikey,$mobile)){
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

//update user location
Db::update("user",array(
    "city" => $city,
    "latitude" => $latitude,
    "longitude" => $longitude
),array(
    "mobile" => $mobile
),array("="));

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "User location updated successfully";
}else{
    $response["return"] = false;
    $response["message"] = "Failed to update user location";
}
json($response);