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

$q = Db::query("SELECT user.id,user.fullname,user.img,user.mobile,user.gender,user.age,user.blood,user.city,donation_history.date
                FROM user LEFT JOIN donation_history
                ON user.mobile = donation_history.mobile
                WHERE user.mobile = ? AND user.active = ?
                ORDER BY donation_history.id DESC
                LIMIT 1",array($mobile,"y"));

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "success";
    $response["data"] = $q->fetchAll(PDO::FETCH_ASSOC);
}else{
    $response["return"] = false;
    $response["message"] = "OOPS!! failed to get user details. try again later";
}
json($response);