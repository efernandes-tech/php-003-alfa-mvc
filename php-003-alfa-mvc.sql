SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS `fabricante`;
CREATE TABLE IF NOT EXISTS `fabricante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `fabricante` (`id`, `nome`) VALUES
(1, 'Adidas'),
(2, 'Dal Ponte'),
(3, 'Olympicus');

DROP TABLE IF EXISTS `linha`;
CREATE TABLE IF NOT EXISTS `linha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `linha` (`id`, `nome`) VALUES
(1, 'Camiseta Oficial'),
(2, 'Camiseta Treino'),
(3, 'Camiseta Comemorativa');

DROP TABLE IF EXISTS `produto`;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

INSERT INTO `produto` (`id`, `linha_id`, `fabricante_id`, `nome`, `descricao`, `preco`, `peso`, `imagem`, `destaque`, `qtd_estoque`, `ativo`) VALUES
(6, 2, 2, 'produto a', 'desc prod a', 29.9, 2.5, '5a2ed0e9f1837_bkg_sgi03.jpg', 1, 20, 1),
(9, 3, 1, 'produto b', 'desc prod b', 99.9, 1.75, '', 1, 1000, 1);

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `login` varchar(15) NOT NULL,
  `senha` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `usuario` (`login`, `senha`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3');


ALTER TABLE `produto`
  ADD CONSTRAINT `fk_01` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_02` FOREIGN KEY (`linha_id`) REFERENCES `linha` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
