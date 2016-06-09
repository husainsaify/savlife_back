<?php
/**
 * ADMIN api to add deals
 */
$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey",
    "username",
    "new_username",
    "password"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$admin_username = e($_POST["username"]);
$new_username = e($_POST["new_username"]);
$password = e($_POST["password"]);


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

if (strlen($new_username) <= 4){
    $response["return"] = false;
    $response["message"] = "Username should be more then 4 characters";
    json($response);
}

if (strlen($password) <= 4){
    $response["return"] = false;
    $response["message"] = "Password should be more then 4 characters";
    json($response);
}

$password_hash = password_hash($password,PASSWORD_DEFAULT);

Db::insert("admin",array(
    "username" => $new_username,
    "password" => $password_hash,
    "active" => "y"
));

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "Admin added successfully";
}else{
    $response["return"] = false;
    $response["message"] = "Failed to add admin";
}
json($response);