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

CREATE TABLE IF NOT EXISTS tbproduto (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    descricao TEXT,
    id_cadastrou INT,
    status VARCHAR(15) DEFAULT 'verificar',
    PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbproduto`
--

INSERT INTO tbproduto (nome, tipo, descricao, id_cadastrou, status)
VALUES
('Trufa de Morango', 'alimento', 'Trufa artesanal recheada com morango', 1, 'liberado'),
('Brigadeiro Gourmet', 'alimento', 'Brigadeiro com granulado belga', 1, 'liberado'),
('Suco de Fruta', 'bebida', 'Suco natural gelado', 1, 'liberado');
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS tbpedido (
    id INT NOT NULL AUTO_INCREMENT,
    id_produto INT NOT NULL,
    id_usuario INT NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,
    observacao TEXT,
    data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Estrutura da tabela `tbusuario`
--
CREATE TABLE IF NOT EXISTS tbusuario (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(50) NOT NULL,
    nivel VARCHAR(10) NOT NULL DEFAULT 'user',
    PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbusuario`
--

INSERT INTO tbusuario (nome, login, senha, nivel)
VALUES
('Administrador', 'admin', '1234', 'adm'),
('Usuario Teste', 'user', '1234', 'user');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
