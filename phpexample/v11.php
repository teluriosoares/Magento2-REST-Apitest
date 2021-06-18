<?php
const STORE_URL = "https://sualoja.com.br/";
const USER = "user";
const PASSWORD = "password";
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




$caes = get_json(2, 'Cães');
$gatos = get_json(2, 'Gatos');
$passaros = get_json(2, 'Pássaros');
$peixes = get_json(2, 'Peixes');
$outros_pets = get_json(2, 'Outros Pets');

$caes_id = add_category($caes);
$gatos_id = add_category($gatos);
$passaros_id = add_category($passaros);
$peixes_id = add_category($peixes);
$outros_pets_id = add_category($outros_pets);

/*for ($i = 1; $i <= 15; $i++) {
  $homes_links = get_json($home_id, "Home Page V{$i}","https://v{$i}.boostcommerce.com.br");
  add_category($homes_links);
}*/

//=========================================================================================

// CÃES - RAÇÕES
$racoes_demo = get_json($caes_id, "Rações");
$racoes_demo_id = add_category($racoes_demo);

$racao_seca = get_json($racoes_demo_id, "Ração Seca", "");
add_category($racao_seca);

$racao_umida = get_json($racoes_demo_id, "Ração Úmida", "");
add_category($racao_umida);

$racao_prescrita = get_json($racoes_demo_id, "Ração Prescrita", "");
add_category($racao_prescrita);

$racao_natural = get_json($racoes_demo_id, "Ração Natural", "");
add_category($racao_natural);

//=========================================================================================

// CÃES - PETISCOS
$petiscos_demo = get_json($caes_id, "Petiscos");
$petiscos_demo_id = add_category($petiscos_demo);

$palitos = get_json($petiscos_demo_id, "Palitos", "");
add_category($palitos);

$bifinhos = get_json($petiscos_demo_id, "Bifinhos", "");
add_category($bifinhos);

$biscoitos = get_json($petiscos_demo_id, "Biscoitos", "");
add_category($biscoitos);

$bolos_chocolates = get_json($petiscos_demo_id, "Bolos e Chocolates", "");
add_category($bolos_chocolates);

//=========================================================================================

// CÃES - TAPETES, FRALDAS E BANHEIRO
$tapetes_fraldas_banheiro_demo = get_json($caes_id, "Tapetes, Fraldas e Banheiro");
$tapetes_fraldas_banheiro_demo_id = add_category($tapetes_fraldas_banheiro_demo);

$tapetes_higienicos = get_json($tapetes_fraldas_banheiro_demo_id, "Tapetes Higiênicos", "");
add_category($tapetes_higienicos);

$fraldas = get_json($tapetes_fraldas_banheiro_demo_id, "Fraldas", "");
add_category($fraldas);

$banheiro = get_json($tapetes_fraldas_banheiro_demo_id, "Banheiro", "");
add_category($banheiro);

$cones = get_json($tapetes_fraldas_banheiro_demo_id, "Cones", "");
add_category($cones);

//=========================================================================================

// CÃES - FARMÁCIA
$farmacia_demo = get_json($caes_id, "Farmácia");
$farmacia_demo_id = add_category($farmacia_demo);

$antipulgas = get_json($farmacia_demo_id, "Antipulgas", "");
add_category($antipulgas);

$anticarrapatos = get_json($farmacia_demo_id, "Anticarrapatos", "");
add_category($anticarrapatos);

$suplementos_vitaminas = get_json($farmacia_demo_id, "Suplementos e Vitaminas", "");
add_category($suplementos_vitaminas);

$demais_medicamentos = get_json($farmacia_demo_id, "Demais Medicamentos", "");
add_category($demais_medicamentos);

//=========================================================================================

// CÃES - BRINQUEDOS
$brinquedos_demo = get_json($caes_id, "Brinquedos");
$brinquedos_demo_id = add_category($brinquedos_demo);

$bichos_de_pelucia = get_json($brinquedos_demo_id, "Bichos de Pelúcia", "");
add_category($bichos_de_pelucia);

$bolinhas = get_json($brinquedos_demo_id, "Bolinhas", "");
add_category($bolinhas);

$brinquedos_nylon = get_json($brinquedos_demo_id, "Brinquedos de Nylon", "");
add_category($brinquedos_nylon);

$brinquedos_educativos = get_json($brinquedos_demo_id, "Brinquedos Educativos", "");
add_category($brinquedos_educativos);

$frisbees = get_json($brinquedos_demo_id, "Frisbees", "");
add_category($frisbees);

$mordedores = get_json($brinquedos_demo_id, "Mordedores", "");
add_category($mordedores);

//=========================================================================================

// CÃES - CAMAS E COBERTORES
$camas_cobertores_demo = get_json($caes_id, "Camas e Cobertores");
$camas_cobertores_demo_id = add_category($camas_cobertores_demo);

$almofadas_colchonetes = get_json($camas_cobertores_demo_id, "Almofadas e Colchonetes", "");
add_category($almofadas_colchonetes);

$camas = get_json($camas_cobertores_demo_id, "Camas", "");
add_category($camas);

$edredons = get_json($camas_cobertores_demo_id, "Edredons", "");
add_category($edredons);

$cobertores = get_json($camas_cobertores_demo_id, "Cobertores", "");
add_category($cobertores);
