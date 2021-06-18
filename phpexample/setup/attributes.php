<?php

const STORE_URL = "https://sualoja.com.br/";
const USER = "user";
const PASSWORD = "password";

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

function get_attribute_json($std) {
    $array = [
        "attribute" => $std
    ];

    return json_encode($array);

  }

  function api_request($api, $method, $params = []) {
    $token = get_token();

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => STORE_URL.'rest/default/'.$api,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_POSTFIELDS => $params,
      CURLOPT_HTTPHEADER => array(
        "accept: application/json",
        "content-type: application/json",
        "authorization: Bearer " . json_decode($token),
      ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);

    return $response;
}

function get_attribute_frontend_input($code) {
    $response =  api_request("V1/products/attributes/{$code}", 'GET', $params);

    $std = json_decode($response);
    return $std;
}

function update_attribute($code,$params) {
    $response =  api_request("V1/products/attributes/{$code}", 'PUT', $params);

  return $response;
}

function execute_csv($filename, $json, $method) {
    $row = 1;
    if (($handle = fopen($filename, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $row++;

            $std = get_attribute_frontend_input($data[0]);
            $std->default_frontend_label = $data[1];
            $std->frontend_labels = ["label" => $data[1], "store_id" => 0];
            $std = get_attribute_json($std);
            echo($std);

            echo $method($data[0], $std);
        }
    fclose($handle);
    }
}

execute_csv('attributes.csv', 'get_attribute_json', 'update_attribute');
