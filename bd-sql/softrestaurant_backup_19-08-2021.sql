# +===================================================================
# | Generado el 19-08-2021 a las 01:03:14 
# | Servidor: localhost
# | MySQL Version: 5.5.5-10.4.16-MariaDB
# | PHP Version: 7.4.12
# | Base de datos: 'softrestaurant'
# | Tablas: abonoscreditos;  arqueocaja;  cajas;  categorias;  clientes;  combos;  combosxproductos;  compras;  configuracion;  cotizaciones;  creditosxclientes;  departamentos;  detallecompras;  detallecotizaciones;  detallenotas;  detallepedidos;  detalleventas;  documentos;  impuestos;  ingredientes;  kardex_combos;  kardex_ingredientes;  kardex_productos;  log;  medidas;  mesas;  movimientoscajas;  notascredito;  productos;  productosxingredientes;  proveedores;  provincias;  salas;  tiposcambio;  tiposmoneda;  usuarios;  ventas
# +-------------------------------------------------------------------
# Si tienen tablas con relacion y no estan en orden dara problemas al recuperar datos. Para evitarlo:
SET FOREIGN_KEY_CHECKS=0; 
SET time_zone = '+00:00';
SET sql_mode = ''; 


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

# | Vaciado de tabla 'abonoscreditos'
# +-------------------------------------
DROP TABLE IF EXISTS `abonoscreditos`;


