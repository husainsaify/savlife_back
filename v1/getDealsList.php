<?php
/**
 * API file to get list of deals
 */
$response = array();
require_once "../inc/Config.php";

/*
    In this api the encrypted key is Id
*/
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

$q = Db::query("SELECT `id`,`lab_name`,`image` AS `img`,`description`,`off` FROM `deals` WHERE `active`=? ORDER BY `off` DESC",array("y"));

//check
if ($q->rowCount() <= 0) {
    $response["return"] = true;
    $response["message"] = "OPPS! no new deals found. Stay tuned we get some amazing deals for you";
    $response["count"] = 0;
    $response["data"] = array();
    json($response);   
}

//show all the details of user
if (!Db::getError()) {
    $response["return"] = true;
    $response["message"] = "success";
    $response["count"] = $q->rowCount();
    $response["data"] = $q->fetchAll(PDO::FETCH_ASSOC);
}else{
    $response["return"] = false;
    $response["message"] = "OPPS! it seems our servers are two busy. Try again later";
}
json($response);