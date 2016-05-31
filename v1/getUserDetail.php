<?php
/**
 * API to get details of user
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

//check user is active
if (!is_mobile_number_registered($mobile,true)){
    $response["return"] = false;
    $response["message"] = "Invalid or inactive user";
    json($response);
}

$q = Db::query("SELECT `id`,`fullname`,`img`,`mobile`,`gender`,`age`,`blood`,`city` FROM `user` WHERE `mobile`=? AND `active`=?",array($mobile,"y"));

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "success";
    $response["data"] = $q->fetchAll(PDO::FETCH_ASSOC);
}else{
    $response["return"] = false;
    $response["message"] = "OOPS!! failed to get user details. try again later";
}
json($response);