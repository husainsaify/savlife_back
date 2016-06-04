<?php
/*
 * CLASS TO SEND OTP MESSAGE TO PHONE NUMBER
 * */
class SendOtp{
    function __construct(){
    }

    public static function send($mobile,$otp,$isOtp = true){

        //Your message to send, Add URL encoding here.

        //if $isOtp is true means its an OTP message
        if ($isOtp){
            $message = urlencode("Hello! Welcome to SavLife. Your OTP is : {$otp}");
        }else{
            //else its an normal message
            $message = urlencode($otp);
        }


        //Prepare you post parameters
        $postData = array(
            'authkey' => MSG91_AUTH_KEY,
            'mobiles' => $mobile,
            'message' => $message,
            'sender' => MSG91_SENDER_ID,
            'route' => MSG91_ROUTE
        );


        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => MSG91_API_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));


        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        //get response
        curl_exec($ch);

        //Print error if any
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
            exit();
        }

        curl_close($ch);
    }
}