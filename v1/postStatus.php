<?php
/**
 * API to post text & photo status
 */
$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey","mobile","status"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$mobile = e($_POST["mobile"]);
$status = e($_POST["status"]);

//check api key
if (!validate_key($apikey,$mobile)){
    $response["return"] = false;
    $response["message"] = "Invalid key. Unauthorised access";
    json($response);
}

//check mobile number is active
if (!is_mobile_number_registered($mobile,true)){
    $response["return"] = false;
    $response["message"] = "Invalid or Inactive mobile number";
    json($response);
}

/*
 * When image var is set upload image and set its url in the $image_url
 * */
$image_url = "";
if (isset($_POST["img"])){
    $image = e($_POST["img"]);

    //decode the image and upload it
    $decodeimage = base64_decode($image);

    $filename = "FEED_IMG_".time().".jpg";

    //make a dir if not exits
    if(!file_exists("../pic/{$mobile}")){
        mkdir("../pic/{$mobile}");
    }
    //upload image
    file_put_contents("../pic/{$mobile}/{$filename}",$decodeimage);
    $image_url = "pic/{$mobile}/{$filename}";
}

if (empty($image_url) && empty($status)){
    $response["return"] = false;
    $response["message"] = "Invalid or empty status";
    json($response);
}

/*
 * Determine type of feed
 * 0 = status
 * 1 = image
 * */
if (empty($image_url)){
    $type = 0;
}else{
    $type = 1;
}

//add status to database
Db::insert("feeds",array(
    "mobile" => $mobile,
    "status" => $status,
    "img" => $image_url,
    "type" => $type,
    "time" => time(),
));

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "Post uploaded successfully";
}else{
    $response["return"] = false;
    $response["message"] = "Failed to post";
}
json($response);
