<?php
class PushNotification{
    //type of notification send by the server
    public static $TYPE_REFER_ALERT = 0;

    public static function send($regId = array(),$title,$message,$type){
        //create data array which has $title, message & type
        $data = array(
            "title" => $title,
            "message" => $message,
            "type" => $type
        );

        $fields = array(
            "registration_ids" => $regId,
            "data" => $data
        );

        $headers = array(
            'Authorization: key=' . GCM_API_KEY,
            'Content-Type: application/json'
        );

        //init curl
        $ch = curl_init();

        //set opt
        curl_setopt($ch,CURLOPT_URL,GCM_API_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        //execute
        $result = curl_exec($ch);

        if ($result === FALSE) {
            //die('Curl failed: ' . curl_error($ch));
            return null;
        }

        //close curl
        curl_close($ch);
        return $result;
    }

    public static function sendToTopic($topic,$title,$message,$type){
        //create data array which has $title, message & type
        $data = array(
            "title" => $title,
            "message" => $message,
            "type" => $type
        );

        $fields = array(
            "to" => '/topics/'.$topic,
            "data" => $data
        );

        $headers = array(
            'Authorization: key=' . GCM_API_KEY,
            'Content-Type: application/json'
        );

        //init curl
        $ch = curl_init();

        //set opt
        curl_setopt($ch,CURLOPT_URL,GCM_API_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        //execute
        $result = curl_exec($ch);

        if ($result === FALSE) {
            //die('Curl failed: ' . curl_error($ch));
            return null;
        }

        //close curl
        curl_close($ch);
        return $result;
    }
    
}