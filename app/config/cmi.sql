-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-04-2026 a las 20:49:45
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
(1, 'curso', 'asdasdasd', 'uploads/actividades/1776272327_Captura_de_pantalla_2026-04-13_083648.png', 'curso', '2026-04-06', '19:30:00', 4, NULL, '2026-04-15 16:49:14', 'Finalizada', 3, 0, 0, 3, '2026-04-15 12:01:10'),
(2, 'entrenamiento', '', NULL, 'entrenamiento', '2026-04-06', '23:49:00', 2, NULL, '2026-04-15 16:49:44', 'Finalizada', 4, 0, 0, 4, '2026-04-15 12:06:12'),
(3, 'mision', '', NULL, 'mision', '2026-04-06', '23:50:00', 2, NULL, '2026-04-15 16:50:06', 'Finalizada', 4, 1, 0, 3, '2026-04-15 12:06:44'),
(4, 'operacion', '', NULL, 'operacion', '2026-04-06', '23:50:00', 2, NULL, '2026-04-15 16:50:38', 'Finalizada', 4, 0, 0, 4, '2026-04-15 12:36:33'),
(5, 'operacion', 'jaslasdakdñkañslkdñlaksdkñaskdñkñaskdñlkañlskdñlkasd', 'uploads/actividades/1776276484_Captura_de_pantalla_2026-03-03_093707.png', 'entrenamiento', '2026-04-15', '13:07:00', 2, NULL, '2026-04-15 18:08:04', 'Finalizada', 5, 3, 2, 0, '2026-04-15 13:08:45');

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
(1, 1, 3, 'Pendiente', NULL, NULL),
(2, 1, 4, 'Pendiente', NULL, NULL),
(3, 1, 5, 'Pendiente', NULL, NULL),
(4, 2, 3, 'Pendiente', NULL, NULL),
(5, 2, 4, 'Pendiente', NULL, NULL),
(6, 2, 5, 'Pendiente', NULL, NULL),
(7, 3, 3, 'Pendiente', NULL, NULL),
(8, 3, 4, 'Pendiente', NULL, NULL),
(9, 3, 5, 'Pendiente', NULL, NULL),
(10, 4, 3, 'Pendiente', NULL, NULL),
(11, 4, 4, 'Pendiente', NULL, NULL),
(12, 4, 5, 'Pendiente', NULL, NULL),
(13, 2, 2, 'Pendiente', NULL, NULL),
(14, 3, 2, 'Asiste', '2026-04-15 12:06:33', NULL),
(15, 4, 2, 'Pendiente', NULL, NULL),
(16, 5, 1, 'Asiste', '2026-04-15 13:08:20', NULL),
(17, 5, 2, 'No asiste', '2026-04-15 13:08:38', NULL),
(18, 5, 3, 'No asiste', '2026-04-15 13:08:34', NULL),
(19, 5, 4, 'Asiste', '2026-04-15 13:08:24', NULL),
(20, 5, 5, 'Asiste', '2026-04-15 13:08:28', NULL);

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
(1, 1, 3, 'CMI0003', 'prueba prueba', '3209839356', 'Activo', 'Pendiente', NULL, NULL, '2026-04-15 12:01:10'),
(2, 1, 4, 'CMI0004', 'FERNEY FRAGUA NOVA', '32098888888', 'Reserva', 'Pendiente', NULL, NULL, '2026-04-15 12:01:10'),
(3, 1, 5, 'CMI0005', 'Pedro Picapiedra', '3209839356', 'Activo', 'Pendiente', NULL, NULL, '2026-04-15 12:01:10'),
(4, 2, 2, 'CMI0002', 'SAUL FRAGUA NOVA', '3209839356', 'Activo', 'Pendiente', NULL, NULL, '2026-04-15 12:06:12'),
(5, 2, 3, 'CMI0003', 'prueba prueba', '3209839356', 'Retirado', 'Pendiente', NULL, NULL, '2026-04-15 12:06:12'),
(6, 2, 4, 'CMI0004', 'FERNEY FRAGUA NOVA', '32098888888', 'Retirado', 'Pendiente', NULL, NULL, '2026-04-15 12:06:12'),
(7, 2, 5, 'CMI0005', 'Pedro Picapiedra', '3209839356', 'Retirado', 'Pendiente', NULL, NULL, '2026-04-15 12:06:12'),
(11, 3, 2, 'CMI0002', 'SAUL FRAGUA NOVA', '3209839356', 'Activo', 'Asiste', NULL, '2026-04-15 12:06:33', '2026-04-15 12:06:44'),
(12, 3, 3, 'CMI0003', 'prueba prueba', '3209839356', 'Retirado', 'Pendiente', NULL, NULL, '2026-04-15 12:06:44'),
(13, 3, 4, 'CMI0004', 'FERNEY FRAGUA NOVA', '32098888888', 'Retirado', 'Pendiente', NULL, NULL, '2026-04-15 12:06:44'),
(14, 3, 5, 'CMI0005', 'Pedro Picapiedra', '3209839356', 'Retirado', 'Pendiente', NULL, NULL, '2026-04-15 12:06:44'),
(18, 4, 2, 'CMI0002', 'SAUL FRAGUA NOVA', '3209839356', 'Activo', 'Pendiente', NULL, NULL, '2026-04-15 12:36:33'),
(19, 4, 3, 'CMI0003', 'prueba prueba', '3209839356', 'Retirado', 'Pendiente', NULL, NULL, '2026-04-15 12:36:33'),
(20, 4, 4, 'CMI0004', 'FERNEY FRAGUA NOVA', '32098888888', 'Retirado', 'Pendiente', NULL, NULL, '2026-04-15 12:36:33'),
(21, 4, 5, 'CMI0005', 'Pedro Picapiedra', '3209839356', 'Retirado', 'Pendiente', NULL, NULL, '2026-04-15 12:36:33'),
(25, 5, 1, 'CMI0001', 'ESTA CARGANDO EL MOTIVO ', '32098888888', 'Activo', 'Asiste', NULL, '2026-04-15 13:08:20', '2026-04-15 13:08:45'),
(26, 5, 2, 'CMI0002', 'SAUL FRAGUA NOVA', '3209839356', 'Activo', 'No asiste', NULL, '2026-04-15 13:08:38', '2026-04-15 13:08:45'),
(27, 5, 3, 'CMI0003', 'prueba prueba', '3209839356', 'Activo', 'No asiste', NULL, '2026-04-15 13:08:34', '2026-04-15 13:08:45'),
(28, 5, 4, 'CMI0004', 'FERNEY FRAGUA NOVA', '32098888888', 'Activo', 'Asiste', NULL, '2026-04-15 13:08:24', '2026-04-15 13:08:45'),
(29, 5, 5, 'CMI0005', 'Pedro Picapiedra', '3209839356', 'Activo', 'Asiste', NULL, '2026-04-15 13:08:28', '2026-04-15 13:08:45');

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
  `pais_id` int(11) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `discord` varchar(100) DEFAULT NULL,
  `indicativo` varchar(10) DEFAULT NULL,
  `estado_id` int(11) DEFAULT 1,
  `observaciones` text DEFAULT NULL,
  `evaluado_por` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  `motivo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `formulario`
--

INSERT INTO `formulario` (`id`, `nombre_completo`, `fecha_nacimiento`, `pais_id`, `telefono`, `discord`, `indicativo`, `estado_id`, `observaciones`, `evaluado_por`, `fecha_registro`, `motivo`) VALUES
(1, 'SAUL FRAGUA NOVA ', '1988-04-10', NULL, '3209839356', NULL, NULL, 3, 'aprovado por los poderes de superman', 0, '2026-04-09 17:29:17', NULL),
(2, 'FERNEY FRAGUA NOVA ', '1988-04-10', NULL, '32098888888', NULL, NULL, 3, 'asdasdas', 0, '2026-04-09 17:33:56', NULL),
(3, 'PAPA NOEL ', '1880-10-10', NULL, '3209839356', NULL, NULL, 4, 'por no tivos de no contacto', 0, '2026-04-09 18:35:13', NULL),
(4, 'prueba prueba', '1988-10-10', NULL, '3209839356', NULL, NULL, 3, 'as', 0, '2026-04-09 18:39:46', NULL),
(5, 'ESTA CARGANDO EL MOTIVO ', '2025-10-10', NULL, '32098888888', NULL, NULL, 3, 'a', 0, '2026-04-09 18:43:52', 'QWEQWEQWEQWEQWEQWEQWEQWEQWE'),
(6, 'Pedro Picapiedra ', '1980-10-10', NULL, '3209839356', NULL, NULL, 3, 'tiene todo lo necesariopara ingreso', 0, '2026-04-13 18:21:09', 'quiero ingresar por me ha parecido una buena comuniada '),
(7, 'SAUL FRAGUA', '1988-10-10', 4, '3209839356', 'fragua', '+43', 3, 'aprobado', 2, '2026-04-19 20:28:03', 'qseqasdasd'),
(8, 'SAUL FRAGUA NOVA', '1988-04-10', 11, '3209839356', 'Kratos', '+57', 1, NULL, NULL, '2026-04-20 12:54:31', 'quiero aprender');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedades`
--

