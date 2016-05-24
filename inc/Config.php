<?php
//include classes
require_once dirname(__DIR__)."/class/Db.php";
require_once dirname(__DIR__)."/class/Password.php";
require_once dirname(__DIR__)."/class/SendOtp.php";
require_once dirname(__DIR__)."/class/ApiEncrypter.php";

//include function files
require_once dirname(__DIR__)."/inc/function.php";

//MSG91 (SMS Gateway)
define("MSG91_AUTH_KEY","112489AdY4qc8z0yxK5735c1cd");
define("MSG91_SENDER_ID","HAKBPL");
define("MSG91_ROUTE",4);
define("MSG91_API_URL","https://control.msg91.com/api/sendhttp.php");