-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Nov-2021 às 16:51
-- Versão do servidor: 10.4.21-MariaDB
-- versão do PHP: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `estoque`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_AtualizaEstoque` (`id_prod` INT, `qtde_comprada` INT, `valor_unit` DECIMAL(9,2))  BEGIN
    declare contador int(11);

    SELECT count(*) into contador FROM estoque WHERE id_produto = id_prod;

    IF contador > 0 THEN
        UPDATE estoque SET qtde=qtde + qtde_comprada, valor_unitario= valor_unit
        WHERE id_produto = id_prod;
    ELSE
        INSERT INTO estoque (id_produto, qtde, valor_unitario) values (id_prod, qtde_comprada, valor_unit);
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_bin NOT NULL,
  `id_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `id_categoria`) VALUES
(1, 'Categoria 1', NULL),
(2, 'Categoria 2', NULL),
(3, 'Categoria 3', NULL),
(4, 'Categoria 4', NULL),
(5, 'Categoria 5', NULL),
(6, 'Categoria 6', NULL),
(7, 'Categoria 7', NULL),
(8, 'Categoria 8', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrada_produto`
--

CREATE TABLE `entrada_produto` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `qtde` int(11) DEFAULT NULL,
  `valor_unitario` decimal(9,2) DEFAULT 0.00,
  `data_entrada` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Acionadores `entrada_produto`
--
DELIMITER $$
CREATE TRIGGER `TRG_EntradaProduto_AD` AFTER DELETE ON `entrada_produto` FOR EACH ROW BEGIN
      CALL SP_AtualizaEstoque (old.id_produto, old.qtde * -1, old.valor_unitario);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRG_EntradaProduto_AI` AFTER INSERT ON `entrada_produto` FOR EACH ROW BEGIN
      CALL SP_AtualizaEstoque (new.id_produto, new.qtde, new.valor_unitario);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRG_EntradaProduto_AU` AFTER UPDATE ON `entrada_produto` FOR EACH ROW BEGIN
      CALL SP_AtualizaEstoque (new.id_produto, new.qtde - old.qtde, new.valor_unitario);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

CREATE TABLE `estoque` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `qtde` int(11) DEFAULT NULL,
  `valor_unitario` decimal(9,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`id`, `nome`) VALUES
(1, 'Fornecedor 1'),
(2, 'Fornecedor 2'),
(3, 'Fornecedor 3'),
(4, 'Fornecedor 4'),
(5, 'Fornecedor 5'),
(6, 'Fornecedor 6');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lista`
--

CREATE TABLE `lista` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `lista`
--

INSERT INTO `lista` (`id`, `nome`) VALUES
(1, 'teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lista_produto`
--

CREATE TABLE `lista_produto` (
  `id_produto` int(11) NOT NULL,
  `id_lista` int(11) NOT NULL DEFAULT 1,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `valor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `lista_produto`
--

INSERT INTO `lista_produto` (`id_produto`, `id_lista`, `quantidade`, `valor`) VALUES
(2, 1, 1, 3.6),
(3, 1, 1, 2),
(4, 1, 1, 2.56),
(1, 1, 1, 2.5),
(2, 1, 1, 3.6),
(3, 1, 1, 2),
(16, 1, 1, 23.18),
(21, 1, 1, 333.33);

-- --------------------------------------------------------

--
-- Estrutura da tabela `medida`
--

CREATE TABLE `medida` (
  `id` int(11) NOT NULL,
  `medida` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `medida`
--

INSERT INTO `medida` (`id`, `medida`) VALUES
(1, 'teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `nome` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `id_medida` int(11) DEFAULT NULL,
  `quantidade` float DEFAULT NULL,
  `id_fornecedor` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `valor` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `status`, `nome`, `id_medida`, `quantidade`, `id_fornecedor`, `id_categoria`, `valor`) VALUES
(1, 0, 'Produto A', 1, 1, 1, 1, 2.5),
(2, 0, 'Produto A', 1, 2, 2, 1, 3.6),
(3, 0, 'Produto A', 1, 2, 3, 1, 2),
(4, 0, 'Produto B', 1, 2, 1, 1, 2.56),
(5, 0, 'Produto B', 1, 2, 2, 1, 2.06),
(6, 0, 'Produto B', 1, 2, 3, 1, 2.76),
(7, 0, 'Produto C', 1, 2, 1, 1, 2.65),
(8, 0, 'Produto C', 1, 2, 2, 1, 2.56),
(9, 0, 'Produto C', 1, 2, 3, 1, 2),
(10, 0, 'Produto D', 1, 2, 1, 4, 25.6),
(11, 0, 'Produto D', 1, 2, 2, 1, 23.18),
(12, 0, 'Produto D', 1, 2, 3, 1, 25),
(13, 0, 'Produto E', 1, 2, 1, 1, 23.11),
(14, 0, 'Produto E', 1, 2, 2, 1, 23.18),
(15, 0, 'Produto E', 1, 2, 3, 1, 23.12),
(16, 0, 'Produto F', 1, 2, 1, 1, 23.18),
(17, 0, 'Produto F', 1, 2, 2, 1, 22.22),
(18, 0, 'Produto F', 1, 3, 3, 1, 33.33),
(19, 0, 'Produto G', 1, 2, 1, 1, 343.44),
(20, 0, 'Produto G', 1, 2, 2, 1, 324.33),
(21, 0, 'Produto G', 1, 2, 3, 1, 333.33),
(23, 0, 'teste3', 1, 2, 1, 1, 20);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_fornecedor`
--

CREATE TABLE `produto_fornecedor` (
  `id_produto` int(11) NOT NULL,
  `id_fornecedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `saida_produto`
--

CREATE TABLE `saida_produto` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `qtde` int(11) DEFAULT NULL,
  `data_saida` date DEFAULT NULL,
  `valor_unitario` decimal(9,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Acionadores `saida_produto`
--
DELIMITER $$
CREATE TRIGGER `TRG_SaidaProduto_AD` AFTER DELETE ON `saida_produto` FOR EACH ROW BEGIN
      CALL SP_AtualizaEstoque (old.id_produto, old.qtde, old.valor_unitario);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRG_SaidaProduto_AI` AFTER INSERT ON `saida_produto` FOR EACH ROW BEGIN
      CALL SP_AtualizaEstoque (new.id_produto, new.qtde * -1, new.valor_unitario);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRG_SaidaProduto_AU` AFTER UPDATE ON `saida_produto` FOR EACH ROW BEGIN
      CALL SP_AtualizaEstoque (new.id_produto, old.qtde - new.qtde, new.valor_unitario);
END
$$
DELIMITER ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Índices para tabela `entrada_produto`
--
ALTER TABLE `entrada_produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices para tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices para tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `lista`
--
ALTER TABLE `lista`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `lista_produto`
--
ALTER TABLE `lista_produto`
  ADD KEY `id_produto` (`id_produto`),
  ADD KEY `id_lista` (`id_lista`);

--
-- Índices para tabela `medida`
--
ALTER TABLE `medida`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_fornecedor` (`id_fornecedor`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_medida` (`id_medida`);

--
-- Índices para tabela `produto_fornecedor`
--
ALTER TABLE `produto_fornecedor`
  ADD KEY `id_produto` (`id_produto`,`id_fornecedor`),
  ADD KEY `FORNECEDOR_PRODUTO` (`id_fornecedor`);

--
-- Índices para tabela `saida_produto`
--
ALTER TABLE `saida_produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produto` (`id_produto`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `entrada_produto`
--
ALTER TABLE `entrada_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `lista`
--
ALTER TABLE `lista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `medida`
--
ALTER TABLE `medida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `saida_produto`
--
ALTER TABLE `saida_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `CATEGORIA_SUBCATEGORIA` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`);

--
-- Limitadores para a tabela `entrada_produto`
--
ALTER TABLE `entrada_produto`
  ADD CONSTRAINT `ENTRADA_PRODUTO` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id`);

--
-- Limitadores para a tabela `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `PRODUTO_ESTOQUE` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id`);

--
-- Limitadores para a tabela `lista_produto`
--
ALTER TABLE `lista_produto`
  ADD CONSTRAINT `LISTA_LISTA` FOREIGN KEY (`id_lista`) REFERENCES `lista` (`id`),
  ADD CONSTRAINT `LISTA_PRODUTO` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id`);

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `PRODUTO_CATEGORIA` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `PRODUTO_MEDIDA` FOREIGN KEY (`id_medida`) REFERENCES `medida` (`id`);

--
-- Limitadores para a tabela `produto_fornecedor`
--
ALTER TABLE `produto_fornecedor`
  ADD CONSTRAINT `FORNECEDOR_PRODUTO` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id`),
  ADD CONSTRAINT `PRODUTO_FORNECEDOR` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id`);

--
-- Limitadores para a tabela `saida_produto`
--
ALTER TABLE `saida_produto`
  ADD CONSTRAINT `SAIDA_PRODUTO` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
