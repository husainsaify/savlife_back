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

$result_q = Db::query("SELECT user.fullname,user.img_thumb AS img,user.mobile,user.gender,user.age,user.blood,user.city,donation_history.date
                FROM user LEFT JOIN donation_history
                ON user.mobile = donation_history.mobile
                WHERE user.id = ? AND user.active = ?
                ORDER BY donation_history.id DESC
                LIMIT 1",array($donor_id,"y"));

$result = $result_q->fetchAll(PDO::FETCH_ASSOC);

if ($result_q->rowCount() <= 0){
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