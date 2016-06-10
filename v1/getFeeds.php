<?php
/**
 * API file to get list of deals
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

//check mobile is active
if (!is_mobile_number_registered($mobile,true)){
    $response["return"] = false;
    $response["message"] = "Invalid key. Unauthorised access";
    json($response);
}

$q = Db::query("SELECT feeds.id,feeds.status,feeds.img,feeds.likes,feeds.type,feeds.time,user.id AS user_id,feeds.mobile AS user_mobile,user.fullname user_fullname,user.img_thumb AS user_image
                FROM feeds
                LEFT JOIN user
                ON feeds.mobile = user.mobile
                WHERE feeds.active = ?
                ORDER BY feeds.id DESC LIMIT 100",array("y"));


if ($q->rowCount() <= 0){
    $response["return"] = false;
    $response["message"] = "OOPS!! no new feeds to show. Buck up start sharing some new content";
    json($response);
}

$data = $q->fetchAll(PDO::FETCH_ASSOC);
$i = 0;
foreach ($data as $feed){
    $feed_id = $feed["id"];
    $data[$i]["user_liked"] = check_user_likes_feed($mobile,$feed_id);
    $i++;
}


if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "success";
    $response["data"] = $data;
}else{
    $response["return"] = false;
    $response["message"] = "OOPS!! failed to load feed. Try again later";
}
json($response);