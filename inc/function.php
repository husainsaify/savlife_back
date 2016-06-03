<?php
//Method to validate $variable
function e($var){
    return trim(htmlentities($var,ENT_QUOTES,"UTF-8"));
}

//method to validate mobile number
function validate_mobile_number($mobile){
    if(preg_match('/^((\+){0,1}91(\s){0,1}(\-){0,1}(\s){0,1})?([0-9]{10})$/', $mobile,$matches)){
        return true;
    }
    return false;
}

/*
 * Function to check required parameters
 * return
 * true = when all the param not set
 * false = when not set
 * */
function check_required_param($param = array(),$method){
    //set up method
    if (strtolower($method) == "post"){
        $r = $_POST;
    }else if (strtolower($method) == "get"){
        $r = $_GET;
    }
    //check of required param
    foreach ($param as $par){
        if (!isset($r[$par]) || empty($r[$par])){
            return false;
            break;
        }
    }
    return true;
}

/*
 * Method to validate email address
 * */
function validate_email($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
}

/*
 * Method to check APIKEY is valid
 * database wali api key
 * */
function check_apikey($apikey){
    $count = Db::rowCount("apikeys",array(
        "name" => $apikey
    ),array("="));

    if ($count == 1){
        return true;
    }
    return false;
}

/*
 * This method will decrypt the key and check if it matches $Mobile
 * match = true
 * did match = false
 * */
function validate_key($key,$mobile){
    $apiEncrypter = new ApiEncrypter();
    $d_key = $apiEncrypter->decrypt($key);
    return $d_key == $mobile ? true : false;
}

/*
 * function to output json
 * */
function json($response = array()){
    echo json_encode($response);
    exit;
}

/*
 * Method to check mobile number registered or not
 * returns
 * True = mobile is registered
 * false = mobile is not registered
 * */
function is_mobile_number_registered($mobile,$active){
    //check for users which are active
    if ($active == true){
        $count = Db::rowCount("user",array(
            "mobile" => $mobile,
            "active" => "y",
            "verified_otp" => "y"
        ),array(
            "=","=","="
        ));

    }else{
        //user active status dont matter
        $count = Db::rowCount("user",array(
            "mobile" => $mobile
        ),array(
            "="
        ));
    }

    return $count == 1 ? true : false;
}

/*
 * Function to generate otp code
 * */
function generate_otp_code(){
    return rand(1000,9999);
}

function check_admin_username_registered($username){
    $count = Db::rowCount("admin",array(
        "username" => $username,
        "active" => "y"
    ),array("=","="));
    return $count == 1 ? true : false;
}