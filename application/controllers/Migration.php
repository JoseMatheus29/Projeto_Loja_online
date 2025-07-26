<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration extends CI_Controller {
    
    public function index() {
        echo "<h1>🚀 Migração de Banco de Dados - JM Commerce (PostgreSQL)</h1>";
        
        // Testa a conexão
        if (!$this->db->conn_id) {
            echo "<p style='color: red;'>❌ Erro: Não foi possível conectar ao banco de dados.</p>";
            echo "<p>Verifique as configurações no arquivo de configuração do banco de dados.</p>";
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
            echo "<p style='color: green;'>✅ Banco de dados já parece estar configurado!</p>";
        }
    }
    
    public function run() {
        $startTime = date('H:i:s');
        echo "<h1>🔧 Executando Migração para PostgreSQL... <small>($startTime)</small></h1>";
        
        try {
            $stepTime = date('H:i:s');
            echo "<p><b>[$stepTime]</b> <span style='color:blue;'>Iniciando remoção das tabelas antigas...</span></p>";
            $drop_tables_sql = "
                DROP TABLE IF EXISTS pedidos CASCADE;
                DROP TABLE IF EXISTS produtos CASCADE;
                DROP TABLE IF EXISTS usuarios CASCADE;
                DROP TABLE IF EXISTS categorias CASCADE;
            ";
            $queries = explode(';', $drop_tables_sql);
            foreach ($queries as $query) {
                $query = trim($query);
                if (!empty($query)) {
                    $this->db->query($query);
                }
            }
            $stepTime = date('H:i:s');
            echo "<p style='color: orange;'><b>[$stepTime]</b> ⚠️ Tabelas antigas foram removidas (se existiam).</p>";

            $stepTime = date('H:i:s');
            echo "<p><b>[$stepTime]</b> <span style='color:blue;'>Criando estrutura das tabelas...</span></p>";
            // SQL para PostgreSQL, traduzido da estrutura original do MySQL
            $sql_structure = "
            CREATE TABLE usuarios (
                user_id SERIAL PRIMARY KEY,
                nome VARCHAR(64) NOT NULL,
                email VARCHAR(64) NOT NULL UNIQUE,
                telefone BIGINT NOT NULL,
                carrinho TEXT DEFAULT NULL,
                tipo VARCHAR(10) NOT NULL DEFAULT 'cliente',
                logado SMALLINT NOT NULL DEFAULT 0,
                senha VARCHAR(255) NOT NULL
            );

            CREATE TABLE categorias (
                id SERIAL PRIMARY KEY,
                nome VARCHAR(100) NOT NULL,
                descricao TEXT,
                status SMALLINT DEFAULT 1
            );

            CREATE TABLE pedidos (
                id SERIAL PRIMARY KEY,
                id_produtos TEXT NOT NULL,
                id_usuario INTEGER NOT NULL,
                status VARCHAR(64) NOT NULL,
                data_entrega DATE DEFAULT NULL,
                valor INTEGER NOT NULL,
                CONSTRAINT fk_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(user_id)
            );

            CREATE TABLE produtos (
                id SERIAL PRIMARY KEY,
                nome VARCHAR(255) NOT NULL,
                tamanho VARCHAR(5) NOT NULL,
                valor DECIMAL(10, 2) NOT NULL,
                descricao TEXT NOT NULL,
                quantidade INTEGER NOT NULL,
                foto VARCHAR(255) NOT NULL,
                status SMALLINT NOT NULL,
                categoria_id INTEGER,
                CONSTRAINT fk_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
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
            $stepTime = date('H:i:s');
            echo "<p style='color: green;'><b>[$stepTime]</b> ✅ Estrutura das tabelas criada com sucesso!</p>";

            $stepTime = date('H:i:s');
            echo "<p><b>[$stepTime]</b> <span style='color:blue;'>Inserindo dados iniciais...</span></p>";
            // Insere dados iniciais
            $this->insert_initial_data();
            $stepTime = date('H:i:s');
            echo "<p style='color: green;'><b>[$stepTime]</b> 🎉 Dados iniciais inseridos com sucesso!</p>";

        } catch (Exception $e) {
            $stepTime = date('H:i:s');
            echo "<p style='color: red;'><b>[$stepTime]</b> ❌ Erro na migração: " . $e->getMessage() . "</p>";
        }

        $endTime = date('H:i:s');
        echo "<p><b>[$endTime]</b> <a href='" . base_url('migration') . "'>🔙 Voltar</a></p>";
    }
    
    private function insert_initial_data() {
        // A linha TRUNCATE foi removida daqui, pois as tabelas são recriadas do zero.
        echo "<p style='color: orange;'>⚠️ Tabelas existentes foram limpas.</p>";

        // Insere dados em 'usuarios'
        $usuarios = [
            ['user_id' => 10, 'nome' => 'João Silva', 'email' => 'joao.silva@example.com', 'telefone' => 123456789, 'carrinho' => null, 'tipo' => 'adm', 'logado' => 0, 'senha' => ''],
            ['user_id' => 11, 'nome' => 'Maria Santos', 'email' => 'maria.santos@example.com', 'telefone' => 987654321, 'carrinho' => null, 'tipo' => 'estoquista', 'logado' => 0, 'senha' => ''],
            ['user_id' => 12, 'nome' => 'Pedro Oliveira', 'email' => 'pedro.oliveira@example.com', 'telefone' => 111111111, 'carrinho' => null, 'tipo' => 'cliente', 'logado' => 0, 'senha' => ''],
            ['user_id' => 13, 'nome' => 'Ana Souza', 'email' => 'ana.souza@example.com', 'telefone' => 222222222, 'carrinho' => null, 'tipo' => 'cliente', 'logado' => 0, 'senha' => ''],
            ['user_id' => 14, 'nome' => 'Luiz Pereira', 'email' => 'luiz.pereira@example.com', 'telefone' => 333333333, 'carrinho' => null, 'tipo' => 'cliente', 'logado' => 0, 'senha' => ''],
            ['user_id' => 15, 'nome' => 'Carla Costa', 'email' => 'carla.costa@example.com', 'telefone' => 444444444, 'carrinho' => null, 'tipo' => 'cliente', 'logado' => 0, 'senha' => ''],
            ['user_id' => 16, 'nome' => 'Fernanda Almeida', 'email' => 'fernanda.almeida@example.com', 'telefone' => 555555555, 'carrinho' => null, 'tipo' => 'cliente', 'logado' => 0, 'senha' => ''],
            ['user_id' => 17, 'nome' => 'Ricardo Martins', 'email' => 'ricardo.martins@example.com', 'telefone' => 666666666, 'carrinho' => null, 'tipo' => 'cliente', 'logado' => 0, 'senha' => ''],
            ['user_id' => 18, 'nome' => 'Camila Lima', 'email' => 'camila.lima@example.com', 'telefone' => 777777777, 'carrinho' => null, 'tipo' => 'cliente', 'logado' => 0, 'senha' => ''],
            ['user_id' => 1, 'nome' => 'admin', 'email' => 'admin@admin.com', 'telefone' => 999999999, 'carrinho' => null, 'tipo' => 'adm', 'logado' => 0, 'senha' => 'admin123'],
            ['user_id' => 31, 'nome' => 'José Matheus', 'email' => 'mateus.alvino.101@gmail.com', 'telefone' => 2147483647, 'carrinho' => null, 'tipo' => 'adm', 'logado' => 0, 'senha' => '732002cec7aeb7987bde842b9e00ee3b'],
            ['user_id' => 32, 'nome' => 'José Matheus', 'email' => 'mateus.alvino.100@gmail.com', 'telefone' => 2147483647, 'carrinho' => '[[],[{\"id_produto\":\"17\",\"idUsuario\":\"32\"}]]', 'tipo' => 'cliente', 'logado' => 0, 'senha' => '732002cec7aeb7987bde842b9e00ee3b'],
            ['user_id' => 33, 'nome' => 'Matheus', 'email' => 'mateusteste@gmail.com', 'telefone' => 2147483647, 'carrinho' => null, 'tipo' => 'estoquista', 'logado' => 0, 'senha' => '732002cec7aeb7987bde842b9e00ee3b'],
            ['user_id' => 34, 'nome' => 'teste', 'email' => 'teste@gmail.com', 'telefone' => 1235678910, 'carrinho' => null, 'tipo' => 'cliente', 'logado' => 0, 'senha' => '732002cec7aeb7987bde842b9e00ee3b'],
            ['user_id' => 37, 'nome' => 'Matheus', 'email' => 'mateus.alvino.2909@outlook.com', 'telefone' => 2147483647, 'carrinho' => null, 'tipo' => 'estoquista', 'logado' => 0, 'senha' => '732002cec7aeb7987bde842b9e00ee3b'],
        ];
        $this->db->insert_batch('usuarios', $usuarios);
        echo "<p style='color: green;'>✅ Dados de usuários inseridos!</p>";

        // Insere dados em 'produtos'
        $produtos = [
            ['id' => 10, 'nome' => 'Blusa Vinho', 'tamanho' => 'P', 'valor' => 29.99, 'descricao' => 'Blusa Vinho', 'quantidade' => 14, 'foto' => 'image-6.png', 'status' => 0],
            ['id' => 11, 'nome' => 'Blusa Rosa', 'tamanho' => 'M', 'valor' => 29.99, 'descricao' => 'Blusa rosa de algodão tamanho M', 'quantidade' => 24, 'foto' => 'image-1.png', 'status' => 0],
            ['id' => 12, 'nome' => 'Blusa Marrom', 'tamanho' => 'G', 'valor' => 29.99, 'descricao' => 'Blusa marrom de algodão tamanho G', 'quantidade' => 26, 'foto' => 'image-2.png', 'status' => 0],
            ['id' => 13, 'nome' => 'Blusa Azul Claro', 'tamanho' => 'GG', 'valor' => 29.99, 'descricao' => 'Blusa azul claro de algodão tamanho GG', 'quantidade' => 19, 'foto' => 'image-3.png', 'status' => 0],
            ['id' => 14, 'nome' => 'Blusa Azul Escuro', 'tamanho' => 'P', 'valor' => 29.99, 'descricao' => 'Blusa azul escuro de algodão tamanho P', 'quantidade' => 2, 'foto' => 'image-4.png', 'status' => 0],
            ['id' => 15, 'nome' => 'Blusa Cinza Clar', 'tamanho' => 'M', 'valor' => 28.99, 'descricao' => 'Blusa Cinza Clar', 'quantidade' => 4, 'foto' => 'image-1.png', 'status' => 0],
            ['id' => 16, 'nome' => 'Blusa Bege', 'tamanho' => 'G', 'valor' => 30.99, 'descricao' => 'Blusa Cinza ', 'quantidade' => 5, 'foto' => 'image-01.png', 'status' => 0],
            ['id' => 17, 'nome' => 'Blusa Verde', 'tamanho' => 'GG', 'valor' => 29.99, 'descricao' => 'Blusa verde de algodão tamanho GG', 'quantidade' => 11, 'foto' => 'image-7.png', 'status' => 0],
            ['id' => 18, 'nome' => 'Blusa vermelha', 'tamanho' => 'P', 'valor' => 30.99, 'descricao' => 'Blusa vermelha', 'quantidade' => 1, 'foto' => 'image-6.png', 'status' => 0],
        ];
        $this->db->insert_batch('produtos', $produtos);
        echo "<p style='color: green;'>✅ Dados de produtos inseridos!</p>";

        // Insere dados em 'pedidos'
        $pedidos = [
            ['id' => 11, 'id_produtos' => '15,16', 'id_usuario' => 31, 'status' => 'Processo de entrega', 'data_entrega' => '2024-03-26', 'valor' => 60],
            ['id' => 12, 'id_produtos' => '18,16', 'id_usuario' => 31, 'status' => 'Processo de entrega', 'data_entrega' => '2024-03-26', 'valor' => 62],
            ['id' => 13, 'id_produtos' => '13', 'id_usuario' => 31, 'status' => 'Processo de entrega', 'data_entrega' => '2024-03-27', 'valor' => 30],
            ['id' => 14, 'id_produtos' => '10,11', 'id_usuario' => 37, 'status' => 'Processo de entrega', 'data_entrega' => '2024-03-27', 'valor' => 60],
        ];
        $this->db->insert_batch('pedidos', $pedidos);
        echo "<p style='color: green;'>✅ Dados de pedidos inseridos!</p>";

        // Insere dados em 'categorias'
        $categorias = [
            ['nome' => 'Roupas', 'descricao' => 'Vestuario em geral', 'status' => 1],
            ['nome' => 'Calcado', 'descricao' => 'Sapatos, tenis, sandalias', 'status' => 1],
            ['nome' => 'Acessorios', 'descricao' => 'Bolsas, cintos, etc.', 'status' => 1],
        ];
        $this->db->insert_batch('categorias', $categorias);
        echo "<p style='color: green;'>✅ Dados de categorias inseridos!</p>";

        echo "<h3>🎉 Migração concluída com sucesso!</h3>";
    }
}
