/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `votos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `rut` varchar(12) NOT NULL,
  `email` varchar(255) NOT NULL,
  `region` int NOT NULL,
  `comuna` int NOT NULL,
  `candidato` varchar(255) NOT NULL,
  `como_se_entero` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `votos` (`id`, `nombre`, `alias`, `rut`, `email`, `region`, `comuna`, `candidato`, `como_se_entero`) VALUES
(1, 'Francisco Jourdan', 'asdfddsfds', '17961332-8', 'fcojour@gmail.com', 13, 1, 'candidato3', 'web,redes_sociales');
INSERT INTO `votos` (`id`, `nombre`, `alias`, `rut`, `email`, `region`, `comuna`, `candidato`, `como_se_entero`) VALUES
(2, 'Francisco Jourdan', 'francis', '12.321.321-8', 'fco@fco.com', 1, 1, 'candidato1', 'web,tv');
INSERT INTO `votos` (`id`, `nombre`, `alias`, `rut`, `email`, `region`, `comuna`, `candidato`, `como_se_entero`) VALUES
(3, 'Germundio Irene', 'Germun', '15.426.523-3', 'germ@gmail.com', 7, 96, 'candidato3', 'tv,redes_sociales');
INSERT INTO `votos` (`id`, `nombre`, `alias`, `rut`, `email`, `region`, `comuna`, `candidato`, `como_se_entero`) VALUES
(4, 'Solange rivera', 'Soled', '74.545.214-8', 'sol@soledad.com', 8, 140, 'candidato3', 'web,redes_sociales'),
(5, 'Francisco Jourdan', 'asdfddsfds', '17.961.332-8', 'fcos@fcos.com', 1, 1, 'candidato1', 'tv,redes_sociales,amigo'),
(6, 'Emanuel', 'emanu', '45.231.526-8', 'emaul@emaniel.com', 6, 51, 'candidato3', 'web,tv,redes_sociales,amigo');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;