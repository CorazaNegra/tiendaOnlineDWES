-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-02-2024 a las 13:16:00
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
-- Base de datos: `vidaparacasa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `codigo` varchar(8) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `categoria` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`codigo`, `nombre`, `descripcion`, `categoria`, `precio`, `imagen`, `activo`) VALUES
('AAA00001', 'hierbaLuisa', 'La parte de la Hierba luisa que se utiliza son las hojas, que desprenden un agradable aroma a limón.\r\n\r\nSe utiliza comúnmente en infusiones, y además de estar deliciosa, ayuda a promover la relajación y aliviar el estrés.\r\n\r\nA la Hierba luisa le gusta estar al sol.\r\n\r\nRegar de forma abundante para hidratar bien toda la tierra pero nunca dejar agua estancada.\r\n\r\nDejar secar la tierra entre riegos.\r\n\r\nEs una planta muy leñosa y de hoja caduca, aunque, en zonas más cálidas se puede considerar de hoja semi-caduca.\r\n\r\nTiene multitud de propiedades medicinales.\r\n\r\nNombre botánico: Aloysia thriphylla', 8, 20.00, '', 1),
('AAA00002', 'equisetumJaponicum', 'Planta acuática muy atractiva. Hoja perenne. Crece formando grupos. Apariencia muy similar al bambú. Después de unos años es recomendable quitar la planta y dividirla en varias plantas para evitar que invada la zona. \r\n\r\nFloración: de Junio a Agosto\r\nAltura: 60-100cm \r\nZonas de plantación: 1 - 2 y 3  Sol - Semi sol', 6, 17.00, '', 1),
('AAA00003', 'aglaonemaRedJoy', 'La Aglaonema Red Joy prefiere lugares iluminados, evita la luz solar directa, esto puede dañar sus hojas. \r\n\r\nDeja secar la capa superior del substrato entre riegos. El exceso de riego puede matar a tu Aglaonema.\r\n\r\nNo utilices substratos apelmazantes, la Aglaonema prefiere macetas con agujeros para permitir un buen drenaje. \r\n\r\nEvita exponer a tu Aglaonema Red Joy a corrientes de aire frío o a cambios bruscos de temperatura. ', 10, 25.00, '', 1),
('AAA00004', 'MacetaHavanaWaves20cm', 'La Maceta Havana Waves, lleva un tapón en la parte inferior para poder usar como maceta de plantación o como cubremacetas.\r\n\r\n* Acabado mate\r\n\r\n* Calidad extra\r\n\r\n* Material muy ligero', 16, 30.00, '', 1),
('AAA00005', 'SubstratoUniversal20lt.', 'Es una mezcla de primera calidad para todas las plantas de interior,de balcón y de terraza,excluidas orquídeas y acidófilas.\r\n\r\nEstá enriquecida con las sustancias nutritivas principales y micronutrientes necesarios para las primeras semanas de cultivo.\r\n\r\nMinerales arcillosos incluidos consiguen una buena capacidad porosa y una emisión regular de sales nutritivas.', 17, 14.00, '', 1),
('AAA00006', 'Higuera8anyos', 'CONSEJOS PARA BONSAI HIGUERA:\r\n\r\nSituación: Exterior, pleno sol.\r\n\r\nRiego: Abundante, no dejar secar demasiado entre riegos.\r\n\r\nTrasplante: Principio primavera, con el inicio de la nueva brotación o en junio tras un defoliado completo.\r\n\r\nInformación más detallada en la ficha que se adjunta con el bonsai.\r\n\r\nNombre botánico: Ficus carica', 5, 55.00, '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `codCategoriaPadre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`codigo`, `nombre`, `activo`, `codCategoriaPadre`) VALUES
(1, 'plantasExterior', 1, NULL),
(2, 'plantasInterior', 1, NULL),
(3, 'macetas', 1, NULL),
(4, 'accesoriosJardin', 1, NULL),
(5, 'otros', 1, NULL),
(6, 'acuaticas', 1, 1),
(7, 'arbustos', 1, 1),
(8, 'aromaticas', 1, 1),
(9, 'bulbos', 1, 1),
(10, 'aglaonemas', 1, 2),
(11, 'alocasias', 1, 2),
(12, 'calatheas', 1, 2),
(13, 'colgantes', 1, 2),
(14, 'macetaBarro', 1, 3),
(15, 'macetaEcofriendly', 1, 3),
(16, 'macetaPlastico', 1, 3),
(17, 'abono', 1, 4),
(18, 'accesorioRiego', 1, 4),
(19, 'herramientas', 1, 4),
(20, 'insecticidas', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineaspedido`
--

CREATE TABLE `lineaspedido` (
  `numPedido` int(11) NOT NULL,
  `numLinea` int(11) NOT NULL,
  `codArticulo` varchar(8) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `total` float NOT NULL,
  `estado` smallint(6) NOT NULL,
  `codUsuario` varchar(9) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `codigoArticulo` varchar(8) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `localidad` varchar(30) NOT NULL,
  `provincia` varchar(30) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `email` varchar(30) NOT NULL,
  `rol` varchar(20) NOT NULL,
  `clave_usuario` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `categoria` (`categoria`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codCategoriaPadre` (`codCategoriaPadre`);

--
-- Indices de la tabla `lineaspedido`
--
ALTER TABLE `lineaspedido`
  ADD PRIMARY KEY (`numPedido`,`numLinea`),
  ADD KEY `codArticulo` (`codArticulo`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `codUsuario` (`codUsuario`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`codigoArticulo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`dni`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`codigo`);

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`codCategoriaPadre`) REFERENCES `categorias` (`codigo`);

--
-- Filtros para la tabla `lineaspedido`
--
ALTER TABLE `lineaspedido`
  ADD CONSTRAINT `lineaspedido_ibfk_1` FOREIGN KEY (`numPedido`) REFERENCES `pedidos` (`idPedido`),
  ADD CONSTRAINT `lineaspedido_ibfk_2` FOREIGN KEY (`codArticulo`) REFERENCES `articulos` (`codigo`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`codUsuario`) REFERENCES `usuarios` (`dni`);

--
-- Filtros para la tabla `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`codigoArticulo`) REFERENCES `articulos` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
