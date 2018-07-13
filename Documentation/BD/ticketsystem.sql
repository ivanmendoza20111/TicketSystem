-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-07-2018 a las 09:58:21
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ticketsystem`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `note` varchar(10000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `fecha`, `note`) VALUES
(1, 19, '2018-07-12 03:14:03', 'prueba'),
(2, 19, '2018-07-12 03:24:37', 'Prueba 2'),
(3, 19, '2018-07-12 03:31:43', 'Prueba'),
(4, 19, '2018-07-12 03:35:48', 'Prueba 33'),
(5, 18, '2018-07-12 03:36:12', 'Probando las Notas'),
(6, 19, '2018-07-12 03:39:02', 'Listo!!'),
(7, 19, '2018-07-12 03:39:30', 'Listo!!'),
(8, 19, '2018-07-12 03:42:30', 'prueba'),
(9, 19, '2018-07-12 03:42:55', 'prueba'),
(10, 19, '2018-07-12 03:43:39', 'Listo!!'),
(11, 19, '2018-07-12 03:45:22', 'Hola, el precio del mouse es muy caro, necesito el dinero!!'),
(12, 19, '2018-07-12 03:45:51', 'Pasa por mi Oficina para darte el dinero del Mouse'),
(13, 19, '2018-07-12 03:46:14', 'Voy!!'),
(14, 19, '2018-07-12 03:46:24', 'Listo!!'),
(15, 19, '2018-07-12 11:30:45', 'Prueba'),
(16, 19, '2018-07-12 11:38:10', 'Prueba'),
(17, 19, '2018-07-12 11:38:15', 'Pruebaaa'),
(18, 19, '2018-07-13 02:53:03', 'Prueba de la prueba\n\nho'),
(19, 19, '2018-07-12 11:46:06', 'Hola'),
(20, 21, '2018-07-12 11:47:22', 'HOla'),
(21, 19, '2018-07-12 11:59:46', 'prueba'),
(22, 19, '2018-07-12 12:04:23', 'hola'),
(23, 19, '2018-07-12 12:05:15', 'ff'),
(24, 19, '2018-07-12 12:05:50', 'cerrado'),
(25, 19, '2018-07-12 12:09:48', 'ff'),
(26, 19, '2018-07-12 12:15:44', 'Favor ver mi celular please'),
(27, 22, '2018-07-12 12:16:14', 'Listo!!'),
(28, 19, '2018-07-13 02:24:48', 'Listo!!'),
(29, 19, '2018-07-13 02:51:15', 'hg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notes_ticket`
--

