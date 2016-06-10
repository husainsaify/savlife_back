<?php
/**
 * Api to get next bill date
 */
$response = array();
require_once "../inc/Config.php";
//fetch next bill date from db
$q = Db::query("SELECT * FROM `next_bill_date`",array());
$dat = $q->fetchAll(PDO::FETCH_ASSOC);
$next_bill_date = $dat[0]["date"];

echo "Next bill date is ".$next_bill_date;