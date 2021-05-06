<?php

$curl = curl_init();

$sku = 'teste01';
$name = 'Produto-teste';


curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://beta2.boostcommerce.com.br/rest/default/V1/products',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>"{
  \"product\": {
    \"sku\": \"$sku\",
    \"name\": \"$name\",
    \"attribute_set_id\": 4,
    \"price\": 25,
    \"status\": 1,
    \"visibility\": 1,
    \"type_id\": \"simple\",
    \"weight\": \"0.5\",
    \"extension_attributes\": {
        \"category_links\": [

            {
                \"position\": 0,
                \"category_id\": \"4\"
            }
        ],
        \"stock_item\": {
            \"qty\": \"10\",
            \"is_in_stock\": true
        }
    }

  }
}
",
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer uwifa0ew28pnzvu2q4d9m6i4my0582wh',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
