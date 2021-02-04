<?php
const STORE_URL = "https://beta1.boostcommerce.com.br/";
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




$homes = get_json(2, 'Home Pages');
$shop = get_json(2, 'Shop');
$home_id = add_category($homes);
$shop_id = add_category($shop);

for ($i = 1; $i <= 15; $i++) {
  $homes_links = get_json($home_id, "Home Page V{$i}","https://v{$i}.boostcommerce.com.br");
  add_category($homes_links);
}

// PÁGINAS DE PRODUTO
$product_demo = get_json($shop_id, "Páginas de Produto");
$product_demo_id = add_category($product_demo);

$product_page_v1 = get_json($product_demo_id, "Página de Produto 1", "https://v1.boostcommerce.com.br/vestido-lovelyz.html");
add_category($product_page_v1);

$product_page_v2 = get_json($product_demo_id, "Página de Produto 2", "https://v6.boostcommerce.com.br/bolsa-estruturada.html");
add_category($product_page_v2);

$product_page_v3 = get_json($product_demo_id, "Página de Produto 3", "https://v7.boostcommerce.com.br/jaqueta-jeans-destroyed.html");
add_category($product_page_v3);

$product_page_v4 = get_json($product_demo_id, "Página de Produto 4", "https://v8.boostcommerce.com.br/blusa-cosmic-girl.html");
add_category($product_page_v4);

$simple_product = get_json($product_demo_id, "Produto Simples", "https://v4.boostcommerce.com.br/vestido-ice-cream.html");
add_category($simple_product);

$config_product = get_json($product_demo_id, "Produto Configurável", "https://v7.boostcommerce.com.br/calca-jeans-skinny.html");
add_category($config_product);

$bundle_product = get_json($product_demo_id, "Produto Agrupado", "https://v1.boostcommerce.com.br/calca-jeans-skinny.html");
add_category($bundle_product);

$sale_product = get_json($product_demo_id, "Produto Promocional", "https://v8.boostcommerce.com.br/jaqueta-studio-dance.html");
add_category($sale_product);

$out_of_stock = get_json($product_demo_id, "Produto Fora de Estoque", "https://v2.boostcommerce.com.br/camiseta-basica.html");
add_category($out_of_stock);

//============================================================

// PÁGINAS DE CATEGORIA
$category_demo = get_json($shop_id, "Páginas de Categoria");
$category_demo_id = add_category($category_demo);

$category_2_colunas = get_json($category_demo_id, "2 Colunas", "https://v4.boostcommerce.com.br/feminino.html");
add_category($category_2_colunas);

$category_3_colunas = get_json($category_demo_id, "3 Colunas", "https://v3.boostcommerce.com.br/feminino.html");
add_category($category_3_colunas);

$category_4_colunas = get_json($category_demo_id, "4 Colunas", "https://v2.boostcommerce.com.br/feminino.html");
add_category($category_4_colunas);

$category_5_colunas = get_json($category_demo_id, "5 Colunas", "https://v1.boostcommerce.com.br/feminino.html");
add_category($category_5_colunas);

$category_2_colunas_sidebar = get_json($category_demo_id, "2 Colunas - Sidebar", "https://v8.boostcommerce.com.br/feminino.html");
add_category($category_2_colunas_sidebar);

$category_3_colunas_sidebar = get_json($category_demo_id, "3 Colunas - Sidebar", "https://v7.boostcommerce.com.br/feminino.html");
add_category($category_3_colunas_sidebar);

$category_4_colunas_sidebar = get_json($category_demo_id, "4 Colunas - Sidebar", "https://v6.boostcommerce.com.br/feminino.html");
add_category($category_4_colunas_sidebar);

$category_5_colunas_sidebar = get_json($category_demo_id, "5 Colunas - Sidebar", "https://v5.boostcommerce.com.br/feminino.html");
add_category($category_5_colunas_sidebar);

$category_with_banner = get_json($category_demo_id, "Categoria com Banner", "https://v10.boostcommerce.com.br/acessorios.html");
add_category($category_with_banner);

$category_filter_slider_v1 = get_json($category_demo_id, "Filtro Animado V1", "https://v9.boostcommerce.com.br/sale.html");
add_category($category_filter_slider_v1);

$category_filter_slider_v2 = get_json($category_demo_id, "Filtro Animado V2", "https://v15.boostcommerce.com.br/ofertas.html");
add_category($category_filter_slider_v2);

//============================================================

// CABEÇALHOS & RODAPÉS
$header_footer_demo = get_json($shop_id, "Cabeçalhos & Rodapés");
$header_footer_demo_id = add_category($header_footer_demo);

$header_v1 = get_json($header_footer_demo_id, "Cabeçalho V1", "https://v1.boostcommerce.com.br" );
add_category($header_v1);

$header_v2 = get_json($header_footer_demo_id, "Cabeçalho V2", "https://v2.boostcommerce.com.br" );
add_category($header_v2);

