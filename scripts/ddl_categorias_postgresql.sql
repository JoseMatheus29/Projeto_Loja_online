-- ============================================
-- Dados das Categorias para PostgreSQL
-- ============================================

INSERT INTO categorias (nome, descricao, ativo) VALUES
('Eletrônicos', 'Produtos eletrônicos e tecnologia', TRUE),
('Roupas', 'Vestuário e acessórios', TRUE),
('Casa e Jardim', 'Produtos para casa e jardim', TRUE),
('Esportes', 'Artigos esportivos e fitness', TRUE),
('Livros', 'Livros e materiais educacionais', TRUE),
('Beleza', 'Produtos de beleza e cuidados pessoais', TRUE),
('Brinquedos', 'Brinquedos e jogos', TRUE),
('Automotivo', 'Peças e acessórios automotivos', TRUE)
ON CONFLICT (nome) DO NOTHING;

-- Produtos de exemplo
INSERT INTO produtos (nome, descricao, preco, quantidade, categoria_id, foto, ativo) VALUES
('Smartphone Samsung Galaxy', 'Smartphone com 128GB de armazenamento', 899.99, 50, 1, 'smartphone.jpg', TRUE),
('Notebook Dell Inspiron', 'Notebook para uso profissional', 2499.99, 25, 1, 'notebook.jpg', TRUE),
('Camiseta Polo', 'Camiseta polo masculina', 79.90, 100, 2, 'camiseta.jpg', TRUE),
('Tênis Nike Air', 'Tênis esportivo para corrida', 299.90, 75, 4, 'tenis.jpg', TRUE),
('Livro: Programação PHP', 'Livro sobre desenvolvimento PHP', 89.90, 30, 5, 'livro.jpg', TRUE),
('Perfume Importado', 'Perfume masculino importado', 199.90, 40, 6, 'perfume.jpg', TRUE),
('Carrinho de Controle Remoto', 'Brinquedo para crianças', 159.90, 60, 7, 'carrinho.jpg', TRUE),
('Óleo Motor 5W30', 'Óleo lubrificante para motor', 45.90, 200, 8, 'oleo.jpg', TRUE),
('Sofá 3 Lugares', 'Sofá confortável para sala', 1299.90, 15, 3, 'sofa.jpg', TRUE),
('Mesa de Jantar', 'Mesa de jantar para 6 pessoas', 899.90, 10, 3, 'mesa.jpg', TRUE)
ON CONFLICT DO NOTHING;
