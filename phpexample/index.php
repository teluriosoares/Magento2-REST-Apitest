<?php

const STORE_URL = "http://mage2.loc/";
const USER = "jn2";
const PASSWORD = "P4ssw0rd";


function get_json($parent, $name, $url=false) {
  
  if (!!$url) {
    return '{
      "category": {
         "parent_id": '.$parent.',
         "name": "'.$name.'",
         "is_active": true,
         "custom_attributes": [
          {
          "attribute_code": "weltpixel_category_url",
          "value": "'.$url.'"
          }
          ]
      } 
    }';
  } else {
    return '{
      "category": {
         "parent_id": '.$parent.',
         "name": "'.$name.'",
         "is_active": true
      } 
    }';
  }
}


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

function get_category($name) {
  $token = get_token();
  $request = STORE_URL."/rest/default/V1/categories";  
  $ch = curl_init($request);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . json_decode($token)));
     
  $result = curl_exec($ch);
  var_dump($result);
}

function add_category ($post) {
  $token = get_token();
  
// Post
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => STORE_URL."rest/default/V1/categories",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $post,
    CURLOPT_HTTPHEADER => array(
      "accept: application/json",
      "content-type: application/json",
      "authorization: Bearer " . json_decode($token),
    ),
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);

  $obj = json_decode($response);
  var_dump($obj);
  return $obj->id;
}

$homes = get_json(2, 'Home Pages 3');
$shop = get_json(2, 'Shop 3');

$home_id = add_category($homes);
$shop_id = add_category($shop);


//Aqui vai criar o link para todas as outras HOMES
for ($i = 1; $i <= 15; $i++) {
  $homes_links = get_json($home_id, "Home Page V{$i}","https://v{$i}.boostcommerce.com.br");
  add_category($homes_links);
}


// COLUNAS
$colunas = get_json($shop_id, "COLUNAS");
$coluna_id = add_category($colunas);


// 5 COLUNAS
$shop_5_colunas = get_json($coluna_id, "5 COLUNAS", "COLOCAR_URL_AQUI" );
add_category($shop_5_colunas);

// 4 COLUNAS
$shop_4_colunas = get_json($coluna_id, "4 COLUNAS", "COLOCAR_URL_AQUI" );
add_category($shop_4_colunas);

$shop_3_colunas = get_json($coluna_id, "3 COLUNAS", "COLOCAR_URL_AQUI" );
add_category($shop_3_colunas);