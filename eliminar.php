<?php
require_once("class/class.php");
$tra = new Login();
$tipo = decrypt($_GET['tipo']);
switch($tipo)
	{
case 'USUARIOS':
$tra->EliminarUsuarios();
exit;
break;

case 'PROVINCIAS':
$tra->EliminarProvincias();
exit;
break;

case 'DEPARTAMENTOS':
$tra->EliminarDepartamentos();
exit;
break;

case 'DOCUMENTOS':
$tra->EliminarDocumentos();
exit;
break;

case 'TIPOMONEDA':
$tra->EliminarTipoMoneda();
exit;
break;

case 'TIPOCAMBIO':
$tra->EliminarTipoCambio();
exit;
break;

case 'MEDIOSPAGOS':
$tra->EliminarMediosPagos();
exit;
break;

case 'IMPUESTOS':
$tra->EliminarImpuestos();
exit;
break;

case 'SALAS':
$tra->EliminarSalas();
exit;
break;

case 'MESAS':
$tra->EliminarMesas();
exit;
break;

case 'CATEGORIAS':
$tra->EliminarCategorias();
exit;
break;

case 'MEDIDAS':
$tra->EliminarMedidas();
exit;
break;

case 'CLIENTES':
$tra->EliminarClientes();
exit;
break;

case 'PROVEEDORES':
$tra->EliminarProveedores();
exit;
break;

case 'INGREDIENTES':
$tra->EliminarIngredientes();
exit;
break;

case 'ELIMINADETALLEINGREDIENTE':
$tra->EliminarDetalleIngrediente();
exit;
break;

case 'PRODUCTOS':
$tra->EliminarProductos();
exit;
break;

case 'COMBOS':
$tra->EliminarCombos();
exit;
break;

case 'ELIMINADETALLECOMBO':
$tra->EliminarDetalleCombo();
exit;
break;

case 'COMPRAS':
$tra->EliminarCompras();
exit;
break;

case 'PAGARFACTURA':
$tra->PagarCompras();
exit;
break;

case 'DETALLESCOMPRAS':
$tra->EliminarDetallesCompras();
exit;
break;

case 'COTIZACIONES':
$tra->EliminarCotizaciones();
exit;
break;

case 'DETALLESCOTIZACIONES':
$tra->EliminarDetallesCotizaciones();
exit;
break;

case 'CAJAS':
$tra->EliminarCajas();
exit;
break;

case 'MOVIMIENTOS':
$tra->EliminarMovimiento();
exit;
break;

case 'CERRARMESA':
$tra->CerrarMesa();
exit;
break;

case 'ELIMINADETALLEPEDIDO':
$tra->EliminarDetallePedido();
exit;
break;

case 'CANCELARPEDIDO':
$tra->CancelarPedido();
exit;
break;

case 'ENTREGARPEDIDOCOCINERO':
$tra->EntregarPedidoMesa();
exit;
break;

case 'ENTREGARPEDIDODELIVERY':
$tra->EntregarPedidoDelivery();
exit;
break;

case 'VENTAS':
$tra->EliminarVentas();
exit;
break;

case 'DETALLESVENTAS':
$tra->EliminarDetallesVentas();
exit;
break;

}
?>