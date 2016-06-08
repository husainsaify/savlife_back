<?php
/**
 * ADMIN api to add deals
 */
$response = array();
require_once "../inc/Config.php";

//check verified param
$param = check_required_param(array("apikey",
    "username",
    "lab_name",
    "code",
    "description",
    "orginal_price",
    "special_price"),"post");

if (!$param){
    $response["return"] = false;
    $response["message"] = "Required parameters not passed";
    json($response);
}

$apikey = e($_POST["apikey"]);
$admin_username = e($_POST["username"]);
$lab_name = e($_POST["lab_name"]);
$code = e($_POST["code"]);
$description = e($_POST["description"]);
$original_price = e($_POST["orginal_price"]);
$special_price = e($_POST["special_price"]);


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

//check code
if (strlen($code) != 6){
    $response["return"] = false;
    $response["message"] = "Code should be of 6 characters";
    json($response);
}

//check $special is not more then original
if ($special_price > $original_price){
    $response["return"] = false;
    $response["message"] = "Special price cannot be bigger then original price";
    json($response);
}

//check user has send an image or nota
$image_url = "";
if (isset($_POST["img"])){
    $img = e($_POST["img"]);
    //decode the image and upload it
    $decodeimage = base64_decode($img);

    $filename = "DEAL_IMG_".time().".jpg";

    //make a dir if not exits
    if(!file_exists("../pic/{$admin_username}")){
        mkdir("../pic/{$admin_username}");
    }

    //upload image
    file_put_contents("../pic/{$admin_username}/{$filename}",$decodeimage);
    $image_url = "pic/{$admin_username}/$filename";
}

//calculate off percentage
$off = ($original_price - $special_price) / $original_price * 100;

Db::insert("deals",array(
    "lab_name" => $lab_name,
    "code" => $code,
    "image" => $image_url,
    "description" => $description,
    "orginal_price" => $original_price,
    "special_price" => $special_price,
    "off" => $off,
    "active" => "y",
    "time" => time()
));

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "deal added successfully";
}else{
    $response["return"] = false;
    $response["message"] = "Failed to add deal. Try again later";
}
json($response);