$header_v3 = get_json($header_footer_demo_id, "Cabeçalho V3", "https://v3.boostcommerce.com.br" );
add_category($header_v3);

$header_v4 = get_json($header_footer_demo_id, "Cabeçalho V4", "https://v4.boostcommerce.com.br" );
add_category($header_v4);

$footer_v1 = get_json($header_footer_demo_id, "Rodapé V1", "https://v10.boostcommerce.com.br" );
add_category($footer_v1);

$footer_v2 = get_json($header_footer_demo_id, "Rodapé V2", "https://v7.boostcommerce.com.br" );
add_category($footer_v2);

$footer_v3 = get_json($header_footer_demo_id, "Rodapé V3", "https://v2.boostcommerce.com.br" );
add_category($footer_v3);

$footer_v4 = get_json($header_footer_demo_id, "Rodapé V4", "https://v6.boostcommerce.com.br" );
add_category($footer_v4);

$pre_footer = get_json($header_footer_demo_id, "Pré-Rodapé", "https://v1.boostcommerce.com.br" );
add_category($pre_footer);

//============================================================

// DESCUBRA MAIS
$discover_more_demo = get_json($shop_id, "Descubra Mais");
$discover_more_demo_id = add_category($discover_more_demo);

$quick_cart = get_json($discover_more_demo_id, "Carrinho Rápido", "https://v1.boostcommerce.com.br/calca-jeans-skinny.html");
add_category($quick_cart);

$infinite_scroll = get_json($discover_more_demo_id, "Rolagem Infinita", "https://v2.boostcommerce.com.br/feminino.html");
add_category($infinite_scroll);

$ajax_catalog = get_json($discover_more_demo_id, "Catálogo Ajax", "https://v3.boostcommerce.com.br/feminino.html");
add_category($ajax_catalog);

$slider_mobile_desktop = get_json($discover_more_demo_id, "Slider Mobile / Desktop", "https://v7.boostcommerce.com.br");
add_category($slider_mobile_desktop);

$lookbook = get_json($discover_more_demo_id, "Lookbook", "https://v1.boostcommerce.com.br");
add_category($lookbook);

$contact_page_v1 = get_json($discover_more_demo_id, "Página de Contato V1", "https://v1.boostcommerce.com.br/contato");
add_category($contact_page_v1);

$contact_page_v2 = get_json($discover_more_demo_id, "Página de Contato V2", "https://v2.boostcommerce.com.br/contato");
add_category($contact_page_v2);

$about_us_page_v1 = get_json($discover_more_demo_id, "Página Sobre Nós V1", "https://v1.boostcommerce.com.br/sobre-nos");
add_category($about_us_page_v1);

$about_us_page_v2 = get_json($discover_more_demo_id, "Página Sobre Nós V2", "https://v2.boostcommerce.com.br/sobre-nos");
add_category($about_us_page_v2);

$success_page = get_json($discover_more_demo_id, "Página de Sucesso", "https://v1.boostcommerce.com.br/pagina-de-sucesso");
add_category($success_page);

//============================================================

// QUICKVIEW & PESQUISA
$quickview_search_demo = get_json($shop_id, "Quickview & Pesquisa");
$quickview_search_demo_id = add_category($quickview_search_demo);

$quickview_v1 = get_json($quickview_search_demo_id, "Quickview V1", "https://v10.boostcommerce.com.br/acessorios.html");
add_category($quickview_v1);

$quickview_v2 = get_json($quickview_search_demo_id, "Quickview V2", "https://v6.boostcommerce.com.br/feminino.html");
add_category($quickview_v2);

$quickview_v3 = get_json($quickview_search_demo_id, "Quickview V3", "https://v7.boostcommerce.com.br/feminino.html");
add_category($quickview_v3);

$search_v1 = get_json($quickview_search_demo_id, "Pesquisa V1", "https://v3.boostcommerce.com.br");
add_category($search_v1);

$search_v2 = get_json($quickview_search_demo_id, "Pesquisa V2", "https://v7.boostcommerce.com.br");
add_category($search_v2);

$search_v3 = get_json($quickview_search_demo_id, "Pesquisa V3", "https://v9.boostcommerce.com.br");
add_category($search_v3);

//============================================================


/*
// COLUNAS
$colunas = get_json($shop_id, "COLUNAS");
$coluna_id = add_category($colunas);

// 5 Colunas
$shop_5_colunas = get_json($coluna_id, "5 Colunas", "COLOCAR_URL_AQUI" );
add_category($shop_5_colunas);

// 4 Colunas
$shop_4_colunas = get_json($coluna_id, "4 Colunas", "COLOCAR_URL_AQUI" );
add_category($shop_4_colunas);

// 3 Colunas
$shop_3_colunas = get_json($coluna_id, "3 Colunas", "COLOCAR_URL_AQUI" );
add_category($shop_3_colunas);
*/