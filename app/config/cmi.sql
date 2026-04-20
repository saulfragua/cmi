-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-04-2026 a las 19:54:32
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_formulario`
--

CREATE TABLE `estados_formulario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operador_curso`
--

CREATE TABLE `operador_curso` (
  `id` int(11) NOT NULL,
  `operador_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operador_unidad`
--

CREATE TABLE `operador_unidad` (
  `id` int(11) NOT NULL,
  `operador_id` int(11) NOT NULL,
  `unidad_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `actividad_operador`
--
ALTER TABLE `actividad_operador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `actividad_operador_historico`
--
ALTER TABLE `actividad_operador_historico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estados_formulario`
--
ALTER TABLE `estados_formulario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formulario`
--
ALTER TABLE `formulario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operadores`
--
ALTER TABLE `operadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operador_curso`
--
ALTER TABLE `operador_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operador_especialidad`
--
ALTER TABLE `operador_especialidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `operador_unidad`
--
ALTER TABLE `operador_unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rangos`
--
ALTER TABLE `rangos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
