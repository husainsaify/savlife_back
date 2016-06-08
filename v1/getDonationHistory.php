<?php
/**
 * API to get donation history
 */
$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey","mobile"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$mobile = e($_POST["mobile"]);

//check api key
if (!validate_key($apikey,$mobile)){
    $response["return"] = false;
    $response["message"] = "Invalid key. Unauthorised access";
    json($response);
}

$q = Db::query("SELECT `date` FROM `donation_history` WHERE mobile = ? ORDER BY `id` DESC",array($mobile));

if ($q->rowCount() <= 0){
    $response["return"] = true;
    $response["message"] = "No donation history";
    $response["count"] = $q->rowCount();
    $response["data"] = array();
    json($response);
}

if (Db::getError()){
    $response["return"] = false;
    $response["message"] = "OOPS!! cannot perform your request. Try again later";
}else{
    $response["return"] = true;
    $response["message"] = "success";
    $response["count"] = $q->rowCount();
    $response["data"] = $q->fetchAll(PDO::FETCH_ASSOC);
}
json($response);