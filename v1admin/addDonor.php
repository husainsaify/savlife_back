<?php
/**
 * ADMIN api to add user
 */
$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey",
    "username",
    "fullname",
    "mobile",
    "gender",
    "age",
    "blood",
    "city"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$admin_username = e($_POST["username"]);
$fullname = e($_POST["fullname"]);
$mobile = e($_POST["mobile"]);
$gender = e($_POST["gender"]);
$age = e($_POST["age"]);
$blood = e($_POST["blood"]);
$city = e($_POST["city"]);


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

//check mobile number is not already registered
if (is_mobile_number_registered($mobile,true)){
    $response["return"] = false;
    $response["message"] = "Mobile number is already registered";
    json($response);
}


if (strlen($mobile) != 10){
    $response["return"] = false;
    $response["message"] = "Invalid mobile number";
    json($response);
}

if ($gender != "male" AND $gender != "female"){
    $response["return"] = false;
    $response["message"] = "Invalid gender";
    json($response);
}

Db::insert("user",array(
    "fullname" => $fullname,
    "mobile" => $mobile,
    "gender" => $gender,
    "age" => $age,
    "blood" => $blood,
    "city" => $city,
    "verified_otp" => "y",
    "active" => "y",
    "created_at" => time()
));

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "Donor added successfully";
}else{
    $response["return"] = false;
    $response["message"] = "OOPS!! failed to add donor try again later";
}
json($response);