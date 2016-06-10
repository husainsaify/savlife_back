<?php
/**
 * api to check bill date
 */
$response = array();
require_once "../inc/Config.php";

$today_date = date("d/m/Y",time());
$today_date = strtotime($today_date);
//fetch next bill date from db
$q = Db::query("SELECT * FROM `next_bill_date`",array());
$dat = $q->fetchAll(PDO::FETCH_ASSOC);
$next_bill_date = strtotime($dat[0]["date"]);

if ($today_date > $next_bill_date){
    $response["return"] = false;
    $response["message"] = "Please pay your bill";
}else{
    $response["return"] = true;
    $response["message"] = "Bill paid till {$dat[0]["date"]}";
}
json($response);