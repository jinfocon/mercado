-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: bdhost0038.servidorwebfacil.com:3306
-- Tempo de geração: 21/05/2023 às 11:21
-- Versão do servidor: 5.7.29-log
-- Versão do PHP: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mercado`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `impostos_tipos_produto`
--

CREATE TABLE `impostos_tipos_produto` (
  `tipo_id` int(11) DEFAULT NULL,
  `imposto` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `impostos_tipos_produto`
--

INSERT INTO `impostos_tipos_produto` (`tipo_id`, `imposto`) VALUES
(NULL, 0.00),
(NULL, 0.00),
(1, 0.00),
(2, 2.00),
(4, 3.00),
(3, 1.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `tipo_id` int(11) DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `tipo_id`, `valor`) VALUES
(1, 'Guaraná Antarctica 600ml', 3, 3.50),
(2, 'Guaraná Antarctica 2LT', 3, 5.00),
(3, 'Bolacha Recheada', 2, 30.00),
(4, 'Alcatra', 4, 30.00),
(5, 'Picanha', 4, 23.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipos_produto`
--

CREATE TABLE `tipos_produto` (
  `id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `tipos_produto`
--

INSERT INTO `tipos_produto` (`id`, `tipo`) VALUES
(1, 'Laticínios'),
(2, 'Cereais'),
(3, 'Bebidas'),
(4, 'Carnes');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `impostos_tipos_produto`
--
ALTER TABLE `impostos_tipos_produto`
  ADD KEY `tipo_id` (`tipo_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_id` (`tipo_id`);

--
-- Índices de tabela `tipos_produto`
--
ALTER TABLE `tipos_produto`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tipos_produto`
--
ALTER TABLE `tipos_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `impostos_tipos_produto`
--
ALTER TABLE `impostos_tipos_produto`
  ADD CONSTRAINT `impostos_tipos_produto_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `tipos_produto` (`id`);

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `tipos_produto` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
