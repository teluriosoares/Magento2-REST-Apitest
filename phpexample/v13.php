<?php
const STORE_URL = "https://v13.boostcommerce.com.br/";
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




$medicamentos = get_json(2, 'Medicamentos');
$genericos = get_json(2, 'Genéricos');
$saude_cuidados = get_json(2, 'Saúde e Cuidados');
$alimentos_vitaminas = get_json(2, 'Alimentos e Vitaminas');
$higiene_cuidados = get_json(2, 'Higiene e Cuidados');
$mamae_bebe = get_json(2, 'Mamãe e Bebê');
$dermocosmeticos = get_json(2, 'Dermocosméticos');

$medicamentos_id = add_category($medicamentos);
$genericos_id = add_category($genericos);
$saude_cuidados_id = add_category($saude_cuidados);
$alimentos_vitaminas_id = add_category($alimentos_vitaminas);
$higiene_cuidados_id = add_category($higiene_cuidados);
$mamae_bebe_id = add_category($mamae_bebe);
$dermocosmeticos_id = add_category($dermocosmeticos);

/*for ($i = 1; $i <= 15; $i++) {
  $homes_links = get_json($home_id, "Home Page V{$i}","https://v{$i}.boostcommerce.com.br");
  add_category($homes_links);
}*/

//=========================================================================================

// MEDICAMENTOS - ANTICONCEPCIONAIS
$anticoncepcionais_demo = get_json($medicamentos_id, "Anticoncepcionais");
$anticoncepcionais_demo_id = add_category($anticoncepcionais_demo);

$pilulas = get_json($anticoncepcionais_demo_id, "Pílulas", "");
add_category($pilulas);

$injetaveis = get_json($anticoncepcionais_demo_id, "Injetáveis", "");
add_category($injetaveis);

$adesivos = get_json($anticoncepcionais_demo_id, "Adesivos", "");
add_category($adesivos);

//=========================================================================================

// MEDICAMENTOS - ANTI-INFLAMATÓRIOS
$antiinflamatorios_demo = get_json($medicamentos_id, "Anti-inflamatórios");
$antiinflamatorios_demo_id = add_category($antiinflamatorios_demo);

$contusoes = get_json($antiinflamatorios_demo_id, "Contusões", "");
add_category($contusoes);

//=========================================================================================

// MEDICAMENTOS - DIABETES
$diabetes_demo = get_json($medicamentos_id, "Diabetes");
$diabetes_demo_id = add_category($diabetes_demo);

$alimentacao = get_json($diabetes_demo_id, "Alimentação", "");
add_category($alimentacao);

$controle_antiglicemicos = get_json($diabetes_demo_id, "Controle | Antiglicêmicos", "");
add_category($controle_antiglicemicos);

$cuidados = get_json($diabetes_demo_id, "Cuidados", "");
add_category($cuidados);

$monitoramento = get_json($diabetes_demo_id, "Monitoramento", "");
add_category($monitoramento);

$freestyle_libre = get_json($diabetes_demo_id, "FreeStyle Libre", "");
add_category($freestyle_libre);

$medtronic = get_json($diabetes_demo_id, "Medtronic", "");
add_category($medtronic);

//=========================================================================================

// MEDICAMENTOS - GRIPE E RESFRIADO
$gripe_resfriado_demo = get_json($medicamentos_id, "Gripe e Resfriado");
$gripe_resfriado_demo_id = add_category($gripe_resfriado_demo);

$tosse = get_json($gripe_resfriado_demo_id, "Tosse", "");
add_category($tosse);

$congestao_nasal = get_json($gripe_resfriado_demo_id, "Congestão Nasal", "");
add_category($congestao_nasal);

$dor_febre = get_json($gripe_resfriado_demo_id, "Dor e Febre", "");
add_category($dor_febre);

$dor_garganta = get_json($gripe_resfriado_demo_id, "Dor de Garganta", "");
add_category($dor_garganta);

//=========================================================================================

// MEDICAMENTOS - COLESTEROL
$colesterol_demo = get_json($medicamentos_id, "Colesterol");
$colesterol_demo_id = add_category($colesterol_demo);

//=========================================================================================

// MEDICAMENTOS - HIPERTENSIVOS
$hipertensivos_demo = get_json($medicamentos_id, "Hipertensivos");
$hipertensivos_demo_id = add_category($hipertensivos_demo);

//=========================================================================================

// MEDICAMENTOS - MEDICAMENTOS ESPECIAIS
$medicamentos_especiais_demo = get_json($medicamentos_id, "Medicamentos Especiais");
$medicamentos_especiais_demo_id = add_category($medicamentos_especiais_demo);

$endocrinologia = get_json($medicamentos_especiais_demo_id, "Endocrinologia", "");
add_category($endocrinologia);

$ginecologico = get_json($medicamentos_especiais_demo_id, "Ginecológico", "");
add_category($ginecologico);

$antitabagismo = get_json($medicamentos_especiais_demo_id, "Antitabagismo", "");
add_category($antitabagismo);

$asma = get_json($medicamentos_especiais_demo_id, "Asma", "");
add_category($asma);

$colesterol = get_json($medicamentos_especiais_demo_id, "Colesterol", "");
add_category($colesterol);

$hipertensivo = get_json($medicamentos_especiais_demo_id, "Hipertensivo", "");
add_category($hipertensivo);

//=========================================================================================

// MEDICAMENTOS - ALERGIAS E INFECÇÕES
$alergias_infeccoes_demo = get_json($medicamentos_id, "Alergias e Infecções");
$alergias_infeccoes_demo_id = add_category($alergias_infeccoes_demo);

$inaladores = get_json($alergias_infeccoes_demo_id, "Inaladores", "");
add_category($inaladores);

$umidificadores = get_json($alergias_infeccoes_demo_id, "Umidificadores", "");
add_category($umidificadores);