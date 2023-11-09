-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2023 a las 18:38:55
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cajas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `idCaja` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idCajero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`idCaja`, `fecha`, `idCajero`) VALUES
(1, '2022-06-28', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `idCotizacion` int(11) NOT NULL,
  `idMoneda` int(11) NOT NULL,
  `compra` float NOT NULL,
  `venta` float NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`idCotizacion`, `idMoneda`, `compra`, `venta`, `fecha`, `hora`, `estado`, `idUsuario`) VALUES
(1, 2, 550, 560, '2023-08-02', '20:14:15', 1, 1),
(2, 3, 600, 610, '2023-08-03', '14:59:25', 1, 1),
(3, 2, 560, 570, '2023-08-07', '12:27:00', 1, 1),
(4, 3, 600, 611, '2023-08-07', '12:29:58', 1, 1),
(5, 2, 561, 570, '2023-08-11', '12:59:29', 1, 1),
(6, 2, 561, 575, '2023-08-11', '13:00:26', 1, 1),
(7, 3, 600, 611, '2023-08-11', '16:18:23', 1, 1),
(8, 2, 700, 710, '2023-09-09', '11:43:05', 1, 1),
(9, 2, 705, 710, '2023-09-09', '11:43:25', 1, 1),
(10, 2, 690, 715, '2023-09-09', '11:45:56', 1, 1),
(11, 2, 691, 715, '2023-10-06', '01:17:49', 1, 1),
(12, 2, 840, 890, '2023-10-06', '01:18:03', 1, 1),
(13, 3, 900, 1000, '2023-10-06', '01:18:16', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles`
--

CREATE TABLE `detalles` (
  `idDetalle` int(11) NOT NULL,
  `idOperacion` int(11) NOT NULL,
  `detalle` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `detalles`
--

INSERT INTO `detalles` (`idDetalle`, `idOperacion`, `detalle`) VALUES
(1, 6, 'ARBA IMPUESTOS'),
(2, 22702, 'SALDO INICAL'),
(3, 22703, 'SALDO INICAL'),
(4, 22704, 'SALDO INICAL'),
(5, 1, '1'),
(6, 1, '1'),
(7, 1, 'prueba'),
(8, 22722, 'prieba'),
(9, 22723, '1'),
(10, 22723, 'extrac'),
(11, 22724, 'compra de clavos'),
(12, 22739, 'INGRESO DE Gerente'),
(13, 22740, 'EGRESO A '),
(14, 22741, 'INGRESO DE Gerente DE Casa Matriz'),
(15, 22742, 'EGRESO A Cajero1'),
(16, 22743, 'INGRESO DE Gerente'),
(17, 22744, 'EGRESO A  DE Sucursal Pilar'),
(18, 22745, 'INGRESO DE Gerente DE Casa Matriz'),
(19, 22746, 'EGRESO A  DE Sucursal Pilar'),
(20, 22747, 'INGRESO DE Gerente DE Casa Matriz'),
(21, 22748, 'EGRESO A Cajero2'),
(22, 22749, 'INGRESO DE Encargado'),
(23, 22750, 'EGRESO A Cajero1'),
(24, 22751, 'INGRESO DE Gerente'),
(25, 22752, 'INGRESO DE Gerente'),
(26, 22753, 'INGRESO DE Gerente'),
(27, 22754, 'INGRESO DE Gerente'),
(28, 22755, 'EGRESO A Encargado DE Sucursal Pilar'),
(29, 22756, 'INGRESO DE Gerente DE Casa Matriz'),
(30, 22757, 'EGRESO A Cajero1'),
(31, 22758, 'SALDO INICIAL'),
(32, 22759, 'SALDO INICIAL'),
(33, 22760, 'SALDO INICIAL'),
(34, 22761, 'EGRESO A Cajero1'),
(35, 22762, 'INGRESO DE Gerente'),
(36, 22763, 'EGRESO A Cajero1'),
(37, 22764, 'INGRESO DE Gerente'),
(38, 22765, 'EGRESO A Cajero1'),
(39, 22766, 'INGRESO DE Gerente'),
(40, 22768, 'EGRESO A Encargado DE Sucursal Pilar'),
(41, 22769, 'INGRESO DE Gerente DE Casa Matriz'),
(42, 22770, 'EGRESO A Encargado DE Sucursal Pilar'),
(43, 22771, 'INGRESO DE Gerente DE Casa Matriz'),
(44, 22772, 'EGRESO A Encargado DE Sucursal Pilar'),
(45, 22773, 'INGRESO DE Gerente DE Casa Matriz'),
(46, 22774, 'SALDO INICIAL'),
(47, 22775, 'SALDO INICIAL'),
(48, 22777, 'EGRESO A Cajero1'),
(49, 22778, 'INGRESO DE Gerente'),
(50, 22779, 'EGRESO A Encargado DE Sucursal Pilar'),
(51, 22780, 'INGRESO DE Gerente DE Casa Matriz'),
(52, 22795, 'INGRESO'),
(53, 22802, 'SALDO INICIAL'),
(54, 22803, 'SALDO INICIAL'),
(55, 22804, 'SALDO INICIAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `idMoneda` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `monedas`
--

INSERT INTO `monedas` (`idMoneda`, `nombre`, `estado`) VALUES
(1, 'Pesos', 1),
(2, 'Dolares', 0),
(3, 'Euros', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operaciones`
--

CREATE TABLE `operaciones` (
  `idOperacion` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `tipoOperacion` int(11) NOT NULL,
  `idMoneda` int(11) NOT NULL,
  `monto` float NOT NULL,
  `cotizacion` float NOT NULL,
  `estado` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `operaciones`
--

INSERT INTO `operaciones` (`idOperacion`, `idUsuario`, `fecha`, `hora`, `tipoOperacion`, `idMoneda`, `monto`, `cotizacion`, `estado`) VALUES
(22802, 1, '2023-10-10', '20:04:31', 5, 1, 10000000, 0, 1),
(22803, 1, '2023-10-10', '20:04:46', 5, 2, 100000, 0, 1),
(22804, 1, '2023-10-10', '20:05:06', 5, 3, 20000, 0, 1),
(22805, 1, '2023-10-10', '20:05:47', 1, 2, 100, 840, 1),
(22806, 1, '2023-10-10', '20:05:55', 2, 2, 200, 890, 1),
(22807, 1, '2023-10-27', '14:28:26', 1, 2, 100, 840, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `idSucursal` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`idSucursal`, `nombre`, `estado`) VALUES
(1, 'Casa Matriz', 1),
(2, 'Sucursal Pilar', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `token`
--

CREATE TABLE `token` (
  `idToken` int(2) NOT NULL,
  `token` varchar(6) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `token`
--

INSERT INTO `token` (`idToken`, `token`, `fecha_hora`) VALUES
(1, 'TXEJOK', '2023-10-27 14:20:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `contra` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `rol` int(5) NOT NULL,
  `estado` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `idSucursal`, `nombre`, `contra`, `rol`, `estado`) VALUES
(1, 1, 'Gerente', 'Gerente', 2, 1),
(2, 1, 'Alberto', 'Cajero1', 0, 1),
(3, 2, 'Encargado', 'Encargado', 1, 1),
(4, 2, 'Cajero2', 'Cajero2', 0, 0),
(16, 1, 'Pablo', 'Pablo123', 2, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`idCaja`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`idCotizacion`);

--
-- Indices de la tabla `detalles`
--
ALTER TABLE `detalles`
  ADD PRIMARY KEY (`idDetalle`);

--
-- Indices de la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`idMoneda`);

--
-- Indices de la tabla `operaciones`
--
ALTER TABLE `operaciones`
  ADD PRIMARY KEY (`idOperacion`),
  ADD KEY `fk_relacion` (`idMoneda`),
  ADD KEY `usuarios_ibfk_2` (`idUsuario`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`idSucursal`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idSucursal` (`idSucursal`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `idCaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `idCotizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `detalles`
--
ALTER TABLE `detalles`
  MODIFY `idDetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `monedas`
--
ALTER TABLE `monedas`
  MODIFY `idMoneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `operaciones`
--
ALTER TABLE `operaciones`
  MODIFY `idOperacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22808;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `idSucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `operaciones`
--
ALTER TABLE `operaciones`
  ADD CONSTRAINT `fk_relacion` FOREIGN KEY (`idMoneda`) REFERENCES `monedas` (`idMoneda`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idSucursal`) REFERENCES `sucursales` (`idSucursal`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
