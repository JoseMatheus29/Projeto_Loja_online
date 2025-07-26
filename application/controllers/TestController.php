<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TestController extends CI_Controller {
    
    public function index() {
        echo "<h1>🔧 Teste de Conectividade - JM Commerce</h1>";
        echo "<p><strong>✅ Controller funcionando!</strong></p>";
        echo "<p><strong>Base URL:</strong> " . base_url() . "</p>";
        echo "<p><strong>Current URL:</strong> " . current_url() . "</p>";
        
        echo "<h3>🔗 Links de Teste:</h3>";
        echo "<ul>";
        echo "<li><a href='" . base_url() . "'>🏠 Home</a></li>";
        echo "<li><a href='" . base_url('HomeController') . "'>🏠 HomeController</a></li>";
        echo "<li><a href='" . base_url('usuarioController/login') . "'>👤 Login</a></li>";
        echo "<li><a href='" . base_url('ProdutoController') . "'>📦 Produtos</a></li>";
        echo "<li><a href='" . base_url('RelatorioController') . "'>📊 Relatórios</a></li>";
        echo "<li><a href='" . base_url('migration') . "'>🔧 Migração</a></li>";
        echo "</ul>";
        
        echo "<h3>📋 Variáveis de Ambiente:</h3>";
        echo "<ul>";
        echo "<li><strong>DB_HOST:</strong> " . (getenv('DB_HOST') ?: 'não definida') . "</li>";
        echo "<li><strong>DB_DRIVER:</strong> " . (getenv('DB_DRIVER') ?: 'não definida') . "</li>";
        echo "<li><strong>DB_DATABASE:</strong> " . (getenv('DB_DATABASE') ?: 'não definida') . "</li>";
        echo "</ul>";
        
        // Teste de banco
        if ($this->db->conn_id) {
            echo "<p style='color: green;'>✅ Conexão com banco funcionando!</p>";
            
            // Lista algumas tabelas
            $tables = $this->db->list_tables();
            if (!empty($tables)) {
                echo "<p><strong>Tabelas encontradas:</strong> " . implode(', ', $tables) . "</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ Erro na conexão com banco!</p>";
        }
    }
}