# | Estructura de la tabla 'abonoscreditos'
# +-------------------------------------
CREATE TABLE `abonoscreditos` (
  `codabono` int(11) NOT NULL AUTO_INCREMENT,
  `codcaja` int(11) NOT NULL,
  `codventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montoabono` decimal(12,2) NOT NULL,
  `formaabono` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaabono` datetime NOT NULL,
  PRIMARY KEY (`codabono`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'abonoscreditos'
# +-------------------------------------

# | Vaciado de tabla 'arqueocaja'
# +-------------------------------------
DROP TABLE IF EXISTS `arqueocaja`;


# | Estructura de la tabla 'arqueocaja'
# +-------------------------------------
CREATE TABLE `arqueocaja` (
  `codarqueo` int(11) NOT NULL AUTO_INCREMENT,
  `codcaja` int(11) NOT NULL,
  `montoinicial` decimal(12,2) NOT NULL,
  `efectivo` decimal(12,2) NOT NULL,
  `cheque` decimal(12,2) NOT NULL,
  `tcredito` decimal(12,2) NOT NULL,
  `tdebito` decimal(12,2) NOT NULL,
  `tprepago` decimal(12,2) NOT NULL,
  `transferencia` decimal(12,2) NOT NULL,
  `electronico` decimal(12,2) NOT NULL,
  `cupon` decimal(12,2) NOT NULL,
  `otros` decimal(12,2) NOT NULL,
  `creditos` decimal(12,2) NOT NULL,
  `abonosefectivo` decimal(12,2) NOT NULL,
  `abonosotros` decimal(12,2) NOT NULL,
  `propinasefectivo` decimal(12,2) NOT NULL,
  `propinasotros` decimal(12,2) NOT NULL,
  `ingresosefectivo` decimal(12,2) NOT NULL,
  `ingresosotros` decimal(12,2) NOT NULL,
  `egresos` decimal(12,2) NOT NULL,
  `egresonotas` decimal(12,2) NOT NULL,
  `nroticket` int(5) NOT NULL,
  `nroboleta` int(5) NOT NULL,
  `nrofactura` int(5) NOT NULL,
  `nronota` int(5) NOT NULL,
  `dineroefectivo` decimal(12,2) NOT NULL,
  `diferencia` decimal(12,2) NOT NULL,
  `comentarios` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaapertura` datetime NOT NULL,
  `fechacierre` datetime NOT NULL,
  `statusarqueo` int(2) NOT NULL,
  PRIMARY KEY (`codarqueo`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'arqueocaja'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `arqueocaja` (`codarqueo`, `codcaja`, `montoinicial`, `efectivo`, `cheque`, `tcredito`, `tdebito`, `tprepago`, `transferencia`, `electronico`, `cupon`, `otros`, `creditos`, `abonosefectivo`, `abonosotros`, `propinasefectivo`, `propinasotros`, `ingresosefectivo`, `ingresosotros`, `egresos`, `egresonotas`, `nroticket`, `nroboleta`, `nrofactura`, `nronota`, `dineroefectivo`, `diferencia`, `comentarios`, `fechaapertura`, `fechacierre`, `statusarqueo`) VALUES 
      ('1', '1', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0.00', '0.00', 'NINGUNO', '2021-08-19 01:03:07', '0000-00-00 00:00:00', '1');
COMMIT;

# | Vaciado de tabla 'cajas'
# +-------------------------------------
DROP TABLE IF EXISTS `cajas`;


# | Estructura de la tabla 'cajas'
# +-------------------------------------
CREATE TABLE `cajas` (
  `codcaja` int(11) NOT NULL AUTO_INCREMENT,
  `nrocaja` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nomcaja` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  PRIMARY KEY (`codcaja`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'cajas'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `cajas` (`codcaja`, `nrocaja`, `nomcaja`, `codigo`) VALUES 
      ('1', '001', 'CAJA PRINCIPAL', '1'), 
      ('2', '002', 'CAJA SECUNDARIA', '3');
COMMIT;

# | Vaciado de tabla 'categorias'
# +-------------------------------------
DROP TABLE IF EXISTS `categorias`;


# | Estructura de la tabla 'categorias'
# +-------------------------------------
CREATE TABLE `categorias` (
  `codcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nomcategoria` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`codcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'categorias'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `categorias` (`codcategoria`, `nomcategoria`) VALUES 
      ('1', 'ASADOS'), 
      ('2', 'SUIZOS'), 
      ('3', 'SALCHIPAPAS'), 
      ('4', 'PICADAS'), 
      ('5', 'MAIZ DESGRANADOS'), 
      ('6', 'HAMBURGUESAS'), 
      ('7', 'CHUZOS DESGRANADOS'), 
      ('8', 'PERROS'), 
      ('9', 'PATACONES'), 
      ('10', 'BEBIDAS'), 
      ('11', 'ADICIONALES');
COMMIT;

# | Vaciado de tabla 'clientes'
# +-------------------------------------
DROP TABLE IF EXISTS `clientes`;


# | Estructura de la tabla 'clientes'
# +-------------------------------------
CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipocliente` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `documcliente` int(11) NOT NULL,
  `dnicliente` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomcliente` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `razoncliente` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `girocliente` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tlfcliente` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_provincia` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `direccliente` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `emailcliente` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `limitecredito` float(12,2) NOT NULL,
  `fechaingreso` date NOT NULL,
  PRIMARY KEY (`idcliente`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'clientes'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `clientes` (`idcliente`, `codcliente`, `tipocliente`, `documcliente`, `dnicliente`, `nomcliente`, `razoncliente`, `girocliente`, `tlfcliente`, `id_provincia`, `id_departamento`, `direccliente`, `emailcliente`, `limitecredito`, `fechaingreso`) VALUES 
      ('1', 'C1', 'JURIDICO', '1', '15885748', '', 'ACCESORIOS RUBENCH. SAA', 'VENTAS DE ACCESORIOS INFORMATICOS', '', '0', '0', 'SANTA CRUZ D EMORA', '', '0.00', '2019-09-09'), 
      ('2', 'C2', 'NATURAL', '16', '10471723', 'VICTOR LOVERA ', '', '', '(0414) 0073940', '0', '0', 'VISTA ALEGRE EL LLANO TOVAR ', '', '0.00', '2019-09-11'), 
      ('3', 'C3', 'NATURAL', '16', '16604603', 'RONAL DAVILA', '', '', '(0412) 7914045', '0', '0', 'SANTA CRUZ DE MORA ', '', '0.00', '2019-09-11'), 
      ('4', 'C4', 'NATURAL', '16', '10901301', 'ZAIDA MARINA MONTOYA GUILLEN ', '', '', '', '0', '0', 'VISTA ALEGRE EL LLANO TOVAR ', '', '0.00', '2019-09-13'), 
      ('5', 'C5', 'NATURAL', '16', '8709182', 'CARNICERIA Y TRANSPORTE LA CANA BRAVA ', '', '', '', '0', '0', 'LA PLAYA BAILADORES ESTADO MERIDA ', '', '0.00', '2019-09-13'), 
      ('6', 'C6', 'NATURAL', '16', '8712928', 'INVERSIONES JOZLIRA DE JOSE ANGEL ROA ZAMBRANO ', '', '', '', '0', '0', 'CALLE PRINCIPAL DE VISTA ALEGRE EL LLANO TOVAR', '', '0.00', '2019-09-13'), 
      ('7', 'C7', 'NATURAL', '16', '8714909', 'HAMBURGUESERIA VISTA ALEGRE', '', '', '', '0', '0', 'VISTA ALEGRE EL LLANO TOVAR AL LADO DE BODEGA JAIMARY ', '', '0.00', '2019-09-13'), 
      ('8', 'C8', 'NATURAL', '16', '12048555', 'DISTRIBUIDORA DUALMAR ', '', '', '', '0', '0', 'EL LLANO TOVAR ESTADO MERIDA ', '', '0.00', '2019-09-13'), 
      ('9', 'C9', 'NATURAL', '16', '10900155', 'CONFITERIA YOHANA ', '', '', '(0414) 7486145', '0', '0', 'EL TERMINAL TOVAR ESTADO MERIDA ', '', '0.00', '2019-09-13'), 
      ('10', 'C10', 'NATURAL', '16', '20218518', 'NORMAN GUERRERO LUGO ', '', '', '(0414) 3753387', '0', '0', 'ESQUINA CARRERA 2 CON CALLE 4 ', '', '0.00', '2019-09-13'), 
      ('11', 'C11', 'NATURAL', '16', '16316704', 'MANUEL EPIFANIO MONTALVO', '', '', '(0424) 7725918', '0', '0', 'ZEA ESTADO MERIDA ', '', '0.00', '2019-09-16'), 
      ('12', 'C12', 'NATURAL', '16', '13092019', 'EVENTO ESTANQUES ', '', '', '', '0', '0', 'TOVAR MERIDA ', '', '0.00', '2019-09-16'), 
      ('13', 'C13', 'NATURAL', '16', '9198626', 'RAMONA MOLINA ', '', '', '', '0', '0', 'MERCADO MUNICIPAL TOVAR MERIDA ', '', '0.00', '2019-09-16'), 
      ('14', 'C14', 'NATURAL', '16', '19486261', 'COMERCIALIZADORA LAS PALMAS ', '', '', '', '0', '0', 'AV CRISTOBAL MENDOZA TOVAR ESTADO MERIDA ', '', '0.00', '2019-09-16'), 
      ('15', 'C15', 'NATURAL', '16', '124860853', 'PANADERIA MAHYLEN DE ALEXANDER MONTES ', '', '', '', '0', '0', 'SANTA CRUZ DE MORA SECTOR PUERTO RICO ', '', '0.00', '2019-09-17'), 
      ('16', 'C16', 'NATURAL', '16', '11111111', 'DENILSON ', '', '', '', '0', '0', 'CARRERA 4TA PASOS ARRIBA DEL HOSPITAL ', '', '0.00', '2019-09-17'), 
      ('17', 'C17', 'NATURAL', '16', '20301662', 'YERALDIN', '', '', '', '0', '0', 'LA PLAYA BAILADORES ', '', '0.00', '2019-09-17'), 
      ('18', 'C18', 'NATURAL', '16', '194867650', 'INVERSIONES EL MININO DE RIGOBERTOPEREIRA ', '', '', '', '0', '0', 'BAILADORES ESTADO MERIDA ', '', '0.00', '2019-09-18'), 
      ('19', 'C19', 'NATURAL', '16', '156946580', 'HELADERIA INDIA CARU DE CAROLINA RAMIREZ ROSALES ', '', '', '', '0', '0', 'BAILADORES ESTADO MERIDA ', '', '0.00', '2019-09-18'), 
      ('20', 'C20', 'NATURAL', '16', '279340430', 'INVERSIONES VG DE GABRIEL AUGUSTO HERNANDEZ ', '', '', '', '0', '0', 'FRENTE A LA FARMACIA TRINIDAD BAILADORES ESTADO MERIDA ', '', '0.00', '2019-09-18'), 
      ('21', 'C21', 'NATURAL', '16', '156954825', 'HELADERIA LOS SAUCES DE TRINIDAD ARELLANO RAMOS ', '', '', '', '0', '0', 'BAILADORES ESTADO MERIDA ', '', '0.00', '2019-09-18'), 
      ('22', 'C22', 'NATURAL', '16', '229285676', 'SUMINISTROS Y CARNICERIA HERMANOS MONTAMEZN', '', '', '', '0', '0', 'BAILADORES ESTADO MERIDA ', '', '0.00', '2019-09-18'), 
      ('23', 'C23', 'NATURAL', '16', '141317640', 'ABASTO EL PARAMERO DE EDUARDO ALEXIS ALARCON ', '', '', '', '0', '0', 'VISTA ALEGRE EL LLANO TOVAR', '', '0.00', '2019-09-18'), 
      ('24', 'C24', 'NATURAL', '16', '8711112', 'ABASTO DENISLON', '', '', '', '0', '0', 'EL LLANO TOVAR ESTADO MERIDA ', '', '0.00', '2019-09-18'), 
      ('25', 'C25', 'NATURAL', '16', '8088762', 'DISTRIBUIDORA GUZMAN BARRERA ', '', '', '', '0', '0', 'URBANIZACI&Oacute;N LA VEGA CASA 62 CALLE 4 TOVAR MERIDA ', '', '0.00', '2019-09-19'), 
      ('26', 'C26', 'NATURAL', '16', '14131239', 'JOEL MORA ', '', '', '', '0', '0', 'URBANIZACI&Oacute;N LA JABONERA TOVAR ESTADO MERIDA ', '', '0.00', '2019-09-19'), 
      ('27', 'C27', 'NATURAL', '16', '8705828', 'YAJAIRA ABREU ', '', '', '', '0', '0', 'CARRERA 4TA TOVAR ESTDO MERIDA ', '', '0.00', '2019-09-19'), 
      ('28', 'C28', 'NATURAL', '16', '21330209', 'FUENTE DE SODA SANTIAGO DE CARLOS IBARRA BARRIOS ', '', '', '', '0', '0', 'SECTOR CUCUCHICA TOVAR ESTADO MERIDA ', '', '0.00', '2019-09-19'), 
      ('29', 'C29', 'NATURAL', '16', '18208164', 'GROOVY ', '', '', '', '0', '0', 'AVENIDA DOMINGO ALBERTO RANGEL TOVAR MERIDA', '', '0.00', '2019-09-20'), 
      ('30', 'C30', 'NATURAL', '16', '076630140', 'PANADERIA FLOR DE BAILAODRES ', '', '', '', '0', '0', 'BAILADORES ESTADO MERIDA ', '', '0.00', '2019-09-27'), 
      ('31', 'C31', 'NATURAL', '16', '20830072', 'LENIN MORA ', '', '', '', '0', '0', 'EL LLANO TOVAR ESTADO MERIDA ', '', '0.00', '2019-09-27'), 
      ('32', 'C32', 'NATURAL', '16', '11389580', 'DANIEL SULBARAN ', '', '', '', '0', '0', 'MARACAY ESTADO ARAGUA', '', '0.00', '2019-10-02'), 
      ('33', 'C33', 'NATURAL', '16', '23240326', 'ABASTO MIS CACHETONAS ', '', '', '', '0', '0', 'LA LAGUNITA TOVAR ESTADO MERIDA ', '', '0.00', '2019-10-02');
COMMIT;

# | Vaciado de tabla 'combos'
# +-------------------------------------
DROP TABLE IF EXISTS `combos`;


# | Estructura de la tabla 'combos'
# +-------------------------------------
CREATE TABLE `combos` (
  `idcombo` int(11) NOT NULL AUTO_INCREMENT,
  `codcombo` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nomcombo` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `existencia` decimal(12,2) NOT NULL,
  `stockminimo` decimal(12,2) NOT NULL,
  `stockmaximo` decimal(12,2) NOT NULL,
  `ivacombo` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `desccombo` decimal(12,2) NOT NULL,
  PRIMARY KEY (`idcombo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'combos'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `combos` (`idcombo`, `codcombo`, `nomcombo`, `preciocompra`, `precioventa`, `existencia`, `stockminimo`, `stockmaximo`, `ivacombo`, `desccombo`) VALUES 
      ('1', '1', 'COMBO #1', '29950.00', '32945.00', '146.00', '2.00', '5.00', 'SI', '0.00'), 
      ('2', '2', 'COMBO #2', '23850.00', '26235.00', '155.00', '2.00', '5.00', 'SI', '7.00'), 
      ('3', '3', 'COMBO LO MEJOR', '17850.00', '19635.00', '155.00', '2.00', '5.00', 'SI', '0.00');
COMMIT;

# | Vaciado de tabla 'combosxproductos'
# +-------------------------------------
DROP TABLE IF EXISTS `combosxproductos`;


# | Estructura de la tabla 'combosxproductos'
# +-------------------------------------
CREATE TABLE `combosxproductos` (
  `iddetallecombo` int(11) NOT NULL AUTO_INCREMENT,
  `codcombo` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` decimal(12,2) NOT NULL,
  PRIMARY KEY (`iddetallecombo`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'combosxproductos'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `combosxproductos` (`iddetallecombo`, `codcombo`, `codproducto`, `cantidad`) VALUES 
      ('1', '1', '102', '5.00'), 
      ('2', '1', '104', '1.00'), 
      ('3', '1', '87', '3.00'), 
      ('4', '2', '44', '1.00'), 
      ('5', '2', '83', '2.00'), 
      ('6', '2', '107', '1.00'), 
      ('7', '2', '89', '1.00'), 
      ('8', '3', '30', '2.00'), 
      ('9', '3', '104', '1.00'), 
      ('10', '3', '108', '1.00'), 
      ('11', '3', '89', '1.00');
COMMIT;

# | Vaciado de tabla 'compras'
# +-------------------------------------
DROP TABLE IF EXISTS `compras`;


# | Estructura de la tabla 'compras'
# +-------------------------------------
CREATE TABLE `compras` (
  `idcompra` int(11) NOT NULL AUTO_INCREMENT,
  `codcompra` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasic` decimal(12,2) NOT NULL,
  `subtotalivanoc` decimal(12,2) NOT NULL,
  `ivac` decimal(12,2) NOT NULL,
  `totalivac` decimal(12,2) NOT NULL,
  `descontadoc` decimal(12,2) NOT NULL,
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
  `codigo` int(11) NOT NULL,
  PRIMARY KEY (`idcompra`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'compras'
# +-------------------------------------

# | Vaciado de tabla 'configuracion'
# +-------------------------------------
DROP TABLE IF EXISTS `configuracion`;


# | Estructura de la tabla 'configuracion'
# +-------------------------------------
CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `documsucursal` int(11) NOT NULL,
  `cuit` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomsucursal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `codgiro` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `girosucursal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tlfsucursal` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `correosucursal` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_provincia` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `direcsucursal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `codmoneda` int(11) NOT NULL,
  `codmoneda2` int(11) NOT NULL,
  `documencargado` int(11) NOT NULL,
  `dniencargado` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomencargado` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tlfencargado` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nroactividadsucursal` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `inicioticket` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `inicioboleta` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `iniciofactura` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `inicionota` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaautorizacion` date NOT NULL,
  `llevacontabilidad` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descuentoglobal` decimal(12,2) NOT NULL,
  `propinasugerida` decimal(12,2) NOT NULL,
  `infoapi` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'configuracion'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `configuracion` (`id`, `documsucursal`, `cuit`, `nomsucursal`, `codgiro`, `girosucursal`, `tlfsucursal`, `correosucursal`, `id_provincia`, `id_departamento`, `direcsucursal`, `codmoneda`, `codmoneda2`, `documencargado`, `dniencargado`, `nomencargado`, `tlfencargado`, `nroactividadsucursal`, `inicioticket`, `inicioboleta`, `iniciofactura`, `inicionota`, `fechaautorizacion`, `llevacontabilidad`, `descuentoglobal`, `propinasugerida`, `infoapi`) VALUES 
      ('1', '3', 'J-40737578-4', 'DONEBA RESTAURANTE', '00998123', 'VENTAS DE COMIDA Y BEBIDAS', '0414 0073940', 'ELSAIYA@GMAIL.COM', '0', '0', 'AVENIDA ROMULO, CALLE 51 # 47-48', '3', '1', '16', '18633174', 'RUBEN DARIO CHIRINOS RODRIGUEZ', '0414 7225970', '0001', '1', '1', '1', '1', '0000-00-00', 'NO', '0.00', '10.00', 'NO');
COMMIT;

# | Vaciado de tabla 'cotizaciones'
# +-------------------------------------
DROP TABLE IF EXISTS `cotizaciones`;


# | Estructura de la tabla 'cotizaciones'
# +-------------------------------------
CREATE TABLE `cotizaciones` (
  `idcotizacion` int(11) NOT NULL AUTO_INCREMENT,
  `codcotizacion` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasi` decimal(12,2) NOT NULL,
  `subtotalivano` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) NOT NULL,
  `descontado` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL,
  `totaldescuento` decimal(12,2) NOT NULL,
  `totalpago` decimal(12,2) NOT NULL,
  `totalpago2` decimal(12,2) NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechacotizacion` datetime NOT NULL,
  `codigo` int(11) NOT NULL,
  PRIMARY KEY (`idcotizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'cotizaciones'
# +-------------------------------------

# | Vaciado de tabla 'creditosxclientes'
# +-------------------------------------
DROP TABLE IF EXISTS `creditosxclientes`;


# | Estructura de la tabla 'creditosxclientes'
# +-------------------------------------
CREATE TABLE `creditosxclientes` (
  `codcredito` int(11) NOT NULL AUTO_INCREMENT,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montocredito` decimal(12,2) NOT NULL,
  PRIMARY KEY (`codcredito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'creditosxclientes'
# +-------------------------------------

# | Vaciado de tabla 'departamentos'
# +-------------------------------------
DROP TABLE IF EXISTS `departamentos`;


# | Estructura de la tabla 'departamentos'
# +-------------------------------------
CREATE TABLE `departamentos` (
  `id_departamento` int(11) NOT NULL AUTO_INCREMENT,
  `departamento` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_provincia` int(11) NOT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'departamentos'
# +-------------------------------------

# | Vaciado de tabla 'detallecompras'
# +-------------------------------------
DROP TABLE IF EXISTS `detallecompras`;


# | Estructura de la tabla 'detallecompras'
# +-------------------------------------
CREATE TABLE `detallecompras` (
  `coddetallecompra` int(11) NOT NULL AUTO_INCREMENT,
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
  `fechaexpiracionc` date NOT NULL,
  PRIMARY KEY (`coddetallecompra`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'detallecompras'
# +-------------------------------------

# | Vaciado de tabla 'detallecotizaciones'
# +-------------------------------------
DROP TABLE IF EXISTS `detallecotizaciones`;


# | Estructura de la tabla 'detallecotizaciones'
# +-------------------------------------
CREATE TABLE `detallecotizaciones` (
  `coddetallecotizacion` int(11) NOT NULL AUTO_INCREMENT,
  `codcotizacion` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcategoria` int(11) NOT NULL,
  `cantcotizacion` decimal(12,2) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `ivaproducto` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentov` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `valorneto2` decimal(12,2) NOT NULL,
  `detallesobservaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipo` int(2) NOT NULL,
  PRIMARY KEY (`coddetallecotizacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'detallecotizaciones'
# +-------------------------------------

# | Vaciado de tabla 'detallenotas'
# +-------------------------------------
DROP TABLE IF EXISTS `detallenotas`;


# | Estructura de la tabla 'detallenotas'
# +-------------------------------------
CREATE TABLE `detallenotas` (
  `coddetallenota` int(11) NOT NULL AUTO_INCREMENT,
  `codnota` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcategoria` int(11) NOT NULL,
  `cantventa` int(15) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `ivaproducto` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentov` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `tipo` int(2) NOT NULL,
  PRIMARY KEY (`coddetallenota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'detallenotas'
# +-------------------------------------

# | Vaciado de tabla 'detallepedidos'
# +-------------------------------------
DROP TABLE IF EXISTS `detallepedidos`;


# | Estructura de la tabla 'detallepedidos'
# +-------------------------------------
CREATE TABLE `detallepedidos` (
  `coddetallepedido` int(11) NOT NULL AUTO_INCREMENT,
  `codpedido` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pedido` int(15) NOT NULL,
  `codventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
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
  `cocinero` int(2) NOT NULL,
  `fechapedido` datetime NOT NULL,
  `fechaentrega` datetime NOT NULL,
  `tipo` int(2) NOT NULL,
  PRIMARY KEY (`coddetallepedido`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'detallepedidos'
# +-------------------------------------

# | Vaciado de tabla 'detalleventas'
# +-------------------------------------
DROP TABLE IF EXISTS `detalleventas`;


# | Estructura de la tabla 'detalleventas'
# +-------------------------------------
CREATE TABLE `detalleventas` (
  `coddetalleventa` int(11) NOT NULL AUTO_INCREMENT,
  `codpedido` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
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
  `valorneto2` decimal(12,2) NOT NULL,
  `detallesobservaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipo` int(2) NOT NULL,
  PRIMARY KEY (`coddetalleventa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'detalleventas'
# +-------------------------------------

# | Vaciado de tabla 'documentos'
# +-------------------------------------
DROP TABLE IF EXISTS `documentos`;


# | Estructura de la tabla 'documentos'
# +-------------------------------------
CREATE TABLE `documentos` (
  `coddocumento` int(11) NOT NULL AUTO_INCREMENT,
  `documento` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`coddocumento`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'documentos'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `documentos` (`coddocumento`, `documento`, `descripcion`) VALUES 
      ('1', 'RUC', 'REGISTRO UNICO DE CONTRIBUYENTES'), 
      ('2', 'RUT', 'REGISTRO UNICO TRIBUTARIO'), 
      ('3', 'RIF', 'REGISTRO DE INFORMACION FISCAL'), 
      ('4', 'RFC', 'REGISTRO FEDERAL DE CONTRIBUYENTES'), 
      ('5', 'RTN', 'REGISTRO TRIBUTARIO NACIONAL'), 
      ('6', 'RTU', 'REGISTRO TRIBUTARIO UNIFICADO'), 
      ('7', 'RNC', 'REGISTRO NACIONAL DEL CONTRIBUYENTE'), 
      ('8', 'NIF', 'NUMERO DE IDENTIFICACION FISCAL'), 
      ('9', 'NIT', 'NUMERO DE IDENTIFICACION TRIBUTARIA'), 
      ('10', 'NITE', 'NUMERO DE IDENTIFICACION TRIBUTARIA ESPECIAL'), 
      ('11', 'DNI', 'DOCUMENTO NACIONAL DE IDENTIDAD'), 
      ('12', 'CUIL', 'CODIGO UNICO DE IDENTIFICACION LABORAL'), 
      ('13', 'CUIT', 'CODIGO UNICO DE IDENTIFICACION TRIBUTARIA'), 
      ('14', 'REGISTRO CIVIL', 'REGISTRO CIVIL'), 
      ('15', 'TARJ. DE IDENTIDAD', 'TARJETA DE IDENTIDAD'), 
      ('16', 'CI', 'CEDULA DE IDENTIDAD'), 
      ('17', 'PASAPORTE', 'PASAPORTE');
COMMIT;

# | Vaciado de tabla 'impuestos'
# +-------------------------------------
DROP TABLE IF EXISTS `impuestos`;


# | Estructura de la tabla 'impuestos'
# +-------------------------------------
CREATE TABLE `impuestos` (
  `codimpuesto` int(11) NOT NULL AUTO_INCREMENT,
  `nomimpuesto` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `valorimpuesto` decimal(12,2) NOT NULL,
  `statusimpuesto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaimpuesto` date NOT NULL,
  PRIMARY KEY (`codimpuesto`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'impuestos'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `impuestos` (`codimpuesto`, `nomimpuesto`, `valorimpuesto`, `statusimpuesto`, `fechaimpuesto`) VALUES 
      ('1', 'IGV', '18.00', 'ACTIVO', '2019-06-02'), 
      ('2', 'IVA', '16.00', 'INACTIVO', '2019-06-02'), 
      ('3', 'ITBMS', '7.00', 'INACTIVO', '2019-06-02');
COMMIT;

# | Vaciado de tabla 'ingredientes'
# +-------------------------------------
DROP TABLE IF EXISTS `ingredientes`;


# | Estructura de la tabla 'ingredientes'
# +-------------------------------------
CREATE TABLE `ingredientes` (
  `idingrediente` int(11) NOT NULL AUTO_INCREMENT,
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
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `controlstocki` int(2) NOT NULL,
  PRIMARY KEY (`idingrediente`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'ingredientes'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `ingredientes` (`idingrediente`, `codingrediente`, `nomingrediente`, `codmedida`, `preciocompra`, `precioventa`, `cantingrediente`, `stockminimo`, `stockmaximo`, `ivaingrediente`, `descingrediente`, `lote`, `fechaexpiracion`, `codproveedor`, `controlstocki`) VALUES 
      ('1', '1', 'PAPAS A LA FRANCESA', '4', '1100.00', '1210.00', '177.50', '20.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('2', '2', 'LOMO DE RES', '4', '9500.00', '10450.00', '68.50', '0.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('3', '3', 'BUTIFARRA', '4', '430.20', '473.22', '83.00', '30.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('4', '4', 'LOMO DE CERDO', '4', '6000.00', '6600.00', '13.50', '15.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('5', '5', 'PECHUGA', '4', '6000.00', '6600.00', '104.50', '15.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('6', '6', 'SALCHICHA DE PERRO', '4', '463.00', '509.30', '96.00', '30.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('7', '7', 'SALCHICHA AMERICANA', '4', '1248.00', '1372.80', '31.00', '10.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('8', '8', 'SUIZA', '4', '3075.00', '3382.50', '96.50', '10.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('9', '9', 'RANCHERA', '4', '1828.57', '2011.43', '76.00', '10.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('10', '10', 'MANGUERA', '4', '1016.00', '1117.60', '132.00', '30.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('11', '11', 'CHORIZO', '4', '999.00', '1098.90', '59.55', '20.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('12', '12', 'JAMON', '4', '173.00', '190.30', '122.00', '10.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('13', '13', 'MOZARELLA', '4', '250.00', '275.00', '382.00', '10.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('14', '14', 'TOCINETA', '4', '473.48', '520.83', '17.00', '15.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('15', '15', 'MAIZ', '4', '1366.71', '1503.38', '30.00', '6.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('16', '16', 'PAN PERRO', '4', '350.00', '385.00', '87.00', '5.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('17', '17', 'PAN HAMBURGUESA', '4', '450.00', '495.00', '38.00', '0.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('18', '18', 'PATACON', '4', '300.00', '330.00', '120.00', '12.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('19', '19', 'CARNE', '4', '2000.00', '2200.00', '81.00', '20.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('20', '20', 'POLLO', '4', '2000.00', '2200.00', '48.00', '5.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('21', '21', 'PICADA DE POLLO', '4', '4000.00', '4400.00', '46.00', '10.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('22', '22', 'PICADA DE LOMITO', '4', '5000.00', '5500.00', '120.00', '10.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('23', '23', 'PICADA DE CERDO', '4', '4500.00', '4950.00', '39.00', '20.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('24', '24', 'CHUZO DE POLLO', '4', '3000.00', '3300.00', '180.50', '20.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('25', '25', 'CHUZO DE LOMITO', '4', '4000.00', '4400.00', '21.50', '8.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('26', '26', 'CHUZO DE CERDO', '4', '3500.00', '3850.00', '18.00', '5.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('27', '27', 'PUNTA ANCA', '4', '6500.00', '7150.00', '21.00', '10.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('28', '28', 'CHURRASCO', '4', '6500.00', '7150.00', '21.00', '10.00', '0.00', 'NO', '0.00', '0', '0000-00-00', '0', '1'), 
      ('29', '29', 'PAN DE PERRO', '4', '280.00', '308.00', '150.00', '10.00', '10.00', 'NO', '0.00', '0', '0000-00-00', '0', '1');
COMMIT;

# | Vaciado de tabla 'kardex_combos'
# +-------------------------------------
DROP TABLE IF EXISTS `kardex_combos`;


# | Estructura de la tabla 'kardex_combos'
# +-------------------------------------
CREATE TABLE `kardex_combos` (
  `codkardex` int(11) NOT NULL AUTO_INCREMENT,
  `codproceso` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codresponsable` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcombo` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `movimiento` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `entradas` decimal(12,2) NOT NULL,
  `salidas` decimal(12,2) NOT NULL,
  `devolucion` decimal(12,2) NOT NULL,
  `stockactual` decimal(12,2) NOT NULL,
  `ivacombo` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `desccombo` decimal(12,2) NOT NULL,
  `precio` decimal(12,2) NOT NULL,
  `documento` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechakardex` date NOT NULL,
  PRIMARY KEY (`codkardex`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'kardex_combos'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `kardex_combos` (`codkardex`, `codproceso`, `codresponsable`, `codcombo`, `movimiento`, `entradas`, `salidas`, `devolucion`, `stockactual`, `ivacombo`, `desccombo`, `precio`, `documento`, `fechakardex`) VALUES 
      ('1', '1', '0', '1', 'ENTRADAS', '146.00', '0.00', '0.00', '146.00', 'SI', '0.00', '8085.00', 'INVENTARIO INICIAL', '2021-07-21'), 
      ('2', '2', '0', '2', 'ENTRADAS', '155.00', '0.00', '0.00', '155.00', 'SI', '7.00', '26235.00', 'INVENTARIO INICIAL', '2021-07-21'), 
      ('3', '3', '0', '3', 'ENTRADAS', '155.00', '0.00', '0.00', '155.00', 'SI', '0.00', '19635.00', 'INVENTARIO INICIAL', '2021-07-21');
COMMIT;

# | Vaciado de tabla 'kardex_ingredientes'
# +-------------------------------------
DROP TABLE IF EXISTS `kardex_ingredientes`;


# | Estructura de la tabla 'kardex_ingredientes'
# +-------------------------------------
CREATE TABLE `kardex_ingredientes` (
  `codkardex` int(11) NOT NULL AUTO_INCREMENT,
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
  `fechakardex` date NOT NULL,
  PRIMARY KEY (`codkardex`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'kardex_ingredientes'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `kardex_ingredientes` (`codkardex`, `codproceso`, `codresponsable`, `codingrediente`, `movimiento`, `entradas`, `salidas`, `devolucion`, `stockactual`, `ivaingrediente`, `descingrediente`, `precio`, `documento`, `fechakardex`) VALUES 
      ('1', '1', '0', '1', 'ENTRADAS', '177.50', '0.00', '0.00', '177.50', 'NO', '0.00', '1210.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('2', '2', '0', '2', 'ENTRADAS', '68.50', '0.00', '0.00', '68.50', 'NO', '0.00', '10450.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('3', '3', '0', '3', 'ENTRADAS', '83.00', '0.00', '0.00', '83.00', 'NO', '0.00', '473.22', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('4', '4', '0', '4', 'ENTRADAS', '13.50', '0.00', '0.00', '13.50', 'NO', '0.00', '6600.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('5', '5', '0', '5', 'ENTRADAS', '104.50', '0.00', '0.00', '104.50', 'NO', '0.00', '6600.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('6', '6', '0', '6', 'ENTRADAS', '96.00', '0.00', '0.00', '96.00', 'NO', '0.00', '509.30', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('7', '7', '0', '7', 'ENTRADAS', '31.00', '0.00', '0.00', '31.00', 'NO', '0.00', '1372.80', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('8', '8', '0', '8', 'ENTRADAS', '96.50', '0.00', '0.00', '96.50', 'NO', '0.00', '3382.50', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('9', '9', '0', '9', 'ENTRADAS', '76.00', '0.00', '0.00', '76.00', 'NO', '0.00', '2011.43', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('10', '10', '0', '10', 'ENTRADAS', '132.00', '0.00', '0.00', '132.00', 'NO', '0.00', '1117.60', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('11', '11', '0', '11', 'ENTRADAS', '59.55', '0.00', '0.00', '59.55', 'NO', '0.00', '1098.90', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('12', '12', '0', '12', 'ENTRADAS', '122.00', '0.00', '0.00', '122.00', 'NO', '0.00', '190.30', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('13', '13', '0', '13', 'ENTRADAS', '382.00', '0.00', '0.00', '382.00', 'NO', '0.00', '275.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('14', '14', '0', '14', 'ENTRADAS', '17.00', '0.00', '0.00', '17.00', 'NO', '0.00', '520.83', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('15', '15', '0', '15', 'ENTRADAS', '30.00', '0.00', '0.00', '30.00', 'NO', '0.00', '1503.38', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('16', '16', '0', '16', 'ENTRADAS', '87.00', '0.00', '0.00', '87.00', 'NO', '0.00', '385.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('17', '17', '0', '17', 'ENTRADAS', '38.00', '0.00', '0.00', '38.00', 'NO', '0.00', '495.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('18', '18', '0', '18', 'ENTRADAS', '120.00', '0.00', '0.00', '120.00', 'NO', '0.00', '330.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('19', '19', '0', '19', 'ENTRADAS', '81.00', '0.00', '0.00', '81.00', 'NO', '0.00', '2200.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('20', '20', '0', '20', 'ENTRADAS', '48.00', '0.00', '0.00', '48.00', 'NO', '0.00', '2200.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('21', '21', '0', '21', 'ENTRADAS', '46.00', '0.00', '0.00', '46.00', 'NO', '0.00', '4400.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('22', '22', '0', '22', 'ENTRADAS', '120.00', '0.00', '0.00', '120.00', 'NO', '0.00', '5500.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('23', '23', '0', '23', 'ENTRADAS', '39.00', '0.00', '0.00', '39.00', 'NO', '0.00', '4950.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('24', '24', '0', '24', 'ENTRADAS', '180.50', '0.00', '0.00', '180.50', 'NO', '0.00', '3300.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('25', '25', '0', '25', 'ENTRADAS', '21.50', '0.00', '0.00', '21.50', 'NO', '0.00', '4400.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('26', '26', '0', '26', 'ENTRADAS', '18.00', '0.00', '0.00', '18.00', 'NO', '0.00', '3850.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('27', '27', '0', '27', 'ENTRADAS', '21.00', '0.00', '0.00', '21.00', 'NO', '0.00', '7150.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('28', '28', '0', '28', 'ENTRADAS', '21.00', '0.00', '0.00', '21.00', 'NO', '0.00', '7150.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('29', '29', '0', '29', 'ENTRADAS', '150.00', '0.00', '0.00', '150.00', 'NO', '0.00', '308.00', 'INVENTARIO INICIAL', '2021-06-18');
COMMIT;

# | Vaciado de tabla 'kardex_productos'
# +-------------------------------------
DROP TABLE IF EXISTS `kardex_productos`;


# | Estructura de la tabla 'kardex_productos'
# +-------------------------------------
CREATE TABLE `kardex_productos` (
  `codkardex` int(11) NOT NULL AUTO_INCREMENT,
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
  `fechakardex` date NOT NULL,
  PRIMARY KEY (`codkardex`)
) ENGINE=MyISAM AUTO_INCREMENT=136 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'kardex_productos'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `kardex_productos` (`codkardex`, `codproceso`, `codresponsable`, `codproducto`, `movimiento`, `entradas`, `salidas`, `devolucion`, `stockactual`, `ivaproducto`, `descproducto`, `precio`, `documento`, `fechakardex`) VALUES 
      ('1', '1', '0', '1', 'ENTRADAS', '62.00', '0.00', '0.00', '62.00', 'NO', '0.00', '11000.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('2', '2', '0', '2', 'ENTRADAS', '74.00', '0.00', '0.00', '74.00', 'NO', '0.00', '8800.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('3', '3', '0', '3', 'ENTRADAS', '82.00', '0.00', '0.00', '82.00', 'NO', '0.00', '9900.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('4', '4', '0', '4', 'ENTRADAS', '90.00', '0.00', '0.00', '90.00', 'NO', '0.00', '11440.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('5', '5', '0', '5', 'ENTRADAS', '96.00', '0.00', '0.00', '96.00', 'NO', '0.00', '12540.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('6', '6', '0', '6', 'ENTRADAS', '96.00', '0.00', '0.00', '96.00', 'NO', '0.00', '9900.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('7', '7', '0', '7', 'ENTRADAS', '95.00', '0.00', '0.00', '95.00', 'NO', '0.00', '13200.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('8', '8', '0', '8', 'ENTRADAS', '57.00', '0.00', '0.00', '57.00', 'NO', '0.00', '8800.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('9', '9', '0', '9', 'ENTRADAS', '93.00', '0.00', '0.00', '93.00', 'NO', '0.00', '8800.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('10', '10', '0', '10', 'ENTRADAS', '928.00', '0.00', '0.00', '928.00', 'NO', '0.00', '6600.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('11', '11', '0', '11', 'ENTRADAS', '816.00', '0.00', '0.00', '816.00', 'NO', '0.00', '3300.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('12', '12', '0', '12', 'ENTRADAS', '92.00', '0.00', '0.00', '92.00', 'NO', '0.00', '13200.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('13', '13', '0', '13', 'ENTRADAS', '97.00', '0.00', '0.00', '97.00', 'NO', '0.00', '14300.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('14', '14', '0', '14', 'ENTRADAS', '95.00', '0.00', '0.00', '95.00', 'NO', '0.00', '17600.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('15', '15', '0', '15', 'ENTRADAS', '91.00', '0.00', '0.00', '91.00', 'NO', '0.00', '8800.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('16', '16', '0', '16', 'ENTRADAS', '96.00', '0.00', '0.00', '96.00', 'NO', '0.00', '9900.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('17', '17', '0', '17', 'ENTRADAS', '95.00', '0.00', '0.00', '95.00', 'NO', '0.00', '8800.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('18', '18', '0', '18', 'ENTRADAS', '99.00', '0.00', '0.00', '99.00', 'NO', '0.00', '6600.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('19', '19', '0', '19', 'ENTRADAS', '89.00', '0.00', '0.00', '89.00', 'NO', '0.00', '12100.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('20', '20', '0', '20', 'ENTRADAS', '95.00', '0.00', '0.00', '95.00', 'NO', '0.00', '9900.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('21', '21', '0', '21', 'ENTRADAS', '95.00', '0.00', '0.00', '95.00', 'NO', '0.00', '18700.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('22', '22', '0', '22', 'ENTRADAS', '892.00', '0.00', '0.00', '892.00', 'NO', '0.00', '4400.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('23', '23', '0', '23', 'ENTRADAS', '81.00', '0.00', '0.00', '81.00', 'NO', '0.00', '7480.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('24', '24', '0', '24', 'ENTRADAS', '85.00', '0.00', '0.00', '85.00', 'NO', '0.00', '7150.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('25', '25', '0', '25', 'ENTRADAS', '97.00', '0.00', '0.00', '97.00', 'NO', '0.00', '7810.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('26', '26', '0', '26', 'ENTRADAS', '96.00', '0.00', '0.00', '96.00', 'NO', '0.00', '7590.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('27', '27', '0', '27', 'ENTRADAS', '94.00', '0.00', '0.00', '94.00', 'NO', '0.00', '7480.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('28', '28', '0', '28', 'ENTRADAS', '97.00', '0.00', '0.00', '97.00', 'NO', '0.00', '11990.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('29', '29', '0', '29', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '23210.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('30', '30', '0', '30', 'ENTRADAS', '58.00', '0.00', '0.00', '58.00', 'NO', '0.00', '6600.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('31', '31', '0', '31', 'ENTRADAS', '93.00', '0.00', '0.00', '93.00', 'NO', '0.00', '7260.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('32', '32', '0', '32', 'ENTRADAS', '91.00', '0.00', '0.00', '91.00', 'NO', '0.00', '6930.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('33', '33', '0', '33', 'ENTRADAS', '74.00', '0.00', '0.00', '74.00', 'NO', '0.00', '110.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('34', '34', '0', '34', 'ENTRADAS', '59.00', '0.00', '0.00', '59.00', 'NO', '0.00', '6930.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('35', '35', '0', '35', 'ENTRADAS', '86.00', '0.00', '0.00', '86.00', 'NO', '0.00', '7480.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('36', '36', '0', '36', 'ENTRADAS', '87.00', '0.00', '0.00', '87.00', 'NO', '0.00', '6380.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('37', '37', '0', '37', 'ENTRADAS', '99.00', '0.00', '0.00', '99.00', 'NO', '0.00', '13310.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('38', '38', '0', '38', 'ENTRADAS', '96.00', '0.00', '0.00', '96.00', 'NO', '0.00', '6930.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('39', '39', '0', '39', 'ENTRADAS', '95.00', '0.00', '0.00', '95.00', 'NO', '0.00', '9900.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('40', '40', '0', '40', 'ENTRADAS', '95.00', '0.00', '0.00', '95.00', 'NO', '0.00', '9790.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('41', '41', '0', '41', 'ENTRADAS', '97.00', '0.00', '0.00', '97.00', 'NO', '0.00', '11220.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('42', '42', '0', '42', 'ENTRADAS', '81.00', '0.00', '0.00', '81.00', 'NO', '0.00', '12760.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('43', '43', '0', '43', 'ENTRADAS', '77.00', '0.00', '0.00', '77.00', 'NO', '0.00', '22000.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('44', '44', '0', '44', 'ENTRADAS', '84.00', '0.00', '0.00', '84.00', 'NO', '0.00', '4950.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('45', '45', '0', '45', 'ENTRADAS', '92.00', '0.00', '0.00', '92.00', 'NO', '0.00', '6380.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('46', '46', '0', '46', 'ENTRADAS', '96.00', '0.00', '0.00', '96.00', 'NO', '0.00', '8580.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('47', '47', '0', '47', 'ENTRADAS', '94.00', '0.00', '0.00', '94.00', 'NO', '0.00', '8910.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('48', '48', '0', '48', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '8690.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('49', '49', '0', '49', 'ENTRADAS', '96.00', '0.00', '0.00', '96.00', 'NO', '0.00', '9130.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('50', '50', '0', '50', 'ENTRADAS', '96.00', '0.00', '0.00', '96.00', 'NO', '0.00', '13090.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('51', '51', '0', '51', 'ENTRADAS', '97.00', '0.00', '0.00', '97.00', 'NO', '0.00', '16170.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('52', '52', '0', '52', 'ENTRADAS', '96.00', '0.00', '0.00', '96.00', 'NO', '0.00', '11880.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('53', '53', '0', '53', 'ENTRADAS', '98.00', '0.00', '0.00', '98.00', 'NO', '0.00', '23210.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('54', '54', '0', '54', 'ENTRADAS', '53.00', '0.00', '0.00', '53.00', 'NO', '0.00', '330.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('55', '55', '0', '55', 'ENTRADAS', '88.00', '0.00', '0.00', '88.00', 'NO', '0.00', '3300.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('56', '56', '0', '56', 'ENTRADAS', '84.00', '0.00', '0.00', '84.00', 'NO', '0.00', '6600.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('57', '57', '0', '57', 'ENTRADAS', '92.00', '0.00', '0.00', '92.00', 'NO', '0.00', '6600.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('58', '58', '0', '58', 'ENTRADAS', '87.00', '0.00', '0.00', '87.00', 'NO', '0.00', '8800.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('59', '59', '0', '59', 'ENTRADAS', '99.00', '0.00', '0.00', '99.00', 'NO', '0.00', '6600.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('60', '60', '0', '60', 'ENTRADAS', '98.00', '0.00', '0.00', '98.00', 'NO', '0.00', '11000.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('61', '61', '0', '61', 'ENTRADAS', '89.00', '0.00', '0.00', '89.00', 'NO', '0.00', '7700.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('62', '62', '0', '62', 'ENTRADAS', '39.00', '0.00', '0.00', '39.00', 'NO', '0.00', '5500.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('63', '63', '0', '63', 'ENTRADAS', '89.00', '0.00', '0.00', '89.00', 'NO', '0.00', '6600.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('64', '64', '0', '64', 'ENTRADAS', '96.00', '0.00', '0.00', '96.00', 'NO', '0.00', '6600.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('65', '65', '0', '65', 'ENTRADAS', '88.00', '0.00', '0.00', '88.00', 'NO', '0.00', '5500.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('66', '66', '0', '66', 'ENTRADAS', '69.00', '0.00', '0.00', '69.00', 'NO', '0.00', '6490.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('67', '67', '0', '67', 'ENTRADAS', '90.00', '0.00', '0.00', '90.00', 'NO', '0.00', '7590.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('68', '68', '0', '68', 'ENTRADAS', '87.00', '0.00', '0.00', '87.00', 'NO', '0.00', '5500.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('69', '69', '0', '69', 'ENTRADAS', '98.00', '0.00', '0.00', '98.00', 'NO', '0.00', '6600.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('70', '70', '0', '70', 'ENTRADAS', '88.00', '0.00', '0.00', '88.00', 'NO', '0.00', '6380.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('71', '71', '0', '71', 'ENTRADAS', '92.00', '0.00', '0.00', '92.00', 'NO', '0.00', '6600.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('72', '72', '0', '72', 'ENTRADAS', '89.00', '0.00', '0.00', '89.00', 'NO', '0.00', '6270.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('73', '73', '0', '73', 'ENTRADAS', '99.00', '0.00', '0.00', '99.00', 'NO', '0.00', '6820.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('74', '74', '0', '74', 'ENTRADAS', '98.00', '0.00', '0.00', '98.00', 'NO', '0.00', '6380.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('75', '75', '0', '75', 'ENTRADAS', '97.00', '0.00', '0.00', '97.00', 'NO', '0.00', '7590.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('76', '76', '0', '76', 'ENTRADAS', '93.00', '0.00', '0.00', '93.00', 'NO', '0.00', '9570.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('77', '77', '0', '77', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '6930.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('78', '78', '0', '78', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '6050.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('79', '79', '0', '79', 'ENTRADAS', '99.00', '0.00', '0.00', '99.00', 'NO', '0.00', '6380.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('80', '80', '0', '80', 'ENTRADAS', '98.00', '0.00', '0.00', '98.00', 'NO', '0.00', '6270.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('81', '81', '0', '81', 'ENTRADAS', '91.00', '0.00', '0.00', '91.00', 'NO', '0.00', '5500.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('82', '82', '0', '82', 'ENTRADAS', '98.00', '0.00', '0.00', '98.00', 'NO', '0.00', '5500.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('83', '83', '0', '83', 'ENTRADAS', '98.00', '0.00', '0.00', '98.00', 'NO', '0.00', '7590.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('84', '84', '0', '84', 'ENTRADAS', '95.00', '0.00', '0.00', '95.00', 'NO', '0.00', '11330.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('85', '85', '0', '85', 'ENTRADAS', '92.00', '0.00', '0.00', '92.00', 'NO', '0.00', '12320.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('86', '86', '0', '86', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '22000.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('87', '87', '0', '87', 'ENTRADAS', '146.00', '0.00', '0.00', '146.00', 'NO', '0.00', '1430.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('88', '88', '0', '88', 'ENTRADAS', '91.00', '0.00', '0.00', '91.00', 'NO', '0.00', '2750.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('89', '89', '0', '89', 'ENTRADAS', '155.00', '0.00', '0.00', '155.00', 'NO', '0.00', '4950.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('90', '90', '0', '90', 'ENTRADAS', '9.00', '0.00', '0.00', '9.00', 'NO', '0.00', '1677.50', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('91', '91', '0', '91', 'ENTRADAS', '146.00', '0.00', '0.00', '146.00', 'NO', '0.00', '1320.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('92', '92', '0', '92', 'ENTRADAS', '113.00', '0.00', '0.00', '113.00', 'NO', '0.00', '1677.50', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('93', '93', '0', '93', 'ENTRADAS', '150.00', '0.00', '0.00', '150.00', 'NO', '0.00', '2200.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('94', '94', '0', '94', 'ENTRADAS', '115.00', '0.00', '0.00', '115.00', 'NO', '0.00', '1980.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('95', '95', '0', '95', 'ENTRADAS', '16.00', '0.00', '0.00', '16.00', 'NO', '0.00', '1677.50', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('96', '96', '0', '96', 'ENTRADAS', '25.00', '0.00', '0.00', '25.00', 'NO', '0.00', '1430.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('97', '97', '0', '97', 'ENTRADAS', '24.00', '0.00', '0.00', '24.00', 'NO', '0.00', '2255.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('98', '98', '0', '98', 'ENTRADAS', '26.00', '0.00', '0.00', '26.00', 'NO', '0.00', '990.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('99', '99', '0', '99', 'ENTRADAS', '40.00', '0.00', '0.00', '40.00', 'NO', '0.00', '1210.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('100', '100', '0', '100', 'ENTRADAS', '78.00', '0.00', '0.00', '78.00', 'NO', '0.00', '1430.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('101', '101', '0', '101', 'ENTRADAS', '94.00', '0.00', '0.00', '94.00', 'NO', '0.00', '4400.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('102', '102', '0', '102', 'ENTRADAS', '97.00', '0.00', '0.00', '97.00', 'NO', '0.00', '5500.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('103', '103', '0', '103', 'ENTRADAS', '91.00', '0.00', '0.00', '91.00', 'NO', '0.00', '495.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('104', '104', '0', '104', 'ENTRADAS', '99.00', '0.00', '0.00', '99.00', 'NO', '0.00', '1155.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('105', '105', '0', '105', 'ENTRADAS', '99.00', '0.00', '0.00', '99.00', 'NO', '0.00', '1100.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('106', '106', '0', '106', 'ENTRADAS', '94.00', '0.00', '0.00', '94.00', 'NO', '0.00', '880.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('107', '107', '0', '107', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '1155.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('108', '108', '0', '108', 'ENTRADAS', '38.00', '0.00', '0.00', '38.00', 'NO', '0.00', '330.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('109', '109', '0', '109', 'ENTRADAS', '966.00', '0.00', '0.00', '966.00', 'NO', '0.00', '2200.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('110', '110', '0', '110', 'ENTRADAS', '77.00', '0.00', '0.00', '77.00', 'NO', '0.00', '3300.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('111', '111', '0', '111', 'ENTRADAS', '94.00', '0.00', '0.00', '94.00', 'NO', '0.00', '4400.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('112', '112', '0', '112', 'ENTRADAS', '99.00', '0.00', '0.00', '99.00', 'NO', '0.00', '5500.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('113', '113', '0', '113', 'ENTRADAS', '96.00', '0.00', '0.00', '96.00', 'NO', '0.00', '7700.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('114', '114', '0', '114', 'ENTRADAS', '99.00', '0.00', '0.00', '99.00', 'NO', '0.00', '3300.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('115', '115', '0', '115', 'ENTRADAS', '97.00', '0.00', '0.00', '97.00', 'NO', '0.00', '2750.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('116', '116', '0', '116', 'ENTRADAS', '90.00', '0.00', '0.00', '90.00', 'NO', '0.00', '3850.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('117', '117', '0', '117', 'ENTRADAS', '90.00', '0.00', '0.00', '90.00', 'NO', '0.00', '5500.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('118', '118', '0', '118', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '3850.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('119', '119', '0', '119', 'ENTRADAS', '97.00', '0.00', '0.00', '97.00', 'NO', '0.00', '4950.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('120', '120', '0', '120', 'ENTRADAS', '98.00', '0.00', '0.00', '98.00', 'NO', '0.00', '4180.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('121', '122', '0', '122', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '3850.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('122', '123', '0', '123', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '3850.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('123', '124', '0', '124', 'ENTRADAS', '99.00', '0.00', '0.00', '99.00', 'NO', '0.00', '3850.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('124', '125', '0', '125', 'ENTRADAS', '99.00', '0.00', '0.00', '99.00', 'NO', '0.00', '2200.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('125', '126', '0', '126', 'ENTRADAS', '96.00', '0.00', '0.00', '96.00', 'NO', '0.00', '6600.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('126', '127', '0', '127', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '9900.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('127', '128', '0', '128', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '10450.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('128', '129', '0', '129', 'ENTRADAS', '99.00', '0.00', '0.00', '99.00', 'NO', '0.00', '5500.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('129', '130', '0', '130', 'ENTRADAS', '100.00', '0.00', '0.00', '100.00', 'NO', '0.00', '5500.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('130', '131', '0', '131', 'ENTRADAS', '94.00', '0.00', '0.00', '94.00', 'NO', '0.00', '11000.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('131', '132', '0', '132', 'ENTRADAS', '77.00', '0.00', '0.00', '77.00', 'NO', '0.00', '1100.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('132', '133', '0', '133', 'ENTRADAS', '96.00', '0.00', '0.00', '96.00', 'NO', '0.00', '1100.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('133', '134', '0', '134', 'ENTRADAS', '97.00', '0.00', '0.00', '97.00', 'NO', '0.00', '330.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('134', '135', '0', '135', 'ENTRADAS', '98.00', '0.00', '0.00', '98.00', 'NO', '0.00', '2090.00', 'INVENTARIO INICIAL', '2021-06-18'), 
      ('135', '136', '0', '136', 'ENTRADAS', '99.00', '0.00', '0.00', '99.00', 'NO', '0.00', '4400.00', 'INVENTARIO INICIAL', '2021-06-18');
COMMIT;

# | Vaciado de tabla 'log'
# +-------------------------------------
DROP TABLE IF EXISTS `log`;


# | Estructura de la tabla 'log'
# +-------------------------------------
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tiempo` datetime DEFAULT NULL,
  `detalles` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `paginas` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'log'
# +-------------------------------------

# | Vaciado de tabla 'medidas'
# +-------------------------------------
DROP TABLE IF EXISTS `medidas`;


# | Estructura de la tabla 'medidas'
# +-------------------------------------
CREATE TABLE `medidas` (
  `codmedida` int(11) NOT NULL AUTO_INCREMENT,
  `nommedida` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`codmedida`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'medidas'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `medidas` (`codmedida`, `nommedida`) VALUES 
      ('1', 'KILOGRAMO'), 
      ('2', 'LITRO'), 
      ('3', 'GRAMO'), 
      ('4', 'UNIDAD');
COMMIT;

# | Vaciado de tabla 'mesas'
# +-------------------------------------
DROP TABLE IF EXISTS `mesas`;


# | Estructura de la tabla 'mesas'
# +-------------------------------------
CREATE TABLE `mesas` (
  `codmesa` int(11) NOT NULL AUTO_INCREMENT,
  `codsala` int(11) NOT NULL,
  `nommesa` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `puestos` int(2) NOT NULL,
  `fecha` date NOT NULL,
  `statusmesa` int(1) NOT NULL,
  PRIMARY KEY (`codmesa`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'mesas'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `mesas` (`codmesa`, `codsala`, `nommesa`, `puestos`, `fecha`, `statusmesa`) VALUES 
      ('1', '1', 'MESA 1', '4', '2017-11-08', '0'), 
      ('2', '1', 'MESA 2', '4', '2017-11-08', '0'), 
      ('4', '1', 'MESA 3', '4', '2017-11-10', '0'), 
      ('5', '1', 'MESA 4', '6', '2017-11-10', '0'), 
      ('6', '1', 'MESA 5', '4', '2017-11-10', '0'), 
      ('7', '1', 'MESA 6', '4', '2017-11-10', '0'), 
      ('8', '1', 'MESA 7', '4', '2017-11-10', '0'), 
      ('9', '1', 'MESA 8', '4', '2017-11-10', '0'), 
      ('10', '1', 'M # 1 DROG.', '6', '2017-11-10', '0'), 
      ('11', '1', 'M # 2 DROG.', '6', '2017-11-10', '0'), 
      ('12', '1', 'M # 1 ZAPA.', '4', '2017-11-10', '0'), 
      ('13', '1', 'M # 2 ZAPA.', '6', '2017-11-10', '0'), 
      ('14', '2', 'MESA 1', '2', '2017-11-10', '0'), 
      ('15', '2', 'MESA 2', '4', '2017-11-10', '0'), 
      ('16', '2', 'MESA 3', '2', '2018-10-20', '0'), 
      ('17', '2', 'MESA 4', '4', '2018-10-20', '0'), 
      ('18', '3', 'MESA 1', '4', '2018-10-20', '0'), 
      ('19', '3', 'MESA 2', '2', '2018-10-20', '0');
COMMIT;

# | Vaciado de tabla 'movimientoscajas'
# +-------------------------------------
DROP TABLE IF EXISTS `movimientoscajas`;


# | Estructura de la tabla 'movimientoscajas'
# +-------------------------------------
CREATE TABLE `movimientoscajas` (
  `codmovimiento` int(11) NOT NULL AUTO_INCREMENT,
  `codcaja` int(11) NOT NULL,
  `tipomovimiento` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcionmovimiento` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montomovimiento` decimal(12,2) NOT NULL,
  `mediomovimiento` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechamovimiento` datetime NOT NULL,
  `codarqueo` int(11) NOT NULL,
  PRIMARY KEY (`codmovimiento`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'movimientoscajas'
# +-------------------------------------

# | Vaciado de tabla 'notascredito'
# +-------------------------------------
DROP TABLE IF EXISTS `notascredito`;


# | Estructura de la tabla 'notascredito'
# +-------------------------------------
CREATE TABLE `notascredito` (
  `idnota` int(11) NOT NULL AUTO_INCREMENT,
  `codcaja` int(11) NOT NULL,
  `codnota` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codfactura` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tipodocumento` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `facturaventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasi` decimal(12,2) NOT NULL,
  `subtotalivano` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) NOT NULL,
  `descontado` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL,
  `totaldescuento` decimal(12,2) NOT NULL,
  `totalpago` decimal(12,2) NOT NULL,
  `fechanota` datetime NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  PRIMARY KEY (`idnota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'notascredito'
# +-------------------------------------

# | Vaciado de tabla 'productos'
# +-------------------------------------
DROP TABLE IF EXISTS `productos`;


# | Estructura de la tabla 'productos'
# +-------------------------------------
CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL AUTO_INCREMENT,
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
  `favorito` int(2) NOT NULL,
  `controlstockp` int(2) NOT NULL,
  PRIMARY KEY (`idproducto`)
) ENGINE=MyISAM AUTO_INCREMENT=136 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'productos'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `productos` (`idproducto`, `codproducto`, `producto`, `codcategoria`, `preciocompra`, `precioventa`, `existencia`, `stockminimo`, `stockmaximo`, `ivaproducto`, `descproducto`, `codigobarra`, `lote`, `fechaelaboracion`, `fechaexpiracion`, `codproveedor`, `stockteorico`, `motivoajuste`, `favorito`, `controlstockp`) VALUES 
      ('1', '1', 'LOMITO DE RES', '1', '10000.00', '11000.00', '62.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('2', '2', 'PECHUGA A LA PLANCHA', '1', '8000.00', '8800.00', '74.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('3', '3', 'LOMITO DE CERDO', '1', '9000.00', '9900.00', '82.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('4', '4', 'LOMITO DE CERDO ENCEBOLLADO Y GRATINADO', '1', '10400.00', '11440.00', '90.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('5', '5', 'LOMITO DE RES ENCEBOLLADO Y GRATINADO', '1', '11400.00', '12540.00', '96.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('6', '6', 'MIXTO', '1', '9000.00', '9900.00', '96.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('7', '7', 'LOMITO DE CERDO RANCHERO', '1', '12000.00', '13200.00', '95.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('8', '8', 'PUNTA DE ANCA', '1', '8000.00', '8800.00', '57.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('9', '9', 'CHURRASCO', '1', '8000.00', '8800.00', '93.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('10', '10', 'SUPER SUIZO', '2', '6000.00', '6600.00', '928.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('11', '11', 'MINI SUIZO', '2', '3000.00', '3300.00', '816.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('12', '12', 'BANDEJA 4 CARNES', '1', '12000.00', '13200.00', '92.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('13', '13', 'BANDEJA TRIFASICA', '1', '13000.00', '14300.00', '97.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('14', '14', 'BANDEJA 5 CARNES', '1', '16000.00', '17600.00', '95.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('15', '15', 'SUIZO ESPECIAL_POLLO', '2', '8000.00', '8800.00', '91.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('16', '16', 'SUIZO ESPECIAL_LOMITO', '2', '9000.00', '9900.00', '96.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('17', '17', 'SUIZO ESPECIAL_CERDO', '2', '8000.00', '8800.00', '95.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('18', '18', 'SUIZO, CHORIZO Y BUTIFARRA', '2', '6000.00', '6600.00', '99.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('19', '19', 'SUIZO CON TODO', '2', '11000.00', '12100.00', '89.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('20', '20', 'SUIZO RANCHERO', '2', '9000.00', '9900.00', '95.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('21', '21', 'SUIZO DONEBA', '2', '17000.00', '18700.00', '95.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('22', '22', 'SALCHIPAPA SENCILLA', '3', '4000.00', '4400.00', '892.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('23', '23', 'SALCHIPAPA CON POLLO', '3', '6800.00', '7480.00', '81.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('24', '24', 'SALCHIPAPA CHORIZO Y BUTIFARRA', '3', '6500.00', '7150.00', '85.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('25', '25', 'SALCHIPAPA CON LOMITO', '3', '7100.00', '7810.00', '97.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('26', '26', 'SALCHIPAPA CON CERDO', '3', '6900.00', '7590.00', '96.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('27', '27', 'SALCHIPAPA CON SUIZA', '3', '6800.00', '7480.00', '94.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('28', '28', 'SALCHIPAPA HAWAIANA', '3', '10900.00', '11990.00', '97.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('29', '29', 'SALCHIPAPA DONEBA', '3', '21100.00', '23210.00', '100.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('30', '30', 'PICADA DE POLLO', '4', '6000.00', '6600.00', '58.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('31', '31', 'PICADA DE LOMITO', '4', '6600.00', '7260.00', '93.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('32', '32', 'PICADA DE CERDO', '4', '6300.00', '6930.00', '91.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('33', '33', 'PICADA TRIFASICA', '4', '100.00', '110.00', '74.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('34', '34', 'PICADA MIXTA', '4', '6300.00', '6930.00', '59.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('35', '35', 'PICADA SUIZO, CHORIZO Y BUTIFARRA', '4', '6800.00', '7480.00', '86.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('36', '36', 'PICADA RANCHERA', '4', '5800.00', '6380.00', '87.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('37', '37', 'PICADA ESCOCESA', '4', '12100.00', '13310.00', '99.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('38', '38', 'PICADA POLLO 100 GRS. Y MAIZ', '4', '6300.00', '6930.00', '96.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('39', '39', 'PICADA DE POLLO 200 GRS. Y MAIZ', '4', '9000.00', '9900.00', '95.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('40', '40', 'PICADA HAWAIANA', '4', '8900.00', '9790.00', '95.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('41', '41', 'PICADA 4 CARNES', '4', '10200.00', '11220.00', '97.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('42', '42', 'PICADA CON TODO', '4', '11600.00', '12760.00', '81.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('43', '43', 'PICADA DONEBA', '4', '20000.00', '22000.00', '77.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('44', '44', 'MAIZ AMERICANO SENCILLO', '5', '4500.00', '4950.00', '84.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('45', '45', 'MAIZ CON SUIZO', '5', '5800.00', '6380.00', '92.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('46', '46', 'MAIZ CON POLLO', '5', '7800.00', '8580.00', '96.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('47', '47', 'MAIZ CON LOMITO', '5', '8100.00', '8910.00', '94.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('48', '48', 'MAIZ CON CERDO', '5', '7900.00', '8690.00', '100.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('49', '49', 'MAIZ RANCHERO', '5', '8300.00', '9130.00', '96.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('50', '50', 'MAIZ HAWAIANO', '5', '11900.00', '13090.00', '96.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('51', '51', 'MAIZ CON TODO', '5', '14700.00', '16170.00', '97.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('52', '52', 'MAIZ CON POLLO Y LOMITO', '5', '10800.00', '11880.00', '96.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('53', '53', 'MAIZ DONEBA', '5', '21100.00', '23210.00', '98.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('54', '54', 'HAMB. DE CARNE', '6', '300.00', '330.00', '53.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('55', '55', 'HAMB. DE POLLO', '6', '3000.00', '3300.00', '88.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('56', '56', 'HAMB. MIXTA', '6', '6000.00', '6600.00', '84.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('57', '57', 'HAMB. HAWAIANA', '6', '6000.00', '6600.00', '92.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('58', '58', 'HAMB. ESPECIAL', '6', '8000.00', '8800.00', '87.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('59', '59', 'HAMB. CARNE, CHORIZO Y BUTIFARRA', '6', '6000.00', '6600.00', '99.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('60', '60', 'HAMB. DONEBA', '6', '10000.00', '11000.00', '98.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('61', '61', 'HAMB. COMBO', '6', '7000.00', '7700.00', '89.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('62', '62', 'CHUZO DE POLLO', '7', '5000.00', '5500.00', '39.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('63', '63', 'CHUZO DE LOMITO', '7', '6000.00', '6600.00', '89.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('64', '64', 'CHUZO DE CERDO', '7', '6000.00', '6600.00', '96.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('65', '65', 'CHUZO DE POLLO Y LOMITO', '7', '5000.00', '5500.00', '88.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('66', '66', 'CHUZO DE POLLO GRATINADO', '7', '5900.00', '6490.00', '69.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('67', '67', 'CHUZO DE LOMITO GRATINADO', '7', '6900.00', '7590.00', '90.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('68', '68', 'PATACON CON POLLO', '9', '5000.00', '5500.00', '87.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('69', '69', 'PATACON CON LOMITO', '9', '6000.00', '6600.00', '98.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('70', '70', 'PATACON POLLO Y LOMITO', '9', '5800.00', '6380.00', '88.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('71', '71', 'PATACON POLLO Y RANCHERA', '9', '6000.00', '6600.00', '92.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('72', '72', 'PATACON POLLO Y CERDO', '9', '5700.00', '6270.00', '89.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('73', '73', 'PATACON CERDO Y RANCHERO', '9', '6200.00', '6820.00', '99.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('74', '74', 'PATACON CON CERDO', '9', '5800.00', '6380.00', '98.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('75', '75', 'PATACON SUIZO AL GRATIN', '9', '6900.00', '7590.00', '97.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('76', '76', 'PATACON TRIFASICO', '9', '8700.00', '9570.00', '93.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('77', '77', 'PATACON SUIZO, CHORIZO Y BUTIFARRA', '9', '6300.00', '6930.00', '100.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('78', '78', 'PATACON POLLO Y SUIZO', '9', '5500.00', '6050.00', '100.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('79', '79', 'PATACON LOMITO Y SUIZO', '9', '5800.00', '6380.00', '99.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('80', '80', 'PATACON LOMITO Y RANCHERA', '9', '5700.00', '6270.00', '98.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('81', '81', 'PATACON CERDO Y SUIZO', '9', '5000.00', '5500.00', '91.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '1', '1'), 
      ('82', '82', 'PATACON CHORIZO Y BUTIFARRA', '9', '5000.00', '5500.00', '98.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('83', '83', 'PATACON HAWAIANA', '9', '6900.00', '7590.00', '98.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('84', '84', 'PATACON ESCOCES', '9', '10300.00', '11330.00', '95.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('85', '85', 'PATACON CON TODO', '9', '11200.00', '12320.00', '92.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('86', '86', 'PATACON DONEBA', '9', '20000.00', '22000.00', '100.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('87', '87', 'GASEOSA 400', '10', '1300.00', '1430.00', '146.00', '5.00', '50.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('88', '88', 'GASEOSA 1.5', '10', '2500.00', '2750.00', '91.00', '5.00', '50.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('89', '89', 'GASEOSA 2.5', '10', '4500.00', '4950.00', '155.00', '5.00', '5.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('90', '90', 'MT TEE', '10', '1525.00', '1677.50', '9.00', '5.00', '5.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('91', '91', 'AGUA BOTELLA', '10', '1200.00', '1320.00', '146.00', '5.00', '6.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('92', '92', 'HIT 500 ML', '10', '1525.00', '1677.50', '113.00', '5.00', '50.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('93', '93', 'CERVEZA LIGTH', '10', '2000.00', '2200.00', '150.00', '5.00', '1.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('94', '94', 'CERVEZA AGUILA NEGRA', '10', '1800.00', '1980.00', '115.00', '5.00', '0.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('95', '95', 'H2O', '10', '1525.00', '1677.50', '16.00', '5.00', '5.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('96', '96', 'BRETA?A', '10', '1300.00', '1430.00', '25.00', '5.00', '6.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('97', '97', 'GATORADE', '10', '2050.00', '2255.00', '24.00', '5.00', '5.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('98', '98', 'HIT CAJA', '10', '900.00', '990.00', '26.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('99', '99', 'PAPAS A LA FRACESA', '11', '1100.00', '1210.00', '40.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('100', '100', 'PORCION MAIZ', '11', '1300.00', '1430.00', '78.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('101', '101', 'PORCION DE POLLO', '11', '4000.00', '4400.00', '94.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('102', '102', 'PORCION DE LOMITO', '11', '5000.00', '5500.00', '97.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('103', '103', 'BUTIFARRA', '11', '450.00', '495.00', '91.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('104', '104', 'RANCHERA', '11', '1050.00', '1155.00', '99.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('105', '105', 'CHORIZO', '11', '1000.00', '1100.00', '99.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('106', '106', 'TOCINETA', '11', '800.00', '880.00', '94.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('107', '107', 'SUIZA', '11', '1050.00', '1155.00', '100.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('108', '108', 'MOZARELLA', '11', '300.00', '330.00', '38.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('109', '109', 'PERRO SENCILLO', '8', '2000.00', '2200.00', '966.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('110', '110', 'PERRO SUPER DONEBA', '8', '3000.00', '3300.00', '77.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('111', '111', 'PERRO AMERICANO', '8', '4000.00', '4400.00', '94.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('112', '112', 'PERRO SUIZO', '8', '5000.00', '5500.00', '99.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('113', '113', 'PERRO ITALO SUIZO', '8', '7000.00', '7700.00', '96.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('114', '114', 'PERRO SUICITO', '8', '3000.00', '3300.00', '99.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('115', '115', 'PERRO CON TOCINETA', '8', '2500.00', '2750.00', '97.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('116', '116', 'PERRO RANCHERO', '8', '3500.00', '3850.00', '90.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('117', '117', 'PERRO ITALO RANCHERO', '8', '5000.00', '5500.00', '90.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('118', '118', 'PERRO CHORIPERRO', '8', '3500.00', '3850.00', '100.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('119', '119', 'PERRO BUTIPERRO', '8', '4500.00', '4950.00', '97.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('120', '120', 'PERRO CON POLLO', '8', '3800.00', '4180.00', '98.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('121', '122', 'PERRO CON CERDO', '8', '3500.00', '3850.00', '100.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('122', '123', 'PERRO GEMELO', '8', '3500.00', '3850.00', '100.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('123', '124', 'PERRO HAWAIANO', '8', '3500.00', '3850.00', '99.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('124', '125', 'PERRO ITALIANO', '8', '2000.00', '2200.00', '99.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('125', '126', 'PERRO MIX', '8', '6000.00', '6600.00', '96.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('126', '127', 'PERRO TRIFASICO', '8', '9000.00', '9900.00', '100.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('127', '128', 'PERRO SALVAJE DONEBA', '8', '9500.00', '10450.00', '100.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('128', '129', 'PERRO COMBO', '8', '5000.00', '5500.00', '99.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('129', '130', 'PERRO SUIZO, CHORIZO Y BUTIFARRA', '8', '5000.00', '5500.00', '100.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('130', '131', 'PERRA', '8', '10000.00', '11000.00', '94.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('131', '132', 'TRABAJADOR', '11', '1000.00', '1100.00', '77.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('132', '133', 'DOMICILIO', '11', '1000.00', '1100.00', '96.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('133', '134', 'JAMON', '11', '300.00', '330.00', '97.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('134', '135', 'PORCION DE CERDO', '11', '1900.00', '2090.00', '98.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1'), 
      ('135', '136', 'PERRO CON LOMITO', '8', '4000.00', '4400.00', '99.00', '5.00', '10.00', 'NO', '0.00', '0', '0', '0000-00-00', '0000-00-00', '0', '0', 'NINGUNO', '0', '1');
COMMIT;

# | Vaciado de tabla 'productosxingredientes'
# +-------------------------------------
DROP TABLE IF EXISTS `productosxingredientes`;


# | Estructura de la tabla 'productosxingredientes'
# +-------------------------------------
CREATE TABLE `productosxingredientes` (
  `codagrega` int(11) NOT NULL AUTO_INCREMENT,
  `codproducto` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codingrediente` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cantracion` decimal(5,2) NOT NULL,
  PRIMARY KEY (`codagrega`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'productosxingredientes'
# +-------------------------------------

# | Vaciado de tabla 'proveedores'
# +-------------------------------------
DROP TABLE IF EXISTS `proveedores`;


# | Estructura de la tabla 'proveedores'
# +-------------------------------------
CREATE TABLE `proveedores` (
  `idproveedor` int(11) NOT NULL AUTO_INCREMENT,
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
  `fechaingreso` date NOT NULL,
  PRIMARY KEY (`idproveedor`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'proveedores'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `proveedores` (`idproveedor`, `codproveedor`, `documproveedor`, `cuitproveedor`, `nomproveedor`, `tlfproveedor`, `id_provincia`, `id_departamento`, `direcproveedor`, `emailproveedor`, `vendedor`, `tlfvendedor`, `fechaingreso`) VALUES 
      ('1', 'P1', '3', '71261097-1', 'CASA FRICAR', '(314) 5969694', '0', '0', 'MONTERIA', 'CASAFRICAR@HOTMAIL.COM', 'FERNEY', '(0425) 4377645', '2019-10-22'), 
      ('2', 'P2', '3', '43417696-3', 'DEPOSITO AL MAR', '(3665) 7354563', '0', '0', 'CLL COTIZADA NECOCLI', 'DEPOSITOALMAR@HOTMAIL.COM', 'PALOMO', '(6582) 9873456', '2019-10-22'), 
      ('3', 'P3', '3', '1045507345-8', 'DISTRIFODS LA GRANJA', '(0412) 7652345', '0', '0', 'APARTADO ANTIOQUIA', 'DISTRIFODSLAGRANJA@HOTMAIL.COM', 'JAMES', '(0254) 3623456', '2019-10-22'), 
      ('4', 'P4', '3', '890903939-5', 'POSTOBON', '(4142) 6554345', '0', '0', 'CHIGORODO', 'POSTOBON@HOTMAIL.COM', 'JUAN DAVID', '(0885) 2436637', '2019-10-22'), 
      ('5', 'P5', '3', '1027953891-4', 'PORKY CARNE LA LIGA', '(9854) 2534566', '0', '0', 'NECOCLI - ANTIOQUIA', 'PORKY@HOTMAIL.COM', 'ANDREA JARAMILLO', '(4126) 5737445', '2019-10-22'), 
      ('6', 'P6', '3', '900430430-3', 'AGUILA GRUPO EMPRESARIAL S.A.S.', '(9887) 6554263', '0', '0', 'MONTERIA - CORDOBA', 'GRUPOAGUILA@HOTMAIL.COM', 'ADRIANA', '(9665) 3426653', '2019-10-22'), 
      ('7', 'P7', '3', '1039086972', 'EXPENDIO DE CARNES', '(4246) 6524343', '0', '0', 'PLAZA DE MERCADO', 'GERMAN@GMAIL.COM', 'GERMAN', '(0414) 5426637', '2019-10-22'), 
      ('8', 'P8', '3', '901022172-1', 'SOLANO ESCUDERO SAS', '(0412) 4546277', '0', '0', 'K1 VIA APARATADO', 'SOLANO@HOTMAIL.COM', 'EDER FLOREZ', '(0414) 5542536', '2019-10-22');
COMMIT;

# | Vaciado de tabla 'provincias'
# +-------------------------------------
DROP TABLE IF EXISTS `provincias`;


# | Estructura de la tabla 'provincias'
# +-------------------------------------
CREATE TABLE `provincias` (
  `id_provincia` int(10) NOT NULL AUTO_INCREMENT,
  `provincia` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_provincia`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'provincias'
# +-------------------------------------

# | Vaciado de tabla 'salas'
# +-------------------------------------
DROP TABLE IF EXISTS `salas`;


# | Estructura de la tabla 'salas'
# +-------------------------------------
CREATE TABLE `salas` (
  `codsala` int(11) NOT NULL AUTO_INCREMENT,
  `nomsala` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`codsala`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'salas'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `salas` (`codsala`, `nomsala`, `fecha`) VALUES 
      ('1', 'SALA PRINCIPAL', '2017-11-08'), 
      ('2', 'SALA SECUNDARIA', '2017-11-08'), 
      ('3', 'SALA BALCON', '2018-10-19');
COMMIT;

# | Vaciado de tabla 'tiposcambio'
# +-------------------------------------
DROP TABLE IF EXISTS `tiposcambio`;


# | Estructura de la tabla 'tiposcambio'
# +-------------------------------------
CREATE TABLE `tiposcambio` (
  `codcambio` int(11) NOT NULL AUTO_INCREMENT,
  `descripcioncambio` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montocambio` decimal(12,3) NOT NULL,
  `codmoneda` int(11) NOT NULL,
  `fechacambio` date NOT NULL,
  PRIMARY KEY (`codcambio`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'tiposcambio'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `tiposcambio` (`codcambio`, `descripcioncambio`, `montocambio`, `codmoneda`, `fechacambio`) VALUES 
      ('1', 'DOLAR PAGINA', '20600.000', '1', '2019-09-05');
COMMIT;

# | Vaciado de tabla 'tiposmoneda'
# +-------------------------------------
DROP TABLE IF EXISTS `tiposmoneda`;


# | Estructura de la tabla 'tiposmoneda'
# +-------------------------------------
CREATE TABLE `tiposmoneda` (
  `codmoneda` int(11) NOT NULL AUTO_INCREMENT,
  `moneda` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `siglas` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `simbolo` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`codmoneda`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'tiposmoneda'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `tiposmoneda` (`codmoneda`, `moneda`, `siglas`, `simbolo`) VALUES 
      ('1', 'US DOLLAR', 'USD', '$'), 
      ('2', 'EURO', 'EUR', '&euro;'), 
      ('3', 'PESO CHILENO', 'CLP', '$'), 
      ('4', 'DOLAR CANADIENSE', 'CAD', '$'), 
      ('5', 'QUETZAL', 'GTQ', 'Q'), 
      ('6', 'DOLAR BELIZE', 'BZD', 'B'), 
      ('7', 'SOLES', 'SOL', 'S/.'), 
      ('8', 'BOLIVAR SOBERANO', 'BS', 'BS. ');
COMMIT;

# | Vaciado de tabla 'usuarios'
# +-------------------------------------
DROP TABLE IF EXISTS `usuarios`;


# | Estructura de la tabla 'usuarios'
# +-------------------------------------
CREATE TABLE `usuarios` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
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
  `comision` float(12,2) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'usuarios'
# +-------------------------------------

COMMIT;
INSERT IGNORE INTO `usuarios` (`codigo`, `dni`, `nombres`, `sexo`, `direccion`, `telefono`, `email`, `usuario`, `password`, `nivel`, `status`, `comision`) VALUES 
      ('1', '18633174', 'RUBEN DARIO CHIRINOS RODRIGUEZ', 'MASCULINO', 'SANTA CRUZ DE MORA', '04147225970', 'ELSAIYA@GMAIL.COM', 'RUBENCHIRINOS', '$2y$10$hgs2lXVu9g9GsZtM4Ntfm.iikNS7AGWcOfR07l83KEcIzQtU0c3rm', 'ADMINISTRADOR(A)', '1', '0.00'), 
      ('2', '16317737', 'MARBELLA PAREDES MARQUEZ', 'FEMENINO', 'SANTA CRUZ DE MORA', '(0412) 6439052', 'PAREDESMARQEUZMARBELLA@GMAIL.COM', 'MARBELLAPAREDES', '$2y$10$v3/EBpwkhUVkoziZ/XmPoOOYrk5LW6ruxj6SCac7QwT5qNqoWjY9i', 'SECRETARIA', '1', '0.00'), 
      ('3', '26546523', 'LEIDA YARITZA RODRIGUEZ', 'FEMENINO', 'SANTA CRUZ DE MORA', '(0414) 3432345', 'LEIDAY@GMAIL.COM', 'CAJERO123', '$2y$10$Pp8.1mlL83E5KD/ewZb4EO8s9sxnu90IsQD3qzxkvHchuvFpVJES.', 'CAJERO(A)', '1', '0.00'), 
      ('4', '189872345', 'CARLOS JESUS GUTIERREZ', 'MASCULINO', 'TOVAR ESTADO MERIDA', '(0412) 5436789', 'CJG@GMAIL.COM', 'MESERO123', '$2y$10$sIZ9bcCZ0IfPwnoVGH4FSOh0Ke0LGPVlh4IrQi79w0emdDqN9i/Ja', 'MESERO(A)', '1', '0.00'), 
      ('5', '2398734', 'PEDRO JESUS CHIRINOS', 'MASCULINO', 'SANTA CRUZ DE MORA', '(0275) 6543456', 'JESUSCH@GMAIL.COM', 'COCINERO123', '$2y$10$d8tN389NHmsFbLzazWsSIe6KT1tfBRjiIynUGtW87fElnk/stXuUu', 'COCINERO(A)', '1', '0.00'), 
      ('6', '237651982', 'RAFAEL CLEMENTINO CONTRERAS', 'MASCULINO', 'SANTA CRUZ DE MORA', '(0414) 5654234', 'CLEMEN@GMAIL.COM', 'REPARTIDOR123', '$2y$10$z5sJxtDoVfhMhvYNgmPzKOihs6CUhBms.heb49h3ZfqJckgfqx2OO', 'REPARTIDOR', '1', '0.00');
COMMIT;

# | Vaciado de tabla 'ventas'
# +-------------------------------------
DROP TABLE IF EXISTS `ventas`;


# | Estructura de la tabla 'ventas'
# +-------------------------------------
CREATE TABLE `ventas` (
  `idventa` int(11) NOT NULL AUTO_INCREMENT,
  `codpedido` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmesa` int(11) NOT NULL,
  `tipodocumento` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcaja` int(11) NOT NULL,
  `codfactura` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codserie` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codautorizacion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasi` decimal(12,2) NOT NULL,
  `subtotalivano` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) NOT NULL,
  `descontado` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL,
  `totaldescuento` decimal(12,2) NOT NULL,
  `totalpago` decimal(12,2) NOT NULL,
  `totalpago2` decimal(12,2) NOT NULL,
  `creditopagado` decimal(12,2) NOT NULL,
  `montodelivery` decimal(12,2) NOT NULL,
  `tipopago` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `formapago` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montopagado` decimal(12,2) NOT NULL,
  `formapago2` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montopagado2` decimal(12,2) NOT NULL,
  `formapropina` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montopropina` decimal(12,2) NOT NULL,
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
  `bandera` int(30) NOT NULL,
  `docelectronico` int(2) NOT NULL,
  PRIMARY KEY (`idventa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                
# | Carga de datos de la tabla 'ventas'
# +-------------------------------------


