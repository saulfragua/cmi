-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-04-2026 a las 18:40:40
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cmi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `tipo` enum('curso','entrenamiento','mision','operacion','ejercicio') NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `operador_id` int(11) NOT NULL,
  `registrado_por` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  `estado` enum('Borrador','Publicada','Finalizada','Cancelada') DEFAULT 'Borrador',
  `total_convocados` int(11) NOT NULL DEFAULT 0,
  `total_asistieron` int(11) NOT NULL DEFAULT 0,
  `total_no_asistieron` int(11) NOT NULL DEFAULT 0,
  `total_pendientes_cierre` int(11) NOT NULL DEFAULT 0,
  `fecha_cierre` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `nombre`, `descripcion`, `imagen`, `tipo`, `fecha`, `hora_inicio`, `operador_id`, `registrado_por`, `fecha_registro`, `estado`, `total_convocados`, `total_asistieron`, `total_no_asistieron`, `total_pendientes_cierre`, `fecha_cierre`) VALUES
(4, 'SAUL FRAGUA', 'asdasdasdasdasdasdasdasd', 'uploads/actividades/1776125161_107410_55.jpg', 'entrenamiento', '2026-04-23', '19:08:00', 4, NULL, '2026-04-14 00:06:01', 'Finalizada', 0, 0, 0, 0, NULL),
(5, 'Curso Avanzado de Combate', 'asdasedasdasdasdasdasd', 'uploads/actividades/1776125920_error404.png', 'entrenamiento', '2026-04-30', '19:24:00', 4, NULL, '2026-04-14 00:18:40', 'Cancelada', 4, 1, 0, 3, '2026-04-14 06:45:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_operador`
--

CREATE TABLE `actividad_operador` (
  `id` int(11) NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `operador_id` int(11) NOT NULL,
  `estado` enum('Pendiente','Asiste','No asiste') DEFAULT 'Pendiente',
  `fecha_respuesta` datetime DEFAULT NULL,
  `observacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividad_operador`
--

INSERT INTO `actividad_operador` (`id`, `actividad_id`, `operador_id`, `estado`, `fecha_respuesta`, `observacion`) VALUES
(15, 4, 2, 'Pendiente', NULL, NULL),
(16, 4, 3, 'Pendiente', NULL, NULL),
(17, 4, 4, 'Asiste', '2026-04-13 19:12:05', NULL),
(18, 4, 5, 'No asiste', '2026-04-13 19:12:12', NULL),
(22, 5, 2, 'Pendiente', NULL, NULL),
(23, 5, 3, 'Pendiente', NULL, NULL),
(24, 5, 4, 'Pendiente', '2026-04-14 10:31:20', 'askjaskjdhakjsdnjklasd'),
(25, 5, 5, 'Pendiente', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_operador_historico`
--

CREATE TABLE `actividad_operador_historico` (
  `id` int(11) NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `operador_id` int(11) DEFAULT NULL,
  `codigo_operador` varchar(50) DEFAULT NULL,
  `nombre_completo` varchar(150) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `estado_operador` varchar(30) DEFAULT NULL,
  `estado_participacion` enum('Pendiente','Asiste','No asiste') NOT NULL DEFAULT 'Pendiente',
  `observacion` text DEFAULT NULL,
  `fecha_respuesta` datetime DEFAULT NULL,
  `fecha_cierre_historico` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividad_operador_historico`
--

INSERT INTO `actividad_operador_historico` (`id`, `actividad_id`, `operador_id`, `codigo_operador`, `nombre_completo`, `telefono`, `estado_operador`, `estado_participacion`, `observacion`, `fecha_respuesta`, `fecha_cierre_historico`) VALUES
(1, 5, 2, 'CMI0002', 'SAUL FRAGUA NOVA', '3209839356', 'Activo', 'Pendiente', NULL, NULL, '2026-04-14 06:45:37'),
(2, 5, 3, 'CMI0003', 'prueba prueba', '3209839356', 'Activo', 'Pendiente', NULL, NULL, '2026-04-14 06:45:37'),
(3, 5, 4, 'CMI0004', 'FERNEY FRAGUA NOVA', '32098888888', 'Reserva', 'Asiste', 'askjaskjdhakjsdnjklasd', '2026-04-13 19:19:57', '2026-04-14 06:45:37'),
(4, 5, 5, 'CMI0005', 'Pedro Picapiedra ', '3209839356', 'Activo', 'Pendiente', NULL, NULL, '2026-04-14 06:45:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `sigla` varchar(20) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `nombre`, `sigla`, `imagen`, `estado`) VALUES
(1, 'Curso Combate Basico', 'CBC', 'curso_combate_basico.png', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `sigla` varchar(10) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`id`, `nombre`, `sigla`, `imagen`, `estado`) VALUES
(2, 'Ametrallador', 'MG', 'ametrallador.png', 'Activo'),
(3, 'Radio Operador', 'RO', 'radio_operador.png', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_formulario`
--

CREATE TABLE `estados_formulario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_formulario`
--

INSERT INTO `estados_formulario` (`id`, `nombre`) VALUES
(1, 'Pendiente'),
(2, 'En revision'),
(3, 'Aprobado'),
(4, 'Rechazado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario`
--

CREATE TABLE `formulario` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `estado_id` int(11) DEFAULT 1,
  `observaciones` text DEFAULT NULL,
  `evaluado_por` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  `motivo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `formulario`
--

INSERT INTO `formulario` (`id`, `nombre_completo`, `fecha_nacimiento`, `pais`, `telefono`, `estado_id`, `observaciones`, `evaluado_por`, `fecha_registro`, `motivo`) VALUES
(1, 'SAUL FRAGUA NOVA ', '1988-04-10', 'Colombia', '3209839356', 3, 'aprovado por los poderes de superman', 0, '2026-04-09 17:29:17', NULL),
(2, 'FERNEY FRAGUA NOVA ', '1988-04-10', 'Argentina', '32098888888', 3, 'asdasdas', 0, '2026-04-09 17:33:56', NULL),
(3, 'PAPA NOEL ', '1880-10-10', 'Estados Unidos', '3209839356', 4, 'por no tivos de no contacto', 0, '2026-04-09 18:35:13', NULL),
(4, 'prueba prueba', '1988-10-10', 'Colombia', '3209839356', 3, 'as', 0, '2026-04-09 18:39:46', NULL),
(5, 'ESTA CARGANDO EL MOTIVO ', '2025-10-10', 'Argentina', '32098888888', 3, 'a', 0, '2026-04-09 18:43:52', 'QWEQWEQWEQWEQWEQWEQWEQWEQWE'),
(6, 'Pedro Picapiedra ', '1980-10-10', 'Nicaragua', '3209839356', 3, 'tiene todo lo necesariopara ingreso', 0, '2026-04-13 18:21:09', 'quiero ingresar por me ha parecido una buena comuniada ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operadores`
--

CREATE TABLE `operadores` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `foto_operador` varchar(255) DEFAULT NULL,
  `nombre_completo` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `rango_id` int(11) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `rol` enum('operador','mando','admin') DEFAULT 'operador',
  `fecha_ultimo_ascenso` date DEFAULT NULL,
  `fecha_modificacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario_actualiza` int(11) DEFAULT NULL,
  `estado` enum('Activo','Reserva','Retirado','Suspendido') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operadores`
--

INSERT INTO `operadores` (`id`, `codigo`, `clave`, `foto_operador`, `nombre_completo`, `fecha_nacimiento`, `rango_id`, `pais`, `telefono`, `rol`, `fecha_ultimo_ascenso`, `fecha_modificacion`, `usuario_actualiza`, `estado`) VALUES
(1, 'CMI0001', '$2y$10$315fHvzjZQzvFytO1fAvm./cd593ltBol307SszQOkdCWLTGRucsS', NULL, 'ESTA CARGANDO EL MOTIVO ', '2025-10-10', NULL, 'Argentina', '32098888888', 'operador', NULL, '2026-04-13 20:59:29', 0, 'Retirado'),
(2, 'CMI0002', '$2y$10$UFuoMkso7aHI0deE.92z1uTt4FUuQTAOX15PEaxfgdNKXHS5hyCmO', NULL, 'SAUL FRAGUA NOVA', '1988-04-10', 4, 'Colombia', '3209839356', 'operador', '1988-04-10', '2026-04-14 11:45:52', 0, 'Suspendido'),
(3, 'CMI0003', '$2y$10$E4c9i2GOkK.lZLmsqqv9rerZkR3r.EpQVhFM3TEsem7fk3aoUPBDa', NULL, 'prueba prueba', '1988-10-10', NULL, 'Colombia', '3209839356', 'operador', NULL, '2026-04-14 15:41:02', 0, 'Activo'),
(4, 'CMI0004', '$2y$10$WeP5VV5WQYfhAr1Bw11pOeRX9yssgzJZb4/7PSfDK5aTDBlGlfZoq', 'ferney_fragua_nova.png', 'FERNEY FRAGUA NOVA', '1988-04-10', 4, 'Argentina', '32098888888', 'operador', '2026-04-10', '2026-04-14 00:20:34', 0, 'Reserva'),
(5, 'CMI0005', '$2y$10$LR3TB2d56vQtQN6JfbrgO.xxeVqmKUrihj613xuXUkdN8ywVjCULm', 'pedro_picapiedra.jpeg', 'Pedro Picapiedra', '1980-10-10', 4, 'Nicaragua', '3209839356', 'operador', NULL, '2026-04-14 15:32:08', 0, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operador_curso`
--

CREATE TABLE `operador_curso` (
  `id` int(11) NOT NULL,
  `operador_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operador_curso`
--

INSERT INTO `operador_curso` (`id`, `operador_id`, `curso_id`) VALUES
(2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operador_especialidad`
--

CREATE TABLE `operador_especialidad` (
  `id` int(11) NOT NULL,
  `operador_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `principal` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operador_especialidad`
--

INSERT INTO `operador_especialidad` (`id`, `operador_id`, `especialidad_id`, `principal`) VALUES
(14, 2, 2, 1),
(15, 2, 3, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operador_unidad`
--

CREATE TABLE `operador_unidad` (
  `id` int(11) NOT NULL,
  `operador_id` int(11) NOT NULL,
  `unidad_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operador_unidad`
--

INSERT INTO `operador_unidad` (`id`, `operador_id`, `unidad_id`) VALUES
(6, 2, 2),
(7, 2, 3),
(8, 4, 3),
(9, 5, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rangos`
--

CREATE TABLE `rangos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `sigla` varchar(10) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rangos`
--

INSERT INTO `rangos` (`id`, `nombre`, `sigla`, `imagen`, `estado`) VALUES
(4, 'Sargento Primero', 'SGTO1', 'sargento_primero.png', 'Activo'),
(5, 'Sargento Segundo', 'SS', NULL, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `sigla` varchar(10) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `nombre`, `sigla`, `imagen`, `estado`) VALUES
(2, 'AEREO', 'ASDAS', 'aereo.png', 'Activo'),
(3, 'Julio Cesar', 'JC', 'julio_cesar.jpeg', 'Activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_actividad_operador` (`operador_id`);

--
-- Indices de la tabla `actividad_operador`
--
ALTER TABLE `actividad_operador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unica_actividad_operador` (`actividad_id`,`operador_id`),
  ADD KEY `fk_act_op_operador` (`operador_id`);

--
-- Indices de la tabla `actividad_operador_historico`
--
ALTER TABLE `actividad_operador_historico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `actividad_id` (`actividad_id`),
  ADD KEY `operador_id` (`operador_id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estados_formulario`
--
ALTER TABLE `estados_formulario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `formulario`
--
ALTER TABLE `formulario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estado_id` (`estado_id`);

--
-- Indices de la tabla `operadores`
--
ALTER TABLE `operadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `rango_id` (`rango_id`);

--
-- Indices de la tabla `operador_curso`
--
ALTER TABLE `operador_curso`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_operador_curso` (`operador_id`,`curso_id`),
  ADD KEY `fk_operador_curso_curso` (`curso_id`);

--
-- Indices de la tabla `operador_especialidad`
--
ALTER TABLE `operador_especialidad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_operador_especialidad` (`operador_id`,`especialidad_id`),
  ADD KEY `fk_operador_especialidad_especialidad` (`especialidad_id`);

--
-- Indices de la tabla `operador_unidad`
--
ALTER TABLE `operador_unidad`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_operador_unidad` (`operador_id`,`unidad_id`),
  ADD KEY `fk_operador_unidad_unidad` (`unidad_id`);

--
-- Indices de la tabla `rangos`
--
ALTER TABLE `rangos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `actividad_operador`
--
ALTER TABLE `actividad_operador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `actividad_operador_historico`
--
ALTER TABLE `actividad_operador_historico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estados_formulario`
--
ALTER TABLE `estados_formulario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `formulario`
--
ALTER TABLE `formulario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `operadores`
--
ALTER TABLE `operadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `operador_curso`
--
ALTER TABLE `operador_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `operador_especialidad`
--
ALTER TABLE `operador_especialidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `operador_unidad`
--
ALTER TABLE `operador_unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `rangos`
--
ALTER TABLE `rangos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `fk_actividad_operador` FOREIGN KEY (`operador_id`) REFERENCES `operadores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `actividad_operador`
--
ALTER TABLE `actividad_operador`
  ADD CONSTRAINT `fk_act_op_actividad` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_act_op_operador` FOREIGN KEY (`operador_id`) REFERENCES `operadores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `formulario`
--
ALTER TABLE `formulario`
  ADD CONSTRAINT `formulario_ibfk_1` FOREIGN KEY (`estado_id`) REFERENCES `estados_formulario` (`id`);

--
-- Filtros para la tabla `operadores`
--
ALTER TABLE `operadores`
  ADD CONSTRAINT `operadores_ibfk_1` FOREIGN KEY (`rango_id`) REFERENCES `rangos` (`id`);

--
-- Filtros para la tabla `operador_curso`
--
ALTER TABLE `operador_curso`
  ADD CONSTRAINT `fk_operador_curso_curso` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_operador_curso_operador` FOREIGN KEY (`operador_id`) REFERENCES `operadores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `operador_especialidad`
--
ALTER TABLE `operador_especialidad`
  ADD CONSTRAINT `fk_operador_especialidad_especialidad` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_operador_especialidad_operador` FOREIGN KEY (`operador_id`) REFERENCES `operadores` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `operador_unidad`
--
ALTER TABLE `operador_unidad`
  ADD CONSTRAINT `fk_operador_unidad_operador` FOREIGN KEY (`operador_id`) REFERENCES `operadores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_operador_unidad_unidad` FOREIGN KEY (`unidad_id`) REFERENCES `unidades` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
