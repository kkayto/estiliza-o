-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Tempo de geração: 09-Set-2022 às 12:10
-- Versão do servidor: 8.0.21
-- versão do PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


--
-- Banco de dados: `testeaula`
--
CREATE DATABASE IF NOT EXISTS `testeaula` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `testeaula`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbproduto`
--

DROP TABLE IF EXISTS `tbproduto`;
CREATE TABLE IF NOT EXISTS `tbproduto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `Id_cadastrou` int NOT NULL,
  `status` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbproduto`
--

INSERT INTO `tbproduto` (`id`, `nome`, `tipo`, `descricao`, `Id_cadastrou`, `status`) VALUES
(1, 'tese', 'te', 'ee', 1, 'liberado'),
(2, 'uva', 'teee', 'eee', 1, 'liberado'),
(3, 'teee', 'bebida', 'ee', 1, 'bloqueado'),
(4, 'tt', 'rr', 'rr', 1, 'liberado'),
(5, 'tee', 'ewe', 'wewe', 1, 'liberado'),
(15, 'celia', 'bebida', 'teste', 3, 'liberado'),
(7, 'teee', 'eeeee', 'rere', 1, 'liberado'),
(9, 'tew', 'te', 'tet', 1, 'liberado'),
(10, 'oi', 'oo', 'oo', 1, 'liberado'),
(14, 'teste', 'limpeza', 'tet', 1, 'liberado'),
(20, 'ANA', 'TETE', 'EE', 1, 'liberado'),
(22, '5', '54', '455', 1, 'liberado'),
(23, 'bola', 'oturos', 'dd', 2, 'liberado'),
(24, 'chocolate', 'alimento', 'gostoso', 2, 'bloqueado'),
(25, 'teste de status', 'diversos', 'testes', 2, 'verificar'),
(26, 'caneta', 'diversos', 'escreve', 1, 'verificar');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbusuario`
--

DROP TABLE IF EXISTS `tbusuario`;
CREATE TABLE IF NOT EXISTS `tbusuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `senha` varchar(15) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `nivel` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbusuario`
--

INSERT INTO `tbusuario` (`id`, `login`, `senha`, `nome`, `nivel`) VALUES
(1, 'celia', '123', 'prof Celia', 'adm'),
(2, 'ana', '369', 'ana maria', 'usuario'),
(3, 'Etec', 'etec', 'etec de poa', 'usuario');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
