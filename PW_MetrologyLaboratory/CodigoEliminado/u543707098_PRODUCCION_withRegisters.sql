-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 25-06-2024 a las 15:22:46
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
-- Base de datos: `u543707098_PRODUCCION`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`u543707098_MARIELA`@`127.0.0.1` PROCEDURE `altaNuevaSolicitudPrueba` (IN `id_prueba` CHAR(10), IN `fechaSolicitud` DATE, IN `fechaRespuesta` DATE, IN `ubicacionArchivos` VARCHAR(255), IN `especificaciones` VARCHAR(255), IN `normaNombre` VARCHAR(255), IN `normaArchivo` VARCHAR(255), IN `id_estatusPrueba` INT, IN `id_administrador` VARCHAR(10), IN `id_solicitante` VARCHAR(10), IN `id_metrologo` VARCHAR(10), IN `id_tipoPrueba` INT, IN `id_prioridad` INT)   BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        ROLLBACK;
        SELECT 'Error: no se pudo registrar la solicitud.' AS msg, id_prueba;
    END;

    START TRANSACTION;
    INSERT INTO Prueba 
        VALUES (id_prueba, fechaSolicitud, NULL, ubicacionArchivos, especificaciones, normaNombre, normaArchivo, NULL , NULL, NULL, NULL, NULL, NULL);

    IF MYSQL_ERRNO() <> 0 THEN
        ROLLBACK;
        SELECT 'Error: no se pudo registrar la solicitud.' AS msg, id_prueba;
    ELSE
        COMMIT;
        SELECT 'Solicitud registrada correctamente.' AS msg, id_prueba;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Cliente`
--

CREATE TABLE `Cliente` (
  `id_cliente` int(11) NOT NULL,
  `descripcionCliente` varchar(150) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `Cliente`
--

INSERT INTO `Cliente` (`id_cliente`, `descripcionCliente`, `estatus`) VALUES
(1, 'TESLA', 1),
(2, 'BR-166', 1),
(3, 'BR-167', 1),
(4, 'BR-177', 1),
(5, 'P32R Nissan', 1),
(6, 'KL MCA', 1),
(7, 'CHRYSLER', 1),
(8, 'CHRYSLER M1/MP', 1),
(9, 'CHRYSLER KL', 1),
(10, 'DAIMLER BR205', 1),
(11, 'MERCEDES BENZ', 1),
(12, 'FORD', 1),
(13, 'BMW', 1),
(24, 'TestCliente', 0),
(25, 'Cliente 13', 1),
(26, 'TestHolis', 0),
(27, 'Prueba Cliente', 0),
(28, 'TestCliente2', 0),
(29, 'TestCliente3', 0),
(30, 'TestCliente4', 0),
(31, 'TestCliente5', 0),
(32, 'TestCliente6', 0),
(33, 'TestCliente7', 0),
(34, 'TestCliente200', 0),
(35, 'TestCliente100', 0),
(36, 'TestCliente 9', 0),
(37, 'aTestsCliente', 0),
(38, 'atest', 0),
(39, 'Cliente Test', 1),
(40, 'TestCliente7575', 1),
(41, 'Tesla123', 1);

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

--
-- Volcado de datos para la tabla `DescripcionMaterial`
--

INSERT INTO `DescripcionMaterial` (`id_descripcion`, `numeroDeParte`, `descripcionMaterial`, `imgMaterial`, `id_plataforma`, `estatus`) VALUES
(1, '1267754-B', 'SMALL MODULE', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/SMALL%20_MODULE.png', 2, 1),
(2, '1225546-A', 'COMFORT', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/COMFORT.png', 2, 1),
(3, '1212349', ' WD , WK', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/WD_WK.png', 7, 1),
(4, '1339747', 'ARMREST', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/ARMREST.png', 8, 1),
(5, '1271826', 'ARMREST', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/2024-06-13_20-38-01-1271826-ARMREST.png', 9, 1),
(6, '1249956', 'A205 680 0150', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/A205%20680%200150.png', 10, 1),
(7, '1311111', 'ARMREST CD-539', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/ARMREST_CD-539.png', 13, 1),
(8, '1335336', ' HEADREST FR ', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/HEADREST_FR.png', 14, 1),
(9, '1336979', ' ARMREST D544 60/40', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/ARMREST_D544_60_40.png', 14, 1),
(10, '1337098', ' ARMREST D544 40/20/40', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/ARMREST_D544_40_20_40.png', 14, 1),
(11, '1337053', ' MAIN D544 40/20/40', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/MAIN_D544_40_20_40.png', 13, 1),
(12, '1363937', 'HEADREST U554', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/HEADREST_U554.png', 13, 1),
(13, '1342277', ' ARMREST U55X', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/ARMREST_U55X.png', 13, 1),
(16, '1325935-A', 'FOAM PART_OTR', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/FOAM_PART_OTR.png', 17, 1),
(17, '1327969', 'CTR', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/CTR.png', 17, 1),
(19, '1352175', 'IV W', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/IV_W.png', 3, 1),
(20, '1383205', 'IV W COMFORT', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/IV_W_COMFORT.png', 3, 1),
(21, '1358904', 'HANDLE', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/HANDLE.png', 11, 1),
(22, '1367031', 'FOAM PART RH', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/FOAM_PART_LID_RH.png', 11, 1),
(24, '1367030', 'FOAM PART LH', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/FOAM_PART_LH.png', 11, 1),
(25, '1365636', 'COVER UP-LH', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/COVER_UP_LH.png', 11, 1),
(26, '1358002', 'FOAM PART LID  LH', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/FOAM_PART_LID_LH.png', 11, 1),
(27, '1368466', 'LID F. HANDR', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/LID_F_HANDR.png', 11, 1),
(28, '1371008 GD', 'HANDFAUL', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/HANDFAUL.png', 11, 1),
(29, '1395627-28-29-30', 'RH-LH CONSOLE', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/RH_LH_CONSOLE.png', 11, 1),
(30, '1325798 (G01)', 'FRONTAL', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/FRONTAL.png', 17, 1),
(31, '1337822', 'LATERAL', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/LATERAL.png', 18, 1),
(32, '1370789', 'CENTRAL CON TUBO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/CENTRAL_CON_TUBO.png', 19, 1),
(33, '1346858', 'LATERAL', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/LATERAL_G05.png', 19, 1),
(34, '1346851', 'FRONTAL', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/FRONTAL_G05.png', 19, 1),
(35, '1363869', 'CENTRAL G06', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/CENTRAL_G06.png', 20, 1),
(36, '1407016', 'ROW', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/ROW.png', 21, 1),
(37, '1381714', 'CENTRAL', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/CENTRAL_G07.png', 21, 1),
(38, '1354343', 'OTR', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/OTR_G20.png', 22, 1),
(39, '1364478', 'OTR', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/OTR_G06.png', 20, 1),
(40, '1352791', '4W', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/4W.png', 4, 1),
(41, '1345008', 'CABECERA LATERAL', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/CABECERA_LATERAL.png', 8, 1),
(42, '1364078 (1339708)', 'CABECERA CENTRAL', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/CABECERA_CENTRAL.jpg', 8, 1),
(43, '1269733', 'FRONTAL', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/FRONTAL_CHRYSLER_KL.png', 9, 1),
(45, '1339212', 'FR', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/FR.png', 5, 1),
(46, '1338915', 'CTR', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/CTR_P32R_Nissan.png', 5, 1),
(47, '1338921', 'OTR', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/CTR_P32R_Nissan.png', 5, 1),
(48, '1376523', 'CTR MCA', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/CTR_MCA.png', 6, 1),
(49, '1465567', 'CTR', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/CTR_TESLA.png', 1, 1),
(50, '1435876', 'LATERAL HR', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/LATERAL_HR.png', 15, 1),
(127, '555522', 'Material6', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/2024-04-22_19-12-11-555522-Material6', 26, 0),
(128, '12345678', 'Material77', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/2024-04-22_19-22-14-12345678-Material65555', 25, 0),
(129, '555522', 'Material68', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/2024-04-23_14-05-41-555522-Material68', 24, 0),
(130, '12345678', 'Material77', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/2024-04-23_14-09-42-12345678-Material77', 24, 1),
(131, '12345', 'Test93/4', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/2024-05-31_17-42-37-12345-Test93/4', 24, 0),
(132, '123456789', 'Material Test', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/2024-06-13_19-24-46-123456789-Material-Test', 25, 1),
(133, '5149515415', 'amaterial49149494898', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/materials/2024-06-19_15-54-46-5149515415-amaterial', 25, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EstatusMaterial`
--

