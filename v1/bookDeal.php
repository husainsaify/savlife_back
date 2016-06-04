<?php
/**
 * API to book a deal
 */

$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey","mobile","id"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$mobile = e($_POST["mobile"]);
$deal_id = e($_POST["id"]);

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

//check deal_id is valid
if (!check_deal_id_is_valid($deal_id)){
    $response["return"] = false;
    $response["message"] = "OOPS!! Invalid or inactive deal";
    json($response);
}

//check this deal is not booked by this user already
if (is_deal_booked_by_user($mobile,$deal_id)){
    $response["return"] = false;
    $response["message"] = "This deal is already booked by you";
    json($response);
}

//book this deal
Db::insert("booked_deals",array(
    "mobile" => $mobile,
    "deal_id" => $deal_id,
    "time" => time()
));

if (!Db::getError()){
    //get the deal code
    $fetch = Db::fetch("deals",array(
        "id" => $deal_id
    ),array("="));

    $deal_code = $fetch[0]["code"];
    $deal_lab_name = $fetch[0]["lab_name"];

    //send sms to the user that deal has been booked
    $message = "Hey! we are happy that you booked an deal from us\nGo to {$deal_lab_name} with Code:: {$deal_code}\nto credit your deal";
    SendOtp::send($mobile,$message,false);

    //show response
    $response["return"] = true;
    $response["message"] = "Deal Booked successfully";
}else{
    $response["return"] = false;
    $response["message"] = "OOPS!! failed to book deal. Try again later";
}
json($response);