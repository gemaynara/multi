-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 20-Out-2020 às 11:08
-- Versão do servidor: 5.7.23-23
-- versão do PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `nozapo53_mdcard`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `adm`
--

CREATE TABLE `adm` (
  `Id` int(11) NOT NULL,
  `dias` varchar(3) DEFAULT '7',
  `novocliente` varchar(1) DEFAULT '1',
  `nome` varchar(150) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `linkpgmto` text NOT NULL,
  `statuslink` int(2) NOT NULL DEFAULT '1',
  `bloquear` int(2) NOT NULL DEFAULT '1',
  `celular` varchar(11) NOT NULL,
  `nomedosite` varchar(120) NOT NULL,
  `urlsite` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `adm`
--

INSERT INTO `adm` (`Id`, `dias`, `novocliente`, `nome`, `login`, `senha`, `linkpgmto`, `statuslink`, `bloquear`, `celular`, `nomedosite`, `urlsite`) VALUES
(1, '10', '1', 'Administrador', '1234', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '<script src=\"https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js\"\r\ndata-preference-id=\"107671554-35d357fe-d8ad-4f5b-a309-95bbc973222c\">\r\n</script>', 1, 1, '45988080666', 'Multi - Sistemas', 'https://cardmulti.mdinelly.com.br');

-- --------------------------------------------------------

--
-- Estrutura da tabela `bairros`
--

CREATE TABLE `bairros` (
  `id` int(11) NOT NULL,
  `idu` int(11) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `taxa` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `bairros`
--

INSERT INTO `bairros` (`id`, `idu`, `bairro`, `taxa`) VALUES
(132, 41, 'Centro', '0.00'),
(133, 41, 'Região de Santos', '7.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `idu` int(11) NOT NULL,
  `img` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `banner`
--

INSERT INTO `banner` (`id`, `idu`, `img`) VALUES
(46, 41, '16030534292690.jpg'),
(47, 42, 'off.jpg'),
(48, 43, 'off.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `idu` int(11) NOT NULL,
  `posicao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `url`, `idu`, `posicao`) VALUES
(87, 'Sanduiches', '16030537281724.jpg', 41, 1),
(88, 'Pizzas', '16030537444441.png', 41, 2),
(89, 'Pastéis', '16030537591270.jpg', 41, 3),
(90, 'Sucos Naturais', '16030537893425.jpg', 41, 4),
(91, 'Bebidas', '16030538143422.jpg', 41, 5),
(92, 'Açaí Natural', '16030538311786.jpg', 41, 6),
(93, 'Teste', 'off.jpg', 42, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `idu` int(11) NOT NULL,
  `nomeempresa` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nomeadmin` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cpf` varchar(18) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `celular` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cep` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rua` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `bairro` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cidade` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `uf` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `complemento` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `numero` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `fuso` varchar(60) NOT NULL DEFAULT 'America/Sao_Paulo',
  `mesa` int(2) NOT NULL DEFAULT '2',
  `balcao` int(2) NOT NULL DEFAULT '1',
  `delivery` int(2) NOT NULL DEFAULT '1',
  `cupon` int(2) NOT NULL DEFAULT '1',
  `dom` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '08:00:00,12:00:00,14:00:00,23:00:00',
  `seg` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '08:00:00,12:00:00,14:00:00,23:00:00',
  `ter` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '08:00:00,12:00:00,14:00:00,23:00:00',
  `qua` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '08:00:00,12:00:00,14:00:00,23:00:00',
  `qui` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '08:00:00,12:00:00,14:00:00,23:00:00',
  `sex` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '08:00:00,12:00:00,14:00:00,23:00:00',
  `sab` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '08:00:00,12:00:00,14:00:00,23:00:00',
  `funcionamento` int(2) DEFAULT '1',
  `cormenu` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '#FFFFFF',
  `corfundo` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '#F0F2F7',
  `corrodape` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '#E3E7EB',
  `corcarrinho` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '#FFFFE6',
  `timerdelivery` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '40 a 50min',
  `timerbalcao` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '20min',
  `modelo` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '1',
  `modelo2` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `modelo3` int(2) NOT NULL DEFAULT '1',
  `datacad` date NOT NULL,
  `dfree` varchar(9) NOT NULL DEFAULT '100.00',
  `insta` varchar(60) NOT NULL DEFAULT 'https://www.instagram.com',
  `expiracao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `config`
--

INSERT INTO `config` (`id`, `idu`, `nomeempresa`, `nomeadmin`, `email`, `senha`, `cpf`, `url`, `telefone`, `celular`, `cep`, `rua`, `bairro`, `cidade`, `uf`, `complemento`, `numero`, `status`, `fuso`, `mesa`, `balcao`, `delivery`, `cupon`, `dom`, `seg`, `ter`, `qua`, `qui`, `sex`, `sab`, `funcionamento`, `cormenu`, `corfundo`, `corrodape`, `corcarrinho`, `timerdelivery`, `timerbalcao`, `modelo`, `modelo2`, `modelo3`, `datacad`, `dfree`, `insta`, `expiracao`) VALUES
(41, 1, 'Goods Lanches', 'Marcelo', 'mxdinelly@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '71950028291', 'clientedemo', '00000000', '45988080666', '85000000', 'Rua Padre Anchieta', 'Centro', 'São Paulo', 'SP', 'Em Frente ao Shopping', '123', 1, 'America/Sao_Paulo', 1, 1, 1, 1, '00:01:00,12:00:00,12:01:00,23:59:00', '00:01:00,12:00:00,12:01:00,23:59:00', '00:01:00,12:00:00,12:01:00,23:59:00', '00:01:00,12:00:00,12:01:00,23:59:00', '00:01:00,12:00:00,12:01:00,23:59:00', '00:01:00,12:00:00,12:01:00,23:59:00', '00:01:00,12:00:00,12:01:00,23:59:00', 1, '#FFFFFF', '#F0F2F7', '#E3E7EB', '#FFFFE6', '40 a 50min', '20min', '1', '1', 1, '2020-10-18', '100.00', 'https://www.instagram.com', '2020-10-22'),
(42, 1, 'Teste', 'Lucas', 'luuscarp@hotmail.com', '779a923d69b2e072747b11975ba86949de167037', '16633853009', 'teste', '00000000', '17111111111', '000000000', 'xx', 'xx', 'xx', 'xx', 'xx', '00', 1, 'America/Sao_Paulo', 1, 1, 1, 1, '08:00:00,12:00:00,14:00:00,23:00:00', '08:00:00,12:00:00,14:00:00,23:00:00', '08:00:00,12:00:00,14:00:00,23:00:00', '08:00:00,12:00:00,14:00:00,23:00:00', '08:00:00,12:00:00,14:00:00,23:00:00', '08:00:00,12:00:00,14:00:00,23:00:00', '08:00:00,12:00:00,14:00:00,23:00:00', 1, '#000000', '#000000', '#000000', '#000000', '40 a 50min', '20min', '1', '1', 1, '2020-10-19', '100.00', 'https://www.instagram.com', '2020-10-29'),
(43, 1, 'teste3', 'Teste', 'teste@gmail.com', '779a923d69b2e072747b11975ba86949de167037', '52258829003', 'teste3', '00000000', '85888799316', '000000000', 'xx', 'xx', 'xx', 'xx', 'xx', '00', 1, 'America/Sao_Paulo', 1, 1, 1, 1, '08:00:00,12:00:00,14:00:00,23:00:00', '08:00:00,12:00:00,14:00:00,23:00:00', '08:00:00,12:00:00,14:00:00,23:00:00', '08:00:00,12:00:00,14:00:00,23:00:00', '08:00:00,12:00:00,14:00:00,23:00:00', '08:00:00,12:00:00,14:00:00,23:00:00', '08:00:00,12:00:00,14:00:00,23:00:00', 1, '#FFFFFF', '#F0F2F7', '#E3E7EB', '#FFFFE6', '40 a 50min', '20min', '1', '1', 1, '2020-10-19', '100.00', 'https://www.instagram.com', '2020-10-29');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `idu` int(9) NOT NULL,
  `nome` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `acesso` varchar(3) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `idu`, `nome`, `login`, `senha`, `acesso`) VALUES
(13, 41, 'Mauro', '4321', 'd5f12e53a182c062b6bf30c1445153faff12269a', '1'),
(14, 41, 'Marcos', '1234', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2'),
(15, 42, 'Lucas', '123456', '7c4a8d09ca3762af61e59520943dc26494f8941b', '1'),
(16, 42, 'Lucas', '12345', '8cb2237d0679ca88db6464eac60da96345513964', '2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fundotopo`
--

CREATE TABLE `fundotopo` (
  `id` int(11) NOT NULL,
  `idu` int(9) NOT NULL,
  `foto` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fundotopo`
--

INSERT INTO `fundotopo` (`id`, `idu`, `foto`) VALUES
(42, 41, '16030533924311.jpg'),
(43, 42, 'off.jpg'),
(44, 43, 'off.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos`
--

CREATE TABLE `grupos` (
  `Id` int(11) NOT NULL,
  `idu` int(9) DEFAULT '0',
  `nomegrupo` varchar(160) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT '0',
  `nomeinterno` varchar(160) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT '0',
  `obrigatorio` int(2) DEFAULT '0',
  `posicao` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `quantidade` int(11) DEFAULT '0',
  `quantidade_minima` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `grupos`
--

INSERT INTO `grupos` (`Id`, `idu`, `nomegrupo`, `nomeinterno`, `obrigatorio`, `posicao`, `status`, `quantidade`, `quantidade_minima`) VALUES
(76, 41, 'Selecione o ponto da carne', 'Sanduiches Carne', 1, 1, 1, 1, '0'),
(77, 41, 'Selecione o Molho', 'Sanduiches Molho', 2, 2, 1, 2, '0'),
(78, 41, 'Escolha até', 'Pizza 2 sabores', 3, 1, 1, 2, '0'),
(79, 41, 'Escolha a Borda', 'Pizza Borda', 1, 2, 1, 1, '0'),
(80, 41, 'Frutas', 'Açaí Frutas', 2, 1, 1, 2, '0'),
(81, 41, 'Complementos', 'Açaí Complementos', 2, 2, 1, 4, '0'),
(82, 41, 'Calda', 'Açaí Calda', 2, 3, 1, 1, '0'),
(83, 41, 'Adicionais', 'Açaí Adicionais', 2, 4, 1, 5, '0'),
(84, 43, 'teste', 'TEste', 2, 1, 1, 4, '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `limite_op`
--

CREATE TABLE `limite_op` (
  `Id` int(11) NOT NULL,
  `idp` varchar(9) DEFAULT NULL,
  `limite` varchar(3) DEFAULT '0',
  `idgrupo` int(11) DEFAULT '0',
  `meioameio` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `limite_op`
--

INSERT INTO `limite_op` (`Id`, `idp`, `limite`, `idgrupo`, `meioameio`) VALUES
(127, '379', '0', 76, 1),
(128, '379', '0', 77, 2),
(129, '380', '0', 78, 3),
(130, '380', '0', 79, 1),
(131, '384', '0', 80, 2),
(132, '384', '0', 81, 2),
(133, '384', '0', 82, 2),
(134, '384', '0', 83, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `logo`
--

CREATE TABLE `logo` (
  `id` int(11) NOT NULL,
  `idu` varchar(9) NOT NULL,
  `foto` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `logo`
--

INSERT INTO `logo` (`id`, `idu`, `foto`) VALUES
(41, '41', '16030534103682.jpg'),
(42, '42', 'off.jpg'),
(43, '43', 'off.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `data` varchar(10) COLLATE latin1_bin NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `idu` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `numero` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `mesas`
--

INSERT INTO `mesas` (`id`, `idu`, `numero`) VALUES
(7, '41', 1),
(8, '42', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `opcionais`
--

CREATE TABLE `opcionais` (
  `id` int(11) NOT NULL,
  `idu` int(11) NOT NULL,
  `idp` int(11) NOT NULL,
  `idg` int(11) DEFAULT '0',
  `opnome` varchar(30) NOT NULL,
  `opdescricao` varchar(160) NOT NULL DEFAULT 'N',
  `valor` varchar(10) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `opcionais`
--

INSERT INTO `opcionais` (`id`, `idu`, `idp`, `idg`, `opnome`, `opdescricao`, `valor`, `status`) VALUES
(338, 41, 0, 76, 'Ponto Bleu (Selada)', 'N', '1.00', 1),
(339, 41, 0, 76, 'Mal Passada', 'N', '0.00', 1),
(340, 41, 0, 76, 'Ao Ponto Para Mal', 'N', '0.00', 1),
(341, 41, 0, 76, 'Ao ponto', 'N', '0.00', 1),
(342, 41, 0, 76, 'Ao ponto para bem', 'N', '0.00', 1),
(343, 41, 0, 76, 'Bem passada', 'N', '0.00', 1),
(344, 41, 0, 77, 'Molho chimichurri', 'N', '3.50', 1),
(345, 41, 0, 77, 'Molho escabeche', 'N', '1.99', 1),
(346, 41, 0, 77, 'Molho romesco', 'N', '0.00', 1),
(347, 41, 0, 77, 'Molho agridoce', 'N', '0.00', 1),
(348, 41, 0, 77, 'Molho barbecue', 'N', '0.00', 1),
(349, 41, 0, 77, 'Molho de Porto', 'N', '0.00', 1),
(350, 41, 0, 77, 'Molho de nozes', 'N', '2.80', 1),
(351, 41, 0, 78, 'Filé com Fritas', 'Molho de tomate , Mussarela, Filé, Batata frita, Requeijão, Orégano', '29.90', 1),
(352, 41, 0, 78, 'Calabresa', 'Molho de tomate , Mussarela, Calabresa fatiada, Orégano', '28.00', 1),
(353, 41, 0, 78, 'Alho e Óleo', 'Molho de tomate , Mussarela, Alho frito crocante, Orégano', '25.00', 1),
(354, 41, 0, 78, 'Cinco Queijos', 'Mussarela, Queijo Provolone, Catupiry, Cheddar, Orégano', '27.00', 1),
(355, 41, 0, 78, 'Escarola', 'Molho de tomate, Mussarela, Chicória, Bacon, Orégano', '32.00', 1),
(356, 41, 0, 79, 'Borda Simples', 'N', '0.00', 1),
(357, 41, 0, 79, 'Borda com Catupiry', 'N', '5.00', 1),
(358, 41, 0, 79, 'Borda Doce com Nutela', 'N', '2.50', 1),
(359, 41, 0, 80, 'Banana', 'N', '0.00', 1),
(360, 41, 0, 80, 'Morango', 'N', '0.00', 1),
(361, 41, 0, 80, 'Maçã', 'N', '0.00', 1),
(362, 41, 0, 80, 'Manga', 'N', '0.00', 1),
(363, 41, 0, 80, 'Abacaxi', 'N', '0.00', 1),
(364, 41, 0, 81, 'Amendoim', 'N', '0.00', 1),
(365, 41, 0, 81, 'Chocoball', 'N', '0.00', 1),
(366, 41, 0, 81, 'Confete', 'N', '0.00', 1),
(367, 41, 0, 81, 'Granola', 'N', '0.00', 1),
(368, 41, 0, 81, 'Leite em Pó', 'N', '0.00', 1),
(369, 41, 0, 81, 'Ovomaltine', 'N', '0.00', 1),
(370, 41, 0, 81, 'Paçoca', 'N', '0.00', 1),
(371, 41, 0, 82, 'Cobertura de Chocolate', 'N', '0.00', 1),
(372, 41, 0, 82, 'Cobertura de Morango', 'N', '0.00', 1),
(373, 41, 0, 82, 'Leite Condensado', 'N', '0.00', 1),
(374, 41, 0, 82, 'Mel', 'N', '0.00', 1),
(375, 41, 0, 83, 'Nutella', 'N', '2.00', 1),
(376, 41, 0, 83, 'KitKat', 'N', '2.00', 1),
(377, 41, 0, 83, 'Sonho de Valsa', 'N', '2.00', 1),
(378, 41, 0, 83, 'Ouro Branco', 'N', '2.00', 1),
(379, 41, 0, 83, 'Suflair', 'N', '2.00', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `idu` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `idpedido` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `entrada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fpagamento` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cidade` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `numero` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `complemento` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rua` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `bairro` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `troco` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `hora` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `celular` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `taxa` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mesa` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pessoas` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `obs` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `vsubtotal` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `vadcionais` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `vtotal` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `idu`, `idpedido`, `entrada`, `fpagamento`, `cidade`, `numero`, `complemento`, `rua`, `bairro`, `troco`, `nome`, `data`, `hora`, `celular`, `taxa`, `mesa`, `pessoas`, `obs`, `status`, `vsubtotal`, `vadcionais`, `vtotal`) VALUES
(237, '41', '993117PW', '2020-10-18 21:03:47', 'BALCAO', '0', '0', '0', '0', '0', '0.00', 'MARCELO', '18-10-2020', '18:03:47', '45988080666', '0', '0', '0', '0', '5', '29.90', '5.49', '35.39'),
(238, '41', '486728PW', '2020-10-18 21:08:43', 'DINHEIRO', 'São Paulo', '102', 'complemento', 'Rua Mexico', 'Região de Santos', '100.00', 'MARCELO', '18-10-2020', '18:08:43', '45988080666', '0.00', '0', '0', '0', '5', '59.8', '2.99', '62.79'),
(239, '41', '480017PW', '2020-10-18 21:11:00', 'CARTAO', 'São Paulo', '102', 'Apto 04', 'Rua Mexico', 'Região de Santos', '0.00', 'JOAQUIM', '18-10-2020', '18:11:00', '45988080666', '7.00', '0', '0', '0', '5', '29.90', '6.49', '43.39'),
(240, '41', '717972PW', '2020-10-18 22:54:38', 'BALCAO', '0', '0', '0', '0', '0', '0.00', 'JOAQUIM', '18-10-2020', '19:54:38', '45988080666', '0', '0', '0', '0', '5', '32.00', '2.50', '34.50'),
(241, '41', '122916PW', '2020-10-18 22:59:11', 'CARTAO', 'São Paulo', '102', 'Apto 04', 'Rua Mexico', 'Região de Santos', '0.00', 'JOAQUIM', '18-10-2020', '19:59:11', '45988080666', '7.00', '0', '0', '0', '5', '25.90', '0.00', '32.9'),
(242, '41', '324784PW', '2020-10-18 23:25:28', 'BALCAO', '0', '0', '0', '0', '0', '0.00', 'JOAQUIM', '18-10-2020', '20:25:28', '45988080666', '0', '0', '0', '0', '5', '19.90', '6.00', '25.90'),
(243, '41', '339492PW', '2020-10-18 23:33:37', 'DINHEIRO', 'São Paulo', '193', 'Residencial Aniele Apto 04', 'Rua México', 'Região de Santos', '100.00', 'MARCELO', '18-10-2020', '20:33:37', '45988080666', '7.00', '0', '0', '0', '5', '59.80', '11.49', '78.29'),
(244, '41', '392173PW', '2020-10-18 23:47:11', 'DINHEIRO', 'São Paulo', '2', '', 'Rua teste', 'Centro', '100.00', 'ADRIANO', '18-10-2020', '20:47:11', '42999411926', '0.00', '0', '0', '0', '1', '59.80', '5.49', '65.29'),
(245, '41', '265465PW', '2020-10-19 18:16:48', 'DINHEIRO', 'São Paulo', '1', 'Teste', 'Teste', 'Centro', '2.00', 'TESTE', '19-10-2020', '15:16:48', '11111111111', '0.00', '0', '0', '0', '1', '29.90', '4.50', '34.4'),
(246, '42', '875296', '2020-10-19 18:52:19', 'MESA', '0', '0', '0', '0', '0', '0.00', 'Lucas', '19-10-2020', '15:52:19', '17992022167', '0', '1', '1', 'N', '5', '10', '0', '10'),
(247, '42', '535287', '2020-10-19 18:54:44', 'MESA', 'cidade', '0', '0', '0', '0', '0.00', 'Lucas', '19-10-2020', '15:54:44', '17111111111', '0.00', '1', '1', '', '5', '10', '0', '10'),
(248, '41', '704402PW', '2020-10-20 01:26:42', 'BALCAO', '0', '0', '0', '0', '0', '0.00', 'RONALDO', '19-10-2020', '22:26:42', '11962831540', '0', '0', '0', '0', '1', '29.90', '5.49', '35.39'),
(249, '41', '268741PW', '2020-10-20 01:34:00', 'BALCAO', '0', '0', '0', '0', '0', '0.00', 'RENATO', '19-10-2020', '22:34:00', '35988597435', '0', '0', '0', '0', '1', '97.70', '9.80', '107.50'),
(250, '41', '984135PW', '2020-10-20 10:56:34', 'DINHEIRO', 'São Paulo', '14', '', 'R Celso de Maia Fonseca', 'Centro', '50.00', 'DULCIMAR', '20-10-2020', '07:56:34', '21964482647', '0.00', '0', '0', '0', '1', '29.90', '4.50', '34.4');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `idu` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `valor` varchar(100) NOT NULL,
  `valorde` varchar(10) DEFAULT '0.00',
  `ingredientes` text NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `fotos2` varchar(255) DEFAULT 'off.jpg',
  `destaques` int(1) NOT NULL DEFAULT '0',
  `visivel` varchar(2) NOT NULL DEFAULT 'G',
  `status` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `idu`, `nome`, `valor`, `valorde`, `ingredientes`, `categoria`, `foto`, `fotos2`, `destaques`, `visivel`, `status`) VALUES
(379, 41, 'Hambúrguer Artesanal Caseiro', '29.90', '0.00', '200g de carne caseira, cebola, alho, cheiro verde fresco, pimenta-do-reino, 6 fatias de queijo prato, 6 fatias de queijo cheddar, 1 tomate cortado em fatias, pão de hambúrguer, folhas de alface americana.', '87', '16030548844658.jpg', 'off.jpg', 0, 'G', 1),
(380, 41, 'Pizza Grande', '0.00', '0.00', '8 Fatias com até 2 sabores', '88', '16030614284783.jpg', 'off.jpg', 0, 'G', 1),
(381, 41, 'Carne Seca Simples', '0.00', '0.00', 'Carne desfiada de primeira, queijo, cebola, tomate e molho especial', '89', '16030618064074.jpg', 'off.jpg', 0, 'G', 1),
(382, 41, 'Suco de Laranja', '0.00', '0.00', 'N', '90', '16030621651974.jpg', 'off.jpg', 0, 'G', 1),
(383, 41, 'Coca - Cola 300ml', '5.00', '0.00', 'N', '91', '16030622614193.jpg', 'off.jpg', 0, 'G', 1),
(384, 41, 'Açaí no Copo', '0.00', '0.00', 'Monte o seu', '92', '16030624863420.jpg', 'off.jpg', 0, 'G', 1),
(385, 42, 'Teste', '10.00', '0.00', 'N', '93', 'off.jpg', 'off.jpg', 0, 'G', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `store`
--

CREATE TABLE `store` (
  `id` int(11) NOT NULL,
  `idu` int(10) NOT NULL,
  `idpedido` varchar(32) NOT NULL,
  `idsecao` int(20) NOT NULL,
  `produto_id` varchar(100) NOT NULL,
  `data` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `valor` varchar(100) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `tamanho` varchar(19) NOT NULL DEFAULT 'N',
  `obs` varchar(255) DEFAULT 'Não'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `store`
--

INSERT INTO `store` (`id`, `idu`, `idpedido`, `idsecao`, `produto_id`, `data`, `status`, `valor`, `quantidade`, `tamanho`, `obs`) VALUES
(806, 41, 'df15ec8eabb40fb2f1ac0b5eb06459a5', 993117, '379', '18-10-2020', 1, '29.90', 1, 'N', 'Sem cebola'),
(807, 41, '7c40f075bea3515691048d93f31cc761', 486728, '379', '18-10-2020', 1, '29.90', 1, 'N', ''),
(808, 41, '423881df32fc82bf5f5544717e8db43e', 480017, '379', '18-10-2020', 1, '29.90', 1, 'N', ''),
(809, 41, 'd4706cbb6bc909da23dd35854cc4e288', 486728, '379', '18-10-2020', 1, '29.90', 1, 'N', ''),
(810, 41, '75f87e31b6ec1098fd155bbee5a6831e', 717972, '380', '18-10-2020', 1, '32.00', 1, 'N', 'Sem orégano'),
(811, 41, 'fa4b974b5b55b76d2ae968aa591fab8b', 122916, '381', '18-10-2020', 1, '25.90', 1, '50cm', 'Sem molho'),
(812, 41, '0f4c8c012ae7137dd5cfeab634e115b6', 324784, '384', '18-10-2020', 1, '19.90', 1, 'Copo 700ml', ''),
(813, 41, '02d5c1b3a31199de03fbeb4ebc3a7249', 339492, '379', '18-10-2020', 1, '29.90', 1, 'N', ''),
(814, 41, '137356ad075d9d728572809cecb6c5ed', 339492, '380', '18-10-2020', 1, '29.90', 1, 'N', ''),
(815, 41, '8a2b25307878860228eed216e5f1821a', 392173, '379', '18-10-2020', 1, '29.90', 1, 'N', ''),
(816, 41, '81b4c96ff6e4ad54198401fe454128a0', 392173, '380', '18-10-2020', 1, '29.90', 1, 'N', ''),
(817, 41, 'fc0c4a7cee7c3a7092236066cfa01b44', 265465, '379', '19-10-2020', 1, '29.90', 1, 'N', ''),
(818, 41, 'ba9cdd30cfd146a2db312b49737602de', 144402, '379', '19-10-2020', 0, '29.90', 1, 'N', ''),
(819, 41, 'f7eeab60635b27696a4870b54bdfdd80', 144402, '379', '19-10-2020', 0, '29.90', 1, 'N', ''),
(820, 42, '11155649940215563ad58f679c1786a4', 875296, '385', '19-10-2020', 1, '10.00', 1, 'N', ''),
(821, 42, 'b2cd99cbf8bb606090d6e7f503c5452b', 535287, '385', '19-10-2020', 1, '10.00', 1, 'N', ''),
(822, 41, '3113837a6f2138eb0627181a7e40c779', 321449, '384', '19-10-2020', 0, '9.00', 1, 'Copo 300ml', ''),
(823, 41, 'dbf95dac5399c0136055c0ec7bc9b04b', 690740, '382', '19-10-2020', 0, '15.00', 3, '500ml', ''),
(824, 41, 'b6de703b2833470456021c63a3aec597', 186534, '379', '19-10-2020', 0, '29.90', 1, 'N', ''),
(825, 41, 'd017f24c720a6a7390dd2198f7549f2f', 190860, '384', '19-10-2020', 0, '9.00', 1, 'Copo 300ml', ''),
(826, 41, '87549d24378621c6c6efb2e472fc7edd', 704402, '379', '19-10-2020', 1, '29.90', 1, 'N', ''),
(827, 41, '93eca260a232b76f73e4383ff19fce20', 190860, '383', '19-10-2020', 0, '5.00', 1, 'N', ''),
(828, 41, 'e8f958e8ec0d5c081ace3db40a123304', 268741, '379', '19-10-2020', 1, '29.90', 1, 'N', ''),
(829, 41, 'b7fb2ee8f052d3590f847efe66a8819e', 268741, '380', '19-10-2020', 1, '29.90', 1, 'N', ''),
(830, 41, '11bc53388d17ae2fad8c8d97d5f0cc49', 268741, '381', '19-10-2020', 1, '19.90', 1, '30cm', ''),
(831, 41, 'f2d06aacc81bdf6a58b06b1833e5dbd9', 268741, '383', '19-10-2020', 1, '5.00', 1, 'N', ''),
(832, 41, 'd1c0adf940508880ca76c330f8b00389', 268741, '384', '19-10-2020', 1, '13.00', 1, 'Copo 500ml', ''),
(833, 41, 'eb58820276a8722dec2a75fe5b1161a7', 427729, '380', '19-10-2020', 0, '27.00', 1, 'N', ''),
(834, 41, '0e032fbbdd38c93c65e2801eabe4905d', 236406, '384', '19-10-2020', 0, '9.00', 1, 'Copo 300ml', ''),
(835, 41, 'f080478899ab13b5f25da9c4dbd6b79b', 984135, '379', '20-10-2020', 1, '29.90', 1, 'N', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `store_o`
--

CREATE TABLE `store_o` (
  `id` int(11) NOT NULL,
  `idu` int(10) NOT NULL,
  `idp` varchar(32) NOT NULL DEFAULT '0',
  `ids` int(30) NOT NULL,
  `nome` varchar(200) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '0',
  `valor` varchar(10) NOT NULL,
  `quantidade` varchar(5) NOT NULL,
  `meioameio` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `store_o`
--

INSERT INTO `store_o` (`id`, `idu`, `idp`, `ids`, `nome`, `status`, `valor`, `quantidade`, `meioameio`) VALUES
(1231, 41, 'df15ec8eabb40fb2f1ac0b5eb06459a5', 993117, 'Ao ponto para bem', 1, '0.00', '1', '0'),
(1232, 41, 'df15ec8eabb40fb2f1ac0b5eb06459a5', 993117, 'Molho chimichurri', 1, '3.50', '1', '0'),
(1233, 41, 'df15ec8eabb40fb2f1ac0b5eb06459a5', 993117, 'Molho escabeche', 1, '1.99', '1', '0'),
(1234, 41, '7c40f075bea3515691048d93f31cc761', 486728, 'Ponto Bleu (Selada)', 1, '1.00', '1', '0'),
(1235, 41, '7c40f075bea3515691048d93f31cc761', 486728, 'Molho barbecue', 1, '0.00', '1', '0'),
(1236, 41, '7c40f075bea3515691048d93f31cc761', 486728, 'Molho de Porto', 1, '0.00', '1', '0'),
(1237, 41, '423881df32fc82bf5f5544717e8db43e', 480017, 'Ponto Bleu (Selada)', 1, '1.00', '1', '0'),
(1238, 41, '423881df32fc82bf5f5544717e8db43e', 480017, 'Molho chimichurri', 1, '3.50', '1', '0'),
(1239, 41, '423881df32fc82bf5f5544717e8db43e', 480017, 'Molho escabeche', 1, '1.99', '1', '0'),
(1240, 41, 'd4706cbb6bc909da23dd35854cc4e288', 486728, 'Mal Passada', 1, '0.00', '1', '0'),
(1241, 41, 'd4706cbb6bc909da23dd35854cc4e288', 486728, 'Molho escabeche', 1, '1.99', '1', '0'),
(1242, 41, 'd4706cbb6bc909da23dd35854cc4e288', 486728, 'Molho agridoce', 1, '0.00', '1', '0'),
(1243, 41, '75f87e31b6ec1098fd155bbee5a6831e', 717972, 'Filé com Fritas', 1, '29.90', '1', '1'),
(1244, 41, '75f87e31b6ec1098fd155bbee5a6831e', 717972, 'Escarola', 1, '32.00', '1', '1'),
(1245, 41, '75f87e31b6ec1098fd155bbee5a6831e', 717972, 'Borda Doce com Nutela', 1, '2.50', '1', '0'),
(1246, 41, '0f4c8c012ae7137dd5cfeab634e115b6', 324784, 'Banana', 1, '0.00', '1', '0'),
(1247, 41, '0f4c8c012ae7137dd5cfeab634e115b6', 324784, 'Morango', 1, '0.00', '1', '0'),
(1248, 41, '0f4c8c012ae7137dd5cfeab634e115b6', 324784, 'Amendoim', 1, '0.00', '1', '0'),
(1249, 41, '0f4c8c012ae7137dd5cfeab634e115b6', 324784, 'Chocoball', 1, '0.00', '1', '0'),
(1250, 41, '0f4c8c012ae7137dd5cfeab634e115b6', 324784, 'Confete', 1, '0.00', '1', '0'),
(1251, 41, '0f4c8c012ae7137dd5cfeab634e115b6', 324784, 'Granola', 1, '0.00', '1', '0'),
(1252, 41, '0f4c8c012ae7137dd5cfeab634e115b6', 324784, 'Cobertura de Chocolate', 1, '0.00', '1', '0'),
(1253, 41, '0f4c8c012ae7137dd5cfeab634e115b6', 324784, 'Nutella', 1, '2.00', '1', '0'),
(1254, 41, '0f4c8c012ae7137dd5cfeab634e115b6', 324784, 'KitKat', 1, '2.00', '1', '0'),
(1255, 41, '0f4c8c012ae7137dd5cfeab634e115b6', 324784, 'Ouro Branco', 1, '2.00', '1', '0'),
(1256, 41, '02d5c1b3a31199de03fbeb4ebc3a7249', 339492, 'Ponto Bleu (Selada)', 1, '1.00', '1', '0'),
(1257, 41, '02d5c1b3a31199de03fbeb4ebc3a7249', 339492, 'Molho chimichurri', 1, '3.50', '1', '0'),
(1258, 41, '02d5c1b3a31199de03fbeb4ebc3a7249', 339492, 'Molho escabeche', 1, '1.99', '1', '0'),
(1259, 41, '137356ad075d9d728572809cecb6c5ed', 339492, 'Filé com Fritas', 1, '29.90', '1', '1'),
(1260, 41, '137356ad075d9d728572809cecb6c5ed', 339492, 'Calabresa', 1, '28.00', '1', '1'),
(1261, 41, '137356ad075d9d728572809cecb6c5ed', 339492, 'Borda com Catupiry', 1, '5.00', '1', '0'),
(1262, 41, '8a2b25307878860228eed216e5f1821a', 392173, 'Mal Passada', 1, '0.00', '1', '0'),
(1263, 41, '8a2b25307878860228eed216e5f1821a', 392173, 'Molho chimichurri', 1, '3.50', '1', '0'),
(1264, 41, '8a2b25307878860228eed216e5f1821a', 392173, 'Molho escabeche', 1, '1.99', '1', '0'),
(1265, 41, '81b4c96ff6e4ad54198401fe454128a0', 392173, 'Filé com Fritas', 1, '29.90', '1', '1'),
(1266, 41, '81b4c96ff6e4ad54198401fe454128a0', 392173, 'Calabresa', 1, '28.00', '1', '1'),
(1267, 41, '81b4c96ff6e4ad54198401fe454128a0', 392173, 'Borda Simples', 1, '0.00', '1', '0'),
(1268, 41, 'fc0c4a7cee7c3a7092236066cfa01b44', 265465, 'Ponto Bleu (Selada)', 1, '1.00', '1', '0'),
(1269, 41, 'fc0c4a7cee7c3a7092236066cfa01b44', 265465, 'Molho chimichurri', 1, '3.50', '1', '0'),
(1270, 41, 'fc0c4a7cee7c3a7092236066cfa01b44', 265465, 'Molho romesco', 1, '0.00', '1', '0'),
(1271, 41, 'ba9cdd30cfd146a2db312b49737602de', 144402, 'Ao ponto', 0, '0.00', '1', '0'),
(1272, 41, 'ba9cdd30cfd146a2db312b49737602de', 144402, 'Molho romesco', 0, '0.00', '1', '0'),
(1273, 41, 'f7eeab60635b27696a4870b54bdfdd80', 144402, 'Bem passada', 0, '0.00', '1', '0'),
(1274, 41, 'f7eeab60635b27696a4870b54bdfdd80', 144402, 'Molho agridoce', 0, '0.00', '1', '0'),
(1275, 41, '3113837a6f2138eb0627181a7e40c779', 321449, 'Banana', 0, '0.00', '1', '0'),
(1276, 41, '3113837a6f2138eb0627181a7e40c779', 321449, 'Manga', 0, '0.00', '1', '0'),
(1277, 41, '3113837a6f2138eb0627181a7e40c779', 321449, 'Confete', 0, '0.00', '1', '0'),
(1278, 41, '3113837a6f2138eb0627181a7e40c779', 321449, 'Granola', 0, '0.00', '1', '0'),
(1279, 41, '3113837a6f2138eb0627181a7e40c779', 321449, 'Leite em Pó', 0, '0.00', '1', '0'),
(1280, 41, '3113837a6f2138eb0627181a7e40c779', 321449, 'Cobertura de Morango', 0, '0.00', '1', '0'),
(1281, 41, '3113837a6f2138eb0627181a7e40c779', 321449, 'Nutella', 0, '2.00', '1', '0'),
(1282, 41, '3113837a6f2138eb0627181a7e40c779', 321449, 'KitKat', 0, '2.00', '1', '0'),
(1283, 41, '3113837a6f2138eb0627181a7e40c779', 321449, 'Sonho de Valsa', 0, '2.00', '1', '0'),
(1284, 41, '3113837a6f2138eb0627181a7e40c779', 321449, 'Ouro Branco', 0, '2.00', '1', '0'),
(1285, 41, 'b6de703b2833470456021c63a3aec597', 186534, 'Ponto Bleu (Selada)', 0, '1.00', '1', '0'),
(1286, 41, 'b6de703b2833470456021c63a3aec597', 186534, 'Molho chimichurri', 0, '3.50', '1', '0'),
(1287, 41, 'b6de703b2833470456021c63a3aec597', 186534, 'Molho escabeche', 0, '1.99', '1', '0'),
(1288, 41, 'd017f24c720a6a7390dd2198f7549f2f', 190860, 'Cobertura de Chocolate', 0, '0.00', '1', '0'),
(1289, 41, '87549d24378621c6c6efb2e472fc7edd', 704402, 'Ao Ponto Para Mal', 1, '0.00', '1', '0'),
(1290, 41, '87549d24378621c6c6efb2e472fc7edd', 704402, 'Molho chimichurri', 1, '3.50', '1', '0'),
(1291, 41, '87549d24378621c6c6efb2e472fc7edd', 704402, 'Molho escabeche', 1, '1.99', '1', '0'),
(1292, 41, 'e8f958e8ec0d5c081ace3db40a123304', 268741, 'Ao Ponto Para Mal', 1, '0.00', '1', '0'),
(1293, 41, 'e8f958e8ec0d5c081ace3db40a123304', 268741, 'Molho barbecue', 1, '0.00', '1', '0'),
(1294, 41, 'e8f958e8ec0d5c081ace3db40a123304', 268741, 'Molho de nozes', 1, '2.80', '1', '0'),
(1295, 41, 'b7fb2ee8f052d3590f847efe66a8819e', 268741, 'Filé com Fritas', 1, '29.90', '1', '1'),
(1296, 41, 'b7fb2ee8f052d3590f847efe66a8819e', 268741, 'Cinco Queijos', 1, '27.00', '1', '1'),
(1297, 41, 'b7fb2ee8f052d3590f847efe66a8819e', 268741, 'Borda com Catupiry', 1, '5.00', '1', '0'),
(1298, 41, 'd1c0adf940508880ca76c330f8b00389', 268741, 'Banana', 1, '0.00', '1', '0'),
(1299, 41, 'd1c0adf940508880ca76c330f8b00389', 268741, 'Morango', 1, '0.00', '1', '0'),
(1300, 41, 'd1c0adf940508880ca76c330f8b00389', 268741, 'Amendoim', 1, '0.00', '1', '0'),
(1301, 41, 'd1c0adf940508880ca76c330f8b00389', 268741, 'Confete', 1, '0.00', '1', '0'),
(1302, 41, 'd1c0adf940508880ca76c330f8b00389', 268741, 'Leite em Pó', 1, '0.00', '1', '0'),
(1303, 41, 'd1c0adf940508880ca76c330f8b00389', 268741, 'Paçoca', 1, '0.00', '1', '0'),
(1304, 41, 'd1c0adf940508880ca76c330f8b00389', 268741, 'Mel', 1, '0.00', '1', '0'),
(1305, 41, 'd1c0adf940508880ca76c330f8b00389', 268741, 'Nutella', 1, '2.00', '1', '0'),
(1306, 41, 'eb58820276a8722dec2a75fe5b1161a7', 427729, 'Alho e Óleo', 0, '25.00', '1', '1'),
(1307, 41, 'eb58820276a8722dec2a75fe5b1161a7', 427729, 'Cinco Queijos', 0, '27.00', '1', '1'),
(1308, 41, 'eb58820276a8722dec2a75fe5b1161a7', 427729, 'Borda Simples', 0, '0.00', '1', '0'),
(1309, 41, '0e032fbbdd38c93c65e2801eabe4905d', 236406, 'Maçã', 0, '0.00', '1', '0'),
(1310, 41, '0e032fbbdd38c93c65e2801eabe4905d', 236406, 'Leite em Pó', 0, '0.00', '1', '0'),
(1311, 41, '0e032fbbdd38c93c65e2801eabe4905d', 236406, 'Leite Condensado', 0, '0.00', '1', '0'),
(1312, 41, '0e032fbbdd38c93c65e2801eabe4905d', 236406, 'Nutella', 0, '2.00', '1', '0'),
(1313, 41, '0e032fbbdd38c93c65e2801eabe4905d', 236406, 'Sonho de Valsa', 0, '2.00', '1', '0'),
(1314, 41, 'f080478899ab13b5f25da9c4dbd6b79b', 984135, 'Ponto Bleu (Selada)', 1, '1.00', '1', '0'),
(1315, 41, 'f080478899ab13b5f25da9c4dbd6b79b', 984135, 'Molho chimichurri', 1, '3.50', '1', '0'),
(1316, 41, 'f080478899ab13b5f25da9c4dbd6b79b', 984135, 'Molho barbecue', 1, '0.00', '1', '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tamanhos`
--

CREATE TABLE `tamanhos` (
  `id` int(11) NOT NULL,
  `idu` int(9) NOT NULL,
  `idp` int(9) NOT NULL,
  `descricao` varchar(30) NOT NULL,
  `valor` varchar(30) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tamanhos`
--

INSERT INTO `tamanhos` (`id`, `idu`, `idp`, `descricao`, `valor`, `status`) VALUES
(56, 41, 381, '15cm', '15.00', 1),
(57, 41, 381, '30cm', '19.90', 1),
(58, 41, 381, '50cm', '25.90', 1),
(59, 41, 382, '500ml', '15.00', 1),
(60, 41, 382, '1lt', '25.00', 1),
(61, 41, 384, 'Copo 300ml', '9.00', 1),
(62, 41, 384, 'Copo 500ml', '13.00', 1),
(63, 41, 384, 'Copo 700ml', '19.90', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `adm`
--
ALTER TABLE `adm`
  ADD PRIMARY KEY (`Id`);

--
-- Índices para tabela `bairros`
--
ALTER TABLE `bairros`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `fundotopo`
--
ALTER TABLE `fundotopo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`Id`);

--
-- Índices para tabela `limite_op`
--
ALTER TABLE `limite_op`
  ADD PRIMARY KEY (`Id`);

--
-- Índices para tabela `logo`
--
ALTER TABLE `logo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `opcionais`
--
ALTER TABLE `opcionais`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `store_o`
--
ALTER TABLE `store_o`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tamanhos`
--
ALTER TABLE `tamanhos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `adm`
--
ALTER TABLE `adm`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `bairros`
--
ALTER TABLE `bairros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT de tabela `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de tabela `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `fundotopo`
--
ALTER TABLE `fundotopo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de tabela `grupos`
--
ALTER TABLE `grupos`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de tabela `limite_op`
--
ALTER TABLE `limite_op`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT de tabela `logo`
--
ALTER TABLE `logo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `opcionais`
--
ALTER TABLE `opcionais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=380;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386;

--
-- AUTO_INCREMENT de tabela `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=836;

--
-- AUTO_INCREMENT de tabela `store_o`
--
ALTER TABLE `store_o`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1317;

--
-- AUTO_INCREMENT de tabela `tamanhos`
--
ALTER TABLE `tamanhos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
