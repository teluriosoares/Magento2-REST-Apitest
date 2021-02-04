<?php

const STORE_URL = "https://lumistore.boostcommerce.com.br/";
const USER = "jn2";
const PASSWORD = "43pmxJocL59z";

function get_token() {
  // Connect
  $userData = array("username" => USER, "password" => PASSWORD);
  $ch = curl_init(STORE_URL."rest/V1/integration/admin/token");
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Length: " . strlen(json_encode($userData))));
  
  $token = curl_exec($ch);
  return $token;
}

function update_config($path, $value) {

        $array = [
          'path' =>  $path,
          'value' => $value
        ];

        $params = json_encode($array);

        $token = get_token();
        
      // PUT
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => STORE_URL."rest/default/V1/jn2-configapi/storeconfig",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "PUT",
          CURLOPT_POSTFIELDS => $params,
          CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "content-type: application/json",
            "authorization: Bearer " . json_decode($token),
          ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

}

update_config("payment/mestremagedc/active", 0);