CREATE TABLE `EstatusMaterial` (
  `id_estatusMaterial` int(11) NOT NULL,
  `descripcionEstatus` varchar(100) NOT NULL,
  `detallesEstatus` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `EstatusMaterial`
--

INSERT INTO `EstatusMaterial` (`id_estatusMaterial`, `descripcionEstatus`, `detallesEstatus`) VALUES
(1, 'Pendiente', 'El solicitante aún no ha entregado el material para las pruebas.'),
(2, 'En inspección', 'Material recibido, en proceso de inspección'),
(3, 'Aprobado', 'El material ha sido aceptado y está listo para las pruebas'),
(4, 'Rechazado', 'El material no cumple con los requisitos y ha sido rechazado'),
(5, 'Por recoger', 'Material disponible para ser recogido por el solicitante.'),
(6, 'Cancelado', 'Pruebas canceladas, material no requerido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EstatusPrueba`
--

CREATE TABLE `EstatusPrueba` (
  `id_estatusPrueba` int(11) NOT NULL,
  `descripcionEstatus` varchar(100) NOT NULL,
  `detallesEstatus` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `EstatusPrueba`
--

INSERT INTO `EstatusPrueba` (`id_estatusPrueba`, `descripcionEstatus`, `detallesEstatus`) VALUES
(1, 'Pendiente de aprobación', 'La prueba está en espera aprobación.'),
(2, 'Aprobado - En fila', 'La prueba ha sido aprobada.'),
(3, 'En proceso', 'La prueba está en curso.'),
(4, 'Completado', 'La prueba ha sido completada exitosamente.'),
(5, 'Rechazado', 'La prueba ha sido rechazada.'),
(6, 'Cancelado', 'La prueba ha sido cancelada.');

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

--
-- Volcado de datos para la tabla `Material`
--

INSERT INTO `Material` (`id_material`, `id_prueba`, `cantidad`, `id_descripcion`, `id_estatusMaterial`) VALUES
(90, '2023-0857', 9, 46, 1),
(91, '2024-0002', 6, 17, 1),
(92, '2024-0002', 6, 31, 1),
(93, '2024-0003', 9, 49, 1),
(94, '2024-0004', 6, 2, 1),
(95, '2024-0004', 9, 19, 1),
(96, '2024-0004', 9, 40, 1),
(97, '2024-0004', 6, 50, 1),
(98, '2024-0005', 9, 46, 1),
(99, '2024-0006', 9, 45, 1),
(100, '2024-0007', 9, 38, 1),
(101, '2024-0008', 9, 49, 1),
(102, '2024-0009', 9, 45, 1),
(103, '2024-0010', 9, 29, 1),
(104, '2024-0011', 9, 46, 1),
(105, '2024-0012', 9, 49, 1),
(106, '2024-0013', 9, 45, 1),
(107, '2024-0014', 9, 49, 1),
(108, '2024-0015', 8, 3, 1),
(109, '2023-0016', 7, 49, 1),
(110, '2024-0017', 8, 49, 1),
(111, '2024-0018', 3, 46, 1),
(112, '2024-0019', 7, 49, 1),
(113, '2024-0020', 7, 49, 1),
(114, '2024-0021', 9, 36, 1),
(115, '2023-0054', 3, 46, 1),
(116, '2023-0054', 5, 2, 1),
(117, '2024-0023', 6, 49, 1),
(118, '2024-0024', 5, 45, 1),
(119, '2024-0025', 6, 49, 1),
(120, '2024-0026', 6, 49, 1),
(121, '2024-0027', 9, 24, 1),
(122, '2024-0028', 6, 45, 1),
(123, '2024-0029', 1, 17, 1),
(124, '2023-0030', 7, 46, 1),
(125, '2024-0031', 7, 46, 1),
(126, '2024-0032', 7, 26, 1),
(127, '2024-0033', 3, 49, 1),
(128, '2024-0034', 9, 49, 1),
(129, '2024-0035', 9, 49, 1),
(130, '2024-0036', 6, 45, 1),
(131, '2024-0037', 6, 26, 1),
(132, '2024-0038', 9, 45, 1),
(133, '2024-0039', 9, 19, 1),
(134, '2024-0040', 7, 17, 1),
(135, '2023-0041', 7, 2, 1),
(136, '2024-0042', 6, 46, 1),
(137, '2023-0043', 6, 46, 1),
(138, '2024-0044', 8, 17, 1),
(139, '2024-0045', 9, 25, 1),
(140, '2024-0045', 9, 26, 1),
(141, '2024-0046', 6, 29, 1),
(142, '2024-0047', 6, 2, 1),
(143, '2024-0048', 9, 28, 1),
(144, '2024-0049', 6, 50, 1),
(145, '2024-0050', 9, 49, 1),
(146, '2024-0051', 9, 9, 1),
(147, '2024-0052', 8, 2, 1),
(148, '2024-0053', 9, 24, 1),
(149, '2024-0054', 7, 46, 1),
(150, '2024-0054', 9, 29, 1),
(151, '2024-0054', 9, 46, 1),
(152, '2024-0055', 6, 2, 1),
(153, '2024-0056', 6, 2, 1),
(154, '2024-0057', 9, 2, 1),
(159, '2024-0058', 6, 45, 1),
(160, '2023-0059', 8, 24, 1),
(161, '2024-0060', 6, 49, 1),
(162, '2024-0061', 8, 22, 1),
(163, '2024-0062', 9, 26, 1),
(164, '2024-0062', 9, 40, 1),
(165, '2024-0063', 8, 24, 1),
(166, '2024-0063', 8, 50, 1),
(167, '2024-0064', 9, 43, 1),
(168, '2024-0064', 9, 7, 1),
(169, '2024-0064', 9, 3, 1),
(170, '2024-0064', 9, 45, 1),
(171, '2024-0064', 9, 21, 1),
(172, '2024-0064', 3, 9, 1),
(173, '2024-0064', 3, 8, 1),
(174, '2023-0065', 9, 43, 1),
(175, '2023-0065', 9, 7, 1),
(176, '2023-0065', 9, 3, 1),
(177, '2023-0065', 9, 45, 1),
(178, '2023-0065', 9, 21, 1),
(179, '2023-0065', 3, 9, 1),
(180, '2023-0065', 3, 8, 1),
(181, '2023-0066', 3, 2, 1),
(182, '2023-0066', 3, 19, 1),
(183, '2023-0066', 3, 40, 1),
(184, '2023-0066', 4, 6, 1),
(185, '2023-0066', 5, 5, 1),
(186, '2024-0067', 3, 49, 1),
(187, '2024-0067', 5, 47, 1),
(188, '2024-0067', 6, 50, 1),
(189, '2024-0067', 7, 42, 1),
(190, '2024-0068', 6, 45, 1),
(191, '2024-0069', 3, 49, 1),
(192, '2024-0069', 3, 20, 1),
(193, '2024-0069', 5, 40, 1),
(194, '2024-0069', 7, 48, 1),
(195, '2024-0069', 6, 43, 1),
(196, '2024-0070', 6, 45, 1),
(197, '2024-0071', 3, 49, 1),
(198, '2024-0071', 3, 26, 1),
(199, '2024-0072', 2, 26, 1),
(201, '2024-0073', 6, 4, 1),
(202, '2024-0074', 3, 48, 1),
(203, '2024-0075', 3, 42, 1),
(204, '2024-0076', 6, 5, 1),
(205, '2024-0077', 9, 6, 1),
(206, '2024-0078', 6, 45, 1),
(208, '2024-0079', 3, 42, 1),
(209, '2024-0080', 3, 42, 1),
(210, '2024-0081', 3, 46, 1),
(211, '2024-0082', 6, 45, 1),
(212, '2024-0083', 6, 4, 1),
(213, '2024-0084', 4, 42, 1),
(214, '2024-0085', 5, 3, 1),
(215, '2024-0086', 5, 3, 1),
(216, '2024-0087', 5, 42, 1),
(217, '2024-0088', 4, 42, 1),
(218, '2024-0089', 6, 42, 1),
(219, '2024-0090', 5, 42, 1),
(220, '2024-0091', 5, 50, 1),
(222, '2024-0093', 6, 45, 1),
(223, '2024-0094', 4, 48, 1),
(225, '2024-0095', 5, 49, 1),
(226, '2024-0095', 3, 10, 1),
(227, '2024-0096', 5, 45, 1),
(228, '2024-0097', 3, 48, 1),
(229, '2024-0097', 3, 50, 1),
(231, '2024-0098', 3, 24, 1),
(232, '2024-0095', 6, 2, 1),
(233, '2024-0094', 3, 46, 1),
(234, '2024-0099', 5, 42, 1),
(235, '2024-0100', 5, 24, 1),
(236, '2024-0101', 5, 5, 1),
(237, '2024-0102', 3, 48, 1),
(238, '2024-0103', 3, 24, 1),
(239, '2024-0103', 3, 42, 1),
(240, '2024-0103', 3, 49, 1),
(241, '2024-0104', 3, 50, 1),
(242, '2024-0104', 3, 40, 1),
(243, '2024-0104', 3, 45, 1),
(244, '2024-0105', 5, 48, 1),
(245, '2024-0106', 3, 50, 1),
(246, '2024-0106', 3, 8, 1),
(247, '2024-0106', 3, 5, 1),
(248, '2024-0107', 3, 2, 1),
(249, '2024-0107', 3, 40, 1),
(250, '2024-0107', 3, 48, 1),
(251, '2024-0108', 3, 19, 1),
(252, '2024-0108', 3, 1, 1),
(253, '2024-0108', 3, 6, 1),
(254, '2024-0109', 3, 40, 1),
(255, '2024-0098', 12, 20, 1),
(257, '2024-0110', 6, 45, 1),
(258, '2024-0111', 3, 48, 1),
(259, '2024-0112', 3, 50, 1),
(260, '2024-0113', 5, 6, 1),
(261, '2024-0114', 5, 45, 1),
(262, '2024-0115', 5, 45, 1);

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

--
-- Volcado de datos para la tabla `MaterialTest`
--

INSERT INTO `MaterialTest` (`id_material`, `id_prueba`, `cantidad`, `id_descripcion`) VALUES
(1, 'test', 55, 5),
(3, '2024-0050', 0, 45),
(4, '2024-0050', 5, 19),
(5, '2024-0050', 5, 46),
(6, '2024-0050', 5, 45),
(20, '2024-0050', 1, 6),
(21, '2024-0050', 1, 41),
(22, '2024-0050', 111, 31),
(23, '2024-0050', 222, 4),
(24, '2024-0050', 111, 1),
(25, '2024-0050', 222, 50),
(26, '2024-0050', 333, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Plataforma`
--

CREATE TABLE `Plataforma` (
  `id_plataforma` int(11) NOT NULL,
  `descripcionPlataforma` varchar(150) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `Plataforma`
--

INSERT INTO `Plataforma` (`id_plataforma`, `descripcionPlataforma`, `id_cliente`, `estatus`) VALUES
(1, 'TESLA', 1, 1),
(2, 'BR-166', 2, 1),
(3, 'BR-167', 3, 1),
(4, 'BR-177', 4, 1),
(5, 'P32R Nissan', 5, 1),
(6, 'KL MCA', 6, 1),
(7, 'AHR', 7, 1),
(8, 'CHRYSLER M1/MP', 8, 1),
(9, 'CHRYSLER KL', 9, 1),
(10, 'DAIMLER BR205', 10, 1),
(11, 'BR167', 11, 1),
(12, 'MFA II', 11, 1),
(13, 'FORD', 12, 1),
(14, 'D544', 12, 1),
(15, 'CX727', 12, 1),
(16, 'CX430', 12, 1),
(17, 'G01', 4, 1),
(18, 'G02', 13, 1),
(19, 'G05', 13, 1),
(20, 'G06', 13, 1),
(21, 'G07', 13, 1),
(22, 'G20', 13, 1),
(24, 'Test Plataforma 9 3/4', 25, 0),
(25, 'Plataforma 13', 25, 1),
(26, 'TestPlataforma1', 25, 0),
(27, 'Material3', 33, 0),
(28, 'PlataformaPruebas', 34, 0),
(29, 'PlataformaNueva', 35, 0),
(30, 'Plataformas', 35, 0),
(31, 'PlataformaNueva', 35, 0),
(32, 'PlataformaNueva', 35, 0),
(34, 'Plataforma99', 35, 0),
(35, 'Plataforma 9', 35, 0),
(37, 'aTestPlataforma', 25, 0),
(38, 'Plataforma Test', 25, 1),
(39, 'TestPlataforma4', 40, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Prioridad`
--

CREATE TABLE `Prioridad` (
  `id_prioridad` int(11) NOT NULL,
  `descripcionPrioridad` varchar(100) NOT NULL,
  `detallesEstatus` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `Prioridad`
--

INSERT INTO `Prioridad` (`id_prioridad`, `descripcionPrioridad`, `detallesEstatus`) VALUES
(1, 'Baja', 'La prueba tiene baja prioridad y puede ser postergada.'),
(2, 'Normal', 'La prueba tiene una prioridad moderada.'),
(3, 'Alta', 'La prueba tiene alta prioridad y debe realizarse pronto.'),
(4, 'Urgente', 'La prueba es de máxima importancia y debe realizarse de inmediato.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Prueba`
--

CREATE TABLE `Prueba` (
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

--
-- Volcado de datos para la tabla `Prueba`
--

INSERT INTO `Prueba` (`id_prueba`, `fechaSolicitud`, `fechaActualizacion`, `fechaCompromiso`, `fechaRespuesta`, `especificaciones`, `especificacionesLab`, `normaNombre`, `normaArchivo`, `id_estatusPrueba`, `id_administrador`, `id_solicitante`, `id_metrologo`, `id_tipoPrueba`, `id_pruebaEspecial`, `otroTipoEspecial`, `id_prioridad`, `rutaResultados`) VALUES
('2023-0016', '2023-07-11', '2024-06-20', '0000-00-00', '2024-06-20', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 2, 5, 'No aplica', 2, 'resultadosGuardados'),
('2023-0030', '2023-04-13', '2023-04-27', '0000-00-00', '2023-04-27', 'hghgmnyujjjjjjjjjjjjk', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_068.pdf'),
('2023-0041', '2023-08-11', '2023-08-24', '0000-00-00', '2023-08-24', 'bgearberabhaetb', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0041-Metrologia_proyecto.pdf', 4, '00030298', '00030293', '00030313', 3, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_076.pdf'),
('2023-0043', '2023-05-13', '2023-06-24', '0000-00-00', '2023-06-24', 'dasvs<dvsb sdgvdsabv sdvbs<dv', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0043-NQA-ISO-9001-Guia-de-implantacion.pdf', 4, '00030298', '00030293', '00030315', 4, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_077.pdf'),
('2023-0054', '2023-03-15', '2023-03-20', '0000-00-00', '2023-03-20', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_066.pdf'),
('2023-0059', '2023-12-15', '2023-12-24', '0000-00-00', '2024-01-02', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, ''),
('2023-0065', '2023-05-17', '2023-05-19', '0000-00-00', '2023-05-19', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/newRequest/newRequestIndex.php', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 2, 5, 'No aplica', 2, ''),
('2023-0066', '2023-09-17', '2024-06-21', '0000-00-00', '2024-06-19', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, donec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0066-LM-Prueba_2024-0054.pdf', 4, '00030298', '00030293', '00030313', 4, 5, 'No aplica', 2, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/files/results/2023-0066-Presentacion-sesión-3-2018.pdf'),
('2023-0857', '2023-10-31', '2024-06-20', '0000-00-00', '2024-06-20', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, donec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. Bibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030315', '00030313', 5, 4, 'Industrial', 2, 'Ruta: M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_059.pdf'),
('2024-0002', '2024-01-02', '2024-04-24', '0000-00-00', '2024-01-05', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, donec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. Bibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO-9001', '../archivos/2024-0002-NQA-ISO-9001-Guia-de-implantacion.pdf', 4, '00030298', '00030315', '00030315', 3, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_021.pdf'),
('2024-0003', '2024-03-01', '2024-04-24', '0000-00-00', '2024-03-05', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, donec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. Bibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030299', '00030315', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_046.pdf'),
('2024-0004', '2024-01-05', '2024-04-24', '0000-00-00', '2024-01-08', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, donec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. Bibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO-9001', '../archivos/2024-0004-Metrologia_proyecto.pdf', 4, '00030298', '00030299', '00030312', 4, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_011.pdf'),
('2024-0005', '2024-04-03', '2024-04-24', '0000-00-00', '2024-04-07', 'Ninguna', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030299', '00030315', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_060.pdf'),
('2024-0006', '2024-03-03', '2024-05-28', '0000-00-00', '2024-05-28', 'Nadita', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_047.pdf'),
('2024-0007', '2024-03-05', '2024-04-24', '0000-00-00', '2024-03-09', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, donec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. Bibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_048.pdf'),
('2024-0008', '2024-01-15', '2024-04-24', '0000-00-00', '2024-01-18', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, donec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_001.pdf'),
('2024-0009', '2024-04-05', '2024-04-24', '0000-00-00', '2024-04-09', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_061.pdf'),
('2024-0010', '2024-01-06', '2024-04-24', '0000-00-00', '2024-01-10', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_022.pdf'),
('2024-0011', '2024-04-07', '2024-04-24', '0000-00-00', '2024-04-11', 'Ninguna', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_062.pdf'),
('2024-0012', '2024-02-12', '2024-04-24', '0000-00-00', '2024-02-15', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_012.pdf'),
('2024-0013', '2024-03-07', '2024-04-24', '0000-00-00', '2024-03-11', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_049.pdf'),
('2024-0014', '2024-04-09', '2024-04-24', '0000-00-00', '2024-04-13', 'Ninguna', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_063.pdf'),
('2024-0015', '2024-03-09', '2024-04-24', '0000-00-00', '2024-03-13', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_050.pdf'),
('2024-0017', '2024-02-10', '2024-04-24', '0000-00-00', '2024-02-15', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_002.pdf'),
('2024-0018', '2023-01-11', '2023-01-21', '0000-00-00', '2023-01-21', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_065.pdf'),
('2024-0019', '2024-03-11', '2024-04-24', '0000-00-00', '2024-03-15', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_051.pdf'),
('2024-0020', '2024-01-11', '2024-04-24', '0000-00-00', '2024-01-15', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_023.pdf'),
('2024-0021', '2024-03-13', '2024-04-24', '0000-00-00', '2024-03-17', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO-9001', '../archivos/2024-0021-Metrologia_proyecto.pdf', 4, '00030298', '00030293', '00030315', 3, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_052.pdf'),
('2024-0023', '2024-03-05', '2024-04-24', '0000-00-00', '2024-03-10', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_003.pdf'),
('2024-0024', '2024-03-15', '2024-04-24', '0000-00-00', '2024-03-19', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_053.pdf'),
('2024-0025', '2024-04-17', '2024-04-24', '0000-00-00', '2024-04-21', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 1, 5, 'No aplica', 3, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_067.pdf'),
('2024-0026', '2024-05-01', '2024-04-24', '0000-00-00', '2024-05-05', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_054.pdf'),
('2024-0027', '2024-05-03', '2024-04-24', '0000-00-00', '2024-05-07', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_055.pdf'),
('2024-0028', '2024-03-08', '2024-04-24', '0000-00-00', '2024-03-11', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_013.pdf'),
('2024-0029', '2024-01-16', '2024-04-24', '0000-00-00', '2024-01-20', 'asdaasdasd', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_024.pdf'),
('2024-0031', '2024-05-05', '2024-04-24', '0000-00-00', '2024-05-09', 'djmnnryymtymtdmhmthmtmmym', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_056.pdf'),
('2024-0032', '2024-04-21', '2024-04-24', '0000-00-00', '2024-04-25', 'bnfgxngnsfngnfh', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_069.pdf'),
('2024-0033', '2024-05-07', '2024-04-24', '0000-00-00', '2024-05-11', 'aefvbebsvwrverbv', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_057.pdf'),
('2024-0034', '2024-04-23', '2024-04-24', '0000-00-00', '2024-04-27', 'srynhrthtrhthsrth', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_070.pdf'),
('2024-0035', '2024-05-09', '2024-04-24', '0000-00-00', '2024-05-13', 'gxnsgbse gfbsaeb baebreb etbaerb ebaerb etbaeberb', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_058.pdf'),
('2024-0036', '2024-04-01', '2024-04-24', '0000-00-00', '2024-04-05', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_071.pdf'),
('2024-0037', '2024-04-03', '2024-04-24', '0000-00-00', '2024-04-07', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_072.pdf'),
('2024-0038', '2024-04-05', '2024-04-24', '0000-00-00', '2024-04-09', 'Ninguna', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0038-Metrologia_proyecto.pdf', 4, '00030298', '00030293', '00030315', 4, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_073.pdf'),
('2024-0039', '2024-04-07', '2024-04-24', '0000-00-00', '2024-04-11', 'ndhmnthntymndghj mth', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0039-Metrologia_proyecto.pdf', 4, '00030298', '00030293', '00030313', 4, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_074.pdf'),
('2024-0040', '2024-04-09', '2024-04-24', '0000-00-00', '2024-04-13', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0040-Metrologia_proyecto.pdf', 4, '00030298', '00030293', '00030315', 3, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_075.pdf'),
('2024-0042', '2024-01-03', '2024-04-24', '0000-00-00', '2024-01-07', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0042-Metrologia_proyecto.pdf', 4, '00030298', '00030293', '00030313', 4, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_026.pdf'),
('2024-0044', '2024-04-12', '2024-04-24', '0000-00-00', '2024-04-12', 'fvs<dvsvb dfg<srbrb dfbfb<dfb dfbfdb dfbfdbdf fbfdbdfbf', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO-9001', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0044-Metodologias_Agiles_de_Desarrollo_de_Software.pdf', 4, '00030298', '00030293', '00030312', 4, 5, 'No aplica', 2, ''),
('2024-0045', '2024-05-02', '2024-04-24', '0000-00-00', '2024-05-05', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_005.pdf'),
('2024-0046', '2024-04-12', '2024-04-24', '0000-00-00', '2024-04-12', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0046-ISO-9001.pdf', 4, '00030298', '00030293', '00030312', 3, 5, 'No aplica', 2, ''),
('2024-0047', '2024-04-12', '2024-04-24', '0000-00-00', '2024-04-12', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0047-Metodologias_Agiles_de_Desarrollo_de_Software.pdf', 4, '00030298', '00030293', '00030312', 3, 5, 'No aplica', 2, ''),
('2024-0048', '2024-02-21', '2024-04-24', '0000-00-00', '2024-02-25', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_044.pdf'),
('2024-0049', '2024-05-04', '2024-04-24', '0000-00-00', '2024-05-07', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_015.pdf'),
('2024-0050', '2024-04-12', '2024-04-24', '0000-00-00', '2024-04-12', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, ''),
('2024-0051', '2024-01-22', '2024-04-24', '0000-00-00', '2024-01-28', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_006.pdf'),
('2024-0052', '2024-04-12', '2024-04-24', '0000-00-00', '2024-04-12', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, ''),
('2024-0053', '2024-01-24', '2024-04-24', '0000-00-00', '2024-01-27', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_016.pdf'),
('2024-0054', '2024-01-08', '2024-04-24', '0000-00-00', '2024-01-12', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_027.pdf'),
('2024-0055', '2024-02-08', '2024-04-24', '0000-00-00', '2024-02-12', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0055-Metrologia_proyecto.pdf', 4, '00030298', '00030293', '00030313', 3, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_036.pdf'),
('2024-0056', '2024-04-12', '2024-04-24', '0000-00-00', '2024-04-12', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0056-Presentacion-sesión-3-2018.pdf', 4, '00030298', '00030293', '00030312', 3, 5, 'No aplica', 2, ''),
('2024-0057', '2024-04-12', '2024-04-24', '0000-00-00', '2024-04-12', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, ''),
('2024-0058', '2024-04-15', '2024-05-17', '0000-00-00', '2024-05-17', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory'),
('2024-0060', '2024-04-15', '2024-04-24', '0000-00-00', '2024-04-15', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, ''),
('2024-0061', '2024-02-09', '2024-04-24', '0000-00-00', '2024-02-13', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_037.pdf'),
('2024-0062', '2024-02-23', '2024-04-24', '0000-00-00', '2024-02-27', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_045.pdf'),
('2024-0063', '2024-01-13', '2024-04-24', '0000-00-00', '2024-01-17', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_028.pdf'),
('2024-0064', '2024-04-17', '2024-05-20', '0000-00-00', '2024-05-20', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/modules/newRequest/newRequestIndex.php', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory'),
('2024-0067', '2024-02-14', '2024-04-24', '0000-00-00', '2024-02-20', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, donec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0067-LM-Prueba_2024-0054.pdf', 4, '00030298', '00030293', '00030312', 3, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_007.pdf'),
('2024-0068', '2024-04-17', '2024-04-24', '0000-00-00', '2024-04-17', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, donec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, ''),
('2024-0069', '2024-02-16', '2024-04-24', '0000-00-00', '2024-02-19', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, donec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_017.pdf'),
('2024-0070', '2024-02-11', '2024-04-24', '0000-00-00', '2024-02-15', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas \"Letraset\", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas \"Letraset\", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030312', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_038.pdf'),
('2024-0071', '2024-04-24', '2024-06-24', '0000-00-00', '0000-00-00', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0071-NQA-ISO-9001-Guia-de-implantacion.pdf', 2, '00030298', '00030293', '00030312', 4, 5, 'No aplica', 2, ''),
('2024-0072', '2024-01-18', '2024-05-06', '0000-00-00', '2024-01-22', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent.', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_029.pdf'),
('2024-0073', '2024-05-01', '2024-06-24', '0000-00-00', '2024-05-03', 'Lorem ipsum dolor sit amet consectetur.', 'Bibendum venenatis metus dictum dapibus id.', 'No aplica', 'No aplica', 2, '00030298', '00030313', '00030312', 1, 5, 'No aplica xd', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados.pdf'),
('2024-0074', '2024-03-18', '2024-05-17', '0000-00-00', '2024-03-23', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent,', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt.', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0074-NQA-ISO-9001-Guia-de-implantacion.pdf', 4, '00030298', '00030293', '00030312', 4, 5, 'No aplica xd', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_008.pdf'),
('2024-0075', '2024-05-02', '2024-05-02', '0000-00-00', '0000-00-00', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent,', '', 'No aplica', 'No aplica', 1, '00030293', '00030350', '00000000', 2, 5, 'No aplica xd', 2, ''),
('2024-0076', '2024-03-21', '2024-05-17', '0000-00-00', '2024-03-24', 'Lorem ipsum dolor sit amet consectetur.', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 2, 5, 'No aplica xd', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_018.pdf'),
('2024-0077', '2024-05-02', '2024-05-02', '0000-00-00', '0000-00-00', 'Lorem ipsum dolor sit amet consectetur.', '', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0077-Presentacion-sesión-3-2018.pdf', 1, '00030293', '00030293', '00000000', 5, 2, 'No aplica xd', 2, ''),
('2024-0078', '2024-05-02', '2024-05-02', '0000-00-00', '0000-00-00', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', '', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0078-Presentacion-sesión-3-2018.pdf', 1, '00030293', '00030293', '00000000', 5, 4, 'otro tipo', 2, ''),
('2024-0079', '2024-05-06', '2024-05-06', '0000-00-00', '0000-00-00', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', '', 'No aplica', 'No aplica', 1, '00030293', '00030293', '00000000', 1, 5, 'No aplica xd', 2, ''),
('2024-0080', '2024-05-06', '2024-05-07', '0000-00-00', '2024-05-07', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00000000', 1, 5, 'No aplica xd', 2, 'M:\\MetrologyLaboratory');
INSERT INTO `Prueba` (`id_prueba`, `fechaSolicitud`, `fechaActualizacion`, `fechaCompromiso`, `fechaRespuesta`, `especificaciones`, `especificacionesLab`, `normaNombre`, `normaArchivo`, `id_estatusPrueba`, `id_administrador`, `id_solicitante`, `id_metrologo`, `id_tipoPrueba`, `id_pruebaEspecial`, `otroTipoEspecial`, `id_prioridad`, `rutaResultados`) VALUES
('2024-0081', '2024-02-13', '2024-05-06', '0000-00-00', '2024-02-17', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', '', 'No aplica', 'No aplica', 4, '00030293', '00030293', '00030313', 2, 5, 'No aplica xd', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_039.pdf'),
('2024-0082', '2024-04-10', '2024-05-06', '0000-00-00', '2024-04-15', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', '', 'No aplica', 'No aplica', 4, '00030293', '00030293', '00000000', 2, 5, 'No aplica xd', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_009.pdf'),
('2024-0083', '2024-05-06', '2024-05-06', '0000-00-00', '2024-05-16', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt', 'No aplica', 'No aplica', 4, '00030293', '00030293', '00000000', 1, 5, 'No aplica xd', 2, 'M:\\MetrologyLaboratory'),
('2024-0084', '2024-05-06', '2024-05-17', '0000-00-00', '2024-05-17', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt', 'iso', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0084-NQA-ISO-9001-Guia-de-implantacion.pdf', 4, '00030298', '00030293', '00030313', 4, 5, 'No aplica xd', 2, 'M:\\MetrologyLaboratory'),
('2024-0085', '2024-04-12', '2024-05-06', '0000-00-00', '2024-04-15', 'error', '', 'No aplica', 'No aplica', 4, '00030293', '00030293', '00000000', 1, 5, 'No aplica xd', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_019.pdf'),
('2024-0086', '2024-05-06', '2024-05-28', '0000-00-00', '2024-05-28', 'error', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat .', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030315', 1, 5, 'No aplica xd', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultadosSolicitud 2024-0086.pdf'),
('2024-0087', '2024-05-06', '2024-05-06', '0000-00-00', '0000-00-00', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', '', 'No aplica', 'No aplica', 1, '00030293', '00030293', '00000000', 1, 5, 'No aplica', 2, ''),
('2024-0088', '2024-05-06', '2024-05-07', '0000-00-00', '2024-05-07', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit.', 'No aplica', 'No aplica', 3, '00030298', '00030293', '00030315', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory'),
('2024-0089', '2024-01-23', '2024-05-06', '0000-00-00', '2024-01-27', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', '', 'No aplica', 'No aplica', 4, '00030293', '00030293', '00030315', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_030.pdf'),
('2024-0090', '2024-05-06', '2024-05-06', '0000-00-00', '0000-00-00', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', '', 'No aplica', 'No aplica', 1, '00030293', '00030293', '00000000', 1, 5, 'No aplica', 2, ''),
('2024-0091', '2024-02-14', '2024-05-06', '0000-00-00', '2024-02-18', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', '', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0091-NQA-ISO-9001-Guia-de-implantacion.pdf', 4, '00030293', '00030293', '00030315', 5, 2, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_040.pdf'),
('2024-0093', '2024-05-06', '2024-05-28', '0000-00-00', '2024-05-28', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit.', 'ISO', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0093-NQA-ISO-9001-Guia-de-implantacion.pdf', 4, '00030298', '00030293', '00030315', 5, 4, 'Industrial', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados.pdf'),
('2024-0094', '2024-05-27', '2024-05-24', '0000-00-00', '0000-00-00', 'xscscsc', '', 'No aplica', 'No aplica', 1, '00030293', '00030293', '00000000', 2, 5, 'No aplica', 2, ''),
('2024-0095', '2024-05-11', '2024-05-24', '0000-00-00', '2024-05-16', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi.', '', 'No aplica', 'No aplica', 4, '00030293', '00030293', '00000000', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_010.pdf'),
('2024-0096', '2024-05-24', '2024-05-24', '0000-00-00', '0000-00-00', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi.', '', 'No aplica', 'No aplica', 1, '00030293', '00030293', '00000000', 1, 5, 'No aplica', 2, ''),
('2024-0097', '2024-05-14', '2024-05-27', '0000-00-00', '2024-05-17', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi.', '', '9001', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0097-', 4, '00030298', '00030293', '00030315', 5, 4, 'otro', 2, 'M:\\MetrologyLaboratory\\PW_MetrologyLaboratory\\resultados_2024_020.pdf'),
('2024-0098', '2024-06-19', '2024-05-27', '0000-00-00', '0000-00-00', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim .', '', '9001njinj', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0098-Presentacion-sesión-3-2018.pdf', 5, '00030298', '00030293', '00000000', 5, 3, 'No aplica', 2, ''),
('2024-0099', '2024-05-30', '2024-06-12', '0000-00-00', '2024-06-12', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'No aplica', 'No aplica', 3, '00030298', '00030298', '00030313', 1, 5, 'No aplica', 2, ''),
('2024-0100', '2024-05-30', '2024-05-30', '0000-00-00', '0000-00-00', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', '', 'No aplica', 'No aplica', 1, '00030293', '00030298', '00000000', 1, 5, 'No aplica', 2, ''),
('2024-0101', '2024-05-30', '2024-05-30', '0000-00-00', '0000-00-00', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', '', '9001', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0101-NQA-ISO-9001-Guia-de-implantacion.pdf', 1, '00030293', '00030298', '00000000', 5, 4, 'Otro tipo', 2, ''),
('2024-0102', '2024-06-12', '2024-06-12', '0000-00-00', '2024-06-12', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'No aplica', 'No aplica', 3, '00030298', '00025455', '00030313', 2, 5, 'No aplica', 2, ''),
('2024-0103', '2024-06-12', '2024-06-12', '0000-00-00', '2024-06-12', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'iso', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0103-Presentacion-sesión-3-2018.pdf', 4, '00030298', '00025455', '00030313', 4, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\Documentacion'),
('2024-0104', '2024-06-12', '2024-06-24', '2024-06-28', '0000-00-00', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', '', 'iso', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0104-Presentacion-sesión-3-2018.pdf', 2, '00030298', '00025455', '00030313', 5, 2, 'No aplica', 2, ''),
('2024-0105', '2024-06-12', '2024-06-14', '0000-00-00', '2024-06-14', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'iso', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0105-Presentacion-sesión-3-2018.pdf', 3, '00030298', '00012345', '00030313', 4, 5, 'No aplica', 2, ''),
('2024-0106', '2024-06-12', '2024-06-12', '0000-00-00', '2024-06-12', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'No aplica', 'No aplica', 4, '00030298', '00012345', '00030315', 2, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory\\Documentacion'),
('2024-0107', '2024-06-12', '2024-06-21', '0000-00-00', '2024-06-12', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'No aplica', 'No aplica', 4, '00030298', '00012345', '00030315', 2, 5, 'No aplica', 3, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/files/results/2024-0107-Presentacion-sesión-3-2018.pdf'),
('2024-0108', '2024-06-12', '2024-06-12', '0000-00-00', '2024-06-12', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel. Torquent fusce erat sociosqu tempus mi curae tempor sollicitudin bibendum dapibus vehicula, \r\ndonec cubilia cursus viverra dignissim morbi justo facilisis diam volutpat litora tincidunt, dictumst magnis primis faucibus est pharetra ante per neque suscipit. \r\nBibendum venenatis metus dictum dapibus id, ac et eros purus aptent, arcu erat senectus nam.', 'iso', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0108-Presentacion-sesión-3-2018.pdf', 2, '00030298', '00012345', '00030313', 5, 4, 'otro', 2, ''),
('2024-0109', '2024-06-12', '2024-06-12', '0000-00-00', '2024-06-12', 'dvzdzczc', 'cvszcxxczcxz', 'No aplica', 'No aplica', 2, '00030298', '00001703', '00030313', 1, 5, 'No aplica', 1, ''),
('2024-0110', '2024-06-19', '2024-06-19', '0000-00-00', '2024-06-21', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', '', '123456', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/archivos/2024-0110-Presentacion-sesión-3-2018.pdf', 4, '00030293', '00030293', '00000000', 4, 5, 'No aplica', 2, 'https://www.gob.mx/cms/uploads/attachment/file/105139/Normas_Oficiales_Mexicanas.pdf'),
('2024-0111', '2024-06-19', '2024-06-19', '0000-00-00', '2024-06-21', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', '', '9001', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/files/norms/2024-0111-Presentacion-sesión-3-2018.pdf', 4, '00030293', '00030293', '00000000', 4, 5, 'No aplica', 2, 'https://www.gob.mx/cms/uploads/attachment/file/105139/Normas_Oficiales_Mexicanas.pdf'),
('2024-0112', '2024-06-19', '2024-06-20', '0000-00-00', '2024-06-20', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'Se adjuntan resultados en pdf', '9001', 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/files/norms/2024-0112-Presentacion-sesión-3-2018.pdf', 4, '00030298', '00030293', '00000000', 4, 5, 'No aplica', 2, 'https://www.gob.mx/cms/uploads/attachment/file/105139/Normas_Oficiales_Mexicanas.pdf'),
('2024-0113', '2024-06-21', '2024-06-24', '0000-00-00', '2024-06-24', 'dfSrgwR', 'Lorem ipsum dolor sit amet consectetur, adipiscing elit mauris vel.', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 1, 5, 'No aplica', 2, 'M:\\MetrologyLaboratory'),
('2024-0114', '2024-06-21', '2024-06-24', '0000-00-00', '0000-00-00', 'fgsedv', '', 'No aplica', 'No aplica', 2, '00030298', '00030293', '00000000', 1, 5, 'No aplica', 2, ''),
('2024-0115', '2024-06-21', '2024-06-24', '0000-00-00', '0000-00-00', 'fgsedv', 'thhdhddfhdzfhreherhthhdhddfhdzfhreherhthhdhddfhdzfhreherhthhdhddfhdzfhreherhthhdhddfhdzfhreherhthhdhddfhdzfhreherhthhdhddfhdzfhreherhthhdhddfhdzfhreherhthhdhddfhdzfhreherhthhdhddfhdzfhreherhthhdhddfhdzfhreherhthhdhddfhdzfhreherhthhdhddfhdzfhreherhthhdhddfhdzfhreherh', 'No aplica', 'No aplica', 4, '00030298', '00030293', '00030313', 1, 5, 'No aplica', 2, 'thhdhddfhdzfhreherh');

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

--
-- Volcado de datos para la tabla `restablecer_password`
--

INSERT INTO `restablecer_password` (`id`, `id_usuario`, `token`, `expira`, `tokenValido`) VALUES
(2, '00030293', 'dwsbaerbeberhbaeth', '2024-06-06 00:00:00', 0),
(3, '00030293', '4b16665ee3651e4698104001c1a808f9', '2024-06-05 18:13:00', 0),
(4, '00030293', 'ddefab85de663cbbf75cb68fcfdd0080', '2024-06-05 18:13:15', 0),
(5, '00030293', '9a6bd083265cbabcd03e55c360832d75', '2024-06-05 18:29:01', 0),
(6, '00030293', 'a2c2c95c87b52ce863a4f7a0bcf201b0', '2024-06-05 18:29:16', 0),
(7, '00030293', '9030b88b68a9fb27719c8badc7f8c063', '2024-06-05 18:35:16', 0),
(8, '00030293', '90a06628fef10419beddee1d29ef9a15', '2024-06-05 18:37:33', 0),
(9, '00030293', '12836c55cddddf95eb7d4c98d93bfdac', '2024-06-05 20:03:03', 0),
(10, '00030293', '2e64a4e5c498e4a5ccc46d1eebdd0173', '2024-06-05 20:03:08', 0),
(11, '00030293', '2f8182e17a5ea680df729b4f59fb13ca', '2024-06-06 18:02:31', 0),
(12, '00030293', 'a907ddf79bbe9fe7c438ccb7418791a0', '2024-06-06 18:04:52', 0),
(13, '00030293', '0a9bcbe45d48a1a23d8068da5e19c08e', '2024-06-06 18:07:04', 0),
(14, '00030293', 'a7d9459dd6b02a6d05cf07e203d7ea1b', '2024-06-06 18:24:12', 0),
(15, '00030293', 'e000eef510fb6bfeefca037e80d9f432', '2024-06-06 18:25:21', 0),
(16, '00030293', 'b324d15eb7eaec83e3eaade7d0ad4951', '2024-06-06 18:27:39', 0),
(17, '00030293', '30c5f662e18577eb056420871e46b749', '2024-06-19 16:20:28', 0),
(18, '00030293', '2c44e81a1f0ed61b7bdc755362afcb1a', '2024-06-19 16:34:03', 0),
(19, '00030293', '495c79e3a7bd265d619e90697c0b6ec3', '2024-06-21 17:40:45', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoEvaluacion`
--

CREATE TABLE `TipoEvaluacion` (
  `id_tipoEvaluacion` int(11) NOT NULL,
  `descripcionEvaluacion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `TipoEvaluacion`
--

INSERT INTO `TipoEvaluacion` (`id_tipoEvaluacion`, `descripcionEvaluacion`) VALUES
(1, 'Evaluación con máquina universal'),
(5, 'TestEvaluacion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoPrueba`
--

CREATE TABLE `TipoPrueba` (
  `id_tipoPrueba` int(11) NOT NULL,
  `descripcionPrueba` varchar(200) NOT NULL,
  `id_tipoEvaluacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `TipoPrueba`
--

INSERT INTO `TipoPrueba` (`id_tipoPrueba`, `descripcionPrueba`, `id_tipoEvaluacion`) VALUES
(1, 'Pruebas-Extracción', 1),
(2, 'Pruebas-Compresión', 1),
(3, 'Pruebas de dureza INSITU', 1),
(4, 'Pruebas de dureza FOAM', 1),
(5, 'Pruebas especiales/otra', 1),
(6, 'testPrueba', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoPruebaEspecial`
--

CREATE TABLE `TipoPruebaEspecial` (
  `id_pruebaEspecial` int(11) NOT NULL,
  `descripcionEspecial` varchar(150) NOT NULL,
  `id_tipoPrueba` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `TipoPruebaEspecial`
--

INSERT INTO `TipoPruebaEspecial` (`id_pruebaEspecial`, `descripcionEspecial`, `id_tipoPrueba`) VALUES
(1, 'Extracción', 5),
(2, 'Compresión', 5),
(3, 'Desprendimiento', 5),
(4, 'Otro', 5),
(5, 'No aplica', 5),
(8, 'testEspecial', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `TipoUsuario`
--

CREATE TABLE `TipoUsuario` (
  `id_tipoUsuario` int(11) NOT NULL,
  `descripcionTipo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `TipoUsuario`
--

INSERT INTO `TipoUsuario` (`id_tipoUsuario`, `descripcionTipo`) VALUES
(1, 'Administrador'),
(2, 'Metrólogo'),
(3, 'Solicitante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario`
--

CREATE TABLE `Usuario` (
  `id_usuario` varchar(20) NOT NULL,
  `nombreUsuario` varchar(150) NOT NULL,
  `correoElectronico` varchar(150) NOT NULL,
  `passwordHash` varchar(150) NOT NULL,
  `id_tipoUsuario` int(11) NOT NULL DEFAULT 3,
  `foto` varchar(150) NOT NULL DEFAULT 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/fotoPerfilDefault.png',
  `estatus` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `Usuario`
--

INSERT INTO `Usuario` (`id_usuario`, `nombreUsuario`, `correoElectronico`, `passwordHash`, `id_tipoUsuario`, `foto`, `estatus`) VALUES
('00000000', 'Sin Asignar', '', '', 2, '', 0),
('00001703', 'Jesiel Ramirez', 'neftali.ramirez@grammer.com', '77537289bef135fcbdad0d5e47255cbce916f92a', 1, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/fotoPerfilDefault.png', 1),
('00001704', 'Jesiel Ramirez Juarez', 'neftali.ramirez@grammer.com', '6a3236f5f213960de5c415fd15c6d1cb5a46d04e', 3, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/fotoPerfilDefault.png', 1),
('00012345', 'Margarita Rueda', 'margarita.r@grammer.com', '8cb2237d0679ca88db6464eac60da96345513964', 3, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/fotoPerfilDefault.png', 0),
('00023653', 'Raul Madero', 'raul.m@grammer.com', '8cb2237d0679ca88db6464eac60da96345513964', 3, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/fotoPerfilDefault.png', 1),
('00025455', 'Lia Grajales', 'lia.g@grammer.com', '8cb2237d0679ca88db6464eac60da96345513964', 1, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/fotoPerfilDefault.png', 1),
('00030293', 'Mariela Reyes', 'extern.mariela.reyes@grammer.com', '8cb2237d0679ca88db6464eac60da96345513964', 3, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/mariela_reyes.jpg', 1),
('00030298', 'Santiago Gómez', 'santiago.g@grammer.com', '8cb2237d0679ca88db6464eac60da96345513964', 1, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/santiago_gomez.jpg', 1),
('00030299', 'Victoria Jimenez', 'victoria.j@grammer.com', '8cb2237d0679ca88db6464eac60da96345513964', 3, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/victoria_jimenez.jpg', 1),
('00030312', 'Elena Mendoza', 'elena.m@grammer.com', '8cb2237d0679ca88db6464eac60da96345513964', 2, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/elena_mendoza.jpg', 1),
('00030313', 'Reyna Lara', 'reyna.l@grammer.com', '8cb2237d0679ca88db6464eac60da96345513964', 2, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/reyna_lara.jpg', 1),
('00030315', 'Kevin Gonzalez', 'kevin.g@grammer.com', '8cb2237d0679ca88db6464eac60da96345513964', 2, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/kevin_gonzalez.jpg', 0),
('00030350', 'Paola Padilla', 'paola.p@grammer.com', '8cb2237d0679ca88db6464eac60da96345513964', 3, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/paola_padilla.jpg', 0),
('00302977', 'Victor Gonzalez', 'victor.g@grammer.com', '8cb2237d0679ca88db6464eac60da96345513964', 3, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/fotoPerfilDefault.png', 1),
('00562456', 'Sergio Lopez', 'sergio.l@grammer.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 3, 'https://arketipo.mx/Produccion/ML/PW_MetrologyLaboratory/imgs/usuarios/fotoPerfilDefault.png', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Cliente`
--
ALTER TABLE `Cliente`
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
-- Indices de la tabla `Plataforma`
--
ALTER TABLE `Plataforma`
  ADD PRIMARY KEY (`id_plataforma`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `Prioridad`
--
ALTER TABLE `Prioridad`
  ADD PRIMARY KEY (`id_prioridad`);

--
-- Indices de la tabla `Prueba`
--
ALTER TABLE `Prueba`
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
-- Indices de la tabla `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_tipoUsuario` (`id_tipoUsuario`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Cliente`
--
ALTER TABLE `Cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `DescripcionMaterial`
--
ALTER TABLE `DescripcionMaterial`
  MODIFY `id_descripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT de la tabla `EstatusMaterial`
--
ALTER TABLE `EstatusMaterial`
  MODIFY `id_estatusMaterial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `EstatusPrueba`
--
ALTER TABLE `EstatusPrueba`
  MODIFY `id_estatusPrueba` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `Material`
--
ALTER TABLE `Material`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;

--
-- AUTO_INCREMENT de la tabla `MaterialTest`
--
ALTER TABLE `MaterialTest`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `Plataforma`
--
ALTER TABLE `Plataforma`
  MODIFY `id_plataforma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `Prioridad`
--
ALTER TABLE `Prioridad`
  MODIFY `id_prioridad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `restablecer_password`
--
ALTER TABLE `restablecer_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `TipoEvaluacion`
--
ALTER TABLE `TipoEvaluacion`
  MODIFY `id_tipoEvaluacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `TipoPrueba`
--
ALTER TABLE `TipoPrueba`
  MODIFY `id_tipoPrueba` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `TipoPruebaEspecial`
--
ALTER TABLE `TipoPruebaEspecial`
  MODIFY `id_pruebaEspecial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `TipoUsuario`
--
ALTER TABLE `TipoUsuario`
  MODIFY `id_tipoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `DescripcionMaterial`
--
ALTER TABLE `DescripcionMaterial`
  ADD CONSTRAINT `DescripcionMaterial_ibfk_1` FOREIGN KEY (`id_plataforma`) REFERENCES `Plataforma` (`id_plataforma`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `Material`
--
ALTER TABLE `Material`
  ADD CONSTRAINT `Material_ibfk_1` FOREIGN KEY (`id_descripcion`) REFERENCES `DescripcionMaterial` (`id_descripcion`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Material_ibfk_2` FOREIGN KEY (`id_prueba`) REFERENCES `Prueba` (`id_prueba`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Material_ibfk_3` FOREIGN KEY (`id_estatusMaterial`) REFERENCES `EstatusMaterial` (`id_estatusMaterial`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Plataforma`
--
ALTER TABLE `Plataforma`
  ADD CONSTRAINT `Plataforma_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `Cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `Prueba`
--
ALTER TABLE `Prueba`
  ADD CONSTRAINT `Prueba_ibfk_1` FOREIGN KEY (`id_estatusPrueba`) REFERENCES `EstatusPrueba` (`id_estatusPrueba`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Prueba_ibfk_2` FOREIGN KEY (`id_prioridad`) REFERENCES `Prioridad` (`id_prioridad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Prueba_ibfk_4` FOREIGN KEY (`id_tipoPrueba`) REFERENCES `TipoPrueba` (`id_tipoPrueba`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Prueba_ibfk_5` FOREIGN KEY (`id_administrador`) REFERENCES `Usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Prueba_ibfk_6` FOREIGN KEY (`id_solicitante`) REFERENCES `Usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Prueba_ibfk_7` FOREIGN KEY (`id_metrologo`) REFERENCES `Usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Prueba_ibfk_8` FOREIGN KEY (`id_pruebaEspecial`) REFERENCES `TipoPruebaEspecial` (`id_pruebaEspecial`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `restablecer_password`
--
ALTER TABLE `restablecer_password`
  ADD CONSTRAINT `restablecer_password_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `Usuario` (`id_usuario`) ON DELETE CASCADE;

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
-- Filtros para la tabla `Usuario`
--
ALTER TABLE `Usuario`
  ADD CONSTRAINT `Usuario_ibfk_1` FOREIGN KEY (`id_tipoUsuario`) REFERENCES `TipoUsuario` (`id_tipoUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
