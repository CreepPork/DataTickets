-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 14, 2014 at 09:37 AM
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
  `data` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tck_arquivos`
--


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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tck_ticket`
--


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
(1, 'Administrador', 'adm@adm.com', 'root', 'e10adc3949ba59abbe56e057f20f883e', 1);

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

