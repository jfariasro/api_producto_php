-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 23-08-2024 a las 22:14:16
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba_api`
--
CREATE DATABASE IF NOT EXISTS `prueba_api` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `prueba_api`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `descripcion`) VALUES
(1, 'Refrigeración', 'Electrodomésticos para mantener alimentos y bebidas frías.'),
(2, 'Lavado', 'Electrodomésticos para lavar ropa y textiles.'),
(3, 'Cocción', 'Electrodomésticos para cocinar alimentos.'),
(4, 'Aspiración', 'Electrodomésticos para limpiar y aspirar el polvo.'),
(5, 'Climatización', 'Electrodomésticos para controlar la temperatura del ambiente.'),
(6, 'Pequeños electrodomésticos', 'Electrodomésticos de tamaño reducido para uso doméstico.'),
(7, 'Hogar Inteligente', 'Electrodomésticos conectados y automatizados para el hogar.'),
(8, 'Electrodomésticos de cocina', 'Electrodomésticos específicos para preparar alimentos.'),
(9, 'Electrodomésticos de cuidado personal', 'Electrodomésticos para el cuidado personal y bienestar.'),
(10, 'Entretenimiento', 'Electrodomésticos relacionados con el entretenimiento en el hogar.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `razonsocial` varchar(100) NOT NULL,
  `fechanacimiento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edad` int NOT NULL,
  `idtipocliente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `cedula`, `razonsocial`, `fechanacimiento`, `edad`, `idtipocliente`) VALUES
(1, '0958986804', 'Jose Farias Romero', '1997-04-24 22:03:26', 27, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `idmarca` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`idmarca`, `nombre`, `descripcion`) VALUES
(1, 'Samsung', 'Marca conocida por su innovación en tecnología y electrodomésticos.'),
(2, 'LG', 'Fabricante global de electrodomésticos y electrónica de consumo.'),
(3, 'Whirlpool', 'Empresa líder en electrodomésticos de cocina y lavandería.'),
(4, 'Bosch', 'Reconocida por su calidad y tecnología avanzada en electrodomésticos.'),
(5, 'Philips', 'Marca internacional que ofrece una amplia gama de electrodomésticos.'),
(6, 'Electrolux', 'Proveedor de soluciones innovadoras para el hogar.'),
(7, 'Panasonic', 'Conocida por sus electrodomésticos duraderos y tecnológicos.'),
(8, 'Siemens', 'Marca alemana con productos de alta gama para el hogar.'),
(9, 'Miele', 'Fabricante de electrodomésticos de lujo con alta durabilidad.'),
(10, 'Sony', 'Aunque conocida por electrónica de consumo, también ofrece algunos electrodomésticos.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int NOT NULL,
  `idcategoria` int NOT NULL,
  `idmarca` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cantidad` int NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `idcategoria`, `idmarca`, `nombre`, `cantidad`, `precio`) VALUES
(1, 1, 1, 'Refrigerador Samsung 500L', 20, 799.99),
(2, 1, 2, 'Refrigerador LG 450L', 15, 749.99),
(3, 2, 3, 'Lavadora Whirlpool 8kg', 25, 549.99),
(4, 2, 4, 'Lavadora Bosch 7kg', 10, 599.99),
(5, 3, 5, 'Horno Philips 60L', 18, 399.99),
(6, 3, 6, 'Cocina Electrolux 4 Hornillas', 22, 299.99),
(7, 4, 7, 'Aspiradora Panasonic 1800W', 30, 129.99),
(8, 4, 8, 'Aspiradora Siemens 2000W', 12, 149.99),
(9, 5, 9, 'Aire Acondicionado Miele 1.5 Ton', 10, 599.99),
(10, 5, 10, 'Calefactor Sony 1500W', 20, 89.99),
(11, 6, 1, 'Tostadora Samsung 2 Rebanadas', 40, 49.99),
(12, 6, 2, 'Batidora LG 600W', 35, 69.99),
(13, 7, 3, 'Termostato Inteligente Whirlpool', 15, 199.99),
(14, 7, 4, 'Cámara de Seguridad Bosch', 25, 229.99),
(15, 8, 5, 'Procesador de Alimentos Philips', 20, 89.99),
(16, 8, 6, 'Cafetera Electrolux 12 Tazas', 30, 99.99),
(17, 9, 7, 'Secador de Pelo Panasonic', 45, 59.99),
(18, 9, 8, 'Plancha de Ropa Siemens', 25, 39.99),
(19, 10, 9, 'Televisor Miele 55\"', 12, 799.99),
(20, 10, 10, 'Sistema de Audio Sony', 15, 299.99),
(21, 1, 1, 'Raaaaa', 20, 799.99),
(22, 6, 5, 'Paaaaa', 10, 2000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocliente`
--

CREATE TABLE `tipocliente` (
  `idtipocliente` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tipocliente`
--

INSERT INTO `tipocliente` (`idtipocliente`, `nombre`, `descripcion`) VALUES
(1, 'Mayorista', 'Cliente Especial, Mayor numero de descuento');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`idmarca`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `idcategoria` (`idcategoria`),
  ADD KEY `idmarca` (`idmarca`);

--
-- Indices de la tabla `tipocliente`
--
ALTER TABLE `tipocliente`
  ADD PRIMARY KEY (`idtipocliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `idmarca` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `tipocliente`
--
ALTER TABLE `tipocliente`
  MODIFY `idtipocliente` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
