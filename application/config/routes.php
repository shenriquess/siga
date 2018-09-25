<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "painel/controller_login";
$route['404_override'] = '';

//================
//===== MAIN =====
//================


//==================
//===== PAINEL =====
//==================

// Administração
$route['painel/administracao/login'] = "painel/administracao/controller_alterar_informacoes/login";

// Configurações
$route['painel/configuracoes/cadastrarcontrato/(:any)'] = "painel/configuracoes/controller_cadastrar_contrato/$1";
$route['painel/configuracoes/cadastrardestino/(:any)'] = "painel/configuracoes/controller_cadastrar_destino/$1";
$route['painel/configuracoes/cadastrarfornecedor/(:any)'] = "painel/configuracoes/controller_cadastrar_fornecedor/$1";
$route['painel/configuracoes/cadastraritem/(:any)'] = "painel/configuracoes/controller_cadastrar_item/$1";
$route['painel/configuracoes/cadastrarusuario/(:any)'] = "painel/configuracoes/controller_cadastrar_usuario/$1";
$route['painel/configuracoes/cadastrartipo/(:any)'] = "painel/configuracoes/controller_cadastrar_tipo/$1";

// Entrada
$route['painel/entrada/inserirentrada/(:any)'] = "painel/entrada/controller_inserir_entrada/$1";

// Relatório
$route['painel/relatorio/balancocontratos/(:any)'] = "painel/relatorio/controller_balanco_contratos/$1";
$route['painel/relatorio/entradaitens/(:any)'] = "painel/relatorio/controller_entrada_itens/$1";
$route['painel/relatorio/estoquedisponivel/(:any)'] = "painel/relatorio/controller_estoque_disponivel/$1";
$route['painel/relatorio/saidaitens/(:any)'] = "painel/relatorio/controller_saida_itens/$1";

// Saída
$route['painel/saida/inserirsaida/(:any)'] = "painel/saida/controller_inserir_saida/$1";

// Outros
$route['logout'] = "painel/controller_home/logout";
$route['login'] = "painel/controller_login";
$route['painel/(index|home|login|logout)'] = 'painel/controller_home/$1';


//=========================
//===== PAINEL EDITAR =====
//=========================

// Administrador
$route['paineleditar/administrador/dadosadministrador/(:any)'] = "painel_editar/administrador/controller_dados_administrador/$1";

// Configurações
$route['paineleditar/configuracoes/alterarcontrato/(:any)'] = "painel_editar/configuracoes/controller_alterar_contrato/$1";
$route['paineleditar/configuracoes/alterardestino/(:any)'] = "painel_editar/configuracoes/controller_alterar_destino/$1";
$route['paineleditar/configuracoes/alterarfornecedor/(:any)'] = "painel_editar/configuracoes/controller_alterar_fornecedor/$1";
$route['paineleditar/configuracoes/alteraritem/(:any)'] = "painel_editar/configuracoes/controller_alterar_item/$1";
$route['paineleditar/configuracoes/alterartipo/(:any)'] = "painel_editar/configuracoes/controller_alterar_tipo/$1";
$route['paineleditar/configuracoes/alterarusuario/(:any)'] = "painel_editar/configuracoes/controller_alterar_usuario/$1";

// Entrada
$route['paineleditar/entrada/alterarentrada/(:any)'] = "painel_editar/entrada/controller_alterar_entrada/$1";

// Saída
$route['paineleditar/saida/alterarsaida/(:any)'] = "painel_editar/saida/controller_alterar_saida/$1";

// Outros
$route['paineleditar/(index|home|login|logout)'] = 'painel_editar/controller_home/$1';


//=========================
//======= API PAINEL ======
//=========================
// Configurações
$route['api/painel/configuracoes/cadastrarcontrato/(:any)'] = "api_painel/configuracoes/controller_cadastrar_contrato/$1";

// Entrada
$route['api/painel/entrada/inserirentrada/(:any)'] = "api_painel/entrada/controller_inserir_entrada/$1";

// Relatório

// Saída
$route['api/painel/saida/inserirsaida/(:any)'] = "api_painel/saida/controller_inserir_saida/$1";


//=============================
//===== API PAINEL EDITAR =====
//=============================
// Configurações
$route['api/paineleditar/configuracoes/alterarusuario/(:any)'] = "api_painel_editar/configuracoes/controller_alterar_usuario/$1";

// Entrada
$route['api/paineleditar/entrada/alterarentrada/(:any)'] = "api_painel_editar/entrada/controller_alterar_entrada/$1";

// Relatório
// Saída

/* End of file routes.php */
/* Location: ./application/config/routes.php */