<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Database Configuration for PostgreSQL
|--------------------------------------------------------------------------
| Configuração adaptada para PostgreSQL no Digital Ocean
*/

$active_group = 'default';
$query_builder = TRUE;

// Configuração para PostgreSQL
$db['default'] = array(
    'dsn'      => '',
    'hostname' => getenv('DB_HOST') ?: 'localhost',
    'username' => getenv('DB_USERNAME') ?: 'postgres',
    'password' => getenv('DB_PASSWORD') ?: '',
    'database' => getenv('DB_DATABASE') ?: 'loja_online',
    'dbdriver' => 'postgre',                    // Driver do PostgreSQL
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE,
    'port'     => getenv('DB_PORT') ?: 5432     // Porta padrão do PostgreSQL
);

// Configuração alternativa para MySQL (backup)
$db['mysql'] = array(
    'dsn'      => '',
    'hostname' => getenv('MYSQL_HOST') ?: 'localhost',
    'username' => getenv('MYSQL_USERNAME') ?: 'admin',
    'password' => getenv('MYSQL_PASSWORD') ?: 'acessoBanco',
    'database' => getenv('MYSQL_DATABASE') ?: 'loja_online',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
