<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
*/

$route['default_controller'] = 'HomeController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Rota de teste
$route['teste'] = 'TestController/index';
$route['teste-home'] = 'HomeController/teste';

// Rota de migração
$route['migration'] = 'migration/index';
$route['migration/run'] = 'migration/run';     
