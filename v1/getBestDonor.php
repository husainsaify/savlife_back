<?php
/**
 * API file to get
 * 50 random donors from city
 */
$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey","mobile","city"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$mobile = e($_POST["mobile"]);
$city = e(strtolower($_POST["city"]));

//check api key
if (!validate_key($apikey,$mobile)){
    $response["return"] = false;
    $response["message"] = "Invalid key. Unauthorised access";
    json($response);
}

/*
 * Check mobile number is active or not
 * --
 * only allow active numbers to update location
 * */
if (!is_mobile_number_registered($mobile,true)){
    $response["return"] = false;
    $response["message"] = "Inactive or invalid number";
    json($response);
}

$q = Db::query("SELECT `id`,`fullname`,`img_thumb` AS `img`,`blood` FROM `user` WHERE `city`=? AND `active`='y' ORDER BY RAND() LIMIT 100",array($city));

if (Db::getError()){
    $response["return"] = false;
    $response["message"] = "OOPS! Failed to get featured donor. Try again";
    json($response);
}

//message when no donors where found
if ($q->rowCount() <= 0){
    $response["return"] = true;
    $response["message"] = "No donors found for {$city}. Try another city";
    $response["count"] = 0;
    $response["data"] = array();
    json($response);
}

$response["return"] = true;
$response["message"] = "success";
$response["count"] = $q->rowCount();
$response["data"] = $q->fetchAll(PDO::FETCH_ASSOC);
json($response);
