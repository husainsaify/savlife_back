<?php
/**
 * APi file to get details of a particular donor
 */
$response = array();
require_once "../inc/Config.php";

/*
    In this api the encrypted key is Id
*/
//check verified param
$param = check_required_param(array("apikey","id"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$id = e($_POST["id"]);

//check api key
if (!validate_key($apikey,$id)){
    $response["return"] = false;
    $response["message"] = "Invalid key. Unauthorised access";
    json($response);
}

$q = Db::query("SELECT * FROM `user` WHERE `id`=?",array($id));

//check
if ($q->rowCount() != 1) {
    $response["return"] = false;
    $response["message"] = "Invalid or inactive user";
    json($response);   
}

//show all the details of user
if (!Db::getError()) {
    $response["return"] = true;
    $response["message"] = "success";
    $response["data"] = $q->fetchAll(PDO::FETCH_ASSOC);
}else{
    $response["return"] = false;
    $response["message"] = "OPPS! it seems our servers are two busy. Try again later.";
}
json($response);