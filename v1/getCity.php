<?php
/**
 * API file to get all the city
 * registered with us
 */
$response = array();
require_once "../inc/Config.php";

$all_users_q = Db::query("SELECT `city` FROM `user` WHERE `verified_otp`=? AND `active`=?",array("y","y"));
$all_users_f = $all_users_q->fetchAll(PDO::FETCH_ASSOC);

//city array
$city_array = array();
foreach ($all_users_f AS $user){
    $city = $user["city"];
    //add this city to the array if its not present
    if (!in_array($city,$city_array)){
        $city_array[] = $city;
    }
}

$response["return"] = true;
$response["message"] = "success";
$response["count"] = count($city_array);
$response["data"] = $city_array;

json($response);