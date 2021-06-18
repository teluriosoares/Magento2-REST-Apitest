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

function post_request($api, $method, $params) {

        $token = get_token();

      // PUT
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

function product_json ($sku, $name, $price, $attributes = [], $stock=500) {
  $array =  [
      "product" => [
        "sku" => $sku,
        "name" => $name,
        "attribute_set_id" => 4,
        "price" => $price,
        "status" =>  1,
        "visibility" => 4,
        "type_id" => "simple",
        "weight" => "0.5",
        "extension_attributes" => [
          "website_ids" => [
            0,
            1
          ],
          "stock_item" => [
            "qty" => $stock,
            "is_in_stock" => true
          ]
        ],
      ]
    ];
    $array['product']['custom_attributes'] = [];

    foreach ($attributes as $code => $value) {
      $array['product']['custom_attributes'][] = ['attribute_code' => $code, 'value' => $value];
    }

    $json = json_encode($array);
    return $json;
}

function image_json($img) {

  $path = './images/'.$img;
  $type = pathinfo($path, PATHINFO_EXTENSION);
  $data = file_get_contents($path);
  $base64 = base64_encode($data);

  $array = [
    "entry" => [
      "label" => $img,
      "media_type" => 'image',
      "position" => 0,
      "disabled" => false,
      "types" => [
        "image",
        "small_image",
        "thumbnail"
      ],
      "file" => './images/'.$img,
      "content" => [
        "base64_encoded_data" => $base64,
        "type" => "image/{$type}",
        "name" => $img
      ],
    ]
  ];

  $json = json_encode($array);
  return $json;
}



function create_product($params) {
  $response =  post_request('V1/products', 'POST', $params);

  return $response;
}

function add_image($sku, $params) {
  return post_request('V1/products/'.$sku.'/media', 'POST', $params);
}

#======================================


$attributes = [
  'category_ids' => [2, 5, 6, 8],
  'description' => "Isso aqui é a descrição",
  'short_description' =>  "Isso aqui é a descrição curta"
];

$sku = "teste29";
$name = 'Teste 29';

//function product_json ($sku, $name, $price, $attributes = [], $stock=500)
$product_teste = product_json($sku, $name, 199, $attributes);
create_product($product_teste);


$image = image_json('img-1.png');
$image2 = image_json('img-2.png');
$image3 = image_json('img-2.png');

$response = add_image($sku,$image);
$response = add_image($sku,$image2);
$response = add_image($sku,$image3);
