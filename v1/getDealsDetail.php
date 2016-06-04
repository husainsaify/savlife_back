<?php
/**
 * API to get details of details
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
$deal_id = e($_POST["id"]);

//check api key
if (!validate_key($apikey,$mobile)){
    $response["return"] = false;
    $response["message"] = "Invalid key. Unauthorised access";
    json($response);
}

$q = Db::query("SELECT `lab_name`,`image` AS `img`,`code`,`description`,`orginal_price`,`special_price`,`off` FROM `deals` WHERE `id`=? AND `active`='y'",array($deal_id));



if ($q->rowCount() != 1){
    $response["return"] = false;
    $response["message"] = "Invalid or inactive offer";
    json($response);
}

if (!Db::getError()){
    $response["return"] = true;
    $response["message"] = "Success";
    /*
     * we will check the status of this deal
     * If this deal is booked will
     * we will mark booked_status
     *      true
     * else
     *      false
     * */
    //check this deal booked by user
    if (is_deal_booked_by_user($mobile,$deal_id)){
        $booked_deal = true;
    }else{
        $booked_deal = false;
    }
    $response["data"] = $q->fetchAll(PDO::FETCH_ASSOC);
    $response["booked_deal"] = $booked_deal;
}else{
    $response["return"] = false;
    $response["message"] = "Invalid or inactive offer";
}
json($response);