<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration extends CI_Controller {
    
    public function index() {
        echo "<h1>🚀 Migração de Banco de Dados - JM Commerce</h1>";
        
        // Testa a conexão
        if (!$this->db->conn_id) {
            echo "<p style='color: red;'>❌ Erro: Não foi possível conectar ao banco de dados.</p>";
            echo "<p>Verifique as configurações no arquivo .env</p>";
            return;
        }
        
        echo "<p style='color: green;'>✅ Conexão com banco estabelecida!</p>";
        echo "<p><strong>Driver:</strong> " . $this->db->dbdriver . "</p>";
        echo "<p><strong>Hostname:</strong> " . $this->db->hostname . "</p>";
        echo "<p><strong>Database:</strong> " . $this->db->database . "</p>";
        
        // Lista tabelas existentes
        $tables = $this->db->list_tables();
        echo "<h3>📋 Tabelas existentes:</h3>";
        if (empty($tables)) {
            echo "<p>Nenhuma tabela encontrada. Execute a migração!</p>";
            echo "<p><a href='" . base_url('migration/run') . "' style='background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🔧 Executar Migração</a></p>";
        } else {
            echo "<ul>";
            foreach ($tables as $table) {
                echo "<li>$table</li>";
            }
            echo "</ul>";
            echo "<p style='color: green;'>✅ Banco de dados já configurado!</p>";
        }
    }
    
    public function run() {
        echo "<h1>🔧 Executando Migração...</h1>";
        
        try {
            // SQL para PostgreSQL
            $sql_structure = "
            -- Tabela de Categorias
            CREATE TABLE IF NOT EXISTS categorias (
                id SERIAL PRIMARY KEY,
                nome VARCHAR(100) NOT NULL,
                descricao TEXT,
                ativo BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            -- Tabela de Usuários
            CREATE TABLE IF NOT EXISTS usuarios (
                id SERIAL PRIMARY KEY,
                nome VARCHAR(150) NOT NULL,
                email VARCHAR(150) UNIQUE NOT NULL,
                senha VARCHAR(255) NOT NULL,
                tipo_usuario VARCHAR(20) DEFAULT 'cliente',
                ativo BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            -- Tabela de Produtos
            CREATE TABLE IF NOT EXISTS produtos (
                id SERIAL PRIMARY KEY,
                nome VARCHAR(200) NOT NULL,
                descricao TEXT,
                preco DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                quantidade INTEGER DEFAULT 0,
                categoria_id INTEGER REFERENCES categorias(id) ON DELETE SET NULL,
                foto VARCHAR(255),
                ativo BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            -- Tabela de Carrinho
            CREATE TABLE IF NOT EXISTS carrinho (
                id SERIAL PRIMARY KEY,
                usuario_id INTEGER REFERENCES usuarios(id) ON DELETE CASCADE,
                produto_id INTEGER REFERENCES produtos(id) ON DELETE CASCADE,
                quantidade INTEGER DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            -- Tabela de Pedidos
            CREATE TABLE IF NOT EXISTS pedidos (
                id SERIAL PRIMARY KEY,
                usuario_id INTEGER REFERENCES usuarios(id) ON DELETE CASCADE,
                total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                status VARCHAR(20) DEFAULT 'pendente',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            -- Tabela de Itens do Pedido
            CREATE TABLE IF NOT EXISTS pedidos_itens (
                id SERIAL PRIMARY KEY,
                pedido_id INTEGER REFERENCES pedidos(id) ON DELETE CASCADE,
                produto_id INTEGER REFERENCES produtos(id) ON DELETE CASCADE,
                quantidade INTEGER NOT NULL,
                preco_unitario DECIMAL(10,2) NOT NULL,
                subtotal DECIMAL(10,2) NOT NULL
            );
            ";
            
            // Executa a estrutura
            $queries = explode(';', $sql_structure);
            foreach ($queries as $query) {
                $query = trim($query);
                if (!empty($query)) {
                    $this->db->query($query);
                }
            }
            
            echo "<p style='color: green;'>✅ Estrutura das tabelas criada!</p>";
            
            // Insere dados iniciais
            $this->insert_initial_data();
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Erro na migração: " . $e->getMessage() . "</p>";
        }
        
        echo "<p><a href='" . base_url('migration') . "'>🔙 Voltar</a></p>";
    }
    
    private function insert_initial_data() {
        // Insere categorias
        $categorias = [
            ['nome' => 'Eletrônicos', 'descricao' => 'Produtos eletrônicos e tecnologia'],
            ['nome' => 'Roupas', 'descricao' => 'Vestuário e acessórios'],
            ['nome' => 'Casa e Jardim', 'descricao' => 'Produtos para casa e jardim'],
            ['nome' => 'Esportes', 'descricao' => 'Artigos esportivos e fitness'],
            ['nome' => 'Livros', 'descricao' => 'Livros e materiais educacionais']
        ];
        
        foreach ($categorias as $categoria) {
            // Verifica se já existe
            $existing = $this->db->get_where('categorias', ['nome' => $categoria['nome']])->row();
            if (!$existing) {
                $this->db->insert('categorias', $categoria);
            }
        }
        
        echo "<p style='color: green;'>✅ Categorias inseridas!</p>";
        
        // Insere usuários padrão
        $usuarios = [
            [
                'nome' => 'Administrador',
                'email' => 'admin@loja.com',
                'senha' => password_hash('admin123', PASSWORD_DEFAULT),
                'tipo_usuario' => 'admin'
            ],
            [
                'nome' => 'Estoquista',
                'email' => 'estoque@loja.com',
                'senha' => password_hash('estoque123', PASSWORD_DEFAULT),
                'tipo_usuario' => 'estoquista'
            ],
            [
                'nome' => 'Cliente Teste',
                'email' => 'cliente@loja.com',
                'senha' => password_hash('cliente123', PASSWORD_DEFAULT),
                'tipo_usuario' => 'cliente'
            ]
        ];
        
        foreach ($usuarios as $usuario) {
            // Verifica se já existe
            $existing = $this->db->get_where('usuarios', ['email' => $usuario['email']])->row();
            if (!$existing) {
                $this->db->insert('usuarios', $usuario);
            }
        }
        
        echo "<p style='color: green;'>✅ Usuários padrão inseridos!</p>";
        
        // Insere alguns produtos de exemplo
        $produtos = [
            [
                'nome' => 'Smartphone Samsung Galaxy',
                'descricao' => 'Smartphone com 128GB de armazenamento',
                'preco' => 899.99,
                'quantidade' => 50,
                'categoria_id' => 1,
                'foto' => 'smartphone.jpg'
            ],
            [
                'nome' => 'Notebook Dell Inspiron',
                'descricao' => 'Notebook para uso profissional',
                'preco' => 2499.99,
                'quantidade' => 25,
                'categoria_id' => 1,
                'foto' => 'notebook.jpg'
            ]
        ];
        
        foreach ($produtos as $produto) {
            // Verifica se já existe
            $existing = $this->db->get_where('produtos', ['nome' => $produto['nome']])->row();
            if (!$existing) {
                $this->db->insert('produtos', $produto);
            }
        }
        
        echo "<p style='color: green;'>✅ Produtos de exemplo inseridos!</p>";
        echo "<h3>🎉 Migração concluída com sucesso!</h3>";
    }
}
