<?php
/**
 * API to perform login
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

//check mobile number is registered or not
if (!is_mobile_number_registered($mobile,false)){
    $response["return"] = false;
    $response["message"] = "{$mobile} is not registered with SavLife. Try registration";
    json($response);
}

/*
 * wait for 2 minutes to send new OTP
 * */

//get last send OTP time stamp
$otp_query = Db::query("SELECT `last_otp` FROM `user` WHERE `mobile`=? LIMIT 1", array($mobile));
$otp_fetch = $otp_query->fetchAll(PDO::FETCH_ASSOC);

/*
 * If row count is equal to 1 means an otp code has been send to the user
 * */
if ($otp_query->rowCount() == 1) {
    //get the last timestamp when OTP was send
    $last_otp_send_timestamp = $otp_fetch[0]["last_otp"];

    //wait for 2 min to send new otp
    if ($last_otp_send_timestamp < time() - 120) {

        //generate otp
        $otp_code = generate_otp_code();

        //send otp message
        SendOtp::send($mobile,$otp_code,true);

        //update otp code
        Db::update("user",array(
            "otp" => $otp_code,
            "verified_otp" => "n",
            "active" => "n"
        ),array(
            "mobile" => $mobile
        ),array(
            "="
        ));

        if (!Db::getError()){
            $response["return"] = true;
            $response["message"] = "OTP Send Successfully";
        }else{
            $response["return"] = false;
            $response["message"] = "Failed to login. Try again later";
        }
        json($response);
    }else{
        $response["return"] = false;
        $response["message"] = "Wait for 2 minutes to send new OTP";
        json($response);
    }
}else{
    $response["return"] = false;
    $response["message"] = "OOPS!! something went wrong. Try again later";
    json($response);
}
