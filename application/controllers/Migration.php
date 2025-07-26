<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration extends CI_Controller {
    
    public function index() {
        echo "<h1>🚀 Migração de Banco de Dados - JM Commerce (MySQL)</h1>";
        
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
        echo "<h1>🔧 Executando Migração para MySQL...</h1>";
        
        try {
            // SQL para MySQL, baseado nos arquivos ddl.sql e ddl_categorias.sql
            $sql_structure = "
            CREATE TABLE `pedidos` (
              `id` int(64) NOT NULL,
              `id_produtos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
              `id_usuario` int(64) NOT NULL,
              `status` varchar(64) NOT NULL,
              `data_entrega` date DEFAULT NULL,
              `valor` int(64) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            CREATE TABLE `produtos` (
              `id` int(11) NOT NULL,
              `nome` varchar(255) NOT NULL,
              `tamanho` varchar(5) NOT NULL,
              `valor` float NOT NULL,
              `descricao` text NOT NULL,
              `quantidade` int(11) UNSIGNED NOT NULL,
              `foto` varchar(255) NOT NULL,
              `status` tinyint(1) NOT NULL
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            CREATE TABLE `usuarios` (
              `user_id` int(255) NOT NULL,
              `nome` varchar(64) NOT NULL,
              `email` varchar(64) NOT NULL,
              `telefone` int(11) NOT NULL,
              `carrinho` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
              `tipo` varchar(10) NOT NULL DEFAULT 'cliente',
              `logado` tinyint(1) NOT NULL,
              `senha` varchar(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            CREATE TABLE IF NOT EXISTS `categorias` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `nome` VARCHAR(100) NOT NULL,
                `descricao` TEXT,
                `status` TINYINT(1) DEFAULT 1
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            ALTER TABLE `pedidos`
              ADD PRIMARY KEY (`id`),
              ADD KEY `id_usuario` (`id_usuario`);

            ALTER TABLE `produtos`
              ADD PRIMARY KEY (`id`);

            ALTER TABLE `usuarios`
              ADD PRIMARY KEY (`user_id`);

            ALTER TABLE `pedidos`
              MODIFY `id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

            ALTER TABLE `produtos`
              MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

            ALTER TABLE `usuarios`
              MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

            ALTER TABLE `pedidos`
              ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`user_id`);
            ";
            
            // Executa a estrutura
            $queries = explode(';', $sql_structure);
            foreach ($queries as $query) {
                $query = trim($query);
                if (!empty($query)) {
                    $this->db->query($query);
                }
            }
            
            echo "<p style='color: green;'>✅ Estrutura das tabelas criada com sucesso!</p>";
            
            // Insere dados iniciais
            $this->insert_initial_data();
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Erro na migração: " . $e->getMessage() . "</p>";
        }
        
        echo "<p><a href='" . base_url('migration') . "'>🔙 Voltar</a></p>";
    }
    
    private function insert_initial_data() {
        // Limpa tabelas para evitar duplicatas, se necessário.
        // CUIDADO: Isso apaga todos os dados existentes.
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->truncate('pedidos');
        $this->db->truncate('produtos');
        $this->db->truncate('usuarios');
        $this->db->truncate('categorias');
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
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
