<?php
/**
 * API to deactivate deal
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
$deal_id = e($_POST["id"]);


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

if (!check_deal_id_is_valid($deal_id)){
    $response["return"] = false;
    $response["message"] = "Inactive or invalid deal";
    json($response);
}

Db::update("deals",array(
    "active" => "n"
),array("id" => $deal_id),array("="));

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "deal deactivated successfully";
}else{
    $response["return"] = false;
    $response["message"] = "Failed to deactivate deal";
}
json($response);