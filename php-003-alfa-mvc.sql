SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `php-003-alfa-mvc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `php-003-alfa-mvc`;

CREATE TABLE IF NOT EXISTS `fabricante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `fabricante` (`id`, `nome`) VALUES
(1, 'Adidas'),
(2, 'Dal Ponte'),
(3, 'Olympicus');

CREATE TABLE IF NOT EXISTS `linha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `linha` (`id`, `nome`) VALUES
(1, 'Camiseta Oficial'),
(2, 'Camiseta Treino'),
(3, 'Camiseta Comemorativa');

CREATE TABLE IF NOT EXISTS `produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linha_id` int(11) NOT NULL,
  `fabricante_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` mediumtext,
  `preco` float DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `imagem` varchar(100) DEFAULT NULL,
  `destaque` tinyint(1) DEFAULT NULL,
  `qtd_estoque` float DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produto_FKIndex1` (`fabricante_id`),
  KEY `produto_FKIndex2` (`linha_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `usuario` (
  `login` varchar(15) NOT NULL,
  `senha` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `usuario` (`login`, `senha`) VALUES
('admin', '202cb962ac59075b964b07152d234b70');


ALTER TABLE `produto`
  ADD CONSTRAINT `fk_01` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_02` FOREIGN KEY (`linha_id`) REFERENCES `linha` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
