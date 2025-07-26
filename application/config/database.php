<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Database Configuration - Multi Database Support
|--------------------------------------------------------------------------
| Configuração que suporta tanto MySQL quanto PostgreSQL
*/

$active_group = 'postgresql';
$query_builder = TRUE;

// Detecta o tipo de banco baseado na variável de ambiente
$db_driver = getenv('DB_DRIVER') ?: 'mysqli';
$db_port = ($db_driver === 'postgre') ? (getenv('DB_PORT') ?: 5432) : (getenv('DB_PORT') ?: 3306);

$db['default'] = array(
    'dsn'      => getenv('DATABASE_URL') ?: '',
    'hostname' => getenv('DB_HOST') ?: (($db_driver === 'postgre') ? 'localhost' : 'db'),
    'username' => getenv('DB_USERNAME') ?: (($db_driver === 'postgre') ? 'postgres' : 'admin'),
    'password' => getenv('DB_PASSWORD') ?: (($db_driver === 'postgre') ? '' : 'acessoBanco'),
    'database' => getenv('DB_DATABASE') ?: 'loja_online',
    'dbdriver' => $db_driver,
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => ($db_driver === 'postgre') ? '' : 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE,
    'port'     => $db_port
);

// Configuração específica para PostgreSQL
$db['postgresql'] = array(
    'dsn'      => getenv('DATABASE_URL') ?: '',
    'hostname' => getenv('DB_HOST') ?: 'localhost',
    'username' => getenv('DB_USERNAME') ?: 'postgres',
    'password' => getenv('DB_PASSWORD') ?: '',
    'database' => getenv('DB_DATABASE') ?: 'loja_online',
    'dbdriver' => 'postgre',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => '',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE,
    'port'     => getenv('DB_PORT') ?: 5432
);

// Configuração específica para MySQL
$db['mysql'] = array(
    'dsn'      => '',
    'hostname' => getenv('DB_HOST') ?: 'db',
    'username' => getenv('DB_USERNAME') ?: 'admin',
    'password' => getenv('DB_PASSWORD') ?: 'acessoBanco',
    'database' => getenv('DB_DATABASE') ?: 'loja_online',
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
    'save_queries' => TRUE,
    'port'     => getenv('DB_PORT') ?: 3306
);