<?php
/**
 * Class to verify OTP code
 * of user
 */

$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey","mobile","otp"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$mobile = e($_POST["mobile"]);
$otp = e($_POST["otp"]);

//check api key
if (!validate_key($apikey,$mobile)){
    $response["return"] = false;
    $response["message"] = "Invalid key. Unauthorised access";
    json($response);
}

if (!validate_mobile_number($mobile)){
    $response["return"] = false;
    $response["message"] = "Invalid mobile number";
    json($response);
}

if (strlen($otp) != 4){
    $response["return"] = false;
    $response["message"] = "Invalid otp code";
    json($response);
}

$count = Db::rowCount("user",array(
    "mobile" => $mobile,
    "otp" => $otp
),array("=","="));

if ($count == 1){
    //valid otp
    Db::update("user",array(
        "verified_otp" => "y",
        "active" => "y"
    ),array(
        "mobile" => $mobile
    ),array(
        "="
    ));

    //get user details
    $user = Db::fetch("user",array(
        "mobile" => $mobile
    ),array(
        "="
    ));

    $response["return"] = true;
    $response["message"] = "Success";
    $response["data"] = $user;
}else{
    $response["return"] = false;
    $response["message"] = "Invalid otp code";
}
json($response);