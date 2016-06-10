<?php
/**
 * api to add likes
 */

$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey","mobile","id"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$mobile = e($_POST["mobile"]);
$feed_id = e($_POST["id"]);

//check api key
if (!validate_key($apikey,$mobile)){
    $response["return"] = false;
    $response["message"] = "Invalid key. Unauthorised access";
    json($response);
}

if (!validate_mobile_number($mobile)){
    $response["return"] = false;
    $response["message"] = "Invalid mobile number";
    json($response);
}

//check user has not already done a like on this feed
$count = Db::rowCount("like_table",array(
    "mobile" => $mobile,
    "feed_id" => $feed_id
),array("=","="));

if ($count != 0){
    $response["return"] = false;
    $response["message"] = "You have already liked this feed";
    json($response);
}

Db::insert("like_table",array(
    "mobile" => $mobile,
    "feed_id" => $feed_id,
    "time" => time()
));

Db::query("UPDATE `feeds` SET `likes` = likes + 1 WHERE `id`=?",array($feed_id));

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "success";
}else{
    $response["return"] = false;
    $response["message"] = "Failed to add like. Try again later";
}
json($response);