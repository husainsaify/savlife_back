<?php
/**
 * API to search donor
 */

$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey","username","id"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$admin_username = e($_POST["username"]);
$donor_id = e($_POST["id"]);


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

$result = Db::fetch("user",array(
    "id" => $donor_id
),array("="));

if (empty($result)){
    $response["return"] = false;
    $response["message"] = "No donor found with this Donor Id";
    json($response);
}

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "success";
    $response["data"] = $result;
}else{
    $response["return"] = false;
    $response["message"] = "No donor found with this Donor Id";
}
json($response);