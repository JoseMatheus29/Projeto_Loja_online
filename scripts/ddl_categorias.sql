-- Tabela de categorias
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    status TINYINT(1) DEFAULT 1
);

-- Categoria exemplo
INSERT INTO categorias (nome, descricao, status) VALUES ('Roupas', 'Vestuario em geral', 1), ('Calcado', 'Sapatos, tenis, sandalias', 1), ('Acessorios', 'Bolsas, cintos, etc.', 1);
