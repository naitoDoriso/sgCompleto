-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 05/10/2022 às 22:20
-- Versão do servidor: 10.4.22-MariaDB
-- Versão do PHP: 8.0.14

DROP DATABASE IF EXISTS sg;
CREATE DATABASE sg;
USE sg;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `AGENDA`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `CONTATO`
--

CREATE TABLE `CONTATO` (
  `ID_CONTATO` int(11) NOT NULL,
  `NOME` varchar(50) NOT NULL,
  `DATA_NASC` date DEFAULT NULL,
  `LOGIN` varchar(50) DEFAULT NULL,
  `IMAGEM` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `CONTATO_ENDERECO`
--

CREATE TABLE `CONTATO_ENDERECO` (
  `ID_CONTATO` int(11) NOT NULL,
  `ID_ENDERECO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `EMAILS`
--

CREATE TABLE `EMAILS` (
  `END_EMAIL` varchar(50) NOT NULL,
  `ID_CONTATO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ENDERECOS`
--

CREATE TABLE `ENDERECOS` (
  `ID_ENDERECO` int(11) NOT NULL,
  `RUA` varchar(30) NOT NULL,
  `NUMERO` int(11) NOT NULL,
  `BAIRRO` varchar(30) NOT NULL,
  `CIDADE` varchar(30) NOT NULL,
  `CEP` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `TELEFONES`
--

CREATE TABLE `TELEFONES` (
  `TELEFONE` varchar(20) NOT NULL,
  `ID_CONTATO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `USUARIO`
--

CREATE TABLE `USUARIO` (
  `LOGIN` varchar(50) NOT NULL,
  `SENHA` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `CONTATO`
--
ALTER TABLE `CONTATO`
  ADD PRIMARY KEY (`ID_CONTATO`),
  ADD KEY `LOGIN` (`LOGIN`);

--
-- Índices de tabela `CONTATO_ENDERECO`
--
ALTER TABLE `CONTATO_ENDERECO`
  ADD PRIMARY KEY (`ID_CONTATO`,`ID_ENDERECO`),
  ADD KEY `ID_ENDERECO` (`ID_ENDERECO`);

--
-- Índices de tabela `EMAILS`
--
ALTER TABLE `EMAILS`
  ADD PRIMARY KEY (`END_EMAIL`),
  ADD KEY `ID_CONTATO` (`ID_CONTATO`);

--
-- Índices de tabela `ENDERECOS`
--
ALTER TABLE `ENDERECOS`
  ADD PRIMARY KEY (`ID_ENDERECO`);

--
-- Índices de tabela `TELEFONES`
--
ALTER TABLE `TELEFONES`
  ADD PRIMARY KEY (`TELEFONE`),
  ADD KEY `ID_CONTATO` (`ID_CONTATO`);

--
-- Índices de tabela `USUARIO`
--
ALTER TABLE `USUARIO`
  ADD PRIMARY KEY (`LOGIN`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `CONTATO`
--
ALTER TABLE `CONTATO`
  MODIFY `ID_CONTATO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ENDERECOS`
--
ALTER TABLE `ENDERECOS`
  MODIFY `ID_ENDERECO` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `CONTATO`
--
ALTER TABLE `CONTATO`
  ADD CONSTRAINT `CONTATO_ibfk_1` FOREIGN KEY (`LOGIN`) REFERENCES `USUARIO` (`LOGIN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `CONTATO_ENDERECO`
--
ALTER TABLE `CONTATO_ENDERECO`
  ADD CONSTRAINT `CONTATO_ENDERECO_ibfk_1` FOREIGN KEY (`ID_CONTATO`) REFERENCES `CONTATO` (`ID_CONTATO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `CONTATO_ENDERECO_ibfk_2` FOREIGN KEY (`ID_ENDERECO`) REFERENCES `ENDERECOS` (`ID_ENDERECO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `EMAILS`
--
ALTER TABLE `EMAILS`
  ADD CONSTRAINT `EMAILS_ibfk_1` FOREIGN KEY (`ID_CONTATO`) REFERENCES `CONTATO` (`ID_CONTATO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `TELEFONES`
--
ALTER TABLE `TELEFONES`
  ADD CONSTRAINT `TELEFONES_ibfk_1` FOREIGN KEY (`ID_CONTATO`) REFERENCES `CONTATO` (`ID_CONTATO`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

INSERT INTO usuario VALUES ('pedro', '12345');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;