-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 10-Jul-2014 às 14:45
-- Versão do servidor: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dataticket`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tck_client`
--

CREATE TABLE IF NOT EXISTS `tck_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `user` varchar(30) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `tck_client`
--

INSERT INTO `tck_client` (`id`, `nome`, `email`, `user`, `passwd`) VALUES
(1, 'Teste de cliente', 'cliente@teste.com.br', 'cliente', '698dc19d489c4e4db73e28a713eab07b'),
(3, 'Marcelo', 'marcelompinheiro@outlook.com', 'celomamp', 'b09397044b2adaecda6a24cb7bdfa158');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tck_comentario`
--

CREATE TABLE IF NOT EXISTS `tck_comentario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_client` int(255) DEFAULT NULL,
  `id_ticket` int(11) NOT NULL,
  `comentario` varchar(500) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comentario_user` (`id_user`),
  KEY `fk_comentario_ticket` (`id_ticket`),
  KEY `fk_client_coment` (`id_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Extraindo dados da tabela `tck_comentario`
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
(45, NULL, 3, 6, 'quantos testes', '2014-07-10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tck_estado`
--

CREATE TABLE IF NOT EXISTS `tck_estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `tck_estado`
--

INSERT INTO `tck_estado` (`id`, `estado`) VALUES
(1, 'Em Aberto'),
(2, 'Em Andamento'),
(3, 'Fechado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tck_ticket`
--

CREATE TABLE IF NOT EXISTS `tck_ticket` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `assunto` varchar(50) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `estado` int(11) NOT NULL,
  `causa` varchar(500) DEFAULT NULL,
  `resolucao` varchar(500) DEFAULT NULL,
  `cliente` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ticket_estado` (`estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `tck_ticket`
--

INSERT INTO `tck_ticket` (`id`, `assunto`, `descricao`, `estado`, `causa`, `resolucao`, `cliente`) VALUES
(1, 'Assunto Teste', 'O meu teste não está funcionando', 3, 'teste', 'teste 2 blablabla 2', 1),
(2, 'Segundo teste', 'Este teste funciona', 3, 'asdf', 'asdfasdf', 1),
(3, 'Falta de espaço', 'Tenho poucos arquivos no servidor, mas o mesmo acusa excesso de arquivos e sem espaço suficiente para mais', 3, 'Pouco espaÃ§o contratado', 'Contratar mais espaÃ§o para os arquivos', 1),
(4, 'teste', 'teste teste', 2, NULL, NULL, 1),
(6, 'Teste InserÃ§Ã£o pelo Cliente', 'Teste', 3, 'Vivamus a suscipit est. In ac interdum erat. Mauris ligula magna, luctus fringilla faucibus et, consequat at lectus. Aliquam egestas elit lacus. Maecenas iaculis, nisi sed molestie viverra, elit nibh cursus elit, vel varius lectus velit ac leo. Duis tincidunt pellentesque risus, eu elementum odio pretium adipiscing. Quisque semper tellus in lorem varius ornare sit amet in lectus. Nunc pulvinar interdum tellus, vitae dictum neque convallis at. Nullam eu tortor sit amet arcu dictum dictum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec lacus augue, posuere id sodales at, placerat et augue. Maecenas nec bibendum diam. Maecenas convallis feugiat turpis, non bibendum justo convallis vitae. Ut vehicula, sapien at convallis varius, nibh massa sagittis ligula, id bibendum nisl elit eu risus. Vivamus faucibus tincidunt faucibus. Integer id massa in mauris sollicitudin sagittis. Cras elit arcu, ', 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tck_user`
--

CREATE TABLE IF NOT EXISTS `tck_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `user` varchar(30) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `tipo` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `tck_user`
--

INSERT INTO `tck_user` (`id`, `nome`, `email`, `user`, `passwd`, `tipo`) VALUES
(1, 'Administrador', 'adm@adm.com', 'root', 'e10adc3949ba59abbe56e057f20f883e', 1),
(10, 'Marcelo Silva', 'marcelo@silva.com', 'msilva', '202cb962ac59075b964b07152d234b70', 3),
(11, 'Walber', 'walber.castro@datasafer.com.br', 'walber', 'e10adc3949ba59abbe56e057f20f883e', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tck_user_ticket`
--

CREATE TABLE IF NOT EXISTS `tck_user_ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_ticket` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_ticket_user` (`id_user`),
  KEY `fk_user_ticket_ticket` (`id_ticket`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Extraindo dados da tabela `tck_user_ticket`
--

INSERT INTO `tck_user_ticket` (`id`, `id_user`, `id_ticket`) VALUES
(14, 1, 1),
(15, 1, 2),
(16, 1, 3),
(17, 1, 4),
(22, 1, 6),
(23, 11, 3);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tck_comentario`
--
ALTER TABLE `tck_comentario`
  ADD CONSTRAINT `fk_client_coment` FOREIGN KEY (`id_client`) REFERENCES `tck_client` (`id`),
  ADD CONSTRAINT `fk_comentario_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `tck_ticket` (`id`),
  ADD CONSTRAINT `fk_comentario_user` FOREIGN KEY (`id_user`) REFERENCES `tck_user` (`id`);

--
-- Limitadores para a tabela `tck_ticket`
--
ALTER TABLE `tck_ticket`
  ADD CONSTRAINT `fk_ticket_estado` FOREIGN KEY (`estado`) REFERENCES `tck_estado` (`id`);

--
-- Limitadores para a tabela `tck_user_ticket`
--
ALTER TABLE `tck_user_ticket`
  ADD CONSTRAINT `fk_user_ticket_ticket` FOREIGN KEY (`id_ticket`) REFERENCES `tck_ticket` (`id`),
  ADD CONSTRAINT `fk_user_ticket_user` FOREIGN KEY (`id_user`) REFERENCES `tck_user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
