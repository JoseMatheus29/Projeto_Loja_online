SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `pedidos` (
  `id` int(64) NOT NULL,
  `id_produtos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `id_usuario` int(64) NOT NULL,
  `status` varchar(64) NOT NULL,
  `data_entrega` date DEFAULT current_timestamp(),
  `valor` int(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `pedidos` (`id`, `id_produtos`, `id_usuario`, `status`, `data_entrega`, `valor`) VALUES
(11, '15,16', 31, 'Processo de entrega', '2024-03-26', 60),
(12, '18,16', 31, 'Processo de entrega', '2024-03-26', 62),
(13, '13', 31, 'Processo de entrega', '2024-03-27', 30),
(14, '10,11', 37, 'Processo de entrega', '2024-03-27', 60);



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


INSERT INTO `produtos` (`id`, `nome`, `tamanho`, `valor`, `descricao`, `quantidade`, `foto`, `status`) VALUES
(10, 'Blusa Vinho', 'P', 29.99, 'Blusa Vinho', 14, 'image-6.png', 0),
(11, 'Blusa Rosa', 'M', 29.99, 'Blusa rosa de algodão tamanho M', 24, 'image-1.png', 0),
(12, 'Blusa Marrom', 'G', 29.99, 'Blusa marrom de algodão tamanho G', 26, 'image-2.png', 0),
(13, 'Blusa Azul Claro', 'GG', 29.99, 'Blusa azul claro de algodão tamanho GG', 19, 'image-3.png', 0),
(14, 'Blusa Azul Escuro', 'P', 29.99, 'Blusa azul escuro de algodão tamanho P', 2, 'image-4.png', 0),
(15, 'Blusa Cinza Clar', 'M', 28.99, 'Blusa Cinza Clar', 4, 'image-1.png', 0),
(16, 'Blusa Bege', 'G', 30.99, 'Blusa Cinza ', 5, 'image-01.png', 0),
(17, 'Blusa Verde', 'GG', 29.99, 'Blusa verde de algodão tamanho GG', 11, 'image-7.png', 0),
(18, 'Blusa vermelha', 'P', 30.99, 'Blusa vermelha', 1, 'image-6.png', 0);


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


INSERT INTO `usuarios` (`user_id`, `nome`, `email`, `telefone`, `carrinho`, `tipo`, `logado`, `senha`) VALUES
(10, 'João Silva', 'joao.silva@example.com', 123456789, NULL, 'adm', 0, ''),
(11, 'Maria Santos', 'maria.santos@example.com', 987654321, NULL, 'estoquista', 0, ''),
(12, 'Pedro Oliveira', 'pedro.oliveira@example.com', 111111111, NULL, 'cliente', 0, ''),
(13, 'Ana Souza', 'ana.souza@example.com', 222222222, NULL, 'cliente', 0, ''),
(14, 'Luiz Pereira', 'luiz.pereira@example.com', 333333333, NULL, 'cliente', 0, ''),
(15, 'Carla Costa', 'carla.costa@example.com', 444444444, NULL, 'cliente', 0, ''),
(16, 'Fernanda Almeida', 'fernanda.almeida@example.com', 555555555, NULL, 'cliente', 0, ''),
(17, 'Ricardo Martins', 'ricardo.martins@example.com', 666666666, NULL, 'cliente', 0, ''),
(18, 'Camila Lima', 'camila.lima@example.com', 777777777, NULL, 'cliente', 0, ''),
(31, 'José Matheus', 'mateus.alvino.101@gmail.com', 2147483647, NULL, 'adm', 0, '732002cec7aeb7987bde842b9e00ee3b'),
(32, 'José Matheus', 'mateus.alvino.100@gmail.com', 2147483647, '[[],[{\"id_produto\":\"17\",\"idUsuario\":\"32\"}]]', 'cliente', 0, '732002cec7aeb7987bde842b9e00ee3b'),
(33, 'Matheus', 'mateusteste@gmail.com', 2147483647, NULL, 'estoquista', 0, '732002cec7aeb7987bde842b9e00ee3b'),
(34, 'teste', 'teste@gmail.com', 1235678910, NULL, 'cliente', 0, '732002cec7aeb7987bde842b9e00ee3b'),
(37, 'Matheus', 'mateus.alvino.2909@outlook.com', 2147483647, NULL, 'estoquista', 0, '732002cec7aeb7987bde842b9e00ee3b');


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
COMMIT;

