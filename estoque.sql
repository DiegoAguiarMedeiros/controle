-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20-Mar-2022 às 20:53
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.4.27

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
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_AtualizaEstoque` (IN `id_prod` INT, IN `qtde_comprada` INT, IN `valor_unit` DECIMAL(9,2))  BEGIN
    
    declare contador int(11);
    declare media float(11,2);

    SELECT count(*) into contador FROM estoque WHERE id_produto = id_prod;
    SELECT (SUM(qtde * valor_unitario) / SUM(qtde)) into media FROM entrada_produto WHERE id_produto = id_prod AND data_entrada > DATE_ADD(CURRENT_DATE(),INTERVAL '-30' DAY);
    INSERT INTO conferencia (dados) values (id_prod);
    INSERT INTO conferencia (dados) values (qtde_comprada);
    INSERT INTO conferencia (dados) values (valor_unit);
    INSERT INTO conferencia (dados) values ('--');
    IF contador > 0 THEN
        IF media > 0 THEN
            UPDATE estoque SET qtde=qtde + qtde_comprada, valor_unitario= media
            WHERE id_produto = id_prod;
        ELSE
            UPDATE estoque SET qtde=qtde + qtde_comprada, valor_unitario= valor_unit
            WHERE id_produto = id_prod;
        END IF;
    ELSE
        INSERT INTO estoque (id_produto, qtde, valor_unitario,id_usuario) values (id_prod, qtde_comprada, valor_unit,1);
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
  `id_categoria` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `id_categoria`, `id_usuario`) VALUES
(1, 'Insumo', NULL, 1),
(34, 'Produto Final', NULL, 1),
(35, 'Massa', NULL, 1),
(36, 'Embalagem', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `conferencia`
--

CREATE TABLE `conferencia` (
  `id` int(11) NOT NULL,
  `dados` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `conferencia`
--

INSERT INTO `conferencia` (`id`, `dados`) VALUES
(0, '1'),
(0, '2'),
(0, '2.50'),
(0, '--'),
(0, '1'),
(0, '2'),
(0, '2.50'),
(0, '--'),
(0, '4'),
(0, '3'),
(0, '4.50'),
(0, '--'),
(0, '7'),
(0, '4'),
(0, '4.50'),
(0, '--'),
(0, '1'),
(0, '2'),
(0, '2.50'),
(0, '--'),
(0, '4'),
(0, '3'),
(0, '4.50'),
(0, '--'),
(0, '7'),
(0, '4'),
(0, '4.50'),
(0, '--'),
(0, '29'),
(0, '3'),
(0, '2.50'),
(0, '--'),
(0, '29'),
(0, '3'),
(0, '2.50'),
(0, '--'),
(0, '29'),
(0, '2'),
(0, '50.00'),
(0, '--'),
(0, '1'),
(0, '-2'),
(0, '2.50'),
(0, '--'),
(0, '1'),
(0, '-2'),
(0, '2.50'),
(0, '--'),
(0, '1'),
(0, '-2'),
(0, '2.50'),
(0, '--'),
(0, '1'),
(0, '-2'),
(0, '2.50'),
(0, '--'),
(0, '4'),
(0, '-3'),
(0, '4.50'),
(0, '--'),
(0, '7'),
(0, '-4'),
(0, '4.50'),
(0, '--'),
(0, '1'),
(0, '-2'),
(0, '2.50'),
(0, '--'),
(0, '4'),
(0, '-3'),
(0, '4.50'),
(0, '--'),
(0, '7'),
(0, '-4'),
(0, '4.50'),
(0, '--'),
(0, '29'),
(0, '-3'),
(0, '2.50'),
(0, '--'),
(0, '29'),
(0, '-3'),
(0, '2.50'),
(0, '--'),
(0, '29'),
(0, '-2'),
(0, '50.00'),
(0, '--'),
(0, '1'),
(0, '3'),
(0, '2.50'),
(0, '--'),
(0, '4'),
(0, '2'),
(0, '5.00'),
(0, '--'),
(0, '7'),
(0, '4'),
(0, '3.00'),
(0, '--'),
(0, '29'),
(0, '2'),
(0, '23.00'),
(0, '--'),
(0, '1'),
(0, '1'),
(0, '50.00'),
(0, '--'),
(0, '29'),
(0, '3'),
(0, '2.00'),
(0, '--'),
(0, '1'),
(0, '-3'),
(0, '2.50'),
(0, '--'),
(0, '4'),
(0, '-2'),
(0, '5.00'),
(0, '--'),
(0, '7'),
(0, '-4'),
(0, '3.00'),
(0, '--'),
(0, '29'),
(0, '-2'),
(0, '23.00'),
(0, '--'),
(0, '1'),
(0, '-1'),
(0, '50.00'),
(0, '--'),
(0, '29'),
(0, '-3'),
(0, '2.00'),
(0, '--'),
(0, '1'),
(0, '2'),
(0, '30.00'),
(0, '--'),
(0, '1'),
(0, '4'),
(0, '50.00'),
(0, '--'),
(0, '29'),
(0, '10'),
(0, '2.50'),
(0, '--'),
(0, '7'),
(0, '20'),
(0, '3.50'),
(0, '--'),
(0, '7'),
(0, '-10'),
(0, '20.00'),
(0, '--'),
(0, '1'),
(0, '-3'),
(0, '2.50'),
(0, '--');

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
-- Extraindo dados da tabela `entrada_produto`
--

INSERT INTO `entrada_produto` (`id`, `id_produto`, `qtde`, `valor_unitario`, `data_entrada`) VALUES
(31, 1, 2, '30.00', '2022-03-02'),
(32, 1, 4, '50.00', '2022-03-02'),
(33, 29, 10, '2.50', '2022-03-02'),
(34, 7, 20, '3.50', '2022-03-02');

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
  `valor_unitario` decimal(9,2) DEFAULT 0.00,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `estoque`
--

INSERT INTO `estoque` (`id`, `id_produto`, `qtde`, `valor_unitario`, `id_usuario`) VALUES
(10, 1, 3, '43.33', 1),
(11, 29, 10, '2.50', 1),
(12, 7, 10, '3.50', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ficha_tecnica`
--

