-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 19-Nov-2015 às 20:17
-- Versão do servidor: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bancoestudos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alterar_senha`
--

CREATE TABLE IF NOT EXISTS `alterar_senha` (
  `token` varchar(60) NOT NULL,
  `login_id` int(10) unsigned NOT NULL,
  `date_request` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL,
  `nome` varchar(45) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--AUTO_INCREMENT

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(10) unsigned NOT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivel`
--

CREATE TABLE IF NOT EXISTS `nivel` (
  `id` int(10) unsigned NOT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `nivel`
--

INSERT INTO `nivel` (`id`, `nome`) VALUES
(1, 'Usuário'),
(2, 'Gerente'),
(3, 'Administrador');

-- --------------------------------------------------------

--
-- Estrutura da tabela `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(10) unsigned NOT NULL,
  `titulo` varchar(80) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descricao` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `texto` longtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `cadastro` datetime DEFAULT NULL,
  `alterado` datetime DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '0',
  `category` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(10) unsigned NOT NULL,
  `nome` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `login_id` int(10) unsigned NOT NULL,
  `nivel_id` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alterar_senha`
--
ALTER TABLE `alterar_senha`
  ADD PRIMARY KEY (`token`), ADD UNIQUE KEY `UNIQUE_ALTERAR_SENHA_LOGIN_ID` (`login_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nivel`
--
ALTER TABLE `nivel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`) USING BTREE, ADD KEY `FK_POST_CATEGORY_ID` (`category`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`), ADD KEY `FK_USUARIO_LOGIN` (`login_id`), ADD KEY `FK_USUARIO_NIVEL` (`nivel_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `nivel`
--
ALTER TABLE `nivel`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `alterar_senha`
--
ALTER TABLE `alterar_senha`
ADD CONSTRAINT `FK_ALTERAR_SENHA_LOGIN_ID` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`);

--
-- Limitadores para a tabela `post`
--
ALTER TABLE `post`
ADD CONSTRAINT `FK_POST_CATEGORY_ID` FOREIGN KEY (`category`) REFERENCES `category` (`id`);

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
ADD CONSTRAINT `FK_USUARIO_LOGIN` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`),
ADD CONSTRAINT `FK_USUARIO_NIVEL` FOREIGN KEY (`nivel_id`) REFERENCES `nivel` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
