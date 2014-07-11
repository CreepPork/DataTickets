-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 11, 2014 at 10:14 AM
-- Server version: 5.0.96
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dataticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `tck_arquivos`
--

CREATE TABLE IF NOT EXISTS `tck_arquivos` (
  `id` int(15) NOT NULL auto_increment,
  `arq_name` varchar(255) NOT NULL,
  `arq_link` varchar(255) NOT NULL,
  `ticket` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tck_arquivos`
--

INSERT INTO `tck_arquivos` (`id`, `arq_name`, `arq_link`, `ticket`) VALUES
(6, 'placa-de-escola-com-palavra-do-teste-13813797.jpg', 'rsc/system_arqs/uploads/placa-de-escola-com-palavra-do-teste-13813797.jpg', 8),
(5, 'placa-de-escola-com-palavra-do-teste-13813797.jpg', 'rsc/system_arqs/uploads/placa-de-escola-com-palavra-do-teste-13813797.jpg', 7);

-- --------------------------------------------------------

--
-- Table structure for table `tck_client`
--

CREATE TABLE IF NOT EXISTS `tck_client` (
  `id` int(11) NOT NULL auto_increment,
  `nome` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `user` varchar(30) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tck_client`
--

INSERT INTO `tck_client` (`id`, `nome`, `email`, `user`, `passwd`) VALUES
(1, 'Teste de cliente', 'cliente@teste.com.br', 'cliente', '698dc19d489c4e4db73e28a713eab07b'),
(3, 'Marcelo', 'marcelompinheiro@outlook.com', 'celomamp', 'b09397044b2adaecda6a24cb7bdfa158');

-- --------------------------------------------------------

--
-- Table structure for table `tck_comentario`
--

CREATE TABLE IF NOT EXISTS `tck_comentario` (
  `id` int(11) NOT NULL auto_increment,
  `id_user` int(11) default NULL,
  `id_client` int(255) default NULL,
  `id_ticket` int(11) NOT NULL,
  `comentario` varchar(500) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_comentario_user` (`id_user`),
  KEY `fk_comentario_ticket` (`id_ticket`),
  KEY `fk_client_coment` (`id_client`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `tck_comentario`
--

INSERT INTO `tck_comentario` (`id`, `id_user`, `id_client`, `id_ticket`, `comentario`, `data`) VALUES
(6, 1, NULL, 1, 'teste de comentÃ¡rio', '2014-07-03'),
(7, 1, NULL, 1, 'teste', '2014-07-03'),
(8, 1, NULL, 2, 'teste', '2014-07-03'),
(9, 1, NULL, 4, 'Teste', '2014-07-03'),
(10, 1, NULL, 3, 'este Ã© um teste de comentÃ¡rio', '2014-07-04'),
(13, NULL, 3, 6, 'teste de cliente', '2014-07-07'),
(14, 1, NULL, 6, 'teste de equipe', '2014-07-07'),
(15, NULL, 3, 6, 'Cliente respondendo comentÃ¡rio', '2014-07-07'),
(28, 1, NULL, 6, 'teste', '2014-07-07'),
(36, 1, NULL, 6, 'teste', '2014-07-07'),
(37, 1, NULL, 6, 'teste', '2014-07-07'),
(38, 1, NULL, 6, 'teste', '2014-07-07'),
(39, 1, NULL, 6, 'teste', '2014-07-07'),
(40, 1, NULL, 6, 'teste', '2014-07-08'),
(41, 1, NULL, 6, 'teste', '2014-07-08'),
(42, 1, NULL, 6, 'teste', '2014-07-08'),
(43, 1, NULL, 6, 'teste', '2014-07-08'),
(44, 1, NULL, 6, 'teste', '2014-07-08'),
(45, NULL, 3, 6, 'quantos testes', '2014-07-10'),
(46, 1, NULL, 6, 'teste denovo', '2014-07-10'),
(47, 1, NULL, 7, 'Este teste', '2014-07-10'),
(48, 1, NULL, 7, 'teste', '2014-07-10'),
(49, 1, NULL, 7, 'teste', '2014-07-10'),
(50, 1, NULL, 7, 'teste', '2014-07-10');

-- --------------------------------------------------------

--
-- Table structure for table `tck_estado`
--

CREATE TABLE IF NOT EXISTS `tck_estado` (
  `id` int(11) NOT NULL auto_increment,
  `estado` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tck_estado`
--

INSERT INTO `tck_estado` (`id`, `estado`) VALUES
(1, 'Em Aberto'),
(2, 'Em Andamento'),
(3, 'Fechado');

-- --------------------------------------------------------

--
-- Table structure for table `tck_ticket`
--

CREATE TABLE IF NOT EXISTS `tck_ticket` (
  `id` int(250) NOT NULL auto_increment,
  `assunto` varchar(50) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `estado` int(11) NOT NULL,
  `causa` varchar(500) default NULL,
  `resolucao` varchar(500) default NULL,
  `cliente` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_ticket_estado` (`estado`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tck_ticket`
--

INSERT INTO `tck_ticket` (`id`, `assunto`, `descricao`, `estado`, `causa`, `resolucao`, `cliente`) VALUES
(1, 'Assunto Teste', 'O meu teste não está funcionando', 3, 'teste', 'teste 2 blablabla 2', 1),
(2, 'Segundo teste', 'Este teste funciona', 3, 'asdf', 'asdfasdf', 1),
(3, 'Falta de espaço', 'Tenho poucos arquivos no servidor, mas o mesmo acusa excesso de arquivos e sem espaço suficiente para mais', 3, 'Pouco espaÃ§o contratado', 'Contratar mais espaÃ§o para os arquivos', 1),
(4, 'teste', 'teste teste', 2, NULL, NULL, 1),
(6, 'Teste InserÃ§Ã£o pelo Cliente', 'Teste', 3, 'Vivamus a suscipit est. In ac interdum erat. Mauris ligula magna, luctus fringilla faucibus et, consequat at lectus. Aliquam egestas elit lacus. Maecenas iaculis, nisi sed molestie viverra, elit nibh cursus elit, vel varius lectus velit ac leo. Duis tincidunt pellentesque risus, eu elementum odio pretium adipiscing. Quisque semper tellus in lorem varius ornare sit amet in lectus. Nunc pulvinar interdum tellus, vitae dictum neque convallis at. Nullam eu tortor sit amet arcu dictum dictum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec lacus augue, posuere id sodales at, placerat et augue. Maecenas nec bibendum diam. Maecenas convallis feugiat turpis, non bibendum justo convallis vitae. Ut vehicula, sapien at convallis varius, nibh massa sagittis ligula, id bibendum nisl elit eu risus. Vivamus faucibus tincidunt faucibus. Integer id massa in mauris sollicitudin sagittis. Cras elit arcu, ', 3),
(7, 'Teste de ticket para envio de email', 'testando os envios de email', 3, 'Aconteceu por causa disso disso e disso', 'Fizemos isso isso e aquilo', 3),
(8, 'teste', 'teste', 2, NULL, NULL, 3),
(9, 'teste 2', 'teste', 1, NULL, NULL, 3),
(10, 'TESTE 3', 'TESTE', 1, NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tck_user`
--

CREATE TABLE IF NOT EXISTS `tck_user` (
  `id` int(11) NOT NULL auto_increment,
  `nome` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `user` varchar(30) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `tipo` int(2) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tck_user`
--

INSERT INTO `tck_user` (`id`, `nome`, `email`, `user`, `passwd`, `tipo`) VALUES
(1, 'Administrador', 'adm@adm.com', 'root', 'e10adc3949ba59abbe56e057f20f883e', 1),
(10, 'Marcelo Silva', 'marcelo@silva.com', 'msilva', '202cb962ac59075b964b07152d234b70', 3),
(11, 'Walber', 'walber.castro@datasafer.com.br', 'walber', 'e10adc3949ba59abbe56e057f20f883e', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tck_user_ticket`
--

CREATE TABLE IF NOT EXISTS `tck_user_ticket` (
  `id` int(11) NOT NULL auto_increment,
  `id_user` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_user_ticket_user` (`id_user`),
  KEY `fk_user_ticket_ticket` (`id_ticket`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `tck_user_ticket`
--

INSERT INTO `tck_user_ticket` (`id`, `id_user`, `id_ticket`) VALUES
(14, 1, 1),
(15, 1, 2),
(16, 1, 3),
(17, 1, 4),
(22, 1, 6),
(23, 11, 3),
(24, 1, 7),
(25, 1, 8);
