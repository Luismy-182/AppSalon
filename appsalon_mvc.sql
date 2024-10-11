-- -------------------------------------------------------------
-- -------------------------------------------------------------
-- TablePlus 1.2.0
--
-- https://tableplus.com/
--
-- Database: mysql
-- Generation Time: 2024-10-10 22:51:56.432359
-- -------------------------------------------------------------

CREATE TABLE `citas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `usuarioId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuarioId_FK` (`usuarioId`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `citasservicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `citaId` int(11) NOT NULL,
  `servicioId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `citaID_FK` (`citaId`),
  KEY `servicioID_FK` (`servicioId`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `precio` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(65) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `confirmado` tinyint(1) NOT NULL,
  `token` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `appsalon_mvc`.`citas` (`id`, `fecha`, `hora`, `usuarioId`) VALUES 
(18, '2024-06-17', '13:00:00', 20),
(19, '2024-06-19', '14:10:00', 22),
(21, '2024-10-18', '16:33:00', 30),
(22, '2024-10-24', '16:33:00', 30),
(23, '2024-10-24', '16:33:00', 30),
(24, '2024-10-22', '16:00:00', 30);

INSERT INTO `appsalon_mvc`.`citasservicios` (`id`, `citaId`, `servicioId`) VALUES 
(3, 18, 1),
(4, 18, 2),
(5, 18, 4),
(6, 18, 3),
(7, 18, 5),
(8, 18, 7),
(9, 19, 1),
(10, 19, 2),
(11, 19, 4),
(12, 19, 3),
(13, 19, 5),
(14, 19, 7),
(15, 19, 8),
(16, 20, 1),
(17, 20, 2),
(18, 20, 3),
(19, 20, 4),
(20, 20, 12),
(21, 23, 16),
(22, 24, 16);

INSERT INTO `appsalon_mvc`.`servicios` (`id`, `nombre`, `precio`) VALUES 
(1, 'Corte de Cabello Mujer', 90.00),
(2, 'Corte de Cabello Hombre', 80.00),
(3, 'Corte de cabello niño', 60.00),
(4, 'Peinado Mujer', 80.00),
(5, 'Peinado Hombre', 60.00),
(7, 'Peinado Niño', 60.00),
(8, 'Corte de Barba', 60.00),
(9, 'Tinte Mujer', 300.00),
(10, 'Uñas', 400.00),
(11, 'Lavado de Cabello', 50.00),
(12, 'Tratamiento Capilar', 150.00),
(16, ' Corte Two Block', 65.00);

INSERT INTO `appsalon_mvc`.`usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `telefono`, `admin`, `confirmado`, `token`) VALUES 
(30, ' Mike', 'Suarez', 'correo@gmail.com', '$2y$10$UOGcbnzBGpuoWdFrVPPyyOlWlxNDx0Qw5Ue/l9Lz7Wyxgg48JaJSC', '2461735434', 0, 1, ''),
(31, ' Miguel Angel', 'Suarez', 'admin@hotmail.com', '$2y$10$/tGqXVTw14ZVBrmG8bqrz.4q9mTQMbJ3IZo1Jz5ehhgZsl1hs5SRu', '2461735434', 1, 1, '');

