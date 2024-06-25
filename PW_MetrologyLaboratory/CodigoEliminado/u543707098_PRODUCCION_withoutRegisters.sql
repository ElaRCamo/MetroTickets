-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 25-06-2024 a las 15:26:35
-- Versión del servidor: 10.11.7-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `PruebasLabMetrologia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Clientes`
--

CREATE TABLE `Clientes` (
  `id_cliente` int(11) NOT NULL,
  `descripcionCliente` varchar(150) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DescripcionMaterial`
--

CREATE TABLE `DescripcionMaterial` (
  `id_descripcion` int(11) NOT NULL,
  `numeroDeParte` varchar(50) NOT NULL,
  `descripcionMaterial` varchar(150) NOT NULL,
  `imgMaterial` varchar(150) NOT NULL,
  `id_plataforma` int(11) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EstatusMaterial`
--

CREATE TABLE `EstatusMaterial` (
  `id_estatusMaterial` int(11) NOT NULL,
  `descripcionEstatus` varchar(100) NOT NULL,
  `detallesEstatus` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EstatusPrueba`
--

CREATE TABLE `EstatusPrueba` (
  `id_estatusPrueba` int(11) NOT NULL,
  `descripcionEstatus` varchar(100) NOT NULL,
  `detallesEstatus` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Material`
--

CREATE TABLE `Material` (
  `id_material` int(11) NOT NULL,
  `id_prueba` char(10) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_descripcion` int(11) NOT NULL,
  `id_estatusMaterial` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `MaterialTest`
--

CREATE TABLE `MaterialTest` (
  `id_material` int(11) NOT NULL,
  `id_prueba` varchar(150) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_descripcion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Plataformas`
--

CREATE TABLE `Plataformas` (
  `id_plataforma` int(11) NOT NULL,
  `descripcionPlataforma` varchar(150) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Prioridad`
--

CREATE TABLE `Prioridad` (
  `id_prioridad` int(11) NOT NULL,
  `descripcionPrioridad` varchar(100) NOT NULL,
  `detallesEstatus` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Pruebas`
--

CREATE TABLE `Pruebas` (
  `id_prueba` char(10) NOT NULL,
  `fechaSolicitud` date NOT NULL,
  `fechaActualizacion` date NOT NULL DEFAULT current_timestamp(),
  `fechaCompromiso` date NOT NULL,
  `fechaRespuesta` date NOT NULL DEFAULT '0000-00-00',
  `especificaciones` varchar(1000) NOT NULL DEFAULT 'Sin observaciones',
  `especificacionesLab` varchar(1000) NOT NULL,
  `normaNombre` varchar(250) NOT NULL,
  `normaArchivo` varchar(250) NOT NULL,
  `id_estatusPrueba` int(11) NOT NULL DEFAULT 5,
  `id_administrador` varchar(20) NOT NULL DEFAULT '00030293',
  `id_solicitante` varchar(20) NOT NULL,
  `id_metrologo` varchar(20) NOT NULL DEFAULT '00000000',
  `id_tipoPrueba` int(11) NOT NULL,
  `id_pruebaEspecial` int(11) NOT NULL DEFAULT 5,
  `otroTipoEspecial` varchar(150) NOT NULL DEFAULT 'No aplica',
  `id_prioridad` int(11) NOT NULL DEFAULT 2,
  `rutaResultados` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restablecer_password`
--

CREATE TABLE `restablecer_password` (
  `id` int(11) NOT NULL,
  `id_usuario` varchar(20) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expira` datetime NOT NULL,
  `tokenValido` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoEvaluacion`
--

CREATE TABLE `TipoEvaluacion` (
  `id_tipoEvaluacion` int(11) NOT NULL,
  `descripcionEvaluacion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoPrueba`
--

CREATE TABLE `TipoPrueba` (
  `id_tipoPrueba` int(11) NOT NULL,
  `descripcionPrueba` varchar(200) NOT NULL,
  `id_tipoEvaluacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoPruebaEspecial`
--

CREATE TABLE `TipoPruebaEspecial` (
  `id_pruebaEspecial` int(11) NOT NULL,
  `descripcionEspecial` varchar(150) NOT NULL,
  `id_tipoPrueba` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoUsuario`
--

CREATE TABLE `TipoUsuario` (
  `id_tipoUsuario` int(11) NOT NULL,
  `descripcionTipo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `id_usuario` varchar(20) NOT NULL,
  `nombreUsuario` varchar(150) NOT NULL,
  `correoElectronico` varchar(150) NOT NULL,
  `passwordHash` varchar(150) NOT NULL,
  `id_tipoUsuario` int(11) NOT NULL DEFAULT 3,
  `foto` varchar(150) NOT NULL DEFAULT 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/fotoPerfilDefault.png',
  `estatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Clientes`
--
ALTER TABLE `Clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `DescripcionMaterial`
--
ALTER TABLE `DescripcionMaterial`
  ADD PRIMARY KEY (`id_descripcion`),
  ADD KEY `id_plataforma` (`id_plataforma`);

--
-- Indices de la tabla `EstatusMaterial`
--
ALTER TABLE `EstatusMaterial`
  ADD PRIMARY KEY (`id_estatusMaterial`);

--
-- Indices de la tabla `EstatusPrueba`
--
ALTER TABLE `EstatusPrueba`
  ADD PRIMARY KEY (`id_estatusPrueba`);

--
-- Indices de la tabla `Material`
--
ALTER TABLE `Material`
  ADD PRIMARY KEY (`id_material`),
  ADD KEY `id_descripcion` (`id_descripcion`),
  ADD KEY `id_prueba` (`id_prueba`),
  ADD KEY `id_estatusMaterial` (`id_estatusMaterial`);

--
-- Indices de la tabla `MaterialTest`
--
ALTER TABLE `MaterialTest`
  ADD PRIMARY KEY (`id_material`);

--
-- Indices de la tabla `Plataformas`
--
ALTER TABLE `Plataformas`
  ADD PRIMARY KEY (`id_plataforma`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `Prioridad`
--
ALTER TABLE `Prioridad`
  ADD PRIMARY KEY (`id_prioridad`);

--
-- Indices de la tabla `Pruebas`
--
ALTER TABLE `Pruebas`
  ADD PRIMARY KEY (`id_prueba`),
  ADD KEY `id_estatusPrueba` (`id_estatusPrueba`),
  ADD KEY `id_administrador` (`id_administrador`),
  ADD KEY `id_solicitante` (`id_solicitante`),
  ADD KEY `id_tipoPrueba` (`id_tipoPrueba`),
  ADD KEY `id_prioridad` (`id_prioridad`),
  ADD KEY `id_metrologo` (`id_metrologo`),
  ADD KEY `id_pruebaEspecial` (`id_pruebaEspecial`);

--
-- Indices de la tabla `restablecer_password`
--
ALTER TABLE `restablecer_password`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `TipoEvaluacion`
--
ALTER TABLE `TipoEvaluacion`
  ADD PRIMARY KEY (`id_tipoEvaluacion`);

--
-- Indices de la tabla `TipoPrueba`
--
ALTER TABLE `TipoPrueba`
  ADD PRIMARY KEY (`id_tipoPrueba`),
  ADD KEY `id_tipoEvaluacion` (`id_tipoEvaluacion`);

--
-- Indices de la tabla `TipoPruebaEspecial`
--
ALTER TABLE `TipoPruebaEspecial`
  ADD PRIMARY KEY (`id_pruebaEspecial`),
  ADD KEY `id_tipoPrueba` (`id_tipoPrueba`);

--
-- Indices de la tabla `TipoUsuario`
--
ALTER TABLE `TipoUsuario`
  ADD PRIMARY KEY (`id_tipoUsuario`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_tipoUsuario` (`id_tipoUsuario`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Clientes`
--
ALTER TABLE `Clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `DescripcionMaterial`
--
ALTER TABLE `DescripcionMaterial`
  MODIFY `id_descripcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `EstatusMaterial`
--
ALTER TABLE `EstatusMaterial`
  MODIFY `id_estatusMaterial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `EstatusPrueba`
--
ALTER TABLE `EstatusPrueba`
  MODIFY `id_estatusPrueba` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Material`
--
ALTER TABLE `Material`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `MaterialTest`
--
ALTER TABLE `MaterialTest`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Plataformas`
--
ALTER TABLE `Plataformas`
  MODIFY `id_plataforma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Prioridad`
--
ALTER TABLE `Prioridad`
  MODIFY `id_prioridad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `restablecer_password`
--
ALTER TABLE `restablecer_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `TipoEvaluacion`
--
ALTER TABLE `TipoEvaluacion`
  MODIFY `id_tipoEvaluacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `TipoPrueba`
--
ALTER TABLE `TipoPrueba`
  MODIFY `id_tipoPrueba` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `TipoPruebaEspecial`
--
ALTER TABLE `TipoPruebaEspecial`
  MODIFY `id_pruebaEspecial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `TipoUsuario`
--
ALTER TABLE `TipoUsuario`
  MODIFY `id_tipoUsuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `DescripcionMaterial`
--
ALTER TABLE `DescripcionMaterial`
  ADD CONSTRAINT `DescripcionMaterial_ibfk_1` FOREIGN KEY (`id_plataforma`) REFERENCES `Plataformas` (`id_plataforma`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `Material`
--
ALTER TABLE `Material`
  ADD CONSTRAINT `Material_ibfk_1` FOREIGN KEY (`id_descripcion`) REFERENCES `DescripcionMaterial` (`id_descripcion`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Material_ibfk_2` FOREIGN KEY (`id_prueba`) REFERENCES `Pruebas` (`id_prueba`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Material_ibfk_3` FOREIGN KEY (`id_estatusMaterial`) REFERENCES `EstatusMaterial` (`id_estatusMaterial`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Plataformas`
--
ALTER TABLE `Plataformas`
  ADD CONSTRAINT `Plataforma_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `Clientes` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Pruebas`
--
ALTER TABLE `Pruebas`
  ADD CONSTRAINT `Prueba_ibfk_1` FOREIGN KEY (`id_estatusPrueba`) REFERENCES `EstatusPrueba` (`id_estatusPrueba`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Prueba_ibfk_2` FOREIGN KEY (`id_prioridad`) REFERENCES `Prioridad` (`id_prioridad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Prueba_ibfk_4` FOREIGN KEY (`id_tipoPrueba`) REFERENCES `TipoPrueba` (`id_tipoPrueba`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Prueba_ibfk_5` FOREIGN KEY (`id_administrador`) REFERENCES `Usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Prueba_ibfk_6` FOREIGN KEY (`id_solicitante`) REFERENCES `Usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Prueba_ibfk_7` FOREIGN KEY (`id_metrologo`) REFERENCES `Usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Prueba_ibfk_8` FOREIGN KEY (`id_pruebaEspecial`) REFERENCES `TipoPruebaEspecial` (`id_pruebaEspecial`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `restablecer_password`
--
ALTER TABLE `restablecer_password`
  ADD CONSTRAINT `restablecer_password_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `TipoPrueba`
--
ALTER TABLE `TipoPrueba`
  ADD CONSTRAINT `TipoPrueba_ibfk_1` FOREIGN KEY (`id_tipoEvaluacion`) REFERENCES `TipoEvaluacion` (`id_tipoEvaluacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `TipoPruebaEspecial`
--
ALTER TABLE `TipoPruebaEspecial`
  ADD CONSTRAINT `TipoPruebaEspecial_ibfk_1` FOREIGN KEY (`id_tipoPrueba`) REFERENCES `TipoPrueba` (`id_tipoPrueba`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD CONSTRAINT `Usuario_ibfk_1` FOREIGN KEY (`id_tipoUsuario`) REFERENCES `TipoUsuario` (`id_tipoUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