CREATE TABLE `ficha_tecnica` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `ficha_tecnica`
--

INSERT INTO `ficha_tecnica` (`id`, `nome`) VALUES
(1, 'teste'),
(2, 'teste2'),
(3, 'teste3'),
(4, 'teste4');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ficha_tecnica_conteudo`
--

CREATE TABLE `ficha_tecnica_conteudo` (
  `id_ficha_tecnica` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_bin NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`id`, `nome`, `id_usuario`) VALUES
(37, 'Sempre Tem', 1),
(38, 'Ok', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `lista`
--

CREATE TABLE `lista` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) COLLATE utf8_bin NOT NULL,
  `id_usuario` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `lista`
--

INSERT INTO `lista` (`id`, `nome`, `id_usuario`) VALUES
(1, 'teste', 1);

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
(53, 1, 1, 0),
(1, 1, 1, 0),
(32, 1, 1, 0),
(50, 1, 1, 0);

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
(1, 'Litro'),
(2, 'Kg'),
(3, 'Un');

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
  `id_categoria` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `status`, `nome`, `id_medida`, `quantidade`, `id_categoria`, `id_usuario`) VALUES
(1, 0, 'Ovos', 3, 30, 1, 1),
(7, 0, 'Farinha de Arroz', 2, 1, 1, 1),
(29, 0, 'Manteiga', 2, 1, 1, 1),
(31, 0, 'Açúcar Refinado ', 2, 1, 1, 1),
(32, 0, 'Leite Condensado Moça', 2, 0.395, 1, 1),
(33, 0, 'Creme de Leite Nestle', 2, 0.2, 1, 1),
(36, 0, 'Gotas AO LEITE Melken', 2, 2.1, 1, 1),
(37, 0, 'Gotas BRANCO Melken', 2, 2.1, 1, 1),
(38, 0, 'Forminha n0 Branca', 3, 100, 36, 1),
(39, 0, 'Luvas', 3, 100, 1, 1),
(40, 0, 'Tag + Fio Sisal', 3, 500, 36, 1),
(41, 0, 'Adesivo Validade', 3, 500, 36, 1),
(42, 0, 'Saco de Papel P', 3, 100, 36, 1),
(43, 0, 'Caixa Kraft 3 Brig', 3, 100, 36, 1),
(44, 0, 'Leite em Pó Ninho', 2, 0.4, 1, 1),
(45, 0, 'Cacau em pó 50%', 2, 0.5, 1, 1),
(46, 0, 'Granulê BRANCO Melken', 2, 0.4, 1, 1),
(47, 0, 'Plástico Filme 100m', 3, 1, 1, 1),
(48, 0, 'Forminha n4 Branca', 3, 500, 36, 1),
(49, 0, 'Saco de Papel M', 3, 100, 36, 1),
(50, 0, 'Cacau em pó 100%', 2, 0.5, 1, 1),
(51, 0, 'Granulê AO LEITE Melken', 2, 0.4, 1, 1),
(52, 0, 'Arroz Japonês Grão Curto', 2, 1, 1, 1),
(53, 0, 'Maisena', 2, 0.2, 1, 1),
(54, 0, 'Açúcar Mascavo', 2, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_fornecedor`
--

