<?php
/**
 * API class to do admin login
 */
$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey","username","password"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$username = e($_POST["username"]);
$password = e($_POST["password"]);


//check api key
if (!validate_key($apikey,$username)){
    $response["return"] = false;
    $response["message"] = "Invalid key. Unauthorised access";
    json($response);
}

//check username is register
if (!check_admin_username_registered($username)){
    $response["return"] = false;
    $response["message"] = "Invalid or inactive admin";
    json($response);
}

$result = Db::fetch("admin",array(
    "username" => $username,
    "active" => "y"
),array("=","="));

$databasePassword = $result[0]["password"];

//check password
if (password_verify($password,$databasePassword)){
    $response["return"] = true;
    $response["message"] = "Success";
}else{
    $response["return"] = false;
    $response["message"] = "Invalid username or password";
}
json($response);


