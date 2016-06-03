<?php
/**
 * API to upload profile pic
 */

$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey","mobile","img"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$mobile = e($_POST["mobile"]);
$image = e($_POST["img"]);

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
//decode the image and upload it
$decodeimage = base64_decode($image);

$filename = "PROFILE_IMG_".time().".jpg";

//make a dir if not exits
if(!file_exists("../pic/{$mobile}")){
    mkdir("../pic/{$mobile}");
}
//upload image
file_put_contents("../pic/{$mobile}/{$filename}",$decodeimage);
$image_url = "pic/{$mobile}/$filename";

//compress image
//Create a thumbnail of the image
$image_size = getimagesize("../".$image_url);
$image_width = $image_size[0];
$image_height = $image_size[1];
$new_size = ($image_width + $image_height) / ($image_width * ($image_height / 45));
$new_width = $image_width * $new_size;
$new_height = $image_height * $new_size;
$new_image = imagecreatetruecolor($new_width, $new_height);
$old_image = imagecreatefromjpeg("../".$image_url);
imagecopyresized($new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
//create name for image thumbnail
$imageThumb = "pic/{$mobile}/THUMB_".$filename;
imagejpeg($new_image,"../".$imageThumb);

//update user
Db::update("user",array(
    "img" => $image_url,
    "img_thumb" => $imageThumb
),array(
     "mobile" => $mobile
),array("="));

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "Photo uploaded successfully";
}else{
    $response["return"] = false;
    $response["message"] = "Failed to upload profile picture";
}
json($response);