CREATE TABLE `produto_fornecedor` (
  `id_produto` int(11) NOT NULL,
  `id_fornecedor` int(11) NOT NULL,
  `valor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `produto_fornecedor`
--

INSERT INTO `produto_fornecedor` (`id_produto`, `id_fornecedor`, `valor`) VALUES
(53, 37, 2),
(53, 38, 1.9),
(1, 38, 13),
(50, 38, 15),
(32, 38, 7),
(1, 37, 12),
(32, 37, 5.9),
(50, 37, 20);

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
-- Extraindo dados da tabela `saida_produto`
--

INSERT INTO `saida_produto` (`id`, `id_produto`, `qtde`, `data_saida`, `valor_unitario`) VALUES
(1, 7, 10, '2022-03-02', '20.00'),
(2, 1, 3, '2022-03-02', '2.50');

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

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`) VALUES
(1, 'Samanta dos Santos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_acesso`
--

CREATE TABLE `usuario_acesso` (
  `login` varchar(14) COLLATE utf8_bin NOT NULL,
  `senha` varchar(50) COLLATE utf8_bin NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_usuario` (`id_usuario`);

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
  ADD KEY `id_produto` (`id_produto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `ficha_tecnica`
--
ALTER TABLE `ficha_tecnica`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `ficha_tecnica_conteudo`
--
ALTER TABLE `ficha_tecnica_conteudo`
  ADD KEY `id_ficha_tecnica` (`id_ficha_tecnica`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Índices para tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `lista`
--
ALTER TABLE `lista`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

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
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_medida` (`id_medida`),
  ADD KEY `id_usuario` (`id_usuario`);

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
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuario_acesso`
--
ALTER TABLE `usuario_acesso`
  ADD UNIQUE KEY `LOGIN` (`login`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `entrada_produto`
--
ALTER TABLE `entrada_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `ficha_tecnica`
--
ALTER TABLE `ficha_tecnica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `lista`
--
ALTER TABLE `lista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `medida`
--
ALTER TABLE `medida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `saida_produto`
--
ALTER TABLE `saida_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `CATEGORIA_SUBCATEGORIA` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `USUARIO_CATEGORIA` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `entrada_produto`
--
ALTER TABLE `entrada_produto`
  ADD CONSTRAINT `ENTRADA_PRODUTO` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id`);

--
-- Limitadores para a tabela `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `PRODUTO_ESTOQUE` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id`),
  ADD CONSTRAINT `USUARIO_ESTOQUE` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `ficha_tecnica_conteudo`
--
ALTER TABLE `ficha_tecnica_conteudo`
  ADD CONSTRAINT `FICHA_TECNICA` FOREIGN KEY (`id_ficha_tecnica`) REFERENCES `ficha_tecnica` (`id`),
  ADD CONSTRAINT `INGREDIENTE` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id`);

--
-- Limitadores para a tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD CONSTRAINT `USUARIO_FORNECEDOR` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Limitadores para a tabela `lista`
--
ALTER TABLE `lista`
  ADD CONSTRAINT `USUARIO_LISTA` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

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
  ADD CONSTRAINT `PRODUTO_MEDIDA` FOREIGN KEY (`id_medida`) REFERENCES `medida` (`id`),
  ADD CONSTRAINT `USUARIO_PRODUTO` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

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

--
-- Limitadores para a tabela `usuario_acesso`
--
ALTER TABLE `usuario_acesso`
  ADD CONSTRAINT `USUARIO_ACESSO` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
