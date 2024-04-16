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

