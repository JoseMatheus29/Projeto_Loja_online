<?php
/**
 * Helper para carregar variáveis de ambiente do arquivo .env
 */

if (!function_exists('load_env')) {
    function load_env($file = '.env') {
        $path = FCPATH . $file;
        
        if (!file_exists($path)) {
            return false;
        }
        
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Ignora comentários
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            
            // Processa a linha KEY=VALUE
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Remove aspas se existirem
                $value = trim($value, '"\'');
                
                // Define a variável de ambiente se ela não existir
                if (!getenv($key)) {
                    putenv("$key=$value");
                    $_ENV[$key] = $value;
                    $_SERVER[$key] = $value;
                }
            }
        }
        
        return true;
    }
}

// Carrega automaticamente o arquivo .env quando este helper é incluído
load_env();
