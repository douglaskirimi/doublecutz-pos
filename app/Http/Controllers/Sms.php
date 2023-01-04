<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Sms 
{
    public $phone;
   public static function send($phone,$body)
    {
        if(substr( $phone, 0, 1 ) ==0){
            $phone='254'.substr( $phone, 1, 9 );
        }
     //  die($phone);

        $url = "http://bulksms.mobitechtechnologies.com/api/sendsms";
        //die($phone);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
           "Content-Type: application/json",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = <<<DATA
          {
                              "api_key":"5cfcaadcf19e0",
                                "username":"justus",
                                "sender_id":"PAYLIFE",
                                "message":"$body",
                                "phone":"$phone"
          }
        DATA;
        //print_r ($data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        //die(var_dump($resp));

       //return true;

        }
}
