-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 17-05-2022 a las 13:01:45
-- Versión del servidor: 5.7.38
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `isasport_posrestaurantes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abonoscreditos`
--

CREATE TABLE `abonoscreditos` (
  `codabono` int(11) NOT NULL,
  `codcaja` int(11) NOT NULL,
  `codventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montoabono` decimal(12,2) NOT NULL,
  `fechaabono` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arqueocaja`
--

CREATE TABLE `arqueocaja` (
  `codarqueo` int(11) NOT NULL,
  `codcaja` int(11) NOT NULL,
  `montoinicial` decimal(12,2) NOT NULL,
  `ingresos` decimal(12,2) NOT NULL,
  `egresos` decimal(12,2) NOT NULL,
  `creditos` decimal(12,2) NOT NULL,
  `abonos` decimal(12,2) NOT NULL,
  `dineroefectivo` decimal(12,2) NOT NULL,
  `diferencia` decimal(12,2) NOT NULL,
  `comentarios` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaapertura` datetime NOT NULL,
  `fechacierre` datetime NOT NULL,
  `statusarqueo` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `arqueocaja`
--

INSERT INTO `arqueocaja` (`codarqueo`, `codcaja`, `montoinicial`, `ingresos`, `egresos`, `creditos`, `abonos`, `dineroefectivo`, `diferencia`, `comentarios`, `fechaapertura`, `fechacierre`, `statusarqueo`) VALUES
(1, 6, '50000.00', '4000.00', '1000.00', '0.00', '0.00', '0.00', '0.00', '', '2020-02-06 03:25:30', '0000-00-00 00:00:00', 1),
(2, 1, '0.00', '323040.00', '0.00', '0.00', '0.00', '0.00', '0.00', '', '2020-02-06 03:53:47', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `codcaja` int(11) NOT NULL,
  `nrocaja` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nomcaja` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`codcaja`, `nrocaja`, `nomcaja`, `codigo`) VALUES
(1, '100', 'CAJA PRINCIPAL', 1),
(6, '2', 'CAJA DOS', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `codcategoria` int(11) NOT NULL,
  `nomcategoria` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`codcategoria`, `nomcategoria`) VALUES
(1, 'SALSAS'),
(2, 'BEBIDAS '),
(3, 'COMIDAS RAPIDAS '),
(4, 'MENU'),
(5, 'INGREDIENTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `documcliente` int(11) NOT NULL,
  `dnicliente` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomcliente` varchar(90) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tlfcliente` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_provincia` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `direccliente` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `emailcliente` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `tipocliente` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `limitecredito` float(12,2) NOT NULL,
  `fechaingreso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idcliente`, `codcliente`, `documcliente`, `dnicliente`, `nomcliente`, `tlfcliente`, `id_provincia`, `id_departamento`, `direccliente`, `emailcliente`, `tipocliente`, `limitecredito`, `fechaingreso`) VALUES
(1, 'C1', 18, '1091658551', 'EDUAR LEONARDO SANCHEZ', '(3157) 690579', 1, 0, 'MOLINO', 'LEOSANCHEZ_19@HOTMAIL.COM', 'NATURAL', 0.00, '2020-02-02'),
(2, 'C2', 18, '13176057', 'MAICOL AREVALO', '(3154) 286798', 1, 0, 'MOLINO', 'MSAREVALO8@GMAIL.COM', 'NATURAL', 0.00, '2020-03-13'),
(3, 'C3', 11, '45442238', 'JUAN', '(9550) 20349', 1, 0, 'JR CIRO ALEGRIA', 'JUAN@GMAIL.COM', 'NATURAL', 0.00, '2020-04-27'),
(4, 'C4', 18, '1007977147', 'FABIAN ROJAS', '(3185) 009585', 1, 0, 'BRUSELAS', 'FABIANPALLAREZ@GMAIL.COM', 'NATURAL', 20000.00, '2020-07-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `idcompra` int(11) NOT NULL,
  `codcompra` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasic` decimal(12,2) NOT NULL,
  `subtotalivanoc` decimal(12,2) NOT NULL,
  `ivac` decimal(12,2) NOT NULL,
  `totalivac` decimal(12,2) NOT NULL,
  `descuentoc` decimal(12,2) NOT NULL,
  `totaldescuentoc` decimal(12,2) NOT NULL,
  `totalpagoc` decimal(12,2) NOT NULL,
  `tipocompra` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `formacompra` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechavencecredito` date NOT NULL,
  `fechapagado` date NOT NULL,
  `observaciones` text CHARACTER SET utf32 COLLATE utf32_spanish_ci NOT NULL,
  `statuscompra` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaemision` date NOT NULL,
  `fecharecepcion` date NOT NULL,
  `codigo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`idcompra`, `codcompra`, `codproveedor`, `subtotalivasic`, `subtotalivanoc`, `ivac`, `totalivac`, `descuentoc`, `totaldescuentoc`, `totalpagoc`, `tipocompra`, `formacompra`, `fechavencecredito`, `fechapagado`, `observaciones`, `statuscompra`, `fechaemision`, `fecharecepcion`, `codigo`) VALUES
(1, '1', 'P2', '0.00', '9600.00', '19.00', '0.00', '0.00', '0.00', '9600.00', 'CONTADO', '1', '0000-00-00', '0000-00-00', 'NINGUNA', 'PAGADA', '2020-07-14', '2020-07-14', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `documsucursal` int(11) NOT NULL,
  `cuit` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomsucursal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `tlfsucursal` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `correosucursal` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_provincia` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `direcsucursal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `nroactividad` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `iniciofactura` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaautorizacion` date NOT NULL,
  `llevacontabilidad` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `documencargado` int(11) NOT NULL,
  `dniencargado` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomencargado` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tlfencargado` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descuentoglobal` decimal(12,2) NOT NULL,
  `porcentaje` decimal(12,2) NOT NULL,
  `codmoneda` int(11) NOT NULL,
  `codmoneda2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `documsucursal`, `cuit`, `nomsucursal`, `tlfsucursal`, `correosucursal`, `id_provincia`, `id_departamento`, `direcsucursal`, `nroactividad`, `iniciofactura`, `fechaautorizacion`, `llevacontabilidad`, `documencargado`, `dniencargado`, `nomencargado`, `tlfencargado`, `descuentoglobal`, `porcentaje`, `codmoneda`, `codmoneda2`) VALUES
(1, 18, '000001', 'K-CHE', '(3134) 830516', 'LEOSANCHEZ_19@HOTMAIL.COM', 1, 1, 'MODELO', '0001', '001-HASTA 500', '2018-11-29', 'NO', 16, '109165851', 'JOSE CRIADO', '(3134) 830516', '0.00', '0.00', 10, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditosxclientes`
--

CREATE TABLE `creditosxclientes` (
  `codcredito` int(11) NOT NULL,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montocredito` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id_departamento` int(11) NOT NULL,
  `departamento` varchar(255) CHARACTER SET latin1 NOT NULL,
  `id_provincia` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamento`, `departamento`, `id_provincia`) VALUES
(1, 'norte de santander', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecompras`
--

CREATE TABLE `detallecompras` (
  `coddetallecompra` int(11) NOT NULL,
  `codcompra` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipoentrada` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcategoria` int(11) NOT NULL,
  `preciocomprac` decimal(12,2) NOT NULL,
  `precioventac` decimal(12,2) NOT NULL,
  `cantcompra` decimal(12,2) NOT NULL,
  `ivaproductoc` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descproductoc` decimal(12,2) NOT NULL,
  `descfactura` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentoc` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `lotec` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaelaboracionc` date NOT NULL,
  `fechaexpiracionc` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `detallecompras`
--

INSERT INTO `detallecompras` (`coddetallecompra`, `codcompra`, `tipoentrada`, `codproducto`, `producto`, `codcategoria`, `preciocomprac`, `precioventac`, `cantcompra`, `ivaproductoc`, `descproductoc`, `descfactura`, `valortotal`, `totaldescuentoc`, `valorneto`, `lotec`, `fechaelaboracionc`, `fechaexpiracionc`) VALUES
(1, '1', 'PRODUCTO', '0043', 'PAPITAS FRITAS', 3, '2000.00', '2500.00', '5.00', 'NO', '2.00', '4.00', '10000.00', '400.00', '9600.00', '0', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedidos`
--

CREATE TABLE `detallepedidos` (
  `coddetallepedido` int(11) NOT NULL,
  `codpedido` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pedido` int(15) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcategoria` int(11) NOT NULL,
  `cantventa` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `ivaproducto` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentov` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `observacionespedido` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cocinero` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `detallepedidos`
--

INSERT INTO `detallepedidos` (`coddetallepedido`, `codpedido`, `pedido`, `codproducto`, `producto`, `codcategoria`, `cantventa`, `precioventa`, `ivaproducto`, `descproducto`, `valortotal`, `totaldescuentov`, `valorneto`, `observacionespedido`, `cocinero`) VALUES
(4, 'P3', 1, '03', 'COCACOLA', 2, '1.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '0', 1),
(5, 'P3', 1, '005', 'HAMBURGUESA', 3, '1.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '0', 1),
(6, 'P3', 1, '004', 'POLLO ASADO', 4, '1.00', '8000.00', 'NO', '0.00', '8000.00', '0.00', '8000.00', '0', 1),
(56, 'P25', 1, '0043', 'PAPITAS FRITAS', 3, '1.00', '2500.00', 'NO', '2.00', '2500.00', '50.00', '2450.00', '0', 1),
(54, 'P25', 1, '005', 'HAMBURGUESA', 3, '1.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '0', 1),
(55, 'P25', 1, '04', 'JUGO HIT', 2, '1.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '0', 1),
(12, 'P3', 2, '03', 'COCACOLA', 2, '1.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '0', 1),
(19, 'P9', 1, '03', 'COCACOLA', 2, '3.00', '2000.00', 'NO', '0.00', '6000.00', '0.00', '6000.00', '0', 1),
(20, 'P9', 1, '005', 'HAMBURGUESA', 3, '2.00', '8000.00', 'SI', '0.00', '16000.00', '0.00', '16000.00', '0', 1),
(21, 'P9', 1, '04', 'JUGO HIT', 2, '1.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '0', 1),
(51, 'P23', 1, '0043', 'PAPITAS FRITAS', 3, '1.00', '2500.00', 'NO', '2.00', '2500.00', '50.00', '2450.00', '0', 1),
(50, 'P23', 1, '005', 'HAMBURGUESA', 3, '1.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '0', 1),
(40, 'P19', 1, '005', 'HAMBURGUESA', 3, '1.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '0', 0),
(36, 'P17', 1, '04', 'JUGO HIT', 2, '1.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '0', 0),
(35, 'P17', 1, '03', 'COCACOLA', 2, '1.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '0', 0),
(39, 'P19', 1, '03', 'COCACOLA', 2, '1.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '0', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventas`
--

CREATE TABLE `detalleventas` (
  `coddetalleventa` int(11) NOT NULL,
  `codpedido` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcategoria` int(11) NOT NULL,
  `cantventa` decimal(12,2) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `ivaproducto` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentov` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `valorneto2` decimal(12,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `detalleventas`
--

INSERT INTO `detalleventas` (`coddetalleventa`, `codpedido`, `codventa`, `codproducto`, `producto`, `codcategoria`, `cantventa`, `preciocompra`, `precioventa`, `ivaproducto`, `descproducto`, `valortotal`, `totaldescuentov`, `valorneto`, `valorneto2`) VALUES
(93, 'P1', '0001-001-HASTA 500', '04', 'JUGO HIT', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(94, 'P1', '0001-001-HASTA 500', '03', 'COCACOLA', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(95, 'P2', '0001-0000000000026', '03', 'COCACOLA', 2, '4.00', '1300.00', '2000.00', 'NO', '0.00', '8000.00', '0.00', '8000.00', '5200.00'),
(96, 'P3', '0', '03', 'COCACOLA', 2, '2.00', '1300.00', '2000.00', 'NO', '0.00', '4000.00', '0.00', '4000.00', '2600.00'),
(97, 'P3', '0', '005', 'HAMBURGUESA', 3, '1.00', '6000.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '6000.00'),
(98, 'P3', '0', '004', 'POLLO ASADO', 4, '1.00', '7000.00', '8000.00', 'NO', '0.00', '8000.00', '0.00', '8000.00', '7000.00'),
(99, 'P4', '0001-0000000000017', '03', 'COCACOLA', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(100, 'P4', '0001-0000000000017', '005', 'HAMBURGUESA', 3, '1.00', '6000.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '6000.00'),
(101, 'P4', '0001-0000000000017', '002', 'CON CARNE GUISADA', 4, '1.00', '6000.00', '7900.00', 'NO', '0.00', '7900.00', '0.00', '7900.00', '6000.00'),
(102, 'P5', '0001-0000000000021', '04', 'JUGO HIT', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(103, 'P5', '0001-0000000000021', '001', 'ALMUERZO CORRIENTE', 4, '1.00', '6000.00', '7900.00', 'NO', '0.00', '7900.00', '0.00', '7900.00', '6000.00'),
(104, 'P6', '0001-0000000000002', '005', 'HAMBURGUESA', 3, '1.00', '6000.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '6000.00'),
(105, 'P6', '0001-0000000000002', '03', 'COCACOLA', 2, '3.00', '1300.00', '2000.00', 'NO', '0.00', '6000.00', '0.00', '6000.00', '3900.00'),
(106, 'P7', '0001-0000000000003', '03', 'COCACOLA', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(107, 'P7', '0001-0000000000003', '04', 'JUGO HIT', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(108, 'P8', '0001-0000000000004', '005', 'HAMBURGUESA', 3, '1.00', '6000.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '6000.00'),
(109, 'P8', '0001-0000000000004', '03', 'COCACOLA', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(110, 'P9', '0001-0000000000005', '03', 'COCACOLA', 2, '3.00', '1300.00', '2000.00', 'NO', '0.00', '6000.00', '0.00', '6000.00', '3900.00'),
(111, 'P9', '0001-0000000000005', '005', 'HAMBURGUESA', 3, '2.00', '6000.00', '8000.00', 'SI', '0.00', '16000.00', '0.00', '16000.00', '12000.00'),
(112, 'P9', '0001-0000000000005', '04', 'JUGO HIT', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(113, 'P10', '0001-0000000000008', '005', 'HAMBURGUESA', 3, '1.00', '6000.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '6000.00'),
(114, 'P10', '0001-0000000000008', '04', 'JUGO HIT', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(115, 'P11', '0001-0000000000009', '005', 'HAMBURGUESA', 3, '2.00', '6000.00', '8000.00', 'SI', '0.00', '16000.00', '0.00', '16000.00', '12000.00'),
(116, 'P11', '0001-0000000000009', '03', 'COCACOLA', 2, '2.00', '1300.00', '2000.00', 'NO', '0.00', '4000.00', '0.00', '4000.00', '2600.00'),
(117, 'P12', '0001-0000000000010', '03', 'COCACOLA', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(118, 'P13', '0001-0000000000011', '03', 'COCACOLA', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(119, 'P13', '0001-0000000000011', '005', 'HAMBURGUESA', 3, '1.00', '6000.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '6000.00'),
(120, 'P14', '0001-0000000000012', '03', 'COCACOLA', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(121, 'P15', '0001-0000000000018', '03', 'COCACOLA', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(122, 'P15', '0001-0000000000018', '04', 'JUGO HIT', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(123, 'P16', '0001-0000000000013', '004', 'POLLO ASADO', 4, '1.00', '7000.00', '8000.00', 'NO', '0.00', '8000.00', '0.00', '8000.00', '7000.00'),
(124, 'P16', '0001-0000000000013', '03', 'COCACOLA', 2, '2.00', '1300.00', '2000.00', 'NO', '0.00', '4000.00', '0.00', '4000.00', '2600.00'),
(125, 'P17', '0001-0000000000014', '03', 'COCACOLA', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(126, 'P17', '0001-0000000000014', '04', 'JUGO HIT', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(127, 'P18', '0001-0000000000015', '03', 'COCACOLA', 2, '2.00', '1300.00', '2000.00', 'NO', '0.00', '4000.00', '0.00', '4000.00', '2600.00'),
(128, 'P18', '0001-0000000000015', '005', 'HAMBURGUESA', 3, '2.00', '6000.00', '8000.00', 'SI', '0.00', '16000.00', '0.00', '16000.00', '12000.00'),
(129, 'P19', '0001-0000000000016', '03', 'COCACOLA', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(130, 'P19', '0001-0000000000016', '005', 'HAMBURGUESA', 3, '1.00', '6000.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '6000.00'),
(131, 'P20', '0001-0000000000019', '04', 'JUGO HIT', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(132, 'P20', '0001-0000000000019', '005', 'HAMBURGUESA', 3, '2.00', '6000.00', '8000.00', 'SI', '0.00', '16000.00', '0.00', '16000.00', '12000.00'),
(133, 'P21', '0001-0000000000020', '03', 'COCACOLA', 2, '2.00', '1300.00', '2000.00', 'NO', '0.00', '4000.00', '0.00', '4000.00', '2600.00'),
(134, 'P21', '0001-0000000000020', '005', 'HAMBURGUESA', 3, '1.00', '6000.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '6000.00'),
(135, 'P21', '0001-0000000000020', '0043', 'PAPITAS FRITAS', 3, '1.00', '2000.00', '2500.00', 'NO', '2.00', '2500.00', '50.00', '2450.00', '2000.00'),
(136, 'P5', '0001-0000000000021', '0043', 'PAPITAS FRITAS', 3, '1.00', '2000.00', '2500.00', 'NO', '2.00', '2500.00', '50.00', '2450.00', '2000.00'),
(137, 'P22', '0001-0000000000022', '04', 'JUGO HIT', 2, '2.00', '1300.00', '2000.00', 'NO', '0.00', '4000.00', '0.00', '4000.00', '2600.00'),
(138, 'P22', '0001-0000000000022', '005', 'HAMBURGUESA', 3, '2.00', '6000.00', '8000.00', 'SI', '0.00', '16000.00', '0.00', '16000.00', '12000.00'),
(139, 'P23', '0001-0000000000023', '005', 'HAMBURGUESA', 3, '1.00', '6000.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '6000.00'),
(140, 'P23', '0001-0000000000023', '0043', 'PAPITAS FRITAS', 3, '1.00', '2000.00', '2500.00', 'NO', '2.00', '2500.00', '50.00', '2450.00', '2000.00'),
(141, 'P24', '0001-0000000000024', '04', 'JUGO HIT', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(142, 'P24', '0001-0000000000024', '005', 'HAMBURGUESA', 3, '1.00', '6000.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '6000.00'),
(143, 'P25', '0001-0000000000025', '005', 'HAMBURGUESA', 3, '1.00', '6000.00', '8000.00', 'SI', '0.00', '8000.00', '0.00', '8000.00', '6000.00'),
(144, 'P25', '0001-0000000000025', '04', 'JUGO HIT', 2, '1.00', '1300.00', '2000.00', 'NO', '0.00', '2000.00', '0.00', '2000.00', '1300.00'),
(145, 'P25', '0001-0000000000025', '0043', 'PAPITAS FRITAS', 3, '1.00', '2000.00', '2500.00', 'NO', '2.00', '2500.00', '50.00', '2450.00', '2000.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `coddocumento` int(11) NOT NULL,
  `documento` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`coddocumento`, `documento`, `descripcion`) VALUES
(1, 'RUC', 'REGISTRO UNICO DE CONTRIBUYENTES'),
(2, 'RUT', 'REGISTRO UNICO TRIBUTARIO'),
(3, 'RIF', 'REGISTRO DE INFORMACION FISCAL'),
(4, 'RFC', 'REGISTRO FEDERAL DE CONTRIBUYENTES'),
(5, 'RTN', 'REGISTRO TRIBUTARIO NACIONAL'),
(6, 'RTU', 'REGISTRO TRIBUTARIO UNIFICADO'),
(7, 'RNC', 'REGISTRO NACIONAL DEL CONTRIBUYENTE'),
(8, 'NIF', 'NUMERO DE IDENTIFICACION FISCAL'),
(9, 'NIT', 'NUMERO DE IDENTIFICACION TRIBUTARIA'),
(10, 'NITE', 'NUMERO DE IDENTIFICACION TRIBUTARIA ESPECIAL'),
(11, 'DNI', 'DOCUMENTO NACIONAL DE IDENTIDAD'),
(12, 'CUIL', 'CODIGO UNICO DE IDENTIFICACION LABORAL'),
(13, 'CUIT', 'CODIGO UNICO DE IDENTIFICACION TRIBUTARIA'),
(14, 'REGISTRO CIVIL', 'REGISTRO CIVIL'),
(15, 'TARJ. DE IDENTIDAD', 'TARJETA DE IDENTIDAD'),
(16, 'CI', 'CEDULA DE IDENTIDAD'),
(17, 'PASAPORTE', 'PASAPORTE'),
(18, 'C.C', 'CEDULA CIUDADANIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuestos`
--

CREATE TABLE `impuestos` (
  `codimpuesto` int(11) NOT NULL,
  `nomimpuesto` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `valorimpuesto` decimal(12,2) NOT NULL,
  `statusimpuesto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaimpuesto` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `impuestos`
--

INSERT INTO `impuestos` (`codimpuesto`, `nomimpuesto`, `valorimpuesto`, `statusimpuesto`, `fechaimpuesto`) VALUES
(2, 'IVA', '19.00', 'ACTIVO', '2019-06-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `idingrediente` int(11) NOT NULL,
  `codingrediente` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nomingrediente` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmedida` int(11) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `cantingrediente` decimal(12,2) NOT NULL,
  `stockminimo` decimal(12,2) NOT NULL,
  `stockmaximo` decimal(12,2) NOT NULL,
  `ivaingrediente` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descingrediente` decimal(12,2) NOT NULL,
  `lote` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaexpiracion` date NOT NULL,
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`idingrediente`, `codingrediente`, `nomingrediente`, `codmedida`, `preciocompra`, `precioventa`, `cantingrediente`, `stockminimo`, `stockmaximo`, `ivaingrediente`, `descingrediente`, `lote`, `fechaexpiracion`, `codproveedor`) VALUES
(1, '1', 'PAN PERRO', 4, '500.00', '600.00', '100.00', '10.00', '200.00', 'NO', '0.00', '01', '2020-02-29', 'P1'),
(2, '2', 'PAN DE HAMBURGUESA', 4, '500.00', '600.00', '100.00', '10.00', '100.00', 'NO', '0.00', '02', '2020-02-29', 'P1'),
(3, '3', 'CARNE', 3, '16.00', '20.00', '1000.00', '200.00', '3000.00', 'NO', '0.00', '03', '2020-03-31', 'P1'),
(4, '4', 'PAPA RIPIO', 3, '6.50', '7.00', '1000.00', '100.00', '3000.00', 'NO', '0.00', '04', '2020-03-31', 'P1'),
(5, '6', 'QUESO', 3, '12.00', '15.00', '1000.00', '200.00', '3000.00', 'NO', '0.00', '06', '2020-03-31', 'P1'),
(6, '7', 'CHICHARR&Oacute;N', 3, '7.00', '7.00', '1000.00', '200.00', '3000.00', 'NO', '0.00', '07', '2020-03-30', 'P1'),
(7, '8', 'POLLO', 3, '10.00', '12.00', '1000.00', '200.00', '3000.00', 'NO', '0.00', '08', '2020-02-29', 'P1'),
(8, '9', 'MAIZ', 3, '25.00', '25.00', '1000.00', '200.00', '3000.00', 'NO', '0.00', '09', '0000-00-00', ''),
(9, '10', 'HUEVOS DE CODORNIZ ', 4, '150.00', '200.00', '100.00', '20.00', '500.00', 'NO', '0.00', '010', '0000-00-00', ''),
(10, '11', 'PAPA ', 3, '2.00', '2.00', '1000.00', '300.00', '25000.00', 'NO', '0.00', '011', '0000-00-00', 'P1'),
(11, '12', 'COPTELERO', 4, '180.00', '200.00', '100.00', '20.00', '500.00', 'NO', '0.00', '012', '2020-04-30', ''),
(12, '13', 'CEBOLLA', 3, '2.00', '2.00', '1000.00', '200.00', '3000.00', 'NO', '0.00', '013', '2020-03-18', 'P1'),
(13, '14', 'LECHUGA ', 4, '100.00', '100.00', '10.00', '5.00', '30.00', 'NO', '0.00', '013', '2020-02-29', 'P1'),
(14, '15', 'CHORIZO', 4, '1200.00', '1200.00', '20.00', '5.00', '100.00', 'NO', '0.00', '015', '2020-04-28', 'P1'),
(15, '5', 'TOMATE', 3, '3.00', '3.00', '1000.00', '200.00', '3000.00', 'NO', '0.00', '05', '2020-03-31', ''),
(16, '16', 'ARROZ', 3, '17.00', '17.00', '1000.00', '200.00', '5000.00', 'NO', '0.00', '016', '0000-00-00', 'P1'),
(17, '17', 'SALCHICHA CL&Aacute;SICA', 4, '1000.00', '1000.00', '30.00', '10.00', '100.00', 'NO', '0.00', '017', '2020-04-30', 'P1'),
(18, '18', 'SALCHICHA RANCHERA ', 4, '2000.00', '2000.00', '100.00', '10.00', '300.00', 'NO', '0.00', '018', '2020-05-31', 'P1'),
(19, '19', 'JAM&Oacute;N', 4, '100.00', '100.00', '100.00', '20.00', '500.00', 'NO', '0.00', '019', '2020-04-30', 'P1'),
(20, '20', 'MARISCOS', 4, '2000.00', '2000.00', '100.00', '10.00', '500.00', 'NO', '0.00', '019', '2020-03-31', 'P1'),
(21, '21', 'TOCINETA ', 4, '1500.00', '1500.00', '100.00', '20.00', '500.00', 'NO', '0.00', '021', '2020-04-28', 'P1'),
(22, '2345', 'PAPITAS FRITAS', 5, '2000.00', '2500.00', '1.00', '10.00', '50.00', 'NO', '0.00', '0', '2020-10-02', 'P2'),
(24, '0010', 'LECHUGA', 3, '1200.00', '1800.00', '0.00', '10.00', '50.00', 'NO', '0.00', '0', '0000-00-00', 'P2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex_ingredientes`
--

CREATE TABLE `kardex_ingredientes` (
  `codkardex` int(11) NOT NULL,
  `codproceso` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codresponsable` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codingrediente` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `movimiento` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `entradas` decimal(12,2) NOT NULL,
  `salidas` decimal(12,2) NOT NULL,
  `devolucion` decimal(12,2) NOT NULL,
  `stockactual` decimal(12,2) NOT NULL,
  `ivaingrediente` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descingrediente` decimal(12,2) NOT NULL,
  `precio` decimal(12,2) NOT NULL,
  `documento` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechakardex` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `kardex_ingredientes`
--

INSERT INTO `kardex_ingredientes` (`codkardex`, `codproceso`, `codresponsable`, `codingrediente`, `movimiento`, `entradas`, `salidas`, `devolucion`, `stockactual`, `ivaingrediente`, `descingrediente`, `precio`, `documento`, `fechakardex`) VALUES
(1, '1', '0', '1', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '600.00', 'INVENTARIO INICIAL', '2020-02-06'),
(2, '2', '0', '2', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '600.00', 'INVENTARIO INICIAL', '2020-02-06'),
(3, '3', '0', '3', 'ENTRADAS', '1000.00', '0.00', '0.00', '1000.00', 'NO', '0.00', '250.00', 'INVENTARIO INICIAL', '2020-02-06'),
(4, '4', '0', '4', 'ENTRADAS', '1000.00', '0.00', '0.00', '1000.00', 'NO', '0.00', '7.00', 'INVENTARIO INICIAL', '2020-02-06'),
(5, '6', '0', '6', 'ENTRADAS', '1000.00', '0.00', '0.00', '1000.00', 'NO', '0.00', '15.00', 'INVENTARIO INICIAL', '2020-02-06'),
(6, '7', '0', '7', 'ENTRADAS', '1000.00', '0.00', '0.00', '1000.00', 'NO', '0.00', '7.00', 'INVENTARIO INICIAL', '2020-02-06'),
(7, '8', '0', '8', 'ENTRADAS', '1000.00', '0.00', '0.00', '1000.00', 'NO', '0.00', '12.00', 'INVENTARIO INICIAL', '2020-02-06'),
(8, '9', '0', '9', 'ENTRADAS', '1000.00', '0.00', '0.00', '1000.00', 'NO', '0.00', '25.00', 'INVENTARIO INICIAL', '2020-02-06'),
(9, '10', '0', '10', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '200.00', 'INVENTARIO INICIAL', '2020-02-06'),
(10, '11', '0', '11', 'ENTRADAS', '1000.00', '0.00', '0.00', '1000.00', 'NO', '0.00', '20.00', 'INVENTARIO INICIAL', '2020-02-06'),
(11, '12', '0', '12', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '200.00', 'INVENTARIO INICIAL', '2020-02-06'),
(12, '13', '0', '13', 'ENTRADAS', '1000.00', '0.00', '0.00', '1000.00', 'NO', '0.00', '2.00', 'INVENTARIO INICIAL', '2020-02-06'),
(13, '14', '0', '14', 'ENTRADAS', '10.00', '0.00', '0.00', '10.00', 'NO', '0.00', '100.00', 'INVENTARIO INICIAL', '2020-02-06'),
(14, '15', '0', '15', 'ENTRADAS', '20.00', '0.00', '0.00', '20.00', 'NO', '0.00', '1200.00', 'INVENTARIO INICIAL', '2020-02-06'),
(15, '5', '0', '5', 'ENTRADAS', '1000.00', '0.00', '0.00', '1000.00', 'NO', '0.00', '3.00', 'INVENTARIO INICIAL', '2020-02-06'),
(16, '16', '0', '16', 'ENTRADAS', '1000.00', '0.00', '0.00', '1000.00', 'NO', '0.00', '17.00', 'INVENTARIO INICIAL', '2020-02-06'),
(17, '17', '0', '17', 'ENTRADAS', '30.00', '0.00', '0.00', '30.00', 'NO', '0.00', '1000.00', 'INVENTARIO INICIAL', '2020-02-06'),
(18, '18', '0', '18', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '2000.00', 'INVENTARIO INICIAL', '2020-02-06'),
(19, '19', '0', '19', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '100.00', 'INVENTARIO INICIAL', '2020-02-06'),
(20, '20', '0', '20', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '2000.00', 'INVENTARIO INICIAL', '2020-02-06'),
(21, '21', '0', '21', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '1500.00', 'INVENTARIO INICIAL', '2020-02-06'),
(22, '2345', '0', '2345', 'ENTRADAS', '1.00', '0.00', '0.00', '1.00', 'NO', '0.00', '2500.00', 'INVENTARIO INICIAL', '2020-07-15'),
(24, '0010', '0', '0010', 'ENTRADAS', '0.00', '0.00', '0.00', '0.00', 'NO', '0.00', '1800.00', 'INVENTARIO INICIAL', '2020-08-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex_productos`
--

CREATE TABLE `kardex_productos` (
  `codkardex` int(11) NOT NULL,
  `codproceso` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codresponsable` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `movimiento` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `entradas` decimal(12,2) NOT NULL,
  `salidas` decimal(12,2) NOT NULL,
  `devolucion` decimal(12,2) NOT NULL,
  `stockactual` decimal(12,2) NOT NULL,
  `ivaproducto` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `precio` decimal(12,2) NOT NULL,
  `documento` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechakardex` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `kardex_productos`
--

INSERT INTO `kardex_productos` (`codkardex`, `codproceso`, `codresponsable`, `codproducto`, `movimiento`, `entradas`, `salidas`, `devolucion`, `stockactual`, `ivaproducto`, `descproducto`, `precio`, `documento`, `fechakardex`) VALUES
(3, '03', '0', '03', 'ENTRADAS', '30.00', '0.00', '0.00', '30.00', 'NO', '0.00', '2000.00', 'INVENTARIO INICIAL', '2020-02-06'),
(6, '04', '0', '04', 'ENTRADAS', '30.00', '0.00', '0.00', '30.00', 'NO', '0.00', '2000.00', 'INVENTARIO INICIAL', '2020-02-06'),
(5, '05', '0', '05', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '100.00', 'INVENTARIO INICIAL', '2020-02-06'),
(7, '001', '0', '001', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '7900.00', 'INVENTARIO INICIAL', '2020-02-06'),
(8, '002', '0', '002', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '7900.00', 'INVENTARIO INICIAL', '2020-02-06'),
(9, '003', '0', '003', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '9000.00', 'INVENTARIO INICIAL', '2020-02-06'),
(10, 'P1', '0', '04', 'SALIDAS', '0.00', '1.00', '0.00', '29.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-02-06'),
(11, 'P1', '0', '03', 'SALIDAS', '0.00', '1.00', '0.00', '29.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-02-06'),
(12, '004', '0', '004', 'ENTRADAS', '200.00', '0.00', '0.00', '200.00', 'NO', '0.00', '8000.00', 'INVENTARIO INICIAL', '2020-02-06'),
(13, '005', '0', '005', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'SI', '0.00', '8000.00', 'INVENTARIO INICIAL', '2020-02-06'),
(14, 'P2', '0', '03', 'SALIDAS', '0.00', '4.00', '0.00', '25.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-02-06'),
(15, 'P3', '0', '03', 'SALIDAS', '0.00', '2.00', '0.00', '22.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-02-06'),
(16, 'P3', '0', '005', 'SALIDAS', '0.00', '1.00', '0.00', '99.00', 'SI', '0.00', '8000.00', 'PEDIDO EN MESA', '2020-02-06'),
(17, 'P3', '0', '004', 'SALIDAS', '0.00', '1.00', '0.00', '199.00', 'NO', '0.00', '8000.00', 'PEDIDO EN MESA', '2020-02-06'),
(18, 'P4', '0', '03', 'SALIDAS', '0.00', '1.00', '0.00', '23.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-02-06'),
(19, 'P4', '0', '005', 'SALIDAS', '0.00', '1.00', '0.00', '98.00', 'SI', '0.00', '8000.00', 'PEDIDO EN MESA', '2020-02-06'),
(20, 'P4', '0', '002', 'SALIDAS', '0.00', '1.00', '0.00', '99.00', 'NO', '0.00', '7900.00', 'PEDIDO EN MESA', '2020-02-06'),
(21, 'P5', '0', '04', 'SALIDAS', '0.00', '1.00', '0.00', '28.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-02-06'),
(22, 'P5', '0', '001', 'SALIDAS', '0.00', '1.00', '0.00', '99.00', 'NO', '0.00', '7900.00', 'PEDIDO EN MESA', '2020-02-06'),
(23, 'P6', '0', '005', 'SALIDAS', '0.00', '1.00', '0.00', '97.00', 'SI', '0.00', '8000.00', 'PEDIDO EN MESA', '2020-02-29'),
(24, 'P6', '0', '03', 'SALIDAS', '0.00', '3.00', '0.00', '19.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-02-29'),
(25, 'P7', '0', '03', 'SALIDAS', '0.00', '1.00', '0.00', '18.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-02-29'),
(26, 'P7', '0', '04', 'SALIDAS', '0.00', '1.00', '0.00', '27.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-02-29'),
(27, 'P8', '0', '005', 'SALIDAS', '0.00', '1.00', '0.00', '96.00', 'SI', '0.00', '8000.00', 'PEDIDO EN MESA', '2020-03-13'),
(28, 'P8', '0', '03', 'SALIDAS', '0.00', '1.00', '0.00', '17.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-03-13'),
(29, 'P9', 'C2', '03', 'SALIDAS', '0.00', '3.00', '0.00', '14.00', 'NO', '0.00', '2000.00', 'PEDIDO EN VENTA', '2020-03-13'),
(30, 'P9', 'C2', '005', 'SALIDAS', '0.00', '2.00', '0.00', '94.00', 'SI', '0.00', '8000.00', 'PEDIDO EN VENTA', '2020-03-13'),
(31, 'P9', 'C2', '04', 'SALIDAS', '0.00', '1.00', '0.00', '26.00', 'NO', '0.00', '2000.00', 'PEDIDO EN VENTA', '2020-03-13'),
(32, 'P10', '0', '005', 'SALIDAS', '0.00', '1.00', '0.00', '93.00', 'SI', '0.00', '8000.00', 'PEDIDO EN MESA', '2020-03-13'),
(33, 'P10', '0', '04', 'SALIDAS', '0.00', '1.00', '0.00', '25.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-03-13'),
(34, 'P11', '0', '005', 'SALIDAS', '0.00', '2.00', '0.00', '91.00', 'SI', '0.00', '8000.00', 'PEDIDO EN MESA', '2020-03-18'),
(35, 'P11', '0', '03', 'SALIDAS', '0.00', '2.00', '0.00', '12.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-03-18'),
(36, 'P12', '0', '03', 'SALIDAS', '0.00', '1.00', '0.00', '11.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-04-27'),
(37, 'P13', 'C3', '03', 'SALIDAS', '0.00', '1.00', '0.00', '10.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-04-27'),
(38, 'P13', 'C3', '005', 'SALIDAS', '0.00', '1.00', '0.00', '90.00', 'SI', '0.00', '8000.00', 'PEDIDO EN MESA', '2020-04-27'),
(39, 'P14', '0', '03', 'SALIDAS', '0.00', '1.00', '0.00', '9.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-05-08'),
(40, 'P15', '0', '03', 'SALIDAS', '0.00', '1.00', '0.00', '8.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-05-12'),
(41, 'P15', '0', '04', 'SALIDAS', '0.00', '1.00', '0.00', '24.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-05-12'),
(42, 'P16', '0', '004', 'SALIDAS', '0.00', '1.00', '0.00', '198.00', 'NO', '0.00', '8000.00', 'PEDIDO EN MESA', '2020-05-14'),
(43, 'P16', '0', '03', 'SALIDAS', '0.00', '2.00', '0.00', '6.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-05-14'),
(44, 'P17', '0', '03', 'SALIDAS', '0.00', '1.00', '0.00', '5.00', 'NO', '0.00', '2000.00', 'PEDIDO EN VENTA', '2020-05-14'),
(45, 'P17', '0', '04', 'SALIDAS', '0.00', '1.00', '0.00', '23.00', 'NO', '0.00', '2000.00', 'PEDIDO EN VENTA', '2020-05-14'),
(46, 'P18', '0', '03', 'SALIDAS', '0.00', '2.00', '0.00', '3.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-07-07'),
(47, 'P18', '0', '005', 'SALIDAS', '0.00', '2.00', '0.00', '88.00', 'SI', '0.00', '8000.00', 'PEDIDO EN MESA', '2020-07-07'),
(48, 'P19', '0', '03', 'SALIDAS', '0.00', '1.00', '0.00', '2.00', 'NO', '0.00', '2000.00', 'PEDIDO EN VENTA', '2020-07-07'),
(49, 'P19', '0', '005', 'SALIDAS', '0.00', '1.00', '0.00', '87.00', 'SI', '0.00', '8000.00', 'PEDIDO EN VENTA', '2020-07-07'),
(50, '0043', '0', '0043', 'ENTRADAS', '50.00', '0.00', '0.00', '50.00', 'NO', '0.00', '2500.00', 'INVENTARIO INICIAL', '2020-07-15'),
(51, '1', 'P2', '0043', 'ENTRADAS', '5.00', '0.00', '0.00', '55.00', 'NO', '2.00', '2000.00', 'COMPRA', '2020-07-15'),
(52, 'P20', '0', '04', 'SALIDAS', '0.00', '1.00', '0.00', '22.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-07-15'),
(53, 'P20', '0', '005', 'SALIDAS', '0.00', '2.00', '0.00', '85.00', 'SI', '0.00', '8000.00', 'PEDIDO EN MESA', '2020-07-15'),
(54, 'P21', '0', '03', 'SALIDAS', '0.00', '2.00', '0.00', '0.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-08-26'),
(55, 'P21', '0', '005', 'SALIDAS', '0.00', '1.00', '0.00', '84.00', 'SI', '0.00', '8000.00', 'PEDIDO EN MESA', '2020-08-26'),
(56, 'P21', '0', '0043', 'SALIDAS', '0.00', '1.00', '0.00', '54.00', 'NO', '2.00', '2500.00', 'PEDIDO EN MESA', '2020-08-26'),
(57, 'P5', '0', '0043', 'SALIDAS', '0.00', '1.00', '0.00', '53.00', 'NO', '2.00', '2500.00', 'PEDIDO EN MESA', '2020-08-26'),
(58, 'P22', '0', '04', 'SALIDAS', '0.00', '2.00', '0.00', '20.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-08-27'),
(59, 'P22', '0', '005', 'SALIDAS', '0.00', '2.00', '0.00', '82.00', 'SI', '0.00', '8000.00', 'PEDIDO EN MESA', '2020-08-27'),
(60, 'P23', 'C1', '005', 'SALIDAS', '0.00', '1.00', '0.00', '81.00', 'SI', '0.00', '8000.00', 'PEDIDO EN VENTA', '2020-08-27'),
(61, 'P23', 'C1', '0043', 'SALIDAS', '0.00', '1.00', '0.00', '52.00', 'NO', '2.00', '2500.00', 'PEDIDO EN VENTA', '2020-08-27'),
(62, 'P24', '0', '04', 'SALIDAS', '0.00', '1.00', '0.00', '19.00', 'NO', '0.00', '2000.00', 'PEDIDO EN MESA', '2020-08-28'),
(63, 'P24', '0', '005', 'SALIDAS', '0.00', '1.00', '0.00', '80.00', 'SI', '0.00', '8000.00', 'PEDIDO EN MESA', '2020-08-28'),
(64, 'P25', 'C1', '005', 'SALIDAS', '0.00', '1.00', '0.00', '79.00', 'SI', '0.00', '8000.00', 'PEDIDO EN VENTA', '2020-08-28'),
(65, 'P25', 'C1', '04', 'SALIDAS', '0.00', '1.00', '0.00', '18.00', 'NO', '0.00', '2000.00', 'PEDIDO EN VENTA', '2020-08-28'),
(66, 'P25', 'C1', '0043', 'SALIDAS', '0.00', '1.00', '0.00', '51.00', 'NO', '2.00', '2500.00', 'PEDIDO EN VENTA', '2020-08-28'),
(67, '0013', '0', '0013', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '9000.00', 'INVENTARIO INICIAL', '2020-08-28'),
(68, '0016', '0', '0016', 'ENTRADAS', '1000.00', '0.00', '0.00', '1000.00', 'NO', '0.00', '15000.00', 'INVENTARIO INICIAL', '2020-08-28'),
(69, '0020', '0', '0020', 'ENTRADAS', '1000.00', '0.00', '0.00', '1000.00', 'NO', '0.00', '600.00', 'INVENTARIO INICIAL', '2020-08-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tiempo` datetime DEFAULT NULL,
  `detalles` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `paginas` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `usuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `log`
--

INSERT INTO `log` (`id`, `ip`, `tiempo`, `detalles`, `paginas`, `usuario`) VALUES
(1, '179.32.182.151', '2020-02-06 12:01:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'EDUAR'),
(2, '191.109.103.41', '2020-02-06 12:01:54', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', '/index.php', 'EDUAR '),
(3, '179.32.182.151', '2020-02-06 12:02:00', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'EDUAR'),
(4, '191.109.103.41', '2020-02-06 12:02:17', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', '/index.php', 'EDUAR'),
(5, '179.32.182.151', '2020-02-06 12:11:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'EDUAR'),
(6, '191.109.103.41', '2020-02-06 12:12:37', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', '/index.php', 'EDUAR'),
(7, '191.109.103.41', '2020-02-06 12:31:08', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', '/index.php', 'EDUAR'),
(8, '179.32.182.151', '2020-02-06 01:04:47', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'EDUAR'),
(9, '179.32.182.151', '2020-02-06 06:17:20', 'Mozilla/5.0 (Linux; Android 9; MRD-LX3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.136 Mobile Safari/537.36', '/index.php', 'EDUAR '),
(10, '179.32.182.151', '2020-02-06 06:17:21', 'Mozilla/5.0 (Linux; Android 9; MRD-LX3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.136 Mobile Safari/537.36', '/index.php', 'EDUAR '),
(11, '186.96.114.43', '2020-02-06 10:57:12', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'EDUAR'),
(12, '186.96.114.43', '2020-02-06 02:42:39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'EDUAR'),
(13, '186.96.114.43', '2020-02-06 02:42:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'EDUAR'),
(14, '186.96.114.43', '2020-02-06 03:21:17', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'EDUAR'),
(15, '186.96.114.43', '2020-02-06 03:37:22', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'ALEX'),
(16, '186.96.114.43', '2020-02-06 04:14:09', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'ALEX'),
(17, '186.96.114.43', '2020-02-06 04:18:33', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'ALEX'),
(18, '186.96.114.43', '2020-02-06 04:31:38', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'CAJERO'),
(19, '186.96.114.43', '2020-02-06 04:50:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'ALEX'),
(20, '186.96.114.43', '2020-02-06 06:04:35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'ALEX'),
(21, '186.96.114.43', '2020-02-08 02:06:01', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'ALEX'),
(22, '186.96.114.43', '2020-02-08 03:04:07', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'ALEX'),
(23, '191.109.75.95', '2020-02-10 07:54:00', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'ALEX'),
(24, '191.109.75.95', '2020-02-10 08:00:23', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', '/index.php', 'ALEX'),
(25, '186.96.114.43', '2020-02-29 01:24:50', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36', '/index.php', 'ADMIN'),
(26, '186.96.114.43', '2020-02-29 02:19:24', 'Mozilla/5.0 (Linux; Android 9; MRD-LX3 Build/HUAWEIMRD-LX3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/80.0.3987.119 Mobile Safari/537.36', '/index.php', 'ADMIN'),
(27, '186.96.114.43', '2020-02-29 02:34:01', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36', '/index.php', 'ADMIN'),
(28, '191.109.58.94', '2020-03-13 04:23:24', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36', '/index.php', 'ADMIN'),
(29, '191.109.58.94', '2020-03-13 05:12:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36', '/index.php', 'ADMIN'),
(30, '191.109.58.94', '2020-03-13 05:30:25', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36', '/index.php', 'VELSER'),
(31, '191.109.58.94', '2020-03-13 05:46:30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36', '/index.php', 'ADMIN'),
(32, '200.69.94.202', '2020-03-18 01:38:57', 'Mozilla/5.0 (Linux; Android 9; SM-A505G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Mobile Safari/537.36', '/index.php', 'ADMIN'),
(33, '186.116.188.142', '2020-04-27 08:30:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.122 Safari/537.36', '/index.php', 'ADMIN'),
(34, '181.67.74.213', '2020-04-27 08:32:07', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 LightSpeed [FBAN/MessengerLiteForiOS;FBAV/261.1.0.57.120;FBBV/210376599;FBDV/iPhone9,3;FBMD/iPhone;FBSN/iOS;FBSV/13.3.1;FBSS/2;FBCR/;FBID/phone;FBLC/es_PE;FBOP/0]', '/index.php', 'ADMIN'),
(35, '181.67.74.213', '2020-04-27 08:33:00', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 LightSpeed [FBAN/MessengerLiteForiOS;FBAV/261.1.0.57.120;FBBV/210376599;FBDV/iPhone9,3;FBMD/iPhone;FBSN/iOS;FBSV/13.3.1;FBSS/2;FBCR/;FBID/phone;FBLC/es_PE;FBOP/0]', '/index.php', 'ADMIN'),
(36, '181.67.74.213', '2020-04-27 08:46:13', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.122 Safari/537.36', '/index.php', 'ADMIN'),
(37, '190.167.64.113', '2020-04-27 09:10:07', 'Mozilla/5.0 (Linux; Android 7.1.1; Z971 Build/NMF26V; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/55.0.2883.91 Mobile Safari/537.36 [FB_IAB/Orca-Android;FBAV/260.0.0.22.122;]', '/index.php', 'ADMIN'),
(38, '186.116.191.52', '2020-05-02 09:05:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36', '/index.php', 'ADMIN'),
(39, '186.116.191.52', '2020-05-02 09:05:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36', '/index.php', 'ADMIN'),
(40, '186.116.191.52', '2020-05-02 09:05:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36', '/index.php', 'ADMIN'),
(41, '186.116.191.52', '2020-05-02 03:56:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36', '/index.php', 'ADMIN'),
(42, '186.116.191.52', '2020-05-02 04:17:55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36', '/index.php', 'ADMIN'),
(43, '186.116.191.52', '2020-05-02 04:31:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36', '/index.php', 'ADMIN'),
(44, '186.116.191.52', '2020-05-08 11:05:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '/index.php', 'ADMIN'),
(45, '186.116.191.52', '2020-05-08 09:23:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '/index.php', 'ADMIN'),
(46, '186.116.190.42', '2020-05-12 08:33:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '/index.php', 'ADMIN'),
(47, '191.109.61.108', '2020-05-12 11:50:46', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36 Edg/81.0.416.72', '/index.php', 'ADMIN'),
(48, '200.41.79.227', '2020-05-14 12:00:42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '/index.php', 'ADMIN'),
(49, '190.217.105.194', '2020-06-23 05:08:28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', '/index.php', 'ADMIN'),
(50, '190.217.105.194', '2020-06-23 05:09:05', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', '/index.php', 'ADMIN'),
(51, '186.116.188.253', '2020-06-27 03:18:41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(52, '190.217.105.194', '2020-07-01 12:38:29', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(53, '190.217.105.194', '2020-07-01 12:40:04', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(54, '190.217.105.194', '2020-07-07 12:35:08', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(55, '190.217.105.194', '2020-07-07 12:57:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(56, '190.217.105.194', '2020-07-07 12:59:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(57, '190.217.105.194', '2020-07-07 01:01:35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(58, '190.217.105.194', '2020-07-07 01:08:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'DEMO'),
(59, '190.217.105.194', '2020-07-07 01:09:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'DEMO'),
(60, '191.109.46.187', '2020-07-07 01:11:05', 'Mozilla/5.0 (Linux; Android 9; MRD-LX3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.117 Mobile Safari/537.36', '/index.php', 'DEMO'),
(61, '190.217.105.194', '2020-07-07 08:16:14', 'Mozilla/5.0 (Linux; Android 9; MRD-LX3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.117 Mobile Safari/537.36', '/index.php', 'DEMO'),
(62, '190.217.105.194', '2020-07-14 04:26:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(63, '190.217.105.194', '2020-07-14 04:27:27', 'Mozilla/5.0 (Windows NT 6.3; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(64, '190.217.105.194', '2020-07-14 04:27:27', 'Mozilla/5.0 (Windows NT 6.3; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(65, '190.217.105.194', '2020-07-15 10:16:21', 'Mozilla/5.0 (Windows NT 6.3; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(66, '190.217.105.194', '2020-07-15 10:16:21', 'Mozilla/5.0 (Windows NT 6.3; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(67, '190.217.105.194', '2020-07-15 10:16:21', 'Mozilla/5.0 (Windows NT 6.3; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(68, '190.217.105.194', '2020-07-15 10:18:22', 'Mozilla/5.0 (Windows NT 6.3; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(69, '190.217.105.194', '2020-07-15 10:50:20', 'Mozilla/5.0 (Windows NT 6.3; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(70, '190.217.105.194', '2020-07-15 12:37:02', 'Mozilla/5.0 (Windows NT 6.3; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(71, '190.217.105.194', '2020-07-16 05:22:36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(72, '190.217.105.194', '2020-07-16 05:59:54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36', '/index.php', 'ADMIN'),
(73, '190.90.22.6', '2020-08-04 10:33:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36', '/index.php', 'ADMIN'),
(74, '190.217.105.194', '2020-08-26 04:26:12', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(75, '190.217.105.194', '2020-08-26 05:05:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(76, '190.217.105.194', '2020-08-26 05:12:18', 'Mozilla/5.0 (Linux; Android 10; Redmi Note 9 Pro) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Mobile Safari/537.36', '/index.php', 'ADMIN'),
(77, '190.217.105.194', '2020-08-26 05:12:58', 'Mozilla/5.0 (Linux; Android 10; Redmi Note 9 Pro) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Mobile Safari/537.36', '/index.php', 'ADMIN'),
(78, '190.217.105.194', '2020-08-27 10:12:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(79, '190.217.105.194', '2020-08-27 10:13:41', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(80, '190.217.105.194', '2020-08-27 10:13:43', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(81, '186.169.153.99', '2020-08-27 10:58:36', 'Mozilla/5.0 (Linux; Android 9; moto g(6) plus) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Mobile Safari/537.36', '/index.php', 'ADMIN'),
(82, '190.217.105.194', '2020-08-27 03:55:52', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(83, '190.217.105.194', '2020-08-27 03:55:54', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(84, '190.217.105.194', '2020-08-27 03:55:54', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(85, '190.217.105.194', '2020-08-27 03:55:55', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(86, '190.217.105.194', '2020-08-27 03:55:55', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(87, '190.217.105.194', '2020-08-27 03:55:55', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(88, '190.217.105.194', '2020-08-27 04:47:57', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(89, '190.217.105.194', '2020-08-27 04:47:58', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(90, '190.217.105.194', '2020-08-27 04:47:58', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(91, '190.217.105.194', '2020-08-28 10:00:54', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36', '/index.php', 'ADMIN'),
(92, '190.217.105.194', '2020-08-28 10:14:07', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(93, '190.217.105.194', '2020-08-28 11:19:08', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36', '/index.php', 'ADMIN'),
(94, '190.217.105.194', '2020-08-28 12:02:37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', '/index.php', 'ADMIN'),
(95, '190.217.105.194', '2020-08-28 05:13:25', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36', '/index.php', 'ADMIN'),
(96, '190.217.105.194', '2020-08-28 06:15:41', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36', '/index.php', 'ADMIN'),
(97, '190.217.105.194', '2020-08-31 09:42:51', 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36', '/index.php', 'ADMIN'),
(98, '190.217.105.194', '2020-09-03 04:33:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36', '/index.php', 'DEMO'),
(99, '190.217.105.194', '2020-09-03 04:33:57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36', '/index.php', 'DEMO'),
(100, '190.217.105.194', '2020-09-03 04:37:08', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36', '/index.php', 'DEMO'),
(101, '190.217.105.194', '2020-09-03 04:38:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.83 Safari/537.36', '/index.php', 'ADMIN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medidas`
--

CREATE TABLE `medidas` (
  `codmedida` int(11) NOT NULL,
  `nommedida` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `medidas`
--

INSERT INTO `medidas` (`codmedida`, `nommedida`) VALUES
(1, 'KILOGRAMO'),
(2, 'LITRO'),
(3, 'GRAMO'),
(4, 'UNIDAD'),
(5, 'PORCION');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mediospagos`
--

CREATE TABLE `mediospagos` (
  `codmediopago` int(11) NOT NULL,
  `mediopago` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `mediospagos`
--

INSERT INTO `mediospagos` (`codmediopago`, `mediopago`) VALUES
(1, 'EFECTIVO'),
(2, 'CHEQUE A FECHA'),
(3, 'CHEQUE AL DIA'),
(4, 'NOTA DE CREDITO'),
(5, 'RED COMPRA'),
(6, 'TRANSFERENCIA'),
(7, 'TARJETA DE CREDITO'),
(8, 'CUPON');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `codmesa` int(11) NOT NULL,
  `codsala` int(11) NOT NULL,
  `nommesa` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `statusmesa` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`codmesa`, `codsala`, `nommesa`, `fecha`, `statusmesa`) VALUES
(11, 1, 'MESA 1', '2020-02-06', 0),
(12, 1, 'MESA 2', '2020-02-06', 0),
(13, 1, 'MESA 3', '2020-02-06', 0),
(14, 1, 'MESA 4', '2020-02-06', 0),
(15, 1, 'MESA 5', '2020-02-06', 0),
(16, 1, 'MESA 6', '2020-02-06', 1),
(17, 1, 'MESA 7', '2020-02-06', 0),
(18, 1, 'MESA 8', '2020-02-06', 0),
(19, 1, 'MESA 9', '2020-02-06', 0),
(20, 1, 'MESA 10', '2020-02-06', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientoscajas`
--

CREATE TABLE `movimientoscajas` (
  `codmovimiento` int(11) NOT NULL,
  `codcaja` int(11) NOT NULL,
  `tipomovimiento` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcionmovimiento` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montomovimiento` decimal(12,2) NOT NULL,
  `codmediopago` int(11) NOT NULL,
  `fechamovimiento` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `movimientoscajas`
--

INSERT INTO `movimientoscajas` (`codmovimiento`, `codcaja`, `tipomovimiento`, `descripcionmovimiento`, `montomovimiento`, `codmediopago`, `fechamovimiento`) VALUES
(1, 6, 'EGRESO', 'XXX', '1000.00', 1, '2020-02-06 03:32:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcategoria` int(11) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `existencia` decimal(12,2) NOT NULL,
  `stockminimo` decimal(12,2) NOT NULL,
  `stockmaximo` decimal(12,2) NOT NULL,
  `ivaproducto` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `codigobarra` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `lote` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaelaboracion` date NOT NULL,
  `fechaexpiracion` date NOT NULL,
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `stockteorico` int(10) NOT NULL,
  `motivoajuste` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `favorito` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idproducto`, `codproducto`, `producto`, `codcategoria`, `preciocompra`, `precioventa`, `existencia`, `stockminimo`, `stockmaximo`, `ivaproducto`, `descproducto`, `codigobarra`, `lote`, `fechaelaboracion`, `fechaexpiracion`, `codproveedor`, `stockteorico`, `motivoajuste`, `favorito`) VALUES
(3, '03', 'COCACOLA', 2, '1300.00', '2000.00', '0.00', '5.00', '50.00', 'NO', '0.00', '003', '0033', '2020-02-05', '2020-03-31', 'P1', 0, 'NINGUNO', 0),
(6, '04', 'JUGO HIT', 2, '1300.00', '2000.00', '18.00', '8.00', '100.00', 'NO', '0.00', '004', '0044', '2020-02-06', '2020-02-29', 'P1', 0, 'NINGUNO', 0),
(5, '05', 'BOLSAS ', 1, '100.00', '100.00', '100.00', '20.00', '300.00', 'NO', '0.00', '005', '0055', '2020-02-05', '2020-02-29', 'P1', 0, 'NINGUNO', 0),
(7, '001', 'ALMUERZO CORRIENTE', 4, '6000.00', '7900.00', '99.00', '10.00', '200.00', 'NO', '0.00', '0', '0', '2020-02-03', '2020-02-08', 'P1', 0, 'NINGUNO', 0),
(8, '002', 'CON CARNE GUISADA', 4, '6000.00', '7900.00', '99.00', '10.00', '200.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', 'P1', 0, 'NINGUNO', 0),
(9, '003', 'CON POLLO', 1, '6000.00', '9000.00', '100.00', '10.00', '300.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', 'P1', 0, 'NINGUNO', 0),
(10, '004', 'POLLO ASADO', 4, '7000.00', '8000.00', '198.00', '20.00', '400.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', 'P1', 0, 'NINGUNO', 0),
(11, '005', 'HAMBURGUESA', 3, '6000.00', '8000.00', '79.00', '10.00', '400.00', 'SI', '0.00', '0', '0', '0000-00-00', '0000-00-00', 'P1', 0, 'NINGUNO', 0),
(12, '0043', 'PAPITAS FRITAS', 3, '2000.00', '2500.00', '51.00', '10.00', '50.00', 'NO', '2.00', '0', '0', '0000-00-00', '0000-00-00', 'P2', 0, 'NINGUNO', 0),
(13, '0013', 'ALITAS BBQ', 3, '7000.00', '9000.00', '100.00', '10.00', '100.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', 'P2', 0, 'NINGUNO', 0),
(14, '0016', 'PICADA', 4, '12000.00', '15000.00', '1000.00', '10.00', '100.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', 'P2', 0, 'NINGUNO', 0),
(15, '0020', 'ROSADA', 1, '400.00', '600.00', '1000.00', '10.00', '100.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', 'P2', 0, 'NINGUNO', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosxingredientes`
--

CREATE TABLE `productosxingredientes` (
  `codagrega` int(11) NOT NULL,
  `codproducto` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codingrediente` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantracion` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idproveedor` int(11) NOT NULL,
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `documproveedor` int(11) NOT NULL,
  `cuitproveedor` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nomproveedor` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tlfproveedor` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_provincia` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `direcproveedor` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `emailproveedor` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `vendedor` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tlfvendedor` varchar(20) CHARACTER SET utf32 COLLATE utf32_spanish_ci NOT NULL,
  `fechaingreso` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`idproveedor`, `codproveedor`, `documproveedor`, `cuitproveedor`, `nomproveedor`, `tlfproveedor`, `id_provincia`, `id_departamento`, `direcproveedor`, `emailproveedor`, `vendedor`, `tlfvendedor`, `fechaingreso`) VALUES
(1, 'P1', 18, '1091658551', 'PERRO LOCO', '(0000', 1, 0, 'XXX', 'XXX@GMAIL.COM', 'X', '() ', '2019-11-29'),
(2, 'P2', 18, '12323546465423', 'GARCIA ', '(3245) 678', 1, 0, 'LA QUINTA', 'NOSESABE@HOTMAIL.COM', 'MENDEZ', '(3124) 561', '2020-02-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE `provincias` (
  `id_provincia` int(10) NOT NULL,
  `provincia` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id_provincia`, `provincia`) VALUES
(1, 'norte de santander');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salas`
--

CREATE TABLE `salas` (
  `codsala` int(11) NOT NULL,
  `nomsala` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `salas`
--

INSERT INTO `salas` (`codsala`, `nomsala`, `fecha`) VALUES
(1, 'SALA UNO', '2020-02-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposcambio`
--

CREATE TABLE `tiposcambio` (
  `codcambio` int(11) NOT NULL,
  `descripcioncambio` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montocambio` decimal(12,3) NOT NULL,
  `codmoneda` int(11) NOT NULL,
  `fechacambio` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tiposcambio`
--

INSERT INTO `tiposcambio` (`codcambio`, `descripcioncambio`, `montocambio`, `codmoneda`, `fechacambio`) VALUES
(1, 'DOLAR PAGINA', '20600.000', 1, '2019-09-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposmoneda`
--

CREATE TABLE `tiposmoneda` (
  `codmoneda` int(11) NOT NULL,
  `moneda` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `siglas` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `simbolo` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tiposmoneda`
--

INSERT INTO `tiposmoneda` (`codmoneda`, `moneda`, `siglas`, `simbolo`) VALUES
(1, 'US DOLLAR', 'USD', '$'),
(2, 'EURO', 'EUR', '&euro;'),
(3, 'PESO CHILENO', 'CLP', '$'),
(4, 'DOLAR CANADIENSE', 'CAD', '$'),
(5, 'QUETZAL', 'GTQ', 'Q'),
(6, 'DOLAR BELIZE', 'BZD', 'B'),
(7, 'SOLES', 'SOL', 'S/.'),
(8, 'BOLIVAR SOBERANO', 'BS', 'BS. '),
(9, 'BOLIVIANOS', 'BS', 'BS'),
(10, 'PESO', '$', '$');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `codigo` int(11) NOT NULL,
  `dni` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombres` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `sexo` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `password` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nivel` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status` int(2) NOT NULL,
  `comision` float(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`codigo`, `dni`, `nombres`, `sexo`, `direccion`, `telefono`, `email`, `usuario`, `password`, `nivel`, `status`, `comision`) VALUES
(1, '109165851', 'eduar', '1', 'molino', '3157690579', 'leosanchez_19@hotmsil.com', 'ADMIN', 'ADMIN', 'ADMINISTRADOR(A)', 1, 0.00),
(4, '1091658551', 'ADMIN', 'MASCULINO', 'OCA&Ntilde;A', '3157690579', 'LEOSANCHEZ_19@HOTMAIL.COM', 'DEMO', '1091658551', 'COCINERO(A)', 1, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `idventa` int(11) NOT NULL,
  `codpedido` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmesa` int(11) NOT NULL,
  `tipodocumento` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcaja` int(11) NOT NULL,
  `codventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codserie` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codautorizacion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasi` decimal(12,2) NOT NULL,
  `subtotalivano` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL,
  `totaldescuento` decimal(12,2) NOT NULL,
  `totalpago` decimal(12,2) NOT NULL,
  `totalpago2` decimal(12,2) NOT NULL,
  `tipopago` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `formapago` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montopagado` decimal(12,2) NOT NULL,
  `montodevuelto` decimal(12,2) NOT NULL,
  `fechavencecredito` date NOT NULL,
  `fechapagado` date NOT NULL,
  `statusventa` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `statuspago` int(2) NOT NULL,
  `fechaventa` datetime NOT NULL,
  `delivery` int(2) NOT NULL,
  `repartidor` int(11) NOT NULL,
  `entregado` int(2) NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  `bandera` int(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`idventa`, `codpedido`, `codmesa`, `tipodocumento`, `codcaja`, `codventa`, `codserie`, `codautorizacion`, `codcliente`, `subtotalivasi`, `subtotalivano`, `iva`, `totaliva`, `descuento`, `totaldescuento`, `totalpago`, `totalpago2`, `tipopago`, `formapago`, `montopagado`, `montodevuelto`, `fechavencecredito`, `fechapagado`, `statusventa`, `statuspago`, `fechaventa`, `delivery`, `repartidor`, `entregado`, `observaciones`, `codigo`, `bandera`) VALUES
(42, 'P1', 14, 'TICKET', 6, '0001-001-HASTA 500', '0001', '1134057955066498443773695053099212628313929669414', '0', '0.00', '4000.00', '19.00', '0.00', '0.00', '0.00', '4000.00', '2600.00', 'CONTADO', '1', '4000.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-02-06 04:26:39', 0, 0, 0, '0', 1, 1),
(43, 'P2', 14, 'TICKET', 1, '0001-0000000000026', '0001', '7154670212432472684681300930558263721752005243402', '0', '0.00', '8000.00', '19.00', '0.00', '0.00', '0.00', '8000.00', '5200.00', 'CONTADO', '1', '8000.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-02-06 04:36:09', 0, 0, 0, '0', 1, 26),
(44, 'P3', 16, '0', 0, '0', '0', '0', '0', '8000.00', '12000.00', '19.00', '1520.00', '0.00', '0.00', '21520.00', '15600.00', '0', '0', '0.00', '0.00', '0000-00-00', '0000-00-00', '0', 1, '2020-02-06 06:05:30', 0, 0, 0, '0', 1, 0),
(45, 'P4', 15, 'TICKET', 1, '0001-0000000000017', '0001', '2523555752756786117867732944899042407083258936547', '0', '8000.00', '9900.00', '19.00', '1520.00', '0.00', '0.00', '19420.00', '13300.00', 'CONTADO', '1', '19420.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-02-06 06:24:46', 0, 0, 0, '0', 1, 17),
(46, 'P5', 12, 'FACTURA', 1, '0001-0000000000021', '0001', '1792915670372445565275546039973152344802930284741', '0', '0.00', '12350.00', '19.00', '0.00', '0.00', '0.00', '12350.00', '9300.00', 'CONTADO', '1', '20000.00', '7650.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-02-06 06:34:11', 0, 0, 0, '0', 1, 21),
(47, 'P6', 11, 'TICKET', 1, '0001-0000000000002', '0001', '4070124319664345071692040042910427530071048572080', '0', '8000.00', '6000.00', '19.00', '1520.00', '0.00', '0.00', '15520.00', '9900.00', 'CONTADO', '1', '15520.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-02-29 02:20:24', 0, 0, 0, '0', 1, 2),
(48, 'P7', 11, 'TICKET', 1, '0001-0000000000003', '0001', '6750762974959663257205485472409075151358744701136', '0', '0.00', '4000.00', '19.00', '0.00', '0.00', '0.00', '4000.00', '2600.00', 'CONTADO', '1', '10000.00', '6000.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-02-29 02:35:08', 0, 0, 0, '0', 1, 3),
(49, 'P8', 11, 'TICKET', 1, '0001-0000000000004', '0001', '5100696130590165245750050172764375444158107224749', '0', '8000.00', '2000.00', '19.00', '1520.00', '0.00', '0.00', '11520.00', '7300.00', 'CONTADO', '1', '20000.00', '8480.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-03-13 05:14:14', 0, 0, 0, '0', 1, 4),
(50, 'P9', 0, 'TICKET', 1, '0001-0000000000005', '0001', '9406642134526850941128977911923963527841303988983', 'C2', '16000.00', '8000.00', '19.00', '3040.00', '0.00', '0.00', '27040.00', '17200.00', 'CONTADO', '1', '30000.00', '2960.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-03-13 05:29:54', 1, 3, 1, '0', 1, 5),
(51, 'P10', 11, 'TICKET', 1, '0001-0000000000008', '0001', '2082866876113443993892722900105304680267979313613', '0', '8000.00', '2000.00', '19.00', '1520.00', '0.00', '0.00', '11520.00', '7300.00', 'CONTADO', '1', '20000.00', '8480.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-03-13 05:49:12', 0, 0, 0, '0', 1, 8),
(52, 'P11', 11, 'TICKET', 1, '0001-0000000000009', '0001', '1836368080645924318279843929307581117015180672113', '0', '16000.00', '4000.00', '19.00', '3040.00', '0.00', '0.00', '23040.00', '14600.00', 'CONTADO', '1', '23040.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-03-18 01:40:45', 0, 0, 0, '0', 1, 9),
(53, 'P12', 11, 'TICKET', 1, '0001-0000000000010', '0001', '8913674014941302889535611514579370738149644874162', '0', '0.00', '2000.00', '19.00', '0.00', '0.00', '0.00', '2000.00', '1300.00', 'CONTADO', '1', '2000.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-04-27 08:33:49', 0, 0, 0, '0', 1, 10),
(54, 'P13', 11, 'FACTURA', 1, '0001-0000000000011', '0001', '9846075345483487549379380248716791408933582830595', 'C3', '8000.00', '2000.00', '19.00', '1520.00', '0.00', '0.00', '11520.00', '7300.00', 'CONTADO', '1', '12000.00', '480.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-04-27 08:48:59', 0, 0, 0, '0', 1, 11),
(55, 'P14', 11, 'TICKET', 1, '0001-0000000000012', '0001', '6074415644197644782439307546741358899464873548926', '0', '0.00', '2000.00', '19.00', '0.00', '0.00', '0.00', '2000.00', '1300.00', 'CONTADO', '1', '2000.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-05-08 09:23:54', 0, 0, 0, '0', 1, 12),
(56, 'P15', 11, 'FACTURA', 1, '0001-0000000000018', '0001', '6051925711812848449241413350260875077549631925769', '0', '0.00', '4000.00', '19.00', '0.00', '0.00', '0.00', '4000.00', '2600.00', 'CONTADO', '1', '4000.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-05-12 08:34:08', 0, 0, 0, '0', 1, 18),
(57, 'P16', 13, 'TICKET', 1, '0001-0000000000013', '0001', '7752554847459760298832103689518284549924779656785', '0', '0.00', '12000.00', '19.00', '0.00', '0.00', '0.00', '12000.00', '9600.00', 'CONTADO', '1', '20000.00', '8000.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-05-14 12:01:13', 0, 0, 0, '0', 1, 13),
(58, 'P17', 0, 'TICKET', 1, '0001-0000000000014', '0001', '6036102234651101377952853363950663273597963074211', '0', '0.00', '4000.00', '19.00', '0.00', '0.00', '0.00', '4000.00', '2600.00', 'CONTADO', '1', '4000.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-05-14 12:06:55', 1, 3, 1, 'VUELTOS PARA 50', 1, 14),
(59, 'P18', 13, 'TICKET', 1, '0001-0000000000015', '0001', '5496787565040897182076915947122762341197692782591', '0', '16000.00', '4000.00', '19.00', '3040.00', '0.00', '0.00', '23040.00', '14600.00', 'CONTADO', '1', '23040.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-07-07 12:37:55', 0, 0, 0, '0', 1, 15),
(60, 'P19', 0, 'TICKET', 1, '0001-0000000000016', '0001', '5291083651639231220594888896583112321697860784906', '0', '8000.00', '2000.00', '19.00', '1520.00', '0.00', '0.00', '11520.00', '7300.00', 'CONTADO', '1', '11520.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-07-07 12:56:23', 1, 0, 0, '0', 1, 16),
(61, 'P20', 13, 'TICKET', 1, '0001-0000000000019', '0001', '1426994405455527293249207968523775474815451913742', '0', '16000.00', '2000.00', '19.00', '3040.00', '0.00', '0.00', '21040.00', '13300.00', 'CONTADO', '1', '50000.00', '28960.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-07-15 12:38:09', 0, 0, 0, '0', 1, 19),
(62, 'P21', 11, 'TICKET', 1, '0001-0000000000020', '0001', '3810937931202744560757438932227619613416646911377', '0', '8000.00', '6450.00', '19.00', '1520.00', '0.00', '0.00', '15970.00', '10600.00', 'CONTADO', '1', '20000.00', '4030.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-08-26 05:07:10', 0, 0, 0, '0', 1, 20),
(63, 'P22', 11, 'TICKET', 1, '0001-0000000000022', '0001', '5411124672289163914321107515975417629097216223625', 'C1', '16000.00', '4000.00', '19.00', '3040.00', '0.00', '0.00', '23040.00', '14600.00', 'CONTADO', '1', '23040.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-08-27 10:30:51', 0, 0, 0, '0', 1, 22),
(64, 'P23', 0, 'TICKET', 1, '0001-0000000000023', '0001', '5124682951823490134287114100356869327523715154168', 'C1', '8000.00', '2450.00', '19.00', '1520.00', '0.00', '0.00', '11970.00', '8000.00', 'CONTADO', '1', '50000.00', '38030.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-08-27 10:37:02', 1, 0, 0, 'SENA', 1, 23),
(65, 'P24', 11, 'TICKET', 1, '0001-0000000000024', '0001', '9985615511099501216608653446737735397859059019130', '0', '8000.00', '2000.00', '19.00', '1520.00', '0.00', '0.00', '11520.00', '7300.00', 'CONTADO', '1', '11520.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-08-28 10:13:05', 0, 0, 0, '0', 1, 24),
(66, 'P25', 0, 'TICKET', 1, '0001-0000000000025', '0001', '0229314967393376888832755126743775707104943271850', 'C1', '8000.00', '4450.00', '19.00', '1520.00', '0.00', '0.00', '13970.00', '9300.00', 'CONTADO', '1', '13970.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', 0, '2020-08-28 11:28:08', 1, 0, 0, '0', 1, 25);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abonoscreditos`
--
ALTER TABLE `abonoscreditos`
  ADD PRIMARY KEY (`codabono`);

--
-- Indices de la tabla `arqueocaja`
--
ALTER TABLE `arqueocaja`
  ADD PRIMARY KEY (`codarqueo`);

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`codcaja`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`codcategoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`idcompra`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `creditosxclientes`
--
ALTER TABLE `creditosxclientes`
  ADD PRIMARY KEY (`codcredito`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `detallecompras`
--
ALTER TABLE `detallecompras`
  ADD PRIMARY KEY (`coddetallecompra`);

--
-- Indices de la tabla `detallepedidos`
--
ALTER TABLE `detallepedidos`
  ADD PRIMARY KEY (`coddetallepedido`);

--
-- Indices de la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
  ADD PRIMARY KEY (`coddetalleventa`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`coddocumento`);

--
-- Indices de la tabla `impuestos`
--
ALTER TABLE `impuestos`
  ADD PRIMARY KEY (`codimpuesto`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`idingrediente`);

--
-- Indices de la tabla `kardex_ingredientes`
--
ALTER TABLE `kardex_ingredientes`
  ADD PRIMARY KEY (`codkardex`);

--
-- Indices de la tabla `kardex_productos`
--
ALTER TABLE `kardex_productos`
  ADD PRIMARY KEY (`codkardex`);

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medidas`
--
ALTER TABLE `medidas`
  ADD PRIMARY KEY (`codmedida`);

--
-- Indices de la tabla `mediospagos`
--
ALTER TABLE `mediospagos`
  ADD PRIMARY KEY (`codmediopago`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`codmesa`);

--
-- Indices de la tabla `movimientoscajas`
--
ALTER TABLE `movimientoscajas`
  ADD PRIMARY KEY (`codmovimiento`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`);

--
-- Indices de la tabla `productosxingredientes`
--
ALTER TABLE `productosxingredientes`
  ADD PRIMARY KEY (`codagrega`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idproveedor`);

--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`id_provincia`);

--
-- Indices de la tabla `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`codsala`);

--
-- Indices de la tabla `tiposcambio`
--
ALTER TABLE `tiposcambio`
  ADD PRIMARY KEY (`codcambio`);

--
-- Indices de la tabla `tiposmoneda`
--
ALTER TABLE `tiposmoneda`
  ADD PRIMARY KEY (`codmoneda`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idventa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abonoscreditos`
--
ALTER TABLE `abonoscreditos`
  MODIFY `codabono` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `arqueocaja`
--
ALTER TABLE `arqueocaja`
  MODIFY `codarqueo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `codcaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `codcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `idcompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `creditosxclientes`
--
ALTER TABLE `creditosxclientes`
  MODIFY `codcredito` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detallecompras`
--
ALTER TABLE `detallecompras`
  MODIFY `coddetallecompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detallepedidos`
--
ALTER TABLE `detallepedidos`
  MODIFY `coddetallepedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
  MODIFY `coddetalleventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `coddocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `impuestos`
--
ALTER TABLE `impuestos`
  MODIFY `codimpuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `idingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `kardex_ingredientes`
--
ALTER TABLE `kardex_ingredientes`
  MODIFY `codkardex` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `kardex_productos`
--
ALTER TABLE `kardex_productos`
  MODIFY `codkardex` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `medidas`
--
ALTER TABLE `medidas`
  MODIFY `codmedida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `mediospagos`
--
ALTER TABLE `mediospagos`
  MODIFY `codmediopago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `codmesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `movimientoscajas`
--
ALTER TABLE `movimientoscajas`
  MODIFY `codmovimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `productosxingredientes`
--
ALTER TABLE `productosxingredientes`
  MODIFY `codagrega` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `provincias`
--
ALTER TABLE `provincias`
  MODIFY `id_provincia` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `salas`
--
ALTER TABLE `salas`
  MODIFY `codsala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tiposcambio`
--
ALTER TABLE `tiposcambio`
  MODIFY `codcambio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tiposmoneda`
--
ALTER TABLE `tiposmoneda`
  MODIFY `codmoneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