CREATE TABLE `novedades` (
  `id` int(11) NOT NULL,
  `operador_id` int(11) NOT NULL,
  `tipo` enum('Llamado de atención','Felicitación') NOT NULL,
  `nivel` enum('Leve','Moderado','Grave','Muy Grave') DEFAULT NULL,
  `categoria` enum('Disciplinario','Operativo','Administrativo') DEFAULT NULL,
  `descripcion` text NOT NULL,
  `observaciones` text DEFAULT NULL,
  `estado` enum('Activo','Cerrado','Anulado') DEFAULT 'Activo',
  `registrado_por` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_anulacion` datetime DEFAULT NULL,
  `motivo_anulacion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `novedades`
--

INSERT INTO `novedades` (`id`, `operador_id`, `tipo`, `nivel`, `categoria`, `descripcion`, `observaciones`, `estado`, `registrado_por`, `fecha_registro`, `fecha_anulacion`, `motivo_anulacion`) VALUES
(1, 2, 'Felicitación', NULL, NULL, 'felicitar al opedaor por su actividades y comprmisos', 'aca es observaciones', 'Activo', 2, '2026-04-17 12:54:21', NULL, NULL),
(2, 2, 'Llamado de atención', 'Moderado', 'Disciplinario', 'asdasdasd', 'asdasd', 'Activo', 2, '2026-04-17 12:54:44', NULL, NULL),
(3, 2, 'Llamado de atención', 'Muy Grave', 'Disciplinario', 'imrespeto al mando superiores', NULL, 'Activo', 2, '2026-04-17 12:55:55', NULL, NULL);

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
  `alias` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `rango_id` int(11) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `discord` varchar(100) DEFAULT NULL,
  `steam` varchar(100) DEFAULT NULL,
  `rol` enum('operador','mando','admin') DEFAULT 'operador',
  `fecha_ultimo_ascenso` date DEFAULT NULL,
  `fecha_modificacion` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario_actualiza` int(11) DEFAULT NULL,
  `estado` enum('Activo','Reserva','Retirado','Suspendido') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operadores`
--

INSERT INTO `operadores` (`id`, `codigo`, `clave`, `foto_operador`, `nombre_completo`, `alias`, `fecha_nacimiento`, `rango_id`, `pais`, `telefono`, `discord`, `steam`, `rol`, `fecha_ultimo_ascenso`, `fecha_modificacion`, `usuario_actualiza`, `estado`) VALUES
(1, 'CMI0001', '$2y$10$315fHvzjZQzvFytO1fAvm./cd593ltBol307SszQOkdCWLTGRucsS', 'esta_cargando_el_motivo.png', 'ESTA CARGANDO EL MOTIVO', NULL, '2025-10-10', NULL, 'Argentina', '32098888888', NULL, NULL, 'operador', NULL, '2026-04-15 18:11:16', 0, 'Activo'),
(2, 'CMI0002', '123', '1776432714_Captura_de_pantalla_2026-04-16_124409.png', 'SAUL FRAGUA NOVA', NULL, '2001-04-10', 4, 'Colombia', '3209839356', NULL, NULL, 'mando', '1988-04-10', '2026-04-19 12:34:00', 0, 'Activo'),
(3, 'CMI0003', '$2y$10$E4c9i2GOkK.lZLmsqqv9rerZkR3r.EpQVhFM3TEsem7fk3aoUPBDa', NULL, 'prueba prueba', NULL, '1988-10-10', NULL, 'Colombia', '3209839356', NULL, NULL, 'operador', NULL, '2026-04-15 18:11:06', 0, 'Activo'),
(4, 'CMI0004', '$2y$10$WeP5VV5WQYfhAr1Bw11pOeRX9yssgzJZb4/7PSfDK5aTDBlGlfZoq', 'ferney_fragua_nova.png', 'FERNEY FRAGUA NOVA', NULL, '1988-04-10', 4, 'Argentina', '32098888888', NULL, NULL, 'operador', '2026-04-10', '2026-04-15 18:11:05', 0, 'Activo'),
(5, 'CMI0005', '$2y$10$LR3TB2d56vQtQN6JfbrgO.xxeVqmKUrihj613xuXUkdN8ywVjCULm', 'pedro_picapiedra.jpeg', 'Pedro Picapiedra', NULL, '1980-10-10', 4, 'Nicaragua', '3209839356', NULL, NULL, 'operador', NULL, '2026-04-15 18:11:04', 0, 'Activo'),
(6, 'CMI0006', '$2y$10$kfqhpWz59y2b0usH97uBju.St/0pZFVApItXV8qRUlXVcxXq/iMr6', 'saul_fragua_nova.png', 'SAUL FRAGUA NOVA', 'Fragua', '1988-04-10', 5, 'Colombia', '3209839356', 'Kratos', 'sfragua', 'operador', '2026-04-20', '2026-04-20 18:46:36', 2, 'Activo');

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
(2, 2, 1),
(3, 6, 1);

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
(15, 2, 3, 0),
(17, 6, 2, 1);

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
(9, 5, 2),
(14, 6, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `iso2` varchar(5) DEFAULT NULL,
  `bandera` varchar(100) DEFAULT NULL,
  `indicativo` varchar(10) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `nombre`, `iso2`, `bandera`, `indicativo`, `estado`) VALUES
(1, 'Alemania', 'DE', 'alemania.png', '+49', 'Activo'),
(2, 'Argentina', 'AR', 'argentina.png', '+54', 'Activo'),
(3, 'Australia', 'AU', 'australia.png', '+61', 'Activo'),
(4, 'Austria', 'AT', 'austria.png', '+43', 'Activo'),
(5, 'Bélgica', 'BE', 'belgica.png', '+32', 'Activo'),
(6, 'Belice', 'BZ', 'belice.png', '+501', 'Activo'),
(7, 'Bolivia', 'BO', 'bolivia.png', '+591', 'Activo'),
(8, 'Brasil', 'BR', 'brasil.png', '+55', 'Activo'),
(9, 'Chile', 'CL', 'chile.png', '+56', 'Activo'),
(10, 'China', 'CN', 'china.png', '+86', 'Activo'),
(11, 'Colombia', 'CO', 'colombia.png', '+57', 'Activo'),
(12, 'Corea del Sur', 'KR', 'corea-sur.png', '+82', 'Activo'),
(13, 'Costa Rica', 'CR', 'costa-rica.png', '+506', 'Activo'),
(14, 'Dinamarca', 'DK', 'dinamarca.png', '+45', 'Activo'),
(15, 'Ecuador', 'EC', 'ecuador.png', '+593', 'Activo'),
(16, 'El Salvador', 'SV', 'elsalvador.png', '+503', 'Activo'),
(17, 'España', 'ES', 'espana.png', '+34', 'Activo'),
(18, 'Estados Unidos', 'US', 'estados-unidos.png', '+1', 'Activo'),
(19, 'Finlandia', 'FI', 'finlandia.png', '+358', 'Activo'),
(20, 'Francia', 'FR', 'francia.png', '+33', 'Activo'),
(21, 'Guatemala', 'GT', 'guatemala.png', '+502', 'Activo'),
(22, 'Honduras', 'HN', 'honduras.png', '+504', 'Activo'),
(23, 'India', 'IN', 'india.png', '+91', 'Activo'),
(24, 'Italia', 'IT', 'italia.png', '+39', 'Activo'),
(25, 'Japón', 'JP', 'japon.png', '+81', 'Activo'),
(26, 'México', 'MX', 'mexico.png', '+52', 'Activo'),
(27, 'Nicaragua', 'NI', 'nicaragua.png', '+505', 'Activo'),
(28, 'Noruega', 'NO', 'noruega.png', '+47', 'Activo'),
(29, 'Nueva Zelanda', 'NZ', 'nueva-zelanda.png', '+64', 'Activo'),
(30, 'Países Bajos', 'NL', 'paises-bajos.png', '+31', 'Activo'),
(31, 'Panamá', 'PA', 'panama.png', '+507', 'Activo'),
(32, 'Paraguay', 'PY', 'paraguay.png', '+595', 'Activo'),
(33, 'Perú', 'PE', 'perú.png', '+51', 'Activo'),
(34, 'Reino Unido', 'GB', 'reino-unido.png', '+44', 'Activo'),
(35, 'Rusia', 'RU', 'rusia.png', '+7', 'Activo'),
(36, 'Suecia', 'SE', 'suecia.png', '+46', 'Activo'),
(37, 'Suiza', 'CH', 'suiza.png', '+41', 'Activo'),
(38, 'Uruguay', 'UY', 'uruguay.png', '+598', 'Activo'),
(39, 'Venezuela', 'VE', 'venezuela.png', '+58', 'Activo');

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
  ADD KEY `estado_id` (`estado_id`),
  ADD KEY `fk_formulario_pais` (`pais_id`);

--
-- Indices de la tabla `novedades`
--
ALTER TABLE `novedades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_operador` (`operador_id`),
  ADD KEY `idx_tipo` (`tipo`),
  ADD KEY `idx_estado` (`estado`);

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
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `actividad_operador_historico`
--
ALTER TABLE `actividad_operador_historico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `novedades`
--
ALTER TABLE `novedades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `operadores`
--
ALTER TABLE `operadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `operador_curso`
--
ALTER TABLE `operador_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `operador_especialidad`
--
ALTER TABLE `operador_especialidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `operador_unidad`
--
ALTER TABLE `operador_unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
  ADD CONSTRAINT `fk_formulario_pais` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`),
  ADD CONSTRAINT `formulario_ibfk_1` FOREIGN KEY (`estado_id`) REFERENCES `estados_formulario` (`id`);

--
-- Filtros para la tabla `novedades`
--
ALTER TABLE `novedades`
  ADD CONSTRAINT `fk_novedad_operador` FOREIGN KEY (`operador_id`) REFERENCES `operadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
