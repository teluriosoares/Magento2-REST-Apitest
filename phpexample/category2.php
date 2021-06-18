<?php
const STORE_URL = "https://modelo.m2.jn2.store/";
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




$feminino = get_json(2, 'Feminino');
$masculino = get_json(2, 'Masculino');
$infantil = get_json(2, 'Infantil');
$acessorios = get_json(2, 'Acessórios');
$sapatos = get_json(2, 'Sapatos');
$sale = get_json(2, 'Sale');

$feminino_id = add_category($feminino);
$masculino_id = add_category($masculino);
$infantil_id = add_category($infantil);
$acessorios_id = add_category($acessorios);
$sapatos_id = add_category($sapatos);
$sale_id = add_category($sale);

/*for ($i = 1; $i <= 15; $i++) {
  $homes_links = get_json($home_id, "Home Page V{$i}","https://v{$i}.boostcommerce.com.br");
  add_category($homes_links);
}*/

// FEMININO - ROUPAS
$roupas_demo = get_json($feminino_id, "Roupas");
$roupas_demo_id = add_category($roupas_demo);

$blusas = get_json($roupas_demo_id, "Blusas", "");
add_category($blusas);

$vestidos = get_json($roupas_demo_id, "Vestidos", "");
add_category($vestidos);

$calcas = get_json($roupas_demo_id, "Calças", "");
add_category($calcas);

$saias = get_json($roupas_demo_id, "Saias", "");
add_category($saias);

$macacoes = get_json($roupas_demo_id, "Macacões", "");
add_category($macacoes);

// FEMININO - CALÇADOS
$calcados_demo = get_json($feminino_id, "Calçados");
$calcados_demo_id = add_category($calcados_demo);

$sandalias = get_json($calcados_demo_id, "Sandálias", "");
add_category($sandalias);

$scarpins = get_json($calcados_demo_id, "Scarpins", "");
add_category($scarpins);

$sapatilhas = get_json($calcados_demo_id, "Sapatilhas", "");
add_category($sapatilhas);

$flats = get_json($calcados_demo_id, "Flats", "");
add_category($flats);

// FEMININO - BOLSAS E ACESSÓRIOS
$bolsas_acessorios_demo = get_json($feminino_id, "Bolsas e Acessórios");
$bolsas_acessorios_demo_id = add_category($bolsas_acessorios_demo);

$bolsas = get_json($bolsas_acessorios_demo_id, "Bolsas", "");
add_category($bolsas);

$carteiras_clutches = get_json($bolsas_acessorios_demo_id, "Carteiras e Clutches", "");
add_category($carteiras_clutches);

$cintos = get_json($bolsas_acessorios_demo_id, "Cintos", "");
add_category($cintos);

$pulseiras = get_json($bolsas_acessorios_demo_id, "Pulseiras", "");
add_category($pulseiras);

$brincos = get_json($bolsas_acessorios_demo_id, "Brincos", "");
add_category($brincos);

//============================================================