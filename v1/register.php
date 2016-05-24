<?php
/**
 * API to register user
 *         POST
 */
$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(
    array("apikey",
        "fullname",
        "mobile",
        "gender",
        "age",
        "blood"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$fullname = e($_POST["fullname"]);
$mobile = e($_POST["mobile"]);
$gender = e($_POST["gender"]);
$age = e($_POST["age"]);
$blood = e($_POST["blood"]);

//check api key
if (!validate_key($apikey,$mobile)){
    $response["return"] = false;
    $response["message"] = "Invalid key. Unauthorised access";
    json($response);
}



//validation
if (!validate_mobile_number($mobile)){
    $response["return"] = false;
    $response["message"] = "Invalid mobile number";
    json($response);
}

//check mobile number is already registered or not
if (is_mobile_number_registered($mobile,false)){
    $response["return"] = false;
    $response["message"] = "{$mobile} already registered. Try login";
    json($response);
}

if (strlen($fullname) <= 3){
    $response["return"] = false;
    $response["message"] = "Fullname should be more then 3 characters";
    json($response);
}

if (strlen($age) > 2){
    $response["return"] = false;
    $response["message"] = "Invalid age";
    json($response);
}

if ($age < 18){
    $response["return"] = false;
    $response["message"] = "You must be 18 to register";
    json($response);
}




$otp_code = generate_otp_code();

//send otp message
SendOtp::send($mobile,$otp_code);

//insert data into db
Db::insert("user",array(
    "fullname" => $fullname,
    "mobile" => $mobile,
    "gender" => $gender,
    "age" => $age,
    "blood" => $blood,
    "otp" => $otp_code,
    "last_otp" => time(),
    "created_at" => time()
));

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "Register successfully, Verify OTP to proceed future";
}else{
    $response["return"] = false;
    $response["message"] = "Failed to register user. Try again later";
}
json($response);
