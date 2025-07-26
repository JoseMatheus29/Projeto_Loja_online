<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
*/

$route['default_controller'] = 'HomeController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Rotas principais
$route['home'] = 'HomeController/index';
$route['login'] = 'usuarioController/login';
$route['logout'] = 'usuarioController/logout';
$route['carrinho'] = 'carrinhoController/index';
$route['produtos'] = 'ProdutoController/index';
$route['categorias'] = 'CategoriaController/index';
$route['pedidos'] = 'pedidosController/index';
$route['relatorios'] = 'RelatorioController/index';

// Rotas específicas para relatórios
$route['relatorios/compras-por-cliente'] = 'RelatorioController/compras_por_cliente';
$route['relatorios/produtos-em-falta'] = 'RelatorioController/produtos_em_falta';
$route['relatorios/valor-por-dia'] = 'RelatorioController/valor_por_dia';

// Rota de migração
$route['migration'] = 'migration/index';     
