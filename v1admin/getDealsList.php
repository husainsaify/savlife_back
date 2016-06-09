<?php
/**
 * ADMIN api to get deals list
 */
$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey",
    "username"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$admin_username = e($_POST["username"]);


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

$q = Db::query("SELECT booked_deals.id,booked_deals.mobile,booked_deals.time,deals.lab_name FROM booked_deals
                LEFT JOIN deals
                ON booked_deals.deal_id = deals.id
                ORDER BY booked_deals.time DESC",array(""));

if ($q->rowCount() <= 0) {
    $response["return"] = false;
    $response["message"] = "No Deals booked yet";
    json($response);
}

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "success";
    $response["data"] = $q->fetchAll(PDO::FETCH_ASSOC);
}else{
    $response["return"] = false;
    $response["message"] = "Failed. Try again later";
}
json($response);