<?php
/**
 * Created by PhpStorm.
 * User: husain
 * Date: 6/3/2016
 * Time: 7:30 PM
 */
$response = array();
require_once "../inc/Config.php";

//echo password_hash("test",PASSWORD_DEFAULT);
/*$api = new ApiEncrypter();
echo $api->encrypt("8962239913");*/
echo PushNotification::sendToTopic("global","hello","world",PushNotification::$TYPE_REFER_ALERT);