CREATE TABLE `notes_ticket` (
  `notes_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(10000) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateend` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hours` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ticket`
--

INSERT INTO `ticket` (`id`, `date`, `subject`, `description`, `status`, `dateend`, `user_id`, `hours`) VALUES
(8, '2018-07-12 01:46:41', 'Prueba', 'Prueba 33', 'Open', NULL, 19, NULL),
(9, '2018-07-12 01:53:14', 'Pc Dañada', 'Buen día!!\n\nSe apago y no quiso volver a encender. Favor chequiar. \n\nMuchas Gracias!!', 'Closed', '2018-07-13 02:51:15', 19, 0.58),
(10, '2018-07-12 01:57:23', 'Puerta dañada', 'La Puerta se cayó, favor habilitarla', 'Closed', '2018-07-12 12:04:23', 19, 10.7),
(12, '2018-07-12 03:45:02', 'Mi Mouse se Rompio', 'Hola!!\r\n\r\nFavor comprarme un Mouse Nuevo\r\n\r\nGracias!!', 'Closed', '2018-07-12 12:05:15', 19, 8.2),
(13, '2018-07-12 11:46:47', 'Prueba', 'Pruebaaa', 'Closed', '2018-07-12 12:09:48', 21, 0),
(14, '2018-07-12 12:15:17', 'Celular dañado', 'Favor ver mi cel que se daño', 'Closed', '2018-07-12 12:16:14', 19, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_notes`
--

CREATE TABLE `ticket_notes` (
  `ticket_id` int(11) NOT NULL,
  `notes_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ticket_notes`
--

INSERT INTO `ticket_notes` (`ticket_id`, `notes_id`) VALUES
(8, 5),
(8, 18),
(9, 15),
(9, 19),
(9, 28),
(9, 29),
(10, 6),
(10, 7),
(10, 8),
(10, 9),
(10, 10),
(10, 22),
(12, 11),
(12, 12),
(12, 13),
(12, 14),
(12, 21),
(12, 23),
(13, 20),
(13, 24),
(13, 25),
(14, 26),
(14, 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_user`
--

CREATE TABLE `ticket_user` (
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ticket_user`
--

INSERT INTO `ticket_user` (`ticket_id`, `user_id`) VALUES
(8, 19),
(8, 21),
(9, 19),
(9, 21),
(10, 18),
(12, 21),
(13, 19),
(14, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(10000) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `lastname`, `username`, `password`, `date_created`, `status`) VALUES
(18, 'Yureyny', 'Madera', 'y.madera', '$2y$04$kbdpszriDPceL1euYCN.qe/L3AU5tjQvnwm8doN9VcsdMtKoPDGvi', '2018-07-10 19:00:22', 'Active'),
(19, 'Ivan', 'Mendoza', 'i.mendoza', '$2y$04$ndgs4l10Av60xq7pf6RIm.NSi1CQUDEri85fMyPq/wNg1P/ghh.ii', '2018-07-10 19:22:34', 'Active'),
(21, 'Wandy', 'Hernandez', 'w.hernandez', '$2y$04$ryRTaJmrMY3h9vBwg03hHeQEoevEhWosyHG308DaXpypPXhOmu0fe', '2018-07-11 12:49:01', 'Inactive'),
(22, 'Edwin', 'Rodriguez', 'ed.rodriguez', '$2y$04$n53qGiu5WT9ypBzBborr/.Ed/jt2zH6V.jQ83aKcrW9bbrwEhZela', '2018-07-12 11:49:13', 'Active');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_ticket`
--

CREATE TABLE `user_ticket` (
  `user_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_11BA68CA76ED395` (`user_id`);

--
-- Indices de la tabla `notes_ticket`
--
ALTER TABLE `notes_ticket`
  ADD PRIMARY KEY (`notes_id`,`ticket_id`),
  ADD KEY `IDX_41ECF9A3FC56F556` (`notes_id`),
  ADD KEY `IDX_41ECF9A3700047D2` (`ticket_id`);

--
-- Indices de la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_97A0ADA3A76ED395` (`user_id`);

--
-- Indices de la tabla `ticket_notes`
--
ALTER TABLE `ticket_notes`
  ADD PRIMARY KEY (`ticket_id`,`notes_id`),
  ADD KEY `IDX_292BC507700047D2` (`ticket_id`),
  ADD KEY `IDX_292BC507FC56F556` (`notes_id`);

--
-- Indices de la tabla `ticket_user`
--
ALTER TABLE `ticket_user`
  ADD PRIMARY KEY (`ticket_id`,`user_id`),
  ADD KEY `IDX_BF48C371700047D2` (`ticket_id`),
  ADD KEY `IDX_BF48C371A76ED395` (`user_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- Indices de la tabla `user_ticket`
--
ALTER TABLE `user_ticket`
  ADD PRIMARY KEY (`user_id`,`ticket_id`),
  ADD KEY `IDX_F2F2B69EA76ED395` (`user_id`),
  ADD KEY `IDX_F2F2B69E700047D2` (`ticket_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `FK_11BA68CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `notes_ticket`
--
ALTER TABLE `notes_ticket`
  ADD CONSTRAINT `FK_41ECF9A3700047D2` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_41ECF9A3FC56F556` FOREIGN KEY (`notes_id`) REFERENCES `notes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `FK_97A0ADA3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `ticket_notes`
--
ALTER TABLE `ticket_notes`
  ADD CONSTRAINT `FK_292BC507700047D2` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_292BC507FC56F556` FOREIGN KEY (`notes_id`) REFERENCES `notes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ticket_user`
--
ALTER TABLE `ticket_user`
  ADD CONSTRAINT `FK_BF48C371700047D2` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_BF48C371A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `user_ticket`
--
ALTER TABLE `user_ticket`
  ADD CONSTRAINT `FK_F2F2B69E700047D2` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F2F2B69EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
