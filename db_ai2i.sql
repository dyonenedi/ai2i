-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.6.20 - MySQL Community Server (GPL)
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              9.2.0.4947
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura do banco de dados para dyon_ai2i
CREATE DATABASE IF NOT EXISTS `dyon_ai2i` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dyon_ai2i`;


-- Copiando estrutura para tabela dyon_ai2i.memory
DROP TABLE IF EXISTS `memory`;
CREATE TABLE IF NOT EXISTS `memory` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `frase` varchar(255) NOT NULL,
  `refere` varchar(27) NOT NULL,
  `confiability` tinyint(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `frase_2` (`frase`),
  KEY `refere` (`refere`),
  KEY `confiability` (`confiability`),
  FULLTEXT KEY `frase_1` (`frase`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='Isso vai ser difícil!';

-- Copiando dados para a tabela dyon_ai2i.memory: 9 rows
DELETE FROM `memory`;
/*!40000 ALTER TABLE `memory` DISABLE KEYS */;
INSERT INTO `memory` (`id`, `frase`, `refere`, `confiability`, `date`) VALUES
	(1, 'dyon enedi adoro pizza', 'dyon enedi', 50, '2015-03-14 15:35:22'),
	(2, 'dyon enedi amo a gabriela', 'dyon enedi', 50, '2015-03-14 15:35:28'),
	(4, 'dyon enedi amo aviões', 'dyon enedi', 50, '2015-03-14 15:35:47'),
	(6, 'sério , dyon enedi amo a gabriela', 'dyon enedi', 50, '2015-03-14 16:37:47'),
	(7, 'pizza é certo', 'dyon enedi', 50, '2015-03-14 17:11:36'),
	(8, 'amo é certo', 'dyon enedi', 50, '2015-03-14 18:05:20'),
	(9, 'a gabi é linda', 'dyon enedi', 50, '2015-03-14 18:22:39'),
	(10, 'pois é', 'dyon', 50, '2015-05-27 14:11:38'),
	(11, 'gosto de comer maça também', 'dyon', 50, '2015-05-27 14:11:46');
/*!40000 ALTER TABLE `memory` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
